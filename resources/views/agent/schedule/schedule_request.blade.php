@extends('agent.agent_dashboard')
@section('agent')

@section('agent_title')
    All Schedule Request
@endsection


<div class="page-content">

    <nav class="page-breadcrumb">

        <div class="row">

            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Schedule Request</li>
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
                                    <th>User</th>
                                    <th>Property</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($user_message as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item['user']['name'] }}</td>
                                        <td>{{ $item['property']['property_name'] }}</td>
                                        <td>{{ $item->tour_date }}</td>
                                        <td>{{ $item->tour_time }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge rounded-pill bg-success">Confirm</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.details.schedule', $item->id) }}"
                                                class="btn btn-outline-info" title="Details">
                                                <i data-feather="eye"></i>
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
