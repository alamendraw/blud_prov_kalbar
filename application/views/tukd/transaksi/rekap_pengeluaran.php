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
    
   
    
     function cetak($ctk){
        
        url='<?php echo base_url(); ?>index.php/tukd_blud/rekappengeluaran/'+$ctk;
        window.open(url+'/Rekap', '_blank');
        window.focus();
        
    }
        
    
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
<center><h3 style="border-left: 6px solid #2196F3!important;border-right: 6px solid #2196F3!important;background-color: #ddffff!important; padding: 5px; width: 30%;">REKAP PENGELUARAN</h3></center>      
<div align="center">
        
        <table style="width: 75%; border-style: 2px solid; text-align: center; background-color: #e8e8e8; border-radius: 15px; ">

            <tr>
                <td colspan="4">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  TYPE="button" value="Layar" onclick="javascript:cetak(1);">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  TYPE="button" value="PDF" onclick="javascript:cetak(2);">
                    <input style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  TYPE="button" value="EXCEL"  onclick="javascript:cetak(3);">
                    
                </td>               
            </tr>
        </table>         

</div>
</div>
  
</body>

</html>