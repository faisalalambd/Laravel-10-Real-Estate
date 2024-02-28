@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    Edit About Us
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#!">Form</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit About Us</li>
        </ol>
    </nav>

    <div class="row profile-body">

        <div class="col-md-12 col-xl-12 middle-wrapper">

            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form id="myForm" method="POST" action="{{ route('update.about.us') }}" class="forms-sample"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $about_us->id }}">

                            <div class="form-group mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ $about_us->title }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Long Description</label>
                                <textarea class="form-control" name="long_description" id="tinymceExample" rows="10">
                                    {!! $about_us->long_description !!}
                                </textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Years of Service</label>
                                <input type="text" name="years" class="form-control"
                                    value="{{ $about_us->years }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Image (440 X 570)</label>
                                <input type="file" name="image" class="form-control" id="image">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"> </label>
                                <img id="showImage" class="wd-80 rounded-circle" src="{{ asset($about_us->image) }}"
                                    alt="About Us Photo" style="width:100px; height:100px;">
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
                title: {
                    required: true,
                },
                long_description: {
                    required: true,
                },
                years: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: 'Please Enter About Us Title',
                },
                long_description: {
                    required: 'Please Enter About Us Description',
                },
                years: {
                    required: 'Please Enter About Us Years of Service',
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
