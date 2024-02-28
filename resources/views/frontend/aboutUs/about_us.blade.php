@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    About Us
@endsection


@php
    $about_us_data = App\Models\AboutUs::find(1);

    $our_partners_data = App\Models\OurPartners::latest()->get();
@endphp


<!--Page Title-->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
        </div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
        </div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>About Us</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>About Us</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- about-section -->
<section class="about-section about-page pb-0">

    <div class="auto-container">

        <div class="inner-container">

            <div class="row align-items-center clearfix">

                <div class="col-lg-6 col-md-12 col-sm-12 image-column">

                    <div class="image_block_2">

                        <div class="image-box">

                            <figure class="image">
                                <img src="{{ $about_us_data->image }}" alt="">
                            </figure>


                            <div class="text wow fadeInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                <h2>{{ $about_us_data->years }}</h2>
                                <h4>Years of <br />Service</h4>
                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-lg-6 col-md-12 col-sm-12 content-column">

                    <div class="content_block_3">

                        <div class="content-box">

                            <div class="sec-title">

                                <h5>About</h5>

                                <h2>{{ $about_us_data->title }}</h2>

                            </div>


                            <div class="text">
                                <p>{!! $about_us_data->long_description !!}</p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- about-section end -->


<!-- clients-section -->
<section class="clients-section bg-color-1">

    <div class="pattern-layer" style="background-image: url({{ asset('frontend/assets/images/shape/shape-1.png') }});">
    </div>


    <div class="auto-container">

        <div class="row clearfix">

            <div class="col-lg-4 col-md-12 col-sm-12 title-column">
                <div class="sec-title">
                    <h5>Our Pertners</h5>
                    <h2>We’re going to Became Partners for the Long Run.</h2>
                </div>
            </div>


            <div class="col-lg-8 col-md-12 col-sm-12 inner-column">

                <div class="clients-logo">

                    <ul class="logo-list clearfix">
                        @foreach ($our_partners_data as $our_partners)
                            <li>
                                <figure class="logo">
                                    <a href="#!">
                                        <img src="{{ $our_partners->image }}" alt="{{ $our_partners->name }}"
                                            title="{{ $our_partners->name }}">
                                    </a>
                                </figure>
                            </li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- clients-section end -->


@endsection
