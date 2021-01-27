<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class Tukd_laporan extends CI_Controller {

	function __construct()
	{	
		parent::__construct();

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
				case 11:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,2);								
        		break;
				case 12:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,3);								
        		break;
                case 29:
					$rek = $this->left($rek,21).'.'.substr($rek,23,1).'.'.substr($rek,24,1).'.'.substr($rek,25,1).'.'.substr($rek,26,2).'.'.substr($rek,28,2);								
        		break;
    			default:
				$rek = "";	
				}
				return $rek;
    }
    
    function ttd_pa($tp='') {
       
        $sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd_blud where kode='PA' and kd_skpd='$tp'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {  
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan'],
                        'kd_skpd' => $resulte['kd_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
        $query1->free_result();    
    }

     function ttd_bk($tp='') {
       
        $sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd_blud where kode='BK' and kd_skpd='$tp'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {  
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan'],
                        'kd_skpd' => $resulte['kd_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
        $query1->free_result();    
    }

    function ttd_bp($tp='') {
       
        $sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd_blud where kode='BP' and kd_skpd='$tp'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {  
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan'],
                        'kd_skpd' => $resulte['kd_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
        $query1->free_result();    
    }

    function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

        }
         
        function  tanggal_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = substr($tgl,5,2);
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.'-'.$bulan.'-'.$tahun;

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

     function ttd()
    {
        $lccr = $this->input->post('q');
        $skpd =$this->session->userdata('kdskpd');
        $sql = "SELECT id_urut,nip, nama, jabatan,pangkat FROM ms_ttd_blud where (kd_skpd='$skpd' and kode='PA') and (upper(kd_skpd) like upper('%$lccr%') or upper(nama) like upper('%$lccr%')) ";
        $query1 = $this->db->query($sql);
        $result = array();
        $ii = 0;
        foreach ($query1->result_array() as $resulte)
        {

            $result[] = array('id' => $ii, 'urut' => $resulte['id_urut'],'nip' => $resulte['nip'], 'nama' => $resulte['nama'], 'jabatan' => $resulte['jabatan'], 'pangkat' => $resulte['pangkat'], );
            $ii++;
        }

        echo json_encode($result);
    }

        function ttd_tim(){
        $lccr = $this->input->post('q');
        $skpd =$this->session->userdata('kdskpd');
        $sql = "SELECT id_urut,nip, nama, jabatan,pangkat FROM ms_ttd_blud where (kd_skpd='$skpd' and kode='BK') and (upper(kd_skpd) like upper('%$lccr%') or upper(nama) like upper('%$lccr%')) ";
        $query1 = $this->db->query($sql);
        $result = array();
        $ii = 0;
        foreach ($query1->result_array() as $resulte)
        {

            $result[] = array('id' => $ii,'urut' => $resulte['id_urut'],'nip' => $resulte['nip'], 'nama' => $resulte['nama'], 'jabatan' => $resulte['jabatan'], 'pangkat' => $resulte['pangkat'], );
            $ii++;
        }

        echo json_encode($result);
    }



    function cetak_register_penerimaan_blud($convert='',$ctgl1='',$ctgl2='',$nipang='',$nipbp=''){
        $skpd = $this->session->userdata('kdskpd');
        $indotgl1=$this->tanggal_format_indonesia($ctgl1);
        $indotgl2=$this->tanggal_format_indonesia($ctgl2);

         $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }
        $cRet = '';
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\"><b>
                  $kab<br>
                  LAPORAN REGISTER PENERIMAAN BLUD <br>
                  </b>
                </td>

            </tr>
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">&nbsp;
                </td>
                
            </tr>
            </table>";
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                         <td width=\"5%\">Periode $indotgl1 s.d $indotgl2</font></td>
                        
                    </tr> 
                   

                    </table>";

         $cRet    .="<table style=\"border-collapse:collapse; font-size:18px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <thead>
                        <tr>
                             <td width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>No. Terima<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Tanggal</b></td>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Keterangan<b></td>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Penyetor<b></td>
                             <td width=\"12%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Kode<br>Rekening<b></td>
                             <td width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Nama<br>Rekening<b></td>
                             <td width=\"12%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Total<br>(Rp.)<b></td>
                        </tr>
                        
                        <tr>
                         <td align=\"center\">1</td>
                         <td align=\"center\">2</td>
                         <td align=\"center\">3</td>
                         <td align=\"center\">4</td>
                         <td align=\"center\">5</td>
                         <td align=\"center\">6</td>
                         <td align=\"center\">7</td>
                         
                         
                    </tr>
                    </thead>
                    
                    ";
        $sql="SELECT a.no_terima, a.tgl_terima,a.nm_str,a.keterangan,a.kd_rek7,b.nm_rek7,sum(a.nilai) as nilai FROM tr_terima_blud_blud a 
        LEFT JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7` where a.kd_skpd='$skpd' and a.tgl_terima between '$ctgl1' and '$ctgl2' GROUP BY a.no_terima";
        $sqlp = $this->db->query($sql);
        $tot=0;
        foreach ($sqlp->result() as $row){
            $no_terima  =$row->no_terima;
            $tgl_terima =$this->tanggal_indonesia($row->tgl_terima);
            $keterangan =$row->keterangan;
            $nm_str     =$row->nm_str;
            $nilai      =$row->nilai;
            $cRet .= " <tr>
                     
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\" >$no_terima</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$tgl_terima</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$keterangan</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$nm_str</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">";
                    $sqlsdana ="SELECT kd_rek7 FROM tr_terima_blud_blud where no_terima='$no_terima'";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        
                        $kd_rek7 = $rows->kd_rek7;
                        $cRet    .= "$kd_rek7<br>";
                    }
                    
                    $cRet     .= "</td>

                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\">";
                    $sqlsdana ="SELECT a.kd_rek7,b.nm_rek7 FROM tr_terima_blud_blud a LEFT JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7` where a.no_terima='$no_terima' ";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        
                        $nm_rek7 = $rows->nm_rek7;
                        $cRet    .= "$nm_rek7<br>";
                    }
                    
                    $cRet     .= "</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"Right\">";
                      $sqlsdana ="SELECT a.kd_rek7,a.nilai FROM tr_terima_blud_blud a where a.no_terima='$no_terima' ";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        $pagu = number_format($rows->nilai,"2",",",".");
                        $cRet .= "$pagu<br>";
                    }
                    
                    $cRet     .= "</td><tr>";

                    $tot=$tot+$nilai;
                     


        }
        $cRet .="<tr>
                     
                     <td colspan=\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\" >Jumlah Keseluruhan</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" >".number_format($tot,"2",",",".")."</td>
                </tr>";

        $cRet .="</table>";

        $sql="select nip,nama,jabatan from ms_ttd_blud where id_urut='$nipang'";
        $query=$this->db->query($sql);
        foreach ($query->result() as $rowsc2)
                {
                    $jabatany =$rowsc2->jabatan;
                    $nama    = $rowsc2->nama;
                    $nip     = $rowsc2->nip;
                    
                }
        $sql_tim="select nip,nama,jabatan from ms_ttd_blud where id_urut='$nipbp'";
        $query=$this->db->query($sql_tim);
        foreach ($query->result() as $row)
                {
                    $jabatanx  =$row->jabatan;
                    $nama_tim = $row->nama;
                    $nip_tim  = $row->nip;
                    
                }
        $tglctk = date('Y-m-d');
        $cRet .="
        <table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >
        <tr>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
        </tr>
        <tr >                       
                <td align='center' colspan='2' width='50%'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td align='center' colspan='2' width='50%'>".$daerah.", ".$this->tanggal_format_indonesia($tglctk)."</td>         
        </tr>
       
        <tr>
                <td align='center' colspan='2' width='50%'><b>$jabatany<b></td>
                <td align='center' colspan='2' width='50%'><b>$jabatanx</b></td>
        </tr>
        <tr>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
        </tr>
         <tr>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
        </tr>
        <tr>
                <td align='center' colspan='2' width='50%'><b>(".$nama.")<b></td>
                <td align='center' colspan='2' width='50%'><b>(".$nama_tim.")</b></td>
        </tr>
        <tr>
                <td align='center' colspan='2' width='50%'><b>".$nip."<b></td>
                <td align='center' colspan='2' width='50%'><b>".$nip_tim."</b></td>
        </tr>
        </table>";

        $data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul = 'REGISTER PENERIMAAN BLUD';
        $this->template->set('title', 'REGISTER PENERIMAAN BLUD');
        

        switch ($convert)
        {
            case 1;
                $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");

                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
        }   

        }


        function cetak_bku_penerimaan_blud($convert='',$ctgl1='',$ctgl2='',$tgl_cetak='',$nipang='',$nipbp=''){
		$skpd         = $this->session->userdata('kdskpd');
		$nm_skpd      = $this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
		$indotgl1     = $this->tanggal_format_indonesia($ctgl1);
		$indotgl2     = $this->tanggal_format_indonesia($ctgl2);
		$cetaktanggal = $this->tanggal_format_indonesia($tgl_cetak);

        $sqlsc="SELECT kd_skpd,alamat,telp,faks,daerah FROM sclient2_blud where kd_skpd='$skpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                {
                  
                    $daerah  = $rowsc->daerah;
                    $alamat  = $rowsc->alamat;
                    $telp    = $rowsc->telp;
                    $faks    = $rowsc->faks;
                  
                }
         $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }
        $cRet = '';

        $cRet  .="<table style=\"border-collapse:collapse;\" width=\"100%\"  align=\"center\" style=\"border-bottom:4px double black\" cellspacing=\"0\" cellpadding=\"4\">
                <tr>
                        <td width=\"10%\" rowspan=\"4\" align=\"left\">
                                <img src=\"" . base_url() . "/image/logo.png\" width=\"110 px\"height=\"120 px\" />

                        </td>
                        <td width=\"80%\" align=\"center\"  font-size=\"13 px\">
                                <h2>$kab </strong> </strong>
                                <br><strong>$nm_skpd</h2>
                                   </br>$alamat<br>
                                Telepon $telp Faks $faks</br>
                               
                               
                        </td>
                </tr>
        </table><br>";

        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\"><b>
                  $kab<br>
                  LAPORAN BKU PENERIMAAN BLUD<br>
                  </b>
                </td>

            </tr>
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">&nbsp;
                </td>
                
            </tr>
            </table>";
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                         <td width=\"5%\">SKPD</td>
                         <td width=\"5%\">: $skpd - $nm_skpd</td>  
                    </tr> 
                    <tr>
                         <td width=\"5%\">Periode</td>
                         <td width=\"5%\">: $indotgl1 s.d $indotgl2</td>
                    </tr>
                    <tr>
                         <td width=\"5%\">&nbsp;</td>
                         <td width=\"5%\">&nbsp;</td>
                    </tr>
                   

                    </table>";


         $cRet    .="<table style=\"border-collapse:collapse; font-size:18px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <thead>
                        <tr>
                             <td rowspan=\"2\" width=\"5%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>No<b></td>
                             <td  colspan =\"6\" width=\"60%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Penerimaan</b></td>
                             <td  colspan =\"3\" width=\"30%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Penyetoran<b></td>
                             <td rowspan=\"2\" width=\"5%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Ket<b></td>
                             
                        </tr>

                        <tr>
                             <td width=\"7%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Tgl<b></td>
                             <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>No. Bukti</b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Cara <br>Pembayaran<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Kode<br>Rekening<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Uraian<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Jumlah</b></td>
                             
                             <td width=\"5%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Tgl<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>No. STS<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Jumlah<b></td>
                             
                        </tr>

                        <tr>
                             <td align=\"center\">1</td>
                             <td align=\"center\">2</td>
                             <td align=\"center\">3</td>
                             <td align=\"center\">4</td>
                             <td align=\"center\">5</td>
                             <td align=\"center\">6</td>
                             <td align=\"center\">7</td>
                             <td align=\"center\">8</td>
                             <td align=\"center\">9</td>
                             <td align=\"center\">10</td>
                             <td align=\"center\">11</td>
                             
                        </tr>
                        
                       
                    </thead>";

        $sql="SELECT a.no_terima, a.tgl_terima,a.nm_str,a.keterangan,a.kd_rek7,b.nm_rek7,sum(a.nilai) as nilai FROM tr_terima_blud_blud a 
        LEFT JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7` where a.kd_skpd='$skpd' and a.tgl_terima between '$ctgl1' and '$ctgl2' GROUP BY a.no_terima order by a.tgl_terima ";
        $sqlp = $this->db->query($sql);
        $no=0;
        $nilai_pend=0;
        foreach ($sqlp->result() as $row){
			$no         = $no+1;
			$no_terima  =$row->no_terima;
			$no_sts     =str_replace("TRM", "STS", $no_terima);
			$tgl_terima =$this->tanggal_indonesia($row->tgl_terima);

			$nilai_pend =$nilai_pend+$row->nilai;
			$nilai      =number_format($row->nilai);
            $cRet .= " <tr>
                     
                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\">$no</td>
                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$tgl_terima</td>
                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$no_terima</td>
                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">";
                    $sqlsdana ="SELECT kd_rek7 FROM tr_terima_blud_blud where no_terima='$no_terima'";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        
                        $kd_rek7 = $rows->kd_rek7;
                        $cRet    .= "<li>$kd_rek7<br>";
                    }
                    
                    $cRet     .= "</td>

                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\">";
                    $sqlsdana ="SELECT a.kd_rek7,b.nm_rek7 FROM tr_terima_blud_blud a LEFT JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7` where a.no_terima='$no_terima' ";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        
                        $nm_rek7 = $rows->nm_rek7;
                        $cRet    .= "$nm_rek7<br>";
                    }
                    
                    $cRet     .= "</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"Right\">";
                      $sqlsdana ="SELECT a.kd_rek7,a.nilai FROM tr_terima_blud_blud a where a.no_terima='$no_terima' ";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        $pagu = number_format($rows->nilai,"2",",",".");
                        $cRet .= "$pagu<br>";
                    }
                    
                    $cRet     .= "</td>

                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>";
        

        $no = $no+1;

        $cRet .= " <tr>
                     
                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\">$no</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\"></td>

                     <td style=\"valign:center;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$tgl_terima</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$no_sts</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\">$nilai</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\"></td>";
        }
        
        $cRet   .="</table>";

        $cRet .=" <table border=\"0\" width=\"35%\">";
        $t_sald=0- 0 ;
        /*foreach ($query3->result() as $row3){
                 $j_saldo_bank=0;
                 $j_saldo=0;
                 $j_saldo_tunai=0;
                 }*/
        $cRet    .= " <tr>
                            <td align=\"center\" width=\"5%\">&nbsp;</td>
                            <td align=\"center\" width=\"50%\"></td>
                            <td align=\"center\" width=\"15%\"></td>
                            <td align=\"center\" width=\"30%\"></td>
                   
                     </tr>
                     <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">Jumlah Penerimaan </td>
                    <td style=\"font-size:12px;\" align=\"right\" width=\"5%\">".number_format($nilai_pend,"2",",",".")."</td>
                    
                     </tr>
                      <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">Jumlah yang disetorkan </td>
                    <td style=\"font-size:12px;\" align=\"right\" width=\"5%\">".number_format($nilai_pend,"2",",",".")."</td>
                
                     </tr>
                      <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">Saldo Kas di Bendahara Penerimaan </td>
                    <td style=\"font-size:12px;\" align=\"right\" width=\"5%\">".number_format(0,"2",",",".")."</td>
                     </tr>
                      <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">Terdiri Atas :</td>
                    <td style=\"font-size:12px;\" align=\"left\" width=\"5%\"></td>
                    
                     </tr>
                     <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">&nbsp;&nbsp;&nbsp;a. Tunai Sebesar</td>
                    <td style=\"font-size:12px;\" align=\"right\" width=\"5%\">".number_format(0,"2",",",".")."</td>
                    
                     </tr>
                     <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">&nbsp;&nbsp;&nbsp;b. Bank Sebesar</td>
                    <td style=\"font-size:12px;\" align=\"right\" width=\"5%\">".number_format(0,"2",",",".")."</td>
                    
                     </tr>
                     <tr>
                    <td style=\"font-size:12px;\" align=\"left\"  colspan=\"3\" width=\"5%\">&nbsp;&nbsp;&nbsp;c. Lainnya</td>
                    <td style=\"font-size:12px;\" align=\"right\" width=\"5%\"></td>
                    
                     </tr>
                    ";  
         $cRet .=" </table>";

        $sql="select nip,nama,jabatan from ms_ttd_blud where id_urut='$nipang'";
        $query=$this->db->query($sql);
        foreach ($query->result() as $rowsc2)
                {
                    $jabatany =$rowsc2->jabatan;
                    $nama    = $rowsc2->nama;
                    $nip     = $rowsc2->nip;
                    
                }
        $sql_tim="select nip,nama,jabatan from ms_ttd_blud where id_urut='$nipbp'";
        $query=$this->db->query($sql_tim);
        foreach ($query->result() as $row)
                {
                    $jabatanx  =$row->jabatan;
                    $nama_tim = $row->nama;
                    $nip_tim  = $row->nip;
                    
                }

        $cRet .=" <table width=\"100%\">
         ";     
        $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\">&nbsp;</td>
                    <td align=\"center\" width=\"50%\"></td>
                     </tr>";
            $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\">Mengetahui</td>
                    <td align=\"center\" width=\"50%\">$daerah, $cetaktanggal</td>
                     </tr>";
            $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\">Pengguna Anggaran</td>
                    <td align=\"center\" width=\"50%\">Bendahara Penerimaan</td>
                    
                     </tr>";
            $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\">&nbsp;</td>
                    <td align=\"center\" width=\"50%\">&nbsp;</td>
                    
                     </tr>";         
            $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\">&nbsp;</td>
                    <td align=\"center\" width=\"50%\">&nbsp;</td>
                    
                     </tr>";         
            $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\"><b><u>$nama</u></td>
                    <td align=\"center\" width=\"50%\"><b><u>$nama_tim</u></td>
                    
                     </tr>";
            $cRet    .= " <tr>
                    <td align=\"center\" width=\"50%\">$nip</td>
                    <td align=\"center\" width=\"50%\">$nip_tim</td>
                    
                     </tr>";            
                             
                     
        $cRet .=" </table>";         




        $data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul = 'REGISTER PENERIMAAN BLUD';
        $this->template->set('title', 'REGISTER PENERIMAAN BLUD');
        

        switch ($convert)
        {
            case 1;
                $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");

                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
        }   

    }

     function cetak_bku_pengeluaran_blud($convert='',$bulan='',$tgl_cetak='',$nipang='',$nipbp=''){
        $skpd         = $this->session->userdata('kdskpd');
        $nm_skpd      = $this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        //$cetaktanggal = $this->tanggal_format_indonesia($tgl_cetak);
        $nbulan       = $this->tukd_model->getBulan($bulan);
        $thn          = $this->session->userdata('pcThang');
        $nipang = str_replace('123456789',' ',$nipang);
        $nipbp = str_replace('123456789',' ',$nipbp);
        
        
        
        $sqlsc="SELECT kd_skpd,alamat,telp,faks,daerah FROM sclient2_blud where kd_skpd='$skpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                {
                  
                    $daerah  = $rowsc->daerah;
                    $alamat  = $rowsc->alamat;
                    $telp    = $rowsc->telp;
                    $faks    = $rowsc->faks;
                  
                }


        $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $daerah = $rowsc->daerah;
               }

       $sql_tim="select nip,nama,jabatan,pangkat from ms_ttd_blud where nip='$nipbp'";
        $query=$this->db->query($sql_tim);
        foreach ($query->result() as $row)
                {
                    $jabatan_tim  =$row->jabatan;
                    $nama_tim = $row->nama;
                    $nip_tim  = $row->nip;
                    $pangkat_tim  = $row->pangkat;
                    
                    
                }
                
        $sql="select nip,nama,jabatan,pangkat from ms_ttd_blud where nip='$nipang'";
        $query=$this->db->query($sql);
        foreach ($query->result() as $rowsc2)
                {
                    $jabatan =$rowsc2->jabatan;
                    $nama    = $rowsc2->nama;
                    $nip     = $rowsc2->nip;
                    $pangkat  = $rowsc2->pangkat;
                    
                }

        $cRet = '';
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\"  align=\"center\" style=\"border-bottom:4px double black\" cellspacing=\"0\" cellpadding=\"4\">
                <tr>
                    <td width=\"10%\" rowspan=\"4\" align=\"left\">
                            <img src=\"" . base_url() . "/image/logo.png\" width=\"110 px\"height=\"120 px\" />
                    </td>
                    <td width=\"80%\" align=\"center\"  font-size=\"12 px\">
                            <h2><b>$kab</b> <br><b>$nm_skpd<b><br></h2>
                            <h3>BUKU KAS UMUM PENGELUARAN
                            <br> BULAN ".strtoupper($nbulan)." $thn</h3>
                             
                    </td>
                </tr>
        </table><br>";
        $cRet .="<table style='border-collapse:collapse;' width='100%' align='center' cellspacing='2' cellpadding='2' border='1'>
        <tr>
        <td bgcolor='#CCCCCC' align='center' width='5%'><b>No</b></td>
        <td bgcolor='#CCCCCC' align='center' width='10%'><b>Tanggal</b></td>
        <td bgcolor='#CCCCCC' align='center' width='10%'><b>Kode Rekening</b></td>
        <td bgcolor='#CCCCCC' align='center' width='30%'><b>Uraian</b></td>
        <td bgcolor='#CCCCCC' align='center' width='10%'><b>Penerimaan</b></td>
        <td bgcolor='#CCCCCC' align='center' width='10%'><b>Pengeluaran</b></td>
        <td bgcolor='#CCCCCC' align='center' width='10%'><b>Saldo</b></td>
        </tr>";

                    
        
        
        
        $sqlsc="SELECT sum(saldo_lalu)  n_saldo_lalu FROM ms_skpd_blud where kd_skpd='$skpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                {
                  
                    $saldo_lalu  = $rowsc->n_saldo_lalu;
                  
                }
        
        $sqlsallalu = "SELECT sum(terima)-sum(keluar)  as sisa FROM 
                    (SELECT DISTINCT '1' jenis, no_kas as nomor, tgl_kas as tanggal, '' as kd_rek, 'Penerimaan SP2D '+b.no_sp2d as keterangan, 0 as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd' and b.jns_spp <>'2' UNION ALL
                    SELECT '2' jenis, no_kas as nomor, tgl_kas as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, nilai as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'  and  b.jns_spp <>'2' UNION ALL
                    SELECT DISTINCT '1' jenis, no_kas as nomor, tgl_kas as tanggal, '' as kd_rek, 'Penerimaan SP2D '+b.no_sp2d as keterangan, 0 as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd' and b.jns_spp in ('2') UNION ALL
                    SELECT '2' jenis, no_kas as nomor, tgl_kas as tanggal, '1110302' as kd_rek, 'Ganti Uang Persediaan' as keterangan, sum(nilai) as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'  and b.jns_spp in ('2') group by no_kas,tgl_kas UNION ALL
                    SELECT '1' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '2' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Setor Simpanan Ke Bank' as keterangan, nilai as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '1' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Pergeseran Uang' as keterangan, 0 as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '2' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'dari Kas Tunai ke Bank' as keterangan, 0 as terima, nilai as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '1' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='1' UNION ALL
                    SELECT '2' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Ambil Kas BLUD Ke Kas Bendahara Pengeluaran BLUD' as keterangan, nilai as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='1' UNION ALL
                    SELECT '1' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT '2' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Ambil Simpanan di Bank' as keterangan, 0 as terima, nilai as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT '1' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Pergeseran Uang' as keterangan, 0 as terima, 0 as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT '2' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Dari Bank ke Kas Tunai' as keterangan, nilai as terima, 0 as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, ket+' atas No SP2D '+a.no_sp2d as keterangan, 0 as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('1','2','10','11','9') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, b.tgl_bukti as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.nilai as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('1','2','10','11','9') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') and b.jns_spp in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, b.tgl_bukti as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, a.nilai as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, a.tgl_bukti as tanggal, b.kd_rek5 as kd_rek, b.nm_rek5 as keterangan, b.nilai as terima, 0 as keluar FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, a.tgl_bukti as tanggal, b.kd_rek5 as kd_rek, b.nm_rek5 as keterangan, 0 as terima, b.nilai as keluar FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_sts as nomor, tgl_sts as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('1') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_sts as nomor, b.tgl_sts as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.rupiah as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('1') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_sts as nomor, tgl_sts as tanggal, '' as kd_rek, 'Penerimaan atas Setoran Langsung ke Rekening Kas BLUD dari Pihak Ketiga' as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_sts as nomor, b.tgl_sts as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_sts as nomor, tgl_sts as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_sts as nomor, b.tgl_sts as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.rupiah as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd'
                    UNION ALL
                    select '1' jenis,no_bukti nomor,tgl_bukti tanggal,'' as kd_rek,ket as keterangan,nilai terima,0 keluar from trhinlain_blud
where kd_skpd ='$skpd'
UNION all
select '2' jenis,no_bukti nomor,a.tgl_bukti tanggal,b.kd_rek_blud as kd_rek,c.nm_rek5 as keterangan,0 terima,rupiah keluar from
trhinlain_blud a inner join trdkasin_blud b left join ms_rek5_blud c on left(b.kd_rek_blud,7) = left(c.kd_rek5,7)
on a.no_sts = b.no_sts
where a.kd_skpd ='$skpd'
UNION ALL
select '1' jenis,no_sts nomor,tgl_sts tanggal,'' as kd_rek,keterangan as keterangan,0 terima,0 keluar from trhkasin_blud
where kd_skpd ='$skpd' and jns_trans ='6'
UNION all
select '2' jenis,a.no_sts nomor,a.tgl_sts tanggal,b.kd_rek_blud as kd_rek,c.nm_rek5 as keterangan,0 terima,rupiah keluar from
trhkasin_blud a inner join trdkasin_blud b left join ms_rek5_blud c on left(b.kd_rek_blud,7) = left(c.kd_rek5,7)
on a.no_sts = b.no_sts
where a.kd_skpd ='$skpd' and jns_trans ='6'
                    ) a WHERE MONTH(tanggal)<'$bulan'";
                  
        $hasil = $this->db->query($sqlsallalu);
        foreach ($hasil->result() as $row){
        $sal_lalu = $row->sisa;
        $cRet .="<tr>
        <td align='center' width='5%'>&nbsp; </td>
        <td align='center' width='10%'>&nbsp;</td>
        <td align='center' width='10%'>&nbsp;</td>
        <td align='right' width='30%'>Saldo Lalu</td>
        <td align='center' width='10%'>&nbsp;</td>
        <td align='center' width='10%'>&nbsp;</td>
        <td align='right' width='10%'>".number_format($sal_lalu+$saldo_lalu,"2",".",",")."</td>
        </tr>";

        }
        $sqlisi = "SELECT * FROM 
                    (SELECT DISTINCT '1' jenis, no_kas as nomor, tgl_kas as tanggal, '' as kd_rek, 'Penerimaan SP2D '+b.no_sp2d as keterangan, 0 as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd' and b.jns_spp <>'2' UNION ALL
                    SELECT '2' jenis, no_kas as nomor, tgl_kas as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, nilai as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'  and  b.jns_spp <>'2' UNION ALL
                    SELECT DISTINCT '1' jenis, no_kas as nomor, tgl_kas as tanggal, '' as kd_rek, 'Penerimaan SP2D '+b.no_sp2d as keterangan, 0 as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd' and b.jns_spp in ('2') UNION ALL
                    SELECT '2' jenis, no_kas as nomor, tgl_kas as tanggal, '1110302' as kd_rek, 'Ganti Uang Persediaan' as keterangan, sum(nilai) as terima, 0 as keluar FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'  and b.jns_spp in ('2') group by no_kas,tgl_kas UNION ALL
                    SELECT '1' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '2' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Setor Simpanan Ke Bank' as keterangan, nilai as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '1' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Pergeseran Uang' as keterangan, 0 as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '2' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'dari Kas Tunai ke Bank' as keterangan, 0 as terima, nilai as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='2' UNION ALL
                    SELECT '1' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='1' UNION ALL
                    SELECT '2' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Ambil Kas BLUD Ke Kas Bendahara Pengeluaran BLUD' as keterangan, nilai as terima, 0 as keluar FROM tr_setorsimpanan_blud WHERE kd_skpd = '$skpd' AND jenis='1' UNION ALL
                    SELECT '1' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT '2' jenis, no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Ambil Simpanan di Bank' as keterangan, 0 as terima, nilai as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT '1' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Pergeseran Uang' as keterangan, 0 as terima, 0 as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT '2' jenis, no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, 'Dari Bank ke Kas Tunai' as keterangan, nilai as terima, 0 as keluar FROM tr_ambilsimpanan_blud WHERE kd_skpd = '$skpd'  UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, ket+' atas No SP2D '+a.no_sp2d as keterangan, 0 as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('1','2','10','11','9') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, b.tgl_bukti as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.nilai as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('1','2','10','11','9') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, b.tgl_bukti as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, a.nilai as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' as kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp not in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, b.tgl_bukti as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, a.nilai as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp not in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti+1 as nomor, tgl_bukti as tanggal, '' as kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp not in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti+1 as nomor, b.tgl_bukti as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.nilai as keluar FROM trdtransout_blud a INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE b.jenis IN ('3') AND b.jns_spp not in ('1','2','3') AND a.kd_skpd = '$skpd' UNION ALL

                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, a.tgl_bukti as tanggal, b.kd_rek5 as kd_rek, b.nm_rek5 as keterangan, b.nilai as terima, 0 as keluar FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_bukti as nomor, tgl_bukti as tanggal, '' kd_rek, ket as keterangan, 0 as terima, 0 as keluar FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_bukti as nomor, a.tgl_bukti as tanggal, b.kd_rek5 as kd_rek, b.nm_rek5 as keterangan, 0 as terima, b.nilai as keluar FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b ON a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti WHERE a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_sts as nomor, tgl_sts as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('1') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_sts as nomor, b.tgl_sts as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.rupiah as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('1') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_sts as nomor, tgl_sts as tanggal, '' as kd_rek, 'Penerimaan atas Setoran Langsung ke Rekening Kas BLUD dari Pihak Ketiga' as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_sts as nomor, b.tgl_sts as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT DISTINCT '1' jenis, a.no_sts as nomor, tgl_sts as tanggal, '' as kd_rek, keterangan as keterangan, 0 as terima, 0 as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd' UNION ALL
                    SELECT '2' jenis, a.no_sts as nomor, b.tgl_sts as tanggal, CASE WHEN LEFT(a.kd_rek5,1)='5' then a.kd_rek5+'/'+a.kd_rek_blud ELSE a.kd_rek_blud END as kd_rek, a.nm_rek_blud as keterangan, 0 as terima, a.rupiah as keluar FROM trdkasin_blud a INNER JOIN trhkasin_blud b ON a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts WHERE b.jns_trans IN ('5') AND LEFT(a.kd_rek5,1)<>'4' AND a.kd_skpd = '$skpd'
                    UNION ALL
                    select '1' jenis,no_bukti nomor,tgl_bukti tanggal,'' as kd_rek,ket as keterangan,nilai terima,0 keluar from trhinlain_blud
where kd_skpd ='$skpd'
UNION all
select '2' jenis,no_bukti nomor,a.tgl_bukti tanggal,b.kd_rek_blud as kd_rek,c.nm_rek5 as keterangan,0 terima,rupiah keluar from
trhinlain_blud a inner join trdkasin_blud b left join ms_rek5_blud c on left(b.kd_rek_blud,7) = left(c.kd_rek5,7)
on a.no_sts = b.no_sts
where a.kd_skpd ='$skpd'
UNION ALL
select '1' jenis,no_sts nomor,tgl_sts tanggal,'' as kd_rek,keterangan as keterangan,0 terima,0 keluar from trhkasin_blud
where kd_skpd ='$skpd' and jns_trans ='6'
UNION all
select '2' jenis,a.no_sts nomor,a.tgl_sts tanggal,b.kd_rek_blud as kd_rek,c.nm_rek5 as keterangan,0 terima,rupiah keluar from
trhkasin_blud a inner join trdkasin_blud b left join ms_rek5_blud c on left(b.kd_rek_blud,7) = left(c.kd_rek5,7)
on a.no_sts = b.no_sts
where a.kd_skpd ='$skpd' and jns_trans ='6'
                    ) a WHERE MONTH(tanggal)='$bulan'
                    ORDER BY tanggal, nomor, jenis";

        
        //sementara di trhkasin +1 di hapus
        
        $saldo=$sal_lalu+$saldo_lalu;
        $hasil = $this->db->query($sqlisi);
                    foreach ($hasil->result() as $row){
                       $jenis = $row->jenis;
                       $nomor = $row->nomor;
                       $tanggal = $row->tanggal;
                       $kd_rek = $row->kd_rek;
                       $keterangan = $row->keterangan;
                       $terima = $row->terima;
                       $keluar = $row->keluar;
                       $saldo=$saldo+$terima-$keluar;
                       if($jenis==1){
                       $cRet .="
                       <tr>
                       <td align='center' style=' border-bottom:solid 1px white; border-top:solid 1px gray;'>$nomor</td>
                       <td align='center' style=' border-bottom:dashed 1px gray; border-top:solid 1px gray;'>$tanggal</td>
                       <td align='center' style=' border-bottom:dashed 1px gray; border-top:solid 1px gray;'>&nbsp; </td>
                       <td style=' border-bottom:dashed 1px gray; border-top:solid 1px gray;'>$keterangan</td>
                       <td style=' border-bottom:dashed 1px gray; border-top:solid 1px gray;'>&nbsp; </td>
                       <td style=' border-bottom:dashed 1px gray; border-top:solid 1px gray;'>&nbsp; </td>
                       <td style=' border-bottom:dashed 1px gray; border-top:solid 1px gray;'>&nbsp; </td>
                       </tr>
                       ";}
                       
                       else {
                        
                        $cRet .="
                       <tr>
                       <td align='center' border-top:dashed 1px gray;>&nbsp; </td>
                       <td align='center' border-top:dashed 1px gray;>&nbsp; </td>
                       <td align='center' border-top:dashed 1px gray;>$kd_rek</td>
                       <td border-top:dashed 1px gray;>$keterangan</td>
                       <td border-top:dashed 1px gray; align='right'>".number_format($terima,"2",".",",")."</td>
                       <td border-top:dashed 1px gray; align='right'>".number_format($keluar,"2",".",",")."</td>
                       <td border-top:dashed 1px gray; align='right'>".number_format($saldo,"2",".",",")."</td>
                       </tr>   ";
                       }
                    
                    }
               

     $asql="
            SELECT sum(sisa) jml from (
            SELECT terima-keluar as sisa FROM(select
            SUM(case when jns=1 then jumlah else 0 end) AS terima,
            SUM(case when jns=2 then jumlah else 0 end) AS keluar
            from (
            select tgl_kas tgl,no_kas bku,'Terima SP2D '+no_sp2d ket,total jumlah,'1' jns,kd_skpd kode from trhsp2d_blud where no_kas<>'' and jns_spp in ('1','2','3')  union
            SELECT b.tgl_kas AS tgl,b.no_kas AS bku,b.keterangan_sp2d AS ket,b.total - isnull(pot, 0) AS jumlah,'1' AS jns,b.kd_skpd AS kode FROM trhsp2d_blud b LEFT JOIN (SELECT no_spm,SUM (nilai) pot FROM trspmpot_blud GROUP BY no_spm) c ON b.no_spm = c.no_spm where no_kas<>'' and b.jns_spp not in('1','2','3') union

            SELECT tgl_kas AS tgl,no_kas AS bku,keterangan as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud union
            SELECT tgl_bukti AS tgl,no_bukti AS bku,ket as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='BANK' union
            SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,a.total-isnull(pot,0) AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhtransout_blud a join trhsp2d_blud b on a.no_sp2d=b.no_sp2d and a.kd_skpd=b.kd_skpd left join (select no_spm, sum(nilai)pot from trspmpot_blud group by no_spm) c on b.no_spm=c.no_spm WHERE pay='BANK' UNION
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'2' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where a.jns_spp in ('1','2','3') and a.jenis<>'3' and a.pay='BANK' union 
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'1' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where  a.jenis='3'  and a.jns_spp in ('1','2','3') and a.pay='BANK' union 
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'1' AS jns,a.kd_skpd AS kode FROM trhtrmpot_blud a inner join trdtrmpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union 
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhstrpot_blud a inner join trdstrpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union 
            SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud
                union all
                select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
                    from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
                    where jns_trans NOT IN ('4','2')   and a.pay='Bank'
                    GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd ) a
            where month(tgl)<'$bulan' and kode='$skpd') a 
            union all
            SELECT terima-keluar as sisa FROM(select
            SUM(case when jns=1 then jumlah else 0 end) AS terima,
            SUM(case when jns=2 then jumlah else 0 end) AS keluar
            from (
            select tgl_kas tgl,no_kas bku,'Terima SP2D '+no_sp2d ket,total jumlah,'1' jns,kd_skpd kode from trhsp2d_blud where no_kas<>'' and jns_spp in ('1','2','3')  union
            SELECT b.tgl_kas AS tgl,b.no_kas AS bku,b.keterangan_sp2d AS ket,b.total - isnull(pot, 0) AS jumlah,'1' AS jns,b.kd_skpd AS kode FROM trhsp2d_blud b LEFT JOIN (SELECT no_spm,SUM (nilai) pot FROM trspmpot_blud GROUP BY no_spm) c ON b.no_spm = c.no_spm where no_kas<>'' and b.jns_spp not in('1','2','3') union
            SELECT tgl_kas AS tgl,no_kas AS bku,keterangan as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud union
            SELECT tgl_bukti AS tgl,no_bukti AS bku,ket as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='BANK' union
            SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,a.total-isnull(pot,0) AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhtransout_blud a join trhsp2d_blud b on a.no_sp2d=b.no_sp2d and a.kd_skpd=b.kd_skpd left join (select no_spm, sum(nilai)pot from trspmpot_blud group by no_spm) c on b.no_spm=c.no_spm WHERE pay='BANK' UNION
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'2' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where a.jns_spp in ('1','2','3') and a.jenis<>'3' and a.pay='BANK' union 
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'1' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where  a.jenis='3' and a.jns_spp in ('1','2','3') and a.pay='BANK' union 
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'1' AS jns,a.kd_skpd AS kode FROM trhtrmpot_blud a inner join trdtrmpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union 
            SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhstrpot_blud a inner join trdstrpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union
            SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud union all
                select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
                    from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
                    where jns_trans NOT IN ('4','2')   and a.pay='Bank'
                    GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd ) a
            where month(tgl)='$bulan' and kode='$skpd') b 
            )x
            ";

   
        $hasil=$this->db->query($asql);
        $bank=$hasil->row();
        $sisa=$bank->jml;
        $saldobank=$sisa;
        
        $esteh="
                SELECT sum(terima) terimax,sum(keluar) keluarx from (
                SELECT 
                SUM(case when jns=1 then jumlah else 0 end ) AS terima,
                SUM(case when jns=2 then jumlah else 0 end) AS keluar
                FROM (
                SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
                select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
                    from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
                    where jns_trans NOT IN ('4','2')  and a.pay='Tunai'
                    GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd             
                UNION ALL
                SELECT  a.tgl_bukti AS tgl, a.no_bukti AS bku, a.ket AS ket, SUM(z.nilai) - isnull(pot, 0) AS jumlah, '2' AS jns, a.kd_skpd AS kode
                                FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
                                LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
                                LEFT JOIN (SELECT no_spm, SUM (nilai) pot   FROM trspmpot_blud GROUP BY no_spm) c
                                ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
                                AND MONTH(a.tgl_bukti)<'$bulan' and a.kd_skpd='$skpd' 
                                AND a.no_bukti NOT IN(
                                select no_bukti from trhtransout_blud 
                                where no_sp2d in 
                                (SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)<'$bulan' and  no_kas not in
                                (SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$skpd' 
                                AND MONTH(tgl_bukti)<'$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$skpd')
                                GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
                        UNION ALL
                SELECT  tgl_bukti AS tgl,   no_bukti AS bku, ket AS ket,  isnull(total, 0) AS jumlah, '2' AS jns, kd_skpd AS kode
                                from trhtransout_blud 
                                WHERE pay = 'TUNAI' and no_sp2d in 
                                (SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)<'$bulan' and  no_kas not in
                                (SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$skpd' 
                                AND MONTH(tgl_bukti)<'$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$skpd'
                
                UNION ALL
                SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION ALL
                SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI'
                union all
                SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
                select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
                    from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
                    where jns_trans NOT IN ('4','2') and a.pay='Tunai'
                    GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd             
                UNION ALL
                SELECT  a.tgl_bukti AS tgl, a.no_bukti AS bku, a.ket AS ket, SUM(z.nilai) - isnull(pot, 0) AS jumlah, '2' AS jns, a.kd_skpd AS kode
                                FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
                                LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
                                LEFT JOIN (SELECT no_spm, SUM (nilai) pot   FROM trspmpot_blud GROUP BY no_spm) c
                                ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
                                AND MONTH(a.tgl_bukti)='$bulan' and a.kd_skpd='$skpd' 
                                AND a.no_bukti NOT IN(
                                select no_bukti from trhtransout_blud 
                                where no_sp2d in 
                                (SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
                                (SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$skpd' 
                                AND MONTH(tgl_bukti)='$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$skpd')
                                GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
                        UNION ALL
                SELECT  tgl_bukti AS tgl,   no_bukti AS bku, ket AS ket,  isnull(total, 0) AS jumlah, '2' AS jns, kd_skpd AS kode
                                from trhtransout_blud 
                                WHERE pay = 'TUNAI' and no_sp2d in 
                                (SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
                                (SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$skpd' 
                                AND MONTH(tgl_bukti)='$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$skpd'
                
                UNION ALL
                SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION ALL
                SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI'
                
                ) a 
                where month(a.tgl)<'$bulan' and kode='$skpd'
                union all
                SELECT 
                SUM(case when jns=1 then jumlah else 0 end ) AS terima,
                SUM(case when jns=2 then jumlah else 0 end) AS keluar
                FROM (
                SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
                select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
                    from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
                    where jns_trans NOT IN ('4','2')  and a.pay='Tunai'
                    GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd             
                UNION ALL
                SELECT  a.tgl_bukti AS tgl, a.no_bukti AS bku, a.ket AS ket, SUM(z.nilai) - isnull(pot, 0) AS jumlah, '2' AS jns, a.kd_skpd AS kode
                                FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
                                LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
                                LEFT JOIN (SELECT no_spm, SUM (nilai) pot   FROM trspmpot_blud GROUP BY no_spm) c
                                ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
                                AND MONTH(a.tgl_bukti)='$bulan' and a.kd_skpd='$skpd' 
                                AND a.no_bukti NOT IN(
                                select no_bukti from trhtransout_blud 
                                where no_sp2d in 
                                (SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
                                (SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$skpd' 
                                AND MONTH(tgl_bukti)='$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$skpd')
                                GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
                        UNION ALL
                SELECT  tgl_bukti AS tgl,   no_bukti AS bku, ket AS ket,  isnull(total, 0) AS jumlah, '2' AS jns, kd_skpd AS kode
                                from trhtransout_blud 
                                WHERE pay = 'TUNAI' and no_sp2d in 
                                (SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
                                (SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$skpd' 
                                AND MONTH(tgl_bukti)='$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$skpd'
                
                UNION ALL
                SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION ALL
                SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI'
                
                ) a 
                where month(a.tgl)='$bulan' and kode='$skpd'
                ) x";


        $hasil = $this->db->query($esteh);
                
        $okok = $hasil->row();  
                     $terima = $okok->terimax;
                     $keluar = $okok->keluarx;                   
                     $saldotunai=$terima-$keluar;
        
        $querypaj=" select sum(debet) debetx,sum(kredit) kreditx from (
                    SELECT 
                    sum(case when jns=1 then terima else 0 end) as debet,
                    sum(case when jns=2 then keluar else 0 end ) as kredit
                    FROM(
                    SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+no_sp2d) AS ket,SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd FROM trhtrmpot_blud a
                    INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
                    GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd
                    UNION ALL
                    SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+no_terima) AS ket,'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd FROM trhstrpot_blud a
                    INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
                    GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_terima, a.kd_skpd) a WHERE MONTH(tgl)<'$bulan' AND kd_skpd='$skpd'
                    union all
                    SELECT 
                    sum(case when jns=1 then terima else 0 end) as debet,
                    sum(case when jns=2 then keluar else 0 end ) as kredit
                    FROM(
                    SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+no_sp2d) AS ket,SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd FROM trhtrmpot_blud a
                    INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
                    GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd
                    UNION ALL
                    SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+no_terima) AS ket,'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd FROM trhstrpot_blud a
                    INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
                    GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_terima, a.kd_skpd) a WHERE MONTH(tgl)='$bulan' AND kd_skpd='$skpd'
                    ) x
                    ";
                $querypjk=$this->db->query($querypaj);
                $rowpjk = $querypjk->row();  
                    $debet=$rowpjk->debetx;
                    $kredit=$rowpjk->kreditx;
                    $saldopjk=$debet-$kredit;

                    $kd_skpd=$skpd;
                    $sql="SELECT sum(masuk)-sum(keluar) kastunai from( SELECT * FROM (
                        SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS masuk,0 AS keluar,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
                        
                        SELECT a.tgl_bukti AS tgl,a.no_bukti AS bku,a.ket AS ket,0 AS masuk, SUM(z.nilai)-isnull(pot,0)  AS keluar,a.kd_skpd AS kode 
                                FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
                                LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
                                LEFT JOIN (SELECT no_spm, SUM (nilai) pot   FROM trspmpot_blud GROUP BY no_spm) c
                                ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
                                AND MONTH(a.tgl_bukti)='$bulan' and a.kd_skpd='$kd_skpd' 
                                AND a.no_bukti NOT IN(
                                select no_bukti from trhtransout_blud 
                                where no_sp2d in 
                                (SELECT ISNULL(no_sp2d,'') as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
                                (SELECT ISNULL(min(z.no_kas),'') as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
                                AND MONTH(tgl_bukti)='$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$kd_skpd')
                                GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
                        UNION ALL
                        select tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,0 AS masuk, ISNULL(total,0)  AS keluar,kd_skpd AS kode 
                                from trhtransout_blud 
                                WHERE pay = 'TUNAI' AND no_sp2d in 
                                (SELECT ISNULL(no_sp2d,'') as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
                                AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
                                (SELECT ISNULL(min(z.no_kas),'') as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
                                AND MONTH(tgl_bukti)='$bulan'
                                GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
                                and jns_spp in (4,5,6) and kd_skpd='$kd_skpd'

                        UNION ALL
                        
                        SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket, 0 as masuk,nilai AS keluar,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION  ALL
                        SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai as masuk,0 AS keluar,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI')a
                        where month(a.tgl)='$bulan' and kode='$kd_skpd' )oke";
                $sqlku=$this->db->query($sql);
                $sqlkumu = $sqlku->row();
                $kastunai=$sqlkumu->kastunai; 
                
              
        $cRet .="</table>" ; 
        $cRet .='<TABLE width="50%" style="font-size:12px">
                    <TR>
                        <TD align="left" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="left" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="left" ><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kas Bank &nbsp; : '.number_format($saldobank,"2",".",",").'</TD>
                    </TR>
                    <TR>
                        <TD align="left" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="left" ><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kas Tunai &nbsp; : '.number_format($kastunai,"2",".",",").'</TD>
                    </TR>
                    <TR>
                        <TD align="left" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="left" ><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pajak &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.number_format($saldopjk,"2",".",",").'</TD>
                    </TR>
                    </TABLE><br/>';

        
        $cRet .='<TABLE width="100%" style="font-size:12px">
                    <TR>
                        <TD align="center" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="center" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="center" >Mengetahui,</TD>
                        <TD align="center" ><b>&nbsp;</TD>
                        <TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_cetak).'</TD>
                    </TR>
                    <TR>
                        <TD align="center" >'.$jabatan.'</TD>
                        <TD align="center" ><b>&nbsp;</TD>
                        <TD align="center" >'.$jabatan_tim.'</TD>
                    </TR>
                    <TR>
                        <TD align="center" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="center" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="center" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="center" ><b>&nbsp;</TD>
                    </TR>
                    <TR>
                        <TD align="center" ><u>'.$nama.' </u> <br>'.$pangkat.'</TD>
                        <TD align="center" ><b>&nbsp;</TD>
                        <TD align="center" ><u>'.$nama_tim.'</u> <br> '.$pangkat_tim.'</TD>
                    </TR>
                    <TR>
                        <TD align="center" >NIP. '.$nip.'</TD>
                        <TD align="center" ><b>&nbsp;</TD>
                        <TD align="center" >NIP. '.$nip_tim.'</TD>
                    </TR>
                    </TABLE><br/>';
        
        $data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul = 'BKU PENGELUARAN $bulan $thn';
        $this->template->set('title', 'BKU PENGELUARAN $bulan $thn');
       

        if($convert==0){
            echo $cRet;
        } elseif ($convert==1) {
            $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
        } elseif ($convert==2) {
             header("Content-Type: application/vnd.ms-excel");
             header("Content-Disposition: attachment; filename= $judul.xls");
             echo $cRet;
        } else {
             header("Content-Type: application/vnd.ms-word");
             header("Content-Disposition: attachment; filename= $judul.doc");
             echo $cRet;
        }
 

    }

        function cetak_register_pengeluaran_blud($convert='',$ctgl1='',$ctgl2='',$nipang='',$nipbp=''){
        $skpd = $this->session->userdata('kdskpd');
        $indotgl1=$this->tanggal_format_indonesia($ctgl1);
        $indotgl2=$this->tanggal_format_indonesia($ctgl2);

         $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }
        $cRet = '';
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\"><b>
                  $kab<br>
                  LAPORAN REGISTER PENGELUARAN BLUD <br>
                  </b>
                </td>

            </tr>
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">&nbsp;
                </td>
                
            </tr>
            </table>";
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                         <td width=\"5%\">Periode $indotgl1 s.d $indotgl2</font></td>
                        
                    </tr> 
                   

                    </table>";

         $cRet    .="<table style=\"border-collapse:collapse; font-size:18px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <thead>
                        <tr>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>No. Terima<b></td>
                             <td width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Tanggal</b></td>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Keterangan<b></td>
                             <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Pay<b></td>
                             <td width=\"12%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Kode<br>Rekening<b></td>
                             <td width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Nama<br>Rekening<b></td>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Total<br>(Rp.)<b></td>
                        </tr>
                        
                        <tr>
                         <td align=\"center\">1</td>
                         <td align=\"center\">2</td>
                         <td align=\"center\">3</td>
                         <td align=\"center\">4</td>
                         <td align=\"center\">5</td>
                         <td align=\"center\">6</td>
                         
                         
                    </tr>
                    </thead>
                    
                    ";
        $sql="SELECT a.no_bukti,a.tgl_bukti,a.ket,a.pay,sum(b.nilai) as total FROM trhtransout_blud a INNER JOIN trdtransout_blud b
ON a.`no_bukti`=b.no_bukti  where kd_skpd='$skpd' and a.tgl_bukti between '$ctgl1' and '$ctgl2' GROUP BY a.no_bukti";
        $sqlp = $this->db->query($sql);
        $tot=0;
        foreach ($sqlp->result() as $row){
            $no_bukti   =$row->no_bukti;
            $tgl_bukti  =$this->tanggal_indonesia($row->tgl_bukti);
            $keterangan =$row->ket;
            $pay        =$row->pay;
            $nilai      =$row->total;
            $cRet .= " <tr>
                     
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\" >$no_bukti</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$tgl_bukti</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$keterangan</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">$pay</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"left\">";
                    $sqlsdana ="SELECT kd_rek7 FROM trdtransout_blud where no_bukti='$no_bukti'";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        
                        $kd_rek7 = $rows->kd_rek7;
                        $cRet    .= "<li>$kd_rek7</li>";
                    }
                    
                    $cRet     .= "</td>

                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\">";
                    $sqlsdana ="SELECT a.kd_rek7,b.nm_rek7 FROM trdtransout_blud a LEFT JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7` where a.no_bukti='$no_bukti' ";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        
                        $nm_rek7 = $rows->nm_rek7;
                        $cRet    .= "<li>$nm_rek7</li>";
                    }
                    
                    $cRet     .= "</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"Right\">";
                      $sqlsdana ="SELECT a.kd_rek7,a.nilai FROM trdtransout_blud a where a.no_bukti='$no_bukti' ";
                    $sdana = $this->db->query($sqlsdana);
                    foreach ($sdana->result() as $rows)
                    {
                        $pagu = number_format($rows->nilai,"2",",",".");
                        $cRet .= "<li>$pagu</li>";
                    }
                    
                    $cRet     .= "</td><tr>";

                    $tot=$tot+$nilai;
                     


        }
        $cRet .="<tr>
                     
                     <td colspan=\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"center\" >Jumlah Keseluruhan</td>
                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" align=\"right\" >".number_format($tot,"2",",",".")."</td>
                </tr>";

        $cRet .="</table>";

         $sql="select nip,nama,jabatan from ms_ttd_blud where id_urut='$nipang'";
        $query=$this->db->query($sql);
        foreach ($query->result() as $rowsc2)
                {
                    $jabatany =$rowsc2->jabatan;
                    $nama    = $rowsc2->nama;
                    $nip     = $rowsc2->nip;
                    
                }
        $sql_tim="select nip,nama,jabatan from ms_ttd_blud where id_urut='$nipbp'";
        $query=$this->db->query($sql_tim);
        foreach ($query->result() as $row)
                {
                    $jabatanx  =$row->jabatan;
                    $nama_tim = $row->nama;
                    $nip_tim  = $row->nip;
                    
                }
        $tglctk = date('Y-m-d');
        $cRet .="
        <table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >
        <tr>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
        </tr>
        <tr >                       
                <td align='center' colspan='2' width='50%'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td align='center' colspan='2' width='50%'>".$daerah.", ".$this->tanggal_format_indonesia($tglctk)."</td>         
        </tr>
       
        <tr>
                <td align='center' colspan='2' width='50%'><b>$jabatany<b></td>
                <td align='center' colspan='2' width='50%'><b>$jabatanx</b></td>
        </tr>
        <tr>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
        </tr>
         <tr>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
                <td align='center' colspan='2' width='50%'>&nbsp;</td>
        </tr>
        <tr>
                <td align='center' colspan='2' width='50%'><b>(".$nama.")<b></td>
                <td align='center' colspan='2' width='50%'><b>(".$nama_tim.")</b></td>
        </tr>
        <tr>
                <td align='center' colspan='2' width='50%'><b>".$nip."<b></td>
                <td align='center' colspan='2' width='50%'><b>".$nip_tim."</b></td>
        </tr>
        </table>";

        $data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul = 'REGISTER PENGELUARAN BLUD';
        $this->template->set('title', 'REGISTER PENGELUARAN BLUD');
        

        switch ($convert)
        {
            case 1;
                $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");

                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
        }   

        }
	
	function cetak_spj_pengeluaran_blud($lcskpd='',$nbulan='',$ttd1='',$tgl_ctk='',$ttd2='',$ctk='',$atas='', $bawah='', $kiri='', $kanan='', $jenis=''){
		$ttd1 = str_replace('123456789',' ',$ttd1);
		$ttd2 = str_replace('123456789',' ',$ttd2); 
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama2= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
				
				$sqlanggaran1="select case when statu=1 and status_ubah=1 and status_ubah=1 and $nbulan>=month(tgl_dpa_ubah) then '3' 
					   when statu=1 and status_ubah=1 and status_ubah=1 and $nbulan>=month(tgl_dpa_ubah) and $nbulan<month(tgl_dpa_ubah) then '3'
					   when statu=1 and status_ubah=1 and status_ubah=1 and $nbulan<month(tgl_dpa_ubah) then '1'
					   when statu=1 and status_ubah=1 and status_ubah=0 and $nbulan>=month(tgl_dpa_ubah) then '3' 
					   when statu=1 and status_ubah=1 and status_ubah=0 and $nbulan<month(tgl_dpa_ubah) then '1'
					   when statu=1 and status_ubah=0 and status_ubah=0 and $nbulan>=month(tgl_dpa) then '1'
					   else 'nilai' end as anggaran from trhrka_blud where kd_skpd='$lcskpd'";
    
                 $sqlanggaran=$this->db->query($sqlanggaran1);
                 foreach ($sqlanggaran->result() as $rowttd)
                {
                    $ang=$rowttd->anggaran;
                }
				
		$tanda_ang=2;
        $thn_ang	   = $this->session->userdata('pcThang');
        
        $skpd = $lcskpd;
        $nama=  $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $bulan= $this->tukd_model->getBulan($nbulan); 
		$prv = $this->db->query("SELECT * from sclient_blud");
		$prvn = $prv->row();          
		$prov = $prvn->provinsi;         
		$daerah = $prvn->daerah;
		if($jenis=='1'){
			$judul='SPJ FUNGSIONAL';
		} else if($jenis=='2'){
			$judul='SPJ ADMINISTRATIF';
		} else {
			$judul='SPJ BELANJA';
		}
        
        $font = 12;
        $fontc = 'font-size:'.$font.'px;';
        $cRet = '';
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">
                 <b> SURAT PENGESAHAN PERTANGGUNGJAWABAN BLUD<BR></b>
                 <b>(".$judul.")<BR></b>&nbsp;
                </td>
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\" width=\"25%\">
                  B L U D
                </td> 
                <td width=\"75%\" style=\"font-size:12px;\">:$skpd - $nama
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Pengguna Anggaran/Kuasa Pengguna Anggaran
                </td> 
                <td style=\"font-size:12px;\">:$nama2
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Bendahara Pengeluaran
                </td> 
                <td style=\"font-size:12px;\">:$nama1
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Tahun Anggaran
                </td> 
                <td style=\"font-size:12px;\">:$thn_ang
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Bulan
                </td> 
                <td style=\"font-size:12px;\">:$bulan
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\" colspan=\"2\">
                 &nbsp;
                </td> 
            </tr>
            
            </table>
            <table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <thead>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Kode<br>Rekening</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Uraian</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Jumlah<br>Anggaran</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\" style=\"font-size:12px\"><b>SPJ-LS Gaji</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\" style=\"font-size:12px\"><b>SPJ-LS Barang & Jasa</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\" style=\"font-size:12px\"><b>SPJ NON LS</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Jumlah SPJ<br>(NON LS)<br>s.d Bulan Ini</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Sisa Pagu<br>Anggaran</b></td>
            </tr>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>s.d<br>Bulan<br>lalu</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Bulan Ini</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>s.d<br>Bulan Ini</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>s.d<br>Bulan<br>lalu</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Bulan Ini</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>s.d<br>Bulan Ini</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>s.d<br>Bulan<br>lalu</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Bulan Ini</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>s.d<br>Bulan Ini</b></td>
            </tr>                 
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">1</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">2</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">3</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">4</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">5</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">6</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">7</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">8</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">9</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">10</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">11</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">12</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">13</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">14</td>
            </tr> 
             </thead>
            <tr>
                <td align=\"center\" style=\"font-size:12px\">&nbsp;</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
            </tr>";

				$att="exec spj_blud '$lcskpd','$nbulan','$thn_ang','$ang' ";
                //echo "$att";
				$hasil=$this->db->query($att);
				foreach ($hasil->result() as $trh1){
				$bre				=	$trh1->kd_rek;
				$wok				=	$trh1->uraian;
				$nilai				=	$trh1->anggaran;
				$real_up_ini		=	$trh1->up_ini;
				$real_up_ll			=	$trh1->up_lalu;
				$real_gaji_ini		=	$trh1->gaji_ini;
				$real_gaji_ll		=	$trh1->gaji_lalu;
				$real_brg_js_ini	=	$trh1->brg_ini;
				$real_brg_js_ll		=	$trh1->brg_lalu;
				$total	= $real_gaji_ll+$real_gaji_ini+$real_brg_js_ll+$real_brg_js_ini+$real_up_ll+$real_up_ini;
				$sisa	= $nilai-$real_gaji_ll-$real_gaji_ini-$real_brg_js_ll-$real_brg_js_ini-$real_up_ll-$real_up_ini;
				$a=strlen($bre);
			
			$cRet .="
				<tr>
                <td valign=\"top\" width=\"8%\" align=\"center\" style=\"font-size:12px\" >&nbsp;".$bre."</td>
                <td valign=\"top\" align=\"left\" width=\"25%\" style=\"font-size:12px\">&nbsp;".$wok."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($nilai,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_gaji_ll,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_gaji_ini,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_gaji_ll+$real_gaji_ini,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_brg_js_ll,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_brg_js_ini,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_brg_js_ll+$real_brg_js_ini,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_up_ll,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_up_ini,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_up_ll+$real_up_ini,"2",",",".")."&nbsp;</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($total,"2",",",".")."&nbsp;</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($sisa,"2",",",".")."&nbsp;</td>
            </tr>";
			
			}
			$cRet .="

            <tr>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px\" >&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">Penerimaan :</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px\">&nbsp;</td>
            </tr>";
            
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
					ON a.no_spp = b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd' AND 
                    MONTH(a.tgl_kas)='$nbulan' AND a.jns_spp IN ('1','2','3','10') AND a.status_sp2d='1') AS sp2d_up_ini,
                    (SELECT SUM(b.nilai) FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
					ON a.no_spp = b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd' AND 
                    MONTH(a.tgl_kas)<'$nbulan' AND a.jns_spp IN ('1','2','3','10') AND a.status_sp2d='1') AS sp2d_up_ll,
                    (SELECT SUM(b.nilai) FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
					ON a.no_spp = b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd' AND 
                    MONTH(a.tgl_kas)='$nbulan' AND a.jns_spp ='4' AND a.status_sp2d='1') AS sp2d_gj_ini,
                    (SELECT SUM(b.nilai) FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
					ON a.no_spp = b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd' AND 
                    MONTH(a.tgl_kas)<'$nbulan' AND a.jns_spp ='4'  AND a.status_sp2d='1') AS sp2d_gj_ll,
                    (SELECT SUM(b.nilai) FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
					ON a.no_spp = b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd' AND 
                    MONTH(a.tgl_kas)='$nbulan' AND a.jns_spp IN ('5','6')  AND a.status_sp2d='1') AS sp2d_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
					ON a.no_spp = b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd' AND 
                    MONTH(a.tgl_kas)<'$nbulan' AND a.jns_spp IN ('5','6') AND a.status_sp2d='1') AS sp2d_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh1 = $hasil->row(); 
            $totalsp2d = $trh1->sp2d_gj_ll+$trh1->sp2d_gj_ini+$trh1->sp2d_brjs_ll+
                         $trh1->sp2d_brjs_ini+$trh1->sp2d_up_ll+$trh1->sp2d_up_ini;
                         
            $cobacoba = $trh1->sp2d_gj_ll;
            
            
            
            $cRet .="   
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\" >&ensp;&ensp;- SP2D</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_gj_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_gj_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_gj_ll + $trh1->sp2d_gj_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_brjs_ll + $trh1->sp2d_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh1->sp2d_up_ll + $trh1->sp2d_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalsp2d,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr> ";           
            
			$csqlsp2d = "SELECT a.no_sp2d,
						SUM(CASE WHEN a.jns_spp IN ('4') AND MONTH(a.tgl_kas)<$nbulan THEN b.nilai ELSE 0 END) AS gj_ll,
						SUM(CASE WHEN a.jns_spp IN ('4') AND MONTH(a.tgl_kas)=$nbulan THEN b.nilai ELSE 0 END) AS gj_ini,
						SUM(CASE WHEN a.jns_spp IN ('4') AND MONTH(a.tgl_kas)<=$nbulan THEN b.nilai ELSE 0 END) AS gj_sdini,
						SUM(CASE WHEN a.jns_spp IN ('5','6') AND MONTH(a.tgl_kas)<$nbulan THEN b.nilai ELSE 0 END) AS br_ll,
						SUM(CASE WHEN a.jns_spp IN ('5','6') AND MONTH(a.tgl_kas)=$nbulan THEN b.nilai ELSE 0 END) AS br_ini,
						SUM(CASE WHEN a.jns_spp IN ('5','6') AND MONTH(a.tgl_kas)<=$nbulan THEN b.nilai ELSE 0 END) AS br_sdini,
						SUM(CASE WHEN a.jns_spp IN ('1','2','3','10') AND MONTH(a.tgl_kas)<$nbulan THEN b.nilai ELSE 0 END) AS up_ll,
						SUM(CASE WHEN a.jns_spp IN ('1','2','3','10') AND MONTH(a.tgl_kas)=$nbulan THEN b.nilai ELSE 0 END) AS up_ini,
						SUM(CASE WHEN a.jns_spp IN ('1','2','3','10') AND MONTH(a.tgl_kas)<=$nbulan THEN b.nilai ELSE 0 END) AS up_sdini
						FROM trhsp2d_blud a INNER JOIN trdspp_blud b 
						ON a.no_spp = b.no_spp and a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$lcskpd'
						AND a.status_sp2d='1' AND MONTH(a.tgl_kas)=$nbulan
						GROUP BY a.no_sp2d";
			
			$hasilsp2d=$this->db->query($csqlsp2d);
				foreach ($hasilsp2d->result() as $trsp2d){
				$xno_sp2d	=	$trsp2d->no_sp2d;
				$xup_ll		=	$trsp2d->up_ll;
				$xup_ini	=	$trsp2d->up_ini;
				$xup_sdini	=	$trsp2d->up_sdini;
				$xbr_ll		=	$trsp2d->br_ll;
				$xbr_ini	=	$trsp2d->br_ini;
				$xbr_sdini	=	$trsp2d->br_sdini;
				$xgj_ll		=	$trsp2d->gj_ll;
				$xgj_ini	=	$trsp2d->gj_ini;
				$xgj_sdini	=	$trsp2d->gj_sdini;
			
			
			$cRet .="   
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp; $xno_sp2d</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xgj_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xgj_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xgj_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xbr_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xbr_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xbr_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xup_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xup_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xup_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($xgj_sdini+$xbr_sdini+$xup_sdini,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
		   </tr> "; 
				}
			$cRet .="
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Potongan Pajak</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            $lcrek = '2110401';// '2110601'; // ppn dan IWP terima
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jppn_up_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jppn_up_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jppn_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jppn_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jppn_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jppn_brjs_ll";
           
            $hasil = $this->db->query($csql);
            $trh2 = $hasil->row();
            $totalppn = $trh2->jppn_up_ini + $trh2->jppn_up_ll + $trh2->jppn_gaji_ini + 
                        $trh2->jppn_gaji_ll + $trh2->jppn_brjs_ini + $trh2->jppn_brjs_ll;
            
            
            $cRet .=" 
            <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;a. PPN</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_gaji_ll + $trh2->jppn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_brjs_ll + $trh2->jppn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh2->jppn_up_ll + $trh2->jppn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalppn,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
			</tr>";
            
            $lcrek = '2110301';//'2110701';// pph 21 dan pihak ketiga terima
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN('1','2','3','10','')) AS jpph21_up_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN('1','2','3','10','')) AS jpph21_up_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph21_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph21_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph21_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph21_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh3 = $hasil->row();
            $totalpph21 = $trh3->jpph21_up_ini + $trh3->jpph21_up_ll + $trh3->jpph21_gaji_ini + 
                        $trh3->jpph21_gaji_ll + $trh3->jpph21_brjs_ini + $trh3->jpph21_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;b. PPH 21</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_gaji_ll + $trh3->jpph21_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_brjs_ll + $trh3->jpph21_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh3->jpph21_up_ll + $trh3->jpph21_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph21,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            $lcrek = '2110302';//'2110201';// pph 22 dan iuran jaminan kesehatan terima
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN('1','2','3','10','')) AS jpph22_up_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN('1','2','3','10','')) AS jpph22_up_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph22_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph22_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph22_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph22_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh4 = $hasil->row();
            $totalpph22 = $trh4->jpph22_up_ini + $trh4->jpph22_up_ll + $trh4->jpph22_gaji_ini + 
                        $trh4->jpph22_gaji_ll + $trh4->jpph22_brjs_ini + $trh4->jpph22_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;c. PPH 22</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_gaji_ll + $trh4->jpph22_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_brjs_ll + $trh4->jpph22_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh4->jpph22_up_ll + $trh4->jpph22_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph22,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
			$lcrek = '2110303';//'2110901';// pph 23 dan iuran jaminan ketenagakerjaan terima
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph23_up_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph23_up_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph23_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph23_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph23_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph23_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh5 = $hasil->row();
            $totalpph23 = $trh5->jpph23_up_ini + $trh5->jpph23_up_ll + $trh5->jpph23_gaji_ini + 
                        $trh5->jpph23_gaji_ll + $trh5->jpph23_brjs_ini + $trh5->jpph23_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;d. PPH 23</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_gaji_ll + $trh5->jpph23_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_brjs_ll + $trh5->jpph23_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh5->jpph23_up_ll + $trh5->jpph23_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph23,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			
			$lcrek = '2110305'; // pph4 ayat 1
            $csql = "SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10','') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS up_pph4_lalu,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10','') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS up_pph4_ini,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10','') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS up_pph4_sdini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS gj_pph4_lalu,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_pph4_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_pph4_sdini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS ls_pph4_lalu,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_pph4_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_pph4_sdini
					FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_rek5='$lcrek' AND a.kd_skpd='$lcskpd'";
                    //echo "$csql";
            
            $hasil = $this->db->query($csql);
            $trh72 = $hasil->row();
            $totalpph4 = $trh72->up_pph4_sdini + $trh72->gj_pph4_sdini + $trh72->ls_pph4_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;e. PPh Pasal 4</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->gj_pph4_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->gj_pph4_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->gj_pph4_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->ls_pph4_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->ls_pph4_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->ls_pph4_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->up_pph4_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->up_pph4_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh72->up_pph4_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph4,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";          
           
			
            /*
			$lcrek = "('2110701','2110702','2110703')"; // IWP
            $csql = "SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<'$nbulan' THEN a.nilai ELSE 0 END) AS up_iwp_lalu,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)='$nbulan' THEN a.nilai ELSE 0 END) AS up_iwp_ini,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<='$nbulan' THEN a.nilai ELSE 0 END) AS up_iwp_sdini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' THEN a.nilai ELSE 0 END) AS gj_iwp_lalu,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' THEN a.nilai ELSE 0 END) AS gj_iwp_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<='$nbulan' THEN a.nilai ELSE 0 END) AS gj_iwp_sdini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' THEN a.nilai ELSE 0 END) AS ls_iwp_lalu,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' THEN a.nilai ELSE 0 END) AS ls_iwp_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<='$nbulan' THEN a.nilai ELSE 0 END) AS ls_iwp_sdini
					FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_rek5 in $lcrek AND a.kd_skpd='$lcskpd'";
            
            $hasil = $this->db->query($csql);
            $trh70 = $hasil->row();
            $totaliwp = $trh70->up_iwp_sdini + $trh70->gj_iwp_sdini + $trh70->ls_iwp_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. IWP</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->gj_iwp_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->gj_iwp_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->gj_iwp_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->ls_iwp_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->ls_iwp_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->ls_iwp_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->up_iwp_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->up_iwp_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh70->up_iwp_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaliwp,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			$lcrek = '2110501'; // TAPERUM
            $csql = "SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<'$nbulan' THEN a.nilai ELSE 0 END) AS up_tap_lalu,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)='$nbulan' THEN a.nilai ELSE 0 END) AS up_tap_ini,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<='$nbulan' THEN a.nilai ELSE 0 END) AS up_tap_sdini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' THEN a.nilai ELSE 0 END) AS gj_tap_lalu,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_tap_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_tap_sdini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS ls_tap_lalu,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_tap_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_tap_sdini
					FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_rek5='$lcrek' AND a.kd_skpd='$lcskpd'";
            
            $hasil = $this->db->query($csql);
            $trh71 = $hasil->row();
            $totaltap = $trh71->up_tap_sdini + $trh71->gj_tap_sdini + $trh71->ls_tap_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Taperum</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->gj_tap_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->gj_tap_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->gj_tap_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->ls_tap_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->ls_tap_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->ls_tap_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->up_tap_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->up_tap_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh71->up_tap_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaltap,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			
			
			$lcrek = '2111001'; // PPnPn 2%
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10')) AS ppnpn_up_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10')) AS ppnpn_up_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS ppnpn_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS ppnpn_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS ppnpn_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhtrmpot_blud a INNER JOIN trdtrmpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS ppnpn_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh15 = $hasil->row();
            $totalppnpn = $trh15->ppnpn_up_ini + $trh15->ppnpn_up_ll + $trh15->ppnpn_gaji_ini + 
                        $trh15->ppnpn_gaji_ll + $trh15->ppnpn_brjs_ini + $trh15->ppnpn_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib PPNPN 2%</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_gaji_ll + $trh15->ppnpn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_brjs_ll + $trh15->ppnpn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh15->ppnpn_up_ll + $trh15->ppnpn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalppnpn,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			

            // PPnPn 3% 2111101       
            $hasil = $this->tukd_model->spj_trmpajak_rek($lcskpd,'2111101',$nbulan,'PPnPn3');
            $trhPPnPn3 = $hasil->row();
            $totalPPnPn3 = $trhPPnPn3->PPnPn3_up_ini + $trhPPnPn3->PPnPn3_up_ll + $trhPPnPn3->PPnPn3_gaji_ini + 
                        $trhPPnPn3->PPnPn3_gaji_ll + $trhPPnPn3->PPnPn3_brjs_ini + $trhPPnPn3->PPnPn3_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib PPNPN 3%</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_gaji_ll + $trhPPnPn3->PPnPn3_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_brjs_ll + $trhPPnPn3->PPnPn3_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_up_ll + $trhPPnPn3->PPnPn3_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalPPnPn3,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
            // Iuran JKK 2111201 | Iuran JKM 2111301     
            $hasil = $this->tukd_model->spj_trmpajak_rek($lcskpd,'2111201',$nbulan,'jkk');
            $trhjkk = $hasil->row();
            $totaljkk = $trhjkk->jkk_up_ini + $trhjkk->jkk_up_ll + $trhjkk->jkk_gaji_ini + 
                        $trhjkk->jkk_gaji_ll + $trhjkk->jkk_brjs_ini + $trhjkk->jkk_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib JKK</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_gaji_ll + $trhjkk->jkk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_brjs_ll + $trhjkk->jkk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_up_ll + $trhjkk->jkk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaljkk,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			

            // Iuran JKM 2111301     
            $hasil = $this->tukd_model->spj_trmpajak_rek($lcskpd,'2111301',$nbulan,'jkm');
            $trhjkm = $hasil->row();
            $totaljkm = $trhjkm->jkm_up_ini + $trhjkm->jkm_up_ll + $trhjkm->jkm_gaji_ini + 
                        $trhjkm->jkm_gaji_ll + $trhjkm->jkm_brjs_ini + $trhjkm->jkm_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib JKM</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_gaji_ll + $trhjkm->jkm_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_brjs_ll + $trhjkm->jkm_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_up_ll + $trhjkm->jkm_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaljkm,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
            // Iuran BPJS 2111401         
            $hasil = $this->tukd_model->spj_trmpajak_rek($lcskpd,'2111401',$nbulan,'bpjs');
            $trhbpjs = $hasil->row();
            $totalbpjs = $trhbpjs->bpjs_up_ini + $trhbpjs->bpjs_up_ll + $trhbpjs->bpjs_gaji_ini + 
                        $trhbpjs->bpjs_gaji_ll + $trhbpjs->bpjs_brjs_ini + $trhbpjs->bpjs_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. BPJS</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_gaji_ll + $trhbpjs->bpjs_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_brjs_ll + $trhbpjs->bpjs_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_up_ll + $trhbpjs->bpjs_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalbpjs,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			

            // Denda Keterlambatan 4140611         
            $hasil = $this->tukd_model->spj_trmpajak_rek($lcskpd,'4140611',$nbulan,'dk');
            $trhdk = $hasil->row();
            $totaldk = $trhdk->dk_up_ini + $trhdk->dk_up_ll + $trhdk->dk_gaji_ini + 
                        $trhdk->dk_gaji_ll + $trhdk->dk_brjs_ini + $trhdk->dk_brjs_ll;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Denda Keterlambatan</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_gaji_ll + $trhdk->dk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_brjs_ll + $trhdk->dk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_up_ll + $trhdk->dk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaldk,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			*/
            // lain terima //copy2
            $tlainnot = "('2110401','2110601','2110305','2110301','2110701','2110303','2110201','2110302','2110901','2130101','2130201','2130401','2130301','2110702','2110703','2110501','2130501','2111201','2111301','2111001','2111101','2111401','4140611')";
            $csql = "SELECT 
					SUM(ISNULL(jlain_up_ll,0)) jlain_up_ll, SUM(ISNULL(jlain_up_ini,0)) jlain_up_ini, 
					SUM(ISNULL(jlain_gaji_ll,0)) jlain_gaji_ll, SUM(ISNULL(jlain_gaji_ini,0)) jlain_gaji_ini, 
					SUM(ISNULL(jlain_brjs_ll,0)) jlain_brjs_ll, SUM(ISNULL(jlain_brjs_ini,0)) jlain_brjs_ini
					 FROM(
					SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<'$nbulan' AND a.kd_rek5 NOT IN $tlainnot THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_up_ll,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)='$nbulan' AND a.kd_rek5 NOT IN $tlainnot THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_up_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' AND a.kd_rek5 NOT IN $tlainnot THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_gaji_ll,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' AND a.kd_rek5 NOT IN $tlainnot THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_gaji_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' AND a.kd_rek5 NOT IN $tlainnot THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_brjs_ll,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' AND a.kd_rek5 NOT IN $tlainnot THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_brjs_ini
					FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd='$lcskpd'
					UNION ALL
					SELECT 
					SUM(CASE WHEN MONTH(a.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS jlain_up_ll,
					SUM(CASE WHEN MONTH(a.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS jlain_up_ini,
					0 AS jlain_gaji_ll, 0 AS jlain_gaji_ini, 0 AS jlain_brjs_ll, 0 AS jlain_brjs_ini
					FROM tr_setorsimpanan_blud a WHERE jenis ='1'
					AND a.kd_skpd='$lcskpd'
					) a ";

			
			
					
					
				
            $hasil = $this->db->query($csql);
            $trh6 = $hasil->row();
            $totallain = $trh6->jlain_up_ini + $trh6->jlain_up_ll + $trh6->jlain_gaji_ini + 
                         $trh6->jlain_gaji_ll + $trh6->jlain_brjs_ini + $trh6->jlain_brjs_ll;
            
            //-------- TOTAL PENERIMAAN
            $jmtrmgaji_ll =  $trh1->sp2d_gj_ll+ $trh2->jppn_gaji_ll + $trh3->jpph21_gaji_ll +
                             $trh4->jpph22_gaji_ll + $trh5->jpph23_gaji_ll + $trh6->jlain_gaji_ll+
                             $trh72->gj_pph4_lalu;
            
            $jmtrmgaji_ini =  $trh1->sp2d_gj_ini + $trh2->jppn_gaji_ini + $trh3->jpph21_gaji_ini +
                              $trh4->jpph22_gaji_ini + $trh5->jpph23_gaji_ini + $trh6->jlain_gaji_ini+
                              $trh72->gj_pph4_ini;
                             
            $jmtrmgaji_sd = $jmtrmgaji_ll + $jmtrmgaji_ini;
            
            
            $jmtrmbrjs_ll =  $trh1->sp2d_brjs_ll + $trh2->jppn_brjs_ll + $trh3->jpph21_brjs_ll +
                             $trh4->jpph22_brjs_ll + $trh5->jpph23_brjs_ll + $trh6->jlain_brjs_ll +
                             $trh72->ls_pph4_lalu;
                                                                                                 
            $jmtrmbrjs_ini =  $trh1->sp2d_brjs_ini + $trh2->jppn_brjs_ini + $trh3->jpph21_brjs_ini +
                             $trh4->jpph22_brjs_ini + $trh5->jpph23_brjs_ini + $trh6->jlain_brjs_ini + 
                             $trh72->ls_pph4_ini;
                             
            $jmtrmbrjs_sd = $jmtrmbrjs_ll + $jmtrmbrjs_ini;
            
            $jmtrmup_ll =  $trh1->sp2d_up_ll + $trh2->jppn_up_ll + $trh3->jpph21_up_ll +
                             $trh4->jpph22_up_ll + $trh5->jpph23_up_ll + $trh6->jlain_up_ll+
                             $trh72->up_pph4_lalu;                           
            
            $jmtrmup_ini =  $trh1->sp2d_up_ini + $trh2->jppn_up_ini + $trh3->jpph21_up_ini +
                             $trh4->jpph22_up_ini + $trh5->jpph23_up_ini + $trh6->jlain_up_ini + 
                             $trh72->up_pph4_ini;
            
            $jmtrmup_sd = $jmtrmup_ll + $jmtrmup_ini;

            
            $cRet .="
                       
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Lain-lain</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_gaji_ll + $trh6->jlain_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_brjs_ll + $trh6->jlain_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh6->jlain_up_ll + $trh6->jlain_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totallain,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">Jumlah Penerimaan :</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmbrjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmbrjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmbrjs_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmup_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmup_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmup_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_sd + $jmtrmbrjs_sd + $jmtrmup_sd,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr> 
           
           
            
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"center\" style=\"font-size:12px\" colspan=\"2\">&nbsp;</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">Pengeluaran :</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

           $csql = "SELECT sum(gaji_lalu) as spj_gaji_ll, sum(gaji_ini) as spj_gaji_ini, sum(brg_lalu) as spj_brjs_ll, 
				sum(brg_ini) as spj_brjs_ini, sum(up_lalu) as spj_up_ll, sum(up_ini) as spj_up_ini from
				(SELECT a. kd_kegiatan, a.kd_rek_blud kd_rek5
				,SUM(CASE WHEN MONTH(b.tgl_bukti)='$nbulan' AND jns_spp in ('1','2','3','10') THEN a.nilai ELSE 0 END) AS up_ini
				,SUM(CASE WHEN MONTH(b.tgl_bukti)<'$nbulan' AND jns_spp in ('1','2','3','10') THEN a.nilai ELSE 0 END) AS up_lalu
				,SUM(CASE WHEN MONTH(b.tgl_bukti)='$nbulan' AND jns_spp in ('4') THEN a.nilai ELSE 0 END) AS gaji_ini
				,SUM(CASE WHEN MONTH(b.tgl_bukti)<'$nbulan' AND jns_spp in ('4') THEN a.nilai ELSE 0 END) AS gaji_lalu
				,SUM(CASE WHEN MONTH(b.tgl_bukti)='$nbulan' AND jns_spp in ('5','6') THEN a.nilai ELSE 0 END) AS brg_ini
				,SUM(CASE WHEN MONTH(b.tgl_bukti)<'$nbulan' AND jns_spp in ('5','6') THEN a.nilai ELSE 0 END) AS brg_lalu
				from trdtransout_blud a join trhtransout_blud b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd='$lcskpd' AND jenis<>'3' AND YEAR(tgl_bukti)='$thn_ang' GROUP BY a.kd_kegiatan, a.kd_rek_blud
				UNION ALL
				SELECT a. kd_kegiatan, a.kd_rek_blud kd_rek5
				,SUM(CASE WHEN MONTH(b.tgl_bukti)='$nbulan' AND jns_spp in ('1','2','3','10') THEN a.nilai*-1 ELSE 0 END) AS up_ini
				,SUM(CASE WHEN MONTH(b.tgl_bukti)<'$nbulan' AND jns_spp in ('1','2','3','10') THEN a.nilai*-1 ELSE 0 END) AS up_lalu
				,SUM(CASE WHEN MONTH(b.tgl_bukti)='$nbulan' AND jns_spp in ('4') THEN a.nilai*-1 ELSE 0 END) AS gaji_ini
				,SUM(CASE WHEN MONTH(b.tgl_bukti)<'$nbulan' AND jns_spp in ('4') THEN a.nilai*-1 ELSE 0 END) AS gaji_lalu
				,SUM(CASE WHEN MONTH(b.tgl_bukti)='$nbulan' AND jns_spp in ('5','6') THEN a.nilai*-1 ELSE 0 END) AS brg_ini
				,SUM(CASE WHEN MONTH(b.tgl_bukti)<'$nbulan' AND jns_spp in ('5','6') THEN a.nilai*-1 ELSE 0 END) AS brg_lalu
				from trdtransout_blud a join trhtransout_blud b on a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd='$lcskpd' AND jenis='3' AND YEAR(tgl_bukti)='$thn_ang' GROUP BY a.kd_kegiatan, a.kd_rek_blud
				UNION ALL
				SELECT a.kd_kegiatan, a.kd_rek_blud kd_rek5
				,SUM(CASE WHEN MONTH(b.tgl_sts)='$nbulan' and b.jns_trans=5 and b.jns_spp in ('1','2','3','10') THEN a.rupiah*-1 ELSE 0 END) AS up_ini
				,SUM(CASE WHEN MONTH(b.tgl_sts)<'$nbulan' and b.jns_trans=5 and b.jns_spp in ('1','2','3','10') THEN a.rupiah*-1 ELSE 0 END) AS up_lalu
				,SUM(CASE WHEN MONTH(b.tgl_sts)='$nbulan' and b.jns_trans=5 and b.jns_spp in ('4') THEN a.rupiah*-1 ELSE 0 END) AS gaji_ini
				,SUM(CASE WHEN MONTH(b.tgl_sts)<'$nbulan' and b.jns_trans=5 and b.jns_spp in ('4') THEN a.rupiah*-1 ELSE 0 END) AS gaji_lalu
				,SUM(CASE WHEN MONTH(b.tgl_sts)='$nbulan' and b.jns_trans=5 and b.jns_spp in ('5','6') THEN a.rupiah*-1 ELSE 0 END) AS brg_ini
				,SUM(CASE WHEN MONTH(b.tgl_sts)<'$nbulan' and b.jns_trans=5 and b.jns_spp in ('5','6') THEN a.rupiah*-1 ELSE 0 END) AS brg_lalu
				from trdkasin_blud a join trhkasin_blud b on a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd
				WHERE b.kd_skpd='$lcskpd' AND LEFT(a.kd_rek5,1)='5' AND YEAR(tgl_sts)='$thn_ang' GROUP BY a.kd_kegiatan, a.kd_rek_blud) a ";


           
           $hasil = $this->db->query($csql);
           $trh7 = $hasil->row(); 
           $totalspj = $trh7->spj_gaji_ll + $trh7->spj_gaji_ini + $trh7->spj_brjs_ll + 
                       $trh7->spj_brjs_ini + $trh7->spj_up_ll + $trh7->spj_up_ini;
                                                            
           $cRet .="
            <tr>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;- SPJ(LS + UP/GU/TU)</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_gaji_ini + $trh7->spj_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_brjs_ini + $trh7->spj_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh7->spj_up_ini + $trh7->spj_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalspj,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            <tr>
			<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;- Penyetoran Pajak</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
           $lcrek = '2110401';//'2110601'; // ppn dan IWP setor
           $csql = "SELECT (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jppn_up_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jppn_up_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jppn_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jppn_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jppn_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jppn_brjs_ll";
            
           $hasil = $this->db->query($csql);
           $trh8 = $hasil->row();
           $totalppn = $trh8->jppn_up_ini + $trh8->jppn_up_ll + $trh8->jppn_gaji_ini + 
                        $trh8->jppn_gaji_ll + $trh8->jppn_brjs_ini + $trh8->jppn_brjs_ll;
            
            $cRet .="
            <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;a. PPN</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_gaji_ll + $trh8->jppn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_brjs_ll + $trh8->jppn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh8->jppn_up_ll + $trh8->jppn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalppn,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            
            $lcrek = '2110301';//'2110701';// pph 21 dan pihak ketiga setor
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph21_up_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph21_up_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph21_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph21_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph21_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph21_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh9 = $hasil->row();
            $totalpph21 = $trh9->jpph21_up_ini + $trh9->jpph21_up_ll + $trh9->jpph21_gaji_ini + 
                          $trh9->jpph21_gaji_ll + $trh9->jpph21_brjs_ini + $trh9->jpph21_brjs_ll;
            
            
            $cRet .="
             <tr> <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;b. PPH 21</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_gaji_ll + $trh9->jpph21_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_brjs_ll + $trh9->jpph21_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh9->jpph21_up_ll + $trh9->jpph21_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph21,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            $lcrek = '2110302';//'2110201';// pph 22 dan iuran jaminan kesehatan setor
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph22_up_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph22_up_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph22_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph22_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph22_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph22_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh10 = $hasil->row();
            $totalpph22 = $trh10->jpph22_up_ini + $trh10->jpph22_up_ll + $trh10->jpph22_gaji_ini + 
                        $trh10->jpph22_gaji_ll + $trh10->jpph22_brjs_ini + $trh10->jpph22_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;c. PPH 22</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_gaji_ll + $trh10->jpph22_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_brjs_ll + $trh10->jpph22_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh10->jpph22_up_ll + $trh10->jpph22_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph22,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            $lcrek = '2110303';//'2110901';// pph 23 dan iuran jaminan ketenagakerjaan setor
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph23_up_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10','')) AS jpph23_up_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph23_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS jpph23_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph23_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS jpph23_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh11 = $hasil->row();
            $totalpph23 = $trh11->jpph23_up_ini + $trh11->jpph23_up_ll + $trh11->jpph23_gaji_ini + 
                        $trh11->jpph23_gaji_ll + $trh11->jpph23_brjs_ini + $trh11->jpph23_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;d. PPH 23</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_gaji_ll + $trh11->jpph23_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_brjs_ll + $trh11->jpph23_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh11->jpph23_up_ll + $trh11->jpph23_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph23,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

			$lcrek = '2110305'; // pph4 ayat 1
            $csql = "SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10','') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS up_pph4_lalu,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10','') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS up_pph4_ini,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10','') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS up_pph4_sdini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS gj_pph4_lalu,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_pph4_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_pph4_sdini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS ls_pph4_lalu,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_pph4_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_pph4_sdini
					FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_rek5='$lcrek' AND a.kd_skpd='$lcskpd'";
                    //echo($csql);
            
            $hasil = $this->db->query($csql);
            $trh75 = $hasil->row();
            $totalpph4_setor = $trh75->up_pph4_sdini + $trh75->gj_pph4_sdini + $trh75->ls_pph4_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;&ensp;&ensp;e. PPh Pasal 4</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->gj_pph4_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->gj_pph4_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->gj_pph4_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->ls_pph4_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->ls_pph4_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->ls_pph4_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->up_pph4_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->up_pph4_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh75->up_pph4_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalpph4_setor,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

			
			/*
			$lcrek = "('2110701','2110702','2110703')"; // IWP
            $csql = "SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS up_iwp_lalu,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS up_iwp_ini,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS up_iwp_sdini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS gj_iwp_lalu,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_iwp_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_iwp_sdini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS ls_iwp_lalu,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_iwp_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_iwp_sdini
					FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_rek5 in $lcrek AND a.kd_skpd='$lcskpd'";
            
            $hasil = $this->db->query($csql);
            $trh73 = $hasil->row();
            $totaliwp_setor = $trh73->up_iwp_sdini + $trh73->gj_iwp_sdini + $trh73->ls_iwp_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. IWP</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->gj_iwp_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->gj_iwp_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->gj_iwp_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->ls_iwp_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->ls_iwp_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->ls_iwp_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->up_iwp_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->up_iwp_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh73->up_iwp_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaliwp_setor,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			$lcrek = '2110501'; // TAPERUM
            $csql = "SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS up_tap_lalu,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS up_tap_ini,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3','10') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS up_tap_sdini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS gj_tap_lalu,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_tap_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS gj_tap_sdini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<'$nbulan' THEN  a.nilai ELSE 0 END) AS ls_tap_lalu,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_tap_ini,
					SUM(CASE WHEN b.jns_spp IN ('5','6') AND MONTH(b.tgl_bukti)<='$nbulan' THEN  a.nilai ELSE 0 END) AS ls_tap_sdini
					FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_rek5='$lcrek' AND a.kd_skpd='$lcskpd'";
            
            $hasil = $this->db->query($csql);
            $trh74 = $hasil->row();
            $totaltap_setor = $trh74->up_tap_sdini + $trh74->gj_tap_sdini + $trh74->ls_tap_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Taperum</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->gj_tap_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->gj_tap_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->gj_tap_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->ls_tap_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->ls_tap_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->ls_tap_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->up_tap_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->up_tap_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh74->up_tap_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaltap_setor,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			 $lcrek = '2111001'; // PPnpn 2%
            $csql = "SELECT (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10')) AS ppnpn_up_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('1','2','3','10')) AS ppnpn_up_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('4')) AS ppnpn_gaji_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('4')) AS ppnpn_gaji_ll,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)='$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS ppnpn_brjs_ini,
                    (SELECT SUM(b.nilai) FROM trhstrpot_blud a INNER JOIN trdstrpot_blud b
                    ON a.no_bukti = b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd = '$lcskpd' AND 
                    b.kd_rek5 = '$lcrek' AND MONTH(a.tgl_bukti)<'$nbulan' AND 
                    a.jns_spp IN ('5','6')) AS ppnpn_brjs_ll";
            
            $hasil = $this->db->query($csql);
            $trh16 = $hasil->row();
            $totalppnpn = $trh16->ppnpn_up_ini + $trh16->ppnpn_up_ll + $trh16->ppnpn_gaji_ini + 
                        $trh16->ppnpn_gaji_ll + $trh16->ppnpn_brjs_ini + $trh16->ppnpn_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib PPNPN 2%</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_gaji_ll + $trh16->ppnpn_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_brjs_ll + $trh16->ppnpn_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh16->ppnpn_up_ll + $trh16->ppnpn_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalppnpn,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            // PPnpn 3% 2111101
            $hasil = $this->tukd_model->spj_strpajak_rek($lcskpd,'2111101',$nbulan,'PPnPn3');
            $trhPPnPn3 = $hasil->row();
            $totalPPnPn3 = $trhPPnPn3->PPnPn3_up_ini + $trhPPnPn3->PPnPn3_up_ll + $trhPPnPn3->PPnPn3_gaji_ini + 
                        $trhPPnPn3->PPnPn3_gaji_ll + $trhPPnPn3->PPnPn3_brjs_ini + $trhPPnPn3->PPnPn3_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib PPNPN 3%</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_gaji_ll + $trhPPnPn3->PPnPn3_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_brjs_ll + $trhPPnPn3->PPnPn3_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhPPnPn3->PPnPn3_up_ll + $trhPPnPn3->PPnPn3_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalPPnPn3,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

            // JKK 2111201   
            $hasil = $this->tukd_model->spj_strpajak_rek($lcskpd,'2111201',$nbulan,'jkk');
            $trhjkk = $hasil->row();
            $totaljkk = $trhjkk->jkk_up_ini + $trhjkk->jkk_up_ll + $trhjkk->jkk_gaji_ini + 
                        $trhjkk->jkk_gaji_ll + $trhjkk->jkk_brjs_ini + $trhjkk->jkk_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib JKK</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_gaji_ll + $trhjkk->jkk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_brjs_ll + $trhjkk->jkk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkk->jkk_up_ll + $trhjkk->jkk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaljkk,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

            // JKM 2111301   
            $hasil = $this->tukd_model->spj_strpajak_rek($lcskpd,'2111301',$nbulan,'jkm');
            $trhjkm = $hasil->row();
            $totaljkm = $trhjkm->jkm_up_ini + $trhjkm->jkm_up_ll + $trhjkm->jkm_gaji_ini + 
                        $trhjkm->jkm_gaji_ll + $trhjkm->jkm_brjs_ini + $trhjkm->jkm_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Iuran Wajib JKM</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_gaji_ll + $trhjkm->jkm_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_brjs_ll + $trhjkm->jkm_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhjkm->jkm_up_ll + $trhjkm->jkm_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaljkm,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

            // Pot. BPJS 2111401   
            $hasil = $this->tukd_model->spj_strpajak_rek($lcskpd,'2111401',$nbulan,'bpjs');
            $trhbpjs = $hasil->row();
            $totalbpjs = $trhbpjs->bpjs_up_ini + $trhbpjs->bpjs_up_ll + $trhbpjs->bpjs_gaji_ini + 
                        $trhbpjs->bpjs_gaji_ll + $trhbpjs->bpjs_brjs_ini + $trhbpjs->bpjs_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. BPJS</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_gaji_ll + $trhbpjs->bpjs_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_brjs_ll + $trhbpjs->bpjs_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhbpjs->bpjs_up_ll + $trhbpjs->bpjs_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalbpjs,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
			// HKPG
            $csql = "SELECT 
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '3' and MONTH(tgl_sts)<'$nbulan' then a.rupiah else 0 end),0)) AS up_hkpg_lalu,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '3' and MONTH(tgl_sts)='$nbulan' then a.rupiah else 0 end),0)) AS up_hkpg_ini,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '3' and MONTH(tgl_sts)<='$nbulan' then a.rupiah else 0 end),0)) AS up_hkpg_sdini,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '2' and MONTH(tgl_sts)<'$nbulan' then a.rupiah else 0 end),0)) AS ls_hkpg_lalu,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '2' and MONTH(tgl_sts)='$nbulan' then a.rupiah else 0 end),0)) AS ls_hkpg_ini,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '2' and MONTH(tgl_sts)<='$nbulan' then a.rupiah else 0 end),0)) AS ls_hkpg_sdini,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '1' and MONTH(tgl_sts)<'$nbulan' then a.rupiah else 0 end),0)) AS gj_hkpg_lalu,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '1' and MONTH(tgl_sts)='$nbulan' then a.rupiah else 0 end),0)) AS gj_hkpg_ini,
				SUM(isnull((case when pot_khusus='1' AND rtrim(jns_cp)= '1' and MONTH(tgl_sts)<='$nbulan' then a.rupiah else 0 end),0)) AS gj_hkpg_sdini
				FROM trdkasin_pkd a 
				INNER JOIN trhkasin_pkd b on a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd ='$lcskpd' AND jns_trans='5'";
							
            $hasil = $this->db->query($csql);
            $trhxx = $hasil->row();
            $totalhkpg = $trhxx->up_hkpg_sdini + $trhxx->gj_hkpg_sdini + $trhxx->ls_hkpg_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- HKPG</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->gj_hkpg_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->gj_hkpg_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->gj_hkpg_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->ls_hkpg_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->ls_hkpg_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->ls_hkpg_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->up_hkpg_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->up_hkpg_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxx->up_hkpg_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totalhkpg,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			
			// Potongan Penghasilan Lainnya
            $csql = "SELECT 
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '3' and MONTH(tgl_sts)<'$nbulan'  then a.rupiah else 0 end),0)) AS up_lain_lalu,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '3' and MONTH(tgl_sts)='$nbulan'  then a.rupiah else 0 end),0)) AS up_lain_ini,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '3' and MONTH(tgl_sts)<='$nbulan'  then a.rupiah else 0 end),0)) AS up_lain_sdini,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '2' and MONTH(tgl_sts)<'$nbulan'  then a.rupiah else 0 end),0)) AS ls_lain_lalu,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '2' and MONTH(tgl_sts)='$nbulan'  then a.rupiah else 0 end),0)) AS ls_lain_ini,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '2' and MONTH(tgl_sts)<='$nbulan'  then a.rupiah else 0 end),0)) AS ls_lain_sdini,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '1' and MONTH(tgl_sts)<'$nbulan'  then a.rupiah else 0 end),0)) AS gj_lain_lalu,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '1' and MONTH(tgl_sts)='$nbulan'  then a.rupiah else 0 end),0)) AS gj_lain_ini,
				SUM(isnull((case when pot_khusus='2' AND rtrim(jns_cp)= '1' and MONTH(tgl_sts)<='$nbulan'  then a.rupiah else 0 end),0)) AS gj_lain_sdini
				FROM trdkasin_pkd a 
				INNER JOIN trhkasin_pkd b on a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
				WHERE a.kd_skpd ='$lcskpd' AND jns_trans='5'";
							
            $hasil = $this->db->query($csql);
            $trhxy = $hasil->row();
            $totallain = $trhxy->up_lain_sdini + $trhxy->gj_lain_sdini + $trhxy->ls_lain_sdini;
            
            
            $cRet .="
             <tr><td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Pot. Penghasilan Lainnya</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->gj_lain_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->gj_lain_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->gj_lain_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->ls_lain_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->ls_lain_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->ls_lain_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->up_lain_lalu,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->up_lain_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhxy->up_lain_sdini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totallain,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			*/
            // SETOR KAS
            $csql = "select 
			SUM(isnull((case when rtrim(jns_spp) IN ('1','2','3','10') and MONTH(tgl_sts)='$nbulan' then c.rupiah else 0 end),0)) AS cp_spj_up_ini,
			SUM(isnull((case when rtrim(jns_spp) IN ('1','2','3','10') and MONTH(tgl_sts)<'$nbulan' then c.rupiah else 0 end),0)) AS cp_spj_up_ll,
			SUM(isnull((case when rtrim(jns_spp) IN ('4') and MONTH(tgl_sts)='$nbulan' then c.rupiah else 0 end),0)) AS cp_spj_gaji_ini,
			SUM(isnull((case when rtrim(jns_spp) IN ('4') and MONTH(tgl_sts)<'$nbulan' then c.rupiah else 0 end),0)) AS cp_spj_gaji_ll,
			SUM(isnull((case when rtrim(jns_spp) IN ('5','6') and MONTH(tgl_sts)='$nbulan' then c.rupiah else 0 end),0)) AS cp_spj_brjs_ini,
			SUM(isnull((case when rtrim(jns_spp) IN ('5','6') and MONTH(tgl_sts)<'$nbulan' then c.rupiah else 0 end),0)) AS cp_spj_brjs_ll
			from trdkasin_blud c INNER JOIN trhkasin_blud d ON c.no_sts = d.no_sts AND c.kd_skpd = d.kd_skpd where d.kd_skpd ='$lcskpd' AND 
			jns_trans IN ('5','1','6') AND LEFT(c.kd_rek5,1) not in ('4') ";
            
            $hasil = $this->db->query($csql);
            $trh_x = $hasil->row();
            $total_cp = $trh_x->cp_spj_up_ini + $trh_x->cp_spj_up_ll + $trh_x->cp_spj_gaji_ini + 
                        $trh_x->cp_spj_gaji_ll + $trh_x->cp_spj_brjs_ini + $trh_x->cp_spj_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Setor Kas</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_gaji_ll + $trh_x->cp_spj_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_brjs_ll + $trh_x->cp_spj_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh_x->cp_spj_up_ll + $trh_x->cp_spj_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($total_cp,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            /*
            // Denda Keterlambatan 4140611   
            $hasil = $this->tukd_model->spj_strpajak_rek($lcskpd,'4140611',$nbulan,'dk');
            $trhdk = $hasil->row();
            $totaldk = $trhdk->dk_up_ini + $trhdk->dk_up_ll + $trhdk->dk_gaji_ini + 
                        $trhdk->dk_gaji_ll + $trhdk->dk_brjs_ini + $trhdk->dk_brjs_ll;
            
            
            $cRet .="
             <tr>
			 <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Denda Keterlambatan</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_gaji_ll + $trhdk->dk_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_brjs_ll + $trhdk->dk_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_up_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trhdk->dk_up_ll + $trhdk->dk_up_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totaldk,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
            
            */
            // lain lain setoran
            $notlain2 = "('2110401','2110601','2110305','2110301','2110701','2110303','2110201','2110302','2110901','2130101','2130201','2130401','2130301','2110702','2110703','2110501','2130501','2111201','2111301','2111001','2111101','2111401','4140611')";
          $csql = "SELECT 
					SUM(ISNULL(jlain_up_ll,0)) jlain_up_ll, SUM(ISNULL(jlain_up_ini,0)) jlain_up_ini, 
					SUM(ISNULL(jlain_gaji_ll,0)) jlain_gaji_ll, SUM(ISNULL(jlain_gaji_ini,0)) jlain_gaji_ini, 
					SUM(ISNULL(jlain_brjs_ll,0)) jlain_brjs_ll, SUM(ISNULL(jlain_brjs_ini,0)) jlain_brjs_ini
					 FROM(
					SELECT 
					SUM(CASE WHEN b.jns_spp IN ('1','2','3') AND MONTH(b.tgl_bukti)<'$nbulan' AND a.kd_rek5 NOT IN $notlain2 THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_up_ll,
					SUM(CASE WHEN b.jns_spp IN ('1','2','3') AND MONTH(b.tgl_bukti)='$nbulan' AND a.kd_rek5 NOT IN $notlain2 THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_up_ini,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)<'$nbulan' AND a.kd_rek5 NOT IN $notlain2 THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_gaji_ll,
					SUM(CASE WHEN b.jns_spp IN ('4') AND MONTH(b.tgl_bukti)='$nbulan' AND a.kd_rek5 NOT IN $notlain2 THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_gaji_ini,
					SUM(CASE WHEN b.jns_spp IN ('6') AND MONTH(b.tgl_bukti)<'$nbulan' AND a.kd_rek5 NOT IN $notlain2 THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_brjs_ll,
					SUM(CASE WHEN b.jns_spp IN ('6') AND MONTH(b.tgl_bukti)='$nbulan' AND a.kd_rek5 NOT IN $notlain2 THEN  ISNULL(a.nilai,0) ELSE 0 END) AS jlain_brjs_ini
					FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					WHERE a.kd_skpd='$lcskpd'
					) a ";
            $hasil = $this->db->query($csql);
            $trh12 = $hasil->row();
            $totallain = $trh12->jlain_up_ini + $trh12->jlain_up_ll + $trh12->jlain_gaji_ini + 
                         $trh12->jlain_gaji_ll + $trh12->jlain_brjs_ini + $trh12->jlain_brjs_ll;
            
            $tox_ini = 0;
            $tox_ini=(empty($tox_ini)?0:$tox_ini);
			$tox_ll = 0;
            $tox_ll=(empty($tox_ll)?0:$tox_ll);
			
            $jmsetgaji_ll =  $trh7->spj_gaji_ll+ $trh8->jppn_gaji_ll + $trh9->jpph21_gaji_ll + 
                             $trh10->jpph22_gaji_ll + $trh11->jpph23_gaji_ll + $trh12->jlain_gaji_ll+ 
                             $trh_x->cp_spj_gaji_ll+$trh75->gj_pph4_lalu;
            
            $jmsetgaji_ini = $trh7->spj_gaji_ini + $trh8->jppn_gaji_ini + $trh9->jpph21_gaji_ini + 
                             $trh10->jpph22_gaji_ini + $trh11->jpph23_gaji_ini + $trh12->jlain_gaji_ini+
                             $trh_x->cp_spj_gaji_ini+$trh75->gj_pph4_ini;
                             
            $jmsetgaji_sd = $jmsetgaji_ll + $jmsetgaji_ini;
            
            
            $jmsetbrjs_ll =  $trh7->spj_brjs_ll + $trh8->jppn_brjs_ll + $trh9->jpph21_brjs_ll + 
                             $trh10->jpph22_brjs_ll + $trh11->jpph23_brjs_ll + $trh12->jlain_brjs_ll+$trh_x->cp_spj_brjs_ll+
							 $trh75->ls_pph4_lalu;
                                                                                                 
            $jmsetbrjs_ini =  $trh7->spj_brjs_ini + $trh8->jppn_brjs_ini + $trh9->jpph21_brjs_ini  +
                             $trh10->jpph22_brjs_ini + $trh11->jpph23_brjs_ini + $trh12->jlain_brjs_ini+
                             $trh_x->cp_spj_brjs_ini+$trh75->ls_pph4_ini;
                             
            $jmsetbrjs_sd = $jmsetbrjs_ll + $jmsetbrjs_ini;
            /* 
            $jmsetup_ll =  $trh7->spj_up_ll + $trh8->jppn_up_ll + $trh9->jpph21_up_ll +
                             $trh10->jpph22_up_ll + $trh11->jpph23_up_ll + $trh12->jlain_up_ll; */
            
            $jmsetup_ll =  $trh7->spj_up_ll + $trh8->jppn_up_ll + $trh9->jpph21_up_ll + 
                             $trh10->jpph22_up_ll + $trh11->jpph23_up_ll + $trh12->jlain_up_ll +$trh_x->cp_spj_up_ll+
							 $trh75->up_pph4_lalu;                             
            
            $jmsetup_ini =  $trh7->spj_up_ini + $trh8->jppn_up_ini + $trh9->jpph21_up_ini +
                             $trh10->jpph22_up_ini + $trh11->jpph23_up_ini + $trh12->jlain_up_ini+$trh_x->cp_spj_up_ini+
							 $trh75->up_pph4_ini;
            
            $jmsetup_sd = $jmsetup_ll + $jmsetup_ini;
            
			
            
            $cRet .="
                       
            <tr>
			<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">&ensp;&ensp;- Lain-lain</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_gaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_gaji_ll + $trh12->jlain_gaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_brjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_brjs_ll + $trh12->jlain_brjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_up_ll+$tox_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_up_ini+$tox_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($trh12->jlain_up_ll + $trh12->jlain_up_ini+$tox_ll+$tox_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($totallain,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";

            $cRet .="
            <tr>
			<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">Jumlah Pengeluaran :</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetgaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetgaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetgaji_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetbrjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetbrjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetbrjs_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetup_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetup_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetup_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmsetgaji_sd + $jmsetbrjs_sd + $jmsetup_sd,"2",",",".")."&nbsp;</td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>";
			/*
            $tox_awal="SELECT isnull(sld_awal,0) AS jumlah,sld_awalpajak FROM ms_skpd_blud where kd_skpd='$lcskpd'";
            $hasil = $this->db->query($tox_awal);
            $tox = $hasil->row('jumlah');
            $sld_apjk = $hasil->row('sld_awalpajak');
			$t_sldawal = $tox + $sld_apjk;
			
            $hasil = $this->tukd_model->spj_tahunlalu($lcskpd,$nbulan);
            $trhspjthnll = $hasil->row();
            $uyhdthnlalu_ll = $trhspjthnll->jlain_up_ll;
            $uyhdthnlalu_ini = $trhspjthnll->jlain_up_ini;
            $pjkthnlalu_ll = $trhspjthnll->jlain_up_pjkll;
            $pjkthnlalu_ini = $trhspjthnll->jlain_up_pjkini;
            $uyhdthnlalu = $uyhdthnlalu_ll+$uyhdthnlalu_ini;
            $pjkthnlalu = $pjkthnlalu_ll+$pjkthnlalu_ini;
            $t_uyhdthnll = $t_sldawal - ($uyhdthnlalu_ll+$pjkthnlalu_ll);
            $t_uyhdthnini = 0 - ($uyhdthnlalu_ini+$pjkthnlalu_ini);
            $t_uyhdthn = $t_uyhdthnll + $t_uyhdthnini;
            $cRet.="
            <tr>
                <td>&ensp;&ensp;</td>
                <td colspan=\"2\">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
				<td>&ensp;&ensp;</td>
            </tr>

            <tr>
			<td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\" $fontc \" colspan=\"2\">UYHD Tahun Lalu</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">".number_format($tox,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">".number_format($tox,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($tox,"2",",",".")."</td>
				<td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            <tr>
                <td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\" $fontc \" colspan=\"2\">Pajak Tahun Lalu</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">".number_format($sld_apjk,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">".number_format($sld_apjk,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($sld_apjk,"2",",",".")."</td>
				<td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
            </tr>

            <tr>
			<td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\" $fontc \" colspan=\"2\">Penyetoran UYHD Tahun Lalu</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">".number_format($uyhdthnlalu_ll,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($uyhdthnlalu_ini,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($uyhdthnlalu,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($uyhdthnlalu,"2",",",".")."</td>
				<td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            <tr>
                <td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\" $fontc \" colspan=\"2\">Penyetoran Pajak Tahun Lalu</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">0,00</td>
                <td align=\"right\" style=\" $fontc \">".number_format($pjkthnlalu_ll,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($pjkthnlalu_ini,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($pjkthnlalu,"2",",",".")."</td>
                <td align=\"right\" style=\" $fontc \">".number_format($pjkthnlalu,"2",",",".")."</td>
				<td align=\"left\" style=\" $fontc border-top:hidden;\">&ensp;&ensp;</td>
            </tr>*/
			$cRet.="	
            <tr>
			<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"center\" style=\"font-size:12px\" colspan=\"2\">&nbsp;</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            <tr>
			<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"left\" style=\"font-size:12px\" colspan=\"2\">Saldo Kas</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_ll - $jmsetgaji_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_ini - $jmsetgaji_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_sd - $jmsetgaji_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmbrjs_ll - $jmsetbrjs_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmbrjs_ini - $jmsetbrjs_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmbrjs_sd - $jmsetbrjs_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmup_ll - $jmsetup_ll,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmup_ini - $jmsetup_ini,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmup_sd - $jmsetup_sd,"2",",",".")."&nbsp;</td>
                <td align=\"right\" style=\"font-size:12px\">".number_format($jmtrmgaji_sd + $jmtrmbrjs_sd + $jmtrmup_sd - $jmsetgaji_sd - $jmsetbrjs_sd - $jmsetup_sd,"2",",",".")."&nbsp;</td>
           <td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
		   </tr>
            <tr>
			<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
                <td align=\"center\" style=\"font-size:12px\" colspan=\"2\">&nbsp;</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
				<td align=\"left\" style=\"font-size:12px;border-top:hidden;\">&ensp;&ensp;</td>
            </tr>
            </table>";
		
		if($jenis=='1'){
		    $cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tukd_model->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b><u>'.$nama2.'</u></b> <br> '.$pangkat.' </TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b><u>'.$nama1.'</u></b><br> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" >NIP. '.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >NIP. '.$nip1.'</TD>
					</TR>
					</TABLE><br/>';
	   } else if ($jenis=='2'){
		    $cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$daerah.', '.$this->tukd_model->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$jabatan1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" > </TD>
						<TD width="50%" align="center" ><b><u>'.$nama1.'</u></b><br> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >NIP. '.$nip1.'</TD>
					</TR>
					</TABLE><br/>';
	   } else {
		    $cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$daerah.', '.$this->tukd_model->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" > </TD>
						<TD width="50%" align="center" ><b><u>'.$nama2.'</u></b><br> '.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >NIP. '.$nip.'</TD>
					</TR>
					</TABLE><br/>';
	   }
	   
	$data['prev']= $cRet;
	
    if($jenis==0){
        echo $cRet;
    }elseif ($jenis==1) {

        $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
    }elseif ($jenis==9) {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename= $judul.xls");
        echo $cRet;
    }
		
 

    } //end function




 
	
	function cetak_matrix_penerimaan_blud($lcskpd='',$ttd1='',$tgl_ctk='',$ctk='',$atas='', $bawah='', $kiri='', $kanan='', $jenis=''){
		$ttd1 = str_replace('123456789',' ',$ttd1);
		
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BP' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
				
		$tanda_ang=2;
        $thn_ang	   = $this->session->userdata('pcThang');
        
        $skpd = $lcskpd;
        $nama=  $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
		$prv = $this->db->query("SELECT * from sclient_blud");
		$prvn = $prv->row();          
		$prov = $prvn->provinsi;         
		$daerah = $prvn->daerah;
        
        $font = 12;
        $fontc = 'font-size:'.$font.'px;';
        $cRet = '';
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">
                 <b> MATRIX PENERIMAAN TAHUN  $thn_ang</b>
                </td>
            </tr>
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">
                 <b> $nama </b>
                </td>
            </tr>
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\">
                 <b>&nbsp;</b>
                </td>
            </tr>
			
            </table>
            <table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <thead>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Kode<br>Rekening</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Uraian</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Target</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"12\" style=\"font-size:12px\"><b>Penyampaian Realisasi </br>(RP)</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\"><b>Jumlah</b></td>
            </tr>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Januari</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Februari</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Maret</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>April</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Mei</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Juni</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Juli</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Agustus</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>September</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Oktober</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>November</b></td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\"><b>Desember</b></td>
            </tr>                 
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">1</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">2</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">3</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">4</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">5</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">6</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">7</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">8</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">9</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">10</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">11</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">12</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">13</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">14</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">15</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">16</td>
            </tr> 
             </thead>
            <tr>
                <td align=\"center\" style=\"font-size:12px\">&nbsp;</td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
                <td align=\"center\" style=\"font-size:12px\"></td>
            </tr>";

				$att="exec matrix_terima '$lcskpd','$thn_ang' ";
				$hasil=$this->db->query($att);
				foreach ($hasil->result() as $trh1){
				$prof			=	$trh1->kd_rek5;
				$ali				=	$trh1->uraian;
				$nilai			=	$trh1->n_angg;
				$iml_nilai			=	$trh1->jml;
				$real_jan		=	$trh1->spj_jan;
				$real_feb	=	$trh1->spj_feb;
				$real_mar	=	$trh1->spj_mar;
				$real_apr	=	$trh1->spj_apr;
				$real_mei	=	$trh1->spj_mei;
				$real_jun		=	$trh1->spj_jun;
				$real_jul		=	$trh1->spj_jul;
				$real_ags	=	$trh1->spj_ags;
				$real_sep	=	$trh1->spj_sep;
				$real_okt		=	$trh1->spj_okt;
				$real_nov	=	$trh1->spj_nov;
				$real_des	=	$trh1->spj_des;
			$a=strlen($prof);
			
			if($a==8){
			$cRet .="
				<tr>
                <td valign=\"top\" width=\"8%\" align=\"left\" style=\"font-size:12px\" ><b>".$prof."</b></td>
                <td valign=\"top\" align=\"left\" width=\"25%\" style=\"font-size:12px\"><b>".$ali."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($nilai,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_jan,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_feb,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_mar,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_apr,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_mei,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_jun,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_jul,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_ags,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_sep,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_okt,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_nov,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_des,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($iml_nilai,"2",",",".")."</b></td>
            </tr>";
			}else{
				$cRet .="
				<tr>
                <td valign=\"top\" width=\"8%\" align=\"left\" style=\"font-size:12px\" >".$prof."</td>
                <td valign=\"top\" align=\"left\" width=\"25%\" style=\"font-size:12px\">".$ali."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($nilai,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_jan,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_feb,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_mar,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_apr,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_mei,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_jun,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_jul,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_ags,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_sep,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_okt,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_nov,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($real_des,"2",",",".")."</td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\">".number_format($iml_nilai,"2",",",".")."</td>
            </tr>";
			}
			}
			$att=" exec jml_matrix_terima '$lcskpd','$thn_ang' ";
				$hasil=$this->db->query($att);
				foreach ($hasil->result() as $trh1){
				$prof			=	$trh1->kd_rek5;
				$ali				=	$trh1->uraian;
				$nilai			=	$trh1->n_angg;
				$iml_nilai			=	$trh1->jml;
				$real_jan		=	$trh1->spj_jan;
				$real_feb	=	$trh1->spj_feb;
				$real_mar	=	$trh1->spj_mar;
				$real_apr	=	$trh1->spj_apr;
				$real_mei	=	$trh1->spj_mei;
				$real_jun		=	$trh1->spj_jun;
				$real_jul		=	$trh1->spj_jul;
				$real_ags	=	$trh1->spj_ags;
				$real_sep	=	$trh1->spj_sep;
				$real_okt		=	$trh1->spj_okt;
				$real_nov	=	$trh1->spj_nov;
				$real_des	=	$trh1->spj_des;


			$cRet .="
				<tr>
                <td valign=\"top\" width=\"8%\" align=\"left\" style=\"font-size:12px\" ><b>".$prof."</b></td>
                <td valign=\"top\" align=\"center\" width=\"25%\" style=\"font-size:12px\"><b>".$ali."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($nilai,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_jan,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_feb,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_mar,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_apr,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_mei,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_jun,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_jul,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_ags,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_sep,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_okt,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_nov,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($real_des,"2",",",".")."</b></td>
                <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($iml_nilai,"2",",",".")."</b></td>
            </tr>";
			}
			
        $cRet .="</table>";
	
			$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$daerah.', '.$this->tukd_model->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >'.$jabatan1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" > </TD>
						<TD width="50%" align="center" ><b><u>'.$nama1.'</u></b><br> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ></TD>
						<TD width="50%" align="center" >NIP. '.$nip1.'</TD>
					</TR>
					</TABLE><br/>';
	   
	   
	$data['prev']= $cRet;
	
        switch ($ctk)
        {
            case 0;
				echo ("<title>MATRIX PENERIMAAN</title>");
				echo $cRet;
                break; 
			case 1;
                $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
                break;
        }   
		
    }
 		
 
    function cetak_spj_pengeluaran($skpd='',$bulan='',$nip1='',$nip2='',$tgl_c='',$ver=''){
        $cetak=$ver;
        $lcskpd=$skpd;
        $nbulan=$bulan;
        $pa_=$nip1;
        $pa = str_replace('%20',' ',$pa_);
        $bk_=$nip2;
        $bk = str_replace('%20',' ',$bk_);
        $test=true;
        $spasi="";
        $tglttd=$tgl_c;
        $thn_ang       = $this->session->userdata('pcThang');

        if($cetak=='1'){
            $nilai_anggaran ='b.nilai';
        }else{
            $nilai_anggaran ='b.nilai_ubah';
        }
        
        $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }
        
         $nip="";        
         $nama="";       
         $jabatan="";
         $nip_1="";      
         $nama_1="";         
         $jabatan_1="";
            
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$lcskpd' and nip='$pa' and kode='PA'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                }
        
            $c2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$lcskpd' and nip='$bk' and kode='BK'";
                 $qc2=$this->db->query($c2);
                 foreach ($qc2->result() as $row_2)
                {
                    $nip_1=$row_2->nip;                    
                    $nama_1= $row_2->nm;
                    $jabatan_1  = $row_2->jab;
                }
        
        $skpd = $lcskpd;
        $nm_skpd=  $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $bulan= $this->tukd_model->getBulan($nbulan); 
        $cRet = '';
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\"><b>
                  $kab<br>
                  SURAT PENGESAHAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN<br>
                  (SPJ BELANJA)<br>&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\" width=\"25%\">
                  SKPD
                </td> 
                <td width=\"75%\" style=\"font-size:12px;\">: $skpd - $nm_skpd
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Pengguna Anggaran/Kuasa Pengguna Anggaran
                </td> 
                <td style=\"font-size:12px;\">: $nama
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Bendahara Pengeluaran
                </td> 
                <td style=\"font-size:12px;\">: $nama_1
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Tahun Anggaran
                </td> 
                <td style=\"font-size:12px;\">: $thn_ang
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Bulan
                </td> 
                <td style=\"font-size:12px;\">: $bulan
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\" colspan=\"2\">
                 &nbsp;
                </td> 
            </tr>

            </table>";

            $cRet    .="<table style=\"border-collapse:collapse; font-size:18px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <thead>
                        <tr>
                             <td rowspan=\"2\" width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Kode Rekening<b></td>
                             <td rowspan=\"2\" width=\"10%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Uraian</b></td>
                             <td rowspan=\"2\" width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Jumlah Anggaran<b></td>
                             <td colspan=\"3\" width=\"60%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Spj Blud<b></td>
                             <td rowspan=\"2\" width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Sisa Pagu<br>Anggaran<b></td>
                        </tr>

                        <tr>
                             <td width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>s.d Bln lalu<b></td>
                             <td width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Bulan ini</b></td>
                             <td width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>s.d Bln ini<b></td>
                             
                        </tr>
                        <tr>
                         <td align=\"center\">1</td>
                         <td align=\"center\">2</td>
                         <td align=\"center\">3</td>
                         <td align=\"center\">4</td>
                         <td align=\"center\">5</td>
                         <td align=\"center\">6</td>
                         <td align=\"center\">7</td>
                         
                    </tr>
                    </thead>
                    
                    <tfoot>
                        <tr>
                             <td colspan=\"7\" style=\"border-bottom:none;border-left:none;border-right:none;\"></td>
                        </tr>
                    </tfoot>
                    <tr>
                         <td style=\"border-bottom:none;border-top:none\" align=\"justify\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"justify\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"right\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         
                    </tr>
                    ";
         $sqlaf = $this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd, SUM($nilai_anggaran) AS nilai FROM trskpd a 
                                    JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
                                    WHERE LEFT(b.kd_rek7,2) IN ('51','52') and LEFT(b.kd_rek7,3) not in ('512', '513', '514', '515', '516', '517', '518') AND a.kd_skpd='$lcskpd'");
       
        foreach ($sqlaf->result() as $rs) {
            $kdskpd1        = $rs->skpd;
            $nilai1         = $rs->nilai;

            $sql11=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_bukti)<'$nbulan' ");
            $hasil11=mysql_fetch_assoc($sql11);
            $sql1=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_bukti)='$nbulan' ");
            $hasil1=mysql_fetch_assoc($sql1);
            $sql111=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_bukti)<='$nbulan' ");
            $hasil111=mysql_fetch_assoc($sql111);
            $cRet    .="<tr>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b></b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>BELANJA DAERAH</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1, "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                    </tr>";     

        }
        
        $sqlww=$this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd,a.kd_program AS program,a.nm_program AS nmprogram,SUM($nilai_anggaran) AS nilai FROM trskpd a 
        JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
        WHERE LEFT(b.kd_rek7,2) IN ('51','52') AND LEFT(b.kd_rek7, 3) not in ('512', '513', '514', '515', '516', '517', '518') AND a.kd_skpd='$lcskpd' GROUP BY a.kd_program order by kd_program1");
       

        $grand1=0;$grand2=0;$grand3=0;$grand4=0;$grand5=0;$grand6=0;$grand7=0;$grand8=0;$grand9=0;$grand9=0;$grand10=0;$tot=0;$sis=0;
        foreach($sqlww->result() as $roww){
            $kdskpd=$roww->skpd;
            $progw=$roww->program;
            $nmprogw=$roww->nmprogram;
            $nilaiw=$roww->nilai;

            if($test==true && substr($progw, 13) != '00.00'){
                    
                    $sqlaf = $this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd, SUM($nilai_anggaran) AS nilai FROM trskpd a 
                    JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
                    WHERE LEFT(b.kd_rek7,2) IN ('52') AND a.kd_skpd='$lcskpd'");
                

                    foreach ($sqlaf->result() as $rs) {
                            $kdskpd1        = $rs->skpd;
                            $nilai1         = $rs->nilai;

                            $sql11=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_bukti)<'$nbulan' and LEFT(b.kd_rek7,2)='52' ");
                            $hasil11=mysql_fetch_assoc($sql11);
                            $sql1=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_bukti)='$nbulan' and LEFT(b.kd_rek7,2)='52' ");
                            $hasil1=mysql_fetch_assoc($sql1);
                            $sql111=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_bukti)<='$nbulan' and LEFT(b.kd_rek7,2)='52' ");
                            $hasil111=mysql_fetch_assoc($sql111);

                          

                            $cRet    .="<tr>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>&nbsp;</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"> <b></b></td>
                                    </tr>
                                        <tr>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>BELANJA LANGSUNG</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1, "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                                    </tr>";     

                    }//end foreach
                    $test=false;   
            }// end if

             $sql11=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<'$nbulan' and left(b.kd_kegiatan,18)='$progw'");
            $hasil11=mysql_fetch_assoc($sql11);
            $sql1=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)='$nbulan' and left(b.kd_kegiatan,18)='$progw'");
            $hasil1=mysql_fetch_assoc($sql1);
            $sql111=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                               INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<='$nbulan' and left(b.kd_kegiatan,18)='$progw'");
            $hasil111=mysql_fetch_assoc($sql111);

          
            $cRet    .="<tr>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$progw</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$nmprogw</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilaiw, "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilaiw-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                    </tr>";



            $sql=$this->db->query(" SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd,a.kd_kegiatan AS program,a.nm_kegiatan AS nmprogram,SUM($nilai_anggaran) AS nilai FROM trskpd a 
            JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
            JOIN m_giat c on a.kd_kegiatan1=c.kd_kegiatan
            WHERE LEFT(b.kd_rek7,2) IN ('51','52') AND left(b.kd_rek7, 3) not in ('512', '513', '514', '515', '516', '517', '518') AND a.kd_skpd='$lcskpd' and a.kd_program='$progw' GROUP BY a.kd_kegiatan1 
            ");

            foreach($sql->result() as $row){
                    $kdskpd=$row->skpd;
                    $prog=$row->program;
                    $nmprog=$row->nmprogram;
                    $nilai=$row->nilai;
                    
                   $sql11=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                   INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<'$nbulan' and b.kd_kegiatan='$prog'");
                   $hasil11=mysql_fetch_assoc($sql11);
                   $sql1=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                   INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)='$nbulan' and b.kd_kegiatan='$prog'");
                   $hasil1=mysql_fetch_assoc($sql1);
                   $sql111=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                   INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<='$nbulan' and b.kd_kegiatan='$prog'");
                   $hasil111=mysql_fetch_assoc($sql111);

                   $grand1=$grand1+$nilai;

                   $cRet    .="<tr>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$prog</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$nmprog</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai, "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                    </tr>";


                    $sqlZ=$this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd,b.no_trdrka AS program,b.nm_rek7 AS nmprogram,SUM($nilai_anggaran) AS nilai FROM trskpd a 
                    JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
                    WHERE LEFT(b.kd_rek7,2) IN ('51','52') AND LEFT(b.kd_rek7, 3) not in ('512', '513', '514', '515', '516', '517', '518') AND a.kd_skpd='$kdskpd' AND b.kd_kegiatan ='$prog' GROUP BY b.no_trdrka
                    ORDER BY program");

                    foreach($sqlZ->result() as $row2){
                            $progy=$row2->program;
                            $nmprogy=$row2->nmprogram;
                            $nilaiy =$row2->nilai;

                           $sqlxx=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                           INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<'$nbulan' and b.kd_kegiatan='$prog' and b.kd_rek7=right('$progy',10)");
                           $hasilxx=mysql_fetch_assoc($sqlxx);
                           $sqlx=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                           INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)='$nbulan' and b.kd_kegiatan='$prog' and b.kd_rek7=right('$progy',10)");
                           $hasilx=mysql_fetch_assoc($sqlx);
                           $sqlxxx=mysql_query("SELECT SUM(nilai)AS nilai2 FROM trhtransout_blud a 
                           INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti WHERE a.jns_spp in ('10') AND a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<='$nbulan' and b.kd_kegiatan='$prog' and b.kd_rek7=right('$progy',10)");
                           $hasilxxx=mysql_fetch_assoc($sqlxxx);

                           $cRet    .="<tr>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\">$progy</td>
                                     <td width=\"30%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\">$nmprogy</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($nilaiy, "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($hasilxx['nilai2'], "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($hasilx['nilai2'], "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($hasilxxx['nilai2'], "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($nilaiy-$hasilxxx['nilai2'], "2", ".", ",")."</td>
                                </tr>"; 

                            $grand2=$grand2+$hasilxx['nilai2'];$grand3=$grand3+$hasilx['nilai2'];$grand4=$grand4+$hasilxxx['nilai2'];
                           


                    }
                    
                }
			}
			$tot= $grand4;
			$sis=  $grand1 - $tot;
        
       $cRet .= " <tr>
                    <td align=\"center\" colspan=\"2\" width=\"40%\"><b>Jumlah</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand1, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand2, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand3, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand4, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($sis, "2", ".", ",")."</b></td>
                </tr>";
			
			
        $cRet .="</table>";

        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                        <td align=\"center\" width=\"25%\"></td>                    
                        <td align=\"center\" width=\"25%\"></td>
                        <td align=\"center\" width=\"25%\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align=\"center\" width=\"25%\">
                        Mengetahui ,
                        <br>
                        $jabatan <br> <br> <br> <br> <br>
                        <b><u>$nama</u></b> <br>
                        $nip
                        </td>                    
                        <td align=\"center\" width=\"25%\"></td>
                        <td align=\"center\" width=\"25%\">
                        $daerah, ".$this->tukd_model->tanggal_format_indonesia($tglttd)." <br>
                        $jabatan_1 <br> <br> <br> <br> <br>
                        <b><u>$nama_1</u></b> <br>
                        $nip_1
                        </td>
                    </tr>
                  </table>";
        $data['prev']= $cRet;
        $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
    }


    function cetak_spj_penerimaan($skpd='',$bulan='',$nip1='',$nip2='',$tgl_c='',$ver=''){
        $cetak=$ver;
        $lcskpd=$skpd;
        $nbulan=$bulan;
        $pa_=$nip1;
        $pa = str_replace('%20',' ',$pa_);
        $bk_=$nip2;
        $bk = str_replace('%20',' ',$bk_);
        $test=true;
        $spasi="";
        $tglttd=$tgl_c;
        $thn_ang       = $this->session->userdata('pcThang');

        if($cetak=='1'){
            $nilai_anggaran ='b.nilai';
        }else{
            $nilai_anggaran ='b.nilai_ubah';
        }
        
        $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }
        
         $nip="";        
         $nama="";       
         $jabatan="";
         $nip_1="";      
         $nama_1="";         
         $jabatan_1="";
            
            $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$lcskpd' and nip='$pa' and kode='PA'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                }
        
            $c2="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$lcskpd' and nip='$bk' and kode='BP'";
                 $qc2=$this->db->query($c2);
                 foreach ($qc2->result() as $row_2)
                {
                    $nip_1=$row_2->nip;                    
                    $nama_1= $row_2->nm;
                    $jabatan_1  = $row_2->jab;
                }
        
        $skpd = $lcskpd;
        $nm_skpd=  $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $bulan= $this->tukd_model->getBulan($nbulan); 
        $cRet = '';
        $cRet = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
        $cRet .="
            
            <tr>
                <td align=\"center\" style=\"font-size:14px;\" colspan=\"2\"><b>
                  $kab<br>
                  SURAT PENGESAHAN PERTANGGUNGJAWABAN BENDAHARA PENERIMAAN<br>
                  (SPJ BELANJA)<br>&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\" width=\"25%\">
                  SKPD
                </td> 
                <td width=\"75%\" style=\"font-size:12px;\">: $skpd - $nm_skpd
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Pengguna Anggaran/Kuasa Pengguna Anggaran
                </td> 
                <td style=\"font-size:12px;\">: $nama
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Bendahara Penerimaan
                </td> 
                <td style=\"font-size:12px;\">: $nama_1
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Tahun Anggaran
                </td> 
                <td style=\"font-size:12px;\">: $thn_ang
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\">
                  Bulan
                </td> 
                <td style=\"font-size:12px;\">: $bulan
                </td>         
            </tr>
            <tr>
                <td align=\"left\" style=\"font-size:12px;\" colspan=\"2\">
                 &nbsp;
                </td> 
            </tr>

            </table>";

            $cRet    .="<table style=\"border-collapse:collapse; font-size:18px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"4\">
                    <thead>
                        <tr>
                             <td rowspan=\"2\" width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Kode Rekening<b></td>
                             <td rowspan=\"2\" width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Uraian</b></td>
                             <td rowspan=\"2\" width=\"20%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Jumlah Anggaran<b></td>
                             <td colspan=\"3\" width=\"45%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Spj Blud<b></td>
                             <td rowspan=\"2\" width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Sisa Pagu<br>Anggaran<b></td>
                        </tr>

                        <tr>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>s.d Bln lalu<b></td>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>Bulan ini</b></td>
                             <td width=\"15%\" bgcolor=\"#CCCCCC\" align=\"center\"><b>s.d Bln ini<b></td>
                             
                        </tr>
                        <tr>
                         <td align=\"center\">1</td>
                         <td align=\"center\">2</td>
                         <td align=\"center\">3</td>
                         <td align=\"center\">4</td>
                         <td align=\"center\">5</td>
                         <td align=\"center\">6</td>
                         <td align=\"center\">7</td>
                         
                    </tr>
                    </thead>
                    
                    <tfoot>
                        <tr>
                             <td colspan=\"7\" style=\"border-bottom:none;border-left:none;border-right:none;\"></td>
                        </tr>
                    </tfoot>
                    <tr>
                         <td style=\"border-bottom:none;border-top:none\" align=\"justify\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"justify\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"right\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         <td style=\"border-bottom:none;border-top:none\" align=\"center\"></td>
                         
                    </tr>
                    ";
         $sqlaf = $this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd, SUM($nilai_anggaran) AS nilai FROM trskpd_blud a 
                                    JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
                                    WHERE LEFT(b.kd_rek5,1) IN ('4') AND a.kd_skpd='$lcskpd'");
       
        foreach ($sqlaf->result() as $rs) {
            $kdskpd1        = $rs->skpd;
            $nilai1         = $rs->nilai;

            $sql11=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_terima)<'$nbulan' GROUP BY no_terima");
            $hasil11=mysql_fetch_assoc($sql11);
            $sql1=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_terima)='$nbulan' GROUP BY no_terima");
            $hasil1=mysql_fetch_assoc($sql1);
            $sql111=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_terima)<='$nbulan' GROUP BY no_terima");
            $hasil111=mysql_fetch_assoc($sql111);
            $cRet    .="<tr>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b></b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>PENDAPATAN DAERAH</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1, "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                    </tr>";     

        }
        
        $sqlww=$this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd,a.kd_program AS program,a.nm_program AS nmprogram,SUM($nilai_anggaran) AS nilai FROM trskpd a 
        JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
        WHERE LEFT(b.kd_rek7,1) IN ('4') AND a.kd_skpd='$lcskpd' GROUP BY a.kd_program order by kd_program1");
       

        $grand1=0;$grand2=0;$grand3=0;$grand4=0;$grand5=0;$grand6=0;$grand7=0;$grand8=0;$grand9=0;$grand9=0;$grand10=0;$tot=0;$sis=0;
        foreach($sqlww->result() as $roww){
            $kdskpd=$roww->skpd;
            $progw=$roww->program;
            $nmprogw=$roww->nmprogram;
            $nilaiw=$roww->nilai;

            if($test==true && substr($progw, 13) != '00.00'){
                    
                    $sqlaf = $this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd, SUM($nilai_anggaran) AS nilai FROM trskpd a 
                    JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
                    WHERE LEFT(b.kd_rek7,1) IN ('4') AND a.kd_skpd='$lcskpd'");
                

                    foreach ($sqlaf->result() as $rs) {
                            $kdskpd1        = $rs->skpd;
                            $nilai1         = $rs->nilai;

                            $sql11=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_terima)<'$nbulan' and LEFT(a.kd_rek7,1)='4' GROUP BY no_terima");
                            $hasil11=mysql_fetch_assoc($sql11);
                            $sql1=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_terima)='$nbulan' and LEFT(a.kd_rek7,1)='4' GROUP BY no_terima");
                            $hasil1=mysql_fetch_assoc($sql1);
                            $sql111=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd1' AND MONTH(a.tgl_terima)<='$nbulan' and LEFT(a.kd_rek7,1)='4' GROUP BY no_terima");
                            $hasil111=mysql_fetch_assoc($sql111);

                          

                            $cRet    .="<tr>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>&nbsp;</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"> <b></b></td>
                                    </tr>
                                        <tr>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b></b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>BELANJA LANGSUNG</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1, "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai1-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                                    </tr>";     

                    }//end foreach
                    $test=false;   
            }// end if

             $sql11=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<'$nbulan' and left(a.kd_kegiatan,18)='$progw' GROUP BY no_terima");
            $hasil11=mysql_fetch_assoc($sql11);
            $sql1=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)='$nbulan' and left(a.kd_kegiatan,18)='$progw' GROUP BY no_terima");
            $hasil1=mysql_fetch_assoc($sql1);
            $sql111=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_bukti)<='$nbulan' and left(a.kd_kegiatan,18)='$progw' GROUP BY no_terima");
            $hasil111=mysql_fetch_assoc($sql111);

          
            $cRet    .="<tr>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$progw</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$nmprogw</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilaiw, "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilaiw-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                    </tr>";



            $sql=$this->db->query(" SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd,a.kd_kegiatan AS program,a.nm_kegiatan AS nmprogram,SUM($nilai_anggaran) AS nilai FROM trskpd a 
            JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
            JOIN m_giat c on a.kd_kegiatan1=c.kd_kegiatan
            WHERE LEFT(b.kd_rek7,1) IN ('4') AND a.kd_skpd='$lcskpd' and a.kd_program='$progw' GROUP BY a.kd_kegiatan1 
            ");

            foreach($sql->result() as $row){
                    $kdskpd=$row->skpd;
                    $prog=$row->program;
                    $nmprog=$row->nmprogram;
                    $nilai=$row->nilai;
                    
                   $sql11=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_terima)<'$nbulan' and a.kd_kegiatan='$prog' GROUP BY no_terima");
                   $hasil11=mysql_fetch_assoc($sql11);
                   $sql1=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_terima)='$nbulan' and a.kd_kegiatan='$prog' GROUP BY no_terima");
                   $hasil1=mysql_fetch_assoc($sql1);
                   $sql111=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_terima)<='$nbulan' and a.kd_kegiatan='$prog' GROUP BY no_terima");
                   $hasil111=mysql_fetch_assoc($sql111);

                   $grand1=$grand1+$nilai;

                   $cRet    .="<tr>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$prog</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\"><b>$nmprog</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai, "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil11['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil1['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($hasil111['nilai2'], "2", ".", ",")."</b></td>
                         <td style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\"><b>".number_format($nilai-$hasil111['nilai2'], "2", ".", ",")."</b></td>
                    </tr>";


                    $sqlZ=$this->db->query("SELECT a.kd_skpd AS skpd,a.nm_skpd AS nmskpd,b.no_trdrka AS program,b.nm_rek7 AS nmprogram,SUM($nilai_anggaran) AS nilai FROM trskpd a 
                    JOIN trdrka_blud b ON a.kd_gabungan=LEFT(b.no_trdrka,32) AND a.kd_skpd=b.kd_skpd
                    WHERE LEFT(b.kd_rek7,1) IN ('4') AND a.kd_skpd='$kdskpd' AND b.kd_kegiatan ='$prog' GROUP BY b.no_trdrka
                    ORDER BY program");

                    foreach($sqlZ->result() as $row2){
                            $progy=$row2->program;
                            $nmprogy=$row2->nmprogram;
                            $nilaiy =$row2->nilai;

                           $sqlxx=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_terima)<'$nbulan' and a.kd_kegiatan='$prog' and a.kd_rek7=right('$progy',10)");
                           $hasilxx=mysql_fetch_assoc($sqlxx);
                           $sqlx=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_terima)='$nbulan' and a.kd_kegiatan='$prog' and a.kd_rek7=right('$progy',10)");
                           $hasilx=mysql_fetch_assoc($sqlx);
                           $sqlxxx=mysql_query("SELECT SUM(a.nilai) AS nilai2 FROM tr_terima_blud_blud a WHERE a.kd_skpd='$kdskpd' AND MONTH(a.tgl_terima)<='$nbulan' and a.kd_kegiatan='$prog' and a.kd_rek7=right('$progy',10)");
                           $hasilxxx=mysql_fetch_assoc($sqlxxx);

                           $cRet    .="<tr>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\">$progy</td>
                                     <td width=\"30%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"justify\">$nmprogy</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($nilaiy, "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($hasilxx['nilai2'], "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($hasilx['nilai2'], "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($hasilxxx['nilai2'], "2", ".", ",")."</td>
                                     <td width=\"10%\" style=\"font-size:20px;border-bottom:none;border-top:none\" align=\"right\">".number_format($nilaiy-$hasilxxx['nilai2'], "2", ".", ",")."</td>
                                </tr>"; 

                            $grand2=$grand2+$hasilxx['nilai2'];$grand3=$grand3+$hasilx['nilai2'];$grand4=$grand4+$hasilxxx['nilai2'];
                           


                    }
                    
                }
            }
            $tot= $grand4;
            $sis=  $grand1 - $tot;
        
       $cRet .= " <tr>
                    <td align=\"center\" colspan=\"2\" width=\"40%\"><b>Jumlah</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand1, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand2, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand3, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($grand4, "2", ".", ",")."</b></td>
                    <td align=\"right\" width=\"10%\"><b>".number_format($sis, "2", ".", ",")."</b></td>
                </tr>";
            
            
        $cRet .="</table>";

        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                        <td align=\"center\" width=\"25%\"></td>                    
                        <td align=\"center\" width=\"25%\"></td>
                        <td align=\"center\" width=\"25%\">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align=\"center\" width=\"25%\">
                        Mengetahui ,
                        <br>
                        $jabatan <br> <br> <br> <br> <br>
                        <b><u>$nama</u></b> <br>
                        $nip
                        </td>                    
                        <td align=\"center\" width=\"25%\"></td>
                        <td align=\"center\" width=\"25%\">
                        $daerah, ".$this->tukd_model->tanggal_format_indonesia($tglttd)." <br>
                        $jabatan_1 <br> <br> <br> <br> <br>
                        <b><u>$nama_1</u></b> <br>
                        $nip_1
                        </td>
                    </tr>
                  </table>";
        $data['prev']= $cRet;
        $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
    }

	function cetak_spjterima(){
        $thn_ang = $this->session->userdata('pcThang');
         $lcskpd = $_REQUEST['kd_skpd'];
         $lcskpd2 = $lcskpd;
         $pilih = $_REQUEST['cpilih'];
         $jnsctk = $_REQUEST['jnsctk'];
         
         if($jnsctk=='1'){
                $lcskpd = substr($lcskpd, 0, 7);
         }

		 if ($pilih==1){
            $lctgl1 = $_REQUEST['tgl1'];
            $lctgl2 = $_REQUEST['tgl2'];   
            $lcperiode = $this->tukd_model->tanggal_format_indonesia($lctgl1)."  S.D. ".$this->tukd_model->tanggal_format_indonesia($lctgl2);
            $lcperiode1 = "Tanggal ".$this->tukd_model->tanggal_format_indonesia($lctgl1);
            $lcperiode2 = "Tanggal ".$this->tukd_model->tanggal_format_indonesia($lctgl2);
			
			$sqlang="zselect case when statu=1 and status_ubah=1 and month('$lctgl2')>=month(tgl_dpa_ubah) then 'nilai_ubah' 
					   when statu=1 and status_ubah=1 and month('$lctgl2')>=month(tgl_dpa) and month('$lctgl2')<month(tgl_dpa_ubah) then 'nilai'
					   when statu=1 and status_ubah=1 and month('$lctgl2')<month(tgl_dpa) then 'nilai'
					   when statu=1 and status_ubah=0 and month('$lctgl2')>=month(tgl_dpa) then 'nilai' 
					   when statu=1 and status_ubah=0 and month('$lctgl2')<month(tgl_dpa) then 'nilai'
					   when statu=1 and status_ubah=0 and month('$lctgl2')>=month(tgl_dpa) then 'nilai'
					   else 'nilai' end as anggaran from trhrka_blud where kd_skpd ='$lcskpd2'";
			
            
         }else{
            $bulan = $_REQUEST['bulan'];
            $lcperiode = $this->tukd_model->getBulan($bulan);
            if($bulan==1){
                $lcperiode1 = "Bulan Sebelumnya";    
				}else{
				$lcperiode1 = "Bulan ".$this->tukd_model->getBulan($bulan-1);
				}  
            $lcperiode2 = "Bulan ".$this->tukd_model->getBulan($bulan);
			$sqlang="select case when statu=1 and status_ubah=1 and $bulan>=month(tgl_dpa_ubah) then 'nilai_ubah' 
					   when statu=1 and status_ubah=1 and $bulan>=month(tgl_dpa) and $bulan<month(tgl_dpa_ubah) then 'nilai'
					   when statu=1 and status_ubah=1 and $bulan<month(tgl_dpa) then 'nilai'
					   when statu=1 and status_ubah=0 and $bulan>=month(tgl_dpa) then 'nilai' 
					   when statu=1 and status_ubah=0 and $bulan<month(tgl_dpa) then 'nilai'
					   when statu=1 and status_ubah=0 and $bulan>=month(tgl_dpa) then 'nilai'
					   else 'nilai' end as anggaran from trhrka_blud where kd_skpd ='$lcskpd2'";
			
         }
         
		 
		
        $hasilang = $this->db->query($sqlang);
        $hasil_ang = $hasilang->row();          
        $anggaran_ = $hasil_ang->anggaran;
         $lcNmPA = '';
		 $lcNipPA = '';
		 $lcJabatanPA = '';
		 $lcPangkatPA = '';
         $lcNmBP = '';
         $lcNipBP = '';
         $lcPangkatBP = '';
         $lcJabatanBP = '';		  		 
		 
         $tgl_ttd= $_REQUEST['tgl_ttd'];
		 $nippa = str_replace('123456789',' ',$_REQUEST['ttd']);		     
          if($nippa!=''){		 
             $csql="SELECT nip as nip,nama,jabatan,pangkat  FROM ms_ttd_blud WHERE nip = '$nippa' AND kd_skpd = '$lcskpd2' AND kode='PA'";
    				 $hasil = $this->db->query($csql);
                     $num_hasil = $hasil->num_rows();
    				 if($num_hasil>0){
    				    $trh2 = $hasil->row(); 
                        $lcNmPA = $trh2->nama;
    				    $lcNipPA = $trh2->nip;
    				    $lcJabatanPA = $trh2->jabatan;
    				    $lcPangkatPA = $trh2->pangkat;
    				 }
		              
         }

         $nipbp = str_replace('123456789',' ',$_REQUEST['ttd2']);		     
		 if($nipbp!=''){
             $csql="SELECT nip,nama,jabatan,pangkat FROM ms_ttd_blud WHERE nip = '$nipbp' AND kd_skpd = '$lcskpd2' AND kode='BP'";
             $hasil3 = $this->db->query($csql);
             $num_hasil3 = $hasil3->num_rows();
             if($num_hasil3>0){
                 $trh3 = $hasil3->row(); 	
                 $lcNmBP = $trh3->nama;
                 $lcNipBP = $trh3->nip;
                 $lcPangkatBP = $trh3->pangkat;
                 $lcJabatanBP = $trh3->jabatan;
             }
         }

		 $prv = $this->db->query("SELECT provinsi,daerah from sclient_blud WHERE kd_skpd='$lcskpd2'");
			$prvn = $prv->row();          
			$prov = $prvn->provinsi;         
			$daerah = $prvn->daerah;

        $csql="SELECT a.nm_skpd FROM ms_skpd_blud a WHERE left(a.kd_skpd,len('$lcskpd')) = '$lcskpd'";
        $hasil = $this->db->query($csql);
        $trh2 = $hasil->row();          
        $lcNmskpd = $trh2->nm_skpd;
        

        
		
         $cRet = '';
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"13\" style=\"font-size:14px;border: solid 1px white;\"><b>".$prov."<br>
                    LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENERIMAAN<BR>SPJ PENDAPATAN PERIODE ".strtoupper($lcperiode)."</b></td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">SKPD</td>
                <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">:&nbsp;$lcskpd - $lcNmskpd</td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">Pengguna Anggaran / Kuasa Pengguna Anggaran</td>
                <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">:&nbsp;$lcNmPA</td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">Bendahara Penerimaan</td>
                <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">:&nbsp;$lcNmBP</td>
            </tr>
            
            </table>
			
			<table style=\"border-collapse:collapse;font-size:12px\" width=\"150%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <thead>
            <tr>
                <td align=\"center\" rowspan=\"2\" width=\"5%\" style=\"font-size:12px\">Kode<br>Rekening</td>
                <td align=\"center\" rowspan=\"2\" width=\"15%\" style=\"font-size:12px\">Uraian</td>
                <td align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Jumlah<br>Anggaran</td>
                <td align=\"center\" colspan=\"3\" style=\"font-size:12px\">Sampai dengan Bulan Lalu</td>
                <td align=\"center\" colspan=\"3\" style=\"font-size:12px\">Bulan Ini</td>
                <td align=\"center\" colspan=\"4\" style=\"font-size:12px\">Sampai dengan Bulan Ini</td>
            </tr>
            <tr>
                <td align=\"center\" style=\"font-size:12px\">Penerimaan</td>
                <td align=\"center\" style=\"font-size:12px\">Penyetoran</td>
                <td align=\"center\" style=\"font-size:12px\">Sisa</td>
                <td align=\"center\" style=\"font-size:12px\">Penerimaan</td>
                <td align=\"center\" style=\"font-size:12px\">Penyetoran</td>
                <td align=\"center\" style=\"font-size:12px\">Sisa</td>
                <td align=\"center\" style=\"font-size:12px\">Jumlah<br>Anggaran<br>yang<br>Terealisasi</td>                
                <td align=\"center\" style=\"font-size:12px\">Jumlah<br>Anggaran<br>yang telah<br>Disetor</td>
                <td align=\"center\" style=\"font-size:12px\">Sisa yang<br>Belum<br>Disetor</td>
                <td align=\"center\" style=\"font-size:12px\">Sisa Anggaran yang<br>Belum<br>Terealisasi/Pelam-<br>pauan Anggaran</td>                                
            </tr>            
            <tr>
                <td align=\"center\" style=\"font-size:12px\">1</td>
                <td align=\"center\" style=\"font-size:12px\">2</td>
                <td align=\"center\" style=\"font-size:12px\">3</td>
                <td align=\"center\" style=\"font-size:12px\">4</td>
                <td align=\"center\" style=\"font-size:12px\">5</td>
                <td align=\"center\" style=\"font-size:12px\">6=(5-4)</td>
                <td align=\"center\" style=\"font-size:12px\">7</td>
                <td align=\"center\" style=\"font-size:12px\">8</td>
                <td align=\"center\" style=\"font-size:12px\">9=(8-7)</td>
                <td align=\"center\" style=\"font-size:12px\">10=(4+7)</td>
                <td align=\"center\" style=\"font-size:12px\">11=(5+8)</td>
                <td align=\"center\" style=\"font-size:12px\">12=(11-10)</td>
                <td align=\"center\" style=\"font-size:12px\">13=(3-10)</td>                
            </tr>
			</thead>";
           

            if ($pilih==1   ){
                $kon_terimaini = " sum(case when (tgl_terima >= '$lctgl1' AND tgl_terima <= '$lctgl2') then nilai else 0 end) as terima_ini";
                $kon_keluarini = " sum(case when (tgl_sts >= '$lctgl1' AND tgl_sts <= '$lctgl2') then rupiah else 0 end) as keluar_ini";          
                $kon_terimalalu = " sum(case when (tgl_terima < '$lctgl1') then nilai else 0 end) as terima_lalu";
                $kon_keluarlalu = " sum(case when (tgl_sts < '$lctgl1') then rupiah else 0 end) as keluar_lalu";
           }else{
                $kon_terimaini  = " SUM(CASE WHEN MONTH(tgl_terima)='$bulan' THEN nilai ELSE 0 END) as terima_ini";
                $kon_terimalalu = " SUM(CASE WHEN MONTH(tgl_terima)<'$bulan' THEN nilai ELSE 0 END) as terima_lalu";
                $kon_keluarini  = " SUM(CASE WHEN MONTH(tgl_sts)='$bulan' THEN rupiah ELSE 0 END) as keluar_ini";
                $kon_keluarlalu = " SUM(CASE WHEN MONTH(tgl_sts)<'$bulan' THEN rupiah ELSE 0 END) as keluar_lalu";
           }

            $n_trdrka = 'trdrka_blud';
            
            $kon_skpd="a.kd_skpd = ";
            $sql  = "SELECT a.kd_kegiatan,a.kode, nm_rek2 as nama,anggaran,terima_ini, terima_lalu, keluar_ini, keluar_lalu FROM 
						(select kd_kegiatan,LEFT(kd_rek5,2) as kode,SUM($anggaran_) as anggaran
						FROM trdrka_blud WHERE kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY kd_kegiatan,LEFT(kd_rek5,2)) a
						LEFT JOIN 
						(SELECT kd_kegiatan, LEFT(kd_rek5,2) as kode,
						$kon_terimaini,
						$kon_terimalalu
						 FROM tr_terima_blud WHERE kd_skpd='$lcskpd2'
						GROUP BY kd_kegiatan,LEFT(kd_rek5,2))b
						ON a.kd_kegiatan=b.kd_kegiatan AND a.kode=b.kode
						LEFT JOIN
						(SELECT LEFT(kd_rek5,2) as kode,
						$kon_keluarini,
						$kon_keluarlalu
						 FROM trhkasin_blud a INNER JOIN trdkasin_blud b
						ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
						WHERE a.kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY LEFT(kd_rek5,2))c
						ON a.kode=c.kode
						LEFT JOIN
						ms_rek2 d ON a.kode=d.kd_rek2

						UNION ALL

						SELECT a.kd_kegiatan,a.kode, nm_rek3 as nama,anggaran, terima_ini, terima_lalu, keluar_ini, keluar_lalu FROM 
						(select kd_kegiatan,LEFT(kd_rek5,3) as kode,SUM($anggaran_) as anggaran
						FROM trdrka_blud WHERE kd_skpd='$lcskpd2'  AND LEFT(kd_rek5,1)='4'
						GROUP BY kd_kegiatan,LEFT(kd_rek5,3)) a
						LEFT JOIN 
						(SELECT kd_kegiatan, LEFT(kd_rek5,3) as kode,
						$kon_terimaini,
						$kon_terimalalu
						 FROM tr_terima_blud WHERE kd_skpd='$lcskpd2'
						GROUP BY kd_kegiatan,LEFT(kd_rek5,3))b
						ON a.kd_kegiatan=b.kd_kegiatan AND a.kode=b.kode
						LEFT JOIN
						(SELECT LEFT(kd_rek5,3) as kode,
						$kon_keluarini,
						$kon_keluarlalu
						 FROM trhkasin_blud a INNER JOIN trdkasin_blud b
						ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
						WHERE a.kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY LEFT(kd_rek5,3))c
						ON a.kode=c.kode
						LEFT JOIN
						ms_rek3 d ON a.kode=d.kd_rek3

						UNION ALL

						SELECT a.kd_kegiatan,a.kode, nm_rek4 as nama, anggaran,terima_ini, terima_lalu, keluar_ini, keluar_lalu FROM 
						(select kd_kegiatan,LEFT(kd_rek5,5) as kode,SUM($anggaran_) as anggaran
						FROM trdrka_blud WHERE kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY kd_kegiatan,LEFT(kd_rek5,5)) a
						LEFT JOIN 
						(SELECT kd_kegiatan, LEFT(kd_rek5,5) as kode,
						$kon_terimaini,
						$kon_terimalalu
						 FROM tr_terima_blud WHERE kd_skpd='$lcskpd2'
						GROUP BY kd_kegiatan,LEFT(kd_rek5,5))b
						ON a.kd_kegiatan=b.kd_kegiatan AND a.kode=b.kode
						LEFT JOIN
						(SELECT LEFT(kd_rek5,5) as kode,
						$kon_keluarini,
						$kon_keluarlalu
						 FROM trhkasin_blud a INNER JOIN trdkasin_blud b
						ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
						WHERE a.kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY LEFT(kd_rek5,5))c
						ON a.kode=c.kode
						LEFT JOIN
						ms_rek4 d ON a.kode=d.kd_rek4

						UNION ALL

						SELECT a.kd_kegiatan,a.kd_rek5 kode, nm_rek5 as nama,anggaran, terima_ini, terima_lalu, keluar_ini, keluar_lalu FROM 
						(select kd_kegiatan,kd_rek5,SUM($anggaran_) as anggaran
						FROM trdrka_blud WHERE kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY kd_kegiatan,kd_rek5) a
						LEFT JOIN 
						(SELECT kd_kegiatan, kd_rek5,
						$kon_terimaini,
						$kon_terimalalu
						 FROM tr_terima_blud WHERE kd_skpd='$lcskpd2'
						GROUP BY kd_kegiatan,kd_rek5)b
						ON a.kd_kegiatan=b.kd_kegiatan AND a.kd_rek5=b.kd_rek5
						LEFT JOIN
						(SELECT kd_rek5,
						$kon_keluarini,
						$kon_keluarlalu
						 FROM trhkasin_blud a INNER JOIN trdkasin_blud b
						ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd
						WHERE a.kd_skpd='$lcskpd2' AND LEFT(kd_rek5,1)='4'
						GROUP BY kd_rek5)c
						ON a.kd_rek5=c.kd_rek5
						LEFT JOIN
						ms_rek5 d ON a.kd_rek5=d.kd_rek5
						ORDER BY kode "     ;

                       //echo "$sql";
                       
                                       
                    $hasil = $this->db->query($sql);                                                      
                    $lcterima_ini=0;
                    $lckeluar_ini=0;
                    $lcprog_lama="";
                    $lckeg_lama="";
                    $ln_jlh1 =0;
                    $ln_jlh2 =0;
                    $ln_jlh3 =0;
                    $ln_jlh4 =0;
                    $ln_jlh5 =0;
                    $ln_jlh6 =0;
                    $ln_jlh7 =0;
                    $ln_jlh8 =0;
                    $ln_jlh9 =0;
                    $ln_jlh10 =0;
                    $ln_jlh11 =0;
                    
                    foreach ($hasil->result() as $row) {
                        $kode = $row->kode;
                        $nama = $row->nama;
						$leng = strlen($kode);
						switch ($leng){
						case 7;
						  $cRet .="<tr>
                                    <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:none;border-top:none\">".$this->tukd_model->dotrek($kode)."</b></td>
                                  <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:none;border-top:none\">$nama</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format($row->anggaran,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format($row->terima_lalu,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format($row->keluar_lalu,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format(($row->keluar_lalu)-($row->terima_lalu),"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format($row->terima_ini,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format($row->keluar_ini,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format(($row->keluar_ini)-($row->terima_ini),"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format(($row->terima_lalu)+($row->terima_ini),"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format(($row->keluar_lalu)+($row->keluar_ini),"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format(($row->keluar_lalu+$row->keluar_ini)-($row->terima_lalu+$row->terima_ini),"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\">".number_format($row->anggaran-($row->terima_lalu+$row->terima_ini),"2",",",".")."</td>
                                  </tr>";
							$ln_jlh1 = $ln_jlh1+$row->anggaran;
							$ln_jlh2 = $ln_jlh2+$row->terima_lalu;
							$ln_jlh3 = $ln_jlh3+$row->keluar_lalu;
							$ln_jlh4 = $ln_jlh3-$ln_jlh2;
							$ln_jlh5 = $ln_jlh5+$row->terima_ini;
							$ln_jlh6 = $ln_jlh6+$row->keluar_ini;
							$ln_jlh7 = $ln_jlh6-$ln_jlh5;
							$ln_jlh8 = $ln_jlh5+$ln_jlh2;
							$ln_jlh9 = $ln_jlh6+$ln_jlh3;
							$ln_jlh10 = $ln_jlh9-$ln_jlh8;
							$ln_jlh11 = $ln_jlh1-$ln_jlh8;
							break;
						default;
						 $cRet .="<tr>
                                    <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".$this->tukd_model->dotrek($kode)."</b></td>
                                  <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b> $nama</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format($row->anggaran,"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format($row->terima_lalu,"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format($row->keluar_lalu,"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format(($row->keluar_lalu)-($row->terima_lalu),"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format($row->terima_ini,"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format($row->keluar_ini,"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format(($row->keluar_ini)-($row->terima_ini),"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format(($row->terima_lalu)+($row->terima_ini),"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format(($row->keluar_lalu)+($row->keluar_ini),"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format(($row->keluar_lalu+$row->keluar_ini)-($row->terima_lalu+$row->terima_ini),"2",",",".")."</b></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:none;border-top:none\"><b>".number_format($row->anggaran-($row->terima_lalu+$row->terima_ini),"2",",",".")."</b></td>
                                  </tr>";
						 						  
								  break;
							} 
					}


        $cRet .="<tr>
                    <td valign=\"top\" align=\"center\" colspan=\"2\" style=\"font-size:12px\"><b>J U M L A H</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh1,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh2,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh3,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh4,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh5,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh6,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh7,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh8,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh9,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh10,"2",",",".")."</b></td>
                    <td valign=\"top\" align=\"right\" style=\"font-size:12px\"><b>".number_format($ln_jlh11,"2",",",".")."</b></td>
                </tr>
                
                <tr>
                    <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;border-top:solid 1px black;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;border-top:solid 1px black;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">Mengetahui</td>
                    <td align=\"left\" colspan=\"6\" style=\"font-size:12px;border: solid 1px white;\"></td>
                    <td align=\"center\" colspan=\"5\" style=\"font-size:12px;border: solid 1px white;\">".$daerah.", ".$this->tanggal_format_indonesia($tgl_ttd)."</td>                                                                                                                                                                                
                </tr>
                <tr>                
                    <td align=\"center\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">$lcJabatanPA</td>
                    <td align=\"left\" colspan=\"6\" style=\"font-size:12px;border: solid 1px white;\"></td>
                    <td align=\"center\" colspan=\"5\" style=\"font-size:12px;border: solid 1px white;\">$lcJabatanBP</td>                    
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
				<tr>
                    <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
				<tr>
                    <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"11\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmPA</u></b><br>$lcPangkatPA</td>
                    <td align=\"center\" colspan=\"6\" style=\"font-size:12px;border: solid 1px white;\"></td>
                    <td align=\"center\" colspan=\"5\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmBP</u></b><br>$lcPangkatBP</td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;\">NIP. $lcNipPA</td>
                    <td align=\"center\" colspan=\"6\" style=\"font-size:12px;border: solid 1px white;\"></td>
                    <td align=\"center\" colspan=\"5\" style=\"font-size:12px;border: solid 1px white;\">NIP. $lcNipBP</td>
                </tr>";
                
                                  
                
        $cRet .='</table>';
          $print = $this->uri->segment(3);
		if($print==0){
         $data['prev']= $cRet;    
		 echo ("<title>SPJ Pendapatan</title>");
		 echo $cRet;}
		 else{
	       $this->_mpdf('',$cRet,10,10,10,'L',0,'');
        }
    }
 
	
	
	function cetak_lap_pendapatan($convert='',$bulan='',$tgl_cetak='',$nipang='',$nipbp=''){
		$skpd         = $this->session->userdata('kdskpd');
		$nm_skpd      = $this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
		//$cetaktanggal = $this->tanggal_format_indonesia($tgl_cetak);
		$nbulan 	= $this->tukd_model->getBulan($bulan);
       $nipang = str_replace('123456789',' ',$nipang);
		$nipbp = str_replace('123456789',' ',$nipbp);
	   
	   
		$sqlsc="SELECT kd_skpd,alamat,telp,faks,daerah FROM sclient2_blud where kd_skpd='$skpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                {
                  
                    $daerah  = $rowsc->daerah;
                    $alamat  = $rowsc->alamat;
                    $telp    = $rowsc->telp;
                    $faks    = $rowsc->faks;
                  
                }


        $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }

         $sql_tim="select nip,nama,jabatan,pangkat from ms_ttd_blud where nip='$nipbp'";
        $query=$this->db->query($sql_tim);
        foreach ($query->result() as $row)
                {
                    $jabatan_tim  =$row->jabatan;
                    $nama_tim = $row->nama;
                    $nip_tim  = $row->nip;
                    $pangkat_tim  = $row->pangkat;
					
                    
                }
				
        $sql="select nip,nama,jabatan,pangkat from ms_ttd_blud where nip='$nipang'";
        $query=$this->db->query($sql);
        foreach ($query->result() as $rowsc2)
                {
                    $jabatan =$rowsc2->jabatan;
                    $nama    = $rowsc2->nama;
                    $nip     = $rowsc2->nip;
					$pangkat  = $rowsc2->pangkat;
                    
                }
		if($bulan==1){
			$awal = 1;
			$akhir = 3;
			$judul = 'TRIWULAN 1';
		} else if($bulan==4){
			$awal = 4;
			$akhir = 6;
			$judul = 'TRIWULAN 2';
		}else if($bulan==7){
			$awal = 7;
			$akhir = 9;
			$judul = 'TRIWULAN 3';
		}else if($bulan==10){
			$awal = 10;
			$akhir = 12;
			$judul = 'TRIWULAN 4';
		}
        $cRet = '';
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\"  align=\"center\" style=\"border-bottom:4px double black\" cellspacing=\"0\" cellpadding=\"4\">
                <tr>
					<td width=\"10%\" rowspan=\"4\" align=\"left\">
							<img src=\"" . base_url() . "/image/soedarso1.png\" width=\"110 px\"height=\"120 px\" />
					</td>
					<td width=\"80%\" align=\"center\"  font-size=\"12 px\">
							<h2><b>$kab</b> <br><b>$nm_skpd<b></h2>
							 LAPORAN PENDAPATAN 
							 <br> PERIODE ".strtoupper($judul)."
							 
					</td>
                </tr>
        </table><br>";
        $cRet .="<table style='border-collapse:collapse;' width='100%' align='center' cellspacing='2' cellpadding='2' border='1'>
		<tr>
		<td bgcolor='#CCCCCC' align='center' width='5%'><b>No</b></td>
		<td bgcolor='#CCCCCC' align='center' width='20%'><b>Uraian</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Anggaran</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Realisasi sd Triwulan Lalu</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Realisasi Triwulan Ini</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Realisasi sd Triwulan Ini</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Lebih (Kurang)</b></td>
		</tr>";
		
		
		$sqlisi = "SELECT a.kd_rek2,nm_rek2,ISNULL(c.nilai,0) as ang, 
					ISNULL(lalu,0) as lalu, ISNULL(ini,0) as ini
					 FROM ms_rek2_blud a
					LEFT JOIN (
					SELECT 
					LEFT(kd_rek_blud,2) as kode,
					SUM(CASE WHEN MONTH(tgl_terima) < $awal  THEN nilai ELSE 0 END ) as lalu,
					SUM(CASE WHEN MONTH(tgl_terima) BETWEEN $awal and $akhir THEN nilai ELSE 0 END ) as ini
					FROM tr_terima_blud where kd_skpd='$skpd' 
					GROUP BY LEFT(kd_rek_blud,2))b
					ON a.kd_rek2=b.kode
					LEFT JOIN 
					(SELECT LEFT(kd_rek5,2) as kode, SUM(total_ubah) as nilai FROM trdpo_blud 
					WHERE LEFT(no_trdrka,10)='$skpd' AND LEFT(kd_rek5,1)='4' GROUP BY LEFT(kd_rek5,2)
					)c 
					ON a.kd_rek2=c.kode
					WHERE LEFT(kd_rek2,1)='4'
					ORDER BY kd_rek2";
		$no=0;
		$hasil = $this->db->query($sqlisi);
                    foreach ($hasil->result() as $row){
                       $kode = $row->kd_rek2;
                       $rek = $row->nm_rek2;
                       $ang = $row->ang;
                       $ini = $row->ini;
                       $lalu = $row->lalu;
					   $sdini=$ini+$lalu;
					   $sisa=$ang-$sdini;
					   if($sisa<0){
						   $a="(";
						   $b=")";
						   $sisa=$sisa*-1;
					   }else{
						   $a="";
						   $b="";
					   }
					   $no=$no+1;
					   $cRet .="
					   <tr>
					   <td align='center'>$no</td>
					   <td align='left'>$rek</td>
					   <td align='right'>".number_format($ang, "2", ".", ",")." </td>
					   <td align='right'>".number_format($lalu, "2", ".", ",")." </td>
					   <td align='right'>".number_format($ini, "2", ".", ",")." </td>
					   <td align='right'>".number_format($sdini, "2", ".", ",")." </td>
					   <td align='right'>$a".number_format($sisa, "2", ".", ",")."$b</td>
					   </tr>";
					  
					}
		
        $cRet .="</table>" ;     


		$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_cetak).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan_tim.'</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><u>'.$nama.' </u> <br>'.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama_tim.'</u> <br> '.$pangkat_tim.'</TD>
					</TR>
                    <TR>
						<TD align="center" >NIP. '.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >NIP. '.$nip_tim.'</TD>
					</TR>
					</TABLE><br/>';
		
        $data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul = 'REGISTER PENERIMAAN BLUD';
        $this->template->set('title', 'REGISTER PENERIMAAN BLUD');
        

        switch ($convert)
        {
            case 0;
				echo ("<title>Lap. Pendapatan</title>");
				echo $cRet;
                break; 
			case 1;
                $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");

                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
        }   

    }

	function cetak_lap_pengeluaran($convert='',$bulan='',$tgl_cetak='',$nipang='',$nipbp=''){
		$skpd         = $this->session->userdata('kdskpd');
		$nm_skpd      = $this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
		//$cetaktanggal = $this->tanggal_format_indonesia($tgl_cetak);
		$nbulan 	= $this->tukd_model->getBulan($bulan);
       $nipang = str_replace('123456789',' ',$nipang);
		$nipbp = str_replace('123456789',' ',$nipbp);
	   
		$sqlsc="SELECT kd_skpd,alamat,telp,faks,daerah FROM sclient2_blud where kd_skpd='$skpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                {
                  
                    $daerah  = $rowsc->daerah;
                    $alamat  = $rowsc->alamat;
                    $telp    = $rowsc->telp;
                    $faks    = $rowsc->faks;
                  
                }


        $sqlsc="SELECT kab_kota,tgl_rka,provinsi,nm_kab_kota,daerah,thn_ang FROM sclient_blud";
               $sqlsclient_blud=$this->db->query($sqlsc);
               foreach ($sqlsclient_blud->result() as $rowsc)
               {
                  $kab     = $rowsc->kab_kota;
                  $thn     = $rowsc->thn_ang;
                  $daerah = $rowsc->daerah;
               }

         $sql_tim="select nip,nama,jabatan,pangkat from ms_ttd_blud where nip='$nipbp'";
        $query=$this->db->query($sql_tim);
        foreach ($query->result() as $row)
                {
                    $jabatan_tim  =$row->jabatan;
                    $nama_tim = $row->nama;
                    $nip_tim  = $row->nip;
                    $pangkat_tim  = $row->pangkat;
					
                    
                }
				
        $sql="select nip,nama,jabatan,pangkat from ms_ttd_blud where nip='$nipang'";
        $query=$this->db->query($sql);
        foreach ($query->result() as $rowsc2)
                {
                    $jabatan =$rowsc2->jabatan;
                    $nama    = $rowsc2->nama;
                    $nip     = $rowsc2->nip;
					$pangkat  = $rowsc2->pangkat;
                    
                }
				
		if($bulan==1){
			$awal = 1;
			$akhir = 3;
			$judul = 'TRIWULAN 1';
		} else if($bulan==4){
			$awal = 4;
			$akhir = 6;
			$judul = 'TRIWULAN 2';
		}else if($bulan==7){
			$awal = 7;
			$akhir = 9;
			$judul = 'TRIWULAN 3';
		}else if($bulan==10){
			$awal = 10;
			$akhir = 12;
			$judul = 'TRIWULAN 4';
		}
        $cRet = '';
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\"  align=\"center\" style=\"border-bottom:4px double black\" cellspacing=\"0\" cellpadding=\"4\">
                <tr>
					<td width=\"10%\" rowspan=\"4\" align=\"left\">
							<img src=\"" . base_url() . "/image/logo.png\" width=\"110 px\"height=\"120 px\" />
					</td>
					<td width=\"80%\" align=\"center\"  font-size=\"12 px\">
							<h2><b>$kab</b> <br><b>$nm_skpd<b></h2>
							 LAPORAN PENGELUARAN 
							 <br> PERIODE ".strtoupper($judul)."
							 
					</td>
                </tr>
        </table><br>";
        $cRet .="<table style='border-collapse:collapse;' width='100%' align='center' cellspacing='2' cellpadding='2' border='1'>
		<tr>
		<td bgcolor='#CCCCCC' align='center' width='5%'><b>No</b></td>
		<td bgcolor='#CCCCCC' align='center' width='20%'><b>Uraian</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Anggaran</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Realisasi sd Triwulan Lalu</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Realisasi Triwulan Ini</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Realisasi sd Triwulan Ini</b></td>
		<td bgcolor='#CCCCCC' align='center' width='15%'><b>Lebih (Kurang)</b></td>
		</tr>";
		
		$no=0;
		$sqlisi = "SELECT * FROM map_peng_blud order by cast(seq as int)";
		$query10 = $this->db->query($sqlisi);
		foreach($query10->result_array() as $res){
				$uraian=$res['Uraian'];
				$bold=$res['bold'];
				$kode_1=trim($res['kode_1']);
				$kode_2=trim($res['kode_2']);
				$kode_3=trim($res['kode_3']);
				$kode_4=trim($res['kode_4']);
				$kode_5=trim($res['kode_5']);
				if($kode_1==''){
						$kode_1="'X'";
						}
						if($kode_2==''){
							$kode_2="'XX'";
						}
						if($kode_3==''){
							$kode_3="'XXX'";
						}
						if($kode_4==''){
							$kode_4="'XXXXX'";
						}
			
			$tess = "SELECT SUM(ISNULL(nilai,0)) as nilai,
				SUM(ISNULL(lalu,0)) lalu, SUM(ISNULL(ini,0)) ini 
				 FROM (SELECT kd_rek5 as kode, SUM(total_ubah) as nilai FROM trdpo_blud 
				WHERE LEFT(no_trdrka,10)='$skpd' AND LEFT(kd_rek5,1)='5' GROUP BY kd_rek5) a
				LEFT JOIN (
				SELECT  a.kd_rek_blud,
				SUM(CASE WHEN MONTH(tgl_bukti) < $awal  THEN nilai ELSE 0 END ) as lalu,
				SUM(CASE WHEN MONTH(tgl_bukti) BETWEEN $awal and $akhir  THEN nilai ELSE 0 END ) as ini
				FROM trdtransout_blud a 
				INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
				where b.kd_skpd='$skpd'
				GROUP BY kd_rek_blud) b
				ON a.kode=b.kd_rek_blud 
				WHERE   (LEFT(kode,1) IN ($kode_1) or LEFT(kode,2) IN ($kode_2) 
				or LEFT(kode,3) IN ($kode_3) or LEFT(kode,4) IN($kode_4))";	
			
			$q = $this->db->query($tess);  
			foreach($q->result_array() as $r){
                       $ang = $r['nilai'];
                       $ini = $r['ini'];
                       $lalu = $r['lalu'];
					   $sdini=$ini+$lalu;
					   $sisa=$ang-$sdini;
					   $no=$no+1;
					   $cRet .="
					   <tr>
					   <td align='cnter'>$no</td>
					   <td align='left'>$uraian</td>
					   <td align='right'>".number_format($ang, "2", ".", ",")." </td>
					   <td align='right'>".number_format($lalu, "2", ".", ",")." </td>
					   <td align='right'>".number_format($ini, "2", ".", ",")." </td>
					   <td align='right'>".number_format($sdini, "2", ".", ",")." </td>
					   <td align='right'>".number_format($sisa, "2", ".", ",")." </td>
					   </tr>";
			}
			
		}		
		
        $cRet .="</table>" ;  

		$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_cetak).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan_tim.'</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><u>'.$nama.' </u> <br>'.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama_tim.'</u> <br> '.$pangkat_tim.'</TD>
					</TR>
                    <TR>
						<TD align="center" >NIP. '.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >NIP. '.$nip_tim.'</TD>
					</TR>
					</TABLE><br/>';
		
        $data['prev'] = $cRet;
        $data['sikap'] = 'preview';
        $judul = 'REGISTER PENERIMAAN BLUD';
        $this->template->set('title', 'REGISTER PENERIMAAN BLUD');
        

        switch ($convert)
        {
            case 0;
				echo ("<title>Lap. Pengeluaran</title>");
				echo $cRet;
                break; 
			case 1;
                $this->tukd_model->_mpdf('',$cRet,7,7,7,'l'); 
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");

                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('tukd/laporan/perkadaII', $data);
                break;
        }   

    }

	
}