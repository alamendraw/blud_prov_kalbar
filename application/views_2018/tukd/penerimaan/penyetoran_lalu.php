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
    var giat     = '1';
    var nomor    = '';
    var cid      = 0 ;
    var plrek    = '';
    var lcstatus = '';
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $("#dialog-modal").dialog({
            height: 200,
            width: 700,
            modal: true,
            autoOpen:false
        });
         $("#dialog-modal_t").dialog({
            height: 500,
            width: 800,
            modal: true,
            autoOpen:false
        });
        $("#dialog-modal_cetak").dialog({
            height: 200,
            width: 400,
            modal: true,
            autoOpen:false
        });
        $("#dialog-modal_edit").dialog({
            height: 200,
            width: 700,
            modal: true,
            autoOpen:false
        });
        get_skpd(); 
		get_tahun();
        });    
     
     //datagrid list sts
     $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_sts_tl',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'no_sts',
    		title:'Nomor STS',
    		width:50},
            {field:'tgl_sts',
    		title:'Tanggal',
    		width:30},
            {field:'kd_skpd',
    		title:'B L U D',
    		width:30,
            align:"left"},
            {field:'keterangan',
    		title:'Uraian',
    		width:50,
            align:"left"}
        ]],
        onSelect:function(rowIndex,rowData){
          nomor     = rowData.no_sts;
          tgl       = rowData.tgl_sts;
          kode      = rowData.kd_skpd;
          lcket     = rowData.keterangan;
          lcjnskeg  = rowData.jns_trans;
          lctotal   = rowData.total;
          get(nomor,tgl,kode,lcket,lcjnskeg,lctotal);   
          lcstatus  = 'edit';
        },
        onDblClickRow:function(rowIndex,rowData){
            load_detail(nomor);      
			section2();   
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
                    lnnilai = rowData.rupiah;
            },                                                     
            columns:[[
                {field:'id',
        		title:'ID',    		
                hidden:"true"},
                {field:'no_sts',
        		title:'No STS',    		
                hidden:"true"},                
        	    {field:'kd_rek5',
        		title:'Nomor Rekening',
                width:1},
                {field:'nm_rek',
        		title:'Nama Rekening',
                width:3},                
                {field:'rupiah',
        		title:'Rupiah',
                align:'right',
                width:1}               
            ]],
           onDblClickRow:function(rowIndex,rowData){
           idx = rowIndex; 
           lcrekedt   = rowData.kd_rek5;
           lcnmrekedt = rowData.nm_rek;
           lcnilaiedt = rowData.rupiah; 
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
        
        $('#tanggalkas').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            },
			onSelect: function(date){
				var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
        $("#tanggal").datebox("setValue",y+'-'+m+'-'+d);
		
		}
        });
    
        
        $('#rek').combogrid({  
           panelWidth:700,  
           idField:'kd_rek5',  
           textField:'kd_rek5',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd_blud/ambil_rek_tetap/'+kode,             
           columns:[[  
               {field:'kd_rek5',title:'Kode Rekening',width:140},  
               {field:'nm_rek',title:'Uraian',width:700},
              ]],
              
               onSelect:function(rowIndex,rowData){
                plrek = rowData.kd_rek5;
               $("#nmrek1").attr("value",rowData.nm_rek.toUpperCase());
              }    
            });
            
          $('#cmb_sts').combogrid({  
           panelWidth:700,  
           idField:'no_sts',  
           textField:'no_sts',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd_blud/load_sts',  
           columns:[[  
               {field:'no_sts',title:'Nomor STS',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               nomor = rowData.no_sts;               
           } 
       });
       
	   
          
        $('#cmb_rek').combogrid({  
           panelWidth:620,  
           idField:'kd_rek5',  
           textField:'kd_rek5',  
           mode:'remote',
           columns:[[
               {field:'kd_rek5',title:'Rekening',width:100},  
               {field:'nm_rek5',title:'Uraian',width:200},
               {field:'kd_blud',title:'Rek. Blud',width:100},
               {field:'uraian',title:'Uraian',width:200},
              ]],
               onSelect:function(rowIndex,rowData){
               $("#nmrek").attr("value",rowData.nm_rek5);
               $("#kd_rek_blud").attr("value",rowData.kd_blud);
               $("#nm_rek_blud").attr("value",rowData.uraian);
               $("#kd_giat").attr("value",rowData.kd_kegiatan);
               $("#nilai").attr("value",0);
              }    
            });
    });  
    
	function tampil_no_terima(no_terima,tgl_terima,kd_rek5,kd_skpd,nilai){
			$('#dg1').datagrid('selectAll');
            var rows = $('#dg1').datagrid('getSelections');           
			for(var p=0;p<rows.length;p++){
                cno_terima  = rows[p].no_terima;
                if (cno_terima==no_terima) {
					swal("Error", "Nomor Ini Sudah Ada Di List", "warning");
					exit();
				}
			}
			$('#dg1').datagrid('selectAll');			
			jgrid     = rows.length ; 
			pidx = jgrid + 1 ;
					$('#dg1').edatagrid('appendRow',{no_terima:no_terima,tgl_terima:tgl_terima,kd_rek5:kd_rek5,nilai:nilai,idx:pidx});
                    $('#dg1').edatagrid('unselectAll');
					$('#jumlahtotal').attr('value',total);

    }
	
    function get_skpd(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#skpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
        								kode = data.kd_skpd;
                                        lckode='4';
        							  }                                     
        	});
    } 
	 function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_blud/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
        			}                                     
        	});
             
        } 
    
    
    function get_rek(kode){
            $('#rek').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/ambil_rek_t_sts/'+kode});
        }
    
    function openWindow(url)
        {
        var no =nomor.split("/").join("123456789");
        window.open(url+'/'+no, '_blank');
        window.focus();
        }     

    function loadgiat(){
        var lcjnsrek=document.getElementById("jns_trans").value;
         $('#giat').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/load_trskpd1_pend/'+lcjnsrek});  
    }
    
    function load_detail(kk){        
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_dsts_lalu',
                data: ({no:kk}),
                dataType:"json",
                success:function(data){                                   
                                $.each(data,function(i,n){
                                id = n['id'];    
                                kdrek = n['kd_rek5'];                                                                    
                                lnrp = n['rupiah'];    
                                lcblud = n['kd_rek_blud'];
                                lcgiat = n['kd_kegiatan'];
                                lcnosts = n['no_sts'];
                                $('#dg1').datagrid('appendRow',{id:id,no_sts:lcnosts,kd_rek5:kdrek,nilai:lnrp,kd_rek_blud:lcblud,kd_giat:lcgiat});
                         
                                });   
                                 
                }
            });
           });  
         set_grid();
    }
 
    function section1(){
         $(document).ready(function(){    
             $('#section1').click();   
             $('#dg').edatagrid('reload');                                              
         });
    }
    
    function section2(){
         $(document).ready(function(){    
             $('#section2').click();                                               
         });   
         set_grid();      
     }
       
     
    function get(nomor,tgl,kode,lcket,lcjnskeg,lctotal){
        $("#nomor").attr("value",nomor);
        $("#nomor_hide").attr("value",nomor);
        $("#tanggal").datebox("setValue",tgl);
        $("#ket").attr("value",lcket)
        $("#jumlahtotal").attr("value",lctotal);
    }
    
    function get_edt(lcrekedt,lcnmrekedt,lcnilaiedt){
        $("#rek_edt").attr("value",lcrekedt);
        $("#nmrek_edt").attr("value",lcnmrekedt);
        $("#nilai_edt").attr("value",lcnilaiedt);
        $("#nilai_edth").attr("value",lcnilaiedt);
        $("#dialog-modal_edit").dialog('open');
    } 
    
    
    function kosong(){
        lcstatus = 'tambah';
        $("#nomor").attr("value",'');
        $("#no_kas").attr("value",'');
        $("#nomor_hide").attr("value",'');
        $("#tanggal").datebox("setValue",'');
        $("#tanggalkas").datebox("setValue",'');
        $("#ket").attr("value",'');
        $("#nmgiat").attr("value",'');
        $("#jumlahtotal").attr("value",0);
        var kode = '';
        var nomor = '';
        $('#giat').combogrid('setValue','');
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_sts',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
    
    function append_save(){        
            var ckdrek = $('#cmb_rek').combogrid('getValue');
            var lcno = document.getElementById('nomor').value;
            var lcnm = document.getElementById('nmrek').value;
            var lcblud = document.getElementById('kd_rek_blud').value;
            var lcnmblud = document.getElementById('nm_rek_blud').value;
            var lcgiat = document.getElementById('kd_giat').value;
            var lcnl = angka(document.getElementById('nilai').value);
            var lstotal = angka(document.getElementById('jumlahtotal').value);
            var lcnl1 = number_format(lcnl,2,'.',',');
            $('#dg1').datagrid('selectAll');
            var rows = $('#dg1').datagrid('getSelections');           
			for(var p=0;p<rows.length;p++){
                kd_blud  = rows[p].kd_rek_blud;
                if (kd_blud==lcblud) {
					swal("Error", "Rekening Blud Sudah Ada Di Dalam Daftar", "warning");
					return
				}
			}
			
            if (ckdrek != '' && lcnl != 0 ) {
                total = number_format(lstotal+lcnl,2,'.',',');
                cid = cid + 1;            
                $('#dg1').edatagrid('appendRow',{id:cid,no_sts:lcno,kd_rek5:ckdrek,kd_rek_blud:lcblud,kd_giat:lcgiat,nilai:lcnl1});
                $('#jumlahtotal').attr('value',total);    
                rek_filter(); 
            }
             
            $('#cmb_rek').combogrid('setValue','');
            $('#nilai').attr('value','0');
            $('#nmrek').attr('value','');
            $('#kd_rek_blud').attr('value','');
            $('#nm_rek_blud').attr('value','');
            $('#kd_giat').attr('value','');
        
    }     
    
    function hapus_detail(){
        var lstotal = angka(document.getElementById('jumlahtotal').value);
        var rows       = $('#dg1').edatagrid('getSelected');
        
        bno_terima    = rows.kd_rek5;
        bnilai        = rows.nilai;
        
        var idx = $('#dg1').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, Kode Rekening :  '+bno_terima+' - Nilai :  '+bnilai+' ?');
        
		angka_nilai=angka(bnilai);
		
        if ( tny == true ) {
			hasil = number_format(lstotal-angka_nilai,0,'.',',');
			$('#dg1').datagrid('deleteRow',idx);     
            $('#dg1').datagrid('unselectAll');
            $('#jumlahtotal').attr('value',hasil);  
        }
			
    }
	
     function rek_filter(){
        var crek='';
         $('#dg1').datagrid('selectAll');
            var rows = $('#dg1').datagrid('getSelections');           
			for(var i=0;i<rows.length;i++){
				crek   = crek+"A"+rows[i].kd_rek5+"A";
                if (i<rows.length && i!=rows.length-1){
                    crek = crek+'B';
                }
            }
               $('#dg1').datagrid('unselectAll');
          $('#cmb_rek').combogrid({url:'<?php echo base_url(); ?>index.php/tukd_blud/ambil_rek_ag2/'+kode+'/'+giat+'/'+crek});  
    }
    
    //data grid Detail STS
    function set_grid(){
        $('#dg1').edatagrid({  
            columns:[[
                {field:'id',
        		title:'ID',    		
                hidden:"true"},
                {field:'no_sts',
        		title:'No STS',    		
                hidden:"true"},
        	    {field:'kd_giat',
        		title:'Kegiatan',    		
                hidden:"true"},
        	    {field:'kd_rek5',
        		title:'Rekening',
                width:1},
				{field:'kd_rek_blud',
        		title:'Rek. Blud',
                width:1},
                {field:'nilai',
        		title:'Rupiah',
                align:'right',
                width:2},
				{field:'hapus',title:'',width:1,align:"center",
                    formatter:function(value,rec){ 
						return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
                    }
                }
                
            ]]
        });    
    }
    
    
    function tambah(){
        var lcno = document.getElementById('nomor').value;
        var cjnstetap = document.getElementById('jns_tetap').checked;
         var giat  = '1';
        if(cjnstetap==true){
            $("#dialog-modal_t").dialog('open');
        } else {

            if(lcno !=''){
            $("#dialog-modal").dialog('open');
            $('#nilai').attr('value','0');
            $('#nmrek').attr('value','');
            var kode = document.getElementById('skpd').value;
            } else {
                swal("Error", "Nomor STS Tidak Boleh Kosong", "warning");
                document.getElementById('no_kas').focus();
                exit();
            }
             rek_filter(); 
        }
    }
    
    function cetak(){
        $("#dialog-modal_cetak").dialog('open');             
    }
    
    function keluar(){
        $("#dialog-modal").dialog('close');
        $("#dialog-modal_t").dialog('close');
        $("#dialog-modal_cetak").dialog('close');
        $("#dialog-modal_edit").dialog('close');
    }    
    
    
    function hapus_rek(){
        var lckurang = angka(lnnilai);
        var lstotal  = angka(document.getElementById('jumlahtotal').value);
        lntotal      =  number_format(lstotal - lckurang,0,'.',',');
        
        $("#jumlahtotal").attr("value",lntotal);
        $('#dg1').datagrid('deleteRow',idx);     
    }
    
    function hapus(){
        var cnomor = document.getElementById('nomor').value;
        var urll   = '<?php echo base_url(); ?>index.php/tukd_blud/hapus_sts';
		var del=confirm('Anda yakin akan menghapus Nomor Penyetoran '+cnomor+'  ?');
		if  (del==true){
			$(document).ready(function(){
			 $.post(urll,({no:cnomor}),function(data){
				status = data;
				if (status=='0'){
					swal("Error", "Gagal Hapus", "warning");
					exit();
				} else {
					swal("Berhasil", "Data Berhasil Dihapus", "success");
					exit();
				}
			 });
			});  
		}
    }
    
    function simpan_sts(){
        var cno       = document.getElementById('nomor').value;
        var cno_hide  = document.getElementById('nomor_hide').value;
        var cbank     = '';
        var ctgl      = $('#tanggal').datebox('getValue');
        var cskpd     = document.getElementById('skpd').value;
        var cnmskpd   = document.getElementById('nmskpd').value;
        var lcket     = document.getElementById('ket').value;
        var cjnsrek   = '2';
        var lcrekbank = '';
        var lntotal   = angka(document.getElementById('jumlahtotal').value);
        var cstatus   = '';
		var tahun_input = ctgl.substring(0, 4);
		
		if (tahun_input != tahun_anggaran){
			swal("Error", "Tahun Tidak Sama Dengan Tahun Anggaran", "warning");
			exit();
		}
        
        if (cno==''){
           swal("Error", "Nomor STS Tidak Boleh Kosong", "warning");
            exit();
        } 
        if (ctgl==''){
            swal("Error", "Tanggal STS Tidak Boleh Kosong", "warning");
            exit();
        }
        if (cskpd==''){
            swal("Error", "Kode SKPD Tidak Boleh Kosong", "warning");
            exit();
        }
        
        if(lcstatus == 'tambah'){
		$(document).ready(function(){
              
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:cno,tabel:'trhkasin_blud',field:'no_sts'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1){
						swal("Error", "Nomor Telah Dipakai", "warning");
						document.getElementById("nomor").focus();
						exit();
						} 
						if(status_cek==0){
						
            $('#dg1').datagrid('selectAll');
            var rows  = $('#dg1').datagrid('getSelections');           
    		lcval_det = '';
            for(var i=0;i<rows.length;i++){
                ckdrek  = rows[i].kd_rek5;              
                cgiat  = rows[i].kd_giat;              
                ckdblud  = rows[i].kd_rek_blud;              
                cnilai  = angka(rows[i].nilai); 
                
                if(i>0){
    				lcval_det = lcval_det+",('"+cskpd+"','"+cno+"','"+ckdrek+"','"+cnilai+"','"+cgiat+"','"+ckdblud+"')";
    			}else{
    				lcval_det = lcval_det+"('"+cskpd+"','"+cno+"','"+ckdrek+"','"+cnilai+"','"+cgiat+"','"+ckdblud+"')";
    			}              
    		}
            $('#dg1').datagrid('unselectAll'); 
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/simpan_sts_pendapatan_tlalu',
                    data: ({tabel:'trhkasin_blud',cid:'no_sts',lcid:cno,no:cno,bank:cbank,tgl:ctgl,skpd:cskpd,ket:lcket,jnsrek:cjnsrek,giat:cgiat,rekbank:lcrekbank,total:lntotal,value_det:lcval_det,sts:cstatus}),
                    dataType:"json",
                    success:function(data){
                        status = data ;
                        if (status=='0'){
                             swal("Error", "Gagal Simpan", "warning");
                             exit();
                        }  else  
                        if (status=='2'){
                             swal("Berhasil", "Data Berhasil Disimpan", "success");
                             $("#nomor_hide").attr("Value",cno);  
                             lcstatus = 'edit'; 
							section1();
                        }
                    }
                });
            });
		//akhir-mulai 
        }
		}
		});
		});
		
       } else {
		$(document).ready(function(){
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({no:cno,tabel:'trhkasin_blud',field:'no_sts'}),
                    url: '<?php echo base_url(); ?>/index.php/tukd_blud/cek_simpan',
                    success:function(data){                        
                        status_cek = data.pesan;
						if(status_cek==1 && cno!=cno_hide){
						swal("Error", "Nomor Telah Dipakai", "warning");
						exit();
						} 
						if(status_cek==0 || cno==cno_hide){
						
             $('#dg1').datagrid('selectAll');
             var rows  = $('#dg1').datagrid('getSelections');           
    		lcval_det = '';
            for(var i=0;i<rows.length;i++){
				ckdrek  = rows[i].kd_rek5;              
                cgiat  = rows[i].kd_giat;              
                ckdblud  = rows[i].kd_rek_blud;              
                cnilai  = angka(rows[i].nilai); 
                if(i>0){
    				lcval_det = lcval_det+",('"+cskpd+"','"+cno+"','"+ckdrek+"','"+cnilai+"','"+cgiat+"','"+ckdblud+"')";
    			}else{
    				lcval_det = lcval_det+"('"+cskpd+"','"+cno+"','"+ckdrek+"','"+cnilai+"','"+cgiat+"','"+ckdblud+"')";
    			}              
    		}
            $('#dg1').datagrid('unselectAll');    
              $(document).ready(function(){
                    $.ajax({
                        type     : "POST",
                        url      : '<?php echo base_url(); ?>/index.php/tukd_blud/update_sts_pendapatan_ag_tlalu',
						data: ({tabel:'trhkasin_blud',cid:'no_sts',lcid:cno,no:cno,bank:cbank,tgl:ctgl,skpd:cskpd,ket:lcket,jnsrek:cjnsrek,giat:cgiat,rekbank:lcrekbank,total:lntotal,value_det:lcval_det,sts:cstatus,nohide:cno_hide}),
						dataType : "json",
                        success  : function(data){
                            
                            status = data;
                            if (status=='0'){
                                 swal("Error", "Gagal Simpan", "warning");
                                 exit();
                            } else 
                            if (status=='2'){
                                swal("Berhasil", "Data Berhasil Tersimpan", "success");
                                $("#nomor_hide").attr("Value",cno);
                                lcstatus = 'edit'; 
								section1();
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
    
    

    
    
    function jumlah(){
        var lcno = document.getElementById('nomor').value;
        var lcnm = document.getElementById('nmrek1').value;
        ckdrek = $('#rek').combogrid('getValue'); 
        var rekcheck = document.getElementById('rekcheck').value ;
        var rows = $('#dg_tetap').datagrid('getChecked');
		if (ckdrek != rekcheck){
            swal("Error", "Rekening Tidak Sesuai", "warning");
            exit();
        }	
		cid = cid + 1;      
        var lstotal = angka(document.getElementById('jumlahtotal').value);
        var lnjm = 0;    
        	for(var i=0;i<rows.length;i++){
        	   ltmb = angka(rows[i].nilai);
               lnjm = lnjm + ltmb;
        	   }
            total = number_format(lstotal+lnjm,0,'.',',');
            $('#jumlahtotal').attr('value',total);    
            lcjm = number_format(lnjm,0,'.',',')               
            $('#dg1').datagrid('appendRow',{id:cid,no_sts:lcno,kd_rek5:ckdrek,rupiah:lcjm,nm_rek:lcnm});
          keluar();
    }
  
  
    function delCommas(nStr)
    {
        var no =nStr.split(",").join("");
        return no1 = eval(no);
    }
    
    function edit_detail(){
    
         var lnnilai = angka(document.getElementById('nilai_edt').value);
         var lnnilai_sb = angka(document.getElementById('nilai_edth').value);
         var lstotal = angka(document.getElementById('jumlahtotal').value);
         
         lcnilai = number_format(lnnilai,0,'.',',');
         total = lstotal - lnnilai_sb + lnnilai; 
         ftotal = number_format(total,0,'.',',');
         $('#dg1').datagrid('updateRow',{
            	index: idx,
            	row: {
            		rupiah: lcnilai                    
            	}
         });
         $('#jumlahtotal').attr('value',ftotal);  
         keluar();
    }
	function input_nomor(){
		var no_awal = document.getElementById('no_kas').value;
		$("#nomor").attr("value",no_awal);
	}
    function refresh(){
		   		window.location.reload();

	   }
    </script>

</head>
<body>


<div id="content"> 
<div id="accordion">
<h3><a href="#" id="section1">List STS</a></h3>
    
    <div>
    <p align="right">         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>               
        <!--<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>-->
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="dg" title="List STS" style="width:870px;height:450px;" >  
        </table>
    </p> 
    </div>   

<h3><a href="#" id="section2" onclick="javascript:set_grid();">Surat Tanda Setoran</a></h3>

   <div  style="height: 350px;">

   <p>       
        <table align="center" style="width:100%;" border="0">
            <tr>
                <td>No. S T S</td>
                <td><input type="text" id="nomor" style="width: 200px;  readonly="true" placeholder="Isi sama dengan No Kas""/><input type="hidden" id="nomor_hide" style="width: 200px;"/></td>
                <td>Tanggal STS</td>
                <td><input type="text" id="tanggal" style="width: 140px;" /></td>
                    
            </tr>            
            <tr>
                <td>B L U D</td>
                <td><input id="skpd" name="skpd" style="width: 140px;" readonly="true"/></td>
                <td colspan="2" align="left"><input type="text" id="nmskpd" style="border:0;width: 450px;" readonly="true"/></td>
                                
            </tr>
            <tr>
                <td>Uraian</td>
                <td colspan="3"><textarea name="ket" rows="1" cols="50" id="ket" style="width: 720px;"></textarea></td>                
            </tr>            
            <tr>
           <input id="jns_tetap" hidden type="checkbox"/></td>            
            </tr>
            <tr>
                <td colspan="4" align="right">
                <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Baru</a>               
                <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_sts();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
                <!--<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>-->
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a></td>

            </tr>
        </table>          
        <table id="dg1" title="Detail STS" style="width:870px;height:350px;" >  
        </table>  
        <div id="toolbar">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah();">Tambah Rekening</a>
        </div>
        
                
   </p>
   <table border="0" align="right" style="width:100%;"><tr>
   <td style="width:75%;" align="right"><B>JUMLAH</B></td>
   <td align="right"><input type="text" id="jumlahtotal" readonly="true" style="border:0;width:200px;text-align:right;"/></td>
   </tr>
   </table>
   
   </div>
</div>
</div>


<div id="dialog-modal" title="Input Rekening">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
    <table>
        <tr>
            <td width="110px">Kode Rekening:</td>
            <td><input id="cmb_rek" name="cmb_rek" style="width: 120px;" /></td>
            <td><input id="nmrek" name="nmrek" style="width: 300px;border:0" /></td>
            <td><input id="kd_giat" name="kd_giat" style="width: 300px;border:0" hidden /></td>
        </tr>
        <tr>
            <td width="110px">Rekening Blud:</td>
            <td><input type="text" id="kd_rek_blud" readonly="true" style="border:0;width: 120px;"/></td>
            <td><input type="text" id="nm_rek_blud" readonly="true" style="border:0;width: 300px;"/></td>
        </tr>
        <tr> 
           <td width="110px">Nilai:</td>
           <td><input type="text" id="nilai" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
        </tr>
    </table>  
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:append_save();">Simpan</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  
</div>

<div id="dialog-modal_edit" title="Edit Rekening">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
    <table>
        <tr>
            <td width="110px">Rekening :</td>
            <td><input type="text" id="rek_edt" readonly="true" style="width: 200px;" /></td>
        </tr>
        <tr>
            <td width="110px">Nama Rekening:</td>
            <td><input type="text" id="nmrek_edt" readonly="true" style="border:0;width: 400px;"/></td>
        </tr>
        <tr> 
           <td width="110px">Nilai:</td>
           <td><input type="text" id="nilai_edt" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/>
               <input type="hidden" id="nilai_edth"/> 
           </td>
        </tr>
    </table>  
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:edit_detail();">Simpan</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  
</div>


<div id="dialog-modal_cetak" title="Input Rekening">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
    <table>
        <tr>
            <td width="110px">No STS:</td>
            <td><input id="cmb_sts" name="cmb_sts" style="width: 200px;" /></td>
        </tr>
    </table>  
    </fieldset>
     <fieldset>
    <table border="0">
        <tr align="center">
            <td></td>
            <td width="100%" align="center"><a  href="<?php echo site_url(); ?>/tukd_blud/cetak_sts" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  </td>
        </tr>
    </table>  
    </fieldset>
    
	
</div>


<div id="dialog-modal_t" title="Checkbox Select">
<table border="0">
<tr>
<td>Rekening</td>
<td><input id="rek" name="rek" style="width: 140px;" />  <input type="text" id="nmrek1" style="border:0;width: 400px;" readonly="true"/> <input type="hidden" id="rekcheck" name="rekcheck" style="width: 140px;" /></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr><td colspan="2">
    <table id="dg_tetap" style="width:770px;height:350px;" >  
        </table>
    </td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr><td colspan="2" align="center">
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:jumlah();">Simpan</a>
	<a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a></td>
</tr>
</table>  
</div>
  	
</body>

</html>