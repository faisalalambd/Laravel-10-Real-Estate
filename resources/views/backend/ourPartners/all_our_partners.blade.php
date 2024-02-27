@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    All Our Partners
@endsection


<div class="page-content">

    <nav class="page-breadcrumb">

        <div class="row">

            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Our Partners</li>
                </ol>
            </div>

            <div class="col-md-6" style="text-align: right;">
                <a href="{{ route('add.our.partner') }}" class="btn btn-outline-light me-2">Add Partner</a>
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
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($our_partners_data as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->image) }}" style="width:60px; height:60px;">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('edit.our.partner', $item->id) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('delete.our.partner', $item->id) }}"
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
