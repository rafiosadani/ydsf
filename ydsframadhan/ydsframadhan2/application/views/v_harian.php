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
        <th colspan="4">Perolehan Ramadhan Kemarin</th>
        <th colspan="4">Perolehan Ramadhan Sekarang</th>
    </tr>
    <tr class="table-info">
        <th>Tgl</th>
        <th>Tunai</th>
        <th>Bank</th>
        <th>Total</th>
        <th>Tgl</th>
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
    foreach ($hari_ramadhan as $key=>$value) {
        
        if($key>30)
            break;
        
        $total_tunai_kemarin+=$ramadhan_kemarin[$value['tgl_kemarin']]['jmltunai'];
        $total_bank_kemarin+=$ramadhan_kemarin[$value['tgl_kemarin']]['jmlbank'];
        $total_total_kemarin+=$ramadhan_kemarin[$value['tgl_kemarin']]['total'];
        $total_tunai_sekarang+=$ramadhan_sekarang[$value['tgl_sekarang']]['jmltunai'];
        $total_bank_sekarang+=$ramadhan_sekarang[$value['tgl_sekarang']]['jmlbank'];
        $total_total_sekarang+=$ramadhan_sekarang[$value['tgl_sekarang']]['total'];
        echo "<tr>
                    <td>$key</td>
                    <td style='text-align: center'>{$value['tgl_kemarin']}</td>
                    <td style='text-align: right'>{$ramadhan_kemarin[$value['tgl_kemarin']]['jmltunai']}</td>
                    <td style='text-align: right'>{$ramadhan_kemarin[$value['tgl_kemarin']]['jmlbank']}</td>
                    <td style='text-align: right'>{$ramadhan_kemarin[$value['tgl_kemarin']]['total']}</td>
                    <td style='text-align: center'>{$value['tgl_sekarang']}</td>
                    <td style='text-align: right'>{$ramadhan_sekarang[$value['tgl_sekarang']]['jmltunai']}</td>
                    <td style='text-align: right'>{$ramadhan_sekarang[$value['tgl_sekarang']]['jmlbank']}</td>
                    <td style='text-align: right'>{$ramadhan_sekarang[$value['tgl_sekarang']]['total']}</td>
                </tr>";
    }
    
        echo "<tr class='table-active'>
                <td colspan='2'style='text-align: center'>Total</td>
                <td style='text-align: right'>$total_tunai_kemarin</td>
                <td style='text-align: right'>$total_bank_kemarin</td>
                <td style='text-align: right'>$total_total_kemarin</td>
                <td></td>
                <td style='text-align: right'>$total_tunai_sekarang</td>
                <td style='text-align: right'>$total_bank_sekarang</td>
                <td style='text-align: right'>$total_total_sekarang</td>
               </tr>";
    ?>
    
</table>