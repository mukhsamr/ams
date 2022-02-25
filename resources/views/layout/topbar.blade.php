<nav class="navbar navbar-header navbar-expand navbar-light bg-white shadow-sm">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        @if(session('holiday'))
        <span class="badge bg-danger ms-3">{{ session('event') }}</span>
        @else

        @if((session('isAbsen')))
        <span class="badge bg-success ms-3"><i data-feather="check"></i></span>
        @else
        <button type="button" class="badge bg-warning border-0 ms-3" data-bs-toggle="modal" data-bs-target="#modalScan"
            {{ date('H:i:s') < session('setting')->start ? 'disabled' : '' }}>
            Anda belum absen
        </button>
        @endif

        @endif

        <div class="modal fade" id="modalScan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalScanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="reader"></div>
                        <strong id="message"></strong>
                        <div id="data"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary me-auto" data-bs-dismiss="modal" id="stopQr">Tutup</button>
                        <button class="btn btn-primary" id="scan">Scan</button>
                    </div>
                </div>
            </div>
        </div>

        <form action="/attendance/qrcode" method="post" id="attendance">
            @csrf
            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="qrcode" id="qrcode">
        </form>


        <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">

            {{-- <li class="dropdown nav-icon">
                <a href="#" data-bs-toggle="dropdown"
                    class="nav-link dropdown-toggle nav-link-lg nav-link-user text-danger">
                    <div class="d-lg-inline-block">
                        <i data-feather="bell"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                    <h6 class='py-2 px-4'>Notifications</h6>
                    <ul class="list-group rounded-none">
                        <li class="list-group-item border-0 align-items-start">
                            <div class="avatar bg-success me-3">
                                <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                            </div>
                            <div>
                                <h6 class='text-bold'>New Order</h6>
                                <p class='text-xs'>
                                    An order made by Ahmad Saugi for product Samsung Galaxy S69
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </li> --}}
            {{-- <li class="dropdown nav-icon me-2">
                <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="d-lg-inline-block">
                        <i data-feather="mail"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                    <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                    <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                </div>
            </li> --}}
            <li class="dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img src="{{ school()->logo }}" alt="logo">
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="/profil"><i data-feather="user"></i> Profil</a>
                    <a class="dropdown-item" href="/attendance"><i data-feather="airplay"></i> Daftar Hadir</a>
                    {{-- <a class="dropdown-item" href="#"><i data-feather="mail"></i> Messages</a> --}}
                    <a class="dropdown-item" href="/setting"><i data-feather="settings"></i> Setelan</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="log-out"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

@push('scripts')
<script src="{{ asset('js/qrcode.js') }}"></script>
@endpush