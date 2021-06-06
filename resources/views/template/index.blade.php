<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Informasi Ketarunaan</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link rel="icon" href="{{asset('logopoltekbang.png')}}">
  <!-- Custom styles for this template-->
  <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  @stack('style')


  <style>
    .bg-gradient-primary{
      background-image: linear-gradient(to top, rgb(76 175 80 / 80%), #3f51b5), url(https://poltekbangplg.ac.id/wp-content/uploads/2020/05/gedung-trbu-new.png)
    }
  </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('home')}}">
        <div class="sidebar-brand-icon">
          <img src="{{ asset('logosika.png') }}" height="50" alt="">
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <?php 
        if (@$_GET['aplikasi'] != null) {
          session()->put('aplikasi', $_GET['aplikasi']);
        }
      ?>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="#">
          <form action="{{ url('home') }}" id="form">
            <select name="aplikasi" class="form-control" onChange="document.getElementById('form').submit();">
              <option {{ session()->get('aplikasi') == 'ketarunaan' ? 'selected' : ''}} value="ketarunaan">Bag.
                Ketarunaan
              </option>
              <option {{ session()->get('aplikasi') == 'alumni' ? 'selected' : ''}} value="alumni">Bag. Alumni</option>
            </select>
          </form>
        </a>
      </li>

      <hr class="sidebar-divider">

      {{-- {{ url()->current() }} --}}

      @if (session()->get('aplikasi') == 'ketarunaan' or session()->get('aplikasi') == null)
        <li class="nav-item active">
          <a class="nav-link" href="{{url('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

        @if (auth::user()->role == 'admin')
        <li class="nav-item @stack('master')">
          <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
          </a>
          <div id="collapseOne" class="collapse @stack('sub-master')" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item @stack('taruna')" href="{{ url('taruna') }}">Data Taruna</a>
              <a class="collapse-item @stack('kamar')" href="{{ url('kamar') }}">Kamar</a>
              <a class="collapse-item @stack('pelanggaran')" href="{{ url('pelanggaran') }}">Pelanggaran</a>
              <a class="collapse-item @stack('penghargaan')" href="{{ url('penghargaan') }}">Penghargaan</a>
              <a class="collapse-item @stack('bataspelanggaran')" href="{{ url('bataspelanggaran ')}}">Batas
                Pelanggaran</a>
              <a class="collapse-item @stack('pengasuh')" href="{{ url('pengasuh') }}">Pengasuh</a>
              <a class="collapse-item @stack('semester')" href="{{ url('semester') }}">Semester</a>
            </div>
          </div>
        </li>
        @endif

        <li class="nav-item @stack('tarunakamar')">
          <a class="nav-link" href="{{url('tarunakamar')}}">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Taruna Kamar</span>
          </a>
        </li>
        <li class="nav-item @stack('tarunapengasuh')">
          <a class="nav-link" href="{{url('tarunapengasuh')}}">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Taruna Pengasuh</span>
          </a>
        </li>
        <li class="nav-item @stack('catatan')">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Catatan</span>
          </a>
          <div id="collapseTwo" class="collapse @stack('sub-catatan')" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item @stack('catatanpelanggaran')" href="{{ url('catatanpelanggaran') }}">Catatan
                Pelanggaran</a>
              <a href="{{ url('catatanhukuman') }}" class="collapse-item @stack('catatanhukuman')">Catatan Hukuman</a>
              <a class="collapse-item @stack('catatanpenghargaan')" href="{{ url('catatanpenghargaan') }}">Catatan
                Penghargaan</a>
              <a class="collapse-item @stack('catatansakit')" href="{{ url('catatansakit') }}">Catatan Sakit</a>
              <a class="collapse-item @stack('catatanperizinan')" href="{{ url('catatanperizinan') }}">Catatan
                Perizinan</a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('home')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Penilaian</span>
          </a>
        </li>
      @else
        <li class="nav-item active">
          <a class="nav-link" href="{{ url('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item @stack('alumni')">
          <a class="nav-link" href="{{ url('alumni') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span> Data Alumni</span>
          </a>
        </li>
        <li class="nav-item @stack('kuesioner')">
          <a class="nav-link" href="{{url('kuesioner')}}">
            <i class="fas fa-fw fa-question"></i>
            <span>Kuesioner</span>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="{{url('home')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan Tracer Study</span>
          </a>
        </li> --}}
      @endif
      <li class="nav-item">
        <a class="nav-link" href="{{url('home')}}">
          <i class="fas fa-fw fa-bullhorn"></i>
          <span>Pengumuman & Berita</span>
        </a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button class="btn btn-link rounded-circle border-0 mr-3" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                      aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                      problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how
                      would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with
                      the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                      told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"
                  width="30" height="30">
                {{-- <i class="fas fa-user" width="200px"></i> --}}
              </a>
              <!-- Dropdown - User Information -->
              <?php
                $id_user = Auth::user()->id;
              ?>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                {{-- <a class="dropdown-item" href="{{url('ubahpassword')}}/{{$id_user}}">
                <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                Ubah Username & Password
                </a> --}}
                {{-- <div class="dropdown-divider"></div> --}}
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Developed By Mustechs 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
  @stack('scripts')
</body>

</html>