<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/shortcut.js"></script>
   
    <script type="text/javascript">
 
	var nl       = 0;
	var tnl      = 0;
	var idx      = 0;
	var tidx     = 0;
	var oldRek   = 0;
    var rek      = 0;
    var detIndex = 0;
    var kdrek    = '';
    var id       = 0;
    var status   = '0';
    var zfrek    = '';
    var zkdrek   = '';
    var status_apbd = '';
    var total_kas   = 0;
	var unit   = '';
	var sts_dana=''
    
    
    shortcut.add("ctrl+m", function() {
        detsimpan();
    });
    
    $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 450,
                width: 970,
                modal: true,
                autoOpen:false                
            });
            
            $("#dialog-modal-edit" ).dialog({
                height: 230,
                width: 970,
                modal: true,
                autoOpen:false                
            });
            get_skpd();
        });    
    
    $(document).ready(function(){

        $('#skpd').hide();
        $('#giat').hide();
    });
    
	
    $(function(){ 
           var mgiat = document.getElementById('giat').value;
           // var kokeg = $('#kdgiat').combogrid('getValue'); 
	       $('#dg').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/rka_blud/select_rka_ubah',
                 idField      : 'id',
                 toolbar      : "#toolbar",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
			 	onSelect:function(rowIndex,rowData){
                    alert('asdasd');
    				},
				columns:[[
	                {field:'id',
					 title:'id',
					 width:10,
                     hidden:true
					},
					{field:'kd_rek5',
					 title:'Rekening',
					 width:12,
					 align:'left'	
					},
					{field:'nm_rek5',
					 title:'Nama Rekening',
					 width:70
					},
                    {field:'nilai',
					 title:'Nilai Penyusunan',
					 width:30,
                     align:'right'
                     },
                     {field:'nilai_ubah',
					 title:'Nilai Perubahan',
					 width:30,
                     align:'right'
                     },
					 {field:'sumberdana',title:'Sumber Dana',width:20,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/redo.png" onclick="javascript:section5('+rec.kd_rek5+');" />';
                    }},
					 {field:'rinci',
					  title:'Detail',
					  width:10,
					  align:'center', 
					  formatter:function(value,rec){
							rek         = rec.kd_rek5;
							return ' <p onclick="javascript:section('+rec.kd_rek5+');">Rincian</p>';
						}
			 		}
					 
                    /*
                    ,
                    {field:'hapus',title:'Hapus',width:10,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus();" />';
                    }}
                    */
				]]
			});
             });
             
            $(function(){
            $('#rek5').combogrid({  
            panelWidth : 700,  
            idField    : 'kd_rek5',  
            textField  : 'kd_rek5',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka_blud/ambil_rekening5',  
            columns    : [[  
                {field:'kd_rek5',title:'Kode ',width:100},  
                {field:'nm_rek5',title:'Nama ',width:700}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdrek = rowData.kd_rek5;
                validate_rek();
            }  
            }); 
            });

            $(document).ready(function(){
                $("#jasa2").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan2',
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]]
                });
                $("#jasa3").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan3',
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]]
                });
                $("#jasa1").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan',    
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]]
                });
            });

            
        //    $(function(){
           
        

            
			
			         $(function(){
            $("#sdana_c").combogrid({
                panelWidth:700,
                idField   :'kd_sdana',
                textField :'kd_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]],
				onSelect:function(rowIndex,rowData){
					 $("#nmsdana_c").attr("value",rowData.nm_sdana.toUpperCase());
    			}
				
            });
            });
	
			
			
            $(function(){
            $("#sdana1").combogrid({
                panelWidth:700,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]]
            });
            });
            
            
            $(function(){
            $("#sdana2").combogrid({
                panelWidth:700,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]]
            });
            });
            
            
            $(function(){
            $("#sdana3").combogrid({
                panelWidth:700,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]]
            });
            });
			
		 	$(function(){
				 $('#kdgiat').combogrid({  
            panelWidth : 700,  
            idField    : 'kd_kegiatan',  
            textField  : 'kd_kegiatan',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka_blud/pgiat/'+'donibro',  
            columns    : [[  
                {field:'kd_kegiatan',title:'Kode SKPD',width:150},  
                {field:'nm_kegiatan',title:'Nama Kegiatan',width:650}    
            ]]
            }); 
			}); 
            
            
            $(function(){
            $("#sdana4").combogrid({
                panelWidth:700,
                idField   :'nm_sdana',
                textField :'nm_sdana',
                mode      :'remote',
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]]
            });
            });


            
	
        
        
        
        function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka_blud/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
			
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd.toUpperCase());
                                        $("#skpd").attr("value",data.kd_skpd);
        								kdskpd = data.kd_skpd;
                                        sta    = data.statu;
                                       // validate_giat();
									   validate_unit();
                                        tombol(sta);
                                        validate_rekening();
                                        $("#kdrek5").combogrid("disable");
										 $("#jasa1").combogrid("disable");
                                         $("#jasa2").combogrid("disable");
                                         $("#jasa3").combogrid("disable");
        							  }                                     
        	});
        }
        
        
        function cek_kas(){
            var xxgiat = document.getElementById('giat').value;
			var xxskpd = document.getElementById('skpd').value;
           // var xxkdrek5 = $('#kd_rek5').datagrid('getValue');
           // alert(xxgiat);
            total_kas = '0';
            $("#cek_kas").attr("value",'0');
            
            $.ajax({
               
               url       : '<?php echo base_url(); ?>/index.php/rka_blud/cek_kas',
               type      : 'POST',
               dataType  : 'json',
               data      : ({skpd:xxskpd,kegiatan:xxgiat}),
               success   : function(data) {
                
                  /*  $.each(data, function(i,n){
                        var nilai_kas = n['nilai'];
                        total_kas = total_kas + angka(nilai_kas) ;
                        $("#cek_kas").attr("value",total_kas);
                    });*/
               }
            });
        }
        
	
        
		  function validate_unit(){
	  	    $(function(){
            $('#unit').combogrid({  
            panelWidth : 700,  
            idField    : 'kd_unit',  
            textField  : 'kd_unit',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka_blud/ambil_unit',  
            columns    : [[  
                {field:'kd_unit',title:'Kode Unit',width:150},  
                {field:'nm_unit',title:'Nama Unit',width:650}    
            ]],
			
            onSelect:function(rowIndex,rowData){
		
				 $("#nmunit").attr("value",rowData.nm_unit.toUpperCase());
				 	unit = rowData.kd_unit;
			
				validate_giat();
            }
            }); 
            });
		}
		
        function validate_giat(){
	  	    $(function(){
            $('#kdgiat').combogrid({  
            panelWidth : 700,  
            idField    : 'kd_kegiatan',  
            textField  : 'kd_kegiatan',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka_blud/pgiat/'+kdskpd,  
            columns    : [[  
                {field:'kd_kegiatan',title:'Kode SKPD',width:150},  
                {field:'nm_kegiatan',title:'Nama Kegiatan',width:650}    
            ]],
			
            onSelect:function(rowIndex,rowData){
				
                 kegiatan = rowData.kd_kegiatan;
                 jns = rowData.jns_kegiatan;
                $("#nmgiat").attr("value",rowData.nm_kegiatan.toUpperCase());
                $("#giat").attr("value",rowData.kd_kegiatan);
                $("#jnskegi").attr("value",rowData.jns_kegiatan);
                validate_combo();
                if(jns == '52'){
                    d = 'Belanja';
                    i = '5';
                    ambil_rek5(i);
                    ambil_layanan(d);
                }else if(jns == '4'){
                    d = 'Pendapatan';
                    i = '4';
                    ambil_rek5(i);
                    ambil_layanan(d);
                }else{
                    d = '';
                    i = '';
                }
               
                $("#kdrek5").combogrid("disable");
				$("#jasa1").combogrid("disable");
                $("#kdrek5").combogrid("setValue",'');
                $("#sdana1").combogrid("setValue",'');
                $("#sdana2").combogrid("setValue",'');
                $("#sdana3").combogrid("setValue",'');
                $("#sdana4").combogrid("setValue",'');
                
                document.getElementById('nilairek').value   = 0;
                document.getElementById('nmrek5').value     = '';  
            }
            }); 
            });
		}

        function ambil_rek5(i){
            $("#dg").datagrid("unselectAll");
            $("#dg").datagrid("selectAll");
            var rows   = $("#dg").datagrid("getSelections");
            var jrows  = rows.length ;

            zfrek  = '';
            zkdrek = '';
            
            for (z=0;z<jrows;z++){
               zkdrek=rows[z].kd_rek5;                 
               if ( z == 0 ){
                   zfrek  = zkdrek ;
               } else {
                   zfrek  = zfrek+','+zkdrek ;
               }
            }          
            
            var jkegi = document.getElementById('jnskegi').value ;
            
            $('#kdrek5').combogrid({  
               panelWidth : 500,  
               idField    : 'kd_rek5',  
               textField  : 'kd_rek5',  
               mode       : 'remote',
               //url        : '<?php echo base_url(); ?>index.php/rka_blud/ambil_rekening5_all_ar_dn', 
               url        : '<?php  echo base_url(); ?>index.php/rka_blud/ambil_rekening5_all_dn',  
 
               queryParams: ({reknotin:zfrek,jns_kegi:jkegi,dika:i}),
               columns    : [[  
                   {field:'kd_rek5',title:'Kode Rekening',width:100},  
                   {field:'nm_rek5',title:'Nama Rekening',width:400}    
               ]],  
               onSelect:function(rowIndex,rowData){
                    kd_rek5 = rowData.kd_rek5;
                    $("#nmrek5").attr("value",rowData.nm_rek5.toUpperCase());
               },
               onLoadSuccess:function(data){
                    $("#nilairek").attr("value",0);
               }  
             });     
        }

         function ambil_layanan(d){
                // var k_giat = $('#kdgiat').combogrid('getValue');
                $("#jasa1").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan/'+d,    
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]],
                    onSelect:function(rowIndex,rowData){
                         $("#nmjasa1").attr("value",rowData.nm_layanan.toUpperCase());
                         var kd = rowData.kd_layanan;
                         ambil_layanan2(kd);
                         $("#jasa2").combogrid("enable");
                         $("#jasa2").combogrid("setValue",'');
                         $("#jasa3").combogrid("setValue",'');
                    }
                });
            }

          /*  function ambil_layanan_bel(){
                // var k_giat = $('#kdgiat').combogrid('getValue');
                $("#jasa1").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan_bel',    
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]],
                    onSelect:function(rowIndex,rowData){
                         //$("#nmjasa1").attr("value",rowData.nm_layanan.toUpperCase());
                         var kd = rowData.kd_layanan;
                         ambil_layanan2(kd);
                         $("#jasa2").combogrid("enable");
                         $("#jasa2").combogrid("setValue",'');
                         $("#jasa3").combogrid("setValue",'');
                    }
                });
            }*/
            function ambil_layanan2(kd){
                $("#jasa2").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan2/'+kd,
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]],
                    onSelect:function(rowIndex,rowData){
                         //$("#nmjasa2").attr("value",rowData.nm_layanan.toUpperCase());
                         var kd = rowData.kd_layanan;
                         ambil_layanan3(kd);
                         $("#jasa3").combogrid("enable");
                         $("#jasa3").combogrid("setValue",'');
                    }
                });
            }
            function ambil_layanan3(kd){
                $("#jasa3").combogrid({
                    panelWidth:500,
                    idField   :'kd_layanan',
                    textField :'nm_layanan',
                    mode      :'remote',
                    url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_layanan3/'+kd,
                    columns   : [[
                    {field:'kd_layanan',title:'Kode',width:100},
                    {field:'nm_layanan',title:'Nama Layanan',width:600}
                    ]],
                    onSelect:function(rowIndex,rowData){
                         //$("#nmjasa3").attr("value",rowData.nm_layanan.toUpperCase());
                    }
                });
            }
         function validate_sdana(){
			 $("#dg_dana").datagrid("unselectAll");
            $("#dg_dana").datagrid("selectAll");
            var rows   = $("#dg_dana").datagrid("getSelections");
            var jrows  = rows.length ;


            zfrek1  = '';
            zkdrek1 = '';
            
            for (z=0;z<jrows;z++){
               zkdrek1=rows[z].kd_sdana;                 
               if ( z == 0 ){
                   zfrek1  = zkdrek1 ;
               } else {
                   zfrek1  = zfrek1+','+zkdrek1 ;
               }
            }
		  }

            function ambil_dana(){
              $("#sdana_c").combogrid({
                panelWidth:700,
                idField   :'kd_sdana',
                textField :'kd_sdana',
                mode      :'remote',
            
                queryParams: ({notins:zfrek1}),
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana2',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]],
                onSelect:function(rowIndex,rowData){
                     $("#nmsdana_c").attr("value",rowData.nm_sdana.toUpperCase());
                }
                
            });
            
             $("#dg_dana").datagrid("unselectAll");
		 }


         function ambil_dana_bel(){
              $("#sdana_c").combogrid({
                panelWidth:700,
                idField   :'kd_sdana',
                textField :'kd_sdana',
                mode      :'remote',
            
                queryParams: ({notins:zfrek1}),
                url       : '<?php echo base_url(); ?>index.php/rka_blud/ambil_sdana2_bel',
                columns   : [[
                {field:'kd_sdana',title:'Kode',width:100},
                {field:'nm_sdana',title:'Sumber Dana',width:600}
                ]],
                onSelect:function(rowIndex,rowData){
                     $("#nmsdana_c").attr("value",rowData.nm_sdana.toUpperCase());
                }
                
            });
            
             $("#dg_dana").datagrid("unselectAll");
         }


        function detail_dana(kdrekk){
			var giat_dana = $("#kdgiat").combogrid('getValue');
			var unit_dana = $("#unit").combogrid('getValue');
			
		
			 $('#dg_dana').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/rka_blud/select_sdana_ubah'+'/'+kdskpd+'/'+giat_dana+'/'+unit_dana+'/'+kdrekk,
                 idField      : 'id',
                 toolbar      : "#toolbar",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
			 	onSelect:function(rowIndex,rowData){
						
						
    				},
				onClickRow:function(rowIndex,rowData){
					$("#sdana_c").combogrid("disable");
						document.getElementById('nilaisdana').disabled = true;
						
						$("#sdana_c").combogrid("setValue",rowData.kd_sdana);
					    document.getElementById('nmsdana_c').value = rowData.nm_sdana;
						document.getElementById('nilaisdana').value = rowData.nilai;
						document.getElementById('nilaisdana2').value = rowData.nilai;
                        document.getElementById('nilaisdanaubah').value = rowData.nilai_ubah;
                        document.getElementById('nilaisdanaubah2').value = rowData.nilai_ubah;
				},
				columns:[[
	                {field:'id',
					 title:'id',
					 width:10,
                     hidden:true
					},
					{field:'kd_sdana',
					 title:'Kode Sumber Dana',
					 width:15,
					 align:'left'	
					},
					{field:'nm_sdana',
					 title:'Nama Sumber Dana',
					 width:50
					},
					{field:'nilai',
					 title:'Nilai Penyusunan',
					 width:25
					},
					 {field:'nilai_ubah',
                     title:'Nilai Perubahan',
                     width:25
                    }
                  
				]]
			});
			
			
		}
        function validate_rekening(){
            
            $("#dg").datagrid("unselectAll");
            $("#dg").datagrid("selectAll");
            var rows   = $("#dg").datagrid("getSelections");
            var jrows  = rows.length ;

            zfrek  = '';
            zkdrek = '';
            
            for (z=0;z<jrows;z++){
               zkdrek=rows[z].kd_rek5;                 
               if ( z == 0 ){
                   zfrek  = zkdrek ;
               } else {
                   zfrek  = zfrek+','+zkdrek ;
               }
            }          
            
            var jkegi = document.getElementById('jnskegi').value ;
            
            $('#kdrek5').combogrid({  
               panelWidth : 500,  
               idField    : 'kd_rek5',  
               textField  : 'kd_rek5',  
               mode       : 'remote',
               //url        : '<?php echo base_url(); ?>index.php/rka_blud/ambil_rekening5_all_ar_dn', 
               url        : '<?php  echo base_url(); ?>index.php/rka_blud/ambil_rekening5_all_dn',  
 
               queryParams: ({reknotin:zfrek,jns_kegi:jkegi}),
               columns    : [[  
                   {field:'kd_rek5',title:'Kode Rekening',width:100},  
                   {field:'nm_rek5',title:'Nama Rekening',width:400}    
               ]],  
               onSelect:function(rowIndex,rowData){
                    kd_rek5 = rowData.kd_rek5;
                    $("#nmrek5").attr("value",rowData.nm_rek5.toUpperCase());
               },
               onLoadSuccess:function(data){
                    $("#nilairek").attr("value",0);
               }  
             });     
        }
        

		
        function getSelections(idx){
			var ids = [];
			var rows = $('#dg').edatagrid('getSelections');
			for(var i=0;i<rows.length;i++){
				ids.push(rows[i].kd_rek5);
			}
			return ids.join(':');
		}

		
        function getSelections2(idx){
			var ids = [];
			var rows = $('#dg1').edatagrid('getSelections');
			for(var i=0;i<rows.length;i++){
				ids.push(rows[i].no_po);
			}
			return ids.join(':');
		}


		function getRowIndex(target){  
			var tr = $(target).closest('tr.datagrid-row');  
			return parseInt(tr.attr('datagrid-row-index'));  
		}  


        function simpan(baru,lama,nilai,sdana){		
    		var cgiat = document.getElementById('giat').value;
    		var cskpd = document.getElementById('skpd').value;
            
    		if (lama==''){
    			lama=baru;
    		}
    			$(function(){
    				$('#dg').edatagrid({
    				     url: '<?php echo base_url(); ?>/index.php/rka_blud/tsimpan/'+cskpd+'/'+cgiat+'/'+baru+'/'+lama+'/'+nilai+'/'+sdana,
    					 idField:'id',
    					 toolbar:"#toolbar",              
    					 rownumbers:"true", 
    					 fitColumns:"true",
    					 singleSelect:"true",
    				});
    			});
		}
        
                
        function validate_combo(){
			var cgiat = document.getElementById('giat').value;       
            $(function(){
			$('#dg').edatagrid({
				 url: '<?php echo base_url(); ?>/index.php/rka_blud/select_rka_ubah/'+cgiat+'/'+unit,
                 idField     : 'id',
                 toolbar     : "#toolbar",              
                 rownumbers  : "true", 
                 fitColumns  : "true",
                 singleSelect: "true",
				 showFooter  : true,
				 nowrap      : false,
				 onSelect:function(rowIndex,rowData){							
							  //alert('asdasd');
                              oldRek   = getSelections(getRowIndex(this));
                              vvkdrek  = rowData.kd_rek5;
                              vvnmrek  = rowData.nm_rek5;
                              vvnilai  = rowData.nilai;
                              vvsdana1 = rowData.sumber;
                              vvsdana2 = rowData.sumber2;
                              vvsdana3 = rowData.sumber3;
                              vvsdana4 = rowData.sumber4;
							  vvkd_layanan=rowData.kd_layanan;
							  vvnm_layanan=rowData.nm_layanan;
                               
							  $("#nilai_rek_tot").attr("value",vvnilai) ;							   
                              $("#nilairek").attr("value",vvnilai);
                              $("#nmrek5").attr("value",vvnmrek);
                              $("#kdrek5").combogrid("setValue",vvkdrek);
							  $("#jasa1").combogrid("setValue",vvkd_layanan);
							  $("#nmjasa1").attr("value",vvnm_layanan);
                              $("#sdana1").combogrid("setValue",vvsdana1);
                              $("#sdana2").combogrid("setValue",vvsdana2);
                              $("#sdana3").combogrid("setValue",vvsdana3);
                              $("#sdana4").combogrid("setValue",vvsdana4);
                              cek_kas();
						  },
				onLoadSuccess:function(data){
						   	load_sum_rek();		 
						  },
				columns:[[
	                {field:'id',
					 title:'id',
					 width:10,
                     hidden:true
                    },
					{field:'kd_rek5',
					 title:'Rekening',
					 width:12,
					 align:'left'	
					},
					{field:'nm_rek5',
					 title:'Nama Rekening',
					 width:70
					},
                    {field:'nilai',
					 title:'Nilai Penyusunan',
					 width:30,
                     align:'right'
                     },
                     {field:'nilai_ubah',
					 title:'Nilai Perubahan',
					 width:30,
                     align:'right'
                     },
					 {field:'sumberdana',title:'Sumber Dana',width:20,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/redo.png" onclick="javascript:section5('+rec.kd_rek5+');" />';
                    }},
					 {field:'rinci',
					  title:'Detail',
					  width:10,
					  align:'center', 
					  formatter:function(value,rec){
							rek         = rec.kd_rek5 ;
							return '<p onclick="javascript:section('+rec.kd_rek5+');">Rincian</p>';
					 }}
					  
                     /*
                     ,
                     {field:'hapus',title:'Hapus',width:10,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus();" />';
                     }}
                     */
				]]

			});
		});
        }

        function after_simpan_sdana(){
            $(function(){
        var unit = $("#unit").combogrid('getValue');
        var cgiat = $("#kdgiat").combogrid('getValue');
            $('#dg').edatagrid({
                 url: '<?php echo base_url(); ?>/index.php/rka_blud/select_rka/'+cgiat+'/'+unit,
                 idField     : 'id',
                 toolbar     : "#toolbar",              
                 rownumbers  : "true", 
                 fitColumns  : "true",
                 singleSelect: "true",
                 showFooter  : true,
                 nowrap      : false,
                 onSelect:function(rowIndex,rowData){                           
                              //alert('asdasd');
                              oldRek   = getSelections(getRowIndex(this));
                              vvkdrek  = rowData.kd_rek5;
                              vvnmrek  = rowData.nm_rek5;
                              vvnilai  = rowData.nilai;
                              vvsdana1 = rowData.sumber;
                              vvsdana2 = rowData.sumber2;
                              vvsdana3 = rowData.sumber3;
                              vvsdana4 = rowData.sumber4;
                              vvkd_layanan=rowData.kd_layanan;
                              vvnm_layanan=rowData.nm_layanan;
                               
                              $("#nilai_rek_tot").attr("value",vvnilai) ;                              
                              $("#nilairek").attr("value",vvnilai);
                              $("#nmrek5").attr("value",vvnmrek);
                              $("#kdrek5").combogrid("setValue",vvkdrek);
                              $("#jasa1").combogrid("setValue",vvkd_layanan);
                              $("#nmjasa1").attr("value",vvnm_layanan);
                              $("#sdana1").combogrid("setValue",vvsdana1);
                              $("#sdana2").combogrid("setValue",vvsdana2);
                              $("#sdana3").combogrid("setValue",vvsdana3);
                              $("#sdana4").combogrid("setValue",vvsdana4);
                              cek_kas();
                          },
                onLoadSuccess:function(data){
                            load_sum_rek();      
                          },
                columns:[[
                    {field:'id',
                     title:'id',
                     width:10,
                     hidden:true
                    },
                    {field:'kd_rek5',
                     title:'Rekening',
                     width:12,
                     align:'left'   
                    },
                    {field:'nm_rek5',
                     title:'Nama Rekening',
                     width:78
                    },
                    {field:'nilai',
                     title:'Nilai Rekening',
                     width:30,
                     align:'right'
                     },
                     {field:'sumberdana',title:'Sumber Dana',width:20,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/redo.png" onclick="javascript:section5('+rec.kd_rek5+');" />';
                    }},
                     {field:'rinci',
                      title:'Detail',
                      width:10,
                      align:'center', 
                      formatter:function(value,rec){
                            rek         = rec.kd_rek5 ;
                            return '<p onclick="javascript:section('+rec.kd_rek5+');">Rincian</p>';
                     }}
                      
                     /*
                     ,
                     {field:'hapus',title:'Hapus',width:10,align:"center",
                     formatter:function(value,rec){ 
                     return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus();" />';
                     }}
                     */
                ]]
            });
            });
        }
        
        
        function validate_rek(){
            $(function(){
			$('#dg_rek').edatagrid({
				url          :  '<?php echo base_url(); ?>/index.php/rka_blud/ld_rek/'+kegiatan+'/'+kdrek,
                idField      : 'id',                  
                rownumbers   : "true", 
                fitColumns   : "true",
                singleSelect : "true",
				showFooter   : true,
				nowrap       : false,				 
				columns:[[
	                {field:'ck',
					 title:'ck',
					 checkbox:true,
					 hidden:true},
					{field:'kd_rek5',
					 title:'Kode Rekening',
					 width:20,
					 align:'left'
					},
					{field:'nm_rek5',
					 title:'Nama Rekening',
					 width:80
					}
				]],
                    onClickRow:function(rowIndex, rowData){                                
                    rk    = rowData.kd_rek5;
                    nmrk  = rowData.nm_rek5;
                    nilai = 0;
                    sdana = 'PAD';                    
                    simpan(rk,oldRek,nilai,sdana);   
					}				 		

			});
		});    
        }
        
        
		function hapus(){
		  
                var nil_cek_kas = document.getElementById('cek_kas').value ;
                
                if ( nil_cek_kas > 0 ) {
                    alert('Rka Sudah di Buat Anggaran Kas...!!!, Hapus Dulu Anggaran Kas nya...!!!');
                    exit();
                }
                
                
                if ( status_apbd=='1' ){
                    alert("APBD TELAH DI SAHKAN...!!!  DATA TIDAK DAPAT DI HAPUS...!!!");
                    exit();
                }
                 var  unit    = $('#unit').combogrid('getValue'); 
                 var  cgiat    = $('#kdgiat').combogrid('getValue');
                 console.log(unit);           
				//var cgiat = document.getElementById('giat').value;
				var cskpd = document.getElementById('skpd').value;
				
				var rek   = getSelections();
				if (rek !=''){
				var del=confirm('Anda yakin akan menghapus rekening '+rek+' ?');
				if  (del==true){
					$(function(){
						$('#dg').edatagrid({
							 url: '<?php echo base_url(); ?>/index.php/rka_blud/thapus/'+cskpd+'/'+cgiat+'/'+rek+'/'+unit,
							 idField:'id',
							 toolbar:"#toolbar",              
							 rownumbers:"true", 
							 fitColumns:"true",
							 singleSelect:"true"
						});
					});
                    
                    $("#kdrek5").combogrid("disable");
					$("#jasa1").combogrid("disable");
                    $("#jasa2").combogrid("disable");
                    $("#jasa3").combogrid("disable");
                    $("#kdrek5").combogrid("setValue",'');
                    $("#nilairek").attr("value",0);
                    document.getElementById('nmrek5').value = '';
                    document.getElementById('nmjasa1').value = '';
                    document.getElementById('nmjasa2').value = '';
                    document.getElementById('nmjasa3').value = '';
                    $("#jasa1").combogrid("setValue",'');
                    $("#jasa2").combogrid("setValue",'');
                    $("#jasa3").combogrid("setValue",'');
                    $("#sdana1").combogrid("setValue",'');
                    $("#sdana2").combogrid("setValue",'');
                    $("#sdana3").combogrid("setValue",'');
                    $("#sdana4").combogrid("setValue",'');
                    
                    //$("#dg").datagrid("reload");
                    zfrek  = '';
                    zkdrek = '';
  				
				}
				}
		}


		function hapus_rinci(){
		  
                var cgiat = document.getElementById('giat').value;
        		var cskpd = document.getElementById('skpd').value;
                var crek  = document.getElementById('reke').value;
                var norka = cskpd+'.'+cgiat+'.'+crek;
                var nopo  = document.getElementById('nopo').value;
                var urai  = document.getElementById('uraian').value;
                
                var total_awal = angka(document.getElementById('rektotal_rinci').value) ;
                
                var rows        = $('#dg1').edatagrid('getSelected');
                    urai        = rows.uraian ;
                var total_rinci = angka(rows.total) ;

                var cfm   = confirm("Hapus Uraian "+urai+" ?") ;
                
                if ( cfm == true ){

                    var idx   = $('#dg1').edatagrid('getRowIndex',rows);
                    $('#dg1').datagrid('deleteRow',idx);     
                    $('#dg1').datagrid('unselectAll');
                    
                    var total_rincian = total_awal - total_rinci ;
                    $("#rektotal_rinci").attr("value",number_format(total_rincian,"2",'.',','));
                    
                    
                    $(document).ready(function(){
                        $.ajax({
                               type     : 'POST',
                               dataType : 'json',
                               data     : ({vnorka:norka,vnopo:nopo}),
                               url      : '<?php echo base_url(); ?>index.php/rka_blud/thapus_rinci_ar',
                               success  : function(data){
                                        st12=data;
                                        if ( st12=='0'){
                                            alert('Gagal Hapus...!!!');
                                        } else {
                                            section(crek);
                                            alert("Data Telah Terhapus...!!!");
                                        }
                               }    
                        });
                    });
                    
                }
		}
		
		
		
		function simpan_rincian(idx,uraian,volum1,satuan1,harga1,volum2,satuan2,volum3,satuan3,rk){		
		var cgiat = document.getElementById('giat').value;
		var cskpd = document.getElementById('skpd').value;

		if (volum1==""){
			volum1=0;
		}

		if (volum2==""){
			volum2=0;
		}
		if (volum3==""){
			volum3=0;
		}
        
        if (harga1==""){
			harga1=0;
		}

		if (satuan1==""){
			satuan1="12345678987654321";
		}
		if (satuan2==""){
			satuan2="12345678987654321";
		}
		if (satuan3==""){
			satuan3="12345678987654321";
		}
            
            $(document).ready(function(){
            $.ajax({
                type     : "POST",       
                dataType : 'json',         
                data     : ({skpd:cskpd,giat:cgiat,rek:rk,id:idx,uraian:uraian,volum1:volum1,satuan1:satuan1,harga1:harga1,volum2:volum2,satuan2:satuan2,volum3:volum3,satuan3:satuan3}),
                url      : '<?php echo base_url(); ?>/index.php/rka_blud/tsimpan_rinci',
                success  : function(data){
                    status = data.pesan;
                    load_sum_rek_rinci(rk);
                    $('#dg1').edatagrid('reload');                                                               
                }
            });
           });
		
		}
        
        function detsimpan(){
            
         $('#dg1').datagrid('unselectAll');    

        var cgiat = document.getElementById('giat').value;
		var cskpd = document.getElementById('skpd').value;
		var unit = $("#unit").combogrid('getValue');
        var crek =  document.getElementById('reke').value;
        var norka  = cskpd+'.'+cgiat+'.'+crek;
		
		 var total_po = angka(document.getElementById('rektotal_rinci').value) ;
        
        
		    if ( unit=='' ){
            alert("Pilih Unit Terlebih Dahulu...!!!");
            exit();
        }
		if ( cgiat=='' ){
            alert("Pilih Kegiatan Terlebih Dahulu...!!!");
            exit();
        }
        
        if ( crek=='' ){
            alert("Pilih Rekening Terlebih Dahulu...!!!");
            exit();
        }
        
        
        $('#dg1').datagrid('selectAll');
        var rows = $('#dg1').datagrid('getSelections');
        
        if ( rows.length == 0 ) {
            $(document).ready(function(){
            $.ajax({
                    type     : 'POST',
                    dataType : 'json',
                    data     : ({vnorka:norka,units:unit}),
                    url      : '<?php echo base_url(); ?>index.php/rka_blud/thapus_rinci_ar_all',
                    success  : function(data){
                               }    
                        });
                    });
            alert("Data Tersimpan...!!!");
            exit();
        }       
         
        for(var i=0;i<rows.length;i++){     
            curaian   = rows[i].uraian;
            cvolume1  = rows[i].volume1;
            csatuan1  = rows[i].satuan1;
            cvolume2  = rows[i].volume2;
            csatuan2  = rows[i].satuan2;
            cvolume3  = rows[i].volume3;
            cvolume   = rows[i].volume;
            csatuan3  = rows[i].satuan3;
            charga1   = angka(rows[i].harga1);
            ctotal    = angka(rows[i].total);            
            no        = i + 1 ;

			
            
            if ( i > 0 ) {
                csql = csql+","+"('"+no+"','"+norka+"','"+curaian+"','"+cvolume1+"','"+csatuan1+"','"+charga1+"','"+ctotal+"','"+cvolume1+"','"+csatuan1+"','"+charga1+"','"+ctotal+"','"+cvolume2+"','"+csatuan2+"','"+cvolume2+"','"+csatuan2+"','"+cvolume3+"','"+csatuan3+"','"+cvolume3+"','"+csatuan3+"','"+cvolume+"','"+cvolume+"','"+unit+"')";
            } else {
                csql = "values('"+no+"','"+norka+"','"+curaian+"','"+cvolume1+"','"+csatuan1+"','"+charga1+"','"+ctotal+"','"+cvolume1+"','"+csatuan1+"','"+charga1+"','"+ctotal+"','"+cvolume2+"','"+csatuan2+"','"+cvolume2+"','"+csatuan2+"','"+cvolume3+"','"+csatuan3+"','"+cvolume3+"','"+csatuan3+"','"+cvolume+"','"+cvolume+"','"+unit+"')";                                            
            } 

        }
		
	
        $(document).ready(function(){
                $.ajax({
                    type     : "POST",   
                    dataType : 'json',                 
                    data     : ({no:norka,sql:csql,skpd:cskpd,giat:cgiat,total_po_dn:total_po,kdrek:crek,units:unit}),
                    url      : '<?php echo base_url(); ?>/index.php/rka_blud/tsimpan_rinci_dn',
                    success  : function(data){                        
                        status_cek = data.pesan; 
				
                         if (status_cek=='1'){               
                            alert('Data Berhasil Tersimpan...!!!');
							 $('#dg1').edatagrid('reload');
					} else if (status_cek=='2'){ 
                            alert('Gagal Tersimpan, Total PO melebihi Nilai Rekening...!!!');
                        
                        } else if (status_cek=='0'){
                            alert('Data Gagal Tersimpan...!!!');
                        }                                              
                    }
                });
                });  
         
        $('#dg1').edatagrid('unselectAll');
       $("#jasa1").combogrid("setValue",'');
        $("#jasa2").combogrid("setValue",'');
        $("#jasa3").combogrid("setValue",'');
        $("#kdrek5").combogrid("setValue",'');
        document.getElementById('nmrek5').value  = '';
        document.getElementById('nmjasa1').value = '';
        document.getElementById('nmjasa2').value = '';
        document.getElementById('nmjasa3').value = '';
    }
		
   
        
        
            
        $(function(){
       	    var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
			$('#dg1').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/rka_blud/rka_rinci',
                 idField      : 'id',
                 toolbar      : "#toolbar1",              
                 rownumbers   : "true", 
                 fitColumns   : false,
                 singleSelect : "true",
				 onAfterEdit  : function(rowIndex, rowData, changes){								
							    },
				 onSelect:function(rowIndex, rowData, changes){							
							  detIndex=rowIndex;
                              po=rowData.no_po;
                              $("#noid").attr("value",detIndex);
                              $("#nopo").attr("value",po);	
                              
						  },
				columns:[[
					{field:'id',
					 title:'id',
					 width:20,
                     hidden:true
					},
                    {field:'no_po',
					 title:'no',
					 width:20,
                     hidden:true
					},
					{field:'uraian',
					 title:'Uraian',
					 width:260
					},
                    {field:'volume1',
					 title:'V 1',
					 width:35,
                     align:'right'
                     },
                    {field:'satuan1',
					 title:'S 1',
					 width:35,
                     align:'center'
                     },
                    {field:'volume2',
					 title:'V 2',
					 width:35,
                     align:'right'
                     },
                    {field:'satuan2',
					 title:'S 2',
					 width:35,
                     align:'center'
                     },
                    {field:'volume3',
					 title:'V 3',
					 width:35,
                     align:'right'
                     },
                    {field:'satuan3',
					 title:'S 3',
					 width:35,
                     align:'center'
                     },
                    {field:'volume',
					 title:'T-VL',
					 width:35,
                     align:'center'
                     },
                    {field:'harga1',
					 title:'Harga',
					 width:90,
                     align:'right'
                     },
                    {field:'total',
					 title:'Total',
					 width:130,
                     align:'right'
                     }
				]]	
			});
		});
        

        $(document).ready(function() {
            $("#accordion").accordion();
        });
  
        function section5(kdrek){
			$('#section5').click();
			detail_dana(kdrek);
			
		}
        function section(kdrek){
            
		    var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
			
			var a     = kdrek ;
            
            if ( mgiat=='' ){
                alert("Pilih Kegiatan Terlebih Dahulu...!!!");
            }
            
            if ( a=='' ){
                alert("Pilih Rekening Terlebih Dahulu...!!!");
            }
            

            $(document).ready(function(){
 			    $("#reke").attr("value",a);            
				$('#section2').click();
                $(function(){
        			$('#dg1').edatagrid({
       				     url          : '<?php echo base_url(); ?>/index.php/rka_blud/rka_rinci/'+mskpd+'/'+mgiat+'/'+kdrek+'/'+unit,
                         idField      : 'id',
                         toolbar      : "#toolbar1",              
                         rownumbers   : "true", 
                         fitColumns   : false,
						 title        : a,
                         singleSelect : "true",
						 onSelect     : function(rowIndex,rowData){
                                       
                                      
                                       $("#uraian_edit").attr("value",rowData.uraian) ;
                                       $("#vol1_edit").attr("value",rowData.volume1) ;
                                       $("#vol2_edit").attr("value",rowData.volume2) ;
                                       $("#vol3_edit").attr("value",rowData.volume3) ;
                                       $("#sat1_edit").attr("value",rowData.satuan1) ;
                                       $("#sat2_edit").attr("value",rowData.satuan2) ;
                                       $("#sat3_edit").attr("value",rowData.satuan3) ;
                                       $("#harga_edit").attr("value",rowData.harga1) ;
                                       $("#nopo_edit").attr("value",rowData.no_po) ;
                                       
                                       var rows_e     = $('#dg1').edatagrid('getSelected');
                                       var idx_ins_e  = $('#dg1').edatagrid('getRowIndex',rows_e);
                                       
                                       
                                       var vol1_e  = rowData.volume1 ;
                                       var vol2_e  = rowData.volume2 ;
                                       var vol3_e  = rowData.volume3 ;
                                       var harga_e = rowData.harga1 ;
                                       
                                       if ( vol1_e == '' || vol1_e == 0 ){
                                            var vvol1_e = 1 ;
                                       } else {
                                            var vvol1_e = vol1_e ;
                                       }
                                       

                                       if ( vol2_e == '' || vol2_e == 0){
                                            var vvol2_e = 1 ;
                                       } else {
                                            var vvol2_e = vol2_e ;
                                       }
                                       

                                       if ( vol3_e == '' || vol3_e == 0 ){
                                            var vvol3_e = 1 ;
                                       } else {
                                            var vvol3_e = vol3_e ;
                                       }
                                       
                                       var ntotal_edit = vvol1_e * vvol2_e * vvol3_e * angka(harga_e) ;
                                       
                                       $("#noid_edit").attr("value",idx_ins_e);
                                       $("#total_edit").attr("value",ntotal_edit);
                                       
                       },
                       onDblClickRow  : function(rowIndex,rowData){
                                        $("#dialog-modal-edit").dialog('open');
                                        document.getElementById('vol1_edit').focus() ;
                       },
                       onAfterEdit  : function(rowIndex, rowData, changes){								
										urai = rowData.uraian;
										idx  = rowData.no_po;
										
										vol1=rowData.volume1;
										sat1=rowData.satuan1;
										har1=rowData.harga1;

										vol2=rowData.volume2;
										sat2=rowData.satuan2;

										vol3=rowData.volume3;
										sat3=rowData.satuan3;

										simpan_rincian(idx,urai,vol1,sat1,har1,vol2,sat2,vol3,sat3,kdrek);
								     },
						onLoadSuccess:function(data){
										load_sum_rek_rinci(kdrek);		 
									 }
        			});
         		});
                    
            });
        }

	   function section1(){
		// validate_combo();
         $(document).ready(function(){    
             $('#section1').click();     
              $('#dg').edatagrid('reload');                                            
         });
       }


    function load_sum_rek(){                
		var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b,units:unit}),
            url:"<?php echo base_url(); ?>index.php/rka_blud/load_sum_rek",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal").attr("value",n['rektotal']);
                });
            }
         });
        });
    }

    
    function load_sum_rek_rinci(c){                
		var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        $(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b,rek:c}),
            url:"<?php echo base_url(); ?>index.php/rka_blud/load_sum_rek_rinci",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#rektotal_rinci").attr("value",n['rektotal_rinci']);
                });
            }
         });
        });
    }
    
    
    function input(){
        
        var cek_giat = $("#kdgiat").combogrid('getValue');
        
        if ( cek_giat=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
        
        $("#kdrek5").combogrid("enable");
        $("#jasa1").combogrid("enable");
        $("#jasa2").combogrid("enable");
        $("#jasa3").combogrid("enable");
        $("#jasa1").combogrid("setValue",'');
        $("#jasa2").combogrid("setValue",'');
        $("#jasa3").combogrid("setValue",'');
        $("#kdrek5").combogrid("setValue",'');
        $("#sdana1").combogrid("setValue",'');
        $("#sdana2").combogrid("setValue",'');
        $("#sdana3").combogrid("setValue",'');
        $("#sdana4").combogrid("setValue",'');
        document.getElementById('nmjasa1').value = '';
        document.getElementById('nmjasa2').value = '';
        document.getElementById('nmjasa3').value = '';
        document.getElementById('nilairek').value    = 0;
        document.getElementById('nilairek').disabled = false;
        document.getElementById('nmrek5').value      = '';
        document.getElementById('nopo').value        = '';
        validate_rekening();
    }
	
	 function tambah_dana(){
		 var cek_unit = $("#unit").combogrid('getValue');
        var cek_giat = $("#kdgiat").combogrid('getValue');
		var cek_rek = $("#kdrek5").combogrid('getValue');
		var cek_nilai = angka(document.getElementById('nilaisdana').value) ;
		var cek_nilai_awal = angka(document.getElementById('nilaisdana2').value) ;
        var cek_nilai_ubah = angka(document.getElementById('nilaisdanaubah').value) ;
        var cek_nilai_awal_ubah = angka(document.getElementById('nilaisdanaubah2').value) ;
		var cek_rekdana = $("#sdana_c").combogrid('getValue');
	
        
        if ( cek_unit=='' ){
            alert('Pilih Unit Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_giat=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_rek=='' ){
            alert('Pilih Rekening Terlebih Dahulu...!!!');
            exit();
        }
		
		
		   if ( cek_rekdana=='' ){
            alert('Kode Sumber dana masih kosong...!!!');
            exit();
        }
		
					   if ( cek_nilai_ubah < 1 ){
            alert('Nilai sumber dana masih kosong...!!!');
            exit();
        }
	
		
		
		
		if(sts_dana != ''){
			
			
			
	
	
			    $.ajax({
				   type     : "POST",
				   dataType : "json",
				   data     : ({kd_skpd:kdskpd,kd_kegiatan:cek_giat,kd_rek5:cek_rek,unit:cek_unit,nilai:cek_nilai,nilai_ubah:cek_nilai_ubah,kd_sdana:cek_rekdana,status:sts_dana,nilaiawal:cek_nilai_awal,nilaiawalubah:cek_nilai_awal_ubah}),
				   url      : '<?php echo base_url(); ?>index.php/rka_blud/simpan_sdana_ubah', 
				   success  : function(data){
							  st121 = data;
							  if ( st121 == '1' ){
								alert("Data Tersimpan...!!!");
								validate_sdana();
                                  $('#dg_dana').edatagrid('reload');   
								//  after_simpan_sdana();
							  }if ( st121 == '2' ){		
								alert("Data Berhasil di Hapus...!!!");
								validate_sdana();
								  $('#dg_dana').edatagrid('reload');  
                                  //after_simpan_sdana();
								}if ( st121 == '3' ){		
								alert("Gagal Simpan,Nilai PO melebihi Nilai Rekening...!!!");								  
							  } else if ( st121 == '0' ){		
								alert("Gagal Simpan...!!!");
							  }
							  }
				}); 
	   
		}else{
			alert('Data sumber dana belum lengkap !');
		} 
        $("#jasa1").combogrid("setValue",'');
        $("#jasa2").combogrid("setValue",'');
        $("#jasa3").combogrid("setValue",'');
        $("#kdrek5").combogrid("setValue",'');
        document.getElementById('nmrek5').value  = '';
        document.getElementById('nmjasa1').value = '';
        document.getElementById('nmjasa2').value = '';
        document.getElementById('nmjasa3').value = '';
	 }
	
	function btl_dana(){
		sts_dana='';
		$("#sdana_c").combogrid("disable");
		document.getElementById('nilaisdana').disabled = true;
		
		$("#sdana_c").combogrid("setValue",'');
		document.getElementById('nmsdana_c').value    = '';
		document.getElementById('nilaisdana').value    = 0;
		document.getElementById('nilaisdana2').value    = 0;
		
		$("#dg_dana").datagrid("unselectAll");
		
	}
	 function input_dana(){
		 sts_dana='tambah';
        
		var cek_unit = $("#unit").combogrid('getValue');
        var cek_giat = $("#kdgiat").combogrid('getValue');
		var cek_rek = $("#kdrek5").combogrid('getValue');
	
        
        if ( cek_unit=='' ){
            alert('Pilih Unit Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_giat=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_rek=='' ){
            alert('Pilih Rekening Terlebih Dahulu...!!!');
            exit();
        }
		
		validate_sdana();
        
        if(cek_giat == '1.02.1.02.02.00.00.01'){
            ambil_dana();
        }else if(cek_giat == '1.02.1.02.02.00.33.01'){
            ambil_dana_bel();
        }

        
        $("#sdana_c").combogrid("enable");
        // $("#sdana_c").combogrid("setValue",'');
		
		document.getElementById('nmsdana_c').value      = '';
        document.getElementById('nilaisdana').disabled  = true;
        document.getElementById('nilaisdanaubah').disabled  = false;
        document.getElementById('nilaisdana').value    = 0;
        document.getElementById('nilaisdana2').value    = 0;    
        document.getElementById('nilaisdanaubah').value    = 0;
		document.getElementById('nilaisdanaubah2').value    = 0;

    }
	
	 function hapus_dana(){
		  sts_dana='hapus';
		 var cek_unit = $("#unit").combogrid('getValue');
        var cek_giat = $("#kdgiat").combogrid('getValue');
		var cek_rek = $("#kdrek5").combogrid('getValue');
		var cek_rekdana = $("#sdana_c").combogrid('getValue');
	   var cnilaisdana = angka(document.getElementById('nilaisdana').value) ;
        
        if ( cek_unit=='' ){
            alert('Pilih Unit Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_giat=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_rek=='' ){
            alert('Pilih Rekening Terlebih Dahulu...!!!');
            exit();
        }
		
		
	
		
	
	
		
		var rows   = $("#dg_dana").datagrid("getSelections");
            var jrows  = rows.length ;
		if(jrows < 1){
			alert('Pilih sumber dana nya dulu !!');
			return;
		}
		
			var del=confirm('Anda yakin akan menghapus sumber dana ini?');
				if  (del==true){
					
					 $.ajax({
				   type     : "POST",
				   dataType : "json",
				   data     : ({kd_skpd:kdskpd,kd_kegiatan:cek_giat,kd_rek5:cek_rek,unit:cek_unit,kd_sdana:cek_rekdana,status:sts_dana,vnilaisdana:cnilaisdana}),
				   url      : '<?php echo base_url(); ?>index.php/rka_blud/simpan_sdana', 
				   success  : function(data){
							  st121 = data;
							  if ( st121 == '1' ){
								alert("Data Tersimpan...!!!");
								validate_sdana();
								  $('#dg_dana').edatagrid('reload');   
							  }if ( st121 == '2' ){		
								alert("Data Berhasil di Hapus...!!!");
								validate_sdana();
								  $('#dg_dana').edatagrid('reload');
							 }if ( st121 == '3' ){		
								alert("Gagal Hapus,Nilai PO melebihi Nilai Rekening...!!!");
								
							  } else {
								alert("Gagal Simpan...!!!");
							  }
							  }
				}); 
				
					
				}

    }
	
	function edit_dana(){
         sts_dana='edit';
		var cek_unit = $("#unit").combogrid('getValue');
        var cek_giat = $("#kdgiat").combogrid('getValue');
		var cek_rek = $("#kdrek5").combogrid('getValue');
	
        
        if ( cek_unit=='' ){
            alert('Pilih Unit Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_giat=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
		
		   if ( cek_rek=='' ){
            alert('Pilih Rekening Terlebih Dahulu...!!!');
            exit();
        }
		
		var rows   = $("#dg_dana").datagrid("getSelections");
            var jrows  = rows.length ;
		if(jrows < 1){
			alert('Pilih sumber dana nya dulu !!');
			return;
		}
	
        
        //$("#sdana_c").combogrid("enable");


        document.getElementById('nilaisdana').disabled      = false;
       

    }
    

    function tambah(){

        var skpd   = document.getElementById('skpd').value;
        var units  = $("#unit").combogrid("getValue");
        var kegi   = $("#kdgiat").combogrid("getValue");
        var reke   = $("#kdrek5").combogrid("getValue");
        var nmrek5 = document.getElementById('nmrek5').value;
        var nrek   = angka(document.getElementById('nilairek').value) ;
        var sdana1 = $("#sdana1").combogrid("getValue");
        var sdana2 = $("#sdana2").combogrid("getValue");
        var sdana3 = $("#sdana3").combogrid("getValue");
        var sdana4 = $("#sdana4").combogrid("getValue");
		
		 var jasa1 = $("#jasa3").combogrid("getValue");
		 
         if ( units == '' ){
            alert('Pilih Unit Terlebih Dahulu...!!!');
            exit();
        }
        if ( kegi == '' ){
            alert('Pilih Kode Kegiatan Terlebih Dahulu...!!!');
            exit();
        }
        if ( reke == '' ){
            alert('Pilih Rekening Terlebih Dahulu...!!!');
            exit();
        }
		
		if ( jasa1 == '' ){
            alert('Pilih Jasa Layanan Terlebih Dahulu...!!!');
            exit();
        }
       
        /*       
        if ( nrek == 0 ){
            alert('Nilai Rekening 0 ???');
            exit();
        }
        */


        $("#dg").datagrid("selectAll");
        var rows = $("#dg").datagrid("getSelections");
        var jrow = rows.length - 1;
        jidx     = jrow + 1 ;

        $('#dg').edatagrid('appendRow',{kd_rek5:reke,nm_rek5:nmrek5,nilai:nrek,id:jidx});
        
        $(document).ready(function(){
        $.ajax({
           type     : "POST",
           dataType : "json",
           data     : ({kd_skpd:skpd,kd_kegiatan:kegi,kd_rek5:reke,nilai:nrek,dana1:sdana1,dana2:sdana2,dana3:sdana3,dana4:sdana4,unitss:units,jasabro:jasa1}),
           url      : '<?php echo base_url(); ?>index.php/rka_blud/tsimpan_ar_ubah', 
           success  : function(data){
                      st12 = data;
                      if ( st12 == '1' ){
                        alert("Data Tersimpan...!!!");
						  $('#dg').edatagrid('reload');    
                      } else {
                        alert("Gagal Simpan...!!!");
                      }
                      }
        });
        });
        
        $("#dg").datagrid("unselectAll");
        validate_combo();
        
        $("#kdrek5").combogrid("disable");
        $("#jasa1").combogrid("disable");
        $("#jasa2").combogrid("disable");
		$("#jasa3").combogrid("disable");
        $("#kdrek5").combogrid("setValue",'');
        $("#nilairek").attr("value",0);
        document.getElementById('nmrek5').value = '';
          $("#jasa1").combogrid("setValue",'');
          $("#jasa2").combogrid("setValue",'');
		  $("#jasa3").combogrid("setValue",'');
           document.getElementById('nmjasa1').value = '';
           document.getElementById('nmjasa2').value = '';
		   document.getElementById('nmjasa3').value = '';
		
        $("#sdana1").combogrid("setValue",'');
        $("#sdana2").combogrid("setValue",'');
        $("#sdana3").combogrid("setValue",'');
        $("#sdana4").combogrid("setValue",'');
    }
    
    
    function btl(){
        
        $("#kdrek5").combogrid("disable");
        $("#jasa1").combogrid("disable");
        $("#jasa2").combogrid("disable");
		$("#jasa3").combogrid("disable");
        $("#jasa2").combogrid("setValue",'');
        $("#jasa3").combogrid("setValue",'');
        document.getElementById('nmjasa1').value = '';
        document.getElementById('nmjasa2').value = '';
        document.getElementById('nmjasa3').value = '';
        $("#kdrek5").combogrid("setValue",'');
		$("#jasa1").combogrid("setValue",'');
        $("#sdana1").combogrid("setValue",'');
        $("#sdana2").combogrid("setValue",'');
        $("#sdana3").combogrid("setValue",'');
        $("#sdana4").combogrid("setValue",'');
        document.getElementById('nilairek').value = 0;
        document.getElementById('nmrek5').value   = '';
		 document.getElementById('nmjasa1').value   = '';
        $("#dg").datagrid("unselectAll");
        
    }
    

    function keluar(){
        $("#dialog-modal").dialog('close');
        $('#dg_rek').datagrid('unselectAll');
        $('#dg').edatagrid('reload');
    } 
      

    function simpan_det_keg(){
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
        var c = document.getElementById('lokasi').value; 
        var d = document.getElementById('sasaran').value;
        var e = document.getElementById('wkeg').value;
        var f = document.getElementById('cp_tu').value;
        var g = document.getElementById('cp_ck').value;
        var h = document.getElementById('m_tu').value;
        var i = document.getElementById('m_ck').value; 
        var j = document.getElementById('k_tu').value;
        var k = document.getElementById('k_ck').value;
        var l = document.getElementById('h_tu').value;  
        var m = document.getElementById('h_ck').value;
        var n = document.getElementById('ttd').value;
        
        if ( b=='' ){
            alert('Pilih Kegiatan Terlebih Dahulu...!!!');
            exit();
        }


		$(function(){      
         $.ajax({
            type: 'POST',
            data: ({skpd:a,giat:b,lokasi:c,sasaran:d,wkeg:e,cp_tu:f,cp_ck:g,m_tu:h,m_ck:i,k_tu:j,k_ck:k,h_tu:l,h_ck:m,ttd:n}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/rka_blud/simpan_det_keg",
			success:function(data){ 
					alert('Data Tersimpan');
					}
         });
        });
    }




    function load_detail_keg(){                
		var a = document.getElementById('skpd').value;
        //var b = document.getElementById('giat').value;
        var b = $('#kdgiat').combogrid('getValue');
        //$(function(){      
         $.ajax({
            type: 'POST',
            data:({skpd:a,keg:b}),
            url:"<?php echo base_url(); ?>index.php/rka_blud/load_det_keg",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#lokasi").attr("value",n['lokasi']);
                    $("#sasaran").attr("value",n['sasaran']);
                    $("#wkeg").attr("value",n['wkeg']);
                    $("#ttd").attr("value",n['ttd']);
                    $("#cp_tu").attr("value",n['cp_tu']);
                    $("#m_tu").attr("value",n['m_tu']);
                    $("#k_tu").attr("value",n['k_tu']);
                    $("#h_tu").attr("value",n['h_tu']);
                    $("#cp_ck").attr("value",n['cp_ck']);
                    $("#m_ck").attr("value",n['m_ck']);
                    $("#k_ck").attr("value",n['k_ck']);
                    $("#h_ck").attr("value",n['h_ck']);
                });
            }
         });
        //});
    }


		function insert(){
			$('#dg1').datagrid('insertRow',{
				index:detIndex,
				row:{uraian:''				
					}
			});
			$('#dg1').datagrid('beginEdit',detIndex+1);		
		}	

        
        //DASAR HUKUM ==================================================================================================
        $(function(){ //load pertama
       	    var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
			$('#dg2').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/rka_blud/rka_hukum/'+mskpd+'/'+mgiat,
                 idField:'id',
                 rownumbers:true, 
                 fitColumns:false,
                 singleSelect:false,
				 onLoadSuccess:function(data){
							       selectall();		 
							   },
				 columns:[[
 					{field:'kd_hukum',
					 title:'kode',
					 width:5,
					 hidden:true,
					 editor:{type:"text"}
					},
					{field:'nm_hukum',
					 title:'Dasar Hukum',
					 width:780,
					 editor:{type:"text"}
					},
                    {field:'ck',
					 title:'ck',
					 width:5,
					 checkbox:true
                     }
				]]	
			
			});
		});

    
    //load dasar hukum pada combo giat==========================================================
	var sell = new Array();
	var max  = 0;
	function getcek(){
		var ids = [];  
		var a=null;
		var rows = $('#dg2').edatagrid('getSelections');  
		for(var i=0; i<rows.length; i++){  
		    a=rows[i].ck;
			max=i;
			if (a!=null){
				sell[i]=a-1;
			}else{
				sell[i]=1000;			
			}
		}  
	}
	
	function setcek(){
		for(var i=0; i<max+1; i++){ 
			if (sell[i]!=1000){
				selectRecord(sell[i]);
			}
		} 		
	}


	function selectall(){
		max  = 0;
		$('#dg2').edatagrid('selectAll');
		getcek();
		Unselectall();
		setcek();
	}

	function Unselectall(){
		$('#dg2').edatagrid('unselectAll');
	}


	function selectRecord(rec){
		$('#dg2').edatagrid('selectRecord',rec);
	}
	
	function load_dhukum(){
        $(function(){
       	    var mskpd = document.getElementById('skpd').value;
            var mgiat = document.getElementById('giat').value;
			$('#dg2').edatagrid({
				url: '<?php echo base_url(); ?>/index.php/rka_blud/rka_hukum/'+mskpd+'/'+mgiat,
                 idField:'id',
                 rownumbers:true, 
                 fitColumns:false,
                 singleSelect:false,
				 columns:[[
 					{field:'kd_hukum',
					 title:'kode',
					 width:5,
					 hidden:true,
					 editor:{type:"text"}
					},
					{field:'nm_hukum',
					 title:'Dasar Hukum',
					 width:780,
					 editor:{type:"text"}
					},
                    {field:'ck',
					 title:'ck',
					 width:5,
					 checkbox:true
                     }
				]]	
			
			});
		});
		selectall();
	}


	function simpan_dhukum(){
		var ids = [];  
		var rows = $('#dg2').edatagrid('getSelections');  
		for(var i=0; i<rows.length; i++){  
		    ids.push(rows[i].kd_hukum);
		}  
		hukum_cont(ids.join('||'));  
	}

    function hukum_cont(isi){
        var a = document.getElementById('skpd').value;
        var b = document.getElementById('giat').value;
		$(function(){      
         $.ajax({
            type: 'POST',
            data: ({skpd:a,giat:b,cisi:isi}),
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/rka_blud/simpan_dhukum",
			success:function(data){ 
					alert('Data Tersimpan');
					}
         });
        });
    }
    
    function tombol(st){  
    if (st=='1'){
            $('#add').linkbutton('disable');
            $('#input').linkbutton('disable');
            $('#btl').linkbutton('disable');
            $('#del').linkbutton('disable');
            $('#save').linkbutton('disable');
            $('#cancel').linkbutton('disable');
            $('#add1').linkbutton('disable');
            $('#del1').linkbutton('disable');
            $('#save1').linkbutton('disable');
            $('#cancel1').linkbutton('disable');
            $('#insert1').linkbutton('disable');
            $('#save2').linkbutton('disable');
            $('#save4').linkbutton('disable');
            document.getElementById("p1").innerHTML="APBD TELAH DI - SAH - KAN...!!!";
            status_apbd = '1';
            
     } else {
            $('#add').linkbutton('enable');
            $('#input').linkbutton('enable');
            $('#btl').linkbutton('enable');
            $('#del').linkbutton('enable');
            $('#save').linkbutton('enable');
            $('#cancel').linkbutton('enable');
            $('#add1').linkbutton('enable');
            $('#del1').linkbutton('enable');
            $('#save1').linkbutton('enable');
            $('#cancel1').linkbutton('enable');
            $('#insert1').linkbutton('enable');
            $('#save2').linkbutton('enable');
            $('#save4').linkbutton('enable');
            
            document.getElementById("p1").innerHTML="";
            status_apbd = '0';
            
     }
    }
    
    
    function append_save() {
        
            var cgiat = document.getElementById('giat').value;
    		var cskpd = document.getElementById('skpd').value;
            var crek  = document.getElementById('reke').value;
            var norka = cskpd+'.'+cgiat+'.'+crek;
            
            $("#dg1").datagrid("unselectAll");
            $('#dg1').datagrid('selectAll');
            var rows   = $('#dg1').datagrid('getSelections') ;
                jgrid  = rows.length ;
            
            var uraian = document.getElementById('uraian').value;
            var vol1   = document.getElementById('vol1').value;
            if ( vol1 == '' ){
                 volu1=1;
            }else{
                volu1=vol1
            }
            var sat1 = document.getElementById('sat1').value;
            var vol2 = document.getElementById('vol2').value;
            if ( vol2 == '' ){
                 volu2=1;
            }else{
                volu2=vol2;
            }
            var sat2 = document.getElementById('sat2').value;
            var vol3 = document.getElementById('vol3').value;
            if ( vol3 == '' ){
                 volu3=1;
            }else{
                volu3=vol3;
            }
            
            var sat3   = document.getElementById('sat3').value;
            var nilai  = document.getElementById('harga').value ;
            var harga  = angka(nilai) ;
            var tvol   = volu1*volu2*volu3;
            var total  = volu1*volu2*volu3*harga;
            
            var fharga = number_format(harga,2,'.',',');           
            var ftotal = number_format(total,2,'.',',');           
           
            var id     = jgrid  ;
            
            $('#dg1').edatagrid('appendRow',{uraian:uraian,volume1:vol1,satuan1:sat1,volume2:vol2,satuan2:sat2,volume3:vol3,volume:tvol,satuan3:sat3,harga1:fharga,id:id,total:ftotal});
            $("#dg1").datagrid("unselectAll");
            
            var total_awal  = angka(document.getElementById('rektotal_rinci').value) ;
            var total_rinci = total
                total_rinci = total_rinci + total_awal; 
                        
            $("#rektotal_rinci").attr("value",number_format(total_rinci,2,'.',','));
            kosong();
       
       }
       
       
       
       function insert_row() {
             
            var rows     = $('#dg1').edatagrid('getSelected');
            var idx_ins  = $('#dg1').edatagrid('getRowIndex',rows);
                
            if ( idx_ins == -1){
                alert("Pilih Lokasi Insert Terlebih Dahulu...!!!") ;
                exit();
            }

            $('#dg1').datagrid('selectAll');
            var rows_grid = $('#dg1').datagrid('getSelections');
            for ( var i=idx_ins; i<rows_grid.length; i++ ) {            
                  $('#dg1').edatagrid('updateRow',{index:i,row:{id:i+1,no_po:i+1}});
            }
            $('#dg1').datagrid('unselectAll');
               
            var uraian = document.getElementById('uraian').value;
            var vol1   = document.getElementById('vol1').value;
            if ( vol1 == '' ){
                 volu1=1;
            }else{
                volu1=vol1
            }
            var sat1 = document.getElementById('sat1').value;
            var vol2 = document.getElementById('vol2').value;
            if ( vol2 == '' ){
                 volu2=1;
            }else{
                volu2=vol2;
            }
            var sat2 = document.getElementById('sat2').value;
            var vol3 = document.getElementById('vol3').value;
            if ( vol3 == '' ){
                 volu3=1;
            }else{
                volu3=vol3;
            }
            var sat3   = document.getElementById('sat3').value;
            var nilai  = document.getElementById('harga').value;
            var harga  = angka(nilai) ;
            var tvol   = volu1*volu2*volu3;
            var total  = volu1*volu2*volu3*harga;
            
            harga = number_format(harga,2,'.',',');
            total = number_format(total,2,'.',',');
       
            $('#dg1').edatagrid('insertRow',{index:idx_ins,row:{uraian:uraian,volume1:vol1,satuan1:sat1,volume2:vol2,satuan2:sat2,volume3:vol3,volume:tvol,satuan3:sat3,harga1:harga,id:id,total:total,id:idx_ins,no_po:idx_ins}});
            $("#dg1").datagrid("unselectAll");
            kosong();
            
    }
       
    
    function kosong(){
            $("#uraian").attr("value","");
            $("#vol1").attr("value","");
            $("#sat1").attr("value","");
            $("#vol2").attr("value","");
            $("#sat2").attr("value","");
            $("#vol3").attr("value","");
            $("#sat3").attr("value","");
            $("#harga").attr("value","");
            $("#no_po").attr("value","");
            document.getElementById('uraian').focus();
            
    }
        
    
    function enter(ckey,_cid){
        if (ckey==13)
        	{    	       	       	    	   
        	   document.getElementById(_cid).focus();
               if(_cid=='uraian'){
                    var as_kdgiat = $("#kdgiat").combogrid("getValue") ;
                    var as_reke   = document.getElementById('reke').value ;
                    
                    if ( as_kdgiat=='' ){
                        alert('Pilih Kegiatan Terlebih Dahulu...!!!');
                        exit();
                    }
                    if ( as_reke=='' ){
                        alert("Pilih Rekening Terlebih Dahulu...!!!");
                        exit();
                    }
                    append_save();
               }
        	}     
        }
        
      
     function standard_harga(){

        $("#dialog-modal").dialog("open");
        var crekening = document.getElementById('reke').value ;

        $('#dg_std').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/rka_blud/load_daftar_harga_detail_ck',
        queryParams   : ({rekening:crekening}),
        idField       : 'id',
        rownumbers    : true, 
        fitColumns    : false,
        singleSelect  : false,
        columns       : [[{field:'id',        title:'id',           width:70, align:"left",hidden:"true"},
                          {field:'no_urut',   title:'No Urut',      width:70, align:"left",hidden:"true"},
                          {field:'kd_rek5',   title:'Rekening',     width:80, align:"left",hidden:"true"},
                          {field:'uraian',    title:'Uraian',       width:510,align:"left"},
                          {field:'merk',      title:'Merk',         width:100,align:"left"},
                          {field:'satuan',    title:'Satuan',       width:100,align:"left"},
                          {field:'harga',     title:'Harga',        width:150,align:"right"},
                          {field:'ck',        title:'ck',           checkbox:true}
                         ]]
        });
        selectall_std();		 
     }   
     
     function kembali_std(){
        $("#section2").click();
        $("#dialog-modal").dialog("close");
     }

     var sell_std = new Array();
	 var max_std  = 0;
	  
     function getcek_std(){
    	var ids   = [];  
		var a     = null;
		var rows  = $('#dg_std').edatagrid('getSelections');  
		for(var i=0; i<rows.length; i++){  
		    a       = rows[i].ck;
			max_std = i;
			if (a!=null){
				sell_std[i]=a-1;
			}else{
				sell_std[i]=1000;			
			}
		}  
	  }
	
	 
     function setcek_std(){
		for(var i=0; i<max+1; i++){ 
			if (sell_std[i]!=1000){
				selectRecord_std(sell_std[i]);
			}
		} 		
	 }


	 function selectall_std(){
		max_std = 0;
		$('#dg_std').edatagrid('selectAll');
		getcek_std();
		Unselectall_std();
		setcek_std();
	 }

	 
     function Unselectall_std(){
		$('#dg_std').edatagrid('unselectAll');
	 }
     
     function selectRecord_std(rec){
		$('#dg_std').edatagrid('selectRecord',rec);
	 }
     
     function pilih_std(){

		var ids  = [];  
		var rows = $('#dg_std').edatagrid('getSelections');  
		for(var i=0; i<rows.length; i++){  

		    var urai_std  = rows[i].uraian;
		    var satu_std  = rows[i].satuan;
		    var harga_std = rows[i].harga;
            
            var vol1      = '';
            var vol2      = '';
            var vol3      = '';
            var tvol      = '';

            var sat2      = '';
            var sat3      = '';
            
            var fharga    = number_format(harga_std,2,'.',',');
            var ftotal    = number_format(harga_std,2,'.',',');
            var total     = harga_std;
            
            $("#dg1").datagrid("unselectAll");
            $('#dg1').datagrid('selectAll');
            var rows_2 = $('#dg1').datagrid('getSelections') ;
                jgrid  = rows_2.length ;
           
            var id     = jgrid  ;
            
            $('#dg1').edatagrid('appendRow',{uraian:urai_std,volume1:vol1,satuan1:satu_std,volume2:vol2,satuan2:sat2,volume3:vol3,volume:tvol,satuan3:sat3,harga1:fharga,id:id,total:ftotal});
            $("#dg1").datagrid("unselectAll");
            
            var total_awal  = angka(document.getElementById('rektotal_rinci').value) ;
            var total_rinci = angka(total)
                total_rinci = total_rinci + total_awal; 
            
            $("#rektotal_rinci").attr("value",number_format(total_rinci,2,'.',','));
            kosong();
            $("#dialog-modal").dialog("close");
            
        }  
	}
    
    function kembali_edit(){
        $("#section2").click();
        $("#dialog-modal-edit").dialog("close");
    }
    
    
    function pilih_edit(){
            
            var uraian_edit = document.getElementById('uraian_edit').value;
            var vol1_edit   = document.getElementById('vol1_edit').value;
			
		
	if ( vol1_edit == '' || vol1_edit == 0){
                 volu1_edit = 1;
            }else{
                volu1_edit  = vol1_edit;
            }
			
				
            var sat1_edit = document.getElementById('sat1_edit').value;
            var vol2_edit = document.getElementById('vol2_edit').value;
            
            if ( vol2_edit == '' || vol2_edit == 0){
                 volu2_edit = 1 ;
            }else{
                volu2_edit  = vol2_edit;
            }
            
            var sat2_edit = document.getElementById('sat2_edit').value;
            var vol3_edit = document.getElementById('vol3_edit').value;
            
            if ( vol3_edit == '' || vol3_edit == 0){
                 volu3_edit = 1 ;
            }else{
                volu3_edit = vol3_edit ;
            }
			
		
            
            var sat3_edit   = document.getElementById('sat3_edit').value;
            var nilai_edit  = document.getElementById('harga_edit').value ;
            
            var harga_edit  = angka(nilai_edit) ;
			

            var tvol_edit   = volu1_edit*volu2_edit*volu3_edit;
            var total_edit  = volu1_edit*volu2_edit*volu3_edit*harga_edit;
            
							
               
            var fharga_edit = number_format(harga_edit,2,'.',',');           
            var ftotal_edit = number_format(total_edit,2,'.',',');      
            
            var idx_ins_edit  = document.getElementById('noid_edit').value;
            
            $('#dg1').edatagrid('updateRow',{index:idx_ins_edit,row:{uraian:uraian_edit,volume1:vol1_edit,satuan1:sat1_edit,volume2:vol2_edit,satuan2:sat2_edit,volume3:vol3_edit,volume:tvol_edit,satuan3:sat3_edit,harga1:fharga_edit,total:ftotal_edit}});
            $("#dg1").datagrid("unselectAll");
            
            var total_pertama    = angka(document.getElementById('total_edit').value) ;
            var total_awal_edit  = angka(document.getElementById('rektotal_rinci').value) ;
            var total_rinci_edit = total_edit ;
	
                total_rinci_edit = total_rinci_edit + total_awal_edit - total_pertama ; 
                        
            $("#rektotal_rinci").attr("value",number_format(total_rinci_edit,2,'.',','));
            $("#dialog-modal-edit").dialog('close');
            kosong(); 
            
            //$("#dg1").datagrid("reload");
    
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

   <?php echo $prev; ?><p id="p1" style="font-size: x-large;color: red;"></p><br />
   <table style="border-collapse:collapse;border-style:hidden;" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
   <tr style="border-style:hidden;">
   <td>S K P D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="sskpd" name="sskpd" readonly="true" style="width:170px;border: 0;" />
   &nbsp;&nbsp;<input id="nmskpd" name="nmskpd" readonly="true" style="width: 320px; border:0;  " /></td>
   </tr>
   <tr style="border-style:hidden;">
   <td>UNIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="unit" name="unit" style="width:170px;" />  
    &nbsp;&nbsp;&nbsp;<input id="nmunit" name="nmunit" readonly="true" style="width:320px;border:0;background-color:transparent;color: black;" disabled="true"/>
   </td>
   </tr>
   <tr style="border-style:hidden;">
   <td>KEGIATAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="kdgiat" name="kdgiat" style="width:170px;" />  
   &nbsp;&nbsp;&nbsp;<input id="nmgiat" name="nmgiat" readonly="true" style="width:320px;border:0;background-color:transparent;color: black;" disabled="true"/>
   <input type="hidden" id="jnskegi" name="jnskegi" style="width:20px;" /></td>
   </tr>
   
   </table>

    <div id="accordion">



    <h2><a href="#" id="section1">Rekening Anggaran</a></h2>
   
               <div  style="height:700px;">      
               
                   <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
                   
                   <tr style="border-bottom-style:hidden;">
                   <td colspan="5" style="border-bottom-style:hidden;"></td>
                   </tr>
                   <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;" >JASA LAYANAN</td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" >
                   <input id="jasa1" name="jasa1" style="width:170px;" disabled='true'/>&nbsp;&nbsp;<input id="jasa2" name="jasa2" style="width:180px;" disabled='true'/>&nbsp;&nbsp;<input id="jasa3" name="jasa3" style="width:350px;" disabled='true'/>
                   <!-- <input id="nmjasa1" name="nmjasa1" readonly="true" style="width:370px;border:0;background-color:transparent;color:black;" disabled="true" /></td>  -->

                   </tr>
                   <!-- <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;" >JASA LAYANAN 2</td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" >
                   <input id="nmjasa2" name="nmjasa2" readonly="true" style="width:370px;border:0;background-color:transparent;color:black;" disabled="true" /></td>
                   
                   </tr>
                    <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;" >JASA LAYANAN 3</td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" >
                   <input id="nmjasa3" name="nmjasa3" readonly="true" style="width:370px;border:0;background-color:transparent;color:black;" disabled="true" /></td>
                   
                   </tr> -->
                   
                   <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;">REKENING</td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="4"><input id="kdrek5" name="kdrek5" style="width:170px;" />  
                       <input id="nmrek5" name="nmrek5" readonly="true" style="width:370px;border:0;background-color:transparent;color:black;" disabled="true" />
                   </td>
                   </tr>
            	   
            	    
            	   
                   
                   <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;" hidden="true">SUMBER DANA</td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" hidden="true"><input id="sdana1" name="sdana1" style="width:170px;"/></td>  
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" hidden="true"><input id="sdana2" name="sdana2" style="width:170px;"/></td>  
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" hidden="true"><input id="sdana3" name="sdana3" style="width:170px;"/></td> 
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:260px;border-bottom-style:hidden;" hidden="true"><input id="sdana4" name="sdana4" style="width:170px;"/></td> 
                   </tr>
                   
                   <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:110px;border-bottom-style:hidden;border-right-style:hidden;" hidden="true">NILAI</td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" hidden="true"><input id="nilairek" name="nilairek" style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))"/><input type='hidden' id="cek_kas" name="cek_kas" style="width:170px;text-align:right;"/></td>
                   <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:600px;border-bottom-style:hidden;" colspan="3"></td>
                   </tr>
                   <tr style="border-bottom-style:hidden;">
                   <td colspan="5" align="center" style="border-bottom-style:hidden;">
                   <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:input()">Tambah</button>
                   <button id="btl" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:btl()">Batal</button>
                   <button id="delrek" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus()">Hapus</button>
                   <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:tambah()">Simpan</button>
                   </td>
                   </tr>
                   <tr style="border-bottom-color:black;height:1px;" >
                   <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
                   </tr>
                   </table>
                   
                   <!--<table border='0' width="100%" >
                   <tr>
                   <td align='right'>
                   <button id="add" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</button>
                   <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</button>
                   <button id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('addRow');">Simpan</button>
                   <button id="cancel" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Batal</button>
                   </td>
                   </tr>
                   </table>-->
                   
                   <table id="dg" title="Input Rekening Rencana Bisnis Anggaran" style="width:880px;height:400px;" >          
                   </table>  
                    <div id="toolbarx">
                		<!--<button  class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">Baru</button>-->
                        <!--<button id="add" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</button>-->
                		<!--<button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</button>-->
                		<!--<button id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('addRow');">Simpan</button>-->
                		<!--<button id="cancel" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Batal</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                        <table style="width:880px;height:10px;border-style:hidden;">
                        <tr><td align="right">
                        <B>Total</B>&nbsp;&nbsp;<input class="right" type="text" name="rektotal" id="rektotal"  style="width:200px;text-align:right;"  readonly="true"/>
                        </td></tr>
                        </table>
                    </div>
                </div>

                <h3><a href="#" id="section5">Sumber Dana</a></h3>
                

                <div>


                  Kode Sumber Dana&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input id="sdana_c" name="sdana_c" style="width:170px;" disabled='true'/>
                  <input type='text' id="nmsdana_c" name="nmsdana_c" style="width:270px;" readonly='true'/>
                  <br />
                    <br />
                  Nilai Dana Penyusunan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input id="nilaisdana" name="nilaisdana" style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))" disabled='true'/>
                   <input hidden='true' id="nilaisdana2" name="nilaisdana2" style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))" disabled='true'/>
                <br />
                <br />
                 Nilai Dana Perubahan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input id="nilaisdanaubah" name="nilaisdanaubah" style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))" disabled="true" />
                   <input hidden='true' id="nilaisdanaubah2" name="nilaisdanaubah2" style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))" disabled='true'/>
                <p align='center'>
                <br />
                  <button id="input_dana" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:input_dana()">Tambah</button>
                        
                       <button id="edit_dana" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:edit_dana()">Edit</button>
                	   
                       <button id="del_dana" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_dana()">Hapus</button>
                       <button id="btl_dana" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:btl_dana()">Batal</button>
                	   <button id="add_dana" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:tambah_dana()">Simpan</button>
                	   <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
                </p>
                 
                   
                <table id="dg_dana" title="Sumber Dana" style="width:880px;height:400px;" >          
                       </table>  
                </div>
    
                <h3><a href="#" id="section2">Rincian Rekening</a></h3>
    
            <div>

                <table border='1' style="width:800px;">
                <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                    <td colspan='8' style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;"><input type="hidden" id="noid" style="width: 200px;" /><input type="hidden" id="nopo" style="width: 200px;" /><input type="hidden" id="reke" style="width: 200px;" /></td>
                </tr>
        		    <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                <td style="border-right-style:hidden;  border-bottom-style:hidden; border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Nilai Rekening&nbsp;&nbsp;&nbsp;</td>
                <td style="border-bottom-style:hidden; border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;" colspan="7">
        		<input id="nilai_rek_tot" name="nilai_rek_tot" style="width:170px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'add');return(currencyFormat(this,',','.',event))" disabled='true'/>
        		</td>
                </tr>
                <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                <td style="border-right-style:hidden;  border-bottom-style:hidden; border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Uraian&nbsp;&nbsp;&nbsp;</td>
                <td style="border-bottom-style:hidden; border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;" colspan="7"><input type="text" id="uraian" style="width: 800px;" onkeypress="javascript:enter(event.keyCode,'vol1');"/></td>
                </tr>
                <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"></td>
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol1</td>
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat1</td>
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol2</td>
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat2</td>
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol3</td>
                    <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat3</td>
                    <td style="border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Harga</td>
                </tr>
                <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">
                    <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"></td>
                    <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol1" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat1');"/></td>
                    <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat1" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'vol2');"/></td>
                    <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol2" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat2');"/></td>
                    <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat2" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'vol3');"/></td>
                    <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol3" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat3');"/></td>
                    <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat3" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'harga');"/></td>
                    <td style="border-spacing:3px ;padding:3px 3px 3px 3px;border-bottom-color:black;"><input type="text" id="harga" style="width: 175px; text-align: right;"  onkeypress="javascript:enter(event.keyCode,'uraian');return(currencyFormat(this,',','.',event))"/>
                    </td>
                </tr>   
                </table>
                <table id="dg1"  style="width:875px;height:370px;"> 
                </table>  
                <table border='1' style="width:870px;">
                <tr style="border-style: hidden;">
                
                <td style="border-style: hidden;">
                    <button id="add1" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:kosong();">Tambah</button>
            		<button id="del1" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_rinci();">Hapus</button>
                    <button id="save1" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:detsimpan();">Simpan</button>
            		<button id="insert1" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:insert_row();">Insert</button>
        			<button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
        		    <!-- <button id="stdhrg" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:standard_harga();">Standard Harga</button> -->
                </td>
                
                <td align='right' style="border-style: hidden;">
                <B>Total</B>&nbsp;&nbsp;&nbsp;&nbsp;<input class="right" type="text" name="rektotal_rinci" id="rektotal_rinci"  style="width:200px" align="right" readonly="true" />
                </td>
                
                </tr>
                
               <!-- <tr>
                <td colspan="2" style="border-style: hidden;">
                <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
                </td>
                </tr> -->
                
                
                </table>
            </div>   


            <h3><a href="#" id="section3" onclick="javascript:load_dhukum();" >Dasar Hukum</a></h3>

            <div>
                
                <table id="dg2" title="Input Dasar Hukum Per Kegiatan" style="width:870px;height:400px;" >  
                
                </table>  
                <div id="toolbar1xa">
            		<button id="save2" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_dhukum();">Simpan</button>
            		<button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
                </div>

        	</div>   

        <h3><a href="#" id="section4" onclick="javascript:load_detail_keg();" >Detail Kegiatan</a></h3>
    
            <div>
            <fieldset style="width:100%;height:570px;border-color:black;border-style:hidden; border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"> 
            <br />
        	<table align="center" border='0' width="100%" style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        	<tr style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Lokasi</b></td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><textarea id="lokasi" name="lokasi" rows='2' cols="40" ></textarea></td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" >&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Kelompok</b></td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;"><textarea id="sasaran" name="sasaran" rows='2' cols="40"></textarea></td>
        	</tr>
        	<tr style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>Waktu</b></td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><textarea id="wkeg" name="wkeg" rows='2' cols="40" > </textarea></td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" >&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><b>PPTK</b></td>
        		<td style="border-spacing:0px ;padding:0px 0px 0px 0px;border-collapse:collapse;" ><?php echo $this->rka_model->combo_ttd(); ?></td>
        	</tr>
        	</table>
        	<br/>    

        	<table align="center" border='0' width="100%" style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
        	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Indikator</b></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><b>Tolak Ukur</b></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><b>Capaian Kinerja</b></td>
        	</tr>
        	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;">
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Capaian</b></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="cp_tu" name="cp_tu" rows='2' cols="45" > </textarea></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="cp_ck" name="cp_ck" rows='2' cols="45" > </textarea></td>
        	</tr>
        	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Masukan</b></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="m_tu" name="m_tu" rows='2' cols="45"  > </textarea></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="m_ck" name="m_ck" rows='2' cols="45"  > </textarea></td>
        	</tr>
        	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Keluaran</b></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="k_tu" name="k_tu" rows='2' cols="45" > </textarea></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" >&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="k_ck" name="k_ck" rows='2' cols="45" > </textarea></td>
        	</tr>
        	<tr style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;border-style:hidden;" >
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;"><b>Hasil</b></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="h_tu" name="h_tu" rows='2' cols="45" > </textarea></td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;">&nbsp;&nbsp;</td>
        		<td style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;" align="center"><textarea id="h_ck" name="h_ck" rows='2' cols="45" > </textarea></td>
        	</tr>
        	</table>
                <div id="toolbar1xa" >
            		<button id="save4" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_det_keg()">Simpan</button>
            		<button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:section1()">Kembali</button>
                </div>
            </fieldset>    
        	</div>   
</div>


        <div id="dialog-modal" title="">

            <p class="validateTips"></p> 
            <fieldset>        
            <table id="dg_std" title="Pilih Standard" style="width:930px;height:300px;">  
            </table>  
            
            <table style="width:930px;height:20px;" border="0">
                <tr>
                <td align="center" colspan='2'>&nbsp;</td>
                </tr>

                <tr>
                <td align="center" >
                <button class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:pilih_std();">Simpan</button>
                <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:kembali_std();">Kembali</button></td>
                </tr>
            </table>
            
            </fieldset>  
        </div>


<div id="dialog-modal-edit" title="Edit Rincian Rekening">

    <p class="validateTips"></p> 
    
    <fieldset>        
    <table border='0' style="width:800px;">
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td colspan='8' style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;"><input type="hidden" id="noid_edit" style="width: 200px;" /><input type="hidden" id="nopo_edit" style="width: 200px;" /><input type="hidden" id="total_edit" style="width: 200px;" /><input type="hidden" id="reke" style="width: 200px;" /></td>
        </tr>
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
        <td style="border-right-style:hidden;  border-bottom-style:hidden; border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Uraian&nbsp;&nbsp;&nbsp;</td>
        <td style="border-bottom-style:hidden; border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;" colspan="7"><input type="text" id="uraian_edit" style="width: 800px;" onkeypress="javascript:enter(event.keyCode,'vol1');"/></td>
        </tr>
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"></td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol1</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat1</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol2</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat2</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Vol3</td>
            <td style="border-right-style:hidden; border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Sat3</td>
            <td style="border-bottom-style:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">Harga</td>
        </tr>
        <tr style="border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;">
            <td style="text-align:center; border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol1_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat1');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat1_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'vol2');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol2_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat2');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat2_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'vol3');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="vol3_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'sat3');"/></td>
            <td style="border-right-style:hidden; border-bottom-color:black;border-style-bottom:hidden;border-spacing:3px ;padding:3px 3px 3px 3px;border-collapse:collapse;"><input type="text" id="sat3_edit" style="width: 90px;" onkeypress="javascript:enter(event.keyCode,'harga');"/></td>
            <td style="border-spacing:3px ;padding:3px 3px 3px 3px;border-bottom-color:black;"><input type="text" id="harga_edit" style="width: 175px; text-align: right;"  onkeypress="javascript:enter(event.keyCode,'uraian');return(currencyFormat(this,',','.',event))"/>
            </td>
        </tr>  
        
        <tr>
        <td colspan="8">&nbsp;
        </td>
        </tr>

        <tr>
        <td colspan="8" align="center">
        <button class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:pilih_edit();">Simpan</button>
        <button class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:kembali_edit();">Kembali</button>
        </td>
        </tr>
        
    </table>
    </fieldset>  
</div>

</div>  	
</body>
</html>