@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    Edit Our Service
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#!">Form</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Our Service</li>
        </ol>
    </nav>

    <div class="row profile-body">

        <div class="col-md-12 col-xl-12 middle-wrapper">

            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form id="myForm" method="POST" action="{{ route('update.our.service') }}"
                            class="forms-sample">
                            @csrf

                            <input type="hidden" name="id" value="{{ $our_service->id }}">

                            <div class="form-group mb-3">
                                <label class="form-label">Font Awesome Icon</label>
                                <input type="text" name="icon" class="form-control"
                                    value="{{ $our_service->icon }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Service Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $our_service->name }}">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea class="form-control" name="short_description" rows="3">{{ $our_service->short_description }}</textarea>
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
                font_awesome_icon: {
                    required: true,
                },
                name: {
                    required: true,
                },
                short_description: {
                    required: true,
                },
            },
            messages: {
                font_awesome_icon: {
                    required: 'Please Enter Font Awesome Icon',
                },
                name: {
                    required: 'Please Enter Service Name',
                },
                short_description: {
                    required: 'Please Enter Short Description',
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
