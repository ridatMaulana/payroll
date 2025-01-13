<header class="dashboard-header">
    <button class="btn-toggle-sidebar d-lg-none">
        <i class="bi bi-list"></i>
    </button>

    <div class="header-right">
        <div class="dropdown">
            <button class="btn-profile dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i>
                {{-- {{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }} --}}
                {{-- <img src=""
                     alt="Profile"
                     class="profile-image"> --}}
                     {{-- {{ Auth::user()->name }} --}}
                <span class="d-none d-md-inline"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
