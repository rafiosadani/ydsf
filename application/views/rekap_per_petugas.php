<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div align="center">
<b>REKAP PRESTASI TOTAL JUNGUT<br>
WILAYAH :<?php if(isset($petugas->nama_cabang)){ echo $petugas->nama_cabang; }else{echo 'SEMUA WILAYAH';}?> &nbsp;<?php if(isset($petugas->kodej)){echo 'JUNGUT : '.$petugas->name ;}?> &nbsp;PERIODE : <?php echo $periode['bulan'].' '.$periode['tahun'] ?> &nbsp;  TANGGAL CETAK : <?php echo date('d-m-y h:i');?>
</b>
</div>
	<div class="box-body table-responsive">
		<table width="100%" border="1">
        <tr>
        <td rowspan="2">NO</td>
        <td rowspan="2">Nama</td>
        <td rowspan="2">Kode</td>
        <td colspan="2">Target</td>
        <td colspan="2">Hasil</td>
        <td colspan="2">Hasil%</td>
        <td rowspan="2">%Rata2</td>
        <td colspan="2">Gagal</td>
        <td colspan="2">Lebih</td>
        <td colspan="2">Total</td>
        <td colspan="2">%Total</td>
        <td rowspan="2">%Rata2</td>
        </tr>
        <tr>
        <td>Donatur</td>
        <td>Donasi</td>
        <td>Donatur</td>
        <td>Donasi</td>
        <td>Donatur</td>
        <td>Donasi</td>
        <td>Donatur</td>
        <td>Donasi</td>
        <td>Donatur</td>
        <td>Donasi</td>
        <td>DNT</td>
        <td>DNS </td>
        <td>DNT</td>
        <td>DNS </td>
        </tr>
        <?php 
        $tot_DNT=0;
        $persn_hsl1=0;
        $tot_DNS=0;
        $tot_HDNT=0;
        $tot_HDNS=0;
        $tot_GDNT=0;
        $tot_GDNS=0;
        $tot_LDNT=0;
        $tot_LDNS=0;
        $tot_TTDNS=0;
        $tot_TTDNT=0;
        foreach($prestasi as $no => $prestasi) :?>
        <tr>
        <td><?php echo $no+1 ?></td>
        <td><?php echo $prestasi->nama ?></td>
        <td><?php echo $prestasi->kodej?></td>
        <td><?php echo $prestasi->T_DNT; $tot_DNT +=$prestasi->T_DNT;?></td>
        <td><?php echo number_format($prestasi->T_DNS,0,',',','); $tot_DNS +=$prestasi->T_DNS;?></td>
        <td><?php echo $prestasi->H_DNT;$tot_HDNT +=$prestasi->H_DNT;?></td>
        <td><?php echo number_format($prestasi->H_DNS,0,',',',');$tot_HDNS +=$prestasi->H_DNS;?></td>
        <td><?php $persn_hsl1=(intval($prestasi->H_DNT) / intval($prestasi->T_DNT))*100; 
        echo number_format($persn_hsl1,2,',',',').'%';
        ?></td>
        <td><?php $persn_hsl2=(intval($prestasi->H_DNS) / intval($prestasi->T_DNS))*100; 
        echo number_format($persn_hsl2,2,',',',').'%';
        ?></td>
        <td><?php $rata=($persn_hsl1 + $persn_hsl2)/2;echo number_format($rata,2,',',',').'%'?></td>
        <td><?php echo $prestasi->G_DNT;$tot_GDNT +=$prestasi->G_DNT;?></td>
        <td><?php echo number_format($prestasi->G_DNS,0,',',',');$tot_GDNS +=$prestasi->G_DNS;?></td>
        <td><?php echo $prestasi->L_DNT;$tot_LDNT +=$prestasi->L_DNT;?></td>
        <td><?php echo number_format($prestasi->L_DNS,0,',',',');$tot_LDNS +=$prestasi->L_DNS;?></td>
        <td><?php echo $prestasi->TT_DNT;$tot_TTDNT += $prestasi->TT_DNT; ?></td>
        <td><?php echo number_format($prestasi->TT_DNS,0,',',',');$tot_TTDNS += $prestasi->TT_DNS;?></td>
        <td><?php $pres_total_dnt=$prestasi->TT_DNT / $prestasi->T_DNT * 100; echo number_format($pres_total_dnt,2,',',',').'%'?></td>
        <td><?php $pres_total_dns=$prestasi->TT_DNS / $prestasi->T_DNS * 100; echo number_format($pres_total_dns,2,',',',').'%' ?></td>
        <td><?php $rata_total=($pres_total_dnt + $pres_total_dns) / 2;echo number_format($rata_total,2,',',',').'%' ?></td>
        </tr>
<?php endforeach; ?>
        <tr>
            <td colspan="3">Jumlah</td>
            <td><?php echo $tot_DNT;?></td>
            <td><?php echo number_format($tot_DNS,0,',',',');?></td>
            <td><?php echo $tot_HDNT;?></td>
            <td><?php echo number_format($tot_HDNS,0,',',',');?></td>
            <td><?php if($tot_DNT != ''){$tot_persn_hsl1=$tot_HDNT/$tot_DNT*100; echo number_format($tot_persn_hsl1,2,',',',').'%'; }else{echo '0';}?></td>
            <td><?php if($tot_DNT != ''){$tot_persn_hsl2=$tot_HDNS/$tot_DNS*100; echo number_format($tot_persn_hsl2,2,',',',').'%'; }else{echo '0';}?></td>
            <td><?php if($tot_DNT != ''){$tot_persn_hsl3=($tot_persn_hsl1 + $tot_persn_hsl2) /2; echo number_format($tot_persn_hsl3,2,',',',').'%';}else{echo '0';}?></td>
            <td><?php echo $tot_GDNT;?></td>
            <td><?php echo number_format($tot_GDNS,0,',',',');?></td>
            <td><?php echo $tot_LDNT;?></td>
            <td><?php echo number_format($tot_LDNS,0,',',',');?></td>
            <td><?php echo $tot_TTDNT;?></td>
            <td><?php echo number_format($tot_TTDNS,0,',',',');?></td>
            <td><?php if($tot_DNT != ''){ $jum_dnt=$tot_TTDNT / $tot_DNT *100; echo number_format($jum_dnt,2,',',',').'%' ;} else{echo '0';}?></td>
            <td><?php if($tot_DNT != ''){$jum_dns=$tot_TTDNS / $tot_DNS *100; echo number_format($jum_dns,2,',',',').'%';}  else{echo '0';}?></td>
            <td><?php if($tot_DNT != ''){$rata_jum= ($jum_dns + $jum_dnt) / 2; echo number_format($rata_jum,2,',',',').'%';} else{echo '0';}?></td>
        </tr>
		</table>



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>