@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#!">Form</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Testimonial</li>
            </ol>
        </nav>

        <div class="row profile-body">

            <div class="col-md-12 col-xl-12 middle-wrapper">

                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form id="myForm" method="POST" action="{{ route('update.testimonial') }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $testimonial->id }}">

                                <div class="form-group mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $testimonial->name }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" value="{{ $testimonial->designation }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="3">{{ $testimonial->message }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Testimonial Image</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"> </label>
                                    <img id="showImage" class="wd-80 rounded-circle" src="{{ asset($testimonial->image) }}"
                                        alt="State Photo" style="width:100px; height:100px;">
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
                    name: {
                        required: true,
                    },
                    designation: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Testimonial Name',
                    },
                    designation: {
                        required: 'Please Enter Testimonial Designation',
                    },
                    message: {
                        required: 'Please Enter Testimonial Message',
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
