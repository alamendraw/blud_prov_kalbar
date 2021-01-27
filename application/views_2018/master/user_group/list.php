<!DOCTYPE html>
<html lang="en">
<head>
	<title>Konfigurasi User Group</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>

<script type="text/javascript">

	var lcstatus = "";

	function keluar(){
		$("#dialog-modal").dialog('close');
	}

	$(document).ready(function() {
			$( "#dialog-modal" ).dialog({
			height: 570,
			width: 1043,
			modal: true,
			autoOpen:false
		});
		keluar();
	});    

	function tambah(){
		lcstatus = 'tambah';
		judul = 'Input Data User Group';
		$("#dialog-modal").dialog({ title: judul });
		kosong();
		$("#dialog-modal").dialog('open');
		document.getElementById("kode").disabled=false;
		document.getElementById("kode").focus();

		$('#dg').edatagrid('loadData',[]);
		$('#dg1').edatagrid('loadData',[]);
		$(document).ready(function(){
			$('#dg').edatagrid({
				url 		: '<?php echo base_url(); ?>/index.php/master/load_dyn_menu'
			});
		});
	}

	function kosong(){
		$("#kode").attr("value",'');
		$("#nama").attr("value",'');
	}

	function tersediaToDefault(){
		var ss = [];
		var ids;
		var rows = $('#dg').datagrid('getSelections');
		$('#dg1').datagrid('loading');  // display loading message
		
		for (var i = 0; i < rows.length ; i++) {
			 var row = rows[i];
			 $('#dg1').edatagrid('appendRow', 
			 	{id1:row.id, nama1:row.nama});

			 var index = $('#dg').datagrid('getRowIndex',rows[i]);
			 ids = index;
			 //alert(ids);
			 $('#dg').datagrid('deleteRow',ids);
		}	
		$('#dg1').datagrid('loaded');  // hide loading message
	}
	function defaultToTersedia(){
		var ss = [];
		var ids;
		var rows = $('#dg1').datagrid('getSelections');
		$('#dg').datagrid('loading');  // display loading message
		
		for (var i = 0; i < rows.length ; i++) {
			 var row = rows[i];
			 $('#dg').edatagrid('appendRow', 
			 	{id:row.id1, nama:row.nama1});

			 var index = $('#dg1').datagrid('getRowIndex',rows[i]);
			 ids = index;
			 //alert(ids);
			 $('#dg1').datagrid('deleteRow',ids);
		}	
		$('#dg').datagrid('loaded');  // hide loading message
	}
	
	function simpan(){
		$('#dg1').datagrid('unselectAll');    
		var kode = document.getElementById('kode').value;
		var nama = document.getElementById('nama').value;

		 if (kode==''){
            alert('Kode Group Tidak Boleh Kosong');
           return;
        }
        if (nama==''){
            alert('Nama Group Tidak Boleh Kosong');
           return;
        }

		$('#dg1').datagrid('selectAll');
		var rows = $('#dg1').datagrid('getSelections');

		if(lcstatus == "edit"){
			$.ajax({
				type 	: "POST",
				dataType : 'json',
				data 	: ({vkode:kode, vnama : nama, vstatus : lcstatus}),
				url 		: '<?php echo base_url(); ?>index.php/master/simpan_h_user_group',
				success : function(data){
					var status = data.pesan;
					if(status=='0'){
						if ( rows.length > 0 ) {
							var csql = "";
							for (var i = 0; i < rows.length; i++) {
								cid_menu = rows[i].id1;
								if(i>0){
									csql = csql+","+"('"+kode+"','"+cid_menu+"')";
								}else{
									csql = "values ('"+kode+"','"+cid_menu+"')";
								}
							}
							simpan_d_user_group(kode, csql);
						}
					}else{
						alert('Gagal Simpan');
					}
				}
			});
			
		}else{

			$.ajax({
				type 	: "POST",
				dataType : 'json',
				data 	: ({vkode:kode, vnama : nama, vstatus : lcstatus}),
				url 		: '<?php echo base_url(); ?>index.php/master/simpan_h_user_group',
				success : function(data){
					var status = data.pesan;
					if(status=='0'){
						if ( rows.length > 0 ) {
							var csql = "";
							for (var i = 0; i < rows.length; i++) {
								cid_menu = rows[i].id1;
								if(i>0){
									csql = csql+","+"('"+kode+"','"+cid_menu+"')";
								}else{
									csql = "values ('"+kode+"','"+cid_menu+"')";
								}
							}
							simpan_d_user_group(kode, csql);
						}
					}else{
						alert('Gagal Simpan');
					}
				}
			});
			
		}
	}

	function simpan_d_user_group(kode, csql){
		$.ajax({
			type 	: "POST",
			dataType: 'json',
			data 	: ({vkode : kode, vsql : csql}),
			url 		: '<?php echo base_url(); ?>index.php/master/simpan_d_user_group',
			success : function(data){
				status = data.pesan;
				if(status == '0'){
					alert('Berhasil Simpan');
					window.location = "<?php echo site_url() ?>/master/user_group"
					return true;
				}else{
					alert('Gagal Simpan');
					return true;
				}
			}
		});
	}

	$(document).ready(function(){
		$('.edit').click(function(){
			var group = $(this).attr("name");
			var group_  = group.split(",");
			$('#kode').attr('value',group_[0]);
			$('#nama').attr('value',group_[1]);
			document.getElementById('kode').disabled = true;
			judul = 'Edit Data User Group';
			$("#dialog-modal").dialog({ title: judul });
			$('#dialog-modal').dialog('open');
			lcstatus="edit";

			$('#dg').datagrid('loadData',[]);
			$('#dg').edatagrid({
				url 		: '<?php echo base_url(); ?>/index.php/master/load_dyn_menu/'+group_[0]
			});

			$('#dg1').datagrid('loadData',[]);
			$('#dg1').edatagrid({
				url 		: '<?php echo base_url(); ?>/index.php/master/load_d_user_group/'+group_[0]
			});
		});

		$('.hapus').click(function(){
			var id_group = $(this).attr("name");
			var del = confirm("apakah anda yakin ingin menghapus User Group dengan id "+ id_group+" ?");
			if(del==true){
				$.ajax({
					type 	: "POST",
					dataType: 'json',
					data 	: ({vkode : id_group}),
					url 		: '<?php echo site_url(); ?>/master/hapus_h_user_group',
					success : function(data){
						var status = data.pesan;
						if(status=='0'){
							//alert('Berhasil Hapus');
							window.location = "<?php echo site_url() ?>/master/user_group";
						}else{
							alert('Gagal Hapus Data');
						}
					}
				});
			}
		});
	});
	function back(){
		window.location = "<?php echo site_url(); ?>/master/user";
	}
</script>

<style type="text/css">
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
</head>
<body>
	<div id="content">
		<h1><?php echo $page_title; ?></h1>
		<?php echo form_open('master/cari_user_group', array('class' => 'basic')); ?>
			Karakter yang di cari :&nbsp;&nbsp;&nbsp;
			<input type="text" name="pencarian" id="pencarian" value="<?php echo set_value('text'); ?>" />
					<input type='submit' name='cari' value='cari' class='btn' />
		<?php echo form_close(); ?>

		<?php if (  $this->session->flashdata('notify') <> "" ) : ?>
			<div class="success"><?php echo $this->session->flashdata('notify'); ?></div>
		<?php endif; ?>

		<div class='btn' id="tambah" onclick="tambah()" name="<?php echo site_url(); ?>">Tambah User Group</div>
		&nbsp;&nbsp;||&nbsp;&nbsp;
		 <div class='btn' id="kembali" onclick="back()">kembali</div>

		<table class="narrow">
					<tr>
						<th>ID Group</th>
						<th>Nama Group</th>
						<th>Jumlah User</th>
						<th>Aksi</th>
					</tr>
					<?php foreach($list as $user_group) : ?>

					<tr>
						<td><?php echo $user_group['id_group']; ?></td>
						<td><?php echo $user_group['nm_group']; ?></td>
						<td><?php echo $user_group['jlh']; ?></td>
						<td>   
							<a  name="<?php echo $user_group['id_group'].','.$user_group['nm_group']; ?>" class="edit" title="Edit"><img src="<?php echo base_url(); ?>assets/images/icon/edit.png" /></a>
								&nbsp;&nbsp;
							<a  name="<?php echo $user_group['id_group']?>" class="hapus" title="Hapus"><img src="<?php echo base_url(); ?>assets/images/icon/cross.png" /></a>
						</td>
					</tr>
					<?php endforeach; ?>
		</table>

		<?php echo $this->pagination->create_links(); ?> <span class="totalitem">Total Item <?php echo $total_rows ; ?></span>
		<div class="clear"></div>
	</div>

	<div id="dialog-modal" title="">
			<fieldset>
		 	<table align="center" style="width:100%;" border="0">
				<tr>
					<td width="200px">KODE USER GROUP</td>
					<td width="5px">:</td>
					<td><input type="text" id="kode" style="width:100px;" /></td>  
				</tr>
				<tr>
					<td>NAMA USER GROUP</td>
					<td>:</td>
					<td><input type="text" id="nama" style="width:310px;"/></td>  
				</tr>
			</table>       
			</fieldset>
			

			<div style="float:left;margin-left:2px;">
				<table id="dg" class="easyui-datagrid" title="TIDAK AKTIF"
					data-options="autoRowHeight:'true', height:400, width:470">
				<thead>
					<tr>
						<th data-options="field:'ck',checkbox:true"></th>
						<th data-options="field:'id',width:80" sortable="true">ID MENU</th>
						<th data-options="field:'nama',width:350" sortable="true">NAMA MENU</th>
					</tr>
				</thead>
				</table>
			</div>

			
			<div style="float:left;">
				<br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="btn" id="tersediaToDefault" onclick="tersediaToDefault()"><b>>></b></div><br><br>
				<div class="btn" id="defaultToTersedia" onclick="defaultToTersedia()" ><b><<</b></div>
			</div>
			

			<div style="float:left;">
				<table id="dg1" class="easyui-datagrid" title="AKTIF"
					data-options="autoRowHeight:'true', height:400, width:470, loadMsg:'Please Wait....!!',">
				<thead>
					<tr>
						<th data-options="field:'ck',checkbox:true"></th>
						<th data-options="field:'id1',width:80" sortable="true">ID MENU</th>
						<th data-options="field:'nama1',width:350" sortable="true">NAMA MENU</th>
					</tr>
				</thead>
				</table>
			</div>
			<div class="clear"></div>
			<br>
			<div style="background:#cccccc;padding:3px">
				<center>
					<a class="btn"   onclick="javascript:simpan();">Simpan</a>
					<a class="btn"   onclick="javascript:keluar();">Kembali</a>
				</center>
			</div>
	</div>
</body>
</html>