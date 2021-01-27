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
	var kdrek5='';
	
    $(document).ready(function() { 
      get_skpd();                                                            
    }); 
    
    $(function(){
	//$('#sskpd').combogrid({  
//		panelWidth:630,  
//		idField:'kd_skpd',  
//		textField:'kd_skpd',  
//		mode:'remote',
//		url:'<?php echo base_url(); ?>index.php/akuntansi/skpd',  
//		columns:[[  
//			{field:'kd_skpd',title:'Kode SKPD',width:100},  
//			{field:'nm_skpd',title:'Nama SKPD',width:500}    
//		]],
//		onSelect:function(rowIndex,rowData){
//			kdskpd = rowData.kd_skpd;
//			$("#nmskpd").attr("value",rowData.nm_skpd);
//			$("#skpd").attr("value",rowData.kd_skpd);
//			//validate_giat();
//		}  
//		}); 
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
	});


	

        function get_skpd()
        {
        
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
                                        $("#skpd").attr("value",data.kd_skpd);
        								kdskpd = data.kd_skpd;
                                               
        							  }                                     
        	});  
        }
 

		function cetakjumasuk(oke)
        {
            var jns= jns;
            if($('#dcetak').datebox('getValue') == 0 || $('#dcetak2').datebox('getValue') == 0 ){
                alert("Pilih Tanggal Periode");
                exit();
            }
			var dcetak = $('#dcetak').datebox('getValue');      
			var dcetak2 = $('#dcetak2').datebox('getValue');     
			var ttd    = nip; 
			var skpd   = kdskpd; 

			var url    = "<?php echo site_url(); ?>/akuntansi_blud/ctk_jurum_blud";  
			window.open(url+'/'+dcetak+'/'+dcetak2+'/'+skpd+'/'+oke, '_blank');
			window.focus();
        }

    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
         td{
            border-bottom:  hidden;
            border-style:  hidden;
         }
         tr{
            border-bottom:none;
            border-style: none;
         }
         table{
            border-bottom:none;
            border-style: none;

         }
	</STYLE> 

</head>
<body>

<div id="content">

<div id="">

<h3 style="border-left: 6px solid #2196F3!important;background-color: #ddffff!important; padding: 5px; width: 30%">CETAK JURNAL BLUD</h3>
    <div>
    <p align="right">         
        <table id="sp2d" title="Cetak Buku Besar" style="width:100%;height:300px; background-color: #e8e8e8; border-radius: 10px " >  
		<tr >
			<td width="20%" height="40" ><B>B L U D</B></td>
			<td width="80%"><input id="sskpd" name="sskpd" readonly="true" style="width: 70px; border-style: none;background-color: #e8e8e8" />  <input id="nmskpd" name="nmskpd" readonly="true" style="width: 500px; border-style: none;background-color: #e8e8e8" /></td>
		</tr>
        
		<tr >
			<td width="20%" height="40" ><B>PERIODE</B></td>
			<td width="80%"><input id="dcetak" name="dcetak" type="text"  style="width:155px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:155px" /></td>
		</tr>
		
		<tr >
			<td width="20%" height="40" >&nbsp</td>
			<td width="80%"> 
                <INPUT TYPE="button" VALUE="CETAK" ONCLICK="cetakjumasuk(0)" style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px " >
			  <INPUT TYPE="button" VALUE="PDF" ONCLICK="cetakjumasuk(1)" style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px" >
                <INPUT TYPE="button" VALUE="EXCEL" ONCLICK="cetakjumasuk(2)" style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px" >
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