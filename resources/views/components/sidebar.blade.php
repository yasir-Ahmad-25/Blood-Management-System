<!-- resources/views/components/sidebar.blade.php -->
<aside class="sidebar bg-black text-white vh-100 position-fixed" style="width: 230px; left: 0; top: 0; z-index: 1040;">
    <div class="sidebar-header p-4 d-flex align-items-center">
        <span class="fw-bold fs-4">🩸 BloodBank</span>
    </div>
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a href="{{ route('admin.index')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.dashboard') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-house"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.donors')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.donors') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-person-badge"></i> Donors
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.donations')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.donations') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-person-badge"></i> Donations
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.blood_inventories')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.blood_inventories') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-droplet"></i> Inventory
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.requests_blood')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.requests') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-inbox"></i> Requests
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.hospitals')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.hospitals') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-hospital"></i> Hospitals
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.report')}}" class="nav-link text-white py-3 px-4 {{ request()->routeIs('admin.reports') ? 'active bg-white text-black' : '' }}">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </li>
        <li class="nav-item mt-auto">
            <a href="{{ route('admin.logout')}}" class="nav-link text-white py-3 px-4">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
    <style>
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: white !important;
            color: black !important;
            border-radius: 12px;
            transition: 0.2s;
        }
        .sidebar {
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.10);
        }
        .sidebar-header {
            border-bottom: 1px solid #222;
        }
    </style>
</aside>
