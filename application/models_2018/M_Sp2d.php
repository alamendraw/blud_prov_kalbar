<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_sp2d extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->model('tukd_model');
    }

    function right($value, $count){
    return substr($value, ($count*-1));
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

	function load_spm($kd_skpd,$kriteria){
		$where="";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        $sql = "SELECT no_spm,tgl_spm,no_spp,tgl_spp,status_spp,kd_skpd,keterangan_spp,bulan,jns_spp,no_tagih,total,
				rekanan,pimpinan,kd_bank,no_rek,npwp,nama
				FROM trhsp2d_blud a LEFT JOIN ms_bank_blud b ON a.kd_bank=b.kode
				WHERE kd_skpd = '$kd_skpd' AND status_spp ='1'  AND status_spm !='1' $where order by no_spp,kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'no_spp'    => $resulte['no_spp'],
                        'no_spm'    => $resulte['no_spm'],
                        'tgl_spp'   => $resulte['tgl_spp'],
                        'tgl_spm'   => $resulte['tgl_spm'],
                        'kd_skpd'   => $resulte['kd_skpd'],
                        'jns_spp'   => $resulte['jns_spp'],
                        'keperluan' => $resulte['keterangan_spp'],
                        'bulan'     => $resulte['bulan'],
                        'total'		=> number_format($resulte['total'],2,'.',','),
                        'status'    =>$resulte['status_spp'],
                        'rekanan'   =>$resulte['rekanan'],
                        'pimpinan'  =>$resulte['pimpinan'],
                        'bank'  	=>$resulte['kd_bank'],
                        'nama_bank' =>$resulte['nama'],
                        'rekening'  =>$resulte['no_rek'],
                        'npwp'    	=>$resulte['npwp'],
                        'no_tagih'  =>$resulte['no_tagih'],
                        );
                        $ii++;
        }
        return $result;
    	$query1->free_result();    
	}
	
	function simpan_sp2d($no_sp2d,$tgl,$no_spm,$skpd,$usernm,$last_update,$kep){
			$sql = "UPDATE trhsp2d_blud SET no_sp2d='$no_sp2d',tgl_sp2d='$tgl',status_spm='1',status_sp2d='',keterangan_sp2d='$kep' WHERE kd_skpd='$skpd' and no_spm='$no_spm'";
            $asg = $this->db->query($sql);
                if ($asg){
					$msg = '2';
					return $msg;
                } else{
					$msg = '0';
					return $msg;
				}            
	}
	
	function update_sp2d($no_sp2d,$tgl,$no_spm,$skpd,$usernm,$last_update,$no_sp2d_hide,$no_spm_hide,$kep){
        $sql = "UPDATE trhsp2d_blud SET no_sp2d='',tgl_sp2d='',status_spm='' WHERE kd_skpd='$skpd' and no_sp2d='$no_sp2d_hide'";
        $asg = $this->db->query($sql);
				if ($asg){
					$sql = "UPDATE trhsp2d_blud SET no_sp2d='$no_sp2d',tgl_sp2d='$tgl',status_spm='1', status_sp2d='',keterangan_sp2d='$kep' WHERE kd_skpd='$skpd' and no_spm='$no_spm'";
					$asg = $this->db->query($sql);
							if ($asg){
								$msg = '2';
								return $msg;
							} else{
								$msg = '0';
								return $msg;
							} 
                } else{
					$msg = '0';
					return $msg;
				}              
	}
	
	function load_sp2d($kd_skpd,$kriteria){
		$where="AND no_sp2d !=''";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT no_kas,tgl_kas,no_sp2d,tgl_sp2d,no_spm,tgl_spm,no_spp,tgl_spp,status_sp2d,kd_skpd,keterangan_sp2d,bulan,jns_spp,no_tagih,total,
				rekanan,pimpinan,kd_bank,no_rek,npwp,nama
				FROM trhsp2d_blud a LEFT JOIN ms_bank_blud b ON a.kd_bank=b.kode
				WHERE kd_skpd = '$kd_skpd' $where order by no_spp,kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_kas'   => $resulte['no_kas'],
                        'tgl_kas'   => $resulte['tgl_kas'],
                        'no_sp2d'   => $resulte['no_sp2d'],
                        'no_spp'    => $resulte['no_spp'],
                        'no_spm'    => $resulte['no_spm'],
                        'tgl_sp2d'  => $resulte['tgl_sp2d'],
                        'tgl_spm'   => $resulte['tgl_spm'],
                        'tgl_spp'   => $resulte['tgl_spp'],
                        'kd_skpd'   => $resulte['kd_skpd'],
                        'jns_spp'   => $resulte['jns_spp'],
                        'keperluan' => $resulte['keterangan_sp2d'],
                        'bulan'     => $resulte['bulan'],
                        'total'		=> number_format($resulte['total'],2,'.',','),
                        'status'    =>$resulte['status_sp2d'],
                        'rekanan'   =>$resulte['rekanan'],
                        'pimpinan'  =>$resulte['pimpinan'],
                        'bank'  	=>$resulte['kd_bank'],
                        'nama_bank' =>$resulte['nama'],
                        'rekening'  =>$resulte['no_rek'],
                        'npwp'    	=>$resulte['npwp'],
                        'no_tagih'  =>$resulte['no_tagih'],
                        );
                        $ii++;
        }
           
        return $result;
    	$query1->free_result();    
	}
	
	
	function simpan_cair($nokas,$tglcair,$nosp2d,$nospm,$nospp,$jns,$skpd,$total,$ket){
		$usernm= $this->session->userdata('pcNama');
		$last_update= "";
		$nmskpd = "";
		$total = str_replace(",","",$total);
		
			$sql = "UPDATE trhsp2d_blud SET no_kas='$nokas', tgl_kas='$tglcair', status_sp2d='1' WHERE no_sp2d='$nosp2d' AND kd_skpd='$skpd' and no_spm='$nospm'";
            $asg = $this->db->query($sql);
			
		//Pengambilan Nomor Bukti Potongan bila tak ada potongan maka nomor Bukti tetap sama dengan nomor Kas	
		
		$sql7 = "SELECT COUNT(*) as jumlah FROM trspmpot_blud a
				INNER JOIN trhsp2d_blud b ON a.no_spm = b.no_spm
				WHERE b.no_sp2d = '$nosp2d'";
				
	$query7 = $this->db->query($sql7);
	foreach($query7->result_array() as $resulte7){
		$jumlah=$resulte7['jumlah'];
		if ($jumlah>0){
				$buktitrm = $nokas+1;
				$no_setor=$buktitrm+1;
				$buktistr=$no_setor+1;
				$sql9 = "SELECT a.*,b.jns_spp, c.kd_rek_blud FROM trspmpot_blud a
						INNER JOIN trhsp2d_blud b ON a.no_spm = b.no_spm
						LEFT JOIN trdspp_blud c on b.no_spp=c.no_spp 
						WHERE b.no_sp2d = '$nosp2d'";
				$query9 = $this->db->query($sql9);
				
					foreach($query9->result_array() as $resulte9){
							$kdrekening=$resulte9['kd_rek5'];
							$nmrekening=$resulte9['nm_rek5'];
							$nilai=$resulte9['nilai'];
							$jenis_spp=$resulte9['jns_spp'];
							$kd_trans=$resulte9['kd_trans'];
							$kd_rek_blud=$resulte9['kd_rek_blud'];
							$this->db->query("insert into trdtrmpot_blud(no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,kd_rek_blud) 
												  values('$buktitrm','$kdrekening','$nmrekening','$nilai','$skpd','$kd_trans','$kd_rek_blud')");
							$this->db->query("insert into trdstrpot_blud(no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,kd_rek_blud) 
												  values('$buktistr','$kdrekening','$nmrekening','$nilai','$skpd','$kd_trans','$kd_rek_blud')");
						}

				$sql8 = "SELECT SUM(a.nilai) as nilai_pot,b.npwp,b.jns_spp, '$nmskpd' nm_skpd, c.kd_kegiatan, '' nm_kegiatan,'' nmrekan,'' pimpinan,'' alamat 
							FROM trspmpot_blud a INNER JOIN trhsp2d_blud b ON a.no_spm = b.no_spm 
							inner join trdspp_blud c on b.no_spp = c.no_spp WHERE b.no_sp2d = '$nosp2d' 
							GROUP BY no_sp2d,b.npwp,b.jns_spp,c.kd_kegiatan";
				$query8 = $this->db->query($sql8); 
					foreach($query8->result_array() as $resulte8){
						
						$nilai=$resulte8['nilai_pot'];
						$npwp=$resulte8['npwp'];
						$jenis=$resulte8['jns_spp'];
						$nmskpd=$resulte8['nm_skpd'];
						$kd_kegiatan=$resulte8['kd_kegiatan'];
						$nm_kegiatan=$resulte8['nm_kegiatan'];
						$nmrekan=$resulte8['nmrekan'];
						$pimpinan=$resulte8['pimpinan'];
						$alamat=$resulte8['alamat'];
						$this->db->query("insert into trhtrmpot_blud(no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,nilai,npwp,jns_spp,no_sp2d,kd_kegiatan,nm_kegiatan,nmrekan,pimpinan,alamat,no_bukti_trans) 
											  values('$buktitrm','$tglcair','Terima pajak nomor SP2D $nosp2d','$usernm','$last_update','$skpd','$nmskpd','$nilai','$npwp','$jenis','$nosp2d','$kd_kegiatan','$nm_kegiatan','$nmrekan','$pimpinan','$alamat','$nokas')");
						$this->db->query("insert into trhstrpot_blud(no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,no_terima,nilai,npwp,jns_spp,no_sp2d,kd_kegiatan,nm_kegiatan,nmrekan,pimpinan,alamat,no_bukti_trans) 
											  values('$buktistr','$tglcair','Setor pajak nomor SP2D $nosp2d','$usernm','$last_update','$skpd','$nmskpd','$buktitrm','$nilai','$npwp','$jenis','$nosp2d','$kd_kegiatan','$nm_kegiatan','$nmrekan','$pimpinan','$alamat','$nokas')");
					}
					
					
				}else{
					
					
					$sql8 = "SELECT distinct jns_spp from trhsp2d_blud WHERE no_sp2d = '$nosp2d' and kd_skpd='$skpd'";
					$hasiln = $this->db->query($sql8);
					$trhn = $hasiln->row();
					$jenis  = $trhn->jns_spp; 
				}
			}
			
		$hasil7 = $this->db->query($sql7);
		$trhn7 = $hasil7->row();
		$jumlah  = $trhn7->jumlah;
		
		if ($jumlah>0){
			$no_sts = $nokas;
			$no_setor=$no_sts+1;
			$no_trans=$no_setor+1;
		}else{
			$no_setor=$nokas;
			$no_trans=$no_setor+1;
		}
		
		if (($jns=='4' || $jns == 5 || $jns == 6)){
		$sql2 = " insert into trhtransout_blud(no_kas,tgl_kas,no_bukti,tgl_bukti,no_sp2d,kd_skpd,nm_skpd,total,ket,jns_spp,username,tgl_update,pay,jenis)
                  values('$no_trans','$tglcair','$no_trans','$tglcair','$nosp2d','$skpd','$nmskpd',$total,'$ket','$jenis','$usernm','$last_update','BANK','1') ";
        $asg2 = $this->db->query($sql2);
        }
		
		$sql = " SELECT a.no_spp,a.kd_skpd,a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,a.nm_rek_blud,a.nilai,d.bulan,d.no_spm,d.no_sp2d
					FROM trdspp_blud a 
					LEFT JOIN trhsp2d_blud d ON a.no_spp=d.no_spp
					WHERE d.no_sp2d='$nosp2d'";
        $query1 = $this->db->query($sql);  
        $ii = 0;
        $jum=0;
        foreach($query1->result_array() as $resulte){

			$sp2d=$nosp2d;
            $jns=$jns;
			$skpd=$resulte['kd_skpd'];
			$giat=$resulte['kd_kegiatan'];
			$rek5=$resulte['kd_rek5'];
			$rekblud=$resulte['kd_rek_blud'];
			$nm_rekblud=$resulte['nm_rek_blud'];
			$nilai=$resulte['nilai'];

			//$nmskpd=$this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
			//$nmgiat=$this->tukd_model->get_nama($giat,'nm_kegiatan','trskpd','kd_kegiatan');
			//$nmrek5=$this->tukd_model->get_nama($rek5,'nm_rek5','ms_rek5','kd_rek5');
			$nmgiat = "";
			$nmrek5 = ""; 
			
			if(($jns == 4 || $jns == 5 || $jns == 6)){
            $this->db->query("insert trdtransout_blud(no_bukti,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,kd_rek_blud,nm_rek_blud,nilai,no_sp2d,kd_skpd) 
                              values('$no_trans','$giat','$nmgiat','$rek5','$nmrek5','$rekblud','$nm_rekblud',$nilai,'$sp2d','$skpd') ");
            
			$this->db->query("UPDATE trdtransout_blud SET nm_kegiatan=b.nm_kegiatan FROM trdtransout_blud a INNER JOIN trdrka_blud b 
					ON a.kd_skpd=b.kd_skpd AND a.kd_rek5=b.kd_rek5 AND a.kd_kegiatan=b.kd_kegiatan
					WHERE a.no_bukti='$no_trans' AND a.kd_skpd='$skpd'");
			}
			
			
		}
                
				
					$msg = '2';
					return $msg;
                      
	}

	function batal_cair($nokas,$tglcair,$nosp2d,$nospm,$nospp,$jns,$skpd){
			$sql = "UPDATE trhsp2d_blud SET no_kas='', tgl_kas='', status_sp2d='' WHERE no_sp2d='$nosp2d' AND kd_skpd='$skpd' and no_spm='$nospm'";
			$asg = $this->db->query($sql);
			
			$sql7 = "SELECT COUNT(*) as jumlah FROM trspmpot_blud a
				INNER JOIN trhsp2d_blud b ON a.no_spm = b.no_spm
				WHERE b.no_sp2d = '$nosp2d'";
			$hasiln = $this->db->query($sql7);
			$trhn = $hasiln->row();
			$jumlah  = $trhn->jumlah; 
			
			if ($jumlah>0){
				$no_trm=$nokas+1;
				$no_kas=$no_trm+1;
				$no_str=$no_kas+1;
				
					$this->db->query("delete from trdtrmpot_blud where no_bukti='$no_trm' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trhtrmpot_blud where no_bukti='$no_trm' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trhtransout_blud where no_bukti='$no_kas' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trdtransout_blud where no_bukti='$no_kas' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trdstrpot_blud where no_bukti='$no_str' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trhstrpot_blud where no_bukti='$no_str' and kd_skpd = '$skpd'");
			
				
				if (($jns=='4' || $jns == '5' || $jns == '6')){
					$no_setor=$nokas;
					$no_kas=$no_setor+1;
					$this->db->query("delete from trhtransout_blud where no_bukti='$no_kas' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trdtransout_blud where no_bukti='$no_kas' and kd_skpd = '$skpd'");
				}
			}else{
					if (($jns=='4' || $jns == '5' || $jns == '6')){
					$no_setor=$nokas;
					$no_kas=$no_setor+1;
					$this->db->query("delete from trhtransout_blud where no_bukti='$no_kas' and kd_skpd = '$skpd'");
					
					$this->db->query("delete from trdtransout_blud where no_bukti='$no_kas' and kd_skpd = '$skpd'");
				}
				}
			
			
			$msg = '2';
			return $msg;
	}

	
	function cetak_sp2d($lntahunang,$lcnosp2d,$lcttd,$lckdskpd,$cetak,$banyak,$jns_cetak){
			$a ='*'.$lcnosp2d.'*';
        $csql = "SELECT no_spp,rekanan,npwp,tgl_spp,no_spm, tgl_spm,tgl_sp2d,jns_spp,
				(CASE WHEN a.jns_spp='6' THEN (SELECT kontrak FROM trhtagih_blud  WHERE no_bukti=a.no_tagih) ELSE '' END) as kontrak,
				alamat,pimpinan,kd_bank,b.nama as nm_bank,no_rek,keterangan_sp2d  FROM trhsp2d_blud a 
				LEFT JOIN ms_bank_blud b ON a.kd_bank = b.kode  
				WHERE a.no_sp2d = '$lcnosp2d'";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        $lcnospm    = $trh->no_spm;
        $ldtglspm   = $trh->tgl_spm;
        $alamat     = $trh->alamat;
        $lcnpwp     = $trh->npwp;
        $rekbank    = $trh->no_rek;
        $lcperlu    = $trh->keterangan_sp2d;
        $lcnospp    = $trh->no_spp;
        $tgl        = $trh->tgl_sp2d;
		$pimpinan	= $trh->pimpinan;
        $nmrekan	= $trh->rekanan;
		$jns		= $trh->jns_spp;
        $nama_bank	= $trh->nm_bank;
		$banyak_kar = strlen($lcperlu);
        $tanggal    = $this->M_Sp2d->tanggal_format_indonesia($tgl);
		$sqlskpd="SELECT a.nm_skpd,a.bank, a.rekening, a.kd_urusan,a.alamat,a.kop,a.daerah
				FROM ms_skpd_blud a WHERE kd_skpd = '$lckdskpd'";
		$sqlskpd=$this->db->query($sqlskpd);
		foreach ($sqlskpd->result() as $rowskpd){
			$kop		= $rowskpd->kop;
			$daerah		= $rowskpd->daerah;
			$lcnmskpd   = $rowskpd->nm_skpd;

		}
        $csqlnilai = "SELECT sum(nilai) [nilai] from  trdspp_blud WHERE no_spp = '$lcnospp'";
        $hasiln = $this->db->query($csqlnilai);
		$trhn = $hasiln->row();
		$n  = $trhn->nilai;
        
	
				$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kode='BUD' and nip='$lcttd'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
					$pangkat=$rowttd->pangkat;
                }
		
		if($jns_cetak=='2'){
			$tinggi='150px';
			//$banyak=9;
			$banyak=10;
		} else 
		if($jns_cetak=='1'){
			$tinggi='80px';
			//$banyak=15;
			$banyak=16;
		}else{
			$tinggi='10px';
			$banyak=$banyak;
		}		
		
		$cRet = '';
                 $cRet .="<!--<table style=\"font-family: Tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"4\" align=\"right\">
                        <img src=\"".base_url()."/image/logo.bmp\"  width=\"75\" height=\"100\" />
                        </td>
					<td align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>
                    <tr><td align=\"center\" style=\"font-size:15px\"><strong>BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH</strong></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">Jalan Ahmad Yani Telepon (0561) 736541 Fax. (0561) 738428</tr>
                    <tr><td align=\"center\">P O N T I A N A K</td></tr>
					<tr><td colspan=\"2\" style=\"border-bottom: hidden;\" align=\"right\" >Kode Pos: 78124 &nbsp; &nbsp;</td></tr>
                    <tr></td><td colspan=\"2\" style=\"border-top: 2px solid black;border-bottom: 1px solid black;font-size:1px;\"  align=\"right\" >&nbsp;</td></tr>
                    </table>
                    &nbsp;<br><br>-->
					";
        $cRet .= "<br><br><br><br><br><br><br>
		<table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px;\"  width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
        $cRet .="
		<tr>
            <td align=\"center\" width=\"50%\" style=\"border-collapse:collapse;font-weight:bold; font-size:12px\"> ".strtoupper($kop)." </td>
            <td align=\"center\" width=\"50%\">
                <table style=\"border-collapse:collapse;font-size:12px; font-weight: bold;\" width=\"100%\" align=\"center\" cellspacing=\"4\" cellpadding=\"0\">
                    <tr>
                        <td align=\"right\">
                            <b>Nomor : $lcnosp2d</b>
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\">
                            SURAT PERINTAH PENCAIRAN DANA<br>(SP2D) 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>   
        <tr>
            <td style=\"border-left:solid 1px black;\" >
                <table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px\" width=\"100%\" align=\"center\" valign=\"top\" border=\"1\" cellspacing=\"4\" cellpadding=\"0\">
      					<tr>
                        <td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" width=\"30%\" align=\"left\" valign=\"top\">&nbsp;Nomor SPM</td>
                        <td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" width=\"2%\" valign=\"top\">:</td>
						<td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" width=\"69%\" valign=\"top\">$lcnospm</td>
                    </tr>
                    <tr>
                        <td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" valign=\"top\">&nbsp;Tanggal</td>
                        <td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" valign=\"top\" >:</td>
						<td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" valign=\"top\">".$this->M_Sp2d->tanggal_format_indonesia($ldtglspm)."</td>
                    </tr>
                    <tr>
                        <td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" valign=\"top\">&nbsp;SKPD</td>
                        <td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" valign=\"top\">:</td>
						<td style=\"border-left:hidden;border-top: hidden;border-bottom: hidden; border-right: hidden;\" valign=\"top\" height=\"60px\">$lckdskpd $lcnmskpd</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px\" width=\"100%\"  valign=\"top\" border=\"0\" cellspacing=\"4\" cellpadding=\"0\">
                    <tr><td valign=\"top\">&nbsp;Dari &nbsp; : Kuasa Bendahara Umum Daerah (Kuasa BUD)</td></tr>
					<tr><td valign=\"top\" >&nbsp;Tahun Anggaran : &nbsp;$lntahunang</td></tr>
					<tr><td valign=\"top\" >&nbsp;</td></tr>
					<tr><td valign=\"top\" >&nbsp;</td></tr>
					<tr><td valign=\"top\" >&nbsp;</td></tr>
					<tr><td valign=\"top\" >&nbsp;</td></tr>
                </table>
            </td>
        </tr>
			<tr>
		<td colspan=\"2\">
			<table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"4\" cellpadding=\"0\">
			<tr>
				<td style=\"border-bottom: hidden; border-right: hidden;\" width=\"120px\">&nbsp;Bank/Pos</td>
				<td style=\"border-bottom: hidden;\" >:&nbsp;</td>
			</tr>
			<tr>
				<td style=\"border-bottom: hidden;\" colspan=\"2\" >&nbsp;Hendaklah mencairkan / memindahbukukan dari baki Rekening </td>
			</tr>
			<tr>
				<td style=\"border-bottom: hidden; border-right: hidden;\" >&nbsp;Uang sebesar Rp</td>
				<td style=\"border-bottom: hidden;\" >:&nbsp;".number_format($n,'2',',','.')."  (".$this->tukd_model->terbilang($n).") </td>
			</tr>
			</table>
        </td>
		</tr>	
        <tr>
            <td colspan=\"2\">";

             $cRet .="<table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"-1\" cellpadding=\"-1\">
			   <tr>
                    <td valign=\"top\" width=\"120px\">&nbsp;Kepada</td>
					<td valign=\"top\" width=\"10px\" >:</td>
                    <td valign=\"top\" >$pimpinan, $nmrekan, $alamat</td>
                </tr>
                <tr>
                    <td valign=\"top\" >&nbsp;NPWP</td>
					<td valign=\"top\" >:</td>
                    <td valign=\"top\" >$lcnpwp</td>
                </tr>
                <tr>
                    <td valign=\"top\" >&nbsp;No.Rekening Bank</td>
					<td valign=\"top\" >:</td>
                    <td valign=\"top\" >$rekbank</td>
                </tr>
                <tr>
                    <td valign=\"top\">&nbsp;Bank/Pos</td>
					<td valign=\"top\">:</td>
                    <td valign=\"top\">$nama_bank</td>
                </tr>
                <tr>
                    <td valign=\"top\" >&nbsp;Untuk Keperluan</td>
					<td valign=\"top\" >:</td>
                    <td height=\"$tinggi\" valign=\"top\" style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px\" >$lcperlu
					</td>
				</tr>
                </table> ";
		
		
         $cRet	.="  </td>
        </tr>
        <tr>
            <td colspan=\"2\">
                <table style=\"border-collapse:collapse;font-family: Tahoma;font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr >
                        <td width=\"5%\" align=\"center\"><b>NO</b></td>
                        <td width=\"28%\" align=\"center\"><b>KODE REKENING</b></td>
                        <td align=\"center\"><b>URAIAN</b></td>
                        <td width=\"15%\" align=\"center\"><b>JUMLAH (Rp)</b></td>
                    </tr>
					<tr>
                        <td align=\"center\">1</td>
                        <td align=\"center\">2</td>
                        <td align=\"center\">3</td>
                        <td align=\"center\">4</td>
                    </tr>";
			$sql_total="SELECT sum(nilai)total FROM trdspp_blud where no_spp='$lcnospp' AND kd_skpd='$lckdskpd'";
                 $sql_x=$this->db->query($sql_total);
                 foreach ($sql_x->result() as $row_x)
                {
                    $lntotal=$row_x->total;                    
                }
				if(($jns==1) || ($jns==2)){
                                        $sql = "select SUM(nilai) nilai from trdspp_blud where no_spp='$lcnospp' AND kd_skpd='$lckdskpd'";
                                        $hasil = $this->db->query($sql);
                                        $lcno = 0;
                                        $lntotal = 0;
                                        foreach ($hasil->result() as $row)
                                        {
                                           $lcno = $lcno + 1;
                                           $lntotal = $lntotal + $row->nilai;
										    $cRet .="<tr>
                                                        <td style=\"border-bottom: hidden;\" align=\"center\">&nbsp;1</td>
                                                        <td style=\"border-bottom: hidden;\">&nbsp; $lckdskpd  </td>
                                                        <td style=\"border-bottom: hidden;\">&nbsp; $lcnmskpd</td>
                                                        <td style=\"border-bottom: hidden;\" align=\"right\">".number_format($row->nilai,"2",",",".")."&nbsp;</td>
                                                    </tr>"; 
                                          
										}  
											if($lcno<=$banyak)
											   {
												 for ($i = $lcno; $i <= $banyak; $i++) 
												  {
													 $cRet .="<tr>
                                                        <td style=\"border-top: hidden;\" align=\"center\">&nbsp;</td>
                                                        <td style=\"border-top: hidden;\" ></td>
                                                        <td style=\"border-top: hidden;\"></td>
                                                        <td style=\"border-top: hidden;\" align=\"right\"></td>
                                                    </tr>";    
												  }                                                   
											   } 
										   }
				else{
				$sql1 = "SELECT COUNT(*) as jumlah FROM(
						SELECT ' ' as urut, kd_kegiatan+'.'+kd_rek_blud as kode, '' as nm_rek, nilai from trdspp_blud where no_spp = '$lcnospp' and kd_skpd = '$lckdskpd')z";
						$hasil1 = $this->db->query($sql1);
						$row1 = $hasil1->row();
						$jumlahbaris = $row1->jumlah;  
						if($jumlahbaris<=$banyak){
							$sql = "SELECT ' ' as urut, kd_kegiatan, kd_rek_blud as kd_rek, b.nm_rek5 as nm_rek, nilai 
									FROM trdspp_blud a LEFT JOIN ms_rek5_blud b ON a.kd_rek_blud=b.kd_rek5 
									WHERE no_spp = '$lcnospp' and kd_skpd = '$lckdskpd'
									ORDER BY kd_kegiatan,kd_rek";
							} else{
							$sql = "SELECT '1' as urut, kd_kegiatan, kd_rek_blud as kd_rek, b.nm_rek3 as nm_rek, SUM(a.nilai) as nilai
									FROM trdspp_blud a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek5,3)=b.kd_rek3
									where no_spp = '$lcnospp' and kd_skpd = '$lckdskpd'
									GROUP BY kd_kegiatan,  LEFT(a.kd_rek5,3), b.nm_rek3 
									UNION ALL
									SELECT '2' as urut, '' kd_kegiatan,'' as kd_rek, '- Rincian Terlampir ' as nm_rek, 0 as nilai
									ORDER BY urut, kd_kegiatan,kd_rek";	
							}	
                                        $hasil = $this->db->query($sql);
                                        $lcno = 0;
										$lcno_baris = 0;
                                       // $lntotal = 0;
                                        foreach ($hasil->result() as $row)
                                        {	
											$lcno_baris = $lcno_baris + 1;										
											if (strlen($row->kd_rek)>=7){
											$lcno = $lcno + 1;
											$lcno_x = $lcno;
											}
											else {
												$lcno_x ='';
											}
                                           $cRet .="<tr>
                                                        <td style=\"border-bottom: hidden;\" align=\"center\">&nbsp;$lcno_x</td>
                                                        <td style=\"border-bottom: hidden;\">33&nbsp; $row->kd_kegiatan.$row->kd_rek </td>
                                                        <td style=\"border-bottom: hidden;\">&nbsp; $row->nm_rek</td>
                                                        <td style=\"border-bottom: hidden;\" align=\"right\">".number_format($row->nilai,"2",",",".")."&nbsp;</td>
                                                    </tr>";    
                                        }
                                        if($lcno_baris<=$banyak){
                                         for ($i = $lcno_baris; $i <= $banyak; $i++) 
                                          {
                                            $cRet .="<tr>
                                                        <td style=\"border-top: hidden;\" align=\"center\">&nbsp;</td>
                                                        <td style=\"border-top: hidden;\" ></td>
                                                        <td style=\"border-top: hidden;\"></td>
                                                        <td style=\"border-top: hidden;\" align=\"right\"></td>
                                                    </tr>";    
                                          }                                                   
                                       }
                                       
				}     
             $cRet .="<tr>
                        <td align=\"right\" colspan=\"3\">&nbsp;<b>JUMLAH&nbsp;</b></td>
                        <td align=\"right\"><b>".number_format($lntotal,"2",",",".")."</b>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=\"4\">&nbsp;Potongan-potongan</td>
                    </tr>
                    <tr>
                        <td  align=\"center\"><b>NO</b></td>
                        <td  align=\"center\"><b>Uraian (No.Rekening)</b></td>
                        <td  align=\"center\"><b>Jumlah(Rp)</b></td>
                        <td  align=\"center\"><b>Keterangan</b></td>
                    </tr>";
                    
                    $sql = "select * from trspmpot_blud where no_spm='$lcnospm' AND kd_skpd='$lckdskpd' AND jns_pot='1'";
                                        $hasil = $this->db->query($sql);
                                        $lcno = 0;
                                        $lntotalpot = 0;
                                        foreach ($hasil->result() as $row)
                                        {
                                           $lcno = $lcno + 1;
										   $kode_rek=$row->kd_rek5;
                                           $lntotalpot = $lntotalpot + $row->nilai;
										   if($kode_rek=='2130101'){
											   $nama_rek='PPh 21';
										   } else if ($kode_rek=='2130201'){
											   $nama_rek='PPh 22';
										   } else if($kode_rek=='2130301'){
											   $nama_rek='PPN';
										   } else if($kode_rek=='2130401'){
											   $nama_rek='PPh 23';
										   } else if($kode_rek=='2130501'){
											   $nama_rek='PPh Pasal 4';
										   } else{
												$nama_rek=$row->nm_rek5;
										   }
                              
                                $cRet .="<tr>
                                            <td align=\"center\">&nbsp;$lcno</td>
                                            <td>&nbsp; $nama_rek</td>
                                            <td align=\"right\">".number_format($row->nilai,"2",",",".")."&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>";    
                            }
							if($lcno<=4)
                                       {
                                         for ($i = $lcno; $i < 4; $i++) 
                                          {
                                            $cRet .= "<tr>
                                                        <td>&nbsp;</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                     </tr>";    
                                          }                                                   
                                       }
                                        
                    $cRet .="
                    <tr>
                        <td>&nbsp;</td>
                        <td align=\"right\"><b>Jumlah</b>&nbsp;</td>
                        <td align=\"right\"><b>".number_format($lntotalpot,"2",",",".")."</b>&nbsp;</td>
                        <td></td>
                    </tr>
                     <tr>
                        <td colspan=\"4\">&nbsp;Informasi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>(tidak mengurangi jumlah pembayaran SP2D)</i></td>
                    </tr>
            
                    <tr>
                        <td align=\"center\"><b>NO</b></td>
                        <td align=\"center\"><b>Uraian (No.Rekening)</b></td>
                        <td align=\"center\"><b>Jumlah(Rp)</b></td>
                        <td align=\"center\"><b>Keterangan</b></td>
                    </tr>";
                    $sql = "select * from trspmpot_blud where no_spm='$lcnospm' AND kd_skpd='$lckdskpd' AND jns_pot ='0'";
                                        $hasil = $this->db->query($sql);
                                        $lcno = 0;
                                       $lntotalpot_not = 0;
                                        foreach ($hasil->result() as $row)
                                        {
                                           $lntotalpot_not = $lntotalpot_not + $row->nilai; 
											$kode_rek=$row->kd_rek5;
                                           $lcno = $lcno + 1;
										   if($kode_rek=='2130101'){
											   $nama_rek='PPh 21';
										   } else if ($kode_rek=='2130201'){
											   $nama_rek='PPh 22';
										   } else if($kode_rek=='2130301'){
											   $nama_rek='PPN';
										   } else if($kode_rek=='2130401'){
											   $nama_rek='PPh 23';
										   } else if($kode_rek=='2130501'){
											   $nama_rek='PPh Pasal 4';
										   } else{
												$nama_rek=$row->nm_rek5;
										   }
							   $cRet .="<tr>
                                            <td align=\"center\">&nbsp;$lcno</td>
                                            <td> &nbsp; $nama_rek</td>
                                            <td align=\"right\">".number_format($row->nilai,"2",",",".")."&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>";    
                            }
							if($lcno<=4)
                                       {
                                         for ($i = $lcno; $i < 4; $i++) 
                                          {
                                            $cRet .= "<tr>
                                                        <td>&nbsp;</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                     </tr>";    
                                          }                                                   
                                       }
							
							
							
							$jum_bayar=strval($lntotal-$lntotalpot);
							$bil_bayar = strval($lntotal-($lntotalpot));
                    $cRet .="
                    <tr>
                        <td>&nbsp;</td>
                        <td align=\"right\"><b>Jumlah</b>&nbsp;</td>
                        <td align=\"right\"><b>".number_format($lntotalpot_not,"2",",",".")."</b>&nbsp;</td>
                        <td></td>
                    </tr>
                     
                </table>  
            </td>
        </tr>
        <tr>
            <td colspan=\"2\">
                <table style=\"border-collapse:collapse;font-family: Tahoma;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"-1\" cellpadding=\"-1\">
                   <tr>
                        <td colspan=\"4\" valign=\"bottom\" style=\"font-weight: bold;\">&nbsp;SP2D yang Dibayarkan</td>
                    </tr>
				   <tr>
				   
                        <td width=\"28%\" align=\"left\">&nbsp;Jumlah yang Diterima</td>
                        <td style=\"border-left: hidden;\" width=\"4%\" align=\"left\">&nbsp;RP</td>
                        <td style=\"border-left: hidden;\" width=\"50%\" align=\"right\">&nbsp;".number_format($lntotal,"2",",",".")."</td>
						<td style=\"border-left: hidden;\" width=\"20%\" align=\"center\">&nbsp;</td>
						</tr>
                    <tr > 
                        <td align=\"left\">&nbsp;Jumlah Potongan</td>
                        <td style=\"border-left: hidden;\" align=\"left\">&nbsp;RP</td>
                        <td style=\"border-left: hidden;\" align=\"right\" >&nbsp; ".number_format($lntotalpot,"2",",",".")."</td>
						<td style=\"border-left: hidden;\" >&nbsp;</td>
                    </tr>
                    <tr style=\"font-weight: bold;\">
                        <td align=\"left\">&nbsp;<b>Jumlah yang Dibayarkan</b></td>
                        <td style=\"border-left: hidden;\" align=\"left\"><b>&nbsp;RP</b></td>
                        <td style=\"border-left: hidden;font-size:11px;\" align=\"right\"><b>&nbsp; ".number_format($lntotal-($lntotalpot),"2",",",".")."</b></td>
						<td style=\"border-left: hidden;\" >&nbsp;</td>
                    </tr>                    
                </table>  
            </td>
        </tr>
        
        <tr>
            <td colspan=\"2\">
                <table style=\"border-collapse:collapse;font-weight: bold;font-family: Tahoma;font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"-1\" cellpadding=\"-1\">
			<tr>
                        <td colspan=\"2\" align=\"left\" >&nbsp;Uang Sejumlah :
                        (&nbsp;".ucwords($this->tukd_model->terbilang($bil_bayar))."&nbsp;)</td>
						
	
                    </tr>
				<tr>
                        <td width=\"70%\" align=\"left\" style=\"font-size:10px\" valign=\"top\">
                        <br>&nbsp;Lembar 1 : Bank Yang Ditunjukan<br>
                        &nbsp;Lembar 2 : Pengguna Anggaran/Kuasa Pengguna Anggaran<br>
                        &nbsp;Lembar 3 : Arsip Kuasa BUD<br>
                        &nbsp;Lembar 4 : Pihak Ketiga<br>
                               
                        </td>
                        <td width=\"30%\" align=\"center\">
                        <br>
                        $daerah, $tanggal<br>
                        <br>Kuasa Bendahara Umum Daerah
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u><br>
                        <br>
                        NIP.                 
                        </td>
                   </tr>
                </table>  
            </td>
        </tr>
        
        
        </table>";
        $data = $this->_mpdf_sp2d('',$cRet,10,5,5,'0'); 
		return $data;		
	}
	
	
	function _mpdf_sp2d($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {
        ini_set("memory_limit","-1");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */
        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        $jam = date("H:i:s");
		$this->mpdf = new mPDF('utf-8', array(215.9,330.2),$size); //folio
        $this->mpdf->AddPage($orientasi,'','',1,1,$lMargin,$rMargin,15,5);
		//$this->mpdf->SetFooter("Printed on Simakda || Halaman {PAGENO} ");
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);      
        $this->mpdf->Output();
    }
	
	
	
}