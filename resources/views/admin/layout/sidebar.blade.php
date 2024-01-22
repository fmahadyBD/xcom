        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('admin/dashboard') }}" class="brand-link">
                <img src="{{ url('admin/images/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin Panel</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (!empty(Auth::guard('admin')->user()->image))
                            <img src="{{ asset(Auth::guard('admin')->user()->image) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @else
                            <img src="{{ asset('admin/images/photos/fahimBasic.png') }}" class="img-circle elevation-3"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ url('admin/dashboard') }}"
                            class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (Session::get('page') == 'dashboard')
                            @php $active="active" @endphp
                        @else
                            @php $active="" @endphp
                        @endif
                        <li class="nav-item">
                            <a href="{{ url('admin/dashboard') }}" class="nav-link {{ $active }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        {{-- This for the seeion is checked or not --}}
                        @if (Session::get('page') == 'updatepassword' || Session::get('page') == 'updatepassword')
                            @php $active="active" @endphp
                        @else
                            @php $active="" @endphp
                        @endif
                        {{-- I dont want to subadmin can assess setting section , so make it as a condition --}}
                        @if (Auth::guard('admin')->user()->type == 'admin')
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link {{ $active }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Settings
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (Session::get('page') == 'updatepassword')
                                        @php $active="active" @endphp
                                    @else
                                        @php $active="" @endphp
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{ url('admin/update-password') }}"
                                            class="nav-link {{ $active }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Update Admin Password</p>
                                        </a>
                                    </li>
                                    @if (Session::get('page') == 'updatedetails')
                                        @php $active="active" @endphp
                                    @else
                                        @php $active="" @endphp
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{ route('edit') }}" class="nav-link  {{ $active }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Update Admin Details</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Session::get('page') == 'subadmins')
                            @php $active="active" @endphp
                        @else
                            @php $active="" @endphp
                        @endif

                        <li class="nav-item">
                            <a href="{{ url('/admin/subadmins') }}" class="nav-link {{ $active }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Subadmins
                                </p>
                            </a>
                        </li>
                        @if (Session::get('page') == 'cms-pages')
                            @php $active="active" @endphp
                        @else
                            @php $active="" @endphp
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('cms-pages') }}" class="nav-link {{ $active }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    CMS Pages

                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
