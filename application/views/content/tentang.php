<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$Qedit = $this->db->query("SELECT content FROM cms WHERE `page_id`='tentang' ORDER BY sequence ASC"); $edit = $Qedit->result_object();
?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="about-page wrapper">
        <h1 class="page-title page-title-border">Tentang Sabilulungan</h1>
        <div class="col-wrapper clearfix">
            <!-- <div class="col">
                <?php echo $edit[0]->content ?>
            </div>
            <div class="col">
                <img src="<?php echo base_url('media/cms/'.$edit[1]->content) ?>" alt="">
                <img src="<?php echo base_url('media/cms/'.$edit[2]->content) ?>" alt="">
            </div>
			
			-->
			<h2>APA YANG SABILULUNGAN WUJUDKAN</h2>

			<h2>TAHAPAN SABILULUNGAN</h2>
        </div>
    </div>
    <!-- wrapper -->
    <div class="project-steps project-steps-alt">
        <div class="wrapper">
            <h2>Tahapan</h2>
            <ul class="project-steps-list list-nostyle clearfix">
                <li class="divider"></li>
                <li>Pendaftaran Proposal Hibah Bansos</li>
                <li class="divider"></li>
                <li>Pemeriksaan Kelengkapan Dokumen Oleh TU</li>
                <li class="divider"></li>
                <li>Pemeriksaan Oleh Walikota</li>
                <li class="divider"></li>
                <li>Klasifikasi Sesuai SKPD Oleh Tim Pertimbangan</li>
            </ul>
            <ul class="project-steps-list list-nostyle clearfix">
                <li class="divider"></li>
                <li>Rekomendasi Dana Oleh SKPD</li>
                <li class="divider"></li>
                <li>Verifikasi Proposal Oleh Tim Pertimbangan</li>
                <li class="divider"></li>
                <li>Verifikasi Proposal Oleh TAPD</li>
                <li class="divider"></li>
                <li>Persetujuan Walikota</li>
            </ul>
            <ul class="project-steps-list list-nostyle clearfix">
				<li class="divider"></li>
                <li>Pemeriksaan Proposal Oleh Tata Usaha</li>
                <li class="divider"></li>
                <li>Pemeriksaan Tahap 1 Oleh Walikota</li>
                <li class="divider"></li>
                <li>Kajian Pencairan</li>
                <li class="divider"></li>
                <li>Pemeriksaan Tahap 2 Oleh Walikota</li>
            </ul>
			<ul class="project-steps-list list-nostyle clearfix">
				<li class="divider"></li>
                <li>Tahapan Pencairan</li>
                <li class="divider"></li>
                <li>Dana Tersalurkan</li>
                <li class="divider"></li>
                <li>Proyek Hibah Bansos Berjalan</li>
            </ul>
        </div>
    </div>
    <!-- project-steps -->
</div>
<!-- content-main -->