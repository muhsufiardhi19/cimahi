<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<?php
switch($tp){

case 'nphd':

$Qdana = $this->db->query("SELECT amount, description FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->result_object();

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.value) AS nominal FROM proposal a JOIN verifikasi_tapd b ON b.id_proposal=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

$Qedit = $this->db->query("SELECT time_entry, type_id FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();

$Qcheck = $this->db->query("SELECT rekomendasi, value, keterangan FROM verifikasi_pertimbangan WHERE id_proposal='$dx'"); $check = $Qcheck->result_object();

$Qproposal = $this->db->query("SELECT file FROM proposal WHERE id='$dx'"); $proposal = $Qproposal->result_object();

$Qketerangan = $this->db->query("SELECT value AS keterangan FROM verifikasi_walikota WHERE id_proposal='$dx'"); $keterangan  = $Qketerangan->result_object();

//$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

?>

<!-- edited sufi -->
<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <h1 class="page-title page-title-border">Pemeriksaan Proposal TU</h1>
        <form class="form-global" method="post" action="<?php echo base_url('process/admin/nphd2/'.$dx) ?>" onsubmit="return check(<?php if(isset($besar[0]->value)) echo $besar[0]->value; else echo '0'; ?>)" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
		
            <ul class="category-list list-nostyle">
                <li>
                    <h3 style="color:#ec7404">Kategori</h3>
                </li>
                <li>
					<div class="control-group">
                    <label class="control-label" for="">Tanggal Masuk Proposal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php $now = new DateTime(); echo $now->format('Y-m-d');?>" required>
                    </div>
					</div>
                    <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <select name="proposal_type">
                    
                    <?php
                    $Qkategori = $this->db->select("id, name")->from('proposal_type')->order_by('id', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        if($edit[0]->type_id == $kategori->id){
                            echo '<option value="'.$kategori->id.'" selected >'.$kategori->name.'</option>';
                        }else{  
                            echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                        }
                    }
                    ?>
                    </select>
					<div>
                </li>
				
				<?php

                //edit April
                $Qlist1 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 1)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist1->result_object() as $list1){
                    
					
					if($list1->id == 1){
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
					}
				
                }
				
				$Qlist2 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 2)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist2->result_object() as $list2){
                    
					
					if($list2->id == 23){
						echo '<li>
                            <label class="checkbox" id="id'.$list2->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list2->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
					}
				
                }
				
                ?>
				
			
			<h3 style="color:#ec7404">Ringkasan Proposal</h3>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal Terbaru yang Diajukan di Proposal</p>
			<p><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-' ?></p>
			<p class="label">Keterangan Dari Walikota</p>
            <p><?php if(isset($keterangan[0]->keterangan)) echo $keterangan[0]->keterangan; else echo '-'; ?></p>
			
			<h3 style="color:#ec7404">Proposal Download</h3>
            <!-- DOWNLOAD DISINI -->	
                <div class="control-group">
				<p><?php if(isset($proposal[0]->file)) echo '<a class="info" target="_blank" href="'.base_url('media/proposal/'.$proposal[0]->file).'">Download File</a>'; else echo '-';?></p>
				</div>
			<!-- -->    
			<h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan" required></textarea>	
				
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Diteruskan ke Walikota" />
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

$Qdana = $this->db->query("SELECT amount, description FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->result_object();

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.value) AS nominal FROM proposal a JOIN verifikasi_tapd b ON b.id_proposal=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

$Qedit = $this->db->query("SELECT time_entry, type_id FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();

$Qcheck = $this->db->query("SELECT rekomendasi, value, keterangan FROM verifikasi_pertimbangan WHERE id_proposal='$dx'"); $check = $Qcheck->result_object();

$Qproposal = $this->db->query("SELECT file FROM proposal WHERE id='$dx'"); $proposal = $Qproposal->result_object();

$Qketerangan = $this->db->query("SELECT value AS keterangan FROM verifikasi_walikota WHERE id_proposal='$dx'"); $keterangan  = $Qketerangan->result_object();

$Qketerangan2 = $this->db->query("SELECT value AS keterangan2 FROM verifikasi_tatausaha WHERE id_proposal='$dx'"); $keterangan2  = $Qketerangan2->result_object();

//$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

?>

<!-- edited sufi -->
<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <h1 class="page-title page-title-border">Pemeriksaan Proposal TU SuperAdmin</h1>
        <form class="form-global" method="post" action="<?php echo base_url('process/admin/nphd2/'.$dx) ?>" onsubmit="return check(<?php if(isset($besar[0]->value)) echo $besar[0]->value; else echo '0'; ?>)" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
		
            <ul class="category-list list-nostyle">
                <li>
                    <h3 style="color:#ec7404">Kategori</h3>
                </li>
                <li>
					<div class="control-group">
                    <label class="control-label" for="">Tanggal Masuk Proposal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php $now = new DateTime(); echo $now->format('Y-m-d');?>" required>
                    </div>
					</div>
                    <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <select name="proposal_type">
                    
                    <?php
                    $Qkategori = $this->db->select("id, name")->from('proposal_type')->order_by('id', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        if($edit[0]->type_id == $kategori->id){
                            echo '<option value="'.$kategori->id.'" selected >'.$kategori->name.'</option>';
                        }else{  
                            echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                        }
                    }
                    ?>
                    </select>
					<div>
                </li>
				
				<?php

                //edit April
                $Qlist1 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 1)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist1->result_object() as $list1){
                    //<label class="checkbox" id="id'.$list2->id.'">
					
					if($list1->id == 1){
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
					}
				
                }
				
				$Qlist2 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 2)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist2->result_object() as $list2){
                    
					
					if($list2->id == 23){
						echo '<li>
                            <label class="checkbox" id="id'.$list2->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list2->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
					}
				
                }
				
                ?>
				<?php

                //edit Mei
               $Qlist1 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 3)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist1->result_object() as $list1){
                    //<label class="checkbox" id="id'.$list2->id.'">
					
					if($list1->id == 23){
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
					}
				
                }
				
                ?>
			
			<h3 style="color:#ec7404">Ringkasan Proposal</h3>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal Terbaru yang Diajukan di Proposal</p>
			<p><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-' ?></p>
			<p class="label">Keterangan Dari Walikota</p>
            <p><?php if(isset($keterangan[0]->keterangan)) echo $keterangan[0]->keterangan; else echo '-'; ?></p>
			
			<h3 style="color:#ec7404">Proposal Download</h3>
            <!-- DOWNLOAD DISINI -->	
                <div class="control-group">
				<p><?php if(isset($proposal[0]->file)) echo '<a class="info" target="_blank" href="'.base_url('media/proposal/'.$proposal[0]->file).'">Download File</a>'; else echo '-';?></p>
				</div>
			<!-- -->    
			<h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan" ><?php if(isset($keterangan2[0]->keterangan2)) echo $keterangan2[0]->keterangan2; ?></textarea>	
				
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Diteruskan ke Walikota" />
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
$Qdana = $this->db->query("SELECT amount, description FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

$Qmohon = $this->db->query("SELECT SUM(amount) AS mohon FROM proposal_dana WHERE `proposal_id`='$dx'"); $mohon = $Qmohon->result_object();

$Qbesar = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='28'"); $besar = $Qbesar->result_object();

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.value) AS nominal FROM proposal a JOIN verifikasi_tapd b ON b.id_proposal=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

$Qedit = $this->db->query("SELECT time_entry, type_id FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();

$Qcheck = $this->db->query("SELECT rekomendasi, value, keterangan FROM verifikasi_pertimbangan WHERE id_proposal='$dx'"); $check = $Qcheck->result_object();

$Qproposal = $this->db->query("SELECT file FROM proposal WHERE id='$dx'"); $proposal = $Qproposal->result_object();

$Qketerangan = $this->db->query("SELECT value AS keterangan FROM verifikasi_walikota WHERE id_proposal='$dx'"); $keterangan  = $Qketerangan->result_object();

//$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

?>

<!-- edited sufi -->
<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <!-- <h1 class="page-title page-title-border">Detail Pemeriksaan Proposal Hibah Bansos Masuk</h1> -->
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <h1 class="page-title page-title-border">Pemeriksaan Proposal TU</h1>
        <form class="form-global" method="post" action="<?php echo base_url('process/admin/nphd2/'.$dx) ?>" onsubmit="return check(<?php if(isset($besar[0]->value)) echo $besar[0]->value; else echo '0'; ?>)" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
		
            <ul class="category-list list-nostyle">
                <li>
                    <h3 style="color:#ec7404">Kategori</h3>
                </li>
                <li>
					<div class="control-group">
                    <label class="control-label" for="">Tanggal Masuk Proposal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php $now = new DateTime(); echo $now->format('Y-m-d');?>" required>
                    </div>
					</div>
                    <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <select name="proposal_type">
                    
                    <?php
                    $Qkategori = $this->db->select("id, name")->from('proposal_type')->order_by('id', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        if($edit[0]->type_id == $kategori->id){
                            echo '<option value="'.$kategori->id.'" selected >'.$kategori->name.'</option>';
                        }else{  
                            echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                        }
                    }
                    ?>
                    </select>
					<div>
                </li>
				
				<?php

                //edit April
                $Qlist1 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 1)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist1->result_object() as $list1){
                    //<label class="checkbox" id="id'.$list2->id.'">
					
					if($list1->id == 1){
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
					}
				
                }
				
				$Qlist2 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 2)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist2->result_object() as $list2){
                    
					
					if($list2->id == 23){
						echo '<li>
                            <label class="checkbox" id="id'.$list2->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list2->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list2->id.'">
                                '.$list2->name.'
                            </label>
                        </li>';
					}
				
                }
				
                ?>
				<?php

                //edit Mei
               $Qlist1 = $this->db->select("id, name")->from('v_tatausaha')->where('part', 3)->order_by('sequence', 'ASC')->get();
				
                foreach($Qlist1->result_object() as $list1){
                    //<label class="checkbox" id="id'.$list2->id.'">
					
					if($list1->id == 23){
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
						
					}else{
						echo '<li>
                            <label class="checkbox" id="id'.$list1->id.'" style="display:none" >
                                <input type="checkbox" name="kelengkapan[]" value="'.$list1->id.'">
                                '.$list1->name.'
                            </label>
                        </li>';
					}
				
                }
				
                ?>
			
			<h3 style="color:#ec7404">Ringkasan Proposal</h3>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal Terbaru yang Diajukan di Proposal</p>
			<p><?php echo 'Rp. '.number_format($mohon[0]->mohon,0,",",".").',-' ?></p>
			<p class="label">Keterangan Dari Walikota</p>
            <p><?php if(isset($keterangan[0]->keterangan)) echo $keterangan[0]->keterangan; else echo '-'; ?></p>
			
			<h3 style="color:#ec7404">Proposal Download</h3>
            <!-- DOWNLOAD DISINI -->	
                <div class="control-group">
				<p><?php if(isset($proposal[0]->file)) echo '<a class="info" target="_blank" href="'.base_url('media/proposal/'.$proposal[0]->file).'">Download File</a>'; else echo '-';?></p>
				</div>
			<!-- -->    
			<h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"></textarea>	
				
                </div>
                <div class="control-actions">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Diteruskan ke Walikota" />
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