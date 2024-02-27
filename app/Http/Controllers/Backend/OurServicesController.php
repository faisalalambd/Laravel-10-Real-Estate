<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OurServices;
use Illuminate\Http\Request;

class OurServicesController extends Controller
{
    public function AllOurServices()
    {
        $our_services_data = OurServices::latest()->get();

        return view('backend.ourServices.all_our_services', compact('our_services_data'));
    } // End Method

    public function AddOurService()
    {
        return view('backend.ourServices.add_our_service');
    } // End Method

    public function StoreOurService(Request $request)
    {
        OurServices::insert([
            'icon' => $request->icon,
            'name' => $request->name,
            'short_description' => $request->short_description,
        ]);

        $notification = [
            'message' => 'Our Service Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.our.services')->with('notification');
    } // End Method

    public function EditOurService($id)
    {
        $our_service = OurServices::findOrFail($id);

        return view('backend.ourServices.edit_our_service', compact('our_service'));
    } // End Method

    public function UpdateOurService(Request $request)
    {
        $our_service_id = $request->id;

        OurServices::findOrFail($our_service_id)->update([
            'icon' => $request->icon,
            'name' => $request->name,
            'short_description' => $request->short_description,
        ]);

        $notification = [
            'message' => 'Our Service Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.our.services')->with('notification');
    } // End Method

    public function DeleteOurService($id)
    {
        OurServices::findOrFail($id)->delete();

        $notification = [
            'message' => 'Our Service Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with('notification');
    }
}
