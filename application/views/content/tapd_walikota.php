<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<?php
switch($tp){

case 'verifikasi':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$p'"); $detail = $Qdetail->result_object();

$Qket = $this->db->query("SELECT value AS rekomendasi FROM proposal_checklist WHERE checklist_id=26 AND proposal_id='$p'"); $ket = $Qket->result_object();

$Qdisposisi = $this->db->query("SELECT path FROM proposal_disposisi WHERE id_proposal='$p'"); $dis = $Qdisposisi->result_object();

$Qcheck2 = $this->db->query("SELECT checklist_id FROM proposal_checklist WHERE proposal_id='$p' AND checklist_id IN (11)");
$check2= $Qcheck2->result_object();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/tapd/verifikasi/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan</h1>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
			<p class="label">Keterangan Tim Pertimbangan</p>
            <p><?php if(isset($check2[0]->checklist_id)) echo 'Dapat Dipertimbangkan'; else echo 'Tidak Dapat Dipertimbangkan'; ?></p>
			
            <p class="label">Nominal yang Direkomendasikan Tim Pertimbangan</p>
            <p><?php echo 'Rp. '.number_format($ket[0]->rekomendasi,0,",",".").',-' ?></p>
			
			<p class="label">File Disposisi</p>
			<p><?php if(isset($dis[0]->path)) echo '<a class="info" target="_blank" href="'.base_url('media/disposisi/'.$dis[0]->path).'">Download File</a>'; else echo '-';?></p>
			<div class="col-wrapper clearfix">
                <p class="label">Pemberian Rekomendasi Dana</p>
                <div class="control-group">
                    <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="1">
                        Ya
                    </label>
                   <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="2">
                        Tidak
                    </label>
					
					<label class="control-label" for=""><p class="label">Nominal yang Direkomendasikan TAPD</p></label>
					<div class="controls">
						<input type="text" placeholder="Rp" name="rekomendasi">
					</div>
                </div>
			</div>
			
			<script type="text/javascript">
				$(document).ready(function(){				
					$("div.control-group input[type=radio]").on('change',function(){
						var thelength = $("div.control-group input[type=radio]").length;
						//alert("ok");
						//document.getElementById('besar').value='';
						});
					
						});
				</script>
                  
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Keterangan</p></label>
                <div class="controls">
                    <textarea rows="5" name="keterangan"></textarea>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Verifikasi" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'generate':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal, c.value AS keterangan FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id JOIN proposal_checklist c ON c.proposal_id=a.id WHERE a.id='$dx' AND c.checklist_id=13"); $detail = $Qdetail->result_object();

$Qmohon2 = $this->db->query("SELECT SUM(amount) AS mohon2 FROM proposal_dana"); $mohon2 = $Qmohon2->result_object();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper">
		<h1 class="page-title page-title-border">Rekapitulasi DNC PBH</h1>
       

            <?php   
            $limit = 15;
            $p = $p ? $p : 1;
            $position = ($p -1) * $limit;
            $this->db->_protect_identifiers=false;
            ?>

            <table class="table-global">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Nama Lengkap Calon Penerima</th>
                        <th rowspan="2">Alamat Lengkap</th>
                        <th rowspan="2">Rencana Penggunaan</th>
                        <th class="has-sub" colspan="3">Nilai</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php
                    if(isset($_POST['rekap'])){
                        $kategori = $_POST['kategori'];
                        $dari = $_POST['dari'];
                        $sampai = $_POST['sampai'];
                        $skpd = $_POST['skpd'];
						$pertimbangan = $_POST['rekomendasi'];
						
						
                        $where = '';
						
						
                        //kategori
                        if($kategori && !$dari && !$sampai && !$skpd){
                            if($kategori=='all') $where .= "";
                            else $where .= "WHERE type_id = $kategori";
                        }elseif($kategori && $dari && !$sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari'";
                        }elseif($kategori && !$dari && $sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai'";
                        }elseif($kategori && !$dari && !$sampai && $skpd){
                            if($kategori=='all' AND $skpd=='all') $where .= "";
                            elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE type_id = $kategori";
                            elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND skpd_id = $skpd";
                        }    

						//rekomendasi
						elseif($kategori && $skpd && $pertimbangan){
							if($kategori=='all'){
								if($skpd=='all'){
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1'";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2'";
									}else{
										$where .= "";
									}
									
								}else{
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1' AND skpd_id = $skpd";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2' AND skpd_id = $skpd";
									}else{
										$where .= "WHERE skpd_id = $skpd";
									}
									
								}
							}else{
								if($skpd=="all"){
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1' AND type_id = $kategori";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2'  AND type_id = $kategori ";
									}else{
										$where .= "WHERE type_id = $kategori";
									}
								}else{
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1' AND skpd_id = $skpd  AND type_id = $kategori";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2' AND skpd_id = $skpd  AND type_id = $kategori";
									}else{
										$where .= "WHERE skpd_id = $skpd  AND type_id = $kategori";
									}
								}
							}
						}

                        //dari
                        elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari'";
                        elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                        elseif(!$kategori && $dari && !$sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                            else $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                        }

                        //sampai
                        elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                        elseif(!$kategori && !$dari && $sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                        }

                        //skpd
                        elseif(!$kategori && !$dari && !$sampai && $skpd){
                            if($skpd=='all') $where .= "";
                            else $where .= "WHERE skpd_id = $skpd";
                        }

                        //mixed
                        elseif($kategori && $dari && $sampai && !$skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                        }elseif(!$kategori && $dari && $sampai && $skpd){
                            if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            else $where .= "WHERE skpd_id = $skpd AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                        }elseif($kategori && $dari && !$sampai && $skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                        }elseif($kategori && !$dari && $sampai && $skpd){
                            if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                        }elseif($kategori && $dari && $sampai && $skpd){
                            if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                            elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                            else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                        }
						
						
						
						$Qlist = $this->db->query("SELECT id, name, address, maksud_tujuan FROM proposal where tapd_stat = '1' ORDER BY id DESC LIMIT $position,$limit");
                    }else { $Qlist = $this->db->select("id, name, address, maksud_tujuan")->from('proposal')->order_by('id', 'DESC')->limit($limit, $position)->get();
						
					}
					
					$Qlist = $this->db->query("SELECT id, name, address, maksud_tujuan FROM proposal where walikota_stat = '1' ORDER BY id DESC LIMIT $position,$limit");
					
					//ferdi -fungsi untuk menampilkan data pada view (bukan report, masih error)
					//$Qlist = $this->db->query("select a.id, a.name, a.address, a.maksud_tujuan from proposal a, rekomendasi_tapd b where b.value = '".$pertimbangan."' and a.id = b.id_proposal");
					
					
					
					
					
                    if($Qlist->num_rows){
                        $i = 1;
						$total = 0;
                        foreach($Qlist->result_object() as $list){
                            $Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$list->id'"); $mohon = $Qmohon->result_object(); 
							
							

                            /*$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id IN (26,28,29)"); $besar = $Qbesar->result_object();*/

                            //edit ferdi
                            $Qbesar = $this->db->query("SELECT value FROM verifikasi_pertimbangan WHERE `id_proposal`='$list->id'"); $besar = $Qbesar->result_object(); 

                            $Qbesar1 = $this->db->query("SELECT value , keterangan FROM verifikasi_tapd WHERE `id_proposal`='$list->id'"); $besar1 = $Qbesar1->result_object(); 

                            echo '<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$list->name.'</td>
                                    <td>'.$list->address.'</td>
                                    <td>'.$list->maksud_tujuan.'</td>
                                    
                                    <td colspan=3>'; if(isset($besar1[0]->value)) echo 'Rp. '.number_format($besar1[0]->value,0,",",".").',-'; else echo '-'; echo '</td>
                                    <td>'; if(isset($besar1[0]->keterangan)) echo $besar1[0]->keterangan; else echo '-'; echo '</td>
                                </tr>';
                            $i++;
							//$total = $total + number_format($mohon[0]->mohon,0,",",".");
                        }
                    }else echo '<tr><td colspan="8">No data.</td></tr>';
                    ?>
                </tbody>
            </table>

            <?php
            if(isset($_POST['rekap'])){
                $kategori = $_POST['kategori'];
                $dari = $_POST['dari'];
                $sampai = $_POST['sampai'];
                $skpd = $_POST['skpd'];
				$pertimbangan = $_POST['rekomendasi'];
				
                $where = '';

                //kategori
                if($kategori && !$dari && !$sampai && !$skpd){
                    if($kategori=='all') $where .= "";
                    else $where .= "WHERE type_id = $kategori";
                }elseif($kategori && $dari && !$sampai && !$skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari'";
                }elseif($kategori && !$dari && $sampai && !$skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai'";
                }elseif($kategori && !$dari && !$sampai && $skpd){
                    if($kategori=='all' AND $skpd=='all') $where .= "";
                    elseif($kategori!='all' AND $skpd=='all') $where .= "WHERE type_id = $kategori";
                    elseif($kategori=='all' AND $skpd!='all') $where .= "WHERE skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND skpd_id = $skpd";
                }                        
				
				//rekomendasi
						elseif($kategori && $skpd && $pertimbangan){
							if($kategori=='all'){
								if($skpd=='all'){
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1'";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2'";
									}else{
										$where .= "";
									}
									
								}else{
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1' AND skpd_id = $skpd";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2' AND skpd_id = $skpd";
									}else{
										$where .= "WHERE skpd_id = $skpd";
									}
									
								}
							}else{
								if($skpd=="all"){
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1' AND type_id = $kategori";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2'  AND type_id = $kategori ";
									}else{
										$where .= "WHERE type_id = $kategori";
									}
								}else{
									if($pertimbangan=='1'){
										$where .= "WHERE tapd_stat = '1' AND skpd_id = $skpd  AND type_id = $kategori";
									}elseif($pertimbangan=='2'){
										$where .= "WHERE tapd_stat = '2' AND skpd_id = $skpd  AND type_id = $kategori";
									}else{
										$where .= "WHERE skpd_id = $skpd  AND type_id = $kategori";
									}
								}
							}	
						}
                //dari
                elseif(!$kategori && $dari && !$sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari'";
                elseif(!$kategori && $dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                elseif(!$kategori && $dari && !$sampai && $skpd){
                    if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari'";
                    else $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                }

                //sampai
                elseif(!$kategori && !$dari && $sampai && !$skpd) $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                elseif(!$kategori && !$dari && $sampai && $skpd){
                    if($skpd=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                }

                //skpd
                elseif(!$kategori && !$dari && !$sampai && $skpd){
                    if($skpd=='all') $where .= "";
                    else $where .= "WHERE skpd_id = $skpd";
                }

                //mixed
                elseif($kategori && $dari && $sampai && !$skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                }elseif(!$kategori && $dari && $sampai && $skpd){
                    if($skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    else $where .= "WHERE skpd_id = $skpd AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                }elseif($kategori && $dari && !$sampai && $skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND skpd_id = $skpd";
                }elseif($kategori && !$dari && $sampai && $skpd){
                    if($kategori=='all') $where .= "WHERE YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                }elseif($kategori && $dari && $sampai && $skpd){
                    if($kategori=='all' && $skpd=='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    elseif($kategori!='all' && $skpd=='all') $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai'";
                    elseif($kategori=='all' && $skpd!='all') $where .= "WHERE YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                    else $where .= "WHERE type_id = $kategori AND YEAR(time_entry) >= '$dari' AND YEAR(time_entry) <= '$sampai' AND skpd_id = $skpd";
                }

                $Qpaging = $this->db->query("SELECT id, name, address, maksud_tujuan FROM proposal $where");
            }else $Qpaging = $this->db->select("id, name, address, maksud_tujuan")->from('proposal')->order_by('id', 'DESC')->get();
				
			$Qpaging = $this->db->query("SELECT id, name, address, maksud_tujuan FROM proposal where walikota_stat = '1'");	
			
            $num_page = ceil($Qpaging->num_rows / $limit);
            if($Qpaging->num_rows > $limit){
                $this->ifunction->paging($p, site_url('tapd').'/generate/', $num_page, $Qpaging->num_rows, 'href', false);
            }
            ?>
            <!-- table-global -->
            <div class="control-actions">
                <!-- <input name="lanjut" class="btn-red btn-plain btn" type="submit" value="Cetak DNC PBH"> -->
                <?php
                if(isset($_POST['rekap'])) echo '<a target="_blank" href="'.base_url('process/generate_dnc_walikota/'.$_POST['kategori'].'/'.$_POST['dari'].'/'.$_POST['sampai'].'/'.$_POST['skpd'].'/'.$_POST['rekomendasi']).'" class="btn-red btn-plain btn" style="display:inline">Cetak DNC PBH</a>';
                else echo '<a target="_blank" href="'.base_url('process/generate_dnc_walikota/').'" class="btn-red btn-plain btn" style="display:inline">Cetak DNC PBH</a>';
                ?>
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </div>
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$p'"); $detail = $Qdetail->result_object();

$Qket = $this->db->query("SELECT value AS rekomendasi FROM proposal_checklist WHERE checklist_id=26 AND proposal_id='$p'"); $ket = $Qket->result_object();

$Qedit = $this->db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$p' AND checklist_id IN (28,29)"); $edit = $Qedit->result_object();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/tapd/edit/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi Pertimbangan</h1>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Nominal yang Direkomendasikan Tim Pertimbangan</p>
            <p><?php echo 'Rp. '.number_format($ket[0]->rekomendasi,0,",",".").',-' ?></p>
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Nominal yang Direkomendasikan TAPD</p></label>
                <div class="controls">
                    <input type="text" placeholder="Rp" name="rekomendasi" value="<?php if(isset($edit[0]->value)) echo $edit[0]->value ?>">
                </div>
            </div>           
            <div class="control-group">
                <label class="control-label" for=""><p class="label">Keterangan</p></label>
                <div class="controls">
                    <textarea rows="5" name="keterangan"><?php if(isset($edit[1]->value)) echo $edit[1]->value ?></textarea>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}