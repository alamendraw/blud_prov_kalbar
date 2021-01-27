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
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert2.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert2.css" />
   <style>    
    #tagih {
        position: relative;
        width: 500px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript">
    var kode     = '';
    var giat     = '';
    var jenis    = '';
    var nomor    = '';
    var cid      = 0;
    var lcstatus = '';
                      
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 650,
                width: 1050,
                modal: true,
                autoOpen:false                
            });              
            $("#tagih").hide();
            get_skpd();
			get_tahun();
			//seting_tombol();
        });    
     
     
     $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/C_Penagihan/load_penagihan_non_ls',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'no_bukti',
    		title:'Nomor Bukti',
    		width:50},
            {field:'tgl_bukti',
    		title:'Tanggal',
    		width:30},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:100,
            align:"left"},
            {field:'ket',
    		title:'Keterangan',
    		width:100,
            align:"left"}
        ]],
        onSelect:function(rowIndex,rowData){
          nomor = rowData.no_bukti;
          tgl   = rowData.tgl_bukti;
          kode  = rowData.kd_skpd;
          ket   = rowData.ket;          
          tot   = rowData.total;
          ststagih=rowData.sts_tagih;
          sts=rowData.status;
		  jenis=rowData.jenis;
		  kontrak=rowData.kontrak;
          get(nomor,tgl,kode,ket,tot,ststagih,sts,jenis,kontrak);   
          load_detail();  
		  load_tot_tagih();
        },
        onDblClickRow:function(rowIndex,rowData){         
            section2(); 
            lcstatus = 'edit';
        }
    });
    
    
    $('#dg1').edatagrid({  
            toolbar:'#toolbar',
            rownumbers:"true", 
            fitColumns:"true",
            singleSelect:"true",
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",            
            nowrap:"true",
            onSelect:function(rowIndex,rowData){                    
                    idx = rowIndex;
                    nilx = rowData.nilai;
            },                                                     
            columns:[[
            {field:'no_bukti',
    		title:'No Bukti',    		
            hidden:"true"},
            {field:'no_sp2d',
    		title:'No SP2D'},
    	    {field:'kd_kegiatan',
    		title:'Kegiatan',
    		width:50},
            {field:'kd_rek5',
    		title:'Rekening',
    		width:30},
			{field:'kd_rek_blud',
    		title:'Rek. BLUD',
    		width:30},
            {field:'nm_rek_blud',
    		title:'Nama Rekening',
    		width:100,
            align:"left"},
            {field:'nilai',
    		title:'Nilai',
    		width:70,
            align:"right"}
            ]]
        });    
                
    $('#dg2').edatagrid({		                
        toolbar:'#toolbar',
		rownumbers:"true", 
		fitColumns:"true",
		singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Tunggu Sebentar....!!",            
		nowrap:"false",
        onSelect:function(rowIndex,rowData){                    
            cidx = rowIndex;            
        },                 
        columns:[[
            {field:'hapus',
    		title:'Hapus',
            width:10,
            align:"center",
            formatter:function(value,rec){                                                                       
                return '<img src="<?php echo base_url(); ?>/assets/images/icon/cross.png" onclick="javascript:hapus_detail();" />';                  
                }                
            },
           {field:'no_bukti',
    		title:'No Bukti',    		
            hidden:"true"},
            {field:'no_sp2d',
    		title:'No SP2D',
			width:20},
    	    {field:'kd_kegiatan',
    		title:'Kegiatan',
    		width:20},
            {field:'kd_rek5',
    		title:'Rekening',
    		width:10},
			{field:'kd_rek_blud',
    		title:'Rek. BLUD',
    		width:10},
            {field:'nm_rek_blud',
    		title:'Nama Rekening',
    		width:70,
            align:"left"},
            {field:'nilai',
    		title:'Nilai',
    		width:10,
            align:"right"}
            ]]        
      });
        
        $('#tanggal').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
           }, onSelect: function(date){
                cek_status_ang();
            }
        });
        
        $('#tgltagih').datebox({  
                required:true,
                formatter :function(date){
                	var y = date.getFullYear();
                	var m = date.getMonth()+1;
                	var d = date.getDate();    
                	return y+'-'+m+'-'+d;
                }
        });
                    
         
        $('#giat').combogrid({  
           panelWidth:700,  
           idField:'kd_kegiatan',  
           textField:'kd_kegiatan',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/C_Penagihan/load_trskpd',
           queryParams:({kd:skpd}),             
           columns:[[  
               {field:'kd_kegiatan',title:'Kode Kegiatan',width:140},  
               {field:'nm_kegiatan',title:'Nama Kegiatan',width:700}
           ]],  
           onSelect:function(rowIndex,rowData){
               idxGiat = rowIndex;               
               giat = rowData.kd_kegiatan;
			   nm_giat = rowData.nm_kegiatan;
               $("#nmkegiatan").attr("value",rowData.nm_kegiatan);
               var nobukti = document.getElementById('nomor').value;
               var kode = document.getElementById('skpd').value;
               var frek = '';
			   kosong2();
			   $('#sp2d').combogrid({url:'<?php echo base_url(); ?>index.php/C_Penagihan/load_sp2d',
			   queryParams:({giat:giat,	kd:kode})
			   });
              
           }
		   
        });
        
		$('#sp2d').combogrid({  
           panelWidth:250,  
           idField:'no_sp2d',  
           textField:'no_sp2d',  
           mode:'remote',
           queryParams:({kd:kode}),             
           columns:[[  
               {field:'no_sp2d',title:'NO SP2D',width:140},  
               {field:'total',title:'Nilai',width:100}
           ]],  
           onSelect:function(rowIndex,rowData){
              sp2d        = rowData.no_sp2d;
              var kode    = document.getElementById('skpd').value;
			  var giat    	= $('#giat').combogrid('getValue');
              $('#rek').combogrid({url:'<?php echo base_url(); ?>index.php/C_Transout/load_rek',
			   queryParams:({no:'',
							giat:giat,
							kd:kode,
							sp2d:sp2d})
			   });
           }  
        });

		 
        
        
		$('#kontrak').combogrid({  
                panelWidth:200,  
                url: '<?php echo base_url(); ?>/index.php/C_Penagihan/kontrak',  
                    idField:'kontrak',  
                    textField:'kontrak',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                           {field:'kontrak',title:'Kontrak',width:40} 
                       ]],  
                    onSelect:function(rowIndex,rowData){
                    //$("#kode").attr("value",rowData.kode);
                    $("#kontrak").attr("value",rowData.kontrak);	
                    }   
        });
        
		
		
		$('#rek').combogrid({  
           panelWidth:350,  
           idField:'kd_rek5',  
           textField:'kd_rek5',  
           mode:'remote',                                   
           columns:[[  
		       {field:'kd_rek5',title:'Kode Rekening Ang.',width:70,align:'center'},  
               {field:'kd_rek_blud',title:'Kode Rekening',width:70,align:'center'},  
               {field:'nm_rek_blud',title:'Nama Rekening',width:200}
           ]],
           onSelect:function(rowIndex,rowData){
		   $("#rek_blud").attr("value",rowData.kd_rek_blud);   
		   $("#nmrek").attr("value",rowData.nm_rek5);   
		   $("#nmrek_blud").attr("value",rowData.nm_rek_blud);   
			var sp2d    = $('#sp2d').combogrid('getValue');
			var giat    = $('#giat').combogrid('getValue');
			var kode    = document.getElementById('skpd').value;
		 	var koderek = rowData.kd_rek5 ;
            var koderekblud = rowData.kd_rek_blud ;
			   $.ajax({
					type     : "POST",
					dataType : "json",   
					data     : ({kegiatan:giat,kdrek5:koderek,kdrekblud:koderekblud,kd_skpd:kode,jns:'1',sp2d:sp2d}), 
					url      : '<?php echo base_url(); ?>index.php/C_Transout/jumlah_ang_trans',
					success  : function(data){
						  $.each(data, function(i,n){
							
							var n_ang  = n['nilai'] ;
							var n_ang_semp  = n['nilai_sempurna'] ;
							var n_ang_ubah  = n['nilai_ubah'] ;
							var n_spp  = n['nilai_spp_lalu'] ;
							var n_sisa = angka(n_ang) - angka(n_spp) ;
							var n_sisa_semp = angka(n_ang_semp) - angka(n_spp) ;
							var n_sisa_ubah = angka(n_ang_ubah) - angka(n_spp) ;
							$("#sisa").attr("Value",number_format(n_sisa,2,'.',','));
							$("#sisa_semp").attr("Value",number_format(n_sisa_semp,2,'.',','));
							$("#sisa_ubah").attr("Value",number_format(n_sisa_ubah,2,'.',','));
							document.getElementById('nilai').select();
						});
					}                                     
			   });
           }
        });                        
    }); 
    
	function load_total_spd(giat){
		var kode = document.getElementById('skpd').value;
		$(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/C_Penagihan/load_total_spd",
            dataType:"json",
			data: ({giat:giat,kode:kode}),
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#tot_spd").attr("value",n['total_spd']);
                });
            }
         });
        });
    }
    function load_total_trans(giat){
		var no_simpan = document.getElementById('no_simpan').value;  
		var kode = document.getElementById('skpd').value;
        
		$(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd2/load_total_trans_tagih",
            dataType:"json",
			data: ({giat:giat,kode:kode,no_simpan:no_simpan}),
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#tot_trans").attr("value",n['total']);
                });
			 $("#rek").combogrid('enable');
            }
         });
        });
    }
	
	function total_sisa_spd(){ 
        var tot_spd   = angka(document.getElementById('tot_spd').value);  
       var tot_trans = angka(document.getElementById('tot_trans').value);  
		   totsisa = tot_spd-tot_trans;
		
	   $('#sisa_spd').attr('value',number_format(totsisa,2,'.',','));

    }
	
    function get_skpd() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
					$("#skpd").attr("value",data.kd_skpd);
					$("#nmskpd").attr("value",data.nm_skpd);
					skpd = data.kd_skpd;
					 kegia();                 
        		}                                     
        	});  
        } 
	
	function seting_tombol(){
		$('#tambah').linkbutton('disable');
		$('#save').linkbutton('disable');
        $('#del').linkbutton('disable');
        //document.getElementById("p1").innerHTML="Batas Pembuatan SPP LS sudah selesai";
	}
	
    function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Penagihan/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        }

    function cek_status_ang(){
        var tgl_cek = $('#tanggal').datebox('getValue');      
            $.ajax({
                url:'<?php echo base_url(); ?>index.php/tukd_blud/cek_status_ang',
                data: ({tgl_cek:tgl_cek}),
                type: "POST",
                dataType:"json",                         
                success:function(data){
                $("#status_ang").attr("value",data.status_ang);
            }  
            });
        }
    
    function kegia(){
      $('#giat').combogrid({url:'<?php echo base_url(); ?>index.php/C_Penagihan/load_trskpd',queryParams:({kd:skpd,jenis:'52'})});  
    }
               
    
    function hapus_detail(){
        var rows = $('#dg2').edatagrid('getSelected');
        cgiat    = rows.kd_kegiatan;
        crek     = rows.kd_rek5;
        cnil     = rows.nilai;
        var idx = $('#dg2').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, Kegiatan : '+cgiat+' Rekening : '+crek+' Nilai : '+cnil);
        if (tny==true){
            $('#dg2').edatagrid('deleteRow',idx);
            $('#dg1').edatagrid('deleteRow',idx);
            total = angka(document.getElementById('total1').value) - angka(cnil);            
            $('#total1').attr('value',number_format(total,2,'.',','));    
            $('#total').attr('value',number_format(total,2,'.',','));
            kosong2();
            
        } 
    }
    
    function load_tot_tagih(){ 
		var nomor    = document.getElementById("nomor").value;
        var cskpd = document.getElementById("skpd").value;     	
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({no:nomor,skpd:cskpd}),
            url:"<?php echo base_url(); ?>index.php/C_Penagihan/load_tot_tagih",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#total").attr("value",n['total']);
                });
            }
         });
        });
    }
    
    function load_detail(){        
        var kk    = document.getElementById("nomor").value;
        var cskpd = document.getElementById("skpd").value;            
            $(document).ready(function(){
            $.ajax({
                type     : "POST",
                url      : '<?php echo base_url(); ?>index.php/C_Penagihan/load_dtagih',
                data     : ({no:kk,skpd:cskpd}),
                dataType : "json",
                success  : function(data){                                          
                    $.each(data,function(i,n){                                    
                    no        = n['no_bukti'];
                    sp2d      = n['no_sp2d'];
                    giat      = n['kd_kegiatan'];
                    rek5      = n['kd_rek5'];
                    rek_blud  = n['kd_rek_blud'];
                    nmrek_blud= n['nm_rek_blud'];
                    nil       = number_format(n['nilai'],2,'.',',');
                    $('#dg1').edatagrid('appendRow',{no_bukti:no,no_sp2d:sp2d,kd_kegiatan:giat,kd_rek5:rek5,nm_rek_blud:nmrek_blud,nilai:nil,kd_rek_blud:rek_blud});                                                                                                                                                                                                                                                                                                                                                                                             
                    });                                                                           
                }
            });
           });                
           set_grid();                                                  
    }
    
    
    
    function set_grid(){
        $('#dg1').edatagrid({                                                                   
            columns:[[
                {field:'no_bukti',
    		title:'No Bukti',    		
            hidden:"true"},
            {field:'no_sp2d',
    		title:'No SP2D'},
    	    {field:'kd_kegiatan',
    		title:'Kegiatan',
    		width:50},
            {field:'kd_rek5',
    		title:'Rekening',
    		width:30},
			{field:'kd_rek_blud',
    		title:'Rek. BLUD',
    		width:30},
            {field:'nm_rek_blud',
    		title:'Nama Rekening',
    		width:100,
            align:"left"},
            {field:'nilai',
    		title:'Nilai',
    		width:70,
            align:"right"}
            ]]
        });                 
    }
    
    
    
    function load_detail2(){        
       $('#dg1').datagrid('selectAll');
       var rows = $('#dg1').datagrid('getSelections');             
       if (rows.length==0){
            set_grid2();
            exit();
       }                     
		for(var p=0;p<rows.length;p++){
            no      	= rows[p].no_bukti;
            sp2d    	= rows[p].no_sp2d;
            giat    	= rows[p].kd_kegiatan;
            rek5    	= rows[p].kd_rek5;
            rek_blud	= rows[p].kd_rek_blud;
            nmrek_blud	= rows[p].nm_rek_blud;
            nil     	= rows[p].nilai;
            $('#dg2').edatagrid('appendRow',{no_bukti:no,no_sp2d:sp2d,kd_kegiatan:giat,kd_rek5:rek5,kd_rek_blud:rek_blud,nm_rek_blud:nmrek_blud,nilai:nil});            
        }
        $('#dg1').edatagrid('unselectAll');
    } 
    
    
    
    function set_grid2(){
        $('#dg2').edatagrid({      
         columns:[[
            {field:'hapus',
    		title:'Hapus',
            width:10,
            align:"center",
            formatter:function(value,rec){                                                                       
                return '<img src="<?php echo base_url(); ?>/assets/images/icon/cross.png" onclick="javascript:hapus_detail();" />';                  
                }                
            },
            {field:'no_bukti',
    		title:'No Bukti',    		
            hidden:"true"},
            {field:'no_sp2d',
    		title:'No SP2D',
			width:20},
    	    {field:'kd_kegiatan',
    		title:'Kegiatan',
    		width:20},
            {field:'kd_rek5',
    		title:'Rekening',
    		width:10},
			{field:'kd_rek_blud',
    		title:'Rek. BLUD',
    		width:10},
            {field:'nm_rek_blud',
    		title:'Nama Rekening',
    		width:70,
            align:"left"},
            {field:'nilai',
    		title:'Nilai',
    		width:10,
            align:"right"}
            ]]     
        });
    }
    
    function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                               
         });         
         $('#dg').edatagrid('reload');
         set_grid();
    }
     
     
    function section2(){
         $(document).ready(function(){                
             $('#section2').click(); 
             document.getElementById("nomor").focus();                                              
         });                 
         set_grid();
    }
       
     
    function get(nomor,tgl,kode,ket,tot,ststagih,sts,jenis,kontrak){
        $("#nomor").attr("value",nomor);
        $("#nomor_hide").attr("value",nomor);
        $("#no_simpan").attr("value",nomor);
        $("#tanggal").datebox("setValue",tgl);
        $("#keterangan").attr("value",ket);        
        $("#beban").attr("value",jns);
        $("#status_byr").attr("value",ststagih);
		$("#jns").attr("Value",jenis);
		$("#kontrak").combogrid("setValue",kontrak);
			if (sts==1){            
			   $('#save').linkbutton('disable');
				$('#del').linkbutton('disable');
			} else {
				$('#save').linkbutton('enable');
				 $('#del').linkbutton('enable');
			}    
		//tombol(sts);
    }
    
    function kosong(){
        cdate = '<?php echo date("Y-m-d"); ?>';        
        $("#nomor").attr("value",'');
        $("#nomor_hide").attr("value",'');
        $("#no_simpan").attr("value",'');
        $("#tanggal").datebox("setValue",'');
        $("#keterangan").attr("value",'');
		$("#kontrak").combogrid("setValue",'');
        $("#total").attr("value",'0');         
        document.getElementById("nomor").focus();  
        lcstatus = 'tambah';
    }
    

    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/C_Penagihan/load_penagihan_non_ls',
        queryParams:({cari:kriteria})
        });        
     });
    }    
        

    function append_save(){
        var no  		= document.getElementById('nomor').value;
        var sp2d    	= $('#sp2d').combogrid('getValue');
        var giat    	= $('#giat').combogrid('getValue');
        var rek     	= $('#rek').combogrid('getValue');
        var rek_blud   	= document.getElementById('rek_blud').value;
        var nmrek_blud = document.getElementById('nmrek_blud').value;
        var sisa    	= angka(document.getElementById('sisa').value);                
        var sisa_semp 	= angka(document.getElementById('sisa_semp').value);                
        var sisa_ubah 	= angka(document.getElementById('sisa_ubah').value);                
        var nil     	= angka(document.getElementById('nilai').value);        
        var nil_rek     = document.getElementById('nilai').value;        
        var status_ang  = document.getElementById('status_ang').value ;
		var total 		= angka(document.getElementById('total1').value) + nil;

            if (status_ang==''){
                 alert('Pilih Tanggal Dahulu') ;
                 exit();
				}
            if ( nil == 0 ){
                 alert('Nilai Nol.....!!!, Cek Lagi...!!!') ;
                 exit();
				}
			/*
			if ( nil > sisa_spd){
                 alert('Nilai Melebihi Sisa SPD...!!!, Cek Lagi...!!!') ;
                 exit();
            }
			if ( total > sisa_spd){
                 alert('Nilai Melebihi Sisa SPD...!!!, Cek Lagi...!!!') ;
                 exit();
            }
			*/
            if ( (status_ang=='Perubahan')&&(nil > sisa_ubah)){
                 alert('Nilai Melebihi Sisa Anggaran Perubahan...!!!, Cek Lagi...!!!') ;
                 exit();
				}
            if ( (status_ang=='Penyempurnaan')&&(nil > sisa_ubah)){
                 alert('Nilai Melebihi Sisa Anggaran Rencana Perubahan...!!!, Cek Lagi...!!!') ;
                 exit();
				}
            if ( (status_ang=='Penyempurnaan')&&(nil > sisa_semp)){
                 alert('Nilai Melebihi Sisa Anggaran Penyempurnaan...!!!, Cek Lagi...!!!') ;
                 exit();
				}
            if ( (status_ang=='Penyusunan')&&(nil > sisa_ubah)){
                 alert('Nilai Melebihi Sisa Anggaran Rencana Perubahan...!!!, Cek Lagi...!!!') ;
                 exit();
				}
            if ( (status_ang=='Penyusunan')&&(nil > sisa_semp)){
                 alert('Nilai Melebihi Sisa Anggaran Rencana Penyempurnaan...!!!, Cek Lagi...!!!') ;
                 exit();
				}
            if ( (status_ang=='Penyusunan')&&(nil > sisa)){
                 alert('Nilai Melebihi Sisa Anggaran Penyusunan...!!!, Cek Lagi...!!!') ;
                 exit();
				}
            if (giat==''){
                 alert('Pilih Kegiatan Dahulu') ;
                 exit();
				}
			var len = giat.length;
			if (len !=21){
				alert('Format Kegiatan Salah');
				exit();
				}
            if (nmrek==''){
                 alert('Pilih Rekening Dahulu') ;
                 exit();
				}
			$('#dg1').edatagrid('appendRow',{no_bukti:no,
											 no_sp2d:sp2d,
											 kd_kegiatan:giat,
											 kd_rek5:rek,
											 kd_rek_blud:rek_blud,
											 nm_rek_blud:nmrek_blud,
											 nilai:nil_rek});
			$('#dg2').edatagrid('appendRow',{no_bukti:no,
											 no_sp2d:sp2d,
											 kd_kegiatan:giat,
											 kd_rek5:rek,
											 kd_rek_blud:rek_blud,
											 nm_rek_blud:nmrek_blud,
											 nilai:nil_rek});                                                
                kosong2();
                $('#total1').attr('value',number_format(total,2,'.',','));
                $('#total').attr('value',number_format(total,2,'.',','));
             
    }     
    
    function tambah(){
        var nor = document.getElementById('nomor').value;
        var tot = document.getElementById('total').value;
        var kd  = document.getElementById('skpd').value;
		var kontrak  = $('#kontrak').combogrid("getValue");
        $('#dg2').edatagrid('reload');
        $('#total1').attr('value',tot);
        $('#giat').combogrid('setValue','');
        $('#rek').combogrid('setValue','');
        var tgl = $('#tanggal').datebox('getValue');
        if (kd != '' && tgl != '' && nor !='' &&kontrak !=''){            
            $("#dialog-modal").dialog('open'); 
            load_detail2();           
        } else {
            alert('Harap Isi Kode , Tanggal , Nomor Penagihan & Nomor Kontrak ') ;         
        }
    }
    
    function kosong2(){        
        $('#giat').combogrid('setValue','');
        $('#rek').combogrid('setValue','');
        $('#sisa').attr('value','0');
        $('#sisa_semp').attr('value','0');
        $('#sisa_ubah').attr('value','0');
        $('#nilai').attr('value','0');
        $('#rek_blud').attr('value','');
        $('#nmrek_blud').attr('value','');
        $('#nmgiat').attr('value','');        
    }
    
    function keluar(){
        $("#dialog-modal").dialog('close');
        $('#dg2').edatagrid('reload');
        kosong2();                        
    }   
     
    function hapus_giat(){
         tot3 = 0;
         var tot = angka(document.getElementById('total').value);
         tot3 = tot - nilx;
         $('#total').attr('value',number_format(tot3,2,'.',','));        
         $('#dg1').datagrid('deleteRow',idx);              
    }
    
    
    function hapus(){
        var cnomor = document.getElementById('nomor_hide').value;
        var urll = '<?php echo base_url(); ?>index.php/C_Penagihan/hapus_penagihan';
        var tny = confirm('Yakin Ingin Menghapus Data, Nomor Penagihan : '+cnomor);        
        if (tny==true){
        $(document).ready(function(){
        $.ajax({url:urll,
                 dataType:'json',
                 type: "POST",    
                 data:({no:cnomor}),
                 success:function(data){
                        status = data.pesan;
                        if (status=='1'){
                            alert('Data Berhasil Terhapus');         
                        } else {
                            alert('Gagal Hapus');
                        }        
                 }
                 
                });           
        });
        }     
    }
    
    
    function simpan_transout() {
        var cno     	 = (document.getElementById('nomor').value).split(" ").join("");
        var cno_hide 	 = document.getElementById('nomor_hide').value;
        var cjenis_bayar = document.getElementById('status_byr').value;
        var ctgl     	 = $('#tanggal').datebox('getValue');
        var cskpd  	  	 = document.getElementById('skpd').value;
        var cnmskpd  	 = document.getElementById('nmskpd').value;
        var cket     	 = document.getElementById('keterangan').value;
		var jns      	 = document.getElementById('jns').value;
		var kontrak  	 = $('#kontrak').combogrid("getValue");
		var status_ang   = document.getElementById('status_ang').value ;		
        var cjenis   	 = '1';
        var csql     	 = '';
		var tahun_input  = ctgl.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			alert('Tahun tidak sama dengan tahun Anggaran');
			return;
		}
		if (status_ang==''){
                 alert('Pilih Tanggal Dahulu') ;
            return;
            }

        var ctagih    = '';
        var ctgltagih = '2014-12-1';
        var ctotal    = angka(document.getElementById('total').value);        
        
        if ( cno=='' ){
            alert('Nomor Bukti Tidak Boleh Kosong');
            exit();
        } 
        if ( ctgl=='' ){
            alert('Tanggal Bukti Tidak Boleh Kosong');
            exit();
        }
        if ( cskpd=='' ){
            alert('Kode SKPD Tidak Boleh Kosong');
            exit();
        }
		if ( cnmskpd=='' ){
            alert('Nama SKPD Tidak Boleh Kosong');
            exit();
        }
		if ( kontrak=='' ){
            alert('Kontrak Tidak Boleh Kosong');
            exit();
        }
        if ( cket=='' ){
            alert('Keterangan Tidak boleh kosong');
            exit();
        }
		var lenket = cket.length;
		if ( lenket>1000 ){
            alert('Keterangan Tidak boleh lebih dari 1000 karakter');
            exit();
        }
		
		if(lcstatus == 'tambah'){
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:cno,tabel:'trhtagih',field:'no_bukti'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						alert("Nomor Telah Dipakai!");
						document.getElementById("nomor").focus();
						exit();
						} 
						if(status_cek==0){
						alert("Nomor Bisa dipakai");
	//---------------------------
					$('#dg1').datagrid('selectAll');
					var rows = $('#dg1').datagrid('getSelections');           
					for(var p=0;p<rows.length;p++){
						cnobukti   = rows[p].no_bukti;
						csp2d	   = rows[p].no_sp2d;
						ckdgiat    = rows[p].kd_kegiatan;
						crek       = rows[p].kd_rek5;
						crek_blud  = rows[p].kd_rek_blud;
						cnmrek_blud= rows[p].nm_rek_blud;
						cnilai     = angka(rows[p].nilai);
		
						if ( p > 0 ) {
						   csql = csql+","+"('"+cno+"','"+csp2d+"','"+ckdgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek_blud+"','"+cnilai+"','"+cskpd+"')";
						} else {
							csql = "('"+cno+"','"+csp2d+"','"+ckdgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek_blud+"','"+cnilai+"','"+cskpd+"')";                                            
						}
					}
					$(document).ready(function(){
					$.ajax({
						 type     : "POST",   
						 dataType : 'json',                 
						 data     : ({cno:cno,cjenis_bayar:cjenis_bayar,ctgl:ctgl,cskpd:cskpd,cnmskpd:cnmskpd,cket:cket,jns:jns,kontrak:kontrak,cjenis:cjenis,ctotal:ctotal,sql_detail:csql}),
						 url      : '<?php echo base_url(); ?>/index.php/C_Penagihan/simpan_penagihan_non_ls',
						 success  : function(data){                        
									status = data;   
										if ( status=='0' ) {               
											alert('Data Header Gagal Tersimpan');
											return
										}
										if ( status=='1' ) {               
											alert('Data Detail Gagal Tersimpan');
											return
										} 
										if ( status=='2' ) {               
											alert('Data Tersimpan..!!');
											$("#nomor_hide").attr("value",cno);
											$("#no_simpan").attr("value",cno);
											lcstatus = 'edit';
											return
										}
									}
							});
					});            
			//--------------			
		}
		}
		});
		});
	} else{
		$(document).ready(function(){
               // alert(csql);
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:cno,tabel:'trhtagih',field:'no_bukti'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && cno!=cno_hide){
						alert("Nomor Telah Dipakai!");
						exit();
						} 
						if(status_cek==0 || cno==cno_hide){
						alert("Nomor Bisa dipakai");
		//-------------------------------------------------------
					$('#dg1').datagrid('selectAll');
					var rows = $('#dg1').datagrid('getSelections');           
					for(var p=0;p<rows.length;p++){
						cnobukti   = rows[p].no_bukti;
						csp2d      = rows[p].no_sp2d;
						ckdgiat    = rows[p].kd_kegiatan;
						crek       = rows[p].kd_rek5;
						crek_blud  = rows[p].kd_rek_blud;
						cnmrek_blud= rows[p].nm_rek_blud;
						cnilai     = angka(rows[p].nilai);
		
						if ( p > 0 ) {
						   csql = csql+","+"('"+cno+"','"+csp2d+"','"+ckdgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek_blud+"','"+cnilai+"','"+cskpd+"')";
						} else {
							csql = "('"+cno+"','"+csp2d+"','"+ckdgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek_blud+"','"+cnilai+"','"+cskpd+"')";                                            
						}
					}
					$(document).ready(function(){
					$.ajax({
						 type     : "POST",   
						 dataType : 'json',                 
						 data     : ({cno:cno,cnohide:cno_hide,cjenis_bayar:cjenis_bayar,ctgl:ctgl,cskpd:cskpd,cnmskpd:cnmskpd,cket:cket,jns:jns,kontrak:kontrak,cjenis:cjenis,ctotal:ctotal,sql_detail:csql}),
						 url      : '<?php echo base_url(); ?>/index.php/C_Penagihan/update_penagihan_non_ls',
						 success  : function(data){                        
									status = data;   
										if ( status=='0' ) {               
											alert('Data Header Gagal Tersimpan');
											return
										}
										if ( status=='1' ) {               
											alert('Data Detail Gagal Tersimpan');
											return
										} 
										if ( status=='2' ) {               
											alert('Data Tersimpan..!!');
											$("#nomor_hide").attr("value",cno);
											$("#no_simpan").attr("value",cno);
											lcstatus = 'edit';
											return
										}
									}
							});
					});      
		//----------
			}
			}
		});
     });
	
	}
	}

    
    function sisa_bayar(){
        
        var sisa     = angka(document.getElementById('sisa').value);             
        var nil      = angka(document.getElementById('nilai').value);        
        var sisasp2d = angka(document.getElementById('sisasp2d').value);
        var tot      = 0;
        tot          = sisa - nil;
        
        if (nil > sisasp2d) {    
                alert('Nilai Melebihi Sisa Sp2d');
                    exit();
        } else {
            if (tot < 0){
                    alert('Nilai Melebihi Sisa');
                    exit();                
            }
        }           
    }       
                         
                  
    function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
    };              
                             
       
                        
   
    
    
    
   
    </script>

</head>
<body>



<div id="content">    
<div id="accordion">
<h3><a href="#" id="section1" >List Penagihan </a></h3>
    <div>
    <p align="right">         
        <a id="tambah" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="dg" title="List Pembayaran Transaksi" style="width:870px;height:600px;" >  
        </table>                          
    </p> 
    </div>   

<h3><a href="#" id="section2">PENAGIHAN</a></h3>
   <div  style="height: 350px;">
   <p>       
   <div id="demo"></div>
        <table align="center" style="width:100%;">
			<tr>
                <td style="border-bottom: double 1px red;"><i>No. Tersimpan<i></td>
                <td style="border-bottom: double 1px red;"><input type="text" id="no_simpan" style="border:0;width: 200px;" readonly="true";/></td>
				<td style="border-bottom: double 1px red;">&nbsp;&nbsp;</td>
				<td style="border-bottom: double 1px red;" colspan = "2"><i>Tidak Perlu diisi atau di Edit</i></td>
                    
            </tr>
            <tr>
                <td>No. Penagihan</td>
                <td>&nbsp;<input type="text" id="nomor" style="width: 200px;" onclick="javascript:select();"/> <input  id="nomor_hide" style="width: 20px;" onclick="javascript:select();" hidden /></td>
                <td>&nbsp;&nbsp;</td>
                <td>Tanggal </td>
                <td><input type="text" id="tanggal" style="width: 140px;" /></td>     
            </tr>                        
            <tr>
                <td>S K P D</td>
                <td>&nbsp;<input id="skpd" name="skpd" readonly="true" style="width: 140px;border: 0;" /></td>
                <td></td>
                <td>Nama SKPD</td> 
                <td><input type="text" id="nmskpd" style="border:0;width: 400px;border: 0;" readonly="true"/></td>                                
            </tr>
            
            <tr>
                <td>Keterangan</td>
                <td colspan="4"><textarea id="keterangan" style="width: 760px; height: 40px;"></textarea></td>
           </tr> 
                <td>Status</td>
                 <td>
                     <select name="status_byr" id="status_byr" disabled>
                         <option value="1">SELESAI</option>
                         <option value="0">BELUM SELESAI</option>
                     </select>
                 </td> 
			</tr>
			<tr>
				 <td>Jenis</td>
                 <td>
                     <select name="jns" id="jns" disabled>
						 <option value="0">TANPA TERMIN / SEKALI PEMBAYARAN</option>
                         <option value="1">DENGAN TERMIN</option>
                         <option value="3">HUTANG TAHUN LALU</option>
                     </select>
                 </td>
			</tr>
			<tr>
				<td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Kontrak</td>
				<td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><input id="kontrak" name="kontrak" style="width:190px"/> 
                <td colspan="3" align="right">
					<!--<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();load_detail();">Baru</a>
					<a id="edit" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_transout2();">Simpan Edit</a>-->
                    <a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_transout();">Simpan</a>
		            <a id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
  		            <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a>                                   
                </td>
            </tr>
        </table>          
        <table id="dg1" title="Rekening" style="width:870px;height:350px;" >  
        </table>  
        <div id="toolbar" align="right">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah();">Tambah Kegiatan</a>
   		    <!--<input type="checkbox" id="semua" value="1" /><a onclick="">Semua Kegiatan</a>-->
            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_giat();">Hapus Kegiatan</a>
               		
        </div>
        <table align="center" style="width:100%;">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td ></td>
            <td align="right">Total : <input type="text" id="total" style="text-align: right;border:0;width: 200px;font-size: large;" readonly="true"/></td>
        </tr>
        </table>
                
   </p>
   </div>
   
</div>
</div>


<div id="dialog-modal" title="Input Kegiatan">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
    <table>
        <tr>
            <td>Kode Kegiatan</td>
            <td>:</td>
            <td width="300"><input id="giat" name="giat" style="width: 200px;" /></td>
            <td>Nama Kegiatan</td>
            <td>:</td>
            <td><input type="text" id="nmkegiatan" readonly="true" style="border:0;width: 400px;"/></td>
        </tr> 
		 <tr>
            <td >SP2D</td>
            <td>:</td>
            <td><input id="sp2d" name="sp2d" style="width:200px;" /></td>
        </tr> 
         <tr>
            <td >Kode Rekening</td>
            <td>:</td>
            <td><input id="rek" name="rek" style="width:200px;" /></td>
            <td >Nama Rekening</td>
            <td>:</td>
            <td><input type="text" id="nmrek" readonly="true" style="border:0;width: 400px;"/></td>
        </tr> 
		<tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="rek_blud" name="rek_blud" style="border:0;width:200px;" readonly="true" /></td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="text" id="nmrek_blud" readonly="true" style="border:0;width:400px;"/></td>
        </tr> 		
        <tr>
            <td >Sisa Penyusunan</td>
            <td>:</td>
            <td><input type="text" id="sisa" readonly="true" style="text-align:right;border:0;width: 150px;"/></td>            
        </tr>
        <tr>
            <td >Sisa Penyempurnaan</td>
            <td>:</td>
            <td><input type="text" id="sisa_semp" readonly="true" style="text-align:right;border:0;width: 150px;"/></td>            
        </tr>
        <tr>
            <td >Sisa Perubahan</td>
            <td>:</td>
            <td><input type="text" id="sisa_ubah" readonly="true" style="text-align:right;border:0;width: 150px;"/></td>            
        </tr>
		<tr>
            <td >Sisa Kas BLUD</td>
            <td>:</td>
            <td colspan="3"><input type="text" id="tot_spd" readonly="true" style="text-align:right;border:0;width: 100px;"/> - 
			<input type="text" id="tot_trans" readonly="true" style="text-align:right;border:0;width: 100px;"/>  =
			<input type="text" id="sisa_spd" readonly="true" style="text-align:right;border:0;width: 150px;"/></td>            
        </tr>
         <tr>
            <td >Status</td>
            <td>:</td>
            <td><input type="text" id="status_ang" readonly="true" style="text-align:right;border:0;width: 150px;"/></td>            
        </tr>
        <tr>
            <td >Nilai</td>
            <td>:</td>
            <td><input type="text" id="nilai" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))" onkeyup="javascript:sisa_bayar();"/></td>            
        </tr>
    </table>  
    </fieldset>
    <fieldset>
    <table align="center">
        <tr>
            <td><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:append_save();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>                               
            </td>
        </tr>
    </table>   
    </fieldset>
    <fieldset>
        <table align="right">           
            <tr>
                <td>Total</td>
                <td>:</td>
                <td><input type="text" id="total1" readonly="true" style="font-size: large;text-align: right;border:0;width: 200px;"/></td>
            </tr>
        </table>
        <table id="dg2" title="Input Rekening" style="width:1000px;height:270px;"  >  
        </table>  
     
    </fieldset>  
</div>
</body>
</html>