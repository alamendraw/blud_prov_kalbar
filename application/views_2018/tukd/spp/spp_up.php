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
   
    var no_spp   = '';
    var kode     = '';
    var lcstatus = '';

        $(document).ready(function() {
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            $( "#dialog-modal" ).dialog({
            height: 300,
            width: 700,
            modal: true,
            autoOpen:false
        });
        get_skpd();
		get_tahun();
        });
           
    $(function(){
   	     $('#dd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
				
				var tahunsekarang = date.getFullYear();
				get_spp(tahunsekarang);
				
				
				
            }
        });
   	
            	$('#bank1').combogrid({  
                panelWidth:700,  
                url: '<?php echo base_url(); ?>/index.php/C_Spp/config_bank2',  
                    idField:'kd_bank',  
                    textField:'kd_bank',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                           {field:'kd_bank',title:'Kd Bank',width:120},  
                           {field:'nama_bank',title:'Nama',width:500}
                       ]],  
                    onSelect:function(rowIndex,rowData){
                    //$("#kode").attr("value",rowData.kode);
                    $("#nama_bank").attr("value",rowData.nama_bank);
                    }   
                });
				
            $('#cspp').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/C_Spp/load_spp_up',  
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
		url: '<?php echo base_url(); ?>/index.php/C_Spp/load_spp_up',
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
    		title:'NO SPP',
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
          nomer   = rowData.no_spp;         
          kode    = rowData.kd_skpd;
          tgl     = rowData.tgl_spp;
          jns     = rowData.jns_spp;
          kep     = rowData.keperluan;
          status  = rowData.status;          
          nilai  = rowData.nilai;          
          get(nomer,kode,tgl,jns,kep,status,nilai);
          lcstatus = 'edit';                                           
        },
        onDblClickRow:function(rowIndex,rowData){
            section1();
        }
        });
            
         
        
         $('#dg1').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/select_data1',
                 autoRowHeight:"true",
                 idField:'id',
                 toolbar:"#toolbar",              
                 rownumbers:"true", 
                 fitColumns:false,
                 singleSelect:"true",
			});
        });
           


             
   
    function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
					$("#dn").attr("value",data.kd_skpd);
					$("#nmskpd").attr("value",data.nm_skpd);
					kode = data.kd_skpd;
					load_sisa_kas();
        			}                                     
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
    function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/C_Spp/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        }    
    function detail1(){
	   	    var no_spp = document.getElementById('no_spp').value;  
			$('#dg1').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/select_data1',
                queryParams:({spp:no_spp}),
                 idField       : 'idx',
                 toolbar       : "#toolbar",              
                 rownumbers    : "true", 
                 fitColumns    : false,
                 autoRowHeight : "true",
                 singleSelect  : false,
                 onLoadSuccess : function(data){                      
                      load_sum_spp();                        
                    },
                onSelect:function(rowIndex,rowData){
                kd = rowIndex;                                               
                },   
                 onAfterEdit:function(rowIndex, rowData, changes){
								kd_rek5=rowData.kdrek5;
                                nm_rek5=rowData.nmrek5;
                                nilai=rowData.nilai1;
                                kd=rowIndex;
								dsimpan(kd_rek5,nm_rek5,nilai,kd);       	                                  
							 },                			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},
					{field:'kdrek5',
					 title:'Rekening',
					 width:100,
					 align:'left'
					},
					{field:'nmrek5',
					 title:'Nama Rekening',
					 width:530
					},
                    {field:'nilai1',
					 title:'Nilai',
					 width:140,
                     align:'right',
					 editor:{type:"numberbox"					     
							} 
                     }
				]]	
			});
        
        }
        
        
        function detail(){
        $(function(){
	   	    var no_spp = '';            
			$('#dg1').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/C_Spp/select_data1',
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
					{field:'kdrek5',
					 title:'Rekening',
					 width:100,
					 align:'left'
					},
					{field:'nmrek5',
					 title:'Nama Rekening',
					 width:530
					},
                    {field:'nilai1',
					 title:'Nilai',
					 width:140,
                     align:'right',
					 editor:{type:"numberbox"					     
							} 
                     }
				]]	
			});
		});
        }
        
        function get(nomer,kode,tgl,jns,kep,status,nilai){
        $("#no_spp").attr("value",nomer);
        $("#no_spp_hide").attr("value",nomer);
        $("#dd").datebox("setValue",tgl);        
        $("#ketentuan").attr("Value",kep);
        $("#nilaiup").attr("Value",nilai);
         tombol(status);           
        }
		
        function kosong(){
            lcstatus = 'tambah';  
            $('#save').linkbutton('enable');
            $('#del').linkbutton('enable');
            $('#sav').linkbutton('enable');
            $('#dele').linkbutton('enable');  
            $("#no_spp").attr("value",'');
            $("#no_spp_hide").attr("value",'');
            $("#rekup").combogrid("setValue",'');
            $("#nmrekup").attr("Value",'');
            $("#nilaiup").attr("Value",0);
            $("#dd").datebox("setValue",'');        
            $("#ketentuan").attr("Value",'');
            document.getElementById("p1").innerHTML="";
            document.getElementById("no_spp").focus();
            detail();
                    
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
     function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#spp').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/C_Spp/load_spp',
         queryParams:({cari:kriteria})
        });        
     });
    }
     
     function setgrid(){
       $('#dg1').edatagrid({			  			 				 
                 columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},
					{field:'kdrek5',
					 title:'Rekening',
					 width:100,
					 align:'left'
					},
					{field:'nmrek5',
					 title:'Nama Rekening',
					 width:530
					},
                    {field:'nilai1',
					 title:'Nilai',
					 width:140,
                     align:'right',
					 editor:{type:"numberbox"					     
							} 
                     }
                      
				]]
                });
     }  
      
     
     function section1(){
         $(document).ready(function(){    
             $('#section1').click();
             // setgrid()                                              
         });
     }
     
     function section4(){
         $(document).ready(function(){    
             $('#section4').click();                                               
         });
     }
     
     
     function hsimpan(){        
        var a       = (document.getElementById('no_spp').value).split(" ").join("");
        var a_hide  = document.getElementById('no_spp_hide').value;
        var b       = $('#dd').datebox('getValue');      
        var c       = document.getElementById('jns_beban').value;        
        var d       = document.getElementById('dn').value;        
        var e       = document.getElementById('ketentuan').value; 
		var f    	= document.getElementById('rekup').value;		
        var k       = angka(document.getElementById('nilaiup').value);
        var l       = angka(document.getElementById('sisa_kas').value);
		var tahun_input = b.substring(0, 4);
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun Tidak Sama Dengan Tahun Anggaran", "error");
			exit();
		}
		if ( a== ''){
                 swal("Error", "Nomor Tidak Boleh Kosong", "error");
                 exit();
            }
		if ( k > l){
                 swal("Error", "Total Nilai Melebihi Sisa Kas", "error");
                 exit();
            }
		
        if (lcstatus=='tambah') { 
		   $(document).ready(function(){
                $.ajax({
                    type     : "POST",
                    url      : '<?php echo base_url(); ?>/index.php/C_Spp/simpan_spp_up',
                    data     : ({tabel:'trhsp2d_blud',no_spp:a,tgl:b,bbn:c,ket:e,nilai:k,skpd:d,rek:f}),
                    dataType : "json",
                    success  : function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        } else if(status=='1'){
                                  swal("Error", "Nomor SPP Telah Dipakai", "error");
                                  exit();
                               } else {
                                  swal("Berhasil", "Data Berhasil Tersimpan", "success");
                                  lcstatus = 'edit';
								   section4();
                               }
                    }
                });
            });   
           
        } else {
            $(document).ready(function(){
                $.ajax({
                    type     : "POST",
                    url      : '<?php echo base_url(); ?>/index.php/C_Spp/update_spp_up',
                    data     : ({tabel:'trhsp2d_blud',no_spp:a,nohide:a_hide,tgl:b,bbn:c,ket:e,nilai:k,skpd:d,rek:f}),
                    dataType : "json",
                    success  : function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        } else if(status=='1'){
                                  swal("Error", "Nomor Sudah Dipakai", "error");
                                  exit();
                               } else {
                                  swal("Berhasil", "Data Tersimpan", "success");
                                  lcstatus = 'edit';
                                  exit();
                               }
                    }
                });
            });   
        }
    }
    
    
    function dsimpan_up() {
        
        var a         =(document.getElementById('no_spp').value).split(" ").join("");
        var rek_up    = $("#rekup").combogrid("getValue") ;
        var nm_rek_up = document.getElementById('nmrekup').value ;
        var nilai_up  = angka(document.getElementById('nilaiup').value) ;
       // alert("'"+a+"','"+rek_up+"','"+nilai_up+"','"+kode+"'");
		
		
        $(function(){      
         $.ajax({
            type     : 'POST',
            data     : ({cno_spp:a,cskpd:kode,crek:rek_up,nrek:nm_rek_up,nilai:nilai_up}),
            dataType : "json",
            url      : "<?php echo base_url(); ?>index.php/C_Spp/dsimpan_up",
            success  : function(data){
            }            
         });
         });
        $("#no_spp_hide").attr("Value",a);
    } 
    
    function dsimpan_up_edit() {
        
        var a         = (document.getElementById('no_spp').value).split(" ").join("");
        var a_hide 	  = document.getElementById('no_spp_hide').value;
        var rek_up    = $("#rekup").combogrid("getValue") ;
        var nm_rek_up = document.getElementById('nmrekup').value ;
        var nilai_up  = angka(document.getElementById('nilaiup').value) ;
        alert("'"+a+"','"+rek_up+"','"+nilai_up+"','"+kode+"'");
		
		
        $(function(){      
         $.ajax({
            type     : 'POST',
            data     : ({cno_spp:a,cskpd:kode,crek:rek_up,nrek:nm_rek_up,nilai:nilai_up,no_hide:a_hide}),
            dataType : "json",
            url      : "<?php echo base_url(); ?>index.php/C_Spp/dsimpan_up_edit",
            success  : function(data){
            }            
         });
         });
        $("#no_spp_hide").attr("Value",a);
    }  
    
    
    function dsimpan(kd_rek5,nm_rek5,nilai,kd){
        var a = document.getElementById('no_spp').value;
        //alert(a);    
        $(function(){      
         $.ajax({
            type: 'POST',
            data: ({cno_spp:a,cskpd:kode,crek:kd_rek5,nrek:nm_rek5,nilai:nilai,kd:kd}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/C_Spp/dsimpan"            
         });
        });
    } 
    
    
    function detsimpan(){
        var a = document.getElementById('no_spp').value;        
        $('#dg1').datagrid('selectAll');
        var rows = $('#dg1').datagrid('getSelections');
         //alert(rows); 
        for(var i=0;i<rows.length;i++){            
            ckdgiat  = rows[i].kdkegiatan;
            cnmgiat  = rows[i].nmkegiatan;
            ckdrek  = rows[i].kdrek5;
            cnmrek  = rows[i].nmrek5;
            cnilai   = rows[i].nilai1;
            cnilai_s   = rows[i].sis;           
            no=i+1;      
            $(document).ready(function(){      
            $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/C_Spp/dsimpan" ,
            data: ({cno_spp:a,cskpd:kode,cgiat:ckdgiat,crek:ckdrek,ngiat:cnmgiat,nrek:cnmrek,nilai:cnilai,sis:cnilai_s,kd:no}),
            dataType:"json"            
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
					if (status='1'){
                            swal("Berhasil", "Data Berhasil Dihapus", "success");         
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
			//alert(idx);
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
		var spp = document.getElementById('no_spp').value;
        var nospp =spp.split("/").join("123456789");       
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({spp:nospp}),
            url:"<?php echo base_url(); ?>index.php/C_Spp/load_sum_spp",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal").attr("value",n['rektotal']);
                    $("#rektotal1").attr("value",n['rektotal1']);
                });
            }
         });
        });
    }
    function tombol(st){  
    if (st=='1'){
    $('#save').linkbutton('disable');
    $('#del').linkbutton('disable');
    $('#sav').linkbutton('disable');
    $('#dele').linkbutton('disable');    
    document.getElementById("p1").innerHTML="Sudah di Buat SPM!!";
     } else {
     $('#save').linkbutton('enable');
     $('#del').linkbutton('enable');
     $('#sav').linkbutton('enable');
     $('#dele').linkbutton('enable');
    document.getElementById("p1").innerHTML="";
     }
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
			 swal("Error", "Bendahara Pengeluaran tidak boleh kosong", "error");
			exit();
		}
		if ( ttd2 =='' ){
			swal("Error", "PPTK tidak boleh kosong", "error");
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
			swal("Error", "Bendahara Pengeluaran tidak boleh kosong", "error");
			exit();
		}
		if ( ttd2 =='' ){
			swal("Error", "PPTK tidak boleh kosong", "error");
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
			swal("Error", "Bendahara Pengeluaran tidak boleh kosong", "error");
			exit();
		}
		if ( ttd2 =='' ){
			swal("Error", "PPTK tidak boleh kosong", "error");
			exit();
		}
		
        var ttd_1 =ttd1.split(" ").join("123456789");
        var ttd_2 =ttd2.split(" ").join("123456789");
		var url    = "<?php echo site_url(); ?>/C_Spp/cetakspp3";    
        window.open(url+'/'+cetak+'/'+no+'/'+kode+'/'+jns+'/'+ttd_1+'/'+ttd_2+'/'+spasi+'/'+tanpa, '_blank');
        window.focus();
        }
       
	   
	   function get_spp(){
		  

			
			var skpd =document.getElementById("dn").value;
				jns = "UP";
			
			
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
<h3><a href="#" id="section4" onclick="javascript:$('#spp').edatagrid('reload')">List SPP</a></h3>
    <div>
    <p align="right">         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section1();kosong();">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="spp" title="List SPP" style="width:870px;height:450px;" >  
        </table>
    </p> 
    </div>

<h3><a href="#" id="section1">Input SPP</a></h3>
   <div  style="height: 350px;">
   <p id="p1" style="font-size: x-large;color: red;"></p>
   <p>

<fieldset style="width:850px;height:650px;border-color:white;border-style:hidden;border-spacing:0;padding:0;">            

<table border='1' style="font-size:11px" >

 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td width="8%" style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >&nbsp;</td>
   <td style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;</td>
   <td style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;</td>
   <td style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;</td>   
 </tr>


 
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td colspan="2" width="8%" style= "color: red;border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >No SPP Terisi Otomatis ! Silahkan Tekan Tombol "Ambil No SPP" !</td>
    </tr>
 
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td width="8%" style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >No SPP</td>
   <td style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" name="no_spp" id="no_spp" disabled onkeyup="this.value=this.value.toUpperCase()" style="width:200px;" /><input type="hidden" name="no_spp_hide" id="no_spp_hide" onclick="javascript:select();" style="width:200px;" />
   <a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:get_spp();">Ambil No SPP</a>  
   </td>
   <td style="border-right-style:hidden;border-top-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">Tanggal</td>
   <td style="border-bottom-style:hidden;border-top-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;<input id="dd" name="dd" type="text" /></td>   
 </tr>
 
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <td width='8%' style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">SKPD</td>
   <td width="53%" style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >     
   <input id="dn" name="dn" readonly="true" style="width:200px; border: 0; " /></td> 
   <td colspan="2" style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <input id="nmskpd" name="nmskpd" readonly="true" style="width:300px; border: 0; " /></td>
   </td>
 </tr>
 
 <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
   <td width='8%'  style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">Beban</td>
   <td width='53%' style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;"><select name="jns_beban" id="jns_beban">
     <option value="1">UP</option>
   </select></td>
   <td width='8%'  style="border-right-style:hidden;border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">Keperluan</td>
   <td width='31%' style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;"><textarea name="ketentuan" id="ketentuan" cols="30" rows="2" ></textarea></td>
 </tr>
 
 

 <tr style="border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">   
   <td width="8%" style="border-right-style:hidden;border-bottom-color:black;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;" >&nbsp;</td>
   <td style="border-right-style:hidden;border-bottom-color:black;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;</td>
   <td style="border-right-style:hidden;border-bottom-color:black;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;</td>
   <td style="border-bottom-color:black;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">&nbsp;</td>   
 </tr>
</table>
<table border='1'>
	<tr style="border-bottom-style:hidden;border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">
		 <td colspan='3' style="font-size:20px;font:bold;color:#004080;" >DETAIL SPP UP</td>
	</tr>
	<tr>
		 <td colspan='3' style="border-bottom-style:hidden;">&nbsp;</td>
	</tr>
	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-bottom-style:hidden;">
		 <td width='10%' style="border-right-style:hidden;border-bottom-style:hidden;">Rekening</td>
		 <td width='15%' style="border-right-style:hidden;border-bottom-style:hidden;"><select name="rekup" id="rekup">
     <option value="1110302">Uang Persediaan</option>
   </select></td>
	</tr>
	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">
		 <td width='10'  style="border-bottom-style:hidden;border-right-style:hidden;">Sisa Kas</td>
		 <td width='15%' style="border-bottom-style:hidden;border-bottom-color:black;border-right-style:hidden;"><input type="text" name="nilaiup" id="sisa_kas"  value="" style="width:150px;text-align:right;"  onkeypress="return(currencyFormat(this,',','.',event))"/> </td>
		 <td width='75'  style="border-bottom-style:hidden;">&nbsp;</td>
	</tr>
	</tr>
	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">
		 <td width='10'  style="border-bottom-style:hidden;border-right-style:hidden;">Nilai</td>
		 <td width='15%' style="border-bottom-style:hidden;border-bottom-color:black;border-right-style:hidden;"><input type="text" name="nilaiup" id="nilaiup"  value="" style="width:150px;text-align:right;"  onkeypress="return(currencyFormat(this,',','.',event))"/> </td>
		 <td width='75'  style="border-bottom-style:hidden;">&nbsp;</td>
	</tr>
	<tr>
		 <td colspan='3' style="border-bottom-color:black;">&nbsp;</td>
	</tr>
	
</table>
        
        <table align="right">
            <tr style="border-bottom-style:hidden;border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">
                <td align="right">
                  <div>
                        <a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true"  onclick="javascript:hsimpan();">Simpan</a>
                        <a id="del"class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hhapus();javascript:section4();">Hapus</a>
                        <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section4();">Kembali</a>
                        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">cetak</a> 
                  </div>
                </td>                
            </tr>
        </table>
        
        <!--<table id="dg1" title="Input Detail SPP" style="width:850%;height:150%;" >  
        </table>-->
        
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
            <!-- <B>Total</B>&nbsp;&nbsp;<input class="right" type="text" name="rektotal" id="rektotal"  style="width:90px" align="rigth" readonly="true" >
            <input class="right" type="hidden" name="rektotal1" id="rektotal1"  style="width:90px" align="rigth" readonly="true" >  
            -->
            
            
        <!--<table border='0' style="width:100%;height:5%;"> 
             <td width='30%'></td>
             <td width='40%'><input class="right" type="hidden" name="rektotal1" id="rektotal1"  style="width:140px" align="right" readonly="true" ></td>
             <td width='15%'><B>Total</B></td>
             <td width='15%'><input class="right" type="text" name="rektotal" id="rektotal"  style="width:140px" align="right" readonly="true" ></td>
        </table>-->

   </p>
   </fieldset> 
   </div>

</div>
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
            <td width="110px">KPA:</td>
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