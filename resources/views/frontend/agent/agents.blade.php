@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    Agents
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
            <h1>Agents</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Agents List</li>
            </ul>
        </div>
    </div>

</section>
<!--End Page Title-->


<!-- agents-page-section -->
<section class="agents-page-section agents-list">

    <div class="auto-container">

        <div class="row clearfix">

            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">

                <div class="default-sidebar agent-sidebar">

                    <div class="agents-search sidebar-widget">

                        <div class="widget-title">
                            <h5>Find Agent</h5>
                        </div>

                        <div class="search-inner">

                            <form action="{{ route('search.agents') }}" method="GET">

                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Enter Agent Name" required="">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="theme-btn btn-one">Search Agent</button>
                                </div>

                            </form>

                        </div>

                    </div>


                    <div class="category-widget sidebar-widget">

                        <div class="widget-title">
                            <h5>Status Of Property</h5>
                        </div>


                        <ul class="category-list clearfix">
                            <li><a href="{{ route('rent.property') }}">For Rent
                                    <span>({{ count($rent_property) }})</span></a></li>
                            <li><a href="{{ route('buy.property') }}">For Buy
                                    <span>({{ count($buy_property) }})</span></a></li>
                        </ul>

                    </div>


                    <div class="featured-widget sidebar-widget">

                        <div class="widget-title">
                            <h5>Featured Properties</h5>
                        </div>

                        <div class="single-item-carousel owl-carousel owl-theme owl-nav-none dots-style-one">

                            @foreach ($featured as $item)
                                <div class="feature-block-one">

                                    <div class="inner-box">

                                        <div class="image-box">

                                            <figure class="image">
                                                <img src="{{ asset($item->property_thumbnail) }}" alt=""
                                                    style="width:370px; height:250px;">
                                            </figure>

                                            <div class="batch"><i class="icon-11"></i></div>
                                            <span class="category">Featured</span>

                                        </div>


                                        <div class="lower-content">

                                            <div class="title-text">
                                                <h4>
                                                    <a
                                                        href="{{ url('property/details/' . $item->id . '/' . $item->property_slug) }}">
                                                        {{ $item->property_name }}
                                                    </a>
                                                </h4>
                                            </div>

                                            <div class="price-box clearfix">
                                                <div class="price-info">
                                                    <h6>Start From</h6>
                                                    <h4>$ {{ number_format($item->lowest_price) }}</h4>
                                                </div>
                                            </div>

                                            <p>{{ $item->short_description }}</p>

                                            <div class="btn-box">
                                                <a href="{{ url('property/details/' . $item->id . '/' . $item->property_slug) }}"
                                                    class="theme-btn btn-two">
                                                    See Details
                                                </a>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-8 col-md-12 col-sm-12 content-side">

                <div class="agency-content-side">

                    <div class="item-shorting clearfix">

                        <div class="left-column pull-left">

                            <h5>Search Reasults: <span>Showing {{ count($agents_data) }} Agents</span></h5>

                        </div>

                    </div>


                    <div class="wrapper grid">

                        <div class="agents-grid-content">

                            <div class="row clearfix">

                                @foreach ($agents_data as $agents)
                                    <div class="col-lg-4 col-md-4 col-sm-12 agents-block">

                                        <div class="agents-block-two">

                                            <div class="inner-box">

                                                <figure class="image-box">
                                                    <img src="{{ !empty($agents->photo) ? url('upload/agent_images/' . $agents->photo) : url('upload/no_image.jpg') }}"
                                                        alt="">
                                                </figure>

                                                <div class="content-box">
                                                    <div class="title-inner">
                                                        <h4>
                                                            <a href="{{ route('agent.details', $agents->id) }}">
                                                                {{ $agents->name }}
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <ul class="info clearfix">

                                                        <li>
                                                            <i class="fab fa fa-envelope"></i>
                                                            <a href="mailto:{{ $agents->email }}">
                                                                {{ $agents->email }}
                                                            </a>
                                                        </li>

                                                        <br>

                                                        <li>
                                                            <i class="fab fa fa-phone"></i>
                                                            <a href="tel:{{ $agents->phone }}">
                                                                {{ $agents->phone }}
                                                            </a>
                                                        </li>

                                                    </ul>

                                                    <div class="btn-box">
                                                        <a href="{{ route('agent.details', $agents->id) }}"
                                                            class="theme-btn btn-two">
                                                            View Profile
                                                        </a>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>


                    <div class="pagination-wrapper">
                        {{ $agents_data->links('vendor.pagination.custom') }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- agents-page-section end -->

@endsection
