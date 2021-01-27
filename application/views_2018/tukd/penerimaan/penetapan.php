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
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert2.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert2.css" />
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
            height: 360,
            width: 900,
            modal: true,
            autoOpen:false,
        });
        get_skpd();
        get_tahun();
        });    
    
     
     $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_tetap',
        idField       : 'id',            
        rownumbers    : "true", 
        fitColumns    : "true",
        singleSelect  : "true",
        autoRowHeight : "false",
        loadMsg       : "Tunggu Sebentar....!!",
        pagination    : "true",
        nowrap        : "true",                       
        columns:[[
    	    {field:'no_tetap',
    		title:'Nomor Tetap',
    		width:50,
            align:"left"},
            {field:'tgl_tetap',
    		title:'Tanggal',
    		width:30},
            {field:'kd_skpd',
    		title:'B L U D',
    		width:30,
            align:"center"},
            {field:'kd_rek',
    		title:'Rekening',
    		width:50,
            align:"center"},
            {field:'nilai',
    		title:'Nilai',
    		width:50,
            align:"center"}
        ]],
        onSelect:function(rowIndex,rowData){
          nomor   = rowData.no_tetap;
          tgl     = rowData.tgl_tetap;
          kode    = rowData.kd_skpd;
          lcket   = rowData.keterangan;
          lcrek   = rowData.kd_rek5;
          nm_rek5   = rowData.nm_rek5;
          rek     = rowData.kd_rek;
          lcnilai = rowData.nilai;
          lcidx   = rowIndex;
          get(nomor,tgl,kode,lcket,lcrek,rek,lcnilai,nm_rek5);   
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Penetapan'; 
           edit_data();   
           lcstatus = 'edit';
        }
        });
        
        
        $('#tanggal').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
    


      
    });
    
    function get_skpd(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
					$("#skpd").attr("value",data.kd_skpd);
					$("#nmskpd").attr("value",data.nm_skpd);
					kode = data.kd_skpd;
					validate_rek();
        		}                                     
        	});
        }
		
	 function get_tahun(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_blud/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        }
        
     function validate_rek(){
	  	$(function(){
        $('#rek').combogrid({  
           panelWidth:500,  
           idField:'kd_rek5',  
           textField:'kd_rek5',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd_blud/ambil_rek_tetap/'+kode,             
           columns:[[  
               {field:'kd_rek5',title:'Kode Rek',width:100},  
			   {field:'nm_rek',title:'Uraian Rinci',width:400}
              ]],
               onSelect:function(rowIndex,rowData){
               $("#nmrek").attr("value",rowData.nm_rek.toUpperCase());
               $("#rek1").attr("value",rowData.kd_rek);
               $("#giat").attr("value",rowData.kd_kegiatan);
			   kd_kegiatan = rowData.kd_kegiatan;
			   kd_rek5 = rowData.kd_rek5;
			   validate_rek_blud(kode,kd_kegiatan,kd_rek5);
              }    
            });
	  	    });
		}

    
	 function validate_rek_blud(kode,kd_kegiatan,kd_rek5){
	  	$(function(){
        $('#rek_blud').combogrid({  
           panelWidth:500,  
           idField:'kd_rek5_blud',  
           textField:'kd_rek5_blud',  
           mode:'remote',
		   queryParams: ({skpd:kode,giat:kd_kegiatan,kd_rek5:kd_rek5}),
           url:'<?php echo base_url(); ?>index.php/tukd_blud/ambil_rek_blud',             
           columns:[[  
               {field:'kd_rek5_blud',title:'Kode Rek',width:100},  
			   {field:'nm_rek5_blud',title:'Uraian Rinci',width:400}
              ]],
               onSelect:function(rowIndex,rowData){
               $("#nmrek_blud").attr("value",rowData.nm_rek5_blud.toUpperCase().trim());
              }    
            });
	  	    });
		}
	
    function section2(){
         $(document).ready(function(){    
             $('#section2').click();                                               
         });   
    }

    
    function section1(){
         $(document).ready(function(){    
             $('#section1').click();   
             $('#dg').edatagrid('reload');                                              
         });
     }
    
       
       
    function get(nomor,tgl,kode,lcket,lcrek,rek,lcnilai,nm_rek5){
        $("#nomor").attr("value",nomor);
        $("#nomor_hide").attr("value",nomor);
        $("#tanggal").datebox("setValue",tgl);
        $("#rek").combogrid("setValue",lcrek);
        $("#rek_blud").combogrid("setValue",rek);
        $("#nilai").attr("value",lcnilai);
        $("#ket").attr("value",lcket);
        $("#nmrek").attr("value",nm_rek5);
    }
    
    function kosong(){
        $("#nomor").attr("value",'');
        $("#nomor_hide").attr("value",'');
        $("#tanggal").datebox("setValue",'');
        $("#rek").combogrid("setValue",'');
        $("#rek1").attr("Value",'');
        $("#nmrek").attr("value",'');
        $("#nilai").attr("value",'');        
        $("#ket").attr("value",'');         
        lcstatus = 'tambah';       
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_tetap',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
    
    function simpan_tetap(){
        
        var cno      = document.getElementById('nomor').value;
        var cno_hide = document.getElementById('nomor_hide').value;
        var ctgl     = $('#tanggal').datebox('getValue');
        var cskpd    = document.getElementById('skpd').value;
        var cnmskpd  = document.getElementById('nmskpd').value ;
        var lckdrek  = $('#rek').combogrid('getValue');
        var rek_blud  = $('#rek_blud').combogrid('getValue');
        var rek      = document.getElementById('rek1').value;
        var kegi      = document.getElementById('giat').value;
        var lcket    = document.getElementById('ket').value;
        var lntotal  = angka(document.getElementById('nilai').value);
            lctotal  = number_format(lntotal,0,'.',',');
       
	   if (cno==''){
            swal("Error", "Nomor Penetapan Tidak Boleh Kosong", "warning");
            exit();
        }
		
		var tahun_input = ctgl.substring(0, 4);
		
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun Tidak Sama Dengan Tahun Anggaran", "warning");
			exit();
		}
		
        if (ctgl==''){
            swal("Error", "Tanggal Tidak Boleh Kosong", "warning");
            exit();
        }
		
        if (cskpd==''){
            swal("Error", "Kode SKPD Tidak Boleh Kosong", "warning");
            exit();
        }
		if(kegi==''){
			swal("Error", "Kode Kegiatan Tidak Boleh Kosong", "warning");
            exit();
		}
		
		if(lckdrek==''){
			swal("Error", "Kode Rekening Tidak Boleh Kosong", "warning");
            exit();
		}
        
		if(rek_blud==''){
			swal("Error", "Kode Rekening BLUD Tidak Boleh Kosong", "warning");
            exit();
		}
        
		if ( lcstatus == 'tambah'){
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:cno,tabel:'tr_tetap_blud',field:'no_tetap'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						swal("Error", "Nomor Telah Dipakai!", "warning");
						exit();
						} 
						
            lcinsert        = " ( no_tetap,  tgl_tetap,  kd_skpd, kd_kegiatan,     kd_rek5,   kd_rek_blud,     nilai,         keterangan  ) ";
            lcvalues        = " ( '"+cno+"', '"+ctgl+"', '"+cskpd+"', '"+kegi+"', '"+lckdrek+"', '"+rek_blud+"', '"+lntotal+"', '"+lcket+"' ) ";
            
            $(document).ready(function(){
                $.ajax({
                    type     : "POST",
                    url      : '<?php echo base_url(); ?>/index.php/tukd_blud/simpan_tetap_ag',
                    data     : ({tabel       :'tr_tetap_blud',  kolom       :lcinsert,        nilai       :lcvalues,        cid       :'no_tetap',   lcid       :cno}),
                    dataType : "json",
                    success  : function(data) {
                        status = data;
                        if ( status == '0') {
							swal("Error", "Gagal Simpan", "warning");
                            exit();
                        }  else {
							swal("Berhasil", "Data Berhasil Tersimpan", "success");
                                lcstatus = 'edit';
								$("#dialog-modal").dialog('close');
                                $('#dg').edatagrid('reload');
                        }
                    }
                });
            });   
           
       //akhir-mulai 
        //}
		}
		});
		});
		
		
       } else {
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:cno,tabel:'tr_tetap_blud',field:'no_tetap'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && cno!=cno_hide){
						swal("Error", "Nomor Telah Dipakai", "warning");
						exit();
						} 
						if(status_cek==0 || cno==cno_hide){
						
            lcinsert        = " ( no_tetap,  tgl_tetap,  kd_skpd, kd_kegiatan,     kd_rek5,   kd_rek_blud,     nilai,         keterangan  ) ";
            lcvalues        = " ( '"+cno+"', '"+ctgl+"', '"+cskpd+"', '"+lckdrek+"', '"+rek+"', '"+rek_blud+"', '"+lntotal+"', '"+lcket+"' ) ";
            $(document).ready(function(){
            $.ajax({
                type     : "POST",
                url      : '<?php echo base_url(); ?>/index.php/tukd_blud/update_tetap_ag',
                data     : ({tabel       :'tr_tetap_blud',  kolom       :lcinsert,        nilai       :lcvalues,        cid       :'no_tetap',   lcid       :cno,no_hide:cno_hide}),
                dataType : "json",
                success  : function(data){
                           status=data ;
                        if ( status=='2' ){
                                swal("Berhasil", "Data Tersimpan", "success");
								lcstatus = 'edit';
                                $("#nomor_hide").attr("Value",cno) ;
								 $("#dialog-modal").dialog('close');
								 $('#dg').edatagrid('reload');
                        }
                        
                        if ( status=='0' ){
                            swal("Error", "Gagal Simpan", "warning");
                            exit();
                        }
                    }
            });
            });
         //akhir
        }
			}
		});
		});
        }
        
    }
    
    
    function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Penetapan';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul    = 'Input Data Penetapan';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("nomor").disabled=false;
        document.getElementById("nomor").focus();
        } 
     
     
     function keluar(){
        $("#dialog-modal").dialog('close');
     }    
    
     
     function hapus(){
        var urll = '<?php echo base_url(); ?>index.php/tukd_blud/hapus_tetap';
		var del=confirm('Anda yakin akan menghapus Nomor Penetapan '+nomor+'  ?');
		if  (del==true){
			$(document).ready(function(){
			 $.post(urll,({no:nomor,skpd:kode}),function(data){
				status = data;
				if (status=='0'){
					swal("Error", "Gagal Hapus", "warning");
					exit();
				} else {
					$('#dg').datagrid('deleteRow',lcidx);   
					swal("Berhasil", "Data Berhasil Di Hapus", "success");
					exit();
				}
			 });
			});   
		}
		
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
	
	 function input_lengkap( url ){
         window.open(url,'_blank');
         window.focus();
     } 
  
   </script>

</head>
<body>

<div id="content"> 
<div id="accordion">
<h3 align="center"><u><b><a href="#" id="section1">INPUTAN PENETAPAN</a></b></u></h3>
    <div>
    <p align="right">   
      <!-- <a href="<?php echo site_url(); ?>/tukd/penetapan_langsung" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:input_lengkap(this.href);return false">Input Penetapan Penerimaan</a> -->
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="dg" title="Listing data penetapan" style="width:870px;height:450px;" >  
        </table>
 
    </p> 
    </div>   

</div>

</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td>No. TETAP</td>
                <td></td>
                <td><input type="text" id="nomor" style="width: 200px;"/><input type="hidden" id="nomor_hide" style="width: 200px;"/></td>  
            </tr>            
            <tr>
                <td>Tanggal </td>
                <td></td>
                <td><input type="text" id="tanggal" style="width: 140px;" /></td>
            </tr>
            <tr>
                <td>B L U D</td>
                <td></td>
                <td><input id="skpd" name="skpd"  style="width: 140px; border:0;" readonly="true" disabled />  <input type="text" id="nmskpd" style="border:0;width: 600px;" readonly="true"/></td>                            
            </tr>
            <tr>
                <td>Rekening</td>
                <td></td>
                <td><input id="rek" name="rek" style="width: 140px;" /> <input type="hidden" id="rek1" style="width: 140px;" readonly="true"/>
                 <input type="text" id="nmrek" style="border:0;width: 600px;" readonly="true"/></td>                
            </tr>
			<tr>
                <td>Rek. BLUD</td>
                <td></td>
                <td><input id="rek_blud" name="rek_blud" style="width: 140px;" /> 
                 <input type="text" id="nmrek_blud" style="border:0;width: 600px;" readonly="true"/></td>                
            </tr>
            <tr>
                <td>Kegiatan</td>
                <td></td>
                <td><input type="text" id="giat" style="width: 160px;" readonly="true"/>
                 </td>                
            </tr>            
            <tr>
                <td>Nilai</td>
                <td></td>
                <td><input type="text" id="nilai" style="width: 140px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td> 
            </tr>
            <tr>
                <td>Keterangan</td>
                <td colspan="2"><textarea rows="2" cols="50" id="ket" style="width: 740px;"></textarea>
                </td> 
            </tr>
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_tetap();">Simpan</a>
				<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
		        <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>


  	
</body>

</html>