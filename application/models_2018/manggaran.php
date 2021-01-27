<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class manggaran extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	
	}

	function get_ctkanggaran($id){
		
		$sql1= "SELECT LEFT(rka.kd_rek5,1) AS kode, (SELECT ms.nm_rek1 FROM ms_rek1 ms WHERE ms.kd_rek1 = LEFT(rka.kd_rek5,1) LIMIT 1) AS nama
				FROM trdrka rka WHERE rka.kd_skpd = '$id' AND rka.`skpd` = 'skpd' GROUP BY LEFT(rka.kd_rek5,1)
				UNION ALL
				SELECT LEFT(rka.kd_rek5,2) AS kode, (SELECT ms.nm_rek2 FROM ms_rek2 ms WHERE ms.kd_rek2 = LEFT(rka.kd_rek5,2) LIMIT 1) AS nama
				FROM trdrka rka WHERE rka.kd_skpd = '$id' AND rka.`skpd` = 'skpd' GROUP BY LEFT(rka.kd_rek5,2)
				UNION ALL
				SELECT LEFT(rka.kd_rek5,3) AS kode, (SELECT ms.nm_rek3 FROM ms_rek3 ms WHERE ms.kd_rek3 = LEFT(rka.kd_rek5,3) LIMIT 1) AS nama
				FROM trdrka rka WHERE rka.kd_skpd = '$id' AND rka.`skpd` = 'skpd' GROUP BY LEFT(rka.kd_rek5,3)
				UNION ALL
				SELECT LEFT(rka.kd_rek5,5) AS kode, (SELECT ms.nm_rek4 FROM ms_rek4 ms WHERE ms.kd_rek4 = LEFT(rka.kd_rek5,5) LIMIT 1) AS nama
				FROM trdrka rka WHERE rka.kd_skpd = '$id' AND LEFT(rka.kd_rek5,2)='51' AND rka.`skpd` = 'skpd' GROUP BY LEFT(rka.kd_rek5,5)
				ORDER BY kode";
			 
			$query = $this->db->query($sql1);
	
		return $query->result();	
	}
	
	function get_ctk_blmodal($id){
		
		$sql1= "SELECT rka.kd_rek5 AS kode,rka.nm_rek5 AS nama
				FROM trdrka rka  WHERE LEFT(rka.kd_rek5,3) = '523' AND rka.kd_skpd = '$id' GROUP BY LEFT(rka.kd_rek5,5)
				ORDER BY kode";
			 
			$query = $this->db->query($sql1);
	
		return $query->result();	
	}
	
	function get_ctkanggaran3($id){
		
		$sql1= "SELECT rka.kd_kegiatan,nm_kegiatan FROM trdrka rka
			INNER JOIN trdskpd sk ON rka.kd_kegiatan = sk.kd_kegiatan AND
			rka.kd_skpd=sk.kd_skpd WHERE  rka.kd_skpd='$id' AND LEFT(rka.kd_rek5,1) <> '4' GROUP BY rka.kd_kegiatan";
			 
		$query = $this->db->query($sql1);
	
		
		return $query->result();	
	}
	
	function get_ctk_blmodal2($id){
		
		$sql1= "SELECT rka.kd_kegiatan,rka.nm_kegiatan FROM trdrka rka
				INNER JOIN trdskpd_2016 sk ON rka.kd_kegiatan = sk.kd_kegiatan AND
				rka.kd_skpd=sk.kd_skpd WHERE  rka.kd_skpd='$id' AND LEFT(rka.kd_rek5,1) <> '4' GROUP BY rka.kd_kegiatan";
							 
			$query = $this->db->query($sql1);
	
		return $query->result();	
	}
	
	function  dotrek($rek){
		
		$nrek=strlen($rek);
		switch ($nrek) {
		case 1:
		$rek = $this->left($rek,1);
		 break;
		case 2:
			$rek = $this->left($rek,1).'.'.substr($rek,1,1);
		 break;
		case 3:
			$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1);
		 break;
		case 5:
			$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);
		break;
		case 7:
			$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);
		break;
		default:
		$rek = "";
		}
		return $rek;
    }
	
	function left($string, $count){
		return substr($string, 0, $count);
    }


}


