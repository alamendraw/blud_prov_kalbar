<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_spp extends CI_Model {

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

	
	function simpan_spp_up($tabel,$no_spp,$tgl,$bbn,$ket,$nilai,$rekup,$skpd,$usernm,$last_update){
		$sqldata = "SELECT a.rekening,a.alamat,a.npwp,a.bendahara, a.bank FROM ms_skpd_blud a 
					WHERE a.kd_skpd='$skpd'";
		$hasil = $this->db->query($sqldata);
        foreach ($hasil->result() as $row){
               $rekening = $row->rekening;
               $alamat = $row->alamat;
               $npwp = $row->npwp;
               $bendahara = $row->bendahara;
               $bank = $row->bank;
		}
        $sql = "select no_spp from $tabel where no_spp='$no_spp'  ";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
			$msg ='1';
			return $msg;
        }else{
            $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$ket','$bank','$rekening','$npwp','Bendahara','$bendahara','$nilai','$skpd','$usernm','$last_update','','','','$alamat')";
            $asg = $this->db->query($sql);
            if($asg){
				$sql = "INSERT INTO trdspp_blud(no_spp,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd,no_trans) 
				values ('$no_spp','','$rekup','$rekup','Uang Persediaan','$nilai','$skpd','')";
				$asg = $this->db->query($sql);
					if($asg){
						$msg ='2';
						return $msg;
					}else{
						$msg ='0';
						return $msg;
					}
            }else{
                $msg ='0';
				return $msg;
            }
        }
	}
	
	function update_spp_up($tabel,$no_spp,$nohide,$tgl,$bbn,$ket,$nilai,$rekup,$skpd,$usernm,$last_update){
		$sqldata = "SELECT a.rekening,a.alamat,a.npwp,a.bendahara, a.bank FROM ms_skpd_blud a 
					WHERE a.kd_skpd='$skpd'";
		$hasil = $this->db->query($sqldata);
        foreach ($hasil->result() as $row){
               $rekening = $row->rekening;
               $alamat = $row->alamat;
               $npwp = $row->npwp;
               $bendahara = $row->bendahara;
               $bank = $row->bank;
		}
		
        $sql = "select no_spp from $tabel where no_spp='$no_spp'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
			$msg ='1';
			return $msg;
        }else{
			$sql = "DELETE FROM trhsp2d_blud WHERE no_spp='$nohide' AND kd_skpd='$skpd'";
            $asg = $this->db->query($sql);
            $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$ket','$bank','$rekening','$npwp','Bendahara','$bendahara','$nilai','$skpd','$usernm','$last_update','','','','$alamat')";
            $asg = $this->db->query($sql);
            if($asg){
				$sql = "DELETE FROM trdspp_blud WHERE no_spp='$nohide' AND kd_skpd='$skpd'";
				$asg = $this->db->query($sql);
				$sql = "INSERT INTO trdspp_blud(no_spp,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd,no_trans) 
						values ('$no_spp','','$rekup','$rekup','Uang Persediaan','$nilai','$skpd','')";
				$asg = $this->db->query($sql);
					if($asg){
						$msg ='2';
						return $msg;
					}else{
						$msg ='0';
						return $msg;
					}
            }else{
                $msg ='0';
				return $msg;
            }
        }
	}
	
	function load_spp_up($kd_skpd,$kriteria){
		$where ="and jns_spp='1'";
        if ($kriteria <> ''){                               
            $where="and jns_spp='1' AND (upper(a.no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(a.kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "select a.no_spp, tgl_spp, jns_spp, keterangan_spp, b.nilai,a.kd_skpd,a.status_spp FROM trhsp2d_blud a 
				LEFT JOIN trdspp_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd = '$kd_skpd' $where order by a.no_spp,a.kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'no_spp' => $resulte['no_spp'],
                        'tgl_spp' => $resulte['tgl_spp'],
                        'jns_spp' => $resulte['jns_spp'],
                        'keperluan' => $resulte['keterangan_spp'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'status' => $resulte['status_spp'],
                        'nilai' => number_format ( $resulte ['nilai'], "2", ".", "," )
                        );
                        $ii++;
        }
        return $result;
    	$query1->free_result();  
	}
	
	function hapus_spp($kd_skpd,$nomor){
		$query = $this->db->query("delete from trdspp_blud where kd_skpd = '$kd_skpd' AND no_spp='$nomor'");
        $query = $this->db->query("delete from trhsp2d_blud where kd_skpd = '$kd_skpd' AND no_spp='$nomor'");
		if($query){
			$msg ='1';
			return $msg;
		}else{
			$msg ='0';
			return $msg;
		}
	}
	
	function load_kegiatan_tu($cskpd){
		$sql    = "select DISTINCT a.kd_kegiatan, a.nm_kegiatan from trdrka_blud a LEFT JOIN trskpd_blud b on a.kd_kegiatan=b.kd_kegiatan AND a.kd_skpd=b.kd_skpd
					WHERE b.jns_kegiatan !='4' AND a.kd_skpd='$cskpd' ORDER BY a.kd_kegiatan ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],  
                        'nm_kegiatan' => $resulte['nm_kegiatan']
                        );
                        $ii++;
        }
       return $result;
       $query1->free_result(); 
	}
	
	//awal sppgu
	function load_spp_gu($kd_skpd,$kriteria) {
	
		$where    = "and jns_spp='2' ";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT no_spp,tgl_spp,status_spp,kd_skpd,keterangan_spp,bulan,jns_spp,no_tagih,total,
				rekanan,pimpinan,kd_bank,no_rek,npwp,nama,alamat, no_lpj
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
                        'alamat'  =>$resulte['alamat'],
                        'nolpj'  =>$resulte['no_lpj']
                        );
                        $ii++;
        }
           
        return $result;
    	$query1->free_result();   
	}
   
	function cetakspp6($kd,$nomor,$jns,$pa,$print,$spasi,$tanpa){
		
        $alamat_skpd = $this->rka_model->get_nama($kd,'alamat','ms_skpd_blud','kd_skpd');		
        $kodepos = '';//$this->rka_model->get_nama($kd,'kodepos','ms_skpd_blud','kd_skpd');
			if($kodepos==''){
				$kodepos = "-------";
			} else {
				$kodepos = "$kodepos";
			}
        $PA = str_replace('123456789',' ',$this->uri->segment(7));
       
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where nip='$PA' and kode = 'PA' AND kd_skpd='$kd'";
		 $sqlttd=$this->db->query($sqlttd1);
		 foreach ($sqlttd->result() as $rowttd)
		{
			$nip=$rowttd->nip;                    
			$nama= $rowttd->nm;
			$jabatan  = $rowttd->jab;
			$pangkat  = $rowttd->pangkat;
		}
        $stsubah =$this->rka_model->get_nama($kd,'status_ubah','trhrka_blud','kd_skpd');
		if($stsubah == 0){
			$sqldpa="SELECT no_dpa as no , tgl_dpa as tgl from trhrka_blud where kd_skpd = '$kd'";
		} else {
			$sqldpa="SELECT no_dpa_ubah as no, tgl_dpa_ubah as tgl from trhrka_blud where kd_skpd = '$kd'";
		}
		$sqldpa=$this->db->query($sqldpa);
		 foreach ($sqldpa->result() as $rowdpa)
		{
			$no_dpa=$rowdpa->no;                    
			$tgl_dpa = $this->tanggal_format_indonesia($rowdpa->tgl);
		}
		
		
		
        if ($jns==1){
        $sql1="SELECT a.no_spp,a.tgl_spp,a.kd_skpd,(select distinct nm_skpd from ms_skpd_blud where kd_skpd=a.kd_skpd) nm_skpd,a.bulan,b.kd_urusan,b.nm_urusan,a.total FROM trhsp2d_blud a INNER JOIN ms_urusan_blud b 
                ON SUBSTRING(a.kd_skpd,1,4)=b.kd_urusan  where a.no_spp='$nomor' AND a.kd_skpd='$kd'";
                 
                 $query = $this->db->query($sql1);
                                                  
                foreach ($query->result() as $row)
                {
                    $kd_urusan=$row->kd_urusan;
                    $nm_urusan=$row->nm_urusan;
                    $kd_skpd=$row->kd_skpd;
                    $nm_skpd=$row->nm_skpd;
                    $tgl=$row->tgl_spp;
                    $tanggal1 = $this->tanggal_format_indonesia($tgl);
                    $bln = $this->getBulan($row->bulan);                    
                    $nilai=number_format($row->nilai,"2",",",".");
                    $nilai1=$row->nilai;
                    $a=$this->tukd_model->terbilang($nilai1);
                }
                
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$kd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }

        $thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$tanggal ="_______________________$thn_ang";
			} else{
			$tanggal = $tanggal1;	
			}				
        $cRet='';
       $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"5\" align=\"right\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"75\" height=\"100\" />
                        </td>
					    <td colspan=\"2\" align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>";

 
        
        // if(substr($kd,0,7)==$this->org_keu && $kd!=$this->skpd_keu ){
        //         $nm_org = $this->rka_model->get_nama($this->skpd_keu,'nm_skpd','ms_skpd_blud','kd_skpd');           
        //         $cRet .="<tr><td align=\"center\" style=\"font-size:13px\">$nm_org</tr>";
        // }
        $nm_org = $this->rka_model->get_nama($kd,'nm_skpd','ms_skpd_blud','kd_skpd');           
                $cRet .="<tr><td align=\"center\" style=\"font-size:13px\"></tr>";

       $cRet .="    
                    <tr><td align=\"center\" style=\"font-size:13px\"><pre style=\"font-family: Times New Roman;\">$nm_skpd</pre></td></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">$alamat_skpd</td></tr>
                    <tr><td align=\"right\">".strtoupper($daerah)." &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
					&nbsp;&nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  Kode Pos: $kodepos &nbsp; &nbsp;</td>	</tr>
					</table>
					<hr  width=\"100%\"> 
					";
					
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong><u>SURAT PERNYATAAN PENGAJUAN SPP - UP </u></strong></td></tr>
                    <tr><td align=\"center\"><strong>Nomor :$nomor </strong></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Sehubungan dengan Surat Permintaan Pembayaran Uang Persediaan (SPP - UP) Nomor $nomor Tanggal $tanggal1 yang kami ajukan sebesar
					$nilai ($a)</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Untuk Keperluan SKPD : $nm_skpd Tahun Anggaran $thn_ang </td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Dengan ini menyatakan sebenarnya bahwa :</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";

        $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"$spasi\">
                     
                        ";
                            
                                  
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">1.</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									 Jumlah Pembayaran UP tersebut di atas akan dipergunakan untuk keperluan guna membiayai kegiatan yang akan kami laksanan sesuai DPA-SKPD</td>
                                     </tr>
                                     ";
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">2.</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									 Jumlah Pembayaran UP tersebut tidak akan dipergunakan untuk membiayai pengeluaran-pengeluaran yang menurut ketentuan yang berlaku
									 harus dilakasanakan dengan Pembayaran Langsung (UP/GU/TU/LS-Barang dan Jasa)
									 </tr>
                                     ";
		
        $cRet .=       " </table>";
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    
                    <tr><td align=\"justify\">Demikian Surat pernyataan ini dibuat untuk melengkapi persyaratan pengajuan SPM-UP SKPD kami</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$daerah, $tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"> </td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
        $data['prev']= $cRet;
            $this->tukd_model->_mpdf('',$cRet,10,10,10,'0'); 
      }
      
      if ($jns==2){
		$sql1="SELECT a.no_spp,a.tgl_spp,a.kd_skpd,(select distinct nm_skpd from ms_skpd_blud where kd_skpd=a.kd_skpd) nm_skpd,a.bulan,a.rekanan, a.no_rek,a.npwp,b.kd_urusan, b.nm_urusan, a.kd_bank
				, ( SELECT 
							nama 
						FROM
							ms_bank_blud
						WHERE 
							kode=a.kd_bank
				) AS nama_bank, a.total
				FROM trhsp2d_blud a INNER JOIN ms_urusan_blud b 
                ON SUBSTRING(a.kd_skpd,1,4)=b.kd_urusan  where a.no_spp='$nomor' AND a.kd_skpd='$kd'";
                 
                 $query = $this->db->query($sql1);
                                                  
                foreach ($query->result() as $row)
                {
                    $kd_urusan=$row->kd_urusan;
                    $nm_urusan=$row->nm_urusan;
                    $kd_skpd=$row->kd_skpd;
                    $nm_skpd=$row->nm_skpd;
                    $tgl=$row->tgl_spp;
					$nama_bank=$row->nama_bank;
                    $no_rek=$row->no_rek;
					$npwp = $row->npwp;
					$rekan = $row->rekanan;
                    $tanggal1 = $this->tanggal_format_indonesia($tgl);
                    $bln = $this->getBulan($row->bulan);                    
                    $nilai=number_format($row->total,"2",",",".");
                    $nilai1=$row->total;
                    $a=$this->tukd_model->terbilang($nilai1);
                    //echo($a);
                }
                
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$kd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
        
        $thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$tanggal ="_______________________$thn_ang";
			} else{
			$tanggal = $tanggal1;	
			}				
		
        $cRet='';
       $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"5\" align=\"right\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"75\" height=\"100\" />
                        </td>
					    <td colspan=\"2\" align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>";

 
        
        if(substr($kd,0,7)==$this->org_keu && $kd!=$this->skpd_keu ){
                $nm_org = $this->rka_model->get_nama($this->skpd_keu,'nm_skpd','ms_skpd_blud','kd_skpd');           
                $cRet .="<tr><td align=\"center\" style=\"font-size:13px\">$nm_org</tr>";
        }

       $cRet .="    
                    <tr><td align=\"center\" style=\"font-size:13px\"><pre style=\"font-family: Times New Roman;\">$nm_skpd</pre></td></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">$alamat_skpd</td></tr>
                    <tr><td align=\"right\">".strtoupper($daerah)." &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
					&nbsp;&nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  Kode Pos: $kodepos &nbsp; &nbsp;</td>	</tr>
					</table>
					<hr  width=\"100%\"> 
					";
					
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong><u>SURAT PERNYATAAN TANGGUNG JAWABAN BELANJA</u></strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                  </table>";
		
		 $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"$spasi\">
                     
                        ";
                            
                                  
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">1. SKPD </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$kd - $nm_skpd</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">2. Satuan Kerja</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$kd - $nm_skpd</td>
                                     </tr>";				 
									 
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">3. Tanggal/NO. DPA</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$tgl_dpa dan $no_dpa</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">4. Tahun Anggaran</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$thn_ang</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">5. Jumlah Belanja </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									Rp. $nilai</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">&nbsp; </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\"></td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									&nbsp;</td>
                                     </tr>";					
        $cRet .=       " </table>";
       
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    
                    <tr><td align=\"justify\">Yang bertanda tangan di bawah ini adalah $jabatan Satuan Kerja $nm_skpd Menyatakan bahwa saya bertanggung jawab penuh atas segala pengeluaran-pengeluaran
					yang telah dibayar lunas oleh Bendahara Pengeluaran kepada yang berhak menerima, sebagaimana tertera dalam Laporan Pertanggung Jawaban Ganti Uang di sampaikan oleh Bendahara Pengeluaran
					<br>
					<br>
					Bukti-bukti belanja tertera dalam Laporan Pertanggung Jawaban Ganti Uang disimpan sesuai ketentuan yang berlaku pada sistem Satuan Kerja $nm_skpd
					untuk kelengkapan administrasi dan keperluan pemeriksaan aparat pengawasan Fungsional
					<br>
					<br>
					Demikian Surat Pernyataan ini dibuat dengan sebenarnya</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$daerah, $tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"> </td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
        
        $data['prev']= $cRet;
        if($print=='1'){
			
			//_mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='')
			
			$data = $this->tukd_model->_mpdf('',$cRet,10,10,10,'0'); 
			return $data;
			}
		if($print=='0'){
		echo $cRet;
		}
      }
      
      
	  if ($jns==3){
		$sql1="SELECT a.no_spp,a.tgl_spp,a.kd_skpd,a.nm_skpd,a.bulan,a.nmrekan, a.no_rek,a.npwp,b.kd_urusan, b.nm_urusan, a.bank
				, ( SELECT 
							nama 
						FROM
							ms_bank_blud
						WHERE 
							kode=a.bank
				) AS nama_bank, a.nilai
				FROM trhsp2d_blud a INNER JOIN ms_urusan_blud b 
                ON SUBSTRING(a.kd_skpd,1,4)=b.kd_urusan  where a.no_spp='$nomor' AND a.kd_skpd='$kd'";
                 
                 $query = $this->db->query($sql1);
                                                  
                foreach ($query->result() as $row)
                {
                    $kd_urusan=$row->kd_urusan;
                    $nm_urusan=$row->nm_urusan;
                    $kd_skpd=$row->kd_skpd;
                    $nm_skpd=$row->nm_skpd;
                    $tgl=$row->tgl_spp;
					$nama_bank=$row->nama_bank;
                    $no_rek=$row->no_rek;
					$npwp = $row->npwp;
					$rekan = $row->nmrekan;
                    $tanggal1 = $this->tanggal_format_indonesia($tgl);
                    $bln = $this->getBulan($row->bulan);                    
                    $nilai=number_format($row->nilai,"2",",",".");
                    $nilai1=$row->nilai;
                    $a=$this->tukd_model->terbilang($nilai1);
                    //echo($a);
                }
                
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$kd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
        
        $thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$tanggal ="_______________________$thn_ang";
			} else{
			$tanggal = $tanggal1;	
			}				
		
        $cRet='';
       $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"5\" align=\"right\">
                        <img src=\"".base_url()."/image/logoHP.bmp\"  width=\"75\" height=\"100\" />
                        </td>
					    <td colspan=\"2\" align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>";

 
        
        if(substr($kd,0,7)==$this->org_keu && $kd!=$this->skpd_keu ){
                $nm_org = $this->rka_model->get_nama($this->skpd_keu,'nm_skpd','ms_skpd_blud','kd_skpd');           
                $cRet .="<tr><td align=\"center\" style=\"font-size:13px\">$nm_org</tr>";
        }

       $cRet .="    
                    <tr><td align=\"center\" style=\"font-size:13px\"><pre style=\"font-family: Times New Roman;\">$nm_skpd</pre></td></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">$alamat_skpd</td></tr>
                    <tr><td align=\"right\">".strtoupper($daerah)." &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
					&nbsp;&nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  Kode Pos: $kodepos &nbsp; &nbsp;</td>	</tr>
					</table>
					<hr  width=\"100%\"> 
					";
					
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong><u>SURAT PERNYATAAN TANGGUNG JAWABAN BELANJA</u></strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                  </table>";
		
		 $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"$spasi\">
                     
                        ";
                            
                                  
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">1. SKPD</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$kd - $nm_skpd</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">2. Satuan Kerja</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$kd - $nm_skpd</td>
                                     </tr>";				 
									 
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">3. Tanggal/NO. DPA</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$tgl_dpa dan $no_dpa</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">4. Tahun Anggaran</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$thn_ang</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">5. Jumlah Belanja </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									Rp. $nilai</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">&nbsp; </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\"></td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									&nbsp;</td>
                                     </tr>";					
        $cRet .=       " </table>";
       
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    
                    <tr><td align=\"justify\">Yang bertanda tangan di bawah ini adalah $jabatan Satuan Kerja $nm_skpd Menyatakan bahwa saya bertanggung jawab penuh atas segala pengeluaran-pengeluaran
					yang telah dibayar lunas oleh Bendahara Pengeluaran kepada yang berhak menerima, sebagaimana tertera dalam Laporan Pertanggung Jawaban Tambah Uang di sampaikan oleh Bendahara Pengeluaran
					<br>
					<br>
					Bukti-bukti belanja tertera dalam Laporan Pertanggung Jawaban Tambah Uang disimpan sesuai ketentuan yang berlaku pada sistem Satuan Kerja $nm_skpd
					untuk kelengkapan administrasi dan keperluan pemeriksaan aparat pengawasan Fungsional
					<br>
					<br>
					Demikian Surat Pernyataan ini dibuat dengan sebenarnya</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$daerah, $tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"> </td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
        
        $data['prev']= $cRet;
        if($print=='1'){
			
			//_mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='')
			
			$this->_mpdf('',$cRet,10,10,10,'0',1,''); 
			}
		if($print=='0'){
		echo $cRet;
		}
      }
      
	  
        if ($jns==4){
        
			$sql1="SELECT a.no_spp,a.tgl_spp,a.kd_skpd,a.nm_skpd,a.bulan,a.nmrekan, a.no_rek,a.npwp, a.jns_beban, b.kd_urusan, b.nm_urusan, a.bank
				, ( SELECT 
							nama 
						FROM
							ms_bank_blud
						WHERE 
							kode=a.bank
				) AS nama_bank, 
				a.no_spd,a.nilai
				FROM trhsp2d_blud a INNER JOIN ms_urusan_blud b 
                ON SUBSTRING(a.kd_skpd,1,4)=b.kd_urusan  where a.no_spp='$nomor' AND a.kd_skpd='$kd'";
                $query = $this->db->query($sql1);
                                                  
                foreach ($query->result() as $row)
                {
                    $kd_urusan=$row->kd_urusan;
                    $nm_urusan=$row->nm_urusan;
                    $kd_skpd=$row->kd_skpd;
                    $nm_skpd=$row->nm_skpd;
                    $spd=$row->no_spd;
                    $tgl=$row->tgl_spp;
                    $jns_bbn=$row->jns_beban;
					$nama_bank=$row->nama_bank;
                    $no_rek=$row->no_rek;
					$npwp = $row->npwp;
					$rekan = $row->nmrekan;
                    $tanggal1 = $this->tanggal_format_indonesia($tgl);
                    $bln = $this->getBulan($row->bulan);                    
                    $nilai=number_format($row->nilai,"2",",",".");
                    $nilai1=$row->nilai;
                    $a=$this->tukd_model->terbilang($nilai1);
                    //echo($a);
                }
                 
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$kd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
       
        $thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$tanggal ="_______________________$thn_ang";
			} else{
			$tanggal = $tanggal1;	
			}				

        $cRet='';
        
		
		switch ($jns_bbn) 
        {
            case '1': //UP
                $lcbeban = "Gaji dan Tunjangan";
                break;
            case '2': //GU
                $lcbeban = "Uang Kespeg";
                break;
            case '3': //TU
                $lcbeban = "Uang Makan";
                break;
			case '4': //TU
                $lcbeban = "Upah Pungut";
                break;
			case '5': //TU
                $lcbeban = "Upah Pungut PBB";
                break;
			case '6': //TU
                $lcbeban = "Upah Pungut PBB-KB PKB & BBN-KB ";
                break;
			case '7': //TU
                $lcbeban = "Gaji & Tunjangan";
                break;
			case '8': //TU
                $lcbeban = "Tunjangan Transport";
                break;
			case '9': //TU
                $lcbeban = "Tunjangan Lainnya";
                break;
            default:
                $lcbeban = "LS";
                
        }			
       $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"5\" align=\"right\">
                        <img src=\"".base_url()."/image/logoHP.bmp\"  width=\"75\" height=\"100\" />
                        </td>
					    <td colspan=\"2\" align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>";

 
        
        if(substr($kd,0,7)==$this->org_keu && $kd!=$this->skpd_keu ){
                $nm_org = $this->rka_model->get_nama($this->skpd_keu,'nm_skpd','ms_skpd','kd_skpd');           
                $cRet .="<tr><td align=\"center\" style=\"font-size:13px\">$nm_org</tr>";
        }

       $cRet .="    
                    <tr><td align=\"center\" style=\"font-size:13px\"><pre style=\"font-family: Times New Roman;\">$nm_skpd</pre></td></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">$alamat_skpd</td></tr>
                    <tr><td align=\"right\">".strtoupper($daerah)." &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
					&nbsp;&nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  Kode Pos: $kodepos &nbsp; &nbsp;</td>	</tr>
					</table>
					<hr  width=\"100%\"> 
					";
					
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong><u>SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK </u></strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Yang Bertanda tangan di bawah ini:</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";

        $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10\" align=\"left\">Nama</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									$nama                                     
									</tr>
                                     ";
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10\" align=\"left\">NIP</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									$nip                                     
									</tr>
                                     ";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10\" align=\"left\">Jabatan</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									$jabatan                                     
									</tr>
                                     ";				 
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10\" align=\"left\">&nbsp;</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									&nbsp;                                     
									</tr>
                                     ";	
        $cRet .=       " </table>";
		$cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"$spasi\">";
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"left\">1.</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									 Perhitungan yang terdapat pada Daftar Perhitungan Tambahan Penghasilan bagi PNS di Lingkungan Pemerintah PROVINSI KALIMANTAN BARAT
									(".strtoupper($lcbeban).") bulan $bln $thn_ang bagi $nm_skpd telah dhitung dengan benar dan berdasarkan daftar hadir kerja Pegawai Negeri Sipil
									Daerah pada $nm_skpd									
									</td> </tr>
                                     ";
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"left\">2.</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									 Apabila dikemudian hari terdapat kelebihan atas pembayaran ".strtoupper($lcbeban)." tersebut, kami bersedia untuk menyetorkan kelebihan tersebut ke Kas Daerah
									 </tr>
                                     ";
		
        $cRet .=       " </table>";
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    
                    <tr><td align=\"justify\">Demikian  pernyataan ini kami buat dengan sebenar-benarnya.</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$daerah, $tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"> </td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
            $data['prev']= $cRet;
			if($print=='1'){
			$this->_mpdf('',$cRet,10,10,10,'0',1,''); 
			}
			if($print=='0'){
			echo $cRet;
			}
	  }
      if ($jns==6){
        /*
		$sql1="SELECT a.no_spp,a.tgl_spp,a.kd_skpd,a.nm_skpd,a.bulan,b.kd_urusan,b.nm_urusan,a.no_spd,a.nilai,(SELECT SUM(x.nilai) FROM trdspd x inner join trhspd w on x.no_spd = w.no_spd WHERE w.jns_beban='52')
                AS spd,(SELECT SUM(z.nilai) FROM trdspp z INNER JOIN trhspp y ON z.no_spp = y.no_spp where y.no_spd=a.no_spd and z.no_spp <> a.no_spp) AS spp FROM trhspp a INNER JOIN ms_urusan b 
                ON SUBSTRING(a.kd_skpd,1,4)=b.kd_urusan  where a.no_spp='$nomor'";
        */

		$sql1="SELECT a.no_spp,a.tgl_spp,a.kd_skpd,a.nm_skpd,a.bulan,a.nmrekan, a.no_rek,a.jns_beban,a.npwp,b.kd_urusan, b.nm_urusan, a.bank, 
				a.no_spd,a.nilai
				FROM trhsp2d_blud a INNER JOIN ms_urusan_blud b 
                ON SUBSTRING(a.kd_skpd,1,4)=b.kd_urusan  where a.no_spp='$nomor' AND a.kd_skpd='$kd'";


	
                 $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                                                  
                foreach ($query->result() as $row)
                {
                    $kd_urusan=$row->kd_urusan;
                    $nm_urusan=$row->nm_urusan;
                    $kd_skpd=$row->kd_skpd;
                    $nm_skpd=$row->nm_skpd;
                    $spd=$row->no_spd;
                    $tgl=$row->tgl_spp;
                    $no_rek=$row->no_rek;
					$npwp = $row->npwp;
					$jns_bbn = $row->jns_beban;
					$rekan = $row->nmrekan;
                    $tanggal1 = $this->tanggal_format_indonesia($tgl);
                    $bln = $this->getBulan($row->bulan);                    
                    $nilai=number_format($row->nilai,"2",",",".");
                    $nilai1=$row->nilai;
                    $a=$this->tukd_model->terbilang($nilai1);
                    //echo($a);
                }
                
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$kd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                   
                }
       
        $thn_ang	   = $this->session->userdata('pcThang');
		if($tanpa==1) {
			$tanggal ="_______________________$thn_ang";
			} else{
			$tanggal = $tanggal1;	
			}				
		switch ($jns_bbn) 
        {
            case '1': //UP
                $lcbeban = "Rutin PNS";
                break;
            case '2': //GU
                $lcbeban = "Rutin Non PNS";
                break;
            case '3': //TU
                $lcbeban = "Barang dan Jasa";
                break;
            default:
                $lcbeban = "LS";
                
        }
        $cRet='';
       $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"5\" align=\"right\">
                        <img src=\"".base_url()."/image/logoHP.bmp\"  width=\"75\" height=\"100\" />
                        </td>
					    <td colspan=\"2\" align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>";

 
        
        if(substr($kd,0,7)==$this->org_keu && $kd!=$this->skpd_keu ){
                $nm_org = $this->rka_model->get_nama($this->skpd_keu,'nm_skpd','ms_skpd_blud','kd_skpd');           
                $cRet .="<tr><td align=\"center\" style=\"font-size:13px\">$nm_org</tr>";
        }

       $cRet .="    
                    <tr><td align=\"center\" style=\"font-size:13px\"><pre style=\"font-family: Times New Roman;\">$nm_skpd</pre></td></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">$alamat_skpd</td></tr>
                    <tr><td align=\"right\">".strtoupper($daerah)." &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
					&nbsp;&nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  Kode Pos: $kodepos &nbsp; &nbsp;</td>	</tr>
					</table>
					<hr  width=\"100%\"> 
					";
					
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong><u>SURAT PERNYATAAN PENGAJUAN SPP - ".strtoupper($lcbeban)." </u></strong></td></tr>
                    <tr><td align=\"center\"><strong>Nomor :$nomor </strong></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Sehubungan dengan Surat Permintaan Pembayaran Langsung (SPP - LS ".strtoupper($lcbeban).") Nomor $nomor Tanggal $tanggal1 yang kami ajukan sebesar
					$nilai (".ucwords($a).")</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Untuk Keperluan SKPD : $nm_skpd Tahun Anggaran $thn_ang </td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                    <tr><td align=\"left\">Dengan ini menyatakan sebenarnya bahwa :</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";

        $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"$spasi\">
                     
                        ";
                            
                                  
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">1.</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									 Jumlah Pembayaran Langsung (LS) $lcbeban tersebut di atas akan dipergunakan untuk keperluan guna membiayai kegiatan yang akan kami laksanan sesuai DPA-SKPD</td>
                                     </tr>
                                     ";
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">2.</td>                                     
                                     <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"90%\" align=\"justify\">
									 Jumlah Pembayaran Langsung (LS) $lcbeban tersebut tidak akan dipergunakan untuk membiayai pengeluaran-pengeluaran yang menurut ketentuan yang berlaku
									 harus dilakasanakan dengan Pembayaran Langsung (UP/GU/TU/LS-Gaji)
									 </tr>
                                     ";
		
        $cRet .=       " </table>";
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    
                    <tr><td align=\"justify\">Demikian Surat pernyataan ini dibuat untuk melengkapi persyaratan pengajuan SPP-LS $lcbeban SKPD kami</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$daerah, $tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"> </td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
        $data['prev']= $cRet;
         if($print==1){    
			$this->_mpdf('',$cRet,10,10,10,'0',1,''); 
			 }
		 if($print==0){
			echo $cRet;
		 }
      }            
    }
	
	//akhir sppgu
	
	
	function load_rek_trdrka($cskpd,$kode_giat){
		$sql    = "select kd_rek5,nm_rek5 from trdrka_blud where kd_skpd='$cskpd' and kd_kegiatan='$kode_giat'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5']
                        );
                        $ii++;
        }
       return $result;
       $query1->free_result(); 
	}
	
	function load_rek_spp($ckdkegi,$ckdrek,$beban){
		if(($beban=='4') or ($beban=='5')){
			$and = "";
		}else{
			$and = "";
		}
		
		if (  $ckdrek != '' ){
            $NotIn = " " ;
        } else {
            $NotIn = " " ;
        }
        
        $sql      = "
					select DISTINCT a.kd_rek5 as kd_rek_blud, b.nm_rek5 as nm_rek_blud,right(no_trdrka,7) as kd_rek5
					from trdpo_blud a left join
					ms_rek5_blud b on rtrim(a.kd_rek5) = rtrim(b.kd_rek5)
					where 
					right(no_trdrka,7)='$ckdrek'
					and substring(no_trdrka,12,22) ='$ckdkegi'
					$NotIn  $and order by a.kd_rek5";
					
        $query1   = $this->db->query($sql);
        $result   = array();
        $ii       = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'      	  => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
                        'nm_rek_blud' => $resulte['nm_rek_blud']
                        );
                        $ii++;
        }
        return $result;
        $query1->free_result();
	}
	
	
	
	function load_rek_ali($ckdkegi,$ckdrek,$beban){
		/*
		if($beban=='7'){
			$and = "AND c.jenis='1'";
		}else{
			$and = "AND c.jenis='2'";
		}
		*/
		if (  $ckdrek != '' ){
            $NotIn = " " ;
        } else {
            $NotIn = " " ;
        }
        
        $sql      = "SELECT DISTINCT b.kd_rek5 as kd_rek_blud, c.nm_rek5 as nm_rek_blud, a.kd_rek5 
					FROM trdrka_blud a LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
					LEFT JOIN ms_rek5_blud c ON b.kd_rek5=c.kd_rek5
					WHERE a.kd_kegiatan = '$ckdkegi' AND a.kd_rek5='$ckdrek' $NotIn  order by b.kd_rek5";
					
        $query1   = $this->db->query($sql);
        $result   = array();
        $ii       = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'      	  => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
                        'nm_rek_blud' => $resulte['nm_rek_blud']
                        );
                        $ii++;
        }
        return $result;
        $query1->free_result();
	}
	
	
	function jumlah_ang_spp($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$cnospp){
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
			WHERE a.kd_kegiatan='$ckdkegi' AND a.kd_rek5='$ckdrek' AND b.kd_rek5='$crekblud' ";
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
	
	function simpan_spp_tu($no_spp,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update){
		$sqldata = "SELECT a.rekening,a.alamat,a.npwp,a.bendahara, a.bank FROM ms_skpd_blud a 
					WHERE a.kd_skpd='$skpd'";
		$hasil = $this->db->query($sqldata);
        foreach ($hasil->result() as $row){
               $rekening = $row->rekening;
               $alamat = $row->alamat;
               $npwp = $row->npwp;
               $bendahara = $row->bendahara;
               $bank = $row->bank;
		}
        $sql = "delete from trhsp2d_blud where kd_skpd='$skpd' and no_spp='$no_spp'";
        $asg = $this->db->query($sql);
            if ($asg){
				  $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,bulan,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$bln','$ket','$bank','$rekening','$npwp','Bendahara','$bendahara','$nilai','$skpd','$usernm','$last_update','','','','$alamat')";
             $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdspp_blud where no_spp='$no_spp' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdspp_blud(no_spp,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans) values $lcnilaidet";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							$msg = '2';
							return $msg;
						}
                    }                
                }            
            }
	}
	
	function update_spp_tu($no_spp,$nohide,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update){
		$sqldata = "SELECT a.rekening,a.alamat,a.npwp,a.bendahara, a.bank FROM ms_skpd_blud a 
					WHERE a.kd_skpd='$skpd'";
		$hasil = $this->db->query($sqldata);
        foreach ($hasil->result() as $row){
               $rekening = $row->rekening;
               $alamat = $row->alamat;
               $npwp = $row->npwp;
               $bendahara = $row->bendahara;
               $bank = $row->bank;
		}
        $sql = "delete from trhsp2d_blud where kd_skpd='$skpd' and no_spp='$nohide'";
            $asg = $this->db->query($sql);
            if ($asg){
				  $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,bulan,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$bln','$ket','$bank','$rekening','$npwp','Bendahara','$bendahara','$nilai','$skpd','$usernm','$last_update','','','','$alamat')";
             $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdspp_blud where no_spp='$nohide' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdspp_blud(no_spp,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans) values $lcnilaidet";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							$msg = '2';
							return $msg;
						}
                    }                
                }            
            }
	}
	
	function load_spp_tu($kd_skpd,$kriteria){
		$where    = "and jns_spp='3' ";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT no_spp,tgl_spp,status_spp,kd_skpd,keterangan_spp,bulan,jns_spp,total from trhsp2d_blud WHERE kd_skpd = '$kd_skpd' $where order by no_spp,kd_skpd";
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
                        'status'    =>$resulte['status_spp']
                        );
                        $ii++;
        }
           
        return $result;
    	$query1->free_result();    
	}
	
	function load_detail_spp($kd_skpd,$spp){
		 $sql = "SELECT kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans FROM trdspp_blud WHERE no_spp='$spp' AND kd_skpd='$kd_skpd' ORDER BY kd_kegiatan,kd_rek5,kd_rek_blud";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'idx'        => $ii,
                        'kdkegiatan' => $resulte['kd_kegiatan'],
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'kdrekblud'  => $resulte['kd_rek_blud'],  
                        'nmrekblud'  => $resulte['nm_rek_blud'],  
                        'nilai1'     => number_format($resulte['nilai'],"2",".",",")
                        );
                        $ii++;
        }
           
     return $result;
     $query1->free_result();  
	}
	
	function simpan_spp_gj($no_spp,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update){
		$sqldata = "SELECT a.rekening,a.alamat,a.npwp,a.bendahara, a.bank FROM ms_skpd_blud a 
					WHERE a.kd_skpd='$skpd'";
		$hasil = $this->db->query($sqldata);
        foreach ($hasil->result() as $row){
               $rekening = $row->rekening;
               $alamat = $row->alamat;
               $npwp = $row->npwp;
               $bendahara = $row->bendahara;
               $bank = $row->bank;
		}
        $sql = "delete from trhsp2d_blud where kd_skpd='$skpd' and no_spp='$no_spp'";
            $asg = $this->db->query($sql);
            if ($asg){
				  $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,bulan,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$bln','$ket','$bank','$rekening','$npwp','Bendahara','$bendahara','$nilai','$skpd','$usernm','$last_update','','','','$alamat')";
             $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdspp_blud where no_spp='$no_spp' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdspp_blud(no_spp,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans) values $lcnilaidet";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							$msg = '2';
							return $msg;
						}
                    }                
                }            
            }
	}
	
	function update_spp_gj($no_spp,$nohide,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update){
		$sqldata = "SELECT a.rekening,a.alamat,a.npwp,a.bendahara, a.bank FROM ms_skpd_blud a 
					WHERE a.kd_skpd='$skpd'";
		$hasil = $this->db->query($sqldata);
        foreach ($hasil->result() as $row){
               $rekening = $row->rekening;
               $alamat = $row->alamat;
               $npwp = $row->npwp;
               $bendahara = $row->bendahara;
               $bank = $row->bank;
		}
        $sql = "delete from trhsp2d_blud where kd_skpd='$skpd' and no_spp='$nohide'";
            $asg = $this->db->query($sql);
            if ($asg){
				  $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,bulan,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$bln','$ket','$bank','$rekening','$npwp','Bendahara','$bendahara','$nilai','$skpd','$usernm','$last_update','','','','$alamat')";
             $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdspp_blud where no_spp='$nohide' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdspp_blud(no_spp,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans) values $lcnilaidet";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							$msg = '2';
							return $msg;
						}
                    }                
                }            
            }
	}
	
	function load_spp_gj($kd_skpd,$kriteria){
		$where    = "and jns_spp='4' ";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT no_spp,tgl_spp,status_spp,kd_skpd,keterangan_spp,bulan,jns_spp,total from trhsp2d_blud WHERE kd_skpd = '$kd_skpd' $where order by no_spp,kd_skpd";
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
                        'status'    =>$resulte['status_spp']
                        );
                        $ii++;
        }
           
        return $result;
    	$query1->free_result();    
	}
	
	
	function load_kegiatan_ls($cskpd){
		$sql    = "select DISTINCT a.kd_kegiatan, a.nm_kegiatan from trdrka_blud a LEFT JOIN trskpd_blud b on a.kd_kegiatan=b.kd_kegiatan AND a.kd_skpd=b.kd_skpd
					WHERE b.jns_kegiatan !='4' AND a.kd_skpd='$cskpd' ORDER BY a.kd_kegiatan ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],  
                        'nm_kegiatan' => $resulte['nm_kegiatan']
                        );
                        $ii++;
        }
       return $result;
       $query1->free_result(); 
	}
	
	function load_detail_penagihan($kd_skpd,$no_tagih){
		 $sql = "SELECT kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai FROM trdtagih_blud WHERE no_bukti='$no_tagih' AND kd_skpd='$kd_skpd' ORDER BY kd_kegiatan,kd_rek5,kd_rek_blud";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'idx'        => $ii,
                        'kdkegiatan' => $resulte['kd_kegiatan'],
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'kdrekblud'  => $resulte['kd_rek_blud'],  
                        'nmrekblud'  => $resulte['nm_rek_blud'],  
                        'nilai1'     => number_format($resulte['nilai'],"2",".",",")
                        );
                        $ii++;
        }
           
     return $result;
     $query1->free_result();  
	}
	
	
	function simpan_spp_ls($no_spp,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update,$rekanan,$bank,$pimpinan,$npwp,$rekening,$jns,$tagih,$alamat){
        $sql = "delete from trhsp2d_blud where kd_skpd='$skpd' and no_spp='$no_spp'";
            $asg = $this->db->query($sql);
            if ($asg){
				  $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,bulan,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$bln','$ket','$bank','$rekening','$npwp','$rekanan','$pimpinan','$nilai','$skpd','$usernm','$last_update','','','$tagih','$alamat')";
             $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdspp_blud where no_spp='$no_spp' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdspp_blud(no_spp,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans) values $lcnilaidet";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							if($jns=='6'){
								$sql = "UPDATE trhtagih_blud SET status='1' WHERE no_bukti='$tagih' AND kd_skpd='$skpd'";
								$asg = $this->db->query($sql); 
								if(!($asg)){
									$msg = '1';
									return $msg;
								}else{
									$msg = '2';
									return $msg;
								}
							}else{
								$msg = '2';
								return $msg;
							}
						}
                    }                
                }            
            }
	}
	
	function update_spp_ls($no_spp,$nohide,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update,$rekanan,$bank,$pimpinan,$npwp,$rekening,$jns,$tagih,$tagih_hide,$alamat){
        $sql = "DELETE from trhsp2d_blud where kd_skpd='$skpd' and no_spp='$nohide'";
            $asg = $this->db->query($sql);
            if ($asg){
				  $sql = "insert into trhsp2d_blud(no_spp,tgl_spp,status_spp,jns_spp,bulan,keterangan_spp,kd_bank,no_rek,npwp,rekanan,pimpinan,total,kd_skpd,username,last_update,no_spm,no_sp2d,no_tagih,alamat) 
					values ('$no_spp','$tgl','0','$bbn','$bln','$ket','$bank','$rekening','$npwp','$rekanan','$pimpinan','$nilai','$skpd','$usernm','$last_update','','','$tagih','$alamat')";
             $asg = $this->db->query($sql);
                if (!($asg)){
                    $msg = '0';
                    return $msg;
                }
                if ($asg){
                    $sql = "delete from trdspp_blud where no_spp='$nohide' AND kd_skpd='$skpd'";
                    $asg = $this->db->query($sql);    
                    if(!($asg)){
                        $msg = '0';
                        return $msg;
                    }else{
                        $sql = "insert into trdspp_blud(no_spp,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,no_trans) values $lcnilaidet";
						$asg = $this->db->query($sql); 
						if(!($asg)){
							$msg = '1';
							return $msg;
						}else{
							if($jns=='6'){
								$sql = "UPDATE trhtagih_blud SET status='0' WHERE no_bukti='$tagih_hide' AND kd_skpd='$skpd'";
								$asg = $this->db->query($sql); 
								$sql = "UPDATE trhtagih_blud SET status='1' WHERE no_bukti='$tagih' AND kd_skpd='$skpd'";
								$asg = $this->db->query($sql); 
								if(!($asg)){
									$msg = '1';
									return $msg;
								}else{
									$msg = '2';
									return $msg;
								}
							}else{
								$sql = "UPDATE trhtagih_blud SET status='0' WHERE no_bukti='$tagih_hide' AND kd_skpd='$skpd'";
								$asg = $this->db->query($sql); 
								$msg = '2';
								return $msg;
							}
						}
                    }                
                }            
            }
	}
	
	function load_spp_ls($kd_skpd,$kriteria){
		$where    = "and jns_spp IN ('5','6') ";
        if ($kriteria <> ''){                               
            $where="AND (upper(no_spp) like upper('%$kriteria%') or tgl_spp like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%') or upper(jns_spp) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT no_spp,tgl_spp,status_spp,kd_skpd,keterangan_spp,bulan,jns_spp,no_tagih,total,
				rekanan,pimpinan,kd_bank,no_rek,npwp,nama,alamat
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
                        'alamat'  =>$resulte['alamat'],
                        );
                        $ii++;
        }
           
        return $result;
    	$query1->free_result();    
	}
	
	function load_sum_tagih($tagih,$skpd){
		$query1 = $this->db->query("select sum(nilai) as rektotal from trdtagih_blud where no_bukti = '$tagih' AND kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'rektotal'  =>  $resulte['rektotal'],
                        'rektotal1' => $resulte['rektotal']                         
                        );
                        $ii++;
        }
		return $result;
        $query1->free_result();	 
	}
	
	function load_ttd($kd_skpd,$ttd){
		$sql = "SELECT * FROM ms_ttd_blud WHERE kd_skpd= '$kd_skpd' and kode='$ttd'";
        $mas = $this->db->query($sql);
        $ii = 0;        
        foreach($mas->result_array() as $resulte){ 
        $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }           
        return $result;
	}
	
	
	function cetakpengantarspp($skpd,$no_spp,$jns,$bk,$pa,$print,$spasi,$tanpa){
		//Pencarian Data 
		switch  ($jns){
			case  1:
			$beban = "UP";
			$uraian = "Uang Persediaan";
			break;
			case  2:
			$beban = "GU";
			$uraian = "Ganti Uang Persediaan";
			break;
			case  3:
			$beban = "TU";
			$uraian = "Tambah Uang Persediaan";
			break;
			case  4:
			$beban = "LS - Gaji";
			$uraian = "LS - Gaji";
			break;
			case  5:
			$beban = "LS - Barang dan Jasa";
			$uraian = "LS - Barang dan Jasa";
			break;
			case  6:
			$beban = "LS - Barang dan Jasa";
			$uraian = "LS - Barang dan Jasa";
			break;
		}
		$nm_skpd = $this->rka_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');	
		$tgl_spp = $this->rka_model->get_nama($no_spp,'tgl_spp','trhsp2d_blud','no_spp');	
		$tanggal = $this->tanggal_format_indonesia($tgl_spp);
		$thn_ang = $this->session->userdata('pcThang');
		
		$sqlskpd="SELECT a.bank, a.rekening, a.kd_urusan,a.alamat,a.kop,a.daerah,
				(SELECT nama FROM ms_bank_blud b WHERE b.kode=a.bank) as nm_bank,
				(SELECT nm_urusan FROM ms_urusan_blud c WHERE c.kd_urusan=a.kd_urusan) as nm_urusan
				FROM ms_skpd_blud a WHERE kd_skpd = '$skpd'";
		$sqlskpd=$this->db->query($sqlskpd);
		foreach ($sqlskpd->result() as $rowskpd){
			$bank		= $rowskpd->nm_bank;                    
			$rekening	= $rowskpd->rekening;
			$kd_urusan	= $rowskpd->kd_urusan;
			$nm_urusan	= $rowskpd->nm_urusan;
			$kop		= $rowskpd->kop;
			$daerah		= $rowskpd->daerah;
		}
		
		$sqlspp="SELECT SUM(b.total) as nilai, SUM(b.total_sempurna) as nilai_sempurna,SUM(b.total_ubah) as nilai_ubah,
			(SELECT SUM(nilai) as nilai FROM( SELECT SUM(a.nilai) as nilai FROM trdtransout_blud a INNER JOIN trhtransout_blud b 
			ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
			WHERE LEFT(kd_rek5,1)='5' AND a.kd_skpd='$skpd'
			AND jns_spp='1'
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
			WHERE jns_spp IN ('3','4','5','6') AND LEFT(a.kd_rek5,1)='5' AND a.kd_skpd='$skpd'
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdtagih_blud a INNER JOIN trhtagih_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
			WHERE LEFT(a.kd_rek5,1)='5' AND a.kd_skpd='$skpd'
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$skpd')  
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhtransout_blud WHERE kd_skpd='$skpd')  
			) c) as lalu
			FROM trdrka_blud a LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
			WHERE LEFT(a.kd_rek5,1)='5' AND a.kd_skpd='$skpd'";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$anggaran=$rowspp->nilai_ubah;                    
			$lalu=$rowspp->lalu; 
			$sisa = $anggaran - $lalu;	
		}
		
		$sqlspp="SELECT SUM(nilai) as nilai FROM trdspp_blud WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$nilai=$rowspp->nilai;                    
		}
		
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where nip='$bk' and kode = 'BK' AND kd_skpd = '$skpd'";
		$sqlttd=$this->db->query($sqlttd1);
		foreach ($sqlttd->result() as $rowttd){
			$nip=$rowttd->nip;                    
			$nama= $rowttd->nm;
			$jabatan  = $rowttd->jab;
			$pangkat  = $rowttd->pangkat;
		}
		
		
		
		
		//Pembuatan Cetakan
		$cRet='';
		$cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong>".strtoupper($kop)." </strong></td></tr>
                    <tr><td align=\"center\"><strong>SURAT PERMINTAAN PEMBAYARAN </strong></td></tr>
                    <tr><td align=\"center\"><strong>(SPP ".strtoupper($beban).")</strong></td></tr>                              
                    <tr><td align=\"center\"><strong>$no_spp</strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"><strong>SURAT PENGANTAR</strong></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"left\">Kepada Yth.</td></tr>
                    <tr><td align=\"left\">Pemimpin BLUD</td></tr>
                    <tr><td align=\"left\">$nm_skpd</td></tr>
                    <tr><td align=\"left\">Di Tempat</td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"center\"></td></tr>
                    <tr><td align=\"left\">Dengan Memperhatikan RAB BLUD $nm_skpd, bersama ini kami mengajukan Surat Permintaan Pembayaran $uraian sebagai berikut:</td></tr>
                    <tr><td align=\"center\"></td></tr>
                  </table>";
				  
		$cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"$spasi\">";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">a.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Urusan Pemerintahan</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">$kd_urusan - $nm_urusan</td></tr>";				
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">b.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">SKPD</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">$nm_skpd</td></tr>";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">c.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Tahun Anggaran</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">$thn_ang</td></tr>";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">d.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Pagu Anggaran</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">".number_format ( $anggaran, "2", ".", "," )."</td></tr>";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">e.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Jumlah Sisa Anggaran</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">".number_format ( $sisa, "2", ".", "," )."</td></tr>";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">f.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Nama Bendahara Pengeluaran BLUD</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">$nama</td></tr>";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">g.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Jumlah Pembayaran Yang Diminta</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">".number_format ( $nilai, "2", ".", "," )."</td></tr>";
		$cRet .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">h.</td>                                     
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">Nama dan Nomor Rekening Bank</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\">:</td>
					 <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"70%\">$bank - $rekening</td></tr>
					 </table>";
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\"> $daerah,$tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"><b><u></u></b><br>
					  <br>
					</td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
				  
		if ($print=='0'){		  
			return $cRet;
		}else{
			$data = $this->tukd_model->_mpdf('',$cRet,10,10,10,'0'); 
			return $data;
		}
 
	}
	
	function cetakringkasanspp($skpd,$no_spp,$jns,$bk,$pa,$print,$spasi,$tanpa){
		//Pencarian Data 
		switch  ($jns){
			case  1:
			$beban = "UP";
			$uraian = "Uang Persediaan";
			break;
			case  2:
			$beban = "GU";
			$uraian = "Ganti Uang Persediaan";
			break;
			case  3:
			$beban = "TU";
			$uraian = "Tambah Uang Persediaan";
			break;
			case  4:
			$beban = "LS - Gaji";
			$uraian = "LS - Gaji";
			break;
			case  5:
			$beban = "LS - Barang dan Jasa";
			$uraian = "LS - Barang dan Jasa";
			break;
			case  6:
			$beban = "LS - Barang dan Jasa";
			$uraian = "LS - Barang dan Jasa";
			break;
		}
		$nm_skpd = $this->rka_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');	
		$tgl_spp = $this->rka_model->get_nama($no_spp,'tgl_spp','trhsp2d_blud','no_spp');	
		$tanggal = $this->tanggal_format_indonesia($tgl_spp);
		$thn_ang = $this->session->userdata('pcThang');
		
		$sqlskpd="SELECT a.bank, a.rekening, a.kd_urusan,a.alamat,a.kop,a.daerah,
				(SELECT nama FROM ms_bank_blud b WHERE b.kode=a.bank) as nm_bank,
				(SELECT nm_urusan FROM ms_urusan_blud c WHERE c.kd_urusan=a.kd_urusan) as nm_urusan
				FROM ms_skpd_blud a WHERE kd_skpd = '$skpd'";
		$sqlskpd=$this->db->query($sqlskpd);
		foreach ($sqlskpd->result() as $rowskpd){
			$bank		= $rowskpd->nm_bank;                    
			$rekening	= $rowskpd->rekening;
			$kd_urusan	= $rowskpd->kd_urusan;
			$nm_urusan	= $rowskpd->nm_urusan;
			$kop		= $rowskpd->kop;
			$daerah		= $rowskpd->daerah;
		}
		$sqlskpd->free_result();
		
		$sqlskpd="SELECT no_dpa,tgl_dpa FROM trhrka_blud a WHERE kd_skpd = '$skpd'";
		$sqlskpd=$this->db->query($sqlskpd);
		foreach ($sqlskpd->result() as $rowskpd){
			$no_dpa		= $rowskpd->no_dpa;                    
			$tgl_dpa	= $this->tanggal_format_indonesia($rowskpd->tgl_dpa);
		}
		$sqlskpd->free_result();

		$sqlspp="SELECT LEFT(a.kd_kegiatan,18) as kd_program,a.kd_kegiatan,b.nm_program,b.nm_kegiatan FROM trdspp_blud a 
				LEFT JOIN trskpd_blud b ON LEFT(a.kd_kegiatan,18) = b.kd_program AND a.kd_kegiatan=b.kd_kegiatan
				AND a.kd_skpd=b.kd_skpd
				WHERE a.no_spp='$no_spp' AND a.kd_skpd = '$skpd'
				GROUP BY LEFT(a.kd_kegiatan,18),a.kd_kegiatan,b.nm_program,b.nm_kegiatan";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$kd_kegiatan	= $rowspp->kd_kegiatan;                    
			$nm_kegiatan	= $rowspp->nm_kegiatan;                    
			$kd_program		= $rowspp->kd_program;                    
			$nm_program		= $rowspp->nm_program;                    
		}
		$sqlspp->free_result();
		
		$sqlspp="SELECT rekanan,alamat,
				(CASE WHEN a.jns_spp IN ('5','6') THEN LEFT(rekanan,2) ELSE ' ' END) AS bentuk,
				(CASE WHEN a.jns_spp='6' THEN (SELECT kontrak FROM trhtagih_blud  WHERE no_bukti=a.no_tagih) ELSE '' END) as kontrak,
				alamat,pimpinan,kd_bank,b.nama as nm_bank,no_rek,keterangan_spp  FROM trhsp2d_blud a 
				LEFT JOIN ms_bank_blud b ON a.kd_bank = b.kode 
				WHERE a.no_spp='$no_spp' AND a.kd_skpd = '$skpd'
				";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$rekanan	= $rowspp->rekanan;                    
			$bentuk		= $rowspp->bentuk;                    
			$nm_bank	= $rowspp->nm_bank;                    
			$pimpinan	= $rowspp->pimpinan;                    
			$no_rek		= $rowspp->no_rek;                    
			$keterangan	= $rowspp->keterangan_spp;                    
			$alamat		= $rowspp->alamat;                    
			$kontrak	= $rowspp->kontrak;                    
		}
		$sqlspp->free_result();

		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where nip='$bk' and kode = 'BK' AND kd_skpd = '$skpd'";
		$sqlttd=$this->db->query($sqlttd1);
		foreach ($sqlttd->result() as $rowttd){
			$nip=$rowttd->nip;                    
			$nama= $rowttd->nm;
			$jabatan  = $rowttd->jab;
			$pangkat  = $rowttd->pangkat;
		}
		$sqlttd->free_result();
		
		$sqlspp="SELECT SUM(b.total) as nilai, SUM(b.total_sempurna) as nilai_sempurna,SUM(b.total_ubah) as nilai_ubah
			FROM trdrka_blud a LEFT JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka
			WHERE LEFT(a.kd_rek5,1)='5' AND a.kd_skpd = '$skpd'";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$anggaran=$rowspp->nilai_ubah;                    
		}
		$sqlspp->free_result();
		
		$sqlspp="select SUM(b.rupiah) as terima FROM trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
			WHERE a.kd_skpd = '$skpd' and a.tgl_sts<='$tgl_spp'";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$terima=$rowspp->terima;                    
		}
		$sqlspp->free_result();
		
		
		
		$sqlspp="SELECT SUM(nilai) as nilai FROM(
			SELECT SUM(a.nilai) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
			WHERE  LEFT(kd_rek5,1)='5' and b.no_tagih='' and b.tgl_kas<='$tgl_spp'
			UNION ALL
			SELECT SUM(a.nilai) as nilai FROM trdtagih_blud a INNER JOIN trhtagih_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
			WHERE LEFT(a.kd_rek5,1)='5' and b.tgl_bukti<='$tgl_spp' and b.kd_skpd='$skpd'
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhsp2d_blud WHERE kd_skpd='$skpd'  and tgl_kas<='$tgl_spp')  
			AND b.no_bukti NOT IN (select ISNULL(no_tagih,'') FROM trhtransout_blud WHERE kd_skpd='$skpd'   and tgl_bukti<='$tgl_spp')  
			) c ";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$keluar=$rowspp->nilai;                    
		}
		$sqlspp->free_result();
		$kasbend = $keluar;
		$total_kas = $anggaran - $kasbend;
	
	
		$sqlspp="select isnull(sum(q.terima_spj-q.keluar_spj),0) kasben from (
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
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$kasblud=$rowspp->kasben;                    
		}
		$sqlspp->free_result();
		$total_kas = $anggaran - $kasblud;
		
		
		$sqlspp="SELECT 
		SUM(CASE WHEN b.jns_spp IN ('1','2') THEN a.nilai ELSE 0 END) as up, 
		SUM(CASE WHEN b.jns_spp IN ('3') THEN a.nilai ELSE 0 END) as tu, 
		SUM(CASE WHEN b.jns_spp IN ('4') THEN a.nilai ELSE 0 END) as gj, 
		SUM(CASE WHEN b.jns_spp IN ('5','6') THEN a.nilai ELSE 0 END) as ls 
		FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON b.no_spp=a.no_spp and b.kd_skpd = a.kd_skpd 
		WHERE a.kd_skpd='$skpd' AND tgl_sp2d <='$tgl_spp' AND a.no_spp !='$no_spp'";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$up=$rowspp->up;                    
			$tu=$rowspp->tu;                    
			$gj=$rowspp->gj;                    
			$ls=$rowspp->ls;                    
		}
		$sqlspp->free_result();
		$total_bel = $up+$tu+$gj+$ls;
		$total_sisa= $total_kas-$total_bel;
		
		$cRet='';
		$cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong>".strtoupper($kop)." </strong></td></tr>
                    <tr><td align=\"center\"><strong>SURAT PERMINTAAN PEMBAYARAN </strong></td></tr>
                    <tr><td align=\"center\"><strong>(SPP ".strtoupper($beban).")</strong></td></tr>                              
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"><strong>$no_spp</strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"><strong>RINGKASAN</strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"></td></tr>
                  </table>";
				  
		 $cRet .= "<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$spasi\"> ";
                    $cRet    .= " <tr><td colspan=\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\"  align=\"center\"><b>RINGKASAN KEGIATAN</b></td></tr> ";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >1. Program </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;font-size:12px\" width=\"18%\">: $kd_program - $nm_program</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >2. Kegiatan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black; \" width=\"18%\">: $kd_kegiatan - $nm_kegiatan </td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >3. Nomor dan Tanggal DPA/DPPA/DPPAL-SKPD </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $no_dpa - $tgl_dpa</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >4. Nama Perusahaan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $rekanan</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >5. Bentuk Perusahaan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $bentuk</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >6. Alamat Perusahaan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $alamat</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >7. Nama Pimpinan Perusahaan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $pimpinan</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >8. Nama dan No. Rek Bank </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $nm_bank - $no_rek</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >9. Nomor Kontrak </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: $kontrak</td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >10. Kegiatan Lanjutan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: Ya/Tidak </td></tr>";    
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >11. Waktu Pelaksanaan Kegiatan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;border-right: solid 1px black;\" width=\"18%\">: </td></tr>";
                    $cRet    .= " <tr><td colspan=\"2\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:solid 1px black;border-right: none;\" width=\"2%\" align=\"left\" >12. Deskripsi Pekerjaan </td>
                                     <td colspan=\"3\" style=\"vertical-align:top;border-top: none;border-bottom: none;horizontal-align:left;border-left:none;font-size:8 px;border-right: solid 1px black;\" width=\"18%\">: <pre>$keterangan</pre></td></tr>";		  
					$cRet    .= " <tr><td colspan=\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\"  align=\"center\"><b>RINGKASAN RAB</b></td></tr> ";                                    
                    $cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"left\">Jumlah dana RAB </td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $anggaran, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">(I)</td> </tr>";  
					$cRet    .= "  <tr><td colspan=\"5\" style=\"vertical-align:center;border-top: solid 1px black;border-bottom: none;\"  align=\"center\"><b>RINGKASAN DANA YANG TERSEDIA</b></td></tr> ";
                    $cRet    .= " <tr><td style=\"valign:center;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"center\">No. Urut</td>                                     
                                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: none;\" width=\"38%\" align=\"center\">Uraian</td>
                                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: none;\" width=\"32%\" align=\"center\">Tanggal Dokumen</td>
                                     <td style=\"valign:center;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"center\">Jumlah Dana</td>
                                     <td style=\"valign:center;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
					$cRet    .= " <tr><td style=\"valign:center;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"center\">1</td>                                     
                                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: none;\" width=\"38%\" align=\"center\">Rek. Kas BLUD</td>
                                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: none;\" width=\"32%\" align=\"center\">$tanggal</td>
                                     <td style=\"valign:center;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $kasblud, "2", ".", "," )."</td>
                                     <td style=\"valign:center;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
					$cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"right\"><i>JUMLAH</i> </td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $kasblud, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">(II)</td>
									 </tr>";                                                                         
                    $cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"right\"><i>Sisa dana yang belum tersedia</i> </td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $total_kas, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
                    $cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"right\">&nbsp;</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>"; 
					$cRet    .= " <tr><td colspan=\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\"  align=\"center\"><b>RINGKASAN BELANJA</b></td></tr> ";
                    $cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"left\">Belanja UP/GU</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $up, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
					$cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"left\">Belanja TU</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $tu, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
					$cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"left\">Belanja LS-Gaji</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $gj, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
					$cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"left\">Belanja LS-Barang Jasa</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $ls, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
					$cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"2%\" align=\"right\"><i>JUMLAH</i></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $total_bel, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">(III)</td>
									 </tr>";
                    $cRet    .= " <tr><td colspan=\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"2%\" align=\"right\"><i>Sisa Dana tersedia, belum dibelanjakan (II-III)</i></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-right: none;\" width=\"18%\" align=\"right\">".number_format ( $total_sisa, "2", ".", "," )."</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-left: none;\" width=\"3%\" align=\"right\">&nbsp;</td>
									 </tr>";
		$cRet .="</table>";
		$cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\"> $daerah,$tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"><b><u></u></b><br>
					  <br>
					</td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
				  
		if ($print=='0'){		  
			return $cRet;
		}else{
			$data = $this->tukd_model->_mpdf('',$cRet,10,10,10,'0'); 
			return $data;
		}
 
	}
		
	function cetakrincianspp($skpd,$no_spp,$jns,$bk,$pa,$print,$spasi,$tanpa){
		//Pencarian Data 
		switch  ($jns){
			case  1:
			$beban = "UP";
			$uraian = "Uang Persediaan";
			break;
			case  2:
			$beban = "GU";
			$uraian = "Ganti Uang Persediaan";
			break;
			case  3:
			$beban = "TU";
			$uraian = "Tambah Uang Persediaan";
			break;
			case  4:
			$beban = "LS - Gaji";
			$uraian = "LS - Gaji";
			break;
			case  5:
			$beban = "LS - Barang dan Jasa";
			$uraian = "LS - Barang dan Jasa";
			break;
			case  6:
			$beban = "LS - Barang dan Jasa";
			$uraian = "LS - Barang dan Jasa";
			break;
		}
		$nm_skpd = $this->rka_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');	
		$tgl_spp = $this->rka_model->get_nama($no_spp,'tgl_spp','trhsp2d_blud','no_spp');	
		$tanggal = $this->tanggal_format_indonesia($tgl_spp);
		$thn_ang = $this->session->userdata('pcThang');
		
		$sqlskpd="SELECT a.bank, a.rekening, a.kd_urusan,a.alamat,a.kop,a.daerah,
				(SELECT nama FROM ms_bank_blud b WHERE b.kode=a.bank) as nm_bank,
				(SELECT nm_urusan FROM ms_urusan_blud c WHERE c.kd_urusan=a.kd_urusan) as nm_urusan
				FROM ms_skpd_blud a WHERE kd_skpd = '$skpd'";
		$sqlskpd=$this->db->query($sqlskpd);
		foreach ($sqlskpd->result() as $rowskpd){
			$bank		= $rowskpd->nm_bank;                    
			$rekening	= $rowskpd->rekening;
			$kd_urusan	= $rowskpd->kd_urusan;
			$nm_urusan	= $rowskpd->nm_urusan;
			$kop		= $rowskpd->kop;
			$daerah		= $rowskpd->daerah;
		}
		
		
		
		$sqlspp="SELECT SUM(nilai) as nilai FROM trdspp_blud WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'";
		$sqlspp=$this->db->query($sqlspp);
		foreach ($sqlspp->result() as $rowspp){
			$nilai=$rowspp->nilai;                    
		}
		
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where nip='$bk' and kode = 'BK' AND kd_skpd = '$skpd'";
		$sqlttd=$this->db->query($sqlttd1);
		foreach ($sqlttd->result() as $rowttd){
			$nip=$rowttd->nip;                    
			$nama= $rowttd->nm;
			$jabatan  = $rowttd->jab;
			$pangkat  = $rowttd->pangkat;
		}
		
		
		$cRet='';
		$cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong>".strtoupper($kop)." </strong></td></tr>
                    <tr><td align=\"center\"><strong>SURAT PERMINTAAN PEMBAYARAN </strong></td></tr>
                    <tr><td align=\"center\"><strong>(SPP ".strtoupper($beban).")</strong></td></tr>                              
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"><strong>$no_spp</strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"><strong>RINCIAN RENCANA PENGGUNAAN</strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                    <tr><td align=\"center\"></td></tr>
                  </table>";
		$cRet .= "<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$spasi\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>No Urut</b></td>                            
                            <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Kode Rekening</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"60%\" align=\"center\"><b>Uraian</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Jumlah</b></td>  
						</tr>
                     </thead>
					";

		if(($jns=='1')||($jns=='2')){
			$total=$nilai;
			$cRet .= "<tr>
					<td align='center'>1</td>
					<td></td>
					<td>Rekening Kas di Bendahara BLUD </td>
					<td align='right'>".number_format ( $nilai, "2", ".", "," )."</td>
					</tr>";
			}else{
			$total=0;	
			$i=0;
			$sqldet="
			SELECT 0 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,left(a.kd_rek5,0) kd_baru,c.nm_kegiatan nm_rek_blud,a.nilai FROM trdspp_blud a left join m_giat_blud c on a.kd_kegiatan = c.kd_kegiatan WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'
			union all
			SELECT 1 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,left(a.kd_rek5,1) kd_baru,c.nm_rek1 nm_rek_blud,a.nilai FROM trdspp_blud a left join ms_rek1 c on left(a.kd_rek5,1) = c.kd_rek1 WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'
			union all
			SELECT 2 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,left(a.kd_rek5,2) kd_baru,c.nm_rek2 nm_rek_blud,a.nilai FROM trdspp_blud a left join ms_rek2 c on left(a.kd_rek5,2) = c.kd_rek2 WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'
			union all
			SELECT 3 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,left(a.kd_rek5,3) kd_baru,c.nm_rek3 nm_rek_blud,a.nilai FROM trdspp_blud a left join ms_rek3 c on left(a.kd_rek5,3) = c.kd_rek3 WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'
			union all
			SELECT 4 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,left(a.kd_rek5,5) kd_baru,c.nm_rek4 nm_rek_blud,a.nilai FROM trdspp_blud a left join ms_rek4 c on left(a.kd_rek5,5) = c.kd_rek4 WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'
			union all
			SELECT 5 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,a.kd_rek5 kd_baru,c.nm_rek5 nm_rek_blud,a.nilai FROM trdspp_blud a left join ms_rek5 c on a.kd_rek5 = c.kd_rek5 WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'
			union all
			SELECT 6 as kode, a.kd_kegiatan,a.kd_rek5,a.kd_rek_blud,a.kd_rek5+c.plus_ang kd_baru,a.nm_rek_blud,a.nilai FROM trdspp_blud a left join ms_rek5_blud c on a.kd_rek_blud = c.kd_rek5 WHERE no_spp='$no_spp' AND kd_skpd = '$skpd'";
			$sqldet=$this->db->query($sqldet);
			foreach ($sqldet->result() as $rowdet){
			$kd_kegiatan=$rowdet->kd_kegiatan;
			$kd_rek_blud=$rowdet->kd_rek_blud;
			$kd_baru=$rowdet->kd_baru;
			$nm_rek=$rowdet->nm_rek_blud;
			$nilai=$rowdet->nilai;
			$total=$total+$nilai;
			$i=$i+1;
			$cRet .= "<tr>
					<td align='center'>$i</td>
					<td>$kd_kegiatan.$kd_baru</td>
					<td>$nm_rek </td>
					<td align='right'>".number_format ( $nilai, "2", ".", "," )."</td>
					</tr>";	
				}
			}
		$cRet .= "<tr>
					<td align='center'></td>
					<td></td>
					<td align='right'>Total &nbsp;</td>
					<td align='right'>".number_format ( $total, "2", ".", "," )."</td>
					</tr>";
		$cRet .="</table>";
		$cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\"> $daerah,$tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"><b><u></u></b><br>
					  <br>
					</td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
				  
		if ($print=='0'){		  
			return $cRet;
		}else{
			$data = $this->tukd_model->_mpdf('',$cRet,10,10,10,'0'); 
			return $data;
		}
 
	}
	
}