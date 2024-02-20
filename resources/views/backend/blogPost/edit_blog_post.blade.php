@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    Edit Blog Post
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#!">Form</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Blog Post</li>
        </ol>
    </nav>

    <div class="row profile-body">

        <div class="col-md-12 col-xl-12 middle-wrapper">

            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form id="myForm" method="POST" action="{{ route('update.blog.post') }}"
                            class="forms-sample" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $blog_post->id }}">

                            <div class="row">

                                <div class="col-sm-6 form-group mb-3">
                                    <label class="form-label">Blog Post Title</label>
                                    <input type="text" name="post_title" class="form-control"
                                        value="{{ $blog_post->post_title }}">
                                </div>

                                <div class="col-sm-6 form-group mb-3">
                                    <label class="form-label">Blog Category</label>
                                    <select name="blog_category_id" class="form-select">
                                        <option selected="" disabled="">Select Category</option>
                                        @foreach ($blog_category as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $blog_post->blog_category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea class="form-control" name="short_description" rows="3">
                                        {{ $blog_post->short_description }}
                                    </textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Long Description</label>
                                <textarea class="form-control" name="long_description" id="tinymceExample" rows="10">
                                        {{ $blog_post->long_description }}
                                    </textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Blog Post Tags</label>
                                <input name="post_tags" id="tags" value="{{ $blog_post->post_tags }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Blog Post Image</label>
                                <input type="file" name="post_image" class="form-control" id="image">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"> </label>
                                <img id="showImage" class="wd-80 rounded-circle"
                                    src="{{ asset($blog_post->post_image) }}" alt="Blog Post Photo"
                                    style="width:100px; height:100px;">
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
                post_title: {
                    required: true,
                },
                blog_category_id: {
                    required: true,
                },
            },
            messages: {
                post_title: {
                    required: 'Please Enter Blog Post Title',
                },
                blog_category_id: {
                    required: 'Please Enter Blog Category',
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
