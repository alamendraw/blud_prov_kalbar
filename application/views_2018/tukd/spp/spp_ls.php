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
    <style>    
    #tagih {
        position: relative;
        width: 700px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
    
    <script type="text/javascript"> 
   
    var nl       = 0;
	var tnl      = 0;
	var idx      = 0;
	var tidx     = 0;
	var oldRek   = 0;
    var rek      = 0;
    var kode     = '';
    var pidx     = 0;  
    var frek     = '';             
    var rek5     = '';
    var edit     = '';
    var lcstatus = '';
                    
    $(document).ready(function() {
            $("#accordion").accordion({
            height: 600
            });
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $( "#dialog-modal" ).dialog({
            height: 300,
            width: 700,
            modal: true,
            autoOpen:false
        });
        $( "#dialog-modal-rek" ).dialog({
            height: 450,
            width: 1100,
            modal: true,
            autoOpen:false
        });
            $("#penagihan").hide();
            get_skpd();
			get_tahun();
		$("#loading").dialog({
				resizable: false,
				width:200,
				height:130,
				modal: true,
				draggable:false,
				autoOpen:false,    
				closeOnEscape:false
				});
      });
    
        
        $(function(){
       	     $('#dd').datebox({  
                required:true,
                formatter :function(date){
                	var y = date.getFullYear();
                	var m = date.getMonth()+1;
                	var d = date.getDate();
                	return y+'-'+m+'-'+d;
                }, onSelect: function(date){
            	var m = date.getMonth()+1;
					$("#kebutuhan_bulan").attr('value',m);
					cek_status_ang();
				}
            });
			
			$('#tgl_ttd').datebox({  
                required:true,
                formatter :function(date){
                	var y = date.getFullYear();
                	var m = date.getMonth()+1;
                	var d = date.getDate();
                	return y+'-'+m+'-'+d;
                }
            });
				
				$('#no_tagih').combogrid({  
                panelWidth:260,  
                    idField:'no_bukti',                    
                    textField:'no_bukti',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'no_bukti',title:'No. Penagihan',width:150},  
                        {field:'nilai',title:'Nilai',align:'left',width:100}
                    ]],
                    onSelect:function(rowIndex,rowData){
						no_tagih=rowData.no_bukti;
						detail_penagihan();
						total_penagihan();
                    }   
                });
				
                $('#cspp').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/C_Spp/load_spp_ls',  
                    idField:'no_spp',                    
                    textField:'no_spp',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'no_spp',title:'SPP',width:60},  
                        {field:'kd_skpd',title:'SKPD',align:'left',width:60},
                        {field:'tgl_spp',title:'Tanggal',width:60} 
                    ]],
                    onSelect:function(rowIndex,rowData){
                    nomer = rowData.no_spp;
                    kode = rowData.kd_skpd;
                    jns = rowData.jns_spp;
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
                    $("#nama_bank").attr("value",rowData.nama_bank);
                    }   
                });
				
				$('#rekanan').combogrid({  
                panelWidth:200,  
                //url: '<?php echo base_url(); ?>/index.php/tukd/perusahaan',  
                    idField:'nmrekan',  
                    textField:'nmrekan',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                           {field:'nmrekan',title:'Perusahaan',width:40} 
                       ]],  
                    onSelect:function(rowIndex,rowData){
                    $("#pimpinan").attr("value",rowData.pimpinan);
                    $("#npwp").attr("value",rowData.npwp);
                    $("#rekening").attr("value",rowData.no_rek);
                    $("#bank").combogrid("setValue",rowData.bank);
                    $("#nama_bank").attr("value",rowData.nama_bank);
					
                    }   
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
				
				
                    $('#spp').edatagrid({
            		url: '<?php echo base_url(); ?>/index.php/C_Spp/load_spp_ls',
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
                	    {field:'no_spp',
                		title:'Nomor SPP',
                		width:40},
                        {field:'tgl_spp',
                		title:'Tanggal',
                		width:25},
                        {field:'kd_skpd',
                		title:'B L U D',
                		width:25,
                        align:"left"},
                        {field:'keperluan',
                		title:'Keterangan',
                		width:140,
                        align:"left"}
                    ]],
                    onSelect:function(rowIndex,rowData){
                      no_spp   = rowData.no_spp;         
                      kode     = rowData.kd_skpd;
                      bln      = rowData.bulan;
                      tgl      = rowData.tgl_spp;
                      jns      = rowData.jns_spp;
                      kep      = rowData.keperluan;
                      status   = rowData.status;
                      tot_spp  = rowData.total;  
                      rekanan  = rowData.rekanan;  
                      pimpinan = rowData.pimpinan;  
                      bank	   = rowData.bank;  
                      nama_bank  = rowData.nama_bank;  
                      rekening  = rowData.rekening;  
                      npwp  = rowData.npwp;  
                      no_tagih  = rowData.no_tagih;  
                      alamat  = rowData.alamat;  
                      get(no_spp,kode,bln,tgl,jns,kep,status,tot_spp,rekanan,pimpinan,bank,nama_bank,rekening,npwp,no_tagih,alamat);
                      detail_trans();   
                      //load_sum_spp(); 
                      edit = 'T' ;
                      lcstatus = 'edit';
                    },
                    onDblClickRow:function(rowIndex,rowData){
                        section2();   
                    }
                });
                
                
                
            
            
                $('#dgsppls').edatagrid({
				//url: '<?php echo base_url(); ?>/index.php/C_Spp/select_data1',
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"false",
                 singleSelect:"true",
                 nowrap:"false",
                 columns:[[
                    {field:'idx',title:'idx',width:100,align:'left',hidden:'true'},               
                    {field:'kdkegiatan',title:'Kegiatan',width:150,align:'left'},
					{field:'kdrek5',title:'Rekening',width:70,align:'left'},
					{field:'kdrekblud',title:'Rek. BLUD',width:70,align:'left'},
					{field:'nmrekblud',title:'Nama Rekening',width:280},
                    {field:'nilai1',title:'Nilai',width:140,align:'right'},
                    {field:'hapus',title:'Hapus',width:100,align:"center",
                    formatter:function(value,rec){ 
                    return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                    }
                    }
				]]	
           }); 
            
           
           
           
           $('#rek_kegi').combogrid({  
           panelWidth:700,  
           idField:'kd_kegiatan',  
           textField:'kd_kegiatan',  
           mode:'remote',
           columns:[[  
               {field:'kd_kegiatan',title:'Kode Kegiatan',width:150},  
               {field:'nm_kegiatan',title:'Nama Kegiatan',width:700}    
           ]]  
           });
           
           
           $('#rek_reke').combogrid({  
           panelWidth:700,  
           idField   :'kd_rek5',  
           textField :'kd_rek5',  
           mode      :'remote',
           columns   :[[  
               {field:'kd_rek5',title:'Kode Rekening',width:150},  
               {field:'nm_rek5',title:'Nama Rekening',width:700}    
           ]]  
           });
		   
		   $('#rek_blud').combogrid({  
           panelWidth:700,  
           idField   :'kd_rek_blud',  
           textField :'kd_rek_blud',  
           mode      :'remote',
           columns   :[[  
               {field:'kd_rek_blud',title:'Rek. BLUD',width:150},  
               {field:'nm_rek_blud',title:'Nama Rekening',width:700}    
           ]]  
           });

        });
        
        
        function get_skpd(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
				  $("#dn").attr("value",data.kd_skpd);
				  $("#nmskpd").attr("value",data.nm_skpd);
				  $("#rek_skpd").combogrid("setValue",data.kd_skpd);
				  $("#rek_nmskpd").attr("value",rowData.nm_skpd.toUpperCase());
				  kode = data.kd_skpd;
				}  
            });
        }
		
		
	    function get_tahun(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Spp/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
        }
		
		function cek_status_ang(){
        var tgl_cek = $('#dd').datebox('getValue');      
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
		
        
        function validate_kegiatan(){
            var kode_s = document.getElementById('dn').value;
            $(function(){
              $('#rek_kegi').combogrid({  
              panelWidth:700,  
              idField   :'kd_kegiatan',  
              textField :'kd_kegiatan',  
              mode      :'remote',
              url       :'<?php echo base_url(); ?>index.php/C_Spp/load_kegiatan_ls',  
              queryParams:({kdskpd:kode_s}), 
              columns   :[[  
               {field:'kd_kegiatan',title:'Kode Kegiatan',width:150},  
               {field:'nm_kegiatan',title:'Nama Kegiatan',width:700}    
               ]],
               onSelect:function(rowIndex,rowData){      
               $("#nm_rek_kegi").attr("value",rowData.nm_kegiatan); 
               $("#rek_reke").combogrid("setValue",''); 
               validate_rekening(); 
			   load_sisa_kas();
               }              
           });
           });
        }    
        
		function load_sisa_kas(){
		var kode = document.getElementById('dn').value;
		$(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/C_Penagihan/load_sisa_kas",
            dataType:"json",
			data: ({kode:kode}),
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#sisa_kas").attr("value",number_format(n['sisa'],2,'.',','));
                });
            }
         });
        });
    }
	
		function validate_rekening(){
            var kode_s = document.getElementById('dn').value;
            var kode_giat = $('#rek_kegi').combobox('getValue');
            $(function(){
              $('#rek_reke').combogrid({  
              panelWidth:700,  
              idField   :'kd_rek5',  
              textField :'kd_rek5',  
              mode      :'remote',
              url       :'<?php echo base_url(); ?>index.php/C_Spp/load_rek_trdrka',  
              queryParams:({kdskpd:kode_s,kode_giat:kode_giat}), 
              columns   :[[  
               {field:'kd_rek5',title:'Kode Rekening',width:150},  
               {field:'nm_rek5',title:'Nama Rekening',width:700}    
               ]],
               onSelect:function(rowIndex,rowData){      
               $("#nm_rek_reke").attr("value",rowData.nm_rek5); 
               $("#rek_blud").combogrid("setValue",''); 
               validate_rek_blud(); 
               }              
           });
           });
        } 
		
        function validate_rek_blud(){
           $('#dgsppls').datagrid('selectAll');
           var rows = $('#dgsppls').datagrid('getSelections');     
           frek  = '' ;
           rek5  = '' ;
           for ( var p=0; p < rows.length; p++ ) { 
           rek5 = rows[p].kdrek5;                                       
           if ( p > 0 ){   
                  frek = frek+','+rek5;
              } else {
                  frek = rek5;
              }
           }
         
                var beban   = document.getElementById('jns_beban').value;
                var kode_s   = document.getElementById('dn').value  ;
                var kode_keg = $('#rek_kegi').combogrid('getValue') ;
				var kode_rek5 = $('#rek_reke').combogrid('getValue') ;
                var nospp    = document.getElementById('no_spp').value ;
                $(function(){
                  $('#rek_blud').combogrid({  
                  panelWidth:700,  
                  idField   :'kd_rek_blud',  
                  textField :'kd_rek_blud',  
                  mode      :'remote',
                  url       :'<?php echo base_url(); ?>index.php/C_Spp/load_rek_spp',  
                  queryParams:({kdkegiatan:kode_keg,kdrek:kode_rek5,beban:beban}), 
                  columns:[[  
                   {field:'kd_rek5',title:'Kode Rekening',width:100},  
                   {field:'kd_rek_blud',title:'Rek. BLUD',width:100},  
                   {field:'nm_rek_blud',title:'Nama Rekening',width:500}    
                   ]],
                   onSelect:function(rowIndex,rowData){      
                           //$("#nm_rek_reke").attr("value",rowData.nm_rek5); 
                           $("#rek_blud").attr("value",rowData.kd_rek_blud); 
                           $("#nm_rek_blud").attr("value",rowData.nm_rek_blud); 
                           var koderek = rowData.kd_rek5 ;
                           var koderekblud = rowData.kd_rek_blud ;
                           $.ajax({
                                type     : "POST",
                        		dataType : "json",   
                                data     : ({kegiatan:kode_keg,kdrek5:koderek,kdrekblud:koderekblud,kd_skpd:kode_s,no_spp:nospp}), 
                        		url      : '<?php echo base_url(); ?>index.php/C_Spp/jumlah_ang_spp',
                        		success  : function(data){
                        		      $.each(data, function(i,n){
                                        $("#rek_nilai_ang").attr("Value",n['nilai']);
                                        $("#rek_nilai_spp").attr("Value",n['nilai_spp_lalu']);
                                        $("#rek_nilai_ang_semp").attr("Value",n['nilai_sempurna']);
                                        $("#rek_nilai_spp_semp").attr("Value",n['nilai_spp_lalu']);
										$("#rek_nilai_ang_ubah").attr("Value",n['nilai_ubah']);
                                        $("#rek_nilai_spp_ubah").attr("Value",n['nilai_spp_lalu']);
                                        var n_ang  = n['nilai'] ;
                                        var n_ang_semp  = n['nilai_sempurna'] ;
                                        var n_ang_ubah  = n['nilai_ubah'] ;
                                        var n_spp  = n['nilai_spp_lalu'] ;
                                        var n_sisa = angka(n_ang) - angka(n_spp) ;
                                        var n_sisa_semp = angka(n_ang_semp) - angka(n_spp) ;
                                        var n_sisa_ubah = angka(n_ang_ubah) - angka(n_spp) ;
                                        $("#rek_nilai_sisa").attr("Value",number_format(n_sisa,2,'.',','));
                                        $("#rek_nilai_sisa_semp").attr("Value",number_format(n_sisa_semp,2,'.',','));
                                        $("#rek_nilai_sisa_ubah").attr("Value",number_format(n_sisa_ubah,2,'.',','));
										
										
                                    });
        						}                                     
        	               });
                   }                
               });
               });
               $('#dgsppls').datagrid('unselectAll');
        }
           
    function validate_jenis(){
        var beban   = document.getElementById('jns_beban').value;
        var skpd    = document.getElementById('dn').value;
		if (beban=='6'){
			detail_kosong();
			$("#penagihan").show();
			$('#icon_tambah').linkbutton('disable');
			$('#no_tagih').combogrid({url:'<?php echo base_url(); ?>index.php/C_Spp/load_no_penagihan',
                                   queryParams:({skpd:skpd})
                                });
			$('#bank').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/config_bank'
                                });
			$('#rekanan').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/perusahaan_ls'
                                });
		}
		if (beban=='5' || beban=='8' ){
			detail_kosong();
			$("#penagihan").hide();	
			$('#icon_tambah').linkbutton('enable');
			$("#no_tagih").combogrid('clear');
			$("#nama_bank").attr("value",'');
			$('#bank').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/config_bank'
                                });
			$('#rekanan').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/perusahaan_ls'
                                });
		}
		
	}

        
    function get(no_spp,kode,bln,tgl,jns,kep,status,tot_spp,rekanan,pimpinan,bank,nama_bank,rekening,npwp,no_tagih,alamat){
		$("#no_spp").attr("value",no_spp);
        $("#no_spp_hide").attr("value",no_spp);
		$("#no_simpan").attr("value",no_spp);
        $("#dd").datebox("setValue",tgl);
        $("#kebutuhan_bulan").attr("Value",bln);
        $("#ketentuan").attr("Value",kep);
        $("#jns_beban").attr("Value",jns);
		$("#rektotal_ls").attr('value',tot_spp);
        $("#rektotal1_ls").attr('value',tot_spp);
        $("#rekanan").combogrid("setValue",rekanan);
        $("#pimpinan").attr('value',pimpinan);
        $("#bank").combogrid("setValue",bank);
        $("#nama_bank").attr('value',nama_bank);
        $("#rekening").attr('value',rekening);
        $("#npwp").attr('value',npwp);
        $("#alamat").attr('value',alamat);
		if(jns=='5'){
			$("#penagihan").hide();
			$("#no_tagih").combogrid('clear');
		}
		if(jns=='6'){
			$("#penagihan").show();
			$("#no_tagih").combogrid("setValue",no_tagih);
			$("#no_tagih_hide").attr('value',no_tagih);
		}
		 tombol(status);           
        }
    
    function kosong(){
        $("#no_spp").attr("value",'');
        $("#no_spp_hide").attr("value",'');
        $("#no_simpan").attr("value",'');
        $("#dd").datebox("setValue",'');
        $("#kebutuhan_bulan").attr("Value",'');
        $("#ketentuan").attr("Value",'');
        $("#jns_beban").attr("Value",'');
		$('#icon_tambah').linkbutton('disable');
        document.getElementById("p1").innerHTML="";        
        detail_kosong(); 
        var pidx  = 0   ;     
        edit      = 'F' ;
        $("#rektotal_ls").attr("Value",0);
        $("#rektotal1_ls").attr("Value",0);
        lcstatus = 'tambah';
        $("#nil").attr("value",'');
        $("#ni").attr("value",'');
        $("#alamat").attr("value",'');
        }


	
    function getRowIndex(target){  
			var tr = $(target).closest('tr.datagrid-row');  
			return parseInt(tr.attr('datagrid-row-index'));  
		}  


    
  
    function cetak(){
        var nom=document.getElementById("no_spp").value;
        $("#cspp").combogrid("setValue",nom);
        $("#dialog-modal").dialog('open');
    }
	
    function keluar(){
        $("#dialog-modal").dialog('close');
    } 
    
    
    function keluar_rek(){
        $("#dialog-modal-rek").dialog('close');
        $("#dgsppls").datagrid("unselectAll");
        $("#rek_nilai").attr("Value",0);
        $("#rek_nilai_ang").attr("Value",0);
        $("#rek_nilai_spp").attr("Value",0);
        $("#rek_nilai_sisa").attr("Value",0);
		$("#rek_nilai_ang_semp").attr("Value",0);
        $("#rek_nilai_spp_semp").attr("Value",0);
        $("#rek_nilai_sisa_semp").attr("Value",0);
		$("#rek_nilai_ang_ubah").attr("Value",0);
        $("#rek_nilai_spp_ubah").attr("Value",0);
        $("#rek_nilai_sisa_ubah").attr("Value",0);
    }     
    
    
    function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#spp').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/C_Spp/load_spp_ls',
         queryParams:({cari:kriteria})
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

     
    function hsimpan(){        
        var a       = (document.getElementById('no_spp').value).split(" ").join("");
        var a_hide  = document.getElementById('no_spp_hide').value;
        var b       = $('#dd').datebox('getValue');      
        var c       = document.getElementById('jns_beban').value; 
        var d       = document.getElementById('kebutuhan_bulan').value;
        var e       = document.getElementById('ketentuan').value;
        var j       = document.getElementById('nmskpd').value;
        var k1      = document.getElementById('rektotal1_ls').value;
        var k 		= angka(k1);
		var l       = $('#rekanan').combogrid('getValue');
        var m       = $('#bank').combogrid('getValue');
        var n       = document.getElementById('rekening').value;
        var o       = document.getElementById('pimpinan').value;
        var p       = document.getElementById('npwp').value;
        var q       = document.getElementById('jns_beban').value;
        var r       = $('#no_tagih').combogrid('getValue');
        var s       = document.getElementById('no_tagih_hide').value;
        var t       = document.getElementById('alamat').value;
        
        var kdskpd  = document.getElementById('dn').value;
        if ( a == '' ){
            swal("Error", "Nomor SPP Kosong", "error");
            exit();
        }
		if (kdskpd == ''){
			 swal("Error", "SKPD Kosong", "error");
            exit();
		}
        
        if ( b == '' ){
            swal("Error", "Tanggal Kosong", "error");
            exit();
        }
		var tahun_input = b.substring(0, 4);
		if (tahun_input != tahun_anggaran){
            swal("Error", "Tahun Tidak Sama Dengan Tahun Anggaran", "error");
			exit();
		}
        
        if ( c == '' ){
            swal("Error", "Beban Kosong", "error");
            exit();
        }
        
        if ( d == '' ){
            swal("Error", "Keterangan Kosong", "error");
            exit();
        }
		if ( l == '' ){
            swal("Error", "Rekanan Kosong", "error");
            exit();
        }
		if ( m == '' ){
            swal("Error", "Bank Kosong", "error");
            exit();
        }
		if ( n == '' ){
            swal("Error", "Rekening Kosong", "error");
            exit();
        }
		if ( o == '' ){
            swal("Error", "Pimpinan Kosong", "error");
            exit();
        }
		if ( p == '' ){
            swal("Error", "NPWP Kosong", "error");
            exit();
        }
		
		if ((q=='6')&&(r=='')){
            swal("Error", "Penagihan Kosong", "error");
            exit();
        }
		if ((q=='5')&&(r!='')){
            swal("Error", "Jika Tanpa Penagihan. Nomor Penagihan harus kosong", "error");
            exit();
        }
		var lenket = e.length;
		if ( lenket>1000 ){
            swal("Error", "Keterangan Lebih dari 1000 Karakter", "error");
            exit();
        }
		//Cek Datagrid
		var ctot_det=0;
		 $('#dgsppls').datagrid('selectAll');
            var rows = $('#dgsppls').datagrid('getSelections');           
			for(var x=0;x<rows.length;x++){
			cnilai3     = angka(rows[x].nilai1);
            ctot_det = ctot_det + cnilai3;
			} 
		if (k != ctot_det){
            swal("Error", "Rincian Tidak Sama dengan Total", "error");
			exit();
		}
		
		if (ctot_det==0){
            swal("Error", "Rincian Rekening Kosong", "error");
			exit();
		}
		if(lcstatus == 'tambah'){
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
					data: ({no:a,tabel:'trhsp2d_blud',field:'no_spp'}),
                    url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						alert("Nomor Telah Dipakai!");
						document.getElementById("nomor").focus();
						exit();
						} 
						if(status_cek==0){
						
				//---------
				   $('#dgsppls').datagrid('selectAll');
					var rows = $('#dgsppls').datagrid('getSelections');
					for(var i=0;i<rows.length;i++){            
						cidx      = rows[i].idx;
						ckdgiat   = rows[i].kdkegiatan;
						ckdrek    = rows[i].kdrek5;
						ckdrekblud= rows[i].kdrekblud;
						cnmrekblud= rows[i].nmrekblud;
						cnilai    = angka(rows[i].nilai1);
						no        = i + 1 ;    
							if (i>0) {
								csql = csql+","+"('"+a+"','"+kdskpd+"','"+ckdgiat+"','"+ckdrek+"','"+ckdrekblud+"','"+cnmrekblud+"','"+cnilai+"','')";
							} else {
								csql = "('"+a+"','"+kdskpd+"','"+ckdgiat+"','"+ckdrek+"','"+ckdrekblud+"','"+cnmrekblud+"','"+cnilai+"','')";                 
								}                                             
							}   	                  
							$(document).ready(function(){
								$.ajax({
									type: "POST",   
									dataType : 'json',                 
									data: ({no:a,sql:csql,tgl:b,beban:c,bulan:d,ket:e,total:k,skpd:kdskpd,rekanan:l,bank:m,rekening:n,pimpinan:o,npwp:p,jns:q,tagih:r,alamat:t}),
									url: '<?php echo base_url(); ?>index.php/C_Spp/simpan_spp_ls',
									success:function(data){                        
										status = data;   
										 if (status=='2'){
											$("#loading").dialog('close');
											swal("Berhasil", "Data Berhasil Tersimpan", "success");
											$("#no_spp_hide").attr("value",a);
											lcstatus='edit';
											section1();
										} else if (status=='1'){
											$("#loading").dialog('close');
											lcstatus='tambah';
											swal("Error", "Header Gagal Tersimpan", "error");
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
                    data: ({no:a,tabel:'trhsp2d_blud',field:'no_spp'}),
                    url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && a!=a_hide){
						swal("Error", "Nomor Telah Dipakai", "error");
						exit();
						} 
						if(status_cek==0 || a==a_hide){
						
		//---------
					$('#dgsppls').datagrid('selectAll');
					var rows = $('#dgsppls').datagrid('getSelections');
					for(var i=0;i<rows.length;i++){            
						cidx      = rows[i].idx;
						ckdgiat   = rows[i].kdkegiatan;
						ckdrek    = rows[i].kdrek5;
						ckdrekblud= rows[i].kdrekblud;
						cnmrekblud= rows[i].nmrekblud;
						cnilai    = angka(rows[i].nilai1);
						no        = i + 1 ;    
							if (i>0) {
								csql = csql+","+"('"+a+"','"+kdskpd+"','"+ckdgiat+"','"+ckdrek+"','"+ckdrekblud+"','"+cnmrekblud+"','"+cnilai+"','')";
							} else {
								csql = "('"+a+"','"+kdskpd+"','"+ckdgiat+"','"+ckdrek+"','"+ckdrekblud+"','"+cnmrekblud+"','"+cnilai+"','')";                 
								}                                             
							}   	                  
							$(document).ready(function(){
								$.ajax({
									type: "POST",   
									dataType : 'json',                 
									data: ({no:a,nohide:a_hide,sql:csql,tgl:b,beban:c,bulan:d,ket:e,total:k,skpd:kdskpd,rekanan:l,bank:m,rekening:n,pimpinan:o,npwp:p,jns:q,tagih:r,tagih_hide:s,alamat:t}),
									url: '<?php echo base_url(); ?>index.php/C_Spp/update_spp_ls',
									success:function(data){                        
										status = data;   
										 if (status=='2'){
											$("#loading").dialog('close');
											swal("Berhasil", "Data Berhasil Tersimpan", "success");
											$("#no_spp_hide").attr("value",a);
											lcstatus='edit';
											section1();
										} else if (status=='1'){
											$("#loading").dialog('close');
											lcstatus='edit';
											swal("Error", "Header Gagal Tersimpan", "error");
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
    
    
        
        function hhapus(){				
            var spp = document.getElementById("no_spp").value;              
            var urll= '<?php echo base_url(); ?>/index.php/C_Spp/hapus_spp';             			    
         	if (spp !=''){
				var del=confirm('Anda yakin akan menghapus SPP '+spp+'  ?');
				if  (del==true){
					$(document).ready(function(){
                    $.post(urll,({no:spp}),function(data){
                    status = data;   
					if (status=='1'){
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
			var rows = $('#dg1').edatagrid('getSelections');
			for(var i=0;i<rows.length;i++){
				ids.push(rows[i].kdkegiatan);
			}
			return ids.join(':');
		}
        
        function getSelections1(idx){
			var ids = [];
			var rows = $('#dg1').edatagrid('getSelections');
			for(var i=0;i<rows.length;i++){
				ids.push(rows[i].kdrek5);
			}
			return ids.join(':');
		}
    
    function kembali(){
        $('#kem').click();
    }                
    

    function load_sum_spp(){                
		var nospp = document.getElementById('no_spp').value;
        //var nospp =spp.split("/").join("123456789");       
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({spp:nospp}),
            url:"<?php echo base_url(); ?>index.php/C_Spp/load_sum_spp",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal_ls").attr('value',number_format(n['rektotal'],2,'.',','));
                    $("#rektotal1_ls").attr('value',number_format(n['rektotal'],2,'.',','));
                });
            }
         });
        });
    }
	
	function total_penagihan(){                
		var nospp = document.getElementById('no_spp').value;
        //var nospp =spp.split("/").join("123456789");       
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({spp:nospp}),
            url:"<?php echo base_url(); ?>index.php/C_Spp/load_sum_spp",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal_ls").attr('value',number_format(n['rektotal'],2,'.',','));
                    $("#rektotal1_ls").attr('value',number_format(n['rektotal'],2,'.',','));
                });
            }
         });
        });
    }

    
	
    
    function tombol(st){ 
    if (st==1){
    $('#save').linkbutton('disable');
    $('#del').linkbutton('disable');
    document.getElementById("p1").innerHTML="Sudah di Buat SPM...!!!";
    } else {
     $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
    document.getElementById("p1").innerHTML="";
    }
    }
    
    
    function tombolnew(){  
     $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
     $('#det').linkbutton('enable');     
     $('#sav').linkbutton('enable');
     $('#dele').linkbutton('enable');
    }
		

    
        
   
   function cetak_spp1(cetak) {
		var spasi  = document.getElementById('spasi').value;
		var nomer   = $("#cspp").combogrid('getValue');
        var jns = document.getElementById('jns_beban').value; 
        var no =nomer.split("/").join("123456789");
		var ttd1   = $("#bk").combogrid('getValue');
		var ttd2   = $("#pa").combogrid('getValue');
		var tanpa       = document.getElementById('tanpa_tanggal').checked; 
		if ( tanpa == false ){
           tanpa=0;
        }else{
           tanpa=1;
        }
		if ( ttd1 =='' ){
			alert("Bendahara Pengeluaran tidak boleh kosong!");
			exit();
		}
		if ( ttd2 =='' ){
			alert("PPTK tidak boleh kosong!");
			exit();
		}
		
        var ttd_1 =ttd1.split(" ").join("123456789");
        var ttd_2 =ttd2.split(" ").join("123456789");
		var url    = "<?php echo site_url(); ?>/C_Spp/cetakspp1";    
        window.open(url+'/'+cetak+'/'+no+'/'+kode+'/'+jns+'/'+ttd_1+'/'+ttd_2+'/'+spasi+'/'+tanpa, '_blank');
        window.focus();
        }
		
     function cetak_spp2(cetak) {
		var spasi  = document.getElementById('spasi').value;
		var nomer   = $("#cspp").combogrid('getValue');
        var jns = document.getElementById('jns_beban').value; 
        var no =nomer.split("/").join("123456789");
		var ttd1   = $("#bk").combogrid('getValue');
		var ttd2   = $("#pa").combogrid('getValue');
		var tanpa       = document.getElementById('tanpa_tanggal').checked; 
		if ( tanpa == false ){
           tanpa=0;
        }else{
           tanpa=1;
        }
		if ( ttd1 =='' ){
			alert("Bendahara Pengeluaran tidak boleh kosong!");
			exit();
		}
		if ( ttd2 =='' ){
			alert("PPTK tidak boleh kosong!");
			exit();
		}
		
        var ttd_1 =ttd1.split(" ").join("123456789");
        var ttd_2 =ttd2.split(" ").join("123456789");
		var url    = "<?php echo site_url(); ?>/C_Spp/cetakspp2";    
        window.open(url+'/'+cetak+'/'+no+'/'+kode+'/'+jns+'/'+ttd_1+'/'+ttd_2+'/'+spasi+'/'+tanpa, '_blank');
        window.focus();
        }

	function cetak_spp3(cetak) {
		var spasi  = document.getElementById('spasi').value;
		var nomer   = $("#cspp").combogrid('getValue');
        var jns = document.getElementById('jns_beban').value; 
        var no =nomer.split("/").join("123456789");
		var ttd1   = $("#bk").combogrid('getValue');
		var ttd2   = $("#pa").combogrid('getValue');
		var tanpa       = document.getElementById('tanpa_tanggal').checked; 
		if ( tanpa == false ){
           tanpa=0;
        }else{
           tanpa=1;
        }
		if ( ttd1 =='' ){
			alert("Bendahara Pengeluaran tidak boleh kosong!");
			exit();
		}
		if ( ttd2 =='' ){
			alert("PPTK tidak boleh kosong!");
			exit();
		}
		
        var ttd_1 =ttd1.split(" ").join("123456789");
        var ttd_2 =ttd2.split(" ").join("123456789");
		var url    = "<?php echo site_url(); ?>/C_Spp/cetakspp3";    
        window.open(url+'/'+cetak+'/'+no+'/'+kode+'/'+jns+'/'+ttd_1+'/'+ttd_2+'/'+spasi+'/'+tanpa, '_blank');
        window.focus();
        }
   
   function detail(){
        var lcno = document.getElementById('no_spp').value;
            if(lcno !=''){
               section3();               
            } else {
                alert('Nomor SPP Tidak Boleh kosong')
                document.getElementById('no_spp').focus();
                exit();
            }
    }    
    
	 function runEffect() {
        var selectedEffect = 'explode';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        $("#notagih").combogrid("setValue",'');
        $("#tgltagih").attr("value",'');
        $("#nmskpd").attr("value",'');
        $("#nil").attr("value",'');
        $("#ni").attr("value",'');
    };        
    
    
    function detail_trans(){
		var no_spp  = document.getElementById('no_spp').value;
		var kdskpd  = document.getElementById('dn').value;
        $(function(){
			$('#dgsppls').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/load_detail_spp',
                queryParams    : ({ spp:no_spp,skpd:kdskpd}),
                 idField       : 'idx',
                 toolbar       : "#toolbar",              
                 rownumbers    : "true", 
                 fitColumns    : false,
                 autoRowHeight : "false",
                 singleSelect  : "true",
                 nowrap        : "true",
                 onLoadSuccess : function(data){                      
                 },
                 columns:[[
                     {field:'idx',
					 title:'idx',
					 width:100,
					 align:'left',
                     hidden:'true'
					 },               
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
					 width:280
					 },
                    {field:'nilai1',
					 title:'Nilai',
					 width:110,
                     align:'right'
                     },
                    {field:'hapus',title:'Hapus',width:50,align:"center",
                    formatter:function(value,rec){ 
                    return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                    }
                    }
				]]	
			});
		});
        }
        
        
    function detail_kosong(){
        var no_spp = '' ; 
		$("#rektotal_ls").attr('value',number_format(0,2,'.',','));
        $("#rektotal1_ls").attr('value',number_format(0,2,'.',','));
        $(function(){
			$('#dgsppls').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/load_detail_spp',
                queryParams:({ spp:no_spp }),
                 idField:'idx',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 autoRowHeight:"false",
                 singleSelect:"true",
                 nowrap:"true",
                 onLoadSuccess:function(data){   
                 },
                onSelect:function(rowIndex,rowData){
                kd  = rowIndex ;  
                idx =  rowData.idx ;                                           
                },
                 columns:[[
                     {field:'idx',
					 title:'idx',
					 width:100,
					 align:'left',
                     hidden:'true'
					 },               
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
					 width:280
					 },
                    {field:'nilai1',
					 title:'Nilai',
					 width:110,
                     align:'right'
                     },
                    {field:'hapus',title:'Hapus',width:50,align:"center",
                    formatter:function(value,rec){ 
                    return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                    }
                    }
				]]	
			});
		});
        }
        
        
		function detail_penagihan(){
		var no_tagih = $('#no_tagih').combogrid('getValue') ;
		var kdskpd  = document.getElementById('dn').value;
        $(function(){
			$('#dgsppls').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/load_detail_penagihan',
                queryParams    : ({ tagih:no_tagih,skpd:kdskpd}),
                 idField       : 'idx',
                 toolbar       : "#toolbar",              
                 rownumbers    : "true", 
                 fitColumns    : false,
                 autoRowHeight : "false",
                 singleSelect  : "true",
                 nowrap        : "true",
                 onLoadSuccess : function(data){                      
                 },
                 columns:[[
                     {field:'idx',
					 title:'idx',
					 width:100,
					 align:'left',
                     hidden:'true'
					 },               
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
					 title:'Rekening',
					 width:70,
					 align:'left'
					 },
					{field:'nmrekblud',
					 title:'Nama Rekening',
					 width:280
					 },
                    {field:'nilai1',
					 title:'Nilai',
					 width:110,
                     align:'right'
                     },
                    {field:'hapus',title:'Hapus',width:50,align:"center",
                    formatter:function(value,rec){ 
                    return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                    }
                    }
				]]	
			});
		});
			$(function(){      
			 $.ajax({
				type: 'POST',
				data:({tagih:no_tagih,skpd:kdskpd}),
				url:"<?php echo base_url(); ?>index.php/C_Spp/load_sum_tagih",
				dataType:"json",
				success:function(data){ 
					$.each(data, function(i,n){
						$("#rektotal_ls").attr('value',number_format(n['rektotal'],2,'.',','));
						$("#rektotal1_ls").attr('value',number_format(n['rektotal'],2,'.',','));
					});
				}
			 });
			});
        }
		
		
        function tambah(){
		   validate_kegiatan();
           $("#dialog-modal-rek").dialog('open'); 
           $("#rek_kegi").combogrid("setValue",'');
           $("#nm_rek_kegi").attr("Value",'');
           $("#rek_reke").combogrid("setValue",'');
           $("#nm_rek_reke").attr("Value",'');
           $("#rek_blud").attr("Value",'');
           $("#nm_rek_blud").attr("Value",'');
           $("#rek_nilai").attr("Value",0);
           $("#rek_nilai_ang").attr("Value",0);
           $("#rek_nilai_spp").attr("Value",0);
           $("#rek_nilai_sisa").attr("Value",0);
		   $("#rek_nilai_ang_semp").attr("Value",0);
           $("#rek_nilai_spp_semp").attr("Value",0);
           $("#rek_nilai_sisa_semp").attr("Value",0);
		   $("#rek_nilai_ang_ubah").attr("Value",0);
           $("#rek_nilai_spp_ubah").attr("Value",0);
           $("#rek_nilai_sisa_ubah").attr("Value",0);
        }
        
       
       function append_save() {
            $('#dgsppls').datagrid('selectAll');
            var rows 			= $('#dgsppls').datagrid('getSelections') ;
                jgrid			= rows.length ;
            var jumtotal  		= document.getElementById('rektotal_ls').value ;
                jumtotal  		= angka(jumtotal);
            var vrek_kegi 		= $('#rek_kegi').combobox('getValue');
            var vrek_reke 		= $('#rek_reke').combobox('getValue');
            var cnil      		= document.getElementById('rek_nilai').value;
            var cnilai    		= cnil;      
            var cnil_sisa   	= angka(document.getElementById('rek_nilai_sisa').value) ;
			var cnil_sisa_semp	= angka(document.getElementById('rek_nilai_sisa_semp').value) ;
			var cnil_sisa_ubah	= angka(document.getElementById('rek_nilai_sisa_ubah').value) ;
            var cnil_input  	= angka(document.getElementById('rek_nilai').value) ;
            var status_ang  	= document.getElementById('status_ang').value ;
			var tot_input 		= angka(document.getElementById('rektotal1_ls').value);
			var sisa_kas 		= angka(document.getElementById('sisa_kas').value);
			var vnm_rek_reke 	= document.getElementById('nm_rek_reke').value;
			var ckdrekblud	 	= document.getElementById('rek_blud').value;
			var cnmrekblud	 	= document.getElementById('nm_rek_blud').value;
				akumulasi 		= cnil_input+tot_input;
            if (status_ang==''){
                 swal("Error", "Pilih Tanggal Dahulu", "error");
                 exit();
            }
			
			if ( akumulasi > sisa_kas){
                 swal("Error", "Nilai Melebihi Sisa Kas", "error");
				  exit();
            }
			
            if ( cnil_input == 0 ){
                 alert('Nilai Nol.....!!!, Cek Lagi...!!!') ;
                  exit();
            }
            if ( (status_ang=='Perubahan')&&(cnil_input > cnil_sisa_ubah)){
				 swal("Error", "Nilai Melebihi Anggaran Perubahan", "error");
                 exit();
            }
            if ( (status_ang=='Penyempurnaan')&&(cnil_input > cnil_sisa_ubah)){
				 swal("Error", "Nilai Melebihi Anggaran Perubahan", "error");
                 exit();
            }
			if ( (status_ang=='Penyempurnaan')&&(cnil_input > cnil_sisa_semp)){
				 swal("Error", "Nilai Melebihi Anggaran Penyempurnaan", "error");
                 exit();
            }
			if ( (status_ang=='Penyusunan')&&(cnil_input > cnil_sisa_ubah)){
				 swal("Error", "Nilai Melebihi Anggaran Perubahan", "error");
                 exit();
            }
			if ( (status_ang=='Penyusunan')&&(cnil_input > cnil_sisa_semp)){
				 swal("Error", "Nilai Melebihi Anggaran Penyempurnaan", "error");
                 exit();
            }
			if ( (status_ang=='Penyusunan')&&(cnil_input > cnil_sisa)){
				 swal("Error", "Nilai Melebihi Anggaran Penyusunan", "error");
                 exit();
            }
            
            if ( edit == 'F' ){
                pidx = pidx + 1 ;
                }
                
            if ( edit == 'T' ){
                pidx = jgrid ;
                pidx = pidx + 1 ;
                }

            $('#dgsppls').edatagrid('appendRow',{kdkegiatan:vrek_kegi,kdrek5:vrek_reke,kdrekblud:ckdrekblud,nmrekblud:cnmrekblud,nilai1:cnilai,idx:pidx});
            $("#dialog-modal-rek").dialog('close'); 
            jumtotal = jumtotal + angka(cnil) ;
            $("#rektotal_ls").attr('value',number_format(jumtotal,2,'.',','));
            $("#rektotal1_ls").attr('value',number_format(jumtotal,2,'.',','));
            $("#dgsppls").datagrid("unselectAll");
       }
       
	function hapus_detail(){
        var rows = $('#dgsppls').edatagrid('getSelected');
        cgiat    = rows.kdkegiatan;
        crek     = rows.kdrek5;
        cnil     = rows.nilai1;
        var idx = $('#dgsppls').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, Kegiatan : '+cgiat+' Rekening : '+crek+' Nilai : '+cnil);
        if (tny==true){
            $('#dgsppls').edatagrid('deleteRow',idx);
            total = angka(document.getElementById('rektotal_ls').value) - angka(cnil);            
            $('#rektotal_ls1').attr('value',number_format(total,2,'.',','));    
            $('#rektotal_ls').attr('value',number_format(total,2,'.',','));
        } 
    }
	
	 function get_spp(){
		  
			 var skpd =document.getElementById("dn").value;
			//skpd=kode;
			
				jns = "LS";
			
			
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Spp/config_spp/'+skpd,
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			no_spp = data.nomor;
					kd = data.kd;
					thn_ang=data.thn_ang;
					
					var inisial = no_spp + "/SPP-"+jns+"/BLUD/"+kd+"/"+thn_ang;
					$("#no_spp").attr('disabled',true);
                    $("#no_spp").attr("value",inisial);
                    $("#dd_spp").attr("value",no_spp);
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
<h3><a href="#" id="section1" onclick="javascript:$('#spp').edatagrid('reload')">List SPP</a></h3>
    <div style="height:350px;">

    <p align="right">         
        <a id="tambah" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="spp" title="List SPP" style="width:870px;height:650px;" >  
        </table>
    </p> 
    </div>

<h3><a href="#" id="section2">Input SPP</a></h3>
 <div  style="height:350px;">
   <p id="p1" style="font-size: x-large;color: red;"></p>
   <fieldset style="width:850px;height:950px;border-color:white;border-style:hidden;border-spacing:0;padding:0;">            
   <table border='1' style="font-size:11px">
  <tr>
	<td style="border-bottom: double 1px red;border-right-style:hidden;border-top: double 1px red;"><i>No. Tersimpan<i></td>
	<td style="border-bottom: double 1px red;border-right-style:hidden;border-top: double 1px red;"><input type="text" id="no_simpan" style="border:0;width: 200px;" readonly="true";/></td>
	<td style="border-bottom: double 1px red;border-right-style:hidden;border-top: double 1px red;">&nbsp;&nbsp;</td>
	<td style="border-bottom: double 1px red;border-top: double 1px red;" colspan = "2"><i>Tidak Perlu diisi atau di Edit</i></td>
</tr> 
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='53%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td>
 </tr>  
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td colspan="2" width="8%" style= "color: red;border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >No SPP Terisi Otomatis ! Silahkan Tekan Tombol "Ambil No SPP" !</td>
    </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >   
   <td width="8%" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;" >No SPP</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="no_spp" id="no_spp"  disabled style="width:250px" onkeyup="this.value=this.value.toUpperCase()"/><input type="hidden" name="no_spp_hide" id="no_spp_hide" style="width:140px"/>
   <a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:get_spp();">Ambil No SPP</a></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Tanggal</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input id="dd" name="dd" type="text" /></td>   
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td width='8%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">B L U D</td>
   <td colspan="3" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"> <input id="dn" name="dn"  readonly="true" style="width:130px; border: 0;"/>
   &nbsp;&nbsp;&nbsp;
   <input id="nmskpd" name="nmskpd" type="text"  style="border: 0;width:350px;"  readonly="true">
   </td> 
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Beban</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"><select name="jns_beban" id="jns_beban" style="height: 27px; width:260px;" onchange="javascript:validate_jenis();">
     <option value="">--Pilih Jenis Beban--</option>     
     <option value="5">LS Barang Jasa (Tanpa Penagihan)</option>     
     <option value="6">LS Barang Jasa (Dengan Penagihan)</option>     
   </td>
  <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Bulan</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><select  name="kebutuhan_bulan" id="kebutuhan_bulan" >
     <option value="">...Pilih Kebutuhan Bulan... </option>
     <option value="1">1  | Januari</option>
     <option value="2">2  | Februari</option>
     <option value="3">3  | Maret</option>
     <option value="4">4  | April</option>
     <option value="5">5  | Mei</option>
     <option value="6">6  | Juni</option>
     <option value="7">7  | Juli</option>
     <option value="8">8  | Agustus</option>
     <option value="9">9  | September</option>
     <option value="10">10 | Oktober</option>
     <option value="11">11 | November</option>
     <option value="12">12 | Desember</option>
   </select></td>
 </tr>
  <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Keperluan</td>
   <td colspan="3" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">
   <textarea name="ketentuan" id="ketentuan" rows="1" cols="50" style="width: 720px;" ></textarea></td>
 </tr>
  <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Rekanan</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="rekanan" id="rekanan"  style="width:200px" /></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Pimpinan </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="pimpinan" id="pimpinan"  style="width:200px" /></td>   
 </tr>
  <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Bank</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="bank" id="bank"  style="width:50px" />&nbsp;&nbsp; <input type="text" name="nama_bank" id="nama_bank" style="border:0;width:250px" readonly="true"/></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">Rekening </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="rekening" id="rekening"  style="width:200px" /></td>   
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">NPWP</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="npwp" id="npwp"  style="width:200px" /></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"> Alamat</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;<input type="text" name="alamat" id="alamat"  style="width:200px" /></td>   
 </tr>
 <tr id="penagihan" style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">No. Tagih</td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;<input type="text" name="no_tagih" id="no_tagih"  style="width:200px" /> <input type="hidden" name="no_tagih_hide" id="no_tagih_hide"  style="width:200px" readonly="true"/></td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;"> </td>
   <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td>   
 </tr>
 <tr style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">
   <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='53%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='8%'  style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;border-right-style:hidden;">&nbsp;</td>
   <td width='31%' style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">&nbsp;</td>
 </tr>  
 <tr style="border-spacing: 3px;padding:3px 3px 3px 3px;">
	<td colspan="4" align='right' style="border-bottom-color:black;border-spacing: 3px;padding:3px 3px 3px 3px;" >
	<a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true"  onclick="javascript:hsimpan();">Simpan</a>
	<a id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hhapus();javascript:section1();">Hapus</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a>
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a></td>              
 </tr>
</table>
 <!------------------------------------------------------------------------------------------------------------------>
        <table id="dgsppls" title="Input Detail SPP" style="width:850%;height:300%;" >  
        </table>
        
        <div id="toolbar" align="left">
    		<a id="icon_tambah" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah();">Tambah Rekening</a>
        </div>
  
        <table border='0' style="width:100%;height:5%;"> 
             <td width='20%'></td>
             <td width='30%'><input class="right" type="hidden" name="rektotal1_ls" id="rektotal1_ls"  style="width:140px" align="right" readonly="true" ></td>
             <td width='20%' align='right'><B>Total</B></td>
             <td width='30%' align='center'><input class="right" type="text" name="rektotal_ls" id="rektotal_ls"  style="width:140px" align="right" readonly="true" ></td>
        </table>
        </fieldset>
        <!------------------------------------------------------------------------------------------------------------------>
   </div>

</div>
</div> 
			<div id="loading" title="Loading...">
			<table align="center">
			<tr align="center"><td><img id="search1" height="50px" width="50px" src="<?php echo base_url();?>/image/loadingBig.gif"  /></td></tr>
			<tr><td>Loading...</td></tr>
			</table>
			</div>


<div id="dialog-modal-rek" title="Input Rekening">
    <p class="validateTips"></p>  
    <fieldset>
    <table align="center" style="width:100%;" border="0">
            <tr>
                <td>KEGIATAN</td>
                <td>:</td>
                <td colspan="6"><input id="rek_kegi" name="rek_kegi" style="width: 200px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="nm_rek_kegi" style="border:0;width: 300px;" readonly="true"/></td>                            
            </tr>

            <tr>
                <td>REKENING</td>
                <td>:</td>
                <td colspan="6"><input id="rek_reke" name="rek_reke" style="width: 200px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="nm_rek_reke" style="border:0;width: 300px;" readonly="true"/></td>                            
            </tr>
			<tr>
                <td>Rek. BLUD</td>
                <td>:</td>
                <td colspan="6"><input id="rek_blud" name="rek_blud" style="width: 200px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="nm_rek_blud" style="border:0;width: 300px;" readonly="true"/></td>                            
            </tr>
            
            <tr bgcolor="#99FF99">
                <td>ANGGARAN</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_ang" style=" width: 196px; text-align: right; " readonly="true" /></td> 
                <td>JUMLAH SPP LALU</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_spp" style="width: 196px; text-align: right; " readonly="true" /></td>
				<td>SISA</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_sisa" style="width: 196px; text-align: right; " readonly="true" /></td>				
            </tr>
			
			<tr bgcolor="#ffe928">
                <td>PENYEMPURNAAN</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_ang_semp" style="width: 196px; text-align: right; " readonly="true" /></td> 
                <td>JUMLAH SPP LALU</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_spp_semp" style="width: 196px; text-align: right; " readonly="true" /></td>
				<td>SISA</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_sisa_semp" style="width: 196px; text-align: right; " readonly="true" /></td>				
            </tr>
			<tr bgcolor="#ff4759">
                <td>PERUBAHAN</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_ang_ubah" style="width: 196px; text-align: right; " readonly="true" /></td> 
                <td>JUMLAH SPP LALU</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_spp_ubah" style="width: 196px; text-align: right; " readonly="true" /></td>
				<td>SISA</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai_sisa_ubah" style="width: 196px; text-align: right; " readonly="true" /></td>				
            </tr>
			 <tr>
                <td>KAS BLUD</td>
                <td>:</td>
                <td><input type="text" id="sisa_kas" style="border:0;width:196px; text-align: right;" readonly="true"/></td> 
            <tr>
            <tr>
                <td>NILAI</td>
                <td>:</td>
                <td><input type="text" id="rek_nilai" style="width: 196px; text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td> 
            <tr>
                <td>STATUS</td>
                <td>:</td>
                <td><input type="text" id="status_ang" style="width: 196px; border:0; text-align: left;" readonly="true"/></td> 
            
			</tr>
            
            <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;</td> 
            </tr>
            
            <tr>
                <td colspan="6" align="center">
                <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:append_save();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar_rek();">Keluar</a>  
                </td>
            </tr>
            
    </table>  
    </fieldset>
	
</div>

<div id="dialog-modal" title="CETAK SPP">
    <p class="validateTips">SILAHKAN PILIH SPP</p>  
    <fieldset>
    <table>
        <tr>            
            <td width="110px">NO SPP:</td>
            <td><input id="cspp" name="cspp" style="width: 170px;" disabled />  &nbsp; &nbsp; &nbsp; <input type="checkbox" id="tanpa_tanggal"> Tanpa Tanggal</td>
        </tr>
       
		<tr>
            <td width="110px">Bend. Pengeluaran:</td>
            <td><input id="bk" name="bk" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd1" name="nmttd1" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">PA:</td>
            <td><input id="pa" name="pa" style="width: 170px;" />  &nbsp; &nbsp; &nbsp;  <input id="nmttd3" name="nmttd3" style="width: 170px;border:0" /></td>
        </tr>
		<tr>
            <td width="110px">SPASI:</td>
            <td><input type="number" id="spasi" style="width: 100px;" value="1"/></td>
        </tr>
    </table>  
    </fieldset>
    <div>
    </div>  
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_spp1(0);">Pengantar</a> 
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_spp2(0);">Ringkasan</a> 
	<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak_spp3(0);">Rincian</a> 
	<br/>
	<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_spp1(1);">Pengantar</a>
	<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_spp2(1);">Ringkasan</a>
	<a class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="javascript:cetak_spp3(1);">Rincian</a>
	&nbsp;&nbsp;&nbsp;<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>  
</div>

</body>
</html>