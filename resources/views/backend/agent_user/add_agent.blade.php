@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#!">Form</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Agent</li>
            </ol>
        </nav>

        <div class="row profile-body">

            <div class="col-md-12 col-xl-12 middle-wrapper">

                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form id="myForm" method="POST" action="{{ route('store.agent') }}" class="forms-sample">
                                @csrf

                                <div class="form-group mb-3">
                                    <label class="form-label">Agent Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Agent Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>


                                <div class="form-group mb-3">
                                    <label class="form-label">Agent Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>



                                <div class="form-group mb-3">
                                    <label class="form-label">Agent Address</label>
                                    <input type="text" name="address" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Agent Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-outline-primary me-2">Save Changes</button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Agent Name',
                    },
                    email: {
                        required: 'Please Enter Agent Email',
                    },
                    phone: {
                        required: 'Please Enter Agent Phone',
                    },
                    password: {
                        required: 'Please Enter Agent Password',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
