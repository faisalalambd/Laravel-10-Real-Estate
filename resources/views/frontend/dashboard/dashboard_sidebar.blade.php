<div class="widget-content">

    <ul class="category-list ">

        <li class="current">
            <a href="{{ route('dashboard') }}">
                <i class="fab fa fa-user"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('user.profile') }}">
                <i class="fa fa-edit" aria-hidden="true"></i> Edit Profile
            </a>
        </li>

        <li>
            <a href="{{ route('user.compare') }}">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Compare
            </a>
        </li>

        <li>
            <a href="{{ route('user.wishlist') }}">
                <i class="fa fa-indent" aria-hidden="true"></i> Wishlist
            </a>
        </li>

        <li>
            <a href="{{ route('user.change.password') }}">
                <i class="fa fa-key" aria-hidden="true"></i> Change Password
            </a>
        </li>

        <li>
            <a href="{{ route('user.logout') }}">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
            </a>
        </li>

    </ul>

</div>
