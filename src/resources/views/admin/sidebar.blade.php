<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EC SITE</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>ダッシュボード</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>商品管理</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('keyvisual.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>キービジュアル管理</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>振込管理</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>アカウント管理</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->