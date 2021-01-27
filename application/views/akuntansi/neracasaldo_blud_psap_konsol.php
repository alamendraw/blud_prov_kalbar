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
    var nip='';
	var kdskpd='';
	var bulan='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });             
        });   
    $(function(){
	$('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/akuntansi_blud/skpd',  
		columns:[[  
			{field:'kd_skpd',title:'Kode SKPD',width:100},  
			{field:'nm_skpd',title:'Nama SKPD',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;
			$("#nmskpd").attr("value",rowData.nm_skpd);
			$("#skpd").attr("value",rowData.kd_skpd);
           
		}  
		}); 
	});
	$(function(){    
        
        $('#dcetak').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        }); 
        
        $('#dcetak2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
         $('#ttd').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/tukd_blud/load_ttd_konsol/PA',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
					nipx = rowData.nip;
                    $("#nmttd").attr("value",rowData.nama);
                    $("#nipx").attr("value",rowData.nip);
                    }  
  
				});
	});
	
    
		function cetakbb($cetak)
        {
			var cetak =$cetak;           	
			var dcetak = $('#dcetak').datebox('getValue');      
			var dcetak2 = $('#dcetak2').datebox('getValue');      
			var ttd    = nipx;                           
            var ttd1 =ttd.split(" ").join("a"); 
			var skpd   = kdskpd;	

			var url    = "<?php echo site_url(); ?>/akuntansi_blud/cetakneraca_saldo_blud_sap"; 
			window.open(url+'/'+dcetak+'/'+ttd1+'/'+skpd+'/'+dcetak2+'/'+cetak, '_blank');
			window.focus();
        }

    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
	</STYLE> 

</head>
<body>

<div id="content">

<div id="accordion">

<h3>CETAK NERACA SALDO</h3>
    <div>
    <p align="right">         
        <table id="sp2d" title="Cetak Neraca Saldo" style="width:870px;height:300px;" >  
		<tr >
			<td width="20%" height="40" ><B>SKPD</B></td>
			<td width="80%"><input id="sskpd" name="sskpd" readonly="true" style="width: 150px;border: 0;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" readonly="true" style="width: 500px; border:0;" /></td>
		</tr>
         <tr >
			<td width="20%" height="40" ><B></B></td>
			<td width="80%"><input id="kpusk" name="kpusk" readonly="true" style="width: 150px;border: 0;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="npusk" name="npusk" readonly="true" style="width: 500px; border:0;" /></td>
		</tr>	
		<tr >
			<td width="20%" height="40" ><B>PERIODE</B></td>
			<td width="80%"><input id="dcetak" name="dcetak" type="text"  style="width:155px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:155px" /></td>
		</tr>
		<tr >
			<td width="20%" height="40" ><B>PENANDA TANGAN</B></td>
			<td width="80%"><input id="ttd" name="ttd" type="text"  style="width:230px" /></td>
		</tr>
		<tr >
			<td width="20%" height="40" >&nbsp</td>
			<td width="80%"> 
				<INPUT TYPE="button" VALUE="Cetak Layar" ONCLICK="cetakbb(1)" style="height:40px;width:100px" > &nbsp;&nbsp;&nbsp;&nbsp; 
				<INPUT TYPE="button" VALUE="Cetak PDF" ONCLICK="cetakbb(2)" style="height:40px;width:100px" > &nbsp;&nbsp;&nbsp;&nbsp; 
				<INPUT TYPE="button" VALUE="Cetak Excel" ONCLICK="cetakbb(3)" style="height:40px;width:100px" >
			</td>
		</tr>
		<tr >
			<td >&nbsp</td>
			<td >&nbsp</td>
		</tr>
        </table>                      
    </p> 
    </div>
</div>
</div>

 	
</body>

</html>