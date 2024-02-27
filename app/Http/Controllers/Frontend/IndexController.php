<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\State;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\ContactUs;
use App\Models\MultiImage;
use App\Models\OurServices;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PropertyMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function PropertyDetails($id, $slug)
    {
        $property = Property::findOrFail($id);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $amenities = $property->amenities_id;
        $property_amenities = explode(',', $amenities);

        $facility = Facility::where('property_id', $id)->get();

        $type_id = $property->propertyType_id;
        $relatedProperty = Property::where('propertyType_id', $type_id)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.property.property_details', compact('property', 'multiImage', 'property_amenities', 'facility', 'relatedProperty'));
    } // End Method

    public function PropertyMessage(Request $request)
    {
        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $request->agent_id,
                'property_id' => $request->property_id,
                'message_name' => $request->message_name,
                'message_email' => $request->message_email,
                'message_phone' => $request->message_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            $notification = [
                'message' => 'Send Message Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            $notification = [
                'message' => 'Please log in to your account first',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    } // End Method

    public function AgentDetails($id)
    {
        $agent = User::findOrFail($id);
        $property = Property::where('agent_id', $id)->get();
        $featured = Property::where('featured', '1')->limit(3)->get();
        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        return view('frontend.agent.agent_details', compact('agent', 'property', 'featured', 'rent_property', 'buy_property'));
    } // End Method

    public function AgentDetailsMessage(Request $request)
    {
        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $request->agent_id,
                'message_name' => $request->message_name,
                'message_email' => $request->message_email,
                'message_phone' => $request->message_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            $notification = [
                'message' => 'Send Message Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            $notification = [
                'message' => 'Please log in to your account first.',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    } // End Method

    public function RentProperty()
    {
        $property = Property::where('status', '1')->where('property_status', 'rent')->paginate(5);
        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        return view('frontend.property.rent_property', compact('property', 'rent_property', 'buy_property'));
    } // End Method

    public function BuyProperty()
    {
        $property = Property::where('status', '1')->where('property_status', 'buy')->paginate(5);
        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        return view('frontend.property.buy_property', compact('property', 'rent_property', 'buy_property'));
    } // End Method

    public function PropertyType($id)
    {
        $property = Property::where('status', '1')->where('propertyType_id', $id)->paginate(5);
        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        $property_type_breadcrumb = PropertyType::where('id', $id)->first();

        return view('frontend.property.property_type', compact('property', 'property_type_breadcrumb', 'rent_property', 'buy_property'));
    } // End Method

    public function StateDetails($id)
    {
        $property = Property::where('status', '1')->where('state', $id)->paginate(5);
        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        $state_breadcrumb_state = State::where('id', $id)->first();

        return view('frontend.property.state_property', compact('property', 'rent_property', 'buy_property', 'state_breadcrumb_state'));
    } // End Method

    public function BuyPropertySearch(Request $request)
    {
        $request->validate(['search' => 'required']);

        $item = $request->search;
        $search_state = $request->state_id;
        $search_type = $request->propertyType_id;

        $property = Property::where('property_name', 'like', '%' . $item . '%')
            ->where('property_status', 'buy')
            ->with('propertyState', 'propertyType')
            ->whereHas('propertyState', function ($q) use ($search_state) {
                $q->where('state_name', 'like', '%' . $search_state . '%');
            })
            ->whereHas('propertyType', function ($q) use ($search_type) {
                $q->where('type_name', 'like', '%' . $search_type . '%');
            })
            ->paginate(5);

        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        return view('frontend.property.property_search', compact('property', 'rent_property', 'buy_property'));
    } // End Method

    public function RentPropertySearch(Request $request)
    {
        $request->validate(['search' => 'required']);

        $item = $request->search;
        $search_state = $request->state_id;
        $search_type = $request->propertyType_id;

        $property = Property::where('property_name', 'like', '%' . $item . '%')
            ->where('property_status', 'rent')
            ->with('propertyState', 'propertyType')
            ->whereHas('propertyState', function ($q) use ($search_state) {
                $q->where('state_name', 'like', '%' . $search_state . '%');
            })
            ->whereHas('propertyType', function ($q) use ($search_type) {
                $q->where('type_name', 'like', '%' . $search_type . '%');
            })
            ->paginate(5);

        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        return view('frontend.property.property_search', compact('property', 'rent_property', 'buy_property'));
    } // End Method

    public function AllPropertySearch(Request $request)
    {
        $property_status = $request->property_status;
        $search_type = $request->propertyType_id;
        $search_state = $request->state_id;
        $bedrooms = $request->bedrooms;
        $bathrooms = $request->bathrooms;

        $property = Property::where('status', '1')
            ->where('bedrooms', $bedrooms)
            ->where('bathrooms', 'like', '%' . $bathrooms . '%')
            ->where('property_status', $property_status)
            ->with('propertyState', 'propertyType')
            ->whereHas('propertyState', function ($q) use ($search_state) {
                $q->where('state_name', 'like', '%' . $search_state . '%');
            })
            ->whereHas('propertyType', function ($q) use ($search_type) {
                $q->where('type_name', 'like', '%' . $search_type . '%');
            })
            ->paginate(5);

        $rent_property = Property::where('property_status', 'rent')->get();
        $buy_property = Property::where('property_status', 'buy')->get();

        return view('frontend.property.property_search', compact('property', 'rent_property', 'buy_property'));
    } // End Method

    public function StoreTourSchedule(Request $request)
    {
        $agent_id = $request->agent_id;
        $property_id = $request->property_id;

        if (Auth::check()) {
            Schedule::insert([
                'user_id' => Auth::user()->id,
                'property_id' => $property_id,
                'agent_id' => $agent_id,
                'tour_date' => $request->tour_date,
                'tour_time' => $request->tour_time,
                'tour_message' => $request->tour_message,
                'created_at' => Carbon::now(),
            ]);

            $notification = [
                'message' => 'Send Request Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            $notification = [
                'message' => 'Please log in to your account first',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    } // End Method

    public function ContactUs()
    {
        return view('frontend.contactUs.contact_us');
    } // End Method

    public function StoreContactUsMessage(Request $request)
    {
        ContactUs::insert([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $notification = [
            'message' => 'Your Message Send Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function PropertyTypes()
    {
        $property_types_data = PropertyType::latest()->get();

        return view('frontend.propertyTypes.property_types', compact('property_types_data'));
    } // End Method

    public function OurServices(){
        $our_services_data = OurServices::latest()->get();
        
        return view('frontend.ourServices.our_services', compact('our_services_data'));
    }
}
