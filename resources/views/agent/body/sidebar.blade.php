@php
    $id = Auth::user()->id;
    $agentId = App\Models\User::find($id);
    $status = $agentId->status;
@endphp


<nav class="sidebar">

    <div class="sidebar-header">
        <a href="{{ route('agent.dashboard') }}" class="sidebar-brand">
            Agent<span>Panel</span>
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
                <a href="{{ route('agent.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            @if ($status === 'active')
                <li class="nav-item nav-category">Real Estate</li>

                <li class="nav-item">
                    <a href="{{ route('agent.all.property') }}" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Property</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('buy.package') }}" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Buy Package</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('package.history') }}" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Package History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('agent.property.message') }}" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Property Message</span>
                    </a>
                </li>
            @else
            @endif

        </ul>

    </div>

</nav>
