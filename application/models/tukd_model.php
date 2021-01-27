<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */

class Tukd_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function set_log_activity($pesan=''){
        $this->load->library('user_agent');
        $mac =$this->agent->platform();
       
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
          $iduser          = $this->session->userdata('Display_name');
          $session_id      = $this->session->userdata('session_id');
          $skpd            = $this->session->userdata ('kdskpd' );
          $tgl             = date('Y-m-d H:i:s');
          $query = 'insert into activity_log(user_name,skpd,tanggal,sesion_id,server_software,ip_address,mac_address,http_user_agent,php_self,pesan,get_location)values
         ("'.$iduser.'","'.$skpd.'","'.$tgl.'","'.$session_id.'","'.$SERVER_SOFTWARE.'","'.$ip_addres.'","'.$mac.'","'.$HTTP_USER_AGENT.'","'.$PHP_SELF.'","'.$pesan.'","'.$lat.'|'.$long.'|'.$kota.'")';
            
          $this->db->query($query);
        
    }
	
	// Tampilkan semua master data fungsi
	//function getAll($limit, $offset)
    function get_kode($kode,$hasil,$tabel,$field)
        {
            $this->db->select($hasil);
            $this->db->where($field, $kode);
            $q = $this->db->get($tabel);
            $data  = $q->result_array();
            $baris = $q->num_rows();
            return $data[0][$hasil];
        }
        
        
    function getAll($tabel,$field1,$limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		$this->db->limit($limit,$offset);
		return $this->db->get();
	}
    function getcari($tabel,$field,$field1,$limit, $offset,$lccari)
	{
		$this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field, $lccari);  
        $this->db->or_like($field1, $lccari);      
		$this->db->order_by($field, 'asc');
        $this->db->limit($limit,$offset);
		return $this->db->get();
	}
    
    function getAllc($tabel,$field1)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
	// Total jumlah data
	function get_count($tabel)
	{
		return $this->db->get($tabel)->num_rows();
	} 
    
	function get_count_cari($tabel,$field1,$field2,$data)
	{
        $this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field1, $data);  
        $this->db->or_like($field2, $data);      
		$this->db->order_by($field1, 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
    function get_count_teang($tabel,$field,$field1,$lccari)
	{
        $this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field, $lccari);  
        $this->db->or_like($field1, $lccari);      
		$this->db->order_by($field, 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
	// Ambil by ID
	function get_by_id($tabel,$field1,$id)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($field1, $id);
		return $this->db->get();
	}
	//cari
    function cari($tabel,$field1,$field2,$limit, $offset,$data)
	{
		$this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field2, $data);  
        $this->db->or_like($field1, $data);      
		$this->db->order_by($field1, 'asc');
		return $this->db->get();
	}
	// Simpan data
	function save($tabel,$data)
	{
		$this->db->insert($tabel, $data);
	}
	
	// Update data
	function update($tabel,$field1,$id, $data)
	{
		$this->db->where($field1, $id);
		$this->db->update($tabel, $data); 	
	}
	
	// Hapus data
	function delete($tabel,$field1,$id)
	{
		$this->db->where($field1, $id);
		$this->db->delete($tabel);
	}
    
     function depan($number)
	{
		$number = abs($number);
		$nomor_depan = array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");
		$depans = "";
		
		if($number<12){
			$depans = " ".$nomor_depan[$number];
		}
		else if($number<20){
			$depans = $this->depan($number-10)." belas";
		}
		else if($number<100){
			$depans = $this->depan($number/10)." puluh ".$this->depan(fmod($number,10));
		}
		else if($number<200){
			$depans = "seratus ".$this->depan($number-100);
		}
		else if($number<1000){
			$depans = $this->depan($number/100)." ratus ".$this->depan(fmod($number,100));
		//$depans = $this->depan($number/100)." Ratus ".$this->depan($number%100);
		}
		else if($number<2000){
			$depans = "seribu ".$this->depan($number-1000);
		}
		else if($number<1000000){
			$depans = $this->depan($number/1000)." ribu ".$this->depan(fmod($number,1000));
		}
		else if($number<1000000000){
			$depans = $this->depan($number/1000000)." juta ".$this->depan(fmod($number,1000000));
		}
		else if($number<1000000000000){
			$depans = $this->depan($number/1000000000)." milyar ".$this->depan(fmod($number,1000000000));
			//$depans = ($number/1000000000)." Milyar ".(fmod($number,1000000000))."------".$number;

		}
		else if($number<1000000000000000){
			$depans = $this->depan($number/1000000000000)." triliun ".$this->depan(fmod($number,1000000000000));
			//$depans = ($number/1000000000)." Milyar ".(fmod($number,1000000000))."------".$number;

		}				
		else{
			$depans = "Undefined";
		}
		return $depans;
	}

	function belakang($number)
	{
		$number = abs($number);
		$number = stristr($number,".");
		$nomor_belakang = array("nol","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");

		$belakangs = "";
		$length = strlen($number);
		$i = 1;
		while($i<$length)
		{
			$get = substr($number,$i,1);
			$i++;
			$belakangs .= " ".$nomor_belakang[$get];
		}
		return $belakangs;
	}

	function terbilang($number)
	{
		if (!is_numeric($number))
		{
			return false;
		}
		if($number<0)
		{
			$hasil = "Minus ".trim($this->depan($number));
			$poin = trim($this->belakang($number));
		}
		else{
			$poin = trim($this->belakang($number));
			$hasil = trim($this->depan($number));
		}
		if($poin)
		{
			$hasil = $hasil." koma ".$poin." Rupiah";
		}
		else{
			$hasil = $hasil." Rupiah";
		}
		return $hasil;  
	}
	
     function _mpdf_custom($content = '', $mode='', $format ='Legal', $default_font_size = 0, $default_font='', $marginLeft=15, $marginRight=15, $marginTop=16, $marginBottom=16, $marginHeader=9, $marginFooter=9, $orientation=''){

        ini_set("memory_limit","-1");

        $this->load->library('mpdf');        
        $this->mpdf->defaultheaderfontsize = 6; /* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;   /* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1;     /* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6; /* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;   /* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 


        $this->mpdf->AddPage($orientation,'',$hal1,'1','off', $marginLeft, $marginRight, $marginTop, $marginBottom, $marginHeader, $marginFooter);
        // $this->mpdf->AddPage('L', '', '', '', '', $marginLeft, $marginRight, $marginTop, $marginBottom, $marginHeader, $marginFooter,'','','','',0,0,0,0,'',$format);
        // $this->mpdf->_setPageSize($format = 'Legal', $orientation = 'L');

        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($content);
        $this->mpdf->Output();

    }
    
    
    function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='',$tMargin='') {
      ini_set("memory_limit","-1");
        $this->load->library('mpdf');
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
		$this->mpdf->SetTopMargin = $tMargin;
        //$this->mpdf->SetHeader('SIMAKDA||');
        $jam = date("H:i:s");
        //$this->mpdf->SetFooter('Printed on @ {DATE j-m-Y H:i:s} |Simakda| Page {PAGENO} of {nb}');
        //$this->mpdf->SetFooter('Printed on Simkeu-BLUD @ {DATE j-m-Y H:i:s A} |Halaman {PAGENO} / {nb}| ');
        
        $this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,$tMargin);
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
               
    }
    

        
    function  tanggal_format_indonesia($tgl){
            
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

    }
    
	function  ambil_bulan($tgl){
        $tanggal  = explode('-',$tgl); 
        return  $tanggal[1];
    }
	
    function  tanggal_ind($tgl){
            
        $tanggal  = explode('-',$tgl); 
        $bulan  = $tanggal[1];
        $tahun  =  $tanggal[0];
        return  $tanggal[2].'-'.$bulan.'-'.$tahun;

    }
        
    function  getBulan($bln){
        switch  ($bln){
			case  1:
			return  "Januari";
			break;
			case  2:
			return  "Februari";
			break;
			case  3:
			return  "Maret";
			break;
			case  4:
			return  "April";
			break;
			case  5:
			return  "Mei";
			break;
			case  6:
			return  "Juni";
			break;
			case  7:
			return  "Juli";
			break;
			case  8:
			return  "Agustus";
			break;
			case  9:
			return  "September";
			break;
			case  10:
			return  "Oktober";
			break;
			case  11:
			return  "November";
			break;
			case  12:
			return  "Desember";
			break;
		}
    }
    
    function right($value, $count){
    return substr($value, ($count*-1));
    }

    function left($string, $count){
    return substr($string, 0, $count);
    }    
    
    function  dotrek($rek){
				$nrek=strlen($rek);
				switch ($nrek) {
                case 1:
				$rek = $this->left($rek,1);								
       			 break;
    			case 2:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1);								
       			 break;
    			case 3:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1);								
       			 break;
    			case 5:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);								
        		break;
    			case 7:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);								
        		break;
				case 11:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,3);								
        		break;
				case 12:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,3);								
        		break;
				case 13:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,3);								
        		break;
				case 14:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,3);								
        		break;
                case 29:
					$rek = $this->left($rek,21).'.'.substr($rek,23,1).'.'.substr($rek,24,1).'.'.substr($rek,25,1).'.'.substr($rek,26,2).'.'.substr($rek,28,2);								
        		break;
    			default:
				$rek = "";	
				}
				return $rek;
    }
    
    
  //wahyu tambah ----------------------------------------	
        function  rev_date($tgl){
			$t=explode("-",$tgl);
			$tanggal  =  $t[2];
			$bulan    =  $t[1];
			$tahun    =  $t[0];
			return  $tanggal.'-'.$bulan.'-'.$tahun;

        }

		function get_sclient($hasil,$tabel)
		{
			$this->db->select($hasil);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}

        function get_nama($kode='',$hasil='',$tabel='',$field='')
        {
            $this->db->select($hasil);
            $this->db->where($field, $kode);
            $q = $this->db->get($tabel);
			$data  = $q->result_array();
            $baris = $q->num_rows();
            return $data[0][$hasil];
        }

// -----------------------------------------------------
        
        
        function combo_beban($id='',$script=''){
        $cRet    = '';                        
        $cRet    = "<select name=\"$id\" id=\"$id\" $script >";
        $cRet   .= "<option value=''>Pilih Beban</option>";                 
        $cRet   .= "<option value='1'>UP</option>";                
        $cRet   .= "<option value='2'>GU</option>";                
        $cRet   .= "<option value='3'>TU</option>"; 
        $cRet   .= "<option value='4'>GAJI</option>"; 
        $cRet   .= "<option value='6'>Barang & Jasa</option>";                      
        $cRet   .= "</select>";        
        return $cRet;
    }
// -----------------------------------------------------	


}

/* End of file fungsi_model.php */
/* Location: ./application/models/fungsi_model.php */