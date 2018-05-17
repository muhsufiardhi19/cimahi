<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
<div class="wrapper clearfix">
    <aside class="sidebar">
    <div class="widget-side">
        <h2>Manajemen Pengguna</h2>
        <ul class="category-list list-nostyle">            
            <li><a href="<?php echo site_url('cms/koordinator'); ?>">Koordinator</a></li>   
            <li><a href="<?php echo site_url('cms/umum'); ?>">Umum</a></li>                     
            <li><a href="<?php echo site_url('cms/aktivasi_user'); ?>">Kode Aktivasi User</a></li>                     
        </ul>
    </div>
    <!-- widget-side -->
    <div class="widget-side">
        <h2>Manajemen Konten</h2>
        <ul class="category-list list-nostyle">
            <li><a href="<?php echo site_url('cms/home'); ?>">Home</a></li>   
            <li><a href="<?php echo site_url('cms/tentang'); ?>">Tentang Sabilulungan</a></li> 
            <li><a href="<?php echo site_url('cms/peraturan'); ?>">Peraturan</a></li>
            <li><a href="<?php echo site_url('cms/cek_pulsa'); ?>">Cek Pulsa Modem</a></li>
            <li><a href="<?php echo site_url('cms/cek_berkas'); ?>">Cek Berkas</a></li>
        </ul>
    </div>
    <!-- widget-side -->
    <div class="widget-side nav-filter">
        <h2><a href="<?php echo site_url('cms/log'); ?>">Log Pengguna</a></h2>
    </div>
</aside>
<!-- sidebar -->

<?php
switch($tp){

case 'cek_pulsa':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/cek_pulsa') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Cek Pulsa</h1>


            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Cek Pulsa" />
                <a href="<?php echo site_url('cms/cek_pulsa') ?>" class="btn-grey btn-plain btn" style="display:inline">Refresh</a>
            </div>
        </form>   
		</br>
		</br>
		<table class="table-global">
			
			
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Pengirim</th>
					<th>Pesan</th>
				</tr>
			</thead>
			<?php
				
				$this->db2= $this->load->database('gammu', true);  
				
				$Qlist = $this->db2->query("SELECT ReceivingDateTime, TextDecoded, SenderNumber FROM inbox ORDER BY ReceivingDateTime DESC LIMIT 10");
				//$this->db2->insert("outbox", array('DestinationNumber' => $phone, 'TextDecoded' => "Silahkan login menggunakan akun yang telah didaftarkan, lalu masukan kode aktivasi berikut : ".$kode));
				
				if($Qlist->num_rows){
                    $i = ($p*15)-14;
                    foreach($Qlist->result_object() as $list){
                        echo '<tr>
                               
                                <td>'.$list->ReceivingDateTime.'</td>
                                <td>'.$list->SenderNumber.'</td>
                                <td>'.$list->TextDecoded.'</td>
                                
                            </tr>';
                        $i++;
                    }
                }
				$this->db2->close();
				
				/* 
				$this->db= $this->load->database('default', true); 
				$this->db->insert("user", array('name' => $name, 'email' => $email, 'address' => $address, 'phone' => $phone, 'ktp' => $ktp, 'username' => $uname, 'password' => $this->ifunction->pswd($pswd), 'role_id' => 6, 'code'=> $kode, 'kecamatan'=> $kecamatan, 'kelurahan'=> $kelurahan, 'rt'=> $rt, 'rw'=> $rw, 'kota'=> $kota)); */
							
							
			

                
			?>
			
		</table>
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'cek_berkas':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('cms/cek_berkas') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Cari Berkas</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">ID Proposal</label>
                    <div class="controls">
                        <input type="text" name="id" required>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Cari" />
            </div>
        </form>   
        </br>
        </br>
        <table class="table-global">
            
            
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th></th>
                </tr>
            </thead>
            <?php 


                $id = $_POST['id'];
                $Qlist = $this->db->query("SELECT file FROM proposal WHERE id='$id'"); $list = $Qlist->result_object();
                $Qlist1 = $this->db->query("SELECT path FROM proposal_disposisi WHERE id_proposal='$id'"); $list1 = $Qlist1->result_object();
                $Qlist2 = $this->db->query("SELECT path FROM proposal_koreksi WHERE id_proposal='$id'"); $list2 = $Qlist2->result_object();
                $Qlist3 = $this->db->query("SELECT path FROM surat_disposisi_1 WHERE id_proposal='$id'"); $list3 = $Qlist3->result_object();
                $Qlist5 = $this->db->query("SELECT path FROM surat_disposisi_2 WHERE id_proposal='$id'"); $list5 = $Qlist5->result_object();
                $Qlist4 = $this->db->query("SELECT path FROM nota_dinas WHERE id_proposal='$id'"); $list4 = $Qlist4->result_object();
                $Qlist6 = $this->db->query("SELECT path FROM dok_nphd WHERE id_proposal='$id'"); $list6 = $Qlist6->result_object();
                $Qlist7 = $this->db->query("SELECT path FROM dok_berita_acara WHERE id_proposal='$id'"); $list7 = $Qlist7->result_object();
                $Qlist8 = $this->db->query("SELECT path FROM dok_surat_pernyataan WHERE id_proposal='$id'"); $list8 = $Qlist8->result_object();
                $Qlist9 = $this->db->query("SELECT path FROM dok_pakta_integritas WHERE id_proposal='$id'"); $list9 = $Qlist9->result_object();
                $Qlist10 = $this->db->query("SELECT path FROM dok_kwitansi WHERE id_proposal='$id'"); $list10 = $Qlist10->result_object();


                 echo '<tr>
                               
                         <td>File Proposal Hibah 1</td>';
                      if(isset($list[0]->file)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal/'.$list[0]->file).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Disposisi 1</td>';
                      if(isset($list1[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/disposisi/'.$list1[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';
                
                echo '<tr>
                               
                         <td>File Hasil Koreksi Usulan Dana Calon Penerima</td>';
                      if(isset($list2[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal_koreksi/'.$list2[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Disposisi 2</td>';
                      if(isset($list3[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/disposisi_baru/'.$list3[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Nota Dinas</td>';
                      if(isset($list4[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/nota_dinas/'.$list4[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';
               
               echo '<tr>
                               
                         <td>File Disposisi 3</td>';
                      if(isset($list5[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/disposisi_dua/'.$list5[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';



                echo '<tr>
                               
                         <td>File NPHD</td>';
                      if(isset($list6[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal_pencairan/file_nphd/'.$list6[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Berita Acara</td>';
                      if(isset($list7[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal_pencairan/berita_acara'.$list7[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Surat Pernyataan</td>';
                      if(isset($list8[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal_pencairan/surat_pernyataan/'.$list8[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Pakta Itegritas</td>';
                      if(isset($list9[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal_pencairan/pakta_integritas/'.$list9[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';

                echo '<tr>
                               
                         <td>File Kwitansi</td>';
                      if(isset($list10[0]->path)) echo '<td><a class="info" target="_blank" href="'.base_url('media/proposal_pencairan/kwitansi/'.$list10[0]->path).'">Download File</a></td>'; else echo '<td>-</td>';

                echo '</tr>';
            ?>
            
        </table>
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'aktivasi_user':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('cms/aktivasi_user') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Cari Kode Aktivasi</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" required>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Cari" />
            </div>
        </form>   
		</br>
		</br>
		<table class="table-global">
			
			
			<thead>
				<tr>
					<th>Username</th>
					<th>Kode Aktivasi</th>
				</tr>
			</thead>
			<?php
				$Qlist = $this->db->query("SELECT username,code FROM user WHERE username like '%".$_POST['uname']."%' ORDER BY ID DESC LIMIT 15");

                if($Qlist->num_rows){
                    $i = ($p*15)-14;
                    foreach($Qlist->result_object() as $list){
                        echo '<tr>
                               
                                <td>'.$list->username.'</td>
                                <td>'.$list->code.'</td>
                                
                            </tr>';
                        $i++;
                    }
                }
			?>
			
		</table>
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'koordinator':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_koordinator'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Koordinator</h1>

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $this->db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $this->db->query("SELECT a.id, a.name, b.name AS role, a.is_active FROM user a JOIN role b ON b.id=a.role_id WHERE a.role_id!='6' ORDER BY a.role_id ASC LIMIT $position,$limit");

                if($Qlist->num_rows){
                    $i = ($p*15)-14;
                    foreach($Qlist->result_object() as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->name.'</td>
                                <td>'.$list->role.'</td>
                                <td style="text-align: center;">'; if($list->is_active==1) echo 'Aktif'; else echo 'Tidak Aktif'; echo '</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_koordinator/'.$list->id).'">Edit</a> | <a href="'.base_url('process/cms/delete_koordinator/'.$list->id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Koordinator ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $this->db->query("SELECT a.name, b.name AS role, a.is_active FROM user a JOIN role b ON b.id=a.role_id WHERE a.role_id!='6'");

        $num_page = ceil($Qpaging->num_rows / $limit);
        if($Qpaging->num_rows > $limit){
            $this->ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, $Qpaging->num_rows, 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_koordinator':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/add_koordinator') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Tambah Koordinator</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Role</label>
                    <div class="controls">
                        <select name="role" onchange="dochange('role', this.value)">
                        <option value="0">-- Silahkan Pilih</option>
                        <?php
                        $Qkategori = $this->db->select("id, name")->from('role')->where('id !=', 6)->order_by('id', 'ASC')->get();

                        foreach($Qkategori->result_object() as $kategori){
                            echo '<option value="'.$kategori->id.'">'.$kategori->name.'</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="control-group" id="role"></div>

                <div class="control-group">
                    <label class="control-label" for="">Nama</label>
                    <div class="controls">
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" checked> Ya</label> &nbsp <label><input type="radio" name="status" value="0"> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/koordinator') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_koordinator':

$Qedit = $this->db->query("SELECT role_id, name, username, skpd_id, is_active FROM user WHERE `id`='$p'"); $edit = $Qedit->result_object();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/edit_koordinator/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Edit Koordinator</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Role</label>
                    <div class="controls">
                        <select name="role" onchange="dochange('role', this.value)">
                        <option value="0">-- Silahkan Pilih</option>
                        <?php
                        $Qkategori = $this->db->select("id, name")->from('role')->where('id !=', 6)->order_by('id', 'ASC')->get();

                        foreach($Qkategori->result_object() as $kategori){
                            echo '<option value="'.$kategori->id.'"'; if($edit[0]->role_id==$kategori->id) echo ' selected'; echo '>'.$kategori->name.'</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="control-group" id="role">
                <?php
                if($edit[0]->skpd_id){
                    echo '<label class="control-label" for="">SKPD</label>
                            <div class="controls">
                                <select name="skpd">
                                <option value="0">-- Silahkan Pilih</option>';

                                $Qkategori = $this->db->select("id, name")->from('skpd')->order_by('id', 'ASC')->get();

                                foreach($Qkategori->result_object() as $kategori){
                                    echo '<option value="'.$kategori->id.'"'; if($edit[0]->skpd_id==$kategori->id) echo ' selected'; echo '>'.$kategori->name.'</option>';
                                }

                                echo '</select>
                            </div>';
                }
                ?>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Nama</label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $edit[0]->name ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" value="<?php echo $edit[0]->username ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" <?php if($edit[0]->is_active==1) echo ' checked'; ?>> Ya</label> &nbsp <label><input type="radio" name="status" value="0" <?php if($edit[0]->is_active==0) echo ' checked'; ?>> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/koordinator') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'umum':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_umum'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Umum</h1>

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $this->db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $this->db->query("SELECT id, name, email, is_active FROM user WHERE role_id='6' ORDER BY id DESC LIMIT $position,$limit");

                if($Qlist->num_rows){
                    $i = ($p*15)-14;
                    foreach($Qlist->result_object() as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->name.'</td>
                                <td>'.$list->email.'</td>
                                <td style="text-align: center;">'; if($list->is_active==1) echo 'Aktif'; else echo 'Tidak Aktif'; echo '</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_umum/'.$list->id).'">Edit</a> | <a href="'.base_url('process/cms/delete_umum/'.$list->id).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Pengguna ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $this->db->query("SELECT id, name, email, is_active FROM user WHERE role_id='6'");

        $num_page = ceil($Qpaging->num_rows / $limit);
        if($Qpaging->num_rows > $limit){
            $this->ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, $Qpaging->num_rows, 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_umum':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/add_umum') ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Tambah Pengguna Umum</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nama (individu atau organisasi)</label>
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
                    <label class="control-label" for="">Nomor Telepon</label>
                    <div class="controls">
                        <input type="text" name="phone" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor KTP</label>
                    <div class="controls">
                        <input type="text" name="ktp" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="email" name="email" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" checked=""> Ya</label> &nbsp <label><input type="radio" name="status" value="0"> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/umum') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_umum':

$Qedit = $this->db->query("SELECT name, email, address, phone, ktp, username, is_active FROM user WHERE `id`='$p'"); $edit = $Qedit->result_object();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/edit_umum/'.$p) ?>" method="post" class="form-check form-global">
            <h1 class="page-title">Edit Pengguna Umum</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Username</label>
                    <div class="controls">
                        <input type="text" name="uname" value="<?php echo $edit[0]->username ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Password</label>
                    <div class="controls">
                        <input type="password" name="pswd">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Ulangi Password</label>
                    <div class="controls">
                        <input type="password" name="repswd">
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
                    <label class="control-label" for="">Nomor Telepon</label>
                    <div class="controls">
                        <input type="text" name="phone" value="<?php echo $edit[0]->phone ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor KTP</label>
                    <div class="controls">
                        <input type="text" name="ktp" value="<?php echo $edit[0]->ktp ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="email" name="email" value="<?php echo $edit[0]->email ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Status</label>
                    <div class="controls">
                        <label><input type="radio" name="status" value="1" <?php if($edit[0]->is_active==1) echo ' checked'; ?>> Ya</label> &nbsp <label><input type="radio" name="status" value="0" <?php if($edit[0]->is_active==0) echo ' checked'; ?>> Tidak</label>
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/umum') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'home':

$Qedit = $this->db->query("SELECT content, sequence FROM cms WHERE `page_id`='home' ORDER BY sequence ASC"); $edit = $Qedit->result_object();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/home') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Home</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Gambar 1</label>
                    <div class="controls file">
                        <input type="file" name="image1">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[0]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence1" value="<?php echo $edit[0]->sequence ?>">
                        <input type="hidden" name="old_image1" value="<?php echo $edit[0]->content ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Gambar 2</label>
                    <div class="controls file">
                        <input type="file" name="image2">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[1]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence2" value="<?php echo $edit[1]->sequence ?>">
                        <input type="hidden" name="old_image2" value="<?php echo $edit[1]->content ?>">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'tentang':

$Qedit = $this->db->query("SELECT content, sequence, type FROM cms WHERE `page_id`='tentang' ORDER BY sequence ASC"); $edit = $Qedit->result_object();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/tentang') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Tentang Sabilulungan</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Konten</label>
                    <div class="controls file">
                        <textarea id="editor" style="width:100%;height:450px" name="content"><?php echo $edit[0]->content ?></textarea>
                        <input type="hidden" name="sequence0" value="<?php echo $edit[0]->sequence ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Gambar 1</label>
                    <div class="controls file">
                        <input type="file" name="image1">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[1]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence1" value="<?php echo $edit[1]->sequence ?>">
                        <input type="hidden" name="old_image1" value="<?php echo $edit[1]->content ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">Gambar 2</label>
                    <div class="controls file">
                        <input type="file" name="image2">
                        <a class="info" target="_blank" href="<?php echo base_url('media/cms/'.$edit[2]->content) ?>">Lihat Gambar</a>
                        <input type="hidden" name="sequence2" value="<?php echo $edit[2]->sequence ?>">
                        <input type="hidden" name="old_image2" value="<?php echo $edit[2]->content ?>">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'peraturan':
?>

<div class="primary">            
    <ul class="nav-project list-nostyle clearfix">
        <li class="active">
            <a class="btn" href="<?php echo site_url('cms/add_peraturan'); ?>">+ Tambah</a>
        </li>
    </ul>

    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <h1 class="page-title">Peraturan</h1>

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $this->db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $this->db->query("SELECT sequence, title FROM cms WHERE page_id='peraturan' ORDER BY sequence ASC LIMIT $position,$limit");

                if($Qlist->num_rows){
                    $i = ($p*15)-14;
                    foreach($Qlist->result_object() as $list){
                        echo '<tr>
                                <td style="text-align: center;">'.$i.'</td>
                                <td>'.$list->title.'</td>
                                <td style="text-align: center;"><a href="'.site_url('cms/edit_peraturan/'.$list->sequence).'">Edit</a> | <a href="'.base_url('process/cms/delete_peraturan/'.$list->sequence).'" onclick="return confirm(\'Apakah Anda yakin akan menghapus Peraturan ini ?\');">Hapus</a></td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $this->db->query("SELECT page_id, title FROM cms WHERE page_id='peraturan'");

        $num_page = ceil($Qpaging->num_rows / $limit);
        if($Qpaging->num_rows > $limit){
            $this->ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, $Qpaging->num_rows, 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'add_peraturan':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/add_peraturan') ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Tambah Peraturan</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Judul</label>
                    <div class="controls">
                        <input type="text" name="title">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">File</label>
                    <div class="controls file">
                        <input type="file" name="file">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Tambah" />
                <a href="<?php echo site_url('cms/peraturan') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'edit_peraturan':

$Qedit = $this->db->query("SELECT title, content FROM cms WHERE `sequence`='$p' AND page_id='peraturan'"); $edit = $Qedit->result_object();
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>

        <form action="<?php echo base_url('process/cms/edit_peraturan/'.$p) ?>" method="post" class="form-check form-global" enctype="multipart/form-data">
            <h1 class="page-title">Edit Peraturan</h1>

            <div class="col-wrapper clearfix">
                <div class="control-group">
                    <label class="control-label" for="">Judul</label>
                    <div class="controls">
                        <input type="text" name="title" value="<?php echo $edit[0]->title ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="">File</label>
                    <div class="controls file">
                        <input type="file" name="file">
                        <a class="info" target="_blank" href="<?php echo base_url('media/peraturan/'.$edit[0]->content) ?>">Lihat File</a>
                        <input type="hidden" name="sequence" value="<?php echo $p ?>">
                        <input type="hidden" name="old_file" value="<?php echo $edit[0]->content ?>">
                    </div>
                </div>
            </div>

            <div class="control-actions">
                <input type="submit" name="lanjut" class="btn-red btn-plain btn" style="display:inline" value="Edit" />
                <a href="<?php echo site_url('cms/peraturan') ?>" class="btn-grey btn-plain btn" style="display:inline">Kembali</a>
            </div>
        </form>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

case 'log':
?>

<div class="primary">
    <div class="project-detail-wrapper">
        <h1 class="page-title">Log Pengguna</h1>

        <?php   
        $limit = 15;
        $p = $p ? $p : 1;
        $position = ($p -1) * $limit;
        $this->db->_protect_identifiers=false;
        ?>

        <table class="table-global">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Aktifitas</th>
                    <th>Alamat IP</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Qlist = $this->db->query("SELECT a.activity, a.ip, a.time_entry, b.name FROM log a JOIN user b ON b.id=a.user_id ORDER BY time_entry ASC LIMIT $position,$limit");

                if($Qlist->num_rows){                  
                    $i = ($p*15)-14;
                    foreach($Qlist->result_object() as $list){
                        switch ($list->activity) {
                            case 'login': $aktifitas = 'Login Manajemen Sistem'; break;
                            case 'register': $aktifitas = 'Mendaftar Sebagai Pengguna'; break;
                            case 'daftar_hibah': $aktifitas = 'Mendaftar Hibah atau Bansos'; break;
                            case 'edit_hibah': $aktifitas = 'Mengedit Hibah atau Bansos'; break;
                            case 'add_koordinator': $aktifitas = 'Menambah Koordinator'; break;
                            case 'edit_koordinator': $aktifitas = 'Mengedit Koordinator'; break;
                            case 'delete_koordinator': $aktifitas = 'Menghapus Koordinator'; break;
                            case 'add_umum': $aktifitas = 'Menambah Pengguna Umum'; break;
                            case 'edit_umum': $aktifitas = 'Mengedit Pengguna Umum'; break;
                            case 'delete_umum': $aktifitas = 'Menghapus Pengguna Umum'; break;
                            case 'home': $aktifitas = 'Mengedit Halaman Home'; break;
                            case 'tentang': $aktifitas = 'Mengedit Halaman Tentang Sabilulungan'; break;
                            case 'add_peraturan': $aktifitas = 'Menambah Peraturan'; break;
                            case 'edit_peraturan': $aktifitas = 'Mengedit Peraturan'; break;
                            case 'delete_peraturan': $aktifitas = 'Menghapus Peraturan'; break;
                            case 'add_nphd': $aktifitas = 'Menambah NPHD'; break;
                            case 'edit_nphd': $aktifitas = 'Mengedit NPHD'; break;
                            case 'add_lpj': $aktifitas = 'Menambah LPJ'; break;
                            case 'edit_lpj': $aktifitas = 'Mengedit LPJ'; break;
                            case 'edit_detail': $aktifitas = 'Mengedit Detail Hibah atau Bansos'; break;
                            case 'tu_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'tu_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'walikota_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'walikota_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'walikota_setuju': $aktifitas = 'Penyetujuan Walikota'; break;
                            case 'walikota_setuju_edit': $aktifitas = 'Edit Penyetujuan Walikota'; break;
                            case 'pertimbangan_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'pertimbangan_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'pertimbangan_verifikasi': $aktifitas = 'Verifikasi Hibah atau Bansos'; break;
                            case 'pertimbangan_verifikasi_edit': $aktifitas = 'Edit Verifikasi Hibah atau Bansos'; break;
                            case 'skpd_periksa': $aktifitas = 'Pemeriksaan Hibah atau Bansos'; break;
                            case 'skpd_periksa_edit': $aktifitas = 'Edit Pemeriksaan Hibah atau Bansos'; break;
                            case 'tapd_verifikasi': $aktifitas = 'Verifikasi Hibah atau Bansos'; break;
                            case 'tapd_verifikasi_edit': $aktifitas = 'Edit Verifikasi Hibah atau Bansos'; break;
                            case 'report': $aktifitas = 'Cetak Formulir Hibah atau Bansos'; break;
                            case 'generate_dnc': $aktifitas = 'Cetak Generate DNC PBH'; break;
                            case 'logout': $aktifitas = 'Logout Manajemen Sistem'; break;
                        }

                        echo '<tr>
                                <td>'.$list->name.'</td>
                                <td>'.$aktifitas.'</td>
                                <td style="text-align:center">'.$list->ip.'</td>
                                <td style="text-align:center">'.date('M d, Y. g:i A', strtotime($list->time_entry)).'</td>
                            </tr>';
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>   

        <?php
        $Qpaging = $this->db->query("SELECT a.activity, a.ip, a.time_entry, b.name AS user FROM log a JOIN user b ON b.id=a.user_id");

        $num_page = ceil($Qpaging->num_rows / $limit);
        if($Qpaging->num_rows > $limit){
            $this->ifunction->paging($p, site_url('cms').'/'.$tp.'/', $num_page, $Qpaging->num_rows, 'href', false);
        }
        ?>             
    </div>
    <!-- project-detail-wrapper -->
</div>
<!-- primary -->

<?php
break;

}
?>

</div>
<!-- wrapper -->
</div>
<!-- content-main -->