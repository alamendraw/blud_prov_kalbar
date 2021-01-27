<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_penagihan extends CI_Model {

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

	
	function load_rek_penagihan($jenis,$giat,$kode,$nomor,$rek,$lccr){
		if ($rek !=''){        
            $notIn = " and b.kd_rek5 not in ($rek) " ;
        }else{
            $notIn  = "";
        }
			 $sql = "select a.kd_kegiatan,a.kd_rek5,a.nm_rek5,b.kd_rek5 as kd_rek_blud, b.uraian as nm_rek_blud, 
					b.total as anggaran, b.total_sempurna as anggaran_sempurna, b.total_ubah as anggaran_ubah,
					(SELECT SUM(nilai) FROM (SELECT SUM(c.nilai) as nilai  FROM trdtransout_blud c 
					INNER JOIN trhtransout_blud d ON c.kd_skpd=d.kd_skpd AND c.no_bukti=d.no_bukti
					WHERE  d.jns_spp='1' AND c.kd_kegiatan =a.kd_kegiatan AND c.kd_skpd=a.kd_skpd AND c.kd_rek5=a.kd_rek5 AND c.kd_rek_blud=b.kd_rek5 
					UNION ALL
					SELECT SUM(e.nilai) as nilai FROM trdspp_blud e INNER JOIN trhsp2d_blud f ON e.kd_skpd=f.kd_skpd AND e.no_spp=f.no_spp
					WHERE f.jns_spp IN ('3','4','5','6')
					AND e.kd_kegiatan =a.kd_kegiatan AND e.kd_skpd=a.kd_skpd AND e.kd_rek5=a.kd_rek5 AND e.kd_rek_blud=b.kd_rek5	
					UNION ALL
					SELECT SUM(g.nilai) as nilai FROM trdtagih_blud g INNER JOIN trhtagih_blud h ON g.kd_skpd=h.kd_skpd AND g.no_bukti=h.no_bukti
			WHERE g.kd_kegiatan =a.kd_kegiatan AND g.kd_skpd=a.kd_skpd AND g.kd_rek5=a.kd_rek5 AND g.kd_rek_blud=b.kd_rek5	
			AND h.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$kode')  
			AND h.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhtransout_blud WHERE kd_skpd='$kode')  	
			)a) as lalu 
					FROM trdrka_blud a 
					LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
					WHERE a.kd_kegiatan='$giat'
					$notIn ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],  
                        'nm_rek5' => $resulte['nm_rek5'],
                        'nm_rek_blud' => $resulte['nm_rek_blud'],
                        'lalu' => $resulte['lalu'],
                        'anggaran' => $resulte['anggaran'],
                        'anggaran_semp' => $resulte['anggaran_sempurna'],
                        'anggaran_ubah' => $resulte['anggaran_ubah'],
                        );
                        $ii++;
        }                   
       return $result;    
       $query1->free_result();
	}
	
	function simpan_penagihan_ls($nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update){
		$sql = "delete from trhtagih_blud where kd_skpd='$skpd' and no_bukti='$nomor'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhtagih_blud(no_bukti,tgl_bukti,ket,kd_skpd,jns_spp,jenis,sts_tagih,kontrak,total,username,tgl_update,status) 
                        values('$nomor','$tgl','$ket','$skpd','$cjenis','$jns','$sts_tagih','$kontrak','$ctotal','$usernm','$last_update','0')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                    exit();
                }
                if ($asg){
                    $sql = "delete from trdtagih_blud where no_bukti='$nomor' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '1';
                        return $msg;
                        exit();
                    }else{
                        $sql = "insert into trdtagih_blud(no_bukti,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd) values $sql_detail";
						$asg = $this->db->query($sql); 
							if(!($asg)){
								$msg = '1';
								return $msg;
								exit();
							}else{
								$msg = '2';
								return $msg;
								exit();	
							}
                    }                
                }            
            }else{
				$msg = '0';
                return $msg;
                exit();
			} 
         
	}
	
	function update_penagihan_ls($no_hide,$nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update){
		$sql = "DELETE from trhtagih_blud where kd_skpd='$skpd' and no_bukti='$no_hide'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhtagih_blud(no_bukti,tgl_bukti,ket,kd_skpd,jns_spp,jenis,sts_tagih,kontrak,total,username,tgl_update,status) 
                        values('$nomor','$tgl','$ket','$skpd','$cjenis','$jns','$sts_tagih','$kontrak','$ctotal','$usernm','$last_update','0')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                    exit();
                }
                if ($asg){
                    $sql = "delete from trdtagih_blud where no_bukti='$no_hide' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '1';
                        return $msg;
                        exit();
                    }else{
                        $sql = "insert into trdtagih_blud(no_bukti,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd) values $sql_detail";
						$asg = $this->db->query($sql); 
							if(!($asg)){
								$msg = '1';
								return $msg;
								exit();
							}else{
								$msg = '2';
								return $msg;
								exit();	
							}
                    }                
                }            
            }else{
				$msg = '0';
				return $msg;
				exit();
			}  
	}
	
	function simpan_penagihan_non_ls($nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update){
		$sql = "delete from trhtagih_blud where kd_skpd='$skpd' and no_bukti='$nomor'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhtagih_blud(no_bukti,tgl_bukti,ket,kd_skpd,jns_spp,jenis,sts_tagih,kontrak,total,username,tgl_update,status) 
                        values('$nomor','$tgl','$ket','$skpd','$cjenis','$jns','$sts_tagih','$kontrak','$ctotal','$usernm','$last_update','0')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                    exit();
                }
                if ($asg){
                    $sql = "delete from trdtagih_blud where no_bukti='$nomor' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '1';
                        return $msg;
                        exit();
                    }else{
                        $sql = "insert into trdtagih_blud(no_bukti,no_sp2d,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd) values $sql_detail";
						$asg = $this->db->query($sql); 
							if(!($asg)){
								$msg = '1';
								return $msg;
								exit();
							}else{
								$msg = '2';
								return $msg;
								exit();	
							}
                    }                
                }            
            }else{
				$msg = '0';
                return $msg;
                exit();
			} 
         
	}
	
	function update_penagihan_non_ls($no_hide,$nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update){
		$sql = "DELETE from trhtagih_blud where kd_skpd='$skpd' and no_bukti='$no_hide'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhtagih_blud(no_bukti,tgl_bukti,ket,kd_skpd,jns_spp,jenis,sts_tagih,kontrak,total,username,tgl_update,status) 
                        values('$nomor','$tgl','$ket','$skpd','$cjenis','$jns','$sts_tagih','$kontrak','$ctotal','$usernm','$last_update','0')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                    exit();
                }
                if ($asg){
                    $sql = "delete from trdtagih_blud where no_bukti='$no_hide' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '1';
                        return $msg;
                        exit();
                    }else{
                        $sql = "insert into trdtagih_blud(no_bukti,no_sp2d,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd) values $sql_detail";
						$asg = $this->db->query($sql); 
							if(!($asg)){
								$msg = '1';
								return $msg;
								exit();
							}else{
								$msg = '2';
								return $msg;
								exit();	
							}
                    }                
                }            
            }else{
				$msg = '0';
				return $msg;
				exit();
			}  
	}
	
	
	function load_penagihan_ls($skpd,$kriteria){
		$result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(no_bukti) like upper('%$kriteria%') or tgl_bukti like '%$kriteria%' or upper(nm_skpd) like 
                    upper('%$kriteria%') or upper(ket) like upper('%$kriteria%')) ";            
        }
        $sql = "SELECT count(*) as total from trhtagih_blud WHERE kd_skpd='$skpd' and jns_spp='6' $where " ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();        

        $sql = "SELECT TOP $rows * from trhtagih_blud  WHERE kd_skpd='$skpd' and jns_spp='6' $where AND no_bukti not in (SELECT TOP $offset no_bukti from trhtagih_blud  WHERE kd_skpd='$skpd' and jns_spp='6' $where order by no_bukti) order by no_bukti,kd_skpd ";
        $query1 = $this->db->query($sql);  
        
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(
                        'id' 		=> $ii,        
                        'no_bukti' 	=> $resulte['no_bukti'],
                        'tgl_bukti' => $resulte['tgl_bukti'],
                        'ket' 		=> $resulte['ket'],
                        'username' 	=> $resulte['username'],    
                        'tgl_update'=> $resulte['tgl_update'],
                        'kd_skpd' 	=> $resulte['kd_skpd'],
                        'total' 	=> $resulte['total'],
                        'sts_tagih' => $resulte['sts_tagih'],
                        'status'    => $resulte['status'],						
                        'jenis'    	=> $resulte['jenis'],
						'kontrak'   => $resulte['kontrak']						
                        );
                        $ii++;
        }
       	$result["rows"] = $row; 
        return $result;
        $query1->free_result(); 
	}
	
	function load_penagihan_non_ls($skpd,$kriteria){
		$result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(no_bukti) like upper('%$kriteria%') or tgl_bukti like '%$kriteria%' or upper(nm_skpd) like 
                    upper('%$kriteria%') or upper(ket) like upper('%$kriteria%')) ";            
        }
        $sql = "SELECT count(*) as total from trhtagih_blud WHERE kd_skpd='$skpd' and jns_spp='1' $where " ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();        

        $sql = "SELECT TOP $rows * from trhtagih_blud  WHERE kd_skpd='$skpd' and jns_spp='1' $where AND no_bukti not in (SELECT TOP $offset no_bukti from trhtagih_blud  WHERE kd_skpd='$skpd' and jns_spp='6' $where order by no_bukti) order by no_bukti,kd_skpd ";
        $query1 = $this->db->query($sql);  
        
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(
                        'id' 		=> $ii,        
                        'no_bukti' 	=> $resulte['no_bukti'],
                        'tgl_bukti' => $resulte['tgl_bukti'],
                        'ket' 		=> $resulte['ket'],
                        'username' 	=> $resulte['username'],    
                        'tgl_update'=> $resulte['tgl_update'],
                        'kd_skpd' 	=> $resulte['kd_skpd'],
                        'total' 	=> $resulte['total'],
                        'sts_tagih' => $resulte['sts_tagih'],
                        'status'    => $resulte['status'],						
                        'jenis'    	=> $resulte['jenis'],
						'kontrak'   => $resulte['kontrak']						
                        );
                        $ii++;
        }
       	$result["rows"] = $row; 
        return $result;
        $query1->free_result(); 
	}
	
	function load_dtagih($nomor,$skpd){
		$sql = "SELECT b.no_bukti,b.no_sp2d, b.kd_kegiatan, b.kd_rek5,b.kd_rek_blud,b.nm_rek_blud,b.nilai
                FROM trhtagih_blud a INNER JOIN
                trdtagih_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
				WHERE a.no_bukti='$nomor'AND a.kd_skpd='$skpd' ORDER BY b.kd_kegiatan,b.kd_rek5";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id'            => $ii,        
                        'no_bukti'      => $resulte['no_bukti'],
                        'no_sp2d'       => $resulte['no_sp2d'],
                        'kd_kegiatan'   => $resulte['kd_kegiatan'],
                        'kd_rek5'       => $resulte['kd_rek5'],
                        'kd_rek_blud'   => $resulte['kd_rek_blud'],
                        'nm_rek_blud'   => $resulte['nm_rek_blud'],
                        'nilai'         => $resulte['nilai']
                        );
                        $ii++;
        }           
        return $result;
        $query1->free_result();
	}
	
	function load_tot_tagih($no,$skpd){
		$query1 = $this->db->query("select sum(nilai) as rektagih from trhtagih_blud a INNER join trdtagih_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
								where a.no_bukti='$no' AND a.kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'total' => number_format($resulte['rektagih'],2,'.',',')
                        );
                        $ii++;
        }
		return $result;
        $query1->free_result();	
	}
	
	function kontrak($lccr,$kd_skpd){
		$sql = "SELECT TOP 5 kontrak FROM trhtagih_blud WHERE kd_skpd = '$kd_skpd'   
					AND UPPER(kontrak) LIKE UPPER('%$lccr%')
					GROUP BY kontrak ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte) {            
            $result[] = array(
                        'id' => $ii,        
                        'kontrak' => $resulte['kontrak'],  
                        );
                        $ii++;
        }
        return $result;
        $query1->free_result();
	}
	
	function load_sp2d($giat,$kode){
		$sql ="SELECT a.no_sp2d, a.total FROM trhsp2d_blud a 
		INNER JOIN trdspp_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
		WHERE a.status_sp2d='1' AND b.kd_kegiatan= '$giat' AND a.kd_skpd = '$kode' 
		AND a.jns_spp !='6'
		GROUP BY a.no_sp2d,a.total";
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
	
	function load_sisa_kas($skpd){
		$sql ="SELECT SUM(setor) setor, SUM(realisasi) as realisasi,SUM(kembali) as kembali FROM (
				SELECT SUM(saldo_lalu) as setor,0 realisasi,0 kembali FROM ms_skpd_blud WHERE kd_skpd='$skpd'
				
				UNION ALL
				SELECT SUM(a.rupiah) as setor,0 realisasi, 0 kembali FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd='$skpd' AND jns_trans in ('2','4','1','5') AND LEFT(kd_rek_blud,1) IN ('4','1','5')
				
				UNION ALL 
				SELECT 0 setor,SUM(nilai) as realisasi, 0 kembali FROM( SELECT SUM(a.nilai) as nilai FROM trdtransout_blud a INNER JOIN trhtransout_blud b 
				ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
				WHERE LEFT(kd_rek5,1)='5' AND a.kd_skpd='$skpd'
				AND jns_spp='1'
				UNION ALL
				SELECT SUM(a.nilai) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
				WHERE jns_spp IN ('3','4','5','6') AND LEFT(kd_rek5,1)='5' AND a.kd_skpd='$skpd'
				UNION ALL
				SELECT SUM(a.nilai) as nilai FROM trdtagih_blud a INNER JOIN trhtagih_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
				WHERE LEFT(kd_rek5,1)='5' AND a.kd_skpd='$skpd'
				AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$skpd')  
				AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhtransout_blud WHERE kd_skpd='$skpd')  
				) c
				UNION ALL 
				SELECT 0 setor, 0 realisasi, SUM(rupiah) AS kembali FROM trdkasin_blud a 
				INNER JOIN trhkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd='$skpd' ) a";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'setor'  	=> $resulte ['setor'],
                    'kembali'  	=> $resulte ['kembali'],
                    'realisasi'	=> $resulte ['realisasi'],
                    'sisa'	=> ($resulte ['setor']+$resulte ['kembali']-$resulte ['realisasi']),
                    //'sisa'	=> ($resulte ['setor']-$resulte ['realisasi']),
            );
        }
       return $result;
        $query1->free_result ();
	}
	
	
	function load_sisa_kas_blud($skpd,$tgl_spp){
		$sql ="select isnull(sum(q.terima_spj-q.keluar_spj),0) kasben from (
				select a.tgl_sts tgl,SUM(b.rupiah) as terima_spj,0 as keluar_spj FROM trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
							WHERE a.kd_skpd = '$skpd'
							group by a.tgl_sts
				union ALL
				SELECT c.tgl,'0' terima_spj,SUM(nilai) as keluar_spj FROM(
							SELECT b.tgl_kas tgl,SUM(a.nilai) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
							WHERE  LEFT(kd_rek5,1)='5' and b.no_tagih='' and b.kd_skpd='$skpd'
							GROUP BY b.tgl_kas
							UNION ALL
							SELECT b.tgl_bukti tgl,SUM(a.nilai) as nilai FROM trdtagih_blud a INNER JOIN trhtagih_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
							WHERE LEFT(a.kd_rek5,1)='5' and b.kd_skpd='$skpd'
							AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$skpd')    
							GROUP BY b.tgl_bukti
				) c
				GROUP BY c.tgl
				) q where q.tgl<='$tgl_spp'";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'setor'  	=> $resulte ['kasben']
            );
        }
       return $result;
        $query1->free_result ();
	}
	
	
	
	
}