<?php 
$namapetugas=$a_petugas[$this->input->post('idpetugas')];
    ?>
<?php
if($this->input->post('jenislaporan')=='excel'){
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Penghimpunan_Cabang_".str_replace(" ","_",$namapetugas).".xls");
}
?>
<h4>Penghimpunan Petugas <?= $namapetugas?></h4>
<h4>Tanggal Cetak : <?=  tgl_indo(date("Y-m-d"))?></h4>
<table class="table table-bordered">
    <tr class="table-info">
        <th rowspan="2">Program</th>
        <th colspan="3">Perolehan Ramadhan <?= $thn_kemarin?></th>
    </tr>
    <tr class="table-info">
        <th>Tunai</th>
        <th>Bank</th>
        <th>Total</th>
    </tr>
    <?php 
    $i=1;
    $totaltunai=0;
    $totalbank=0;
    $totaltotal=0;
    foreach ($ramadhan_kemarin as $value) {
       
        echo "<tr>
                <td>{$value['program']}</td>
                <td style='text-align: right'>".formatRupiah($value['jmltunai'],false)."</td>
                <td style='text-align: right'>".formatRupiah($value['jmlbank'],false)."</td>
                <td style='text-align: right'>".formatRupiah($value['jmltotal'],false)."</td>
            </tr>";
                
        $totaltunai+=$value['jmltunai'];
        $totalbank+=$value['jmlbank'];
        $totaltotal+=$value['jmltotal'];
                    
    }
    
        echo "<tr class='table-active'>
                <td>Total</td>
                <td style='text-align: right'>".formatRupiah($totaltunai,false)."</td>
                <td style='text-align: right'>".formatRupiah($totalbank,false)."</td>
                <td style='text-align: right'>".formatRupiah($totaltotal,false)."</td>
               </tr>";
    ?>
    
</table>