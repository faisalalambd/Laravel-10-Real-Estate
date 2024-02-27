@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    Our Services
@endsection


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
            <h1>Our Services</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>All Services</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- feature-style-three -->
<section class="feature-style-three service-page centred">

    <div class="auto-container">

        <div class="row clearfix">

            @foreach ($our_services_data as $our_services)
                <div class="col-lg-4 col-md-6 col-sm-12 feature-block">

                    <div class="feature-block-two wow fadeInUp animated" data-wow-delay="00ms"
                        data-wow-duration="1500ms">

                        <div class="inner-box">

                            <div class="icon-box">
                                <i class="{{ $our_services->icon }}"></i>
                            </div>

                            <h4>{{ $our_services->name }}</h4>

                            <p>{{ $our_services->short_description }}</p>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</section>
<!-- feature-style-three end -->


@endsection
