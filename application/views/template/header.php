<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<header role="banner" class="header-main clearfix">
    <div class="wrapper">
        <a class="logo" href="<?php echo base_url() ?>">
            <img src="<?php echo base_url('static/img/logo.jpg') ?>" alt="" height="36" width="180">
        </a>
        <nav role="navigation" class="nav-main">
            <ul class="clearfix list-nostyle">
                <li>
                    <a class="link-green" href="<?php echo site_url('tentang') ?>">Tentang Aplikasi</a>
                </li>
                <?php
                if(isset($_SESSION['sabilulungan']['role'])){
                    if($_SESSION['sabilulungan']['role']==6) {echo '<li><a class="link-blue" href="'.site_url('proposal_user/0/0/0/0/'.$_SESSION['sabilulungan']['uid']).'">Proposal Saya</a></li><li><a class="link-purple" href="'.site_url('lpj').'">LPJ</a></li> ';
                        $user_id = $_SESSION['sabilulungan']['uid'];
                        $Qdetail = $this->db->query("SELECT id from proposal where user_id = '.$user_id.' and current_stat = 7"); $detail = $Qdetail->result_object();
                        $i = $Qdetail->num_rows();
                
                        if($i > 0){      
                           echo '<li><a class="link-purple" href="'.site_url('hibah2/edit/'.$detail[0]->id).'">Daftar Proposal</a></li>';
                        }else{
                            //echo 'nihil';
                        }
                    }
                        
                    elseif($_SESSION['sabilulungan']['role']==5) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('hibah').'">Daftar Lanjutan</a></li><li><a class="link-purple" href="'.site_url('report').'">Pengecekan Berkas</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==4) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('report2').'">Pemilihan SKPD dan Verifikasi</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==3) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('report').'">Pemberian Rekomendasi</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==2) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('report2').'">Verifikasi</a></li><li><a class="link-purple" href="'.site_url('tapd/generate').'">Rekapitulasi</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==1) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('report2').'">Pemeriksaan Proposal</a></li><li><a class="link-purple" href="'.site_url('tapd_walikota/generate').'">Cetak</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==7) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('hibah').'">Daftar Hibah</a></li><li><a class="link-purple" href="'.site_url('report').'">Pemeriksaan</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==8) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('input').'">Mendaftar Hibah Masuk</a></li> ';
                    elseif($_SESSION['sabilulungan']['role']==9) echo '<li><a class="link-blue" href="'.site_url('proposal').'">Proposal Hibah / Bansos</a></li><li><a class="link-purple" href="'.site_url('report').'">Koreksi</a></li><li><a class="link-purple" href="'.site_url('cms').'">Utility</a></li> ';
                }else echo '
                    <li>
                        <a class="link-purple" href="'.site_url('peraturan').'">Peraturan</a>
                    </li> 
                    <li>
                        <a class="link-green" href="'.site_url('lapor').'">Lapor</a>
                    </li>
                    <li>
                        <a class="link-blue" href="'.site_url('panduan').'">Panduan Aplikasi</a>
                    </li>
                    ';
                ?> 
            </ul>
        </nav>
        <!-- nav-main -->
        <div class="nav-user list-nostyle clearfix">
            <form class="form-search-header" action="<?php echo site_url('proposal') ?>" method="post">
                <input type="text" name="keyword" placeholder="Cari">
                <button name="search" class="btn-search btn-ir" style="border:none" type="submit">Search</button>
            </form>
            <!-- <a class="btn-user btn-ir" href="<?php echo site_url('login') ?>">User</a> -->
            
            
            <?php
            /* if(isset($_SESSION['sabilulungan']['role'])){
                echo '<a class="logo-bandung" href="'.site_url('logout/'.$_SESSION['sabilulungan']['uid']).'" style="margin-top:3px;margin-right:10px" onclick="return confirm(\'Apakah Anda Yakin Akan Keluar ?\');" alt="Sign Out">
                    <img src="'.base_url('static/img/btn-user.png').'" alt="">
                </a>';
            }else{
                echo '<a class="logo-bandung" href="'.site_url('login').'" style="margin-top:3px;margin-right:10px" alt="Sign In">
                    <img src="'.base_url('static/img/btn-user.png').'">
                </a>';
            } */
            
            if(isset($_SESSION['sabilulungan']['role'])){
                echo '<a class="logo-bandung" href="'.site_url('logout/'.$_SESSION['sabilulungan']['uid']).'" onclick="return confirm(\'Apakah Anda Yakin Akan Keluar ?\');" alt="Sign Out">
                    Logout
                </a>';
            }else{
                echo '<a class="logo-bandung" href="'.site_url('login').'"  alt="Sign In">
                    Login
                </a>';
            }
            
            ?>
           
            
            
        </div>
        <!-- nav-user -->
    </div>
    <!-- wrapper -->
    <div class="nav-user-panel nav-sub-panel" style="display: none;">
        <div class="wrapper clearfix">
            <form class="form-signin-header" action="<?php echo base_url('process/login') ?>">
                <input type="text" name="uname" placeholder="Username">
                <input type="password" name="pswd" placeholder="Password">
                <button class="btn-login btn-red btn-plain btn" type="submit">Masuk</button>
                <span class="link-register">/ <a href="<?php echo site_url('daftar') ?>">Daftar</a></span>
            </form>
            <!-- <ul class="user-links list-nostyle">
                <li class="username">
                    Vostro Robert
                </li>
                <li>
                    <a href="#">Edit Profile</a>
                </li>
                <li class="signout">
                    <a class="btn-red btn-plain btn" href="#">Keluar</a>
                </li>
            </ul> -->
        </div>
        <!-- <div style="font-size:10px;margin-left:53.5%;"><a href="<?php echo site_url('sandi') ?>" style="color:#FFF">Lupa Kata Sandi ?</a></div> -->
    </div>
    <!-- nav-user -->
</header>
<!-- header-main -->