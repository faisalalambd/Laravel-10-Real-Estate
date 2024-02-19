<nav class="sidebar">

    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            Admin<span>Panel</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>


    <div class="sidebar-body">

        <ul class="nav">

            <li class="nav-item nav-category">Main</li>

            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>


            <li class="nav-item nav-category">Property</li>

            <li class="nav-item">
                <a href="{{ route('all.propertyType') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Property Type</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('all.state') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Property State</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('all.amenities') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Amenities</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('all.property') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Property</span>
                </a>
            </li>


            <li class="nav-item nav-category">Package</li>

            <li class="nav-item">
                <a href="{{ route('admin.package.history') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Package History</span>
                </a>
            </li>


            <li class="nav-item nav-category">Message</li>

            <li class="nav-item">
                <a href="{{ route('admin.property.message') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Property Message</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('all.testimonial') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Testimonials Manage</span>
                </a>
            </li>


            <li class="nav-item nav-category">Agent</li>

            <li class="nav-item">
                <a href="{{ route('all.agent') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Manage Agent</span>
                </a>
            </li>


            <li class="nav-item nav-category">Blog</li>

            <li class="nav-item">
                <a href="{{ route('all.blog.category') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Blog Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('all.blog.post') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Blog Post</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.blog.comment') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Blog Comment</span>
                </a>
            </li>


            <li class="nav-item nav-category">Setting</li>

            <li class="nav-item">
                <a href="{{ route('smtp.setting') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">SMTP Setting</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('site.setting') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Site Setting</span>
                </a>
            </li>

        </ul>

    </div>

</nav>
