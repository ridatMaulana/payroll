<div class="sidebar">
    <div class="sidebar-header d-flex flex-column align-items-center position-relative">
        <img src="http://localhost:9000/payroll/system_resources%2Ficon-asqi.png?" alt="" srcset=""
        style="width: 50px; height: 50px;">
        <h3 class="text-white mb-0">{{ config('app.name', 'Laravel') }}</h3>
        <button class="btn-close-sidebar d-lg-none position-absolute top-0 end-0 m-2" style="background-color: #343a40; border: none;">
            <i class="bi bi-x-lg text-white"></i>
        </button>
    </div>
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @if(Auth::user()->role->nama == 'Admin')
        <li class="nav-item">
            <a href="{{ route('karyawan') }}" class="nav-link {{ request()->is('karyawan/*') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                <span>Karyawan</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->role->nama == 'Admin')
        <li class="nav-item">
            <a href="{{ route('komponen.index') }}" class="nav-link {{ request()->is('komponen/*') ? 'active' : '' }}">
                <i class="bi bi-archive"></i>
                <span>Komponen Tambahan</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->role->nama != 'Karyawan')
        <li class="nav-item">
            <a href="{{ route('gaji.index') }}" class="nav-link {{ request()->is('gaji/*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Gaji</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->role->nama == 'Karyawan')
        <li class="nav-item">
            <a href="{{ route('slip-gaji.index', ['karyawan_id' => Auth::user()->karyawan->id]) }}" class="nav-link {{ request()->is('slip-gaji/*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Slip Gaji</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->role->nama != 'Direktur')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('keluhan/*') ? 'active' : '' }}" href="{{ route('keluhan.index') }}">
                <i class="bi-chat-left-dots"></i>
                <span>Keluhan</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->role->nama == 'Admin')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('notification/*') ? 'active' : '' }}" href="{{ route('notification.index') }}">
                <i class="bi bi-bell"></i>
                <span>Notifikasi</span>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
