<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//doni star -->
class Utilities extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
		
	}

	
	function cek_con(){
		$kon =  $this->load->database('alternatif', TRUE);
		$lckon = $kon->initialize();
        if(!$lckon){
        	$data=array("isi"=>"Database Tidak Terkoneksi !!! Tidak dapat melanjutkan proses","baris"=>"BARIS","pesan"=>'1');

        }else{
            $data=array("isi"=>"Database Terkoneksi","baris"=>"BARIS","pesan"=>'0');
        }
		echo json_encode($data); 
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

	


	 function export_realisasi_blud()
    {
        $data['page_title']= 'TRANSFER DATA KEUANGAN BLUD';
        $this->template->set('title', 'TRANSFER KEUANGAN BLUD');   
        $this->template->load('template','utilitas/export/transfer',$data) ; 
    }
	
	function skpd_sig() {
		$skpd=$this->session->userdata('kdskpd');
			
		$sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd where kd_skpd='".$skpd."'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }  
    
        echo json_encode($result);
	}

	function liat(){
		$skpd=$this->session->userdata('kdskpd');
		$sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd ";
        $query1 = $this->db_keu->query($sql);  

        print_r($query1);

	}

	function hitrecord(){
		$this->load->model('koneksi');
		$bulan = $this->input->post('bulan');
		ini_set("memory_limit", "-1");
		ini_set('max_execution_time',0);

		$sql = $this->db_keu->query("Delete From temp_sp2d");

		$kd_skpd = $this->session->userdata('kdskpd');
		$where = "WHERE a.kd_skpd='$kd_skpd' AND b.kd_kegiatan='1.02.1.02.02.00.00.02' and MONTH(tgl_kas_bud) <='$bulan' AND a.`status_bud`='1'";	
		
		$query =$this->db_keu->query("SELECT a.no_sp2d,a.`tgl_sp2d`,a.`no_spm`,a.`tgl_spm`,a.`no_spp`,a.`tgl_spp`,a.no_kas,a.`kd_skpd`,a.`keperluan`,
			a.`jns_spp`,b.`kd_kegiatan`,b.kd_rek5, b.`nilai`,a.tgl_kas_bud FROM trhsp2d a INNER JOIN trdspp b ON a.`no_spp`=b.`no_spp` $where");

		$i=0;
		foreach ($query->result_array() as $dt) {
			$i++;
			$no_sp2d     = $dt['no_sp2d'];
			$tgl_sp2d    = $dt['tgl_sp2d'];
			$no_spm      = $dt['no_spm'];
			$tgl_spm     = $dt['tgl_spm'];
			$no_spp      = $dt['no_spp'];
			$tgl_spp     = $dt['tgl_spp'];
			$no_kas      = $dt['no_kas'];
			$kd_skpd     = $dt['kd_skpd'];
			$keperluan   = $dt['keperluan'];
			$jns_spp     = $dt['jns_spp'];
			$kd_kegiatan = $dt['kd_kegiatan'];
			$kd_rek5     = $dt['kd_rek5'];
			$nilai       = $dt['nilai'];
			$tgl_kas_bud = $dt['tgl_kas_bud'];


			$sql1 = "insert into temp_sp2d (no_sp2d,tgl_sp2d,no_spm,tgl_spm,no_spp,tgl_spp,no_kas,kd_skpd,keperluan,jns_spp,kd_kegiatan,kd_rek5,nilai,tgl_kas_bud)
					values('$no_sp2d','$tgl_sp2d','$no_spm','$tgl_spm','$no_spp','$tgl_spp','$no_kas','$kd_skpd','$keperluan','$jns_spp','$kd_kegiatan','$kd_rek5','$nilai','$tgl_kas_bud') ";
			$asg1 = $this->db_keu->query($sql1);

		}

		$sql = $this->db->query("Delete From sp2d_import");

		$rec   = count($query->result_array());
		$data=array("jumlah"=>$rec);
		echo json_encode($data);
		$query->free_result();
	}

	function proses_transfer(){
		$this->load->model('koneksi');

		ini_set("memory_limit", "-1");
		ini_set('max_execution_time',0);
		

		$bulan = $this->input->post('bulan');
		$baris =$this->input->post('baris');
		//$baris =15;
		
	    $where='';
	    $sp2d ='';
		$kd_skpd = $this->session->userdata('kdskpd');
		$where = "where kd_skpd = '$kd_skpd' and MONTH(tgl_kas_bud)<='$bulan' ";
		$sql = "SELECT * from temp_sp2d $where order by no_sp2d limit $baris,1";

		/*$where = "where a.kd_skpd='$kd_skpd'  AND a.status_bud='1' ";	
		
		$sql =$this->db_keu->query("SELECT a.no_sp2d,a.tgl_sp2d,a.no_spm,a.tgl_spm,a.no_spp,a.tgl_spp,a.no_kas,a.kd_skpd,a.keperluan,
a.jns_spp FROM trhsp2d a $where order by a.no_sp2d limit $baris,1");*/

        $query1 = $this->db_keu->query($sql);  
		   foreach($query1->result_array() as $res){

				$no_sp2d     = $res['no_sp2d'];
				$tgl_sp2d    = $res['tgl_sp2d'];
				$no_spm      = $res['no_spm'];
				$tgl_spm     = $res['tgl_spm'];
				$no_spp      = $res['no_spp'];
				$tgl_spp     = $res['tgl_spp'];
				$no_kas      = $res['no_kas'];
				$kd_skpd     = $res['kd_skpd'];
				$keperluan   = $res['keperluan'];
				$jns_spp     = $res['jns_spp'];
				$kd_kegiatan = $res['kd_kegiatan'];
				$kd_rek5     = $res['kd_rek5'];
				$nilai       = $res['nilai'];
				$tgl_kas_bud = $res['tgl_kas_bud'];

				$baris=$baris+1;

				

				$sql1 = "insert into sp2d_import (no_sp2d,tgl_sp2d,no_spm,tgl_spm,no_spp,tgl_spp,no_kas,kd_skpd,keperluan,jns_spp,kd_kegiatan,kd_rek5,nilai,tgl_kas_bud)
				values('$no_sp2d','$tgl_sp2d','$no_spm','$tgl_spm','$no_spp','$tgl_spp','$no_kas','$kd_skpd','$keperluan','$jns_spp','$kd_kegiatan','$kd_rek5','$nilai','$tgl_kas_bud') ";

				$asg1 = $this->db->query($sql1);
				if($asg1){
							$isi  ='Insert ['.$baris.']'.'.'.$this->titik($no_sp2d.'||'.$kd_rek5.'||'.$nilai).'=>['.$keperluan.']';
							$datx=array("isi"=>$isi,"baris"=>($baris),"pesan"=>'0','1');
							echo json_encode($datx);
					 
				}else{
					$isi  ='Gagal Insert ['.$baris.']'.'.'.$this->titik($no_sp2d.'||'.$kd_rek5.'||'.$nilai).'=>['.$keperluan.']';
					$datx=array("isi"=>$isi,"baris"=>($baris),"pesan"=>'1','0');
					echo json_encode($datx); 
				}
				
				
			}

	}

	 function titik($str){
        $panjang=50;
        if($panjang>=strlen($str)){
            $selisih=$panjang-strlen($str);
            for($i=1;$i<=$selisih;$i++){
                $str .='.';
            }
            $hasil=$str;
        }else{
            $hasil=substr($str,0,105);
        } 
        return $hasil;
    }
	
	function load_transfer() {
		$this->load->model('koneksi');
		$kd_skpd = $this->session->userdata('kdskpd');

		$result = array();
		$row = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$offset = ($page-1)*$rows;
		$kriteria = '';
		$kriteria = $this->input->post('cari');

        $where = "where kd_skpd = '$kd_skpd'";
		
        if ($kriteria <> ''){                               
            $where .=" and kd_skpd like'%$kriteria%' or no_spm like'%$kriteria%' or no_spp like'%$kriteria%')";            
        }

  		
		$sql = "SELECT count(*) as tot from temp_sp2d $where" ;
		$query1 = $this->db_keu->query($sql);
		$total = $query1->row();
		
		$sql = "SELECT * from temp_sp2d $where order by no_sp2d desc limit $offset,$rows";
		$query1 = $this->db_keu->query($sql);  
		$result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
						'no_spm' => $resulte['no_spm'],     
						'no_spp' => $resulte['no_spp'], 	
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd']                                                                                                
                        );
                        $ii++;
        }
        
		
		
        $result["total"] = $total->tot;
        $result["rows"] = $row; 

        echo json_encode($result);
    	   
	}



	function load_telah_transfer() {
		$this->load->model('koneksi');
		$kd_skpd = $this->session->userdata('kdskpd');

        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');

        $where = "where kd_skpd = '$kd_skpd' and st_ex='11'";
		
        if ($kriteria <> ''){                               
            $where .=" and (upper(nm_skpd) like upper('%$kriteria%') or kd_skpd like'%$kriteria%' or no_spm like'%$kriteria%' or no_spp like'%$kriteria%')";            
        }

        $sql = "SELECT count(*) as tot from trhspm $where" ;
        $query1 = $this->db_keu->query($sql);
        $total = $query1->row();
		     
        $sql = "SELECT * from trhspm $where order by tgl_spm desc limit $offset,$rows";
        $query1 = $this->db_keu->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
						'no_spm' => $resulte['no_spm'],     
						'no_spp' => $resulte['no_spp'], 	
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],                                                                                                
                        'st_ex' => $resulte['st_ex']                                                                                                
                        );
                        $ii++;
        }
        
		
		
        $result["total"] = $total->tot;
        $result["rows"] = $row; 

        echo json_encode($result);
    	   
	}

	private function f_project_root(){

		$array_url = explode('/',base_url());

		unset($array_url[0]);
		unset($array_url[1]);
		unset($array_url[2]);

		$ext = implode('/', $array_url);

		return $_SERVER['DOCUMENT_ROOT'].'/'.$ext;


	}


	function backup_data(){
		$this->load->model('koneksi');
					   
		$kodeskpd=$this->session->userdata('kdskpd');
		$sql="select nm_skpd from ms_skpd where kd_skpd='$kodeskpd'";
		$query=$this->db->query($sql);
		$hasil=$query->row();
		$namaskpd=$hasil->nm_skpd;
		
		$nm_skpd=substr($namaskpd,0,20);
	
		$array_no_spm = explode('|',$this->input->get('str_no_spm'));
		$array_no_spp = explode('|',$this->input->get('str_no_spp'));
		
		$tgl_update=  date('Y-m-d H:i:s');
		foreach($array_no_spm as $array_nospmm){
	//			$this->db->query("update trhspm set st_ex='11', tgl_ex='$tgl_update' where no_spm='$array_nospmm'");
		}
		// $nama_file	  =	'C:/BACKUP/SPM/SIADINDA_SPM'.'_'.$kodeskpd.'_'.date("DdMY").'_'.time().'_1.dny';


		// jika directory belum ada maka buat directory nya
		if(!file_exists($this->f_project_root().'import_sp2d_blud')){
			mkdir($this->f_project_root().'import_sp2d_blud', 0777);	
		}

		$nama_file = $this->f_project_root(). 'import_sp2d_blud/SIMBLUD'.'_'.$kodeskpd.'_'.date("DdMY").'_'.time().'_1.sql';	
		
		


		

	
		$return="";
		
		$return	.= "/*".$kodeskpd."*/\n";
		$return	.= "DROP TABLE IF EXISTS trhspmtemp;\n" ;
	
		$query_create_table=$this->db_keu->query("show create table trhspm");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		$return .= str_replace('trhspm','trhspmtemp',$field_create).";\n";
		
		
		foreach($array_no_spm as $array_no_spm){
			$this->db_keu->or_where('no_spm',$array_no_spm);
		}

		$sql = $this->db->query("Delete From trhspm");		 
		$query =$this->db_keu->get('trhspm');
		
		foreach($query->result() as $result){

			$query_column = $this->db_keu->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='simakda_siadinda_2016' AND table_name = 'trhspm'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
			
		
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
				$field_name .= $column->COLUMN_NAME. ",";
					
				$column_name = $column->COLUMN_NAME;			
				$values .= '"'.$result->$column_name.'",';
			}
			
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
		
			$return .= "INSERT INTO trhspmtemp ($field_name) VALUES ($values);\n";

			//$sql ="Insert Into trhspm ($field_name) VALUES ($values)";

			$sql = $this->db->query("Insert Into trhspm ($field_name) VALUES ($values)");  
				
			
		}
		
		
		
		
		// echo $return;
		$handle = fopen($nama_file,'w+');
		$write = fwrite($handle, $return);

		if($write != false){
			fclose($handle);
			echo 1;
		}else{
			echo 0;
		}
		
		       
	}
}
