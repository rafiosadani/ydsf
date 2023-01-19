
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="<?= base_url('home')?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('grafikprogram')?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Grafik Program</span></a>
                </li>
                <?php if (!$this->session->userdata('ptgs_user')) {?>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('harian')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Harian</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('perprogram')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Perprogram</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('percabangpetugas')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Percabang Petugas</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('percabangpintu')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Percabang Pintu</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('pintujungut')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Pintu Jungut</span></a>
                </li>

                <?php }?>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('petugasperprogram')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Petugas Per program</span></a>
                </li>
                <?php if (!$this->session->userdata('ptgs_user')) {?>
                <li> <a class="waves-effect waves-dark" href="<?= base_url('pergeraipetugas')?>" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Lap. Pergerai Petugas</span></a>
                </li>
                <?php }?>
            </ul>
        </nav>

        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <!--div class="sidebar-footer"-->
        <!-- item--><!--a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a-->
        <!-- item--><!--a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a-->
        <!-- item--><!--a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i>Logout</a> </div-->
    <!-- End Bottom points-->
</aside>

<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->