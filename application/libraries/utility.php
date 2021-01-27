<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Utility{
   	var $CI = NULL;
   	function __construct()
   	{
      	$this->CI =& get_instance();
   	}
   	function set_log_activity($id,$sesion,$skpd,$error){
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom=ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac=substr($mycom,($pmac+36),17); // Get Physical Address
        
         if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
             $ip_addres = $_SERVER['HTTP_CLIENT_IP'];
         } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
             $ip_addres = $_SERVER['HTTP_X_FORWARDED_FOR'];
         } else {
             $ip_addres = $_SERVER['REMOTE_ADDR'];
         }
          $SERVER_SOFTWARE = $_SERVER['SERVER_SOFTWARE'];
          $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
          $PHP_SELF        = $_SERVER['PHP_SELF'];
          $lat             = ''; // latitude
          $long            = ''; // longitude
          $kota            = '';
        /* $getloc = json_decode(file_get_contents("http://ipinfo.io/"));
         $coordinates = explode(",", $getloc->loc); // -> '32,-72' becomes'32','-72'
         $lat = $coordinates[0]; // latitude
         $long =$coordinates[1]; // longitude
         $kota = $getloc->city;*/

         $tgl = date('Y-m-d H:i:s');
   		$query = 'insert into activity_log_blud(user_name,skpd,tanggal,sesion_id,server_software,ip_address,mac_address,http_user_agent,php_self,pesan,get_location)values
         ("'.$id.'","'.$skpd.'","'.$tgl.'","'.$sesion.'","'.$SERVER_SOFTWARE.'","'.$ip_addres.'","'.$mac.'","'.$HTTP_USER_AGENT.'","'.$PHP_SELF.'","'.$error.'","'.$lat.'|'.$long.'|'.$kota.'")';
		    
          $this->CI->db->query($query);
		
   	}
}