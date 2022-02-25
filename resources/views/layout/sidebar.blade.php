@php
$foto = auth()->user()->foto ?? auth()->user()->userable->foto ?? 'default.png';
@endphp

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex" style="height:130px">
                <img src="{{ asset('storage/img/' . $foto) }}" alt="foto profil" class="rounded-circle m-auto"
                    style="width: 150px; height: 150px; object-fit:cover;">
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu mt-0">

                {{-- Teacher --}}
                @can('teacher')

                <li class='sidebar-title'>Menu Utama</li>
                <li class="sidebar-item {{ active(request()->is('teacher/home*')) }}" id="home">
                    <a href="/teacher/home" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Beranda</span>
                    </a>

                </li>

                <li class="sidebar-item {{ active(request()->is('teacher/competences*')) }}" id="competence">
                    <a href="/teacher/competences" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i>
                        <span>Kompetensi Dasar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ active(request()->is('teacher/journals*')) }}">
                    <a href="/teacher/journals" class='sidebar-link'>
                        <i data-feather="clipboard" width="20"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('teacher/scores*', 'teacher/ledgers*')) }}">
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

                <li class="sidebar-item {{ active(request()->is('teacher/calendars*')) }}">
                    <a href="/teacher/calendars" class='sidebar-link'>
                        <i data-feather="calendar" width="20"></i>
                        <span>Kalender</span>
                    </a>
                </li>

                <hr>
                @endcan

                {{-- Guardian --}}
                @can('guardian')

                <li class='sidebar-title'>Wali Kelas</li>

                <li class="sidebar-item {{ active(request()->is('guardian/home*')) }}" id="home">
                    <a href="/guardian/home" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item {{ active(request()->is('guardian/competences*')) }}">
                    <a href="/guardian/competences" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i>
                        <span>Kompetensi Dasar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ active(request()->is('guardian/journals*')) }}">
                    <a href="/guardian/journals" class='sidebar-link'>
                        <i data-feather="clipboard" width="20"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('guardian/scores*', 'guardian/ledgers*')) }}">
                    <a href=" #" class='sidebar-link'>
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

                <li
                    class="sidebar-item has-sub {{ active(request()->is('guardian/notes*', 'guardian/spirituals*', 'guardian/socials*', 'guardian/ekskuls*')) }}">
                    <a href=" #" class='sidebar-link'>
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
                        <li>
                            <a href="/guardian/ekskuls">Ekskul</a>
                        </li>
                    </ul>
                </li>

                <li
                    class="sidebar-item has-sub {{ active(request()->is('guardian/students*', 'guardian/attendance*')) }}">
                    <a href=" #" class='sidebar-link'>
                        <i data-feather="user" width="20"></i>
                        <span>Siswa</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/guardian/attendance">Daftar Hadir</a>
                        </li>
                        <li>
                            <a href="/guardian/students">Database</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('guardian/raports*')) }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="book-open" width="20"></i>
                        <span>Raport</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="/guardian/raports/pts">PTS</a>
                        </li>
                        <li>
                            <a href="/guardian/raports/k13">K13</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ active(request()->is('guardian/gradeLedger*')) }}">
                    <a href="/guardian/gradeLedger" class='sidebar-link'>
                        <i data-feather="archive" width="20"></i>
                        <span>Ledger Kelas</span>
                    </a>
                </li>
                <hr>
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

                <li class="sidebar-item {{ active(request()->is('operator/competences*')) }}">
                    <a href="/operator/competences" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i>
                        <span>Kompetensi Dasar</span>
                    </a>
                </li>

                <li class="sidebar-item {{ active(request()->is('operator/journals*')) }}">
                    <a href="/operator/journals" class='sidebar-link'>
                        <i data-feather="clipboard" width="20"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('operator/scores*', 'operator/ledgers*')) }}">
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

                <li class="sidebar-item has-sub {{ active(request()->is('daftar/students*', 'daftar/guardians*')) }}">
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

                <li class="sidebar-item has-sub {{ active(request()->is('user*')) }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="user" width="20"></i>
                        <span>Akun</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/user/student">Siswa</a>
                        </li>
                        <li>
                            <a href="/user/teacher">Guru</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('operator/attendance*', 'calendar*')) }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="airplay" width="20"></i>
                        <span>Absensi</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/operator/attendance/student">Siswa</a>
                        </li>
                        <li>
                            <a href="/operator/attendance/teacher">Guru</a>
                        </li>
                        <li>
                            <a href="/calendar">Kalender</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('operator/raports*')) }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="book-open" width="20"></i>
                        <span>Raport</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="/operator/raports/pts">PTS</a>
                        </li>
                        <li>
                            <a href="/operator/raports/k13">K13</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ active(request()->is('operator/gradeLedger*')) }}">
                    <a href="/operator/gradeLedger" class='sidebar-link'>
                        <i data-feather="archive" width="20"></i>
                        <span>Ledger Kelas</span>
                    </a>
                </li>
                <hr>
                @endcan

                {{-- Admin --}}

                @can('admin')
                <li class='sidebar-title'>Admin</li>

                <li
                    class="sidebar-item has-sub {{ active(request()->is('database/students*', 'database/teachers*')) }}">
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

                <li class="sidebar-item {{ active(request()->is('subjects*')) }}">
                    <a href="/subjects" class='sidebar-link'>
                        <i data-feather="book" width="20"></i>
                        <span>Mata Pelajaran</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ active(request()->is('grades*', 'subGrades*')) }}">
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

                <li class="sidebar-item has-sub {{ active(request()->is('lists*')) }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="list" width="20"></i>
                        <span>List Isian</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/lists/spiritual">Spiritual</a>
                        </li>
                        <li>
                            <a href="/lists/social">Sosial</a>
                        </li>
                        <li>
                            <a href="/lists/ekskul">Ekskul</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ active(request()->is('versions*')) }}">
                    <a href="/versions" class='sidebar-link'>
                        <i data-feather="hash" width="20"></i>
                        <span>Versi</span>
                    </a>
                </li>

                <li class="sidebar-item {{ active(request()->is('school*')) }}">
                    <a href="/school" class='sidebar-link'>
                        <i data-feather="settings" width="20"></i>
                        <span>Setelan</span>
                    </a>
                </li>

                @endcan

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

<script>
    if (screen.width >= 992) document.getElementById("sidebar").className = 'active'

</script>