<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light navbar-dark">
    <div class="container">
      <a href="<?= base_url(); ?>" class="navbar-brand">
        <span class="brand-text"><?= $profile['name_user'] ?></span>
      </a>
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item d-sm-inline-block">
          <a href="<?= base_url() ?>" class="nav-link <?php if($this->uri->segment(1) == '' || $this->uri->segment(1) == 'reynaldo_home' ) {echo 'active';} ?>">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- content-main -->
    <div class="content">
      <div class="container">