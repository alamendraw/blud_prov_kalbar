<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class C_spm extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		$this->load->model('M_Spm');
	}
    
	function config_tahun() {
        $result = array();
         $tahun  = $this->session->userdata('pcThang');
		 $result = $tahun;
         echo json_encode($result);
	}
	
	function spm(){
        $data['page_title']= 'INPUT SPM';
        $this->template->set('title', 'INPUT SPM');   
        $this->template->load('template','tukd/spm/spm',$data) ; 
    }
	
	
	function load_spp() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('q');
		$data	= $this->M_Spm->load_spp($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function simpan_spm(){
        $no_spm		 = $this->input->post('no');
        $tgl   		 = $this->input->post('tgl');
        $no_spp   	 = $this->input->post('nospp');
        $skpd   	 = $this->input->post('skpd');
		$lcnilaidet	 = $this->input->post('sql');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spm->simpan_spm($no_spm,$tgl,$no_spp,$skpd,$usernm,$last_update,$lcnilaidet);				
		echo json_encode($data);
    }
	
	function update_spm(){
        $no_spm		 = $this->input->post('no');
        $no_spm_hide = $this->input->post('no_hide');
        $tgl   		 = $this->input->post('tgl');
        $no_spp   	 = $this->input->post('nospp');
        $no_spp_hide = $this->input->post('nospp_hide');
        $skpd   	 = $this->input->post('skpd');
		$lcnilaidet	 = $this->input->post('sql');
		$usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Spm->update_spm($no_spm,$tgl,$no_spp,$skpd,$usernm,$last_update,$lcnilaidet,$no_spp_hide,$no_spm_hide);				
		echo json_encode($data);
    }

	function load_spm() {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
		$data	= $this->M_Spm->load_spm($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function load_detail_potongan() {
		$kd_skpd = $this->input->post('skpd');
		$spm = $this->input->post('spm');
		$data	= $this->M_Spm->load_detail_potongan($kd_skpd,$spm);				
		echo json_encode($data);
    }
	
	function load_sum_pot(){
		$spm    = $this->input->post('spm');
		$skpd    = $this->input->post('skpd');
        $query1 = $this->db->query("select sum(nilai) as rektotal from trspmpot_blud where no_spm='$spm' AND kd_skpd='$skpd'");  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'rektotal' => number_format($resulte['rektotal'],2,'.',','),
                        'rektotal1' => $resulte['rektotal']                       
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
           $query1->free_result();	
	}
    
	 function hapus_spm() { 
  		$spm   = $this->input->post('spm');
		$skpd  = $this->input->post('skpd');
        $spp   = $this->input->post('spp'); 
		$data  = $this->M_Spm->hapus_spm($spm,$skpd,$spp);				
		echo json_encode($data);
    }
	
	function rek_pot_trans() {
        $spp = $this->input->post('no_spp') ;
        $skpd   = $this->input->post('skpd') ;
        $lccr   = $this->input->post('q') ;
		$data  = $this->M_Spm->rek_pot_trans($spp,$skpd,$lccr);				
		echo json_encode($data);
	}
   
    function rek_pot() {
        $lccr   = $this->input->post('q') ;
        $data  = $this->M_Spm->rek_pot($lccr);				
		echo json_encode($data);
	}
	

	function cetak_spm(){
        $cetak 		= $this->uri->segment(3);
		$lcnospm 	= str_replace('123456789','/',$this->uri->segment(4));
        $kd 		= $this->uri->segment(5);
        $jns 		= $this->uri->segment(6);
        $tanpa 		= $this->uri->segment(9);
        $baris 		= $this->uri->segment(10);
		$BK 		= str_replace('123456789',' ',$this->uri->segment(7));
        $PA 		= str_replace('123456789',' ',$this->uri->segment(8));
		$PPK 		= str_replace('123456789',' ',$this->uri->segment(11));
		$data		= $this->M_Spm->cetak_spm($cetak,$lcnospm,$kd,$jns,$tanpa,$baris,$BK,$PA,$PPK);				
		echo ($data);
		 
	}
	
	function config_spm(){
        $skpd = $this->uri->segment(3);
		
/*		
		$sql = "select count(no_spm) as nilai ,kd_skpd,right(kd_skpd,2) as kd,
					(select  top 1 thn_ang from sclient_blud) as thn_ang
					from trhsp2d_blud where kd_skpd ='$skpd'  and len(no_spm)>1
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
				from trhsp2d_blud where kd_skpd ='$skpd'  and len(no_spm)>1
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