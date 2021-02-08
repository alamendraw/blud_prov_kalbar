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
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
  
  <script type="text/javascript">
        $.fn.datebox.defaults.formatter = function(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return d+'-'+m+'-'+y;
        }
        
        var tipe = '';
        var data_api =[];
        $(document).ready(function() {            
            load_table();
            $("#form_periode").hide();
            $("#form_rekening").hide();
            $("#tombol").hide();
            
            $("#rd_periode").on('change', function(){
                tipe = this.value;
                $("#form_periode").show();
                $("#tombol").show();
                $("#form_rekening").hide();
            });
            $("#rd_rekening").on('change', function(){
                tipe = this.value;
                $("#form_rekening").show();
                $("#tombol").show();
                $("#form_periode").hide();
            });
            $('#dd1').datebox({
                required:true
            });
            $('#dd2').datebox({
                required:true
            });

            $('#cb_rekening').combogrid({  
                panelWidth:500,  
                idField:'kd_rek5',  
                textField:'nm_rek5',  
                mode:'remote',
                url:'<?php echo site_url(); ?>/C_integrasi/get_rek5_pendapatan',  
                columns:[[  
                    {field:'kd_rek5',title:'Kode Rekening',width:100},  
                    {field:'nm_rek5',title:'Nama Rekening',width:400}    
                ]],  
                onSelect:function(rowIndex,rowData){
                    
                }  
            }); 
           
        });
        
    function proses(){ 
        if(tipe=='periode'){
            tgl1 = $("#dd1").datebox('getValue').split('-');
            tgl2 = $("#dd2").datebox('getValue').split('-');
            tanggal1 = tgl1[2]+'-'+tgl1[1]+'-'+tgl1[0];
            tanggal2 = tgl2[2]+'-'+tgl2[1]+'-'+tgl2[0];

            $.ajax({
                type: "GET",
                url: "http://36.89.105.74:6060/api_bendahara/BendaharaPenerimaan/stsperiode",
                data: {'tglawal': tanggal1, 'tglakhir': tanggal2, 'SIMRS-KEY': 'msm-af2780ascdAds'},
                dataType: "json",
                success: function (response) {
                    if(response.status==false){
                        alert(response.message);
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?= site_url('C_integrasi');?>/save_data",
                            data: {'data': response.dataSTS},
                            dataType: "json",
                            success : function(data){
                                console.log(data);
                                load_table();
                            }
                        });
                    }
                }
            });

        }else{
            rek = $("#cb_rekening").combogrid("getValue");  
            $.ajax({
                type: "GET",
                url: "http://36.89.105.74:6060/api_bendahara/BendaharaPenerimaan/stsakun",
                data: {'kd_rek5': rek, 'SIMRS-KEY': 'msm-af2780ascdAds'},
                dataType: "json",
                success: function (response) { 
                    if(response.status==false){
                        alert(response.message); 
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?= site_url('C_integrasi');?>/save_data",
                            data: {'data': response.dataSTS},
                            dataType: "json",
                            success : function(data){
                                console.log(data);
                                load_table();
                            }
                        });
                    }
                }
            });
           
            
        }
 
        load_table();
    }
     
    function load_table(){        
        $('#dg').edatagrid({
            url: "<?= site_url('C_integrasi');?>/data_api",
            idField:'id',            
            rownumbers:"true", 
            fitColumns:"true",
            singleSelect:"true",
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",
            pagination:"true",
            nowrap:"true",                       
            columns:[[
                {field:'no_terima', title:'Nomor Terima', width:20},
                {field:'tgl_terima', title:'Tanggal', width:15},
                {field:'kd_rek5', title:'Rekening', width:10},
                {field:'nilai', title:'Nilai', width:25, align:"right"},
                {field:'keterangan', title:'Keterangan', width:50}
            ]],
            onSelect:function(rowIndex,rowData){
            
                                        
            },
            onDblClickRow:function(rowIndex,rowData){
            
            }
            
        });
       
    }       

  
   </script> 

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INTEGRASI PENERIMAAN</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
            <td colspan="4">  
                <input type="radio" class="easyui-radiobutton" name="tipe" id="rd_periode" value="periode"> Periode
           
                <input type="radio" class="easyui-radiobutton" name="tipe" id="rd_rekening" value="rekening"> Rekening
            </td> 
        </tr>
        <tr> 
            <td width="40%">
                <div id="form_periode">
                    <input id="dd1" type="text" class="easyui-datebox" required="required"> s/d 
                    <input id="dd2" type="text" class="easyui-datebox" required="required">
                </div>

                <div id="form_rekening">
                    <input type="text" id="cb_rekening" style="width:330px;"/>
                </div> 
            </td>
            <td colspan="3" width="60%"> 
                <div id="tombol">
                    <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:proses()">Proses</a>
                </div>
            </td> 
            
        </tr>
        <tr>
            <td colspan="4"> &nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">
                <table id="dg" title="LISTING DATA INTEGRASI" style="width:900px;height:365px;" > </table>
            </td>
        </tr>
    </table>    
    
        
 
    </p> 
    </div>   
</div>
 
</body>

</html>