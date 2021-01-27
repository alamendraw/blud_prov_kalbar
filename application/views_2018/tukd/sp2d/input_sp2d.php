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
    <script type="text/javascript"> 
    
    var nl 			= 0;
	var tnl 		= 0;
	var idx			= 0;
	var tidx		= 0;
	var oldRek		= 0;
    var rek			= 0;
	var lcstatus	= '';
    
    $(function(){
   	     $('#dd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
				return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
            }
        });
   	});

     $(function(){
   	     $('#dkas').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
   	});
	
	$(function(){
	$('#bank').combogrid({  
                panelWidth:200,  
                    idField:'kd_bank',  
                    textField:'kd_bank',
                    //mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                           {field:'kd_bank',title:'Kd Bank',width:40},  
                           {field:'nama_bank',title:'Nama',width:140}
                       ]],  
                    onSelect:function(rowIndex,rowData){
                    //$("#kode").attr("value",rowData.kode);
                    $("#nama_bank").attr("value",rowData.nama_bank);
                    }   
                });	
	});
	
	
        $(function(){
            $('#csp2d').combogrid({  
                panelWidth:500,  
                //url: '<?php echo base_url(); ?>/index.php/C_Sp2d/pilih_sp2d',  
                    idField:'no_sp2d',                    
                    textField:'no_sp2d',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'no_sp2d',title:'SP2D',width:60},  
                        {field:'kd_skpd',title:'SKPD',align:'left',width:60},
                        {field:'no_spm',title:'SPM',width:60} 
                          
                    ]],
                    onSelect:function(rowIndex,rowData){
                    kode = rowData.no_sp2d;
                    dns = rowData.kd_skpd;
                   
                    }   
                });
				
				$('#ttd').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/C_Spp/load_ttd/PA',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    //$("#nmttd3").attr("value",rowData.nama);
                    }  
				}); 
				
			
				
           });

        function val_ttd(dns){
           $(function(){
            $('#ttd').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/C_Sp2d/pilih_ttd/'+dns,  
                    idField:'nip',                    
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'nip',title:'NIP',width:60},  
                        {field:'nama',title:'NAMA',align:'left',width:100}
                        
                        
                    ]],
                    onSelect:function(rowIndex,rowData){
                    nip = rowData.nip;
                    
                    }   
                });
           });              
         }
    $(function(){ 
     $('#sp2d').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/C_Sp2d/load_sp2d',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'no_sp2d',
    		title:'Nomor SP2D',
    		width:90},
            {field:'no_spm',
    		title:'Nomor SPM',
    		width:90},
            {field:'tgl_sp2d',
    		title:'Tanggal',
    		width:35},
            {field:'kd_skpd',
    		title:' B L U D',
    		width:35,
            align:"left"},
            {field:'total',
    		title:'Nilai',
    		width:40,
            align:"left"}
        ]],
        onSelect:function(rowIndex,rowData){
          no_sp2d   = rowData.no_sp2d;
          no_spm   	= rowData.no_spm;
		  no_spp   	= rowData.no_spp;
		  tgl_sp2d 	= rowData.tgl_sp2d;
		  tgl_spm  	= rowData.tgl_spm;
		  tgl_spp  	= rowData.tgl_spp;
		  jns_spp  	= rowData.jns_spp;
		  ckep     	= rowData.keperluan;
		  bulan    	= rowData.bulan;
		  bank     	= rowData.bank;
		  rekanan  	= rowData.rekanan;
		  rekening 	= rowData.rekening;
		  nama_bank = rowData.nama_bank;
		  status  	= rowData.status;
		  pimpinan  = rowData.pimpinan;
		  npwp  	= rowData.npwp;
		  total  	= rowData.total;
		  getspm(no_sp2d,tgl_sp2d,no_spm,no_spp,tgl_spm,tgl_spp,jns_spp,ckep,bulan,bank,rekanan,rekening,nama_bank,status,pimpinan,npwp,total); 
		  detail();
		  lcstatus = 'edit'; 
        },
        onDblClickRow:function(rowIndex,rowData){
            //st = rowData.status;
            section2();   
        }
    });
    }); 
        
              
    $(function(){
            $('#nospm').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/C_Sp2d/load_spm',  
                    idField:'no_spm',                    
                    textField:'no_spm',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'no_spm',title:'No',width:60},  
                        {field:'kd_skpd',title:'SKPD',align:'left',width:80} 
                          
                    ]],
                     onSelect:function(rowIndex,rowData){
                        no_spm 		= rowData.no_spm;         
                        tgl_spm 	= rowData.tgl_spm;         
                        no_spp 		= rowData.no_spp;         
                        tgl_spp    	= rowData.tgl_spp;
                        bulan   	= rowData.bulan;
                        jns    		= rowData.jns_spp;
                        kep    		= rowData.keperluan;
                        npwp  		= rowData.npwp;
                        total  		= rowData.total;
                        rekanan  	= rowData.rekanan;
                        pimpinan	= rowData.pimpinan;
                        bank     	= rowData.bank;
                        nama_bank	= rowData.nama_bank;
                        rekening   	= rowData.rekening;
                        status   	= rowData.status;
						jns_spp		= rowData.jns_spp;
                        get(no_spm,tgl_spm,no_spp,tgl_spp,bulan,jns,kep,npwp,rekanan,bank,nama_bank,rekening,pimpinan,status,total);
						detail();
						tampil_potongan();
						load_sum_pot();
						get_sp2d(jns_spp);
					}  
                });
           });
    
             
        $(function(){
			$('#dg').edatagrid({
				//url: '<?php echo base_url(); ?>/index.php/C_Sp2d/select_data1',
                 autoRowHeight:"true",
                 idField:'id',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 singleSelect:"true"
                                  
			});
		}); 
        
        
        
        $(function(){
			$('#pot').edatagrid({
				//url: '<?php echo base_url(); ?>/index.php/C_Sp2d/pot',
                 autoRowHeight:"true",
                 idField:'id',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 singleSelect:"true",
                                  
			});
		}); 
    
  
        
        function detail(){
		var no_spp  = document.getElementById('nospp').value;	
		var kdskpd  = document.getElementById('dn').value;	
        $(function(){
			$('#dg').edatagrid({
				url: '<?php echo base_url(); ?>index.php/C_Spp/load_detail_spp',
                queryParams    : ({ spp:no_spp,skpd:kdskpd}),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"true",
                 singleSelect:false,
                 onLoadSuccess:function(data){                      
                      //load_sum_spm();
                      },                                  			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},                     
                     {field:'kdkegiatan',
					 title:'Kegiatan',
					 width:150,
					 align:'left'
					 },
					{field:'kdrek5',
					 title:'Rekening',
					 width:70,
					 align:'left'
					 },
					{field:'kdrekblud',
					 title:'Rek. BLUD',
					 width:70,
					 align:'left'
					 },
					{field:'nmrekblud',
					 title:'Nama Rekening',
					 width:340
					 },
                    {field:'nilai1',
					 title:'Nilai',
					 width:120,
                     align:'right'
                     },
				]]	
			});
		});
        }
        
		function tampil_potongan () {
			var vnospm  = $('#nospm').combogrid('getValue'); 
            var skpd = document.getElementById('dn').value ;
            $(function(){
			$('#pot').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spm/load_detail_potongan',
                queryParams    : ({ spm:vnospm,skpd:skpd }),
                idField       : 'id',
                toolbar       : "#toolbar",              
                rownumbers    : "true", 
                fitColumns    : false,
                autoRowHeight : "false",
                singleSelect  : "true",
                nowrap        : "true",
      			columns       :
                     [[
                        {field:'id',title:'id',width:100,align:'left',hidden:'true'}, 
                        {field:'kd_trans',title:'Rek. Trans',width:100,align:'left'},			
                        {field:'kd_trans_blud',title:'Rek. BLUD',width:100,align:'left'},			
                        {field:'kd_rek5',title:'Rekening',width:100,align:'left'},			
    					{field:'nm_rek5',title:'Nama Rekening',width:280},
    					{field:'jns_pot',title:'Jenis',width:50,align:"right"},
    					{field:'nilai',title:'Nilai',width:100,align:"right"},
        			]]	
                  });
		    });
    }

		
        function detail1(){
        $(function(){ 
            var no_spp='';
			$('#dg').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Sp2d/select_data1',
                queryParams:({spp:no_spp}),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"true",
                 singleSelect:false,                                                   			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},                     
                     {field:'kdkegiatan',
					 title:'Kegiatan',
					 width:150,
					 align:'left'
					},
					{field:'kdrek5',
					 title:'Rekening',
					 width:70,
					 align:'left'
					},
					{field:'nmrek5',
					 title:'Nama Rekening',
					 width:400					 
					},
                    {field:'nilai1',
					 title:'Nilai',
					 width:100,
                     align:'right'
                     }
                      
				]]	
			
			});
  	

		});
        }
        
        
        
      function load_sum_pot(){                
			var spm  = $('#nospm').combogrid('getValue'); 
			var skpd = document.getElementById('dn').value;              
			$(function(){      
			 $.ajax({
				type      : 'POST',
				data      : ({spm:spm,skpd:skpd}),
				url       : "<?php echo base_url(); ?>index.php/C_Spm/load_sum_pot",
				dataType  : "json",
				success   : function(data){ 
					$.each(data, function(i,n){
						$("#rektotal").attr("value",n['rektotal']);
					});
				}
			 });
			});
		}
        
        function pot1(){
        $(function(){
	   	    var no_spm='';                         
			$('#pot').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Sp2d/pot',
                queryParams:({spm:no_spm}),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"true",
                 singleSelect:false,                                              			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},                    
					{field:'kd_rek5',
					 title:'Rekening',
					 width:100,
					 align:'left'
					},
					{field:'nm_rek5',
					 title:'Nama Rekening',
					 width:550
					},                    
                    {field:'nilai',
					 title:'Nilai',
					 width:100,
                     align:'right'
                     }
                      
				]]	
			
			});
  	

		});
        }
              
        function get(no_spm,tgl_spm,no_spp,tgl_spp,bulan,jns,kep,npwp,rekanan,bank,nama_bank,rekening,pimpinan,status,total){
			$("#no_spm").attr("value",no_spm);
			$("#tgl_spm").attr("value",tgl_spm);
			$("#nospp").attr("value",no_spp);
            $("#tgl_spp").attr("value",tgl_spp);
            $("#kebutuhan_bulan").attr("Value",bulan);
            $("#ketentuan").attr("Value",kep);
            $("#jns_beban").attr("Value",jns);
            $("#npwp").attr("Value",npwp);
            $("#rekanan").attr("Value",rekanan);
            $("#bank").combogrid("setValue",bank);
			$("#rekening").attr("Value",rekening);
            $("#nama_bank").attr("Value",nama_bank);
            $("#pimpinan").attr("Value",pimpinan);
			$("#rekspm").attr("value",total);
        }
                  
        function getspm(no_sp2d,tgl_sp2d,no_spm,no_spp,tgl_spm,tgl_spp,jns_spp,ckep,bulan,bank,rekanan,rekening,nama_bank,status,pimpinan,npwp,total){
			$("#no_sp2d").attr("value",no_sp2d);
			$("#no_sp2d_hide").attr("value",no_sp2d);
			$("#dd").datebox("setValue",tgl_sp2d);
            $("#csp2d").combogrid("setValue",no_sp2d);
            $("#nospm").combogrid("setValue",no_spm);
			$("#nospm_hide").attr("value",no_spm);
			$("#nospp").attr("value",no_spp);
            $("#tgl_spp").attr("value",tgl_spp);
            $("#tgl_spm").attr("value",tgl_spm);
            $("#jns_beban").attr("Value",jns_spp);
            $("#npwp").attr("Value",npwp);
            $("#kebutuhan_bulan").attr("Value",bulan);
            $("#ketentuan").attr("Value",ckep);
            $("#bank").combogrid("setValue",bank);
            $("#rekanan").attr("Value",rekanan);
            $("#rekening").attr("Value",rekening);
            $("#nama_bank").attr("Value",nama_bank);
            $("#pimpinan").attr("Value",pimpinan);
			$("#rekspm").attr("value",total);
			tampil_potongan();
			load_sum_pot();
            tombol(status); 
        }
		
	function tombol(st){  
     if (st=='1'){
     $('#save').linkbutton('disable');
     document.getElementById("p1").innerHTML="SP2D Sudah dicairkan!!";
     } else {
     $('#save').linkbutton('enable');
     document.getElementById("p1").innerHTML="";
     }
    }
	
	
    function kosong(){
			lcstatus = "tambah";
			document.getElementById("p1").innerHTML="";
			$("#no_sp2d").attr("value",'');
			$("#dd").datebox("setValue",'');
			$("#nospp").attr("value",'');
			$("#tgl_spp").attr("value",'');
			$("#tgl_spm").attr("value",'');
			$("#kebutuhan_bulan").attr("Value",'');
			$("#ketentuan").attr("Value",'');
			$("#jns_beban").attr("Value",'');
			$("#npwp").attr("Value",'');
			$("#rekanan").attr("Value",'');
			$("#ban1").combogrid("setValue",'');
			$("#rekening").attr("Value",'');
			$("#pimpinan").attr("Value",'');   
			$("#nospm").combogrid("clear");
			$('#save').linkbutton('enable');
			detail1();
			pot1();
			}


        $(document).ready(function() {
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $("#dialog-modal").dialog({
            height: 300,
            width: 700,
            modal: true,
            autoOpen:false
        });
		get_tahun();
		get_skpd();
        });
       
    function cetak(){
        $("#dialog-modal").dialog('open');
    } 
	
     function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Sp2d/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        }
		
	function get_skpd(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
				  $("#dn").attr("value",data.kd_skpd);
				  $("#nmskpd").attr("value",data.nm_skpd);
				}  
            });
        }
		
    function keluar(){
        $("#dialog-modal").dialog('close');
    }   
     function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#sp2d').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/C_Sp2d/load_sp2d',
         queryParams:({cari:kriteria})
        });        
     });
    }
        
	function simpan_sp2d(){   
        var no1 	 	= (document.getElementById('no_sp2d').value).split(" ").join("");
        var no1_hide 	= (document.getElementById('no_sp2d_hide').value);
        var b1 		 	= $('#dd').datebox('getValue');    
        var b2 			= document.getElementById('tgl_spm').value;
		var d  			= document.getElementById('dn').value;	
        var no_spm   	= $("#nospm").combogrid("getValue") ; 
        var no_spm_hide = (document.getElementById('nospm_hide').value);
        var kep 		= (document.getElementById('ketentuan').value);
		var tahun_input = b1.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun Tidak Sama Dengan Tahun Anggaran", "error");
			exit();
		}
		
		if (no1=="") {
			swal("Error", "Nomor SP2D Tidak Boleh Kosong", "error");
		exit();
		}
		
		if (b2>b1){
			swal("Error", "Tanggal SP2D tidak boleh lebih kecil dari Tanggal SPM", "error");
		exit();
		}
        if(lcstatus == 'tambah'){
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
					data: ({no:no1,tabel:'trhsp2d_blud',field:'no_sp2d'}),
                    url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						swal("Error", "Nomor Telah Dipakai", "error");
						document.getElementById("nomor").focus();
						exit();
						} 
						if(status_cek==0){

						$(document).ready(function(){
							$.ajax({
								type: "POST",   
								dataType : 'json',                 
								data: ({no:no1,tgl:b1,skpd:d,nospm:no_spm,kep:kep}),
								url: '<?php echo base_url(); ?>index.php/C_Sp2d/simpan_sp2d',
								success:function(data){                        
									status = data;   
									 if (status=='2'){
										$("#loading").dialog('close');
										swal("Berhasil", "Data Berhasil Tersimpan", "success");
										$("#no_sp2d_hide").attr("value",no1);
										$("#nospm_hide").attr("value",no_spm);
										lcstatus='edit';
										section1();
									} else{ 
										$("#loading").dialog('close');
										lcstatus='tambah';
										swal("Error", "Detail Gagal Tersimpan", "error");
									}                                               
								}
							});
							});            
											
           
		//----------
			}
			}
			});
			});
			} else {
			$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:no1,tabel:'trhsp2d_blud',field:'no_sp2d'}),
                    url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && no1!=no1_hide){
						swal("Error", "Nomor Telah Dipakai", "error");
						exit();
						} 
						if(status_cek==0 || no1==no1_hide){
						
						$(document).ready(function(){
							$.ajax({
								type: "POST",   
								dataType : 'json',                 
								data: ({no:no1,tgl:b1,skpd:d,nospm:no_spm,nospm_hide:no_spm_hide,no_hide:no1_hide,kep:kep}),
								url: '<?php echo base_url(); ?>index.php/C_Sp2d/update_sp2d',
								success:function(data){                        
									status = data;   
									 if (status=='2'){
										$("#loading").dialog('close');
										swal("Berhasil", "Data Berhasil Tersimpan", "success");
										$("#no_sp2d_hide").attr("value",no1);
										$("#nospm_hide").attr("value",no_spm);
										lcstatus='edit';
										section1();
									} else{ 
										$("#loading").dialog('close');
										lcstatus='edit';
										swal("Error", "Data Gagal Tersimpan", "error");
									}                                             
								}
							});
							});     
		//-----------
					}
				}
			});
		});
       }
	}
    
 
 
       

     function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                               
         });
     }
     function section2(){



         $(document).ready(function(){    
             $('#section2').click();                                               
         });
     }

     function section3(){
         $(document).ready(function(){    
             $('#section3').click();                                               
         });
     }
     

    
    function tombolnew(){  
    
     $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
     $('#poto').linkbutton('enable');     
    
    }
    
	
    function cetak_sp2d(cetak) {
        var kode  = $("#csp2d").combogrid("getValue") ; 
        var no    = kode.split("/").join("123456789");
		var baris = document.getElementById('baris').value;
		var dns = document.getElementById('dn').value;
	    var vttd  = $("#ttd").combogrid("getValue"); 
		if(vttd==''){
			alert('Pilih Penandatangan dulu!');
			exit();
		}
	    var vttd =vttd.split(" ").join("abc");
		var jns_cetak = document.getElementById('jns_cetak').value;
		var url    = "<?php echo site_url(); ?>/C_Sp2d/cetak_sp2d";   
        window.open(url+'/'+cetak+'/'+no+'/'+dns+'/'+vttd+'/'+baris+'/'+jns_cetak, '_blank');
        window.focus();
        }
   
		function get_sp2d(jns_spp){
		  
			 var skpd =document.getElementById("dn").value;
			
			
			if(jns_spp=='1'){
						jns = "UP";
			}else if(jns_spp=='2'){
						jns = "GU";
			}else if(jns_spp=='3'){
						jns = "TU";
			}else if(jns_spp=='4'){
						jns = "LS-GJ";
			}else{
						jns = "LS";
			}
			
				
			
			
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Sp2d/config_sp2d/'+skpd,
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			no_spp = data.nomor;
					kd = data.kd;
					thn_ang=data.thn_ang;
					
					var inisial = no_spp + "/SP2D-"+jns+"/BLUD/"+kd+"/"+thn_ang;
					$("#no_sp2d").attr('disabled',true);
                    $("#no_sp2d").attr("value",inisial);
                    
        			}                                     
        	});
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

<h3><a href="#" id="section1" onclick="javascript:$('#sp2d').edatagrid('reload')">INPUT SP2D</a></h3>
    <div>
    <p align="right">       
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="sp2d" title="List SP2D" style="width:870px;height:450px;" >  
        </table>                      
    </p> 
    </div>

<h3><a href="#" id="section2" onclick="javascript:$('#dg').edatagrid('reload')" >INPUT DATA SP2D</a></h3>
   <div  style="height: 400px;">
   <p id="p1" style="font-size: x-large;color: red;"></p>
<table border='0' style="font-size:11px" >
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td colspan="2" width="8%" style= "color: red;border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >No SP2D Terisi Otomatis ! Silahkan Pilih No SP2D Terlebih Dahulu !</td>
    </tr>
 <tr>
   <td >No SP2D </td>
   <td> <input type="text" name="no_sp2d" id="no_sp2d"  disabled style="width:150px" onkeyup="this.value=this.value.toUpperCase();" >
		<input type="hidden" name="no_sp2d_hide" id="no_sp2d_hide"  style="width:150px" >
   </td>
   <td>Tgl SP2D </td>
   <td><input id="dd" name="dd" type="text" readonly="true" style="width:155px" /></td>
 </tr>
 <tr>
   <td >No SPM</td>
   <td><input type="text" name="nospm" id="nospm"  style="width:155px">
	   <input type="hidden" name="nospm_hide" id="nospm_hide"  style="width:155px">
   </td>
   <td>Tgl SPM </td>
   <td><input id="tgl_spm" name="tgl_spm" type="text" readonly="true" style="width:150px" /></td>
 </tr>
 <tr>   
   <td width="8%" >No SPP</td>
   <td><input id="nospp" name="nospp" readonly="true" style="width:150px" /></td>
   <td>Tgl SPP </td>
   <td><input id="tgl_spp" name="tgl_spp" type="text" readonly="true" style="width:150px" /></td>   
    </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">B L U D</td>
   <td width="53%" colspan="3" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px" > <input id="dn" name="dn" style="border:0;width:100px" readonly="true"/> <input id="nmskpd" name="nmskpd" style="border:0;width:350px" readonly="true"/></td>
 </tr>
 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Beban</td>
   <td width='53%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"><select name="jns_beban" id="jns_beban" style="width:260px;" disabled>
     <option value="">...Pilih Jenis Beban... </option>
     <option value="1">UP</option>
     <option value="2">GU</option>
     <option value="3">TU</option>
     <option value="4">LS GAJI</option>
     <option value="5">LS Barang Jasa (Tanpa Penagihan)</option>     
     <option value="6">LS Barang Jasa (Dengan Penagihan)</option> </td>
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Bulan</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><select  name="kebutuhan_bulan" id="kebutuhan_bulan" style="width:200px;" disabled>
     <option value="">...Pilih Kebutuhan Bulan... </option>
     <option value="1" >1 | Januari</option>
     <option value="2">2 | Februari</option>
     <option value="3">3 | Maret</option>
     <option value="4">4 | April</option>
     <option value="5">5 | Mei</option>
     <option value="6">6 | Juni</option>
     <option value="7">7 | Juli</option>
     <option value="8">8 | Agustus</option>
     <option value="9">9 | September</option>
     <option value="10">10 | Oktober</option>
     <option value="11">11 | November</option>
     <option value="12">12 | Desember</option>
   </select></td>
 </tr>
 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Keperluan</td>
   <td colspan="3" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <textarea name="ketentuan" id="ketentuan" rows="1" cols="50" style="width: 720px;" ></textarea></td>
 </tr>
 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Rekanan</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="rekanan" id="rekanan"  style="width:200px" /></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Pimpinan </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="pimpinan" id="pimpinan"  style="width:200px" /></td>   
 </tr>
  <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Bank</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="bank" id="bank"  style="width:50px" />&nbsp;&nbsp; <input type="text" name="nama_bank" id="nama_bank" style="border:0;width:250px" readonly="true"/></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Rekening </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="rekening" id="rekening"  style="width:200px" /></td>   
 </tr>
 <tr style="border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">NPWP</td>
   <td style="border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="npwp" id="npwp"  style="width:200px" /></td>
   <td style="border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"> </td>
   <td style="border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td> 
</tr>   

</table>
     <table id="dg" title=" Detail SPM" style="width:850%;height:250%;" >  
      </table >
        <table style="width:98%">
		<tr align="right">
		<td align="right">
		<B>Total</B>&nbsp;&nbsp;<input class="right" type="text" name="rekspm" id="rekspm"  style="width:140px" align="right" readonly="true" >		
		</td>
		</tr>
		</table>
        
		<table id="pot" title="List Potongan" style="width:850px;height:150px;" >  
        </table>
		
		 <table style="width:98%">
		<tr align="right">
		<td align="right">
		<B>Total</B>&nbsp;&nbsp;<input class="right" type="text" name="rektotal" id="rektotal"  style="width:140px" align="right" readonly="true" >		
		</td>
		</tr>
		</table>
		
		 </table>
		
	<table style="width:98%">
		<tr  style="border-spacing: 3px;padding:3px 3px 3px 3px;">
     <td colspan="4" align="center"  >
      <a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_sp2d();">Simpan</a>
      <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a>               
	  <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a> </td>                
 </tr> 
	</table>
   </p>
    </div>
    

</div> 
<div id="dialog-modal" title="CETAK SP2D">
    <p class="validateTips">SILAHKAN PILIH NO SP2D</p> 
    <fieldset>
    <table>
        <tr>
            <td width="110px">NO SP2D:</td>
            <td><input id="csp2d" name="csp2d" style="width: 170px;" /></td>
        </tr>
        <tr>
            <td width="110px">KPA:</td>
            <td><input id="ttd" name="ttd" style="width: 170px;" /></td>
        </tr>
		 <tr>
            <td width="110px">Jenis:</td>
            <td><select name="jns_cetak" id="jns_cetak" style="width:200px;">
				 <option value="1">Normal </option>
				 <option value="2">Keterangan Panjang</option>
				 <option value="3">Baris Manual</option></td>
        </tr>
       <tr>
            <td width="110px">Baris:</td>
            <td><input type="number" id="baris" name="baris" style="width: 40px;"value="22" /></td>
        </tr>
    </table>  
    </fieldset>
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_sp2d(0);">Cetak Layar</a> 
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_sp2d(1);">Cetak PDF</a> 
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  
</div>
   
  
</div>

 	
</body>

</html>