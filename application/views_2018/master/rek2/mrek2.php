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
    
    var kode = '';
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 350,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){  
        
     $('#rek1').combogrid({  
       panelWidth:500,  
       idField:'kd_rek1',  
       textField:'kd_rek1',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_rekening1',  
       columns:[[  
           {field:'kd_rek1',title:'Kode Rekening',width:100},  
           {field:'nm_rek1',title:'Nama Rekening',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
            kd_rek1 = rowData.kd_rek1;
            $("#nm_u").attr("value",rowData.nm_rek1.toUpperCase());
           // muncul();                
       }  
     });     
        
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_rekening2',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {field:'kd_rek2',
    		title:'Kode Kelompok',
    		width:15,
            align:"center"},
    	    {field:'kd_rek1',
    		title:'Kode Akun',
    		width:15,
            align:"center"},
            {field:'nm_rek2',
    		title:'Nama Rekening',
    		width:50}
        ]],
        onSelect:function(rowIndex,rowData){
          kd_s = rowData.kd_rek2;
          kd_u = rowData.kd_rek1;
          nm_s = rowData.nm_rek2;
          kel = rowData.kelompok;
          lra = rowData.lra;
          get(kd_s,kd_u,nm_s); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Urusan'; 
           edit_data();   
        }
        
        });
       
    });        

 
    
    function get(kd_s,kd_u,nm_s) {
        
        $("#kode").attr("value",kd_s);
        $("#rek1").combogrid("setValue",kd_u);
        $("#nama").attr("value",nm_s);    
                       
    }
       
    function kosong(){
        $("#kode").attr("value",'');
        $("#rek1").combogrid("setValue",'');
        $("#nama").attr("value",'');
    }
    
    function muncul(){
        //alert(kd_s);
        var c_urus=kd_urus+'.';
        var c_skpd=kd_s;
        if(lcstatus=='tambah'){ 
            $("#kode").attr("value",c_urus);
        } else {
            $("#kode").attr("value",c_skpd);
        }     
    }
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_rekening2',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_rek2(){
       
        var ckode = document.getElementById('kode').value;
        var crek1= $('#rek1').combogrid('getValue');
        var cnama = document.getElementById('nama').value;
        if (ckode==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (crek1==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (cnama==''){
            alert('Nama  Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kd_rek2,kd_rek1,nm_rek2)";
            lcvalues = "('"+ckode+"','"+crek1+"','"+cnama+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master',
                    data: ({tabel:'ms_rek2',kolom:lcinsert,nilai:lcvalues,cid:'kd_rek2',lcid:ckode}),
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
            
            lcquery = "UPDATE ms_rek2 SET nm_rek2='"+cnama+"',kd_rek1='"+crek1+"' where kd_rek2='"+ckode+"'";

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
        judul = 'Edit Data Kelompok';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Kelompok';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=false;
        document.getElementById("kode").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
        //lcstatus = 'edit';
     }    
     
	  function cetak(){
		 
			var url    = "<?php echo site_url(); ?>/ctk_mrek/cetak_rek2";	  
			window.open(url,'_blank');
			window.focus();
	 }
     
     function hapus(){
        var ckode = document.getElementById('kode').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
        $(document).ready(function(){
         $.post(urll,({tabel:'ms_rek2',cnid:ckode,cid:'kd_rek2'}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                $('#dg').datagrid('deleteRow',lcidx);   
                alert('Data Berhasil Dihapus..!!');
                exit();
            }
         });
        });

		$("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 
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
<h3 align="center"><u><b><a>INPUTAN MASTER REKENING KELOMPOK</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="10%">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td>               
        
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
		<!--<td><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a></td>-->
        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA REKENING KELOMPOK" style="width:900px;height:440px;" >  
        </table>
        </td>
        </tr>
    </table>  
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td width="30%">KODE AKUN</td>
                <td width="1%">:</td>
                <td><input type="text" id="rek1" style="width:50px;"/><input type="text" id="nm_u" style="width:310px;"/></td>  
            </tr> 
           <tr>
                <td width="30%">KODE REKENING</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode" style="width:100px;"/></td>  
            </tr>
                       
            <tr>
                <td width="30%">NAMA REKENING</td>
                <td width="1%">:</td>
                <td><input type="text" id="nama" style="width:360px;"/></td>  
            </tr>
          
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_rek2();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>