<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_sts extends CI_Model {

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

	
	function list_no_terima($kd_skpd,$lccr){
		$sql    = "select no_terima,tgl_terima,kd_rek5,kd_rek_blud,kd_skpd,nilai,keterangan,kd_kegiatan from tr_terima_blud where kd_skpd='$kd_skpd' AND no_terima NOT IN(select ISNULL(no_terima,'') no_terima from trdkasin_blud where kd_skpd='$kd_skpd') AND no_terima LIKE '%$lccr%' ORDER BY tgl_terima,kd_rek5";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'no_terima' => $resulte['no_terima'],  
                        'tgl_terima' => $resulte['tgl_terima'],
						'kd_rek5' => $resulte['kd_rek5'],
						'kd_rek_blud' => $resulte['kd_rek_blud'],
						'kd_skpd' => $resulte['kd_skpd'],
						'kd_giat' => $resulte['kd_kegiatan'],
						'nilai' => number_format($resulte['nilai'],2,'.',','),
						'keterangan' => $resulte['keterangan']						
                        );
                        $ii++;
        }
        return $result;
		$query1->free_result();	
	}
	
	
	function simpan_sts_pendapatan($tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$pay,$jns_cp,$total,$lckdrek,$lnil_rek,$lcnilaidet,$no_terima,$usernm,$last_update,$sp2d){
			$sql = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nomor'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhkasin_blud(no_sts,kd_skpd,tgl_sts,keterangan,total,jns_spp,pay,
                        jns_trans,username,tgl_update) 
                        values('$nomor','$skpd','$tgl','$ket','$total','$jns_cp','$pay','$jnsrek','$usernm','$last_update')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdkasin_blud where no_sts='$nomor' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdkasin_blud(kd_skpd,no_sts,kd_rek5,rupiah,kd_kegiatan,no_terima,kd_rek_blud) values $lcnilaidet";
                        $asg = $this->db->query($sql); 
						$msg = '2';
						return $msg;
                    }                
                }            
            } 
	}
	
	function simpan_setor_kas($tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$pay,$jns_cp,$total,$lckdrek,$lnil_rek,$lcnilaidet,$no_terima,$usernm,$last_update,$sp2d){
			$sql = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nomor' and jns_trans<>'4'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhkasin_blud(no_sts,kd_skpd,tgl_sts,keterangan,total,jns_spp,pay,
                        jns_trans,username,tgl_update) 
                        values('$nomor','$skpd','$tgl','$ket','$total','$jns_cp','$pay','$jnsrek','$usernm','$last_update')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdkasin_blud where no_sts='$nomor' AND kd_skpd='$skpd' and LEFT(kd_rek5,1)<>'4'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdkasin_blud(kd_skpd,no_sts,kd_rek5,rupiah,kd_kegiatan,kd_rek_blud,nm_rek_blud,no_sp2d) values $lcnilaidet";
                        $asg = $this->db->query($sql); 
						$msg = '2';
						return $msg;
                    }                
                }            
            } 
	}
	
	
	function update_sts_pendapatan_ag($nohide,$tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$pay,$jns_cp,$total,$lckdrek,$lnil_rek,$lcnilaidet,$no_terima,$usernm,$last_update){
			$sql = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nohide'";
            $asg = $this->db->query($sql);
			$sql = "insert into trhkasin_blud(no_sts,kd_skpd,tgl_sts,keterangan,total,jns_spp,pay,
                        jns_trans,username,tgl_update) 
                        values('$nomor','$skpd','$tgl','$ket','$total','$jns_cp','$pay','$jnsrek','$usernm','$last_update')";
                $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                    exit();
                }
                if ($asg){
                    $sql = "delete from trdkasin_blud where no_sts='$nohide' AND kd_skpd='$skpd' ";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                        exit();
                    }else{
                        $sql = "insert into trdkasin_blud(kd_skpd,no_sts,kd_rek5,rupiah,kd_kegiatan,no_terima,kd_rek_blud) values $lcnilaidet";
                        $asg = $this->db->query($sql); 
						$msg = '2';
						return $msg;
						exit();
                    }                
                } 
	}
	
	function load_sts($kd_skpd,$kriteria){
		$result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $where ='';
        if ($kriteria <> ''){                               
            $where=" and (upper(a.no_sts) like upper('%$kriteria%') or a.tgl_sts like '%$kriteria%' or a.kd_skpd like'%$kriteria%' or
            upper(a.keterangan) like upper('%$kriteria%')) ";            
        }
       
        $sql = "SELECT COUNT(*) as total FROM trhkasin_blud a where a.kd_skpd='$kd_skpd' and a.jns_trans='4' $where " ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();
		$sql = "
		SELECT top $rows a.*,(SELECT nm_skpd FROM ms_skpd_blud WHERE kd_skpd = a.kd_skpd) AS nm_skpd
		FROM trhkasin_blud a where a.kd_skpd='$kd_skpd' and a.jns_trans='4' 
		$where  AND a.no_sts NOT IN (SELECT top $offset no_sts FROM trhkasin_blud where kd_skpd='$kd_skpd' and jns_trans='4' ORDER BY tgl_sts, no_sts)order by a.tgl_sts, a.no_sts
		";
		
		$query1 = $this->db->query($sql); 
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array( 
						'id' => $ii,        
                        'no_sts' => $resulte['no_sts'],
                        'tgl_sts' => $resulte['tgl_sts'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['keterangan'],    
                        'total' =>  number_format($resulte['total'],2,'.',','),
                        'jns_trans' => $resulte['jns_trans'],
                        'nm_skpd' => $resulte['nm_skpd']                                                                                          
                        );
                        $ii++;
				}
       $result["rows"] = $row; 
       return $result;
       $query1->free_result();	
	}
	
	function load_dsts($lcskpd,$kriteria){
		$sql = "SELECT no_sts,kd_skpd,kd_rek5,kd_rek_blud,kd_kegiatan,rupiah,no_terima
        from trdkasin_blud a where a.no_sts = '$kriteria'  AND a.kd_skpd = '$lcskpd'  order by a.no_sts";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_sts' => $resulte['no_sts'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
                        'kd_giat' => $resulte['kd_kegiatan'],
                        'rupiah' =>  number_format($resulte['rupiah'],2,'.',','),
                        'no_terima' => $resulte['no_terima']
						);
                        $ii++;
        }
       return $result;
	}
	
	function hapus_sts($kd_skpd,$nomor){
		$sql = "delete from trhkasin_blud where no_sts='$nomor' AND kd_skpd='$kd_skpd'";
        $asg = $this->db->query($sql);
		$sql = "delete from trdkasin_blud where no_sts='$nomor' AND kd_skpd='$kd_skpd'";
		$asg = $this->db->query($sql);
        $msg = '1';
        return $msg;
	}
	
	
	function ambil_rek_ag2($lccr,$lckdskpd){
		$sql = "SELECT a.kd_kegiatan, a.kd_rek5,a.nm_rek5,b.kd_rek5 as kd_blud,b.uraian from trdrka_blud a 
				LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
				WHERE a.kd_skpd='$lckdskpd' AND LEFT(a.kd_rek5,1)='4'
			    AND upper(a.kd_rek5) like upper('%$lccr%') order by a.kd_rek5";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
           
            $result[] = array(
                        'id' => $ii,
                        'kd_kegiatan' => $resulte['kd_kegiatan'],  
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        'kd_blud' => $resulte['kd_blud'],  
                        'uraian' => $resulte['uraian']
                        );
                        $ii++;
        }
        return $result;
	}
	
	function simpan_sts_pendapatan_tlalu($tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$total,$lcnilaidet,$usernm,$last_update){
		$sql = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nomor'";
            $asg = $this->db->query($sql);
            if ($asg){
				 $sql = "insert into trhkasin_blud(no_sts,kd_skpd,tgl_sts,keterangan,total,jns_trans,username,tgl_update) 
                        values('$nomor','$skpd','$tgl','$ket','$total','$jnsrek','$usernm','$last_update')";
               
			   $asg = $this->db->query($sql);
                
				if (!($asg)){
                    $msg = '0';
                    return $msg;
                    exit();
                }
               
			   if ($asg){
                    $sql = "delete from trdkasin_blud where no_sts='$nomor' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
						return $msg;
                        exit();
                    }else{
                        $sql = "insert into trdkasin_blud(kd_skpd,no_sts,kd_rek5,rupiah,kd_kegiatan,kd_rek_blud) values $lcnilaidet";
                        $asg = $this->db->query($sql); 
					}                
                }            
            }
			
			$msg = '2';
            return $msg;
            exit();
	}
	
	function load_sts_tl($kd_skpd,$kriteria){
		$result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $where ='';
        if ($kriteria <> ''){                               
            $where=" and (upper(a.no_sts) like upper('%$kriteria%') or a.tgl_sts like '%$kriteria%' or a.kd_skpd like'%$kriteria%' or
            upper(a.keterangan) like upper('%$kriteria%')) ";            
        }
        $sql = "SELECT COUNT(*) as total FROM trhkasin_blud a where a.kd_skpd='$kd_skpd' and a.jns_trans='2' $where " ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();
		$sql = "
		SELECT top $rows a.*,(SELECT nm_skpd FROM ms_skpd_blud WHERE kd_skpd = a.kd_skpd) AS nm_skpd from trhkasin_blud a where a.kd_skpd='$kd_skpd' and a.jns_trans='2' 
		$where  AND a.no_sts NOT IN (SELECT top $offset no_sts FROM trhkasin_blud where kd_skpd='$kd_skpd' and jns_trans='2' ORDER BY tgl_sts, no_sts)order by a.tgl_sts, a.no_sts
		";
		$query1 = $this->db->query($sql); 
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array( 
						'id' => $ii,        
                        'no_sts' => $resulte['no_sts'],
                        'tgl_sts' => $resulte['tgl_sts'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['keterangan'],    
                        'total' =>  number_format($resulte['total'],2,'.',','),
                        'jns_trans' => $resulte['jns_trans']
                        );
                        $ii++;
				}
		$result["rows"] = $row; 
        return $result;
        $query1->free_result();	
	}
	
	
	function load_dsts_lalu($lcskpd,$kriteria){
		$sql = "SELECT no_sts,kd_skpd,kd_rek5,rupiah,kd_rek_blud,kd_kegiatan
        from trdkasin_blud a where a.no_sts = '$kriteria'  AND a.kd_skpd = '$lcskpd' order by a.no_sts";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte) { 
            $result[] = array(
                        'id' => $ii,        
                        'no_sts' => $resulte['no_sts'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_kegiatan' => $resulte['kd_kegiatan'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
                        'rupiah' =>  number_format($resulte['rupiah'],2,'.',',')
						);
                        $ii++;
        }
       return $result;	
	}
	
	function update_sts_pendapatan_ag_tlalu($tabel,$nomor,$nohide,$tgl,$skpd,$ket,$jnsrek,$giat,$total,$lcnilaidet,$usernm,$last_update){
		$sql = "delete from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nohide'";
		$asg = $this->db->query($sql);
			 $sql = "insert into trhkasin_blud(no_sts,kd_skpd,tgl_sts,keterangan,total,
					jns_trans,username,tgl_update) 
					values('$nomor','$skpd','$tgl','$ket','$total','2','$usernm','$last_update')";
			$asg = $this->db->query($sql);
			if (!($asg)){
				$msg = '0';
				return $msg;
				exit();
			}
			if ($asg){
				$sql = "delete from trdkasin_blud where no_sts='$nohide' AND kd_skpd='$skpd' ";
				$asg = $this->db->query($sql);    
				if(!($asg)){
					$msg = '0';
					return $msg;
					exit();
				}else{
					$sql = "insert into trdkasin_blud(kd_skpd,no_sts,kd_rek5,rupiah,kd_kegiatan,kd_rek_blud) values $lcnilaidet";
					$asg = $this->db->query($sql); 
				}                
			}
		$msg = '2';
        return $msg;
		exit();
			
	}
	
	
	
	
	
	
	
	
	
}