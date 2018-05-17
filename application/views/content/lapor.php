<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Lapor</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <form class="form-global" action="<?php echo base_url('process/lapor/send') ?>" method="post">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="">Nama</label>
                    <div class="controls">
                        <input type="text" name="name" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Email</label>
                    <div class="controls">
                        <input type="email" name="email" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Subjek</label>
                    <div class="controls">
                        <input type="text" name="subject" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Pesan</label>
                    <div class="controls">
                        <textarea name="message" required></textarea>
                    </div>
                </div>
                <div class="control-actions clearfix">
                    <button class="btn-red btn-plain btn" type="submit">Kirim</button>
                </div>
            </fieldset>
        </form>                    
        <p><b>Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD) Kota Cimahi</b></p>
        <p>Jl. Raden Demang Hardjakusumah Gd.B Lt.4</p>
        <p>E-mail: sabilulungan.cimahi@gmail.com</p>
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->