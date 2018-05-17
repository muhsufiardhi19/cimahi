<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper clearfix">
		<?php
		if(isset($_SESSION['notify'])){
			echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
			unset($_SESSION['notify']);
		}            
		?> 
        <div class="primary">
            <ul class="nav-project list-nostyle clearfix">
               
                <?php
                if(isset($_SESSION['sabilulungan'])){
                    if($_SESSION['sabilulungan']['role']==6 || $_SESSION['sabilulungan']['role']==7) 
                        echo '<li>
                            <a class="btn" href="'.site_url('proposal_user/0/0/0/0/'.$_SESSION['sabilulungan']['uid']).'">Proposal Saya</a>
                        </li>';
                    }
                ?>
            </ul>
			<ul>
				<div class="col-wrapper clearfix">
					<h3 style="color:#ec7404">Keterangan Status</h3>
					<div>
						<p>
						 1. Pemeriksaan Tatausaha</br>
						 2. Pemeriksaan Walikota</br>
						 3. Pemeriksaan Tim Pertimbangan</br>
						 4. Pemeriksaan SKPD</br>
						 5. Verifikasi Tim Pertimbangan</br>
						 6. Verifikasi TAPD</br>
						 7. Walikota</br>
						 8. Pemeriksaan Proposal TU</br>
						 9. Persetujuan Walikota Tahap I</br> 
						10. Kajian Pencairan</br>
						11. Persetujuan Walikota Tahap II</br>
						12. Pencairan</br>
						</p>
						
					</div>
				</div>
			</ul>
			
            <ul class="project-list-wrapper list-nostyle clearfix">
                <?php
                $limit = 26;
                $p = $p ? $p : 1;
                $position = ($p -1) * $limit;
                $this->db->_protect_identifiers=false;

                $where = ''; $order = 'ORDER BY a.id DESC';
                if($t != 0) $where = 'WHERE a.skpd_id='.$t;
                elseif($tp != 0) $where = 'WHERE a.current_stat='.$tp;
                elseif($d != 0){
                    if($d==1) $order = 'ORDER BY a.id DESC';
                    elseif($d==2) $order = 'ORDER BY mohon DESC';
                }
                elseif($dx != 0) $where = 'WHERE YEAR(a.time_entry)='.$dx;
                elseif($id != 0) $where = 'WHERE a.user_id='.$id;
                elseif(isset($_POST['search'])){
                    $keyword = $_POST['keyword'];
                    $where = "WHERE a.judul LIKE '%$keyword%'";
                }

                $Qlist = $this->db->query("SELECT a.id, a.name AS oleh, a.user, a.judul, a.latar_belakang, a.current_stat, a.time_entry, b.name, b.role_id, c.name AS skpd, SUM(d.amount) AS mohon, e.name AS tahap
                                        FROM proposal a
                                        LEFT JOIN user b ON b.id=a.user_id
                                        LEFT JOIN skpd c ON c.id=a.skpd_id
                                        LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                        LEFT JOIN flow e ON e.id=a.current_stat
                                        $where
                                        GROUP BY a.id $order LIMIT $position,$limit");

                if($Qlist->num_rows){
                    $i = 0; $role = array(5, 7, 8);
                    foreach($Qlist->result_object() as $list){
                        $Qimage = $this->db->query("SELECT `path` FROM proposal_photo WHERE `proposal_id`='$list->id' ORDER BY sequence ASC LIMIT 1"); $image = $Qimage->result_object();

                        $Qproses = $this->db->query("SELECT `action`  FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id ASC"); $proses = $Qproses->result_object();

                        $Qnilai = $this->db->query("SELECT value FROM proposal_checklist WHERE `proposal_id`='$list->id' AND checklist_id='28'"); $nilai = $Qnilai->result_object();

                        //$Qtahap = $this->db->query("SELECT `flow_id` FROM proposal_approval WHERE `proposal_id`='$list->id' ORDER BY flow_id DESC LIMIT 1"); $tahap = $Qtahap->result_object();

                        $konten = strip_tags($list->latar_belakang); $konten = substr($konten, 0, 150); $length = strlen($konten);
                       
                        echo '<li class="clearfix" id="'.$i.'">
                                <div class="project-list-image">
                                    <img src="'.base_url('media/proposal_foto/'.$image[0]->path).'">
                                </div>
                                <div class="project-list-text">
                                    <ul class="project-list-progress list-nostyle clearfix">
                                        <li class="step-1 '; if(isset($proses[0])==1) echo 'done'; elseif(isset($proses[0])==2) echo 'failed'; echo '">1</li>
                                        <li class="step-2 '; if(isset($proses[1])==1) echo 'done'; elseif(isset($proses[1])==2) echo 'failed'; echo '">2</li>
                                        <li class="step-3 '; if(isset($proses[2])==1) echo 'done'; elseif(isset($proses[2])==2) echo 'failed'; echo '">3</li>
                                        <li class="step-4 '; if(isset($proses[3])==1) echo 'done'; elseif(isset($proses[3])==2) echo 'failed'; echo '">4</li>
                                        <li class="step-5 '; if(isset($proses[4])==1) echo 'done'; elseif(isset($proses[4])==2) echo 'failed'; echo '">5</li>
                                        <li class="step-6 '; if(isset($proses[5])==1) echo 'done'; elseif(isset($proses[5])==2) echo 'failed'; echo '">6</li>
                                    </ul>
                                    <ul class="project-list-progress list-nostyle clearfix">
                                        <li class="step-7 '; if(isset($proses[6])==1) echo 'done'; elseif(isset($proses[6])==2) echo 'failed'; echo '">7</li>
                                        <li class="step-8 '; if($proses[7]->action==1) echo 'done'; elseif($proses[7]->action==2) echo 'failed'; echo '">8</li>
                                        <li class="step-7 '; if($proses[8]->action==1) echo 'done'; elseif($proses[8]->action==2) echo 'failed'; echo '">9</li>
                                        <li class="step-6 '; if($proses[9]->action==1) echo 'done'; elseif($proses[9]->action==2) echo 'failed'; echo '">10</li>
                                        <li class="step-5 '; if($proses[10]->action==1) echo 'done'; elseif($proses[10]->action==2) echo 'failed'; echo '">11</li>
                                        <li class="step-4 '; if($list->current_stat==12) echo 'done'; elseif($list->current_stat==12) echo 'failed'; echo '">12</li>
                                        
                                    </ul>
                                    <h3><a href="'.site_url('detail/'.$list->id).'">'.$list->judul.'</a></h3>
                                    <p class="author"><span class="label">Tanggal Daftar:</span> '.date('M d, Y', strtotime($list->time_entry)).'</p>
                                    <p class="author"><span class="label">Oleh:</span> ';
                                    if(isset($list->user)) echo $list->user;
                                    elseif(in_array($list->role_id, $role)) echo $list->oleh;
                                    else echo $list->name;
                                    echo '</p>
                                    <p class="status"><span class="label">Tahapan:</span> ';
                                    if(isset($list->tahap)) echo $list->tahap; else echo 'Proyek Terdaftar';
                                    // if(isset($tahap[0]->flow_id)){
                                    //     switch ($tahap[0]->flow_id) {
                                    //         case '1': echo 'Proses Seleksi'; break;
                                    //         case '2': echo 'Proses Seleksi'; break;
                                    //         case '3': echo 'Proses Seleksi'; break;
                                    //         case '4': echo 'Proses Seleksi'; break;
                                    //         case '5': echo 'Proyek Disetujui'; break;
                                    //         case '6': echo 'Proyek Disetujui'; break;
                                    //         case '7': echo 'Proyek Berjalan'; break;
                                    //     }
                                    // }else echo 'Proyek Terdaftar';
                                    echo '</p>
                                    <p class="category"><span class="label">Kategori:</span> '; if($list->skpd) echo $list->skpd; else echo '-'; echo '</p>
                                    <p>'.$konten; if($length >= 150) echo '...'; echo '</p>
                                    <p class="author"><span class="label">Nilai yang Diajukan:</span> Rp. '.number_format($list->mohon,0,",",".").',-</p>
                                    <p class="status"><span class="label">Nilai yang Disetujui:</span> '; if(isset($nilai[0]->value)) echo 'Rp. '.number_format($nilai[0]->value,0,",",".").',-'; else echo '-'; echo '</p>
                                </div>
                            </li>'; 

                        $i++;

                        if($i==2){
                            echo '</ul><ul class="project-list-wrapper list-nostyle clearfix">';
                            $i = 0;
                        }
                    }                    
                }
                ?>
            </ul>
            <!-- project-list-wrapper -->
            <?php
            $Qpaging = $this->db->query("SELECT a.id, a.user, a.judul, a.latar_belakang, a.current_stat, b.name, c.name AS skpd, SUM(d.amount) AS mohon, e.name AS tahap
                                        FROM proposal a
                                        LEFT JOIN user b ON b.id=a.user_id
                                        LEFT JOIN skpd c ON c.id=a.skpd_id
                                        LEFT JOIN proposal_dana d ON d.proposal_id=a.id
                                        LEFT JOIN flow e ON e.id=a.current_stat
                                        $where
                                        GROUP BY a.id $order");

            $num_page = ceil($Qpaging->num_rows / $limit);
            if($Qpaging->num_rows > $limit){
                if($t != 0) $this->ifunction->paging($p, site_url('proposal').'/'.$t.'/0/0/0/0/', $num_page, $Qpaging->num_rows, 'href', false);
                elseif($tp != 0) $this->ifunction->paging($p, site_url('proposal').'/0/'.$tp.'/0/0/0/', $num_page, $Qpaging->num_rows, 'href', false);
                elseif($d != 0){
                    if($d==1) $this->ifunction->paging($p, site_url('proposal').'/0/0/'.$d.'/0/0/', $num_page, $Qpaging->num_rows, 'href', false);
                    elseif($d==2) $this->ifunction->paging($p, site_url('proposal').'/0/0/'.$d.'/0/0/', $num_page, $Qpaging->num_rows, 'href', false);
                }
                elseif($dx != 0) $this->ifunction->paging($p, site_url('proposal').'/0/0/0/'.$dx.'/0/', $num_page, $Qpaging->num_rows, 'href', false);
                elseif($id != 0) $this->ifunction->paging($p, site_url('proposal').'/0/0/0/0/'.$id.'/', $num_page, $Qpaging->num_rows, 'href', false);
                // elseif(isset($_POST['search'])){
                //     $keyword = $_POST['keyword'];
                //     $where = "WHERE a.judul LIKE '%$keyword%'";
                // }
                else $this->ifunction->paging($p, site_url('proposal').'/0/0/0/0/0/', $num_page, $Qpaging->num_rows, 'href', false);
            }
            ?>
        </div>
        <!-- primary -->
    </div>
    <!-- wrapper -->
</div>
<!-- content-main -->