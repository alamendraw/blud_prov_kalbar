<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Options extends CI_Controller{
	function DataMaster(){
		$Char		= $this->input->post('q');
		$Tabel		= $this->input->post('Tabel');
		$IdData		= $this->input->post('IdData');
		$Data1		= $this->input->post('Data1');
		$Data2		= $this->input->post('Data2');
		if($Data2 <> ""){$Or1 = "OR UPPER($Data2) LIKE UPPER('%$Char%')";}else{$Or1="";}
		$Data3		= $this->input->post('Data3');
		if($Data3 <> ""){$Or2 = "OR UPPER($Data3) LIKE UPPER('%$Char%')";}else{$Or2="";}
		$NotIn_		= $this->input->post('NotIn_');
		$In_		= $this->input->post('In_');
		$CodeQuery	= "	SELECT * FROM $Tabel WHERE (UPPER($Data1) LIKE UPPER('%$Char%') $Or1 $Or2 ) $NotIn_ $In_ ORDER BY $IdData";
        $RunCode	= $this->db->query($CodeQuery);
        $Result		= array();
        $ii			= 0;
		$RunCode->free_result();
        foreach($RunCode->result_array() as $Row){
			if($Data2 <> "" && $Data3 == ""){
				$Result[]	= array(
					'id'	=> $ii,
					$IdData => $Row[$IdData],
					$Data1	=> strtoupper($Row[$Data1]),
					$Data2	=> strtoupper($Row[$Data2])
				);
			}elseif($Data2 <> "" && $Data3 <> ""){
				$Result[]	= array(
					'id'	=> $ii,
					$IdData => $Row[$IdData],
					$Data1	=> strtoupper($Row[$Data1]),
					$Data2	=> strtoupper($Row[$Data2]),
					$Data3	=> strtoupper($Row[$Data3])
				);
			}else{
				$Result[]	= array(
					'id'	=> $ii,
					$IdData => $Row[$IdData],
					$Data1	=> strtoupper($Row[$Data1])
				);
			}
			$ii++;
		}
		echo json_encode($Result);
	}
}