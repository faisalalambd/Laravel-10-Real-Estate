@php
    $our_services_home = App\Models\OurServices::latest()->limit(3)->get();
@endphp


<section class="chooseus-section">

    <div class="auto-container">

        <div class="inner-container bg-color-2">

            <div class="upper-box clearfix">

                <div class="sec-title light">
                    <h5>Why Choose Us?</h5>
                    <h2>Reasons To Choose Us</h2>
                </div>


                <div class="btn-box">
                    <a href="{{ route('our.services') }}" class="theme-btn btn-one">All Services</a>
                </div>

            </div>


            <div class="lower-box">

                <div class="row clearfix">

                    @foreach ($our_services_home as $our_services)
                        <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">

                            <div class="chooseus-block-one">

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

        </div>

    </div>

</section>
