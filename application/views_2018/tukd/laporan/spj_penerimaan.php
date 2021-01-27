
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
   
    <script type="text/javascript"> 
    var nip='';
    var kdskpd='';
    var kdrek5='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 400,
                width: 800            
            });  
            get_skpd();           
        });   
     function get_skpd()
        {
        
            $.ajax({
                url:'<?php echo base_url(); ?>index.php/tukd_blud/config_skpd',
                type: "POST",
                dataType:"json",                         
                success:function(data){
                $("#sskpd").attr("value",data.kd_skpd);
                $("#nmskpd").attr("value",data.nm_skpd);
                kdskpd = data.kd_skpd;
                v_skpd(kdskpd);
              }                                     
            });
             
        }
    function v_skpd(tp){    
    $(function(){
        $('#pa').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/tukd_laporan/ttd_pa/'+tp,  
                    idField:'nip',                    
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'nip',title:'NIP',width:60},  
                        {field:'nama',title:'NAMA',align:'left',width:100}
                        
                        
                    ]],
                    onSelect:function(rowIndex,rowData){
                    nip_pa = rowData.nip;
                    
                    }   
                });
        
    });
    $(function(){
        $('#bk').combogrid({  
                panelWidth:500,  
                url: '<?php echo base_url(); ?>/index.php/tukd_laporan/ttd_bp/'+tp,  
                    idField:'nip',                    
                    textField:'nama',
                    mode:'remote',  
                    fitColumns:true,  
                    columns:[[  
                        {field:'nip',title:'NIP',width:60},  
                        {field:'nama',title:'NAMA',align:'left',width:100}
                        
                        
                    ]],
                    onSelect:function(rowIndex,rowData){
                    nip_bk = rowData.nip;
                    
                    }   
                }); 
        
    });
    }
    
    $(function(){
    $('#tgl').datebox({  
            required:true,
            formatter :function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return y+'-'+m+'-'+d;
            }
        });
        
    
    });
    
    function validate1(){
        var bln1 = document.getElementById('bulan1').value;
        
    }
   
       function cetak()
        {
            var ver = $('input[name=cetak]:checked').val();
            var skpd   = kdskpd; 
            var bulan   =  document.getElementById('bulan1').value;
            var nip1_   = $("#pa").combogrid("getValue") ;
            var nip1=nip1_.split(" ").join("%20");
            var nip2_   = $("#bk").combogrid("getValue") ;
            var nip2=nip2_.split(" ").join("%20");
            var tgl_c =$('#tgl').datebox('getValue');
            
            var url    = "<?php echo site_url(); ?>/tukd_laporan/cetak_spj_penerimaan";
            window.open(url+'/'+skpd+'/'+bulan+'/'+nip1+'/'+nip2+'/'+tgl_c+'/'+ver, '_blank'); 
            window.focus();

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



<h3 align='center'>CETAK LAPORAN PERTANGGUNG JAWABAN PENERIMAAN-BLUD(SPJ-BLUD)</></h3>

    <fieldset>
    <p align="center">         
        <table id="sp2d" border='0'title="Cetak SPJ" align="center"style="height:200px;width:100%;" >  
        <tr >
            <td width="35%" height="40" align="right"><B>SKPD</B></td>
            <td width="80%">&nbsp;<input id="sskpd" readonly='true' name="sskpd" style="width: 150px; height:20px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" style="width: 350px; border:0;" /></td>
        </tr>
        <tr >
            <td width="35%" height="40"  align="right"><B>BULAN</B></td>
            <td ><?php echo $this->rka_model->combo_bulan('bulan1','onchange="javascript:validate1();"'); ?> </td>
        </tr>
        <tr>
            <td width="35%" height="40"  align="right"><B>Sumber Anggaran</B></td>
            <td>
            <input type="radio" name="cetak" id="cetak" value="1" checked="true" /><label for="cetak">Anggaran Penyusunan</label>
            <input type="radio" name="cetak" id="cetak2" value="2"/><label for="cetak2">Anggaran Perubahan</label>
            </td>
        </tr>
        <tr >
            <td width="35%" height="40"  align="right"><B>Pengguna Anggaran</B></td>
            <td>&nbsp;<input id="pa" name="pa" style="width: 150px;height:20px;" /></td>
        </tr>
        <tr >
            <td width="35%" height="40"  align="right"><B>Bendahara Penerimaan</B></td>
            <td>&nbsp;<input id="bk" name="bk" style="width: 150px;height:20px;" /></td>
        </tr>
        <tr >
            <td width="35%" height="40"  align="right"><B>Tanggal Cetak</B></td>
            <td>&nbsp;<input id="tgl" name="tgl" style="width: 150px;height:20px;" /></td>
        </tr>
        <tr >
            
            <td colspan="2" align='center'>&nbsp;</td>
        </tr>
        <tr >
            
            <td colspan="2" align='center'><a class="easyui-linkbutton" id="btn" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a></td>
        </tr>
        
        </table>                      
    </p> 
    </fieldset>
    


</div>

    
</body>

</html>



