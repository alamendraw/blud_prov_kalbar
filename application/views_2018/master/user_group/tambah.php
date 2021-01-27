<!DOCTYPE html>
<html lang="en">
<head>
	<title>Tambah User Group</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
</head>
<body>
	<div id="content">
		<table id="dg" class="easyui-datagrid" title="Konfigurasi Group">
			<thead>
				<tr>
					<th data-options="field:'itemid',width:80">Item ID</th>
					<th data-options="field:'productid',width:100">Product</th>
					<th data-options="field:'listprice',width:80,align:'right'">List Price</th>
					<th data-options="field:'unitcost',width:80,align:'right'">Unit Cost</th>
					<th data-options="field:'attr1',width:250">Attribute</th>
					<th data-options="field:'status',width:60,align:'center'">Status</th>
				</tr>
			</thead>
		</table>
	</div>
</body>
</html>