<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TuVi Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a> {{-- Auth::user()->name --}}
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Users Management --}}
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Quản lý Thành viên</p>
                    </a>
                </li>

                {{-- Horoscopes Management --}}
                <li class="nav-item">
                    <a href="{{ route('admin.horoscopes.index') }}" class="nav-link {{ request()->routeIs('admin.horoscopes.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star-of-david"></i>
                        <p>Quản lý Lá số</p>
                    </a>
                </li>
                
                {{-- Glossaries Management --}}
                <li class="nav-item">
                    <a href="{{ route('admin.glossaries.index') }}" class="nav-link {{ request()->routeIs('admin.glossaries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Quản lý Thuật ngữ</p>
                    </a>
                </li>

                {{-- Tags Management --}}
                <li class="nav-item">
                    <a href="{{ route('admin.tags.index') }}" class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Quản lý Tags</p>
                    </a>
                </li>

                {{-- Stars Management --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Quản lý Sao
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.stars.index') }}" class="nav-link {{ request()->routeIs('admin.stars.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Sao</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stars.create') }}" class="nav-link {{ request()->routeIs('admin.stars.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Sao mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Rules Management --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-gavel"></i> {{-- Biểu tượng cái búa hoặc cuốn sách luật --}}
                        <p>
                            Quản lý Luật giải
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.rules.index') }}" class="nav-link {{ request()->routeIs('admin.rules.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Rules</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rules.create') }}" class="nav-link {{ request()->routeIs('admin.rules.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Rule mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Other menus can be added here --}}

            </ul>
        </nav>
    </div>
</aside>