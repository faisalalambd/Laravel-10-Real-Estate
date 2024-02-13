<?php

namespace App\Http\Controllers\Backend;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StateController extends Controller
{
    public function AllState()
    {
        $state = State::latest()->get();
        return view('backend.state.all_state', compact('state'));
    } // End Method

    public function AddState()
    {
        return view('backend.state.add_state');
    } // End Method

    public function StoreState(Request $request)
    {
        $property_state_image = $request->file('state_image');

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $property_state_image->getClientOriginalExtension();
        $image = $manager->read($property_state_image);
        $image->resize(370, 275);
        $image->toJpeg(80)->save(base_path('public/upload/state/' . $name_gen));
        $save_url = 'upload/state/' . $name_gen;

        State::insert([
            'state_name' => $request->state_name,
            'state_image' => $save_url,
        ]);

        $notification = [
            'message' => 'Property State Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.state')->with($notification);
    } // End Method

    public function EditState($id)
    {
        $state = State::findOrFail($id);
        return view('backend.state.edit_state', compact('state'));
    } // End Method

    public function UpdateState(Request $request)
    {
        $state_id = $request->id;

        $property_state_image = $request->file('state_image');

        if ($property_state_image) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $property_state_image->getClientOriginalExtension();
            $image = $manager->read($property_state_image);
            $image->resize(370, 275);
            $image->toJpeg(80)->save(base_path('public/upload/state/' . $name_gen));
            $save_url = 'upload/state/' . $name_gen;

            // Delete existing image if it exists
            $existing_image = State::findOrFail($state_id);
            if ($existing_image->state_image) {
                if (file_exists(public_path($existing_image->state_image))) {
                    unlink(public_path($existing_image->state_image));
                }
            }

            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
                'state_image' => $save_url,
            ]);

            $notification = [
                'message' => 'Property State Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.state')->with($notification);
        } else {
            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
            ]);

            $notification = [
                'message' => 'Property State Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.state')->with($notification);
        }
    } // End Method

    public function DeleteState($id)
    {
        $state = State::findOrFail($id);
        $property_state_image = $state->state_image;
        unlink($property_state_image);

        State::findOrFail($id)->delete();

        $notification = [
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
