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
    
    var kdstatus = '';
    var kd = '';
                        
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 420,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });    
     
 
	$(function(){
	$('#sskpd').combogrid({  
		panelWidth:630,  
		idField:'kd_skpd',  
		textField:'kd_skpd',  
		mode:'remote',
		url:'<?php echo base_url(); ?>index.php/tukd/skpd',  
		columns:[[  
			{field:'kd_skpd',title:'Kode SKPD',width:100},  
			{field:'nm_skpd',title:'Nama SKPD',width:500}    
		]],
		onSelect:function(rowIndex,rowData){
			kdskpd = rowData.kd_skpd;
            $("#nmskpd").attr("value",rowData.nm_skpd);
			
		}  
		}); 
	});

	
	function validate1(){
        var bln1 = document.getElementById('bulan1').value; 
    }
    
    function cek_seluruh_skpd($cetak){
      
        skpdx   = kdskpd; 
		twx = document.getElementById('twx').value;
		jenis = document.getElementById('jenis').value;
		bulan   =  document.getElementById('bulan1').value;
		
		if(jenis==2){
			if(bulan==''){
				alert('Pilih Bulan terlebih dahulu!');
			}
		}else{
				bulan=='x';
		}
		
        url="<?php echo site_url(); ?>/tukd/preview_rekap_penerimaan/seluruh/"+$cetak+'/'+skpdx+'/'+jenis+'/'+twx+'/'+bulan+'/Report-cek-anggaran'
         
        openWindow( url );
    }
	
	function cek_rekening($cetak){
		
		twx = document.getElementById('twx').value;
		jenis = document.getElementById('jenis').value;
		bulan   =  document.getElementById('bulan1').value;
		
		if(jenis==2){
			if(bulan==''){
				alert('Pilih Bulan terlebih dahulu!');
				exit();
			}
		}else{
				bulan=='x';
		}
		
        url="<?php echo site_url(); ?>/tukd/preview_rekap_penerimaan_seluruh/seluruh/"+$cetak+'/'+jenis+'/'+twx+'/'+bulan+'/Report-cek-anggaran'
         
        openWindow( url);
    }
    
 
 function openWindow( url,$jns ){
        
            lc = '';
      window.open(url+lc,'_blank');
      window.focus();
      
     }  
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>CEK NILAI ANGGARAN DAN REALISASI</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:800px;" border="0">
      <tr>
           <td width="20%">&nbsp;</td>
           <td width="1%">&nbsp;</td>
           <td> 
      </tr>
	<tr >
			<td width="20%" height="40" ><B>SKPD</B></td>
			<td width="1%">:</td>
			<td width="1%"><input id="sskpd" name="sskpd" style="width: 150px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 500px; border:0;" /></td>
		</tr>
	<tr>
			<td width="20%" height="40" ><B>PERIODE CETAK</B></td>
			<td width="1%">:</td>
			<td width="80%">			
				<select name="jenis" id="jenis" style="width:200px;">
				 <option value="0">SELURUH</option>
				 <option value="1">PER-TW</option>
				 <option value="2">PER-BULAN</option>                 
                </select>
			</td>
		</tr>
	<tr>
			<td width="20%" height="40" ><B>TRIWULAN</B></td>
			<td width="1%">:</td>
			<td width="80%">			
				<select name="twx" id="twx" style="width:200px;">
				 <option value="1">TRIWULAN-I</option>
				 <option value="2">TRIWULAN-II</option>
				 <option value="3">TRIWULAN-III</option>
				 <option value="4">TRIWULAN-IV</option>                 
                </select>
			</td>
		</tr>
		<tr >
			<td width="20%" height="40" ><B>BULAN</B></td>
			<td width="1%">:</td>
			<td><?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?> </td>
		</tr>
	<tr>
           <td width="20%">Cetak Rekap Per-SKPD</td>
           <td width="1%">:</td>
           <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_seluruh_skpd(0);return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_seluruh_skpd(1);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_seluruh_skpd(2);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr> 
		
        <tr>
           <td width="20%">Cetak Rekap Seluruh</td>
           <td width="1%">:</td>
           <td> 
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_rekening(0);return false" >
                    <img src="<?php echo base_url(); ?>assets/images/icon/print.png" width="25" height="23" title="preview"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_rekening(1);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/print_pdf.png" width="25" height="23" title="cetak"/></a>
                    <a class="easyui-linkbutton" plain="true" onclick="javascript:cek_rekening(2);return false">                    
                    <img src="<?php echo base_url(); ?>assets/images/icon/excel.jpg" width="25" height="23" title="cetak"/></a>
           </td>    
        </tr> 
		 		
        <tr>
        <td colspan="4">
        </td>
        </tr>

    </table>    
    
    </p> 
    </div>   
</div>

</body>

</html>