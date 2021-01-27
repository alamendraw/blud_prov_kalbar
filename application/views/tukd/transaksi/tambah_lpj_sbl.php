<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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
   
    <script type="text/javascript"> 
   
	var jnsbeban='';
    var no_lpj   = '';
    var kode     = '';
    var spd      = '';
    var st_12    = 'edit';
    var nidx     = 100
    var spd2     = '';
    var spd3     = '';
    var spd4     = '';
    var lcstatus = '';
    
    $(document).ready(function() {
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

    $("#nomor_urut").attr('maxlength','5');
    
    $("#nomor_urut").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
    // Allow: Ctrl+A, Command+A
    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
    // Allow: home, end, left, right, down, up
    (e.keyCode >= 35 && e.keyCode <= 40)) {
    // let it happen, don't do anything
    return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
    e.preventDefault();
    }
    });
            $("#accordion").accordion();
            $("#lockscreen").hide();                        
            $("#frm").hide();
            
        get_skpd();
        });
   
    
    $(function(){
				
   	     $('#dd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        
        $('#dd1').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
        
        $('#dd2').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });

                
         
          
		  $('#spp').edatagrid({
    		url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_lpj',
            idField:'id',            
            rownumbers:"true", 
            fitColumns:"true",
            singleSelect:"true",
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",
            pagination:"true",
            nowrap:"true",                       
            columns:[[
        	    {field:'no_lpj',
        		title:'NO LPJ',
        		width:120},
                {field:'tgl_lpj',
        		title:'Tanggal',
        		width:50},
                {field:'nm_skpd',
        		title:'Nama SKPD',
        		width:170,
                align:"left"},
                {field:'ket',
        		title:'Keterangan',
        		width:110,
                align:"left"}
            ]],
            onSelect:function(rowIndex,rowData){
              nomer    = rowData.no_lpj;         
              kode     = rowData.kd_skpd;
              tgllpj   = rowData.tgl_lpj;
              tglawal  = rowData.tgl_awal;
              tglakhir = rowData.tgl_akhir;
              cket     = rowData.ket;
              jspp     = rowData.jnsspp;
              status   = rowData.status_lpj;
              
              urut     = rowData.urut;         
              format   = rowData.format;

              get(urut,format,nomer,kode,tgllpj,cket,status,tglawal,tglakhir,jspp);
              detail_trans_3(nomer);
              load_sum_lpj(); 
              lcstatus = 'edit';                                       
            },
            onDblClickRow:function(rowIndex,rowData){
                section1();
            }
        });
//doni star -->	
		//var kdlpj=document.getElementById("no_lpj").value;
		
		$('#dg1').edatagrid({
//    		url: '<?php echo base_url(); ?>/index.php/tukd/select_data1_lpj',
			url: '<?php echo base_url(); ?>/index.php/tukd_blud/select_data1_lpj',  
			idField:'idx',
            toolbar:"#toolbar",              
            rownumbers:"true", 
            fitColumns:false,
            autoRowHeight:"false",
			     loadMsg:"Tunggu Sebentar....!!",
            singleSelect:"true",
            nowrap:"true", 
            columns:[[
        	  
                     {field:'idx',
                     title:'idx',
                     width:100,
                     align:'left',
                     hidden:'true'
                     },               
                     {field:'no_bukti',
                     title:'No Bukti',
                     width:110,
                     align:'left'
                     },                                          
                     {field:'kdkegiatan',
                     title:'Kegiatan',
                     width:140,
                     align:'left'
                     },
                     {field:'kdrek5',
                     title:'Rekening',
                     width:80,
                     align:'left'
                     },
                     {field:'nmrek5',
                     title:'Nama Rekening',
                     width:280
                     },
                     {field:'nilai1',
                     title:'Nilai',
                     width:110,
                     align:'right'
                     } ,
                     {field:'hapus',
                     title:'',
                     width:35,
                     align:"center",
                    formatter:function(value,rec){ 
                    return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail_grid();" />';
                    } 
                    }
            ]]
		
			
        });
	
			
   	});
        
           
        
    function val_ttd(dns){
           $(function(){
            $('#ttd').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/tukd/pilih_ttd/'+dns,  
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
         

    
    function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/tukd_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#dn").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd);
                                            kode   = data.kd_skpd;
                                            //validate_spd(kode);
        							  }                                     
        	});  
        }         
    
    
    
    
	     function get(urut,format,nomer,kode,tgllpj,cket,status,tglawal,tglakhir,jnsspp){
        $("#no_lpj").attr("value",format);
        $("#nomor_urut").attr("value",urut);
        $("#dn").attr("Value",kode);		
        $("#dd").datebox("setValue",tgllpj);
        $("#dd1").datebox("setValue",tglawal);
        $("#dd2").datebox("setValue",tglakhir);
        $("#keterangan").attr("Value",cket);
        document.getElementById("no_lpj").disabled=true; 
        document.getElementById("nomor_urut").disabled=true; 
       
	
    		if ((status == undefined) || (status =='')|| (status =='null') ){
    			
    			status='0';
    		}else{		
    			status='1';		
    		}
		
			  
        tombol(status);           
        }
	
                                 
        
		
        function kosong(){
        $('#no_lpj').attr("value","/LPJ-BLUD/<?php echo $kdskpd;?>/<?php echo $tahun;?>");
        $("#nomor_urut").attr("value",'');
        $("#dd").datebox("setValue",'');
        $("#keterangan").attr("value",'');
        $("#nomor_urut").focus();
        $('#save').linkbutton('enable');
        st_12 = 'baru';
        lcstatus = 'tambah';
        $("#dd1").datebox("setValue",'');
        $("#dd2").datebox("setValue",'');
        
        document.getElementById("nomor_urut").disabled=false; 
       

         $('#save').linkbutton('enable');
         $('#del').linkbutton('enable');
         $('#sav').linkbutton('enable');
         $('#del').linkbutton('enable');
         $('#load').linkbutton('enable');
         $('#load_kosong').linkbutton('enable'); 
;        load_data_b('2');

        }

		
    function getRowIndex(target){  
			var tr = $(target).closest('tr.datagrid-row');  
			return parseInt(tr.attr('datagrid-row-index'));  
		} 
       
    
    function cetak(){
        var nom=document.getElementById("no_spp").value;
        $("#dialog-modal").dialog('open');
    } 
    
    
    function keluar(){
        $("#dialog-modal").dialog('close');
    } 
    
    
    function keluar_no(){
        $("#dialog-modal-tr").dialog('close');
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
    function cari(){
     var kriteria = document.getElementById("txtcari").value; 
        $(function(){ 
            $('#spp').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/tukd/load_lpj',
         queryParams:({cari:kriteria})
        });        
     });
    }
    
     
    function section1(){
         $(document).ready(function(){    
             $('#section1').click();
         });
     }
     
    
    function section4(){
         $(document).ready(function(){    
             $('#section4').click();                                               
         });
     }
     
     
     function section5(){
         $(document).ready(function(){    
             $("#dialog-modal-tr").click();                                               
         });
     }
     
    function tambah_no(){
        judul = 'Input Data No Transaksi';
        $("#dialog-modal-tr").dialog({ title: judul });
        $("#dialog-modal-tr").dialog('open');
        
        document.getElementById("no_spp").focus();
        
        if ( st_12 == 'baru' ){
        $("#no1").attr("value",'');
        $("#no2").attr("value",'');
        $("#no3").attr("value",'');
        $("#no4").attr("value",'');
        $("#no5").attr("value",'');
        }
     }
     
     function tambah_no2(){
        judul = 'Input Data No Transaksi';
        $("#dialog-modal-tr").dialog({ title: judul });
        $("#dialog-modal-tr").dialog('open');
        document.getElementById("no_spp").focus();
        
        if ( st_12 == 'baru' ){
        $("#no1").attr("value",'');
        $("#no2").attr("value",'');
        $("#no3").attr("value",'');
        $("#no4").attr("value",'');
        $("#no5").attr("value",'');
        }
     } 
     
     
     function simpan(){        

        var digit     = $("#nomor_urut").val().length;
        var nlpj_urut = document.getElementById('nomor_urut').value;
        var nlpjx     = document.getElementById('no_lpj').value;
        var nlpj      = nlpj_urut+nlpjx;
        var b         = $('#dd').datebox('getValue');  
        var c         = $('#dd1').datebox('getValue');
        var d         = $('#dd2').datebox('getValue');
        var nket      = document.getElementById('keterangan').value;
		
		
		if(nlpj_urut==""){
        		alert("No LPJ Masih Kosong!");
        		return;
		}
    if(digit < 5){
            alert('Nomor Urut Harus 5 Digit')
            document.getElementById('nomor_urut').focus();
            return;
    }
		
		if(b==""){
      		alert("Tanggal LPJ Masih Kosong!");
      		return;
		}
		
		if(nket==""){
      		alert("Keterangan LPJ Masih Kosong!");
      		return;
		}
		
		
		
		if(c==""){
		alert("Tanggal Transaksi Awal Masih Kosong!");
		return;
		}
		
		if(d==""){
		alert("Tanggal Transaksi Akhir Masih Kosong!");
		return;
		}
		
		$('#dg1').datagrid('selectAll');
        var rows = $('#dg1').datagrid('getSelections');
		if(rows.length < 1){
		alert("Detail LPJ Masih Kosong!");
		return;
		}
		

	
        //alert (c+"-"+d);
 if ( lcstatus=='tambah' ) {

 $.ajax({url: '<?php echo base_url(); ?>index.php/tukd_blud/cek_lpj',   
         type: "POST",
         dataType:'json',                             
         data:({nlpj:nlpj}),	
         success:function(data)				 
				 {
				      
            if (data.jml >0) {
                    alert('Data Dengan No LPJ '+nlpj +' Sudah Ada Ganti Dengan Yang Lain...!!!');
                    return;
            
            }else{  

                  $('#dg1').datagrid('selectAll');
                  var rows = $('#dg1').datagrid('getSelections');

                    for(var i=0;i<rows.length;i++){            
                        
                        cidx      = rows[i].idx;
                        cnobukti1 = rows[i].no_bukti;
                        ckdgiat   = rows[i].kdkegiatan;
                        cnmgiat   = rows[i].nmkegiatan;
                        ckdrek    = rows[i].kdrek5;
                        cnmrek    = rows[i].nmrek5;
                        cnilai    = angka(rows[i].nilai1);
                        no        = i + 1 ;      
                        
                         $(document).ready(function(){      
                         $.ajax({
                         type     : 'POST',
                         url      : "<?php  echo base_url(); ?>index.php/tukd_blud/simpan_lpj",
                         data     : ({nlpj:nlpj,no_bukti1:cnobukti1,tgllpj:b,ket:nket,cnkdgiat:ckdgiat,cnkdrek:ckdrek,tglawal:c,tglakhir:d,nilai:cnilai}),
                         dataType : "json",
                           success  : function(data){
                                  status = data;
                           }
                         
                         });
                         }); 
                    }


                    if (status=='0'){
                         bar_error("Gagal Menyimpan Data", "Failed");
                        //alert('Gagal Simpan..!!');
                        return;
                    } else {
                         bar("Nomor Transaksi dengan No Bukti : " +nlpj + " Tersimpan.","Your file has been Saved.");
                      //  alert('Data Tersimpan...!!!');
                        lcstatus = 'edit';
                        section4();
                        return;
                    }
               
						
                $('#dg1').edatagrid('unselectAll');
		        }
        }
    });


 } else {
        
         var tny = confirm('Yakin Ingin Update Data LPJ No :  '+nlpj+'  ..?');
        
        if ( tny == true ) {
            
       var nlpj_urut = document.getElementById('nomor_urut').value;
       var nlpjx     = document.getElementById('no_lpj').value;
       var nlpj      = nlpj_urut+nlpjx;
       var b         = $('#dd').datebox('getValue');  
       var nket      = document.getElementById('keterangan').value;
		
        $('#dg1').datagrid('selectAll');
        var rows = $('#dg1').datagrid('getSelections');
        
        for(var i=0;i<rows.length;i++){            
            
            cidx      = rows[i].idx;
            cnobukti1 = rows[i].no_bukti;
            ckdgiat   = rows[i].kdkegiatan;
            cnmgiat   = rows[i].nmkegiatan;
            ckdrek    = rows[i].kdrek5;
            cnmrek    = rows[i].nmrek5;
            cnilai    = angka(rows[i].nilai1);
                       
            no        = i + 1 ;      
            
            $(document).ready(function(){      
            $.ajax({
            type     : 'POST',
            url      : "<?php  echo base_url(); ?>index.php/tukd_blud/update_lpj",
            data     : ({nlpj:nlpj,no_bukti1:cnobukti1,tgllpj:b,ket:nket,cnkdgiat:ckdgiat,cnkdrek:ckdrek,tglawal:c,tglakhir:d,nilai:cnilai}),
            dataType : "json",
			
			             success  : function(data){
                         status = data;


                    }

        });
        });
        }
		

            if (status=='0'){
                 // alert('Gagal Update..!!');
                 bar_error("Gagal Update", "Failed");
                  return;
            } else {
                  //alert('Data Update...!!!');
                  bar("Nomor Transaksi dengan No Bukti : " +nlpj + " Berhasil Update.","Your file has been Saved.");
                  lcstatus = 'edit';
                  section1();
                  return;
            }
               
						
        $('#dg1').edatagrid('unselectAll');

        }
       }
    }
    
    
    
    
    

        
    
    function kembali(){
        $('#kem').click();
    }                
    
    
     function load_sum_lpj(){          
        
        $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd_blud/load_sum_lpj",
            data:({lpj:nomer}),
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){

                    $("#rektotal").attr('value',number_format(n['cjumlah'], "2", ".", "," ));
                });
            }
         });
        });
    }
    
    
    function load_sum_tran(){                
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({no_bukti:no_bukti}),
            url:"<?php echo base_url(); ?>index.php/tukd/load_sum_tran",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    //$("#rektotal").attr("value",n['rektotal']);
                    //$("#rektotal1").attr("value",n['rektotal1']);
                    $("#rektotal").attr('value',number_format(n['rektotal'],2,'.',','));
                    $("#rektotal1").attr('value',number_format(n['rektotal'],2,'.',','));

                });
            }
         });
        });
    }
   
   
    function tombol(st){

    if (st=='1') {
        console.log(st);
         $('#sav').linkbutton('enable');
         $('#del').linkbutton('enable');
        $('#load').linkbutton('disable');
        $('#load_kosong').linkbutton('disable'); 
        
     } else {
         $('#save').linkbutton('enable');
         $('#del').linkbutton('enable');
         $('#sav').linkbutton('enable');
         $('#dele').linkbutton('enable');
         $('#load').linkbutton('enable');
         $('#load_kosong').linkbutton('enable'); 
         
     }
    }	
    
        
    function openWindow(url)
    {
        var vnospp  =  $("#cspp").combogrid("getValue");
         
		        lc  =  "?nomerspp="+vnospp+"&kdskpd="+kode+"&jnsspp="+jns ;
        window.open(url+lc,'_blank');
        window.focus();
    }
    

    function detail_trans_3(nolpj){

     $(function(){
     $('#dg1').edatagrid({
               url: '<?php echo base_url(); ?>/index.php/tukd_blud/select_data1_lpj',
               queryParams:({ lpj:nolpj }),
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
                     {field:'no_bukti',
                     title:'No Bukti',
                     width:110,
                     align:'left'
                     },                                          
                     {field:'kdkegiatan',
                     title:'Kegiatan',
                     width:140,
                     align:'left'
                     },
                     {field:'kdrek5',
                     title:'Rekening',
                     width:80,
                     align:'left'
                     },
                     {field:'nmrek5',
                     title:'Nama Rekening',
                     width:280
                     },
                     {field:'nilai1',
                     title:'Nilai',
                     width:110,
                     align:'right'
                     },
                    {field:'hapus',title:'',width:35,align:"center"
                    }
				]]	
			});
		});
        }
        

        
 
    
    function hapus_detail(){
        
        var a          = document.getElementById('no_lpj').value;
        var rows       = $('#dg1').edatagrid('getSelected');
        var ctotal_lpj = document.getElementById('rektotal').value;
        
        bbukti      = rows.no_bukti;
        bkdrek      = rows.kdrek5;
        bkdkegiatan = rows.kdkegiatan;
        bnilai      = rows.nilai1;
        ctotal_lpj  = angka(ctotal_lpj) - angka(bnilai) ;
        
        var idx = $('#dg1').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, No Bukti :  '+bbukti+'  Rekening :  '+bkdrek+'  Nilai :  '+bnilai+' ?');
        
        if ( tny == true ) {
            
            $('#rektotal').attr('value',number_format(ctotal_lpj,2,'.',','));
            $('#dg1').datagrid('deleteRow',idx);     
            $('#dg1').datagrid('unselectAll');
              
             var urll = '<?php echo base_url(); ?>index.php/tukd/dsimpan_lpj';
             $(document).ready(function(){
             $.post(urll,({cnolpj:a,cnobukti:bbukti}),function(data){
             status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    return;
                } else {
                    alert('Data Telah Terhapus..!!');
                    return;
                }
             });
             });    
        }     
    }
    
  function hhapus(){				
           var nlpj_urut = document.getElementById('nomor_urut').value;
           var nlpjx     = document.getElementById('no_lpj').value;
           var lpj      = nlpj_urut+nlpjx;              
           var urll= '<?php echo base_url(); ?>/index.php/tukd_blud/hhapuslpj';             			    
           if (spp !=''){
                var del=confirm('Anda yakin akan menghapus LPJ '+lpj+'  ?');
                 if  (del==true){
                     $(document).ready(function(){
                         $.post(urll,({no:lpj}),function(data){
                              status = data;                       
                         });
                     });				
                 }
           } 
	}
  
    function hapus_detail_grid(){
        
        var a          = document.getElementById('no_lpj').value;
        var rows       = $('#dg1').edatagrid('getSelected');
        var ctotal_lpj = document.getElementById('rektotal').value;
        
        bbukti      = rows.no_bukti;
        bkdrek      = rows.kdrek5;
        bkdkegiatan = rows.kdkegiatan;
        bnilai      = rows.nilai1;
        ctotal_lpj  = angka(ctotal_lpj) - angka(bnilai) ;
        
        var idx = $('#dg1').edatagrid('getRowIndex',rows);
        var tny = confirm('Yakin Ingin Menghapus Data, No Bukti :  '+bbukti+'  Rekening :  '+bkdrek+'  Nilai :  '+bnilai+' ?');
        
        if ( tny == true ) {
            
            $('#rektotal').attr('value',number_format(ctotal_lpj,2,'.',','));
            $('#dg1').datagrid('deleteRow',idx);     
            $('#dg1').datagrid('unselectAll');
          
        }     
    }

//doni star -->
function load_data_b(jload) {
//doni end -->	 
        var dtgl1        = $('#dd1').datebox('getValue') ;
        var dtgl2        = $('#dd2').datebox('getValue') ;
        var ntotal_trans = document.getElementById('rektotal').value ; 
            ntotal_trans = angka(ntotal_trans) ;
        
 //doni star -->      
        $(function(){ 
            $('#dg1').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_data_transaksi_lpj',
         queryParams:({tgl1:dtgl1,tgl2:dtgl2,load:jload})
        });        
     });
	 
	 jumlahtotal(jload);
    }
//doni end -->   
//    function load_data(jload) {
//doni star -->

	  function opt(val){
        jnsbeban = val; 	
		  $('#dg1').edatagrid('reload');
		}
function load_data(jload) {
//doni end -->	 
        var jnsbeban     ='10';
        var dtgl1        = $('#dd1').datebox('getValue') ;
        var dtgl2        = $('#dd2').datebox('getValue') ;
        var ntotal_trans = document.getElementById('rektotal').value ; 
            ntotal_trans = angka(ntotal_trans) ;
        
		   
        if ( dtgl1 == '' ) {
           alert('Isi Tanggal Awal Terlebih Dahulu...!!!'); 
           document.getElementById('dd1').focus() ;
           return;
           }       
        if ( dtgl2 == '' ) {
           alert('Isi Tanggal S/D Terlebih Dahulu...!!!'); 
           document.getElementById('dd2').focus() ;
           return;
           }
		
 //doni star -->      
        $(function(){ 
            $('#dg1').edatagrid({
	       url: '<?php echo base_url(); ?>/index.php/tukd_blud/load_data_transaksi_lpj',
         queryParams:({tgl1:dtgl1,tgl2:dtgl2,load:jload,beban:jnsbeban})
        });        
     });
	 
	 jumlahtotal(jload,jnsbeban);

    }
function jumlahtotal(load,beban){
		   var dtgl1        = $('#dd1').datebox('getValue') ;
        var dtgl2        = $('#dd2').datebox('getValue') ;
		
		$.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php/tukd_blud/load_data_transaksi_jum',
                data: ({tgl1:dtgl1,tgl2:dtgl2,jload:load,jbeban:beban}),
                dataType:"json",
                success: function (data) {
		
				$("#rektotal").attr("value",number_format(data.total, "2", ".", "," ));
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
<div id="accordion" style="width:940px;height:780px;" >
<h3><a href="#" id="section4" onclick="javascript:$('#spp').edatagrid('reload')">List LPJ </a></h3>
<div>
    <p align="right">  
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section1();kosong();">Tambah</a>               
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="spp" title="List LPJ" style="width:880px;height:450px;" >  
        </table>
    </p> 
</div>

<h3><a href="#" id="section1">Input LPJ</a></h3>

   <div  style="height: 350px;">
   <p id="p1" style="font-size: x-large;color: red;"></p>
   <p>


 
 
 <fieldset style="width:850px;height:650px;border-color:white;border-style:hidden;border-spacing:0;padding:0;">            

<table border='0' style="font-size:11px" >
 
  <tr>
     <td width='20%'>SKPD</td>
     <td><input name="dn" id="dn" readonly="true" style="width:100px"></input>&nbsp;&nbsp;&nbsp;<input name="nmskpd" id="nmskpd" readonly="true" style="width:350px"></input></td>
  </tr>

  <tr>
     <td  width  ='20%'>No LPJ</td>
     <td width   ='80%'>
     <input type ="text" name="nomor_urut" id="nomor_urut" onclick="javascript:select();" style="width:40px" />
     <input type ="text" name="no_lpj" id="no_lpj" readonly="true" onclick="javascript:select();" style="width:225px" />
     </td>
 </tr>
 
 
  <tr> 
   <td  width='20%'>Tanggal</td>
   <td  width="80%"><input id="dd" name="dd" type="text" style="width:95px" /></td>   

 </tr>


  <tr style="height:0px;">   
     <td colspan='0' >
  <td style="color: red; color: width:80%">*Untuk Keterangan Tidak Boleh Menggunakan Tanda Petik satu (') dan Tanda Petik dua(")      
        </td> 
         </td> 
   </tr>
  <tr>
   
      <td width='20%' >KETERANGAN</td>
     <td width='80%' ><textarea name="keterangan" id="keterangan" cols="100" rows="2" ></textarea></td>
  
  </tr>
  
     
 <tr style="height: 30px;">

                  
      
      <td colspan="4">
                  <div align="right">
                    <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();">Baru</a>
                    <a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true"  onclick="javascript:simpan();">Simpan</a>
                    <a id="del"class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hhapus();javascript:section4();">Hapus</a>
                    <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section4();">Kembali</a>
                  </div>
        </td>                
  </tr>

  
   <tr> 
  
     <td colspan='6' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Transaksi</td>  
  </tr>

  <tr style="height: 10px;">
     <td colspan='4' >
     
     
     
     <input id="dd1" name="dd1" type="text" style="width:95px" />&nbsp;S/D&nbsp;<input id="dd2" name="dd2" type="text" style="width:95px"/>
  &nbsp;&nbsp;&nbsp;&nbsp;<a id="load" style="width:70px" class="easyui-linkbutton" iconCls="icon-add" plain="true"  onclick="javascript:load_data('1');" >Tampil</a>

&nbsp;&nbsp;&nbsp;&nbsp;<a id="load_kosong" style="width:70px" class="easyui-linkbutton" iconCls="icon-remove" plain="true"  onclick="javascript:load_data_b('2');" >Kosong</a>
<!--doni end -->
</td>  
  </tr>


  </table>
   
       <table id="dg1" title="Input Detail LPJ" style="width:870%;height:300%;" >  
        </table>
  
        <table border='0' style="width:100%;height:5%;"> 
             <td width='34%'></td>
             <td width='35%'><input class="right" type="hidden" name="rektotal1" id="rektotal1"  style="width:140px" align="right" readonly="true" ></td>
             <td width='6%'><B>Total</B></td>
             <td width='25%'><input class="right" type="text" name="rektotal" id="rektotal"  style="width:260px" align="right" readonly="true" ></td>
        </table>

   </p>

</fieldset>     
</div>
</div>
</div> 

<?php $this->load->view('inc/open_dialog.php'); ?>

</body>
</html>