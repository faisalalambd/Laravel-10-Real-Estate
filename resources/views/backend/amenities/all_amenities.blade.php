@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    All Amenities
@endsection


<div class="page-content">

    <nav class="page-breadcrumb">

        <div class="row">

            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Amenities</li>
                </ol>
            </div>

            <div class="col-md-6" style="text-align: right;">
                <a href="{{ route('add.amenity') }}" class="btn btn-outline-light me-2">Add Amenity</a>
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
                                    <th>Amenity Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($amenities as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->amenity_name }}</td>
                                        <td>
                                            <a href="{{ route('edit.amenity', $item->id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('delete.amenity', $item->id) }}"
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
