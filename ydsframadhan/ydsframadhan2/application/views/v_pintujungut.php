<?php 
if($this->input->post('idcabang')=='') $jeniscabang= 'Semua Cabang';
else $jeniscabang= $a_cabang[$this->input->post('idcabang')];
    ?>
<?php
if($this->input->post('jenislaporan')=='excel'){
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Penghimpunan_Pintu_Jungut_Cabang_".str_replace(" ","_",$jeniscabang).".xls");
}
?>
<h4>Penghimpunan Pintu Jungut Cabang <?= $jeniscabang?></h4>
<h4>Tanggal Cetak : <?=  tgl_indo(date("Y-m-d"))?></h4>
<table class="table table-bordered">
    <tr class="table-info">
        <th>Nama</th>
        <th>Thn. Kemarin</th>
        <th>Thn. Sekarang</th>
        <th>Posisi</th>
    </tr>
    <?php 
    $i=1;
    $totalkemarin=0;
    $totalsekarang=0;
    foreach ($a_petugas as $key=>$value) {
        
        if(!array_key_exists($key, $ramadhan_kemarin)){
            $ramadhan_kemarin[$key]=0;
            $ramadhan_sekarang[$key]=0;
        }
        
        if($ramadhan_kemarin[$key]>$ramadhan_sekarang[$key])
            $status="Turun";
        elseif($ramadhan_kemarin[$key]<$ramadhan_sekarang[$key])
            $status="Naik";
        else
            $status="-";
        
        echo "<tr>
                <td>$value</td>
                <td style='text-align: right'>$ramadhan_kemarin[$key]</td>
                <td style='text-align: right'>$ramadhan_sekarang[$key]</td>
                <td>$status</td>
            </tr>";
            
        $totalkemarin+=$ramadhan_kemarin[$key];
        $totalsekarang+=$ramadhan_sekarang[$key];
    }
    
        echo "<tr class='table-active'>
                <td style='text-align: center'>Total</td>
                <td style='text-align: right'>$totalkemarin</td>
                <td style='text-align: right'>$totalsekarang</td>
                <td></td>
               </tr>";
    ?>
    
</table>