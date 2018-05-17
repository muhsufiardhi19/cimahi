<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<?php
switch($tp){

case 'edit':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

$Qket = $this->db->query("SELECT value AS keterangan FROM verifikasi_tatausaha WHERE `id_proposal`='$dx'"); $ket = $Qket->result_object();

$Qedit = $this->db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='14'"); $edit = $Qedit->result_object();
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
        
        
        <form action="<?php echo base_url('process/walikota/periksaaja/'.$dx) ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title page-title-border">Pemeriksaan Walikota I</h1>
			
			<h3 style="color:#ec7404">Ringkasan Proposal</h3>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
	
                <div class="control-group">
                    <label class="control-label" for="">Update Disposisi</label>
                    <div class="controls file">
                        <input type="file" name="new_disposisi" accept="application/pdf" required="">
                    </div>
                </div>
                
            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"></textarea>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Lanjut ke Proses Kajian Pencarian" />
                <!--<input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'view':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

$Qket = $this->db->query("SELECT value AS keterangan FROM verifikasi_tatausaha WHERE `id_proposal`='$dx'"); $ket = $Qket->result_object();

$Qketerangan = $this->db->query("SELECT value AS keterangan_walikota FROM tahapan_walkot_1 WHERE id_proposal='$dx'"); $keterangan  = $Qketerangan->result_object();

$Qedit = $this->db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='14'"); $edit = $Qedit->result_object();

$Qdisposisi = $this->db->query("SELECT path FROM surat_disposisi_1 WHERE id_proposal='$dx'"); $dis = $Qdisposisi->result_object();
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
        
        
        <form action="<?php echo base_url('process/walikota/periksaaja/'.$dx) ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title page-title-border">Pemeriksaan Walikota I</h1>
			
			<h3 style="color:#ec7404">Ringkasan Proposal</h3>
            <p class="label">Nama (Individu atau Organisasi)</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
	
                <div class="control-group">
                    <label class="control-label" for="">File Exist</label>
					<p><?php if(isset($dis[0]->path)) echo '<a class="info" target="_blank" href="'.base_url('media/disposisi_baru/'.$dis[0]->path).'">Download File</a>'; else echo '-';?></p>
                </div>
				
				<div class="control-group">
                    <label class="control-label" for="">Update Disposisi</label>
                    <div class="controls file">
                        <input type="file" name="new_disposisi" accept="application/pdf" required="">
                    </div>
                </div>
                
            <h3 style="color:#ec7404">Keterangan</h3>
            <textarea rows="5" name="keterangan"><?php if(isset($keterangan[0]->keterangan_walikota)) echo $keterangan[0]->keterangan_walikota; ?></textarea>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Lanjut ke Proses Kajian Pencarian" />
                <!--<input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" /> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}