{{--@php--}}
{{--$links = [--}}
{{--    [--}}
{{--        "href" => "dashboard",--}}
{{--        "text" => "Dashboard",--}}
{{--        "is_multi" => false,--}}
{{--    ],--}}
{{--    [--}}
{{--        "href" => [--}}
{{--            [--}}
{{--                "section_text" => "User",--}}
{{--                "section_list" => [--}}
{{--                    ["href" => "user", "text" => "Data User"],--}}
{{--                    ["href" => "user.new", "text" => "Buat User"]--}}
{{--                ]--}}
{{--            ]--}}
{{--        ],--}}
{{--        "text" => "User",--}}
{{--        "is_multi" => true,--}}
{{--    ],--}}
{{--];--}}
{{--$navigation_links = array_to_object($links);--}}
{{--@endphp--}}

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="" alt="">
            </a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Outlet</li>
            <li class="{{ Request::routeIs('outlet.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('outlet.index') }}"><i class="fas fa-store"></i><span>Daftar Outlet</span></a>
            </li>

            <li class="menu-header">Barang</li>
            <li class="{{ Request::routeIs('barang.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('barang.index') }}"><i class="fas fa-boxes"></i><span>Daftar Barang</span></a>
            </li>

            <li class="menu-header">User</li>
            <li class="nav-item dropdown {{ Route::is(['user', 'user.*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Pendukung</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('user') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user') }}">User</a>
                    </li>
                    <li class="{{ Route::is('user.new') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.new') }}">New User</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
