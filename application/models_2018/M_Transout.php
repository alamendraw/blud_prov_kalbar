<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_Transout extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->model('tukd_model');
    }

    function left($string, $count){
    return substr($string, 0, $count);
    }

    function  tanggal_format_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = $this-> getBulan(substr($tgl,5,2));
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.' '.$bulan.' '.$tahun;

    }

    function  getBulan($bln){
        switch  ($bln){
        case  1:
        return  "Januari";
        break;
        case  2:
        return  "Februari";
        break;
        case  3:
        return  "Maret";
        break;
        case  4:
        return  "April";
        break;
        case  5:
        return  "Mei";
        break;
        case  6:
        return  "Juni";
        break;
        case  7:
        return  "Juli";
        break;
        case  8:
        return  "Agustus";
        break;
        case  9:
        return  "September";
        break;
        case  10:
        return  "Oktober";
        break;
        case  11:
        return  "November";
        break;
        case  12:
        return  "Desember";
        break;
    	}
    }
	
	function jumlah_ang_trans_lain($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$jns,$sp2d){

			$sql="SELECT SUM(b.total) as nilai, SUM(b.total_sempurna) as nilai_sempurna,SUM(b.total_ubah) as nilai_ubah,
			(
			SELECT SUM(nilai) as nilai FROM
			(
			SELECT SUM(a.nilai) as nilai FROM trdtransout_blud a INNER JOIN trhtransout_blud b 
			ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud'
			AND jns_spp='1'
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
			WHERE jns_spp IN ('3','4','5','6') AND a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud'
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdtagih_blud a INNER JOIN trhtagih_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud'
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$ckdskpd')  
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhtransout_blud WHERE kd_skpd='$ckdskpd')  
			) c) as lalu
			FROM trdrka_blud a LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND b.kd_rek5='$crekblud'";
		
        $query1   = $this->db->query($sql);   
        $result   = array();
        $ii       = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'             => $ii,        
                        'nilai'          => number_format($resulte['nilai'],2,'.',','),
                        'nilai_sempurna' => number_format($resulte['nilai_sempurna'],2,'.',','),
                        'nilai_ubah'     => number_format($resulte['nilai_ubah'],2,'.',','),
                        'nilai_spp_lalu' => number_format($resulte['lalu'],2,'.',',')
                        );
                        $ii++;
        }
        return $result;
        $query1->free_result();	
	}
	

	function load_transout_silpa($kd_skpd,$kriteria){
		$where = '';        
		$result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        
        if ($kriteria != '') {
            $where = " and (upper(a.no_bukti) like upper('%$kriteria%') or a.tgl_bukti like '%$kriteria%' or upper(a.nm_skpd) like 
                    upper('%$kriteria%') or upper(a.ket) like upper('%$kriteria%')) ";
        }
        
        $sql = "SELECT count(*) as tot from trhtransout_blud a where kd_skpd='$kd_skpd' AND jenis='11'  $where ";
       $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT * FROM trhtransout_blud where kd_skpd='$kd_skpd' AND jenis='11'  $where";
        $query1 = $this->db->query ( $sql );
        $result = array();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $row [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_kas'   	  => $resulte ['no_kas'],
                    'tgl_bukti'   => $resulte ['tgl_bukti'],
                    'tgl_kas' 	  => $resulte ['tgl_kas'],
                    'no_sp2d' 	  => $resulte ['no_sp2d'],
                    'ket'         => $resulte ['ket'],
                    'username'    => $resulte ['username'],
                    'tgl_update'  => $resulte ['tgl_update'],
                    'kd_skpd'     => $resulte ['kd_skpd'],
                    'kd_unit'     => $resulte ['kd_unit'],
                    'nm_skpd'     => $resulte ['nm_skpd'],
                    'total'       => $resulte ['total'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'no_tagih'    => $resulte ['no_tagih'],
                    'sts_tagih'   => $resulte ['sts_tagih'],
                    'tgl_tagih'   => $resulte ['tgl_tagih'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'pay'         => $resulte ['pay'],
                    'no_kas_pot'  => $resulte ['no_kas_pot'],
                    'status'      => $resulte ['status'],
                    'jenis'      => $resulte ['jenis']
                    
            );
            $ii ++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row;
        return $result;
        $query1->free_result();
	}
	
	function load_transout_lain($kd_skpd,$kriteria){
		$where = '';        
		$result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        
        if ($kriteria != '') {
            $where = " and (upper(a.no_bukti) like upper('%$kriteria%') or a.tgl_bukti like '%$kriteria%' or upper(a.nm_skpd) like 
                    upper('%$kriteria%') or upper(a.ket) like upper('%$kriteria%')) ";
        }
        
        $sql = "SELECT count(*) as tot from trhtransout_blud a where kd_skpd='$kd_skpd' AND jenis='10'  $where ";
       $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT * FROM trhtransout_blud where kd_skpd='$kd_skpd' AND jenis='10'  $where";
        $query1 = $this->db->query ( $sql );
        $result = array();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $row [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_kas'   	  => $resulte ['no_kas'],
                    'tgl_bukti'   => $resulte ['tgl_bukti'],
                    'tgl_kas' 	  => $resulte ['tgl_kas'],
                    'no_sp2d' 	  => $resulte ['no_sp2d'],
                    'ket'         => $resulte ['ket'],
                    'username'    => $resulte ['username'],
                    'tgl_update'  => $resulte ['tgl_update'],
                    'kd_skpd'     => $resulte ['kd_skpd'],
                    'kd_unit'     => $resulte ['kd_unit'],
                    'nm_skpd'     => $resulte ['nm_skpd'],
                    'total'       => $resulte ['total'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'no_tagih'    => $resulte ['no_tagih'],
                    'sts_tagih'   => $resulte ['sts_tagih'],
                    'tgl_tagih'   => $resulte ['tgl_tagih'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'pay'         => $resulte ['pay'],
                    'no_kas_pot'  => $resulte ['no_kas_pot'],
                    'status'      => $resulte ['status'],
                    'jenis'      => $resulte ['jenis']
                    
            );
            $ii ++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row;
        return $result;
        $query1->free_result();
	}
	
	
	function load_no_ambil_kas($giat,$kode,$jns){
			
        $sql ="SELECT no_bukti no_sp2d, tgl_bukti, nilai total FROM tr_setorsimpanan_blud WHERE jenis='1' AND kd_skpd = '$kode' ORDER BY no_bukti, nilai";
    
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'         => $ii,
                    'no_sp2d'    => $resulte ['no_sp2d'],
                    'tgl_bukti'  => $resulte ['tgl_bukti'],
                    'total'      => $resulte ['total']
            );
            $ii ++;
        }
       return $result;
        $query1->free_result ();
	}
	
	function load_no_ambil_silpa($giat,$kode,$jns){
            $thn = $this->session->userdata ('pcThang' );

        $sql ="SELECT 'SILPA' no_sp2d, '$thn-01-01' tgl_bukti, isnull(sum(total),0) total from (
				  SELECT 'SILPA' no_sp2d, '$thn-01-01' tgl_bukti, saldo_lalu total FROM ms_skpd_blud WHERE kd_skpd = '$kode'
				  UNION ALL
				  SELECT 'SILPA' no_sp2d, '$thn-01-01' tgl_bukti, isnull(a.nilai,0)*-1 total from trdtransout_blud a inner join trhtransout_blud b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
				  where jenis='11' AND a.kd_skpd = '$kode') a";
    
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'         => $ii,
                    'no_sp2d'    => $resulte ['no_sp2d'],
                    'tgl_bukti'  => $resulte ['tgl_bukti'],
                    'total'      => $resulte ['total']
            );
            $ii ++;
        }
       return $result;
        $query1->free_result ();
	}
	
	function load_rek_lain($giat,$jns,$skpd,$nomor,$sp2d){
		
            $sql = "SELECT distinct a.kd_rek5,a.nm_rek5,c.kd_rek5 kd_rek_blud, c.nm_rek5 nm_rek_blud FROM trdrka_blud a 
					INNER JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
					LEFT JOIN ms_rek5_blud c ON b.kd_rek5=c.kd_rek5
					WHERE a.kd_skpd='$skpd' AND a.kd_kegiatan='$giat' and c.jenis in ('1','2')";
				
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'kd_rek5'  => $resulte ['kd_rek5'],
                    'nm_rek5'  => $resulte ['nm_rek5'],
                    'kd_rek_blud'  => $resulte ['kd_rek_blud'],
                    'nm_rek_blud'  => $resulte ['nm_rek_blud']
            );
            $ii ++;
        }
		return $result;
        $query1->free_result ();
	}
	
	function load_transout($kd_skpd,$kriteria){
		$where = '';        
		$result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        
        if ($kriteria != '') {
            $where = " and (upper(a.no_bukti) like upper('%$kriteria%') or a.tgl_bukti like '%$kriteria%' or upper(a.nm_skpd) like 
                    upper('%$kriteria%') or upper(a.ket) like upper('%$kriteria%')) ";
        }
        
        $sql = "SELECT count(*) as tot from trhtransout_blud a where kd_skpd='$kd_skpd' AND jenis='1'  $where ";
       $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT * FROM trhtransout_blud where kd_skpd='$kd_skpd' AND jenis='1'  $where";
        $query1 = $this->db->query ( $sql );
        $result = array();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $row [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_kas'   	  => $resulte ['no_kas'],
                    'tgl_bukti'   => $resulte ['tgl_bukti'],
                    'tgl_kas' 	  => $resulte ['tgl_kas'],
                    'no_sp2d' 	  => $resulte ['no_sp2d'],
                    'ket'         => $resulte ['ket'],
                    'username'    => $resulte ['username'],
                    'tgl_update'  => $resulte ['tgl_update'],
                    'kd_skpd'     => $resulte ['kd_skpd'],
                    'kd_unit'     => $resulte ['kd_unit'],
                    'nm_skpd'     => $resulte ['nm_skpd'],
                    'total'       => $resulte ['total'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'no_tagih'    => $resulte ['no_tagih'],
                    'sts_tagih'   => $resulte ['sts_tagih'],
                    'tgl_tagih'   => $resulte ['tgl_tagih'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'pay'         => $resulte ['pay'],
                    'no_kas_pot'  => $resulte ['no_kas_pot'],
                    'status'      => $resulte ['status'],
                    'jenis'      => $resulte ['jenis']
                    
            );
            $ii ++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row;
        return $result;
        $query1->free_result();
	}
	
	function load_transout_tlalu($kd_skpd,$kriteria){
		$where = '';        
		$result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        
        if ($kriteria != '') {
            $where = " and (upper(a.no_bukti) like upper('%$kriteria%') or a.tgl_bukti like '%$kriteria%' or upper(a.nm_skpd) like 
                    upper('%$kriteria%') or upper(a.ket) like upper('%$kriteria%')) ";
        }
        
        $sql = "SELECT count(*) as tot from trhtransout_blud a where kd_skpd='$kd_skpd' AND jenis='2'  $where ";
       $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT * FROM trhtransout_blud where kd_skpd='$kd_skpd' AND jenis='2'  $where";
        $query1 = $this->db->query ( $sql );
        $result = array();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $row [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_kas'   	  => $resulte ['no_kas'],
                    'tgl_bukti'   => $resulte ['tgl_bukti'],
                    'tgl_kas' 	  => $resulte ['tgl_kas'],
                    'no_sp2d' 	  => $resulte ['no_sp2d'],
                    'ket'         => $resulte ['ket'],
                    'username'    => $resulte ['username'],
                    'tgl_update'  => $resulte ['tgl_update'],
                    'kd_skpd'     => $resulte ['kd_skpd'],
                    'kd_unit'     => $resulte ['kd_unit'],
                    'nm_skpd'     => $resulte ['nm_skpd'],
                    'total'       => $resulte ['total'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'no_tagih'    => $resulte ['no_tagih'],
                    'sts_tagih'   => $resulte ['sts_tagih'],
                    'tgl_tagih'   => $resulte ['tgl_tagih'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'pay'         => $resulte ['pay'],
                    'no_kas_pot'  => $resulte ['no_kas_pot'],
                    'status'      => $resulte ['status'],
                    'jenis'      => $resulte ['jenis']
                    
            );
            $ii ++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row;
        return $result;
        $query1->free_result();
	}
	
	
	function load_trskpd_blud($giat,$cskpd){
		if ($giat != '') {
            $cgiat = " and a.kd_kegiatan not in ($giat)";
        }
        $lccr = $this->input->post ( 'q' );
        $sql = "SELECT a.kd_kegiatan,a.nm_kegiatan, SUM(nilai) as nilai, SUM(nilai_ubah) as nilai_ubah FROM trdrka_blud a where kd_skpd='$cskpd' and left(kd_rek5,1)='5'
				GROUP BY a.kd_kegiatan,a.nm_kegiatan
				ORDER BY a.kd_kegiatan,a.nm_kegiatan
		";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $result [] = array (
                    'id' => $ii,
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan'],
                    'kd_program' => '',
                    'nm_program' => '',
                    'total' => $resulte ['nilai'] 
            );
            $ii ++;
        }
        
        return $result;
        $query1->free_result ();
	}
	
	function load_dtransout($nomor,$skpd){
		$sql = "SELECT * FROM trdtransout_blud WHERE no_bukti ='$nomor' AND kd_skpd='$skpd'";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_sp2d'     => $resulte ['no_sp2d'],
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan'],
                    'kd_rek5'     => $resulte ['kd_rek5'],
                    'kd_rek_blud' => $resulte ['kd_rek_blud'],
                    'nm_rek5'     => $resulte ['nm_rek5'],
                    'nm_rek_blud' => $resulte ['nm_rek_blud'],
                    'nilai'       => $resulte ['nilai'],
                    'status'      => $resulte ['status'],
                    'kd_skpd'      => $resulte ['kd_skpd']
            );
            $ii ++;
        }
		return $result ;
        $query1->free_result ();
	}
	
	function jumlah_ang_trans($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$jns,$sp2d){
		if($jns=='1'||$jns=='2'){
		
		 $sql="SELECT SUM(b.total) as nilai, SUM(b.total_sempurna) as nilai_sempurna,SUM(b.total_ubah) as nilai_ubah,
			(
			SELECT SUM(nilai) as nilai FROM
			(
			SELECT SUM(a.nilai) as nilai FROM trdtransout_blud a INNER JOIN trhtransout_blud b 
			ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud'
			AND jns_spp in ('1','2')
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
			WHERE jns_spp IN ('3','4','5','6') AND a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud'
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdtagih_blud a INNER JOIN trhtagih_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud'
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$ckdskpd')  
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhtransout_blud WHERE kd_skpd='$ckdskpd')  
			) c) as lalu
			FROM trdrka_blud a LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND b.kd_rek5='$crekblud' ";
		} else {
			$sql="SELECT SUM(b.nilai) as nilai,SUM(b.nilai) as nilai_sempurna,SUM(b.nilai) as nilai_ubah, 
				(SELECT ISNULl(SUM(a.nilai),0) as nilai FROM trdtransout_blud a INNER JOIN trhtransout_blud b 
			ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
			WHERE a.no_sp2d='$sp2d' AND a.kd_kegiatan= '$ckdkegi' AND b.kd_skpd = '$ckdskpd' 
			AND a.kd_rek5='$ckdrek' AND a.kd_rek_blud='$crekblud' ) as lalu
			FROM trhsp2d_blud a 
			INNER JOIN trdspp_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
			WHERE a.no_sp2d='$sp2d' AND b.kd_kegiatan= '$ckdkegi' AND a.kd_skpd = '$ckdskpd' 
			AND b.kd_rek5='$ckdrek' AND b.kd_rek_blud='$crekblud'";
		}
        $query1   = $this->db->query($sql);   
        $result   = array();
        $ii       = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'             => $ii,        
                        'nilai'          => number_format($resulte['nilai'],2,'.',','),
                        'nilai_sempurna' => number_format($resulte['nilai_sempurna'],2,'.',','),
                        'nilai_ubah'     => number_format($resulte['nilai_ubah'],2,'.',','),
                        'nilai_spp_lalu' => number_format($resulte['lalu'],2,'.',',')
                        );
                        $ii++;
        }
        return $result;
        $query1->free_result();	
	}
	
	function hapus_transout($nomor,$skpd){
		 $sql = "delete from trdtransout_blud where no_bukti='$nomor' AND kd_skpd='$skpd'";
        $asg = $this->db->query ( $sql );
        if ($asg) {
            $sql = "delete from trhtransout_blud  where no_bukti='$nomor' AND kd_skpd='$skpd'";
            $asg = $this->db->query ( $sql );
            $pesan = $this->db->last_query();
            $this->tukd_model->set_log_activity($pesan);
            if (! ($asg)) {
                $msg = '0';
                return $msg;
            }
        } else {
            $msg ='0';
            return $msg;
        }
        $msg = '1';
        return $msg;
	}
	
	function load_sp2d($giat,$kode,$jns){
		
		if ($jns=='1' || $jns=='2'){
            $sql ="SELECT a.no_sp2d, a.total FROM trhsp2d_blud a 
			INNER JOIN trdspp_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
			WHERE a.status_sp2d='1' AND a.kd_skpd = '$kode' AND a.jns_spp in ('$jns')
			GROUP BY a.no_sp2d,a.total";
            }
        else {
            $sql ="SELECT a.no_sp2d, a.total FROM trhsp2d_blud a 
			INNER JOIN trdspp_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
			WHERE a.status_sp2d='1' AND b.kd_kegiatan= '$giat' AND a.kd_skpd = '$kode' AND a.jns_spp='$jns'
			GROUP BY a.no_sp2d,a.total";
        }
		
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'no_sp2d'  => $resulte ['no_sp2d'],
                    'total'  => $resulte ['total'],
            );
            $ii ++;
        }
       return $result;
        $query1->free_result ();
	}
	
	function load_rek($giat,$jns,$skpd,$nomor,$sp2d){
		
		if ($jns=='1' || $jns=='2'){
            $sql = "SELECT distinct a.kd_rek5,a.nm_rek5,c.kd_rek5 kd_rek_blud, c.nm_rek5 nm_rek_blud FROM trdrka_blud a 
					INNER JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
					LEFT JOIN ms_rek5_blud c ON b.kd_rek5=c.kd_rek5
					WHERE a.kd_skpd='$skpd' AND a.kd_kegiatan='$giat'";
            }
        else {
            $sql = "SELECT b.kd_rek5,c.nm_rek5,b.kd_rek_blud,nm_rek_blud FROM trhsp2d_blud a 
					INNER JOIN trdspp_blud b  ON a.kd_skpd=b.kd_skpd AND a.no_spp = b.no_spp
					LEFT JOIN ms_rek5 c ON b.kd_rek5=c.kd_rek5
					WHERE a.kd_skpd='$skpd' AND a.no_sp2d='$sp2d' AND b.kd_kegiatan='$giat'";
        }

		
						
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'kd_rek5'  => $resulte ['kd_rek5'],
                    'nm_rek5'  => $resulte ['nm_rek5'],
                    'kd_rek_blud'  => $resulte ['kd_rek_blud'],
                    'nm_rek_blud'  => $resulte ['nm_rek_blud'],
            );
            $ii ++;
        }
		return $result;
        $query1->free_result ();
	}
	
	function simpan_transout($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update,$jns_tagih,$no_tagih,$jenis){
		$msg = array ();
		if ($tabel == 'trhtransout_blud') {
                
                 $sqlbl      = "delete from trhtransout_blud where kd_skpd='$skpd' and no_bukti='$nomor'";
                 $asgbl      = $this->db->query ( $sqlbl );
            if ($asgbl) {
                        $sqlbl = "insert into trhtransout_blud(no_kas,tgl_kas,no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,total,pay,no_tagih,sts_tagih,jns_spp,jenis) 
                        values ('$nokas','$tglkas','$nomor','$tgl','$ket','$usernm','$update','$skpd','$nmskpd','$total','$xpay','$no_tagih','$jns_tagih','$beban','$jenis')";
                        $asgbl = $this->db->query ( $sqlbl );
                       if (! ($sqlbl)) {
                            $msg = array (
                              'pesan' => '0' 
                            );
                            return $msg;
                            exit ();
                        } else {
							if($jns_tagih=='1'){
								$sqlbl      = "UPDATE trhtagih_blud SET status='1' where kd_skpd='$skpd' and no_tagih='$no_tagih'";
								$asgbl      = $this->db->query ( $sqlbl );
									if (! ($sqlbl)) {
										$msg = array (
										  'pesan' => '0' 
										);
										return $msg;
										exit ();
									}else{
										$msg = array (
										'pesan' => '1' 
										);
										return $msg;
									}
							} else{
								$msg = array (
										'pesan' => '1' 
								);
								return $msg;
							}
                        }
            } else {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg;
            }
        
        }elseif ($tabel == 'trdtransout_blud') {
            $kode = $this->session->userdata ('kdskpd' );
            // Simpan Detail //
            $sqlbl = "delete from trdtransout_blud where kd_skpd='$kode' AND no_bukti='$nomor'";
            $asgbl = $this->db->query ( $sqlbl );
            if (! ($sqlbl)) {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg;
            } else {
                 
                 $sql   = "insert into trdtransout_blud(no_bukti,no_sp2d,kd_kegiatan,nm_kegiatan,kd_rek5,kd_rek_blud,nm_rek5,nm_rek_blud,nilai,status,kd_skpd)";
                 $asg   = $this->db->query ( $sql . $csql );
				 
                if (! ($asg)) {
                    $msg = array (
                            'pesan' => '0' 
                    );
                   return $msg;
                } else {
                    $msg = array ('pesan' => '1' );
                    return $msg;
                 
                }
                
            }
        }

	}
	
	function update_transout($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update,$nomor_simpan,$jns_tagih,$no_tagih,$jenis){
		$msg = array ();
        // Simpan Header //
        if ($tabel == 'trhtransout_blud') {
                 $sqlbl      = "delete from trhtransout_blud where kd_skpd='$skpd' and no_bukti='$nomor_simpan'";
                 $asgbl      = $this->db->query ( $sqlbl );
            if ($asgbl) {
						$sqlbl = "insert into trhtransout_blud(no_kas,tgl_kas,no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,total,pay,no_tagih,sts_tagih,jns_spp,jenis) 
                        values('$nokas','$tglkas','$nomor','$tgl','$ket','$usernm','$update','$skpd','$nmskpd','$total','$xpay','$no_tagih','$jns_tagih','$beban','$jenis')";
						$asgbl = $this->db->query ( $sqlbl );
                       if (! ($sqlbl)) {
                            $msg = array (
                                    'pesan' => '0' 
                            );
                            return $msg ;
                            exit ();
                        } else {
								if($jns_tagih=='1'){
								$sqlbl      = "UPDATE trhtagih_blud SET status='1' where kd_skpd='$skpd' and no_tagih='$no_tagih'";
								$asgbl      = $this->db->query ( $sqlbl );
									if (! ($sqlbl)) {
										$msg = array (
										  'pesan' => '0' 
										);
										return $msg;
										exit ();
									}else{
										$msg = array (
										'pesan' => '1' 
										);
										return $msg;
									}
							} else{
								$msg = array (
										'pesan' => '1' 
								);
								return $msg;
							}
                        }
            } else {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg ;
            }
        
        } 
        elseif ($tabel == 'trdtransout_blud') {
            $kode = $this->session->userdata ('kdskpd' );
            // Simpan Detail //
            $sqlbl = "delete from trdtransout_blud where kd_skpd='$kode' and no_bukti='$nomor_simpan'";
            $asgbl = $this->db->query ( $sqlbl );
            if (! ($sqlbl)) {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg ;
            } else {
                 
                 $sql   = "insert into trdtransout_blud(no_bukti,no_sp2d,kd_kegiatan,nm_kegiatan,kd_rek5,kd_rek_blud,nm_rek5,nm_rek_blud,nilai,status,kd_skpd)";
                 $asg   = $this->db->query ( $sql . $csql );
                if (! ($asg)) {
                    $msg = array (
                            'pesan' => '0' 
                    );
                   return $msg ;
                } else {
                    $msg = array ('pesan' => '1' );
                   return $msg ;
                 
                }
                
            }
        }

	}
	
	
	function load_no_penagihan($skpd,$lccr){
		$sql = "SELECT no_bukti,total FROM trhtagih_blud WHERE kd_skpd='$skpd' AND status !='1' AND jns_spp='1'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'no_bukti' => $resulte['no_bukti'],
                        'nilai' => number_format($resulte['total'],2,'.',','),
                                                                                                                 
                        );
                        $ii++;
        }
        return $result;
	}
	
	function load_detail_penagihan($kd_skpd,$no_tagih){
		
		 $sql = "SELECT a.no_sp2d,a.kd_kegiatan,b.nm_kegiatan,a.kd_rek5,c.nm_rek5,a.kd_rek_blud,a.nm_rek_blud,a.nilai 
			FROM trdtagih_blud a 
			LEFT JOIN trskpd_blud b ON a.kd_kegiatan=b.kd_kegiatan AND a.kd_skpd=b.kd_skpd
			LEFT JOIN ms_rek5 c ON a.kd_rek5=c.kd_rek5 
			WHERE no_bukti='$no_tagih' AND a.kd_skpd='$kd_skpd' 
			ORDER BY a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud";                   
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx'        => $ii,
                        'no_sp2d' => $resulte['no_sp2d'],
                        'kd_kegiatan'     => $resulte['kd_kegiatan'],  
                        'nm_kegiatan'  => $resulte['nm_kegiatan'],  
                        'kd_rek5'  => $resulte['kd_rek5'],  
                        'kd_rek_blud'  => $resulte['kd_rek_blud'],  
                        'nm_rek5'  => $resulte['nm_rek5'],  
                        'nm_rek_blud'  => $resulte['nm_rek_blud'],  
                        'nilai'     => number_format($resulte['nilai'],"2",".",",")
                        );
                        $ii++;
        }
           
     return $result;
     $query1->free_result();  
	}
	
	
	function load_giat_trans($sp2d,$cskpd){
        $lccr = $this->input->post ( 'q' );
        $sql = "SELECT b.kd_kegiatan,b.nm_kegiatan FROM trhtransout_blud a 
				INNER JOIN trdtransout_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
				WHERE b.kd_skpd='$cskpd' AND b.no_sp2d='$sp2d'
				GROUP BY b.kd_kegiatan,b.nm_kegiatan 
				ORDER BY b.kd_kegiatan,b.nm_kegiatan";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $result [] = array (
                    'id' => $ii,
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan']
            );
            $ii ++;
        }
        
        return $result;
        $query1->free_result ();
	}
	
	function load_sp2d_trans($kode,$jns){
		/* $sql ="SELECT a.no_sp2d, a.total FROM trhsp2d_blud a 
		INNER JOIN trdspp_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
		WHERE a.status_sp2d='1'  AND a.kd_skpd = '$kode' 
		AND a.jns_spp='$jns'
		GROUP BY a.no_sp2d,a.total"; */
		
		$sql = "SELECT b.no_sp2d , 0 as total FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti
		        WHERE a.kd_skpd='$kode' AND a.jns_spp='$jns' GROUP BY b.no_sp2d";
		
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'no_sp2d'  => $resulte ['no_sp2d'],
                    'total'  => $resulte ['total']
            );
            $ii ++;
        }
       return $result;
        $query1->free_result ();
	}
	
	function load_rek_trans($giat,$skpd,$sp2d){
			$sql = "SELECT b.kd_rek5,c.nm_rek5,b.kd_rek_blud,nm_rek_blud FROM trhtransout_blud a 
						INNER JOIN trdtransout_blud b  ON a.kd_skpd=b.kd_skpd AND a.no_bukti = b.no_bukti
						LEFT JOIN ms_rek5 c ON b.kd_rek5=c.kd_rek5
						WHERE a.kd_skpd='$skpd' AND b.no_sp2d='$sp2d' AND b.kd_kegiatan='$giat'
		";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'kd_rek5'  => $resulte ['kd_rek5'],
                    'nm_rek5'  => $resulte ['nm_rek5'],
                    'kd_rek_blud'  => $resulte ['kd_rek_blud'],
                    'nm_rek_blud'  => $resulte ['nm_rek_blud'],
            );
            $ii ++;
        }
		return $result;
        $query1->free_result ();
	}
	
	function jumlah_sisa_trans($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$sp2d){
		$sql="SELECT SUM(sp2d) sp2d, SUM(realisasi) as realisasi,SUM(kembali) as kembali FROM (
			SELECT SUM(a.nilai) as sp2d,0 realisasi, 0 as kembali FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
			WHERE a.kd_skpd='$ckdskpd' AND b.no_sp2d='$sp2d' 
			AND a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek'
			AND a.kd_rek_blud='$crekblud'
			UNION ALL
			SELECT 0 sp2d, SUM(b.nilai) as realisasi,0 as kembali FROM trhtransout_blud a 
			INNER JOIN trdtransout_blud b  ON a.kd_skpd=b.kd_skpd AND a.no_bukti = b.no_bukti
			LEFT JOIN ms_rek5 c ON b.kd_rek5=c.kd_rek5
			WHERE a.kd_skpd='$ckdskpd' AND b.no_sp2d='$sp2d' 
			AND b.kd_kegiatan='$ckdkegi' AND b.kd_rek5='$ckdrek'
			AND b.kd_rek_blud='$crekblud'
			UNION ALL
			SELECT 0 sp2d, 0 realisasi, SUM(rupiah) AS kembali FROM trdkasin_blud a 
			INNER JOIN trhkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
			WHERE a.kd_skpd='$ckdskpd' AND a.no_sp2d='$sp2d' 
			AND a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek'
			AND a.kd_rek_blud='$crekblud' )a";
		
        $query1   = $this->db->query($sql);   
        $result   = array();
        $ii       = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'            => $ii,        
                        'sp2d'          => number_format($resulte['sp2d'],2,'.',','),
                        'realisasi' 	=> number_format($resulte['realisasi'],2,'.',','),
                        'kembali'	 	=> number_format($resulte['kembali'],2,'.',','),
                        'sisa' 			=> number_format($resulte['sp2d']-$resulte['realisasi']-$resulte['kembali'],2,'.',',')
                        );
                        $ii++;
        }
        return $result;
        $query1->free_result();	
	}
	
	function simpan_pengembalian($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update){
		$msg = array ();
		if ($tabel == 'trhkasin_blud') {
                 $sqlbl      = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nomor'";
                 $asgbl      = $this->db->query ( $sqlbl );
            if ($asgbl) {
                        $sqlbl = "insert into trhkasin_blud(no_sts,tgl_sts,keterangan,username,tgl_update,kd_skpd,total,pay,jns_spp) 
                        values('$nomor','$tgl','$ket','$usernm','$update','$skpd','$total','$xpay','$beban')";
                        $asgbl = $this->db->query ( $sqlbl );
                       if (! ($sqlbl)) {
                            $msg = array (
                              'pesan' => '0' 
                            );
                            return $msg;
                            exit ();
                        } else {
								$msg = array (
								'pesan' => '1' 
								);
								return $msg;
                        }
            } else {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg;
            }
        
        } 
        elseif ($tabel == 'trdkasin_blud') {
            
            // Simpan Detail //
            $sqlbl = "delete from trdkasin_blud where no_sts='$nomor'";
            $asgbl = $this->db->query ( $sqlbl );
            if (! ($sqlbl)) {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg;
            } else {
                 $sql   = "insert into trdkasin_blud(no_sts,no_sp2d,kd_kegiatan,kd_rek5,kd_rek_blud,rupiah,kd_skpd,nm_rek_blud)";
                 $asg   = $this->db->query ( $sql . $csql );
                if (! ($asg)) {
                    $msg = array (
                            'pesan' => '0' 
                    );
                   return $msg;
                } else {
                    $msg = array ('pesan' => '1' );
                    return $msg;
                 
                }
            }
        }
	}
	
	function update_pengembalian($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update,$nomor_simpan){
		$msg = array ();
        // Simpan Header //
        if ($tabel == 'trhkasin_blud') {
                 $sqlbl      = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nomor_simpan'";
                 $asgbl      = $this->db->query ( $sqlbl );
            if ($asgbl) {
                        $sqlbl = "insert into trhkasin_blud(no_sts,tgl_sts,keterangan,username,tgl_update,kd_skpd,total,pay,jns_spp) 
                        values('$nomor','$tgl','$ket','$usernm','$update','$skpd','$total','$xpay','$beban')";
                        $asgbl = $this->db->query ( $sqlbl );
                       if (! ($sqlbl)) {
                            $msg = array (
                              'pesan' => '0' 
                            );
                            return $msg;
                            exit ();
                        } else {
								$msg = array (
								'pesan' => '1' 
								);
								return $msg;
                        }
            } else {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg ;
            }
        
        } 
        elseif ($tabel == 'trdkasin_blud') {
            // Simpan Detail //
            $sqlbl = "delete from trdkasin_blud where no_sts='$nomor_simpan'";
            $asgbl = $this->db->query ( $sqlbl );
            if (! ($sqlbl)) {
                $msg = array (
                        'pesan' => '0' 
                );
               return $msg ;
            } else {
                 
                 $sql   = "insert into trdkasin_blud(no_sts,no_sp2d,kd_kegiatan,kd_rek5,kd_rek_blud,rupiah,kd_skpd,nm_rek_blud)";
                 $asg   = $this->db->query ( $sql . $csql );
                if (! ($asg)) {
                    $msg = array (
                            'pesan' => '0' 
                    );
                   return $msg ;
                } else {
                    $msg = array ('pesan' => '1' );
                   return $msg ;
                }
            }
        }
	}
	
	
	function load_pengembalian($kd_skpd,$kriteria){
		$result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		
		$where ='';
      
		
        if ($kriteria <> '') {
            $where = " and (upper(no_sts) like upper('%$kriteria%') or tgl_sts like '%$kriteria%' or upper(keterangan) like upper('%$kriteria%')) ";
            
        }
        
        $sql = "SELECT count(*) as tot from trhtransout_blud WHERE kd_skpd='$kd_skpd' AND jenis='3' $where";
       $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT TOP $rows * FROM trhtransout_blud WHERE kd_skpd='$kd_skpd' AND jenis='3' AND no_bukti NOT IN (SELECT TOP $offset no_bukti FROM trhtransout_blud WHERE kd_skpd='$kd_skpd' AND jenis='3' $where ORDER BY no_bukti) $where order by no_bukti";
        $query1 = $this->db->query ( $sql );
        $result = array();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $row [] = array (
                    'id'          => $ii,
                    'no_kas'      => $resulte ['no_kas'],
                    'tgl_kas'     => $resulte ['tgl_kas'],
					'no_bukti'    => $resulte ['no_bukti'],
                    'tgl_bukti'   => $resulte ['tgl_bukti'],
                    'no_sp2d'     => $resulte ['no_sp2d'],
                    'ket'         => $resulte ['ket'],
                    'username'    => $resulte ['username'],
                    'tgl_update'  => $resulte ['tgl_update'],
                    'kd_skpd'     => $resulte ['kd_skpd'],
                    'kd_unit'     => $resulte ['kd_unit'],
                    'nm_skpd'     => $resulte ['nm_skpd'],
                    'total'       => $resulte ['total'],
                    'no_tagih'    => $resulte ['no_tagih'],
                    'sts_tagih'   => $resulte ['sts_tagih'],
                    'tgl_tagih'   => $resulte ['tgl_tagih'],
                    'jns_spp'     => $resulte ['jns_spp'],
                    'pay'         => $resulte ['pay'],
                    'no_kas_pot'  => $resulte ['no_kas_pot'],
                    'status'      => $resulte ['status'],
                    'jenis'      => $resulte ['jenis']
                    
            );
            $ii ++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row;
        return $result;
        $query1->free_result();
	}
	
	function load_dpengembalian($nomor,$skpd){
		$sql = "SELECT * FROM trdtransout_blud WHERE no_bukti ='$nomor' AND kd_skpd='$skpd'";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_sp2d'     => $resulte ['no_sp2d'],
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan'],
                    'kd_rek5'     => $resulte ['kd_rek5'],
                    'kd_rek_blud' => $resulte ['kd_rek_blud'],
                    'nm_rek5'     => $resulte ['nm_rek5'],
                    'nm_rek_blud' => $resulte ['nm_rek_blud'],
                    'nilai'       => $resulte ['nilai'],
                    'status'      => '',
                    'kd_skpd'     => $resulte ['kd_skpd']
            );
            $ii ++;
        }
		return $result ;
        $query1->free_result ();
	}
	
	function hapus_pengembalian($nomor,$skpd){
		 $sql = "delete from trdtransout_blud where no_bukti='$nomor' AND kd_skpd='$skpd'";
        $asg = $this->db->query ( $sql );
        if ($asg) {
            $sql = "delete from trhtransout_blud  where no_bukti='$nomor' AND kd_skpd='$skpd'";
            $asg = $this->db->query ( $sql );
            $pesan = $this->db->last_query();
            $this->tukd_model->set_log_activity($pesan);
            if (! ($asg)) {
                $msg = '0';
                return $msg;
            }
        } else {
            $msg ='0';
            return $msg;
        }
        $msg = '1';
        return $msg;
	}
	
	function load_rek1($skpd,$lccr){
		$sql = "SELECT kd_rek5,nm_rek5 FROM ms_rek5_blud WHERE kd_rek5='1110301'";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'kd_rek5'  => $resulte ['kd_rek5'],
                    'nm_rek5'  => $resulte ['nm_rek5'],
            );
            $ii ++;
        }
		return $result;
        $query1->free_result ();
	}
	
	
	
}