<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */

class Tukd_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	// Tampilkan semua master data fungsi
	//function getAll($limit, $offset)
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
	
	/* function terbilang_get_valid($str,$from,$to,$min=1,$max=9){
		$val=false;
		$from=($from<0)?0:$from;
		for ($i=$from;$i<$to;$i++){
			if (((int) $str{$i}>=$min)&&((int) $str{$i}<=$max)) $val=true;
		}
		return $val;
	}
	
	function terbilang_get_str($i,$str,$len){
        	$numA=array("","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan");
        	$numB=array("","Se","Dua ","Tiga ","Empat ","Lima ","Enam ","Tujuh ","Delapan ","Sembilan ");
        	$numC=array("","Satu ","Dua ","Tiga ","Empat ","Lima ","Enam ","Tujuh ","Delapan ","Sembilan ");
        	$numD=array(0=>"puluh",1=>"belas",2=>"ratus",4=>"ribu", 7=>"juta", 10=>"milyar", 13=>"triliun");
        	$buf="";
        	$pos=$len-$i;
        	switch($pos){
        		case 1:
        				if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
        					$buf=$numA[(int) $str{$i}];
        			break;
        		case 2:	case 5: case 8: case 11: case 14:
        				if ((int) $str{$i}==1){
        					if ((int) $str{$i+1}==0)
        						$buf=($numB[(int) $str{$i}]).($numD[0]);
        					else
        						$buf=($numB[(int) $str{$i+1}]).($numD[1]);
        				}
        				else if ((int) $str{$i}>1){
        						$buf=($numB[(int) $str{$i}]).($numD[0]);
        				}				
        			break;
        		case 3: case 6: case 9: case 12: case 15:
        				if ((int) $str{$i}>0){
        						$buf=($numB[(int) $str{$i}]).($numD[2]);
        				}
        			break;
        		case 4: case 7: case 10: case 13:
        				if ($this->terbilang_get_valid($str,$i-2,$i)){
        					if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
        						$buf=$numC[(int) $str{$i}].($numD[$pos]);
        					else
        						$buf=$numD[$pos];
        				}
        				else if((int) $str{$i}>0){
        					if ($pos==4)
        						$buf=($numB[(int) $str{$i}]).($numD[$pos]);
        					else
        						$buf=($numC[(int) $str{$i}]).($numD[$pos]);
        				}
        			break;
        	}
        	return $buf;
        }
		
	function terbilang($nominal){
		$buf="";
		$str=$nominal."";
		$len=strlen($str);
		for ($i=0;$i<$len;$i++){
			$buf=trim($buf)." ".$this->terbilang_get_str($i,$str,$len);
		}
		return trim($buf);
	} */
//===     
    
    
    
    /* function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {
        
        ini_set("memory_limit","-1");
        $this->load->library('mpdf');
        
        $this->mpdf->defaultheaderfontsize = 6;
        $this->mpdf->defaultheaderfontstyle = BI;
        $this->mpdf->defaultheaderline = 1;

        $this->mpdf->defaultfooterfontsize = 6;
        $this->mpdf->defaultfooterfontstyle = BI;
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        //$this->mpdf->SetHeader('SIMAKDA||');
        $jam = date("H:i:s");
        //$this->mpdf->SetFooter('Printed on @ {DATE j-m-Y H:i:s} |Simakda| Page {PAGENO} of {nb}');
        $this->mpdf->SetFooter('Printed on SIADINDA | {DATE j-m-Y H:i:s} |Halaman {PAGENO} / {nb}| ');
        
        $this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin);
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
    } */

	function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {
        $this->load->library('mpdf');
		ini_set("memory_limit","-1");
		ini_set("max_execution_time","-1");
        $this->mpdf->defaultheaderfontsize = 6;
        $this->mpdf->defaultheaderfontstyle = BI;
        $this->mpdf->defaultheaderline = 1;
        $this->mpdf->defaultfooterfontsize = 6;
        $this->mpdf->defaultfooterfontstyle = BI;
        $this->mpdf->defaultfooterline = 1;
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        $jam = date("H:i:s");
        $this->mpdf->SetFooter('Printed on Simkeu-BLUD @ {DATE j-m-Y H:i:s} |Halaman {PAGENO} / {nb}| ');
        $this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin);
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);
        $this->mpdf->Output();
    }

        //function  tanggal_format_indonesia($tgl){
//        $tanggal  =  substr($tgl,8,2);
//        $bulan  = $this-> getBulan(substr($tgl,5,2));
//        $tahun  =  substr($tgl,0,4);
//        return  $tanggal.' '.$bulan.' '.$tahun;
//
//   }
//        }
        
    function  tanggal_format_indonesia($tgl){
            
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

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
                case 29:
					$rek = $this->left($rek,21).'.'.substr($rek,23,1).'.'.substr($rek,24,1).'.'.substr($rek,25,1).'.'.substr($rek,26,2).'.'.substr($rek,28,2);								
        		break;
    			default:
				$rek = "";	
				}
				return $rek;
    }
    
//Combo jns_tunai -AKBAR-

	function combo_pay($nm='',$call=''){
        $cRet    = '';                        
        $cRet    = "<select name=\"$nm\" id=\"$nm\" $call >";
        $cRet   .= "<option value=''>......</option>";    
        $cRet   .= "<option value='TUNAI'>TUNAI</option>";                
        $cRet   .= "<option value='BANK'>BANK</option>";                     
        $cRet   .= "</select>";        
        return $cRet;
    }
//______________________________________________________________________  

  
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

		function get_nama($kode,$hasil,$tabel,$field)
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}

		function get_kode($kode,$hasil,$tabel,$field)
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}
		
		
		
		//akbar
		
		function get_rek($kode,$hasil,$tabel,$field)//AKBAR ambil rek dgn model
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}
		
		function get_skpd($kode,$hasil,$tabel,$field)//AKBAR ambil skpd dgn model
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}
		
		function get_unt($kode,$hasil,$tabel,$field)//AKBAR ambil unit dgn model
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}
// -----------------------------------------------------
		function combo_kdttd($id='',$script=''){
		$cRet    = '';                        
		$cRet    = "<select id=\"$id\" $script >";
		$cRet   .= "<option value=''>Pilih</option>";                 
		$cRet   .= "<option value='PA'>Pengguna Anggaran</option>";                
		$cRet   .= "<option value='BK'>Bendahara Pengeluaran</option>"; 
		$cRet   .= "<option value='BKP'>Bendahara Pengeluaran Pembantu</option>"; 
		$cRet   .= "<option value='BP'>Bendahara Penerimaan</option>";
		$cRet   .= "<option value='PT'>PPATK</option>";
		$cRet   .= "</select>";        
		return $cRet;
    }
// -----------------------------------------------------
		function combo_beban($id='',$script=''){
		$cRet    = '';                        
		$cRet    = "<select name=\"$id\" id=\"$id\" $script >";
		$cRet   .= "<option value=''>Pilih Beban</option>";                 
		$cRet   .= "<option value='1'>UP/GU</option>";                
		$cRet   .= "<option value='3'>TU</option>"; 
		$cRet   .= "<option value='4'>GAJI</option>"; 
		$cRet   .= "<option value='6'>Barang & Jasa</option>";                      
		$cRet   .= "</select>";        
		return $cRet;
    }
// -----------------------------------------------------

		function combo_beban_up_tu($id='',$script=''){
		$cRet    = '';                        
		$cRet    = "<select name=\"$id\" id=\"$id\" $script >";
		$cRet   .= "<option value=''>Pilih Beban</option>";                 
		$cRet   .= "<option value='1'>UP/GU</option>";                
		$cRet   .= "<option value='3'>TU</option>";                      
		$cRet   .= "</select>";        
        return $cRet;
    }
// -----------------------------------------------------

	function terbilang($nominal){
		$cek_koma = $this->right($nominal,2);
		$nil_true = str_replace($this->right($nominal,3),"00",$nominal);
		$nil_false = $cek_koma;
		$terbil_bersih	= "";
		$terbil_koma	= "";
		$buf1			= "";
		$buf2			= "";
		$hasil			= "";
		
		$str=$nil_true.".";
		$len=strlen($str);
		
		$str_false=$nil_false."";
		$len_false=strlen($str_false);
		
		for ($i=0;$i<$len;$i++){
			$terbil_bersih=trim($buf1)." ".$this->terbilang_str_bersih($i,$str,$len);
			$buf1=$terbil_bersih;
		}
		for ($i=0;$i<$len_false;$i++){
			$terbil_koma=trim($buf2)." ".$this->terbilang_str_koma($i,$str_false,$len_false);
			$buf2=$terbil_koma;
		}
		if($this->left($cek_koma,1) == 0 && $this->right($cek_koma,1) == 0){
			$hasil = $buf1;
		}elseif($this->left($cek_koma,1) == 0 && $this->right($cek_koma,1) != 0){
			$hasil = $buf1." koma nol ".$buf2;
		}else{
			$hasil = $buf1." koma ".$buf2;
		}
		return trim($hasil);
	} 
	
	function terbilang_str_bersih($i,$str,$len){
		$numA=array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");
		$numB=array("","se","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
		$numC=array("","satu ","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
		$numD=array(0=>"puluh",1=>" belas",2=>"ratus",7=>"ribu", 10=>"juta", 13=>"milyar", 16=>"triliun");
		$buf="";
		$pos=$len-$i;
		switch($pos){
			case 1:
					if (!$this->terbilang_bersih_valid($str,$i-1,$i,1,1))
						$buf=$numA[(int) $str{$i}];
				break;
			case 2:	case 5: case 8: case 11: case 14:
					if ((int) $str{$i}==1){
						if ((int) $str{$i+1}==0)
							$buf=($numB[(int) $str{$i}]).($numD[0]);
						else
							$buf=($numB[(int) $str{$i+1}]).($numD[1]);
					}
					else if ((int) $str{$i}>1){
							$buf=($numB[(int) $str{$i}]).($numD[0]);
					}				
				break;
			case 3: case 6: case 9: case 12: case 15:
					if ((int) $str{$i}>0){
							$buf=($numB[(int) $str{$i}]).($numD[2]);
					}
				break;
			case 4: case 7: case 10: case 13:
					if ($this->terbilang_bersih_valid($str,$i-2,$i)){
						if (!$this->terbilang_bersih_valid($str,$i-1,$i,1,1))
							$buf=$numC[(int) $str{$i}].($numD[$pos]);
						else
							$buf=$numD[$pos];
					}
					else if((int) $str{$i}>0){
						if ($pos==4)
							$buf=($numB[(int) $str{$i}]).($numD[$pos]);
						else
							$buf=($numC[(int) $str{$i}]).($numD[$pos]);
					}
				break;
		}
		return $buf;
	}

	function right($value, $count){
    return substr($value, ($count*-1));
    }

    function left($string, $count){
    return substr($string, 0, $count);
    }    
	
	function terbilang_bersih_valid($str,$from,$to,$min=1,$max=9){
		$val=false;
		$from=($from<0)?0:$from;
		for ($i=$from;$i<$to;$i++){
			if (((int) $str{$i}>=$min)&&((int) $str{$i}<=$max)) $val=true;
		}
		return $val;
	}		
	
	function terbilang_str_koma($i,$str_false,$len_false){
		$numA=array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");
		$numB=array("","se","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
		$numC=array("","satu ","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
		$numD=array(0=>"puluh",1=>"belas",2=>"ratus",7=>"ribu", 10=>"juta", 13=>"milyar", 16=>"triliun");
		$buf="";
		$pos=$len_false-$i;
		switch($pos){
			case 1:
					if (!$this->terbilang_koma_valid($str_false,$i-1,$i,1,1))
						$buf=$numA[(int) $str_false{$i}];
				break;
			case 2:	case 5: case 8: case 11: case 14:
					if ((int) $str_false{$i}==1){
						if ((int) $str_false{$i+1}==0)
							$buf=($numB[(int) $str_false{$i}]).($numD[0]);
						else
							$buf=($numB[(int) $str_false{$i+1}]).($numD[1]);
					}
					else if ((int) $str_false{$i}>1){
							$buf=($numB[(int) $str_false{$i}]).($numD[0]);
					}				
				break;
			case 3: case 6: case 9: case 12: case 15:
					if ((int) $str_false{$i}>0){
							$buf=($numB[(int) $str_false{$i}]).($numD[2]);
					}
				break;
			case 4: case 7: case 10: case 13:
					if ($this->terbilang_koma_valid($str_false,$i-2,$i)){
						if (!$this->terbilang_koma_valid($str_false,$i-1,$i,1,1))
							$buf=$numC[(int) $str_false{$i}].($numD[$pos]);
						else
							$buf=$numD[$pos];
					}
					else if((int) $str_false{$i}>0){
						if ($pos==4)
							$buf=($numB[(int) $str_false{$i}]).($numD[$pos]);
						else
							$buf=($numC[(int) $str_false{$i}]).($numD[$pos]);
					}
				break;
		}
		return $buf;
	}
	
	function terbilang_koma_valid($str_false,$from,$to,$min=1,$max=9){
		$val=false;
		$from=($from<0)?0:$from;
		for ($i=$from;$i<$to;$i++){
			if (((int) $str_false{$i}>=$min)&&((int) $str_false{$i}<=$max)) $val=true;
		}
		return $val;
	}


}

/* End of file fungsi_model.php */
/* Location: ./application/models/fungsi_model.php */