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
<style>
        table{
            border-spacing: 0;
        }
        td{
            padding: 0px;
        }
        input{
            padding: 2px;
            border: 1px solid #ccc;
        }
        input:hover{
            border: 1px solid #000;
        }
        input:focus{
            border: 1px solid #f00;
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
         #kanan{
        float: right;
    }

</style>
    <script type="text/javascript">

    var cid = 0;
    var lcidx = 0;
    var dg='';
    var lcotori='';
    
 $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 220,
            width: 400,
            modal: true,
            autoOpen:false
        });
  });          



 function kosong(){
        $("#id_user").attr("value",'');
        $("#user_name").attr("value",'');
        $("#password").attr("value",'');
        $("#type").attr("value",'');
        $("#nama").attr("value",'');
        $("#skpd").attr("value",'');
        $("#cmbgroup").attr("value",'');
       /* $("#dg").combogrid("setvalue",'');
        $("#dg").combogrid("clear");*/
    };

  function back(){
        window.location = "<?php echo site_url(); ?>/master/user";
    }
    
    
 function simpan(){
        var cid_us = document.getElementById('id_user').value;
        var cuser = document.getElementById('user_name').value;
        var cpass = document.getElementById('password').value;
        var cnama = document.getElementById('nama').value;
        var cgroup      = document.getElementById('cmbgroup').value; 
    /*    var cskpd      = document.getElementById('skpd').value; */
        var ctype      = document.getElementById('type').value; 
        
        if (cuser==''){
            alert('User Name Tidak Boleh Kosong');
            exit();
        }
        if (cpass==''){
            alert('Password Tidak Boleh Kosong');
            exit();
        }
        if (cnama==''){
            alert('Nama Tidak Boleh Kosong');
            exit();
        }
        if (ctype==''){
            alert('Type Tidak Boleh Kosong');
            exit();
        }
       /* if (cskpd==''){
            alert('Kode SKPD Tidak Boleh Kosong');
            exit();
        }*/
        if (cgroup==''){
            alert('Group Tidak Boleh Kosong');
            exit();
        }

            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_toni',
                    data:({cidus:cid_us,cus:cuser,cpa:cpass,cty:ctype,cnm:cnama,cgroup:cgroup}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            kosong();      
                            back();
                        }
                    }
                });
            });    
     };
</script>
</head>
<body>
<div id="content">        
   <fieldset>
     <table align="center" style="width:100% ;">
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>      
           <tr>
                <td width="20%"><span style="font-weight:bold">ID USER</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="id_user" name="id_user" disabled="true" maxlength="3" style="width:40px; height:27px "/></td>  
            </tr>            
            <tr>
                <td width="20%"><span style="font-weight:bold">USER NAME</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="user_name" name="user_name" style="width:260px; height:27px"/></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">PASSWORD</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="password" name="password" style="width: 140px; height:27px" /></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">NAMA LENGKAP</span></td>
                <td width="1%">:</td>
                <td>&nbsp;&nbsp;<input type="text" id="nama" name="nama" style="width:260px; height:27px"/></td>  
            </tr>
           <tr>
        <td width="0%"><span style="font-weight:bold">APLIKASI</span></td>
        <td width="1%">:</td>
        <td>
                 <select name="type" id="type" style="width:200px;">
              <option >...PILIH APLIKASI... </option>
              <option value="1" >SIMBLUD</option>';
              
              
             </select>
        <td>
        </tr>     

         <tr>
                <td width="20%"><span style="font-weight:bold">GROUP MENU</span></td>
                <td width="1%">:</td>
                <td>
        <?php
            $cmbgroup="select * from h_user_group ";
            $pagingquery1 = $cmbgroup; ;
            $res = mysql_query($pagingquery1)or die("pagingquery gagal".mysql_error());
                                ?>
        <select name="cmbgroup" id="cmbgroup" style="height: 27px; width: 300px;">
       <option value="">...PILIH GROUP... </option>
       <?php
         if($res)
           {
           while ($result = mysql_fetch_row($res)) 
           {
        ?>
        
       <option value="<?php echo $result[0]; ?>" <?php if($result[0]==$cmbgroup){echo "selected=''";}?> > <?php echo $result[0]."  -   ".$result[1]; ?> </option>
       <?php 
           }
           }
        ?>
     </select></td>
            </tr>
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>       
            <tr>
                <td colspan="3" align="center"><a class="btn" plain="true" onclick="javascript:simpan();">Simpan</a>
                <a class="btn" plain="true" href="<?php echo site_url(); ?>/master/user">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>
        
</body>

</html>