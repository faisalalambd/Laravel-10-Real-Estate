@extends('agent.agent_dashboard')
@section('agent')

@section('agent_title')
    Schedule Request Details
@endsection


<div class="page-content">

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">

                <div class="card-body">

                    <h6 class="card-title">Schedule Request Details</h6>

                    <form method="post" action="{{ route('agent.update.schedule') }}">

                        @csrf

                        <input type="hidden" name="id" value="{{ $schedule_details->id }}">
                        <input type="hidden" name="email" value="{{ $schedule_details->user->email }}">

                        <div class="table-responsive pt-3">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>
                                        <td>User Name </td>
                                        <td><code>{{ $schedule_details->user->name }}</code></td>
                                    </tr>

                                    <tr>
                                        <td>Property Name </td>
                                        <td><code>{{ $schedule_details->property->property_name }}</code></td>
                                    </tr>


                                    <tr>
                                        <td>Tour Date </td>
                                        <td><code>{{ $schedule_details->tour_date }}</code></td>
                                    </tr>


                                    <tr>
                                        <td>Tour Time </td>
                                        <td><code>{{ $schedule_details->tour_time }}</code></td>
                                    </tr>


                                    <tr>
                                        <td>Message </td>
                                        <td><code>{{ $schedule_details->tour_message }}</code></td>
                                    </tr>

                                    <tr>
                                        <td>Request Send Time </td>
                                        <td><code>{{ $schedule_details->created_at->format('l M d Y') }}</code></td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <br>

                        <button type="submit" class="btn btn-outline-success me-2">Request Confirm</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection
