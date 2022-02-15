<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <div data-toggle="dropdown">
        <img src="<?= base_url() ?>assets/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
      </div>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->