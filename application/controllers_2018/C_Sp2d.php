<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class C_sp2d extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		$this->load->model('M_Sp2d');
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
	
	function load_sp2d() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('q');
		$data	= $this->M_Sp2d->load_sp2d($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function simpan_sp2d(){
        $no_sp2d	 = $this->input->post('no');
        $tgl   		 = $this->input->post('tgl');
        $no_spm   	 = $this->input->post('nospm');
        $skpd   	 = $this->input->post('skpd');
        $kep   	 	 = $this->input->post('kep');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Sp2d->simpan_sp2d($no_sp2d,$tgl,$no_spm,$skpd,$usernm,$last_update,$kep);				
		echo json_encode($data);
    }
	
	function update_sp2d(){
        $no_sp2d	 	= $this->input->post('no');
        $no_sp2d_hide	= $this->input->post('no_hide');
        $tgl   		 	= $this->input->post('tgl');
        $no_spm   	 	= $this->input->post('nospm');
        $no_spm_hide	= $this->input->post('nospm_hide');
        $skpd   	 	= $this->input->post('skpd');
		$usernm      	= $this->session->userdata('pcNama');
		$kep	      	= $this->session->userdata('kep');
		$last_update 	= date('Y-m-d H:i:s');
		$data	= $this->M_Sp2d->update_sp2d($no_sp2d,$tgl,$no_spm,$skpd,$usernm,$last_update,$no_sp2d_hide,$no_spm_hide,$kep);				
		echo json_encode($data);
    }

	function cair_sp2d(){
        $data['page_title']= 'INPUT PENCAIRAN SP2D';
        $this->template->set('title', 'INPUT PENCAIRAN SP2D');   
        $this->template->load('template','tukd/sp2d/cair_sp2d',$data) ; 
    }
	
	function simpan_cair(){
		$nokas		= $this->input->post('nkas');
		$tglcair	= $this->input->post('tglcair');
		$nosp2d		= $this->input->post('nosp2d');
        $nospm		= $this->input->post('nospm');
        $nospp  	= $this->input->post('nospp');
        $ket  	    = $this->input->post('keperluan');
        $jns		= $this->input->post('jns');
        $skpd   	= $this->input->post('skpd');
        $total   	= $this->input->post('total');
		$data		= $this->M_Sp2d->simpan_cair($nokas,$tglcair,$nosp2d,$nospm,$nospp,$jns,$skpd,$total,$ket);				
		echo json_encode($data);
	}
	
	function batal_cair(){
		$nokas		= $this->input->post('nkas');
		$tglcair	= $this->input->post('tglcair');
		$nosp2d		= $this->input->post('nosp2d');
        $nospm		= $this->input->post('nospm');
        $nospp  	= $this->input->post('nospp');
        $jns		= $this->input->post('jns');
        $skpd   	= $this->input->post('skpd');
		$data		= $this->M_Sp2d->batal_cair($nokas,$tglcair,$nosp2d,$nospm,$nospp,$jns,$skpd);				
		echo json_encode($data);
	}
	
	
	function cetak_sp2d(){
		$lntahunang = $this->session->userdata('pcThang');
        $lcnosp2d 	= str_replace('123456789','/',$this->uri->segment(4));
        $lcttd 		= str_replace('abc',' ',$this->uri->segment(6));
	    $lckdskpd 	= $this->uri->segment(5);
	    $cetak 		= $this->uri->segment(3);
	    $banyak 	= $this->uri->segment(7);
		$jns_cetak 	= $this->uri->segment(8);
		$data		= $this->M_Sp2d->cetak_sp2d($lntahunang,$lcnosp2d,$lcttd,$lckdskpd,$cetak,$banyak,$jns_cetak);				
		echo ($data);
    }

	
	function config_sp2d(){
        $skpd = $this->uri->segment(3);
/*		
		$sql = "select count(no_sp2d) as nilai ,kd_skpd,right(kd_skpd,2) as kd,
					(select  top 1 thn_ang from sclient_blud) as thn_ang
					from trhsp2d_blud where kd_skpd ='$skpd'  and len(no_sp2d)>1
group by kd_skpd"; 
*/

		$sql = "select sum(case 
				when x.nilai_x-x.nilai_y='0' 
				then x.nilai_x
				when x.nilai_y='0' 
				then '1'
				 end) as nilai,x.kd_skpd,x.kd,x.thn_ang from (
				select '1' urut,count(no_spm) as nilai_x,count(no_spm) nilai_y,kd_skpd,
				right(kd_skpd,2) as kd,
				(select  top 1 thn_ang from sclient_blud) as thn_ang
				from trhsp2d_blud where kd_skpd ='$skpd'  and len(no_sp2d)>1
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