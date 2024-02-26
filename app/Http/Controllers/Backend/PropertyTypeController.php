<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;

class PropertyTypeController extends Controller
{
    // Method to display all property types
    public function AllPropertyType()
    {
        // Retrieve all property types from the database and pass them to the view
        $propertyTypes = PropertyType::latest()->get();
        return view('backend.propertyType.all_propertyType', compact('propertyTypes'));
    } // End Method

    // Method to display the form for adding a new property type
    public function AddPropertyType()
    {
        // Return the view for adding a new property type
        return view('backend.propertyType.add_propertyType');
    } // End Method

    // Method to store a new property type in the database
    public function StorePropertyType(Request $request)
    {
        // Insert a new property type into the database with data from the form
        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);

        // Set a success notification and redirect to the view displaying all property types
        $notification = [
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.propertyType')->with($notification);
    } // End Method

    // Method to display the form for editing a property type
    public function EditPropertyType($id)
    {
        // Retrieve the property type with the specified ID and pass it to the edit view
        $propertyTypes = PropertyType::findOrFail($id);
        return view('backend.propertyType.edit_propertyType', compact('propertyTypes'));
    } // End Method

    // Method to update the details of a property type in the database
    public function UpdatePropertyType(Request $request)
    {
        // Retrieve the property type ID from the form
        $propertyType_id = $request->id;

        // Update the property type details in the database with data from the form
        PropertyType::findOrFail($propertyType_id)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);

        // Set a success notification and redirect to the view displaying all property types
        $notification = [
            'message' => 'Property Type Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.propertyType')->with($notification);
    } // End Method

    // Method to delete a property type from the database
    public function DeletePropertyType($id)
    {
        // Delete the property type with the specified ID from the database
        PropertyType::findOrFail($id)->delete();

        // Set a success notification and redirect back to the previous page
        $notification = [
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
