@extends('agent.agent_dashboard')
@section('agent')

@section('agent_title')
    Agent Profile View
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">

    <div class="row profile-body">

        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">

            <div class="card rounded">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <img class="wd-100 rounded-circle"
                                src="{{ !empty($profileData->photo) ? url('upload/agent_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                alt="profile">
                            <span class="h4 ms-3 ">{{ $profileData->username }}</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                        <p class="text-muted">{{ $profileData->name }}</p>
                    </div>

                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ $profileData->email }}</p>
                    </div>

                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                        <p class="text-muted">{{ $profileData->phone }}</p>
                    </div>

                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                        <p class="text-muted">{{ $profileData->address }}</p>
                    </div>

                    <br>

                    <div class="mt-3 d-flex social-links">

                        <a href="{{ $profileData->facebook }}" target="_blank;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="facebook"></i>
                        </a>

                        <a href="{{ $profileData->youtube }}" target="_blank;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="youtube"></i>
                        </a>

                        <a href="{{ $profileData->instagram }}" target="_blank;"
                            class="btn btn-icon border btn-xs me-2">
                            <i data-feather="instagram"></i>
                        </a>

                        <a href="{{ $profileData->linkedin }}" target="_blank;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="linkedin"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>
        <!-- left wrapper end -->


        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">

            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <h6 class="card-title">Update Agent Profile </h6>

                        <form method="POST" action="{{ route('agent.profile.store') }}" class="forms-sample"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf

                            <div class="row">

                                <div class="col-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ $profileData->username }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $profileData->name }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ $profileData->email }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ $profileData->phone }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ $profileData->address }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" name="facebook" class="form-control"
                                        value="{{ $profileData->facebook }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">YouTube</label>
                                    <input type="text" name="youtube" class="form-control"
                                        value="{{ $profileData->youtube }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" name="instagram" class="form-control"
                                        value="{{ $profileData->instagram }}">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" name="linkedin" class="form-control"
                                        value="{{ $profileData->linkedin }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3">{{ $profileData->description }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Photo </label>
                                    <input class="form-control" name="photo" type="file" id="image">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label"> </label>
                                    <img id="showImage" class="wd-80 rounded-circle"
                                        src="{{ !empty($profileData->photo) ? url('upload/agent_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                        alt="Agent Profile Image">
                                </div>

                            </div>

                            <button type="submit" class="btn btn-outline-primary me-2">Save Changes</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>
        <!-- middle wrapper end -->

    </div>

</div>


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
