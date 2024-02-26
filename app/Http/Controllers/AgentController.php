<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AgentController extends Controller
{
    public function AgentDashboard()
    {
        return view('agent.index');
    } // End Method

    public function AgentLogin()
    {
        return view('agent.agent_login');
    } // End Method

    public function AgentRegister(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::AGENT);
    } // End Method

    // Method to handle agent logout
    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout(); // Logout the user

        $request->session()->invalidate(); // Invalidate the user's session

        $request->session()->regenerateToken(); // Regenerate the session token

        // Notification to be displayed after logout
        $notification = [
            'message' => 'Agent Logout Successfully',
            'alert-type' => 'success',
        ];

        return redirect('/agent/login')->with($notification);
    } // End Method

    // Method to display and update the agent profile
    public function AgentProfile()
    {
        $id = Auth::user()->id; // Get the user ID from the authenticated user

        $profileData = User::find($id); // Retrieve user data for the given ID

        return view('agent.agent_profile_view', compact('profileData'));
    } // End Method

    // Method to store the updated agent profile information
    public function AgentProfileStore(Request $request)
    {
        $id = Auth::user()->id; // Get the user ID from the authenticated user
        $data = User::find($id); // Retrieve user data for the given ID

        // Update user profile information from the form data
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->description = $request->description;

        // Handle profile photo upload
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/agent_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/agent_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save(); // Save the updated profile data

        // Notification to be displayed after profile update
        $notification = [
            'message' => 'Agent Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    // Method to display the agent change password view
    public function AgentChangePassword()
    {
        $id = Auth::user()->id; // Get the user ID from the authenticated user

        $profileData = User::find($id); // Retrieve user data for the given ID

        return view('agent.agent_change_password', compact('profileData'));
    } // End Method

    // Method to update the agent password
    public function AgentUpdatePassword(Request $request)
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
}
