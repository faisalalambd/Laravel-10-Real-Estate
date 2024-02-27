@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    Property Types
@endsection

<style>
    .category-section .category-list li {
        width: 25%;
    }

    .category-block-one .inner-box {
        max-width: 265px;
    }
</style>


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
            <h1>Property Types</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>All Property Types</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- category-section -->
<section class="category-section category-page centred mr-0 pt-120 pb-90">

    <div class="auto-container">

        <div class="inner-container wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">

            <ul class="category-list clearfix">

                @foreach ($property_types_data as $property_types)
                    @php
                        $property_count = App\Models\Property::where('propertyType_id', $property_types->id)->get();
                    @endphp

                    <li>

                        <div class="category-block-one">

                            <div class="inner-box">

                                <div class="icon-box">
                                    <i class="{{ $property_types->type_icon }}"></i>
                                </div>

                                <h5>
                                    <a
                                        href="{{ route('property.type', $property_types->id) }}">{{ $property_types->type_name }}</a>
                                </h5>

                                <span>{{ count($property_count) }}</span>

                            </div>

                        </div>
                    </li>
                @endforeach

            </ul>

        </div>

    </div>

</section>
<!-- category-section end -->


@endsection
