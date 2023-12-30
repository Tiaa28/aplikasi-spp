<div class="main-header">
  <div class="logo-header">
      <a href="{{ route('homepage') }}" class="logo">
          Aplikasi SPP
      </a>
      <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse"
          aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
  </div>
  <nav class="navbar navbar-header navbar-expand-lg">
      <div class="container-fluid">
          <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
              <li class="nav-item dropdown">
                  <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                      <img src="{{ asset('assets/img/profile.jpg') }}" alt="user-img" width="36"
                          class="img-circle"><span>{{ Auth::guard('siswa')->check() ? $siswa->nama : $petugas->nama_petugas }}</span></span>
                  </a>
                  <ul class="dropdown-menu dropdown-user">
                      <li>
                          <div class="user-box">
                              <div class="u-img"><img src="{{ asset('assets/img/profile.jpg') }}" alt="user">
                              </div>
                              <div class="u-text">
                                  <h4>{{ Auth::guard('siswa')->check() ? $siswa->nama : $petugas->nama_petugas }}</h4>
                                  <p class="text-muted">
                                      {{ Auth::guard('siswa')->check() ? $siswa->nisn : $petugas->username }}</p>
                              </div>
                          </div>
                      </li>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('user-setting') }}"><i class="ti-settings"></i> Account
                          Setting</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
                  </ul>
                  <!-- /.dropdown-user -->
              </li>
          </ul>
      </div>
  </nav>
</div>
