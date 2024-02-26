<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Method to display the admin dashboard view
    public function AdminDashboard()
    {
        return view('admin.index');
    } // End Method

    // Method to handle admin logout
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout(); // Logout the user

        $request->session()->invalidate(); // Invalidate the user's session

        $request->session()->regenerateToken(); // Regenerate the session token

        // Notification to be displayed after logout
        $notification = [
            'message' => 'Admin Logout Successfully',
            'alert-type' => 'success',
        ];

        return redirect('/admin/login')->with($notification);
    } // End Method

    // Method to display the admin login view
    public function AdminLogin()
    {
        return view('admin.admin_login');
    } // End Method

    // Method to display and update the admin profile
    public function AdminProfile()
    {
        $id = Auth::user()->id; // Get the user ID from the authenticated user

        $profileData = User::find($id); // Retrieve user data for the given ID

        return view('admin.admin_profile_view', compact('profileData'));
    } // End Method

    // Method to store the updated admin profile information
    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id; // Get the user ID from the authenticated user
        $data = User::find($id); // Retrieve user data for the given ID

        // Update user profile information from the form data
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Handle profile photo upload
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save(); // Save the updated profile data

        // Notification to be displayed after profile update
        $notification = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    // Method to display the admin change password view
    public function AdminChangePassword()
    {
        $id = Auth::user()->id; // Get the user ID from the authenticated user

        $profileData = User::find($id); // Retrieve user data for the given ID

        return view('admin.admin_change_password', compact('profileData'));
    } // End Method

    // Method to update the admin password
    public function AdminUpdatePassword(Request $request)
    {
        // Validation for old and new passwords
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Check if the old password matches the current password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            $notification = [
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error',
            ];

            return back()->with($notification);
        }

        // Update the password with the hashed new password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Notification to be displayed after password change
        $notification = [
            'message' => 'Password Change Successfully',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    } // End Method

    // Method to fetch all users with the 'agent' role and pass them to the view
    public function AllAgent()
    {
        $all_agent = User::where('role', 'agent')->get();
        return view('backend.agent_user.all_agent', compact('all_agent'));
    } // End Method

    // Method to return the view for adding a new agent
    public function AddAgent()
    {
        return view('backend.agent_user.add_agent');
    } // End Method

    // Method to store a new agent in the database based on the data from the request
    public function StoreAgent(Request $request)
    {
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'active',
        ]);

        // Notification for a successful agent creation
        $notification = [
            'message' => 'Agent Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.agent')->with($notification);
    } // End Method

    // Method to fetch and display the information of a specific agent for editing
    public function EditAgent($id)
    {
        $all_agent = User::findOrFail($id);
        return view('backend.agent_user.edit_agent', compact('all_agent'));
    } // End Method

    // Method to update the information of an agent in the database based on the data from the request
    public function UpdateAgent(Request $request)
    {
        $user_id = $request->id;

        User::findOrFail($user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Notification for a successful agent update
        $notification = [
            'message' => 'Agent Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.agent')->with($notification);
    } // End Method

    // Method to delete a specific agent from the database
    public function DeleteAgent($id)
    {
        User::findOrFail($id)->delete();

        // Notification for a successful agent deletion
        $notification = [
            'message' => 'Agent Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    // Method to change the status of an agent based on the request data
    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        // Response indicating successful status change
        return response()->json(['success' => 'Status Change Successfully']);
    } // End Method
}
