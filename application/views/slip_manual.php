<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('partials/head') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css"
        rel="stylesheet" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php $this->load->view('partials/header') ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('partials/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Slip Manual
                    <small>Control panel</small>
                </h1>
                
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Slip Manual</li>
                </ol>
                
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">Filter Pencarian</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="kodej" class="control-label">Jungut<span style="color: red">
                                                        *</span></label>
                                                <select class="form-control selectpicker" id="kodej" name="kodej" data-live-search="true">
                                                    <option name="kodej" value="-">Semua Jungut</option>
                                                    <?php foreach($jungut as $jungut) : ?>
                                                    <option name="kodej" value="<?php echo $jungut->kodej ?>"><?php echo $jungut->kodej." - ".$jungut->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-5">
                                                <label for="date" class="control-label">Tanggal<span style="color: red">
                                                        *</span></label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control daterange-btn" id="date" name="date" />
                                                </div>
                                            </div>
                                                                    
                                            
                                            <div class="col-sm-2">
                                                <label for="button"> </label>
                                                <button id="btnsubmit" type="button" name="button" class="btn btn-block btn-success">
                                                    Submit 
                                                    <span><i class="fa fa-search"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12" id="catatan">
                                        <br>
                                        <h4 style="color: red; margin-left: 15px;">Catatan : Klik tombol Submit untuk menambah slip baru !</h4>
                                    </div>
                                    <div class="col-xs-12">                                    
                                        <div class="box-header">
                                            <a class="btn btn-success" id="btn-tambah-slipbaru" data-toggle="modal" data-target="#modal-tambah-slipbaru-slipmanual" style="display: none;"><i class="fa fa-plus-circle"></i> Slip Baru</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- </form> -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row (main row) -->

                <div class="row" id="divTable" style="display:none;">
                    <div class="col-xs-12">
                        <div class="box box-info">                            
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>No Slip</th>
                                                <th>Tgl Setor</th>
                                                <th>Bank</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('partials/footer') ?>


    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('partials/modal') ?>

    <!-- <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
  </script> -->
</body>
<?php $this->load->view('partials/js') ?>
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script>
    $(document).ready(function () {

        $("#table").DataTable();
        $(function () {
            $('.daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: moment().startOf('month'),
                    endDate: moment().endOf('month')
                },
                function (start, end) {
                    $('.daterange-btn').html(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'))
                }

            )

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })

            $('#modal-date-slipbaru-slipmanual').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn:true,
                todayHighlight:true
            });
        });

        function price_format(values)
{
values=""+values+"";
var len=values.length;
var mod=len % 3;
if(mod==0) mod =3;
var divided= len/3;
divided=parseInt(divided);
var priceFormat=values.substr(0,mod)+",";
var pointer=0;
for(var pointer=0;pointer<divided; pointer++)
{
priceFormat=priceFormat+""+values.substr((mod+(pointer*3)),3)+",";
}
while(priceFormat.substr(priceFormat.length-1,1)==",")
{
priceFormat=priceFormat.substr(0,priceFormat.length-1);
}
while(priceFormat.substr(0,1)==",")
{
priceFormat=priceFormat.substr(1,priceFormat.length-1);
}
priceFormat=priceFormat;
return priceFormat;
}

        function convertToRupiah(angka){
                var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join(',').split('').reverse().join('');
                return ribuan;
           }

        $("#btnsubmit").click(function() {
            $('#btn-tambah-slipbaru').show();
            $('#catatan').hide();
            $("#table").DataTable();
            $("#table").DataTable().destroy();
            tampil();
            function tampil() {
                $("#table").DataTable().destroy();
                $('#divTable').show();
                var kodej = $("select#kodej").children("option:selected").val();
                var date = $("#date").val();
                // console.log(date);
                var cont = "";
                var keter="";
                $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('slipmanual/getData') ?>',
                    data  : {
                        kodej : kodej,
                        date : date,
                    },
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                        for (var i=0;i<data.length;i++) {     
                            if(data[i].ket == null){
                                keter=" ";
                            }else{
                                keter = data[i].ket;
                            }
                    var startdate = new Date(data[i].tgl_setor);
                    var tanggal = moment(startdate).format('DD-MM-YYYY');

                            cont += '<tr validasi="'+data[i].validasi+'" noslip="'+ data[i].noslip +'" nama_jungut="'+data[i].nama_jungut+'" infaq="'+data[i].infaq+'" pena="'+data[i].pena+'" zakat="'+data[i].zakat+'" rcy="'+data[i].RCY+'" cgq="'+data[i].CGQ+'" jumlah="'+ data[i].jumlah +'" ket="'+ data[i].ket +'" bank="'+ data[i].bank +'" kodej="'+data[i].entr_pegawai+'" noksr="'+ data[i].no_kasir +'" >'+
                                '<td class=""><a class="btn btn-success" id="btn-submit" href="<?php echo base_url('front-office/slip-manual/rekap-slip/')?>'+data[i].noslip+'" target="_blank" style="width:38px;"><i class="glyphicon glyphicon-print"></i></a></br><a class="btn btn-success" id="btn-tambah" data-toggle="modal" data-target="#modal-tambah-slipmanual" style="width:38px;"><i class="fa fa-plus-circle"></i></a><br><a class="btn btn-success" id="btn-detail" data-toggle="modal" data-target="#modal-slipmanual" style="width:38px;"><i class="fa fa-list"></i></a></td>'+
                                '<td>'+ data[i].noslip +'</td>'+
                                '<td>'+ tanggal +'</td>'+
                                '<td>'+ data[i].nama_bank +'</td>'+
                                '<td>Rp. '+ price_format(data[i].jumlah) +'</td>'+
                                '<td>'+keter+'</td>'+
                                '</tr>';
                        }
                        $("#tbody").html(cont);
                        $("#table").DataTable();
                        // // console.log(kwit);
                        // console.log(data);
                    }
                });
            }
 

            // $(document).on('click','#btn-submit',function () {
            //     location.href="<?php echo base_url('slipmanual/cetakSlip') ?>";
            // })
            $(document).on('click','#btn-detail',function () {
                var _this = $(this).closest('tr');
                var noslip = $(_this).attr('noslip');
                var infaq = $(_this).attr('infaq');
                var zakat = $(_this).attr('zakat');
                var pena = $(_this).attr('pena');
                var cgq = $(_this).attr('cgq');
                var rcy = $(_this).attr('rcy');
                var nama_jungut = $(_this).attr('nama_jungut');
                var date = $("#date").val();
                
                $("#modal-jungut").val(nama_jungut);
                $("#modal-noslip-manual").val(noslip);
                $.ajax({
                    type  : 'POST',
                    url   : '<?php echo base_url('slipmanual/getDataProgram') ?>',
                    data  : {
                        noslip : noslip,
                        date : date
                    },
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                        var cont="";
                        var contTot="";
                        var totJum=0;
                            for (var i=0;i<data.length;i++) {                            
                            
                            totJum += parseInt(data[i].jumlah);
                            cont +='<table width="100%">'+'<tr>'+'<td width="50%">'+data[i].nama_program+'</td>'+'<td>Rp. '+price_format(data[i].jumlah)+'</td>'+'</tr>'+'</table>';
                            contTot = '<table width="100%">'+'<tr>'+'<td width="50%">Jumlah</td>'+'<td>Rp. '+price_format(totJum)+'</td>'+'</tr>'+'</table>';
                        }
                        $("#modal-tabel-slipmanual").html(cont);
                        $("#modal-tabel-slipmanual-total").html(contTot);
                        // console.log('ok');
                    }
                });

                $("#modal-infaq-text").html('Infaq');
                $("#modal-zakat-text").html('Zakat');
                $(".selectpicker").selectpicker("refresh");
                // $('#modal-slipmanual').modal('show');
                // console.log('ok');
            });



            $(document).on('click','#btn-tambah',function () {
                var _this = $(this).closest('tr');
                var noslip = $(_this).attr('noslip');
                var infaq = $(_this).attr('infaq');
                var zakat = $(_this).attr('zakat');
                var pena = $(_this).attr('pena');
                var cgq = $(_this).attr('cgq');
                var rcy = $(_this).attr('rcy');
                var bank = $(_this).attr('bank');
                var validasi = $(_this).attr('validasi');
                var nama_jungut = $(_this).attr('nama_jungut');
                var kodej = $(_this).attr('kodej');
                
                $("#modal-noslip-tambah-manual").val(noslip);
                $("#modal-idbank").val(bank);
                $("#modal-kodej-tambah-manual").val(kodej);
                $("#modal-tambah-validasi").val(validasi);

            });


            $(document).on('click','#btn-tambah-slipbaru-slipmanual',function(){
                
                var jumlah = $("#modal-jumlah-slipbaru-slipmanual").val();
                var id_vent = $("#program-slipbaru-slipmanual").children("option:selected").attr('id_vent');
                var jungut = $("select#jungut-slipbaru-slipmanual").val();
                var tgl_himp = $("#modal-date-slipbaru-slipmanual").val();
                var program = $("#program-slipbaru-slipmanual").val();
                var bank = $("#bank-slipbaru-slipmanual").val();
                var nokasir = $("#modal-nokasir-slipbaru-slipmanual").val();
                var keterangan = $("#modal-keterangan-slipbaru-slipmanual").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('slipmanual/insertSlipBaru') ?>",
                    data: {
                        jumlah:jumlah,
                        id_vent:id_vent,
                        jungut : jungut,
                        tgl_himp:tgl_himp,
                        program:program,
                        bank:bank,
                        nokasir:nokasir,
                        keterangan:keterangan,
                    },
                    dataType: "json",
                    async:true,
                    success: function (data) {
                        // console.log('ok');
                        $('#modal-tambah-slipbaru-slipmanual').modal('hide');
                    }
                });   
            });

            $(document).on('click', '#btn-tambah-slipmanual', function () {
                var noslip = $("#modal-noslip-tambah-manual").val();
                var jumlah = $("#jumlah-tambah-slipmanual").val();
                var id_vent = $("#program-slipmanual").children("option:selected").attr('id_vent');
                var kodej = $("#modal-kodej-tambah-manual").val();
                var bank = $("#modal-idbank").val();
                var program = $("#program-slipmanual").children("option:selected").val();
                var validasi = $("#modal-tambah-validasi").val();
                $.ajax({
                    type : 'POST',
                    url : '<?php echo base_url('slipmanual/insertProg') ?>',
                    data : {
                        noslip : noslip,
                        program : program,
                        jumlah : jumlah,
                        kodej : kodej,
                        bank : bank,
                        id_vent :id_vent,
                        validasi : validasi
                    },
                    async : true,
                    dataType : 'json',                    
                    success : function(data) {
                         console.log('ok');
                        $('#modal-tambah-slipmanual').modal('hide');
                        // $("#modal-noslip-tambah-manual").val("");
                        // $("#modal-idbank").val("");
                        // $("#modal-tambah-validasi").val("");
                        // $(".selectpicker").selectpicker("refresh");
                    },error: function () {
                        $('#modal-tambah-slipmanual').modal('hide');
                    }
                });
            });

        });
    }); 

    

    

    

    // $(document).ready(function(){
    //     $("#form-val").submit(function(){
    //         $('#modal-validasi').modal('hide');
    //     });
    // });
</script>

</html>