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
    
    var nl           = 0;
	var tnl          = 0;
	var idx          = 0;
	var tidx         = 0;
	var oldRek       = 0;
    var rek          = 0;
    var lcstatus     = '';
    var jumlah_pajak = 0;
    var pidx         = 0;
    
    $(function(){
		$(document).ready(function() {
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $("#dialog-modal").dialog({
				height: 410,
				width: 750,
				modal: true,
				autoOpen:false
			});
			get_tahun();
			get_skpd();
		});

        $('#dd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
				return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
				},
			onSelect: function(date){
            $("#kebutuhan_bulan").attr("Value",(date.getMonth()+1));
            }
        });
        
		$('#bank').combogrid({  
                panelWidth:310,  
                //url: '<?php echo base_url(); ?>/index.php/tukd_blud/config_bank',  
                    idField:'kd_bank',  
                    textField:'kd_bank',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                           {field:'kd_bank',title:'Kd Bank',width:100},  
                           {field:'nama_bank',title:'Nama',width:200}
                       ]],  
                    onSelect:function(rowIndex,rowData){
                    //$("#kode").attr("value",rowData.kode);
                    $("#nama_bank").attr("value",rowData.nama_bank);
                    }   
                });

        $('#cspm').combogrid({  
			panelWidth:500,  
			//url: '<?php echo base_url(); ?>/index.php/C_Spm/pilih_spm',  
				idField    : 'no_spm',                    
				textField  : 'no_spm',
				mode       : 'remote',  
				fitColumns : true,  
				columns:[[  
					{field:'no_spm',title:'SPM',width:60},  
					{field:'kd_skpd',title:'SKPD',align:'left',width:60},
					{field:'no_spp',title:'SPP',width:60} 
				]],
				onSelect:function(rowIndex,rowData){
				kode = rowData.no_spm;
				skpd = rowData.kd_skpd;
				}   
			});
                
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
		
        $('#spm').edatagrid({
        		url: '<?php echo base_url(); ?>/index.php/C_Spm/load_spm',
                idField       : 'id',            
                rownumbers    : "true", 
                fitColumns    : "true",
                singleSelect  : "true",
                autoRowHeight : "false",
                loadMsg       : "Tunggu Sebentar....!!",
                pagination    : "true",
                nowrap        : "true",
        rowStyler: function(index,row){
        if (row.status == "1"){
          return 'background-color:#03d3ff;';
        }
        },                       
                columns:[[
					{title:'',
					width:5,
					checkbox:"true"},
            	    {field:'no_spm',
            		title:'Nomor SPM',
            		width:70},
                    {field:'tgl_spm',
            		title:'Tanggal',
            		width:30},
                    {field:'kd_skpd',
            		title:' B L U D',
            		width:30,
                    align:"left"},
                    {field:'keperluan',
            		title:'Keterangan',
            		width:140,
                    align:"left"}
                ]],
                onSelect:function(rowIndex,rowData){
                  no_spm   	= rowData.no_spm;
                  no_spp   	= rowData.no_spp;
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
                  getspm(no_spm,no_spp,tgl_spm,tgl_spp,jns_spp,ckep,bulan,bank,rekanan,rekening,nama_bank,status,pimpinan,npwp,total); 
				  detail();
                  lcstatus = 'edit';   
                },
                onDblClickRow:function(rowIndex,rowData,st){
                    section2();   
                }
            });
            
            
            
            $('#nospp').combogrid({  
                panelWidth : 500,  
                url        : '<?php echo base_url(); ?>/index.php/C_Spm/load_spp',  
                idField    : 'no_spp',                    
                textField  : 'no_spp',
                mode       : 'remote',  
                fitColumns : true,  
                columns:[[  
						{field:'no_spp',title:'No',width:60},  
						{field:'kd_skpd',title:'SKPD',align:'left',width:80} 
                    ]],
                     onSelect:function(rowIndex,rowData){
                        no_spp 		= rowData.no_spp;         
                        bulan   	= rowData.bulan;
                        tgl     	= rowData.tgl_spp;
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
						jns_spp		=	rowData.jns_spp;
						
                        get(no_spp,tgl,bulan,jns,kep,npwp,rekanan,bank,nama_bank,rekening,pimpinan,status,total);
                        detail();
						kosong_potongan();
						get_spm(jns_spp);
                    }  
                });
                
                
                $('#dg').edatagrid({
                    //url           : '<?php echo base_url(); ?>/index.php/C_Spm/select_data1',
                    autoRowHeight : "true",
                    idField       : 'id',
                    toolbar       : "#toolbar",              
                    rownumbers    : "true", 
                    fitColumns    : false,
                    singleSelect  : "true"
                    });
            
                
                $('#rekpajak').combogrid({  
                   panelWidth : 700,  
                   idField    : 'kd_rek5',  
                   textField  : 'kd_rek5',  
                   mode       : 'remote',
                   //url        : '<?php echo base_url(); ?>index.php/C_Spm/rek_pot',  
                   columns:[[  
                       {field:'kd_rek5',title:'Kode Rekening',width:100},  
                       {field:'nm_rek5',title:'Nama Rekening',width:700}    
                   ]],  
                   onSelect:function(rowIndex,rowData){
                       $("#nmrekpajak").attr("value",rowData.nm_rek5);
                   }  
                   });
                   
                   
    			$('#dgpajak').edatagrid({
    			     //url            : '<?php echo base_url(); ?>/index.php/C_Spm/pot',
                     idField        : 'id',
                     toolbar        : "#toolbar",              
                     rownumbers     : "true", 
                     fitColumns     : false,
                     autoRowHeight  : "true",
                     singleSelect   : false,
                     columns:[[
                        {field:'id',title:'id',width:100,align:'left',hidden:'true'}, 
                        {field:'kd_trans',title:'Rek. Trans',width:100,align:'left'},			
                        {field:'kd_trans_blud',title:'Rek. BLUD',width:100,align:'left'},			
                        {field:'kd_rek5',title:'Rekening',width:100,align:'left'},			
    					{field:'nm_rek5',title:'Nama Rekening',width:217},
    					{field:'nilai',title:'Nilai',width:100,align:"right"},
    					{field:'jns_pot',title:'Jenis',width:50,align:"right"},
                        {field:'hapus',title:'Hapus',width:50,align:"center",
                        formatter:function(value,rec){ 
                        return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                        }
                        }
        			]]	
        			});
					
				$('#bk').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/C_Spp/load_ttd/BK',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd1").attr("value",rowData.nama);
                    }  
				});          
				
				$('#pa').combogrid({  
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
                    $("#nmttd3").attr("value",rowData.nama);
                    }  
				});  

			$('#ppk').combogrid({  
					panelWidth:600,  
					idField:'nip',  
					textField:'nip',  
					mode:'remote',
					url:'<?php echo base_url(); ?>index.php/C_Spp/load_ttd/PT',  
					columns:[[  
						{field:'nip',title:'NIP',width:200},  
						{field:'nama',title:'Nama',width:400}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd4").attr("value",rowData.nama);
                    }  
				}); 				
			
			});

        function detail(){
		var no_spp  = $('#nospp').combogrid('getValue'); 
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
        
        
        
        function detail_kosong(){
       var no_spp  = '';
		var kdskpd  = document.getElementById('dn').value;	
        $(function(){
			$('#dg').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/load_detail_spp',
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
              

        function get(no_spp,tgl,bulan,jns,kep,npwp,rekanan,bank,nama_bank,rekening,pimpinan,status,total){
            $("#nospp").attr("value",no_spp);
            $("#tgl_spp").attr("value",tgl);
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
            $("#rekspm1").attr("value",total);
			validate_rek_trans();
        }
                  
        
        function getspm(no_spm,no_spp,tgl_spm,tgl_spp,jns_spp,ckep,bulan,bank,rekanan,rekening,nama_bank,status,pimpinan,npwp,total){
			$("#no_spm").attr("value",no_spm);
            $("#spm_pot").attr("value",no_spm);
            $("#no_spm_hide").attr("value",no_spm);
            $("#nospp").combogrid("setValue",no_spp);
            $("#nospp1").attr("value",no_spp); 
            $("#dd").datebox("setValue",tgl_spm);
            $("#jns_beban").attr("Value",jns_spp);
            $("#tgl_spp").attr("value",tgl_spp);
            $("#npwp").attr("Value",npwp);
            $("#kebutuhan_bulan").attr("Value",bulan);
            $("#ketentuan").attr("Value",ckep);
            $("#bank").combogrid("setValue",bank);
            $("#rekanan").attr("Value",rekanan);
            $("#rekening").attr("Value",rekening);
            $("#nama_bank").attr("Value",nama_bank);
            $("#pimpinan").attr("Value",pimpinan);
			$("#rekspm").attr("value",total);
            $("#rekspm1").attr("value",total);
			tampil_potongan();
			load_sum_pot();
            tombol(status); 
			validate_rek_trans();
			
			
        }
		
        
        function kosong(){
            lcstatus = 'tambah';    
            cdate    = '<?php echo date("Y-m-d"); ?>';
            $("#no_spm").attr("value",'');
            $("#no_spm_hide").attr("value",'');
            $("#spm_pot").attr("value",'');
            $("#dd").datebox("setValue",cdate);
            $("#nospp").combogrid("setValue",'');       
            $("#sp").attr("value",'');        
            $("#tgl_spp").attr("value",'');
            $("#kebutuhan_bulan").attr("Value",'');
            $("#ketentuan").attr("Value",'');
            $("#jns_beban").attr("Value",'');
            $("#npwp").attr("Value",'');
            $("#rekanan").attr("Value",'');
             $("#bank1").combogrid("setValue",'');
            $("#rekening").attr("Value",'');
            document.getElementById("p1").innerHTML="";
            detail_kosong();
            $("#nospp").combogrid("clear");
            tombolnew();
            $("#totalrekpajak").attr("value",0);
            
        }
        

    
       
    
    function cetak(){
        var nom=document.getElementById("no_spm").value;
        $("#cspm").combogrid("setValue",nom);
        $("#dialog-modal").dialog('open');
    } 
    
    
    function keluar(){
        $("#dialog-modal").dialog('close');
    }   
    
    function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Spm/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        }
    function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#spm').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/C_Spm/load_spm',
         queryParams:({cari:kriteria})
        });        
     });
    }
        
    function data_no_spp(){
		  $('#nospp').combogrid({url: '<?php echo base_url(); ?>/index.php/C_Spm/nospp_2'});  
		}
		
    function simpan_spm(){        
        var a       = (document.getElementById('no_spm').value).split(" ").join("");
        var a_hide  = document.getElementById('no_spm_hide').value;
        var b      	= $('#dd').datebox('getValue'); 
        var c       = document.getElementById('tgl_spp').value;      
        var d       = document.getElementById('dn').value;
		var e  		= $('#nospp').combogrid('getValue'); 
        var e_hide  = document.getElementById('nospp1').value;	
		
		var tahun_input = b.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun Tidak Sama Dengan Tahun Anggaran", "error");
			exit();
		}
		if (a==""){
			swal("Error", "No SPM Tidak Boleh Kosong", "error");
		exit();
		}
		if (c>b){
			swal("Error", "Tanggal SPM tidak boleh lebih kecil dari tanggal SPP", "error");
		exit();
		}
		
        if(lcstatus == 'tambah'){
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
					data: ({no:a,tabel:'trhsp2d_blud',field:'no_spm'}),
                    url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						swal("Error", "Nomor Telah Dipakai", "error");
						document.getElementById("nomor").focus();
						exit();
						} 
						if(status_cek==0){
				//---------
					csql='';
				   $('#dgpajak').datagrid('selectAll');
					var rows = $('#dgpajak').datagrid('getSelections');
					for(var i=0;i<rows.length;i++){            
						cidx      		= rows[i].idx;
						ckdtrans   		= rows[i].kd_trans.split(" ").join("");
						ckdtransblud	= rows[i].kd_trans_blud.split(" ").join("");
						ckdrek5			= rows[i].kd_rek5.split(" ").join("");
						cnmrek5			= rows[i].nm_rek5;
						cjnspot			= rows[i].jns_pot;
						cnilai 			= angka(rows[i].nilai);
						no        = i + 1 ;    
							if (i>0) {
								csql = csql+","+"('"+a+"','"+ckdtrans+"','"+ckdtransblud+"','"+ckdrek5+"','"+cnmrek5+"','"+cjnspot+"','"+cnilai+"','"+d+"')";
							} else {
								csql = "('"+a+"','"+ckdtrans+"','"+ckdtransblud+"','"+ckdrek5+"','"+cnmrek5+"','"+cjnspot+"','"+cnilai+"','"+d+"')";                 
								}                                             
							}   	                  
							$(document).ready(function(){
								$.ajax({
									type: "POST",   
									dataType : 'json',                 
									data: ({no:a,sql:csql,tgl:b,skpd:d,nospp:e}),
									url: '<?php echo base_url(); ?>index.php/C_Spm/simpan_spm',
									success:function(data){                        
										status = data;   
										 if (status=='2'){
											$("#loading").dialog('close');
											swal("Berhasil", "Data Berhasil Tersimpan", "success");
											$("#no_spm_hide").attr("value",a);
											$("#nospp1").attr("value",e);
											lcstatus='edit';
											section1();
										} else if (status=='1'){
											$("#loading").dialog('close');
											lcstatus='tambah';
											swal("Berhasil", "Data Berhasil Tersimpan Tanpa Potongan", "success");
										}else{ 
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
                    data: ({no:a,tabel:'trhsp2d_blud',field:'no_spm'}),
                    url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && a!=a_hide){
						swal("Error", "Nomor Telah Dipakai", "error");
						exit();
						} 
						if(status_cek==0 || a==a_hide){
						
				//---------
					csql='';
					$('#dgpajak').datagrid('selectAll');
					var rows = $('#dgpajak').datagrid('getSelections');
					for(var i=0;i<rows.length;i++){            
						cidx      		= rows[i].idx;
						ckdtrans   		= rows[i].kd_trans.split(" ").join("");
						ckdtransblud	= rows[i].kd_trans_blud.split(" ").join("");
						ckdrek5			= rows[i].kd_rek5.split(" ").join("");
						cnmrek5			= rows[i].nm_rek5;
						cjnspot			= rows[i].jns_pot;
						cnilai 			= angka(rows[i].nilai);
						no        		= i + 1 ;    
							if (i>0) {
								csql = csql+","+"('"+a+"','"+ckdtrans+"','"+ckdtransblud+"','"+ckdrek5+"','"+cnmrek5+"','"+cjnspot+"','"+cnilai+"','"+d+"')";
							} else {
								csql = "('"+a+"','"+ckdtrans+"','"+ckdtransblud+"','"+ckdrek5+"','"+cnmrek5+"','"+cjnspot+"','"+cnilai+"','"+d+"')";                 
								}                                             
							}   
							$(document).ready(function(){
								$.ajax({
									type: "POST",   
									dataType : 'json',                 
									data: ({no:a,sql:csql,tgl:b,skpd:d,nospp:e,nospp_hide:e_hide,no_hide:a_hide}),
									url: '<?php echo base_url(); ?>index.php/C_Spm/update_spm',
									success:function(data){                        
										status = data;   
										 if (status=='2'){
											$("#loading").dialog('close');
											swal("Berhasil", "Data Berhasil Tersimpan", "success");
											$("#no_spm_hide").attr("value",a);
											$("#nospp1").attr("value",e);
											lcstatus='edit';
											section1();
										} else if (status=='1'){
											$("#loading").dialog('close');
											lcstatus='edit';
											swal("Berhasil", "Data Berhasil Tersimpan Tanpa Potongan", "success");
										}else{ 
											$("#loading").dialog('close');
											lcstatus='edit';
											swal("Error", "Detail Gagal Tersimpan", "error");
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
        
    function edit_keterangan(){
		
		var a1      = (document.getElementById('no_spm').value).split(" ").join("");
        var a1_hide = document.getElementById('no_spm_hide').value;
        var b1      = $('#dd').datebox('getValue'); 
        var b       = document.getElementById('tgl_spp').value;      
        var c       = document.getElementById('jns_beban').value; 
        var d       = document.getElementById('kebutuhan_bulan').value;
        var e       = document.getElementById('ketentuan').value;
        var f       = document.getElementById('rekanan').value;
        var g       = $("#bank1").combogrid("getValue") ; 
        var h       = document.getElementById('npwp').value;
        var i       = document.getElementById('rekening').value;
        var j       = document.getElementById('nmskpd').value;
        var k       = document.getElementById('dn').value;
        var l       = document.getElementById('sp').value;
        var m       = document.getElementById('rekspm1').value; 
        var cc      = $('#cc').combobox('getValue'); 
		var tahun_input = b1.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun tidak sama dengan tahun Anggaran", "error");
			exit();
		}
		if (a1==""){
			swal("Error", "No SPM Tidak Boleh Kosong", "error");
			exit();
		}
		if (l==""){
		swal("Error", "No SPD Tidak Boleh Kosong", "error");
		
		exit();
		}
		if (b>b1){
		swal("Error", "Tanggal SMP tidak boleh lebih kecil dari tanggal SPP", "error");
		exit();
		}
		var lenket = e.length;
		if ( lenket>1000 ){
			swal("Error", "Keterangan Tidak boleh lebih dari 1000 karakter", "error");
            exit();
        }
	
        lcquery = " UPDATE trhspm_blud SET keperluan='"+e+"', tgl_spm='"+b1+"' WHERE no_spm='"+a1+"' AND no_spp='"+no_spp+"' AND kd_skpd='"+k+"'"; 
        lcquery2 = " UPDATE trhspp_blud SET keperluan='"+e+"' WHERE no_spp='"+no_spp+"' AND kd_skpd='"+k+"'"; 
            $(document).ready(function(){
            $.ajax({
                type     : "POST",
                url      : '<?php echo base_url(); ?>/index.php/C_Spm/update_ket_spm',
                data     : ({st_query:lcquery,st_query2:lcquery2,tabel:'trhspm_blud',cid:'no_spm',lcid:a1,lcid_h:a1_hide}),
                dataType : "json",
                success  : function(data){
                           status=data ;
                        if ( status=='1' ){
							swal("Error", "Nomor SPM Sudah Terpakai...!!!,  Ganti Nomor SPM...!!!", "error");
                            exit();
                        }
                        if ( status=='2' ){
							swal("Berhasil", "Data Berhasil Tersimpan", "success");
                            exit();
								}
                        if ( status=='0' ){
                            swal("Error", "Gagal Simpan", "error");
                            exit();
                        }
                    }
            });
            });
        }
    
	
	
    function simpan(reke,nrek){		
		var spm = document.getElementById('no_spm').value;
		var cskpd =document.getElementById('dn').value;
        
        $(function(){      
            $.ajax({
            type: 'POST',
            data: ({cskpd:cskpd,spm:spm,kd_rek5:reke,nmrek:nrek}),
            dataType:"json",
            url:'<?php echo base_url(); ?>/index.php/C_Spm/pot_simpan'
         });
        });
		}
        
    
	function hhapus(){				
             var spm = document.getElementById("no_spm").value;
			var skpd =document.getElementById('dn').value;
			var spp  = document.getElementById('nospp').value;	    
            var urll= '<?php echo base_url(); ?>/index.php/C_Spm/hapus_spm';             			    
         	if (spp !=''){
				var del=confirm('Anda yakin akan menghapus SPM '+spm+'  ?');
				if  (del==true){
					$(document).ready(function(){
                    $.post(urll,({spm:spm,spp:spp,skpd:skpd}),function(data){
                    status = data;   
					if (status='1'){
                            swal("Berhasil", "Data Berhasil Terhapus", "success");       
                        } else {
                            swal("Error", "Gagal Hapus", "error");
                        }					
                    });
                    });				
				}
				} 
	}
        
        
    function getSelections(idx){
			var ids = [];
			var rows = $('#pot').edatagrid('getSelections');
			for(var i=0;i<rows.length;i++){
				ids.push(rows[i].kd_rek5);
			}
			return ids.join(':');
	}
    
   
        
    function load_sum_pot(){                
		var spm = document.getElementById('no_spm').value;              
		var skpd = document.getElementById('dn').value;              
        $(function(){      
         $.ajax({
            type      : 'POST',
            data      : ({spm:spm,skpd:skpd}),
            url       : "<?php echo base_url(); ?>index.php/C_Spm/load_sum_pot",
            dataType  : "json",
            success   : function(data){ 
                $.each(data, function(i,n){
                    $("#totalrekpajak").attr("value",n['rektotal']);
                });
            }
         });
        });
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
     
     
     function tombol(st){  
        if (st==1){
            $('#save').linkbutton('disable');
            $('#del').linkbutton('disable');
			$('#save-pot').linkbutton('disable');
            $('#del-pot').linkbutton('disable');
			$('#edit-ket').linkbutton('enable');
            document.getElementById("p1").innerHTML="Sudah di Buat SP2D!!";
         } else {
             $('#save').linkbutton('enable');
             $('#del').linkbutton('enable');
			 $('#save-pot').linkbutton('enable');
             $('#del-pot').linkbutton('enable');
			 $('#edit-ket').linkbutton('disable');
            document.getElementById("p1").innerHTML="";
         }
    }
    
    function tombolnew(){  
     $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
	 $('#save-pot').linkbutton('enable');
     $('#del-pot').linkbutton('enable');
	 $('#edit-ket').linkbutton('disable');
    }
     
    function cetak_spm(cetak){
		var kode	= $("#cspm").combogrid("getValue") ;
		var no 		= kode.split("/").join("123456789");
		var ttd 	= $("#bk").combogrid("getValue") ;
		var ttd1 	= ttd.split(" ").join("123456789");
		var ttd_2 	= $("#pa").combogrid("getValue") ;
		var ttd2 	= ttd_2.split(" ").join("123456789");
		var ttd_3 	= $("#ppk").combogrid("getValue") ;
		var ttd3 	= ttd_3.split(" ").join("123456789");
		var tanpa   = document.getElementById('tanpa_tanggal').checked; 
		var baris   = document.getElementById("baris").value;
		var jns   = document.getElementById("jns_beban").value;
		var skpd   = document.getElementById("dn").value;
		
		if ( tanpa == false ){
           tanpa=0;
        }else{
           tanpa=1;
        }
		if(ttd==''){
			swal("Error", "Pilih Bendahara Pengeluaran Terlebih Dahulu!", "error");
			exit();
		}
		if(ttd_2==''){
			swal("Error", "Pilih PPTK Terlebih Dahulu!", "error");
			exit();
		}
		var url    = "<?php echo site_url(); ?>/C_Spm/cetak_spm";    
		window.open(url+'/'+cetak+'/'+no+'/'+skpd+'/'+jns+'/'+ttd1+'/'+ttd2+'/'+tanpa+'/'+baris+'/'+ttd3, '_blank');
        window.focus();
        }
		
		
		
     
    
    
    function append_save() {
			var no_spm_pot  	= document.getElementById('no_spm').value;
            $('#dgpajak').datagrid('selectAll');
            var rows  			= $('#dgpajak').datagrid('getSelections');
            jgrid     = rows.length ; 
            var kd_trans    	= $("#rektrans").combogrid("getValue") ;
            var kd_trans_blud 	= document.getElementById("rektrans_blud").value ;
            var rek_pajak    	= $("#rekpajak").combogrid("getValue") ;
            var nm_rek_pajak 	= document.getElementById("nmrekpajak").value ;
            var nilai_pajak  	= document.getElementById("nilairekpajak").value ;
            var nil_pajak    	= angka(nilai_pajak);
            var dinas        	= document.getElementById('dn').value;
            var vnospm       	= document.getElementById('no_spm').value;
            var jns_pot      	= document.getElementById('jns_pot').value;
            var cket         	= '0' ;
            var jumlah_pajak 	= document.getElementById('totalrekpajak').value ;   
                jumlah_pajak 	= angka(jumlah_pajak);        
            if(no_spm_pot==''){
				swal("Error", "Isi No SPM Terlebih Dahulu...!!!", "error");
                exit();
			}
			if(kd_trans==''){
				swal("Error", "Isi Rekening Transaksi Terlebih Dahulu...!!!", "error");
                exit();
			}
            if ( rek_pajak == '' ){
				swal("Error", "Isi Rekening Pajak Terlebih Dahulu...!!!", "error");
                exit();
                }
            
            if ( nilai_pajak == 0 ){
				swal("Error", "Isi Nilai Terlebih Dahulu...!!!", "error");
                exit();
                }
            
            pidx = jgrid + 1 ;

            $('#dgpajak').edatagrid('appendRow',{kd_rek5:rek_pajak,kd_trans:kd_trans,kd_trans_blud:kd_trans_blud,nm_rek5:nm_rek_pajak,nilai:nilai_pajak,jns_pot:jns_pot,id:pidx});
            $("#rekpajak").combogrid("setValue",'');
            $("#nmrekpajak").attr("value",'');
            $("#nilairekpajak").attr("value",0);
            jumlah_pajak = jumlah_pajak + nil_pajak ;
            $("#totalrekpajak").attr('value',number_format(jumlah_pajak,2,'.',','));
            validate_rekening();
    }


    function validate_rekening() {
           $('#dgpajak').datagrid('selectAll');
           var rows = $('#dgpajak').datagrid('getSelections');
           frek  = '' ;
           rek5  = '' ;
           for ( var p=0; p < rows.length; p++ ) { 
           rek5 = rows[p].kd_rek5;                                       
           if ( p > 0 ){   
                  frek = frek+','+rek5;
              } else {
                  frek = rek5;
              }
           }
           
           $(function(){
           $('#rekpajak').combogrid({  
                   panelWidth  : 700,  
                   idField     : 'kd_rek5',  
                   textField   : 'kd_rek5',  
                   mode        : 'remote',
                   url         : '<?php echo base_url(); ?>index.php/C_Spm/rek_pot', 
                   queryParams :({kdrek:frek}), 
                   columns:[[  
                       {field:'kd_rek5',title:'Kode Rekening',width:100},  
                       {field:'nm_rek5',title:'Nama Rekening',width:700}    
                   ]],  
                   onSelect:function(rowIndex,rowData){
                       $("#nmrekpajak").attr("value",rowData.nm_rek5);
                   }  
                   });
                   });
          $('#dgpajak').datagrid('unselectAll');         
    }
    
    
    function hapus_detail(){
        
        var vnospm        = document.getElementById('no_spm').value;
        var dinas         = document.getElementById('dn').value;
        
        var rows          = $('#dgpajak').edatagrid('getSelected');
        var ctotalpotspm  = document.getElementById('totalrekpajak').value ;
        
        bkdrek            = rows.kd_rek5;
        bnilai            = rows.nilai;
        
        var idx = $('#dgpajak').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, Rekening : '+bkdrek+'  Nilai :  '+bnilai+' ?');
        
        if ( tny == true ) {
            $('#dgpajak').datagrid('deleteRow',idx);     
            $('#dgpajak').datagrid('unselectAll');
             ctotalpotspm = angka(ctotalpotspm) - angka(bnilai) ;
             $("#totalrekpajak").attr("Value",number_format(ctotalpotspm,2,'.',','));
             }     
        }
        
        
    function tampil_potongan () {
            var vnospm = document.getElementById('no_spm').value ;
            var skpd = document.getElementById('dn').value ;
            $(function(){
			$('#dgpajak').edatagrid({
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
    					{field:'nm_rek5',title:'Nama Rekening',width:217},
    					{field:'nilai',title:'Nilai',width:100,align:"right"},
    					{field:'jns_pot',title:'Jenis',width:50,align:"right"},
                        {field:'hapus',title:'Hapus',width:50,align:"center",
                        formatter:function(value,rec){ 
                        return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                        }
                        }
        			]]	
                  });
		    });
    }

	 function kosong_potongan() {
            var vnospm = '';
            var skpd = document.getElementById('dn').value ;
            $(function(){
			$('#dgpajak').edatagrid({
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
    					{field:'nm_rek5',title:'Nama Rekening',width:217},
    					{field:'nilai',title:'Nilai',width:100,align:"right"},
    					{field:'jns_pot',title:'Jenis',width:50,align:"right"},
                        {field:'hapus',title:'Hapus',width:50,align:"center",
                        formatter:function(value,rec){ 
                        return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                        }
                        }
        			]]	
                  });
		    });
    }
 

function inputnomor(){    
        var nomorspm = document.getElementById('no_spm').value;
        $("#spm_pot").attr("value",nomorspm);
     }


	function validate_rek_trans() {
		var no_spp  = $('#nospp').combogrid('getValue'); 
		var kdskpd  = document.getElementById('dn').value;
           $(function(){
			   $('#rektrans').combogrid({  
					panelWidth:500,  
					idField:'kd_rek5',  
					textField:'kd_rek5',  
					mode:'remote',
                    url  : '<?php echo base_url(); ?>index.php/C_Spm/rek_pot_trans', 
                    queryParams :({no_spp:no_spp,skpd:kdskpd}), 
					columns:[[  
						{field:'kd_rek5',title:'Rekening',width:100},  
						{field:'kd_rek_blud',title:'Rek. BLUD',width:100},    
						{field:'nm_rek_blud',title:'Nama Rek.',width:300}    
					]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmrektrans").attr("value",rowData.nm_rek5);
                    $("#rektrans_blud").attr("value",rowData.kd_rek_blud);
                    $("#nmrektrans_blud").attr("value",rowData.nm_rek_blud);
					validate_rekening();
                    }  
				});
			   });
           
     
}	
     
	 
	 function get_spm(jns_spp){
		  
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
        		url:'<?php echo base_url(); ?>index.php/C_Spm/config_spm/'+skpd,
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			no_spp = data.nomor;
					kd = data.kd;
					thn_ang=data.thn_ang;
					
					var inisial = no_spp + "/SPM-"+jns+"/BLUD/"+kd+"/"+thn_ang;
					$("#no_spm").attr('disabled',true);
                    $("#no_spm").attr("value",inisial);
                    
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
<h3><a href="#" id="section1" onclick="javascript:$('#spm').edatagrid('reload')">List SPM</a></h3>
    <div>
	 <p align="right">         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();section2();">Tambah</a>
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="spm" title="List SPM" style="width:870px;height:450px;" >  
        </table>
    </p> 
    </div>

<h3><a href="#" id="section2" onclick="javascript:$('#dg').edatagrid('reload')" >Input SPM</a></h3>
<div  style="height: 350px;">
<p id="p1" style="font-size: x-large;color: red;"></p>
<fieldset style="width:850px;height:1350px;border-color:white;border-style:hidden;border-spacing:0;padding:0;">    
<table border='1' style="font-size:11px" >
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >&nbsp;</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td>
 </tr>
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td colspan="2" width="8%" style= "color: red;border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >No SPM Terisi Otomatis ! Silahkan Pilih No SPP Terlebih Dahulu !</td>
    </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >No SPM</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"><input type="text" name="no_spm" id="no_spm" disabled style="width:200px;" onkeyup="this.value=this.value.toUpperCase(); javascript:inputnomor();"/><input type="hidden" name="no_spm_hide" id="no_spm_hide"  style="width:200px;"/>
   </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Tgl SPM </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;&nbsp;<input id="dd" name="dd" type="text" style="width:100px;" /></td>
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;" >   
   <td width="8%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">No SPP</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"><input id="nospp" name="nospp" style="width:200px;" />
     <input type="hidden" name="nospp1" id="nospp1" /></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Tgl SPP </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;&nbsp;<input id="tgl_spp" name="tgl_spp" type="text" readonly="true" style="width:100px;" /></td>   
    </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">B L U D</td>
   <td width="53%" colspan="3" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px" ><input id="dn" name="dn" style="width:200px" readonly="true"/> <input id="nmskpd" name="nmskpd" style="border:0;width:350px" readonly="true"/></td>
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
 </table>
    
	<table id="dg" title=" Detail SPM" style="width:850%;height:250%;">  
    </table>
        <table border='0' >
            <tr>
                <td width='400px'></td>
                <td width='220px'></td>
                <td width='240px'></td>
            </tr>
            <tr>
                <td></td>
                <td align='right'><B>Total</B></td>
                <td align="right"><input class="right" type="text" name="rekspm" id="rekspm"  style="width:200px" align="right" readonly="true" >
                    <input class="right" type="hidden" name="rekspm1" id="rekspm1"  style="width:100px" align="right" readonly="true" >
                </td>
            </tr>
        </table>
    </p>
	<!--dari sini -->
	 <fieldset>
       <table border='0' style="font-size:11px"> 
           <tr>
                <td>No. SPM</td>
                <td>:</td>
                <td><input type="text" id="spm_pot" name="spm_pot" style="width:200px;" readonly="true"/></td>
           </tr>
		   <tr>
                <td>Rekening Transaksi</td>
                <td>:</td>
                <td><input type="text" id="rektrans"   name="rektrans" style="width:200px;"/></td>
                <td><input type="text" id="nmrektrans" name="nmrektrans" style="width:400px;border:0px;"/></td>
           </tr>
		   <tr>
                <td>Rek. Transaksi BLUD</td>
                <td>:</td>
                <td><input type="text" id="rektrans_blud"   name="rektrans_blud" style="width:200px;" readonly="true"/></td>
                <td><input type="text" id="nmrektrans_blud" name="nmrektrans_blud" style="width:400px;border:0px;" readonly="true"/></td>
           </tr>
           <tr>
                <td>Rekening Potongan</td>
                <td>:</td>
                <td><input type="text" id="rekpajak"   name="rekpajak" style="width:200px;" /></td>
                <td><input type="text" id="nmrekpajak" name="nmrekpajak" style="width:400px;border:0px;" readonly="true"/></td>
           </tr>
           <tr>
                <td>Jenis Potongan</td>
                <td>:</td>
                <td colspan="2"><select  name="jns_pot" id="jns_pot" style="width:200px;">
				 <option value="0">Tidak Pengurangi SP2D</option>
				 <option value="1" >Mengurangi SP2D</option>
			   </select></td>
           </tr>
           <tr>
                <td align="left">Nilai</td>
                <td>:</td>
                <td><input type="text" id="nilairekpajak" name="nilairekpajak" style="width:200px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
                <td></td>
           </tr>
           <tr>
             <td colspan="4" align="center" > 
                 <a id="save-pot" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:append_save();" >Tambah Potongan</a>
             </td>
           </tr>
       </table>
       </fieldset>
      &nbsp;&nbsp; 
       <table id="dgpajak" title="List Potongan" style="width:850px;height:300px;">  
       </table>   
	   <table border='0' >
            <tr>
                <td width='400px'></td>
                <td width='220px'></td>
                <td width='240px'></td>
            </tr>
            <tr>
                <td></td>
                <td align='right'><B>Total</B></td>
                <td align="right"><input class="right" type="text" name="totalrekpajak" id="totalrekpajak"  style="width:200px" align="right" readonly="true" >
                </td>
            </tr>
        </table>
		<table align="center" border="0">
		 <tr align="right" style="border-bottom:black; border-spacing: 3px;padding:3px 3px 3px 3px;">
			<td align="right" style="border-bottom:black; border-spacing: 3px;padding:3px 3px 3px 3px;">
			<a id="edit-ket" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:edit_keterangan();">Edit Keterangan</a>
			<a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_spm();">Simpan</a>
			<a id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hhapus();javascript:section1();">Hapus</a>
			<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a>
			<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a></td>                
		</tr>
		</table>
	<!--Sampai sini -->
    </fieldset>
    </div>
</div>
</div> 

<div id="dialog-modal" title="CETAK SPM">
    <p class="validateTips">SILAHKAN PILIH SPM</p> 
    <fieldset>
    <table>
        <tr>            
            <td width="110px">NO SPP:</td>
            <td><input id="cspm" name="cspm" style="width: 170px;" disabled />  &nbsp; &nbsp; &nbsp; <input type="checkbox" id="tanpa_tanggal"> Tanpa Tanggal</td>
        </tr>
       
		<tr>
            <td width="110px">Bend. Pengeluaran:</td>
            <td><input id="bk" name="bk" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd1" name="nmttd1" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">KPA:</td>
            <td><input id="pa" name="pa" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd3" name="nmttd3" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">PPK:</td>
            <td><input id="ppk" name="ppk" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd4" name="nmttd4" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">SPASI:</td>
            <td><input type="number" id="spasi" style="width: 100px;" value="1"/></td>
        </tr>
		<tr>
            <td width="110px">Baris SPM:</td>
            <td><input type="number" id="baris" name="baris" style="width: 30px;border:0" value="15"/></td>
        </tr>
		
    </table>   
    </fieldset>
	<br/>
	<table style="border-collapse:collapse" align="center" border="1" width="98%">
	<tr>
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_spm(0);">Cetak Layar</a> 
	<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_spm(1);">Cetak PDF</a>
	</tr>
  </table>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  
</div>
</body>
</html>