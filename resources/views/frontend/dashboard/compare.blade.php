@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    Compare Properties
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
            <h1>Compare Properties</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Compare Properties</li>
            </ul>
        </div>
    </div>

</section>
<!--End Page Title-->


<!-- properties-section -->
<section class="properties-section centred">

    <div class="auto-container">

        <div class="table-outer">

            <table class="properties-table">

                <style>
                    .custom_compare_remove {
                        position: relative;
                        display: inline-block;
                        width: 40px;
                        height: 40px;
                        line-height: 40px;
                        border: 1px solid #e5e7ec;
                        border-radius: 4px;
                        font-size: 20px;
                        color: #a6a7af;
                        text-align: center;
                    }

                    .custom_compare_remove:hover {
                        background-color: #2dbe6c;
                        border-color: #2dbe6c;
                    }
                </style>

                {{-- Load Compare Data into frontend_dashboard.blade.php --}}
                <tbody id="compare"></tbody>

            </table>

        </div>

    </div>

</section>
<!-- properties-section end -->


@endsection
