<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name') }} | @yield('title') </title>

    <!-- Bootstrap -->
    <link href="{{ asset('admin/assets') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('admin/assets') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('admin/assets') }}/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('admin/assets') }}/build/css/custom.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('admin/assets') }}/vendors/pnotify/dist/pnotify.css" rel="stylesheet">

    <link href="{{ asset('admin/assets') }}/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="{{ asset('admin/assets') }}/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <link href="{{ asset('admin/assets') }}/vendors/alertifyjs/css/alertify.min.css" rel="stylesheet">
    <link href="{{ asset('admin/assets') }}/vendors/alertifyjs/css/themes/default.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Tambahan -->
    @yield('styles')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title">
                            {{-- <i class="fa fa-paw"></i> --}}
                            <span>Dashboard | {{ auth()->user()->role }}</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ asset('img/avatar') . "/" . auth()->user()->getAvatar() }}" alt="..."
                                class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Selamat datang,</span>
                            <h2>{{ auth()->user()->name }}</h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            
                            <h3>Menu Utama</h3>
                            <ul class="nav side-menu">
                                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard </a>
                                </li>
                                @if (auth()->user()->role == 'petugas')
                                    <li>
                                        <a>
                                            <i class="fa fa-sitemap"></i> Master Data <span
                                                class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('petugas.index') }}"><i class="fa fa-user-secret"></i>Data Petugas
                                            <li><a href="{{ route('anggota.index') }}"><i class="fa fa-users"></i>Data Anggota
                                            <li><a href="{{ route('buku.index') }}"><i class="fa fa-book"></i>Data
                                                    Buku</a></li>
                                            <li><a href="{{ route('rak.index') }}"><i class="fa fa-table"></i>Rak Buku</a></li>
                                            <li><a href="{{ route('kategori.index') }}"><i class="fa fa-tag"></i>Kategori Buku</a></li>
                                            <li><a href="{{ route('pengarang.index') }}"><i class="fa fa-user-md"></i>Data
                                                    pengarang</a></li>
                                            <li><a href="{{ route('penerbit.index') }}"><i class="fa fa-file-text"></i>Data
                                                    penerbit</a></li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-sitemap"></i> Transaksi <span
                                                class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a><i class="fa fa-bar-chart-o"></i> Peminjaman<span
                                                        class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{ route('pinjam.index') }}">Daftar peminjaman</a></li>
                                                    <li><a href="{{ route('pinjam.create') }}">Input peminjaman</a></li>
                                                </ul>
                                            </li>
                                            <li><a><i class="fa fa-retweet"></i> Pengembalian<span
                                                        class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{ route('pengembalian.index') }}">Daftar Pengembalian</a>
                                                    </li>
                                                    <li><a href="{{ route('pengembalian.create') }}">Input Pengembalian</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="{{ route('peraturan.index') }}"><i class="fa fa-cog"></i>Peraturan</span></a>
                                    </li>
                                    <li><a href="{{ route('identitas') }}"><i class="fa fa-refresh"></i>Identitas web</a>
                                    </li>
                                @endif
                                @if (auth()->user()->role == 'anggota')
                                    <li><a href="{{ route('katalog') }}"><i class="fa fa-book"></i>Katalog Buku</a></li>
                                    <li><a href="{{ route('anggota.pinjam') }}"><i class="fa fa-bar-chart-o"></i>Peminjaman
                                        saya</a></li>
                                @endif
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ asset('img/avatar') . "/" . auth()->user()->getAvatar() }}"
                                        alt="">{{ auth()->user()->name }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="javascript:;"> Profil saya</a></li>
                                    <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                                class="fa fa-sign-out pull-right"></i> Keluar</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>

                            {{-- <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image"><img
                                                    src="{{ asset('img/avatar') . "/" . auth()->user()->getAvatar() }}"
                            alt="Profile Image" /></span>
                            <span>
                                <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                            </span>
                            <span class="message">
                                Film festivals used to be do-or-die moments for movie makers. They were
                                where...
                            </span>
                            </a>
                            </li>
                            <li>
                                <a>
                                    <span class="image"><img
                                            src="{{ asset('img/avatar') . "/" . auth()->user()->getAvatar() }}"
                                            alt="Profile Image" /></span>
                                    <span>
                                        <span>John Smith</span>
                                        <span class="time">3 mins ago</span>
                                    </span>
                                    <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were
                                        where...
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="image"><img
                                            src="{{ asset('img/avatar') . "/" . auth()->user()->getAvatar() }}"
                                            alt="Profile Image" /></span>
                                    <span>
                                        <span>John Smith</span>
                                        <span class="time">3 mins ago</span>
                                    </span>
                                    <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were
                                        where...
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="image"><img
                                            src="{{ asset('img/avatar') . "/" . auth()->user()->getAvatar() }}"
                                            alt="Profile Image" /></span>
                                    <span>
                                        <span>John Smith</span>
                                        <span class="time">3 mins ago</span>
                                    </span>
                                    <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were
                                        where...
                                    </span>
                                </a>
                            </li>
                            <li>
                                <div class="text-center">
                                    <a>
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        </li> --}}
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            @yield('title.left')
                        </div>

                        {{-- <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="clearfix"></div>

                    @yield('content')

                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    {{ identitas()->nama }}, &copy; {{ date('Y') }}
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
    <div class="load">Loading&#8230;</div>

    <!-- jQuery -->
    <script src="{{ asset('admin/assets') }}/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('admin/assets') }}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin/assets') }}/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="{{ asset('admin/assets') }}/vendors/nprogress/nprogress.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('admin/assets') }}/build/js/custom.min.js"></script>
    <script src="{{ asset('admin/assets') }}/vendors/ckeditor/ckeditor.js"></script>
    <!-- PNotify -->
    <script src="{{ asset('admin/assets') }}/vendors/pnotify/dist/pnotify.js"></script>
    <script src="{{ asset('admin/assets') }}/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="{{ asset('admin/assets') }}/vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('admin/assets') }}/vendors/alertifyjs/alertify.min.js"></script>
    <script src="{{ asset('admin/assets/vendors/select2/dist/js/select2.min.js') }}"></script>

    @if (session('info'))
    <script>
        initNotify("{{ session('info') }}");

    </script>
    @endif
    <script>
        siteUrl = (uri = null) => {
            return `{{ url('/') }}/${uri}`;
        }

    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Tambahan -->
    @yield('scripts')
</body>

</html>
