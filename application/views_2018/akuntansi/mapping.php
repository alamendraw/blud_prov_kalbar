<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
   
    <script type="text/javascript"> 

	function mapping_transfer(){
		document.getElementById('load').style.visibility='visible';

		$(function(){      
		 $.ajax({
			type: 'POST',
			data: ({nomor:'1'}),
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/akuntansi_blud/proses_mapping_transfer",
			success:function(data){
			if (data = 1){
					alert('TRANSFER DATA APBD SELESAI');
					document.getElementById('load').style.visibility='hidden';
				}
			}
		 });
		});
	}
	
	function mapping(){
		document.getElementById('load').style.visibility='visible';

		$(function(){      
		 $.ajax({
			type: 'POST',
			data: ({nomor:'1'}),
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/akuntansi_blud/proses_mapping",
			success:function(data){
			if (data = 1){
					alert('POSTING JURNAL SELESAI');
					document.getElementById('load').style.visibility='hidden';
				}
			}
		 });
		});
	}
	

    </script>

</head>
<body>

<div id="content">

<div id="accordion">

<h3>POSTING JURNAL BLUD</h3>
    <div>
    <p >         
        <table id="sp2d" title="Posting Jurnal" style="width:870px;height:300px;" >  
		<tr >
			<td width="100%" align="center"> <INPUT TYPE="button" VALUE="TRANSFER DATA APBD" style="height:40px;width:300px" onclick="mapping_transfer()" >
			</td>
		</tr>
		
		<tr >
			<td width="100%" align="center"> <INPUT TYPE="button" VALUE="POSTING JURNAL" style="height:40px;width:300px" onclick="mapping()" >
			</td>
		</tr>
		
		<tr height="70%" >
			<td align="center" style="visibility:hidden" >	<DIV id="load" > <IMG SRC="<?php echo base_url(); ?>assets/images/mapping.gif" WIDTH="270" HEIGHT="40" BORDER="0" ALT=""></DIV></td>
		</tr>
		</table>                      
    </p> 
    </div>
</div>
</div>

 	
</body>

</html>