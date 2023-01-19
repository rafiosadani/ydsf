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
      <?php if ($this->session->userdata('hak') == "0") : ?>
        <li>
          <a href="<?php echo base_url('user') ?>">
            <i class="fa fa-user"></i> <span>User</span>
            <!-- <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                  </span> -->
          </a>
        </li>
      <?php endif; ?>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-calendar"></i> <span>Rekap Jungut</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php if ($this->session->userdata('admin') == TRUE) : ?>
            <li class="active"><a href="<?php echo base_url('report') ?>"><i class="fa fa-circle-o"></i> Rekap Perolehan</a></li>
            <li><a href="<?php echo base_url('report/harian') ?>"><i class="fa fa-circle-o"></i> Rekap Harian Jungut</a></li>
            <li><a href="<?php echo base_url('report/per-petugas') ?>"><i class="fa fa-circle-o"></i> Rekap Per Petugas</a></li>
            <li><a href="<?php echo base_url('report/perbulan') ?>"><i class="fa fa-circle-o"></i> Rekap Laporan Per Bulan</a></li>
            <li><a href="<?php echo base_url('report/prestasi') ?>"><i class="fa fa-circle-o"></i> Rekap Prestasi</a></li>
            <li><a href="<?php echo base_url('report/kawasan-kurang-target') ?>"><i class="fa fa-circle-o"></i> Rekap Kawasan Kurang Target</a></li>
            <li><a href="<?php echo base_url('report/validasi') ?>"><i class="fa fa-circle-o"></i> Rekap Validasi</a></li>
            <li><a href="<?php echo base_url('report/setoran') ?>"><i class="fa fa-circle-o"></i> Rekap Setoran</a></li>
            <li><a href="<?php echo base_url('report/gagal-kwitansi') ?>"><i class="fa fa-circle-o"></i> Rekap Kwitansi Gagal</a></li>
            <li><a href="<?php echo base_url('report/centang') ?>"><i class="fa fa-circle-o"></i> Rekap Centang</a></li>
          <?php endif ?>
          <?php if ($this->session->userdata('admin') != TRUE) : ?>
            <li class="active"><a href="<?php echo base_url('report') ?>"><i class="fa fa-circle-o"></i> Rekap Perolehan</a></li>
            <li><a href="<?php echo base_url('report/harian') ?>"><i class="fa fa-circle-o"></i> Rekap Harian Jungut</a></li>
            <li><a href="<?php echo base_url('report/setoran') ?>"><i class="fa fa-circle-o"></i> Rekap Setoran</a></li>
            <li><a href="<?php echo base_url('report/validasi') ?>"><i class="fa fa-circle-o"></i> Rekap Validasi</a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-university"></i> <span>Rekap Keuangan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="<?php echo base_url('keuangan/program') ?>"><i class="fa fa-circle-o"></i> Per Program</a></li>
          <li><a href="<?php echo base_url('keuangan/bank') ?>"><i class="fa fa-circle-o"></i> Per Bank</a></li>
          <li><a href="<?php echo base_url('keuangan/rinci-slip/bank') ?>"><i class="fa fa-circle-o"></i> Rinci Slip Bank</a></li>
          <li><a href="<?php echo base_url('keuangan/rekap-slip-bank') ?>"><i class="fa fa-circle-o"></i> Rekap Slip Bank</a></li>
          <?php if ($this->session->userdata('admin') == TRUE) : ?>
            <li><a href="<?php echo base_url('keuangan/rkay') ?>"><i class="fa fa-circle-o"></i> Rekap RKAY</a></li>
          <?php endif ?>
        </ul>
      </li>
      <?php if ($this->session->userdata('admin') == TRUE) : ?>
        <?php if ($this->session->userdata('hak') == '0' || $this->session->userdata('hak') == '3') : ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Front Office</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="<?php echo base_url('front-office/validasi-kasir') ?>"><i class="fa fa-circle-o"></i> Validasi Kasir</a></li>
              <li class="active"><a href="<?php echo base_url('front-office/validasi-tunai') ?>"><i class="fa fa-circle-o"></i> Validasi Tunai</a></li>
              <li class="active"><a href="<?php echo base_url('front-office/lap-validasi-tunai') ?>"><i class="fa fa-circle-o"></i> Laporan Validasi Tunai</a></li>
              <li class=""><a href="<?php echo base_url('front-office/rek-koran') ?>"><i class="fa fa-circle-o"></i> Upload Rek Koran</a></li>
              <li class=""><a href="<?php echo base_url('front-office/slip-manual') ?>"><i class="fa fa-circle-o"></i> Slip Manual</a></li>
              <?php if ($this->session->userdata('superadmin') == TRUE || $this->session->userdata('admin_grup') == TRUE) : ?>
                <li class=""><a href="<?php echo base_url('front-office/edit-slip-bank') ?>"><i class="fa fa-circle-o"></i> Edit Slip Bank</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-briefcase"></i> <span>Donatur</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php if ($this->session->userdata('admin') == TRUE) : ?>
            <li class="active"><a href="<?php echo base_url('data/donatur') ?>"><i class="fa fa-circle-o"></i>Data Donatur</a></li>
            <li><a href="<?php echo base_url('data/koordinator') ?>"><i class="fa fa-circle-o"></i>Koordinator</a></li>
            <li><a href="<?php echo base_url('data/kawasan') ?>"><i class="fa fa-circle-o"></i>Kawasan</a></li>
            <li><a href="<?php echo base_url('data/data-rekap-donatur') ?>"><i class="fa fa-circle-o"></i>Data Rekap Donatur</a></li>
          <?php endif; ?>
          <?php if ($this->session->userdata('admin') != TRUE) : ?>
            <li class="active"><a href="<?php echo base_url('data/donatur') ?>"><i class="fa fa-circle-o"></i>Data Donatur</a></li>
            <!-- <li><a href=""><i class="fa fa-circle-o"></i>Donasi FO</a></li> -->
          <?php endif; ?>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-file"></i> <span>Umum</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">

          <li><a href="<?php echo base_url('umum/slip-karyawan') ?>"><i class="fa fa-circle-o"></i>Slip Karyawan</a></li>
          <li><a href="<?php echo base_url('umum/angsuran') ?>"><i class="fa fa-circle-o"></i>Angsuran</a></li>

          <?php if ($this->session->userdata('admin') != TRUE) : ?>
            <!-- <li class="active"><a href="<?php echo base_url('data/donatur') ?>"><i class="fa fa-circle-o"></i>Data Donatur</a></li> -->
            <!-- <li><a href=""><i class="fa fa-circle-o"></i>Donasi FO</a></li> -->
          <?php endif; ?>
        </ul>
      </li>

      <li class="header">OTHER NAVIGATION</li>
      <?php if ($this->session->userdata('hak') != '5') : ?>
        <li><a href="<?php echo base_url('rkay-ramadhan') ?>"><i class="fa fa-book"></i>RKAY Ramadhan</a></li>
      <?php endif; ?>
      <li><a href="<?php echo base_url('data/donasi') ?>"><i class="fa fa-money"></i>Donasi FO</a></li>
	<?php if ($this->session->userdata('admin') == TRUE) : ?>
      <li><a href="<?php echo base_url('data/cetakdonasi') ?>"><i class="fa fa-print one"></i>Cetak Kwitansi</a></li>
      <?php endif; ?>
      <?php if ($this->session->userdata('priv_group') == TRUE || $this->session->userdata('hak') == '4') : ?>
        <li><a href="<?php echo base_url('data/validasi') ?>"><i class="fa fa-circle-o"></i>Validasi Donasi FO</a></li>
      <?php endif; ?>
      <?php if ($this->session->userdata('superadmin') == TRUE || $this->session->userdata('admin_grup') == TRUE) : ?>
        <li>
          <a href="<?php echo base_url('batal/setor') ?>">
            <i class="fa fa-repeat"></i> <span>Batal Setoran</span>
            <!-- <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                  </span> -->
          </a>
        </li>
      <?php endif; ?>
      <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
        <li>
          <a href="<?php echo base_url('ydsf1') ?>" target="_blank">
            <i class="fa fa-send"></i> <span>Send Email</span>
            <!-- <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                  </span> -->
          </a>
        </li>
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
