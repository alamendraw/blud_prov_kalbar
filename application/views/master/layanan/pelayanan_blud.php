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
    
    var kode     = '';
    var giat     = '';
    var nomor    = '';
    var judul    = '';
    var cid      = 0;
    var lcidx    = 0;
    var lcstatus = '';
                    
    $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 250,
            width: 600,
            modal: true,
            autoOpen:false
        });

        $('#hunit').combogrid({  
           panelWidth:500,  
           idField:'kd_layanan',  
           textField:'nm_layanan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/master/ambil_kode_pelayanan_blud',  
           columns:[[  
               {field:'kd_layanan',title:'Kode layanan',width:100},  
               {field:'nm_layanan',title:'Nama layanan',width:400}    
           ]],  
           onSelect:function(rowIndex,rowData){
               $("#parent").attr("value",rowData.kd_layanan.toUpperCase());
               id = rowData.kd_layanan;
               sublayanan(id);
              // $("#kode").attr("value",rowData.kd_urusan.toUpperCase()+'.');                
           }  
         });
    });    

    function sublayanan(id){
        $('#subunit').combogrid({  
           panelWidth:500,  
           idField:'kd_layanan',  
           textField:'nm_layanan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/master/ambil_kode_subpelayanan_blud/'+id,  
           columns:[[  
               {field:'kd_layanan',title:'Kode layanan',width:100},  
               {field:'nm_layanan',title:'Nama layanan',width:400}    
           ]],  
           onSelect:function(rowIndex,rowData){
               $("#subparent").attr("value",rowData.kd_layanan.toUpperCase());
              // $("#kode").attr("value",rowData.kd_urusan.toUpperCase()+'.');                
           }  
         });
    }
     $(function(){        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_pelayanan_blud',
        idField      : 'id',            
        rownumbers   : "true", 
        fitColumns   : "true",
        singleSelect : "true",
        autoRowHeight: "false",
        loadMsg      : "Tunggu Sebentar....!!",
        pagination   : "true",
        nowrap       : "true",                       
        columns:[[
    	    {field:'kd_layanan',
    		title:'Kode layanan',
    		width:15,
            align:"center"},
            {field:'nm_layanan',
    		title:'Nama layanan',
    		width:50}
        ]],
        onSelect:function(rowIndex,rowData){
          kd = rowData.kd_layanan;
          pr = rowData.parent;
          nm = rowData.nm_layanan;
          get(kd,nm,pr); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Pelayanan Blud'; 
           edit_data();   
        }
        
        });
       
    });        

 
    
    function get(kd,nm,pr) {
        
        $("#kode").attr("value",kd);
        $("#kode_detail").attr("value",kd);
        $("#hunit").combogrid("setValue",pr);
        $("#parent").attr("value",pr);
        $("#nama").attr("value",nm);     
                       
    }
       
    function kosong(){
        $("#kode").attr("value",'');
        $("#kode_detail").attr("value",'');
        $("#parent").attr("value",'');
        $("#hunit").combogrid("setValue",'');
        $("#nama").attr("value",'');
        document.getElementById("kode_detail").disabled=false;
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_dana',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_fungsi(){
       
        var ckode = document.getElementById('subunit').value;
        var cparent = document.getElementById('subparent').value;
        var ckode_detail = document.getElementById('kode_detail').value;
        var cnama = document.getElementById('nama').value;
                
      /*  if (ckode==''){
            alert('Kode Tidak Boleh Kosong');
            exit();
        }*/
        if (ckode_detail==''){
            alert('Kode Detail Tidak Boleh Kosong');
            exit();
        }
        if (cnama==''){
            alert('Nama Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kd_layanan,level,parent,nm_layanan)";
            lcvalues = "('"+ckode_detail+"','3','"+cparent+"','"+cnama+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master',
                    data: ({tabel:'ms_layanan',kolom:lcinsert,nilai:lcvalues,cid:'kd_layanan',lcid:ckode}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE ms_layanan SET parent='"+cparent+"', nm_layanan='"+cnama+"' where kd_layanan='"+ckode+"'";

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Sumber Dana';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode_detail").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Pelayanan Blud';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=false;
        document.getElementById("kode").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
     }    
    
     function hapus(){
        var ckode = document.getElementById('kode').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
        $(document).ready(function(){
         $.post(urll,({tabel:'ms_dana_blud',cnid:ckode,cid:'kd_sdana'}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                $('#dg').datagrid('deleteRow',lcidx);   
                alert('Data Berhasil Dihapus..!!');
                $("#dialog-modal").dialog('close');
                exit();
            }
         });
        });    
    } 
    
       
    function addCommas(nStr)
    {
    	nStr += '';
    	x = nStr.split(',');
        x1 = x[0];
    	x2 = x.length > 1 ? ',' + x[1] : '';
    	var rgx = /(\d+)(\d{3})/;
    	while (rgx.test(x1)) {
    		x1 = x1.replace(rgx, '$1' + '.' + '$2');
    	}
    	return x1 + x2;
    }
    
     function delCommas(nStr)
    {
    	nStr += ' ';
    	x2 = nStr.length;
        var x=nStr;
        var i=0;
    	while (i<x2) {
    		x = x.replace(',','');
            i++;
    	}
    	return x;
    }
  
    
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INPUTAN MASTER SUMBER DANA</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:100%;" border="0">
        <tr style="border-style:hidden;">
        <td width="10%" style="border-style:hidden;">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td> 
        <td width="5%" style="border-style:hidden;"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
        </tr>
    </table>  
    
        <table id="dg" title="LISTING DATA Pelayanan Blud" style="width:900px;height:365px;" >  
        </table>  
    
        
 
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
           <tr>
                <td width="30%">HEADER LAYANAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="hunit" style="width:200px;"/><input type="text" id="parent" hidden="" style="width:100px;"/></td>  
            </tr>   
            <tr>
                <td width="30%">SUB HEADER LAYANAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="subunit" style="width:200px;"/><input type="text" id="subparent" hidden="" style="width:100px;"/></td>  
            </tr>   
             <tr>
                <td width="30%">KODE DETAIL LAYANAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode_detail" style="width:100px;"/></td>  
            </tr>       
            <tr>
                <td width="30%">NAMA DETAIL LAYANAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="nama" style="width:360px;"/></td>  
            </tr>
            
            
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_fungsi();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>