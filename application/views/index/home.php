<script>

$(document).ready(function() {
	  $('.carousel').carousel({
	  	interval: 3000
	  }); 
	  $().newsTicker({
	  		newsList: ".ticker",
	 		startDelay: 10,
	 		tickerRate: 80,
			loopDelay: 5000,
	 		controls: false,
	 		ownControls: false,
	 		stopOnHover: false,
	 		resumeOffHover: true
	  });
});






</script>

<style>


</style>

<?php
$kd_skpd = $this->session->userdata('kdskpd');

$sqltpk="SELECT a.nm_skpd AS nama,b.alamat,b.telp,b.faks,b.daerah FROM ms_skpd_blud a 
		INNER JOIN sclient2_blud b ON a.kd_skpd=b.kd_skpd
		WHERE a.kd_skpd = '$kd_skpd'";
	 $sqlpk=$this->db->query($sqltpk);
        foreach ($sqlpk->result() as $rowpk)
        {
        $pk=$rowpk->nama;
		$alamat=$rowpk->alamat;
		if($rowpk->telp != ''){
		$telp=$rowpk->telp;
		}else{
		$telp = '-';
		}
		
		if($rowpk->faks != ''){
		$faks=$rowpk->faks;
		}else{
		$faks = '-';
		}
		$daerah=$rowpk->daerah;
        }		
		
?>


<div id="content" align="center">
<h1 style="padding:15px 2px; color:black; text-align:left;">
		<ul class="ticker" style=" padding:0px; margin:0; font-size:18px;">
			<li class="icon-info-sign icon-white">Selamat Datang <?php echo $this->session->userdata('Display_name'); ?>, <?php echo $pk; ?> </li>
		</ul>
</h1>



<div style="min-height:400px; border: 0px solid #000; width: 700px">
<?php if($kd_skpd=='0.00.00.00' or $kd_skpd=='0.00.0.00'){

 
 echo '<br/><br/><br/><div style="width:100%; height:100%; font-size:40px; color:#f00;">MAAF ANDA TIDAK DAPAT MELANJUTKAN / MENGGUNAKAN SISTEM, KARENA STATUS BELUM TERLUNASI<br/>
 
  <a href="index.php/welcome/login">lOGIN KEMBALI</a>
 
 </div>';
 }else{
 ?>
<!-- <div class="hero-unit">
        <h2>Selamat Datang di <?php echo $ingat.' '.$ingat; ?></h2>
        <p>Sistem Informasi Kepegawaian PNS Banyuwangi merupakan sebuah aplikasi untuk melakukan manajemen data kepegawaian untuk pegawai negeri sipil (PNS) di kabupaten Banyuwangi. Silahkan masukkan username dan password anda untuk mulai untuk melakukan manajemen atau pengolahan data kepegawaian sesuai dengan hak akses yang anda miliki.</p>
        <p><a class="btn btn-primary btn-large">Pelajari Lebih Lanjut <i class="icon-circle-arrow-right icon-white"></i> </a></p>
      </div> -->
 <!--disini tepat menu home
<div id="post_isi">
	<div class="shortcutHome">
	        <a href='#'><img src=images/slide/1.png border=none></a>
	        <a href='#'><img src=images/slide/2.png border=none></a>
	        <a href='#'><img src=images/slide/3.png border=none></a>
	        <a href='#'><img src=images/slide/4.png border=none></a>
	        <a href='#'><img src=images/slide/5.png border=none></a>
	        <a href='#'><img src=images/slide/6.png border=none></a>
	        <a href='#'><img src=images/slide/7.png border=none></a>
	        <a href='#'><img src=images/slide/8.png border=none></a>
	        <a href='#'><img src=images/slide/9.png border=none></a>
	        <a href='#'><img src=images/slide/10.png border=none></a>
	 </div>
</div>-->

<tr> 
	<td width="800" valign="top" align="center">
	<img src="<?php echo base_url();?>image/logo_kemenkes.png" width="254" height="350" alt=""/>
	</td>
<tr>

  <?php } ?>
  
</div>
</div>
