<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_spm extends CI_Model {

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

	function load_spp($kd_skpd,$kriteria){
		$where="";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        $sql = "SELECT no_spp,tgl_spp,status_spp,kd_skpd,keterangan_spp,bulan,jns_spp,no_tagih,total,
				rekanan,pimpinan,kd_bank,no_rek,npwp,nama
				FROM trhsp2d_blud a LEFT JOIN ms_bank_blud b ON a.kd_bank=b.kode
				WHERE kd_skpd = '$kd_skpd' AND status_spp !='1' $where order by no_spp,kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_spp'    => $resulte['no_spp'],
                        'tgl_spp'   => $resulte['tgl_spp'],
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
	
	function simpan_spm($no_spm,$tgl,$no_spp,$skpd,$usernm,$last_update,$lcnilaidet){
        $sql = "UPDATE trhsp2d_blud SET no_spm='$no_spm',tgl_spm='$tgl',status_spm='' WHERE kd_skpd='$skpd' and no_spp='$no_spp'";
            $asg = $this->db->query($sql);
                if ($asg){
                    $sql = "delete from trspmpot_blud where no_spm='$no_spm' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
						$sql = "UPDATE trhsp2d_blud SET status_spp='1' WHERE no_spp='$no_spp' AND kd_skpd='$skpd'";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '2';
							return $msg;
						}else{
							$sql = "insert into trspmpot_blud(no_spm,kd_trans,kd_trans_blud,kd_rek5,nm_rek5,jns_pot,nilai,kd_skpd) values $lcnilaidet";
							$asg = $this->db->query($sql); 
							if(!($asg)){
								$msg = '1';
								return $msg;
							}else{
								$msg = '3';
								return $msg;
							}
						}
                    }                
                }            
	}
	
	function update_spm($no_spm,$tgl,$no_spp,$skpd,$usernm,$last_update,$lcnilaidet,$no_spp_hide,$no_spm_hide){
        $sql = "UPDATE trhsp2d_blud SET no_spm='',tgl_spm='',status_spm='' WHERE kd_skpd='$skpd' and no_spm='$no_spm_hide'";
        $asg = $this->db->query($sql);
		$sql = "UPDATE trhsp2d_blud SET no_spm='$no_spm',tgl_spm='$tgl',status_spm='' WHERE kd_skpd='$skpd' and no_spp='$no_spp'";
        $asg = $this->db->query($sql);
                if ($asg){
                    $sql = "delete from trspmpot_blud where no_spm='$no_spm_hide' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
					$sql = "UPDATE trhsp2d_blud SET status_spp='0' WHERE no_spp='$no_spp_hide' AND kd_skpd='$skpd'";
					$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							$sql = "UPDATE trhsp2d_blud SET status_spp='1' WHERE no_spp='$no_spp' AND kd_skpd='$skpd'";
							$asg = $this->db->query($sql); 
							if(!($asg)){
								$msg = '1';
								return $msg;
							}else{
								$sql = "insert into trspmpot_blud(no_spm,kd_trans,kd_trans_blud,kd_rek5,nm_rek5,jns_pot,nilai,kd_skpd) values $lcnilaidet";
								$asg = $this->db->query($sql); 
								$msg = '2';
								return $msg;
							}
						}
                    }                
                }            
	}
	
	function load_spm($kd_skpd,$kriteria){
		$where="AND no_spm !=''";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT no_spm,tgl_spm,no_spp,tgl_spp,status_spm,kd_skpd,keterangan_spp,bulan,jns_spp,no_tagih,total,
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
                        'no_spp'    => $resulte['no_spp'],
                        'no_spm'    => $resulte['no_spm'],
                        'tgl_spm'   => $resulte['tgl_spm'],
                        'tgl_spp'   => $resulte['tgl_spp'],
                        'kd_skpd'   => $resulte['kd_skpd'],
                        'jns_spp'   => $resulte['jns_spp'],
                        'keperluan' => $resulte['keterangan_spp'],
                        'bulan'     => $resulte['bulan'],
                        'total'		=> number_format($resulte['total'],2,'.',','),
                        'status'    =>$resulte['status_spm'],
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
	
	function load_detail_potongan($kd_skpd,$spm){
		 $sql = "SELECT kd_trans,kd_trans_blud,kd_rek5,nm_rek5,nilai,jns_pot 
				FROM trspmpot_blud WHERE no_spm='$spm' AND kd_skpd='$kd_skpd' ORDER BY kd_trans,kd_rek5";                   
       
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'idx'        	=> $ii,
                        'kd_trans' 		=> $resulte['kd_trans'],
                        'kd_trans_blud' => $resulte['kd_trans_blud'],  
                        'kd_rek5'  		=> $resulte['kd_rek5'],  
                        'nm_rek5'  		=> $resulte['nm_rek5'],  
                        'jns_pot'  		=> $resulte['jns_pot'],  
                        'nilai'    		=> number_format($resulte['nilai'],"2",".",",")
                        );
                        $ii++;
        }
           
     return $result;
     $query1->free_result();  
	}
	
	function hapus_spm($spm,$skpd,$spp){
		$query = $this->db->query("delete from trspmpot_blud where kd_skpd = '$skpd' AND no_spm='$spm'");
        $query = $this->db->query("UPDATE trhsp2d_blud SET no_spm='',status_spp='',tgl_spm='' WHERE no_spm='$spm' AND kd_skpd='$skpd'");
		if($query){
			$msg ='1';
			return $msg;
		}else{
			$msg ='0';
			return $msg;
		}
	}
	
	
	function rek_pot_trans($spp,$skpd,$lccr){
		$sql    = " SELECT a.kd_rek5,b.nm_rek5,kd_rek_blud,nm_rek_blud FROM trdspp_blud a
					LEFT JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5
					where no_spp = '$spp' AND kd_skpd ='$skpd' and ( upper(kd_rek_blud) like upper('%$lccr%')
                    OR upper(nm_rek_blud) like upper('%$lccr%') )  ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        'kd_rek_blud' => $resulte['kd_rek_blud'],  
                        'nm_rek_blud' => $resulte['nm_rek_blud'],  
                        );
                        $ii++;
        }
           
        return $result;
		$query1->free_result();	
	}
	
	function rek_pot($lccr){
		$sql    = " SELECT kd_rek5,nm_rek5 FROM ms_pot_blud where ( upper(kd_rek5) like upper('%$lccr%')
                    OR upper(nm_rek5) like upper('%$lccr%') )  ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        );
                        $ii++;
        }
           
        return $result;
		$query1->free_result();
	}
	
	function cetak_spm($cetak,$lcnospm,$kd,$jns,$tanpa,$baris,$BK,$PA,$PPK){
		$nmskpd		= $this->rka_model->get_nama($kd,'nm_skpd','ms_skpd_blud','kd_skpd');		
        $sqlttd1="SELECT * FROM ms_ttd_blud WHERE kd_skpd = '$kd' AND nip = '$PA' AND kode='PA' ";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd){
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nama;
                    $jabatan  = $rowttd->jabatan;
                    $pangkat  = $rowttd->pangkat;
                }
		$sqlttd2="SELECT * FROM ms_ttd_blud WHERE kd_skpd = '$kd' AND nip = '$BK' AND kode='BK' ";
                 $sqlttd2=$this->db->query($sqlttd2);
                 foreach ($sqlttd2->result() as $rowttd2){
                    $nip2=$rowttd2->nip;                    
                    $nama2= $rowttd2->nama;
                    $jabatan2  = $rowttd2->jabatan;
                    $pangkat2  = $rowttd2->pangkat;
                }
		$sqlttd3="SELECT * FROM ms_ttd_blud WHERE kd_skpd = '$kd' AND nip = '$PPK'  ";
                 $sqlttd3=$this->db->query($sqlttd3);
                 foreach ($sqlttd3->result() as $rowttd3){
                    $nip3=$rowttd3->nip;                    
                    $nama3= $rowttd3->nama;
                    $jabatan3  = $rowttd3->jabatan;
                    $pangkat3  = $rowttd3->pangkat;
                }
        		
        
        
		$sqlskpd="SELECT a.bank, a.rekening, a.kd_urusan,a.alamat,a.kop,a.daerah
				FROM ms_skpd_blud a WHERE kd_skpd = '$kd'";
		$sqlskpd=$this->db->query($sqlskpd);
		foreach ($sqlskpd->result() as $rowskpd){
			$kop		= $rowskpd->kop;
			$daerah		= $rowskpd->daerah;
		}
		$sqlskpd->free_result();
		
        $csql = "SELECT no_spp,rekanan,npwp,tgl_spp,tgl_spm,
				(CASE WHEN a.jns_spp='6' THEN (SELECT kontrak FROM trhtagih_blud  WHERE no_bukti=a.no_tagih) ELSE '' END) as kontrak,
				alamat,pimpinan,kd_bank,b.nama as nm_bank,no_rek,keterangan_spp  FROM trhsp2d_blud a 
				LEFT JOIN ms_bank_blud b ON a.kd_bank = b.kode 
				WHERE a.no_spm = '$lcnospm'  AND a.kd_skpd='$kd'";
        $hasil = $this->db->query($csql);
        $trh = $hasil->row();
        
        switch ($jns) 
        {
            case '1': //UP
                $lcbeban = "UP/<strike>GU/TU/LS</strike>";
                break;
            case '2': //GU
                $lcbeban = "<strike>UP</strike>/GU/<strike>TU/LS</strike>";
                break;
            case '3': //TU
                $lcbeban = "<strike>UP/GU</strike>/TU/<strike>LS</strike>";
                break;
            default:
                $lcbeban = "<strike>UP/GU/TU</strike>/LS";
                
        }
        
        $lcskpd = $nmskpd;
        $lcrekbank = $trh->no_rek;
        $lctahun = $this->session->userdata('pcThang');
        $lcnpwp = $trh->npwp;
        $lckeperluan = ltrim($trh->keterangan_spp);
        $lcnospp = $trh->no_spp;
		$thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$ldtglspp ="_______________________$thn_ang";
		}else{
        $ldtglspp =$this->tukd_model->tanggal_format_indonesia($trh->tgl_spp);
		}
        $tglspm =$this->tukd_model->tanggal_format_indonesia($trh->tgl_spm);
        $pimpinan=$trh->pimpinan;
        $nmrekan=$trh->rekanan;
        $nama_bank=$trh->nm_bank;
		
		
		
		$thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$tglspm ="_______________________$thn_ang";
			}
		
        $cRet = "";
        $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"-1\" cellpadding=\"-1\">
                     <tr>
                         <td colspan=\"2\" align=\"center\" style=\"font-size:14px;border: solid 1px white;\">
                            <b>$kop</b>
                         </td>
                     </tr>
                     <tr>
                         <td colspan=\"2\" align=\"center\" style=\"font-size:15px;border: solid 1px white;\">
                            <b>SURAT PERINTAH MEMBAYAR (SPM)</b>
                         </td>
                     </tr>
                     <tr>
                         <td colspan=\"2\" align=\"center\" style=\"font-size:14px;border: solid 1px white;\">
                            <b>TAHUN ANGGARAN $lctahun</b>
                         </td>
                     </tr>
                     <tr>
                         <td colspan=\"2\" align=\"right\" style=\"font-size:12px;border-right: none;border-top: none;border-left: none;\">
                            Nomor SPM : $lcnospm
                         </td>
                     </tr>
                     <tr>
                         <td colspan=\"2\" align=\"center\" style=\"font-size:14px\">&nbsp;</td>
                     </tr>
                     <tr>
                         <td width=\"50%\" style=\"font-size:14px\">
                            <table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"600\" align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td width=\"100%\" style=\"font-size:14px; border-bottom:hidden \">
                                        <b>PEJABAT KEUANGAN<br>$nmskpd</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=\"100%\" style=\"font-size:14px; border-top:hidden\">
                                        Supaya menerbitkan SP2D kepada:
                                    </td>
                                </tr>
                            </table>
                         </td>
                         <td width=\"50%\" style=\"font-size:14px\" valign=\"top\">&nbsp; <b>Potongan-potongan :<b/></td>
                     </tr>
                     <tr>
                         <td width=\"50%\" style=\"font-size:12px\" valign=\"top\">
						 <table style=\"border-collapse:collapse;\" width=\"600\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
							<tr>
								<td valign=\"top\" style=\"font-size:12px\">B L U D</td>
								<td valign=\"top\" style=\"font-size:12px\">:</td>
								<td valign=\"top\" style=\"font-size:12px\"><b>$lcskpd</b></td>
							</tr>";
							$cRet .="
							<tr>
								<td valign=\"top\" style=\"font-size:12px\">Pihak Ketiga</td>
								<td valign=\"top\" style=\"font-size:12px\">:</td>
								<td valign=\"top\" style=\"font-size:12px\">$pimpinan $nmrekan</td>
							</tr>
							<tr>
								<td valign=\"top\" style=\"font-size:12px\">Nomor Rekening Bank </td>
								<td valign=\"top\" style=\"font-size:12px\">:</td>
								<td valign=\"top\" style=\"font-size:12px\">$nama_bank - $lcrekbank </td>
							</tr>
							<tr>
								<td valign=\"top\" style=\"font-size:12px\">NPWP</td>
								<td valign=\"top\" style=\"font-size:12px\">:</td>
								<td valign=\"top\" style=\"font-size:12px\">$lcnpwp</td>
							</tr>";
							
							$cRet .="
							<tr>
								<td valign=\"top\" style=\"font-size:12px\">Dasar Pembayaran/No dan Tanggal SPD </td>
								<td valign=\"top\" style=\"font-size:12px\">:</td>
								<td valign=\"top\" style=\"font-size:12px\"></td>
							</tr>
							
							<tr>
								<td valign=\"top\" style=\"font-size:12px;border-bottom: solid 1px black;border-top: solid 1px black;\"> Untuk keperluan </td>
								<td valign=\"top\" style=\"font-size:12px;border-bottom: solid 1px black;border-top: solid 1px black;\">:</td>
								<td valign=\"top\" style=\"font-size:12px;border-bottom: solid 1px black;border-top: solid 1px black;\"><pre style=\"font-family:Times New Roman\">$lckeperluan</pre></td>
							</tr>
					 </table>
						 <table style=\"border-collapse:collapse;\" width=\"600\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                 <tr>
                                    <td width=\"100%\" style=\"font-size:12px\">
                                         Pembebanan pada kode rekening :
                                         <table style=\"border-collapse:collapse;\" width=\"600\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
                                            ";
                                        if(($jns==1) || ($jns==2)){
                                        $sql = "select SUM(nilai) nilai from trdspp_blud where no_spp='$lcnospp' AND kd_skpd='$kd'";
                                        $hasil = $this->db->query($sql);
                                        $lcno = 0;
                                        $lntotal = 0;
                                        foreach ($hasil->result() as $row)
                                        {
                                           $lcno = $lcno + 1;
                                           $lntotal = $lntotal + $row->nilai;
										   
                                           $cRet .="   
											  <tr>
                                                <td style=\"font-size:12px\"> </td>
                                                <td style=\"font-size:12px\"> $lcskpd</td>
                                                <td style=\"font-size:12px\"> Rp </td>
                                                <td style=\"font-size:12px\" align=\"right\">".number_format($row->nilai,"2",",",".")."</td>
                                            </tr>"; 
										}  
										  $cRet .="</table>";
											if($lcno<=$baris)
											   {
												 for ($i = $lcno; $i <= $baris; $i++) 
												  {
													$cRet .="<br>";     
												  }                                                   
											   } 
										   } else{
										
										$sql1 = "SELECT COUNT(*) as jumlah FROM(
												SELECT ' ' as urut, kd_kegiatan+'.'+kd_rek_blud as kode, '' as nama, nilai from trdspp_blud where no_spp = '$lcnospp' and kd_skpd = '$kd')z
												";
                                        $hasil1 = $this->db->query($sql1);
										$row1 = $hasil1->row();
										$jumlahbaris = $row1->jumlah;
										if($jumlahbaris<=$baris){
											$sql = "
												SELECT 0 as urut,a.kd_kegiatan   AS kode,
												b.nm_kegiatan as nama, nilai 
												FROM trdspp_blud a LEFT JOIN m_giat_blud b ON a.kd_kegiatan=b.kd_kegiatan
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												union all
												SELECT 1 as urut,kd_kegiatan + '.' + left(a.kd_rek5,1)   AS kode,
												b.nm_rek1 as nama, nilai 
												FROM trdspp_blud a LEFT JOIN ms_rek1 b ON left(a.kd_rek5,1)=b.kd_rek1
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												union all
												SELECT 2 as urut,kd_kegiatan + '.' + left(a.kd_rek5,1)+ '.' + substring(a.kd_rek5,2,1)   AS kode,
												b.nm_rek2 as nama, nilai 
												FROM trdspp_blud a LEFT JOIN ms_rek2 b ON left(a.kd_rek5,2)=b.kd_rek2
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												union all
												SELECT 3 as urut,kd_kegiatan + '.' + left(a.kd_rek5,1)+ '.' + substring(a.kd_rek5,2,1) + '.' + substring(a.kd_rek5,3,1)   AS kode,
												b.nm_rek3 as nama, nilai 
												FROM trdspp_blud a LEFT JOIN ms_rek3 b ON left(a.kd_rek5,3)=b.kd_rek3
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												union all
												SELECT 4 as urut,kd_kegiatan + '.' + left(a.kd_rek5,1)+ '.' + substring(a.kd_rek5,2,1) + '.' + substring(a.kd_rek5,3,1) + '.' + substring(a.kd_rek5,4,2)   AS kode,
												b.nm_rek4 as nama, nilai 
												FROM trdspp_blud a LEFT JOIN ms_rek4 b ON left(a.kd_rek5,5)=b.kd_rek4 
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												union all
												SELECT 5 as urut,kd_kegiatan + '.' + left(a.kd_rek5,1)+ '.' + substring(a.kd_rek5,2,1) + '.' + substring(a.kd_rek5,3,1) + '.' + substring(a.kd_rek5,4,2) +'.' + substring(a.kd_rek5,6,2)   AS kode,
												b.nm_rek5 as nama, nilai 
												FROM trdspp_blud a LEFT JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5 
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												union all
												SELECT 6 as urut,kd_kegiatan + '.' + left(a.kd_rek5,1)+ '.' + substring(a.kd_rek5,2,1) + '.' + substring(a.kd_rek5,3,1) + '.' + substring(a.kd_rek5,4,2) +'.' + substring(a.kd_rek5,6,2) + '.' + left(b.plus_ang,2) + '.' + substring(b.plus_ang,3,3)   AS kode,
												b.nm_rek5 as nama, nilai 
												FROM trdspp_blud a LEFT JOIN ms_rek5_blud b ON a.kd_rek_blud=b.kd_rek5 
												WHERE no_spp = '$lcnospp' and kd_skpd = '$kd'
												ORDER BY kode";
										} else{
										$sql = "SELECT '1' as urut, a.kd_kegiatan+'.'+LEFT(a.kd_rek5,3) as kode, b.nm_rek3 as nama, SUM(a.nilai) as nilai
												FROM trdspp_blud a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek5,3)=b.kd_rek3
												where no_spp = '$lcnospp' and kd_skpd = '$kd'
												GROUP BY kd_kegiatan,  LEFT(a.kd_rek5,3), b.nm_rek3 
												UNION ALL
												SELECT '2' as urut, '' as kode, '- Rincian Terlampir ' as nama, 0 as nilai
												ORDER BY urut, kode";	
										}
                                        $hasil = $this->db->query($sql);
                                        $lcno = 0;
                                        $lntotal = 0;
                                        foreach ($hasil->result() as $row)
                                        {
                                           $lcno = $lcno + 1;
                                           $lntotal = $lntotal + $row->nilai;
										$cRet .="     
                                           <tr>
                                                <td style=\"font-size:12px\">
                                                    $row->kode
                                                </td>
                                                <td style=\"font-size:12px\">
                                                    ".ucwords($row->nama)."
                                                </td>
                                                <td style=\"font-size:12px\">
                                                    Rp
                                                </td>
                                                <td style=\"font-size:12px\" align=\"right\">
                                                    ".number_format($row->nilai,"2",",",".")."&nbsp;
                                                </td>
                                            </tr>"; 
											   
										   }
											$cRet .="</table>";
											if($lcno<=$baris)
											   {
												 for ($i = $lcno; $i <=$baris; $i++) 
												  {
													$cRet .="<br>";     
												  }                                                   
											   }
                                        }
                                     $sql = "select SUM(nilai) nilai from trdspp_blud where no_spp='$lcnospp' AND kd_skpd='$kd'";
                                        $hasil = $this->db->query($sql);
                                        foreach ($hasil->result() as $row)
                                        {
                                           $lnterbilang = $row->nilai;
										}
                                    $cRet .="</td>
                                <tr>
                                    <td width=\"100%\" align=\"right\" style=\"font-size:12px;border-hidden: top 1px black;border-top: solid 1px black;\">
                                    Jumlah SPP yang diminta 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Rp ".number_format($lnterbilang,"2",",",".")." &nbsp;                              
                                    </td>
                                </tr>
								<tr>
                                    <td width=\"100%\" align=\"left\" style=\"font-size:13px;border-bottom: solid 1px black;border-top: hidden;\">
                                   
                                    <b><i>".ucwords($this->tukd_model->terbilang($lnterbilang))."</i></b><br>
                                    Nomor dan Tanggal SPP :$lcnospp dan $ldtglspp                                   
                                    </td>
                                </tr>
                                 <tr>
                                    <td width=\"100%\" style=\"font-size:12px;border-bottom: none;border-top: solid 1px black;\">
                                        &nbsp;                                                      
                                    </td>
                                </tr>
                            </table>
                         </td>
                         <td width=\"50%\" style=\"font-size:12px\" valign=\"top\">
                            <table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"600\" align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">
                                <tr><thead>
                                    <td width=\"10%\" style=\"font-size:12px\" valign=\"center\" align=\"center\" valign=\"top\"><b>No.</b></td>
                                    <td width=\"50%\" style=\"font-size:12px\" valign=\"center\" align=\"center\"><b>Uraian (No. Rekening)</b></td>
                                    <td width=\"20%\" style=\"font-size:12px\" valign=\"center\" align=\"center\" valign=\"top\"><b>Jumlah</b></td>
                                    <td width=\"20%\" style=\"font-size:12px\" valign=\"center\" align=\"center\" valign=\"top\"><b>Keterangan</b></td>
                                    </thead>
                                </tr>";
                                 $sql = "select * from trspmpot_blud where no_spm='$lcnospm' AND kd_skpd='$kd' AND jns_pot='1'";
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
                                                        <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\">$lcno</td>
                                                        <td align=\"left\" style=\"font-size:12px\">".ucwords($nama_rek)."</td>
                                                        <td align=\"right\">".number_format($row->nilai,"2",",",".")."</td>
                                                        <td></td>
                                                    </tr>";    
                                        }
                                        
                                       if($lcno<=4)
                                       {
                                         for ($i = $lcno; $i <= 4; $i++) 
                                          {
                                            $cRet .= "<tr>
                                                        <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\">&nbsp;</td>
                                                        <td align=\"left\" style=\"font-size:12px\"></td>
                                                        <td></td>
                                                        <td></td>
                                                     </tr>";    
                                          }                                                   
                                       }
                                $cRet .="
                                <tr>
                                    <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\"></td>
                                    <td align=\"left\" style=\"font-size:12px\"><b>Jumlah Potongan</b></td>
                                    <td align=\"right\"><b>".number_format($lntotalpot,"2",",",".")."</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\" colspan=\"4\">
                                    Informasi :<i>(tidak mengurangi jumlah pembayaran SPM)</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=\"10%\" style=\"font-size:12px\" valign=\"center\" align=\"center\" valign=\"top\"><b>No.</b></td>
                                    <td align=\"center\" valign=\"center\" style=\"font-size:12px\"><b>Uraian</b></td>
                                    <td align=\"center\" valign=\"center\" style=\"font-size:12px\"><b>Jumlah</b></td>
                                    <td align=\"center\" valign=\"center\" style=\"font-size:12px\"><b>Keterangan</b></td>
                                </tr>";
                                 $sql = "select * from trspmpot_blud where no_spm='$lcnospm' AND kd_skpd='$kd' AND jns_pot ='0'";
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
                                            $cRet .="
                                                    <tr>
                                                        <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\">$lcno</td>
                                                        <td align=\"left\" style=\"font-size:12px\">".$nama_rek."</td>
                                                        <td align=\"right\">".number_format($row->nilai,"2",",",".")."</td>
                                                        <td></td>
                                                    </tr>";    
                                        }
                                       if($lcno<=4)
                                       {
                                         for ($i = $lcno; $i <= 4; $i++) 
                                          {
                                            $cRet .= "<tr>
                                                        <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\">&nbsp;</td>
                                                        <td align=\"left\" style=\"font-size:12px\"></td>
                                                        <td></td>
                                                        <td></td>
                                                     </tr>";    
                                          }                                                   
                                       }
                                
                                
                                $cRet .="
								<tr>
                                    <td width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\"></td>
                                    <td align=\"left\" style=\"font-size:12px\"><b>Jumlah</b></td>
                                    <td align=\"right\"><b>".number_format($lntotalpot_not,"2",",",".")."</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan=\"2\" width=\"10%\" style=\"font-size:12px\" align=\"center\" valign=\"top\"><b>Jumlah SPM</b></td>
                                    <td align=\"right\"><b>".number_format($lnterbilang-$lntotalpot,"2",",",".")."</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width=\"10%\" style=\"font-size:12px;border-bottom: none;\" align=\"left\" valign=\"top\" colspan=\"4\">
                                    Terbilang: <i>(".ucwords($this->tukd_model->terbilang($lnterbilang-$lntotalpot,"2",",",".")).")</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=\"10%\" style=\"font-size:12px;border-bottom: none;border-top: none;\" align=\"Center\" valign=\"top\" colspan=\"4\">
                                    <br><br>
                                    $daerah, $tglspm <br>
                                    <pre>$jabatan3</pre><br><br><br><br><br>
                                    <b><u>$nama3</u></b><br>$pangkat3<br>
                                    NIP. $nip3
                                    <br>
                                    <br>                                    
                                    </td>
                                </tr>
                            </table>
                         </td>
                     </tr>
                     <tr>
                         <td colspan=\"2\" style=\"font-size:12px\" align=\"center\">
                         <i>SPM ini sah apabila telah ditandatangani dan distempel oleh Kepala B L U D</i>
                         </td>
                     </tr>
                  </table>";
                     

    $data['prev']= $cRet;    
	switch($cetak) {
		case 0;
			return $cRet;
        break;
        case 1;
			$data = $this->tukd_model->_mpdf('',$cRet,5,5,5,'1') ;
			return $data;
        break;
        case 2;        
			$data = $this->_mpdf_down('',$cRet,10,10,10,1,0,'','Cetak SPM '.$lcnospm.'');
			return $data;
        break;
        }
	}
}