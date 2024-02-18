@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#!">Form</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit SMTP Setting</li>
            </ol>
        </nav>

        <div class="row profile-body">

            <div class="col-md-12 col-xl-12 middle-wrapper">

                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form id="myForm" method="POST" action="{{ route('update.smtp.setting') }}"
                                class="forms-sample">
                                @csrf

                                <input type="hidden" name="id" value="{{ $smtp_setting->id }}">

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail Mailer</label>
                                    <input type="text" name="mail_mailer" class="form-control"
                                        value="{{ $smtp_setting->mail_mailer }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail Host</label>
                                    <input type="text" name="mail_host" class="form-control"
                                        value="{{ $smtp_setting->mail_host }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail Port</label>
                                    <input type="text" name="mail_port" class="form-control"
                                        value="{{ $smtp_setting->mail_port }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail Username</label>
                                    <input type="text" name="mail_username" class="form-control"
                                        value="{{ $smtp_setting->mail_username }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail Password</label>
                                    <input type="text" name="mail_password" class="form-control"
                                        value="{{ $smtp_setting->mail_password }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail Encryption</label>
                                    <input type="text" name="mail_encryption" class="form-control"
                                        value="{{ $smtp_setting->mail_encryption }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Mail From Address</label>
                                    <input type="text" name="mail_from_address" class="form-control"
                                        value="{{ $smtp_setting->mail_from_address }}">
                                </div>

                                <button type="submit" class="btn btn-outline-primary me-2">Update Changes</button>

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
                    amenity_name: {
                        required: true,
                    },
                },
                messages: {
                    amenity_name: {
                        required: 'Please Enter Amenity Name',
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
