@extends('agent.agent_dashboard')
@section('agent')

@section('agent_title')
    All Property
@endsection


<div class="page-content">

    <nav class="page-breadcrumb">

        <div class="row">

            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Property</li>
                </ol>
            </div>

            <div class="col-md-6" style="text-align: right;">
                <a href="{{ route('agent.add.property') }}" class="btn btn-outline-light me-2">Add Property</a>
            </div>

        </div>

    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="dataTableExample" class="table">

                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Property Type</th>
                                    <th>Status Type</th>
                                    <th>City</th>
                                    <th>Property Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($property as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->property_thumbnail) }}"
                                                style="width:60px; height:60px;">
                                        </td>
                                        <td>{{ $item->property_name }}</td>
                                        <td>{{ $item['propertyType']['type_name'] }}</td>
                                        <td>{{ $item->property_status }}</td>
                                        <td>{{ $item->city }}</td>
                                        <td>{{ $item->property_code }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">InActive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.details.property', $item->id) }}"
                                                class="btn btn-outline-info" title="Details">
                                                <i data-feather="eye"></i>
                                            </a>

                                            <a href="{{ route('agent.edit.property', $item->id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>

                                            <a href="{{ route('agent.delete.property', $item->id) }}"
                                                class="btn btn-outline-danger" id="delete" title="Delete">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection
