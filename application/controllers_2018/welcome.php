<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_login');
		$this->client_logon = $this->session->userdata('logged');
	}

	function index(){
		$this->template->set('title', 'SIMBLUD');
		if ($this->client_logon){
			$data['ingat']= 'Setelah selesai menggunakan, jangan lupa untuk "Logout".';
			$this->template->load('template','index/home',$data);
			}else{
			redirect('/welcome/login');
		}
	}

	public function login(){
		$data['logo']		= 'image/logo.png';
		$data['css_data']		= 'css/jr-login.css';
		$data['goverment_name']	= 'PEMERINTAH KOTA PONTIANAK';
		$data['app_name']		= 'SIMBLUD';
		$data['dec_app_name']	= 'SISTEM INFORMASI MANAJEMEN<br>BADAN LAYANAN UMUM DAERAH';
		$data['footer']			= '&#9742; Kontak konsultasi : 	<br>Copyright &copy; 2012 MSM Consultant';
		$this->template->set('title', 'FORM LOGIN - SIMBLUD');
		if($_POST){
			
			$user       = 	$this->m_login->validate($_POST['username'], $_POST['password'],$_POST['pcthang']);
			$bar        = 	$_POST['username'];
			$pass       = 	$_POST['password'];
			$last_login =	date('Y-m-d H:i:s');
			$jr         = '';
			$iduser     = $this->session->userdata('Display_name');
			$session_id = $this->session->userdata('session_id');
			$skpd       = $this->session->userdata ('kdskpd' );

			$your_username = '';
				$cing		=	"SELECT stat_login, RTRIM(UPPER('$bar')) AS your_username FROM [user_blud] WHERE user_name   = '$bar' AND type = '1'";
				$cek_bar	=	$this->db->query($cing);
				if($cek_bar->num_rows()>0){
					foreach ($cek_bar->result() as $row){
						$jr				= $row->stat_login;
						$your_username	= $row->your_username;
					}
				}
			if($user == TRUE && $jr == 0){
				$this->utility->set_log_activity($iduser,$session_id,$skpd,'Succes Login');
				$query = $this->db->query("UPDATE user_blud SET stat_login = '0',last_login = '$last_login' WHERE user_name = '$bar' AND type = '1'");
				redirect('welcome');

			}elseif($user == FALSE && $jr == 1){
				$data['error_message'] = '&#160;&#160;&#160;&#160;&#160;&#160;Nama pengguna : '.$your_username.' sudah login.';
				$this->template->load('template/login', 'index/login',$data);
				$this->utility->set_log_activity($iduser,$session_id,'-',$data['error_message']);

			}elseif($user == FALSE && $jr == 0){
				$data['error_message'] = '&#160;&#160;&#160;&#160;&#160;&#160;Nama pengguna / kata sandi anda salah.';
				$this->template->load('template/login', 'index/login',$data);
				$this->utility->set_log_activity($iduser,$session_id,'-',$data['error_message'].'['.$bar.']'.'|'.'['.$pass.']');

			}
		}else{
			$this->template->load('template/login','index/login',$data);

		}
	}

	public function logout(){
		$this->m_login->logout();
		redirect('/welcome/login?&data=doc-user/?is=destroy/confirm-status/?is=logout-accept');
	}

	public function ceklogin(){
		$user=$this->session->userdata('pcNama');
		if ($user==''){
			echo '1';
			$query = $this->db->query("UPDATE user_blud SET stat_login = '0' WHERE stat_login = '1' AND type = '1'");
		}else{
			echo '0';
		}
	}
}