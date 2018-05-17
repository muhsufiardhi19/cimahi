<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<?php
switch($tp){

case 'edit':

$Qedit = $this->db->query("SELECT time_entry, name, address, judul, latar_belakang, maksud_tujuan, file, kecamatan, kelurahan, rt, rw, kodepos FROM proposal WHERE id='$dx'"); $edit = $Qedit->result_object();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Koreksi Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?> 
        <form class="form-global" method="post" action="<?php echo base_url('process/hibah/edit2/'.$dx) ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal Kegiatan</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php $now = new DateTime(); echo $now->format('Y-m-d');?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi)</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $edit[0]->name ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea name="address" required><?php echo $edit[0]->address ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Kecamatan</label>
                    <select name="kecamatan">
                    <option value="0">-- Silahkan Pilih</option>
                    <?php
                    $Qkategori = $this->db->select("id, nama_kecamatan")->from('kecamatan')->order_by('id', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        if($edit[0]->kecamatan == $kategori->id){
                            echo '<option value="'.$kategori->id.'" selected >'.$kategori->nama_kecamatan.'</option>';
                        }else{  
                            echo '<option value="'.$kategori->id.'">'.$kategori->nama_kecamatan.'</option>';
                        }
                    }
                    ?>
                    </select>
                <div>
                    </br>
                <div class="control-group">
                    <label class="control-label" for="">Kelurahan</label>
                    <select name="kelurahan" id="kelurahan" onchange="fungsikodepos(this)">
                    <option value="0">-- Silahkan Pilih</option>
                    <?php


                    $Qkategori = $this->db->select("id, nama_kelurahan, kode_pos")->from('kelurahan')->order_by('nama_kelurahan', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        if($edit[0]->kelurahan == $kategori->kode_pos){
                            echo '<option value="'.$kategori->kode_pos.'" selected >'.$kategori->nama_kelurahan.'</option>';
                        }else{  
                            echo '<option value="'.$kategori->kode_pos.'">'.$kategori->nama_kelurahan.'</option>';
                        }
                    }
                    ?>
                    </select>
                <div>
                    </br>
                
                
                
                <div class="control-group">
                    <label class="control-label" for="">RW</label>
                    <div class="controls">
                        <input type="text" name="rw" value="<?php echo $edit[0]->rw ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">RT</label>
                    <div class="controls">
                        <input type="text" name="rt" value="<?php echo $edit[0]->rt ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Kode Pos</label>
                    <div class="controls">
                        <input type="text" name="kodepos" id="kodepos" value="<?php echo $edit[0]->kodepos ?>" readonly required>
                    </div>
                </div>
                
                <script type="text/javascript">
                function fungsikodepos(data)
                {
                
                    document.getElementById ("kodepos").value = data.value;
                    

                }
                </script>
                <div class="control-group">
                    <label class="control-label" for="">Judul Kegiatan</label>
                    <div class="controls">
                        <input type="text" name="judul" value="<?php echo $edit[0]->judul ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Latar Belakang</label>
                    <div class="controls">
                        <textarea name="latar" required><?php echo $edit[0]->latar_belakang ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Maksud dan Tujuan</label>
                    <div class="controls">
                        <textarea name="maksud" required><?php echo $edit[0]->maksud_tujuan ?></textarea>
                    </div>
                </div>
        <div class="control-group">
                    <label class="control-label" for="">Sasaran dan Penerima Manfaat</label>
                    <div class="controls">
                        <textarea name="sasaran" required><?php echo $edit[0]->maksud_tujuan ?></textarea>
                    </div>
                </div>
        <div class="control-group">
                    <label class="control-label" for="">Titik/Lokasi Kegiatan</label>
                    <div class="controls">
                        <textarea name="titik" required><?php echo $edit[0]->maksud_tujuan ?></textarea>
                    </div>
                </div>
        
                <!-- <div class="control-group">
                    <label class="control-label" for="">Deskripsi Kegiatan</label>
                    <div class="controls">
                        <textarea name="kegiatan" required></textarea>
                    </div>
                </div> -->
                

                <div class="control-group">
                    <label class="control-label" for="">Ringkasan Usulan Baru (Format PDF)</label>
                    <div class="controls file">
                        <input type="file" name="proposal" accept="application/pdf" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Total Dana Yang Disetujui</label>
                    <?php
                        $Qdetail = $this->db->query("SELECT value from verifikasi_tapd where id_proposal = '$dx'"); $detail = $Qdetail->result_object();
                        
                        echo 'Rp. '.number_format($detail[0]->value,0,",",".").',-';
                    ?>
                </div>

				<?php
					$Qawal = $this->db->query("SELECT sum(amount) as jumlah FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC"); $awal = $Qawal->result_object();
				?>
				<div class="control-group">
                    <label class="control-label" for="">Total</label>
                    <p id="total" for=""><?php echo 'Rp.'.$awal[0]->jumlah.',-';?></p>
                </div> 
                
				
                <div class="control-group">
                    <label class="control-label" for="">Daftar Rincian Dana</label>
                    <?php                    
                    $Qdana = $this->db->query("SELECT sequence, description, amount FROM proposal_dana WHERE proposal_id='$dx' ORDER BY sequence ASC");

                    foreach($Qdana->result_object() as $dana){
                        echo '<div class="controls file">
                                <input type="text" name="deskripsi[]" value="'.$dana->description.'" placeholder="Deskripsi">
                                <input id="totalan[]" type="number" name="jumlah[]" value="'.$dana->amount.'" placeholder="Jumlah" onchange="myFunction()">
                                <input type="hidden" name="dana[]" value="'.$dana->amount.'">
                            </div>';
                    }
                    ?>
                    <a id="dana" class="danas" onclick="addDana()" for="">Tambah Koreksi Dana</a>
				</div>
				
				
				 <script>
                
                    function addDana(){
                         $('.control-group').on('click', '.danas', function(event) {
                            event.preventDefault();
                            var $content = $('<div class="controls file"><input type="text" name="deskripsi[]" placeholder="Deskripsi"><input type="number" name="jumlah[]" placeholder="Jumlah" onchange="myFunction()"></div>');
                            $content.insertBefore($(this));
                        });
                    } 
                     function myFunction() {
                        var x = document.getElementsByName("jumlah[]").length;
                        // x.value = x.length;
                        var i =0;
                        var total = 0;
                        for(i = 0; i< x; i++){
                            var y = document.getElementsByName("jumlah[]")[i].value;
                            total = total + Number(y);
                            // alert(x);

                            changeFormat(total);
                    }


                    function changeFormat(total){
                    var bilangan = total;
                    var number_string = bilangan.toString(),
                        sisa    = number_string.length % 3,
                        rupiah  = number_string.substr(0, sisa),
                        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    document.getElementById("total").innerHTML = "Rp."+rupiah+",-"; 
                    //document.getElementById('koreksi').value= rupiah;
                }
                    // var x = document.getElementById("total");
                    
                }

                </script>
                <div class="control-actions clearfix">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <button class="btn-red btn-plain btn" type="submit">DAFTAR</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->

<?php
break;

default:
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Mendaftar Hibah Bansos</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?> 
        <form class="form-global" method="post" action="<?php echo base_url('process/hibah/daftar') ?>" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Tanggal Proposal</label>
                    <div class="controls">
                        <input id="datepicker-tgl" type="text" name="tanggal" value="<?php $now = new DateTime(); echo $now->format('Y-m-d');?>" >
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi untuk bansos / organisasi untuk hibah)</label>
                    <div class="controls">
                        <input type="text" name="name" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Alamat</label>
                    <div class="controls">
                        <textarea name="address" required></textarea>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="">Kecamatan</label>
                    <select name="kecamatan">
                    <option value="0">-- Silahkan Pilih</option>
                    <?php
                    $Qkategori = $this->db->select("id, nama_kecamatan")->from('kecamatan')->order_by('id', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        echo '<option value="'.$kategori->id.'">'.$kategori->nama_kecamatan.'</option>';
                    }
                    ?>
                    </select>
                <div>
                    </br>
                <div class="control-group">
                    <label class="control-label" for="">Kelurahan</label>
                    <select name="kelurahan" id="kelurahan" onchange="fungsikodepos(this)">
                    <option value="0">-- Silahkan Pilih</option>
                    <?php
                    $Qkategori = $this->db->select("id, nama_kelurahan, kode_pos")->from('kelurahan')->order_by('nama_kelurahan', 'ASC')->get();

                    foreach($Qkategori->result_object() as $kategori){
                        echo '<option value="'.$kategori->kode_pos.'">'.$kategori->nama_kelurahan.'</option>';
                    }
                    ?>
                    </select>
                <div>
                    </br>
                
                
                
                <div class="control-group">
                    <label class="control-label" for="">RW</label>
                    <div class="controls">
                        <input type="text" name="rw" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">RT</label>
                    <div class="controls">
                        <input type="text" name="rt" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Kode Pos</label>
                    <div class="controls">
                        <input type="text" name="kodepos" id="kodepos" readonly required>
                    </div>
                </div>
                
                <script type="text/javascript">
                function fungsikodepos(data)
                {
                
                    document.getElementById ("kodepos").value = data.value;
                    

                }
                </script>
                
                <div class="control-group">
                    <label class="control-label" for="">Judul Kegiatan</label>
                    <div class="controls">
                        <input type="text" name="judul" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Latar Belakang</label>
                    <div class="controls">
                        <textarea name="latar" required></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Maksud dan Tujuan</label>
                    <div class="controls">
                        <textarea name="maksud" required></textarea>
                    </div>
                </div>
        <div class="control-group">
                    <label class="control-label" for="">Sasaran Penerima Manfaat</label>
                    <div class="controls">
                        <textarea name="sasaran" required></textarea>
                    </div>
                </div>
        <div class="control-group">
                    <label class="control-label" for="">Titik / Lokasi Kegiatan</label>
                    <div class="controls">
                        <textarea name="titik" required></textarea>
                    </div>
                </div>

                <!-- <div class="control-group">
                    <label class="control-label" for="">Deskripsi Kegiatan</label>
                    <div class="controls">
                        <textarea name="kegiatan" required></textarea>
                    </div>
                </div> -->
                <div class="control-group">
                    <label class="control-label" for="">Ringkasan Usulan (Format PDF)</label>
                    <div class="controls file">
                        <input type="file" name="proposal" accept="application/pdf" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="">Dana</label>
                    <div class="controls file">
                        <input type="text" name="deskripsi[]" placeholder="Deskripsi">
                        <input type="number" name="jumlah[]" placeholder="Jumlah">
                    </div>
                    <a class="dana" href="#">Tambah Dana</a>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Logo atau Foto Profil Calon Penerima</label>
                    <div class="controls file">
                        <input type="file" name="foto[]">
                    </div>
                    <a class="link" href="#">Tambah Foto</a>
                </div>
                <div class="control-actions clearfix">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sabilulungan']['uid']; ?>">
                    <input type="hidden" name="role_id" value="<?php echo $_SESSION['sabilulungan']['role']; ?>">
                    <button class="btn-red btn-plain btn" type="submit">Daftar</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->

<?php
break;

}