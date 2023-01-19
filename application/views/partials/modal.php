

<div class="modal fade modal-slipmanual" id="modal-slipmanual">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detail Slip</h4>
      </div>
      <form class="form-vertical" id="form-val" method="post">
      <div class="modal-body">
        <div class="form-group">
        <label for="modal-jumlah" class="control-label">Jungut</label>
            <input id="modal-jungut" type="text" class="form-control" name="jumlah" readonly>
          </div>
          <div class="form-group">
          <label for="modal-noslip" class="control-label">Noslip</label>
            <input id="modal-noslip-manual" type="text" class="form-control" name="noslip" readonly>
          </div>
          <table width="100%" id="modal-tabel-slipmanual">
          <table width="100%" id="modal-tabel-slipmanual-total">
          </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div></form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade modal-slipmanual" id="modal-tambah-slipmanual">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Program</h4>
      </div>
      <form class="form-vertical" id="form-val" method="post">
      <div class="modal-body">
          <div class="form-group">
          <label for="modal-noslip" class="control-label">Noslip</label>
            <input id="modal-noslip-tambah-manual" type="text" class="form-control" name="noslip" readonly>
          </div>
        <div class="form-group">
        <label for="modal-program-slipmanual" class="control-label">Program</label>
            <select class="form-control selectpicker" id="program-slipmanual" name="kodej" data-live-search="true">
              <option name="prog" value="">pilih data</option>
              <?php foreach($programe as $program) : ?>
              <option name="prog" id_vent="<?php echo $program->id_vent ?>"  value="<?php echo $program->PROG ?>"><?php echo $program->NM_PROGRAM ?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <input type="hidden" nama="idbank" id="modal-idbank">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-kodej" id="modal-kodej-tambah-manual">
          <!-- <input type="hidden" nama="modal-" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi"> -->

          <div class="form-group">
          <label for="modal-jumlah" class="control-label">Jumlah</label>
            <input id="jumlah-tambah-slipmanual" type="number" class="form-control" name="jumlah" >
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" id="btn-tambah-slipmanual" class="btn btn-success">Simpan</button>
      </div></form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade modal-slipbaru-slipmanual" id="modal-tambah-slipbaru-slipmanual">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Keuangan</h4>
      </div>
      <form class="form-vertical" id="form-val" method="post">
      <div class="modal-body">

          <div class="form-group">
        <label for="modal-program-slipmanual" class="control-label">Jungut</label>
            <select required class="form-control selectpicker" id="jungut-slipbaru-slipmanual" name="kodej" data-live-search="true">
              <option name="jungut" value="">Semua Jungut</option>
              <?php foreach($jungut as $jungut) : ?>
              <option name="jungut"  value="<?php echo $jungut->kodej?>"><?php echo $jungut->name ?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group">
          <label for="modal-noslip" class="control-label">Tanggal Penghimpunan</label>
            <input required id="modal-date-slipbaru-slipmanual" type="text" class="form-control" name="noslip" autocomplete="off">
          </div>
        <div class="form-group">
        <label for="modal-program-slipmanual" class="control-label">Program</label>
            <select required class="form-control selectpicker" id="program-slipbaru-slipmanual" name="kodej" data-live-search="true">
              <option name="prog" value="">pilih data</option>
              <?php foreach($programs as $programs) : ?>
              <option name="prog" id_vent="<?php echo $programs->id_vent ?>"  value="<?php echo $programs->PROG ?>"><?php echo $programs->NM_PROGRAM ?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group">
          <label for="modal-noslip" class="control-label">Jumlah</label>
            <input required id="modal-jumlah-slipbaru-slipmanual" type="number" class="form-control" name="noslip" autocomplete="off">
          </div>
          <div class="form-group">
        <label for="modal-program-slipmanual" class="control-label">Bank</label>
            <select required class="form-control selectpicker" id="bank-slipbaru-slipmanual" name="kodej" data-live-search="true">
              <option name="bank" value="">pilih data</option>
              <?php foreach($bank as $bank) : ?>
              <option name="bank" value="<?php echo $bank->BANK ?>"><?php echo $bank->NM_BANK.' - '.$bank->REC ?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group">
          <label for="modal-noslip" class="control-label">No Kasir</label>
            <input id="modal-nokasir-slipbaru-slipmanual" type="text" class="form-control" name="noslip" autocomplete="off">
          </div>
          <div class="form-group">
          <label for="modal-noslip" class="control-label">Keterangan</label>
            <input id="modal-keterangan-slipbaru-slipmanual" type="text" class="form-control" name="noslip" >
          </div>
          <!-- <input type="hidden" nama="idbank" id="modal-idbank">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi">
          <input type="hidden" nama="modal-validasi" id="modal-tambah-validasi"> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" id="btn-tambah-slipbaru-slipmanual" class="btn btn-success">Simpan</button>
      </div></form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-logout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Logout</h4>
      </div>
      <div class="modal-body">
        apakah anda ingin keluar?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <a type="button" class="btn btn-primary" id="real-logout-button-cause-i-dont-give-a-fffff">logout</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
        apakah anda ingin menghapus data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <a href="#" id="btn-delete" type="submit" class="btn btn-danger">Hapus</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <div class="modal-body">
        <form class="form-vertical" action="" method="">
        <!-- <div class="form-group">

            <label for="status" class="control-label">Status<span style="color: red"> *</span></label>
            <select id="status" class="form-control selectpicker" name="status" data-live-search="true" required>
                <option  name="status" value=""></option>
            </select>

        </div> -->
        <div class="form-group">

            <label for="modal-program" class="control-label">Program<span style="color: red"> *</span></label>
            <select id="modal-program" class="form-control selectpicker" name="program" data-live-search="true" required>
              <?php foreach($program as $program) : ?>
                <option  name="program" value="<?php echo $program->PROG ?>"><?php echo $program->NM_PROGRAM ?></option>
              <?php endforeach; ?>
            </select>

        </div>
        <div class="form-group">
        <label for="modal-nominal" class="control-label">Nominal<span style="color: red"> *</span></label>
            <input id="modal-nominal" type="number" class="form-control" name="nominal" id="nominal" placeholder="Input nominal" min="0" required>
          </div>
          <div class="form-group">
          <label for="modal-ket" class="control-label">Keterangan</label>
            <input id="modal-ket" type="text" class="form-control" name="ket" id="ket" placeholder="keterangan" >
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" id="btn-edit2" class="btn btn-info" data-dismiss="modal">Ubah</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-filter">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Filter Data</h4>
      </div>
      <form class="form-vertical" action="<?php echo base_url('donatur/searchKoor') ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <label for="hp" class="control-label">No.HP</label>
                          <input id="hp" type="number" class="form-control" name="hp" placeholder="Nomor Hp" min="0" >
          </div>
        <div class="form-group">
        <label for="nama" class="control-label">Nama</label>
            <input id="nama" type="text" class="form-control" name="nama" placeholder="Input nama">
          </div>
          <div class="form-group">
          <label for="alamat" class="control-label">Alamat</label>
                          <input id="alamat" type="text" class="form-control" name="alamat" placeholder="Input alamat" >
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <input type="submit" class="btn btn-success" value="Filter">
      </div></form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-filter1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Filter Data</h4>
      </div>
      <form class="form-vertical" action="<?php echo base_url('donatur/searchKwsn') ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <label for="kwsn" class="control-label">No.Kawasan</label>
                          <input id="kwsn" type="number" class="form-control" name="kwsn" placeholder="Nomor kawasan" min="0" >
          </div>
        <div class="form-group">
        <label for="nama" class="control-label">Nama Kawasan</label>
            <input id="nama" type="text" class="form-control" name="nama" placeholder="Input nama kawasan">
          </div>
          <div class="form-group">
          <label for="alamat" class="control-label">Alamat</label>
                          <input id="alamat" type="text" class="form-control" name="alamat" placeholder="Input alamat" >
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <input type="submit" class="btn btn-success" value="Filter">
      </div></form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-filter2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Filter Data</h4>
      </div>
      <form class="form-vertical" action="<?php echo base_url('donatur/searchDonatur') ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <label for="kwsn" class="control-label">No.Kawasan</label>
                          <input id="kwsn" type="number" class="form-control" name="kwsn" placeholder="Nomor kawasan" min="0" >
          </div>
          <div class="form-group">
          <label for="status" class="control-label">Status</label>
          <select id="status" class="form-control selectpicker" name="status" data-live-search="true">
                <option  name="status" value="">Semua</option>
                <option  name="status" value="A">Aktif</option>
                <option  name="status" value="P">Pasif</option>
            </select>
            </div>
            <div class="form-group">
              <label for="tglhimpun" class="control-label">Tanggal Masuk</label>
              <div class="input-group date" id="reportrange">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="tgl" class="form-control daterange-btn" placeholder="YYYY-MM-DD - YYYY-MM-DD" id="tgl1" value="">
              </div>
            </div>
        <div class="form-group">
        <div class="form-group">
          <label for="noid" class="control-label">No.Donatur</label>
                          <input id="noid" type="number" class="form-control" name="noid" placeholder="Nomor donatur" min="0" >
          </div>
          <div class="form-group">
        <label for="nama" class="control-label">Nama Lengkap</label>
            <input id="nama" type="text" class="form-control" name="nama" placeholder="Input nama">
          </div>
          <div class="form-group">
          <label for="alamat" class="control-label">Alamat</label>
                          <input id="alamat" type="text" class="form-control" name="alamat" placeholder="Input alamat" >
          </div>

          <div class="form-group">
            <label for="program" class="control-label">Program</label>
            <select id="program" class="form-control selectpicker" name="program" data-live-search="true">
              <option name="program" value=""> - </option>
              <?php foreach($prog as $prog) : ?>
                <option  name="program" value="<?php echo $prog->NM_PROGRAM ?>"><?php echo $prog->NM_PROGRAM ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <div class="form-group">

            <label for="kodej" class="control-label">Petugas</label>
            <select id="kodej" class="form-control selectpicker" name="kodej" data-live-search="true">
              <option name="kodej" value=""> - </option>
              <?php foreach($petugas as $petugas) : ?>
                <option  name="kodej" value="<?php echo $petugas->kodej ?>"><?php echo $petugas->kodej.' - '.$petugas->name ?></option>
              <?php endforeach; ?>
            </select>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <input type="submit" class="btn btn-success" value="Filter">
      </div></form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</div>
