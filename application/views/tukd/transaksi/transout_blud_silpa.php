<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autonumeric/autoNumeric-2.0-BETA.js"></script>
    <link href="<?php echo base_url(); ?>easyui/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert.css">

 

     <style>    
    #tagih {
        position: relative;
        width: 500px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript">
      
    
    var kode  = '';
    var giat  = '';
    var jenis = '';
    var nomor = '';
    var cid   = 0;
    var lcstatus = '';

    
    var xxx = 0;
                     
     $(document).ready(function() {
		 $("#penagihan").hide();
		 $("#pilihan").hide();
		 get_skpd();
            $( "#jr" ).dialog({
              height: 220,
              width: 580,
              modal: true,
              autoOpen:false,
              buttons: {
                Close: function (){
                $(this).dialog("close");
                }
              }
            });
            $("#nomor_urut").attr('maxlength','5');
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 650,
                width: 1000,
                modal: true,
                autoOpen:false                
            });              
            $("#tagih").hide();
      			$("#tbl_s2pd_tu").hide();
      			$("#dialog-modal_edit").dialog({
                  height: 150,
                  width: 700,
                  modal: true,
                  autoOpen:false
              });
            $('input[name=dari_anggaran]').bind('change', function(){
                    kosong2();
            });
        });    
     
    
 $(function(){ 
     $('#sdana').combogrid({
       url:'<?php echo base_url(); ?>index.php/C_Transout/ambil_sdana',
      
       panelWidth:160,
       idField:'kd_sdana',  
       textField:'nm_sdana',  
       mode:'remote',
       fitColumns:'true',
       columns:[[
        {field:'nm_sdana',title:'Sumber Dana',width:150}
       ]],
       onSelect:function(rowIndex,rowData){
        //$('#nilai').focus();
        //$('#nmunit').attr('value',(rowData.nm_unit).toUpperCase());
       }
    }); 

      var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
        };
        $( "#accordion" ).accordion({
        icons: icons
        });
        $( "#toggle" ).button().on( "click", function() {
        if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
        $( "#accordion" ).accordion( "option", "icons", null );
        } else {
        $( "#accordion" ).accordion( "option", "icons", icons );
        }
        });
        
        $( ".widget input[type=submit], .widget a, .widget button" ).button();

     $('#dg').edatagrid({
    url: '<?php echo base_url(); ?>/index.php/C_Transout/load_transout_silpa',
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
        width:100},
            {field:'tgl_bukti',
        title:'Tanggal',
        width:40},
            {field:'nm_skpd',
        title:'Nama B L U D',
        width:100,
            align:"left"},
            {field:'ket',
        title:'Keterangan',
        width:100,
            align:"left"}
        ]],
        onSelect:function(rowIndex,rowData){
          nomor_bukti = rowData.no_bukti;
          tgl         = rowData.tgl_bukti;
          kode        = rowData.kd_skpd;
          nama        = rowData.nm_skpd;
          ket         = rowData.ket;          
          tot         = rowData.total;
          vpay        = rowData.pay;
          beban       = rowData.jns_spp;
          notagih     = rowData.no_tagih;
          jnstagih    = rowData.sts_tagih;
          lcstatus    = 'edit';         
          get(nomor_bukti,tgl,kode,nama,ket,tot,vpay,beban,jnstagih,notagih);
                                                   
        },
        onDblClickRow:function(rowIndex,rowData){         
                       
             xxx = 0;
    section2();
    load_detail();  
	cek_status_ang();
             
        }
    });

    $(function(){
      $('#dgpajak').edatagrid({
            idField       : 'id',    
            rownumbers    : "true", 
            fitColumns    : false,
            autoRowHeight : "false",
            singleSelect  : "true",
            nowrap        : "true",
            showFooter:"true",
            /*pagination  : "true",*/
            columns       :
                     [[
                        {field:'id',title:'id',width:100,align:'left',hidden:'true'}, 
                        {field:'kd_rek5',title:'Rekening',width:100,align:'left'},      
                        {field:'nm_rek5',title:'Nama Rekening',width:317},
                        {field:'nilai',title:'Nilai',width:250,align:"right"},
                        {field:'hapus',title:'Hapus',width:100,align:"center",
                        formatter:function(value,rec){ 
                            return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail_pot();" />';
                            }
                        }
              ]]
          });
      });
    
    $('#dg1').edatagrid({  
            toolbar:'#toolbar',
            rownumbers:"true", 
            fitColumns:"true",
            //singleSelect:"true",
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",            
            nowrap:"true",
            onSelect:function(rowIndex,rowData){                    
                    idx = rowIndex;
                    nilx = rowData.nilai;
            }
        });  
        
    $('#dg2').edatagrid({                   
         toolbar:'#toolbar',
		rownumbers:"true", 
		fitColumns:"true",
		//singleSelect:"true",
		autoRowHeight:"false",
		loadMsg:"Tunggu Sebentar....!!",            
		nowrap:"true",
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
            hidden:"true",
            width:30},
			{field:'sp2d',
			title:'No Ambil Kas',
            width:30},
            {field:'kd_kegiatan',
			title:'Kegiatan',
            width:20},
            {field:'nm_kegiatan',
			title:'Nama Kegiatan',        
            hidden:"true",
            width:30},
            {field:'kd_rek5',
			title:'Kode Rekening',
            width:15,
            align:'center'},
            {field:'kd_rek_blud',
			title:'Rek. Blud',
            width:15,
            align:'center'},
            {field:'nm_rek5',
			title:'Nama Rekening',
            align:"left",
            width:40,
			hidden:"true"},
            {field:'nm_rek_blud',
			title:'Nama Rekening',
            align:"left",
            width:30},
			{field:'nilai',
			title:'Rupiah',
            align:"right",
            width:15}
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
        
         $('#tglkas').datebox({  
            required:true,
            formatter :function(date){
              var y = date.getFullYear();
              var m = date.getMonth()+1;
              var d = date.getDate();    
              return y+'-'+m+'-'+d;
            }
        });
        
         $('#tgl_kas').datebox({  
            required:true,
            formatter :function(date){
              var y = date.getFullYear();
              var m = date.getMonth()+1;
              var d = date.getDate();    
              return y+'-'+m+'-'+d;
            }
        });
        
  
      
         //alert(kode);                                 
        $('#giat').combogrid({  
           panelWidth:700,  
           idField:'kd_kegiatan',  
           textField:'kd_kegiatan',  
           mode:'remote',
           //url:'<?php echo base_url(); ?>index.php/C_Transout/load_trskpd',
           queryParams:({kd:kode}),             
           columns:[[  
               {field:'kd_kegiatan',title:'Kode Kegiatan',width:140},  
               {field:'nm_kegiatan',title:'Nama Kegiatan',width:700}
           ]],  
           onSelect:function(rowIndex,rowData){
              idxGiat     = rowIndex;               
              giat        = rowData.kd_kegiatan;
              var kode    = document.getElementById('kdskpd').value;
              var jns_bbn = document.getElementById('jns_beban').value;
              $("#nmgiat").attr("value",rowData.nm_kegiatan);
			  $('#sp2d').combogrid({url:'<?php echo base_url(); ?>index.php/C_Transout/load_no_ambil_silpa',
			   queryParams:({giat:giat,	kd:kode,jns:jns_bbn})
			   });
           }  
        });
      
		
		 $('#sp2d').combogrid({  
           panelWidth:650,  
           idField:'no_sp2d',  
           textField:'no_sp2d',  
           mode:'remote',
           queryParams:({kd:kode}),             
           columns:[[  
               {field:'no_sp2d',title:'No Ambil Kas',width:100},  
               {field:'tgl_bukti',title:'Tanggal Ambil Kas',width:150},  
               {field:'total',title:'Nilai',width:400}
           ]],  
           onSelect:function(rowIndex,rowData){
              sp2d        = rowData.no_sp2d;
              var kode    = document.getElementById('kdskpd').value;
              var nobukti = document.getElementById('nomor_urut').value;
              var jns_bbn = document.getElementById('jns_beban').value;
			  var giat    	= $('#giat').combogrid('getValue');
              var frek    = '';
              $('#dg1').edatagrid('unselectAll');                 
              $('#rek').combogrid({url:'<?php echo base_url(); ?>index.php/C_Transout/load_rek_lain',
			   queryParams:({no:nobukti,
							giat:giat,
							jns:jns_bbn,
							kd:kode,
							sp2d:sp2d})
			   });
			   
			  load_sisa_bank();
			  load_sisa_tunai();
           }  
        });
		
		 $('#rek').combogrid({  
           panelWidth:700,  
           idField:'kd_rek5',  
           textField:'kd_rek5',
           mode:'remote',                                   
           columns:[[  
               {field:'kd_rek_blud',title:'Rek. BLUD',width:75,align:'left'},  
               {field:'nm_rek_blud',title:'Nama Rekening BLUD',width:275},
			   {field:'kd_rek5',title:'Rek. Ang',width:75,align:'left'},  
               {field:'nm_rek5',title:'Nama Rekening Ang',width:275},

           ]],
           onSelect:function(rowIndex,rowData){
			var sp2d    = $('#sp2d').combogrid('getValue');
			var giat    = $('#giat').combogrid('getValue');
			var kode    = document.getElementById('kdskpd').value;
			var jns    = document.getElementById('jns_beban').value;
			$('#nmrek').attr('value',(rowData.nm_rek5).trim());
			$('#rek_blud').combogrid('setValue',(rowData.kd_rek_blud).trim());
			$('#nm_rek_blud').attr('value',(rowData.nm_rek_blud).trim());
			var koderek = rowData.kd_rek5 ;
            var koderekblud = rowData.kd_rek_blud ;
			   $.ajax({
					type     : "POST",
					dataType : "json",   
					data     : ({kegiatan:giat,kdrek5:koderek,kdrekblud:koderekblud,kd_skpd:kode,jns:jns,sp2d:sp2d}), 
					url      : '<?php echo base_url(); ?>index.php/C_Transout/jumlah_ang_trans_lain',
					success  : function(data){
						  $.each(data, function(i,n){
							$("#ang_murni").attr("Value",n['nilai']);
							$("#real_murni").attr("Value",n['nilai_spp_lalu']);
							$("#ang_ubah").attr("Value",n['nilai_ubah']);
							$("#real_ubah").attr("Value",n['nilai_spp_lalu']);
							var n_ang  = n['nilai'] ;
							var n_ang_ubah  = n['nilai_ubah'] ;
							var n_spp  = n['nilai_spp_lalu'] ;
							var n_sisa = angka(n_ang) - angka(n_spp) ;
							var n_sisa_ubah = angka(n_ang_ubah) - angka(n_spp) ;
							$("#sisa_murni").attr("Value",number_format(n_sisa,2,'.',','));
							$("#sisa_ubah").attr("Value",number_format(n_sisa_ubah,2,'.',','));
						});
					}                                     
			   });
            } 
        });

	$('#rek_blud').combogrid({  
           panelWidth:700,  
           idField:'kd_rek_blud',  
           textField:'kd_rek_blud',  
           mode:'remote',
           //url:'<?php echo base_url(); ?>index.php/C_Transout/load_trskpd',
           queryParams:({kd:kode}),             
           columns:[[  
               {field:'kd_rek_blud',title:'Kode Rek. Blud',width:140},  
               {field:'nm_rek_blud',title:'Nama Rek. Blud',width:700}
           ]]  
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
						//total_penagihan();
                    }   
                });
		
    });   
	
    function cek_status_ang(){
        var tgl_cek = $('#tanggal').datebox('getValue');
          $.ajax({
            url:'<?php echo base_url(); ?>index.php/tukd_blud/cek_status_ang',
                data: ({tgl_cek:tgl_cek}),
		   //queryParams    : ({ tgl_cek:tgl_cek }),
            type: "POST",
            dataType:"json",                         
            success:function(data){
          $("#status_ang").attr("value",data.status_ang);
          }  
            });
        }
	
    function get_skpd() {
          $.ajax({
            url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
            type: "POST",
            dataType:"json",                         
            success:function(data){
                        $("#kdskpd").attr("value",data.kd_skpd);
                        $("#nmskpd").attr("value",data.nm_skpd);
                        kode = data.kd_skpd;
                        kegia();              
                        }                                     
          });  
        }
        
    function kegia(){
      $('#giat').combogrid({url:'<?php echo base_url(); ?>index.php/C_Transout/load_trskpd',queryParams:({kd:kode,jenis:'52'})});  
    }     
    
	function get_nourut(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_blud/no_urut',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
					$("#nomor_urut").attr("value",data.no_urut);
					$("#nomor_simpan").attr("value",data.no_urut);
        		}                                     
        	});  
        }
             
    function hapus_detail(){
        var rows = $('#dg2').edatagrid('getSelected');
        cgiat = rows.kd_kegiatan;
        crek = rows.kd_rek5;
        cnil = rows.nilai;
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
    
  function load_detail_baru(){        
        var kk = '';
        var ctgl = $('#tanggal').datebox('getValue');
        var cskpd = document.getElementById("kdskpd").value;//$('#skpd').combogrid('getValue');             
           $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/C_Transout/load_dtransout',
                data: ({no:kk,kd_skpd:cskpd}),
                dataType:"json",
                success:function(data){
                    $.each(data,function(i,n){  					
                    no      = n['no_bukti'];                                                                   
                    sp2d    = n['no_sp2d'];
                    giat    = n['kd_kegiatan'];
                    nmgiat  = n['nm_kegiatan'];
                    rek5    = n['kd_rek5'];
                    rek_blud  = n['kd_rek_blud'];
                    nmrek5  = n['nm_rek5'];
                    nmrek_blud  = n['nm_rek_blud'];
                    nil     = number_format(n['nilai'],2,'.',',');
                    status = n['status'];
                    $('#dg1').edatagrid('appendRow',{no_bukti:no,sp2d:sp2d,kd_kegiatan:giat,nm_kegiatan:nmgiat,kd_rek5:rek5,kd_rek_blud:rek_blud,nm_rek5:nmrek5,nm_rek_blud:nmrek_blud,nilai:nil,status:status});                                                                                                                                                                                                                                                                                                                                                                                             
                    });                                                                           
                }
            });
           });   
           set_grid();                                                  
    }
  
  
   
    function load_detail(){        
        var kk = nomor_bukti;
        var ctgl = $('#tanggal').datebox('getValue');
        var cskpd = document.getElementById("kdskpd").value;        
           $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/C_Transout/load_dtransout',
                data: ({no:kk,kd_skpd:cskpd}),
                dataType:"json",
                success:function(data){
                    $.each(data,function(i,n){  					
                    no      = n['no_bukti'];                                                                   
                    sp2d    = n['no_sp2d'];
                    giat    = n['kd_kegiatan'];
                    nmgiat  = n['nm_kegiatan'];
                    rek5    = n['kd_rek5'];
                    rek_blud  = n['kd_rek_blud'];
                    nmrek5  = n['nm_rek5'];
                    nmrek_blud  = n['nm_rek_blud'];
                    nil     = number_format(n['nilai'],2,'.',',');
                    status = n['status'];
                    kd_skpd = n['kd_skpd'];
                    $('#dg1').edatagrid('appendRow',{no_bukti:no,sp2d:sp2d,kd_kegiatan:giat,nm_kegiatan:nmgiat,kd_rek5:rek5,kd_rek_blud:rek_blud,nm_rek5:nmrek5,nm_rek_blud:nmrek_blud,nilai:nil,status:status,kd_skpd:kd_skpd});                                                                                                                                                                                                                                                                                                                                                                                             
                    });                                                                           
                }
            });
           });   
           set_grid();                                                  
    }
  
       function plhsp2d(no_sp2d,no_sp2d){
              $("#no_sp2d").attr("Value",no_sp2d);
              $("#no_kas").attr("Value",no_kas_bud);
              $("#tgl_kas").datebox("setValue",tgl_kas_bud);
              //$("#nomor").attr("Value",no_kas_bud);
              $("#tanggal").datebox("setValue",'');
  }

    function load_detail_baru(){           
           set_grid();                                                  
    }
    
    function set_grid(){
        $('#dg1').edatagrid({                                                                   
            columns:[[
            {field:'no_bukti',
			title:'No Bukti',       
            hidden:"true",
            width:30},
			{field:'sp2d',
			title:'No Ambil Kas',
            width:50},
            {field:'kd_kegiatan',
			title:'Kegiatan',
            width:50},
            {field:'nm_kegiatan',
			title:'Nama Kegiatan',        
            hidden:"true",
            width:30},
            {field:'kd_rek5',
			title:'Kode Rekening',
            width:25,
            align:'center'},
            {field:'kd_rek_blud',
			title:'Rek. Blud',
            width:25,
            align:'center'},
            {field:'nm_rek5',
			title:'Nama Rekening',
            align:"left",
            width:40,
			hidden:"true"},
            {field:'nm_rek_blud',
			title:'Nama Rekening',
            align:"left",
            width:40},
			{field:'nilai',
			title:'Rupiah',
            align:"right",
            width:30},
            {field:'status',
			title:'Status',        
            hidden:"true",
            width:30},
            {field:'kd_skpd',
			title:'Kode SKPD',        
            hidden:"true",
            width:30}
            ]]
        });                 
    }
    
    function load_detail2(){        
       $('#dg1').datagrid('selectAll');
       var rows = $('#dg1').datagrid('getSelections');             
       if (rows.length==0){
            set_grid2();
            return;
       }                     
		for(var p=0;p<rows.length;p++){
            no        	= rows[p].no_bukti;
            sp2d      	= rows[p].sp2d;
            giat      	= rows[p].kd_kegiatan;
            nmgiat    	= rows[p].nm_kegiatan;
            rek5      	= rows[p].kd_rek5;
            kd_rek_blud = rows[p].kd_rek_blud;
            nmrek5    	= rows[p].nm_rek5;
            nm_rek_blud = rows[p].nm_rek_blud;
            nmrek13   	= rows[p].nm_rek13;
            nil       	= rows[p].nilai;
            $('#dg2').edatagrid('appendRow',{no_bukti:no,sp2d:sp2d,kd_kegiatan:giat,nm_kegiatan:nmgiat,kd_rek_blud:kd_rek_blud,kd_rek5:rek5,nm_rek5:nmrek5,nm_rek_blud:nm_rek_blud,nilai:nil});            
        }
        $('#dg1').edatagrid('unselectAll');
    } 
    
    function set_grid2(){
        $('#dg2').edatagrid({      
         columns:[[
            {field:'hapus',
        title:'Hapus',
            width:17,
            align:"center",
            formatter:function(value,rec){                                                                       
                return '<img src="<?php echo base_url(); ?>/assets/images/icon/cross.png" onclick="javascript:hapus_detail();" />';                  
                }                
            },
            {field:'no_bukti',
			title:'No Bukti',       
            hidden:"true",
            width:30},
			{field:'sp2d',
			title:'No Ambil Kas',
            width:50},
            {field:'kd_kegiatan',
			title:'Kegiatan',
            width:50},
            {field:'nm_kegiatan',
			title:'Nama Kegiatan',        
            hidden:"true",
            width:30},
            {field:'kd_rek5',
			title:'Kode Rekening',
            width:25,
            align:'center'},
            {field:'kd_rek_blud',
			title:'Rek. Blud',
            width:25,
            align:'center'},
            {field:'nm_rek5',
			title:'Nama Rekening',
            align:"left",
            width:40,
			hidden:"true"},
            {field:'nm_rek_blud',
			title:'Nama Rekening',
            align:"left",
            width:40},
			{field:'nilai',
			title:'Rupiah',
            align:"right",
            width:30}
            ]]     
        });
    }
    
     function section1(){
         $(document).ready(function(){    
             $('#section1').click();  
              $('#dg').edatagrid('reload');
         });
         set_grid();
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
            
    function get(nomor_bukti,tgl,kode,nama,ket,tot,vpay,beban,jnstagih,notagih){
        $("#nomor_urut").attr("value",nomor_bukti);
        $("#nomor_simpan").attr("value",nomor_bukti);
        $("#tanggal").datebox("setValue",tgl);
        $("#keterangan").attr("value",ket);        
        $("#total").attr("value",number_format(tot,2,'.',','));
        $("#jns_tunai").attr("value",vpay);    
        $("#jns_beban").attr("value",beban); 
        $("#jns_tagih").attr("value",jnstagih); 
		$("#no_tagih").combogrid("setValue",notagih);
		if(jnstagih=='1'){
			$("#penagihan").show();	
			$("#pilihan").show();	
		}else{
			$("#penagihan").hide();	
			$("#pilihan").hide();	
		}
    }
    
    function tombol(st){  
    if (st=='1'){
    $('#simpan').linkbutton('disable');
    $('#poto').linkbutton('disable');
    $('#hapus').linkbutton('disable');
    document.getElementById("p1").innerHTML="Sudah di Buat LPJ !!";
     } else {
     $('#tambah').linkbutton('enable');
     $('#hapus').linkbutton('enable');
     $('#simpan').linkbutton('enable');
     $('#poto').linkbutton('enable');
     document.getElementById("p1").innerHTML="";
     }
    }
    
    function tombolnew(){  
    $('#simpan').linkbutton('enable');
    $('#poto').linkbutton('enable');
     $('#tambah').linkbutton('enable');
     $('#hapus').linkbutton('enable');
    $('#tombol_giat').linkbutton('enable');
    }

   
    
    function kosong(){//r
    	$("#tbl_giat").show();
		get_nourut();
    	$('#dg1').datagrid('loadData',[]);
        cdate = '<?php echo date("Y-m-d"); ?>';
        $("#nomor_urut").attr("value",'');
        $("#nomor_simpan").attr("value",'');
        $("#tanggal").datebox("setValue",'');
        document.getElementById("p1").innerHTML="";
        $("#keterangan").attr("value",'');        
        $("#status_ang").attr("value",'');        
        $("#total").attr("value",'0');         
        $("#jns_tunai").attr("value",'TUNAI');
        
        load_detail_baru(); 
        document.getElementById("nomor_simpan").disabled=true; 
        document.getElementById("nomor_urut").disabled=false; 
        document.getElementById("nomor_urut").focus();
        tombolnew();
        kosong2();
        lcstatus = 'tambah';
        xxx = 0;
        $('#dgpajak').datagrid('loadData',[]);
    }
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
    url: '<?php echo base_url(); ?>/index.php/C_Transout/load_transout_lain',
            queryParams:({cari:kriteria})
        });        
     });
    } 
    
      
    function append_save(){
        var no  		= document.getElementById('nomor_urut').value;
		var giat    	= $('#giat').combogrid('getValue');
		var sp2d    	= $('#sp2d').combogrid('getValue');
        var rek     	= $('#rek').combogrid('getValue');
		var rek_blud	= $('#rek_blud').combogrid('getValue');
        var nm_rek_blud = document.getElementById('nm_rek_blud').value;
        var nm_rek 		= document.getElementById('nmrek').value;
        var nmgiat 		= document.getElementById('nmgiat').value;
        var status_ang  = document.getElementById('status_ang').value;
        var nil     	= document.getElementById('nilai').value;    
        var jns_tunai  	= document.getElementById('jns_tunai').value;    
        var nil1     	= angka(document.getElementById('nilai').value);    
        var ang_murni  	= angka(document.getElementById('ang_murni').value);    
        var ang_ubah  	= angka(document.getElementById('ang_ubah').value);    
        var total1  	= angka(document.getElementById('total1').value);    
        var nsisa_bank  = angka(document.getElementById('sisa_bank').value);    
        var nsisa_tunai = angka(document.getElementById('sisa_tunai').value);    
         
		if ((status_ang  == 'Penyusunan') && (nil1 > ang_murni) ){
			swal({title: "",text:"<a style='color:red;font-size:large;'>Nilai Melebihi Anggaran Penyusunan.</a>",type:"warning",html:true});
			return;
		}  
		if ((status_ang  == 'Penyusunan') && (nil1 > ang_ubah) ){
			swal({title: "",text:"<a style='color:red;font-size:large;'>Nilai Melebihi Rencana Anggaran Perubahan.</a>",type:"warning",html:true});
			return;
		}
		
		if ((status_ang  == 'Perubahan') && (nil1 > ang_ubah) ){
			swal({title: "",text:"<a style='color:red;font-size:large;'>Nilai Melebihi Anggaran Perubahan.</a>",type:"warning",html:true});
			return;
		}
		if ((jns_tunai  == 'TUNAI') && (nil1 > sisa_tunai) ){
			swal({title: "",text:"<a style='color:red;font-size:large;'>Nilai Melebihi Kas Tunai di Bendahara.</a>",type:"warning",html:true});
			return;
		}
		if ((jns_tunai  == 'BANK') && (nil1 > sisa_bank) ){
			swal({title: "",text:"<a style='color:red;font-size:large;'>Nilai Melebihi Kas di Bank.</a>",type:"warning",html:true});
			return;
		}
        //tot = sisa - angka(nil);
        // console.log(tot);
				$('#dg1').edatagrid('appendRow',{no_bukti:no,
                                                 sp2d:sp2d,
                                                 kd_kegiatan:giat,
                                                 nm_kegiatan:nmgiat,
                                                 kd_rek5:rek,
                                                 kd_rek_blud:rek_blud,
                                                 nm_rek5:nm_rek,
                                                 nm_rek_blud:nm_rek_blud,
                                                 nilai:nil});   
												 
                $('#dg2').edatagrid('appendRow',{no_bukti:no,
                                                 sp2d:sp2d,
                                                 kd_kegiatan:giat,
                                                 nm_kegiatan:nmgiat,
                                                 kd_rek5:rek,
                                                 kd_rek_blud:rek_blud,
                                                 nm_rek5:nm_rek,
                                                 nm_rek_blud:nm_rek_blud,
                                                 nilai:nil});                                                 
               
			   total_ = total1+nil1;
			   $('#total1').attr('value',number_format(total_,2,'.',','));
               $('#total').attr('value',number_format(total_,2,'.',','));
			   /*
			   kosong2();
                total = angka(document.getElementById('total1').value) + angka(nil);
                $('#total1').attr('value',number_format(total,2,'.',','));
                $('#total').attr('value',number_format(total,2,'.',','));
                $('#dg1').datagrid('selectAll');

                var rows   = $('#dg1').datagrid('getSelections');
                var arr    = new Array();
                for (var i = 0 ; i < rows.length; i++) {
                arr.push(rows[i].sdana);
                }
                $('#dg1').datagrid('unselectAll');

*/
               
    }  
    
	function load_sisa_bank(){           
        $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd_blud/load_sisa_bank_lain",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#sisa_bank").attr("value",n['sisa']);
                   // $("#rekspm1").attr("value",n['rekspm1']);
                });
            }
         });
        });
    }
	
	function load_sisa_tunai(){
		var sp2d = $('#sp2d').combogrid('getValue');	
        $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd_blud/load_sisa_tunai_lain/"+sp2d,
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#sisa_tunai").attr("value",n['sisa']);
                   // $("#rekspm1").attr("value",n['rekspm1']);
                });
            }
         });
        });
    }
	
    function validate_rekening() {
           
           $('#dgpajak').datagrid('selectAll');
           var rows = $('#dgpajak').datagrid('getSelections');
           
           if(rows.length < 1){
              return;
           }

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
                   url         : '<?php echo base_url(); ?>index.php/C_Transout/rek_pot_trans', 
                   queryParams :({kdrek:frek}), 
                   columns:[[  
                       {field:'kd_rek5',title:'Kode Rekening',width:100},  
                       {field:'nm_rek5',title:'Nama Rekening',width:700}    
                   ]],  
                   onSelect:function(rowIndex,rowData){
                       $("#nmrekpajak").attr("value",rowData.nm_rek5.toUpperCase());
                   }  
                   });
               });
          $('#dgpajak').datagrid('unselectAll');         
    }   
    
    function tambah(){
        var nor = document.getElementById('nomor_urut').value;
        var tot = document.getElementById('total').value;
        var kd = document.getElementById('kdskpd').value;//$('#skpd').combogrid('getValue');

        $('#dg2').edatagrid('reload');
        $('#total1').attr('value',tot);
        $('#giat').combogrid('setValue','');
        $('#rek').combogrid('setValue','');
        //$('#rek_blud').combogrid('setValue','');
        var tgl = $('#tanggal').datebox('getValue');
        //var jns1 = document.getElementById('beban').value;
        if (kd != '' && tgl != '' && nor !=''){            
            $("#dialog-modal").dialog('open'); 
            load_detail2();           
        } else {
            alert('Harap Isi Nomor Bukti, Kode SKPD dan Tanggal Transaksi') ;         
        }
    }
    
    function kosong2(){        
        $('#giat').combogrid('setValue','');
        $('#rek').combogrid('setValue','');
        $('#rek_blud').combogrid('setValue','');
        $('#sdana').combogrid('setValue','');
        $('#nmgiat').attr('value','');
        $('#nmrek').attr('value','');
        $('#nm_rek_blud').attr('value','');
        $('#nmsdana').attr('value','');        
        $('#sisa').attr('value','0');
        $('#nilai').attr('value','0');
        $('#nilai').attr('value','0');             
        $('#nmgiat').attr('value','');        
    }
    
    function keluar(){
        $("#dialog-modal").dialog('close');
    //$('#dg1').edatagrid('reload');
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
        var nomor = document.getElementById('nomor_urut').value;
        var urut = document.getElementById('nomor_simpan').value;
		var kd = document.getElementById('kdskpd').value;
        var cnomor =urut;

        var goww  = '<?php echo base_url(); ?>index.php/C_Transout/hapus_transout';
        swal({
          title: "",
          text:"<a style='font-size:large;'>Hapus Transaksi dengan No Bukti :</a> <a style='color:red;font-size:large;'>"+cnomor+"</a> <a style='font-size:large;'>?</a>",
          type: "warning",
          html:true,
          showCancelButton: true,
          confirmButtonColor: "#2B80D0",
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak",
          closeOnConfirm: false,
          closeOnCancel: true
        },function(isConfirm){
          if (isConfirm) {
            $(document).ready(function(){
              $.ajax({url:goww,
                dataType:'json',
                type: "POST",
                data:({no:cnomor,skpd:kd }),
                success:function(data){
                  status = data;
                  if(status=='1'){
                    swal({title: "",text:"<a style='font-size:large;'>Transaksi dengan No Bukti :</a> <a style='color:red;font-size:large;'>"+cnomor+"</a> <a style='font-size:large;'>Terhapus.</a>",type:"success",html:true});
                    $("#dg").datagrid("reload") ;
                    section1();
                  }else{
                    bar_error("Gagal Melakukan Penyimpanan", "Failed");
                    return;
                  }
                }
              });
            });
          }
        });
    }
    
function cek_ver(){
          var cno   		= document.getElementById('nomor_urut').value; 
          var cno_simpan    = document.getElementById('nomor_simpan').value; 
          var cskpd 		= document.getElementById('kdskpd').value;
          console.log(cskpd);
          
          if (lcstatus=='tambah') {

              
              $(document).ready(function(){
               
                 $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: {no:cno,skpd:cskpd},
                    url: '<?php echo base_url(); ?>index.php/C_Transout/cek_verify',
                    success:function(data){                        
                       
                         if (data=='1'){               
                           simpan_transout();
                           
                        } else{
                            
                            alert('Data nomor ganda...!!!');
                            document.getElementById("nomor").focus();
                        }                                             
                    }
                }); 
              });

          }else{
			$(document).ready(function(){
               //alert(csql);
                 $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: {no:cno,skpd:cskpd},
                    url: '<?php echo base_url(); ?>index.php/C_Transout/cek_verify',
                    success:function(data){                        
                       
                         if (data=='1' || cno==cno_simpan){               
                           update_transout();
                           //simpan_potongan();
                           /*tombolnew();*/
                        } 
						if(data=='0' && cno!=cno_simpan){
                            /*tombolnew();*/ 
                            alert('Data nomor ganda...!!!');
                            document.getElementById("nomor").focus();
                        }                                             
                    }
                }); 
              });          }   
}


    function simpan_transout(){
        var cnourut      = document.getElementById('nomor_urut').value;
        var cno          = cnourut;
        var ctgl         = $('#tanggal').datebox('getValue'); 
        var cskpd        = document.getElementById('kdskpd').value;
        var cnmskpd      = document.getElementById('nmskpd').value;
        var cket         = document.getElementById('keterangan').value;
        var cjenis_bayar = document.getElementById('jns_tunai').value;
        var cjns_bbn	 = document.getElementById('jns_beban').value;
        var cjns_tagih   = document.getElementById('jns_tagih').value;
        var cno_tagih	 = $('#no_tagih').datebox('getValue');
		var jenis        = '11';
        var csql         = ''; 
        var csql13       = '';
        var ctotal       = angka(document.getElementById('total').value);    
        var status_ang   = document.getElementById('status_ang').value;
        if (cno  ==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Nomor Urut Tidak Boleh Kosong.</a>",type:"warning",html:true});
            return;
        } 
        if (ctgl==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Tanggal Bukti Tidak Boleh Kosong.</a>",type:"warning",html:true});
            return;
        }
        if ((cjns_tagih=='1') && (cno_tagih=='')){
            swal({title: "",text:"<a style='color:red;font-size:large;'>No Penagihan harus dipilih.</a>",type:"warning",html:true});
            return;
        }
        
        $(document).ready(function(){
            $.ajax({
                type: "POST",       
                dataType : 'json',         
                data: ({tabel:'trhtransout_blud',no:cno,tgl:ctgl,nokas:cno,tglkas:ctgl,skpd:cskpd,nmskpd:cnmskpd,ket:cket,total:ctotal,cpay:cjenis_bayar,jns_tgh:cjns_tagih,no_tgh:cno_tagih,beban:cjns_bbn,jenis:jenis}),
                url: '<?php echo base_url(); ?>/index.php/C_Transout/simpan_transout',
                success:function(data){
                    status = data.pesan; 
                    if (status=='1'){               
                        $('#dg1').datagrid('selectAll');
							var rows = $('#dg1').datagrid('getSelections'); 
							var crek_grid='';			
							for(var p=0;p<rows.length;p++){
								cnobukti   = cno;
								csp2d      = rows[p].sp2d;
								ckdgiat    = rows[p].kd_kegiatan;
								cnmgiat    = rows[p].nm_kegiatan;
								crek       = rows[p].kd_rek5;
								crek_blud  = rows[p].kd_rek_blud;
								cnmrek     = rows[p].nm_rek5;
								cnmrek_blud= rows[p].nm_rek_blud;
								cnmrek13   = rows[p].nm_rek13;
								cnilai     = angka(rows[p].nilai);
									  //if(crek_grid != crek){
												if (p>0) {
													csql   = csql+","+"('"+cnobukti+"','"+csp2d+"','"+ckdgiat+"','"+cnmgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek+"','"+cnmrek_blud+"','"+cnilai+"','"+status_ang+"','"+cskpd+"')";
												} else {
													csql   = "values('"+cnobukti+"','"+csp2d+"','"+ckdgiat+"','"+cnmgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek+"','"+cnmrek_blud+"','"+cnilai+"','"+status_ang+"','"+cskpd+"')";
												}  
											//}

											crek_grid=crek;						  
							} 

							$(document).ready(function(){
							   //alert(csql);
								 $.ajax({
									type: "POST",   
									dataType : 'json',                 
									data: ({tabel:'trdtransout_blud',no:cno,sql:csql}),
									url: '<?php echo base_url(); ?>/index.php/C_Transout/simpan_transout',
									success:function(data){                        
										status = data.pesan;   
										 if (status=='1'){
											bar("Nomor Transaksi dengan No Bukti : " +cno+ " Tersimpan.","Data telah tersimpan.");
											$("#nomor_simpan").attr("value",cno);
											lcstatus    = 'edit';   
											$("#dg").datagrid("reload") ;
											section1();
										} else{ 
											bar_error("Gagal Melakukan Penyimpanan", "Failed");
										}                                             
									}
								}); 
							  });
						
						      
                    } else{ 
                        bar_error("Gagal Melakukan Penyimpanan", "Failed");
                    }
            
                }
            });
        });
    } 
    
    function update_transout(){
        var cnourut      = document.getElementById('nomor_urut').value;
        var cnosimpan    = document.getElementById('nomor_simpan').value;
        var cno          = cnourut;
        var ctgl         = $('#tanggal').datebox('getValue'); 
        var cskpd        = document.getElementById('kdskpd').value;
        var cnmskpd      = document.getElementById('nmskpd').value;
        var cket         = document.getElementById('keterangan').value;
        var cjenis_bayar = document.getElementById('jns_tunai').value;
        var cjns_bbn	 = document.getElementById('jns_beban').value;
		var cjns_tagih   = document.getElementById('jns_tagih').value;
        var cno_tagih	 = $('#no_tagih').datebox('getValue'); 
        var jenis        = '11';
		var csql         = ''; 
        var csql13       = '';
        var ctotal       = angka(document.getElementById('total').value);    
        var status_ang   = document.getElementById('status_ang').value;
        if (cno  ==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Nomor Urut Tidak Boleh Kosong.</a>",type:"warning",html:true});
            return;
        } 
		if (status_ang  ==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Pilih Tanggal terlebih dahulu.</a>",type:"warning",html:true});
            return;
        } 
        if (ctgl==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Tanggal Bukti Tidak Boleh Kosong.</a>",type:"warning",html:true});
            return;
        }
       
        if ((cjns_tagih=='1') && (cno_tagih=='')){
            swal({title: "",text:"<a style='color:red;font-size:large;'>No Penagihan harus dipilih.</a>",type:"warning",html:true});
            return;
        }
        
        $(document).ready(function(){
            $.ajax({
                type: "POST",       
                dataType : 'json',         
                data: ({tabel:'trhtransout_blud',no:cno,nosimpan:cnosimpan,tgl:ctgl,nokas:cno,tglkas:ctgl,skpd:cskpd,nmskpd:cnmskpd,ket:cket,total:ctotal,cpay:cjenis_bayar,jns_tgh:cjns_tagih,no_tgh:cno_tagih,beban:cjns_bbn,jenis:jenis}),
                url: '<?php echo base_url(); ?>/index.php/C_Transout/update_transout',
                success:function(data){
                    status = data.pesan; 
                    if (status=='1'){               
                        $('#dg1').datagrid('selectAll');
							var rows = $('#dg1').datagrid('getSelections'); 
							var crek_grid='';			
							for(var p=0;p<rows.length;p++){
								cnobukti   = cno;
								csp2d      = rows[p].sp2d;
								ckdgiat    = rows[p].kd_kegiatan;
								cnmgiat    = rows[p].nm_kegiatan;
								crek       = rows[p].kd_rek5;
								crek_blud  = rows[p].kd_rek_blud;
								cnmrek     = rows[p].nm_rek5;
								cnmrek_blud= rows[p].nm_rek_blud;
								cnmrek13   = rows[p].nm_rek13;
								cnilai     = angka(rows[p].nilai);
									  //if(crek_grid != crek){
												if (p>0) {
													csql   = csql+","+"('"+cnobukti+"','"+csp2d+"','"+ckdgiat+"','"+cnmgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek+"','"+cnmrek_blud+"','"+cnilai+"','"+status_ang+"','"+cskpd+"')";
												} else {
													csql   = "values('"+cnobukti+"','"+csp2d+"','"+ckdgiat+"','"+cnmgiat+"','"+crek+"','"+crek_blud+"','"+cnmrek+"','"+cnmrek_blud+"','"+cnilai+"','"+status_ang+"','"+cskpd+"')";
												}  
											//}

											crek_grid=crek;						  
							} 

							$(document).ready(function(){
							   //alert(csql);
								 $.ajax({
									type: "POST",   
									dataType : 'json',                 
									data: ({tabel:'trdtransout_blud',no:cno,sql:csql,nosimpan:cnosimpan}),
									url: '<?php echo base_url(); ?>/index.php/C_Transout/update_transout',
									success:function(data){                        
										status = data.pesan;   
										 if (status=='1'){
											bar("Nomor Transaksi dengan No Bukti : " +cno+ " Tersimpan.","Your file has been Saved.");
											$("#nomor_simpan").attr("value",cno);
											lcstatus    = 'edit';
											$("#dg").datagrid("reload") ;
											section1();
										} else{ 
											bar_error("Gagal Melakukan Penyimpanan", "Failed");
										}                                             
									}
								}); 
							  });
						
						      
                    } else{ 
                        bar_error("Gagal Melakukan Penyimpanan", "Failed");
                    }
            
                }
            });
        });
    } 
    
    
    function sisa_bayar(){
        var sisa    = angka(document.getElementById('sisa').value);             
        var nil     = angka(document.getElementById('nilai').value);        
        var sisasp2d     = angka(document.getElementById('sisasp2d').value);
        var tot  = 0;
        /*alert(sisa+'/'+nil);        */
        tot = sisa - nil;
        if (nil > sisasp2d){    
                alert('Nilai Melebihi Sisa Sp2d');
                    return;
        } else {
            if (tot < 0){
                    alert('Nilai Melebihi Sisa');
                    return;                
            }
        }           
    }  

    function unit(){
    $('#cunit').combogrid({
       url:'<?php echo base_url(); ?>index.php/C_Transout/unit',
       panelWidth:260,
       idField:'kd_unit',  
       textField:'nm_unit',  
       mode:'remote',
       fitColumns:'true',
       columns:[[
        {field:'nm_unit',title:'Unit',width:250}
       ]],
       onSelect:function(rowIndex,rowData){
        $('#nmunit').attr('value',(rowData.nm_unit).toUpperCase());

       }
    });
  }     
                         
                  
    function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        $("#notagih").combogrid("setValue",'');
        $("#tgltagih").attr("value",'');
        //$("#skpd").combogrid("setValue",'');
        $("#keterangan").attr("value",'');
        $("#beban").attr("value",'');
        load_detail_baru();
        
    };              
                             
       
                        
    
    
    
	
	function l_dw_total(vss){
	$(document).ready(function(){      
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>/index.php/C_Transout/load_d_transout_total_tu',
					data: ({nsp:vss}),
					dataType:"json",
					success:function(data){                                   
						$.each(data,function(i,n){  
						tjml = n['ntl'];    
						$('#total').attr('value',tjml);	
						});                
					}
					});
				}); 
	}
	
	
	function edit_n_tu(n_tu){
	$("#nilai_edt").attr("value",n_tu);
    $("#nilai_edth").attr("value",n_tu);
    $("#dialog-modal_edit").dialog('open');
	}

  function bar(j,r){
    document.getElementById("ok").innerHTML=j;
    document.getElementById("x").innerHTML="";
    document.getElementById("eng").innerHTML=r;
    $('#jr').dialog('open');
  }

  function bar_error(error,jr){
    document.getElementById("ok").innerHTML="";
    document.getElementById("x").innerHTML=error;
    document.getElementById("eng").innerHTML=jr;
    $('#jr').dialog('open');
  }
	
	
	
	function keluar_ok(){
        $("#dialog-modal_edit").dialog('close');
    } 
	
	function open_dialogmodal(){
         var status_ang = document.getElementById('status_ang').value;
         var jns_bbn = document.getElementById('jns_beban').value;
		if(status_ang ==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Pilih Tanggal Terlebih Dahulu.</a>",type:"warning",html:true});
		}else if(jns_bbn==''){
            swal({title: "",text:"<a style='color:red;font-size:large;'>Jenis Beban Tidak Boleh Kosong.</a>",type:"warning",html:true});
		}else{
		tambah();
		}
	}
	
	function validate_pilihan(){
        var beban   = document.getElementById('jns_beban').value;
		if ((beban=='1')||(beban=='3')){
			$("#pilihan").show();
			$("#no_tagih").combogrid('clear');
		} else {
			$("#pilihan").hide();	
			$("#penagihan").hide();	
			$("#no_tagih").combogrid('clear');
		}
		
	}
	function validate_jenis(){
        var pilihan   = document.getElementById('jns_tagih').value;
        var skpd    = document.getElementById('kdskpd').value;
		if (pilihan=='1'){
			load_detail_baru();
			$("#penagihan").show();
			$('#tombol_giat').linkbutton('disable');
			$('#no_tagih').combogrid({url:'<?php echo base_url(); ?>index.php/C_Transout/load_no_penagihan',
                                   queryParams:({skpd:skpd})
                                });
		} else {
			load_detail_baru();
			$("#penagihan").hide();
			$('#tombol_giat').linkbutton('enable');
			$("#no_tagih").combogrid('clear');
		}
		
	}
	
	 function detail_penagihan(){     
        var cnourut      = document.getElementById('nomor_urut').value;
        var no_tagih = $('#no_tagih').combogrid('getValue');
        var kdskpd = document.getElementById("kdskpd").value;  
        var status_ang = document.getElementById("status_ang").value;  
			if(cnourut==''){
				alert("Isi Nomor Transaksi terlebih dahulu!");
				return;
			}
           $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/C_Transout/load_detail_penagihan',
                data:({tagih:no_tagih,skpd:kdskpd}),
                dataType:"json",
                success:function(data){
                    $.each(data,function(i,n){  					
                    no      = cnourut;                                                                   
                    sp2d    = n['no_sp2d'];
                    giat    = n['kd_kegiatan'];
                    nmgiat  = n['nm_kegiatan'];
                    rek5    = n['kd_rek5'];
                    rek_blud  = n['kd_rek_blud'];
                    nmrek5  = n['nm_rek5'];
                    nmrek_blud  = n['nm_rek_blud'];
                    nil     = n['nilai'];
                    status = status_ang;
                    $('#dg1').edatagrid('appendRow',{no_bukti:no,sp2d:sp2d,kd_kegiatan:giat,nm_kegiatan:nmgiat,kd_rek5:rek5,kd_rek_blud:rek_blud,nm_rek5:nmrek5,nm_rek_blud:nmrek_blud,nilai:nil,status:status});                                                                                                                                                                                                                                                                                                                                                                                             
                    });                                                                           
                }
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
						$("#total").attr('value',number_format(n['rektotal'],2,'.',','));
						//$("#rektotal1_ls").attr('value',number_format(n['rektotal'],2,'.',','));
					});
				}
			 });
			});
		   
           set_grid();                                                  
    }
  
  
	
	
	
	
    </script>

</head>
<body>



<div id="content">    
<div id="accordion">
<h3><a href="#" id="section1" >List Pembayaran Transaksi Menggunakan SILPA</a></h3>
    <div>
    <div class="well" align="left">         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
    </div> 
    <table id="dg" title="List Pembayaran Transaksi Menggunakan SILPA" style="width:870px;height:450px;" ></table>                          
    </div>   

<h3><a href="#" id="section2">PEMBAYARAN TRANSAKSI MENGGUNAKAN SILPA</a></h3>
   <div  style="height: 350px;">
   <p id="p1" style="font-size: x-large;color: red;"></p>
   <p>       
   <div id="demo"></div>
        <table align="center" style="width:100%;">
            <tr>
                <td width="10%">No. Bukti</td>
                <td width="10%">
                <input type="text" id="nomor_urut" style="width: 100px;" />
                <input type="text" id="nomor_simpan" readonly="true" style="width: 100px;" readonly="true" hidden />
                </td>
                <td width="1%"></td>
                <td width="5%">Tanggal Bukti</td>
                <td width="10%"><input type="text" id="tanggal" style="width: 140px;" /></td>     
            </tr>
                                   
            <tr>
                <td>B L U D</td>
                <td><input id="kdskpd" style="width: 140px;"/></td>
                <td></td>
                <td>Nama BLUD </td> 
                <td><input type="text" id="nmskpd" style="border:0;width: 300px;" readonly="true"/></td>                                
            </tr>
            
          <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">  
             <td style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;"></td>
             <td colspan="4" style="color: red;width: 650px; text-align:left" colspan="4">*Untuk keterangan Tidak Boleh Menggunakan Tanda Petik satu (') dan Tanda Petik dua (")</td>
          </tr>
            <tr>
                <td>Keterangan</td>
                <td colspan="4"><textarea id="keterangan" style="width: 650px; height: 40px;"></textarea></td>
           </tr>            
            <tr>
				<td>Jenis Beban</td>
					<td><select name="jns_beban" id="jns_beban" style="width:260px;" onchange="javascript:validate_pilihan();">
					 <option value="11">Transaksi menggunakan SILPA </option>
					 <!--<option value="">--Pilih Jenis Beban--</option>
					 <option value="1">UP/GU</option>
					 <option value="3">TU</option>
					 <option value="4">LS GAJI</option>
					 <option value="5">LS Barang Jasa (Tanpa Penagihan)</option>     
					 <option value="6">LS Barang Jasa (Dengan Penagihan)</option></td>-->
					<td></td>
                <td>Pembayaran</td>
                 <td >
                     <select name="jns_tunai" id="jns_tunai">
                         <option value="TUNAI">TUNAI</option>
                         <option value="BANK">BANK</option>
                     </select>
                 </td>
			<tr id="pilihan">
                <td>Jenis Transaksi</td>
                <td colspan="3"><select name="jns_tagih" id="jns_tagih" style="height: 27px; width:300px;" onchange="javascript:validate_jenis();">
				 <option value="0">Tanpa Penagihan</option>     
				 <!--<option value="1">Dengan Penagihan</option> </td>-->
           </tr>
			<tr id="penagihan">
                <td>No.Penagihan</td>
                <td colspan="3"><input type="text" id="no_tagih" style="width: 300px;" /></td>
           </tr>	 
			<tr>
                <td>Status Ang.</td>
                <td colspan="3"><input type="text" id="status_ang" style="border:0;width: 300px;" readonly="true"/></td>
           </tr>
                <td colspan="6" align="right">
                    <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();">Tambah</a>
                    <a id="simpan" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:cek_ver();">Simpan</a>
                    <a id="hapus" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                    <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a>                                   
                </td>
            </tr>
            
        </table>          
        <table id="dg1" title="Rekening" style="width:870px;height:450px;" >  
        </table>  
        <div id="toolbar" style="padding:5px;height:auto">
			<div id="tbl_giat" align="left">
			<a id="tombol_giat" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:open_dialogmodal();">Tambah Kegiatan</a>
			</div>
			<div id="tbl_s2pd_tu" align="right">
				<b style="color:red">Pilih No Ambil Kas : <input type="text" id="sp2d_tu" style="text-align: width: 200px;font-size: large;"/></b>                  
			</div>
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
            <td><input type="text" id="nmgiat" readonly="true" style="border:1;width: 400px;"/></td>
        </tr>        
       <tr>
            <td>No Ambil Kas</td>
            <td>:</td>
            <td width="300"><input id="sp2d" name="sp2d" style="width: 200px;" /></td>
       </tr>        
         <tr>
            <td >Kode Rekening</td>
            <td>:</td>
            <td><input id="rek" name="rek" style="width: 200px;" /></td>
            <td >Nama Rekening</td>
            <td>:</td>
            <td><input type="text" id="nmrek" readonly="true" style="border:1;width: 400px;"/><input type="text" id="rek13" readonly="true" hidden="true" style="border:1;width: 100px;"/><input type="text" id="nm_rek13" readonly="true" hidden="true" style="border:1;width: 100px;"/></td>
        </tr>
        <tr>
            <td >Kode Rekening Blud</td>
            <td>:</td>
            <td width="20%"><input id="rek_blud" name="rek_blud" style="width: 200px;" disabled />
            <td >Nama Rekening Blud</td>
            <td>:</td>
            <td width="20%"><input id="nm_rek_blud" name="nm_rek_blud" readonly="true" style="width: 400px;" readonly="true" />
        </tr>
		
		<tr>
            <td >Anggaran Murni</td>
            <td>:</td>
            <td width="20%"><input id="ang_murni" name="ang_murni" readonly="true" style="text-align: right; border:0;width: 150px;" />
            <td >Anggaran Perubahan</td>
            <td>:</td>
            <td width="20%"><input id="ang_ubah" name="ang_ubah" readonly="true" style="text-align: right;border:0;width: 150px;" />
        </tr>
        <tr>
            <td >Realisasi Murni</td>
            <td>:</td>
            <td width="20%"><input id="real_murni" name="real_murni" readonly="true" style="text-align: right; border:0;width: 150px;" />
            <td >Realisasi Perubahan</td>
            <td>:</td>
            <td width="20%"><input id="real_ubah" name="real_ubah" readonly="true" style="text-align: right;border:0;width: 150px;" />
        </tr>
        <tr>
            <td >Sisa Murni</td>
            <td>:</td>
            <td width="20%"><input id="sisa_murni" name="sisa_murni" readonly="true" style="text-align: right; border:0;width: 150px;" />
            <td >Sisa Perubahan</td>
            <td>:</td>
            <td width="20%"><input id="sisa_ubah" name="sisa_ubah" readonly="true" style="text-align: right;border:0;width: 150px;" />
        </tr>
		<tr>
            <td >Sisa Tunai</td>
            <td>:</td>
            <td width="20%"><input id="sisa_tunai" name="sisa_tunai" readonly="true" style="text-align: right; border:0;width: 150px;" />
            <td >Sisa Bank</td>
            <td>:</td>
            <td width="20%"><input id="sisa_bank" name="sisa_tunai" readonly="true" style="text-align: right;border:0;width: 150px;" />
        </tr>
        <tr>
            <td >Nilai</td>
            <td>:</td>
            <td><input type="text" id="nilai" style="text-align: right;width: 150px;" onkeypress="return(currencyFormat(this,',','.',event))" /></td>            
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
        <table id="dg2" title="Input Rekening" style="width:950px;height:270px;"  >  
        </table>  
     
    </fieldset>  
</div>


<div id="dialog-modal_edit" title="Edit NILAI">
    <fieldset>
    <table>
        <tr> 
           <td width="110px">Nilai:</td>
           <td><input type="text" id="nilai_edt" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/>
               <input type="hidden" id="nilai_edth"/> 
           </td>
        </tr>
    </table>  
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:edit_detail_ok();">Simpan</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar_ok();">Keluar</a>  
</div>
<?php $this->load->view('inc/open_dialog.php'); ?>

</body>

</html>