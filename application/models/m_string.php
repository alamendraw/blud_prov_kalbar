<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_string extends CI_Model {
	function right_char($data, $count){
		return substr($data, ($count*-1));
	}

	function left_char($data, $count){
		return substr($data, 0, $count);
	}

	function rek_format($data){
		$get_length = strlen($data);
		switch ($get_length){
			case 1:
				$data = $this->left_char($data,1);								
			break;
			case 2:
				$data = $this->left_char($data,1).'.'.substr($data,1,1);								
			break;
			case 3:
				$data = $this->left_char($data,1).'.'.substr($data,1,1).'.'.substr($data,2,1);								
			break;
			case 5:
				$data = $this->left_char($data,1).'.'.substr($data,1,1).'.'.substr($data,2,1).'.'.substr($data,3,2);								
			break;
			case 7:
				$data = $this->left_char($data,1).'.'.substr($data,1,1).'.'.substr($data,2,1).'.'.substr($data,3,2).'.'.substr($data,5,2);								
			break;
		default:
			$data = "";	
		}
		return $data;
    }

	function month_name($data, $font_type){
		$values = "";
        switch ($data){
			case  1:
				$values = "Januari";
			break;
			case  2:
				$values = "Februari";
			break;
			case  3:
				$values = "Maret";
			break;
			case  4:
				$values = "April";
			break;
			case  5:
				$values = "Mei";
			break;
			case  6:
				$values = "Juni";
			break;
			case  7:
				$values = "Juli";
			break;
			case  8:
				$values = "Agustus";
			break;
			case  9:
				$values = "September";
			break;
			case  10:
				$values = "Oktober";
			break;
			case  11:
				$values = "November";
			break;
			case  12:
				$values = "Desember";
			break;
		}
		if($font_type == "BIG"){
			return strtoupper($values);
		}elseif($font_type == "SMALL"){
			return strtolower($values);
		}else{
			return $values;
		}
	}

	function get_data($field, $tabel, $where){
		$sql1 = "SELECT $field FROM $tabel $where LIMIT 1";
        $query1 = $this->db->query($sql1);
		$query1->free_result();
        foreach ($query1->result() as $row){
            $data = $row->$field;
        }
		return $data;
	}

	function date_format_text($data, $font_type){
		$date	= explode('-',$data); 
		$month  = $this->month_name($date[1], $font_type);
		$year  =  $date[0];
		return  $date[2].' '.$month.' '.$year;
	}

	function date_format_number($data, $char){
		$val	= explode("-",$data);
		$date	= $val[2];
		$month	= $val[1];
		$year	= $val[0];
		return  $date.$char.$month.$char.$year;
	}

	function MPDF_Version_2_0_3($HTMLCode='',$LeftMargin='',$RightMargin='',$PageOrientation='') {
		$this->load->library('mpdf');
		ini_set("memory_limit","-1");
		ini_set("max_execution_time","-1");
		$this->mpdf->defaultheaderfontsize = 6;
		$this->mpdf->defaultheaderfontstyle = BI;
		$this->mpdf->defaultheaderline = 1;
		$this->mpdf->defaultfooterfontsize = 6;
		$this->mpdf->defaultfooterfontstyle = BI;
		$this->mpdf->defaultfooterline = 1;
		$this->mpdf->SetLeftMargin = $LeftMargin;
		$this->mpdf->SetRightMargin = $RightMargin;
		$DateToday	= $this->m_string->date_format_text(date("Y-m-d"),"Normal");
		$TimeToday	= date('H:i:s');
		$this->mpdf->SetFooter('SIADINDA PEMKAB SLEMAN @ Tanggal : '.$DateToday.' - Pukul : '.$TimeToday.' WIB |Halaman {PAGENO} dari {nb}| ');
		$this->mpdf->AddPage($PageOrientation,'','','','',$LeftMargin,$RightMargin);
		$this->mpdf->writeHTML($HTMLCode);
		$this->mpdf->Output();
    }
}