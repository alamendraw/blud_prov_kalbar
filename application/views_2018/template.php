<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/metro-green/easyui.css">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo.png" type="image/x-icon" />
	<link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet" type="text/css" />
	<base href="<?php echo base_url();?>" />
	<link type="text/css" href="<?php echo base_url();?>assets/menu.css" rel="stylesheet" />
  	<script src="<?php echo base_url(); ?>assets/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/jquery.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tab.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.newsTicker-2.2.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/home.css">





<style>
.shadow
{
text-shadow: 2px 2px 2px #333;
font:bold 20px Arial, Helvetica, sans-serif;
}

.shadow1
{
text-shadow: 5px 5px 5px #333;
font:bold 40px Arial;
}
.shadow2
{
text-shadow: 2px 2px 2px #333;
font:bold 30px Arial, Helvetica, sans-serif;
}
</style>


	<SCRIPT LANGUAGE="JavaScript">


	var secs;
	var timerID = null;
	var timerRunning = false;
	var delay = 2000;

	function InitializeTimer(){
		secs = 1;
		StopTheClock();
		StartTheTimer();
	}

	function StopTheClock(){
		if(timerRunning)
		clearTimeout(timerID);
		timerRunning = false;
	}

	function StartTheTimer(){
		if (secs==0){
			StopTheClock();
			ceklogin();
			secs = 1;
			timerRunning = true;
			timerID = self.setTimeout("StartTheTimer()", delay);
		}else{
			self.status = secs;
			secs = secs - 1;
			timerRunning = true;
			timerID = self.setTimeout("StartTheTimer()", delay);
		}
	}


	function ceklogin(){
        $(function(){      
         $.ajax({
            type: 'POST',
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/welcome/ceklogin/",
            success:function(data){
			   if (data==1){
				  document.location.href = '<?php echo base_url(); ?>index.php'; 
			   }
			}
         });
        });
	}

	/* function logout_confirm(xurl){
		var tny = confirm("KONFIRMASI LOGOUT SIMAKDA ?");
        if (tny==true){
			window.location = xurl;
        }else{
			return;
		}
		
	} */


	</SCRIPT>


</head>
<body  onload="InitializeTimer(); StartTheTimer();" >
<div id="wrapper">
	<!-- <div id="header">
	    	<div class="title"></div>
	 <div class="clear"></div>
	</div> -->
	<div id="header">
    	<div class="title">
			<table cellpadding="0" cellspacing="0" width="200%" align="center" border="0">
				<tr height="80px">
					<td width="130px" valign="bottom" align="center"><img src="<?php echo base_url(); ?>image/logo.png" style="width:75px;margin: 0px 0px 0px 20px;" ></td>
					<td align="left" style="">
						<font style="color:yellow; font-size:27px; padding-bottom: 5px"  class="shadow">SIMAK-BLUD</font><br />
						<font  style="line-height: 20px; font-size:20px; color:black"  >SISTEM INFORMASI MANAJEMEN AKUNTANSI KEUANGAN<br>
						BADAN LAYANAN UMUM DAERAH</font>
					</td>
					<td align="right">
					<?php 
					$query=$this->db->query("SELECT thn_ang FROM sclient_blud");
					$data=$query->row();
					$thang=$data->thn_ang;	
					?>
					<font style="line-height: 20px; font-size:20px; color:red"   class="shadow2">TAHUN ANGGARAN<br />
					</font><font  style="line-height: 20px; font-size:20px; color:red"  class="shadow2"> <?PHP echo $thang ?></font></td>
				</tr>
			</table>
		
		</div>
	</div>

<?php

 $otori = $this->session->userdata('pcOtoriName');
 echo $this->dynamic_menu->build_menu('dyn_menu', '1',$otori);

?>
    
 
    <?php echo $contents; ?>
   
    	<div id="footer">
		 <table cellpadding="0" cellspacing="0" width="100%" align="center" border="0">
    	<tr>
    		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "&#9742; KONTAK KONSULTASI : - Copyright &copy; 2012 - "?> <?php echo date("Y") ?> <?php echo "|| MSM CONSULTANTS";?></td>
    		<td align="right">
    			<a> 
									<form name="Tick">
										<script type='text/javascript'>
											var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
											var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
											var date = new Date();
											var day = date.getDate();
											var month = date.getMonth();
											var thisDay = date.getDay(),
												thisDay = myDays[thisDay];
											var yy = date.getYear();
											var year = (yy < 1000) ? yy + 1900 : yy;
											document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
										</script>
									<input readonly="true" type="text" size="10" name="Clock" style="border-style:none; background-color:transparent; color:#fff; text-align:center">
									</form>
										<script type='text/javascript'>
											function show(){
												var Digital=new Date()
												var hours=Digital.getHours()
												var minutes=Digital.getMinutes()
												var seconds=Digital.getSeconds()
												var dn="AM"
												if (hours>12){
													dn="PM"
													hours=hours-12
												}
												if (hours==0)
													hours=12
												if (minutes<=9)
													minutes="0"+minutes
												if (seconds<=9)
													seconds="0"+seconds
													document.Tick.Clock.value=hours+":"+minutes+":"
													+seconds+" "+dn
													setTimeout("show()",1000)
											}
											show()
										</script>
								</a>
    		</td>
    		
    	</tr>
    </table>
	</div>
</div>
</body>
</html>