$(document).ready(function(){
    $("#tab_rab").tabs('select',0);
    
    $('#tab_rab').tabs({
		onSelect:function(title,index){
			var idx = index;
			if(idx == '0'){
			    if(plappend_head==true){
			        $('#input_header').show();
                	$('#listing_header').hide();
			    }else{
                    $('#input_header').hide();
                	$('#listing_header').show(1000);
                	$('#dg_header').datagrid('reload');
                }
			}else{
			     if(idx=='1'){
			        var row = $('#dg_header').datagrid('getSelected');
                   
                	if(row){
                	   lcid = row.id_proyek
                       $('#ind_idproyek_h').val(row.id_proyek);
                       $(function(){ 
                    		$('#dg_detail').datagrid({
                    			url: '<?php echo base_url(); ?>proyek/load_rabdet',
                    			queryParams:({cari:'',id_proyek:lcid})
                    		});    
                    	}); 
                   
                       
                	   $('#input_detail').hide();
            	       $('#listing_detail').show(1000);
            	       $('#dg_detail').datagrid('reload');
                	}else{
                	   $.messager.alert('Input Data Detail','Pilih baris data header !','warning');
                       $("#tab_rab").tabs('select',0);
                	} 
                 }else{
                    if(idx=='2'){
                        var row1 = $('#dg_header').datagrid('getSelected');
                        var row2 = $('#dg_detail').datagrid('getSelected');
                        
                        if(row1 && row2){
                    	   $('#input_rinci').hide();
                	       $('#listing_rinci').show(1000);
                	       $('#dg_rinci').datagrid('reload');
                    	}else{
                    	      if(!row1){
                    	         $.messager.alert('Input Data Header','Pilih baris data Header !','warning');
                                 $("#tab_rab").tabs('select',0); 
                    	      }else{
                    	        if(!row2){
                        	         $.messager.alert('Input Data Rincian Detail','Pilih baris data detail !','warning');
                                     $("#tab_rab").tabs('select',1); 
                        	      }   
                    	      }
                               
                    	   
                    	} 
                    }
                 }
			}
		}
	});	
    
    
    $('#dg_header').datagrid({  
		url:'<?php echo base_url();?>proyek/load_rab',
		toolbar: '#toolbar_head',
		idField: 'id_proyek',
		nowrap: false,
		pagination: true,
		rownumbers: true,
		fitColumns: false,
		singleSelect: true,
		remoteSort: true,  
  		columns:[[
  			{field:'id_proyek',title:'<b>Id Proyek</b>',width:100, sortable:true,halign:"center"},  
  			{field:'rab_tgl',title:'<b>Tanggal RAB</b>',width:100,halign:"center",align:"center"},
  			{field:'cn_rab',title:'<b>Nilai RAB</b>',width:150,halign:"center",align:"right"},  
  			{field:'ket_rab',title:'<b>Keterangan</b>',width:700,halign:"center"}
  		]],
  		onSelect:function(rowIndex,rowData){
  			lcnm = rowData.id_proyek+' - '+rowData.nm_proyek;
            lcnilai = rowData.cn_rab;
            lctgl = rowData.rab_tgl;
            $('#nm_proyek_h').val(lcnm);
            $('#nm_proyek_d').val(lcnm);
            $('#nilai_proyek').val(lcnilai);
            $('#tgl_proyek').val(lctgl);
            
            
 		}
	});
    
    
    $('#dg_detail').datagrid({  
		url:'<?php echo base_url();?>proyek/load_rabdet',
		toolbar: '#toolbar_detail',
		idField: 'kode',
		nowrap: false,
		pagination: true,
		rownumbers: true,
		fitColumns: false,
		singleSelect: true,
		remoteSort: true,  

  		columns:[[
  			{field:'kd_tabrab',title:'<b>Kode</b>',width:75, sortable:true,halign:"center"},  
  			{field:'rab_ket',title:'<b>Tahapan</b>',width:400,halign:"center"},
  			{field:'crab_qty',title:'<b>Jumlah</b>',width:70,halign:"center",align:"center"},  
  			{field:'rab_satuan',title:'<b>Satuan</b>',width:70,halign:"center",align:"center"},
            {field:'crab_harga',title:'<b>Harga</b>',width:100,halign:"center",align:"right"},
            {field:'crab_totharga',title:'<b>Total</b>',width:100,halign:"center",align:"right"}
  		]],
  		onSelect:function(rowIndex,rowData){
  			
 		}
	});
    
    
    $('#dg_rinci').datagrid({  
		url:'<?php echo base_url();?>master/load_produk',
		toolbar: '#toolbar_rinci',
		idField: 'kode',
		nowrap: false,
		pagination: true,
		rownumbers: true,
		fitColumns: false,
		singleSelect: true,
		remoteSort: true,  

  		columns:[[
  			{field:'kode',title:'Kode',width:10, sortable:true,halign:"center"},  
  			{field:'nama',title:'Nama',width:30,halign:"center"},
  			{field:'uraian',title:'Uraian Produk',width:40,halign:"center"},  
  			{field:'status',title:'Status Kode',width:10,halign:"center"},
            {field:'nm_unit',title:'Kode Unit',width:10,halign:"center"}
  			
  		]],
  		onSelect:function(rowIndex,rowData){
  			kode = rowData.kode;
  			kode_unit = rowData.kode_unit;
  			nama = rowData.nama;
  			uraian = rowData.uraian;
  			status = rowData.status;
            kode_lm = rowData.kode_lm;
  			set_field(kode,kode_unit,nama,uraian,status,kode_lm);
 		}
	});
    
    
    
    $('#cmb_area_h').combogrid({
		panelWidth:300,  
		idField:'kode',  
		textField:'kd_nm',  
		mode:'remote',
		url:'<?php echo base_url(); ?>cmain/get_area',  
		columns:[[  
			{field:'kode',title:'Kode',width:80},  
			{field:'nama',title:'Nama',width:220}    
		]],
        onSelect:function(rowIndex,rowData){
            lcarea = rowData.kode;
            lcunit = $('#cmbunit_h').combogrid('getValue');
            
            if(lcunit==''){
                return false;
            }else{
               $(function(){ 
            		$('#dg_header').datagrid({
            			url: '<?php echo base_url(); ?>proyek/load_rab',
            			queryParams:({cari:'',kd_unit:lcunit,kd_area:lcarea})
            		});    
            	}); 
                
            }
           
            $('#dg_header').datagrid('reload');
            $('#dg_header').datagrid('clearSelections');
        }
	});
    
    $('#cmbunit_h').combogrid({
		panelWidth:300,  
		idField:'kode',  
		textField:'kd_nm',  
		mode:'remote',
		url:'<?php echo base_url(); ?>cmain/get_listunit',  
		columns:[[  
			{field:'kode',title:'Kode',width:80},  
			{field:'nama',title:'Nama',width:220}    
		]],
        onSelect:function(rowIndex,rowData){
            lcarea =  $('#cmb_area_h').combogrid('getValue');
            lcunit = rowData.kode;
            
            $(function(){ 
        		$('#dg_header').datagrid({
        			url: '<?php echo base_url(); ?>proyek/load_rab',
        			queryParams:({cari:'',kd_unit:lcunit,kd_area:lcarea})
        		});    
        	});
            $('#dg_header').datagrid('reload');
            $('#dg_header').datagrid('clearSelections');
        }
	});
    
    $('#cmbunit_d').combogrid({
		panelWidth:300,  
		idField:'kode',  
		textField:'kd_nm',  
		mode:'remote',
		url:'<?php echo base_url(); ?>cmain/get_listunit',  
		columns:[[  
			{field:'kode',title:'Kode',width:80},  
			{field:'nama',title:'Nama',width:220}    
		]],
        onSelect:function(rowIndex,rowData){
            lcunit = rowData.kode;
            $('#kdunit_h').val(lcunit);
            $(function(){ 
        		$('#dg_detail').datagrid({
        			url: '<?php echo base_url(); ?>master/load_produk',
        			queryParams:({cari:'',kd_unit:lcunit})
        		});    
        	});
            $('#dg_detail').datagrid('reload');
            $('#dg_detail').datagrid('clearSelections');
        }
	});
    
    $('#inh_idproyek').combogrid({
		panelWidth:410,  
		idField:'kode',  
		textField:'kode',  
		mode:'remote',
		url:'<?php echo base_url(); ?>proyek/get_idproyek_rab',  
		columns:[[  
			{field:'kode',title:'Kode',width:100},  
			{field:'nama',title:'Nama',width:300}    
		]],
        onSelect:function(rowIndex,rowData){
            lcnm = rowData.kd_nm;
            $('#nm_proyek_h').val(lcnm);
        }
	});
    
    
     $('#ind_kdtabrab').combogrid({
		panelWidth:410,  
		idField:'kode',  
		textField:'kode',  
		mode:'remote',
		url:'<?php echo base_url(); ?>proyek/get_kdtab_rab',  
		columns:[[  
			{field:'kode',title:'Kode',width:100},  
			{field:'nama',title:'Nama',width:300}    
		]],
        onSelect:function(rowIndex,rowData){
            lcnm = rowData.nama;
            $('#ind_rabket').val(lcnm);
        }
	});
    
    $('#ind_satuan').combogrid({
		panelWidth:300,  
		idField:'kode',  
		textField:'nama',  
		mode:'remote',
		url:'<?php echo base_url(); ?>master/get_listsatuan',  
		columns:[[  
			{field:'kode',title:'Kode',width:80},  
			{field:'nama',title:'Nama',width:220}    
		]]
	});
    
    	
});