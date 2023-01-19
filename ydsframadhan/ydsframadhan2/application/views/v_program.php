<?php 
if($this->input->post('idcabang')=='') $jeniscabang= 'Semua Cabang';
else $jeniscabang= $a_cabang[$this->input->post('idcabang')];
    ?>
<?php
if($this->input->post('jenislaporan')=='excel'){
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Penghimpunan_Harian_".str_replace(" ","_",$jeniscabang).".xls");
}
?>
<h4>Penghimpunan Harian <?= $jeniscabang?></h4>
<h4>Tanggal Cetak : <?=  tgl_indo(date("Y-m-d"))?></h4>
<table class="table table-bordered">
    <tr class="table-info">
        <th rowspan="2">Hari</th>
        <th colspan="3">Perolehan Ramadhan Kemarin</th>
        <th colspan="3">Perolehan Ramadhan Sekarang</th>
    </tr>
    <tr class="table-info">
        <th>Tunai</th>
        <th>Bank</th>
        <th>Total</th>
        <th>Tunai</th>
        <th>Bank</th>
        <th>Total</th>
    </tr>
    <?php 
    $total_tunai_kemarin=0;
    $total_bank_kemarin=0;
    $total_total_kemarin=0;
    $total_tunai_sekarang=0;
    $total_bank_sekarang=0;
    $total_total_sekarang=0;
    foreach ($a_program as $key=>$value) {
        
        $total_tunai_kemarin+=$ramadhan_kemarin[$key]['jmltunai'];
        $total_bank_kemarin+=$ramadhan_kemarin[$key]['jmlbank'];
        $total_total_kemarin+=$ramadhan_kemarin[$key]['total'];
        $total_tunai_sekarang+=$ramadhan_sekarang[$key]['jmltunai'];
        $total_bank_sekarang+=$ramadhan_sekarang[$key]['jmlbank'];
        $total_total_sekarang+=$ramadhan_sekarang[$key]['total'];
        echo "<tr>
                    <td >$value</td>
                    <td style='text-align: right'>{$ramadhan_kemarin[$key]['jmltunai']}</td>
                    <td style='text-align: right'>{$ramadhan_kemarin[$key]['jmlbank']}</td>
                    <td style='text-align: right'>{$ramadhan_kemarin[$key]['total']}</td>
                    <td style='text-align: right'>{$ramadhan_sekarang[$key]['jmltunai']}</td>
                    <td style='text-align: right'>{$ramadhan_sekarang[$key]['jmlbank']}</td>
                    <td style='text-align: right'>{$ramadhan_sekarang[$key]['total']}</td>
                </tr>";
    }
    
        echo "<tr class='table-active'>
                <td style='text-align: center'>Total</td>
                <td style='text-align: right'>$total_tunai_kemarin</td>
                <td style='text-align: right'>$total_bank_kemarin</td>
                <td style='text-align: right'>$total_total_kemarin</td>
                <td style='text-align: right'>$total_tunai_sekarang</td>
                <td style='text-align: right'>$total_bank_sekarang</td>
                <td style='text-align: right'>$total_total_sekarang</td>
               </tr>";
    ?>
    
</table>