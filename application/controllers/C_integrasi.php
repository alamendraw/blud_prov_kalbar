<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_integrasi extends CI_Controller {

	function __construct(){	
		parent::__construct();
	}

    function get_rek5_pendapatan() {
        $lccr = $this->input->post('q');
        $sql = "SELECT concat(left(kd_rek5,1),'.',SUBSTRING(kd_rek5, 2, 1),'.',SUBSTRING(kd_rek5, 3, 1),'.',SUBSTRING(kd_rek5, 4, 2),'.',SUBSTRING(kd_rek5, 6, 2)) kd_rek5,kd_rek5 kode,nm_rek5 from ms_rek5 where left(kd_rek5,1)='4' and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) ";
 
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    public function penerimaan(){ 
        $data['page_title']= 'Integrasi Penerimaan';
        $this->template->set('title', 'Integrasi Penerimaan');   
        $this->template->load('template','integrasi/penerimaan',$data) ;
    }
	
    function save_data(){
        $data = $this->input->post('data');
        $tanggal = date('Y-m-d');
        //HAPUS DATA DI TANGGAL YANG SAMA
        $this->db->delete("temp_penerimaan", ['created_at'=>$tanggal]);
        foreach($data as $row){
            $no_terima= $row['no_terima'];
            $field = array(
                'jenis' => $row['jenis'],
                'kd_kegiatan' => $row['kd_kegiatan'],
                'kd_rek5' => $row['kd_rek5'],
                'kd_rek_lo' => $row['kd_rek_lo'],
                'kd_skpd' => $row['kd_skpd'],
                'keterangan' => $row['keterangan'],
                'nilai' => $row['nilai'],
                'no_terima' => $no_terima,
                'no_tetap' => $row['no_tetap'],
                'sts_tetap' => $row['sts_tetap'],
                'tgl_terima' => $row['tgl_terima'],
                'tgl_tetap' => $row['tgl_tetap'],
                'username' => $row['username'],
                'created_at' => $tanggal
            ); 
            //INSERT TABEL TEMPORARY
            $this->db->insert("temp_penerimaan", $field);

            //CEK DATA TABEL PENERIMAAN
            $cek_terima = $this->db->query("SELECT count(*) total from tr_terima_blud where no_terima='$no_terima'")->row('total');
            if($cek_terima>0){ 
                $upd_field = array(
                    'jenis' => $row['jenis'],
                    'kd_kegiatan' => $row['kd_kegiatan'],
                    'kd_rek5' => str_replace('.','',$row['kd_rek5']), 
                    'kd_skpd' => $row['kd_skpd'],
                    'keterangan' => $row['keterangan'],
                    'nilai' => $row['nilai'], 
                    'no_tetap' => $row['no_tetap'],
                    'sts_tetap' => $row['sts_tetap'],
                    'tgl_terima' => $row['tgl_terima'],
                    'tgl_tetap' => $row['tgl_tetap']
                );
                $this->db->update("tr_terima_blud",['no_terima'=>$no_terima],$upd_field);
            }else{ 
                $ins_field = array(
                    'jenis' => $row['jenis'],
                    'kd_kegiatan' => $row['kd_kegiatan'],
                    'kd_rek5' => str_replace('.','',$row['kd_rek5']), 
                    'kd_skpd' => $row['kd_skpd'],
                    'keterangan' => $row['keterangan'],
                    'nilai' => $row['nilai'],
                    'no_terima' => $no_terima,
                    'no_tetap' => $row['no_tetap'],
                    'sts_tetap' => $row['sts_tetap'],
                    'tgl_terima' => $row['tgl_terima'],
                    'tgl_tetap' => $row['tgl_tetap']
                );                
                $this->db->insert("tr_terima_blud", $ins_field);
            } 
        }
        
        $result['status'] = 'success';
        $result['message'] = 'Data Berhasil Terintegrasi';
        echo json_encode($result);
    }

    function data_api() {
        $tanggal = date('Y-m-d');        
        $sql = "SELECT no_terima,tgl_terima,kd_rek5,nilai,keterangan from temp_penerimaan where created_at='$tanggal' order by no_terima";
        // echo $sql; die;
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'no_terima' => $resulte['no_terima'],
                        'tgl_terima' => $resulte['tgl_terima'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'nilai' => number_format($resulte['nilai'],2),
                        'keterangan' => $resulte['keterangan']                                                                                     
                    );
                    $ii++;
        }
           
        echo json_encode($result);
    	   
	}
}
