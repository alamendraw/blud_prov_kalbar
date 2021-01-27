
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
  <style>    
    #tagih {
        position: relative;
        width: 822px;
        height: 50px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';

    var kdskpd='';
    var kdrek5='';
    
    var jang='';
    var jper='';
    var ctk='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 50,
                width: 822            
            });
            $('input[name=cetak]').val(['']);
                     
        });

   

   
     $(function(){
    $('#ttd').combogrid({  
        panelWidth:550,  
        idField:'nip',  
        textField:'nip',  
        mode:'remote',
        url:'<?php echo base_url(); ?>index.php/tukd_laporan/ttd',  
        columns:[[  
            {field:'nip',title:'Nip',width:150},  
            {field:'nama',title:'Nama',width:200},    
            {field:'jabatan',title:'Jabatan',width:200},    
        ]],
        onSelect:function(rowIndex,rowData){
            nip = rowData.urut;
            $("#nmttd").attr("value",rowData.nama);
            $("#ttd").attr("value",rowData.nip);
           
        }  
        }); 
    });
  
   $(function(){
    $('#ttd_tim').combogrid({  
        panelWidth:550,  
        idField:'nip',  
        textField:'nip',  
        mode:'remote',
        url:'<?php echo base_url(); ?>index.php/tukd_laporan/ttd_tim',  
        columns:[[  
            {field:'nip',title:'Nip',width:150},  
            {field:'nama',title:'Nama ',width:200},    
            {field:'jabatan',title:'Jabatan',width:200},    

        ]],
        onSelect:function(rowIndex,rowData){
            nip_tim = rowData.urut;
            $("#nmttd_tim").attr("value",rowData.nama);
            $("#ttd_tim").attr("value",rowData.nip);
           
        }  
        }); 
    });

  

function opt1(val){        
        jang = val; 
                        
    }    
    
    function opt2(val){        
        jper = val; 
                        
    }  
     
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
         $('#tgl_cetak').datebox({  
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
        $("#tagih").hide();
    });   
        
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
   
    function cetak(kode)
        {
           
            var convert =kode;
            ctgl1       = $('#dcetak').datebox('getValue');
            ctgl2       = $('#dcetak2').datebox('getValue');
            tgl_cetak   = $('#tgl_cetak').datebox('getValue');
            var nipang  =nip;
            var nipbp   =nip_tim;

            var url    = "<?php echo site_url(); ?>/tukd_laporan/cetak_bku_penerimaan_blud";     
            window.open(url+'/'+convert+'/'+ctgl1+'/'+ctgl2+'/'+tgl_cetak+'/'+nipang+'/'+nipbp, '_blank');
            window.focus();
           
            }
    
     
     function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        };
          
        
    </script>

    <STYLE TYPE="text/css"> 
         input.right{ 
         text-align:right;
     }
          #content{
            padding-top:30px;
        }

        .form-table{
            width: 100%;
        }

        .form-table tr td:first-child{
            width: 20%;
            text-align: right;
            padding-right: 10px;
        }

        .form-table tr td:nth-child(2){
            width: 2%;
        }


         .form-table tr td > select{
            min-width: 100px;
            margin: 0;
        }

         .form-table tr td > input[type="submit"]{
            min-width: 70px;
        }

        .btn{
            border: none;
            background: #428bca;
            color: white;
            padding: 10px 20px;
            display: inline-block;
        }

        .btn{
            text-decoration: none;
        }
         .btn:hover{
            background: #176391;
        }
         #kanan{
        float: right; 
         } 
    </STYLE> 

</head>
<body>

<div id="content">


<h3> BKU PENERIMAAN BLUD</h3>
 <fieldset>
    
    <p align="right">         
        <table id="sp2d" title="Cetak;"  >   
        <tr>
            <td colspan="3" width="10%"><b>Periode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <input type="text" id="dcetak" style="width: 100px;" /> s.d. <input type="text" id="dcetak2" style="width: 100px;" />
            </td>
        </tr>
         <tr >
                <td width="30%"><b>Tanda Tangan Anggaran</b></td>
                <td colspan="2" width="50%"><input id="ttd" name="ttd" style="width: 150px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmttd" name="nmttd" style="width: 300px; border:0;" /></td>
            </tr>
            
            <tr >
                <td width="30%"><b>Tanda Tangan Bendahara Penerimaan</b></td>
                <td colspan="2" width="50%"><input id="ttd_tim" name="ttd_tim" style="width: 150px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmttd_tim" name="nmttd_tim" style="width: 300px; border:0;" /></td>
            </tr>
            <tr>
            <td colspan="3" width="10%"><b>Tanggal Cetak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <input type="text" id="tgl_cetak" style="width: 100px;" />
            </td>
        </tr>
        

        <tr >
            <td colspan="4"><a class="btn" iconCls="icon-print" plain="true" onclick="javascript:cetak(1);">Cetak</a>
            <a class="btn" iconCls="icon-excel" plain="true" onclick="javascript:cetak(2);">Cetak excel</a>
            <a class="btn" iconCls="icon-word" plain="true" onclick="javascript:cetak(3);">Cetak word</a></td>
        </tr>
        
        </table>                      
    </p> 
    
</fieldset>
</div>


    
</body>

</html>