@php
    $property_type = App\Models\PropertyType::latest()->limit(5)->get();
@endphp



<section class="category-section centred">

    <div class="auto-container">

        <div class="inner-container wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">

            <ul class="category-list clearfix">

                @foreach ($property_type as $item)
                    @php
                        $property_count = App\Models\Property::where('propertyType_id', $item->id)->get();
                    @endphp

                    <li>

                        <div class="category-block-one">

                            <div class="inner-box">

                                <div class="icon-box">
                                    <i class="{{ $item->type_icon }}"></i>
                                </div>

                                <h5>
                                    <a href="{{ route('property.type', $item->id) }}">
                                        {{ $item->type_name }}
                                    </a>
                                </h5>

                                <span>{{ count($property_count) }}</span>

                            </div>

                        </div>

                    </li>
                @endforeach

            </ul>

            <div class="more-btn">
                <a href="{{ route('property.types') }}" class="theme-btn btn-one">
                    All Property Types
                </a>
            </div>

        </div>

    </div>

</section>
