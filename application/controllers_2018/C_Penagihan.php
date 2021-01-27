<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class C_Penagihan extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		$this->load->model('M_Penagihan');
		$this->load->model('M_Transout');
	}
    
	function config_tahun() {
        $result = array();
         $tahun  = $this->session->userdata('pcThang');
		 $result = $tahun;
         echo json_encode($result);
	}
	
	function load_penagihan_ls(){
		$skpd     	= $this->session->userdata('kdskpd');
        $kriteria 	= $this->input->post('cari');
		$data		= $this->M_Penagihan->load_penagihan_ls($skpd,$kriteria);
		echo json_encode($data);
    }
	
	function load_penagihan_non_ls(){
		$skpd     	= $this->session->userdata('kdskpd');
        $kriteria 	= $this->input->post('cari');
		$data		= $this->M_Penagihan->load_penagihan_non_ls($skpd,$kriteria);
		echo json_encode($data);
    }
	
	function kontrak() {                 
        $lccr 		= $this->input->post('q');
		$kd_skpd  	= $this->session->userdata('kdskpd');    
		$data		= $this->M_Penagihan->kontrak($lccr,$kd_skpd);
		echo json_encode($data);		
    }
	
	function load_trskpd() {
        $giat = $this->input->post ( 'giat' );
        $cskpd = $this->input->post ( 'kd' );
        $jns_beban = '';
        $cgiat = '';
		$data	= $this->M_Transout->load_trskpd($giat,$cskpd);			
		echo json_encode($data);
    }
	
	function load_rek_penagihan() {                      
        $jenis  = $this->input->post('jenis');
        $giat   = $this->input->post('giat');  
        $kode   = $this->input->post('kd');
        $nomor  = $this->input->post('no');
        $rek    = $this->input->post('rek');        
        $lccr   = $this->input->post('q');
        $data	= $this->M_Penagihan->load_rek_penagihan($jenis,$giat,$kode,$nomor,$rek,$lccr);
		echo json_encode($data);
	}
	
	function simpan_penagihan_ls(){
        $nomor       = $this->input->post('cno');
        $sts_tagih 	 = $this->input->post('cjenis_bayar');
        $tgl         = $this->input->post('ctgl');
        $skpd        = $this->input->post('cskpd');
		$nm_skpd   	 = $this->input->post('cnmskpd');
        $ket         = $this->input->post('cket');
        $jns      	 = $this->input->post('jns');
        $kontrak     = $this->input->post('kontrak');
        $cjenis      = $this->input->post('cjenis');
        $sql_detail  = $this->input->post('sql_detail');
        $ctotal      = $this->input->post('ctotal');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Penagihan->simpan_penagihan_ls($nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update);
		echo json_encode($data);
    }
	
	function update_penagihan_ls(){
        $no_hide       = $this->input->post('cnohide');
        $nomor       = $this->input->post('cno');
        $sts_tagih 	 = $this->input->post('cjenis_bayar');
        $tgl         = $this->input->post('ctgl');
        $skpd        = $this->input->post('cskpd');
		$nm_skpd   	 = $this->input->post('cnmskpd');
        $ket         = $this->input->post('cket');
        $jns      	 = $this->input->post('jns');
        $kontrak     = $this->input->post('kontrak');
        $cjenis      = $this->input->post('cjenis');
        $sql_detail  = $this->input->post('sql_detail');
        $ctotal      = $this->input->post('ctotal');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Penagihan->update_penagihan_ls($no_hide,$nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update);
		echo json_encode($data);
    }
	
	function simpan_penagihan_non_ls(){
        $nomor       = $this->input->post('cno');
        $sts_tagih 	 = $this->input->post('cjenis_bayar');
        $tgl         = $this->input->post('ctgl');
        $skpd        = $this->input->post('cskpd');
		$nm_skpd   	 = $this->input->post('cnmskpd');
        $ket         = $this->input->post('cket');
        $jns      	 = $this->input->post('jns');
        $kontrak     = $this->input->post('kontrak');
        $cjenis      = $this->input->post('cjenis');
        $sql_detail  = $this->input->post('sql_detail');
        $ctotal      = $this->input->post('ctotal');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Penagihan->simpan_penagihan_non_ls($nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update);
		echo json_encode($data);
    }
	
	function update_penagihan_non_ls(){
        $no_hide     = $this->input->post('cnohide');
        $nomor       = $this->input->post('cno');
        $sts_tagih 	 = $this->input->post('cjenis_bayar');
        $tgl         = $this->input->post('ctgl');
        $skpd        = $this->input->post('cskpd');
		$nm_skpd   	 = $this->input->post('cnmskpd');
        $ket         = $this->input->post('cket');
        $jns      	 = $this->input->post('jns');
        $kontrak     = $this->input->post('kontrak');
        $cjenis      = $this->input->post('cjenis');
        $sql_detail  = $this->input->post('sql_detail');
        $ctotal      = $this->input->post('ctotal');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Penagihan->update_penagihan_non_ls($no_hide,$nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update);
		echo json_encode($data);
    }
	
	
	
	function load_dtagih(){        
        $nomor 	= $this->input->post('no');    
        $skpd 	= $this->input->post('skpd'); 
		$data	= $this->M_Penagihan->load_dtagih($nomor,$skpd);
		echo json_encode($data);
    }
	
	function load_tot_tagih(){
		$no 	= $this->input->post('no');
		$skpd 	= $this->input->post('skpd');
		$data	= $this->M_Penagihan->load_tot_tagih($no,$skpd);
		echo json_encode($data);
	}
    
	
	function penagihan_nonls(){
        $data['page_title']= 'INPUT PENAGIHAN NON LS';
        $this->template->set('title', 'INPUT PENAGIHAN NON LS');   
        $this->template->load('template','tukd/transaksi/penagihan_non_ls',$data) ; 
    }
	
	function load_sp2d() {
        $giat        = $this->input->post ( 'giat' );
        $kode        = $this->input->post ( 'kd' );
		$data		= $this->M_Penagihan->load_sp2d($giat,$kode);			
		echo json_encode($data);
    }
	
	function load_sisa_kas(){
        $skpd   = $this->input->post ( 'kode' );
        $data	= $this->M_Penagihan->load_sisa_kas($skpd);			
		echo json_encode($data);	
	}
	
}