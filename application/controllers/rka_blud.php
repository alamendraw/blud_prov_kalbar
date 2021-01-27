<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rka_blud extends CI_Controller {

    function __contruct() {
        parent::__construct();
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
				case 8:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);								
        		break;
				case 13:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2).'.'.substr($rek,7,2).'.'.substr($rek,9,3);								
        		break;
    			default:
				$rek = "";	
				}
				return $rek;
    }
	

    
	
	 function tambah_rka() {
        $jk = $this->rka_model->combo_skpd();
        $ry = $this->rka_model->combo_giat();
        $cRet = '';

        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >
                   <tr >                       
                        <td>$jk</td>
                        <td>$ry</td>
                        </tr>
                  ";

        $cRet .="</table>";
        $data['prev'] = $cRet;
        $data['page_title'] = 'INPUT RENCANA BISNIS ANGGARAN';
        $this->template->set('title', 'INPUT RBA');
        $sql = "select a.kd_rek5,a.nm_rek5,a.nilai,a.nilai as total from trdrka_blud a ";

        $query1 = $this->db->query($sql);
        $results = array();
        $i = 1;
        foreach ($query1->result_array() as $resulte) {
            $results[] = array(
                'id' => $i,
                'kd_rek5' => $resulte['kd_rek5'],
                'nm_rek5' => $resulte['nm_rek5'],
                'nilai' => $resulte['nilai'],
                'total' => $resulte['total']
            );
            $i++;
        }
        $this->template->load('template', 'anggaran/rka/tambah_rka', $data);
        $query1->free_result();
    }
	
	    function tanggal_format_indonesia($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = $this->getBulan(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
	
	
	  function getBulan($bln) {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
	 function config_skpd() {
        $skpd = $this->session->userdata('kdskpd');
        $sql = "SELECT a.kd_skpd,a.nm_skpd,b.statu,b.status_ubah FROM  ms_skpd_blud a LEFT JOIN trhrka_blud b ON a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd'";
        $query1 = $this->db->query($sql);

        $test = $query1->num_rows();

        $ii = 0;
        foreach ($query1->result_array() as $resulte) {
            $result = array(
                'id' => $ii,
                'kd_skpd' => $resulte['kd_skpd'],
                'nm_skpd' => $resulte['nm_skpd'],
                'statu' => $resulte['statu'],
                'status_ubah' => $resulte['status_ubah']
            );
            $ii++;
        }
        echo json_encode($result);
        $query1->free_result();
    }
	
	function pgiat($cskpd='') {
        
        $lccr = $this->input->post('q');
        $sql  = " SELECT a.kd_kegiatan,a.nm_kegiatan,a.jns_kegiatan FROM trskpd_blud a 
                 where a.kd_skpd='$cskpd' and ( upper(a.kd_kegiatan) like upper('%$lccr%') or upper(a.nm_kegiatan) like upper('%$lccr%') ) ";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan'  => $resulte['kd_kegiatan'],  
                        'nm_kegiatan'  => $resulte['nm_kegiatan'],
                        'jns_kegiatan' => $resulte['jns_kegiatan']
                        );
                        $ii++;
        }
        echo json_encode($result);
           
    }

    function ambil_rekening5_all_dika(){
    	//$dika = $this->input->post('dika');
    	$lccr    = $this->input->post('q');
		$notin   = $this->input->post('reknotin');
		$jnskegi = $this->input->post('jns_kegi');
		$sql="";
		if ( $notin <> ''){
			$where = " and kd_rek7 not in ($notin) ";
		} else {
			$where = " ";
		}
		
	
		if ( $jnskegi =='4' ) {
			$sql = "SELECT kd_rek7, nm_rek7 FROM ms_rek7_blud where ( left(kd_rek7,1)='4' )
					and (upper(kd_rek7) like upper('%$lccr%') or upper(nm_rek7) like upper('%$lccr%')) $where order by kd_rek7";
		}			
		
		 if ( $jnskegi=='51' ){
				$sql = "SELECT kd_rek7, nm_rek7 FROM ms_rek7_blud where ( left(kd_rek7,1)='5')
						and (upper(kd_rek7) like upper('%$lccr%') or upper(nm_rek7) like upper('%$lccr%'))  $where order by kd_rek7";
		  } 
		  
		  
			 if (  $jnskegi=='52' ){
				$sql = "SELECT kd_rek7, nm_rek7 FROM ms_rek7_blud where ( left(kd_rek7,1)='5')
						and (upper(kd_rek7) like upper('%$lccr%') or upper(nm_rek7) like upper('%$lccr%')) $where order by kd_rek7";
		  } 	  
			
			
	



		
		$query1 = $this->db->query($sql); 
		$result = array();
		$ii = 0;
		foreach($query1->result_array() as $resulte)
		{ 
			$result[] = array(
						'id' => $ii,        
						'kd_rek5' => $resulte['kd_rek7'],  
						'nm_rek5' => $resulte['nm_rek7']
						);
						$ii++;
		}
		echo json_encode($result);

    }
	
	function ambil_unit() {
        
        $lccr = $this->input->post('q');
        $sql  = " SELECT * from ms_unit_layanan
                 where ( upper(kd_unit) like upper('%$lccr%') or upper(nm_unit) like upper('%$lccr%') ) and level='2'";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_unit'  => $resulte['kd_unit'],  
                        'nm_unit'  => $resulte['nm_unit']
                        );
                        $ii++;
        }
        echo json_encode($result);
           
    }
	
	function select_rka($kegiatan='',$unit='') {

        $sql = "select a.kd_rek5,b.nm_rek5,a.nilai,a.nilai_ubah,a.sumber,a.sumber2,a.sumber3,a.sumber4 from trdrka_blud a inner join ms_rek5 b on a.kd_rek5=b.kd_rek5  where a.kd_kegiatan='$kegiatan' and a.kd_skpd='$unit' order by a.kd_rek5";                   
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        'nilai' => number_format($resulte['nilai'],"2",".",","),
                        'nilai_ubah' => number_format($resulte['nilai_ubah'],"2",".",","),                             
                        'sumber' => $resulte['sumber'],
                        'sumber2' => $resulte['sumber2'],
                        'sumber3' => $resulte['sumber3'],
                        'sumber4' => $resulte['sumber4']
                        );
                        $ii++;
        }
           
           echo json_encode($result);
            $query1->free_result();
    }
	
	function select_sdana($kdskpd='',$kegiatan='',$unit='',$kdrek='') {

        $sql = "SELECT a.*,(select nm_sdana from ms_dana_blud where kd_sdana=a.kd_sdana) as nm_sdana FROM detail_sdana_trdrka a WHERE a.kd_skpd='$kdskpd' AND a.kd_kegiatan='$kegiatan' AND a.kd_unit='$unit' AND a.kd_rek7='$kdrek'";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_sdana' => $resulte['kd_sdana'],  
                        'nm_sdana' => $resulte['nm_sdana'],  
                        'nilai' => number_format($resulte['nilai'],"2",".",",")
                                                     
                        );
                        $ii++;
        }
           
           echo json_encode($result);
            $query1->free_result();
    }
	
	function ambil_rekening5() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek7, nm_rek7 FROM ms_rek7_blud where left(kd_rek7,1) in ('4','5','6') and (upper(kd_rek7) like upper('%$lccr%') or upper(nm_rek7) like upper('%$lccr%')) ";
        $query1 = $this->db->query($sql);
        $result = array();
        $ii = 0;
        foreach ($query1->result_array() as $resulte) {

            $result[] = array(
                'id' => $ii,
                'kd_rek5' => $resulte['kd_rek7'],
                'nm_rek5' => $resulte['nm_rek7']
            );
            $ii++;
        }

        echo json_encode($result);
    }

	function ambil_sdana(){
        $lccr  = $this->input->post('q');
        $query1 = $this->db->query("select kd_sdana, nm_sdana from ms_dana_blud") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_sdana' => $resulte['kd_sdana'],
            'nm_sdana' => $resulte['nm_sdana']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }
	
	function ambil_sdana2(){
        $lccr  = $this->input->post('q');
		 $notin  = $this->input->post('notins');
		 	if ( $notin <> ''){
			$where = "AND kd_sdana not in ($notin) ";
		} else {
			$where = " ";
		}
		
        $query1 = $this->db->query("SELECT kd_sdana, nm_sdana,jenis from ms_dana_blud where jenis = 'Pendapatan' $where") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_sdana' => $resulte['kd_sdana'],
            'nm_sdana' => $resulte['nm_sdana'],
            'jenis'    => $resulte['jenis']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }

    function ambil_sdana2_bel(){
        $lccr  = $this->input->post('q');
         $notin  = $this->input->post('notins');
            if ( $notin <> ''){
            $where = "AND kd_sdana not in ($notin) ";
        } else {
            $where = "";
        }
        
        $query1 = $this->db->query("SELECT kd_sdana, nm_sdana,jenis from ms_dana_blud where jenis = 'Belanja' $where") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_sdana' => $resulte['kd_sdana'],
            'nm_sdana' => $resulte['nm_sdana'],
            'jenis'    => $resulte['jenis']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }
	
	function ambil_layanan(){
        $lccr  = $this->input->post('q');
        $dika = $this->uri->segment(3);
        // $kd = substr($this->uri->segment(3),0,1);
        // $kd = $this->input->post('giat');
        // $kd = $_POST['giat'];
        // if($kd =='1.02.1.02.02.00.00.01'){
        //     $nama = 'Pendapatan';
        // }elseif($kd =='1.02.1.02.02.00.33.01'){
        //     $nama = 'Belanja';
        // }else{
        //     $nama = '';
        // }
        $query1 = $this->db->query("SELECT kd_layanan, nm_layanan,jenis from ms_layanan where level='1' and jenis = '".$dika."'") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_layanan' => $resulte['kd_layanan'],
            'nm_layanan' => $resulte['nm_layanan']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }

    function ambil_layanan_bel(){
        $lccr  = $this->input->post('q');
        $query1 = $this->db->query("SELECT kd_layanan, nm_layanan from ms_layanan where level='1' and jenis = 'Belanja'") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_layanan' => $resulte['kd_layanan'],
            'nm_layanan' => $resulte['nm_layanan']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }

    function ambil_layanan2(){
        $lccr  = $this->input->post('q');
        $kd = $this->uri->segment(3);
        $query1 = $this->db->query("select kd_layanan, nm_layanan from ms_layanan where level='2' and parent='".$kd."'") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_layanan' => $resulte['kd_layanan'],
            'nm_layanan' => $resulte['nm_layanan']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }
    
	function ambil_layanan3(){
        $lccr  = $this->input->post('q');
        $kd = $this->uri->segment(3);
        $query1 = $this->db->query("select kd_layanan, nm_layanan from ms_layanan where level='3' and parent='".$kd."'") ;
        $ii     = 0;
        $result = array();
        foreach ($query1->result_array() as $resulte) {
            $result[] = array(
            'id'       => '$ii',
            'kd_layanan' => $resulte['kd_layanan'],
            'nm_layanan' => $resulte['nm_layanan']
            );
            $ii++;    
        }
        echo json_encode($result) ;
        $query1->free_result();
    }
	
	function cek_kas() {

        $skpd = $this->input->post('skpd');
        $kegiatan = $this->input->post('kegiatan');

        $result = array();
        $query = $this->db->query("select * from trskpd_blud where kd_skpd='$skpd' and kd_kegiatan='$kegiatan'");
        
        $ii = 0;

        foreach ($query->result_array() as $row) {

            $result[] = array(
                'id' => '$ii',
                'bulan' => $row['bulan'],
                'nilai' => $row['nilai']
            );
            $ii++;
        }
        echo json_encode($result);
    }
	
	function tsimpan($skpd='',$kegiatan='',$rekbaru='',$reklama='',$nilai=0,$sdana='') {
       
        if (trim($reklama)==''){
            $reklama=$rekbaru;
        }

        $nmskpd=$this->rka_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $nmgiat=$this->rka_model->get_nama($kegiatan,'nm_kegiatan','trskpd_blud','kd_kegiatan');
        $nmrek5=$this->rka_model->get_nama($rekbaru,'nm_rek7','ms_rek7_blud','kd_rek7');

        $notrdrka=$skpd.'.'.$kegiatan.'.'.$rekbaru;
		
        $query = $this->db->query(" delete from trdrka_blud where kd_skpd='$skpd' and kd_kegiatan='$kegiatan' and kd_rek7='$reklama' ");
        $query = $this->db->query(" insert into trdrka_blud(no_trdrka,kd_skpd,kd_kegiatan,kd_rek7,nilai,nilai_ubah,sumber,nm_skpd,nm_rek7,nm_kegiatan) values('$notrdrka','$skpd','$kegiatan','$rekbaru',$nilai,$nilai,'$sdana','$nmskpd','$nmrek5','$nmgiat') ");   
        $query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ),TK_MAS=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ),TU_MAS='Dana' where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ");    
		
		
        $this->select_rka($kegiatan);
    }
	
	function ld_rek($giat='',$rek='') {
        if ($rek==''){
            $dan='';
        }else{
            $dan="and a.kd_rek7='$rek'";
        }
        $sql = " SELECT kd_rek7,nm_rek7 FROM (SELECT kd_rek7,nm_rek7 FROM ms_rek7_blud WHERE kd_rek7 NOT IN (SELECT kd_rek7 FROM trdrka_blud WHERE kd_kegiatan='$giat'  ) AND
                 (kd_rek7 LIKE '4%' OR kd_rek7 LIKE '5%' OR kd_rek7 LIKE '6%'))a,
                 (SELECT @kd:=b.jns_kegiatan, @pj:=LENGTH(b.jns_kegiatan) FROM trskpd_blud a INNER JOIN m_giat_blud b ON 
                 a.kd_kegiatan1=b.kd_kegiatan WHERE a.kd_kegiatan='$giat' )t 
                 WHERE LEFT(a.kd_rek7,@pj)=@kd $dan ORDER BY a.kd_rek7 ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek7'],  
                        'nm_rek5' => $resulte['nm_rek7']
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }
	
	function load_sum_rek_rinci_rka(){

		$kdskpd = $this->input->post('skpd');
		$kegiatan = $this->input->post('keg');
		$rek = $this->input->post('rek');
		$norka=$kdskpd.'.'.$kegiatan.'.'.$rek;
        $query1 = $this->db->query("SELECT nilai, nilai_ubah FROM trdrka_blud where no_trdrka='$norka' ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal_rka' => number_format($resulte['nilai'],"2",".",","),
                       // 'rektotal_rka_sempurna' => number_format($resulte['nilai_sempurna'],"2",".",","),
                        'rektotal_rka_ubah' => number_format($resulte['nilai_ubah'],"2",".",","),
						
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
		   
		 }

	function load_sum_rek_rinci_sempurna(){

		$kdskpd = $this->input->post('skpd');
		$kegiatan = $this->input->post('keg');
		$rek = $this->input->post('rek');
		$norka=$kdskpd.'.'.$kegiatan.'.'.$rek;

        $query1 = $this->db->query(" select sum(total_ubah) as rektotal_rinci from trdpo_blud where no_trdrka='$norka' ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal_rinci' => number_format($resulte['rektotal_rinci'],"2",".",","),  
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);	
	}
	
	function cek_nopo_sempurna($norka='',$cpo){
        $query_find = $this->db->query("select * from trdpo_blud where no_trdrka='$norka' and no_po='$cpo' and (total<>0)");
        $update = $query_find->num_rows();
        if($update < 1){
            $result = '0';
        }else{
            $result = '1';
        }
        echo json_encode($result);
    }	
	
	function tsimpan_rinci_jk_sempurna(){
        $norka     	= $this->input->post('no');
        $csql      	= $this->input->post('sql');
        $cskpd     	= $this->input->post('skpd');
        $kegiatan  	= $this->input->post('giat'); 
        $id        	= $this->session->userdata('pcNama');
        $sdana1 	= $this->input->post('dana1');
        $sdana2 	= $this->input->post('dana2');
        $sdana3 	= $this->input->post('dana3');
        $sdana4 	= $this->input->post('dana4');
        $rekening 	= $this->input->post('rekening');
		
        $sql       = "delete from trdpo_blud where  no_trdrka='$norka'";
		$asg       = $this->db->query($sql);
        	
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{
					//echo $csql;
					if($csql==' '){
					$asg='1';	
					}else{
                    $sql = "insert into trdpo_blud(no_po,header,kode,kd_rek5,no_trdrka,uraian,volume1,satuan1,harga1,total,volume_ubah1,satuan_ubah1,harga_ubah1,total_ubah,
                            volume2,satuan2,volume_ubah2,satuan_ubah2,volume3,satuan3,volume_ubah3,satuan_ubah3,tvolume,tvolume_ubah,volume_sempurna1,volume_sempurna2,
                            volume_sempurna3,tvolume_sempurna,satuan_sempurna1,satuan_sempurna2,satuan_sempurna3,harga_sempurna1,total_sempurna)"; 
					$asg = $this->db->query($sql.$csql);
					}
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                    }  else {
						$query1 = $this->db->query("update trdrka_blud set 
													nilai_ubah=(select sum(total_ubah) as nl from trdpo_blud where no_trdrka=trdrka_blud.no_trdrka)
													,username='$id',last_update=getdate()  where no_trdrka='$norka' ");  
						$query1 = $this->db->query("update trskpd_blud set total_ubah= (select sum(nilai_sempurna) as jum from trdrka_blud where kd_kegiatan='$kegiatan' and kd_skpd='$cskpd' ),
													username1='$id',last_update=getdate() where kd_kegiatan='$kegiatan' and kd_skpd='$cskpd' ");
						
						//$this->rka_rinci($cskpd,$kegiatan,$rekening);
							
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
    }

	
	function index($offset = 0, $lctabel, $field, $field1, $judul, $list, $lccari) {

    //$this->index('0','ms_skpd_blud','kd_skpd','nm_skpd','RKA 0','rka0','');
        $data['page_title'] = "CETAK $judul";

        //$total_rows = $this->master_model->get_count($lctabel);
        if (empty($lccari)) {
            $total_rows = $this->master_model->get_count($lctabel);
            $lc = "/.$lccari";
        } else {
            $total_rows = $this->master_model->get_count_teang($lctabel, $field, $field1, $lccari);
            $lc = "";
        }
        // pagination        

        $config['base_url'] = site_url("rka_blud/" . $list);
        $config['total_rows'] = $total_rows;
        $config['per_page'] = '10';
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $config['full_tag_open'] = '<ul class="page-navi">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $limit = $config['per_page'];
        $offset = $this->uri->segment(3);
        $offset = (!is_numeric($offset) || $offset < 1) ? 0 : $offset;

        if (empty($offset)) {
            $offset = 0;
        }

        if (empty($lccari)) {
            $kd_skpd = $this->session->userdata('kdskpd');
            $sqltpk = "SELECT * FROM ms_skpd_blud WHERE kd_skpd = '$kd_skpd'";
            $data['list'] = $this->db->query($sqltpk);

            //$data['list'] 		= $this->master_model->getAll($lctabel,$field,$limit, $offset);
        } else {
            $data['list'] = $this->master_model->getCari($lctabel, $field, $field1, $limit, $offset, $lccari);
        }
        $data['num'] = $offset;
        $data['total_rows'] = $total_rows;

        $this->pagination->initialize($config);
        $a = $judul;
        $data['sikap'] = 'list';
        $this->template->set('title', 'CETAK RBA');
        $this->template->load('template', "anggaran/rka/" . $list, $data);
    }
	
	 function thapus($skpd = '', $kegiatan = '', $rek = '',$unit='') {

        $notrdrka = $skpd.'.'.$kegiatan.'.'.$rek;
		$nogab = $skpd.'.'.$kegiatan;
		 $query = $this->db->query(" delete from trdrka_blud where kd_skpd='$skpd' and kd_kegiatan='$kegiatan' and kd_rek5='$rek'");
        $query = $this->db->query(" delete from trdpo_blud where no_trdrka='$notrdrka'");
        $query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ) where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ");
		
	   $this->select_rka($kegiatan);
    }
	
	 function tsimpan_rinci(){

        $skpd    = $this->input->post('skpd');
        $kegiatan    = $this->input->post('giat');
        $rekening    = $this->input->post('rek');
        $index    = $this->input->post('id');
        $uraian    = $this->input->post('uraian');
        $volume1    = $this->input->post('volum1');
        $satuan1    = $this->input->post('satuan1');
        $harga1    = $this->input->post('harga1');
        $volume2    = $this->input->post('volum2');
        $satuan2    = $this->input->post('satuan2');
        $volume3    = $this->input->post('volum3');
        $satuan3    = $this->input->post('satuan3');
        
        $satuan1 = str_replace("12345678987654321","",$satuan1);
        $satuan1 = str_replace("undefined","",$satuan1);

        $satuan2 = str_replace("12345678987654321","",$satuan2);
        $satuan2 = str_replace("undefined","",$satuan2);

        $satuan3 = str_replace("12345678987654321","",$satuan3);
        $satuan3 = str_replace("undefined","",$satuan3);

        $uraian = str_replace("%20"," ",$uraian);
        $uraian = str_replace("%60"," ",$uraian);

        $norka  = $skpd.'.'.$kegiatan.'.'.$rekening;
        $vol1=$volume1;
        $vol2=$volume2;
        $vol3=$volume3;
        if($volume1==0){$volume1=1;$vol1='';}
        if($volume2==0){$volume2=1;$vol2='';}
        if($volume3==0){$volume3=1;$vol3='';}
        
        $total   = $volume1*$volume2*$volume3*$harga1;

        $query1 = $this->db->query(" delete from trdpo_blud where no_po='$index' and no_trdrka='$norka' ");  
        $query1 = $this->db->query(" insert into trdpo_blud(no_po,no_trdrka,uraian,volume1,satuan1,harga1,total,volume_ubah1,satuan_ubah1,harga_ubah1,total_ubah,volume2,satuan2,volume_ubah2,satuan_ubah2,volume3,satuan3,volume_ubah3,satuan_ubah3) 
                                     values('$index','$norka','$uraian','$vol1','$satuan1',$harga1,$total,'$vol1','$satuan1',$harga1,$total,'$vol2','$satuan2','$vol2','$satuan2','$vol3','$satuan3','$vol3','$satuan3') ");  
        $query1 = $this->db->query(" update trdrka_blud set nilai= (select sum(total) as nl from trdpo_blud where no_trdrka=trdrka.no_trdrka),nilai_ubah=(select sum(total) as nl from trdpo_blud where no_trdrka=trdrka.no_trdrka) where no_trdrka='$norka' ");  
        $query1 = $this->db->query(" update trskpd_blud set total= (select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ) where kd_kegiatan='$kegiatan' and kd_skpd='$skpd' ");   
        $this->rka_rinci($skpd,$kegiatan,$rekening);
    }
	
	    function thapus_rinci_ar_all() {
        $norka = $this->input->post('vnorka');
        $query = $this->db->query("delete from trdpo_blud where no_trdrka='$norka' ");

        if ($query > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }
	
	function tsimpan_rinci_jk(){
        $norka     	= $this->input->post('no');
        $csql      	= $this->input->post('sql');
        $cskpd     	= $this->input->post('skpd');
        $kegiatan  	= $this->input->post('giat'); 
        $id        	= $this->session->userdata('pcNama');                       
        $sdana1 	= $this->input->post('dana1');
        $sdana2 	= $this->input->post('dana2');
        $sdana3 	= $this->input->post('dana3');
        $sdana4 	= $this->input->post('dana4');

                                 
		$sql       = "delete from trdpo_blud where  no_trdrka='$norka'";
		$asg       = $this->db->query($sql);
        	
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "insert into trdpo_blud(no_po,header,kode,kd_rek5,no_trdrka,uraian,volume1,satuan1,harga1,total,volume_ubah1,satuan_ubah1,harga_ubah1,total_ubah,
                            volume2,satuan2,volume_ubah2,satuan_ubah2,volume3,satuan3,volume_ubah3,satuan_ubah3,tvolume,tvolume_ubah,volume_sempurna1,volume_sempurna2,
                            volume_sempurna3,tvolume_sempurna,satuan_sempurna1,satuan_sempurna2,satuan_sempurna3,harga_sempurna1,total_sempurna)"; 
					//echo $sql ;
							//echo $csql ;
							
                    $asg = $this->db->query($sql.$csql);
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
	  /*
		$query1 = $this->db->query(" update trdrka set nilai= (select sum(total) as nl from trdpo where no_trdrka=trdrka.no_trdrka),
                                    nilai_sempurna= (select sum(total) as nl from trdpo where no_trdrka=trdrka.no_trdrka),
                                    nilai_ubah=(select sum(total) as nl from trdpo where no_trdrka=trdrka.no_trdrka),
									nilai_akhir_sempurna=(select sum(total) as nl from trdpo where no_trdrka=trdrka.no_trdrka)
									,username='$id',last_update=getdate(),
									sumber='$sdana1',sumber2='$sdana2',sumber3='$sdana3',sumber4='$sdana4',nilai_sumber='$ndana1',
									nilai_sumber2=$ndana2,nilai_sumber3=$ndana3,nilai_sumber4=$ndana4,		
									sumber1_su='$sdana1',sumber2_su='$sdana2',sumber3_su='$sdana3',sumber4_su='$sdana4',nsumber1_su=$ndana1,
									nsumber2_su=$ndana2,nsumber3_su=$ndana3,nsumber4_su=$ndana4,		
									sumber1_ubah='$sdana1',sumber2_ubah='$sdana2',sumber3_ubah='$sdana3',sumber4_ubah='$sdana4',nsumber1_ubah=$ndana1,
									nsumber2_ubah=$ndana2,nsumber3_ubah=$ndana3,nsumber4_ubah=$ndana4		
                                    where no_trdrka='$norka' ");  
		$query1 = $this->db->query("update trskpd_blud set total= (select sum(nilai) as jum from trdrka where kd_kegiatan='$kegiatan' and kd_skpd='$cskpd' ),
                                    total_sempurna= (select sum(nilai) as jum from trdrka where kd_kegiatan='$kegiatan' and kd_skpd='$cskpd' ), 
                                    total_ubah= (select sum(nilai) as jum from trdrka where kd_kegiatan='$kegiatan' and kd_skpd='$cskpd' ), 
                                    username='$id',last_update=getdate()
                                    where kd_kegiatan='$kegiatan' and kd_skpd='$cskpd' ");	
									*/
		//$this->rka_rinci($cskpd,$kegiatan,$rekening);
	
    }
	
	
	
	  function tsimpan_rinci_dn(){
        
        $norka     = $this->input->post('no');
        $csql      = $this->input->post('sql');
        $cskpd     = $this->input->post('skpd');
        $kegiatan  = $this->input->post('giat'); 
		 $total_po_dn  = $this->input->post('total_po_dn'); 
		  $kdrek  = $this->input->post('kdrek'); 
		  
		   $unit  = $this->input->post('units'); 
        
		$nogab=$cskpd.'.'.$kegiatan;
		
		$cek_dana=$this->db->query("select sum(nilai) as nilai from trdrka_blud where kd_skpd='$cskpd' and kd_kegiatan='$kegiatan' and kd_rek7='$kdrek' and kd_unit='$unit'");
		$data_cek=$cek_dana->row();
		$total_rek_unit=$data_cek->nilai;
		
		if($total_po_dn > $total_rek_unit){
		
			$msg = array('pesan'=>'2');
                    echo json_encode($msg);
                  
		}else{
		
		 
        $sql       = "delete from trdpo_blud where  no_trdrka='$norka' and kd_unit='$unit'";
        $asg       = $this->db->query($sql);
            
                           
                    $sql2 = "insert into trdpo_blud (no_po,no_trdrka,uraian,volume1,satuan1,harga1,total,volume_ubah1,satuan_ubah1,harga_ubah1,total_ubah,volume2,satuan2,volume_ubah2,satuan_ubah2,volume3,satuan3,volume_ubah3,satuan_ubah3,tvolume,tvolume_ubah,kd_unit)"; 
                  $asg1 = $this->db->query($sql2.$csql);
              

	   $msg = array('pesan'=>'1');
                       echo json_encode($msg);
					   
					   
		
	   
		}
		
		
	
    
    }
	
	function rka_rinci($skpd='',$kegiatan='',$rekening='') {
        
        $norka  = $skpd.'.'.$kegiatan.'.'.$rekening;
        $sql    = "select * from trdpo_blud where no_trdrka='$norka' order by no_po";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;

        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id'      => $ii,   
                        'header'  => $resulte['header'],  
                        'kode'    => $resulte['kode'],  
                        'no_po'   => $resulte['no_po'],  
                        'rek_blud'   => $resulte['kd_rek5'],  
                        'uraian'  => $resulte['uraian'],  
                        'volume1' => $resulte['volume1'],  
                        'volume2' => $resulte['volume2'],  
                        'volume3' => $resulte['volume3'],  
                        'satuan1' => $resulte['satuan1'],  
                        'satuan2' => $resulte['satuan2'],  
                        'satuan3' => $resulte['satuan3'],
                        'volume'  => $resulte['tvolume'],  
                        'harga1'  => number_format($resulte['harga1'],"2",".",","),  
                        'hargap'  => number_format($resulte['harga1'],"2",".",","),                             
                        'harga2'  => number_format($resulte['harga2'],"2",".",","),                             
                        'harga3'  => number_format($resulte['harga3'],"2",".",","),
                        'totalp'  => number_format($resulte['total'],"2",".",",") ,                            
                        'total'   => number_format($resulte['total'],"2",".",","),
                        'volume_sempurna1' => $resulte['volume_sempurna1'],
                        'tvolume_sempurna' => $resulte['tvolume_sempurna'],                            
                        'satuan_sempurna1' => $resulte['satuan_sempurna1'],
                        'harga_sempurna1'  => number_format($resulte['harga_sempurna1'],"2",".",","),
                        'total_sempurna'  => number_format($resulte['total_sempurna'],"2",".",","),
                        'volume_ubah1' => $resulte['volume_ubah1'],
                        'tvolume_ubah' => $resulte['tvolume_ubah'],                            
                        'satuan_ubah1' => $resulte['satuan_ubah1'],
                        'harga_ubah1'  => number_format($resulte['harga_ubah1'],"2",".",","),
                        'total_ubah'  => number_format($resulte['total_ubah'],"2",".",",")
                        );
                        $ii++;
        }
           
           echo json_encode($result);
    }

	function load_sum_rek(){

        $kdskpd = $this->input->post('skpd');
        $kegiatan = $this->input->post('keg');
		$unit = $this->input->post('units');

        $query1 = $this->db->query(" select sum(nilai) as rektotal,sum(nilai_ubah) as rektotal_ubah from trdrka_blud where kd_skpd='$kdskpd' and kd_kegiatan='$kegiatan' and kd_unit='$unit' ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal' => number_format($resulte['rektotal'],"2",".",","),  
                        'rektotal_ubah' => number_format($resulte['rektotal_ubah'],"2",".",",")  
                        );
                        $ii++;
        }
           
           //return $result;
           echo json_encode($result);   
    }
	
	 function load_sum_rek_rinci(){

        $kdskpd = $this->input->post('skpd');
        $kegiatan = $this->input->post('keg');
        $rek = $this->input->post('rek');
        $norka=$kdskpd.'.'.$kegiatan.'.'.$rek;

        $query1 = $this->db->query(" select sum(total) as rektotal_rinci,sum(total_ubah) as rektotal_rinci_ubah from trdpo_blud where no_trdrka='$norka' ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal_rinci' => number_format($resulte['rektotal_rinci'],"2",".",","),  
                        'rektotal_rinci_ubah' => number_format($resulte['rektotal_rinci_ubah'],"2",".",",")  
                        );
                        $ii++;
        }
           
           //return $result;
           echo json_encode($result);   
    }
	
	function simpan_sdana(){
        
        $kdskpd = $this->input->post('kd_skpd');
        $kdkegi = $this->input->post('kd_kegiatan');
        $kdrek  = $this->input->post('kd_rek5');
        $nilai  = $this->input->post('nilai');
        $unit = $this->input->post('unit');
        $kd_sdana = $this->input->post('kd_sdana');
		 $status = $this->input->post('status');
		  $vnilaisdana = $this->input->post('vnilaisdana');
		   $nilaiawal = $this->input->post('nilaiawal');
		 
		 
		 $nmskpd = $this->rka_model->get_nama($kdskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $nmkegi = $this->rka_model->get_nama($kdkegi,'nm_kegiatan','trskpd_blud','kd_kegiatan');
       
		
     
	 if($status == 'tambah'){
		   $cek=$this->db->query("select * from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' and kd_sdana='$kd_sdana'");      
		if($cek->num_rows() > 0){
			echo '0';
			return;
		}
		
		
		$query_ins = $this->db->query("insert into detail_sdana_trdrka (kd_skpd,kd_unit,kd_kegiatan,kd_rek7,nilai,kd_sdana) values('$kdskpd','$unit','$kdkegi','$kdrek','$nilai','$kd_sdana')");    
		$query_up = $this->db->query("update trdrka_blud set nilai=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ),nilai_ubah=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ) where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'");    
		$query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
			$q=$this->db->query("SELECT distinct no_trdrka,kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' and a.kd_rek7='$kdrek'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$no_trdrka=$dat->no_trdrka;
			$kd_rek13=$dat->kd_rek13;
			$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 
					WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q21 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai' where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			}else{
				
				$notrdrka2=substr($no_trdrka,0,32).'.'.$kd_rek13;
				$q21 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai')");    
			}
		}
		
		echo '1';
		 
	 }else if($status == 'edit'){
		  $gab=$kdskpd.'.'.$kdkegi.'.'.$kdrek;
		  
		    $cek_tot_sdana=$this->db->query("select sum(nilai) as total from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'")->row();
		  $cek_tot_sdana=$cek_tot_sdana->total;
		  
		  
		  
		  $selisih=$cek_tot_sdana+$nilai-$nilaiawal;
	
		  $cek_tot_po=$this->db->query("select sum(total) as total from trdpo_blud where no_trdrka='$gab' and kd_unit='$unit'")->row();
		  $cek_tot_po=$cek_tot_po->total; 
		  
		  
		   if($selisih < $cek_tot_po){
			 echo '3';
		 }else{
		 	 $query_edit = $this->db->query("update detail_sdana_trdrka set nilai='$nilai' where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' and kd_sdana='$kd_sdana'");    
		
		$query_up = $this->db->query("update trdrka_blud set nilai=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ),nilai_ubah=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ) where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'"); 	  
		$query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
			$q=$this->db->query("SELECT distinct no_trdrka,kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' and a.kd_rek7='$kdrek'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$no_trdrka=$dat->no_trdrka;
			$kd_rek13=$dat->kd_rek13;
			$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 
					WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q21 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai' where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			}else{
				
				$notrdrka2=substr($no_trdrka,0,32).'.'.$kd_rek13;
				$q21 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai')");    
			}
		} 
		
		echo '1';
			 
		 }
		 
		 
	 }else if($status == 'hapus'){
		 $gab=$kdskpd.'.'.$kdkegi.'.'.$kdrek;
		 
		  $cek_tot_sdana=$this->db->query("select sum(nilai) as total from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'")->row();
		 
		 $cek_tot_sdana=$cek_tot_sdana->total;
		  
		  $selisih=$cek_tot_sdana-$vnilaisdana;
		  
		  $cek_tot_po=$this->db->query("select sum(total) as total from trdpo_blud where no_trdrka='$gab' and kd_unit='$unit'")->row();
		  $cek_tot_po=$cek_tot_po->total;
		  
		  
		 if($selisih < $cek_tot_po){
			 echo '3';
		 }else{
		 
		
			 $query_edit = $this->db->query("delete from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' and kd_sdana='$kd_sdana'");    
		
		$query_up = $this->db->query("update trdrka_blud set nilai=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ),nilai_ubah=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ) where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'"); 
		$query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
			$q=$this->db->query("SELECT distinct no_trdrka,kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' and a.kd_rek7='$kdrek'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$no_trdrka=$dat->no_trdrka;
			$kd_rek13=$dat->kd_rek13;
			$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 
					WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q21 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai' where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			}else{
				
				$notrdrka2=substr($no_trdrka,0,32).'.'.$kd_rek13;
				$q21 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai')");    
			}
		}
		
		echo '2';
		 
		
	 }
	 }
      
     
        
    }
	
	function tsimpan_ar(){
        $kdskpd = $this->input->post('kd_skpd');
        $kdkegi = $this->input->post('kd_kegiatan');
        $kdrek  = $this->input->post('kd_rek5');
        $nilai  = $this->input->post('nilai');
        $sdana1 = $this->input->post('dana1');
        $sdana2 = $this->input->post('dana2');
        $sdana3 = $this->input->post('dana3');
        $sdana4 = $this->input->post('dana4');
		
		$unit = $this->input->post('unitss');
		$jasa = $this->input->post('jasabro');
        $nmskpd = $this->rka_model->get_nama($kdskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $nmkegi = $this->rka_model->get_nama($kdkegi,'nm_kegiatan','trskpd_blud','kd_kegiatan');
        $nmrek  = $this->rka_model->get_nama($kdrek,'nm_rek5','ms_rek5','kd_rek5');
		
        
        $notrdrka  = $kdskpd.'.'.$kdkegi.'.'.$kdrek ;
		$nogab=$kdskpd.'.'.$kdkegi;
			
        $query_del = $this->db->query("delete from trdrka_blud where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' and kd_unit='$unit' and kd_layanan='$jasa' and kd_rek5='$kdrek' ");
        $query_ins = $this->db->query("insert into trdrka_blud (no_trdrka,kd_skpd,nm_skpd,kd_unit,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah,sumber,sumber2,sumber3,sumber4,kd_layanan) values('$notrdrka','$kdskpd','$nmskpd','$unit','$kdkegi','$nmkegi','$kdrek','$nmrek','$nilai','$nilai','$sdana1','$sdana2','$sdana3','$sdana4','$jasa')");        
        $query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
		 /*
		 $q=$this->db->query("SELECT kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON RIGHT(a.no_trdrka,10)=b.kd_rek7 WHERE no_trdrka ='$notrdrka'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$kd_rek13=$dat->kd_rek13;
			//$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			$nmrek13  = '';
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON RIGHT(a.no_trdrka,10)=b.kd_rek7 
					WHERE LEFT(no_trdrka,32)='$nogab' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE LEFT(no_trdrka,32)='$nogab' AND RIGHT(no_trdrka,7)='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q2 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai' where LEFT(no_trdrka,32)='$nogab' AND RIGHT(no_trdrka,7)='$kd_rek13'");
			}else{
				
				$notrdrka2=$nogab.'.'.$kd_rek13;
				$q2 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah,sumber,sumber2,sumber3,sumber4) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai','$sdana1','$sdana2','$sdana3','$sdana4')");    
			}
		} 
		 */
        if ( $query_ins > 0 and $query_del > 0 ) {
            echo "1" ;
        } else {
            echo "0" ;
        }
        
    }
	
	function simpan_det_keg(){
        $skpd=$this->input->post('skpd');
        $giat=$this->input->post('giat');
        $lokasi=$this->input->post('lokasi');      
        $sasaran=$this->input->post('sasaran');      
        $wkeg=$this->input->post('wkeg');      
        $cp_tu=$this->input->post('cp_tu');      
        $cp_ck=$this->input->post('cp_ck');      
        $m_tu=$this->input->post('m_tu');      
        $m_ck=$this->input->post('m_ck');      
        $k_tu=$this->input->post('k_tu');      
        $k_ck=$this->input->post('k_ck');      
        $h_tu=$this->input->post('h_tu');      
        $h_ck=$this->input->post('h_ck');      
        $ttd=$this->input->post('ttd'); 
        $this->db->query(" update trskpd_blud set tu_capai='$cp_tu', 
							 tu_mas='$m_tu',            
							 tu_kel='$k_tu',            
							 tu_has='$h_tu',
							 tk_capai='$cp_ck',
							 tk_mas='$m_ck',
							 tk_kel='$k_ck',
							 tk_has='$h_ck',
							 lokasi='$lokasi',
							 sasaran_giat='$sasaran',
							 waktu_giat='$wkeg',
							 kd_pptk='$ttd',
							 tu_capai_ubah='$cp_tu', 
							 tu_mas_ubah='$m_tu',            
							 tu_kel_ubah='$k_tu',            
							 tu_has_ubah='$h_tu',
							 tk_capai_ubah='$cp_ck',
							 tk_mas_ubah='$m_ck',
							 tk_kel_ubah='$k_ck',
							 tk_has_ubah='$h_ck'
        where kd_skpd='$skpd' and kd_kegiatan='$giat'  "); 
    }
	
	function simpan_det_keg_sempurtna(){
        $skpd=$this->input->post('skpd');
        $giat=$this->input->post('giat');
        $lokasi=$this->input->post('lokasi');      
        $sasaran=$this->input->post('sasaran');      
        $wkeg=$this->input->post('wkeg');      
        $cp_tu=$this->input->post('cp_tu');      
        $cp_ck=$this->input->post('cp_ck');      
        $m_tu=$this->input->post('m_tu');      
        $m_ck=$this->input->post('m_ck');      
        $k_tu=$this->input->post('k_tu');      
        $k_ck=$this->input->post('k_ck');      
        $h_tu=$this->input->post('h_tu');      
        $h_ck=$this->input->post('h_ck');      
        $ttd=$this->input->post('ttd'); 
        $this->db->query(" update trskpd_blud 
							 lokasi='$lokasi',
							 sasaran_giat='$sasaran',
							 waktu_giat='$wkeg',
							 kd_pptk='$ttd',
							 tu_capai_ubah='$cp_tu', 
							 tu_mas_ubah='$m_tu',            
							 tu_kel_ubah='$k_tu',            
							 tu_has_ubah='$h_tu',
							 tk_capai_ubah='$cp_ck',
							 tk_mas_ubah='$m_ck',
							 tk_kel_ubah='$k_ck',
							 tk_has_ubah='$h_ck'
        where kd_skpd='$skpd' and kd_kegiatan='$giat'  "); 
    }
	
	function load_det_keg() {

        $kdskpd = $this->input->post('skpd');
        $kegiatan = $this->input->post('keg');
        
        $query1 = $this->db->query(" select *, (SELECT SUM(nilai) FROM trdrka_blud WHERE kd_skpd = '$kdskpd' AND kd_kegiatan = '$kegiatan') as total from trskpd_blud where kd_skpd='$kdskpd' and kd_kegiatan='$kegiatan'  ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                'id' => $ii,        
                'lokasi' => $resulte['lokasi'],  
                'sasaran' => $resulte['sasaran_giat'],  
                'wkeg' => $resulte['waktu_giat'],  
                'ttd' => $resulte['kd_pptk'],
                'cp_tu' => $resulte['tu_capai'],
                'm_tu' => $resulte['tu_mas'],
                'k_tu' => $resulte['tu_kel'],
                'h_tu' => $resulte['tu_has'],
                'cp_ck' => $resulte['tk_capai'],
                'm_ck' => 'Rp.'.number_format($resulte['total']),
                'k_ck' => $resulte['tk_kel'],
                'h_ck' => $resulte['tk_has'],
                //'total'=>$resulte['total'],
                //'sumber_dana_'=>$resulte['sumber_dana']
            );
            $ii++;
        }
        echo json_encode($result);
    }
	
	
	function load_det_keg_sempurna() {

        $kdskpd = $this->input->post('skpd');
        $kegiatan = $this->input->post('keg');
        
        $query1 = $this->db->query(" select *, (SELECT SUM(nilai) FROM trdrka_blud WHERE kd_skpd = '$kdskpd' AND kd_kegiatan = '$kegiatan') as total from trskpd_blud where kd_skpd='$kdskpd' and kd_kegiatan='$kegiatan'  ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                'id' => $ii,        
                'lokasi' => $resulte['lokasi'],  
                'sasaran' => $resulte['sasaran_giat'],  
                'wkeg' => $resulte['waktu_giat'],  
                'ttd' => $resulte['kd_pptk'],
                'cp_tu' => $resulte['tu_capai_ubah'],
                'm_tu' => $resulte['tu_mas_ubah'],
                'k_tu' => $resulte['tu_kel_ubah'],
                'h_tu' => $resulte['tu_has_ubah'],
                'cp_ck' => $resulte['tk_capai_ubah'],
                'm_ck' => 'Rp.'.number_format($resulte['total_ubah']),
                'k_ck' => $resulte['tk_kel_ubah'],
                'h_ck' => $resulte['tk_has_ubah'],
                //'total'=>$resulte['total'],
                //'sumber_dana_'=>$resulte['sumber_dana']
            );
            $ii++;
        }
        echo json_encode($result);
    }
	
	function rka_hukum($skpd='',$kegiatan='') {

        $sql = " SELECT *,(SELECT dhukum FROM d_hukum_blud WHERE kd_skpd='$skpd' AND kd_kegiatan='$kegiatan' AND dhukum=m_hukum_blud.kd_hukum_blud) AS ck FROM m_hukum_blud ";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_hukum_blud' => $resulte['kd_hukum_blud'],  
                        'nm_hukum_blud' => $resulte['nm_hukum_blud'],  
                        'ck'   => $resulte['ck']                          
                        );
                        $ii++;
        }
           
           echo json_encode($result);
    }
	
	 function simpan_dhukum(){

        $skpd  = $this->input->post('skpd');
        $giat  = $this->input->post('giat');
        $isi   = $this->input->post('cisi');      
        $pecah = explode('||',$isi);
        $pj    = count($pecah);

        $this->db->query(" delete from d_hukum_blud where kd_skpd='$skpd' and kd_kegiatan='$giat' ");        
    
        for($i=0;$i<$pj;$i++){
            if (trim($pecah[$i])!=''){
                $this->db->query(" insert into d_hukum_blud(kd_skpd,kd_kegiatan,dhukum) values('$skpd','$giat','".$pecah[$i]."') ");         
            }
        }
    }
	
	function ambil_rekening5_all_dn() {
		
		$lccr    = $this->input->post('q');
		$notin   = $this->input->post('reknotin');
		$jnskegi = $this->input->post('jns_kegi');
		$sql="";
		if ( $notin <> ''){
			$where = " and kd_rek5 not in ($notin) ";
		} else {
			$where = " ";
		}
		
	
		if ( $jnskegi =='4' ) {
			$sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where ( left(kd_rek5,1)='4' )
					and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) $where order by kd_rek5";
		}			
		
		 if ( $jnskegi=='51' ){
				$sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where ( left(kd_rek5,1)='5')
						and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%'))  $where order by kd_rek5";
		  } 
		  
		  
			 if (  $jnskegi=='52' ){
				$sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where ( left(kd_rek5,1)='5')
						and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) $where order by kd_rek5";
		  } 	  
			
			
	



		
		$query1 = $this->db->query($sql); 
		$result = array();
		$ii = 0;
		foreach($query1->result_array() as $resulte)
		{ 
			$result[] = array(
						'id' => $ii,        
						'kd_rek5' => $resulte['kd_rek5'],  
						'nm_rek5' => $resulte['nm_rek5']
						);
						$ii++;
		}
		echo json_encode($result);
	}
	
	function load_daftar_harga_detail_ck($norek='') {
	   
		$norek  = $this->input->post('rekening') ;

		$sql    = "SELECT *, kd_rek7 as ck from trdharga where kd_rek7 = '$norek' order by no_urut ";
		$query1 = $this->db->query($sql);  
		$result = array();
		$ii     = 0;
		foreach($query1->result_array() as $resulte)
		{ 
			$result[] = array(
						'id'         => $ii,        
						'no_urut'    => $resulte['no_urut'],
						'kd_rek5'    => $resulte['kd_rek7'],
						'uraian'     => $resulte['uraian'],
						'merk'       => $resulte['merk'],
						'satuan'     => $resulte['satuan'],
						//'harga'      => number_format($resulte['harga'],"2",".",","),
						'harga'      => $resulte['harga'],
						'keterangan' => $resulte['keterangan'],
						'ck'         => $resulte['ck']

						);
						$ii++;
		}
		echo json_encode($result);
	}
	
	function cetak(){
		$bro= 'adsfs';
		
		 $this->tukd_model->_mpdf ( '', $bro, 5, 5, 10, '0' );
	}
	
	
	   function rka0() {
        $this->index('0', 'ms_skpd_blud', 'kd_skpd', 'nm_skpd', 'RBA 0', 'rka0', '');
    }
	
	   function rka1() {
        $this->index('0', 'ms_skpd_blud', 'kd_skpd', 'nm_skpd', 'RBA 1', 'rka1', '');
    }
	
	 function rka21() {
        $this->index('0', 'ms_skpd_blud', 'kd_skpd', 'nm_skpd', 'RBA 2.1', 'rka21', '');
    }
	
	 function rka22() {
        $this->index('0', 'ms_skpd_blud', 'kd_skpd', 'nm_skpd', 'RBA 2.2', 'rka22', '');
    }

	 function preview_rka0() {
        $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
        }
		
		
		    $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
		
		
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }

       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"90 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"1\">
       
          <tr>
            <td colspan=\"2\"\ align=\"center\"><strong>Ringkasan Anggaran Pendapatan dan Biaya </strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr><td bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>No</b></td>                            
              <td bgcolor=\"#CCCCCC\" width=\"70%\" align=\"center\"><b>Uraian</b></td>
              <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Jumlah(Rp)</b></td></tr>
           </thead>
           
            <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"center\"><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"70%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>3</i></td></tr>
            ";
    
	
			$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\"><b>A.</b></td>                                     
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"70%\"><b>Pendapatan BLUD</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b></b></td></tr>";
			/*							 
			$q=$this->db->query("SELECT LEFT(kd_rek7,2) as no,nm_rek2 as uraian , SUM(nilai) as nilai FROM trdrka_blud a 
									LEFT JOIN ms_rek2 b ON LEFT(kd_rek7,2)=kd_rek2 WHERE LEFT(kd_rek7,1)='4' AND kd_skpd='$id'
									GROUP BY left(kd_rek7,2),nm_rek2
									order BY LEFT(kd_rek7,2) ");
									
			$q3=$this->db->query("SELECT SUM(nilai) as nilai FROM trdrka_blud a 
								LEFT JOIN ms_rek2 b ON LEFT(kd_rek7,2)=kd_rek2 WHERE LEFT(kd_rek7,1)='4' AND kd_skpd='$id'
								GROUP BY left(kd_rek7,2),nm_rek2")->row();
			*/
			$q=$this->db->query("select LEFT(b.kd_rek5,2) as kode, c.nm_rek2 uraian, SUM(total) nilai FROM trdrka_blud a INNER JOIN trdpo_blud b 
									ON a.no_trdrka=b.no_trdrka 
									LEFT JOIN ms_rek_blud2 c ON LEFT(b.kd_rek5,2)=c.kd_rek2
									WHERE a.kd_skpd='$id' AND LEFT(kd_rek5,1)='4'
									GROUP BY LEFT(b.kd_rek5,2), c.nm_rek2
									");
			$q3=$this->db->query("select  SUM(total) nilai FROM trdrka_blud a INNER JOIN trdpo_blud b 
									ON a.no_trdrka=b.no_trdrka 
									LEFT JOIN ms_rek_blud2 c ON LEFT(b.kd_rek5,2)=c.kd_rek2
									WHERE a.kd_skpd='$id' AND LEFT(kd_rek5,1)='4'")->row();

$jum_p=$q3->nilai;

$no=0;
foreach($q->result_array() as $data){
	$no++;
	$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\">$no</td>                                     
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"70%\">".$data['uraian']."</td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">".number_format($data['nilai'],'2','.',',')."</td></tr>";
}

	$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\"><b></b></td>                                     
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"70%\"><b>Jumlah</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>".number_format($jum_p,'2','.',',')."</b></td></tr>";
										 
			 $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\"><b>B.</b></td>                                     
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"70%\"><b>Biaya BLUD</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b></b></td></tr>";
		
	/*
										 
		$q1=$this->db->query("SELECT LEFT(kd_rek7,2) as no,nm_rek2 as uraian , SUM(nilai) as nilai FROM trdrka_blud a 
									LEFT JOIN ms_rek2 b ON LEFT(kd_rek7,2)=kd_rek2 WHERE LEFT(kd_rek7,1)='5' AND kd_skpd='$id'
									GROUP BY left(kd_rek7,2),nm_rek2
									order BY LEFT(kd_rek7,2) ");

		$q4=$this->db->query("SELECT SUM(nilai) as nilai FROM trdrka_blud a 
								LEFT JOIN ms_rek2 b ON LEFT(kd_rek7,2)=kd_rek2 WHERE LEFT(kd_rek7,1)='5' AND kd_skpd='$id'
								GROUP BY left(kd_rek7,2),nm_rek2")->row();
								*/
	$q1=$this->db->query("select LEFT(b.kd_rek5,2) as kode, c.nm_rek2 uraian, SUM(total) nilai FROM trdrka_blud a INNER JOIN trdpo_blud b 
									ON a.no_trdrka=b.no_trdrka 
									LEFT JOIN ms_rek_blud2 c ON LEFT(b.kd_rek5,3)=c.kd_rek2
									WHERE a.kd_skpd='$id' AND LEFT(kd_rek5,1)='5'
									GROUP BY LEFT(b.kd_rek5,2), c.nm_rek2");

	$q4=$this->db->query("select SUM(total) nilai FROM trdrka_blud a INNER JOIN trdpo_blud b 
									ON a.no_trdrka=b.no_trdrka 
									LEFT JOIN ms_rek_blud2 c ON LEFT(b.kd_rek5,3)=c.kd_rek2
									WHERE a.kd_skpd='$id' AND LEFT(kd_rek5,1)='5'
									")->row();

$jum_b=$q4->nilai;


$no=0;
foreach($q1->result_array() as $data1){
	$no++;
	$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\">$no</td>                                     
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"70%\">".$data1['uraian']."</td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">".number_format($data1['nilai'],'2','.',',')."</td></tr>";
}		

		$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"10%\" align=\"center\"><b></b></td>                                     
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"70%\"><b>Jumlah</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"20%\" align=\"right\"><b>".number_format($jum_b,'2','.',',')."</b></td></tr>";
		$cRet    .= "</table>";
		$namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"50%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"50%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
		  <b>Direktur Rumah Sakit Umum Daerah</b><br>
		  <b>$namaskpd</b>
		  <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
				$this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '0' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }
    //preview_rka1 dika
    function preview_rka1() {
        $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
            $thh_lalu=(1*$rowsc->thn_ang)-1;
        }
        
        
            $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
        
        
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }

       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"100 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD 1</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"1\">
       
          <tr>
            <td colspan=\"2\"\ align=\"center\"><strong>ANGGARAN PENDAPATAN BLUD BERDASARKAN SUMBER PENDAPATAN</strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>No</b></td>                            
              <td bgcolor=\"#CCCCCC\" width=\"30%\" align=\"center\"><b>Uraian</b></td>
               <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Proyeksi<br />TA $thh_lalu<br />(Rp)</b></td></tr>
                <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Target<br />Periode TA 2016<br />(Rp)</b></td></tr>
                 <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Prakiraan Maju (Forward Estimate)<br />(Rp)</b></td></tr>
              <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>Selisih<br />%</b></td></tr>
           </thead>
           
             <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"30%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>3</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>4</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>5</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>6=(4-3)/3</i></td></tr>            
           ";
    $q1     =$this->db->query("SELECT * FROM ms_layanan WHERE parent='0' and LEVEL = '1' AND jenis = 'Pendapatan' ORDER BY kd_layanan ASC ");
    $no     =0;
    $totbl1 =0;
    foreach($q1->result_array() as $data1){
        $no++;
        $kd_layanan = $data1['kd_layanan'];
        $q1a        = $this->db->query("SELECT SUM(a.nilai) AS nilai from (SELECT a.*,c.parent FROM trdrka_blud a 
                INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='4'
                ) a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();
        $q1b        = $this->db->query("SELECT SUM(a.nilai)*1.1 AS nilai from (SELECT a.*,c.parent FROM trdrka_blud a 
                INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='4'
                ) a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();
        $nil1a        = $q1a->nilai;
        $nil1b        = $q1b->nilai;
        $cRet.= "<tr>
                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"><b>".$no."</b></td>                                     
                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>".$data1['nm_layanan']."</b></td>
                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b></b></td></tr>
                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil1a,'2','.',',')."</b></td></tr>
                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil1b,'2','.',',')."</b></td></tr>
                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b></b></td>
                  </tr>";
        $totbl1a =$totbl1+$nil1a;
        $totbl1b =$totbl1+$nil1b;
        $q2=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan' and LEVEL = '2' AND jenis = 'Pendapatan' order by kd_layanan asc");
        $no2='Z';
        foreach($q2->result_array() as $data2){
                    $no2++;
                    $kd_layanan2=$data2['kd_layanan'];
                    $q2a        = $this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a
                            INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='4'
                            and c.parent='$kd_layanan2'")->row();
                    $q2b        = $this->db->query("SELECT SUM(a.nilai)*1.1 AS nilai FROM trdrka_blud a
                            INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='4'
                            and c.parent='$kd_layanan2'")->row();
                    $nil2a        = $q2a->nilai;
                    $nil2b        = $q2b->nilai;
            $cRet.= " <tr>
                <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;padding-left:18px;\" width=\"8%\" align=\"center\"><b>".substr($no2,1,1)."</b></td>                                     
                <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>".$data2['nm_layanan']."</b></td>
                <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b></b></td></tr>
                <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil2a,'2','.',',')."</b></td></tr>
                <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil2b,'2','.',',')."</b></td></tr>
                <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b></b></td>
                </tr>";
				$no3=0;
                 $q3=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan2' and LEVEL = '3' AND jenis = 'Pendapatan' order by kd_layanan asc");
                foreach($q3->result_array() as $data3){
                    $no3++;
                    $kd_layanan3=$data3['kd_layanan'];
                    $q3a        = $this->db->query("SELECT SUM(a.nilai) AS nilai FROM (SELECT a.*,c.parent FROM trdrka_blud a 
                        INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='4'
                        ) a INNER JOIN ms_layanan b ON a.parent=b.kd_layanan WHERE a.kd_layanan='$kd_layanan3'")->row();
                    $q3b        = $this->db->query("SELECT SUM(a.nilai)*1.1 AS nilai from (SELECT a.*,c.parent FROM trdrka_blud a 
                        INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='4'
                        ) a INNER JOIN ms_layanan b ON a.parent=b.kd_layanan WHERE a.kd_layanan='$kd_layanan3'")->row();
                    $nil3a        = $q3a->nilai;
                    $nil3b        = $q3b->nilai;
                    $cRet.= " <tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"></td>                                     
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">- ".$data3['nm_layanan']."</td>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"></td></tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">".number_format($nil3a,'2','.',',')."</td></tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">".number_format($nil3b,'2','.',',')."</td></tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                  </tr>";
                }
            }
    }
    $cRet    .= " <tr>                                 
                 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"53%\" colspan='2' align=\"center\"><b>TOTAL</b></td>
                 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"></td></tr>
                 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"><b>".number_format($totbl1a,'2','.',',')."</b></td></tr>
                 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"><b>".number_format($totbl1b,'2','.',',')."</b></td></tr>
                 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"5%\" align=\"right\"></td></tr>";
        $cRet    .= "</table>";
        $namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"50%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"50%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
          <b>Direktur Rumah Sakit Umum Daerah</b><br>
          <b>$namaskpd</b>
          <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
                $this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '0' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }

    //end preview_rka1 dika
    function preview_rka1_l() {
        $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
			$thh_lalu=(1*$rowsc->thn_ang)-1;
        }
		
		
		    $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
		
		
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }

       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"100 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD 1</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"1\">
       
          <tr>
            <td colspan=\"2\"\ align=\"center\"><strong>ANGGARAN PENDAPATAN BLUD BERDASARKAN SUMBER PENDAPATAN</strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>No</b></td>                            
              <td bgcolor=\"#CCCCCC\" width=\"30%\" align=\"center\"><b>Uraian</b></td>
			   <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Proyeksi<br />TA $thh_lalu<br />(Rp)</b></td></tr>
			    <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Target<br />Periode TA 2016<br />(Rp)</b></td></tr>
				 <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Prakiraan Maju (Forward Estimate)<br />(Rp)</b></td></tr>
              <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>Selisih<br />%</b></td></tr>
           </thead>
           
             <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"30%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>3</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>4</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>5</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>6=(4-3)/3</i></td></tr>            
		   ";
    
$q=$this->db->query("SELECT *,0 AS Nilai_Target, 0 AS Nilai_Maju, 0 AS Selisih FROM ms_layanan WHERE LEVEL = '1' AND jenis = 'Pendapatan' ORDER BY kd_layanan ASC");

$urut = 0;
foreach ($q->result() as $row) {
$urut++;
$k_layanan =$row->kd_layanan;
$n_layanan =$row->nm_layanan;
$nil1      =$row->Nilai_Target;
$nil2      =$row->Nilai_Maju;

$cRet.= " <tr>
                          <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"><b>".$urut."</b></td>                                     
                          <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$row->nm_layanan</b></td>
                          <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b></b></td></tr>
                          <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil1,'2','.',',')."</b></td></tr>
                          <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil2,'2','.',',')."</b></td></tr>
                          <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b></b></td>
                          </tr>
                                                     
                        ";
$q2=$this->db->query("SELECT *,0 AS Nilai_Target, 0 AS Nilai_Maju, 0 AS Selisih FROM ms_layanan WHERE LEVEL = '2' AND parent = '$k_layanan' AND jenis = 'Pendapatan' GROUP BY kd_layanan ASC");
$no = 'Z';
            foreach ($q2->result() as $row2) {
            $no++;
            $k_layanan2 =$row2->kd_layanan;
            $n_layanan2 =$row2->nm_layanan;
            $nil11      =$row2->Nilai_Target;
            $nil22      =$row2->Nilai_Maju;

            $cRet.= " <tr>
                                      <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"><b>".substr($no,1,1)."</b></td>                                     
                                      <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>$n_layanan2</b></td>
                                      <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b></b></td></tr>
                                      <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil11,'2','.',',')."</b></td></tr>
                                      <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nil22,'2','.',',')."</b></td></tr>
                                      <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b></b></td>
                                      </tr>
                                                                 
                                    ";
$q3=$this->db->query("SELECT *,
(SELECT SUM(b.nilai) AS nilai FROM trdrka_blud a INNER JOIN detail_sdana_trdrka b ON a.kd_skpd=b.kd_skpd 
INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' 
AND a.kd_kegiatan=b.kd_kegiatan
AND a.kd_rek7=b.kd_rek7 AND LEFT(b.kd_rek7,1)='4' AND c.level='3' and c.parent = '$k_layanan2') AS Nilai_Target, 
(SELECT SUM(b.nilai)*1.1 AS nilai FROM trdrka_blud a INNER JOIN detail_sdana_trdrka b ON a.kd_skpd=b.kd_skpd 
INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' 
AND a.kd_kegiatan=b.kd_kegiatan
AND a.kd_rek7=b.kd_rek7 AND LEFT(b.kd_rek7,1)='4' AND c.level='3' and c.parent = '$k_layanan2') AS Nilai_Maju, 0 AS Selisih FROM ms_layanan WHERE LEVEL = '3' AND parent = '$k_layanan2' AND jenis = 'Pendapatan' GROUP BY parent,kd_layanan ORDER BY kd_layanan ASC");
                    
                    foreach ($q3->result() as $row3) {
                    $n_layanan3 =$row3->nm_layanan;
                    $nil111      =$row3->Nilai_Target;
                    $nil222      =$row3->Nilai_Maju;
                   
                    $cRet.= " <tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"></td>                                     
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\">- $n_layanan3</td>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"></td></tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">".number_format($nil111,'2','.',',')."</td></tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">".number_format($nil222,'2','.',',')."</td></tr>
                                  <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"></td>
                                  </tr>                
                                ";
                                }
                            }

}
			$cRet    .= " <tr>                                 
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"53%\" colspan='2' align=\"center\"><b>TOTAL</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"><b>".number_format($nilai,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"><b>".number_format($nilai,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"5%\" align=\"right\"></td></tr>
										 
										 ";
								 
			
		$cRet    .= "</table>";
		$namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"50%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"50%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
		  <b>Direktur Rumah Sakit Umum Daerah</b><br>
		  <b>$namaskpd</b>
		  <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
				$this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '0' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }
	
	function preview_rka1_lama() {
        $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
			$thh_lalu=(1*$rowsc->thn_ang)-1;
        }
		
		
		    $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
		
		
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }

       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"100 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD 1</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"1\">
       
          <tr>
            <td colspan=\"2\"\ align=\"center\"><strong>ANGGARAN PENDAPATAN BLUD BERDASARKAN SUMBER PENDAPATAN</strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>No</b></td>                            
              <td bgcolor=\"#CCCCCC\" width=\"30%\" align=\"center\"><b>Uraian</b></td>
			   <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Proyeksi<br />TA $thh_lalu<br />(Rp)</b></td></tr>
			    <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Target<br />Periode TA 2016<br />(Rp)</b></td></tr>
				 <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Prakiraan Maju (Forward Estimate)<br />(Rp)</b></td></tr>
              <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>Selisih<br />%</b></td></tr>
           </thead>
           
             <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"30%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>3</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>4</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"20%\" align=\"center\"><i>5</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>6=(4-3)/3</i></td></tr>            
		   ";
    
	$q5=$this->db->query("SELECT SUM(b.nilai) AS nilai FROM trdrka_blud a INNER JOIN detail_sdana_trdrka b ON a.kd_skpd=b.kd_skpd 
		inner join ms_unit_layanan c on a.kd_unit=c.kd_unit WHERE a.kd_skpd='$id' 
AND a.kd_kegiatan=b.kd_kegiatan
AND a.kd_rek7=b.kd_rek7 AND LEFT(b.kd_rek7,1)='4'")->row();
$nilai=$q5->nilai;


	
			$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"><b>I</b></td>                                     
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>PELAYANAN</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b></b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nilai,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nilai,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b></b></td></tr>
										 
										 ";
		$q=$this->db->query("SELECT * FROM ms_unit_layanan WHERE LEVEL='1' ORDER BY kd_unit ASC");
		
		$no='Z';
		foreach($q->result_array() as $data){
			$no++;
			
			$unit=$data['kd_unit'];
		$q1=$this->db->query("SELECT SUM(b.nilai) AS nilai FROM trdrka_blud a INNER JOIN detail_sdana_trdrka b ON a.kd_skpd=b.kd_skpd 
		inner join ms_unit_layanan c on a.kd_unit=c.kd_unit WHERE a.kd_skpd='$id' 
AND a.kd_kegiatan=b.kd_kegiatan
AND a.kd_rek7=b.kd_rek7 AND LEFT(b.kd_rek7,1)='4' and c.parent='$unit'")->row();
$nilai_unit=$q1->nilai;
					
			$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\"><b>".substr($no,1,1)."</b></td>                                     
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"45%\"><b>".$data['nm_unit']."</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b></b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\"><b>".number_format($nilai_unit,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">".number_format($nilai_unit,'2','.',',')."<b></b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"right\"><b></b></td></tr>
										 
										 ";
										 
	$q2=$this->db->query("SELECT * FROM ms_unit_layanan WHERE parent='$unit'");
	$urut=0;
				foreach($q2->result_array() as $data2){
					$urut++;
					
					$subunit=$data2['kd_unit'];
					$q4=$this->db->query("SELECT SUM(b.nilai) AS nilai FROM trdrka_blud a INNER JOIN detail_sdana_trdrka b ON a.kd_skpd=b.kd_skpd 
		inner join ms_unit_layanan c on a.kd_unit=c.kd_unit WHERE a.kd_skpd='$id' 
AND a.kd_kegiatan=b.kd_kegiatan
AND a.kd_rek7=b.kd_rek7 AND LEFT(b.kd_rek7,1)='4' and a.kd_unit='$subunit'")->row();
$nilai_sub_unit=$q4->nilai;

						$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"8%\" align=\"center\">$urut</td>                                     
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"45%\">".$data2['nm_unit']."</td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\">".number_format($nilai_sub_unit,'2','.',',')."</td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\">".number_format($nilai_sub_unit,'2','.',',')."</td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"5%\" align=\"right\"></td></tr>
										 
										 ";
				}
			
		}
		
		
			$cRet    .= " <tr>                                 
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"53%\" colspan='2' align=\"center\"><b>TOTAL</b></td>
                                         <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"><b>".number_format($nilai,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"14%\" align=\"right\"><b>".number_format($nilai,'2','.',',')."</b></td></tr>
										 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"5%\" align=\"right\"></td></tr>
										 
										 ";
								 
			
		$cRet    .= "</table>";
		$namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"50%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"50%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
		  <b>Direktur Rumah Sakit Umum Daerah</b><br>
		  <b>$namaskpd</b>
		  <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
				$this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '0' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }
	
	function preview_rka21() {
        $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
			$thh_lalu=(1*$rowsc->thn_ang)-1;
        }
		
		
		    $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
		
		
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }

       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"100 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD 2.1</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"1\">
       
          <tr>
            <td colspan=\"2\"\ align=\"center\"><strong>Rekapitulasi Anggaran Biaya BLUD</strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" rowspan='2'><b>No</b></td>                            
              <td bgcolor=\"#CCCCCC\" width=\"35%\" align=\"center\" rowspan='2'><b>Alokasi Biaya</b></td>
			   <td bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\" colspan='3'><b>Jenis Anggaran</b></td>

				  <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" rowspan='2'><b>Total Biaya</b></td></tr>
           <tr>                         
             
			   <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Belanja Pegawai</b></td>
			    <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Belanja barang/Jasa</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Belanja Modal</b></td></tr>
				  
           </thead>
           
             <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"35%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>3</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>4</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>5</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>6</i></td></tr>            
		   ";
    
	
			$q1=$this->db->query("SELECT * FROM ms_layanan WHERE parent='0' and jenis = 'Belanja'");
	
		$no=0;
		$totblp1=0;
		$totblb1=0;
		$totblm1=0;
		$tottot1=0;
foreach($q1->result_array() as $data1){
	$no++;
	$kd_layanan=$data1['kd_layanan'];
	
				$q6=$this->db->query("select sum(a.nilai) as nilai from (SELECT a.*,b.kd_rek13,c.parent FROM trdrka_blud a INNER JOIN ms_rek7 b ON a.kd_rek7=b.kd_rek7 
				INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
				AND LEFT(b.kd_rek13,3)='521') a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();

				$blp1=$q6->nilai;
				
				$q7=$this->db->query("select sum(a.nilai) as nilai from (SELECT a.*,b.kd_rek13,c.parent FROM trdrka_blud a INNER JOIN ms_rek7 b ON a.kd_rek7=b.kd_rek7 
				INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
				AND LEFT(b.kd_rek13,3)='522') a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();

				$blb1=$q7->nilai;
				
				$q8=$this->db->query("select sum(a.nilai) as nilai from (SELECT a.*,b.kd_rek13,c.parent FROM trdrka_blud a INNER JOIN ms_rek7 b ON a.kd_rek7=b.kd_rek7 
				INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
				AND LEFT(b.kd_rek13,3)='523') a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();

				$blm1=$q8->nilai;
				
				$tot1=$blp1+$blb1+$blm1;
				
							
	$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\"><b>".$this->getromawi($no)."</b></td>                                     
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"35%\"><b>".$data1['nm_layanan']."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>".number_format($blp1,"2",".",",")."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>".number_format($blb1,"2",".",",")."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>".number_format($blm1,"2",".",",")."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\"><b>".number_format($tot1,"2",".",",")."</b></td>
			 </tr>
			 
			 ";
			 
		$totblp1=$totblp1+$blp1;
		$totblb1=$totblb1+$blb1;
		$totblm1=$totblm1+$blm1;
		$tottot1=$tottot1+$tot1;
		
		
		$q2=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan' order by kd_layanan asc");
		$no2='Z';
			foreach($q2->result_array() as $data2){
				$no2++;
					$kd_layanan2=$data2['kd_layanan'];
					
							$q3=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7 b ON a.kd_rek7=b.kd_rek7 
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							AND LEFT(b.kd_rek13,3)='521' and c.parent='$kd_layanan2'")->row();
						
							$blp=$q3->nilai;
							
							$q4=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7 b ON a.kd_rek7=b.kd_rek7 
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							AND LEFT(b.kd_rek13,3)='523' and c.parent='$kd_layanan2'")->row();
						
							$blb=$q4->nilai;
							
							$q5=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7 b ON a.kd_rek7=b.kd_rek7 
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							AND LEFT(b.kd_rek13,3)='523' and c.parent='$kd_layanan2'")->row();
						
							$blm=$q5->nilai;
							
							$tot=$blp+$blb+$blm;
						
				$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"center\"></td>                                     
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"35%\">".substr($no2,1,1).".&nbsp;".$data2['nm_layanan']."</td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">".number_format($blp,"2",".",",")."</td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">".number_format($blb,"2",".",",")."</td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">".number_format($blm,"2",".",",")."</td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"right\">".number_format($tot,"2",".",",")."</td>
			 </tr>
			 
			 ";
			}	
		
			
}						 

	$cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"45%\" align=\"center\" colspan='2'><b>JUMLAH</b></td>                                     
			 
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"15%\" align=\"right\"><b>".number_format($totblp1,"2",".",",")."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"15%\" align=\"right\"><b>".number_format($totblb1,"2",".",",")."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"15%\" align=\"right\"><b>".number_format($totblm1,"2",".",",")."</b></td>
			 <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: solid 1px black;\" width=\"15%\" align=\"right\"><b>".number_format($tottot1,"2",".",",")."</b></td>
			 </tr>
			 
			 ";
			
		$cRet    .= "</table>";
		$namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"50%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"50%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
		  <b>Direktur Rumah Sakit Umum Daerah</b><br>
		  <b>$namaskpd</b>
		  <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
				$this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '0' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }
	
	  function getromawi($angka) {
        switch ($angka) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
	
	
	 function daftar_kegiatan($offset = 0) {
        $id = $this->uri->segment(3);
        $data['page_title'] = "DAFTAR KEGIATAN";

        $total_rows = $this->rka_model->get_count($id);

        // pagination        

        $config['base_url'] = site_url("rka/daftar_kegiatan/$id");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $config['num_links'] = 6;
        $config['full_tag_open'] = '<ul class="page-navi">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $limit = $config['per_page'];
        $offset = $this->uri->segment(4);
        $offset = (!is_numeric($offset) || $offset < 1) ? 0 : $offset;

        if (empty($offset)) {
            $offset = 0;
        }

        $data['list'] = $this->rka_model->getAll_blud($limit, $offset, $id);
        $data['num'] = $offset;
        $data['total_rows'] = $total_rows;

        $this->pagination->initialize($config);

        $this->template->set('title', 'Master Data kegiatan');
        $this->template->load('template', 'anggaran/rka/list', $data);
    }
	
	function preview_rka22() {
	   $id = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
			$thh_lalu=(1*$rowsc->thn_ang)-1;
        }
		
		
		    $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
		
		
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }

       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"100 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD 2.2</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"1\">
       
          <tr>
            <td colspan=\"2\"\ align=\"center\"><strong>Anggaran Biaya BLUD Berdasarkan Sumber dan Alokasi Anggaran</strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\" rowspan='2'><b>No</b></td>                            
              <td bgcolor=\"#CCCCCC\" width=\"35%\" align=\"center\" rowspan='2'><b>Alokasi Biaya</b></td>
			   <td bgcolor=\"#CCCCCC\" width=\"45%\" align=\"center\" colspan='8'><b>Sumber Dana Tahun Anggaran $thn</b></td>

				  <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" rowspan='2'><b>Jumlah</b></td></tr>
           <tr>                         
             
			   <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Jasa layanan</b></td>
			    <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Hibah</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Kerjasama</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>APBD</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>APBA</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Lain-lain</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Lain-lain</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Piutang</b></td>
				 </tr>
				  
           </thead>
           
             <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"35%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>3</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>4</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>5</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>6</i></td></tr>  
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>7</i></td></tr>  
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>8</i></td></tr>  
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>9</i></td></tr>  
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>10</i></td></tr>  
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>11</i></td></tr>            
		   ";
    
			
$q1=$this->db->query("SELECT * FROM ms_layanan WHERE parent='0'");
	
		$no=0;
		$totbl1=0;
	
foreach($q1->result_array() as $data1){
		$no++;
	$kd_layanan=$data1['kd_layanan'];
	
	
		$q5=$this->db->query("select sum(a.nilai) as nilai from (SELECT a.*,c.parent FROM trdrka_blud a 
				INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
				) a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();

				$bl1=$q5->nilai;
				
	
	$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><b>".$this->getromawi($no)."</b></td>                            
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"35%\" align=\"left\"><b>".$data1['nm_layanan']."</b></td>
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl1,"2",".",",")."</b></td></tr> 
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl1,"2",".",",")."</b></td></tr>            
		   ";
		   
		   
		   	 $totbl1=$totbl1+$bl1;
	
		
		
		$q2=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan' order by kd_layanan asc");
		$no2='Z';
			foreach($q2->result_array() as $data2){
					$no2++;
					$kd_layanan2=$data2['kd_layanan'];
					
							$q4=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							and c.parent='$kd_layanan2'")->row();
						
							$bl=$q4->nilai;
							
							
							
							$tot=$bl;
							
					
					$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\"><b>".substr($no2,1,1)."</b></td>                            
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"35%\" align=\"left\"><b>".$data2['nm_layanan']."</b></td>
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl,"2",".",",")."</b></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl,"2",".",",")."</b></td></tr>            
						   ";
			
			
					$q3=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan2' order by kd_layanan asc");
					$no3=0;
					foreach($q3->result_array() as $data3){
							$no3++;
							$kd_layanan3=$data3['kd_layanan'];
							
							$q6=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							and a.kd_layanan='$kd_layanan3'")->row();
						
							$bl3=$q6->nilai;
							
							
							
							$tot3=$bl3;
							
							$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\">$no3</td>                            
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"35%\" align=\"left\">".$data3['nm_layanan']."</td>
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\">".number_format($bl3,"2",".",",")."</td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\">".number_format($bl3,"2",".",",")."</td></tr>            
						   ";
						   
					}
			
			}

}

			$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"40%\" align=\"center\" colspan='2'><b>JUMLAH</b></td>                            
             
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($totbl1,"2",".",",")."</b></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr>  
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($totbl1,"2",".",",")."</b></td></tr>            
						   ";	
			
		$cRet    .= "</table>";
		$namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"70%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"30%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
		  <b>Direktur Rumah Sakit Umum Daerah</b><br>
		  <b>$namaskpd</b>
		  <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
				$this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '1' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }

    function pengesahan_rba()
    {
        $data['page_title']= 'Pengesahan RBA';
        $this->template->set('title', 'Pengesahan RBA');   
        $this->template->load('template','anggaran/rka/pengesahan_rba',$data) ; 
    }
    function load_pengesahan_rba(){
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        
        if ($kriteria <> ''){                               
            $where="where (upper(a.kd_skpd) like upper('%$kriteria%') or a.no_dpa like'%$kriteria%')";            
        }
        
        $sql = "SELECT count(*) as tot from trhrka_blud a INNER JOIN ms_skpd_blud b ON a.kd_skpd = b.kd_skpd $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT * from trhrka_blud a INNER JOIN ms_skpd_blud b ON a.kd_skpd = b.kd_skpd $where order by a.kd_skpd ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $row[] = array(
                        'id' => $ii,
                        'kd_skpd' => $resulte['kd_skpd'],        
                        'nm_skpd' => $resulte['nm_skpd'],
                        'statu' => $resulte['statu'],
                        'status_ubah' => $resulte['status_ubah'],
                        'no_dpa' => $resulte['no_dpa'],        
                        'tgl_dpa' => $resulte['tgl_dpa'],
                        'no_dpa_ubah' => $resulte['no_dpa_ubah'],
                        'tgl_dpa_ubah' => $resulte['tgl_dpa_ubah']
                        );
                $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);     
    }
	
	
	function simpan_pengesahan(){
        $kdskpd = $this->input->post('kdskpd');
        $stdpa 	= $this->input->post('stdpa');
        $stdppa = $this->input->post('stdppa');
        $no  	= $this->input->post('no');
        $tgl 	= $this->input->post('tgl');
        $no2 	= $this->input->post('no2');
        $tgl2 	= $this->input->post('tgl2');
        $query_upd = $this->db->query("UPDATE trhrka_blud SET statu='$stdpa', status_ubah='$stdppa', no_dpa='$no', tgl_dpa='$tgl', no_dpa_ubah='$no2',tgl_dpa_ubah='$tgl2' WHERE kd_skpd ='$kdskpd'");
        if ( $query_upd > 0 ) {
            echo "1" ;
        } else {
            echo "0" ;
        }
	}
    
	
	
	function rka221() {
       $this->index2('0', 'trskpd_blud', 'kd_kegiatan', 'nm_kegiatan', 'RBA', 'rka221','');
    }
	
	function rka221_ubah() {
       $this->index2('0', 'trskpd_blud', 'kd_kegiatan', 'nm_kegiatan', 'RBA PERUBAHAN', 'rka221_ubah','');
    }
	
	function index2($offset = 0, $lctabel, $field, $field1, $judul, $list, $lccari) {
		$kd_skpd  = $this->session->userdata('kdskpd');
        $data['page_title'] = "CETAK $judul";
        if (empty($lccari)) {
            $total_rows = $this->db->query("SELECT DISTINCT kd_kegiatan from trskpd_blud WHERE kd_skpd='$kd_skpd' ")->num_rows();
    
        } else {
            $total_rows = $this->db->query("SELECT DISTINCT kd_kegiatan from trskpd_blud WHERE kd_skpd='$kd_skpd' and ($field like '%$lccari%' or $field1 like '%$lccari%')")->num_rows();

        }
        $config['base_url'] = site_url("rka_blud/" . $list);
        $config['total_rows'] = $total_rows;
        $config['per_page'] = '10';
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $config['full_tag_open'] = '<ul class="page-navi">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $limit = $config['per_page'];
        $offset = $this->uri->segment(3);
        $offset = (!is_numeric($offset) || $offset < 1) ? 0 : $offset;

        if (empty($offset)) {
            $offset = 0;
        }

			 $sqlpa = "SELECT nip, nama FROM ms_ttd_blud where kode='PA' AND kd_skpd='$kd_skpd' group by nip, nama";
            $data['ttdpa'] = $this->db->query($sqlpa);
		
        if (empty($lccari)) {

            $sqltpk = "SELECT kd_skpd, kd_kegiatan,nm_kegiatan from trskpd_blud  WHERE kd_skpd='$kd_skpd'order by $field asc ";
            $data['list'] = $this->db->query($sqltpk);

      
        } else {
			

		  $sqltpk = "SELECT kd_skpd, kd_kegiatan,nm_kegiatan from trskpd_blud where kd_skpd='$kd_skpd' AND ($field like '%$lccari%' or $field1 like '%$lccari%')
					order by $field asc ";
            $data['list'] = $this->db->query($sqltpk);
		
 
        }
        $data['num'] = $offset;
        $data['total_rows'] = $total_rows;

        $this->pagination->initialize($config);
        $a = $judul;
        $data['sikap'] = 'list';
        $this->template->set('title', 'CETAK RBA');
        $this->template->load('template', "anggaran/rka/" . $list, $data);
    }
	
	function preview_rka221() {
	   $kd_unit = $this->uri->segment(3);
        $cetak = $this->uri->segment(4);
		  $q_u = $this->db->query("select nm_unit from ms_unit_layanan where kd_unit='$kd_unit'")->row();
		    $nm_unit = $q_u->nm_unit;
		$id = $this->session->userdata('kdskpd');
        $sqldns = "SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud
                   a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
        $sqlskpd = $this->db->query($sqldns);
        foreach ($sqlskpd->result() as $rowdns) {
            $kd_urusan = $rowdns->kd_u;
            $nm_urusan = $rowdns->nm_u;
            $kd_skpd = $rowdns->kd_sk;
            $nm_skpd = $rowdns->nm_sk;
        }
        $sqlsc = "SELECT * FROM sclient";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $tgl = $rowsc->tgl_rka;
            $tanggal = $this->tanggal_format_indonesia($tgl);
            $kab = $rowsc->kab_kota;
            $daerah = $rowsc->daerah;
            $thn = $rowsc->thn_ang;
			$thh_lalu=(1*$rowsc->thn_ang)-1;
        }
		
		
		    $sqlsc = "SELECT * FROM ms_skpd_blud WHERE kd_skpd='$id'";
        $sqlsclient = $this->db->query($sqlsc);
        foreach ($sqlsclient->result() as $rowsc) {

            $nmskpd = strtoupper(str_replace('Rumah Sakit Umum Daerah','rsud',$rowsc->nm_skpd));
          
        }
		
		
        $sqlttd1 = "SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd where kd_skpd='$id' and kode='PA'";
        $sqlttd = $this->db->query($sqlttd1);
        foreach ($sqlttd->result() as $rowttd) {
            $nip = $rowttd->nip;
            $nama = $rowttd->nm;
            $jabatan = $rowttd->jab;
        }
		
		
		$q=$this->db->query("SELECT * FROM trskpd_blud WHERE kd_kegiatan='1.02.1.02.02.00.33.01'")->row();
		$nm_program=$q->nm_program;
		$nm_kegiatan=$q->nm_kegiatan;
		
		$q1=$this->db->query("SELECT SUM(nilai) AS nilai FROM trdrka_blud WHERE kd_unit='$kd_unit' AND LEFT(kd_rek7,1)='5'")->row();
		$ang_biaya=$q1->nilai;
		
       $cRet='';
    $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
          <tr>
            <td width=\"10%\" rowspan=\"4\" align=\"left\">
              <img src=\"".base_url()."/image/logo.png\" width=\"100 px\"height=\"100 px\" />

            </td> 
            <td width=\"80%\" align=\"center\">
              <h2><strong>RENCANA BISNIS ANGGARAN </strong> 
              <br><strong>$nmskpd</strong></h2>
            </td>
            
            <td width=\"20%\" rowspan=\"4\" align=\"center\">
              <strong>RBA - BLUD 2.2.1<br />
			  $nm_unit</strong>
              </td>
            <tr>
            <td width=\"80%\" align=\"center\">
              <h2><strong>TAHUN ANGGARAN $thn</strong></h2> </td>
            </td>
          </tr>                                                      
          </tr>
        </table>";
    $cRet .="<table style=\"border-collapse:collapse;font-size:12px;\" width=\"100%\" align=\"left\" border=\"1\">
       
	     <tr>
            <td align=\"center\" width=\"15%\"><strong>Program</strong></td>
			<td align=\"left\" colspan='2'><strong>&nbsp;".$nm_program."</strong></td>
          </tr>
		    <tr>
            <td align=\"center\"><strong>Kegiatan</strong></td>
			<td align=\"left\" colspan='2'><strong>&nbsp;".$nm_kegiatan."&nbsp;$nm_unit</strong></td>
          </tr>
		  
		      <tr>
            <td align=\"center\" ><strong>Indikator</strong></td>
			<td align=\"center\" ><strong>Tolak Ukur Kinerja</strong></td>
			<td align=\"center\" width=\"20%\"><strong>Target Kinerja</strong></td>
          </tr>
		        <tr>
            <td align=\"center\" ><strong>Input</strong></td>
			<td align=\"left\" >&nbsp;<strong>Anggaran Biaya</strong></td>
			<td align=\"right\" ><strong>".number_format($ang_biaya,"2",".",",")."</strong></td>
          </tr>";
		  
		   
		 
		$q2=$this->db->query("SELECT b.nm_rek3,SUM(a.nilai) AS nilai FROM trdrka_blud a 
INNER JOIN ms_rek3_blud b ON LEFT(a.kd_rek7,4)=b.kd_rek3
WHERE a.kd_unit='$kd_unit' AND LEFT(a.kd_rek7,1)='4' GROUP BY LEFT(a.kd_rek7,4) ORDER BY a.kd_rek7 ASC");
$out='';
foreach($q2->result_array() as $data){
	
	if($out == ''){
		$out1='Output';
	}else{
		$out1='';
	}
	
	$cRet .="<tr>
            <td align=\"center\" ><strong>".$out1."</strong></td>
			<td align=\"left\" >&nbsp;<strong>".$data['nm_rek3']."</strong></td>
			<td align=\"right\" ><strong>".number_format($data['nilai'],"2",".",",")."</strong></td>
          </tr>";
	$out='Output';	  
	
}
	$cRet .="<tr>
            <td align=\"center\" ><strong>Outcome</strong></td>
			<td align=\"left\" >&nbsp;Pencapaian Standar Pelayanan Minumum Administrasi manajemen</td>
			<td align=\"center\" >90%</td>
          </tr>
          <tr>
            <td colspan=\"3\"\ align=\"center\"><strong>Anggaran Belanja</strong></td>
          </tr>
        </table>";
    $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
           <thead>                       
            <tr>                        
              <td bgcolor=\"#CCCCCC\" width=\"50%\" align=\"center\" rowspan='2' colspan='2'><b>Komponen Biaya</b></td>
			   <td bgcolor=\"#CCCCCC\" width=\"35%\" align=\"center\" colspan='3'><b>Rincian Biaya</b></td>

				  <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\" ><b>Jumlah Anggaran</b></td></tr>
           <tr>                         
             
			   <td bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>Jumlah</b></td>
			    <td bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>Satuan</b></td>
				 <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>Harga satuan</b></td>
				  <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>(Rp)</b></td>
				 </tr>
				  
         
           
             <tr><td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"5%\" align=\"center\" colspan='2'><i>1</i></td>                            
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"center\"><i>2</i></td>
              <td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"center\"><i>3</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>4</i></td></tr> 
<td style=\"vertical-align:middle;border-top: none;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"center\"><i>5 = (2X4)</i></td></tr>          
		     </thead>
		   ";
    
			
$q1=$this->db->query("SELECT * FROM ms_layanan WHERE parent='0' and jenis = 'Belanja'");
	
		$no=0;
		$totbl1=0;
	
foreach($q1->result_array() as $data1){
		$no++;
	$kd_layanan=$data1['kd_layanan'];
	
	
		$q5=$this->db->query("select sum(a.nilai) as nilai from (SELECT a.*,c.parent FROM trdrka_blud a 
				INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
				) a inner join ms_layanan b on a.parent=b.kd_layanan where b.parent='$kd_layanan'")->row();

				$bl1=$q5->nilai;
				
	
	$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-right: none;font-size:11px;\" width=\"5%\" align=\"left\">&nbsp;<b>".$this->getromawi($no)."</b></td>                            
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-left: none;font-size:11px;\" width=\"45%\" align=\"left\"><b>".$data1['nm_layanan']."</b></td>
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\"></td></tr> 
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\"></td></tr> 
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 
 
<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl1,"2",".",",")."</b></td></tr>            
		   ";
		   
		   
		   	 $totbl1=$totbl1+$bl1;
	
		
		
		$q2=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan' order by kd_layanan asc");
		$no2='Z';
			foreach($q2->result_array() as $data2){
					$no2++;
					$kd_layanan2=$data2['kd_layanan'];
					
							$q4=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							and c.parent='$kd_layanan2'")->row();
						
							$bl=$q4->nilai;
							
							
							
							$tot=$bl;
							
					
					$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-right: none;font-size:11px;\" width=\"5%\" align=\"left\">&nbsp;&nbsp;&nbsp;<b>".substr($no2,1,1)."</b></td>                            
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-left: none;font-size:11px;\" width=\"45%\" align=\"left\"><b>".$data2['nm_layanan']."</b></td>
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 

				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl,"2",".",",")."</b></td></tr>            
						   ";
			
			
					$q3=$this->db->query("SELECT * FROM ms_layanan WHERE parent='$kd_layanan2' order by kd_layanan asc");
					$no3=0;
					foreach($q3->result_array() as $data3){
							$no3++;
							$kd_layanan3=$data3['kd_layanan'];
							
							$q6=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							and a.kd_layanan='$kd_layanan3'")->row();
						
							$bl3=$q6->nilai;
							
							
							
							$tot3=$bl3;
							
							$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-right: none;font-size:11px;\" width=\"5%\" align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$no3</td>                            
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-left: none;font-size:11px;\" width=\"45%\" align=\"left\"><b>".$data3['nm_layanan']."</b></td>
              <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\"></td></tr> 
				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"></td></tr> 

				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($bl3,"2",".",",")."</b></td></tr>            
						   ";
						   
						   $q7=$this->db->query("SELECT a.kd_rek7,a.nm_rek7,a.nilai FROM trdrka_blud a
							INNER JOIN ms_layanan c ON a.kd_layanan=c.kd_layanan WHERE a.kd_skpd='$id' AND LEFT(a.kd_rek7,1)='5'
							and a.kd_layanan='$kd_layanan3' order by a.kd_rek7 asc");
						foreach($q7->result_array() as $data4){
							$kd_rek7=$data4['kd_rek7'];
							$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-right: none;font-size:11px;\" width=\"5%\" align=\"left\">&nbsp;</td>                            
							  <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-left: none;font-size:11px;\" width=\"45%\" align=\"left\"><b>&nbsp;&nbsp;&nbsp;".$data4['nm_rek7']."</b></td>
							  <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\">&nbsp;</td></tr> 
								<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"right\">&nbsp;</td></tr> 
								<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\">&nbsp;</td></tr> 

								<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($data4['nilai'],"2",".",",")."</b></td></tr>   
								";
								
							$q8=$this->db->query("SELECT b.uraian,b.volume1,b.satuan1,b.harga1,b.total FROM trdrka_blud a INNER JOIN trdpo_blud b ON a.no_trdrka=b.no_trdrka AND a.kd_unit=b.kd_unit
													WHERE a.kd_unit='$kd_unit' AND a.kd_layanan='$kd_layanan3' AND kd_rek7='$kd_rek7' order by no_po asc");
							
						
							foreach($q8->result_array() as $data5){
							
							$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-right: none;font-size:11px;\" width=\"5%\" align=\"left\">&nbsp;</td>                            
							  <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;border-left: none;font-size:11px;\" width=\"45%\" align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data5['uraian']."</td>
							  <td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"center\">".$data5['volume1']."</td></tr> 
								<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"10%\" align=\"center\">".$data5['satuan1']."</td></tr> 
								<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\">".number_format($data5['harga1'],"2",".",",")."</td></tr> 

								<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: none;font-size:11px;\" width=\"15%\" align=\"right\">".number_format($data5['total'],"2",".",",")."</td></tr>   
								";
							}
						}
							
						   
					}
			
			}

}

			$cRet .= "<tr><td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"85%\" align=\"center\" colspan='5'><b>JUMLAH BIAYA</b></td>                            
             


				<td style=\"vertical-align:middle;border-top: solid 1px black;border-bottom: solid 1px black;font-size:11px;\" width=\"15%\" align=\"right\"><b>".number_format($totbl1,"2",".",",")."</b></td></tr>            
						   ";	
			
		$cRet    .= "</table>";
		$namaskpd=str_replace('Rumah Sakit Umum Daerah','',$nm_skpd);
    $cRet .="<br ><table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
           <tr>
         <td width=\"50%\" align=\"left\" >&nbsp;
          </td>
          <td width=\"50%\" align=\"center\" >$daerah, $tanggal
          <br>Mengesahkan,<br>
		  <b>Direktur Rumah Sakit Umum Daerah</b><br>
		  <b>$namaskpd</b>
		  <br><br>
          <p>&nbsp;</p>
          <br><u><b>".$nama."</b></u>
          <br>NIP. ".$nip."
           </td></tr>
          </table>";//COBA 


        $data['prev'] = $cRet;
        //$this->_mpdf('',$cRet,10,10,10,0);
        $judul = 'RBA0 - ' . $id;
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
        switch ($cetak) {
            case 1;
                //$this->_mpdf('', $cRet, 10, 10, 10, '0');
				$this->tukd_model->_mpdf ( '', $cRet, 10, 10, 10, '0' );
                break;
            case 2;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename= $judul.xls");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
            case 3;
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Content-Type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename= $judul.doc");
                $this->load->view('anggaran/rka/perkadaII', $data);
                break;
        }
    }
	
    function cari221() {
        $lccr = $this->input->post('nm_skpd');
 
		 $this->index2('0', 'ms_unit_layanan', 'kd_unit', 'nm_unit', 'RBA 2.2.1', 'rka221', $lccr);
    }
//-------------------------- dika rka ubah ---------------------------------------------//
    function tambah_rka_ubah() {
        $jk = $this->rka_model->combo_skpd ();
        $ry = $this->rka_model->combo_giat ();
        $cRet = '';
        
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >
                   <tr >                       
                        <td>INPUT ANGGARAN PERUBAHAN$jk</td>
                        <td>$ry</td>
                        </tr>
                  ";
        
        $cRet .= "</table>";
        $data ['prev'] = $cRet;
        $data ['page_title'] = 'INPUT RENCANA BISNIS ANGGARAN PERUBAHAN';
        $this->template->set ( 'title', 'INPUT RBA PERUBAHAN' );
        $sql = "select a.kd_rek5,b.nm_rek5,a.nilai,a.nilai_ubah from trdrka_blud a inner join ms_rek5 b on a.kd_rek5=b.kd_rek5";
        
        $query1 = $this->db->query ( $sql );
        $results = array ();
        $i = 1;
        foreach ( $query1->result_array () as $resulte ) {
            $results [] = array (
                    'id' => $i,
                    'kd_rek5' => $resulte ['kd_rek5'],
                    'nm_rek5' => $resulte ['nm_rek5'],
                    'nilai' => $resulte ['nilai'],
                    'nilai_ubah' => $resulte ['nilai_ubah'] 
            );
            $i ++;
        }
        $this->template->load ( 'template', 'anggaran/rka/tambah_rka_ubah', $data );
    }
    function skpd() {
        $lccr = $this->input->post ( 'q' );
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd_blud where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') order by kd_skpd ";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $result [] = array (
                    'id' => $ii,
                    'kd_skpd' => $resulte ['kd_skpd'],
                    'nm_skpd' => $resulte ['nm_skpd'] 
            );
            $ii ++;
        }
        
        echo json_encode ( $result );
        $query1->free_result ();
    }
    function tsimpan_ar_ubah(){
        
        $kdskpd = $this->input->post('kd_skpd');
        $kdkegi = $this->input->post('kd_kegiatan');
        $kdrek  = $this->input->post('kd_rek5');
        $nilai  = $this->input->post('nilai');
        $sdana1 = $this->input->post('dana1');
        $sdana2 = $this->input->post('dana2');
        $sdana3 = $this->input->post('dana3');
        $sdana4 = $this->input->post('dana4');
        
         $unit = $this->input->post('unitss');
          $jasa = $this->input->post('jasabro');
                
        $nmskpd = $this->rka_model->get_nama($kdskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $nmkegi = $this->rka_model->get_nama($kdkegi,'nm_kegiatan','trskpd_blud','kd_kegiatan');
        $nmrek  = $this->rka_model->get_nama($kdrek,'nm_rek7','ms_rek7_blud','kd_rek7');
        
        $notrdrka  = $kdskpd.'.'.$kdkegi.'.'.$kdrek ;
        $nogab=$kdskpd.'.'.$kdkegi;
            
        $query_del = $this->db->query("delete from trdrka_blud where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' and kd_unit='$unit' and kd_layanan='$jasa' and kd_rek7='$kdrek' ");
        $query_ins = $this->db->query("insert into trdrka_blud (no_trdrka,kd_skpd,nm_skpd,kd_unit,kd_kegiatan,nm_kegiatan,kd_rek7,nm_rek7,nilai,nilai_ubah,sumber,sumber2,sumber3,sumber4,kd_layanan) values('$notrdrka','$kdskpd','$nmskpd','$unit','$kdkegi','$nmkegi','$kdrek','$nmrek','0.00','$nilai','$sdana1','$sdana2','$sdana3','$sdana4','$jasa')");        
        $query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
         
         $q=$this->db->query("SELECT kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON RIGHT(a.no_trdrka,10)=b.kd_rek7 WHERE no_trdrka ='$notrdrka'");
        
        if($q->num_rows() > 0){
            $dat=$q->row();
            $kd_rek13=$dat->kd_rek13;
            $nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
            
            $q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON RIGHT(a.no_trdrka,10)=b.kd_rek7 
                    WHERE LEFT(no_trdrka,32)='$nogab' AND b.kd_rek13='$kd_rek13'")->row();
            $nilai=$q2->nilai;
                
            $q1=$this->db->query("SELECT * FROM trdrka  WHERE LEFT(no_trdrka,32)='$nogab' AND RIGHT(no_trdrka,7)='$kd_rek13'");
            if($q1->num_rows() > 0){
                $q2 = $this->db->query("update trdrka set nilai_ubah='$nilai' where LEFT(no_trdrka,32)='$nogab' AND RIGHT(no_trdrka,7)='$kd_rek13'");
            }else{
                
                $notrdrka2=$nogab.'.'.$kd_rek13;
                $q2 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah,sumber,sumber2,sumber3,sumber4) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','0.00','$nilai','$sdana1','$sdana2','$sdana3','$sdana4')");    
            }
        } 
         
        if ( $query_ins > 0 and $query_del > 0 ) {
            echo "1" ;
        } else {
            echo "0" ;
        }
        
    }
    function select_rka_ubah($kegiatan='',$unit='') {

        $sql = "select a.kd_rek7,b.nm_rek7,a.nilai,a.nilai_ubah,a.sumber,a.sumber2,a.sumber3,a.sumber4,a.kd_layanan,c.nm_layanan from trdrka_blud a inner join ms_rek7_blud b on a.kd_rek7=b.kd_rek7 left join ms_layanan c on a.kd_layanan=c.kd_layanan where a.kd_kegiatan='$kegiatan' and a.kd_unit='$unit' order by a.kd_rek7";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek7'],  
                        'nm_rek5' => $resulte['nm_rek7'],  
                        'nilai' => number_format($resulte['nilai'],"2",".",","),
                        'nilai_ubah' => number_format($resulte['nilai_ubah'],"2",".",","),                             
                        'sumber' => $resulte['sumber'],
                        'sumber2' => $resulte['sumber2'],
                        'sumber3' => $resulte['sumber3'],
                        'sumber4' => $resulte['sumber4'],
                        'kd_layanan' => $resulte['kd_layanan'],
                        'nm_layanan' => $resulte['nm_layanan']                      
                        );
                        $ii++;
        }
           
           echo json_encode($result);
            $query1->free_result();
    }
    function select_sdana_ubah($kdskpd='',$kegiatan='',$unit='',$kdrek='') {

        $sql = "SELECT a.*,(select nm_sdana from ms_dana_blud where kd_sdana=a.kd_sdana) as nm_sdana FROM detail_sdana_trdrka a WHERE a.kd_skpd='$kdskpd' AND a.kd_kegiatan='$kegiatan' AND a.kd_unit='$unit' AND a.kd_rek7='$kdrek'";                   
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_sdana' => $resulte['kd_sdana'],  
                        'nm_sdana' => $resulte['nm_sdana'],  
                        'nilai' => number_format($resulte['nilai'],"2",".",","),
                        'nilai_ubah' => number_format($resulte['nilai_ubah'],"2",".",",")
                        );
                        $ii++;
        }
           
           echo json_encode($result);
            $query1->free_result();
    }
    function simpan_sdana_ubah(){
        
		$kdskpd      = $this->input->post('kd_skpd');
		$kdkegi      = $this->input->post('kd_kegiatan');
		$kdrek       = $this->input->post('kd_rek5');
		$nilai       = $this->input->post('nilai');
		$nilai_ubah  = $this->input->post('nilai_ubah');
		$unit        = $this->input->post('unit');
		$kd_sdana    = $this->input->post('kd_sdana');
		$status      = $this->input->post('status');
		$vnilaisdana = $this->input->post('vnilaisdana');
		$nilaiawal   = $this->input->post('nilaiawal');
			
		 
		$nmskpd = $this->rka_model->get_nama($kdskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
		$nmkegi = $this->rka_model->get_nama($kdkegi,'nm_kegiatan','trskpd_blud','kd_kegiatan');
       
		
     
	 if($status == 'tambah'){
		   $cek=$this->db->query("select * from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' and kd_sdana='$kd_sdana'");      
		if($cek->num_rows() > 0){
			echo '0';
			return;
		}
		
		
		$query_ins = $this->db->query("insert into detail_sdana_trdrka (kd_skpd,kd_unit,kd_kegiatan,kd_rek7,nilai,nilai_ubah,kd_sdana) values('$kdskpd','$unit','$kdkegi','$kdrek','$nilai','$nilai_ubah','$kd_sdana')");    
		$query_up = $this->db->query("update trdrka_blud set nilai=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ),nilai_ubah=( select sum(nilai_ubah) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ) where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'");    
		$query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai_ubah) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
			$q=$this->db->query("SELECT distinct no_trdrka,kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' and a.kd_rek7='$kdrek'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$no_trdrka=$dat->no_trdrka;
			$kd_rek13=$dat->kd_rek13;
			$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 
					WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q21 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai_ubah' where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			}else{
				
				$notrdrka2=substr($no_trdrka,0,32).'.'.$kd_rek13;
				$q21 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai_ubah')");    
			}
		}
		
		echo '1';
		 
	 }else if($status == 'edit'){
		  $gab=$kdskpd.'.'.$kdkegi.'.'.$kdrek;
		  
		    $cek_tot_sdana=$this->db->query("select sum(nilai) as total from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'")->row();
		  $cek_tot_sdana=$cek_tot_sdana->total;
		  
		  
		  
		  $selisih=$cek_tot_sdana+$nilai-$nilaiawal;
	
		  $cek_tot_po=$this->db->query("select sum(total) as total from trdpo_blud where no_trdrka='$gab' and kd_unit='$unit'")->row();
		  $cek_tot_po=$cek_tot_po->total; 
		  
		  
		   if($selisih < $cek_tot_po){
			 echo '3';
		 }else{
		 	 $query_edit = $this->db->query("update detail_sdana_trdrka set nilai_ubah='$nilai_ubah' where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' and kd_sdana='$kd_sdana'");    
		
		$query_up = $this->db->query("update trdrka_blud set nilai=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ),nilai_ubah=( select sum(nilai_ubah) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ) where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'"); 	  
		$query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai_ubah) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
			$q=$this->db->query("SELECT distinct no_trdrka,kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' and a.kd_rek7='$kdrek'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$no_trdrka=$dat->no_trdrka;
			$kd_rek13=$dat->kd_rek13;
			$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 
					WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q21 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai_ubah' where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			}else{
				
				$notrdrka2=substr($no_trdrka,0,32).'.'.$kd_rek13;
				$q21 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai_ubah')");    
			}
		} 
		
		echo '1';
			 
		 }
		 
		 
	 }else if($status == 'hapus'){
		 $gab=$kdskpd.'.'.$kdkegi.'.'.$kdrek;
		 
		  $cek_tot_sdana=$this->db->query("select sum(nilai) as total from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'")->row();
		 
		 $cek_tot_sdana=$cek_tot_sdana->total;
		  
		  $selisih=$cek_tot_sdana-$vnilaisdana;
		  
		  $cek_tot_po=$this->db->query("select sum(total) as total from trdpo_blud where no_trdrka='$gab' and kd_unit='$unit'")->row();
		  $cek_tot_po=$cek_tot_po->total;
		  
		  
		 if($selisih < $cek_tot_po){
			 echo '3';
		 }else{
		 
		
			 $query_edit = $this->db->query("delete from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' and kd_sdana='$kd_sdana'");    
		
		$query_up = $this->db->query("update trdrka_blud set nilai=( select sum(nilai) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ),nilai_ubah=( select sum(nilai_ubah) as jum from detail_sdana_trdrka where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek' ) where kd_skpd='$kdskpd' and kd_unit='$unit' and kd_kegiatan='$kdkegi' and kd_rek7='$kdrek'"); 
		$query = $this->db->query(" update trskpd_blud set total=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),total_ubah=( select sum(nilai_ubah) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tk_mas=( select sum(nilai) as jum from trdrka_blud where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ),tu_mas='Dana' where kd_kegiatan='$kdkegi' and kd_skpd='$kdskpd' ");  
			$q=$this->db->query("SELECT distinct no_trdrka,kd_rek13 FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' and a.kd_rek7='$kdrek'");
		
		if($q->num_rows() > 0){
			$dat=$q->row();
			$no_trdrka=$dat->no_trdrka;
			$kd_rek13=$dat->kd_rek13;
			$nmrek13  = $this->rka_model->get_nama($kd_rek13,'nm_rek5','ms_rek5','kd_rek5');
			
			$q2=$this->db->query("SELECT SUM(a.nilai) AS nilai FROM trdrka_blud a INNER JOIN ms_rek7_blud b ON a.kd_rek7=b.kd_rek7 
					WHERE a.kd_skpd='$kdskpd' and a.kd_kegiatan='$kdkegi' AND b.kd_rek13='$kd_rek13'")->row();
			$nilai=$q2->nilai;
				
			$q1=$this->db->query("SELECT * FROM trdrka  WHERE kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			if($q1->num_rows() > 0){
				$q21 = $this->db->query("update trdrka set nilai='$nilai',nilai_ubah='$nilai_ubah' where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' AND kd_rek5='$kd_rek13'");
			}else{
				
				$notrdrka2=substr($no_trdrka,0,32).'.'.$kd_rek13;
				$q21 = $this->db->query("insert into trdrka (no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) values('$notrdrka2','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kd_rek13','$nmrek13','$nilai','$nilai_ubah')");    
			}
		}
		
		echo '2';
		 
		
	 }
	 }
    }
//---------------------------------------- Tambah Program Kegiatan ---------------------------------------//
function urusan() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_urusan,nm_urusan FROM ms_urusan_blud where upper(kd_urusan) like upper('%$lccr%') or upper(nm_urusan) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_urusan' => $resulte['kd_urusan'],  
                        'nm_urusan' => $resulte['nm_urusan'],  
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

function tambah_giat()
	{
		$wy=$this->rka_model->combo_urus();
        $jk=$this->rka_model->combo_skpd1();         
        $cRet='';
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                   <tr>
                        <td>Kode Urusan</td>
                        <td>:</td>
                        <td>$wy</td>
                        </tr>
                  ";
         
         $cRet .="<tr>
                        <td>Kode SKPD</td>
                        <td>:</td>
                        <td>$jk</td>
                        </tr>
                  </table>";
        $data['prev']= $cRet;
        $data['page_title']= 'PILIH KEGIATAN';
        $this->template->set('title', 'DETAIL KEGIATAN');          
        $this->template->load('template','anggaran/rka/pilih_giat',$data) ; 
        //$this->load->view('anggaran/rka/tambah_rka',$data) ;
   }
   function ld_giat($skpd='',$urusan='') { 
        $lccr   = $this->input->post('q');
		if ($skpd=='0')
		{
			$sql    = "SELECT kd_kegiatan,nm_kegiatan,jns_kegiatan FROM m_giat_blud where (left(kd_kegiatan,4)= '$urusan') and (upper(kd_kegiatan) 
                        like upper('%$lccr%') or upper(nm_kegiatan) like upper('%$lccr%')) and kd_kegiatan not in(select kd_kegiatan1 
                        from trskpd_blud_rancang where kd_skpd='$skpd') order by kd_kegiatan  ";
	}else{
			$sql    = "SELECT kd_kegiatan,nm_kegiatan,jns_kegiatan FROM m_giat_blud where (left(kd_kegiatan,10)= left('$skpd',10) or 
                        (left(kd_kegiatan,4)='$urusan' or left(kd_kegiatan,4)='0.00') and (upper(kd_kegiatan) like upper('%$lccr%') or 
                        upper(nm_kegiatan) like upper('%$lccr%')) ) and kd_kegiatan not in(select kd_kegiatan1 from trskpd_blud where kd_skpd='$skpd') 
                        order by kd_kegiatan ";	
}
	
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],  
                        'nm_kegiatan' => $resulte['nm_kegiatan'],
                        'jns_kegiatan' => $resulte['jns_kegiatan'],
                        'lanjut' => 'Tidak'

                        );
                        $ii++;
        }
        echo json_encode($result);
	}

    function select_giat($skpd='') {    
        $sql = "select a.kd_kegiatan as kd_kegiatan,b.nm_kegiatan,a.jns_kegiatan,a.lanjut from trskpd_blud a inner join m_giat_blud b on b.kd_kegiatan=a.kd_kegiatan1 where a.kd_skpd='$skpd' order by a.kd_kegiatan";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id' => $ii,
                        'kd_kegiatan' => $resulte['kd_kegiatan'],                         
                        'nm_kegiatan' => $resulte['nm_kegiatan'],  
                        'jns_kegiatan' => $resulte['jns_kegiatan'],                           
                        'lanjut' => $resulte['lanjut']                           
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
	

	function psimpan($skpd='',$urusan='',$rekbaru='',$reklama='',$jns='',$lanjut='Tidak') {      	
    $kd=$this->right($rekbaru,5);
    $prog1=$this->left($rekbaru,13);	
    $giat=$urusan.'.'.$skpd.'.'.$kd;
    $prog=$this->left($giat,18); 
    $gabung=$skpd.'.'.$giat;
    $nmskpd=$this->rka_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd');
    $nmgiat=$this->rka_model->get_nama($rekbaru,'nm_kegiatan','m_giat_blud','kd_kegiatan');
    $nmprog=$this->rka_model->get_nama($prog1,'nm_program','m_prog','kd_program');
	$query = $this->db->query("delete from trskpd_blud where kd_skpd='$skpd' and kd_gabungan='$gabung'");
	$query = $this->db->query("insert into trskpd_blud(kd_gabungan,kd_kegiatan,kd_program,kd_urusan,kd_skpd,kd_kegiatan1,kd_program1,jns_kegiatan,nm_skpd,nm_kegiatan,nm_program,lanjut) 
                                values('$gabung','$giat','$prog','$urusan','$skpd','$rekbaru','$prog1','$jns','$nmskpd','$nmgiat','$nmprog','$lanjut')");	
    $this->select_giat($skpd);
    }
	
	 function ghapus($skpd='',$kegiatan) {
		$query = $this->db->query("delete from trskpd_blud where kd_skpd='$skpd' and kd_kegiatan='$kegiatan' and  kd_kegiatan not in(SELECT DISTINCT kd_kegiatan FROM trdrka)");
		$this->select_giat($skpd);
    }
	
	
	
	
	function load_rek_blud($kd_rek='') {
		$lccr = $this->input->post('q');
        $sql = "select kd_rek5, nm_rek5 FROM ms_rek5_blud WHERE LEFT(kd_rek5,1)=LEFT($kd_rek,1) and ( upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%') ) ORDER BY kd_rek5";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id' => $ii,
                        'kd_rek5' => $resulte['kd_rek5'],                         
                        'nm_rek5' => $resulte['nm_rek5']                        
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
	
	function tsimpan_sempurna(){
        $kdskpd = $this->input->post('kd_skpd');
        $kdkegi = $this->input->post('kd_kegiatan');
        $kdrek  = $this->input->post('kd_rek5');
        $nilai  = $this->input->post('nilai');
        $sdana1 = rtrim($this->input->post('dana1'));
        $id         =  $this->session->userdata('pcNama');        
        $nmskpd = $this->rka_model->get_nama($kdskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $nmkegi = $this->rka_model->get_nama($kdkegi,'nm_kegiatan','trskpd_blud','kd_kegiatan');
        $nmrek  = $this->rka_model->get_nama($kdrek,'nm_rek5','ms_rek5','kd_rek5');
        
        $notrdrka  = $kdskpd.'.'.$kdkegi.'.'.$kdrek ;
        $query_find = $this->db->query("select * from trdrka_blud where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' and kd_rek5='$kdrek'");
        $update = $query_find->num_rows();
        if($update > 0){
            $query_ins = $this->db->query("update trdrka_blud set nilai_ubah='$nilai',username='$id',sumber='$sdana1',last_update=getdate() where kd_skpd='$kdskpd' and kd_kegiatan='$kdkegi' and kd_rek5='$kdrek'
                                           ");        
        }else{
            $query_ins = $this->db->query("insert into trdrka_blud(no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah,sumber,sumber2,sumber3,sumber4,username,last_update) 
            values('$notrdrka','$kdskpd','$nmskpd','$kdkegi','$nmkegi','$kdrek','$nmrek',0,'$nilai','$sdana1','','','','$id',getdate())");        
        }
        
        
        if ( $query_ins > 0 ) {
            echo "1" ;
        } else {
            echo "0" ;
        }
        
    }
	
	
	
	function preview_rba(){
        $id 	= $this->uri->segment(3);
        $giat 	= $this->uri->segment(4);
        $ttd1	= $this->uri->segment(5);
		$thn   	= $this->session->userdata('pcThang');
		
		$len_id=strlen($id);
		$len_giat=strlen($giat);
		
		 //$ttd1 = STR_REPLACE("%20"," ",$ttd1);
		
		//$tgl_ttd= $_REQUEST['tgl_ttd'];
		//$ttd1= $_REQUEST['ttd1'];
		//$ttd2= $_REQUEST['ttd2'];
		//$tanggal_ttd = $this->tanggal_format_indonesia($tgl_ttd);
        
        /* $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    //$tanggal = $this->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                } */
		
		$sqlsc="SELECT daerah, kop FROM ms_skpd_blud where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kop;
                    $daerah  = $rowsc->daerah;
                }	
		
       //$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd_blud WHERE kd_skpd= '$id' AND rtrim(kode)='PA' AND nip='$ttd1'   ";
       
	   $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd_blud WHERE rtrim(kode)='PA' AND kd_skpd='$id'   ";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip; 
                    $pangkat=$rowttd->pangkat;
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                }
		/*		
		$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE left(kd_skpd,7)= left('$id',7) AND kode='PA' AND(REPLACE(nip, ' ', '')='$ttd2')  ";
                 $sqlttd2=$this->db->query($sqlttd2);
                 foreach ($sqlttd2->result() as $rowttd2)
                {
                    $nip2=$rowttd2->nip;
                    $pangkat2=$rowttd2->pangkat;
                    $nama2= $rowttd2->nm;
                    $jabatan2  = $rowttd2->jab;
                }
				*/
        $sqlorg="SELECT f.kd_urusan,f.nm_urusan,a.kd_skpd,e.nm_skpd,a.kd_program,a.nm_program,a.kd_kegiatan,c.nm_kegiatan,SUM(d.nilai) AS nilai,a.tu_capai,a.tu_mas,a.tu_kel,a.tu_has,
                a.tk_capai,a.tk_mas,a.tk_kel,a.tk_has,a.lokasi,a.waktu_giat,a.sasaran_giat FROM trskpd_blud a 
                INNER JOIN m_giat_blud c ON a.kd_kegiatan1=c.KD_KEGIATAN
                INNER JOIN trdrka_blud d ON a.kd_kegiatan=d.kd_kegiatan
                INNER JOIN ms_skpd_blud e ON a.kd_skpd=e.kd_skpd
                INNER JOIN ms_urusan_blud f ON a.kd_urusan=f.kd_urusan where a.kd_kegiatan='$giat' and a.kd_skpd='$id'
                GROUP BY f.kd_urusan,
				f.nm_urusan,
				a.kd_skpd,
				e.nm_skpd,
				a.kd_program,
				a.nm_program,
				a.kd_kegiatan,
				c.nm_kegiatan,
				a.tu_capai,
				a.tu_mas,
				a.tu_kel,
				a.tu_has,
				a.tk_capai,
				a.tk_mas,
				a.tk_kel,
				a.tk_has,
				a.lokasi,
				a.waktu_giat,
				a.sasaran_giat";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $roworg)
                {
                    $kd_urusan=$roworg->kd_urusan;                    
                    $nm_urusan	= $roworg->nm_urusan;
                    $kd_skpd  	= $roworg->kd_skpd;
                    $nm_skpd  	= $roworg->nm_skpd;
                    $kd_prog  	= $roworg->kd_program;
                    $nm_prog  	= $roworg->nm_program;
                    $kd_giat  	= $roworg->kd_kegiatan;
                    $nm_giat_blud  	= $roworg->nm_kegiatan;
                    $lokasi  	= $roworg->lokasi;
                    $waktu_giat = $roworg->waktu_giat;
                    $tu_capai  	= $roworg->tu_capai;
                    $tu_mas  	= $roworg->tu_mas;
                    $tu_kel  	= $roworg->tu_kel;
                    $tu_has  	= $roworg->tu_has;
                    $tk_capai  	= $roworg->tk_capai;
                    $tk_mas  	= $roworg->tk_mas;
                    $tk_kel  	= $roworg->tk_kel;
                    $tk_has  	= $roworg->tk_has;
                    $sas_giat 	= $roworg->sasaran_giat;
                }
		$kd_urusan= empty($roworg->kd_urusan) || ($roworg->kd_urusan) == '' ? '' : ($roworg->kd_urusan);
		$nm_urusan= empty($roworg->nm_urusan) || ($roworg->nm_urusan) == '' ? '' : ($roworg->nm_urusan);
		$kd_skpd= empty($roworg->kd_skpd) || ($roworg->kd_skpd) == '' ? '' : ($roworg->kd_skpd);
		$nm_skpd= empty($roworg->nm_skpd) || ($roworg->nm_skpd) == '' ? '' : ($roworg->nm_skpd);
		$kd_prog= empty($roworg->kd_program) || ($roworg->kd_program) == '' ? '' : ($roworg->kd_program);
		$nm_prog= empty($roworg->nm_program) || ($roworg->nm_program) == '' ? '' : ($roworg->nm_program);
		$kd_giat= empty($roworg->kd_kegiatan) || ($roworg->kd_kegiatan) == '' ? '' : ($roworg->kd_kegiatan);
		$nm_giat_blud= empty($roworg->nm_kegiatan) || ($roworg->nm_kegiatan) == '' ? '' : ($roworg->nm_kegiatan);
		$lokasi= empty($roworg->lokasi) || ($roworg->lokasi) == '' ? '' : ($roworg->lokasi);
		$waktu_giat= empty($roworg->waktu_giat) || ($roworg->waktu_giat) == '' ? '' : ($roworg->waktu_giat);
		$tu_capai= empty($roworg->tu_capai) || ($roworg->tu_capai) == '' ? '' : ($roworg->tu_capai);
		$tu_mas= empty($roworg->tu_mas) || ($roworg->tu_mas) == '' ? '' : ($roworg->tu_mas);
		$tu_kel= empty($roworg->tu_kel) || ($roworg->tu_kel) == '' ? '' : ($roworg->tu_kel);
		$tu_has= empty($roworg->tu_has) || ($roworg->tu_has) == '' ? '' : ($roworg->tu_has);
		$tk_capai= empty($roworg->tk_capai) || ($roworg->tk_capai) == '' ? '' : ($roworg->tk_capai);
		$tk_mas= empty($roworg->tk_mas) || ($roworg->tk_mas) == '' ? '' : ($roworg->tk_mas);
		$tk_kel= empty($roworg->tk_kel) || ($roworg->tk_kel) == '' ? '' : ($roworg->tk_kel);
		$tk_has= empty($roworg->tk_has) || ($roworg->tk_has) == '' ? '' : ($roworg->tk_has);
		$sas_giat= empty($roworg->sasaran_giat) || ($roworg->sasaran_giat) == '' ? '' : ($roworg->sasaran_giat);

        $sqltp="SELECT SUM(nilai) AS totb FROM trdrka_blud WHERE kd_kegiatan='$giat' AND kd_skpd='$id'";
                 $sqlb=$this->db->query($sqltp);
                 foreach ($sqlb->result() as $rowb)
                {
                   $totp  =number_format($rowb->totb,"2",".",",");
                   $totp1 =number_format($rowb->totb*1.1,"2",".",",");
                }
                
        
        $cRet='';
        $cRet .="<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr> 
                         <td width=\"90%\" align=\"center\"><strong>RENCANA BISNIS DAN ANGGARAN SATUAN KERJA PERANGKAT DAERAH</strong></td>
                         <td width=\"10%\" rowspan=\"3\" align=\"center\"><strong>FORMULIR <BR> RBA BLUD </strong></td>
                    </tr>
                    
                    <tr>
                         <td align=\"center\"><strong> $kab</strong> </td>
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>TAHUN ANGGARAN $thn</strong></td>
                    </tr>

                  </table>";
         $cRet .="<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Urusan Pemerintahan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_urusan - $nm_urusan</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Organisasi</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_skpd   - $nm_skpd</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Program</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_prog   - $nm_prog</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Kegiatan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_giat   - $nm_giat_blud</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Waktu Pelaksanaan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$waktu_giat</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Lokasi Kegiatan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$lokasi</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"left\" border=\"1\">";
        $cRet .= "<tr>
                    <td colspan=\"3\" align=\"center\"><b>Indikator & Tolak Ukur Kinerja Belanja langsung</b></td>
                 </tr>";
		$cRet .="<tr>
                 <td width=\"20%\" align=\"center\"><b>Indikator</b></td>
                 <td width=\"60%\" align=\"center\"><b>Tolak Ukur Kerja</b></td>
                 <td width=\"20%\" align=\"center\"><b>Target Kinerja</b></td>
                </tr>";		  
        $cRet .=" <tr align=\"center\">
                    <td width=\"20%\">Capaian Program </td>
                    <td width=\"60%\">$tu_capai</td>
                    <td width=\"20%\">$tk_capai</td>
                 </tr>";
        $cRet .=" <tr align=\"center\">
                    <td width=\"20%\">Masukan </td>
                    <td width=\"60%\">$tu_mas</td>
                    <td width=\"20%\">Rp. $totp </td>
                </tr>";
        $cRet .=" <tr align=\"center\">
                    <td width=\"20%\">Keluaran </td>
                    <td width=\"60%\">$tu_kel</td>
                    <td width=\"20%\">$tk_kel</td>
                  </tr>";
        $cRet .=" <tr align=\"center\">
                    <td width=\"20%\">Hasil </td>
                    <td width=\"60%\">$tu_has</td>
                    <td width=\"20%\" >$tk_has</td>
                  </tr>";
        $cRet .= "<tr>
                    <td colspan=\"3\"  width=\"100%\" align=\"left\">Kelompok Sasaran Kegiatan : $sas_giat</td>
                </tr>";
        
        $cRet .= "<tr>
                        <td colspan=\"3\" align=\"center\">RINCIAN ANGGARAN BELANJA LANGSUNG <br>PROGRAM DAN PERKEGIATAN SATUAN KERJA PERANGKAT DAERAH</td>
                  </tr>";
                    
        $cRet .="</table>";
		
        $cRet .= "<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
					<thead> 
                        <tr><td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>Kode Rekening</b></td>                            
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>Uraian</b></td>
                            <td colspan=\"3\" bgcolor=\"#CCCCCC\" width=\"30%\" align=\"center\"><b>Rincian Perhitungan</b></td>
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Jumlah(Rp.)</b></td></tr>
                        <tr>
 		                    <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\">Volume</td>
                            <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\">Satuan</td>
                            <td width=\"14%\" bgcolor=\"#CCCCCC\" align=\"center\">harga</td>
                        </tr>    
                     
						</thead>
                     
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10%\" align=\"center\">&nbsp; </td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"8%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"8%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"14%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td></tr>
                        ";
                 $sql1="SELECT * FROM(SELECT 0 header,0 no_po, LEFT(a.kd_rek5,1)AS rek1,LEFT(a.kd_rek5,1)AS rek,b.nm_rek1 AS nama ,0 AS volume,' 'AS satuan,
						0 AS harga,SUM(a.nilai) AS nilai,'1' AS id FROM trdrka_blud a INNER JOIN ms_rek1 b ON LEFT(a.kd_rek5,1)=b.kd_rek1 WHERE a.kd_kegiatan='$giat' AND a.kd_skpd='$id' 
						GROUP BY LEFT(a.kd_rek5,1),nm_rek1 
						 UNION ALL 
						 SELECT 0 header, 0 no_po,LEFT(a.kd_rek5,2) AS rek1,LEFT(a.kd_rek5,2) AS rek,b.nm_rek2 AS nama,0 AS volume,' 'AS satuan,
						0 AS harga,SUM(a.nilai) AS nilai,'2' AS id FROM trdrka_blud a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek5,2)=b.kd_rek2 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek5,2),nm_rek2 
						 UNION ALL  
						 SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,3) AS rek1,LEFT(a.kd_rek5,3) AS rek,b.nm_rek3 AS nama,0 AS volume,' 'AS satuan,
						0 AS harga,SUM(a.nilai) AS nilai,'3' AS id FROM trdrka_blud a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek5,3)=b.kd_rek3 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek5,3),nm_rek3 
						 UNION ALL 
						 SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,5) AS rek1,LEFT(a.kd_rek5,5) AS rek,b.nm_rek4 AS nama,0 AS volume,' 'AS satuan,
						0 AS harga,SUM(a.nilai) AS nilai,'4' AS id FROM trdrka_blud a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek5,5)=b.kd_rek4 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek5,5),nm_rek4 
						 UNION ALL 
						 SELECT 0 header, 0 no_po, a.kd_rek5 AS rek1,RTRIM(a.kd_rek5) AS rek,b.nm_rek5 AS nama,0 AS volume,' 'AS satuan,
						0 AS harga,SUM(a.nilai) AS nilai,'5' AS id FROM trdrka_blud a INNER JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY a.kd_rek5,b.nm_rek5
						 UNION ALL 
						 SELECT * FROM (SELECT  b.header,b.no_po,RIGHT(a.no_trdrka,7) AS rek1,RIGHT(a.no_trdrka, 7)+c.plus_ang AS rek,b.uraian AS nama,0 AS volume,' ' AS satuan,
						0 AS harga,SUM(a.total) AS nilai,'6' AS id 
						FROM trdpo_blud a
						LEFT JOIN trdpo_blud b ON b.kode=a.kode AND b.header ='1' AND a.no_trdrka=b.no_trdrka
						left join ms_rek5_blud c on b.kd_rek5=c.kd_rek5
						WHERE LEFT(a.no_trdrka,$len_id)='$id' AND SUBSTRING(a.no_trdrka,12,$len_giat)='$giat'
						GROUP BY  RIGHT(a.no_trdrka,7),b.header,a.kd_rek5,b.no_po,b.uraian,c.plus_ang)z WHERE header='1'
						UNION ALL
						SELECT a. header,a.no_po,RIGHT(a.no_trdrka,7) AS rek1,' 'AS rek,a.uraian AS nama,a.volume1 AS volume,a.satuan1 AS satuan,
						a.harga1 AS harga,a.total AS nilai,'6' AS id FROM trdpo_blud a  WHERE LEFT(a.no_trdrka,$len_id)='$id' AND SUBSTRING(no_trdrka,12,$len_giat)='$giat' AND (header='0' or header is null)
						) a ORDER BY a.rek1,a.id,a.no_po";
                 
                $query = $this->db->query($sql1);

                foreach ($query->result() as $row)
                {
                    $rek=$row->rek;
                    $reke=$this->dotrek($rek);
                    $uraian=$row->nama;
                    $sat=$row->satuan;
                    $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                    $volum= empty($row->volume) || $row->volume == 0 ? '' :number_format($row->volume,2,',','.');
                    $nila= empty($row->nilai) || $row->nilai == 0 ? '' :number_format($row->nilai,2,',','.');
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"left\">$reke</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\">$volum</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\">$sat</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">$hrg</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nila</td></tr>
                                     ";
                }
                    $cRet .= "<tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
                                <td align=\"right\">&nbsp;</td>
                             </tr>";
                    $cRet    .=" <tr><td colspan =\"5\" style=\"vertical-align:top;\" align=\"right\"><b>JUMLAH</b></td>
                                <td style=\"vertical-align:top;\"  align=\"right\"><b>$totp</b></td></tr>";
				$cRet    .= "</table>";                            
        $cRet    .= "</table>";
		
		
		$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.',</TD>
					</TR>
                    <TR>
						<TD align="center" ></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><u></u> <br></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama.'</u> <br> '.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD align="center" ></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >NIP. '.$nip.'</TD>
					</TR>
					</TABLE><br/>';
		
		
        $data['prev']= $cRet;    
		$judul='RBA_'.$id.'';
             $this->rka_model->_mpdf('',$cRet,10,10,10,'0');
		/*switch($cetak) { 
        case 1;
             $this->_mpdf('',$cRet,10,10,10,'0');
        break;
		case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 0;  
		 echo ("<title>RKA 221</title>");
			echo($cRet);
        break;
        }*/
	}
	
	
	function preview_rba_ubah(){
        $id = $this->uri->segment(3);
        $giat = $this->uri->segment(4);
        $ttd1	= $this->uri->segment(5);
		 
		 $ttd1 = STR_REPLACE("%20"," ",$ttd1);
		//$tgl_ttd= $_REQUEST['tgl_ttd'];
		//$ttd1= $_REQUEST['ttd1'];
		//$ttd2= $_REQUEST['ttd2'];
		//$tanggal_ttd = $this->tanggal_format_indonesia($tgl_ttd);
        
		
		
		$len_id=strlen($id);
		$len_giat=strlen($giat);
		
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud where kd_skpd='$id'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                   
                    $tgl=$rowsc->tgl_rka;
                    //$tanggal = $this->tanggal_format_indonesia($tgl);
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                }
      $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd_blud WHERE left(kd_skpd,7)= left('$id',7) AND kode='PA' AND nip='$ttd1'  ";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip; 
                    $pangkat=$rowttd->pangkat;
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                }
		/*		
		$sqlttd2="SELECT nama as nm,nip as nip,jabatan as jab, pangkat as pangkat FROM ms_ttd WHERE left(kd_skpd,7)= left('$id',7) AND kode='PA' AND(REPLACE(nip, ' ', '')='$ttd2')  ";
                 $sqlttd2=$this->db->query($sqlttd2);
                 foreach ($sqlttd2->result() as $rowttd2)
                {
                    $nip2=$rowttd2->nip;
                    $pangkat2=$rowttd2->pangkat;
                    $nama2= $rowttd2->nm;
                    $jabatan2  = $rowttd2->jab;
                }
				*/
        $sqlorg="SELECT f.kd_urusan,f.nm_urusan,a.kd_skpd,e.nm_skpd,a.kd_program,a.nm_program,a.kd_kegiatan,c.nm_kegiatan,SUM(d.nilai) AS nilai,
				a.tu_capai,a.tu_mas,a.tu_kel,a.tu_has,a.tk_capai,a.tk_mas,a.tk_kel,a.tk_has,
				a.tu_capai_ubah,a.tu_mas_ubah,a.tu_kel_ubah,a.tu_has_ubah,a.tk_capai_ubah,a.tk_mas_ubah,a.tk_kel_ubah,a.tk_has_ubah,
				a.lokasi,a.sasaran_giat FROM trskpd_blud a 
                INNER JOIN m_giat_blud c ON a.kd_kegiatan1=c.KD_KEGIATAN
                INNER JOIN trdrka_blud d ON a.kd_kegiatan=d.kd_kegiatan
                INNER JOIN ms_skpd_blud e ON a.kd_skpd=e.kd_skpd
                INNER JOIN ms_urusan_blud f ON a.kd_urusan=f.kd_urusan where a.kd_kegiatan='$giat' and a.kd_skpd='$id'
                GROUP BY f.kd_urusan,
				f.nm_urusan,
				a.kd_skpd,
				e.nm_skpd,
				a.kd_program,
				a.nm_program,
				a.kd_kegiatan,
				c.nm_kegiatan,
				a.tu_capai,
				a.tu_mas,
				a.tu_kel,
				a.tu_has,
				a.tk_capai,
				a.tk_mas,
				a.tk_kel,
				a.tk_has,
				a.tu_capai_ubah,
				a.tu_mas_ubah,
				a.tu_kel_ubah,
				a.tu_has_ubah,
				a.tk_capai_ubah,
				a.tk_mas_ubah,
				a.tk_kel_ubah,
				a.tk_has_ubah,
				a.lokasi,
				a.sasaran_giat";
                 $sqlorg1=$this->db->query($sqlorg);
                 foreach ($sqlorg1->result() as $roworg)
                {
                    $kd_urusan=$roworg->kd_urusan;                    
                    $nm_urusan= $roworg->nm_urusan;
                    $kd_skpd  = $roworg->kd_skpd;
                    $nm_skpd  = $roworg->nm_skpd;
                    $kd_prog  = $roworg->kd_program;
                    $nm_prog  = $roworg->nm_program;
                    $kd_giat  = $roworg->kd_kegiatan;
                    $nm_giat_blud  = $roworg->nm_kegiatan;
                    $lokasi  = $roworg->lokasi;
                    $tu_capai  = $roworg->tu_capai;
                    $tu_mas  = $roworg->tu_mas;
                    $tu_kel  = $roworg->tu_kel;
                    $tu_has  = $roworg->tu_has;
                    $tk_capai  = $roworg->tk_capai;
                    $tk_mas  = $roworg->tk_mas;
                    $tk_kel  = $roworg->tk_kel;
                    $tk_has  = $roworg->tk_has;
                    $sas_giat = $roworg->sasaran_giat;
                }
		$kd_urusan= empty($roworg->kd_urusan) || ($roworg->kd_urusan) == '' ? '' : ($roworg->kd_urusan);
		$nm_urusan= empty($roworg->nm_urusan) || ($roworg->nm_urusan) == '' ? '' : ($roworg->nm_urusan);
		$kd_skpd= empty($roworg->kd_skpd) || ($roworg->kd_skpd) == '' ? '' : ($roworg->kd_skpd);
		$nm_skpd= empty($roworg->nm_skpd) || ($roworg->nm_skpd) == '' ? '' : ($roworg->nm_skpd);
		$kd_prog= empty($roworg->kd_program) || ($roworg->kd_program) == '' ? '' : ($roworg->kd_program);
		$nm_prog= empty($roworg->nm_program) || ($roworg->nm_program) == '' ? '' : ($roworg->nm_program);
		$kd_giat= empty($roworg->kd_kegiatan) || ($roworg->kd_kegiatan) == '' ? '' : ($roworg->kd_kegiatan);
		$nm_giat_blud= empty($roworg->nm_kegiatan) || ($roworg->nm_kegiatan) == '' ? '' : ($roworg->nm_kegiatan);
		$lokasi= empty($roworg->lokasi) || ($roworg->lokasi) == '' ? '' : ($roworg->lokasi);
		$tu_capai= empty($roworg->tu_capai) || ($roworg->tu_capai) == '' ? '' : ($roworg->tu_capai);
		$tu_mas= empty($roworg->tu_mas) || ($roworg->tu_mas) == '' ? '' : ($roworg->tu_mas);
		$tu_kel= empty($roworg->tu_kel) || ($roworg->tu_kel) == '' ? '' : ($roworg->tu_kel);
		$tu_has= empty($roworg->tu_has) || ($roworg->tu_has) == '' ? '' : ($roworg->tu_has);
		$tk_capai= empty($roworg->tk_capai) || ($roworg->tk_capai) == '' ? '' : ($roworg->tk_capai);
		$tk_mas= empty($roworg->tk_mas) || ($roworg->tk_mas) == '' ? '' : ($roworg->tk_mas);
		$tk_kel= empty($roworg->tk_kel) || ($roworg->tk_kel) == '' ? '' : ($roworg->tk_kel);
		$tk_has= empty($roworg->tk_has) || ($roworg->tk_has) == '' ? '' : ($roworg->tk_has);
		$tu_capai_ubah= empty($roworg->tu_capai_ubah) || ($roworg->tu_capai_ubah) == '' ? '' : ($roworg->tu_capai_ubah);
		$tu_mas_ubah= empty($roworg->tu_mas_ubah) || ($roworg->tu_mas_ubah) == '' ? '' : ($roworg->tu_mas_ubah);
		$tu_kel_ubah= empty($roworg->tu_kel_ubah) || ($roworg->tu_kel_ubah) == '' ? '' : ($roworg->tu_kel_ubah);
		$tu_has_ubah= empty($roworg->tu_has_ubah) || ($roworg->tu_has_ubah) == '' ? '' : ($roworg->tu_has_ubah);
		$tk_capai_ubah= empty($roworg->tk_capai_ubah) || ($roworg->tk_capai_ubah) == '' ? '' : ($roworg->tk_capai_ubah);
		$tk_mas_ubah= empty($roworg->tk_mas_ubah) || ($roworg->tk_mas_ubah) == '' ? '' : ($roworg->tk_mas_ubah);
		$tk_kel_ubah= empty($roworg->tk_kel_ubah) || ($roworg->tk_kel_ubah) == '' ? '' : ($roworg->tk_kel_ubah);
		$tk_has_ubah= empty($roworg->tk_has_ubah) || ($roworg->tk_has_ubah) == '' ? '' : ($roworg->tk_has_ubah);
		$sas_giat= empty($roworg->sasaran_giat) || ($roworg->sasaran_giat) == '' ? '' : ($roworg->sasaran_giat);

        $sqltp="SELECT SUM(nilai) AS totb,SUM(nilai_ubah) AS totb_ubah FROM trdrka_blud WHERE kd_kegiatan='$giat' AND kd_skpd='$id'";
                 $sqlb=$this->db->query($sqltp);
                 foreach ($sqlb->result() as $rowb)
                {
                   $totp  =number_format($rowb->totb,"2",".",",");
                   $totp_ubah  =number_format($rowb->totb_ubah,"2",".",",");
                   $totp1 =number_format($rowb->totb*1.1,"2",".",",");
                }
                
        
        $cRet='';
        $cRet .="<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr> 
                         <td width=\"90%\" align=\"center\"><strong>RENCANA BISNIS DAN ANGGARAN PERUBAHAN SATUAN KERJA PERANGKAT DAERAH</strong></td>
                         <td width=\"10%\" rowspan=\"3\" align=\"center\"><strong>FORMULIR <BR> RBA BLUD</strong></td>
                    </tr>
                    
                    <tr>
                         <td align=\"center\"><strong> $kab</strong> </td>
                    </tr>
                    <tr>
                         <td align=\"center\"><strong>TAHUN ANGGARAN $thn</strong></td>
                    </tr>

                  </table>";
         $cRet .="<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td width=\"20%\" align=\"left\">&nbsp;Urusan Pemerintahan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_urusan - $nm_urusan</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Organisasi</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_skpd   - $nm_skpd</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Program</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_prog   - $nm_prog</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Kegiatan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$kd_giat   - $nm_giat_blud</td></tr>
						<tr><td width=\"20%\" align=\"left\">&nbsp;Lokasi Kegiatan</td>
						<td width=\"5%\" align=\"center\">:</td>
						<td width=\"80%\" align=\"left\">$lokasi</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"left\" border=\"1\">";
        $cRet .= "<tr>
                    <td colspan=\"5\" align=\"center\"><b>Indikator & Tolak Ukur Kinerja Belanja langsung</b></td>
                 </tr>";
		$cRet .="<tr>
                 <td rowspan=\"2\" width=\"20%\" align=\"center\"><b>Indikator</b></td>
                 <td colspan=\"2\" width=\"20%\" align=\"center\"><b>Sebelum</b></td>
                 <td colspan=\"2\" width=\"20%\" align=\"center\"><b>Sesudah</b></td>
                </tr>
				<tr>
				<td width=\"20%\" align=\"center\"><b>Tolak Ukur Kerja</b></td>
                 <td width=\"20%\" align=\"center\"><b>Target Kinerja</b></td>
				 <td width=\"20%\" align=\"center\"><b>Tolak Ukur Kerja</b></td>
                 <td width=\"20%\" align=\"center\"><b>Target Kinerja</b></td>
				</tr>";		  
        $cRet .=" <tr align=\"center\">
                    <td>Capaian Program </td>
                    <td>$tu_capai</td>
                    <td>$tk_capai</td>
					<td>$tu_capai_ubah</td>
                    <td>$tk_capai_ubah</td>
                 </tr>";
        $cRet .=" <tr align=\"center\">
                    <td>Masukan </td>
                    <td>$tu_mas</td>
                    <td>Rp. $totp </td>
                    <td>$tu_mas_ubah</td>
                    <td>Rp. $totp_ubah </td>
                </tr>";
        $cRet .=" <tr align=\"center\">
                    <td>Keluaran </td>
                    <td>$tu_kel</td>
                    <td>$tk_kel</td>
                    <td>$tu_kel_ubah</td>
                    <td>$tk_kel_ubah</td>
                  </tr>";
        $cRet .=" <tr align=\"center\">
                    <td>Hasil </td>
                    <td>$tu_has</td>
                    <td>$tk_has</td>
                    <td>$tu_has_ubah</td>
                    <td>$tk_has_ubah</td>
                  </tr>";
        $cRet .= "<tr>
                    <td colspan=\"5\"  width=\"100%\" align=\"left\">Kelompok Sasaran Kegiatan : $sas_giat</td>
                </tr>";
        
        $cRet .= "<tr>
                        <td colspan=\"5\" align=\"center\">RINCIAN ANGGARAN BELANJA LANGSUNG <br>PROGRAM DAN PERKEGIATAN SATUAN KERJA PERANGKAT DAERAH</td>
                  </tr>";
                    
        $cRet .="</table>";
		
        $cRet .= "<table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
					<thead> 
                        <tr><td rowspan=\"3\" bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>Kode Rekening</b></td>                            
                            <td rowspan=\"3\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>Uraian</b></td>
                            <td colspan=\"4\" bgcolor=\"#CCCCCC\" width=\"50%\" align=\"center\"><b>Sebelum</b></td>
                            <td colspan=\"4\" bgcolor=\"#CCCCCC\" width=\"50%\" align=\"center\"><b>Sesudah</b></td>
						</tr>
						<tr>
                            <td colspan=\"3\" bgcolor=\"#CCCCCC\" width=\"30%\" align=\"center\"><b>Rincian Perhitungan</b></td>
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Jumlah(Rp.)</b></td>
							 <td colspan=\"3\" bgcolor=\"#CCCCCC\" width=\"30%\" align=\"center\"><b>Rincian Perhitungan</b></td>
                            <td rowspan=\"2\" bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>Jumlah(Rp.)</b></td>
						</tr>
                        <tr>
 		                    <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\">Volume</td>
                            <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\">Satuan</td>
                            <td width=\"14%\" bgcolor=\"#CCCCCC\" align=\"center\">harga</td>
							<td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\">Volume</td>
                            <td width=\"8%\" bgcolor=\"#CCCCCC\" align=\"center\">Satuan</td>
                            <td width=\"14%\" bgcolor=\"#CCCCCC\" align=\"center\">harga</td>
                        </tr> 
						  
						
						</thead>
                     
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10%\" align=\"center\">&nbsp; </td>                            
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"8%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"8%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"14%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td></tr>
                        ";
                 $sql1="SELECT * FROM(SELECT 0 header,0 no_po, LEFT(a.kd_rek5,1)AS rek1,LEFT(a.kd_rek5,1)AS rek,b.nm_rek1 AS nama ,
						0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai, 
						0 AS volume_ubah,' 'AS satuan_ubah, 0 AS harga_ubah,SUM(a.nilai_ubah) AS nilai_ubah, 
						'1' AS id FROM trdrka_blud a INNER JOIN ms_rek1 b ON LEFT(a.kd_rek5,1)=b.kd_rek1 WHERE a.kd_kegiatan='$giat' AND a.kd_skpd='$id' 
						GROUP BY LEFT(a.kd_rek5,1),nm_rek1 
						 UNION ALL 
						 SELECT 0 header, 0 no_po,LEFT(a.kd_rek5,2) AS rek1,LEFT(a.kd_rek5,2) AS rek,b.nm_rek2 AS nama,
						 0 AS volume,' 'AS satuan,0 AS harga,SUM(a.nilai) AS nilai,
						 0 AS volume_ubah,' 'AS satuan_ubah, 0 AS harga_ubah,SUM(a.nilai_ubah) AS nilai_ubah, 
						 '2' AS id FROM trdrka_blud a INNER JOIN ms_rek2 b ON LEFT(a.kd_rek5,2)=b.kd_rek2 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek5,2),nm_rek2 
						 UNION ALL  
						 SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,3) AS rek1,LEFT(a.kd_rek5,3) AS rek,b.nm_rek3 AS nama,
						 0 AS volume, ' 'AS satuan,	0 AS harga,SUM(a.nilai) AS nilai,
						 0 AS volume_ubah,' 'AS satuan_ubah, 0 AS harga_ubah,SUM(a.nilai_ubah) AS nilai_ubah, 
						 '3' AS id FROM trdrka_blud a INNER JOIN ms_rek3 b ON LEFT(a.kd_rek5,3)=b.kd_rek3 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek5,3),nm_rek3 
						 UNION ALL 
						 SELECT 0 header, 0 no_po, LEFT(a.kd_rek5,5) AS rek1,LEFT(a.kd_rek5,5) AS rek,b.nm_rek4 AS nama,
						 0 AS volume,' 'AS satuan,0 AS harga,SUM(a.nilai) AS nilai,
						0 AS volume_ubah,' 'AS satuan_ubah, 0 AS harga_ubah,SUM(a.nilai_ubah) AS nilai_ubah, 
						 '4' AS id FROM trdrka_blud a INNER JOIN ms_rek4 b ON LEFT(a.kd_rek5,5)=b.kd_rek4 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY LEFT(a.kd_rek5,5),nm_rek4 
						 UNION ALL 
						 SELECT 0 header, 0 no_po, a.kd_rek5 AS rek1,RTRIM(a.kd_rek5) AS rek,b.nm_rek5 AS nama,
						 0 AS volume,' 'AS satuan, 0 AS harga,SUM(a.nilai) AS nilai,
						0 AS volume_ubah,' 'AS satuan_ubah, 0 AS harga_ubah,SUM(a.nilai_ubah) AS nilai_ubah, 
						 '5' AS id FROM trdrka_blud a INNER JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5 WHERE a.kd_kegiatan='$giat'
						AND a.kd_skpd='$id'  GROUP BY a.kd_rek5,b.nm_rek5
						 UNION ALL 
						 SELECT * FROM (SELECT  b.header,b.no_po,RIGHT(a.no_trdrka,7) AS rek1,RIGHT(a.no_trdrka, 7)+c.plus_ang AS rek,b.uraian AS nama,
						 0 AS volume,' ' AS satuan,	0 AS harga,SUM(a.total) AS nilai,
						0 AS volume_ubah,' 'AS satuan_ubah, 0 AS harga_ubah,SUM(a.total_ubah) AS nilai_ubah, '6' AS id 
						FROM trdpo_blud a
						LEFT JOIN trdpo_blud b ON b.kode=a.kode AND b.header ='1' AND a.no_trdrka=b.no_trdrka
						left join ms_rek5_blud c on b.kd_rek5=c.kd_rek5
						WHERE LEFT(a.no_trdrka,$len_id)='$id' AND SUBSTRING(a.no_trdrka,12,$len_giat)='$giat'
						GROUP BY  RIGHT(a.no_trdrka,7),b.header,a.kd_rek5,b.no_po,b.uraian,c.plus_ang)z WHERE header='1'
						UNION ALL
						SELECT a. header,a.no_po,RIGHT(a.no_trdrka,7) AS rek1,' 'AS rek,a.uraian AS nama,
						a.volume1 AS volume,a.satuan1 AS satuan, a.harga1 AS harga,a.total AS nilai,
						a.volume_ubah1 AS volume_ubah,a.satuan_ubah1 AS satuan_ubah, a.harga_ubah1 AS harga_ubah,a.total_ubah AS nilai_ubah,
						'6' AS id FROM trdpo_blud a  WHERE LEFT(a.no_trdrka,$len_id)='$id' AND SUBSTRING(no_trdrka,12,$len_giat)='$giat' AND (header='0' or header is null)
						) a ORDER BY a.rek1,a.id,a.no_po";
                 
                $query = $this->db->query($sql1);

                foreach ($query->result() as $row)
                {
                    $rek=$row->rek;
                    $reke=$this->dotrek($rek);
                    $uraian=$row->nama;
                    $sat=$row->satuan;
                    $sat_ubah=$row->satuan_ubah;
                    $hrg= empty($row->harga) || $row->harga == 0 ? '' :number_format($row->harga,2,',','.');
                    $volum= empty($row->volume) || $row->volume == 0 ? '' :number_format($row->volume,2,',','.');
                    $nila= empty($row->nilai) || $row->nilai == 0 ? '' :number_format($row->nilai,2,',','.');
                    $hrg_ubah= empty($row->harga_ubah) || $row->harga_ubah == 0 ? '' :number_format($row->harga_ubah,2,',','.');
                    $volum_ubah= empty($row->volume_ubah) || $row->volume_ubah == 0 ? '' :number_format($row->volume_ubah,2,',','.');
                    $nila_ubah= empty($row->nilai_ubah) || $row->nilai_ubah == 0 ? '' :number_format($row->nilai_ubah,2,',','.');
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\" align=\"left\">$reke</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\">$volum</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\">$sat</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">$hrg</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nila</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"right\">$volum_ubah</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"8%\" align=\"center\">$sat_ubah</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"14%\" align=\"right\">$hrg_ubah</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nila_ubah</td></tr>
                                     ";
                }
                    $cRet .= "<tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
				                <td>&nbsp;</td>
                                <td align=\"right\">&nbsp;</td>
                             </tr>";
                    $cRet    .=" <tr><td colspan =\"5\" style=\"vertical-align:top;\" align=\"right\"><b>JUMLAH</b></td>
                                <td style=\"vertical-align:top;\"  align=\"right\"><b>$totp</b></td>
                                <td style=\"vertical-align:top;\"  align=\"right\"><b></b></td>
                                <td style=\"vertical-align:top;\"  align=\"right\"><b></b></td>
                                <td style=\"vertical-align:top;\"  align=\"right\"><b></b></td>
                                <td style=\"vertical-align:top;\"  align=\"right\"><b>$totp_ubah</b></td>
								</tr>";
				$cRet    .= "</table>";                            
        $cRet    .= "</table>";
		
		$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.',</TD>
					</TR>
                    <TR>
						<TD align="center" ></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan.'</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><u></u> <br></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama.'</u> <br> '.$pangkat.'</TD>
					</TR>
                    <TR>
						<TD align="center" ></TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >NIP. '.$nip.'</TD>
					</TR>
					</TABLE><br/>';
		
		
        $data['prev']= $cRet;    
		$judul='RBA_'.$id.'';
             $this->rka_model->_mpdf('',$cRet,10,10,10,'L');
		/*switch($cetak) { 
        case 1;
             $this->_mpdf('',$cRet,10,10,10,'0');
        break;
		case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= $judul.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 3;     
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-word");
            header("Content-Disposition: attachment; filename= $judul.doc");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        case 0;  
		 echo ("<title>RKA 221</title>");
			echo($cRet);
        break;
        }*/
	}
	
	
	function cek_data_anggaran()
    {
        $data['page_title']= 'CEK RBA';
        $this->template->set('title', 'CEK RBA');   
        $this->template->load('template','anggaran/rka/cek_data_anggaran',$data) ; 
    }
	
	
	function preview_cetakan_cek_data_anggaran(){



        $cetak = $this->uri->segment(4);
        $data_ang = $this->uri->segment(5);

        $jdl='';
        if($data_ang=='1'){
            $jdl=' ';
        }else if($data_ang=='2'){
            $jdl=' PERGESERAN ';
        }else if($data_ang=='3'){
            $jdl=' PERUBAHAN ';
        }

        $cRet='';
       $Xret1 = '';
       $Xret1.="<table style=\"font-size:30px;border-left:solid 0px black;border-top:solid 0px black;border-right:solid 0px black;\" width=\"100%\" border=\"0\">
                    <tr>
                        <td align=\"center\" colspan=\"7\" style=\"font-size:22px;border: solid 0px white;\"><b>LAPORAN PERBANDINGAN<br>NILAI ANGGARAN $jdl DAN NILAI ANGGARAN KAS</b></td>                     
                    </tr>
                 </table>";

       $Xret2 = '';
       $Xret3 = ''; 
       
       $Xret2.="<table style=\"border-collapse:collapse;font-size:14px;border-left:solid 1px black;border-top:solid 1px black;border-right:solid 1px black;\" width=\"100%\" border=\"0\">
                    ";
       $Xret3.= " 
                 </table>";
            $cRet .= $Xret1.$Xret2.$Xret3; 
        
        
        $font = 11;
        $font1 = $font - 1;
        
        $cRet .= "<table style=\"border-collapse:collapse;vertical-align:middle;font-size:15 px;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">

                     <thead >                       
                        <tr>
                            <td bgcolor=\"#A9A9A9\" width=\"3%\" align=\"center \"><b>no</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"7%\" align=\"center \"><b>KODE</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"12%\" align=\"center \"><b>NAMA</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>B. PEGAWAI</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>B. PEGAWAI (RO)</b></td>
							<td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>SELISIH<br> B. PEGAWAI</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>B. BARANG JASA</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>B. BARANG JASA (RO)</b></td>
							<td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>SELISIH<br> B. BARANG JASA</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>B. MODAL</b></td>
                            <td bgcolor=\"#A9A9A9\" width=\"10%\" align=\"center\"><b>B. MODAL (RO)</b></td>
							<td bgcolor=\"#A9A9A9\" width=\"11%\" align=\"center\"><b>SELISIH<br> B. MODAL</b></td>
                         </tr>
                     </thead>
                     
                   
                        ";
           
        $stt='';
        if($data_ang=='1'){
            $stt='';
        }else if($data_ang=='2'){
            $stt='_sempurna';
        }else if($data_ang=='3'){
            $stt='_ubah';
        }

                $sql1="select z.kd_skpd,b.nm_skpd,sum(bp) bp,sum(bp_ro) bp_ro,sum(bbj) bbj,sum(bbj_ro) bbj_ro,
							sum(bm) bm,sum(bm_ro) bm_ro from(
							select kd_skpd, isnull(sum(bp),0) as bp,0 as bp_ro,isnull(sum(bbj),0) bbj
							, 0 as bbj_ro,
							isnull(sum(bm),0) bm, 0 as bm_ro
							
							from(
select kd_skpd, nm_skpd, case when kd_rek5='5210701' then sum(nilai) end as bp,
case when kd_rek5='5222601' then sum(nilai) end as bbj,
case when kd_rek5='5239201' then sum(nilai) end as bm from trdrka_blud
group by kd_skpd, nm_skpd,kd_rek5
)x
group by kd_skpd,nm_skpd
UNION
select kd_skpd, 0 as bp ,isnull(sum(bp),0) as bp_ro,
0 as bbj, isnull(sum(bbj),0) bbj_ro
, 0 as bm, isnull(sum(bm),0) bm_ro from(
select left(no_trdrka,10) as kd_skpd,  
case when right(no_trdrka,7)='5210701' then sum(total) end as bp,
case when right(no_trdrka,7)='5222601' then sum(total) end as bbj,
case when right(no_trdrka,7)='5239201' then sum(total) end as bm from trdpo_blud
group by left(no_trdrka,10),right(no_trdrka,7)
)x
group by kd_skpd
)z left join ms_skpd_blud b on z.kd_skpd = b.kd_skpd
where z.kd_skpd <> '1.02.01.00'
group by z.kd_skpd,b.nm_skpd
order by z.kd_skpd
  
                        ";
  

                
                $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                 $ii = 0;                
                foreach ($query->result() as $row)
                {
                    $kd_skpd=rtrim($row->kd_skpd);
                    $nm=rtrim($row->nm_skpd);
                    
					$bp=rtrim($row->bp);
					$nilai_bp = number_format($bp,2,',','.');
                    $bp_ro=($row->bp_ro);
                    $nilai_bp_ro = number_format($bp_ro,2,',','.');
					$sel_bp= $bp_ro - $bp;
					$sel_nilai_bp = number_format($sel_bp,2,',','.');
					
                    $bbj=($row->bbj);
                    $nilai_bbj = number_format($bbj,2,',','.');
					$bbj_ro=($row->bbj_ro);
                    $nilai_bbj_ro = number_format($bbj_ro,2,',','.');
					
					$sel_bbj= $bbj_ro - $bbj;
                    $sel_nilai_bbj = number_format($sel_bbj,2,',','.');
					
					
                    $bm=($row->bm);
                    $nilai_bm = number_format($bm,2,',','.');
					$bm_ro=($row->bm_ro);
                    $nilai_bm_ro = number_format($bm_ro,2,',','.');
					
					$sel_bm=$bm_ro-$bm;
                    $sel_nilai_bm = number_format($sel_bm,2,',','.');
                   
                    
                     $ii++;

                      $cRet    .= " <tr>
                                         <td align=\"center\" style=\"vertical-align:middle; \" >$ii</td>                                
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$kd_skpd</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$nm</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_bp</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_bp_ro</td>
										<td align=\"right\" style=\"vertical-align:middle; \" >$sel_nilai_bp</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_bbj</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_bbj_ro</td>
										<td align=\"right\" style=\"vertical-align:middle; \" >$sel_nilai_bbj</td>
                                        <td align=\"right\" style=\"vertical-align:middle; \" >$nilai_bm</td>
                                        <td align=\"center\" style=\"vertical-align:middle; \" >$nilai_bm_ro</td>
										<td align=\"right\" style=\"vertical-align:middle; \" >$sel_nilai_bm</td>
                                    </tr> 
                                   
                                    ";
    
                }

 
        $cRet .="</table>";
 
        $data['prev']= $cRet;    
        //$this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        switch($cetak) {
        case 0;
               echo ("<title>Lap Perbandingan Anggaran dan Realisasi</title>");
                echo($cRet);
  
 //           $this->template->load('template','anggaran/rka/perkadaII',$data);
        break;
        case 1;
             $this->_mpdf('',$cRet,10,10,10,'1');
        break;
        case 2;        
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= cek_anggaran.xls");
            $this->load->view('anggaran/rka/perkadaII', $data);
        break;
        
        }    
    }
//akhir cetakan
	
	
}
