<html>
<head>
<title>Koneksi Multi Database</title>
</head>
<body>

<h2>Database 1</h2>
<table>
<thead>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
</thead>
<tbody>
<?php
foreach($data2->result() as $siswa){
 echo "<tr>
 <td>$siswa->kd_skpd</td>
 <td>$siswa->nm_skpd</td>
</tr>";
}
?>
</tbody>
</table>

</tbody>
</table>
</body>
</html>