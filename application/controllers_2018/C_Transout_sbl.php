<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class C_Transout extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		$this->load->model('M_Transout');
	}
	
	function transout_blud() {
        $data ['page_title'] = 'INPUT PEMBAYARAN TRANSAKSI';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT PEMBAYARAN TRANSAKSI' );
        $this->template->load ( 'template', 'tukd/transaksi/transout_blud', $data );
        $this->tukd_model->set_log_activity(); 
    }

    
	function config_tahun() {
        $result = array();
         $tahun  = $this->session->userdata('pcThang');
		 $result = $tahun;
         echo json_encode($result);
	}
	
	function input_sp2d(){
        $data['page_title']= 'INPUT SP2D';
        $this->template->set('title', 'INPUT SP2D');   
        $this->template->load('template','tukd/sp2d/input_sp2d',$data) ; 
    }
	
	
	function load_spm() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('q');
		$data	= $this->M_Sp2d->load_spm($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function load_transout() {
        $kd_skpd = $this->session->userdata ( 'kdskpd' );
		$kriteria = '';
        $kriteria = $this->input->post ( 'cari' );
		$data	= $this->M_Transout->load_transout($kd_skpd,$kriteria);				
		echo json_encode($data);
    } 

	function load_trskpd() {
        $giat = $this->input->post ( 'giat' );
        $cskpd = $this->input->post ( 'kd' );
        $jns_beban = '';
        $cgiat = '';
		$data	= $this->M_Transout->load_trskpd_blud($giat,$cskpd);			
		echo json_encode($data);
    }
	
	function load_dtransout() {
        $nomor = $this->input->post ( 'no' );
        $skpd = $this->input->post ( 'kd_skpd' );
		$data	= $this->M_Transout->load_dtransout($nomor,$skpd);			
		echo json_encode($data);
    }
	
	function hapus_transout() {
        $nomor = $this->input->post ( 'no' );
        $skpd = $this->input->post ( 'skpd' );
		$data	= $this->M_Transout->hapus_transout($nomor,$skpd);			
		echo json_encode($data);
    }

	
	function load_sp2d() {
        $giat        = $this->input->post ( 'giat' );
        $kode        = $this->input->post ( 'kd' );
        $jns        = $this->input->post ( 'jns' );
		$data		= $this->M_Transout->load_sp2d($giat,$kode,$jns);			
		echo json_encode($data);
    }
	
	function load_rek() {
        $giat        = $this->input->post ( 'giat' );
        $skpd        = $this->input->post ( 'kd' );
        $nomor       = $this->input->post ( 'no' );
        $sp2d        = $this->input->post ( 'sp2d' );
        $lccr        = $this->input->post ( 'q' );
		$data		= $this->M_Transout->load_rek($giat,$skpd,$nomor,$sp2d);			
		echo json_encode($data);
    }
	
	function cek_verify(){
         $nomor    = $this->input->post ( 'no' );
         $skpd     = $this->input->post ( 'skpd' );
         $sql = "select * from trhtransout_blud where kd_skpd='$skpd' and no_bukti='$nomor'";
         $asg = $this->db->query ( $sql );
         if ($asg->num_rows()>0){
            echo 0;
         }else{
            echo 1;
         }
    }
	
	function jumlah_ang_trans(){  
        $ckdkegi  = $this->input->post('kegiatan');
        $ckdrek   = $this->input->post('kdrek5');
        $crekblud = $this->input->post('kdrekblud');
        $ckdskpd  = $this->input->post('kd_skpd');
        $jns   = $this->input->post('jns');
        $sp2d   = $this->input->post('sp2d');
		$data	= $this->M_Transout->jumlah_ang_trans($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$jns,$sp2d);				
		echo json_encode($data);
    }
	
	
	function simpan_transout() {
        $tabel      = $this->input->post ( 'tabel' );
        $nomor      = $this->input->post ( 'no' );
        $tgl        = $this->input->post ( 'tgl' );
        $nokas      = $this->input->post ( 'nokas' );
        $tglkas     = $this->input->post ( 'tglkas' );
        $skpd       = $this->input->post ( 'skpd' );
        $nmskpd     = $this->input->post ( 'nmskpd' );
        $beban      = $this->input->post ( 'beban' );
        $ket        = $this->input->post ( 'ket' );
        $total      = $this->input->post ( 'total' );
        $csql       = $this->input->post ( 'sql' );
        $usernm     = $this->session->userdata ( 'pcNama' );
        $xpay       = $this->input->post ( 'cpay' );
        $jns_tagih  = $this->input->post ( 'jns_tgh' );
        $no_tagih   = $this->input->post ( 'no_tgh' );
        $update 	= date ( 'Y-m-d H:i:s' );
        $data		= $this->M_Transout->simpan_transout($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update,$jns_tagih,$no_tagih);			
		echo json_encode($data);
    }
	
	
	function update_transout() {
        $tabel      = $this->input->post ( 'tabel' );
        $nomor      = $this->input->post ( 'no' );
        $nomor_simpan  = $this->input->post ( 'nosimpan' );
        $tgl        = $this->input->post ( 'tgl' );
        $nokas      = $this->input->post ( 'nokas' );
        $tglkas     = $this->input->post ( 'tglkas' );
        $skpd       = $this->input->post ( 'skpd' );
        $nmskpd     = $this->input->post ( 'nmskpd' );
        $beban      = $this->input->post ( 'beban' );
        $ket        = $this->input->post ( 'ket' );
        $total      = $this->input->post ( 'total' );
        $csql       = $this->input->post ( 'sql' );
        $usernm     = $this->session->userdata ( 'pcNama' );
        $xpay       = $this->input->post ( 'cpay' );
		$jns_tagih  = $this->input->post ( 'jns_tgh' );
        $no_tagih   = $this->input->post ( 'no_tgh' );
        $update		= date ( 'Y-m-d H:i:s' );
		$data		= $this->M_Transout->update_transout($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update,$nomor_simpan,$jns_tagih,$no_tagih);			
		echo json_encode($data);
    }
	
	function load_no_penagihan() { 
        $skpd = $this->input->post('skpd');
        $lccr = $this->input->post('q');
        $data = $this->M_Transout->load_no_penagihan($skpd,$lccr);			
		echo json_encode($data);
	}
	
	function load_detail_penagihan() {
		$kd_skpd = $this->input->post('skpd');
		$no_tagih = $this->input->post('tagih');
		$data	= $this->M_Transout->load_detail_penagihan($kd_skpd,$no_tagih);				
		echo json_encode($data);
    }
	
	function pengembalian_transaksi() {
        $data ['page_title'] = 'INPUT PENGEMBALIAN TRANSAKSI';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT PENGEMBALIAN TRANSAKSI' );
        $this->template->load ( 'template', 'tukd/transaksi/pengembalian_transaksi', $data );
        $this->tukd_model->set_log_activity(); 
    }
	
	function load_giat_trans() {
        $cskpd = $this->input->post ( 'kd' );
        $sp2d = $this->input->post ( 'sp2d' );
		$data	= $this->M_Transout->load_giat_trans($sp2d,$cskpd);			
		echo json_encode($data);
    }
	
	function load_sp2d_trans() {
        $kode        = $this->input->post ( 'kd' );
        $jns        = $this->input->post ( 'jns' );
		$data		= $this->M_Transout->load_sp2d_trans($kode,$jns);			
		echo json_encode($data);
    }
	
	function load_rek_trans() {
        $giat        = $this->input->post ( 'giat' );
        $skpd        = $this->input->post ( 'kd' );
        $sp2d        = $this->input->post ( 'sp2d' );
        $lccr        = $this->input->post ( 'q' );
		$data		= $this->M_Transout->load_rek_trans($giat,$skpd,$sp2d);			
		echo json_encode($data);
    }
	
	function jumlah_sisa_trans(){  
        $ckdkegi  = $this->input->post('kegiatan');
        $ckdrek   = $this->input->post('kdrek5');
        $crekblud = $this->input->post('kdrekblud');
        $ckdskpd  = $this->input->post('kd_skpd');
        $sp2d     = $this->input->post('sp2d');
		$data	  = $this->M_Transout->jumlah_sisa_trans($ckdkegi,$ckdrek,$crekblud,$ckdskpd,$sp2d);				
		echo json_encode($data);
    }
	function cek_verify_(){
         $nomor    = $this->input->post ( 'no' );
         $skpd     = $this->input->post ( 'skpd' );
         $sql = "select * from trhkasin_blud where kd_skpd='$skpd' and no_sts='$nomor'";
         $asg = $this->db->query ( $sql );
         if ($asg->num_rows()>0){
            echo 0;
         }else{
            echo 1;
         }
    }
	
	function simpan_pengembalian() {
        $tabel      = $this->input->post ( 'tabel' );
        $nomor      = $this->input->post ( 'no' );
        $tgl        = $this->input->post ( 'tgl' );
        $nokas      = $this->input->post ( 'nokas' );
        $tglkas     = $this->input->post ( 'tglkas' );
        $skpd       = $this->input->post ( 'skpd' );
        $nmskpd     = $this->input->post ( 'nmskpd' );
        $beban      = $this->input->post ( 'beban' );
        $ket        = $this->input->post ( 'ket' );
        $total      = $this->input->post ( 'total' );
        $csql       = $this->input->post ( 'sql' );
        $usernm     = $this->session->userdata ( 'pcNama' );
        $xpay       = $this->input->post ( 'cpay' );
        $update 	= date ( 'Y-m-d H:i:s' );
        $data		= $this->M_Transout->simpan_pengembalian($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update);			
		echo json_encode($data);
    }
	
	
	function update_pengembalian() {
        $tabel      = $this->input->post ( 'tabel' );
        $nomor      = $this->input->post ( 'no' );
        $nomor_simpan  = $this->input->post ( 'nosimpan' );
        $tgl        = $this->input->post ( 'tgl' );
        $nokas      = $this->input->post ( 'nokas' );
        $tglkas     = $this->input->post ( 'tglkas' );
        $skpd       = $this->input->post ( 'skpd' );
        $nmskpd     = $this->input->post ( 'nmskpd' );
        $beban      = $this->input->post ( 'beban' );
        $ket        = $this->input->post ( 'ket' );
        $total      = $this->input->post ( 'total' );
        $csql       = $this->input->post ( 'sql' );
        $usernm     = $this->session->userdata ( 'pcNama' );
        $xpay       = $this->input->post ( 'cpay' );
        $update		= date ( 'Y-m-d H:i:s' );
		$data		= $this->M_Transout->update_pengembalian($tabel,$nomor,$tgl,$nokas,$tglkas,$skpd,$nmskpd,$beban,$ket,$total,$csql,$usernm,$xpay,$update,$nomor_simpan);			
		echo json_encode($data);
    }
	
	function load_pengembalian() {
        $kd_skpd = $this->session->userdata ( 'kdskpd' );
		$kriteria = '';
        $kriteria = $this->input->post ( 'cari' );
		$data	= $this->M_Transout->load_pengembalian($kd_skpd,$kriteria);				
		echo json_encode($data);
    } 

	function load_dpengembalian() {
        $nomor = $this->input->post ( 'no' );
        $skpd = $this->input->post ( 'kd_skpd' );
		$data	= $this->M_Transout->load_dpengembalian($nomor,$skpd);			
		echo json_encode($data);
    }
	
	function hapus_pengembalian() {
        $nomor = $this->input->post ( 'no' );
        $skpd = $this->input->post ( 'skpd' );
		$data	= $this->M_Transout->hapus_pengembalian($nomor,$skpd);			
		echo json_encode($data);
    }
	
	function load_rek1() {
        $skpd        = $this->input->post ( 'kd' );
        $lccr        = $this->input->post ( 'q' );
		$data		 = $this->M_Transout->load_rek1($skpd,$lccr);			
		echo json_encode($data);
    }
	
}