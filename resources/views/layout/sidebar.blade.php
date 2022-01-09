<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div style="height:100px;background: url('/storage/img/core/annahl.png') no-repeat center;background-size: contain">
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu mt-0">

                {{-- Teacher --}}
                @can('teacher')

                <li class='sidebar-title'>Menu Utama</li>
                <li class="sidebar-item {{ request()->is('teacher/home*') ? 'active' : '' }}" id="home">
                    <a href="/teacher/home" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Beranda</span>
                    </a>

                </li>

                <li class="sidebar-item {{ request()->is('teacher/competences*') ? 'active' : '' }}" id="competence">
                    <a href="/teacher/competences" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i>
                        <span>Kompetensi Dasar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('teacher/journals*') ? 'active' : '' }}">
                    <a href="/teacher/journals" class='sidebar-link'>
                        <i data-feather="clipboard" width="20"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ (request()->is('teacher/scores*') || request()->is('teacher/ledgers*')) ? 'active' : '' }}" id="grades">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="sidebar" width="20"></i>
                        <span>Penilaian</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/teacher/scores">Harian</a>
                        </li>
                        <li>
                            <a href="/teacher/ledgers">Ledger</a>
                        </li>

                    </ul>
                </li>
                @endcan

                {{-- Guardian --}}
                @can('guardian')

                <li class='sidebar-title'>Wali Kelas</li>

                <li class="sidebar-item {{ request()->is('guardian/home*') ? 'active' : '' }}" id="home">
                    <a href="/guardian/home" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('guardian/competences*') ? 'active' : '' }}">
                    <a href="/guardian/competences" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i>
                        <span>Kompetensi Dasar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('guardian/journals*') ? 'active' : '' }}">
                    <a href="/guardian/journals" class='sidebar-link'>
                        <i data-feather="clipboard" width="20"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ (request()->is('guardian/scores*') || request()->is('guardian/ledgers*')) ? 'active' : '' }}" id="grades">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="sidebar" width="20"></i>
                        <span>Penilaian</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/guardian/scores">Harian</a>
                        </li>
                        <li>
                            <a href="/guardian/ledgers">Ledger</a>
                        </li>

                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('guardian/notes*') || request()->is('guardian/spirituals*') || request()->is('guardian/sosials*') ? 'active' : '' }}" id="notes">

                    <a href="#" class='sidebar-link'>
                        <i data-feather="list" width="20"></i>
                        <span>Isian</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/guardian/notes">Catatan</a>
                        </li>
                        <li>
                            <a href="/guardian/spirituals">Spiritual</a>
                        </li>
                        <li>
                            <a href="/guardian/socials">Sosial</a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="sidebar-item has-sub" id="raports">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="book-open" width="20"></i>
                        <span>Raport</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="/guardian/raports/pts">PTS</a>
                        </li>
                        <li>
                            <a href="/guardian/raports/K13">K13</a>
                        </li>
                    </ul>
                </li> --}}
                @endcan

                {{-- Operator --}}
                @can('operator')

                <li class='sidebar-title'>Operator</li>

                <li class="sidebar-item {{ request()->is('operator/home*') ? 'active' : '' }}" id="home">
                    <a href="/operator/home" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('operator/competences*') ? 'active' : '' }}">
                    <a href="/operator/competences" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i>
                        <span>Kompetensi Dasar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('operator/journals*') ? 'active' : '' }}">
                    <a href="/operator/journals" class='sidebar-link'>
                        <i data-feather="clipboard" width="20"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ (request()->is('operator/scores*') || request()->is('operator/ledgers*')) ? 'active' : '' }}" id="grades">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="sidebar" width="20"></i>
                        <span>Penilaian</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/operator/scores">Harian</a>
                        </li>
                        <li>
                            <a href="/operator/ledgers">Ledger</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('daftar/students*') || request()->is('daftar/guardians*') ? 'active' : '' }}" id="lists">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="book-open" width="20"></i>
                        <span>Daftar</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/daftar/students">Siswa</a>
                        </li>
                        <li>
                            <a href="/daftar/guardians">Wali Kelas</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('user*') ? 'active' : '' }}" id="lists">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="user" width="20"></i>
                        <span>Akun</span>
                    </a>
                    <ul class="submenu">
                        {{-- <li>
                            <a href="/user/student">Siswa</a>
                        </li> --}}
                        <li>
                            <a href="/user/teacher">Guru</a>
                        </li>
                    </ul>
                </li>
                @endcan

                {{-- Admin --}}

                @can('admin')
                <li class='sidebar-title'>Admin</li>

                <li class="sidebar-item has-sub {{ request()->is('database/students*') || request()->is('database/teachers*') ? 'active' : '' }}" id="lists">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="database" width="20"></i>
                        <span>Database</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/database/students">Siswa</a>
                        </li>
                        <li>
                            <a href="/database/teachers">Guru</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ request()->is('subjects*') ? 'active' : '' }}">
                    <a href="/subjects" class='sidebar-link'>
                        <i data-feather="book" width="20"></i>
                        <span>Mata Pelajaran</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('grades*') || request()->is('subGrades*') ? 'active' : '' }}" id="lists">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="trello" width="20"></i>
                        <span>Kelas</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/grades">Kelas</a>
                        </li>
                        <li>
                            <a href="/subGrades">Sub Kelas</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ request()->is('versions*') ? 'active' : '' }}">
                    <a href="/versions" class='sidebar-link'>
                        <i data-feather="hash" width="20"></i>
                        <span>Versi</span>
                    </a>
                </li>

                @endcan

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
