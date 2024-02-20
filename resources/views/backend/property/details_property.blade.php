@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    Property Details
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#!">Table</a></li>
            <li class="breadcrumb-item active" aria-current="page">Property Details</li>
        </ol>
    </nav>


    <div class="row">

        <div class="col-md-6 grid-margin stretch-card">

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped">

                            <tbody>

                                <tr>
                                    <td>Main Image</td>
                                    <td>
                                        <img src="{{ asset($property->property_thumbnail) }}"
                                            style="width:80px; height:80px;">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Property Name</td>
                                    <td><code>{{ $property->property_name }}</code></td>
                                </tr>

                                <tr>
                                    <td>Property Code</td>
                                    <td><code>{{ $property->property_code }}</code></td>
                                </tr>

                                <tr>
                                    <td>Lowest Price</td>
                                    <td><code>{{ $property->lowest_price }}</code></td>
                                </tr>

                                <tr>
                                    <td>Max Price</td>
                                    <td><code>{{ $property->max_price }}</code></td>
                                </tr>

                                <tr>
                                    <td>Property Type</td>
                                    <td><code>{{ $property['propertyType']['type_name'] }}</code></td>
                                </tr>

                                <tr>
                                    <td>Property Size</td>
                                    <td><code>{{ $property->property_size }}</code></td>
                                </tr>

                                <tr>
                                    <td>Rooms</td>
                                    <td><code>{{ $property->rooms }}</code></td>
                                </tr>

                                <tr>
                                    <td>BedRooms</td>
                                    <td><code>{{ $property->bedrooms }}</code></td>
                                </tr>

                                <tr>
                                    <td>Bathrooms</td>
                                    <td><code>{{ $property->bathrooms }}</code></td>
                                </tr>

                                <tr>
                                    <td>Garage</td>
                                    <td><code>{{ $property->garage }}</code></td>
                                </tr>

                                <tr>
                                    <td>Garage Size</td>
                                    <td><code>{{ $property->garage_size }}</code></td>
                                </tr>

                                <tr>
                                    <td>Property Status</td>
                                    <td><code>{{ $property->property_status }}</code></td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-6 grid-margin stretch-card">

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped">

                            <tbody>

                                <tr>
                                    <td>Property Amenities</td>
                                    <td>
                                        <select name="amenities_id[]" class="js-example-basic-multiple form-select"
                                            multiple="multiple" data-width="100%">
                                            @foreach ($amenities as $amenity)
                                                <option value="{{ $amenity->amenity_name }}"
                                                    {{ in_array($amenity->amenity_name, $property_amenities) ? 'selected' : '' }}>
                                                    {{ $amenity->amenity_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Address</td>
                                    <td><code>{{ $property->address }}</code></td>
                                </tr>

                                <tr>
                                    <td>State</td>
                                    <td><code>{{ $property['propertyState']['state_name'] }}</code></td>
                                </tr>

                                <tr>
                                    <td>Neighborhood</td>
                                    <td><code>{{ $property->neighborhood }}</code></td>
                                </tr>

                                <tr>
                                    <td>Postal Code</td>
                                    <td><code>{{ $property->postal_code }}</code></td>
                                </tr>

                                <tr>
                                    <td>City</td>
                                    <td><code>{{ $property->city }}</code></td>
                                </tr>

                                <tr>
                                    <td>Latitude</td>
                                    <td><code>{{ $property->latitude }}</code></td>
                                </tr>


                                <tr>
                                    <td>Longitude</td>
                                    <td><code>{{ $property->longitude }}</code></td>
                                </tr>

                                <tr>
                                    <td>Property Video</td>
                                    <td><code>{{ $property->property_video }}</code></td>
                                </tr>

                                <tr>
                                    <td>Agent</td>
                                    @if ($property->agent_id == null)
                                        <td><code> Admin </code></td>
                                    @else
                                        <td><code> {{ $property['user']['name'] }} </code></td>
                                    @endif
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if ($property->status == 1)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">InActive</span>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                        <br><br>

                        @if ($property->status == 1)
                            <form method="post" action="{{ route('inactive.property') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $property->id }}">
                                <button type="submit" class="btn btn-outline-light">InActive</button>
                            </form>
                        @else
                            <form method="post" action="{{ route('active.property') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $property->id }}">
                                <button type="submit" class="btn btn-outline-light">Active</button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection
