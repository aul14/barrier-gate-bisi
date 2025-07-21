<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg p-0 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
    id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-1">
        <div class="d-flex justify-content-start">
            <img src="{{ asset('img/logo-bisi.png') }}" width="50" alt="Logo" class="img img-thumbnail">

            <span class="text-white font-weight-bolder mt-3 ms-2">PT Bisi International Tbk</span>
        </div>
        <nav aria-label="breadcrumb">
            <h5 class="font-weight-bolder text-white position-absolute start-50 translate-middle">
                {{ $title }}</h5>
        </nav>

        <div class="collapse navbar-collapse d-flex me-4 justify-content-end" id="navbar">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->fullname }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    @if (auth()->user()->role == 'admin')
                        <li><a class="dropdown-item btn-register" href="javascript:void(0)">
                                <i class="fa fa-user-plus"></i> Add User</a>
                        </li>
                    @endif
                    @if (Request::is('report*'))
                        <li><a class="dropdown-item" href="{{ route('full_table') }}">
                                <i class="fa fa-table"></i> Dashboard Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('/') }}">
                                <i class="fa fa-tv"></i> Realtime Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('log.index') }}">
                                <i class="fa fa-history"></i> Log Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('antrian.index') }}">
                                <i class="fa fa-list"></i> Antrian Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fa fa-user-gear"></i> User Management</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('log_sap.index') }}">
                                    <i class="fa fa-list-alt"></i> Log API SAP</a>
                            </li>
                        @endif
                    @elseif (Request::is('log*'))
                        <li><a class="dropdown-item" href="{{ route('full_table') }}">
                                <i class="fa fa-table"></i> Dashboard Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('/') }}">
                                <i class="fa fa-tv"></i> Realtime Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('report.index') }}">
                                <i class="fa fa-clipboard"></i> Report Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('antrian.index') }}">
                                <i class="fa fa-list"></i> Antrian Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fa fa-user-gear"></i> User Management</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('log_sap.index') }}">
                                    <i class="fa fa-list-alt"></i> Log API SAP</a>
                            </li>
                        @endif
                    @elseif(Request::is('full_table*'))
                        <li><a class="dropdown-item" href="{{ url('/') }}">
                                <i class="fa fa-tv"></i> Realtime Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('log.index') }}">
                                <i class="fa fa-history"></i> Log Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('report.index') }}">
                                <i class="fa fa-clipboard"></i> Report Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('antrian.index') }}">
                                <i class="fa fa-list"></i> Antrian Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fa fa-user-gear"></i> User Management</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('log_sap.index') }}">
                                    <i class="fa fa-list-alt"></i> Log API SAP</a>
                            </li>
                        @endif
                    @elseif(Request::is('antrian*'))
                        <li><a class="dropdown-item" href="{{ route('full_table') }}">
                                <i class="fa fa-table"></i> Dashboard Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('/') }}">
                                <i class="fa fa-tv"></i> Realtime Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('log.index') }}">
                                <i class="fa fa-history"></i> Log Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('report.index') }}">
                                <i class="fa fa-clipboard"></i> Report Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fa fa-user-gear"></i> User Management</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('log_sap.index') }}">
                                    <i class="fa fa-list-alt"></i> Log API SAP</a>
                            </li>
                        @endif
                    @elseif (Request::is('users*'))
                        <li><a class="dropdown-item" href="{{ route('full_table') }}">
                                <i class="fa fa-table"></i> Dashboard Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('/') }}">
                                <i class="fa fa-tv"></i> Realtime Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('log.index') }}">
                                <i class="fa fa-history"></i> Log Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('report.index') }}">
                                <i class="fa fa-clipboard"></i> Report Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('antrian.index') }}">
                                <i class="fa fa-list"></i> Antrian Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('log_sap.index') }}">
                                    <i class="fa fa-list-alt"></i> Log API SAP</a>
                            </li>
                        @endif
                    @elseif (Request::is('sap_log*'))
                        <li><a class="dropdown-item" href="{{ route('full_table') }}">
                                <i class="fa fa-table"></i> Dashboard Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('/') }}">
                                <i class="fa fa-tv"></i> Realtime Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('log.index') }}">
                                <i class="fa fa-history"></i> Log Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('report.index') }}">
                                <i class="fa fa-clipboard"></i> Report Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('antrian.index') }}">
                                <i class="fa fa-list"></i> Antrian Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fa fa-user-gear"></i> User Management</a>
                            </li>
                        @endif
                    @else
                        <li><a class="dropdown-item" href="{{ route('full_table') }}">
                                <i class="fa fa-table"></i> Dashboard Monitor</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('log.index') }}">
                                <i class="fa fa-history"></i> Log Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('report.index') }}">
                                <i class="fa fa-clipboard"></i> Report Barrier Gate</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('antrian.index') }}">
                                <i class="fa fa-list"></i> Antrian Barrier Gate</a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="fa fa-user-gear"></i> User Management</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('log_sap.index') }}">
                                    <i class="fa fa-list-alt"></i> Log API SAP</a>
                            </li>
                        @endif
                    @endif

                    <li>
                        <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link px-0">
                                {{-- <i class=""></i> --}}
                                <i class="fa fa-power-off"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</nav>
<!-- End Navbar -->
