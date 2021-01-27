<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Config extends CI_Controller{
	function data_skpd(){
		$skpd	= $this->session->userdata('kdskpd');
		$sql	= "SELECT kd_skpd, nm_skpd, alamat FROM ms_skpd WHERE kd_skpd='$skpd'";
		$query1 = $this->db->query($sql);
		$query1->free_result();  
		if($query1->num_rows()<1){
            $result = array(
				'kd_skpd' => 'false',
				'nm_skpd' => 'false'
			);
        }else{
			$ii = 0;
			foreach($query1->result_array() as $resulte){ 
				$result = array(
					'id'		=> $ii,
					'kd_skpd'	=> $resulte['kd_skpd'],
					'nm_skpd'	=> $resulte['nm_skpd'],
					'alamat'	=> $resulte['alamat']
				);
				$ii++;
			}
		}
		echo json_encode($result);
	}

	function data_unit(){
		$skpd	= $this->session->userdata('kdskpd');
		$unit	= $this->session->userdata('kdunit');
		$sql	= "SELECT kd_unit,nm_unit FROM ms_unit WHERE kd_unit='$unit' AND kd_skpd='$skpd'";
		$query1	= $this->db->query($sql);
		$query1->free_result();  
		if($query1->num_rows()<1){
            $result = array(
				'kd_unit' => 'false',
				'nm_unit' => 'false'
			);
        }else{
			$ii = 0;
			foreach($query1->result_array() as $resulte){ 
				$result = array(
					'id' => $ii,
					'kd_unit' => $resulte['kd_unit'],
					'nm_unit' => $resulte['nm_unit']
				);
				$ii++;
			}
		}
		echo json_encode($result); 
	}

	function confirm($status_link=''){
		$data['st_unit']	= $_REQUEST['c5da50ba575ec8281f54abe2fb80b117'];
		$data['link_view']	= $_REQUEST['4ad03dbb6c593238386098bb4af8af49'];
		$data['title_menu']	= $_REQUEST['217ab0ed1e3572c7b282c96cf07b6cd4'];
		$data['skpd']		= $_REQUEST['01b65414a7fcd5be9a79a85bc452ef46'];
		$data['nmskpd']		= $_REQUEST['1aa005a9c5a6faed9994872cc6383421'];
		$data['unit']		= $_REQUEST['93f4ef5a3470ffc2fe5e1aea1e6c93dc'];
		$data['nmunit']		= $_REQUEST['8b36f6342584be8533d9b5f746d272d6'];
		$data['value_kds']	= $_REQUEST['9946687e5fa0dab5993ededddb398d2e'];
		$data['value_nms']	= $_REQUEST['f066ce9385512ee02afc6e14d627e9f2'];
		$data['value_kdu']	= $_REQUEST['039da699d091de4f1240ae50570abed9'];
		$data['value_nmu']	= $_REQUEST['b600fc6b6ea1955d114861c42934c659'];
		$data['value_menu']	= $_REQUEST['8afb7aa8a1a0dd7bd77ca8857bcc422d'];
		$data['value_link']	= $_REQUEST['1c649762b9a449f9844b2326339a592c'];
		$data['value_stu']	= $_REQUEST['368ad5d0aae0822e0369f9fa6fc3f12b'];
		$data['st_menu']	= $_REQUEST['4c499012962862e16a7ca99e5fb51b8d'];
		$title_tab = '';
		if($status_link <> 'accept' || $data['st_unit'] <> $data['value_stu'] || $data['link_view'] <> $data['value_link'] || $data['skpd'] <> $data['value_kds'] || $data['nmskpd'] <> $data['value_nms'] || $data['unit'] <> $data['value_kdu'] || $data['nmunit'] <> $data['value_nmu'] || $data['title_menu'] <> $data['value_menu'] ){
			redirect('/welcome/logout');
		}
		if($data['unit'] == 'false'){
			$title_tab = ''.strtoupper($data['title_menu'].' * '.$data['skpd'].' - '.$data['nmskpd']).'';
		}else{
			$title_tab = ''.strtoupper($data['title_menu'].' * '.$data['unit'].' - '.$data['nmunit']).'';
		}
		$data['judul_menu']	= $title_tab;
		if($status_link == 'accept' && $data['st_unit'] == $data['value_stu'] && $data['link_view'] == $data['value_link'] && $data['skpd'] == $data['value_kds'] && $data['nmskpd'] == $data['value_nms'] && $data['unit'] == $data['value_kdu'] && $data['nmunit'] == $data['value_nmu'] && $data['title_menu'] == $data['value_menu'] ){
			$this->template->set('title', "$title_tab");
			$this->template->load('template',''.$data['link_view'].'',$data);
		}
	}

	function no_jr(){
		$tabel		= $this->input->post('tabel');
		$field_id	= $this->input->post('field_id');
		$where_		= $this->input->post('where_');
		$where_tbl	= $this->input->post('where_tbl');
		$st_numb	= $this->input->post('st_numb');
		$jns		= $this->input->post('jns');
		$id_1		= "";
		$id_2		= "";
		$filter		= "";
		
		if($jns == "UP/GU/TU"){
			$filter	= "AND jns_spp IN('1','2','3')";
		}
		if($jns == "LSBTL"){
			$filter	= "AND jns_spp IN('7')";
		}
		
		$sql1		= "SELECT number AS id_1 FROM ms_number $where_ $st_numb ORDER BY number DESC LIMIT 1";
    	$query1		= $this->db->query($sql1);
		$query1->free_result();
		if($query1->num_rows()<1){
				$id_1 = '0000';
		}else{
			foreach ($query1->result() as $row){
				$id_1 = $row->id_1;
			}
		}

		$sql2		= "SELECT $field_id AS id_2 FROM $tabel $where_tbl $filter ORDER BY $field_id DESC LIMIT 1";
    	$query2		= $this->db->query($sql2);
		$query2->free_result();
		if($query2->num_rows()<1){
				$id_2 = '0000';
		}else{
			foreach ($query2->result() as $row){
				$id_2 = $row->id_2;
			}
		}
		$get_hasil	= $this->db->query("SELECT '$id_1' AS id_numb, '$id_2' AS id_tbl");
		$get_hasil->free_result();
		foreach($get_hasil->result_array() as $resulte){
			$result = array( 
				'id_numb'	=> $resulte['id_numb'],
				'id_tbl'	=> $resulte['id_tbl']
			);
        }
		echo json_encode($result);
	}

	function validate_id(){
        $tabel		= $this->input->post('tabel');
		$id_number	= $this->input->post('id_number');
		$id_tabel	= $this->input->post('id_tabel');
		$field_id	= $this->input->post('field_id');
		$and_		= $this->input->post('and_');
		$st_numb	= $this->input->post('st_numb');
		$st_cek		= $this->input->post('st_cek');
		
		if($st_cek == 'all'){
			$sql1		= "SELECT number FROM ms_number WHERE number='$id_number' $and_ $st_numb LIMIT 1";
			$query1		= $this->db->query($sql1);
			$query1->free_result();

			$sql2		= "SELECT $field_id FROM $tabel WHERE $field_id='$id_tabel' $and_ LIMIT 1";
			$query2		= $this->db->query($sql2);
			$query2->free_result();
			if($query1->num_rows()>0){
				echo '1';
			}elseif($query2->num_rows()>0){
				echo '2';
			}else{
				echo '0';
			}
		}
		if($st_cek == '1'){
			$sql1		= "SELECT number FROM ms_number WHERE number='$id_number' $and_ $st_numb LIMIT 1";
			$query1		= $this->db->query($sql1);
			$query1->free_result();
			if($query1->num_rows()>0){
				echo '1';
			}else{
				echo '0';
			}
		}
		
		if($st_cek == '2'){
			$sql2		= "SELECT $field_id FROM $tabel WHERE $field_id='$id_tabel' $and_ LIMIT 1";
			$query2		= $this->db->query($sql2);
			$query2->free_result();
			if($query2->num_rows()>0){
				echo '2';
			}else{
				echo '0';
			}
		}
       
    }

	function cek_status(){
		$query_cek	= $this->input->post('query_cek');
		$and_		= $this->input->post('and_');

		$sql1		= "$query_cek $and_ LIMIT 1";
		$query1		= $this->db->query($sql1);
		$query1->free_result();
		if($query1->num_rows()>0){
			$result = array('hasil' =>'TRUE');
		}else{
			$result = array('hasil' =>'FALSE');
		}
		echo json_encode($result);
	}

	function data_bulan(){
		$lccr	= $this->input->post('q');
        $sql	= "SELECT kd,nm FROM ms_bln WHERE (UPPER(kd) LIKE UPPER('%$lccr%') OR UPPER(nm) LIKE UPPER('%$lccr%')) ORDER BY kd";
        $query1 = $this->db->query($sql);
		$query1->free_result();
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){
           $result[] = array(
				'id' => $ii,
				'kd'	=> $resulte['kd'],
				'nm'	=> ' '.$resulte['kd'].'. '.$resulte['nm']
			);
		$ii++;
        }
        echo json_encode($result); 	   
	}

	function data_rek(){
		$lccr		= $this->input->post('q');
		$skpd		= $this->input->post('skpd');
		$unit		= str_replace("false","",$this->input->post('unit'));
		$sub		= $this->input->post('sub');
		$jns		= $this->input->post('jns');
		$val		= $this->input->post('xvalidate');
		$rek_data	= $this->input->post('rek_data');
		$and_not	= "";
		if($rek_data == "PENDAPATAN"){
			$sql	= "	SELECT kd_rek5,nm_rek5 FROM trdrka WHERE kd_skpd='$skpd' AND LEFT(kd_rek5,1) = '4'
						AND skpd = 'skpd' AND (UPPER(kd_rek5) LIKE UPPER('%$lccr%') OR UPPER(nm_rek5) 
						LIKE UPPER('%$lccr%')) ORDER BY kd_rek5";
		}elseif($rek_data == "PEMBIYAAN"){
			$sql	= "	SELECT kd_rek5,nm_rek5 FROM trdrka WHERE kd_skpd='$skpd' AND LEFT(kd_rek5,1) = '6'
						AND skpd = 'skpd' AND (UPPER(kd_rek5) LIKE UPPER('%$lccr%') OR UPPER(nm_rek5)
						LIKE UPPER('%$lccr%')) ORDER BY kd_rek5";
		}else{
			if($val <> ""){
			$and_not = "AND d.kd_rek5 NOT IN ('$val')";
			}
			if($jns == "3" or $jns == "7"){
				$fil = true;
			}else{
				$fil = false;
			}
			if($fil == true){
				$sql	= "	SELECT d.kd_rek5,d.nm_rek5 FROM trdspp d INNER JOIN trhsp2d h ON d.no_spp = h.no_spp WHERE d.kd_skpd='$skpd' AND d.kd_unit = '$unit' 
							AND h.jns_spp = '$jns' AND h.no_kas <> '' AND stat_tu_lsbend  = '0' $and_not
							AND (UPPER(d.kd_kegiatan) LIKE UPPER('%$lccr%') OR UPPER(d.nm_kegiatan) LIKE UPPER('%$lccr%'))
							GROUP BY d.kd_rek5 ORDER BY d.kd_rek5";
			}elseif($fil == false){
				$sql	= "	SELECT d.kd_rek5,d.nm_rek5 FROM trdrka d WHERE d.kd_skpd='$skpd' AND d.kd_unit = '$unit' $and_not
							AND d.kd_subkegiatan = '$sub' AND d.skpd = 'skpd' AND (UPPER(d.kd_rek5) LIKE UPPER('%$lccr%') OR UPPER(d.nm_rek5)
							LIKE UPPER('%$lccr%')) ORDER BY d.kd_rek5";
			}
		}
        $query1 = $this->db->query($sql);
        $result = array();
        $ii		= 0;
		$query1->free_result();
        foreach($query1->result_array() as $resulte){
			$result[] = array(
				'id' => $ii,
				'kd_rek5' => $resulte['kd_rek5'],
				'nm_rek5' => $resulte['nm_rek5']
			);
			$ii++;
		}
		echo json_encode($result);
	}

	function delete_data(){
		$id_numb		= $this->input->post('id_numb');
		$and_			= $this->input->post('and_');
		$st_numb		= $this->input->post('st_numb');
		$no_id			= $this->input->post('no_id');
		$id_data		= $this->input->post('id_data');
		$tabel_h		= $this->input->post('tabel_h');
		$tabel_d		= $this->input->post('tabel_d');
		$have_detail	= $this->input->post('have_detail');
		$jurnal			= $this->input->post('jurnal');
		$on_number		= $this->input->post('on_number');
        $msg = array();
		if($on_number == "true"){
			$sql = "DELETE FROM ms_number WHERE number = '$id_numb' $and_ $st_numb";
			$asg = $this->db->query($sql);
		}
		$sql = "DELETE FROM $tabel_h WHERE $id_data = '$no_id'";
        $asg = $this->db->query($sql);

		if($have_detail == 'true'){
			$sql = "DELETE FROM $tabel_d WHERE $id_data = '$no_id'";
			$asg = $this->db->query($sql);
		}
		if($jurnal == 'true'){
			$sql = "DELETE FROM trhju_pkd WHERE no_voucher='$no_id'";
			$asg = $this->db->query($sql);

			$sql = "DELETE FROM trdju_pkd WHERE no_voucher='$no_id'";
			$asg = $this->db->query($sql);
		}
		if(!($asg)){
              $msg = array('pesan'=>'0');
              echo json_encode($msg);
               exit();
		}else{
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
            exit();
        }
    }
}