@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    Contact Us Messages
@endsection


<div class="page-content">

    <nav class="page-breadcrumb">

        <div class="row">

            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Contact Us Messages</li>
                </ol>
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
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($contact_us_message_data as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->message }}</td>
                                        <td>
                                            <a href="{{ route('delete.contact.us.message', $item->id) }}"
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
