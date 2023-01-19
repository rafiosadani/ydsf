<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url('assets/images/icon.png') ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>
          <?php echo $this->session->userdata('ses_name') ?>
        </p>
        <a href="#">
          <?php echo $this->session->userdata('ses_email') ?></a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li>
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-calendar"></i> <span>Rekap Jungut</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="<?php echo base_url('report') ?>"><i class="fa fa-circle-o"></i> Rekap Perolehan</a></li>
          <li><a href="<?php echo base_url('report/harian') ?>"><i class="fa fa-circle-o"></i> Rekap Harian Jungut</a></li>
          <li><a href="<?php echo base_url('report/setoran') ?>"><i class="fa fa-circle-o"></i> Rekap Setoran</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-briefcase"></i> <span>Donatur</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="<?php echo base_url('data/donatur') ?>"><i class="fa fa-circle-o"></i>Data Donatur</a></li>
        </ul>
      </li>
      <li class="header">OTHER NAVIGATION</li>
			<?php if ($this->session->userdata('hak') != '5') : ?>
			<li ><a href="<?php echo base_url('rkay-ramadhan') ?>"><i class="fa fa-book"></i>RKAY Ramadhan</a></li>
			<?php endif; ?>
      <li>
          <a href="" data-toggle="modal" data-target="#modal-logout">
            <i class="fa fa-power-off"></i> <span>Sign Out</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
