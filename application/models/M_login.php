<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_login extends CI_Model {
	public function login($user_id,$otori,$pcthang,$Cuser,$Display_name,$Skpd,$Unit){
		$time = date("j F Y, H:i:s");
		$user =  array(
			'pcUser'		=> $user_id,
			'pcOtoriName'	=> $otori,
			'pcThang'		=> $pcthang,
			'pcNama'		=> $Cuser,
			'pcLoginTime'	=> $time,
			'Display_name'	=> $Display_name,
			'kdskpd'		=> $Skpd,
			'kdunit'		=> $Unit
			); 
		$CI =& get_instance();
		$CI->session->set_userdata('logged', $user_id);
		$CI->session->set_userdata($user);
	}

	public function logout(){
		
		date_default_timezone_set('Asia/Jakarta');
		$last_logout	=	date('Y-m-d H:i:s');
		$username		= 	$this->session->userdata('pcNama');
		$query			=	$this->db->query("UPDATE user_blud SET stat_login = '0',last_logout = '$last_logout' WHERE user_name = '$username' AND type = '1'");
		$CI 			=&	get_instance();
		$CI->session->sess_destroy();
	}

	public function validate($username,$password,$pcThang){
		//$query = $this->db->get_where('[user]', array('user_name' => $username));
		$tess = "SELECT * FROM [user_blud] WHERE user_name = '$username'";
		//echo $tess ;
		$query = $this->db->query($tess);
		$cek = $query->num_rows();
		if($cek != 0){
			foreach($query->result() as $row):
				$client['id_client'] = $row->id_user;
				$client['username'] = $row->user_name;
				$client['password'] = $row->password;
				$client['otori'] = $row->type;
				$client['display_name'] = $row->nama;
				$client['kd_skpd'] = $row->kd_skpd;
				$client['kd_unit'] = $row->kd_unit;
				$client['type'] = $row->type;
				$client['stat_login'] = $row->stat_login;
			endforeach;
			$passmd5	=	md5($password);
			if($passmd5 == $client['password'] and $client['type'] == '1' and ($client['stat_login'] == '0' or $client['stat_login'] == '1') ){
				$this->login($client['id_client'],$client['otori'],$pcThang,$client['username'],$client['display_name'],$client['kd_skpd'],$client['kd_unit'],$client['type']);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}