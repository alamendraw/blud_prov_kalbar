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
        
		get_tahun();
        });    
   
     
     $(function(){ 
        
        
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_sts_koreksi',
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
    		},
            {field:'tgl_bukti',
    		title:'Tanggal',
    		},
            {field:'ket',
    		title:'Keterangan',
    		width:20,
            align:"left"},
            {field:'no_sts',
    		title:'No STS',
    		width:20,
            align:"left"},
			{field:'nilai',
    		title:'Nilai',
    		width:20,
            align:"right"}
        ]],
        onSelect:function(rowIndex,rowData){
          nomor     = rowData.no_bukti;
		  nomor_sts = rowData.no_sts;
          tgl       = rowData.tgl_bukti;
          kode      = rowData.kd_skpd;
          lcket     = rowData.ket;
          cnilai 	= rowData.nilai_ed;
		  cnilai_aw	= rowData.nilai_awal;
          lcpay     = rowData.pay;
		  lctgl_trans = rowData.tgl_trans
          get(nomor,tgl,kode,cnilai,lcket,lctgl_trans,lcpay,nomor_sts,cnilai_aw);   
                  
          lcstatus  = 'edit';
        },
        onDblClickRow:function(rowIndex,rowData){
            section2();   
        }
        });
        
        $('#dg_tetap').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd/load_tetap_sts/'+kode+'/'+plrek,
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"false",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {field:'ck',
    		title:'Pilih',
    		width:5,
            align:"center",
            checkbox:true                
            },
    	    {field:'no_tetap',
    		title:'Nomor Tetap',
    		width:10,
            align:"center"},
            {field:'tgl_tetap',
    		title:'Tanggal',
    		width:5,
            align:"center"},
            {field:'nilai',
    		title:'Nilai',
    		width:5,
            align:"center"}
        ]]
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
                {field:'kd_keg',
        		title:'Kode Kegiatan',
                width:3},                
                {field:'lcnl',
        		title:'Rupiah',
                align:'right',
                width:1}               
            ]],
           onDblClickRow:function(rowIndex,rowData){
           idx = rowIndex; 
           lcrekedt   = rowData.kd_rek5;
           lcrkegi    =rowdata.kd_keg;
           lcnmrekedt = rowData.nm_rek;
           lcnilaiedt = rowData.rupiah; 
           get_edt(lcrekedt,lcnmrekedt,lcnilaiedt); 
           load_detail(lcrkegi)
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
        
                $('#tanggal_sts').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        $('#tgl_trans').datebox({  
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
           url:'<?php echo base_url(); ?>index.php/tukd/ambil_rek_tetap/'+kode,             
           columns:[[  
               {field:'kd_rek5',title:'Kode Rekening',width:140},  
               {field:'nm_rek',title:'Uraian',width:700},
              ]],
              
               onSelect:function(rowIndex,rowData){
                plrek = rowData.kd_rek5;
               $("#nmrek1").attr("value",rowData.nm_rek.toUpperCase());
               $("#dg_tetap").edatagrid({url: '<?php echo base_url(); ?>/index.php/tukd/load_tetap_sts/'+kode+'/'+plrek});
              }    
            });
            
          $('#cmb_sts').combogrid({  
           panelWidth:700,  
           idField:'no_sts',  
           textField:'no_sts',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd/load_sts',  
           columns:[[  
               {field:'no_sts',title:'Nomor STS',width:100},  
               {field:'nm_skpd',title:'Nama SKPD',width:700}    
           ]],  
           onSelect:function(rowIndex,rowData){
               nomor = rowData.no_sts;               
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
									  ambil_skx(kode)
        	}  
            });
        }
    
    function ambil_skx(kdx)
    {
    
    $('#stsx').combogrid({
           panelWidth:410,  
           idField:'no_sts',  
           textField:'no_sts',  
           mode:'remote',
           url:'<?php echo base_url(); ?>index.php/tukd_blud/load_sp2d_sts_belanja_new/'+kdx,             
           columns:[[  
               {field:'no_sts',title:'NO STS',width:140},
               {field:'tgl_sts',title:'TGL STS',width:140},
				{field:'total',title:'Total',width:140}			   
           ]],  
           onSelect:function(rowIndex,rowData){
                tgl_stsx =rowData.tgl_sts;
				$("#tanggal_sts").datebox("setValue",tgl_stsx);
				no_stsx =rowData.no_sts;
				totalxx =rowData.total;
				$("#nilaiawl").attr("value",totalxx);
				document.getElementById("nilai").focus();
			   
           }
              
        });
        }
        
 
  
	
	 function get_tahun() {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd/config_tahun',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        			tahun_anggaran = data;
					$("#skp").attr("value",data.kd_skpd);
        			$("#nmskp").attr("value",data.nm_skpd);
        			}                                     
        	});
             
        }

   	
    
    
    function get_rek(kode){
            $('#rek').combogrid({url:'<?php echo base_url(); ?>index.php/tukd/ambil_rek_t_sts/'+kode});
        }
    
    function openWindow(url)
        {
        var no =nomor.split("/").join("123456789");
        window.open(url+'/'+no, '_blank');
        window.focus();
        }     

    function loadgiat(){
        var lcjnsrek=document.getElementById("jns_trans").value;
        alert(lcjnsrek);
         $('#giat').combogrid({url:'<?php echo base_url(); ?>index.php/tukd/load_trskpd1/'+lcjnsrek});  
    }
    
    function load_detail(kk){        

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/tukd/load_dsts_belanja',
                data: ({no:kk}),
                dataType:"json",
                success:function(data){                                   
                                $.each(data,function(i,n){
                                id = n['id'];    
                                kdrek = n['kd_rek5'];                                                                    
                                lnrp = n['rupiah'];    
                                lcnmrek = n['nm_rek'];
                                lcnosts = n['no_sts'];
                                $('#dg1').datagrid('appendRow',{id:id,no_sts:lcnosts,kd_rek5:kdrek,rupiah:lnrp});                         
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
       
     
    function get(nomor,tgl,kode,cnilai,lcket,lctgl_trans,lcpay,nomor_sts,cnilai_aw){
		$('#simpan').linkbutton('disable');
		$("#no_kas").attr("value",nomor);
		$("#stsx").attr("value",nomor_sts);
        $("#tanggal").datebox("setValue",tgl);
        $("#tanggal_sts").datebox("setValue",lctgl_trans);
        $("#ket").attr("value",lcket);
        $("#nilai").attr("value",cnilai);
		$("#nilaiawl").attr("value",cnilai_aw);
	    $("#jns_pay").attr("value",lcpay);
		$("#skpd").attr("value",kode)
    }
    
    function get_edt(lcrekedt,lcnmrekedt,lcnilaiedt){
        $("#rek_edt").attr("value",lcrekedt);
        $("#nmrek_edt").attr("value",lcnmrekedt);
        $("#nilai_edt").attr("value",lcnilaiedt);
        $("#nilai_edth").attr("value",lcnilaiedt);
        $("#dialog-modal_edit").dialog('open');
    }     
    
    function kosong(){
		$('#simpan').linkbutton('enable');
		get_nourut();
		get_skpd();
        lcstatus = 'tambah';
        $("#no_kas").attr("value",'');
		$("#stsx").attr("value",'');
		$("#tanggal").datebox("setValue",'');
        $("#tgl_trans").datebox("setValue",'');
        $("#ket").attr("value",'');
        $("#jns_pay").attr("value",'');
		$("#nilai").attr("value",'');
		$("#nilaiawl").attr("value",'');
        //$("#jumlahtotal").attr("value",0);
        var kode = '';
        var nomor = '';
        //$('#giat').combogrid('setValue','');
        //$('#sp2d').combogrid('setValue','');
		//$("#nmgiat").attr("value",'');

    }

	 
	function get_nourut(){
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_blud/no_urut',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
					$("#no_kas").attr("value",data.no_urut);
					//$("#nomor_simpan").attr("value",data.no_urut);
        		}                                     
        	});  
        }
		
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_sts_koreksi',
        queryParams:({cari:kriteria})
        });        
     })
    }
    
    
    function append_save(){        
        
            var ckdrek = $('#cmb_rek').combogrid('getValue');
            var lcst = $('#stsx').combogrid('getValue');
            var giatxx = $('#giatx').combogrid('getValue');
            var lcnl = angka(document.getElementById('nilai').value);
                                     
            if (ckdrek != '' && lcnl != 0 ) {
                
                cid = cid + 1;            
                
                $('#dg1').datagrid('appendRow',{kd_rek:ckdrek,no_sts:lcst,kd_giat:giatxx,lcnl:lcnl});    
                
            }
             
            $('#cmb_rek').combogrid('setValue','');
            $('#nilai').attr('value','0');
            $('#nmrek').attr('value','');
        
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
    }
    
    
    function rek_fil(){
       
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
          $('#cmb_rek').combogrid({url:'<?php echo base_url(); ?>index.php/tukd/ambil_rek1/'+crek});  
    }
    
    
    function set_grid(){
        $('#dg1').edatagrid({  
            columns:[[
                {field:'id',
        		title:'ID',    		
                hidden:"true"},
                {field:'no_sts',
        		title:'No STS',    		
                hidden:"true"},                
        	    {field:'kd_rek',
        		title:'Nomor Rekening',
                width:2},
                {field:'kd_giat',
        		title:'Kode Kegiatan',
                width:4},                
                {field:'lcnl',
        		title:'Nilai',
                align:'right',
                width:2}                
                
            ]]
        });    
    }
    
    
    function tambah(){
        
         $("#dialog-modal").dialog('open');
         var stsxx = $('#stsx').combogrid('getValue');
         var giatxx = $('#giatx').combogrid('getValue');                  
         
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
    
 
    
    function hapus(){
        var cno_kas = document.getElementById('no_kas').value;
        var urll   = '<?php echo base_url(); ?>index.php/tukd_blud/hapus_sts_pen';
		var cskpdx     = document.getElementById('skpd').value;
        $(document).ready(function(){
         $.post(urll,({cno_kas:cno_kas,cskpdx:cskpdx}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                alert('Data Berhasil Dihapus..!!');
				get_nourut();
                exit();
            }
         });
        });    
    }
    
    
    
    function simpan_sts(){
 
        var cno       = document.getElementById('no_kas').value;
		var cbank     = '';
        var cpay      = document.getElementById('jns_pay').value;
		var ctgl      = $('#tanggal').datebox('getValue');
        var ctgl_trans= $('#tanggal_sts').datebox('getValue');
        var cskpd     = document.getElementById('skpd').value;
        var stsxx     = $('#stsx').combogrid('getValue');
        var lcket     = document.getElementById('ket').value;
		var cjnsrek   = '5';
		var nilaw      = document.getElementById('nilaiawl').value;
		var nilak      = document.getElementById('nilai').value;
		

    

            lcinsert = "(no_bukti ,  tgl_bukti,RP_BANK, RP_KAS,   KET      ,  KD_SKPD   ,   KD_UNIT  , username,    tgl_update ,  jns_beban,  lain , kd_kegiatan ,pengurang_belanja,   no_sts       ,      nilai    ,   pay          ,    tgl_trans    )"; 
           
		   lcvalues = "('"+cno+"', '"+ctgl+"',  0    ,  0    , '"+lcket+"', '"+cskpd+"', '"+cskpd+"', ''      ,      ''       ,     ''    ,   ''   ,      ''     , ''     , '"+stsxx+"'    , '"+nilak+"'   , '"+cpay+"'     ,  '"+ctgl_trans+"')";
			
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url      : '<?php echo base_url(); ?>/index.php/tukd_blud/simpan_sts_belanja',
                    data     : ({tabel:'trhinlain_blud',kolom:lcinsert,nilai:lcvalues,cid:'no_bukti'}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();

                        }
                    }
                });
            });   
       
    

        
    }
    
    


    
    
    function jumlah(){

        var lcno = document.getElementById('nomor').value;
        var lcnm = document.getElementById('nmrek1').value;
        ckdrek = $('#rek').combogrid('getValue'); 
        var rows = $('#dg_tetap').datagrid('getChecked');
        cid = cid + 1;      
        
        var lstotal = angka(document.getElementById('jumlahtotal').value);
        
        
        var lnjm = 0;    
        	for(var i=0;i<rows.length;i++){
        	   ltmb = angka(rows[i].nilai);
               lnjm = lnjm + ltmb;
        	   }
  
            total = number_format(lstotal+lnjm,2,'.',',');
            $('#jumlahtotal').attr('value',total);    
            lcjm = number_format(lnjm,2,'.',',')               

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
         
         lcnilai = number_format(lnnilai,2,'.',',');
         total = lstotal - lnnilai_sb + lnnilai; 
         ftotal = number_format(total,2,'.',',');
         $('#dg1').datagrid('updateRow',{
            	index: idx,
            	row: {
            		rupiah: lcnilai                    
            	}
         });
         $('#jumlahtotal').attr('value',ftotal);  
         keluar();
    }
    
    </script>

</head>
<body>


<div id="content"> 
<div id="accordion">
<h3><a href="#" id="section1">List Koreksi Pendapatan</a></h3>
    
    <div>
    <p align="right">         
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="dg" title="List STS" style="width:870px;height:450px;" >  
        </table>
    </p> 
    </div>   

<h3><a href="#" id="section2" onclick="javascript:set_grid();">Koreksi Pendapatan (NOMOR KOREKSI TERISI OTOMATIS !)</a></h3>

   <div  style="height: 300px;">

   <p>       
        <table align="center" style="width:100%;" border="0">
            <tr>
                <td>No. Koreksi</td>
                <td>: <input type="text" id="no_kas" disabled style="width: 200px;"/></td>
                <td>Tanggal STS</td>
                <td><input type="text" id="tanggal" style="width: 140px;" /></td>
            </tr>            
            <tr>
                <td>S K P D</td>
                <td>: <input id="skpd" name="skpd" style="width: 140px;" disabled/></td>
                <td colspan="2" align="left"><input type="text" id="nmskpd" style="border:0;width: 250px;" readonly="true"/></td>
            </tr>
            <tr>
                <td>Uraian</td>
                <td colspan="3"><textarea name="ket" id="ket" cols="40" rows="4" style="border: 0;"  ></textarea></td>                
            </tr>            
           <tr >
			<td colspan="2">

			</td>
            </tr>
			<td>STS</td>
            <td>: <input id="stsx" name="stsx" style="width: 200px;" /></td>
            </tr>
			<tr>
                <td>Tanggal Transaksi</td>
                <td>: <input type="text" id="tanggal_sts" style="width: 140px;"  /></td>
            </tr>  
			<tr> 
				<td width="110px">Nilai Awal</td>
				<td>: <input type="text" id="nilaiawl" style="text-align: right;" disabled/></td>
			</tr>
			<tr> 
				<td width="110px">Nilai Koreksi</td>
				<td>: <input type="text" id="nilai" style="text-align: right;"/></td>
			</tr>
            <tr>
                <td>Jenis</td>
                <td>: <select name="jns_pay" id="jns_pay">
                         <option value="">......</option>     
                         <option value="BANK">BANK</option>
                         <option value="TUNAI">TUNAI</option>
                     </select>&nbsp;</td>
            </tr>
			<tr>
            <td colspan="4"> <input id="jns_tetap" hidden = "true" type="checkbox"/></td>            
            </tr>
            <tr>
                <td colspan="4" align="right">
                <a class="easyui-linkbutton" id="simpan" iconCls="icon-save" plain="true" onclick="javascript:simpan_sts();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a></td>

            </tr>
        </table>          
        <!--<table id="dg1" title="Detail STS" style="width:870px;height:350px;" >  
        </table>  
        <div id="toolbar">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah();">Tambah Rekening</a>
    		<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_rek();">Hapus Rekening</a>    		
        </div>
        
                
   </p>
   <table border="0" align="right" style="width:100%;"><tr>
   <td style="width:75%;" align="right"><B>JUMLAH</B></td>
   <td align="right"><input type="text" id="jumlahtotal" readonly="true" style="border:0;width:200px;text-align:right;"/></td>
   </tr>
   </table>-->
   
   </div>
</div>
</div>


<div id="dialog-modal" title="Input Rekening Pengembalian">    
    <fieldset>
    <table>
        <tr>
            <td width="110px">Kode Rekening</td>
            <td>: <input id="cmb_rek" name="cmb_rek" style="width: 200px;" /></td>
        </tr>
        <tr>
            <td width="110px">Nama Rekening</td>
            <td>: <input type="text" id="nmrek" readonly="true" style="border:0;width: 400px;"/></td>
        </tr>
        <tr> 
           <td width="110px">Nilai Lalu</td>
           <td>: <input type="text" id="nilai_lalu" disabled style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
        </tr>
        <tr> 
           <td width="110px">Nilai</td>
           <td>: <input type="text" id="nilai" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
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
            <td width="110px">Kode Rekening:</td>
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
            <td width="100%" align="center"><a  href="<?php echo site_url(); ?>/tukd/cetak_sts" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>  </td>
        </tr>
    </table>  
    </fieldset>
    
	
</div>


<div id="dialog-modal_t" title="Checkbox Select">
<table border="0">
<tr>
<td>Rekening</td>
<td><input id="rek" name="rek" style="width: 140px;" />  <input type="text" id="nmrek1" style="border:0;width: 400px;" readonly="true"/></td>
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