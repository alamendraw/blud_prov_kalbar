<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/bootstrap-progressbar-3.1.0.css"/>
    <script type='text/javascript' src="<?php echo base_url();?>bootstrap/bootstrap-3.1.0.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url();?>bootstrap/bootstrap-progressbar.js"></script>
  <style>    
    #tagih {
        position: relative;
        width: 922px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var bln='';
    var kdrek5='';
    var nbln='';
    var lasdate='';
    var cekit=0;

    var plappend = true;
    var plappend_head = false;
    var plappend_det = false; 
    var plappend_rin = false;
    var rec=0;
    var satuan=0;
    var posisi=0;
    var sukses=0;
    var gagal=0;
    var ujung=true;
    var current=0;
    var aa=0;
    var lcpesan="";

    
     $(document).ready(function() {
            $('#input-box').show(1000);
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });
            $('#tombol_transfer').hide(); 

            $('#bulan').combogrid({  
               panelWidth:120,
               panelHeight:300,  
               idField:'bln',  
               textField:'nm_bulan',  
               mode:'remote',
               url:'<?php echo base_url(); ?>index.php/utilities/bulan',  
               columns:[[ 
                   {field:'nm_bulan',title:'Nama Bulan',width:100} 
               ]],
               onSelect:function(rowIndex,rowData){
                    posisi  =0;
                    sukses  =0;
                    gagal   =0;
                    current =0;
                    aa      =0;

                    bln = rowData.bln;
                    nbln= rowData.nm_bulan;
                    apbd(bln);
                    var today = new Date();
                    var lastOfMonth = new Date(today.getFullYear(),bln, 0);
                    lasdate= lastOfMonth.getDate();
                    $('#tombol_transfer').hide(); 
                    
                }   
           
           });

            //cek_mon();
        });


$(function(){   
        $('#list_telah').hide();
        $('#tombol_telah').hide();
        
     $('#dg').edatagrid({
        pageSize:20,
        height: 750,
        //url: '<?php echo base_url(); ?>/index.php/utilities/load_transfer',
        idField:'no_spm',            
        rownumbers:"true", 
        fitColumns:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",  
        singleSelect:false,
        columns:[[
            {field:'ck',
            checkbox:true,
            title:'ck',
            align:"center"},
            {field:'no_spm',
            title:'No. SPM',
            width:20,
            align:"left"},
            {field:'no_spp',
            title:'No. SPP',
            width:20,
            align:"left"},
            {field:'kd_skpd',
            title:'Kode SKPD',
            width:20,
            align:"left"},
            {field:'nm_skpd',
            title:'Nama SKPD',
            width:30,
            align:"left"}
        ]],
        onCheck:function(rowIndex,rowData){
          no_spm = rowData.no_spm;
          no_spp = rowData.no_spp;
          kd_s = rowData.kd_skpd;
          nm_s = rowData.nm_skpd;
          get(no_spm,no_spp,kd_s,nm_s); 
          lcidx = rowIndex;                 
        },
        rowStyler: function(index,rowData){
            return 'background-color:#31B404;color:#fff;';
        }

        });

 });

        
function cek_mon(){
    var d = '<?php echo date('m');?>';
    if (d <=6)
    {
         $("#awal").attr("checked",true);
    }else{
        $("#ubah").attr("checked",true);
    }
}

function AddItems(isi,pesan,baris,tambah){
        var mySel = document.getElementById("isidata"); 
        var myOption; 

        if (tambah=='1'){
                posisi=posisi+satuan;
                $('.progress-bar').attr({'aria-valuetransitiongoal': posisi});
                $('.progress-bar').progressbar({display_text: 'fill'});
                $('.h-default-themed .progress-bar').progressbar();
            }

        myOption = document.createElement("Option"); 
        myOption.text = isi; 
        myOption.value = isi; 
        if(baris =='0'){
            myOption.style = 'color:white;font-family:courier new;'; 
        }else if(baris=='1'){
            myOption.style = 'color:red;font-family:courier new;';          
        }else if(baris=='2'){
            myOption.style = 'color:#05E405;font-family:courier new;font-size:14px;';
        }
        mySel.add(myOption);            
        bawah();

        if(current>=rec){
                
                setTimeout(function(){
                    $('.progress-bar').attr({'aria-valuetransitiongoal': 0});
                    $('.progress-bar').progressbar({display_text: 'fill'});
                    $('.h-default-themed .progress-bar').progressbar();
                },4000);

            }
    }

    function bawah() {
        var objDiv = document.getElementById("isidata");
        objDiv.scrollTop = objDiv.scrollHeight;
        return false;
    }
    
    function record(bln){   
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/utilities/hitrecord',
                    data: ({bulan:bln}),
                    dataType:"json",
                    success:function(data){
                        rec=(data.jumlah);
                        if(rec>0){
                           satuan=100/rec;
                        }

                        
                        AddItems('Sejumlah ('+rec+'), Insert Temp SP2D Selesai ...!','','2','0');
                        AddItems('Proses Transfer Data SP2D BLUD dilakukan ...','','2','0');
                        isi_list(rec,bln);  
                        
                    }
                });
            });  
        }

        function isi_list(rec,bln){
            if (rec>0){
                var a=0;
                for (var i=1;i<=rec ;i++ )
                {
                      setTimeout(function(){
                            ambil_baris(a,bln,rec);
                            a++;
                      },rec*i);
                }
            }else{
                alert('Data Tidak Ditemukan');
            }
        }

   

    function ambil_baris(cbaris,bln,rec){
            var a='1';
            var skpd=0;
            posisi=0;
            sukses=0;
            gagal=0;
            current=0;
            aa=0;
       
            var alamat='<?php echo base_url(); ?>/index.php/utilities/proses_transfer';
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: alamat,
                    data: ({baris:cbaris,bulan:bln}),
                    dataType:"json",
                    success:function(data){
                        current++;
                        AddItems(data.isi,data.pesan,'0','1');
                            if (rec==current){
                                AddItems('{Pengiriman Data SP2D BLUD Bulan '+current+' Selesai ... (Sukses : '+current+') (Gagal : 0)','','2','0');
                                swal("Good job!", "Calculate Transaction Finish !!", "success");
                            }
                         aa++;     
                    }
                });
            });             
        
        }
    
    function apbd(bln){
            document.getElementById('isidata').innerHTML = "";
            AddItems('Proses Perhitungan Realisasi Anggaran Bulan '+nbln,'2','2','0');
            AddItems('Cek Koneksi Server Keuangan Pidie','0','0','0');
            //$('#tombol').linkbutton('disabled');
            cekkon(bln);
            //record(bln);
    }

    function cekkon(bln){
           
            var alamat='<?php echo base_url(); ?>/index.php/utilities/cek_con';
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: alamat,
                    dataType:"json",
                    success:function(data){
						$pesan = data.pesan;
						$isi   = data.isi;
                		if($pesan=='1'){
							AddItems($isi,'','1','0');
                		}else{
                			AddItems($isi,'','0','0');
                			record(bln);
                			AddItems('Proses Insert Temp SP2D dilakukan ...','2','2','1');
                       
                		}
                            
                    }
                });
            });             
        
        }
    

    function transfer(){
    
    var rows=$('#dg').datagrid('getSelections');

     if(rows.length==0){
        alert ('Silahkan Pilih Data Terlebih Dahulu!');
     return;
    }  
    
    nospm=[];
    nospp=[];
    for (var i=0;i<rows.length;i++){
        nospm.push(rows[i].no_spm);
        nospp.push(rows[i].no_spp);
    }  
    
    string_no_spm =  nospm.join('|');
    string_no_spp =  nospp.join('|'); 

    //console.log(string_no_spm);
            
     $.get('<?php echo base_url('index.php/utilities/backup_data')?>',{str_no_spm:string_no_spm,str_no_spp:string_no_spp},
    function(data){
        alert('Data Berhasil di Transfer ');
        $('#dg').edatagrid('reload');
    }); 
    
    } 

    function cari(){
    var kriteria = '';
    $(function(){ 
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/utilities/load_transfer',
        queryParams:({cari:kriteria})
        });        
     });
    }
  
     
    function valid_com(){
        var cek=document.getElementById('awal').checked;
        var cek1=document.getElementById('ubah').checked;
        if(cek==true && cek1 == false){
            $("#awal").attr("checked",true);
            $("#ubah").attr("checked",false);
        }else if(cek1==true && cek==false){
            $("#awal").attr("checked",false);
            $("#ubah").attr("checked",true);
        }else if(cek1==false && cek==false){
            $("#awal").attr("checked",false);
            $("#ubah").attr("checked",true);
        }else{
            $("#awal").attr("checked",false);
            $("#ubah").attr("checked",false);
        }
    
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



<h4 align="center"><u><b><a>TRANSFER DATA SP2D BLUD ONLINE DPKAD PIDIE</b></u></h4>     
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Proses Transfer Data" style="width:925px;height:400px;" >          
        <tr>
            <td colspan="3" style="border-bottom: double 1px red;"><i>Proses perhitungan SP2D akan memakan waktu &plusmn; 15 Menit !!</i></td>
        </tr>
      
        <tr>
            <td width="10%">S.D BULAN</td>
            <td width="1%">:</td>
            <td width="79%"><input id="bulan" name="bulan" style="width: 100px;" /></td>
        </tr>
      <!--   <tr>
         <td  width="100%" colspan="3" align="center" id="tombol_transfer">
              <INPUT TYPE="button" VALUE="TRANSFER NOW ..." ONCLICK="javascript:transfer();" style="height:40px;width:150px;background-color:#31B404;color:#fff;">
         </td>      
      
      </tr>  -->
        
        </table >

        
        <div class="accordion" style="width:auto; height:370px; border:#999999 solid 0px;">
                
                <div id="title-box"></div>
                <div id="input-box">
          
                  
                        <div class="progress progress-striped active" style="height:25px;">
                            <div class="progress-bar progress-bar-striped"  role="progressbar" aria-valuetransitiongoal="0" id="prog"></div>
                        </div>
                        <select name="isidata" id="isidata" multiple="multiple" style="width:100%;height:320px;background-color:#000000;border:0px" disabled="true">
                        </select>
                                    
                    
                    
                 </div>
              
        </div>
        
    </p>
</div>
</div>   
</body>

</html>