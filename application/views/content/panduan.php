<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <h1 class="page-title page-title-border">Panduan Aplikasi</h1>
        <div class="col-wrapper clearfix">
            <!-- <div id="pdf" style="height:600px">
                <p>It appears you don't have Adobe Reader or PDF support in this web browser. <a href="smedia/Hibah_Bansos_Online_Sabilulungan.pdf">Click here to download the PDF</a></p>
            </div> -->

            <!-- <p><strong>Penggunaan Media Online sabilulungan.bandung.go.id Untuk Transparansi dan Akuntabilitas Penyaluran Dana Hibah dan Bantuan Sosial di Pemerintah Kota Bandung</strong></p>
            <p>Ringkasan singkat</p>
            <p>Penyaluran bantuan hibah dan bantuan sosial (bansos) telah menjadi masalah hukum nasional di Indonesia. Telah banyak kasus hukum terjadi akibat penggunaan dan penyalurannya, baik pemerintahan di tingkat pusat (Kementrian / Lembaga) maupun di Pemerintah Daerah Baik Provinsi, Kabupaten / Kota di Indonesia.</p>
            <p>Bantuan sosial dan Hibah konon disalahgunakan dengan &lsquo;kreatif&rsquo; untuk politik pencitraan oleh kepala daerah/wakil, terutama Kepala Daerah Incumbent yang mencalon kembali dalam ajang pemilukada untuk periode ke dua. Bisa juga disalahgunakan untuk para tim sukses yang dianggap telah berjasa dan dalam menggolkan kepala daerah/wakil yang sedang menjabat.</p>
            <p>Berdasarkan hasil kajian Komisi Pemberantasan Korupsi yang disampaikan oleh Direktur Dikyanmas KPK, Dedie A Rachim pada tanggal 21-22 November 2011 di Pontianak.</p>

            <p style="text-align:center;margin:100px 0 0">
                <a target="_blank" style="background:#0C88CE;color:#FFF;text-decoration:none;padding:20px" href="media/Hibah_Bansos_Online_Sabilulungan.pdf">LIHAT PERATURAN LEBIH LENGKAP</a>
            </p> -->

            <style type="text/css">
            .list li{
                text-transform: uppercase; 
            }
            </style>

            <ul class="list">
                <?php
                $Qlist = $this->db->query("SELECT title, content FROM cms WHERE page_id='peraturan' ORDER BY sequence ASC");

                
                ?>
              
                <!-- <li><a target="_blank" href="<?php echo base_url('media/peraturan/01.02 SOP_Bendaharan Hibah dan Bantuan Sosial (Repaired).pdf'); ?>">SOP Bendaharan Hibah dan Bantuan Sosial (Repaired)</a></li> -->
                
            </ul>
        </div>
    </div>
</div>
<!-- content-main -->