@extends('agent.agent_dashboard')
@section('agent')
    <div class="page-content">

        <nav class="page-breadcrumb">

            <div class="row">

                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#!">Table</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Package History</li>
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
                                        <th>Package</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($package_history as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{ !empty($item->user->photo) ? url('upload/agent_images/' . $item->user->photo) : url('upload/no_image.jpg') }}"
                                                    style="width:60px; height:60px;">
                                            </td>
                                            <td>{{ $item->package_name }}</td>
                                            <td>{{ $item->invoice }}</td>
                                            <td>{{ $item->package_amount }}</td>
                                            <td>{{ $item->created_at->format('l d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('agent.package.invoice', $item->id) }}"
                                                    class="btn btn-outline-warning" title="Download">
                                                    <i data-feather="download"></i>
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
