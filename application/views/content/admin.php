<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<?php
switch($tp){

case 'nphd':

//SUPI

$Qdana = $this->db->query("SELECT a.name AS npenerima, a.judul AS jkegiatan, SUM(b.value) AS nominal FROM proposal a JOIN verifikasi_tapd b ON b.id_proposal=a.id WHERE a.id='$dx'");
//$Qdana = $this->db->query("SELECT description, amount FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $this->db->query("SELECT SUM(value) AS mohon FROM verifikasi_tapd WHERE `id_proposal`='$dx'"); $mohon = $Qmohon->result_object();
//$Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->result_object();

$Qproposal = $this->db->query("SELECT file FROM proposal WHERE id='$dx'"); $proposal = $Qproposal->result_object();

$Qkoreksi = $this->db->query("SELECT path FROM proposal_koreksi WHERE id_proposal='$dx'"); $kor = $Qkoreksi->result_object();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Tahap X - admin/nphd ==> Tahap XII - tapd/Pencairan</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
		
	<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
		<script type="text/javascript" src="<?php echo base_url();?>static/js/form.js" ></script>
        <!-- <h1 class="page-title page-title-border">Detail Pengecekan Tahap X</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/tapd/pencairan_nphd/'.$dx) ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos</h1>
            <ul class="category-list list-nostyle">
                <li>
                    <h3 style="color:#ec7404">Status Hibah</h3>
                </li>
                <li>
                    <select id="kategori3" name="kategori3" onchange="jsFunction2()">
                    <option value="0">-- PILIH Status Pencairan</option>
                    
                    <option value="1">Pencairan Hibah Pemerintah Pusat</option>
					<option value="2">Pencairan Hibah Pemerintah Daerah Lain </option>
					<option value="3">Pencairan BUMN BUMD</option>
					<option value="4">Pencairan Hibah Badan/Lembaga dan atau ORMAS</option>
                
                    </select>
                </li>
            </ul>
					
			<!-- SUFI -->  
			  
             <?php		
                $Qlist1 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 3)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist1->result_object() as $list1){
					
					
						echo '
                            <label class="checkbox" id="id'.$list1->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
							 ';
					
					
                }
                ?>
			
			
    	
			<script type="text/javascript">
                
                function jsFunction2()
                {
                    //alert($id_option);
					if (document.getElementById("kategori3").value == "1"){
					//alert("fisik");
						var link = document.getElementById('id30')
						link.style.display = 'none';
					}else if (document.getElementById("kategori3").value == "2"){
					//alert("non fisik");
						var link = document.getElementById('id30')
                        link.style.display = 'none';
					}else if(document.getElementById("kategori3").value == "3"){
						var link = document.getElementById('id30')
                        link.style.display = 'none';
					}else {
						var link = document.getElementById('id30')
                        link.style.display = 'inherit';
					}
					
                    

                }
            </script> 

            <!-- <p>Pengecualian Poin 4 ; Surat Keterangan Domisili</p> -->
	
	
			<br>	
				<h3 style="color:#ec7404">Upload Dokumen</h3>
				<div class="control-group">
				    
                    
                    <label class="control-label" for="">Foto Penandatanganan NPHD</label>
                    <div class="controls file">
                        <input type="file" name="foto" required>
                    </div>
                    
					
					<label class="control-label" for="">File NPHD</label>
                    <div class="controls file">
                        <input type="file" name="nphd" accept="application/pdf" required>
                    </div>
					
					<label class="control-label" for="">Berita Acara</label>
					<div class="controls file">
                        <input type="file" name="acara" accept="application/pdf" required>
                    </div>
					
					<label class="control-label" for="">Surat Pernyataan</label>
					<div class="controls file">
                        <input type="file" name="pernyataan" accept="application/pdf" required>
                    </div> 
					
					<label class="control-label" for="">Pakta Integritas</label>
					<div class="controls file">
                        <input type="file" name="pakta" accept="application/pdf" required>
                    </div>
					
					<label class="control-label" for="">Kwitansi</label>
					<div class="controls file">
                        <input type="file" name="kwitansi" accept="application/pdf" required>
                    </div>


                </div>
			</br>
                <div class="control-group">
                    <h3 style>Koreksi Rincian Dana</h3>
                    <div class="controls file">
                        <table class="table-global">                            
                            <thead><tr><th>Penerima</th><th>Judul Kegiatan</th><th>Nilai Nominal</th><th>Download Koreksi SKPD</th><th>Download Ringkasan Proposal</th><th>Keterangan</th></tr></thead>
                            <tbody>
                            <?php
                            foreach($Qdana->result_object() as $dana){
                                echo '<tr>
								
										<td>'.$dana->npenerima.'</td>
                                        
										<td>'.$dana->jkegiatan.'</td>
								
                                        <td>Rp. '.number_format($dana->nominal,0,",",".").',-</td>
										
										<td><a class="info" target="_blank" href="'.base_url('media/proposal_koreksi/'.$kor[0]->path).'">Download Hasil</a></td>		
										
										<td><a class="info" target="_blank" href="'.base_url('media/proposal/'.$proposal[0]->file).'">Download Ringkasan</a></td>
										
										<td><input type="text" name="koreksi[]"></td>
										
                                    </tr>';
                            }                            
                            ?>
                            </tbody>
                            <tfoot>
                                <?php
                                echo '<tr>
                                        <th colspan="2">Total</th>
                                        <th colspan="4">Rp. '.number_format($mohon[0]->mohon,0,",",".").',-</th>
										
                                    </tr>';
                                ?>
                            </tfoot>
                        </table>
                        <h3 style>Permohonan 1</h3>
                        <table class="table-data table-global">
                        <thead>
                        <tr>
                            <th>Dana</th>
                            <th>Proposal</th>
                            <th>Penyetujuan</th>
                        </tr>
                        </thead>                        
                        <tbody>
                            <?php
                            $Qdana = $this->db->query("SELECT description, amount, correction FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

                            $Qmohon = $this->db->query("SELECT SUM(amount) AS mohon, SUM(correction) AS setuju FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

                            $Qnilai = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $nilai = $Qnilai->result_object();

                            foreach($Qdana->result_object() as $dana){
                                echo '<tr>
                                        <td>'.$dana->description.'</td>
                                        <td>Rp. '.number_format($dana->amount,0,",",".").',-</td>
                                        <td>Rp. '.number_format($dana->correction,0,",",".").',-</td>
                                    </tr>';
                            }
                            ?>                        
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-'; ?></th>
                            <th><?php echo 'Rp. '.number_format($mohon[0]->setuju,0,",",".").',-'; ?></th>
                        </tr>
                        <!-- <tr>
                            <th>Nilai yang Disetujui</th>
                            <th><?php if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; ?></th>
                            <th><?php if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; ?></th>
                        </tr> -->
                        </tfoot>
                    </table>



                    </table>
                        <h3 style>Permohonan 2</h3>
                        <table class="table-data table-global">
                        <thead>
                        <tr>
                            <th>Dana</th>
                            <th>Proposal</th>
                            <th>Penyetujuan</th>
                        </tr>
                        </thead>                        
                        <tbody>
                            <?php
                            $Qdana = $this->db->query("SELECT description, amount, correction FROM proposal_dana_fix WHERE proposal_id='$dx' ORDER BY sequence ASC");

                            $Qmohon = $this->db->query("SELECT SUM(amount) AS mohon, SUM(correction) AS setuju FROM proposal_dana_fix WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

                            $Qnilai = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $nilai = $Qnilai->result_object();

                            foreach($Qdana->result_object() as $dana){
                                echo '<tr>
                                        <td>'.$dana->description.'</td>
                                        <td>Rp. '.number_format($dana->amount,0,",",".").',-</td>
                                        <td>Rp. '.number_format($dana->correction,0,",",".").',-</td>
                                    </tr>';
                            }
                            ?>                        
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-'; ?></th>
                            <th><?php echo 'Rp. '.number_format($mohon[0]->setuju,0,",",".").',-'; ?></th>
                        </tr>
                        <!-- <tr>
                            <th>Nilai yang Disetujui</th>
                            <th><?php if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; ?></th>
                            <th><?php if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; ?></th>
                        </tr> -->
                        </tfoot>
                    </table>


                    </div>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="PROSES" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'lpj':
$Qdana = $this->db->query("SELECT amount, description FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->result_object();

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.value) AS nominal FROM proposal a JOIN verifikasi_tapd b ON b.id_proposal=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

$Qedit = $this->db->query("SELECT time_entry, type_id FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();

$Qcheck = $this->db->query("SELECT rekomendasi, value, keterangan FROM verifikasi_pertimbangan WHERE id_proposal='$dx'"); $check = $Qcheck->result_object();

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
        <h1 class="page-title page-title-border">Laporan Pertanggung Jawaban (LPJ)</h1>
        <form class="form-global" method="post" action="<?php echo base_url('process/admin/lpj/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal Pelaporan</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php $now = new DateTime(); echo $now->format('Y-m-d');?>" required>
                    </div>
				</div>
				
				<h3 style="color:#ec7404">Ringkasan Proposal</h3>
				<p class="label">Nama (Individu atau Organisasi):</p>
				<p><?php echo $detail[0]->name ?></p>
				<p class="label">Judul Kegiatan:</p>
				<p><?php echo $detail[0]->judul ?></p>
				<p class="label">Deskripsi Singkat Kegiatan</p>
				<p><?php echo $detail[0]->latar_belakang ?></p>
				<p class="label">Nominal Terbaru yang Diajukan di Proposal</p>
				<p><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-' ?></p>
				
				 <div class="control-group">
                    <label class="control-label" for="">Upload Ringkasan Laporan Penggunaan Dana Hibah Bansos</label>
                    <div class="controls file">
                         <input type="file" name="disposisi" accept="application/pdf" required="">
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="">Foto Kegiatan</label>
                    <div class="controls file">
                        <input type="file" name="foto[]">
                    </div>
                    <a class="link" href="#">Tambah Gambar</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Video</label>
                    <div class="controls file">
                        <input type="text" name="video[]" placeholder="Youtube URL">
                    </div>
                    <a class="video" href="#">Tambah Video</a>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Submit" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdana = $this->db->query("SELECT description, amount, correction FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->result_object();

$Qedit = $this->db->query("SELECT nphd FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();
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
        <h1 class="page-title page-title-border">NPHD</h1>
        <form class="form-global" method="post" action="<?php echo base_url('process/admin/edit/'.$dx) ?>" onsubmit="return check(<?php if(isset($besar[0]->value)) echo $besar[0]->value; else echo '0'; ?>)" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Upload NPHD</label>
                    <div class="controls file">
                        <input type="file" name="nphd" accept="application/pdf">
                        <a class="info" target="_blank" href="<?php echo base_url('media/nphd/'.$edit[0]->nphd) ?>">Lihat NPHD</a>
                        <input type="hidden" name="old_nphd" value="<?php echo $edit[0]->nphd ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Foto</label>
                    <?php                    
                    $Qfoto = $this->db->query("SELECT `path`, sequence FROM proposal_photo WHERE proposal_id='$dx' AND is_nphd='1' ORDER BY sequence ASC");

                    foreach($Qfoto->result_object() as $foto){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_foto[]" value="'.$foto->sequence.'"> Hapus</label>
                                <input type="file" name="foto[]">
                                <a class="info" target="_blank" href="'.base_url('media/proposal_foto/'.$foto->path).'">Lihat Foto</a>
                                <input type="hidden" name="old_foto[]" value="'.$foto->path.'">
                            </div>';
                    }
                    ?>
                    <a class="link" href="#">Tambah Foto</a>
                </div>                
                <p class="label">Nominal dari TAPD</p>
                <p><?php if(isset($besar[0]->value)) echo 'Rp. '.number_format($besar[0]->value,0,",",".").',-'; else echo '-'; ?></p>

                <div class="control-group">
                    <label class="control-label" for="">Koreksi Rincian Dana</label>
                    <div class="controls file">
                        <table class="table-global">                            
                            <thead><tr><th>Deskripsi</th><th>Jumlah</th><th>Koreksi</th></tr></thead>
                            <tbody>
                            <?php
                            foreach($Qdana->result_object() as $dana){
                                echo '<tr>
                                        <td>'.$dana->description.'</td>
                                        <td>Rp. '.number_format($dana->amount,0,",",".").',-</td>
                                        <td><input type="number" value="'.$dana->correction.'" name="koreksi[]" onkeyup=\'sum()\'></td>
                                    </tr>';
                            }                            
                            ?>
                            </tbody>
                            <tfoot>
                                <?php
                                echo '<tr>
                                        <th>Total</th>
                                        <th>Rp. '.number_format($mohon[0]->mohon,0,",",".").',-</th>
                                        <th><input type="number" value="'.$besar[0]->value.'" name="total" id="total" disabled></th>
                                    </tr>';
                                ?>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'view':
$Qedit = $this->db->query("SELECT tanggal_lpj FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();
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
        <h1 class="page-title page-title-border">Laporan Pertanggung Jawaban (LPJ)</h1>
        <form class="form-global" method="post" action="<?php echo base_url('process/admin/view/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php echo $edit[0]->tanggal_lpj ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Gambar</label>
                    <?php                    
                    $Qfoto = $this->db->query("SELECT `path`, sequence FROM proposal_lpj WHERE proposal_id='$dx' AND type='1' ORDER BY sequence ASC");

                    foreach($Qfoto->result_object() as $foto){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_foto[]" value="'.$foto->sequence.'"> Hapus</label>
                                <input type="file" name="foto[]">
                                <a class="info" target="_blank" href="'.base_url('media/proposal_lpj/'.$foto->path).'">Lihat Gambar</a>
                                <input type="hidden" name="old_foto[]" value="'.$foto->path.'">
                            </div>';
                    }
                    ?>
                    <a class="link" href="#">Tambah Gambar</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Video</label>
                    <?php                    
                    $Qfoto = $this->db->query("SELECT `path`, sequence FROM proposal_lpj WHERE proposal_id='$dx' AND type='2' ORDER BY sequence ASC");

                    foreach($Qfoto->result_object() as $foto){
                        echo '<div class="controls file">
                                <label class="control-label" style="font-weight:normal"><input type="checkbox" name="del_video[]" value="'.$foto->sequence.'"> Hapus</label>
                                <input type="text" name="video[]" value="'.$foto->path.'" placeholder="Youtube URL">
                                <input type="hidden" name="old_video[]" value="'.$foto->path.'">
                            </div>';
                    }
                    ?>
                    <a class="video" href="#">Tambah Video</a>
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />
                    <!-- <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                    <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}