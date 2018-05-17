<?php if(!defined('BASEPATH')) exit('No direct script access allowed') ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="register-page wrapper-half">
        <h1 class="page-title page-title-border">Daftar</h1>
        <?php
        if(isset($_SESSION['notify'])){
            echo '<div class="alert-bar alert-bar-'.$_SESSION['notify']['type'].'" style="width:100%">'.$_SESSION['notify']['message'].'</div>';
            unset($_SESSION['notify']);
        }            
        ?>
        <form class="form-global" method="post" action="<?php echo base_url('process/user/register') ?>">
            <fieldset>
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
                    <label class="control-label" for="">Nama (Sesuai KTP)</label>
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
                    <label class="control-label" for="">Kota</label>
                    <div class="controls">
                        <input type="text" name="kota" required>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="">Kecamatan</label>
                    <div class="controls">
                        <input type="text" name="kecamatan" required>
                    </div>
                </div>
				
				<div class="control-group">
                    <label class="control-label" for="">Kelurahan</label>
                    <div class="controls">
                        <input type="text" name="kelurahan" required>
                    </div>
                </div>

				
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
				 
				
				
				<script type="text/javascript">
				function fungsikodepos(data)
				{
				
					document.getElementById ("kodepos").value = data.value;
					

				}
				</script>
                <div class="control-group">
                    <label class="control-label" for="">Nomor Telepon</label>
                    <div class="controls">
                        <input type="text" name="phone" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">Nomor Induk Kependudukan (NIK)</label>
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
                <div class="control-actions clearfix">
                    <button class="btn-red btn-plain btn" type="submit">Daftar</button>
                    <!-- <button class="btn-black btn-plain btn" type="reset">Reset</button> -->
                </div>
            </fieldset>
        </form>
        <!-- form-register -->
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->