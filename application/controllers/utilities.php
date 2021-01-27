<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//doni star -->
class Utilities extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
		
	} 

	
	function cek_con(){ 
		$kon =  $this->load->database('alternatif', TRUE);
		$lckon = $kon->initialize();
        if(!$lckon){
        	$data=array("isi"=>"Database Tidak Terkoneksi !!! Tidak dapat melanjutkan proses","baris"=>"BARIS","pesan"=>'1');

        }else{
            $data=array("isi"=>"Database Terkoneksi","baris"=>"BARIS","pesan"=>'0');
        }
		echo json_encode($data); 
	}

	function bulan() {
        for ($count = 1; $count <= 12; $count++)
        {
            $result[]= array(
                     'bln' => $count,
                     'nm_bulan' => $this->tukd_model->getBulan($count)
                     );    
        }
        echo json_encode($result);
	}

    function rekal(){
        $data['page_title']= 'Rekal';
        $this->template->set('title', 'Rekal');   
        $this->template->load('template','utilitas/rekal',$data) ;   
    }   
	


	 function export_realisasi_blud()
    {
        $data['page_title']= 'TRANSFER DATA KEUANGAN BLUD';
        $this->template->set('title', 'TRANSFER KEUANGAN BLUD');   
        $this->template->load('template','utilitas/export/transfer',$data) ; 
    }
	
	function skpd_sig() {
		$skpd=$this->session->userdata('kdskpd');
			
		$sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where kd_skpd='".$skpd."'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }  
    
        echo json_encode($result);
	}
function rekal_lpj($bulan=''){
    $oke="select top 1 thn_ang from sclient_blud";
    $jiwa=$this->db->query($oke);
    foreach($jiwa->result() as $a){
        $tahun=$a->thn_ang;
    }
    $tahun="2019";
    $last_update = date('Y-m-d H:i:s');
    $number = $this->db->query("select count(number_sp2b) as number from trhsp3b_blud")->row();
    $number_sp3b = $number->number;
    $i=0;
    $sql_opd =$this->db->query("SELECT kd_skpd, (select nm_skpd from ms_skpd_blud where kd_skpd=trhrka_blud.kd_skpd) nm_skpd from trhrka_blud WHERE kd_skpd !='1.02.01.00'");
    foreach($sql_opd->result() as $a){
        $pukes =$a->kd_skpd;
        $pukesx=$a->nm_skpd;
    
    if($bulan==1){
        $no_lpj     = "1";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Januari $tahun";
        $tgl_awal   = "$tahun-01-01";
        $tgl_akhir  = "$tahun-01-31";
        $tgl_lpj    = "$tahun-01-31";
    } if($bulan==2){
        $no_lpj     = "2";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Februari $tahun";        
        $tgl_awal   = "$tahun-01-01";
        if($tahun%4==0){
                $tgl_akhir  = "$tahun-02-29";
                $tgl_lpj    = "$tahun-02-29";
        } else {
                $tgl_akhir  = "$tahun-02-28";
                $tgl_lpj    = "$tahun-02-28";            
        }
    } if($bulan==3){
        $no_lpj     = "3";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Maret $tahun";
        $tgl_awal   = "$tahun-03-01";
        $tgl_akhir  = "$tahun-03-31";
        $tgl_lpj    = "$tahun-03-31";
    } if($bulan==4){
        $no_lpj     = "4";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan April $tahun";
        $tgl_awal   = "$tahun-04-01";
        $tgl_akhir  = "$tahun-04-30";
        $tgl_lpj    = "$tahun-04-30";
    } if($bulan==5){
        $no_lpj     = "5";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Mei $tahun";
        $tgl_awal   = "$tahun-05-01";
        $tgl_akhir  = "$tahun-05-31";
        $tgl_lpj    = "$tahun-05-31";        
    } if($bulan==6){
        $no_lpj     = "6";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Juni $tahun";
        $tgl_awal   = "$tahun-06-01";
        $tgl_akhir  = "$tahun-06-30";
        $tgl_lpj    = "$tahun-06-30";
    } if($bulan==7){
        $no_lpj     = "7";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Juli $tahun";
        $tgl_awal   = "$tahun-07-01";
        $tgl_akhir  = "$tahun-07-31";
        $tgl_lpj    = "$tahun-07-31";
    } if($bulan==8){
        $no_lpj     = "8";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Agustus $tahun";
        $tgl_awal   = "$tahun-08-01";
        $tgl_akhir  = "$tahun-08-31";
        $tgl_lpj    = "$tahun-08-31";
    } if($bulan==9){
        $no_lpj     = "9";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan September $tahun";
        $tgl_awal   = "$tahun-09-01";
        $tgl_akhir  = "$tahun-09-30";
        $tgl_lpj    = "$tahun-09-30";
    } if($bulan==10){
        $no_lpj     = "10";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Oktober $tahun";
        $tgl_awal   = "$tahun-10-01";
        $tgl_akhir  = "$tahun-10-31";
        $tgl_lpj    = "$tahun-10-31";        
    } if($bulan==11){
        $no_lpj     = "11";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan November $tahun";
        $tgl_awal   = "$tahun-11-01";
        $tgl_akhir  = "$tahun-11-30";
        $tgl_lpj    = "$tahun-11-30";           
    } if($bulan==12){
        $no_lpj     = "12";
        $no_lpj2    = "/$pukes/I/$tahun";
        $keterangan = "$pukesx Bulan Desember $tahun";
        $tgl_awal   = "$tahun-12-01";
        $tgl_akhir  = "$tahun-12-31";
        $tgl_lpj    = "$tahun-12-31";           
    }

    $sql_bulan  = "DELETE FROM trhlpj_bludx where month(tgl_lpj)=$bulan and kd_skpd='$pukes'";
    $sql_excute = $this->db->query($sql_bulan);
    $sql_bulan  = "DELETE FROM trlpj_bludx  where month(tgl_lpj)=$bulan and kd_skpd='$pukes'";
    $sql_excute = $this->db->query($sql_bulan);

    /*UP*/
    $sql  =" INSERT INTO trlpj_bludx SELECT '$no_lpj/LPJ-UP$no_lpj2' no_lpj, a.no_bukti, '$tgl_lpj' tgl_lpj, 'LPJ $keterangan' keterangan, kd_kegiatan, kd_rek5, (select nm_rek5 from ms_rek5 WHERE kd_rek5=a.kd_rek5) nm_rek5, nilai, ''username,
            '$last_update' tgl_update, a.kd_skpd, kd_rek_blud, nm_rek_blud from trdtransout_blud a inner join trhtransout_blud b on
            a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd where a.kd_skpd='$pukes' and month(b.tgl_bukti)=$bulan and year(b.tgl_bukti)=$tahun and b.jns_spp=1";
    
    $sql_e= $this->db->query($sql); 
    /*cek ada tidak*/
    $sql  ="SELECT count(*) itung from trhtransout_blud b where
           b.kd_skpd='$pukes' and month(b.tgl_bukti)=$bulan and year(b.tgl_bukti)=$tahun and b.jns_spp=1";
    $sql_e= $this->db->query($sql);
    foreach($sql_e->result() as $a){ $itung=$a->itung;}
    if($itung > 0){
        $sql  =" INSERT into trhlpj_bludx (no_lpj, kd_skpd, keterangan,tgl_lpj, status, tgl_awal, tgl_akhir, jenis, no_sp2d, bulan)
              values ('$no_lpj/LPJ-UP$no_lpj2', '$pukes', 'LPJ $keterangan', '$tgl_lpj', 1, '$tgl_awal', '$tgl_akhir', 1,'',$bulan)";
        $sql_e= $this->db->query($sql);  
    }




    /*GU*/
    $sql  =" INSERT INTO trlpj_bludx SELECT '$no_lpj/LPJ-GU$no_lpj2' no_lpj, a.no_bukti, '$tgl_lpj' tgl_lpj, 'LPJ $keterangan' keterangan, kd_kegiatan, kd_rek5, (select nm_rek5 from ms_rek5 WHERE kd_rek5=a.kd_rek5) nm_rek5, nilai, ''username,
            '$last_update'tgl_update, a.kd_skpd, kd_rek_blud, nm_rek_blud from trdtransout_blud a inner join trhtransout_blud b on
            a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd where a.kd_skpd='$pukes' and month(b.tgl_bukti)=$bulan and year(b.tgl_bukti)=$tahun and b.jns_spp=2";
    
    $sql_e= $this->db->query($sql); 
    /*cek ada tidak*/
    $sql  ="SELECT count(*) itung from trhtransout_blud b where
           b.kd_skpd='$pukes' and month(b.tgl_bukti)=$bulan and year(b.tgl_bukti)=$tahun and b.jns_spp=2";
    $sql_e= $this->db->query($sql);
    foreach($sql_e->result() as $a){ $itung=$a->itung;}
    if($itung > 0){
        $sql  =" INSERT into trhlpj_bludx (no_lpj, kd_skpd, keterangan,tgl_lpj, status, tgl_awal, tgl_akhir, jenis, no_sp2d, bulan)
              values ('$no_lpj/LPJ-GU$no_lpj2', '$pukes', 'LPJ $keterangan', '$tgl_lpj', 1, '$tgl_awal', '$tgl_akhir', 2,'',$bulan)";
        $sql_e= $this->db->query($sql);  
    }

    /*TU*/ 
    $sql  =" INSERT INTO trlpj_bludx SELECT '$no_lpj/LPJ-TU$no_lpj2' no_lpj, a.no_bukti, '$tgl_lpj' tgl_lpj, 'LPJ $keterangan' keterangan, kd_kegiatan, kd_rek5, (select nm_rek5 from ms_rek5 WHERE kd_rek5=a.kd_rek5) nm_rek5, nilai, ''username,
            '$last_update'tgl_update, a.kd_skpd, kd_rek_blud, nm_rek_blud from trdtransout_blud a inner join trhtransout_blud b on
            a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd where a.kd_skpd='$pukes' and month(b.tgl_bukti)=$bulan and year(b.tgl_bukti)=$tahun and b.jns_spp=3";
    $sql_e= $this->db->query($sql); 

    /*cek ada tidak*/
    $sql  ="SELECT count(*) itung from trhtransout_blud b where
           b.kd_skpd='$pukes' and month(b.tgl_bukti)=$bulan and year(b.tgl_bukti)=$tahun and b.jns_spp=3";
    $sql_e= $this->db->query($sql);
    foreach($sql_e->result() as $a){ $itung=$a->itung;}
    if($itung > 0){
        $sql  =" INSERT into trhlpj_bludx (no_lpj, kd_skpd, keterangan,tgl_lpj, status, tgl_awal, tgl_akhir, jenis, no_sp2d,bulan)
              values ('$no_lpj/LPJ-TU$no_lpj2', '$pukes', 'LPJ $keterangan', '$tgl_lpj', 1, '$tgl_awal', '$tgl_akhir', 3,'',$bulan)";
        $sql_e= $this->db->query($sql);  
    }

    $i=$number_sp3b+1;
    $sql="DELETE from trhsp3b_blud where kd_skpd='$pukes' and month(tgl_sp3b)='$bulan'";
    $sql_e= $this->db->query($sql);
    $sql="INSERT INTO trhsp3b_blud 
    select  no_sp3b, kd_skpd, keterangan, tgl_sp3b, status, tgl_awal, tgl_akhir, isnull((select top 1 no_lpj from trhlpj_bludx WHERE tgl_lpj='$tgl_akhir' and kd_skpd='$pukes'),'-') no_lpj, sum(total) total, skpd, bulan, username, tgl_update, status_bud, no_sp2b, tgl_sp2b, number_sp2b from (

    SELECT '$no_lpj/SP3B$no_lpj2' no_sp3b, b.kd_skpd, 'SP3B $keterangan'keterangan, '$tgl_akhir'tgl_sp3b, 1 status, '$tgl_awal'tgl_awal, '$tgl_akhir'tgl_akhir,
    ''no_lpj, sum(b.total) total, b.kd_skpd skpd, '$no_lpj' bulan, '' username, '$last_update'tgl_update, 1 status_bud, '$no_lpj/SP2B$no_lpj2' no_sp2b, '$tgl_akhir' tgl_sp2b, '$i' number_sp2b
    from trhtransout_blud b INNER JOIN trdtransout_blud a on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd 
    WHERE month(b.tgl_bukti)='$bulan' and b.kd_skpd='$pukes'  GROUP BY b.kd_skpd
    union all
    select '$no_lpj/SP3B$no_lpj2' no_sp3b, kd_skpd, 'SP3B $keterangan'keterangan, '$tgl_akhir'tgl_sp3b, 1 status, '$tgl_awal'tgl_awal, '$tgl_akhir'tgl_akhir, ''no_lpj, sum(nilai) total, kd_skpd, '$no_lpj' bulan,
    '' username,  '$last_update'tgl_update, 1 status_bud, '$no_lpj/SP2B$no_lpj2' no_sp2b, '$tgl_akhir' tgl_sp2b, '$i' number_sp2b from tr_terima_blud WHERE month(tgl_terima)=1 and kd_skpd='$pukes' GROUP BY kd_skpd, month(tgl_terima)

    )xxxx GROUP BY no_sp3b, kd_skpd, keterangan, tgl_sp3b, status, tgl_awal, tgl_akhir, no_lpj, skpd, bulan, username, tgl_update, status_bud, no_sp2b, tgl_sp2b, number_sp2b
    "; 


    $sql_e= $this->db->query($sql);

    $sql="DELETE from trsp3b_blud where kd_skpd='$pukes' and month(tgl_sp3b)='$bulan'";
    $sql_e= $this->db->query($sql);
    $sql="INSERT INTO trsp3b_blud 
    select no_sp3b, '' no_bukti, tgl_sp3b, keterangan,  kd_rek_blud, nm_rek5, sum(nilai) nilai,
    kd_skpd, kd_kegiatan, no_lpj from (

    SELECT '$no_lpj/SP3B$no_lpj2' no_sp3b, a.no_bukti, '$tgl_akhir' tgl_sp3b, 'SP3B $keterangan'keterangan, a.kd_rek_blud, a.nm_rek_blud nm_rek5, a.nilai, a.kd_skpd, a.kd_kegiatan, 
    isnull((select top 1 no_lpj from trhlpj_bludx WHERE tgl_lpj = '$tgl_akhir' and kd_skpd='$pukes'),'-') no_lpj
    from  trdtransout_blud a INNER JOIN trhtransout_blud b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd 
    WHERE month(b.tgl_bukti)='$bulan' and a.kd_skpd='$pukes'
    union all 
    select '$no_lpj/SP3B$no_lpj2' no_sp3b, no_terima no_bukti, '$tgl_akhir' tgl_sp3b, 'SP3B $keterangan'keterangan, kd_rek_blud, 
    (select nm_rek5 from ms_rek5_blud WHERE kd_rek5= a.kd_rek_blud) nm_rek5, nilai, kd_skpd, kd_kegiatan, '-' no_lpj
    from  tr_terima_blud a WHERE month(tgl_terima)='$bulan' and kd_skpd='$pukes'
    ) xx GROUP BY no_sp3b,kd_rek_blud,nm_rek5, kd_skpd,kd_kegiatan,tgl_sp3b,keterangan,no_lpj
    ";
 
    $sql_e= $this->db->query($sql);

    } //end foreach skpd
    $msg=1;
    echo json_encode($msg);
    
}

function ambil_lpj($bulan=''){

		$inittw = $bulan;
        $oke="select top 1 thn_ang from sclient_blud";
        $jiwa=$this->db->query($oke);
        foreach($jiwa->result() as $a){
            $tahun=$a->thn_ang;
        }
        $skpd_bp  = "1.02.01.00";
        $last_update = date('Y-m-d H:i:s');
        
        if($inittw=='1'){
            $init_bulan1 = '1';
            $init_bulan2 = '1'; 
            $int_tw      = '01';
            $int_tw2     = 'JANUARI';
            $cket        = 'JANUARI TAHUN '.$tahun;
            $awal        = $tahun.'-01-01';            
            $ntgllpj     = $tahun.'-01-31';
            
            $csql1 = "DELETE FROM trhlpj_bludx";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud";
            $query = $this->db->query($csql4);
        
        }else
        if($inittw=='2'){
            $init_bulan1 = '2';
            $init_bulan2 = '2'; 
            $int_tw      = '02';
            $int_tw2     = 'FEBRUARI';
            $cket        = 'FEBRUARI TAHUN '.$tahun;
            $awal        = $tahun.'-02-01';
            $ntgllpj     = $tahun.'-02-28';

            $csql1 = "DELETE FROM trhlpj_bludx where bulan='2'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=2";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='2'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=2";
            $query = $this->db->query($csql4);           
        }else
        if($inittw=='3'){
            $init_bulan1 = '3';
            $init_bulan2 = '3'; 
            $int_tw      = '03';
            $int_tw2     = 'MARET';
            $cket        = 'MARET TAHUN '.$tahun;
            $awal        = $tahun.'-03-01';
            $ntgllpj     = $tahun.'-03-31';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='3'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=3";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='3'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=3";
            $query = $this->db->query($csql4);                  
        }else
        if($inittw=='4'){
            $init_bulan1 = '4';
            $init_bulan2 = '4'; 
            $int_tw      = '04';
            $int_tw2     = 'APRIL';
            $cket        = 'APRIL TAHUN '.$tahun;
            $awal        = $tahun.'-04-01';
            $ntgllpj     = $tahun.'-04-30';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='4'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=4";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='4'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=4";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='5'){
            $init_bulan1 = '5';
            $init_bulan2 = '5'; 
            $int_tw      = '05';
            $int_tw2     = 'MEI';
            $cket        = 'MEI TAHUN '.$tahun;
            $awal        = $tahun.'-05-01';
            $ntgllpj     = $tahun.'-05-31';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='5'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=5";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='5'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=5";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='6'){
            $init_bulan1 = '6';
            $init_bulan2 = '6'; 
            $int_tw      = '06';
            $int_tw2     = 'JUNI';
            $cket        = 'JUNI TAHUN '.$tahun;
            $awal        = $tahun.'-06-01';
            $ntgllpj     = $tahun.'-06-30';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='6'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=6";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='6'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=6";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='7'){
            $init_bulan1 = '7';
            $init_bulan2 = '7'; 
            $int_tw      = '07';
            $int_tw2     = 'JULI';
            $cket        = 'JULI TAHUN '.$tahun;
            $awal        = $tahun.'-07-01';
            $ntgllpj     = $tahun.'-07-31';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='7'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=7";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='7'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=7";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='8'){
            $init_bulan1 = '8';
            $init_bulan2 = '8'; 
            $int_tw      = '08';
            $int_tw2     = 'AGUSTUS';
            $cket        = 'AGUSTUS TAHUN '.$tahun;
            $awal        = $tahun.'-08-01';
            $ntgllpj     = $tahun.'-08-31';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='8'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=8";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='8'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=8";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='9'){
            $init_bulan1 = '9';
            $init_bulan2 = '9'; 
            $int_tw      = '09';
            $int_tw2     = 'SEPTEMBER';
            $cket        = 'SEPTEMBER TAHUN '.$tahun;
            $awal        = $tahun.'-09-01';
            $ntgllpj     = $tahun.'-09-30';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='9'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=9";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='9'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=9";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='10'){
            $init_bulan1 = '10';
            $init_bulan2 = '10'; 
            $int_tw      = '10';
            $int_tw2     = 'OKTOBER';
            $cket        = 'OKTOBER TAHUN '.$tahun;
            $awal        = $tahun.'-10-01';
            $ntgllpj     = $tahun.'-10-31';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='10'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=10";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='10'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=10";
            $query = $this->db->query($csql4);      

        }else
        if($inittw=='11'){
            $init_bulan1 = '11';
            $init_bulan2 = '11'; 
            $int_tw      = '11';
            $int_tw2     = 'NOVEMBER';
            $cket        = 'NOVEMBER TAHUN '.$tahun;
            $awal        = $tahun.'-11-01';
            $ntgllpj     = $tahun.'-11-30';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='11'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=11";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='11'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=11";
            $query = $this->db->query($csql4);      

        }    else
        if($inittw=='12'){
            $init_bulan1 = '12';
            $init_bulan2 = '12'; 
            $int_tw      = '12';
            $int_tw2     = 'DESEMBER';
            $cket        = 'DESEMBER TAHUN '.$tahun;
            $awal        = $tahun.'-12-01';
            $ntgllpj     = $tahun.'-12-31';
            $csql1 = "DELETE FROM trhlpj_bludx where bulan='12'";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_bludx where month(tgl_lpj)=12";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud where bulan='12'";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud where month(tgl_sp3b)=12";
            $query = $this->db->query($csql4);                  
        }                         
        
        $sql_skpd    = "select kd_skpd,nm_skpd from ms_skpd_blud order by kd_skpd";           
        $query_skpd = $this->db->query($sql_skpd);          
        
        $number = $this->db->query("select count(number_sp2b) as number from trhsp3b_blud")->row();
        $number_sp3b = $number->number;
        
        $ii     = 0;
        foreach($query_skpd->result_array() as $hasil)
        { 
           $ii = $number_sp3b+1; 
           $initskpd = $hasil['kd_skpd'];
           $initnmskpd = $hasil['nm_skpd'];      
       
        $nlpj  = $int_tw."/".$initskpd."/LPJ/".$int_tw2."/2019"; 
        $nsp3b = $int_tw."/".$initskpd."/SP2B/".$int_tw2."/2019"; 
        $nsp2b = $ii."/".$int_tw."/".$initskpd."/SPB/".$int_tw2."/2019";         
        
        $csql_hlpj = "INSERT INTO trhlpj_bludx (no_lpj,kd_skpd,keterangan,tgl_lpj,status,bulan,jenis,tgl_awal,tgl_akhir) values ('$nlpj','$initskpd','$cket','$ntgllpj','0','$init_bulan2','1','$awal','$ntgllpj')";
          
        $query1 = $this->db->query($csql_hlpj);

        
        $cload_total = $this->db->query("       
                   SELECT sum(c.total) total FROM(
                   SELECT isnull(sum(a.nilai*-1),0) as total
                   FROM TRDINLAIN_blud a inner join TRHINLAIN_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='initskpd' and b.jns_beban='16'
                   union all
                   SELECT isnull(sum(a.nilai),0) as total
                   FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd')c")->row();
        $total_sp3b = $cload_total->total;                      
        
        $csql_sp3b = "insert into trhsp3b_blud(no_sp3b,kd_skpd,tgl_sp3b,keterangan,status,no_lpj,total,skpd,bulan,username,tgl_update,status_bud,no_sp2b,tgl_sp2b,number_sp2b) 
                        values('$nsp3b','$initskpd','$ntgllpj','$cket','1','$nlpj','$total_sp3b','$skpd_bp','$init_bulan2','DIKNAS','$last_update','1','$nsp2b','$ntgllpj','$ii')";
                                                  
        $query1 = $this->db->query($csql_sp3b);
        
        $csql_dlpj = "INSERT INTO trlpj_bludx (no_lpj,no_bukti,tgl_lpj,keterangan,kd_kegiatan,kd_rek5,nm_rek5,nilai,kd_skpd)       
                    select c.no_lpj,c.no_bukti,c.tgl_lpj,c.keterangan,c.kd_kegiatan,c.kd_rek5,c.nm_rek5,c.nilai,c.kd_skpd from(
                    SELECT '$nlpj' as no_lpj, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, a.kd_kegiatan,a.kd_rek_blud kd_rek5,a.nm_rek_blud nm_rek5,a.nilai,b.kd_skpd 
                    FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                    month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd'
                   union all
                    SELECT '$nlpj' as no_lpj, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, b.kd_kegiatan,a.kd_rek5,'Koreksi Belanja' nm_rek5,a.nilai*-1 nilai,b.kd_skpd 
                    FROM TRDINLAIN_blud a inner join TRHINLAIN_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                    month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd' and b.jns_beban='16' )c order by cast (c.no_bukti as int)
                   "; 
   
        $query1 = $this->db->query($csql_dlpj);  
        
        $csql_dsp3b = "INSERT INTO trsp3b_blud(no_sp3b,no_bukti,tgl_sp3b,keterangan,kd_kegiatan,kd_rek5,nm_rek5,nilai,kd_skpd,no_lpj)       
                    SELECT c.no_sp3b,c.no_bukti,c.tgl_lpj,c.keterangan,c.kd_kegiatan,c.kd_rek5,c.nm_rek5,c.nilai,c.kd_skpd,c.no_lpj from(
                    SELECT '$nsp3b' as no_sp3b, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, a.kd_kegiatan,a.kd_rek_blud kd_rek5,a.nm_rek_blud nm_rek5,a.nilai,b.kd_skpd,'$nlpj' as no_lpj 
                    FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd'
                    union all
                    SELECT '$nsp3b' as no_sp3b, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, b.kd_kegiatan,a.kd_rek5,'Koreksi Belanja' nm_rek5,a.nilai*-1 nilai,b.kd_skpd,'$nlpj' as no_lpj 
                    FROM TRDINLAIN_blud a inner join TRHINLAIN_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd' and b.jns_beban='16')c
                   order by cast (c.no_bukti as int)
                   ";  

        $query1 = $this->db->query($csql_dsp3b); 
 
        }
        $msg=1;
        echo json_encode($msg);
    }

	function liat(){
		$skpd=$this->session->userdata('kdskpd');
		$sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd ";
        $query1 = $this->db_keu->query($sql);  

        print_r($query1);

	}

	function hitrecord(){
		$this->load->model('koneksi');
		$bulan = $this->input->post('bulan');
		ini_set("memory_limit", "-1");
		ini_set('max_execution_time',0);

		$sql = $this->db_keu->query("Delete From temp_sp2d");

		$kd_skpd = $this->session->userdata('kdskpd');
		$where = "WHERE a.kd_skpd='$kd_skpd' AND b.kd_kegiatan='1.02.1.02.02.00.00.02' and MONTH(tgl_kas_bud) <='$bulan' AND a.`status_bud`='1'";	
		
		$query =$this->db_keu->query("SELECT a.no_sp2d,a.`tgl_sp2d`,a.`no_spm`,a.`tgl_spm`,a.`no_spp`,a.`tgl_spp`,a.no_kas,a.`kd_skpd`,a.`keperluan`,
			a.`jns_spp`,b.`kd_kegiatan`,b.kd_rek5, b.`nilai`,a.tgl_kas_bud FROM trhsp2d a INNER JOIN trdspp b ON a.`no_spp`=b.`no_spp` $where");

		$i=0;
		foreach ($query->result_array() as $dt) {
			$i++;
			$no_sp2d     = $dt['no_sp2d'];
			$tgl_sp2d    = $dt['tgl_sp2d'];
			$no_spm      = $dt['no_spm'];
			$tgl_spm     = $dt['tgl_spm'];
			$no_spp      = $dt['no_spp'];
			$tgl_spp     = $dt['tgl_spp'];
			$no_kas      = $dt['no_kas'];
			$kd_skpd     = $dt['kd_skpd'];
			$keperluan   = $dt['keperluan'];
			$jns_spp     = $dt['jns_spp'];
			$kd_kegiatan = $dt['kd_kegiatan'];
			$kd_rek5     = $dt['kd_rek5'];
			$nilai       = $dt['nilai'];
			$tgl_kas_bud = $dt['tgl_kas_bud'];


			$sql1 = "insert into temp_sp2d (no_sp2d,tgl_sp2d,no_spm,tgl_spm,no_spp,tgl_spp,no_kas,kd_skpd,keperluan,jns_spp,kd_kegiatan,kd_rek5,nilai,tgl_kas_bud)
					values('$no_sp2d','$tgl_sp2d','$no_spm','$tgl_spm','$no_spp','$tgl_spp','$no_kas','$kd_skpd','$keperluan','$jns_spp','$kd_kegiatan','$kd_rek5','$nilai','$tgl_kas_bud') ";
			$asg1 = $this->db_keu->query($sql1);

		}

		$sql = $this->db->query("Delete From sp2d_import");

		$rec   = count($query->result_array());
		$data=array("jumlah"=>$rec);
		echo json_encode($data);
		$query->free_result();
	}

	function proses_transfer(){
		$this->load->model('koneksi');

		ini_set("memory_limit", "-1");
		ini_set('max_execution_time',0);
		

		$bulan = $this->input->post('bulan');
		$baris =$this->input->post('baris');
		//$baris =15;
		
	    $where='';
	    $sp2d ='';
		$kd_skpd = $this->session->userdata('kdskpd');
		$where = "where kd_skpd = '$kd_skpd' and MONTH(tgl_kas_bud)<='$bulan' ";
		$sql = "SELECT * from temp_sp2d $where order by no_sp2d limit $baris,1";

		/*$where = "where a.kd_skpd='$kd_skpd'  AND a.status_bud='1' ";	
		
		$sql =$this->db_keu->query("SELECT a.no_sp2d,a.tgl_sp2d,a.no_spm,a.tgl_spm,a.no_spp,a.tgl_spp,a.no_kas,a.kd_skpd,a.keperluan,
a.jns_spp FROM trhsp2d a $where order by a.no_sp2d limit $baris,1");*/

        $query1 = $this->db_keu->query($sql);  
		   foreach($query1->result_array() as $res){

				$no_sp2d     = $res['no_sp2d'];
				$tgl_sp2d    = $res['tgl_sp2d'];
				$no_spm      = $res['no_spm'];
				$tgl_spm     = $res['tgl_spm'];
				$no_spp      = $res['no_spp'];
				$tgl_spp     = $res['tgl_spp'];
				$no_kas      = $res['no_kas'];
				$kd_skpd     = $res['kd_skpd'];
				$keperluan   = $res['keperluan'];
				$jns_spp     = $res['jns_spp'];
				$kd_kegiatan = $res['kd_kegiatan'];
				$kd_rek5     = $res['kd_rek5'];
				$nilai       = $res['nilai'];
				$tgl_kas_bud = $res['tgl_kas_bud'];

				$baris=$baris+1;

				

				$sql1 = "insert into sp2d_import (no_sp2d,tgl_sp2d,no_spm,tgl_spm,no_spp,tgl_spp,no_kas,kd_skpd,keperluan,jns_spp,kd_kegiatan,kd_rek5,nilai,tgl_kas_bud)
				values('$no_sp2d','$tgl_sp2d','$no_spm','$tgl_spm','$no_spp','$tgl_spp','$no_kas','$kd_skpd','$keperluan','$jns_spp','$kd_kegiatan','$kd_rek5','$nilai','$tgl_kas_bud') ";

				$asg1 = $this->db->query($sql1);
				if($asg1){
							$isi  ='Insert ['.$baris.']'.'.'.$this->titik($no_sp2d.'||'.$kd_rek5.'||'.$nilai).'=>['.$keperluan.']';
							$datx=array("isi"=>$isi,"baris"=>($baris),"pesan"=>'0','1');
							echo json_encode($datx);
					 
				}else{
					$isi  ='Gagal Insert ['.$baris.']'.'.'.$this->titik($no_sp2d.'||'.$kd_rek5.'||'.$nilai).'=>['.$keperluan.']';
					$datx=array("isi"=>$isi,"baris"=>($baris),"pesan"=>'1','0');
					echo json_encode($datx); 
				}
				
				
			}

	}

	 function titik($str){
        $panjang=50;
        if($panjang>=strlen($str)){
            $selisih=$panjang-strlen($str);
            for($i=1;$i<=$selisih;$i++){
                $str .='.';
            }
            $hasil=$str;
        }else{
            $hasil=substr($str,0,105);
        } 
        return $hasil;
    }
	
	function load_transfer() {
		$this->load->model('koneksi');
		$kd_skpd = $this->session->userdata('kdskpd');

		$result = array();
		$row = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$offset = ($page-1)*$rows;
		$kriteria = '';
		$kriteria = $this->input->post('cari');

        $where = "where kd_skpd = '$kd_skpd'";
		
        if ($kriteria <> ''){                               
            $where .=" and kd_skpd like'%$kriteria%' or no_spm like'%$kriteria%' or no_spp like'%$kriteria%')";            
        }

  		
		$sql = "SELECT count(*) as tot from temp_sp2d $where" ;
		$query1 = $this->db_keu->query($sql);
		$total = $query1->row();
		
		$sql = "SELECT * from temp_sp2d $where order by no_sp2d desc limit $offset,$rows";
		$query1 = $this->db_keu->query($sql);  
		$result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
						'no_spm' => $resulte['no_spm'],     
						'no_spp' => $resulte['no_spp'], 	
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd']                                                                                                
                        );
                        $ii++;
        }
        
		
		
        $result["total"] = $total->tot;
        $result["rows"] = $row; 

        echo json_encode($result);
    	   
	}



	function load_telah_transfer() {
		$this->load->model('koneksi');
		$kd_skpd = $this->session->userdata('kdskpd');

        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');

        $where = "where kd_skpd = '$kd_skpd' and st_ex='11'";
		
        if ($kriteria <> ''){                               
            $where .=" and (upper(nm_skpd) like upper('%$kriteria%') or kd_skpd like'%$kriteria%' or no_spm like'%$kriteria%' or no_spp like'%$kriteria%')";            
        }

        $sql = "SELECT count(*) as tot from trhspm $where" ;
        $query1 = $this->db_keu->query($sql);
        $total = $query1->row();
		     
        $sql = "SELECT * from trhspm $where order by tgl_spm desc limit $offset,$rows";
        $query1 = $this->db_keu->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
						'no_spm' => $resulte['no_spm'],     
						'no_spp' => $resulte['no_spp'], 	
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],                                                                                                
                        'st_ex' => $resulte['st_ex']                                                                                                
                        );
                        $ii++;
        }
        
		
		
        $result["total"] = $total->tot;
        $result["rows"] = $row; 

        echo json_encode($result);
    	   
	}

	private function f_project_root(){

		$array_url = explode('/',base_url());

		unset($array_url[0]);
		unset($array_url[1]);
		unset($array_url[2]);

		$ext = implode('/', $array_url);

		return $_SERVER['DOCUMENT_ROOT'].'/'.$ext;


	}


	function backup_data(){
		$this->load->model('koneksi');
					   
		$kodeskpd=$this->session->userdata('kdskpd');
		$sql="select nm_skpd from ms_skpd where kd_skpd='$kodeskpd'";
		$query=$this->db->query($sql);
		$hasil=$query->row();
		$namaskpd=$hasil->nm_skpd;
		
		$nm_skpd=substr($namaskpd,0,20);
	
		$array_no_spm = explode('|',$this->input->get('str_no_spm'));
		$array_no_spp = explode('|',$this->input->get('str_no_spp'));
		
		$tgl_update=  date('Y-m-d H:i:s');
		foreach($array_no_spm as $array_nospmm){
	//			$this->db->query("update trhspm set st_ex='11', tgl_ex='$tgl_update' where no_spm='$array_nospmm'");
		}
		// $nama_file	  =	'C:/BACKUP/SPM/SIADINDA_SPM'.'_'.$kodeskpd.'_'.date("DdMY").'_'.time().'_1.dny';


		// jika directory belum ada maka buat directory nya
		if(!file_exists($this->f_project_root().'import_sp2d_blud')){
			mkdir($this->f_project_root().'import_sp2d_blud', 0777);	
		}

		$nama_file = $this->f_project_root(). 'import_sp2d_blud/SIMBLUD'.'_'.$kodeskpd.'_'.date("DdMY").'_'.time().'_1.sql';	
		
		


		

	
		$return="";
		
		$return	.= "/*".$kodeskpd."*/\n";
		$return	.= "DROP TABLE IF EXISTS trhspmtemp;\n" ;
	
		$query_create_table=$this->db_keu->query("show create table trhspm");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		$return .= str_replace('trhspm','trhspmtemp',$field_create).";\n";
		
		
		foreach($array_no_spm as $array_no_spm){
			$this->db_keu->or_where('no_spm',$array_no_spm);
		}

		$sql = $this->db->query("Delete From trhspm");		 
		$query =$this->db_keu->get('trhspm');
		
		foreach($query->result() as $result){

			$query_column = $this->db_keu->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='simakda_siadinda_2016' AND table_name = 'trhspm'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
			
		
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
				$field_name .= $column->COLUMN_NAME. ",";
					
				$column_name = $column->COLUMN_NAME;			
				$values .= '"'.$result->$column_name.'",';
			}
			
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
		
			$return .= "INSERT INTO trhspmtemp ($field_name) VALUES ($values);\n";

			//$sql ="Insert Into trhspm ($field_name) VALUES ($values)";

			$sql = $this->db->query("Insert Into trhspm ($field_name) VALUES ($values)");  
				
			
		}
		
		
		
		
		// echo $return;
		$handle = fopen($nama_file,'w+');
		$write = fwrite($handle, $return);

		if($write != false){
			fclose($handle);
			echo 1;
		}else{
			echo 0;
		}
		
		       
	}
}
