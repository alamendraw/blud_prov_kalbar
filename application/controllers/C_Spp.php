<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class C_spp extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		$this->load->model('M_Spp');
	}
    
	function config_tahun() {
        $result = array();
         $tahun  = $this->session->userdata('pcThang');
		 $result = $tahun;
         echo json_encode($result);
	}
	
//--- SPP UP	
	
	function spp_up(){
        $data['page_title']= 'INPUT SPP UP';
        $this->template->set('title', 'INPUT SPP UP');   
        $this->template->load('template','tukd/spp/spp_up',$data) ; 
    }
	
	function simpan_spp_up(){
        $tabel  	 = $this->input->post('tabel');
        $no_spp		 = $this->input->post('no_spp');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('bbn');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('nilai');
        $rekup   	 = $this->input->post('rek');
        $skpd   	 = $this->input->post('skpd');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	 	= $this->M_Spp->simpan_spp_up($tabel,$no_spp,$tgl,$bbn,$ket,$nilai,$rekup,$skpd,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function update_spp_up(){
        $tabel  	 = $this->input->post('tabel');
        $no_spp		 = $this->input->post('no_spp');
        $nohide		 = $this->input->post('nohide');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('bbn');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('nilai');
        $rekup   	 = $this->input->post('rek');
        $skpd   	 = $this->input->post('skpd');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	 	 = $this->M_Spp->update_spp_up($tabel,$no_spp,$nohide,$tgl,$bbn,$ket,$nilai,$rekup,$skpd,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function load_spp_up() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		$data	  = $this->M_Spp->load_spp_up($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
    
	 function hapus_spp() { 
  		$kd_skpd  = $this->session->userdata('kdskpd');
		$nomor 	  = $this->input->post('no');
		$data	  = $this->M_Spp->hapus_spp($kd_skpd,$nomor);				
		echo json_encode($data);
    }
	

//SPP GU
//awal sppgu
	function spp_gu(){
        $data['page_title']= 'INPUT SPP GU';
        $this->template->set('title', 'INPUT SPP GU');   
        $this->template->load('template','tukd/spp/spp_gu',$data) ;
		//$this->tukd_model->set_log_activity(); 
    }
		
	function load_spp_gu() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		$data	  = $this->M_Spp->load_spp_gu($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function load_ttd3($ttd){
        $kd_skpd = $this->session->userdata('kdskpd'); 
		$sql = "SELECT * FROM ms_ttd_blud WHERE kode='$ttd'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
	}
		
	function pilih_ttd($dns='') {
        $lccr = $this->input->post('q');
        $sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd_blud where kd_skpd ='$dns' ";
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
    
	function nlpj() {
		$skpd = $this->session->userdata('kdskpd');
		$sql = "select DISTINCT no_lpj,tgl_lpj FROM trhlpj_blud WHERE status='0' AND jenis = '1' AND kd_skpd = '$skpd'";
		
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'no_lpj' => $resulte['no_lpj'],  
                        'tgl_lpj' => $resulte['tgl_lpj']  
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result();	   
	}
    
	function select_data1($spp='') {
  	$kd_skpd  = $this->session->userdata('kdskpd');
    $spp = $this->input->post('spp');
    $sql = "SELECT kd_kegiatan,kd_rek5,kd_rek_blud, nm_rek_blud, nilai,no_trans as no_bukti FROM trdspp_blud WHERE no_spp='$spp' AND kd_skpd='$kd_skpd' ORDER BY no_trans,kd_kegiatan,kd_rek5";                   
        
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
                        'nilai1'     => number_format($resulte['nilai'],"2",".",","),
                        'nilai'      => number_format($resulte['nilai']),
                        'no_bukti'   => $resulte['no_bukti']  
                        );
                        $ii++;
        }
           
           echo json_encode($result);
     $query1->free_result();
    }
    
	function load_sum_lpj_ag(){
		$skpd = $this->session->userdata('kdskpd');
		$xlpj = $this->input->post('lpj');
        $query1 = $this->db->query("SELECT SUM(a.nilai) AS jml FROM trlpj_blud a WHERE no_lpj='$xlpj' AND kd_skpd='$skpd' ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'cjumlah'  =>  $resulte['jml']                       
                        );
                        $ii++;
        }
		echo json_encode($result);
        $query1->free_result();	
	}

	function simpan_spp_gu(){
		$tabel   = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid     = $this->input->post('cid');
        $lcid    = $this->input->post('lcid');
        $lcnotagih = $this->input->post('tagih');
        $lcnolpj = $this->input->post('no_lpj');
		$skpd  = $this->session->userdata('kdskpd');
		
		$sql = "select $cid from $tabel where $cid='$lcid' AND kd_skpd='$skpd' ";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
			$query = $this->db->query("UPDATE trhlpj_blud SET status = '1' WHERE no_lpj = '$lcnolpj' AND kd_skpd='$skpd'");
            if($asg){
				
                echo '2';
            }else{
                echo '0';
            }
        }
		
		
	}
	
	function dsimpan_gu(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$no_spp = $this->input->post('no');
		$csql     = $this->input->post('sql');            
		$sql = "DELETE from trdspp_blud where no_spp='$no_spp' AND kd_skpd='$kdskpd'";
                $asg = $this->db->query($sql);
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "INSERT INTO trdspp_blud (no_spp,kd_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd,kd_kegiatan,no_trans)"; 
                    $asg = $this->db->query($sql.$csql);
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
						
							   $msg = array('pesan'=>'1');
								echo json_encode($msg);
						
					}
				}
	}
	
	function dsimpan_spp(){
	       $no_spp      = $this->input->post('cnospp');
           $kd_kegiatan = $this->input->post('ckdgiat');
           $kd_rek5     = $this->input->post('ckdrek');
           $kd_rek_blud     = $this->input->post('kd_rek_blud');
           $vno_bukti   = $this->input->post('cnobukti');
                        
           $sql = "delete from trdspp_blud where no_spp='$no_spp' and kd_kegiatan='$kd_kegiatan' and kd_rek5='$kd_rek5' and kd_rek_blud='$kd_rek_blud' and no_bukti='$vno_bukti' ";
           $asg = $this->db->query($sql);

           echo '1';
	}

	function dsimpan_hapus(){
           $no_spp  = trim($this->input->post('cno_spp'));
           $lcid    = $this->input->post('lcid');
           $lcid_h  = $this->input->post('lcid_h');
           
           if (  $lcid <> $lcid_h ) {
               $sql     = " delete from trdspp_blud where no_spp='$no_spp' ";
               $asg     = $this->db->query($sql);
               if ($asg > 0){  	
                    echo '1';
                    exit();
               } else {
                    echo '0';
                    exit();
               }
          }     
	}
     
	function hhapus_gu() { 
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nomor = $this->input->post('no');
		$nolpj   = $this->input->post('nolpj');
		$query = $this->db->query("delete from trdspp_blud where no_spp='$nomor' AND kd_skpd='$kdskpd'");
        $query = $this->db->query("delete from trhsp2d_blud where no_spp='$nomor' AND kd_skpd='$kdskpd'");
		$query = $this->db->query("UPDATE trhlpj_blud SET status = '0' WHERE no_lpj = '$nolpj' AND kd_skpd='$kdskpd'");
    }
	
	function load_sum_spp(){
		$xspp = $this->input->post('spp');
		$skpd = $this->session->userdata('kdskpd');
        $query1 = $this->db->query("select sum(nilai) as rektotal from trdspp_blud where no_spp = '$xspp' AND kd_skpd='$skpd'");  
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
		echo json_encode($result);
        $query1->free_result();	
	}
    
	function load_sum_tran(){
		$skpd = $this->session->userdata('kdskpd');
		$id = $this->input->post('no_bukti');
        $query1 = $this->db->query("select sum(nilai) as rektotal from trdtransout_blud where no_bukti='$id' AND kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal'  => $resulte['rektotal'],
                        'rektotal1' => $resulte['rektotal']                       
                        );
                        $ii++;
        }
           
		   echo json_encode($result);
            $query1->free_result();	
	}
    
	function select_data_tran_4($no_bukti1='') {
    
    $no_bukti1 = $this->input->post('no_bukti1');

        $sql    = "SELECT kd_kegiatan,nm_kegiatan,kd_rek5,kd_rek_blud,nilai, no_bukti FROM trdtransout_blud WHERE no_bukti='$no_bukti1' ORDER BY no_bukti, kd_kegiatan, kd_rek5"; 
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx' => $ii,
                        'kdkegiatan' => $resulte['kd_kegiatan'],
                        'nmkegiatan' => $resulte['nm_kegiatan'],       
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'nmrek5'     => $resulte['kd_rek_blud'],  
                        'nilai1'     => number_format($resulte['nilai']),
                        'no_bukti'   => $resulte['no_bukti']
                        );
                        $ii++;
        }
           echo json_encode($result);
           $query1->free_result();
    }
    
	function select_data_tran_5($no_bukti1='') {
        
        $kd_skpd   = $this->session->userdata('kdskpd');
        $no_bukti1 = $this->input->post('no_bukti1');
        
        $lcfilt = $no_bukti1;
        $lc     = '';
        if ($lcfilt!=''){
            $lcfilt = str_replace('A',"'",$lcfilt);
            $lcfilt = str_replace('B',",",$lcfilt);
            $lc = " and no_bukti not in ($lcfilt) ";
        }
        
        $sql    = " SELECT no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' $lc ORDER BY no_bukti ";                   
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx'      => $ii,
                        'no_bukti' => $resulte['no_bukti']
                        );
                        $ii++;
        }
           echo json_encode($result);
           $query1->free_result();
    }
    
	function load_data_transaksi($kdskpd='',$nolpj='') {
        $kdskpd  = $this->session->userdata('kdskpd');	
		$nolpj = $this->input->post('nolpj');

		$sql = "SELECT a.kd_kegiatan,a.kd_rek5, a.nm_rek5, a.kd_rek_blud, a.nm_rek_blud, a.nilai ,a.no_bukti,a.no_lpj, b.kd_skpd FROM trlpj_blud a INNER JOIN trhlpj_blud b 
                    ON a.no_lpj=b.no_lpj 
				WHERE b.kd_skpd='$kdskpd'  and a.no_lpj='$nolpj' ORDER BY a.no_bukti, a.kd_kegiatan, a.kd_rek5";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx' => $ii,
                        'kdkegiatan' => $resulte['kd_kegiatan'],
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'nmrek5'     => $resulte['nm_rek5'],  
						'kdrekblud'     => $resulte['kd_rek_blud'],  
                        'nmrekblud'     => $resulte['nm_rek_blud'],  
                        'nilai1'     => number_format($resulte['nilai'],2,'.',','),
                        'no_bukti'   => $resulte['no_bukti']
                        );
                        $ii++;
        }
           echo json_encode($result);
           $query1->free_result();
    }
    
	function cetakspp6(){
		
		$print = $this->uri->segment(3);
        $nomor = str_replace('123456789','/',$this->uri->segment(4));
		$kd    = $this->uri->segment(5);
        $jns   = $this->uri->segment(6);
		$pa   	= str_replace('123456789',' ',$this->uri->segment(7));
        $tanpa   = $this->uri->segment(8);
		$spasi = $this->uri->segment(9); 
		
		
		$data	= $this->M_Spp->cetakspp6($kd,$nomor,$jns,$pa,$print,$spasi,$tanpa);				
		echo json_encode ($data);          
    }
	
	function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;
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
		case  0:
        return  "-";
        break;
		
    }
    }
    
	//akhir sppgu


//SPP TU
	function spp_tu(){
		$data['page_title']= 'INPUT SPP TU';
		$this->template->set('title', 'INPUT SPP TU');   
		$this->template->load('template','tukd/spp/spp_tu',$data) ; 
    }	
    
	function load_kegiatan_tu() { 
        $cskpd  =  $this->input->post('kdskpd');
		$data	= $this->M_Spp->load_kegiatan_tu($cskpd);				
		echo json_encode($data);
	}
	
	function load_rek_trdrka() { 
        $cskpd  =  $this->input->post('kdskpd');
        $kode_giat  =  $this->input->post('kode_giat');
		$data	= $this->M_Spp->load_rek_trdrka($cskpd,$kode_giat);				
		echo json_encode($data);
	}
	
	function load_rek_spp() {  
        $ckdkegi  = $this->input->post('kdkegiatan');
        $ckdrek   = $this->input->post('kdrek');
        $beban   = $this->input->post('beban');
		$data	= $this->M_Spp->load_rek_spp($ckdkegi,$ckdrek,$beban);				
		echo json_encode($data);
	}
	
	function load_rek_ali() {  
        $ckdkegi  = $this->input->post('kdkegiatan');
        $ckdrek   = $this->input->post('kdrek');
        $beban   = $this->input->post('beban');
		$data	= $this->M_Spp->load_rek_ali($ckdkegi,$ckdrek,$beban);				
		echo json_encode($data);
	}
	
	 function jumlah_ang_spp(){  
        $ckdkegi  = $this->input->post('kegiatan');
        $ckdrek   = $this->input->post('kdrek5');
        $crekblud = $this->input->post('kdrekblud');
        $ckdskpd  = $this->input->post('kd_skpd');
        $cnospp   = $this->input->post('no_spp');
		$data	= $this->M_Spp->jumlah_ang_spp($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$cnospp);				
		echo json_encode($data);
    }
   
	function simpan_spp_tu(){
        $no_spp		 = $this->input->post('no');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('beban');
        $bln   		 = $this->input->post('bulan');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('total');
        $skpd   	 = $this->input->post('skpd');
        $lcnilaidet	 = $this->input->post('sql');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spp->simpan_spp_tu($no_spp,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function update_spp_tu(){
        $no_spp		 = $this->input->post('no');
        $nohide		 = $this->input->post('nohide');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('beban');
        $bln   		 = $this->input->post('bulan');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('total');
        $skpd   	 = $this->input->post('skpd');
        $lcnilaidet	 = $this->input->post('sql');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spp->update_spp_tu($no_spp,$nohide,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function load_spp_tu() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		$data	= $this->M_Spp->load_spp_tu($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function load_detail_spp() {
		$kd_skpd = $this->input->post('skpd');
		$spp = $this->input->post('spp');
		$data	= $this->M_Spp->load_detail_spp($kd_skpd,$spp);				
		echo json_encode($data);
    }
    
//SPP GAJI
	function spp_gj(){
		$data['page_title']= 'INPUT SPP LS GAJI';
		$this->template->set('title', 'INPUT SPP LS GAJI');   
		$this->template->load('template','tukd/spp/spp_gj',$data) ; 
    }	
	
	function simpan_spp_gj(){
        $no_spp		 = $this->input->post('no');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('beban');
        $bln   		 = $this->input->post('bulan');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('total');
        $skpd   	 = $this->input->post('skpd');
        $lcnilaidet	 = $this->input->post('sql');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spp->simpan_spp_gj($no_spp,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function update_spp_gj(){
        $no_spp		 = $this->input->post('no');
        $nohide		 = $this->input->post('nohide');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('beban');
        $bln   		 = $this->input->post('bulan');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('total');
        $skpd   	 = $this->input->post('skpd');
        $lcnilaidet	 = $this->input->post('sql');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spp->update_spp_tu($no_spp,$nohide,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function load_spp_gj() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		$data	= $this->M_Spp->load_spp_gj($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
//SPP LS
	function spp_ls(){
		$data['page_title']= 'INPUT SPP LS BARANG JASA';
		$this->template->set('title', 'INPUT SPP LS BARANG JASA');   
		$this->template->load('template','tukd/spp/spp_ls',$data) ; 
    }	
	
	function load_kegiatan_ls() { 
        $cskpd  =  $this->input->post('kdskpd');
		$data	= $this->M_Spp->load_kegiatan_ls($cskpd);				
		echo json_encode($data);
	}

	function load_detail_penagihan() {
		$kd_skpd = $this->input->post('skpd');
		$no_tagih = $this->input->post('tagih');
		$data	= $this->M_Spp->load_detail_penagihan($kd_skpd,$no_tagih);				
		echo json_encode($data);
    }	
	
	function load_no_penagihan() { 
        $skpd = $this->input->post('skpd');
        $lccr = $this->input->post('q');
        $sql = "SELECT no_bukti,total FROM trhtagih_blud WHERE kd_skpd='$skpd' AND status !='1' AND jns_spp='6'";
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
        echo json_encode($result);
	}

	function simpan_spp_ls(){
        $no_spp		 = $this->input->post('no');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('beban');
        $bln   		 = $this->input->post('bulan');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('total');
        $rekanan   	 = $this->input->post('rekanan');
        $bank   	 = $this->input->post('bank');
        $pimpinan  	 = $this->input->post('pimpinan');
        $npwp   	 = $this->input->post('npwp');
        $rekening  	 = $this->input->post('rekening');
        $skpd   	 = $this->input->post('skpd');
        $jns   	 	 = $this->input->post('jns');
        $tagih   	 = $this->input->post('tagih');
        $lcnilaidet	 = $this->input->post('sql');
        $alamat	 = $this->input->post('alamat');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spp->simpan_spp_ls($no_spp,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update,$rekanan,$bank,$pimpinan,$npwp,$rekening,$jns,$tagih,$alamat);				
		echo json_encode($data);
    }

	function update_spp_ls(){
        $no_spp		 = $this->input->post('no');
        $nohide		 = $this->input->post('nohide');
        $tgl   		 = $this->input->post('tgl');
        $bbn   		 = $this->input->post('beban');
        $bln   		 = $this->input->post('bulan');
        $ket   		 = $this->input->post('ket');
        $nilai  	 = $this->input->post('total');
        $skpd   	 = $this->input->post('skpd');
		$rekanan   	 = $this->input->post('rekanan');
        $bank   	 = $this->input->post('bank');
        $pimpinan  	 = $this->input->post('pimpinan');
        $npwp   	 = $this->input->post('npwp');
        $rekening  	 = $this->input->post('rekening');
		$jns   	 	 = $this->input->post('jns');
        $tagih   	 = $this->input->post('tagih');
        $tagih_hide	 = $this->input->post('tagih_hide');
        $lcnilaidet	 = $this->input->post('sql');
        $alamat	 = $this->input->post('alamat');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spp->update_spp_ls($no_spp,$nohide,$tgl,$bbn,$bln,$ket,$nilai,$skpd,$lcnilaidet,$usernm,$last_update,$rekanan,$bank,$pimpinan,$npwp,$rekening,$jns,$tagih,$tagih_hide,$alamat);				
		echo json_encode($data);
    } 
	
	function load_spp_ls() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		$data	= $this->M_Spp->load_spp_ls($kd_skpd,$kriteria);				
		echo json_encode($data);
	}

	function load_sum_tagih(){
		$tagih 	= $this->input->post('tagih');
		$skpd 	= $this->input->post('skpd');
		$data	= $this->M_Spp->load_sum_tagih($tagih,$skpd);				
		echo json_encode($data);
	}
	
	function load_ttd($ttd){
        $kd_skpd = $this->session->userdata('kdskpd'); 
		$data	= $this->M_Spp->load_ttd($kd_skpd,$ttd);				
		echo json_encode($data);
	}

	 function cetakspp1(){
		$print 	= $this->uri->segment(3);
		$no_spp	= str_replace('123456789','/',$this->uri->segment(4));
        $skpd 	= $this->uri->segment(5);
        $jns   	= $this->uri->segment(6);
        $bk   	= str_replace('123456789',' ',$this->uri->segment(7));
        $pa   	= str_replace('123456789',' ',$this->uri->segment(8));
        $spasi	= $this->uri->segment(9);
        $tanpa	= $this->uri->segment(10);
		$data	= $this->M_Spp->cetakpengantarspp($skpd,$no_spp,$jns,$bk,$pa,$print,$spasi,$tanpa);				
		echo ($data);
	 }
	 
	  function cetakspp2(){
		$print 	= $this->uri->segment(3);
		$no_spp	= str_replace('123456789','/',$this->uri->segment(4));
        $skpd 	= $this->uri->segment(5);
        $jns   	= $this->uri->segment(6);
        $bk   	= str_replace('123456789',' ',$this->uri->segment(7));
        $pa   	= str_replace('123456789',' ',$this->uri->segment(8));
        $spasi	= $this->uri->segment(9);
        $tanpa	= $this->uri->segment(10);
		$data	= $this->M_Spp->cetakringkasanspp($skpd,$no_spp,$jns,$bk,$pa,$print,$spasi,$tanpa);				
		echo ($data);
	 }
	 
	 function cetakspp3(){
		$print 	= $this->uri->segment(3);
		$no_spp	= str_replace('123456789','/',$this->uri->segment(4));
        $skpd 	= $this->uri->segment(5);
        $jns   	= $this->uri->segment(6);
        $bk   	= str_replace('123456789',' ',$this->uri->segment(7));
        $pa   	= str_replace('123456789',' ',$this->uri->segment(8));
        $spasi	= $this->uri->segment(9);
        $tanpa	= $this->uri->segment(10);
		$data	= $this->M_Spp->cetakrincianspp($skpd,$no_spp,$jns,$bk,$pa,$print,$spasi,$tanpa);				
		echo ($data);
	 }
	 
	 
	function config_spp(){
        $skpd = $this->uri->segment(3);
		/*
		$sql = "select count(no_spp) as nilai ,kd_skpd,right(kd_skpd,2) as kd,
					(select  top 1 thn_ang from sclient_blud) as thn_ang
					from trhsp2d_blud where kd_skpd ='$skpd' 
					group by kd_skpd"; 
		*/			
					
		$sql = "select sum(case 
				when x.nilai_x-x.nilai_y='0' 
				then x.nilai_x
				when x.nilai_y='0' 
				then '1'
				 end) as nilai,x.kd_skpd,x.kd,x.thn_ang from (
				select '1' urut,count(no_spp) as nilai_x,count(no_spp) nilai_y,kd_skpd,
				right(kd_skpd,2) as kd,
				(select  top 1 thn_ang from sclient_blud) as thn_ang
				from trhsp2d_blud where kd_skpd ='$skpd' 
				group by kd_skpd
				union all
				select '2' urut,'0' nilai_x,'0' nilai_y,'$skpd' kd_skpd,RIGHT('$skpd',2) kd,
				(select  top 1 thn_ang from sclient_blud) as thn_ang
				) x
				group by x.kd_skpd,x.kd,x.thn_ang "; 			
        $query1 = $this->db->query($sql);  
		
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(                                
                        'nomor' => $resulte['nilai'] + 1,
						 'kd' => $resulte['kd'] ,
						 'thn_ang' => $resulte['thn_ang'] ,
                        );
                        
        }
        echo json_encode($result); 	
    }

	
}