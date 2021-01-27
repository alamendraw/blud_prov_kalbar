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
  <style>     
    #tagih {
        position: relative;
        width: 922px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
    var kdskpd='';
    var kdrek5='';
    var bulan='';
    
     $(document).ready(function() {
            $("#accordion").accordion();                         
        });   
    $(function(){
    $('#sskpd').combogrid({  
        panelWidth:630,  
        idField:'kd_skpd',  
        textField:'kd_skpd',  
        mode:'remote',
        url:'<?php echo base_url(); ?>index.php/akuntansi_blud/skpd',  
        columns:[[  
            {field:'kd_skpd',title:'Kode SKPD',width:100},  
            {field:'nm_skpd',title:'Nama SKPD',width:500}    
        ]],
        onSelect:function(rowIndex,rowData){
            kdskpd = rowData.kd_skpd;
            $("#nmskpd").attr("value",rowData.nm_skpd);
            $("#skpd").attr("value",rowData.kd_skpd);
           
        }  
        }); 
    });
    
        
     
    function submit(){
        if (ctk==''){
            alert('Pilih Jenis Cetakan');
            exit();
        }
        document.getElementById("frm_ctk").submit();    
    }
        
    $(function(){
         $('#dcetak').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
    });

    $(function(){
         $('#dcetak2').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
    });
       
    $(function(){
        //$("#status").attr("option",false);
        $("#kode_skpd").hide();
    });   
     /*   
    function opt(val){        
        ctk = val; 
        if (ctk=='1'){
            $("#tagih").hide();
            $("#dcetak").datebox("setValue",'');
            $("#dcetak2").datebox("setValue",'');
        } else if (ctk=='2'){
           $("#tagih").show();
           } else {
            exit();
        } 
    } 
*/  

$(function(){   
         $('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
        
        
  $('#ttd').combogrid({  
                    panelWidth:600,  
                    idField:'nip',  
                    textField:'nip',  
                    mode:'remote',
                    url:'<?php echo base_url(); ?>index.php/tukd_blud/load_ttd/PA',  
                    columns:[[  
                        {field:'nip',title:'NIP',width:200},  
                        {field:'nama',title:'Nama',width:400}    
                    ]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd").attr("value",rowData.nama);
                    }  
  
                });
    $('#ttd2').combogrid({  
                    panelWidth:600,  
                    idField:'nip',  
                    textField:'nip',  
                    mode:'remote',
                    url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PPK',  
                    columns:[[  
                        {field:'nip',title:'NIP',width:200},  
                        {field:'nama',title:'Nama',width:400}    
                    ]],
                    onSelect:function(rowIndex,rowData){
                    $("#nmttd2").attr("value",rowData.nama);
                    }  
  
                });
});

    function opt(val){ 
        ctk = val; 
        if (ctk=='1'){
           // urll ='<?php echo base_url(); ?>index.php/akuntansi/cetak_lra_lo';
        } else if (ctk=='2'){
            $("#kode_skpd").show();
           // urll ='<?php echo base_url(); ?>index.php/akuntansi/cetak_lra_lo_unit/'+kdskpd+'/'+ctk;
        } else {
            exit();
        }          
       // $('#frm_ctk').attr('action',urll);                        
    } 
    
    function cetak($pilih){
            if($("#ttd").combogrid('getValue') ==0 || $("#tgl_ttd").combogrid('getValue')==0 ){
                alert("Sebagian Belum Terisi");
                exit();
            }
            var ttdx   = $("#ttd").combogrid('getValue');
            //var ttdz   = $("#ttd2").combogrid('getValue');
            var ttd1 =ttdx.split(" ").join("a");
            //var ttd2 =ttdz.split(" ").join("a");
            var tgl_ttd   = $("#tgl_ttd").combogrid('getValue');
            var pilih =$pilih;
            cbulan = $('#bulan').combogrid('getValue');
            if(ctk==1){
                urll ='<?php echo base_url(); ?>index.php/akuntansi_blud/cetak_lra_blud_sap/'+cbulan;
                if (bulan==''){
                alert("Pilih Bulan dulu");
                exit(); 
                }
            }else{
                urll ='<?php echo base_url(); ?>index.php/akuntansi/cetak_lra_unit/'+cbulan+'/'+kdskpd;
                if (kdskpd==''){
                alert("Pilih Unit dulu");
                exit();
                }if (bulan==''){
                alert("Pilih Bulan dulu");
                exit(); 
                }
            }
                    
                //var url    = "<?php echo site_url(); ?>/akuntansi/cetak_lra_lo";    
                window.open(urll+'/'+pilih+'/'+tgl_ttd+'/'+ttd1+'/sp3b', '_blank');
               // window.open("https://translate.google.com",window.print(),'_blank');
                window.focus();
            

        }



        
    $(function(){ 
                   $('#bulan').combogrid({  
                   panelWidth:120,
                   panelHeight:300,  
                   idField:'bln',  
                   textField:'nm_bulan',  
                   mode:'remote',
                   url:'<?php echo base_url(); ?>index.php/rka/bulan',  
                   columns:[[ 
                       {field:'nm_bulan',title:'Nama Bulan',width:700}    
                   ]],
                    onSelect:function(rowIndex,rowData){
                        bulan = rowData.nm_bulan;
                        $("#bulan").attr("value",rowData.nm_bulan);
                    }
               }); 
          });
    
        function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        };
        
      function pilih() {
       op = '1';       
      };   
     
        
    
    </script>

    <STYLE TYPE="text/css"> 
        table{
            border-style: hidden;
        }
        td{
            border-style: hidden;
        }
        tr{
            border-style: hidden;
        }
         input.right{ 
         text-align:right; 
         } 
    </STYLE> 

</head>
<body>

<div id="content">
<h3 style="border-left: 6px solid #2196F3!important;background-color: #ddffff!important; padding: 5px; width: 30%;">CETAK SP3B</h3>      
<div align="center">
        
        <table style="width: 75%; border-style: 2px solid; text-align: center; background-color: #e8e8e8; border-radius: 15px; ">

            <tr>
                <td colspan="2" style="text-align: right;"><h4>Bulan</h4></td>
                <td width="25%" style="text-align: left">        
                    &nbsp;<input type="text" id="bulan" style="width: 100px;" />
                    <input type="radio" name="cetak" value="1" onclick="opt(this.value)" /><b>SKPD</b>
                </td width="25%">
                <td width="20%"></td>
                
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;"><h4>Tanggal TTD</h4></td>
                <td width="25%" style="text-align: left">        
                    &nbsp;<input type="text" id="tgl_ttd" style="width: 100px;" />
                </td width="25%">
                <td width="20%"></td>               
                             
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="25%" style="text-align: right;"><h4>Pengguna Anggaran</h4></td>
                <td colspan="2" style="text-align: left">        
                    &nbsp;<input id="ttd" name="ttd" style="width: 170px;" />  
              
                    <input id="nmttd" name="nmttd" style="border-style: none; border-radius: 5px; text-align: left; background-color: #e8e8e8;" />
                </td>    
            </tr>
            <tr>
                <td colspan="4">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  TYPE="button" value="Layar" onclick="javascript:cetak(1);">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  TYPE="button" value="PDF" onclick="javascript:cetak(0);">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  TYPE="button" value="EXCEL"  onclick="javascript:cetak(2);">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px; margin-bottom: 20px "  TYPE="button" value="WORD"  onclick="javascript:cetak(3);"></td>
                </td>               
            </tr>
        </table>         

</div>
</div>
  
</body>

</html>