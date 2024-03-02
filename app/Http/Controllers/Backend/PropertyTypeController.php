<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;

class PropertyTypeController extends Controller
{
    public function AllPropertyType()
    {
        $propertyTypes = PropertyType::latest()->get();
        return view('backend.propertyType.all_propertyType', compact('propertyTypes'));
    } // End Method

    public function AddPropertyType()
    {
        return view('backend.propertyType.add_propertyType');
    } // End Method

    public function StorePropertyType(Request $request)
    {
        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);

        $notification = [
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.propertyType')->with($notification);
    } // End Method

    public function EditPropertyType($id)
    {
        $propertyTypes = PropertyType::findOrFail($id);
        return view('backend.propertyType.edit_propertyType', compact('propertyTypes'));
    } // End Method

    public function UpdatePropertyType(Request $request)
    {
        $propertyType_id = $request->id;

        PropertyType::findOrFail($propertyType_id)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);

        $notification = [
            'message' => 'Property Type Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.propertyType')->with($notification);
    } // End Method

    public function DeletePropertyType($id)
    {
        PropertyType::findOrFail($id)->delete();

        $notification = [
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
