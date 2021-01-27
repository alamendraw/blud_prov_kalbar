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
            height: 460,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){  
        
     $('#kd_rek6').combogrid({  
       panelWidth:500,  
       idField:'kd_rek6',  
       textField:'kd_rek6',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_rekening6_blud',  
       columns:[[  
           {field:'kd_rek6',title:'Kode Rekening',width:100},  
           {field:'nm_rek6',title:'Nama Rekening',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
           // kd_rek13 = rowData.kd_rek5;
            $("#kd_rek7").attr("value",rowData.kd_rek6);
            var cek = rowData.kd_rek6.substring(0,1);
           if(cek == '5' || cek == '4'){
            $('#r').show();
            rek513(rowData.kd_rek6);
           }else{
            $('#r').hide();
           }
            $('#nm_rek6').attr("value",rowData.nm_rek6.toUpperCase());
                           
       }  
     });
  //   var kd_rek6 = document.getElementById('kd_rek6').value;
  function rek513(kd_rek6){
    $('#kd_rek5_13').attr('disabled',false);
     $('#kd_rek5_13').combogrid({  
       panelWidth:500,  
       idField:'kd_rek5',  
       textField:'kd_rek5',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_rekening5_13',  
       columns:[[  
           {field:'kd_rek5',title:'Kode Rekening',width:100},  
           {field:'nm_rek5',title:'Nama Rekening',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
        $('#nm_rek5_13').attr("value",rowData.nm_rek5.toUpperCase());
       }  
     });
}
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_rekening7_blud',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {field:'kd_rek7',
    		title:'Kode rek Blud',
    		width:10,
            align:"center"},
            {field:'nm_rek7',
    		title:'Nama Rekening Blud',
    		width:35},
    	    {field:'kd_rek13',
    		title:'Kode Rekening Anggaran',
    		width:10,
            align:"center"}
        ]],
        onSelect:function(rowIndex,rowData){
          kd_s = rowData.kd_rek7;
          nm_s = rowData.nm_rek7;
          kd_6 = rowData.kd_rek6;
          kd_rek13 = rowData.kd_rek13;
          nm_rek13 = rowData.nm_rek13;
          kd_rek4_13 = rowData.kd_rek4_13;
          get(kd_s,nm_s,kd_6,kd_rek13,nm_rek13,kd_rek4_13); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
            kd_s       = rowData.kd_rek7;
            nm_s       = rowData.nm_rek7;
            kd_6       = rowData.kd_rek6;
            kd_rek13   = rowData.kd_rek13;
            nm_rek13   = rowData.nm_rek13;
            kd_rek4_13 = rowData.kd_rek4_13;
            get(kd_s,nm_s,kd_6,kd_rek13,nm_rek13,kd_rek4_13);
           lcidx = rowIndex;
           judul = 'Edit Data Urusan'; 
           edit_data();   
        }
        
        });
       
    });        

 
    
    function get(kd_s,nm_s,kd_6,kd_rek13,nm_rek13,kd_rek4_13) {
        $("#kd_rek6").combogrid("setValue",kd_6);
        $("#kd_rek7").attr("value",kd_s);
        $("#nm_rek7").attr("value",nm_s);
        $("#kd_rek5_13").combogrid("setValue",kd_rek13);
        $("#nm_rek5_13").attr("value",nm_rek13);
    }
       
    function kosong(){
        $("#kd_rek7").attr("value",'');
        $("#nm_rek7").attr("value",'');
        $("#kd_rek13").combogrid("setValue",'');
        $("#nm_rek13").attr("value",'');
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
		url: '<?php echo base_url(); ?>/index.php/master/load_rekening7_blud',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
    function simpan_rek5(){
       
        var ckd_rek7 = document.getElementById('kd_rek7').value;
        var cnm_rek7 = document.getElementById('nm_rek7').value;
        var ckd_rek6 = ckd_rek7.substring(0,8);
        var ckd_rek4_13 = document.getElementById('kd_rek4_13').value;
        var cnm_rek13 = document.getElementById('nm_rek5_13').value;
        var ckd_rek13= $('#kd_rek5_13').combogrid('getValue');
        if (ckd_rek7==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (cnm_rek13==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (cnm_rek7==''){
            alert('Nama  Tidak Boleh Kosong');
            exit();
        }
        if(lcstatus=='tambah'){ 
            
            lcinsert  = "(kd_rek7,kd_rek6,nm_rek7,kd_rek13,kd_rek4_13,nm_rek13)";
            lcvalues  = "('"+ckd_rek7+"','"+ckd_rek6+"','"+cnm_rek7+"','"+ckd_rek13+"','"+ckd_rek4_13+"','"+cnm_rek13+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master',
                    data: ({tabel:'ms_rek7_blud',kolom:lcinsert,nilai:lcvalues,cid:'kd_rek7',lcid:ckd_rek7}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            // exit();
                            return;
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            // exit();
                            return;
                        }else{
                            alert('Data Tersimpan..!!');
                            // exit();
                            return;
                        }
                    }
                });
            });   
           
        } else{
             
            lcquery = "UPDATE ms_rek7_blud SET kd_rek7='"+ckd_rek7+"',kd_rek6='"+ckd_rek6+"',nm_rek7='"+cnm_rek7+"',kd_rek13='"+ckd_rek13+"',kd_rek4_13='"+ckd_rek4_13+"',nm_rek13='"+cnm_rek13+"' where kd_rek7='"+ckd_rek7+"'";

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
                            // exit();
                            return;
                        }else{
                            alert('Data Tersimpan..!!');
                            // exit();
                            return;
                        }
                    }
            });
            });
            
            
        }
        
        
        alert("Data Berhasil disimpan");
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Rincian Objek';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        //document.getElementById("kode").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Rincian Objek';
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
		 
			var url    = "<?php echo site_url(); ?>/ctk_mrek/cetak_rek5";	  
			window.open(url,'_blank');
			window.focus();
	 }

     
     function hapus(){
        var ckode = document.getElementById('kd_rek7').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
        var tny = confirm('Yakin Ingin Menghapus Data, Kode Rekening : '+ckode);

        if (tny==true) {
        $(document).ready(function(){
         $.post(urll,({tabel:'ms_rek7_blud',cnid:ckode,cid:'kd_rek7'}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                $('#dg').datagrid('deleteRow',lcidx);   
                alert('Data Berhasil Dihapus..!!');
                $("#dialog-modal").dialog('close');
                // exit();
                $('#dg').datagrid('reload');
            }
         });
        });
        };    
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
<h3 align="center"><u><b><a>INPUTAN MASTER REKENING RINCIAN OBJEK</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="10%">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td>               
        
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
		<td><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a></td>
        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA REKENING RINCIAN OBJEK" style="width:900px;height:440px;" >  
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
                <td width="30%">KODE REKENING 6</td>
                <td width="1%">:</td>
                <td><input type="text" id="kd_rek6" style="width:100px;"/><input type="text" id="nm_rek6" readonly="" style="width:310px;background-color: #00FFFF;"/></td>  
            </tr> 
            <input type="text" id="kd_rek4_13" style="width:100px;" hidden="" />
            <tr>
                <td width="30%">KODE REKENING 7</td>
                <td width="1%">:</td>
                <td><input type="text" id="kd_rek7" style="width:100px;"/><input type="text" id="nm_rek7" style="width:310px;"/></td> 
            </tr> 
            <tr id="r">
                <td width="30%">KODE REKENING 5 13</td>
                <td width="1%">:</td>
                <td><input type="text" id="kd_rek5_13" disabled="" style="width:100px;"/><input type="text" id="nm_rek5_13" readonly="" style="width:310px;background-color: #00FFFF;"/></td> 
            </tr> 
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_rek5();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>