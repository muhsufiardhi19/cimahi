<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<?php
switch($tp){

case 'periksa':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

/*$Qket = $this->db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id=13"); $ket = $Qket->result_object();*/
//edit ferdi
$Qket = $this->db->query("SELECT value AS keterangan FROM pemeriksaan_tu WHERE id_proposal='$dx'"); $ket = $Qket->result_object();

$Qdisposisi = $this->db->query("SELECT path FROM proposal_disposisi WHERE id_proposal='$dx'"); $dis = $Qdisposisi->result_object();
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

        <form action="<?php echo base_url('process/pertimbangan/periksa/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi TU</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
            <h2></h2>
			<p class="label">File Disposisi</p>
			<p><?php if(isset($dis[0]->path)) echo '<a class="info" target="_blank" href="'.base_url('media/disposisi/'.$dis[0]->path).'">Download File</a>'; else echo '-';?></p>
			
		
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Kategori Hibah Bansos</h3>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $this->db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11");

                    foreach($Qskpd->result_object() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'">
                                    '.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $this->db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11,9");

                    foreach($Qskpd->result_object() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'">
                                    '.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Disposisi ke SKPD" />
                <input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" />
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'verifikasi':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, a.type_id, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

/*$Qcheck = $this->db->query("SELECT value FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id IN (17,26,27)");
$check = $Qcheck->result_object();*/

//edit ferdi
$Qcheck = $this->db->query("SELECT rekomendasi, value, keterangan FROM pemeriksaan_skpd WHERE id_proposal='$dx'");
$check = $Qcheck->result_object();

$Qcheck2 = $this->db->query("SELECT checklist_id FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id IN (15)");
$check2= $Qcheck2->result_object();

//edit 29
$Qcheck3 = $this->db->query("SELECT keputusan FROM verifikasi_pertimbangan WHERE id_proposal='$dx'");
$check3 = $Qcheck3->result_object();


$Qdisposisi = $this->db->query("SELECT path FROM proposal_disposisi WHERE id_proposal='$dx'"); $dis = $Qdisposisi->result_object();

$Qkoreksi = $this->db->query("SELECT path FROM proposal_koreksi WHERE id_proposal='$dx'"); $kor = $Qkoreksi->result_object();
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

        <form name="pertimbangan" action="<?php echo base_url('process/pertimbangan/verifikasi/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Berdasarkan Pertimbangan SKPD</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
			<p class="label">Rekomendasi Dari SKPD</p>
            <p><?php if(isset($check[0]->value)) echo 'Dapat direkomendasikan'; else echo 'Tidak dapat direkomendasikan'; ?></p>
            <p class="label">Nominal dari SKPD</p>
            <p><?php if(isset($check[0]->value)) echo 'Rp. '.number_format($check[0]->value,0,",",".").',-'; else echo '-'; ?></p>
			<p class="label">File Disposisi</p>
			<p><?php if(isset($dis[0]->path)) echo '<a class="info" target="_blank" href="'.base_url('media/disposisi/'.$dis[0]->path).'">Download File</a>'; else echo '-';?></p>
			<p class="label">Hasil Koreksi Rekomendasi Dana</p>
			<p><?php if(isset($kor[0]->path)) echo '<a class="info" target="_blank" href="'.base_url('media/proposal_koreksi/'.$kor[0]->path).'">Download File</a>'; else echo '-';?></p>
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Formulir Verifikasi</h3>
				 <div class="control-group">
                    <label class="control-label" for="">Pemberian Pertimbangan</label>
                    <div class="control-group">
                    <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="1">
                        Ya
                    </label>
                   <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="0">
                        Tidak
                    </label>
                </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Koreksi (Angka)</label>
                    <div class="controls">
                        <input type="text" id="koreksi" name="koreksi" onchange="changeFormat()" required >
                    </div>
                </div>
				<script type="text/javascript">
                function changeFormat(){
                    var bilangan = document.getElementById('koreksi').value;
                    var number_string = bilangan.toString(),
                        sisa    = number_string.length % 3,
                        rupiah  = number_string.substr(0, sisa),
                        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    document.getElementById('koreksi').value= rupiah;
                }
            </script>
				
				
                <div class="control-group">
                    <label class="control-label" for="">Keterangan</label>
                    <div class="controls">
                        <textarea rows="5" name="keterangan" required></textarea>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input <?php if(isset($check3[0]->keputusan)); ?> type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Verifikasi" />

                <?php
                //str_replace("'", "", $detail[0]->judul)
                $view = base_url('process/pdf/view/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);
                $export = base_url('process/pdf/export/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);
                ?>
				
				<input type="submit" name="tolak" class="btn-red btn-plain btn" style="display:inline" value="Ditolak" />
                <a target="_blank" <?php if(isset($check3[0]->keputusan)) echo ' href="'.$view.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Preview Formulir</a>
                <a target="_blank" <?php if(isset($check3[0]->keputusan)) echo ' href="'.$export.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Cetak Formulir</a>
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

case 'edit':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

/*$Qket = $this->db->query("SELECT value AS keterangan FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id=13"); $ket = $Qket->result_object();*/
//edit ferdi
$Qket = $this->db->query("SELECT value AS keterangan FROM pemeriksaan_tu WHERE id_proposal='$dx'"); $ket = $Qket->result_object();

/*$Qedit = $this->db->query("SELECT checklist_id, value FROM proposal_checklist WHERE `proposal_id`='$dx' AND checklist_id='31'"); $edit = $Qedit->result_object();*/


//edit ferdi
$Qedit = $this->db->query("SELECT  value FROM pemeriksaan_pertimbangan WHERE `id_proposal`='$dx'"); $edit = $Qedit->result_object();

$Qdisposisi = $this->db->query("SELECT path FROM proposal_disposisi WHERE id_proposal='$dx'"); $dis = $Qdisposisi->result_object();

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

        <form action="<?php echo base_url('process/pertimbangan/edit/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Proposal Hibah Bansos Hasil Seleksi TU</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Keterangan dari TU</p>
            <p><?php if(isset($ket[0]->keterangan)) echo $ket[0]->keterangan; else echo '-'; ?></p>
			<p class="label">File Disposisi</p>
			<p><?php if(isset($dis[0]->path)) echo '<a class="info" target="_blank" href="'.base_url('media/disposisi/'.$dis[0]->path).'">Download File</a>'; else echo '-';?></p>
            <h2></h2>
            <div class="col-wrapper clearfix">
                <h3 style="color:#ec7404">Kategori Hibah Bansos</h3>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $this->db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11");

                    foreach($Qskpd->result_object() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'"'; if($edit[0]->value==$skpd->id) echo ' checked';
                                    echo '>'.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
                <ul class="category-list col list-nostyle">
                    <?php
                    $Qskpd = $this->db->query("SELECT * FROM skpd ORDER BY id ASC LIMIT 11,11");

                    foreach($Qskpd->result_object() as $skpd){
                        echo '<li>
                                <label class="radio">
                                    <input type="radio" name="skpd" value="'.$skpd->id.'"'; if($edit[0]->value==$skpd->id) echo ' checked';
                                    echo '>'.$skpd->name.'
                                </label>
                            </li>';
                    }
                    ?>
                </ul>
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

case 'view':

$Qdetail = $this->db->query("SELECT a.name, a.judul, a.latar_belakang, a.type_id, SUM(b.amount) AS nominal FROM proposal a JOIN proposal_dana b ON b.proposal_id=a.id WHERE a.id='$dx'"); $detail = $Qdetail->result_object();

/*$Qcheck = $this->db->query("SELECT value FROM proposal_checklist WHERE proposal_id='$dx' AND checklist_id IN (17,26,27)");
$check = $Qcheck->result_object();*/

//edit ferdi
$Qcheck = $this->db->query("SELECT rekomendasi, value, keterangan FROM verifikasi_pertimbangan WHERE id_proposal='$dx'");
$check = $Qcheck->result_object();

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

        <form action="<?php echo base_url('process/pertimbangan/view/'.$dx) ?>" method="post" class="form-check form-global">
            <h1 class="page-title page-title-border">Pemeriksaan Berdasarkan Pertimbangan SKPD</h1>
            <p class="label">Nama (Individu atau Organisasi):</p>
            <p><?php echo $detail[0]->name ?></p>
            <p class="label">Judul Kegiatan:</p>
            <p><?php echo $detail[0]->judul ?></p>
            <p class="label">Deskripsi Singkat Kegiatan</p>
            <p><?php echo $detail[0]->latar_belakang ?></p>
            <p class="label">Nominal yang Diajukan di Proposal</p>
            <p><?php echo 'Rp. '.number_format($detail[0]->nominal,0,",",".").',-' ?></p>
            <p class="label">Nominal dari SKPD</p>
            <p><?php if(isset($check[0]->value)) echo 'Rp. '.number_format($check[0]->value,0,",",".").',-'; else echo '-'; ?></p>
			
            <h2></h2>
            <div class="col-wrapper clearfix">
  

                <h3 style="color:#ec7404">Formulir Verifikasi</h3>

                <div class="control-group">
                    <label class="control-label" for="">Pemberian Pertimbangan</label>
                    <div class="control-group">
                    <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="1" <?php if($check[0]->rekomendasi==1) echo 'checked';?>>
                        Ya
                    </label>
                   <label class="control-label radio-inline radio">
                        <input type="radio" name="beri" value="0" <?php if($check[0]->rekomendasi==0) echo 'checked';?>>
                        Tidak
                    </label>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Koreksi (Angka)</label>
                    <div class="controls">
                        <input id="koreksi" type="text" name="koreksi" onchange="changeFormat()" <?php if(isset($check[0]->value)) echo ' value="'.$check[0]->value.'"'; ?>>
                    </div>
                </div>

                <script type="text/javascript">
                function changeFormat(){
                    var bilangan = document.getElementById('koreksi').value;
                    var number_string = bilangan.toString(),
                        sisa    = number_string.length % 3,
                        rupiah  = number_string.substr(0, sisa),
                        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    document.getElementById('koreksi').value= rupiah;
                }
            </script>
                <div class="control-group">
                    <label class="control-label" for="">Keterangan</label>
                    <div class="controls">
                        <textarea rows="5" name="keterangan"><?php if(isset($check[0]->keterangan)) echo $check[0]->keterangan; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Simpan" />

                <?php
                //str_replace("'", "", $detail[0]->judul)
                $view = base_url('process/pdf/view/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);
                $export = base_url('process/pdf/export/'.date('d M Y').' - '.rawurlencode($detail[0]->judul).'/'.$detail[0]->type_id.'/'.$dx);
                ?>

                <!-- <a target="_blank" <?php if(isset($check[1]->value)) echo ' href="'.$view.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Preview Formulir</a>
                <a target="_blank" <?php if(isset($check[1]->value)) echo ' href="'.$export.'"'; else echo ' onclick="alert(\'Silahkan Verifikasi Formulir Terlebih Dahulu.\');"'; ?> class="btn-orange btn-plain btn" style="display:inline">Cetak Formulir</a> -->
                <a href="<?php echo site_url('report') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>
    </div>
</div>
<!-- content-main -->

<?php
break;

}