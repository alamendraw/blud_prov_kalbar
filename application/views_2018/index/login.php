<script src="<?php echo base_url(); ?>assets/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tab.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.newsTicker-2.2.js"></script>


<script type="text/javascript">
	$(document).ready(function(){  
	  $('.carousel').carousel({
	  	interval: 3000
	  }); 
	  $().newsTicker({
	  		newsList: ".ticker",
	 		startDelay: 10,
	 		tickerRate: 120,
			loopDelay: 5000,
	 		controls: false,
	 		ownControls: false,
	 		stopOnHover: false,
	 		resumeOffHover: true
		});
	});

	function loading_style(){
		document.getElementById('button_login').disabled=true;
	}
</script>


<div class="box-title">
<section class="section-style">
	<label class="goverment-name">
		<img src="<?php echo base_url(); ?><?php echo $logo; ?>" width="140px" height="160px" align="center"/>
		<br> <?php echo $goverment_name;?>
	</label>
</section>

	<div class="system-name" style="text-align:center;font-size:32px;">
		<ul class="ticker" style=" padding:0px; margin:0">
			<li>SIMBLUD</li>
		</ul>
	</div>
	<div class="footer-name">
		<h1><?php echo $footer ?></h1>
	</div>
</div>

<div class="form-login">
	<div id="jr" style="display: block; width: 100%; margin: 0px;">
		<ul class="login-title"><li ><span><?php echo $dec_app_name; ?><br><br></span></li></ul>
			<div class="login-document">

				<form action="<?php echo site_url(); ?>/welcome/login" method="post">
					<input type="text" onclick="javascript:select();" name="username" class="username" placeholder="Nama pengguna" title="Masukan nama pengguna / username anda."/>
					<input type="password" onclick="javascript:select();" name="password" class="password" placeholder="Kata sandi" title="Masukan kata sandi / password anda."/><br><br>
					<div class="login-confirm">
						<input id="button_login" type="submit" value="LOGIN"/>&#160;&#160;&#160;
						<!--<select class="select" name ="pcthang" title="Sesuaikan data tahun anggaran yang akan anda akses.">
							<option value="2017">Tahun Anggaran - 2017</option>
						</select>
						-->
<?php $thang =  date("Y"); 
	$thang_maks = $thang + 0 ;
	$thang_min = $thang - 0 ;
	echo '<select name ="pcthang">';
	$tahun_2017 = "2018";
	for ($th=$thang_min ; $th<=$thang_maks ; $th++)
	{
		if ($th==$thang) {
			echo "<option selected value=$tahun_2017>$tahun_2017</option>";
			}
		else {	
		echo "<option value=$tahun_2017>$tahun_2017</option>";
		}
	}
	echo '</select>';	
        
        
    ?>
						<br><br><br><br>
						<a class="error-message"><?php echo isset($error_message) ? $error_message : ''?></a>
					</div>
					
				</form>
			</div>
	</div>
</div>