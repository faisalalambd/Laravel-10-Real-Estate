@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    Wishlist
@endsection


<!--Page Title-->
<section class="page-title-two bg-color-1 centred">

    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
        </div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});">
        </div>
    </div>

    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Wishlist</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Wishlist</li>
            </ul>
        </div>
    </div>

</section>
<!--End Page Title-->


<!-- property-page-section -->
<section class="property-page-section property-list">

    <div class="auto-container">

        <div class="row clearfix">

            @php
                $id = Auth::user()->id;
                $userData = App\Models\User::find($id);
            @endphp

            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">

                <div class="blog-sidebar">

                    <div class="sidebar-widget post-widget">

                        <div class="widget-title">
                            <h4>User Profile </h4>
                        </div>

                        <div class="post-inner">

                            <div class="post">

                                <figure class="post-thumb">
                                    <img src="{{ !empty($userData->photo) ? url('upload/user_images/' . $userData->photo) : url('upload/no_image.jpg') }}"
                                        alt="">
                                </figure>

                                <h5>{{ $userData->name }}</h5>

                                <p>{{ $userData->email }} </p>

                            </div>

                        </div>

                    </div>


                    <div class="sidebar-widget category-widget">

                        <div class="widget-title"></div>


                        @include('frontend.dashboard.dashboard_sidebar')

                    </div>

                </div>

            </div>


            <div class="col-lg-8 col-md-12 col-sm-12 content-side">

                <div class="property-content-side">

                    <div class="wrapper list">

                        <div class="deals-list-content list-item">

                            {{-- Load Wishlist Data into frontend_dashboard.blade.php --}}
                            <div id="wishlist"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- property-page-section end -->


@endsection
