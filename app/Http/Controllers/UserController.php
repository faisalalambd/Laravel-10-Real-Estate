<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Method to display the index view
    public function Index()
    {
        return view('frontend.index');
    } // End Method

    // Method to display the user profile view
    public function UserProfile()
    {
        // Get the authenticated user's ID
        $id = Auth::user()->id;

        // Retrieve user data based on the ID
        $userData = User::find($id);

        // Return the view with the user data
        return view('frontend.dashboard.edit_profile', compact('userData'));
    } // End Method

    // Method to update the user profile
    public function UserProfileStore(Request $request)
    {
        // Get the authenticated user's ID
        $id = Auth::user()->id;

        // Find the user data based on the ID
        $data = User::find($id);

        // Update user data with the form input values
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Handle file upload for user photo
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename; // Use object notation consistently
        }

        // Save the updated user data
        $data->save();

        // Set a success notification and redirect back
        $notification = [
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($notification);
    } // End Method

    // Method to handle user logout
    public function UserLogout(Request $request)
    {
        // Logout the user, invalidate the session, and regenerate the token
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Set a success notification and redirect to the login page
        $notification = [
            'message' => 'User Logout Successfully',
            'alert-type' => 'success',
        ];

        return redirect('/login')->with($notification);
    } // End Method

    // Method to display the change password view
    public function UserChangePassword()
    {
        return view('frontend.dashboard.change_password');
    } // End Method

    // Method to update user password
    public function UserPasswordUpdate(Request $request)
    {
        // Validation for old and new passwords
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Check if the old password matches the current authenticated user's password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            $notification = [
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error',
            ];

            return back()->with($notification);
        }

        // Update the user's password with the new hashed password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Set a success notification and redirect back
        $notification = [
            'message' => 'Password Change Successfully',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    } // End Method
}
