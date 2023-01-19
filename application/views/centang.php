
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('partials/head') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css"
        rel="stylesheet" />
    <style>
    #table th{
        min-width:78px;
    }
    </style>
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
                    Rekap Centang
                    <small>Control panel</small>
                </h1>
                
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Rekap Centang</li>
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
                                    <form action="<?php echo base_url('report/centang/rekap') ?>" target="_blank" method="post">
                                        <div class="form-group">
                                            <!-- <div class="col-sm-5">
                                                <label for="kodej" class="control-label">Jungut<span style="color: red">
                                                        *</span></label>
                                                <select class="form-control selectpicker" id="kodej" name="kodej" data-live-search="true">
                                                    <option name="kodej" value="-">Semua Jungut</option>
                                                    <?php foreach($jungut as $jungut) : ?>
                                                    <option name="kodej" value="<?php echo $jungut->kodej ?>"><?php echo $jungut->kodej." - ".$jungut->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div> -->

                                            <div class="col-sm-5">
                                                <label for="date" class="control-label">Bulan<span style="color: red">
                                                        *</span></label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control daterange-btn" id="datepicker" name="date" />
                                                </div>
                                            </div>

                                            <div class="col-sm-2" style="padding-top:5px;">
                                                <label for="button"> </label>
                                                <button id="btnsubmit" type="button" name="button" class="btn btn-block btn-success">
                                                    Submit 
                                                    <span><i class="fa fa-search"></i></span>
                                                </button>
                                            </div>
                                            <div class="col-sm-2" style="padding-top:5px;">
                                                <label for="button"> </label>
                                                <input type="submit" name="btnexcel" class="btn btn-block btn-success" value="Export to excel" />
                                            </div>                                            
                                            <div class="col-sm-2" style="padding-top:5px;">
                                                <label for="button"> </label>
                                                <input type="submit" name="btncetak" class="btn btn-block btn-info" value="Cetak" />                                                
                                            </div>
                                        </div>
                                    </form>
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

                <div class="row" id="divTable" style="">
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
                                    <thead id="thead">
                                    <th>No.</th>
                                    <th>Kodej</th>
                                    <th>Nama</th>
                                    <th>Dep</th>
                                    <th>Qty</th>
                                    <th>Jumlah</th>
                                    </thead>

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

        

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format:'mm-yyyy'
            })
            //------------------------------------------

        //hari dalam 1 bulan
            var getDaysInMonth = function(month,year) {
            // Here January is 1 based
            //Day 0 is the last day in the previous month
            return new Date(year, month, 0).getDate();
            // Here January is 0 based
            // return new Date(year, month+1, 0).getDate();
            };
        //----------------------------------------------------------------------

        $("#table").DataTable();
        $("#btnsubmit").click(function() {
            $("#table").DataTable().destroy();
            $("#thead").remove();
            $("#table tbody tr").remove();
            var kodej = $("select#kodej").children("option:selected").val();
                var date = $("#datepicker").val();
                // console.log(date);
                var cont = "";
                var head="";
                var cabang="";
                var row="";
                var tb="";
                var monthLength="";
                var month=date.split('-')[0];
                var months = month.replace(/^0+/, '');
                var monthss=parseInt(months);
                var year=parseInt(date.split('-')[1]);
                var monthLength = getDaysInMonth(monthss,year);
                var td="";
                var bln="";
                        if(monthss == '1'){
                            var bulan="JAN";
                        }else if(monthss == '2'){
                            bulan="FEB";
                        }else if(monthss == '3'){
                            bulan="MAR";
                        }else if(monthss == '4'){
                            bulan="APR";
                        }else if(monthss == '5'){
                            bulan="MEI";
                        }else if(monthss == '6'){
                            bulan="JUN";
                        }else if(monthss == '7'){
                            bulan="JUL";
                        }else if(monthss == '8'){
                            bulan="AGS";
                        }else if(monthss == '9'){
                            bulan="SEP";
                        }else if(monthss == '10'){
                            bulan="OKT";
                        }else if(monthss == '11'){
                            bulan="NOV";
                        }else if(monthss == '12'){
                            bulan="DES";
                        }
                        dnts="";
                        for (var a = 1; a <= parseInt(monthLength); a++) {
                                    bln += '<th colspan="2">'+a+' '+bulan+'</th>';
                                    dnts += '<th>Dnt</th>'+
                                            '<th>Dns</th>';
                                    }
                        
                            head =  '<thead id="thead">'+
                                    '<tr>'+
                                    '<th rowspan="2">No</th>'+
                                    '<th rowspan="2">Kodej</th>'+
                                    '<th rowspan="2">Nama</th>'+
                                    '<th rowspan="2">Dep</th>'+
                                    bln+                   
                                    '<th rowspan="2">Qty</th>'+
                                    '<th colspan="2">Jumlah</th>'+
                                    '</tr>'+
                                    '<tr>'+
                                    dnts+
                                    '<th>Dnt</th>'+
                                    '<th>Dns</th>'+
                                    '</tr>'+
                                    '</thead>'
                                    ;
            $("#table").append(head);
            // console.log(monthLength);
            $("#table").DataTable({
                // columns : [
                //     {
                //         title : "No."
                //     },
                //     {
                //         title : "Kodej"
                //     },
                //     {
                //         title : "Nama"
                //     },

                // ],
                ordering: false,
                processing: true,
                serverSide: true,
                lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
                ajax:{
                 url:"<?php echo base_url('centang/getData') ?>",
                 type:"POST",
                 data:{
                     date:date
                 }
                }
            });        
        });

        });


        //submit-event

            //fungsi-tampil
            function tampil() {
                $("#table").DataTable().destroy();
                $('#divTable').show();
                var kodej = $("select#kodej").children("option:selected").val();
                var date = $("#datepicker").val();
                // console.log(date);
                var cont = "";
                var head="";
                var cabang="";
                var row="";
                var tb="";
                var monthLength="";
                var month=date.split('-')[0];
                var months = month.replace(/^0+/, '');
                var monthss=parseInt(months);
                var year=parseInt(date.split('-')[1]);
                var monthLength = getDaysInMonth(monthss,year);
                var td="";
                

                $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('centang/getData') ?>',
                    data  : {
                        date : date,
                    },
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                        for(var s=0;s<=parseInt(monthLength)*2;s++){
                            td += '<td>'+'ds'+'</td>';
                        }
                        for (var i=0;i<data.length;i++) {  
                            // console.log(data);
                            var no = i+1;
                            // cabang = data[i].cabang;
                            // if(data[i].id_cabang = '1'){
                            //     cabang="SBY";
                            // }
                            // var monthStart = (data[i].tahun, data[i].bulan, 1);
                            // var monthEnd = (data[i].tahun, data[i].bulan+1, 1);
                            // var monthLength = (monthEnd - monthStart) / (1000 * 60 * 60 * 24);

                            // for (let a = 1; a <= monthLength+1; a++) {
                            //     row += '<td>'++'</td>';
                            //     dnt = '<td>'+data[i].dnt[a]+'</td>'+;
                            //     dns
                            // }
                            // month = data[i].bulan;                        
                            // year = data[i].tahun;

                            
                            

                            cont += '<tr>'+
                                '<td>'+no+'</td>'+
                                '<td>'+ data[i].kodej+'</td>'+
                                '<td>'+ data[i].name +'</td>'+
                                '<td>'+ data[i].cabang +'</td>'+
                                // for (let a = 1; a <= monthLength+1; a++) {
                                //     '<td>'+data[i].dnt[a]+'</td>'+;
                                //     '<td>'+data[i].dns[a]+'</td>'+;
                                // }
                                td+
                                '<td>'+ 'dsd' +'</td>'+
                                // '<td>'+ data[i].jumlah +'</td>'+
                                '</tr>';                                
                            
                        }                
                        console.log(monthss);

                        //BULAN INDO
                        var bln="";
                        if(monthss == '1'){
                            var bulan="JAN";
                        }else if(monthss == '2'){
                            bulan="FEB";
                        }else if(monthss == '3'){
                            bulan="MAR";
                        }else if(monthss == '4'){
                            bulan="APR";
                        }else if(monthss == '5'){
                            bulan="MEI";
                        }else if(monthss == '6'){
                            bulan="JUN";
                        }else if(monthss == '7'){
                            bulan="JUL";
                        }else if(monthss == '8'){
                            bulan="AGS";
                        }else if(monthss == '9'){
                            bulan="SEP";
                        }else if(monthss == '10'){
                            bulan="OKT";
                        }else if(monthss == '11'){
                            bulan="NOV";
                        }else if(monthss == '12'){
                            bulan="DES";
                        }
                        //------------------------------------------

                        for (var a = 1; a <= parseInt(monthLength); a++) {
                                    bln += '<th colspan="2" align="center">'+a+' '+bulan+'</th>';
                                    }
                        
                            head = '<tr>'+
                                    '<th >No</th>'+
                                    '<th >Kodej</th>'+
                                    '<th >Nama</th>'+
                                    '<th >Dep</th>'+
                                    bln+                   
                                    '<th >Qty</th>'+
                                    '<th >Jumlah</th>'+
                                    '</tr>';

                        $("#thead").html(head);
                        $("#tbody").html(cont);
                        $("#table").DataTable({
                                lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
                                fixedHeader: {
                                                header: true,
                                                footer: true
                                            }
                            });
                    }
                });
                //end-ajaxx
            }
</script>

</html>