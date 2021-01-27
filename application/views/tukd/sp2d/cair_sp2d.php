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
                url: '<?php echo base_url(); ?>/index.php/C_Sp2d/pilih_sp2d',  
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
                    val_ttd(dns);
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
        rowStyler: function(index,row){
        if (row.status == "1"){
          return 'background-color:#03d3ff;';
        }
        },                       
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
          no_kas    = rowData.no_kas;
          tgl_kas   = rowData.tgl_kas;
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
		  getspm(no_kas,tgl_kas,no_sp2d,tgl_sp2d,no_spm,no_spp,tgl_spm,tgl_spp,jns_spp,ckep,bulan,bank,rekanan,rekening,nama_bank,status,pimpinan,npwp,total); 
		  detail();
		  lcstatus = 'edit'; 
        },
        onDblClickRow:function(rowIndex,rowData){
            section2(status);   
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
                        get(no_spm,tgl_spm,no_spp,tgl_spp,bulan,jns,kep,npwp,rekanan,bank,nama_bank,rekening,pimpinan,status,total);
						detail();
						tampil_potongan();
						load_sum_pot();
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
        
       function cair(){
		var cap=document.getElementById("btcair").value;
		var nokas=document.getElementById("nokas").value;
		if (nokas==''){
			swal("Error", "Nomor Kas tidak boleh kosong", "error");
			exit();
		}
		if (cap=='CAIRKAN'){
			simpan_cair();
			document.getElementById("btcair").value="BATAL CAIR";
		}else{
			batal_cair();
			document.getElementById("btcair").value="CAIRKAN";		
		}
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
                  
        function getspm(no_kas,tgl_kas,no_sp2d,tgl_sp2d,no_spm,no_spp,tgl_spm,tgl_spp,jns_spp,ckep,bulan,bank,rekanan,rekening,nama_bank,status,pimpinan,npwp,total){
			$("#nokas").attr("value",no_kas);
			$("#no_sp2d").attr("value",no_sp2d);
			$("#no_sp2d_hide").attr("value",no_sp2d);
			$("#dkas").datebox("setValue",tgl_kas);
			$("#dd").datebox("setValue",tgl_sp2d);
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
			$("#loading").dialog({
				resizable: false,
				width:200,
				height:130,
				modal: true,
				draggable:false,
				autoOpen:false,    
				closeOnEscape:false
				});
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $("#dialog-modal").dialog({
            height: 200,
            width: 700,
            modal: true,
            autoOpen:false
        });
		get_tahun();
		get_skpd();
		get_nourut()
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
	
	function get_nourut(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_blud/no_urut',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			$("#nokas").attr("value",data.no_urut);
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
        
	
	function simpan_cair(){        
		var nokas 	= document.getElementById('nokas').value;
		var tglcair = $('#dkas').datebox('getValue');        
		var nosp2d 	= document.getElementById('no_sp2d').value;
		var tglsp2d = $('#dd').datebox('getValue');        			
		var nospm 	=  $('#nospm').datebox('getValue'); 
		var nospp 	= document.getElementById('nospp').value; 
		var keperluan 	= document.getElementById('ketentuan').value; 
		var cskpd 	= document.getElementById('dn').value; 
		var jns     = document.getElementById('jns_beban').value; 
		var total     = document.getElementById('rekspm').value;
		var tahun_input = tglcair.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun tidak sama dengan tahun Anggaran!!!", "error");
			exit();
		}
		if (tglsp2d>tglcair){
		swal("Error", "Tanggal Pencairan tidak boleh lebih kecil dari tanggal Penerimaan", "error");
		exit();
		}
		if (tglcair==''){
		swal("Error", "Tanggal tidak boleh kosong", "error");
		exit();
		}
		$(function(){      
		 $.ajax({
			type: 'POST',
			data: ({nkas:nokas,tglcair:tglcair,nosp2d:nosp2d,nospm:nospm,nospp:nospp,skpd:cskpd,jns:jns,total:total,keperluan:keperluan}),
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/C_Sp2d/simpan_cair",
			beforeSend:function(xhr){
			$("#loading").dialog('open');
			},
			success:function(data){
				if (data = 2){
					$("#loading").dialog('close');
					swal("Berhasil", "SP2D Telah Dicairkan", "success");
					$('#nokas').attr('readonly',true);
					document.getElementById("p1").innerHTML="SP2D Sudah Cair!!";
					document.getElementById("btcair").value="BATAL CAIR";
				}else{
					$("#loading").dialog('close');
					swal("Gagal", "SP2D Gagal Dicairkan", "error");
					document.getElementById("p1").innerHTML="";
				}
			}
		 });
		});

	}

    function batal_cair(){        
		var nokas 	= document.getElementById('nokas').value;
		var tglcair = $('#dkas').datebox('getValue');        
		var nosp2d 	= document.getElementById('no_sp2d').value;
		var tglsp2d = $('#dd').datebox('getValue');        			
		var nospm 	=  $('#nospm').datebox('getValue'); 
		var nospp 	= document.getElementById('nospp').value; 
		var cskpd 	= document.getElementById('dn').value; 
		var jns     = document.getElementById('jns_beban').value; 
		var tahun_input = tglcair.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun tidak sama dengan tahun Anggaran!!!", "error");
			exit();
		}
		if (tglsp2d>tglcair){
		swal("Error", "Tanggal Pencairan tidak boleh lebih kecil dari tanggal Penerimaan", "error");
		exit();
		}
		if (tglcair==''){
		swal("Error", "Tanggal tidak boleh kosong", "error");
		exit();
		}
		$(function(){      
		 $.ajax({
			type: 'POST',
			data: ({nkas:nokas,tglcair:tglcair,nosp2d:nosp2d,nospm:nospm,nospp:nospp,skpd:cskpd,jns:jns}),
			dataType:"json",
			url:"<?php echo base_url(); ?>index.php/C_Sp2d/batal_cair",
			beforeSend:function(xhr){
			$("#loading").dialog('open');
			},
			success:function(data){
				if (data = 2){
					$("#loading").dialog('close');
					swal("Berhasil", "Pencairan SP2D Telah Dibatalkan", "success");
					$('#nokas').attr('readonly',false);
					document.getElementById("btcair").value="CAIRKAN";
					document.getElementById("p1").innerHTML="";
					get_nourut();
				}else{
					$("#loading").dialog('close');
					swal("Gagal", "SP2D Gagal Dibatalkan", "error");
					$('#nokas').attr('readonly',true);
					document.getElementById("p1").innerHTML="SP2D Sudah Cair!!";
				}
			}
		 });
		});

	}
   

     function section1(){
         $(document).ready(function(){    
             $('#section1').click();                                               
         });
     }
     function section2(status){
		
		if (status=='1'){
			$('#nokas').attr('readonly',true);
			document.getElementById("btcair").value="BATAL CAIR";
		} else{
		  get_nourut();
		  document.getElementById("btcair").value="CAIRKAN";
		}
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

<h3><a href="#" id="section1" onclick="javascript:$('#sp2d').edatagrid('reload')">PENCAIRAN SP2D</a></h3>
    <div>
    <p align="right">       
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="sp2d" title="List SP2D" style="width:870px;height:450px;" >  
        </table>                      
    </p> 
    </div>

<h3><a href="#" id="section2" onclick="javascript:$('#dg').edatagrid('reload')" >PENCAIRAN SP2D</a></h3>
  <div>
   <p id="p1" style="font-size:medium;color:red;"></p>
<table border='0' style="font-size:11px" >
 <tr>
   <td >No Cair </td>
   <td><input type="text" name="nokas" id="nokas"  style="width:150px" ></td>
   <td>Tgl Cair </td>
   <td><input id="dkas" name="dkas" type="text"  style="width:155px" /></td>   
 </tr>
</table>

<table border='0' style="font-size:11px" >
 <tr>
   <td >No SP2D </td>
   <td> <input type="text" name="no_sp2d" id="no_sp2d"  style="width:150px" readonly="true" onkeyup="this.value=this.value.toUpperCase();" >
		<input type="hidden" name="no_sp2d_hide" id="no_sp2d_hide"  style="width:150px" >
   </td>
   <td>Tgl SP2D </td>
   <td><input id="dd" name="dd" type="text" readonly="true" style="width:155px" disabled /></td>
 </tr>
 <tr>
   <td >No SPM</td>
   <td><input type="text" name="nospm" id="nospm"  style="width:155px" disabled>
	   <input type="hidden" name="nospm_hide" id="nospm_hide"  style="width:155px" readonly="true">
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
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">B L UD</td>
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
     <table id="dg" title=" Detail SPM" style="width:850%;height:200%;" >  
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
				<INPUT TYPE="button" name="btcair" id="btcair" VALUE="CAIRKAN" ONCLICK="cair()" style="height:40px;width:100px">			   
				<INPUT TYPE="button" name="btback" id="btback" VALUE="KEMBALI" ONCLICK="javascript:section1();" style="height:40px;width:100px">			   	 
			</td>                
	</tr> 
	</table>
	
	
   </p>
</div>
</div>
	<div id="loading" title="Loading...">
			<table align="center">
			<tr align="center"><td><img id="search1" height="50px" width="50px" src="<?php echo base_url();?>/image/loadingBig.gif"  /></td></tr>
			<tr><td>SEDANG MEMUAT...</td></tr>
			</table>
			</div>
</div> 
	
</body>

</html>