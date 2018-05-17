<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div role="main" class="content-main" style="margin:120px 0 50px">
    <div class="wrapper-half">
        <h1 class="page-title page-title-border">Sign in</h1>
        <?php
        if(isset($_SESSION['notify'])){
           
            unset($_SESSION['notify']);
		?>
			<script type="text/javascript">
				alert("Pendaftaran berhasil. Silahkan login menggunakan kode aktivasi yang dikirim kepada ponsel anda.");	
			</script>
		<?php
        }            
        ?>        
        <form class="form-global" method="post" action="<?php echo base_url('process/user/aktivasi') ?>">
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
                    <label class="control-label" for="">Kode Aktivasi</label>
                    <div class="controls">
                        <input type="text" name="kode" required>
                    </div>
                </div>
                <div class="control-actions clearfix">
                    <button class="btn-red btn-plain btn" type="submit">Aktivasi</button>
                </div>
            </fieldset>
        </form>
        <!-- form-register -->
    </div>
    <!-- wrapper-half -->
</div>
<!-- content-main -->