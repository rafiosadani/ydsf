<header class="main-header">
  <!-- Logo -->
  <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>YD</b>SF</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>YDSF</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url('assets/images/icon.png') ?>" class="user-image" alt="User Image">
            <span class="hidden-xs">
              <?php echo $this->session->userdata('ses_name') ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo base_url('assets/images/icon.png') ?>" class="img-circle" alt="User Image">

              <p>
                <?php echo $this->session->userdata('ses_name') ?>
                <small><?php echo $this->session->userdata('ses_email') ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
                <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-logout">Sign
                  out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>