@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    Site Setting
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#!">Form</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Site Setting</li>
        </ol>
    </nav>

    <div class="row profile-body">

        <div class="col-md-12 col-xl-12 middle-wrapper">

            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form id="myForm" method="POST" action="{{ route('update.site.setting') }}"
                            class="forms-sample" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $site_setting->id }}">

                            <div class="form-group mb-3">
                                <label class="form-label">Company Phone</label>
                                <input type="text" name="company_phone" class="form-control"
                                    value="{{ $site_setting->company_phone }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Company Address</label>
                                <input type="text" name="company_address" class="form-control"
                                    value="{{ $site_setting->company_address }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Company Email</label>
                                <input type="email" name="company_email" class="form-control"
                                    value="{{ $site_setting->company_email }}">
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label class="form-label">Company About</label>
                                <textarea class="form-control" name="company_about" rows="3">
                                        {{ $site_setting->company_about }}
                                    </textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" name="facebook" class="form-control"
                                    value="{{ $site_setting->facebook }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">YouTube</label>
                                <input type="text" name="youtube" class="form-control"
                                    value="{{ $site_setting->youtube }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="text" name="instagram" class="form-control"
                                    value="{{ $site_setting->instagram }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Twitter</label>
                                <input type="text" name="twitter" class="form-control"
                                    value="{{ $site_setting->twitter }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Copyright</label>
                                <input type="text" name="copyright" class="form-control"
                                    value="{{ $site_setting->copyright }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Company Logo (1500, 386)</label>
                                <input type="file" name="company_logo" class="form-control" id="image">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"> </label>
                                <img id="showImage" class="wd-80" src="{{ asset($site_setting->company_logo) }}"
                                    alt="Company Logo" style="width:250px; height:100px;">
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
                company_phone: {
                    required: true,
                },
                company_address: {
                    required: true,
                },
                company_email: {
                    required: true,
                },
                company_about: {
                    required: true,
                },
                facebook: {
                    required: true,
                },
                youtube: {
                    required: true,
                },
                instagram: {
                    required: true,
                },
                twitter: {
                    required: true,
                },
                copyright: {
                    required: true,
                },
            },
            messages: {
                company_phone: {
                    required: 'Please Enter Company Phone Number',
                },
                company_address: {
                    required: 'Please Enter Company Address',
                },
                company_email: {
                    required: 'Please Enter Company Email',
                },
                company_about: {
                    required: 'Please Enter Company About',
                },
                facebook: {
                    required: 'Please Enter Company Facebook',
                },
                youtube: {
                    required: 'Please Enter Company YouTube',
                },
                instagram: {
                    required: 'Please Enter Company Instagram',
                },
                twitter: {
                    required: 'Please Enter Company Twitter',
                },
                copyright: {
                    required: 'Please Enter Company Copyright',
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
