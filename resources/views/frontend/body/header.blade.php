@php
    $site_setting = App\Models\SiteSetting::find(1);
@endphp


<header class="main-header">

    <!-- header-top -->
    <div class="header-top">

        <div class="top-inner clearfix">

            <div class="left-column pull-left">

                <ul class="info clearfix">

                    <li>
                        <i class="far fa-map-marker-alt"></i>
                        {{ $site_setting->company_address }}
                    </li>

                    {{-- <li>
                        <i class="far fa-clock"></i>Mon - Sat 9.00 - 18.00
                    </li> --}}

                    <li>
                        <i class="far fa-phone"></i>
                        <a href="tel:{{ $site_setting->company_phone }}">{{ $site_setting->company_phone }}</a>
                    </li>

                </ul>

            </div>


            <div class="right-column pull-right">

                <ul class="social-links clearfix">

                    <li>
                        <a href="{{ $site_setting->facebook }}" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>

                    <li>
                        <a href="{{ $site_setting->youtube }}" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>

                    <li>
                        <a href="{{ $site_setting->instagram }}" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>

                    <li>
                        <a href="{{ $site_setting->twitter }}" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>

                </ul>


                @auth
                    <div class="sign-box">
                        <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i>Dashboard</a>
                        |
                        <a href="{{ route('user.logout') }}"><i class="fas fa-sign-out"></i>Logout</a>
                    </div>
                @else
                    <div class="sign-box">
                        <a href="{{ route('login') }}"><i class="fas fa-sign-in"></i>Sign In</a>
                    </div>
                @endauth

            </div>

        </div>

    </div>


    <!-- header-lower -->
    <div class="header-lower">

        <div class="outer-box">

            <div class="main-box">

                <div class="logo-box">
                    <figure class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset($site_setting->company_logo) }}" alt="Company Logo">
                        </a>
                    </figure>
                </div>


                <div class="menu-area clearfix">

                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler">
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </div>


                    <nav class="main-menu navbar-expand-md navbar-light">

                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">

                            <ul class="navigation clearfix">

                                <li><a href="{{ url('/') }}"><span>Home</span></a></li>

                                <li><a href="{{ route('about.us') }}"><span>About Us</span></a></li>

                                <li><a href="{{ route('our.services') }}"><span>Services</span></a></li>

                                <li class="dropdown"><a href="{{ route('properties') }}"><span>Property</span></a>
                                    <ul>
                                        <li><a href="{{ route('rent.property') }}">Rent Property</a></li>
                                        <li><a href="{{ route('buy.property') }}">Buy Property</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('agents') }}"><span>Agent</span></a></li>

                                <li><a href="{{ route('blog.list') }}"><span>Blog</span></a></li>

                                <li><a href="{{ route('contact.us') }}"><span>Contact</span></a></li>

                                {{-- <li>
                                    <style>
                                        .custom_button:hover {
                                            color: #2dbe6c !important;
                                            background-color: #000 !important;
                                            border: 1px solid #2dbe6c !important;
                                        }
                                    </style>
                                    <a href="{{ route('agent.login') }}"
                                        class="theme-btn btn-one btn-light custom_button">
                                        <span>+</span>Add Listing</a>
                                </li> --}}

                            </ul>

                        </div>

                    </nav>

                </div>


                {{-- <div class="btn-box">
                    <a href="{{ route('agent.login') }}" class="theme-btn btn-one"><span>+</span>Add Listing</a>
                </div> --}}

            </div>

        </div>

    </div>


    <!--sticky Header-->
    <div class="sticky-header">

        <div class="outer-box">

            <div class="main-box">

                <div class="logo-box">
                    <figure class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset($site_setting->company_logo) }}" alt="Company Logo">
                        </a>
                    </figure>
                </div>


                <div class="menu-area clearfix">
                    <nav class="main-menu clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav>
                </div>

                {{-- <div class="btn-box">
                    <a href="{{ route('agent.login') }}" class="theme-btn btn-one"><span>+</span>Add Listing</a>
                </div> --}}

            </div>

        </div>

    </div>

</header>
