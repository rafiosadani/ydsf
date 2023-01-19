<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">


	<div class="box-body table-responsive">
		<table width="100%">
			<tr class="tableheader">
				<b>
					<td colspan="2" align="center">REKAP LAPORAN PER BANK</td>
				</b>
			</tr>
			<tr class="tableheader">
				<?php $post = $this->input->post();
					if (($post['tglhimp'] != "" && $post['tglval'] != "") || ($post['tglhimp'] == "" && $post['tglval'] != "")) : ?>
						<td align="center" colspan="2"><?php echo "PERIODE : TANGGAL KEUANGAN ".$date['date_val1']." s/d ".$date['date_val2'] ?></td>
				<?php endif; ?>
				<?php $post = $this->input->post();
					if ($post['tglhimp'] != "" && $post['tglval'] == "") : ?>
						<td align="center" colspan="2"><?php echo "PERIODE : TANGGAL PENGHIMPUNAN ".$date['date_himp1']." s/d ".$date['date_himp2'] ?></td>
				<?php endif; ?>
			</tr>
			<tr>
				<td><p><p>
					<?php if ($this->input->post('cabang') == '-') : ?>
                    <table width="100%" border="1">
                                <tr class="style1">
                                    <td rowspan="2">
                                        BANK
                                    </td>
                                    <?php if($this->session->userdata('admin_grup')==TRUE){
                                         foreach ($this->mprogram->getCabangGrup() as $cabang) : ?>
                                        <td colspan="2">
                                            <?php echo $cabang->nm_cabang ?>
                                        </td>
                                    <?php endforeach;}else{ 
                                        foreach ($this->mprogram->getCabang() as $cabang) : ?>
                                        <td colspan="2">
                                            <?php echo $cabang->nm_cabang ?>
                                        </td>
                                    <?php endforeach;} ?>
                                    <td rowspan="2">
                                        Total
                                    </td>
                                </tr>
                                <tr class="style1">
                                    <?php if($this->session->userdata('admin_grup')==TRUE){
                                         for ($x = 0;$x < count($this->mprogram->getCabangGrup()); $x++) { ?>
                                        <td>
                                            JUNGUT
                                        </td>
                                        <td>
                                            KANTOR
                                        </td>
                                    <?php }}else{
                                        for ($x = 0;$x < count($this->mprogram->getCabang()); $x++) { ?>
                                        <td>
                                            JUNGUT
                                        </td>
                                        <td>
                                            KANTOR
                                        </td>
                                    <?php }}?>
                                </tr>
                                <?php $jjml = 0;$jml = array();$jml2 = array();foreach ($bank as $bank) { ?>
                                    <tr>
                                        <td><b><?php echo $bank->NM_BANK ?></b>
                                            <?php $sumt = 0;foreach($this->mbank->perBankAll($bank->BANK) as $program) {
                                                $sumt += $program->total; ?>
                                            <tr>
                                                <td><?php echo $program->program ?></td>
                                                <?php
                                                    if($this->session->userdata('admin_grup')==TRUE){
                                                        $cabang = $this->mprogram->getCabangGrup(); 
                                                    }else{
                                                        $cabang = $this->mprogram->getCabang(); 
                                                    }
                                                    for ($x = 0; $x < count($cabang); $x++) { 
                                                        $y = $cabang[$x]->cabang.'_jungut';
                                                        $z = $cabang[$x]->cabang.'_kantor';
                                                ?>
                                                    <td align=right>
                                                        <?php echo number_format($program->$y,0,'.',',') ?>
                                                    </td>
                                                    <td align=right>
                                                        <?php echo number_format($program->$z,0,'.',',') ?>
                                                    </td>
                                                <?php } ?>
                                                <td align=right><?php echo number_format($program->total,0, '.', ',') ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td bgcolor="#4acc39"><b>Jumlah <?php echo $bank->NM_BANK ?></b></td>
                                                <?php 
                                                    $sumj = $sumk = 0;
                                                    $j = array();
                                                    if($this->session->userdata('admin_grup')==TRUE){
                                                        $cab = $this->mprogram->getCabangGrup(); 
                                                    }else{
                                                        $cab = $this->mprogram->getCabang();
                                                    }
                                                    
                                                    for ($a = 0; $a < count($cab); $a++) {
                                                        $j[] = [$cab[$a]->cabang.'_jungut',
                                                        $cab[$a]->cabang.'_kantor'];
                                                    }

                                                    $sum = array();
                                                    $prog = $this->mbank->perBankAll($bank->BANK);
                                                    
                                                    for ($a = 0;$a < count($cab); $a++) {
                                                        $jungut = $j[$a][0];
                                                        $kantor = $j[$a][1];
                                                        
                                                        for ($v = 0;$v < count($prog);$v++) {
                                                            $sumj += $prog[$v]->$jungut;
                                                            $sumk += $prog[$v]->$kantor;
                                                        }
                                                        $sum[] = [$sumj,$sumk];
                                                        $sumj = 0;
                                                        $sumk = 0;
                                                    }
                                                ?>
                                                <?php 
                                                $jmltest = array();
                                                foreach ($sum as $sum ) {
                                                    $jmltest[] = [$sum[0],$sum[1]];
                                                    
                                                    ?>
                                                    <td bgcolor="#4acc39" align=right><b><?php echo number_format($sum[0],0,'.',',') ?></b></td>
                                                    <td bgcolor="#4acc39" align=right><b><?php echo number_format($sum[1],0,'.',',') ?></b></td>
                                                <?php }
                                                $jml[] = [$jmltest];
                                                $jml2[] = [$sumt];
                                                ?>
                                                <td bgcolor="#4acc39" align=right><b><?php echo number_format($sumt,0,'.',',') ?></b></td>
                                            </tr>   
                                        </td>
                                    </tr>
                                <?php } 
                                $finaltotal = array();
                                $ttl = 0;
                                $ttl2 = 0;
                                if($this->session->userdata('admin_grup')==TRUE){
                                for ($cc = 0;$cc<count($this->mprogram->getCabangGrup());$cc++) {
                                    for ($bb = 0;$bb<count($jml);$bb++) {
                                        $ttl += $jml[$bb][0][$cc][0];
                                        $ttl2 += $jml[$bb][0][$cc][1];
                                    }
                                    $finaltotal[] = [$ttl,$ttl2];
                                    $ttl = 0;
                                    $ttl2 = 0;
                                }
                                }else{
                                    for ($cc = 0;$cc<count($this->mprogram->getCabang());$cc++) {
                                        for ($bb = 0;$bb<count($jml);$bb++) {
                                            $ttl += $jml[$bb][0][$cc][0];
                                            $ttl2 += $jml[$bb][0][$cc][1];
                                        }
                                        $finaltotal[] = [$ttl,$ttl2];
                                        $ttl = 0;
                                        $ttl2 = 0;
                                    }   
                                }

                                $ttl3 = 0;
                                for ($kk = 0;$kk<count($jml2);$kk++) {
                                    $ttl3 += $jml2[$kk][0];
                                }
                                ?>
                                <tr>
                                    <td bgcolor="#f75127"><b>JUMLAH</b></td>
                                    <?php foreach ($finaltotal as $ftotal) { ?>
                                    <td bgcolor="#f75127" align="right"><b><?php echo number_format($ftotal[0],0,'.',',') ?></b></td>
                                    <td bgcolor="#f75127" align="right"><b><?php echo number_format($ftotal[1],0,'.',',') ?></b></td>
                                    <?php } ?>
                                    <td bgcolor="#f75127" align="right"><b><?php echo number_format($ttl3,0,'.',',') ?></b></td>
                                </tr>
							</table>
                    <?php endif;?>	
                    <?php if ($this->input->post('cabang') != '-') : ?>
                    <table width="100%" border="1">
                                <tr class="style1">
                                    <td rowspan="2">
                                        BANK
                                    </td>
                                    <?php 
                                        $cbg = "";
                                        if($this->session->userdata('admin_grup')==TRUE){
                                            $namacab = $this->mprogram->getCabangGrup();
                                        }else{
                                            $namacab = $this->mprogram->getCabang();
                                        }
                                        for ($s = 0; $s < count($namacab);$s++) {
                                            if ($namacab[$s]->id_cab == $this->input->post('cabang')) {
                                                $cbg = $namacab[$s]->nm_cabang;
                                            }
                                        } 
                                    ?>
                                        <td colspan="2">
                                            <?php echo $cbg ?>
                                        </td>
                                    <td rowspan="2">
                                        Total
                                    </td>
                                </tr>
                                <tr class="style1">
                                        <td>
                                            JUNGUT
                                        </td>
                                        <td>
                                            KANTOR
                                        </td>
                                </tr>
                                <?php $jml = array();foreach ($bank as $bank) { ?>
                                    <tr>
                                        <td><b><?php echo $bank->NM_BANK ?></b>
                                            <?php $sum1 = $sum2 = $sum3 = 0;foreach($this->mbank->perBankCab($bank->BANK,$this->input->post('cabang')) as $program) {
                                                $sum1 += $program->jungut;
                                                $sum2 += $program->kantor;
                                                $sum3 += $program->total;
                                                 ?>
                                            <tr>
                                                <td><?php echo $program->program ?></td>
                                                <td align=right>
                                                    <?php echo number_format($program->jungut,0,'.',',') ?>
                                                </td>
                                                <td align=right>
                                                    <?php echo number_format($program->kantor,0,'.',',') ?>
                                                </td>
                                                <td align=right><?php echo number_format($program->total,0, '.', ',') ?></td>
                                            </tr>
                                            <?php } 
                                            $jml[] = [$sum1,$sum2,$sum3];
                                             ?>
                                            <tr>
                                                <td bgcolor="#4acc39"><b>Jumlah <?php echo $bank->NM_BANK ?></b></td>
                                                <td bgcolor="#4acc39" align=right><b><?php echo number_format($sum1,0,'.',',') ?></b></td>
                                                <td bgcolor="#4acc39" align=right><b><?php echo number_format($sum2,0,'.',',') ?></b></td>
                                                <td bgcolor="#4acc39" align=right><b><?php echo number_format($sum3,0,'.',',') ?></b></td>
                                            </tr>   
                                        </td>
                                    </tr>
                                <?php } 

                                $ttl1 = $ttl2 = $ttl3 = 0;
                                for ($kk = 0;$kk<count($jml);$kk++) {
                                    $ttl1 += $jml[$kk][0];
                                    $ttl2 += $jml[$kk][1];
                                    $ttl3 += $jml[$kk][2];
                                }
                                
                                ?>
                                <tr>
                                    <td bgcolor="#f75127"><b>JUMLAH</b></td>
                                    <td bgcolor="#f75127" align="right"><b><?php echo number_format($ttl1,0,'.',',') ?></b></td>
                                    <td bgcolor="#f75127" align="right"><b><?php echo number_format($ttl2,0,'.',',') ?></b></td>
                                    <td bgcolor="#f75127" align="right"><b><?php echo number_format($ttl3,0,'.',',') ?></b></td>
                                </tr>
							</table>
                    <?php endif;?>
                <p><p><p></td>
			</tr>
			
		</table>
	</div>



</body>
<?php $this->load->view('partials/js') ?>
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
</script>

</html>