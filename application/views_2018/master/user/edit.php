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
    
    $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 220,
            width: 400,
            modal: true,
            autoOpen:false
        });
  }); 


 

    function back(){
        window.location = "<?php echo site_url(); ?>/master/user";
    }        

   
    
     function simpan(){
        var cid_us = document.getElementById('id_user').value;
        var cuser = document.getElementById('user_name').value;
        var cpass = document.getElementById('password').value;
        
        var cnama = document.getElementById('nama').value;
        var cgroup      = document.getElementById('cmbgroup').value; 
      
        var ctype      = document.getElementById('type').value; 
        
        if (cid_us==''){
            alert('Id User Tidak Boleh Kosong');
            return;
        } 
        if (cuser==''){
            alert('User Name Tidak Boleh Kosong');
            return;
        }
        if (cpass==''){
            alert('Password Tidak Boleh Kosong');
            return;
        }
        if (cnama==''){
            alert('Nama Tidak Boleh Kosong');
            return;
        }
        if (ctype==''){
            alert('Type Tidak Boleh Kosong');
            return;
        }
       
        if (cgroup==''){
            alert('Kode Group Tidak Boleh Kosong');
            return;
        }
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/update_toni',
                    data:({cidus:cid_us,cus:cuser,cpa:cpass,cty:ctype,cnm:cnama,csgroup:cgroup}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Update..!!');
                            return;
                        }else if(status=='1'){
                            alert('Data Tidak Ada..!!');
                            return;
                        }else{
                            alert('Data Updated..!!');
                            back();      
                            return;

                        }
                    }
                });
            });    
     };
     
     
     $(function(){   
     var idq =  document.getElementById('id_user').value;
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_otorisasi/'+idq,
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'idx',
    		title:'ID',
    		width:15,
            align:"center"},
            {field:'title',
    		title:'Menu',
    		width:35},
            {field:'status',
    		title:'Status',
			align:'center',
    		width:15,
			editor:{type:'combobox',
					options:{ valueField:'status',
							  textField:'status',
							  panelwidth:910,	
							  panelheigth:10,	
							  url :'<?php echo base_url(); ?>/index.php/master/yatidak',
							  required:false									  
							}
					}			
			},
        ]],
        onAfterEdit:function(rowIndex, rowData, changes){
            idx=rowData.idx;
		    tt = rowData.title;
            st = rowData.status;
            simpanx(idx,tt,st);
           	$('#dg').datagrid('reload');  
            },
        onSelect:function(rowIndex,rowData){
          kd = rowData.idx;
          tt = rowData.title;
          st = rowData.status;
          get(kd,tt,st); 
          lcidx = rowIndex;  
                                       
        }
        
        });
       
    });  
    
    function simpanx(cid,ctt,sta){
		var ids =  document.getElementById('id_user').value;	
       // alert(sta);	
		$(document).ready(function(){
			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>/index.php/master/simpan_otorisasi',
				data: ({idx:cid,tt:ctt,st:sta,vids:ids}),
				dataType:"json"
			});
		});                                            
	
		$('#dg').datagrid('reload');     

    } 
    
     function get(kd,tt) {
        
        $("#id").attr("value",kd);
        $("#title").attr("value",tt);     
                       
    }
	</script>
 </head>
 <body>
<div id="content">
  <table align="center" style="width:100%;">
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>   
    	<tr>
        <td width="20%"><span style="font-weight:bold">USER ID</span></td>
        <td width="1%">:</td>
            <td>
            &nbsp;&nbsp;<input style="height: 27px; " name="id_user" type="text" id="id_user" disabled="true" value="<?php echo $user->id_user; ?>" size="3" /> <?php echo form_error('id_user'); ?>
            </td>
        </tr>
        <tr>
        <td width="20%"><span style="font-weight:bold">USER NAME</span></td>
        <td width="1%">:</td>
            <td>
            &nbsp;&nbsp;<input style="height: 27px; "name="user_name" type="text" id="user_name" value="<?php echo $user->user_name; ?>" size="16" />
            </td>
        </tr>
        <tr>
        <td width="20%"><span style="font-weight:bold">PASSWORD</span></td>
        <td width="1%">:</td>
            <td>
            <input style="height: 27px; "name="password_before" type="hidden" id="password_before" value="<?php echo $user->password; ?>" size="40" />
            &nbsp;&nbsp;<input style="height: 27px; "name="password" type="password" id="password" value="<?php echo $user->password; ?>" size="40" />
            </td>
        </tr>
        <tr>
        <td width="20%"><span style="font-weight:bold">NAMA LENGKAP</span></td>
        <td width="1%">:</td>
            <td>
                &nbsp;&nbsp;<input style="height: 27px; " name="nama" type="text" id="nama" value="<?php echo $user->nama; ?>" size="40" />
            </td>
        </tr>
        <tr>
        <td width="0%"><span style="font-weight:bold">APLIKASI</span></td>
        <td width="1%">:</td>
        <td>
                 <select name="type" id="type" style="width:200px;">
                 <?php

                 if($user->type== 1){
                    echo '<option value="1" selected>SIMBLUD</option>';
                 }
                 ?> 
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
            $res = $this->db->query($pagingquery1);?>
			
        <select name="cmbgroup" id="cmbgroup" style="height: 27px; width: 300px;">
       <option value="">...PILIH GROUP... </option>
       <?php
         if($res)
           {
           while ($result = mysql_fetch_row($res)) 
           {
        ?>
        
       <option value="<?php echo $result[0]; ?>" <?php if($result[0]==$user->id_group){echo "selected=''";}?> > <?php echo $result[0]."  -   ".$result[1]; ?> </option>
       <?php 
           }
           }
        ?>
     </select></td>
            </tr>
		<tr>
        <td width="0%"><span style="font-weight:bold">APLIKASI</span></td>
        <td width="1%">:</td>
        <td><input id="group" name="group" style="width:190px" />
        <td>
        </tr> 	
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>        
     
        <tr>
           <td colspan="3" align="center">
            <a class="btn"  plain="true" onclick="javascript:simpan();">Simpan</a>
            <a class="btn"  plain="true" onclick="history.go(0)">Refresh</a>
            <a class="btn"  plain="true" href="<?php echo site_url(); ?>/master/user">Kembali</a> </td>
        </tr>
    </table>

</div>
</body>

</html>