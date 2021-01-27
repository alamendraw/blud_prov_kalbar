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
    var cid  = 0;
    var lcidx       = 0;
    var lcstatus    = '';
    
    //var status_rka='0';
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 400,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){ 
        $('#kode').combogrid({  
           panelWidth:700,  
           idField:'kd_skpd',  
           textField:'kd_skpd',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/rka_blud/skpd',  
           columns:[[  
               {field:'kd_skpd',title:'Kode BLUD',width:200},  
               {field:'nm_skpd',title:'Nama BLUD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               kd = rowData.kd_skpd;               
               $("#nmskpd").attr("value",rowData.nm_skpd.toUpperCase());                
           }  
       });
	   
        $('#tgldpa').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
         $('#tgldppa').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
            onSelect: function(date){
		      jaka = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	       }
        });
		
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/rka_blud/load_pengesahan_rba',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true", 
            onSelect:function(rowIndex,rowData){
                ckd_skpd = rowData.kd_skpd;
                cnm_skpd = rowData.nm_skpd;
                csts_dpa = rowData.statu;
                csts_dppa = rowData.status_ubah;
                cno_dpa = rowData.no_dpa;
                ctgl_dpa = rowData.tgl_dpa;
                cno_dppa = rowData.no_dpa_ubah;
                ctgl_dppa = rowData.tgl_dpa_ubah;
                get(ckd_skpd,csts_dpa,csts_dppa,cno_dpa,ctgl_dpa,cno_dppa,ctgl_dppa); 
                lcidx = rowIndex;                           
            },
            onDblClickRow:function(rowIndex,rowData){
                lcidx = rowIndex;
                judul = 'Edit Pengesahan DPA & DPPA'; 
                //get_rka_sah();
                edit_data();   
            }
        });		
		
    });        

    function get(ckd_skpd,csts_dpa,csts_dppa,cno_dpa,ctgl_dpa,cno_dppa,ctgl_dppa){
	
        $("#kode").combogrid("setValue",ckd_skpd);
       
        if (csts_dpa==1){            
            $("#stsdpa").attr("checked",true);
        } else {
            $("#stsdpa").attr("checked",false);
        }
		
        if (csts_dppa==1){            
            $("#stsdppa").attr("checked",true);
        } else {
            $("#stsdppa").attr("checked",false);
        }			
		
        $("#dpa").attr("value",cno_dpa);
        $("#tgldpa").datebox("setValue",ctgl_dpa);
        $("#dppa").attr("value",cno_dppa);
        $("#tgldppa").datebox("setValue",ctgl_dppa);			
    }
  
    function kosong(){
        $("#kode").combogrid("setValue",'');
        $("#nmskpd").attr("value",'')
        $("#stsdpa").attr("checked",false);
        $("#stsdppa").attr("checked",false);		
        $("#dpa").attr("value",'');
        $("#tgldpa").datebox("setValue",'');
        $("#dppa").attr("value",'');
        $("#tgldppa").datebox("setValue",'');
    }
    
    function cari(){
        var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
        $('#dg').edatagrid({
                url: '<?php echo base_url(); ?>/index.php/rka/load_pengesahan_dpa',
                queryParams:({cari:kriteria})
           });        
        });
    }
	
    function simpan_pengesahan(){
        var ckd = $('#kode').combogrid('getValue');
        var cst1 = document.getElementById('stsdpa').checked;
        
//        if(status_rka=='0'){
//            alert('Tidak bisa sahkan DPA, \nRKA Belum disetujui');                
//            exit();
//        }else{
            if (cst1==false){
                cst1=0;
            }else{
                cst1=1;
            }

            var cst2 = document.getElementById('stsdppa').checked;
            if (cst2==false){
                cst2=0;
            }else{
                cst2=1;
            }

            var cno1 = document.getElementById('dpa').value;
            var ctgl1 = $('#tgldpa').datebox('getValue');
            var cno2 = document.getElementById('dppa').value;
            var ctgl2 = $('#tgldppa').datebox('getValue');
            //alert(ckd);
            if (ckd==''){
                alert('SKPD Tidak Boleh Kosong');
                exit();
            }

            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/rka_blud/simpan_pengesahan',
                    data: ({tabel:'trhrka_blud',kdskpd:ckd,stdpa:cst1,stdppa:cst2,no:cno1,tgl:ctgl1,no2:cno2,tgl2:ctgl2}),
                    dataType:"json"
                });
            });

            alert("Data Berhasil disimpan");
            $("#dialog-modal").dialog('close');
            $('#dg').edatagrid('reload');
        //}	
    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Pengesahan DPA & DPPA';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
		
     function keluar(){
        $("#dialog-modal").dialog('close');
		lcstatus = 'edit';
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
        
//    function get_rka_sah(){
//        var xxskpd = $('#kode').combogrid('getValue');
//        $.ajax({
//            url     : '<?php echo base_url(); ?>index.php/rka/get_rka_sah',
//            type    : 'POST',
//            dataType: 'json',
//            data    : ({skpd:xxskpd}),
//            success: function (data) {
//                    status_rka = data.status_rka;
//                    }
//        });
//    }
    
    function cellStyler(value, row, index) {
        var col;
        if (row.kd_skpd != null) {
            if(row.statu == 0){
                col = '<input type="checkbox" onclick="return false"/>';
            }else col = '<input type="checkbox" checked = true onclick="return false">';
            
        }
        return col;
    }
    function cellStyler1(value, row, index) {
        var col;
        if (row.kd_skpd != null) {
            if(row.status_ubah == 0){
                col = '<input type="checkbox" onclick="return false" />';
            }else col = '<input type="checkbox" checked=true onclick="return false"/>';
        }
        return col;
    }
    
  
</script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>PENGESAHAN RBA & RBA PERUBAHAN</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        	
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>

        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA PENGESAHAN" style="width:900px;height:470px;" > 
            <thead>
                <tr>
                    <th data-options="field:'kd_skpd', width:2, align:'center'" rowspan="2">Kode BLUD</th>
                    <th data-options="field:'nm_skpd', width:7, align:'left'" rowspan="2">Nama BLUD</th>
                    <th colspan="3">RBA</th>
                    <th Colspan="3">RBA Perubahan</th>
                </tr>
                <tr>
                    <th data-options="field:'statu', width:2, align:'center', formatter:cellStyler">Status</th>
                    <th data-options="field:'no_dpa', width:2, align:'center'">Nomor </th>
                    <th data-options="field:'tgl_dpa', width:2, align:'center'">Tanggal </th>
                    <th data-options="field:'status_ubah', width:2, align:'center', formatter:cellStyler1">Status</th>
                    <th data-options="field:'no_dpa_ubah', width:2, align:'center'">Nomor </th>
                    <th data-options="field:'tgl_dpa_ubah', width:2, align:'center'">Tanggal </th>
                </tr>
            </thead>
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
                <td width="30%" >BLUD</td>
                <td width="1%">:</td>
                <td>
                    <input id="kode" disabled="true" style="width:200px;"/>
                    <input type="text" id="nmskpd" style="border:0;width:350px;"/>
                </td>
            </tr>
        </table>
        <hr>
        <table align="center" style="width:100%;" border="0">
            <tr>
                <td width="30%">Pengesahan RBA</td>
                <td width="1%">:</td>
                <td><input type="checkbox" id="stsdpa"  onclick="javascript:runEffect();"/></td>
            </tr>
            <tr>
                <td width="30%">NO. RBA</td>
                <td width="1%">:</td>
                <td><input type="text" id="dpa" style="width:200px;"/></td>  
            </tr>
            <tr>
                <td width="30%">TGL RBA</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgldpa" style="width:150px;"/></td>  
            </tr>
                        
        </table>
        </hr>
        <hr></hr>
        <table align="center" style="width:100%;" border="0">
            <tr>
                <td width="30%">Pengesahan RBA Perubahan</td>
                <td width="1%">:</td>
                <td><input type="checkbox" id="stsdppa"  onclick="javascript:runEffect();"/></td>
            </tr>

            <tr>
                <td width="30%">No. RBA Perubahan</td>
                <td width="1%">:</td>
                <td><input type="text" id="dppa" style="width:200px;"/></td> 				
            </tr>

            <tr>
                <td width="30%">TGL RBA Perubahan</td>
                <td width="1%">:</td>
                <td><input type="text" id="tgldppa" style="width:150px;"/></td>  
            </tr>  
            
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            
            <tr>
                <td colspan="5" align="center">
                    <a class="easyui-linkbutton" iconCls="icon-save" plain="false" onclick="javascript:simpan_pengesahan();">Simpan</a>
                    <a class="easyui-linkbutton" iconCls="icon-undo" plain="false" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>