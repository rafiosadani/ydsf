<?php 
if($this->input->post('idcabang')=='') $jeniscabang= 'Semua Cabang';
else $jeniscabang= $a_cabang[$this->input->post('idcabang')];
    ?>
<?php
if($this->input->post('jenislaporan')=='excel'){
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Penghimpunan_Gerai_".str_replace(" ","_",$jeniscabang).".xls");
}
?>
<h4>Penghimpunan Gerai <?= $jeniscabang?></h4>
<h4>Tanggal Cetak : <?=  tgl_indo(date("Y-m-d"))?></h4>
<table class="table table-bordered">
    <tr class="table-info">
        <th>Gerai</th>
        <th>Petugas</th>
        <th>Jumlah</th>
    </tr>
    <?php 
    $i=1;
    $totaltotal=0;
    foreach ($ramadhan_sekarang as $key=>$value) {
        $i=1;
        $rowspan=$value['jumlah']+1;
        $totalpergerai=0;
        foreach ($value['petugas'] as $keypetugas=>$valuepetugas) {
            $totaltotal+=$valuepetugas;
            $totalpergerai+=$valuepetugas;
            if($i==1){
                echo "<tr>
                        <td rowspan='$rowspan'>{$value['nm_gerai']}</td>
                        <td>$keypetugas</td>
                        <td style='text-align: right'>".formatRupiah($valuepetugas,false)."</td>
                    </tr>";
            }else{
                echo "<tr>
                        <td>$keypetugas</td>
                        <td style='text-align: right'>".formatRupiah($valuepetugas,false)."</td>
                    </tr>";
                
            }
                if($i==$value['jumlah']){
                    echo "<tr class='table-active'>
                            <td>Jumlah</td>
                            <td style='text-align: right'>".formatRupiah($totalpergerai,false)."</td>
                        </tr>";
                }
            $i++;
        }
                    
    }
    
        echo "<tr class='table-active'>
                <td colspan='2' style='text-align: center'>Total</td>
                <td style='text-align: right'>".formatRupiah($totaltotal,false)."</td>
               </tr>";
    ?>
    
</table>