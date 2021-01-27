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
$(document).ready(function(){
    $("#load").hide();
});
            $(function(){ 
               $("#load").hide();
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
    

    
    function tothego(){
        $(document).ready(function(){
            $("#load").show();  
                    var bulan = $('#bulan').combogrid('getValue');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo base_url(); ?>/index.php/utilities/rekal_lpj/"+bulan,
                        success: function(data) {
                                $status = data;   
                                    if ($status=='1'){
                                           $("#load").hide();
                                        alert('Berhasil');
                                    } else{ 
                                            $("#load").hide();
                                        alert('Gagal');
                                    }  
                        }
                    });
            });
    }

        
    
    </script>


</head>
<body>

<div id="content">



<h3>REKAL SP3B</h3><BR>       
<div align="center">
       
        <table id="sp2d" title="Cetak" style="width:100%;height:800px; border-style: hidden;" >
            <tr> 
                &ensp; <input type="text" id="bulan" style="width: 100px;" /> <br><br>
                <button  style="height:30px;width:80px; background-color: #008CBA; cursor: pointer; color: white; border: none; border-radius: 5px "  onclick="javascript:tothegox();"> REKAL</button>
                <br><br><br><br>
            </tr>
            <tr>
                <DIV id="load" > <IMG SRC="<?php echo base_url(); ?>assets/images/proses.gif" BORDER="0" ALT=""></DIV>
            </tr>
        </table>                       

</div>

    
</body>

</html>