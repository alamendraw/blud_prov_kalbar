<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mfungsi extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	public function  tanggal_format_indonesia($tgl){
        $tanggal  = explode('-',$tgl);
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

        }

    public function  tanggal_indonesia($tgl){
		
        $tanggal  =  substr($tgl,8,2);
        $bulan  = substr($tgl,5,2);
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.'-'.$bulan.'-'.$tahun;
	}
	
	public function hari($tgl){
		$day = date('D', strtotime($tgl));
		$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		);
		return $dayList[$day];
	}

    public function  getBulan($bln){
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
	
    public function  dotrek($rek){
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
		default:
		$rek = "";
		}
		return $rek;
    }


    function right($value, $count){
		return substr($value, ($count*-1));
    }

    function left($string, $count){
		return substr($string, 0, $count);
    }
	
	
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

	
	
	function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {

        ini_set("memory_limit","512M");
        $this->load->library('mpdf');

      
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1;
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
       
        $jam = date("H:i:s");
       
        $this->mpdf->SetFooter('Printed on SIMAKDA |Halaman {PAGENO} / {nb}| ');

        $this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin);

        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);
        $this->mpdf->Output();

    }
	
}
