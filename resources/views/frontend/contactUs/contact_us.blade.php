@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    Contact Us
@endsection


@php
    $site_setting_data = App\Models\SiteSetting::find(1);
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
            <h1>Contact Us</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- contact-info-section -->
<section class="contact-info-section sec-pad centred">

    <div class="auto-container">

        <div class="sec-title">
            <h5>Contact us</h5>
            <h2>Get In Touch</h2>
        </div>


        <div class="row clearfix">

            <div class="col-lg-4 col-md-6 col-sm-12 info-block">

                <div class="info-block-one">

                    <div class="inner-box">

                        <div class="icon-box">
                            <i class="icon-32"></i>
                        </div>

                        <h4>Email Address</h4>

                        <p>
                            <a href="mailto:{{ $site_setting_data->company_email }}">
                                {{ $site_setting_data->company_email }}
                            </a>
                        </p>

                    </div>

                </div>

            </div>


            <div class="col-lg-4 col-md-6 col-sm-12 info-block">

                <div class="info-block-one">

                    <div class="inner-box">

                        <div class="icon-box">
                            <i class="icon-33"></i>
                        </div>

                        <h4>Phone Number</h4>

                        <p>
                            <a href="tel:{{ $site_setting_data->company_phone }}">
                                {{ $site_setting_data->company_phone }}
                            </a>
                        </p>

                    </div>

                </div>

            </div>


            <div class="col-lg-4 col-md-6 col-sm-12 info-block">

                <div class="info-block-one">

                    <div class="inner-box">

                        <div class="icon-box">
                            <i class="icon-34"></i>
                        </div>

                        <h4>Office Address</h4>

                        <p>{{ $site_setting_data->company_address }}</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- contact-info-section end -->


<!-- contact-section -->
<section class="contact-section bg-color-1">

    <div class="auto-container">

        <div class="row align-items-center clearfix">

            <div class="col-lg-6 col-md-12 col-sm-12 content-column">

                <div class="content-box">

                    <div class="sec-title">
                        <h5>Contact</h5>
                        <h2>Contact Us</h2>
                    </div>


                    <div class="form-inner">

                        <form method="post" action="{{ route('store.contact.us') }}" id="contact-form">

                            @csrf

                            <div class="row clearfix">

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="username" placeholder="Your Name" required="">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="email" name="email" placeholder="Email address" required="">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="phone" placeholder="Phone" required="">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="subject" placeholder="Subject" required="">
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea name="message" placeholder="Message"></textarea>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button class="theme-btn btn-one" type="submit" name="submit-form">
                                        Send Message
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            <div class="col-lg-6 col-md-12 col-sm-12 map-column">

                <div class="google-map-area">

                    <div class="google-map" id="contact-google-map" data-map-lat="23.810331" data-map-lng="90.412521"
                        data-icon-path="{{ asset('frontend/assets/images/icons/map-marker.png') }}"
                        data-map-title="{{ $site_setting_data->company_address }}" data-map-zoom="12"
                        data-markers='{
                            "marker-1": [23.810331, 90.412521, "<h4>Branch Office</h4><p>Dhaka, Bangladesh</p>","{{ asset('frontend/assets/images/icons/map-marker.png') }}"]
                        }'>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- contact-section end -->


<!-- subscribe-section -->
<section class="subscribe-section bg-color-3">
    <div class="pattern-layer" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
    </div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 text-column">
                <div class="text">
                    <span>Subscribe</span>
                    <h2>Sign Up To Our Newsletter To Get The Latest News And Offers.</h2>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 form-column">
                <div class="form-inner">
                    <form action="contact.html" method="post" class="subscribe-form">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Enter your email" required="">
                            <button type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- subscribe-section end -->


@endsection
