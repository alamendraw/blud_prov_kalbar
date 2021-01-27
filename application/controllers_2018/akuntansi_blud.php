<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Akuntansi_Blud extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
  
	}
	
	function bulan() {
               
        for ($count = 1; $count <= 12; $count++)
        {
            $result[]= array(
                     'bln' => $count,
                     'nm_bulan' => $this->tukd_model->getBulan($count)
                     );    
        }
        
        echo json_encode($result);
    	
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
	
	
	function list_ttd() {
        $kd_skpd  = $this->session->userdata('kdskpd');
        $sql = "SELECT nip,nama,jabatan,kd_skpd FROM ms_ttd_blud where kd_skpd='$kd_skpd' and kode='PA'order by nama";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan'],
                        'kd_skpd' => $resulte['kd_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
	
	
	function skpd() {
        $id_user = $this->session->userdata('pcUser');
        $kd_skpd = $this->session->userdata('kdskpd');
		$id_group=$this->akuntansi_model->get_nama($id_user,'id_group','[user_blud]','id_user');
		$lccr = $this->input->post('q');
		
		if ($id_group=='3'){
            $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd_blud where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') order by kd_skpd ";
        }else{
            $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd_blud where kd_skpd='$kd_skpd'";
        }
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
            $query1->free_result();
    }
	
	function mapping(){
        $data['page_title']= 'POSTING JURNAL';
        $this->template->set('title', 'POSTING JURNAL');   
        $this->template->load('template','akuntansi/mapping',$data) ;	
	}
	
	function proses_mapping(){
		$user    = $this->session->userdata('pcNama');
		$skpd    = $this->session->userdata('kdskpd');
		$thn     = $this->session->userdata('pcThang');
		$this->db->query("exec jurnal_brewok_blud '$skpd','$user',$thn");	   
		echo '1';	
	}
	
	function proses_mapping_transfer(){
		$user    = $this->session->userdata('pcNama');
		$skpd    = $this->session->userdata('kdskpd');
		$thn     = $this->session->userdata('pcThang');
		$this->db->query("exec transfer_data_apbd '$skpd',$thn");	   
		echo '1';	
	}
	
	function jumum()
    {
        $data['page_title']= 'INPUT JURNAL UMUM';
        $this->template->set('title', 'INPUT JURNAL UMUM');   
        $this->template->load('template','akuntansi/jumum',$data) ; 
    }
	
    function load_ju() {
		$skpd     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $kriteria = $this->input->post('cari');
        $where ="AND tabel='1'";
        if ($kriteria <> ''){                               
            $where="AND tabel='1' and (upper(no_voucher) like upper('%$kriteria%') or tgl_voucher like '%$kriteria%' or upper(ket) like upper('%$kriteria%')) ";            
        }
        
        $sql = "SELECT count(*) as total from trhju_blud WHERE kd_skpd = '$skpd' $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result(); 
        
        $sql = " select top $rows * from trhju_blud  WHERE kd_skpd = '$skpd' $where and no_voucher not in (select top $offset no_voucher from trhju_blud  WHERE kd_skpd = '$skpd' $where order by tgl_voucher,no_voucher,kd_skpd) order by tgl_voucher,no_voucher,kd_skpd ";//limit $offset,$rows";
        $query1 = $this->db->query($sql);          
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $row[] = array(                        
                        'no_voucher'    => $resulte['no_voucher'],
                        'tgl_voucher'   => $resulte['tgl_voucher'],
                        'kd_skpd'       => $resulte['kd_skpd'],
                        'nm_skpd'        => $resulte['nm_skpd'],
                        'ket'           => trim($resulte['ket']),
                        'reev'           => trim($resulte['reev']),
                        'total_d'         => $resulte['total_d'],
                        'total_k'         => $resulte['total_k']                        				                        			
                        );
                        $ii++;
        }
        $result["rows"] = $row; 
        echo json_encode($result);
        $query1->free_result();                 	   
	}
    
    function load_dju(){
		$skpd     = $this->session->userdata('kdskpd');
        $nomor = $this->input->post('no');            
        $sql = "SELECT a.no_voucher,b.kd_kegiatan,b.nm_kegiatan,b.kd_rek5,b.map_real,case when rk='D' then b.nm_rek5 else SPACE(4)+b.nm_rek5 end AS nm_rek5,b.debet,b.kredit,b.rk,b.jns,b.pos FROM trhju_blud a INNER JOIN trdju_blud b ON a.no_voucher=b.no_voucher AND a.kd_skpd=b.kd_unit
		WHERE a.no_voucher='$nomor' AND a.kd_skpd = '$skpd'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(                                
                        'no_voucher'  => $resulte['no_voucher'],                      
                        'kd_kegiatan' => $resulte['kd_kegiatan'],
                        'nm_kegiatan' => $resulte['nm_kegiatan'],
                        'kd_rek5'     => $resulte['kd_rek5'],
                        'kd_rek_ang'     => $resulte['map_real'],
                        'nm_rek5'     => $resulte['nm_rek5'],
                        'debet'       => $resulte['debet'],
                        'kredit'      => $resulte['kredit'],
                        'rk'          => $resulte['rk'],   
                        'jns'         => $resulte['jns'],
                        'post'         => $resulte['pos']                                                                                                                                                          
                        );
                        $ii++;
        }           
        echo json_encode($result);
        $query1->free_result();
    }
    
    function load_ju_trskpd() {        
        $jenis =$this->input->post('jenis');
        $len = strlen($jenis);
        $giat =$this->input->post('giat');
        $cskpd = $this->input->post('kd');
        
        $jns_beban='';
        $cgiat = '';
        if ($jenis !=''){
            $jns_beban = "and left(a.kd_rek5,$len)='$jenis'";
        }
        if ($giat !=''){                               
            $cgiat = " and a.kd_kegiatan not in ($giat) ";
        }                
        $lccr = $this->input->post('q');        
        $sql = "SELECT distinct a.kd_kegiatan,a.nm_kegiatan,'' kd_program, '' as nm_program, 0 total FROM trdrka_blud a
                WHERE a.kd_skpd='$cskpd' $jns_beban $cgiat AND (UPPER(a.kd_kegiatan) LIKE UPPER('%$lccr%') OR UPPER(a.nm_kegiatan) LIKE UPPER('%$lccr%'))
				";                                              
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],  
                        'nm_kegiatan' => $resulte['nm_kegiatan'],
                        'kd_program' => $resulte['kd_program'],  
                        'nm_program' => $resulte['nm_program'],
                        'total'       => $resulte['total']        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
        $query1->free_result();    	   
	}

    function load_ju_rek() {     
        //$jenis = $this->uri->segment(3);
        $jenis  = $this->input->post('jenis');        
        $len    = strlen($jenis);        
        $giat   = $this->input->post('giat');  
        $kode   = $this->input->post('kd');       
        $rek    = $this->input->post('rek');        
        $lccr   = $this->input->post('q');    
        $lenrka = strlen($kode)+strlen($giat)+1;
        $titik	= ".";
            
        if ($rek !=''){
            //if($jenis == '7' || $jenis == '8'  ||  $jenis == '9'){
                //$notIn = " and kd_rek4 not in ($rek) " ;
            //}else{
            $notIn = " and a.kd_rek5 not in ($rek) " ;
            //}
        }else{
            $notIn  = "";
        }
        //echo $jenis;
        /*
        if ($jenis == '4'  ||  $jenis == '5'){
            $sql = "SELECT DISTINCT RIGHT(a.no_trdrka,7) kd_rek5, b.nm_rek5, b.kd_rek5 kd_rek64 FROM trdpo_blud a 
			INNER JOIN ms_rek5_blud b ON a.kd_rek5=b.kd_rek5
			WHERE LEFT(a.no_trdrka,$lenrka) = '$kode$titik$giat' 
			$notIn AND ( upper(b.kd_rek5) like upper('%$lccr%') or upper(b.nm_rek5) like upper('%$lccr%')) order by kd_rek5, kd_rek64";                    
        }
		else {
                           
            $sql = "SELECT kd_rek5, nm_rek5, kd_rek5 kd_rek64 FROM ms_rek5_blud a where left(kd_rek5,$len)='$jenis' $notIn AND ( upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) order by kd_rek5";
        }*/
		
		$sql = "SELECT kd_rek5, nm_rek5, kd_rek5 kd_rek64 FROM ms_rek5_blud a where left(kd_rek5,$len)='$jenis' $notIn AND ( upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) order by kd_rek5";
		
			
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(                          
                        'kd_rek5' => $resulte['kd_rek64'],  
                        'kd_rek_ang' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5']
                        );
                        $ii++;
        }                   
       echo json_encode($result);    
       $query1->free_result();       	   
	}
    
    function simpan_ju(){
        $tabel  = $this->input->post('tabel');
        $nomor  = $this->input->post('no');
        $tgl    = $this->input->post('tgl');
        $skpd   = $this->input->post('skpd');
        $nmskpd = $this->input->post('nmskpd');
        $ket    = $this->input->post('ket');
        $reev   = $this->input->post('reev');
        $total_d = $this->input->post('total_d');
        $total_k = $this->input->post('total_k');
        $csql    = $this->input->post('sql');
        
        $usernm     = $this->session->userdata('pcNama');    
        $update     = date('Y-m-d H:i:s');      
        $msg        = array();
						if ($tabel == 'trhju_blud') {
						$sql = "delete from trhju_blud where kd_skpd='$skpd' and no_voucher='$nomor'";
						$asg = $this->db->query($sql);
						$sql = "delete from trdju_blud where no_voucher='$nomor' and kd_unit='$skpd'";
						$asg = $this->db->query($sql);
						if ($asg){
							$sql = "insert into trhju_blud(no_voucher,tgl_voucher,ket,username,tgl_update,kd_skpd,nm_skpd,total_d,total_k,tabel,reev) 
									values('$nomor','$tgl','$ket','$usernm','$update','$skpd','$nmskpd','$total_d','$total_k','1','$reev')";
							$asg = $this->db->query($sql);
							if (!($asg)){
							   $msg = array('pesan'=>'0');
							   echo json_encode($msg);
								exit();
							} else {
								$msg = array('pesan'=>'1');
								echo json_encode($msg);
							}             
							} else {
							$msg = array('pesan'=>'0');
							echo json_encode($msg);
							exit();
							}
						}
            
						 else if ($tabel == 'trdju_blud') {
							
							// Simpan Detail //                       
								$sql = "delete from trdju_blud where no_voucher='$nomor' and kd_unit='$skpd'";
								$asg = $this->db->query($sql);
								if (!($asg)){
									$msg = array('pesan'=>'0');
									echo json_encode($msg);
									exit();
								}else{            
									$sql = "insert into trdju_blud(no_voucher,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,debet,kredit,rk,jns,kd_unit,pos,urut,map_real)"; 
					
									$asg = $this->db->query($sql.$csql);
									if (!($asg)){
									   $msg = array('pesan'=>'0');
										echo json_encode($msg);
										exit();
									}  else {
									   $msg = array('pesan'=>'1');
										echo json_encode($msg);
									}
								}                                                                 
						} 
				
    }
    
    function simpan_ju_edit(){
        $tabel  = $this->input->post('tabel');
        $nomor  = $this->input->post('no');
        $no_bku  = $this->input->post('no_bku');
        $tgl    = $this->input->post('tgl');
        $skpd   = $this->input->post('skpd');
        $nmskpd = $this->input->post('nmskpd');
        $ket    = $this->input->post('ket');
        $reev   = $this->input->post('reev');
        $total_d = $this->input->post('total_d');
        $total_k = $this->input->post('total_k');
        $csql    = $this->input->post('sql');
        
        $usernm     = $this->session->userdata('pcNama');    
        $update     = date('Y-m-d H:i:s');      
        $msg        = array();

	
       
						if ($tabel == 'trhju_blud') {
						$sql = "delete from trhju_blud where kd_skpd='$skpd' and no_voucher='$no_bku'";
						$asg = $this->db->query($sql);
						$sql = "delete from trdju_blud where no_voucher='$no_bku' and kd_unit='$skpd'";
						$asg = $this->db->query($sql);
						if ($asg){
							$sql = "insert into trhju_blud(no_voucher,tgl_voucher,ket,username,tgl_update,kd_skpd,nm_skpd,total_d,total_k,tabel,reev) 
									values('$nomor','$tgl','$ket','$usernm','$update','$skpd','$nmskpd','$total_d','$total_k','1','$reev')";
							$asg = $this->db->query($sql);
							if (!($asg)){
							   $msg = array('pesan'=>'0');
							   echo json_encode($msg);
								exit();
							} else {
								$msg = array('pesan'=>'1');
								echo json_encode($msg);
							}             
							} else {
							$msg = array('pesan'=>'0');
							echo json_encode($msg);
							exit();
							}
						}
            
						 else if ($tabel == 'trdju_blud') {
							
							// Simpan Detail //                       
								$sql = "delete from trdju_blud where no_voucher='$no_bku' and kd_unit='$skpd'";
								$asg = $this->db->query($sql);
								if (!($asg)){
									$msg = array('pesan'=>'0');
									echo json_encode($msg);
									exit();
								}else{            
									$sql = "insert into trdju_blud(no_voucher,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,debet,kredit,rk,jns,kd_unit,pos,urut,map_real)"; 
					
									$asg = $this->db->query($sql.$csql);
									if (!($asg)){
									   $msg = array('pesan'=>'0');
										echo json_encode($msg);
										exit();
									}  else {
									   $msg = array('pesan'=>'1');
										echo json_encode($msg);
									}
								}                                                                 
						} 
				
    }
    
	
    function hapus_ju(){
		$skpd     = $this->session->userdata('kdskpd');
        $nomor = $this->input->post('no');
        $msg = array();
        $sql = "delete from trdju_blud where no_voucher='$nomor' AND kd_unit='$skpd'";
        $asg = $this->db->query($sql);
        if ($asg){
            $sql = "delete from trhju_blud where no_voucher='$nomor' AND kd_skpd='$skpd'";
            $asg = $this->db->query($sql);
            if (!($asg)){
              $msg = array('pesan'=>'0');
              echo json_encode($msg);
               exit();
            } 
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            exit();
        }
        $msg = array('pesan'=>'1');
        echo json_encode($msg);
    }
	
	function jur_umum(){
        $data['page_title']= 'JURNAL APBD & BLUD';
        $this->template->set('title', 'JURNAL APBD & BLUD');
		
		$id_user     = $this->session->userdata('pcUser');
		$id_group=$this->akuntansi_model->get_nama($id_user,'id_group','[user_blud]','id_user');
		
		if ($id_group=='3'){					
		$this->template->load('template','akuntansi/jur_umum_all',$data) ;  
		}else{
		$this->template->load('template','akuntansi/jur_umum',$data) ;  
		} 
	
    } 
	
	function jur_umum_blud(){
        $data['page_title']= 'JURNAL BLUD';
        $this->template->set('title', 'JURNAL BLUD');   
        
		$id_user     = $this->session->userdata('pcUser');
		$id_group=$this->akuntansi_model->get_nama($id_user,'id_group','[user_blud]','id_user');
		
		if ($id_group=='3'){					
		$this->template->load('template','akuntansi/jur_umum_blud_all',$data) ; 
		}else{
		$this->template->load('template','akuntansi/jur_umum_blud',$data) ;  
		} 
		
    }
	
	function buku_besar(){
	
        $data['page_title']= 'BUKU BESAR APBD & BLUD';
        $this->template->set('title', 'BUKU BESAR APBD & BLUD');   
        
		$id_user     = $this->session->userdata('pcUser');
		$id_group=$this->akuntansi_model->get_nama($id_user,'id_group','[user_blud]','id_user');
		
		if ($id_group=='3'){					
		$this->template->load('template','akuntansi/bukubesar_all',$data) ;
		}else{
		$this->template->load('template','akuntansi/bukubesar',$data) ;
		} 
	
	}
	
	
	function buku_besar_blud(){
	
        $data['page_title']= 'BUKU BESAR BLUD';
        $this->template->set('title', 'BUKU BESAR BLUD');   	
		
		$id_user     = $this->session->userdata('pcUser');
		$id_group=$this->akuntansi_model->get_nama($id_user,'id_group','[user_blud]','id_user');
		
		if ($id_group=='3'){					
		$this->template->load('template','akuntansi/bukubesar_blud_all',$data) ; 
		}else{
		$this->template->load('template','akuntansi/bukubesar_blud',$data) ; 
		} 
		
	}
	
	
	function cetakbb_kelompok($dcetak='',/*$ttd='',*/$skpd='',$rek5='',$dcetak2='', $jenis=''){ //Henri_TB
        
		$thn_ang = $this->session->userdata('pcThang');
			$cRet ='<TABLE width="100%">
					<TR>
						<TD align="center" ><B>BUKU BESAR APBD DAN BLUD</B></TD>
					</TR>
					<TR>
						<TD align="center" ><B>'.strtoupper($this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd')).'</B></TD>
					</TR>
					<TR>
						<TD align="center" ><B></B></TD>
						<TD align="center" ><B></B></TD>
						<TD align="center" ><B></B></TD>
					</TR>
					</TABLE>';

			$cRet .='<TABLE width="100%">
					 <TR>
						<TD align="left" width="20%" >Rekening</TD>
						<TD align="left" width="80%" >: '.$rek5.' '.$this->tukd_model->get_nama($rek5,'nm_rek5','ms_rek5_blud','kd_rek5').'</TD>
					 </TR>
					 <TR>
						<TD align="left" width="20%" >Periode</TD>
						<TD align="left" width="80%" >: '.$this->tukd_model->tanggal_format_indonesia($dcetak).' s/d '.$this->tukd_model->tanggal_format_indonesia($dcetak2).'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse;" width="100%" align="center" border="1" cellspacing="0" cellpadding="4">
					 <THEAD>
					 <TR>
						<TD width="10%"  bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
                        <TD width="30%" bgcolor="#CCCCCC" align="center" >URAIAN</TD>
						<TD width="5%" bgcolor="#CCCCCC" align="center" >REF</TD>
						<TD width="15%" bgcolor="#CCCCCC" align="center" >DEBET</TD>
						<TD width="15%" bgcolor="#CCCCCC" align="center" >KREDIT</TD>
						<TD width="15%" bgcolor="#CCCCCC" align="center" >SALDO</TD>
					 </TR>
					 </THEAD>';
		
		if (substr($rek5,0,1)=='5'){
		$csql3 = "SELECT sum(a.debet) as debet,sum(a.kredit) as kredit FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' and b.tgl_voucher < '$dcetak'";
		} else {
        $csql3 = "SELECT sum(a.debet) as debet,sum(a.kredit) as kredit FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' and b.tgl_voucher < '$dcetak'";
		}
         
         $hasil = $this->db->query($csql3);
         $trh4 = $hasil->row(); 
         $awaldebet = $trh4->debet;
         $awalkredit = $trh4->kredit;
                    if ((substr($rek5,0,1)=='1') or (substr($rek5,0,1)=='5')){					
						$saldo=$awaldebet-$awalkredit;
					}else{
						$saldo=$awalkredit-$awaldebet;
					} 
                    if($saldo<0){
					$a='(';
					$saldo1=$saldo*-1;
					$b=')';
					} else{
					$a='';
					$saldo1=$saldo;
					$b='';	
					}
                    $cRet .='<TR>
								<TD width="10%" align="left" ></TD>
                                <TD width="30%" align="left" >saldo awal</TD>
								<TD width="5%" align="left" ></TD>
								<TD width="15%" align="right" ></TD>
								<TD width="15%" align="right" ></TD>
								<TD width="15%" align="right" >'.$a.''.number_format($saldo1,"2",",",".").''.$b.'</TD>
							 </TR>';	      
                
				$idx=1;
				
				if (substr($rek5,0,1)=='5'){
				$query = $this->db->query("SELECT a.kd_unit,a.kd_rek5,a.debet,a.kredit,b.tgl_voucher,b.ket,b.no_voucher FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' AND b.tgl_voucher>='$dcetak' AND b.tgl_voucher<='$dcetak2' 
										   order by tgl_voucher,no_voucher");
				} else {
				$query = $this->db->query("SELECT a.kd_unit,a.kd_rek5,a.debet,a.kredit,b.tgl_voucher,b.ket,b.no_voucher FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' AND b.tgl_voucher>='$dcetak' AND b.tgl_voucher<='$dcetak2' 
										   order by tgl_voucher,no_voucher");
				}
				
				if ($query->num_rows() > 0){
				$jdebet=0;
				$jkredit=0;
				foreach($query->result_array() as $res){
										
					$tgl_voucher=$res['tgl_voucher'];
					$ket=$res['ket'];
					$ref=$res['no_voucher'];
					$debet=$res['debet'];
					$kredit=$res['kredit'];
                    $unitt =$res['kd_unit'];
					$idx++;
					if($debet<0){
						$debet1=$debet*-1;
						$c='(';
						$d=')';
						}else{
						$c='';
						$d='';	
						$debet1=$debet;
						}
					if($kredit<0){
						$kredit1=$kredit*-1;
						$e='(';
						$f=')';
						}else{
						$e='';
						$f='';	
						$kredit1=$kredit;
						}	
					$saldo=$saldo;
					if ((substr($rek5,0,1)=='1') or (substr($rek5,0,1)=='5')){					
						$saldo=$saldo+$debet-$kredit;
					}else{
						$saldo=$saldo+$kredit-$debet;
					}
					if($saldo<0){
						$saldo1=$saldo*-1;
						$i='(';
						$j=')';
						}else{
						$saldo1=$saldo;
						$i='';
						$j='';	
						}
					$cRet .='<TR>
								<TD width="10%" align="left" >'.$this->tukd_model->tanggal_format_indonesia($tgl_voucher).'</TD>
                                <TD width="30%" align="left" >'.$ket.'</TD>
								<TD width="5%" align="left" >'.$ref.'</TD>
								<TD width="15%" align="right" >'.$c.''.number_format($debet1,"2",",",".").''.$d.'</TD>
								<TD width="15%" align="right" >'.$e.''.number_format($kredit1,"2",",",".").''.$f.'</TD>
								<TD width="15%" align="right" >'.$i.''.number_format($saldo1,"2",",",".").''.$j.'</TD>
							 </TR>';
							 
					$jdebet=$jdebet+$debet;
					$jkredit = $jkredit + $kredit;
	
				}
				if($jdebet<0){
						$jdebet1=$jdebet*-1;
						$k='(';
						$l=')';
						}else{
						$jdebet1=$jdebet;
						$k='';
						$l='';	
						}
				if($jkredit<0){
						$jkredit1=$jkredit*-1;
						$m='(';
						$n=')';
						}else{
						$jkredit1=$jkredit;
						$m='';
						$n='';	
						}
				
				$cRet .='<TR>
					<TD width="10%" align="left" ></TD>
					<TD width="30%" align="left" >JUMLAH</TD>
					<TD width="5%" align="left" ></TD>
					<TD width="15%" align="right" >'.$k.''.number_format($jdebet1,"2",",",".").''.$l.'</TD>
					<TD width="15%" align="right" >'.$m.''.number_format($jkredit1,"2",",",".").''.$n.'</TD>
					<TD width="15%" align="right" >'.$i.''.number_format($saldo1,"2",",",".").''.$j.'</TD>
				 </TR>';
				$cRet .='</TABLE>';				 
				} else{
				
				$cRet .='</TABLE>';
				}
			
			if($jenis == 1){
			echo '<title> Buku Besar Kelompok </title>';
			echo $cRet;
			}
			if($jenis ==2){
            $this->tukd_model->_mpdf('',$cRet,10,5,10,'0');	
			}
	}
	
	function rekening_blud_kelompok() {
        $lccr = $this->input->post('q');
		$skpd = $this->session->userdata('kdskpd');		
        $sql = " SELECT DISTINCT isnull(kd_rek5,'') kd_rek5 , isnull(nm_rek5,'') nm_rek5 FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd 
				 where kd_skpd='$skpd' and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) group by kd_rek5,nm_rek5 order by kd_rek5";
 
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],                   
                        );
                        $ii++;
        }
           
        echo json_encode($result);
	}
	
	function bukubesar_blud_blud(){
	
        $data['page_title']= 'CETAK BUKU BESAR BLUD';
        $this->template->set('title', 'BUKU BESAR BLUD');   
        $this->template->load('template','akuntansi/bukubesar_blud_blud',$data) ; 	
	
	}
	
	function cetakbb_kelompok_blud($dcetak='',/*$ttd='',*/$skpd='',$rek5='',$dcetak2='', $jenis=''){ //Henri_TB	
		
		$thn_ang = $this->session->userdata('pcThang');
			$cRet ='<TABLE width="100%">
					<TR>
						<TD align="center" ><B>BUKU BESAR BLUD</B></TD>
					</TR>
					<TR>
						<TD align="center" ><B>'.strtoupper($this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd')).'</B></TD>
					</TR>
					<TR>
						<TD align="center" ><B></B></TD>
						<TD align="center" ><B></B></TD>
						<TD align="center" ><B></B></TD>
					</TR>
					</TABLE>';

			$cRet .='<TABLE width="100%">
					 <TR>
						<TD align="left" width="20%" >Rekening</TD>
						<TD align="left" width="80%" >: '.$rek5.' '.$this->tukd_model->get_nama($rek5,'nm_rek5','ms_rek5_blud','kd_rek5').'</TD>
					 </TR>
					 <TR>
						<TD align="left" width="20%" >Periode</TD>
						<TD align="left" width="80%" >: '.$this->tukd_model->tanggal_format_indonesia($dcetak).' s/d '.$this->tukd_model->tanggal_format_indonesia($dcetak2).'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse;" width="100%" align="center" border="1" cellspacing="0" cellpadding="4">
					 <THEAD>
					 <TR>
						<TD width="10%"  bgcolor="#CCCCCC" align="center" >TANGGAL</TD>
                        <TD width="30%" bgcolor="#CCCCCC" align="center" >URAIAN</TD>
						<TD width="5%" bgcolor="#CCCCCC" align="center" >REF</TD>
						<TD width="15%" bgcolor="#CCCCCC" align="center" >DEBET</TD>
						<TD width="15%" bgcolor="#CCCCCC" align="center" >KREDIT</TD>
						<TD width="15%" bgcolor="#CCCCCC" align="center" >SALDO</TD>
					 </TR>
					 </THEAD>';
		
		if (substr($rek5,0,1)=='5'){
		$csql3 = "SELECT sum(a.debet) as debet,sum(a.kredit) as kredit FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' and b.tgl_voucher < '$dcetak' and reev in ('0','2')";
		} else {
        $csql3 = "SELECT sum(a.debet) as debet,sum(a.kredit) as kredit FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' and b.tgl_voucher < '$dcetak' and reev in ('0','2')";
		}
         
         $hasil = $this->db->query($csql3);
         $trh4 = $hasil->row(); 
         $awaldebet = $trh4->debet;
         $awalkredit = $trh4->kredit;
                    if ((substr($rek5,0,1)=='1') or (substr($rek5,0,1)=='5')){					
						$saldo=$awaldebet-$awalkredit;
					}else{
						$saldo=$awalkredit-$awaldebet;
					} 
                    if($saldo<0){
					$a='(';
					$saldo1=$saldo*-1;
					$b=')';
					} else{
					$a='';
					$saldo1=$saldo;
					$b='';	
					}
                    $cRet .='<TR>
								<TD width="10%" align="left" ></TD>
                                <TD width="30%" align="left" >saldo awal</TD>
								<TD width="5%" align="left" ></TD>
								<TD width="15%" align="right" ></TD>
								<TD width="15%" align="right" ></TD>
								<TD width="15%" align="right" >'.$a.''.number_format($saldo1,"2",",",".").''.$b.'</TD>
							 </TR>';	      
                
				$idx=1;
				
				if (substr($rek5,0,1)=='5'){
				$query = $this->db->query("SELECT a.kd_unit,a.kd_rek5,a.debet,a.kredit,b.tgl_voucher,b.ket,b.no_voucher FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' AND b.tgl_voucher>='$dcetak' AND b.tgl_voucher<='$dcetak2' and reev in ('0','2') 
										   order by tgl_voucher,no_voucher");
				} else {
				$query = $this->db->query("SELECT a.kd_unit,a.kd_rek5,a.debet,a.kredit,b.tgl_voucher,b.ket,b.no_voucher FROM trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher=b.no_voucher AND a.kd_unit=b.kd_skpd WHERE a.kd_rek5='$rek5' AND b.kd_skpd='$skpd' AND b.tgl_voucher>='$dcetak' AND b.tgl_voucher<='$dcetak2' and reev in ('0','2') 
										   order by tgl_voucher,no_voucher");
				}
				
				if ($query->num_rows() > 0){
				$jdebet=0;
				$jkredit=0;
				foreach($query->result_array() as $res){
										
					$tgl_voucher=$res['tgl_voucher'];
					$ket=$res['ket'];
					$ref=$res['no_voucher'];
					$debet=$res['debet'];
					$kredit=$res['kredit'];
                    $unitt =$res['kd_unit'];
					$idx++;
					if($debet<0){
						$debet1=$debet*-1;
						$c='(';
						$d=')';
						}else{
						$c='';
						$d='';	
						$debet1=$debet;
						}
					if($kredit<0){
						$kredit1=$kredit*-1;
						$e='(';
						$f=')';
						}else{
						$e='';
						$f='';	
						$kredit1=$kredit;
						}	
					$saldo=$saldo;
					if ((substr($rek5,0,1)=='1') or (substr($rek5,0,1)=='5')){					
						$saldo=$saldo+$debet-$kredit;
					}else{
						$saldo=$saldo+$kredit-$debet;
					}
					if($saldo<0){
						$saldo1=$saldo*-1;
						$i='(';
						$j=')';
						}else{
						$saldo1=$saldo;
						$i='';
						$j='';	
						}
					$cRet .='<TR>
								<TD width="10%" align="left" >'.$this->tukd_model->tanggal_format_indonesia($tgl_voucher).'</TD>
                                <TD width="30%" align="left" >'.$ket.'</TD>
								<TD width="5%" align="left" >'.$ref.'</TD>
								<TD width="15%" align="right" >'.$c.''.number_format($debet1,"2",",",".").''.$d.'</TD>
								<TD width="15%" align="right" >'.$e.''.number_format($kredit1,"2",",",".").''.$f.'</TD>
								<TD width="15%" align="right" >'.$i.''.number_format($saldo1,"2",",",".").''.$j.'</TD>
							 </TR>';
							 
					$jdebet=$jdebet+$debet;
					$jkredit = $jkredit + $kredit;
	
				}
				if($jdebet<0){
						$jdebet1=$jdebet*-1;
						$k='(';
						$l=')';
						}else{
						$jdebet1=$jdebet;
						$k='';
						$l='';	
						}
				if($jkredit<0){
						$jkredit1=$jkredit*-1;
						$m='(';
						$n=')';
						}else{
						$jkredit1=$jkredit;
						$m='';
						$n='';	
						}
				
				$cRet .='<TR>
					<TD width="10%" align="left" ></TD>
					<TD width="30%" align="left" >JUMLAH</TD>
					<TD width="5%" align="left" ></TD>
					<TD width="15%" align="right" >'.$k.''.number_format($jdebet1,"2",",",".").''.$l.'</TD>
					<TD width="15%" align="right" >'.$m.''.number_format($jkredit1,"2",",",".").''.$n.'</TD>
					<TD width="15%" align="right" >'.$i.''.number_format($saldo1,"2",",",".").''.$j.'</TD>
				 </TR>';
				$cRet .='</TABLE>';				 
				} else{
				
				$cRet .='</TABLE>';
				}
			
			if($jenis == 1){
			echo '<title> Buku Besar Kelompok BLUD</title>';
			echo $cRet;
			}
			if($jenis ==2){
            $this->tukd_model->_mpdf('',$cRet,10,5,10,'0');	
			}
	}
	
	function lap_lo_konsol($cbulan="", $pilih=1){// created by henri_tb
        $cetak='2';//$ctk;
        $id     	= $this->session->userdata('kdskpd');
		//$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
		
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
				
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
			
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN OPERASIONAL APBD DAN BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";

        $sqlmaplo="	select '1' bold, '4' kode, 'PENDAPATAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '41' kode, 'PENDAPATAN JASA LAYANAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '411' kode, 'Jasa Layanan Kesehatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411')
					union all
					select '4' bold, '412' kode, 'Penyesuaian Pendapatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('412')
					union all
					select '5' bold, '4129' kode, 'Jumlah Pendapatan Jasa Layanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411', '412')
					union all
					select '0' bold, '41299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '42' kode, 'PENDAPATAN HIBAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '421' kode, 'Hibah Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421')
					union all
					select '4' bold, '422' kode, 'Hibah Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('422')
					union all
					select '4' bold, '423' kode, 'Hibah Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('423')
					union all
					select '5' bold, '4239' kode, 'Jumlah Pendapatan Hibah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421','422','423')
					union all
					select '0' bold, '42399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '43' kode, 'HASIL KERJASAMA DENGAN PIHAK LAIN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '431' kode, 'Hasil Kerjasama Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431')
					union all
					select '4' bold, '432' kode, 'Pendapatan Sewa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('432')
					union all
					select '4' bold, '433' kode, 'Pendapatan Kerjasama Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('433')
					union all
					select '5' bold, '4339' kode, 'Jumlah Pendapatan Hasil Kerjasama' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431','432','433')
					union all
					select '0' bold, '43399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '44' kode, 'PENDAPATAN APBD' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '441' kode, 'APBD Kota Pontianak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441')
					union all
					select '4' bold, '442' kode, 'APBD Provinsi Kalimantan Barat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('442')
					union all
					select '4' bold, '443' kode, 'APBD Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('443')
					union all
					select '5' bold, '4439' kode, 'Jumlah Pendapatan APBD' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441','442','443')
					union all
					select '0' bold, '44399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '45' kode, 'PENDAPATAN APBN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '451' kode, 'APBN - Dana Dekonsentrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451')
					union all
					select '4' bold, '452' kode, 'APBN - Tugas Pembantuan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('452')
					union all
					select '4' bold, '453' kode, 'APBN - Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('453')
					union all
					select '5' bold, '4539' kode, 'Jumlah Pendapatan APBN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451','452','453')
					union all
					select '0' bold, '45399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '453999' kode, 'LAIN-LAIN PENDAPATAN BLUD YANG SAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '461' kode, 'Hasil Penjualan Kekayaan yang Tidak Dipisahkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461')
					union all
					select '4' bold, '462' kode, 'Hasil Pemanfaatan Kekayaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('462')
					union all
					select '4' bold, '463' kode, 'Jasa Giro' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('463')
					union all
					select '4' bold, '464' kode, 'Pendapatan Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('464')
					union all
					select '4' bold, '465' kode, 'Keuntungan Selisih Nilai Tukar Rupiah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('465')
					union all
					select '4' bold, '466' kode, 'Komisi dan Potongan Penjualan/Pengadaan Barang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('466')
					union all
					select '4' bold, '467' kode, 'Hasil Investasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('467')
					union all
					select '4' bold, '468' kode, 'Lain-lain Pendapatan BLUD yang Sah Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('468')
					union all
					select '5' bold, '4689' kode, 'Jumlah Lain-lain Pendapatan yang Sah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461','462','463','464','465','466','467','468')
					union all
					select '5' bold, '46899' kode, 'JUMLAH PENDAPATAN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4')
					union all
					select '0' bold, '468999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '5' kode, 'BIAYA' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '51' kode, 'BIAYA OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '511' kode, 'BIAYA PELAYANAN' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5111' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5111')
					union all
					select '4' bold, '5112' kode, 'Biaya Bahan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5112')
					union all
					select '4' bold, '5113' kode, 'Biaya Jasa Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5113')
					union all
					select '4' bold, '5114' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5114')
					union all
					select '4' bold, '5115' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5115')
					union all
					select '4' bold, '5116' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5116')
					union all
					select '4' bold, '5117' kode, 'Biaya Pelayanan Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5117')
					union all
					select '5' bold, '51179' kode, 'Jumlah Biaya Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('511')
					union all
					select '0' bold, '51179' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '512' kode, 'BIAYA UMUM DAN ADMINISTRASI' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5121' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5121')
					union all
					select '4' bold, '5122' kode, 'Biaya Administrasi Kantor' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5122')
					union all
					select '4' bold, '5123' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5123')
					union all
					select '4' bold, '5124' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5124')
					union all
					select '4' bold, '5125' kode, 'Biaya Promosi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5125')
					union all
					select '4' bold, '5126' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5126')
					union all
					select '4' bold, '5127' kode, 'Biaya Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5127')
					union all
					select '4' bold, '5128' kode, 'Biaya Umum dan Administrasi Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5128')
					union all
					select '5' bold, '51289' kode, 'Jumlah Biaya Umum dan Administrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('512')
					union all
					select '5' bold, '512899' kode, 'Jumlah Biaya Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,2) in ('51')
					union all
					select '0' bold, '5199999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '530' kode, 'BIAYA NON-OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5301' kode, 'Biaya Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5301')
					union all
					select '4' bold, '5302' kode, 'Biaya Administrasi Bank' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5302')
					union all
					select '4' bold, '5303' kode, 'Biaya Kerugian Penjualan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5303')
					union all
					select '4' bold, '5304' kode, 'Biaya Kerugian Penurunan Nilai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5304')
					union all
					select '4' bold, '5305' kode, 'Biaya Non-Operasional Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5305')
					union all
					select '5' bold, '53059' kode, 'Jumlah Biaya Non-Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('530')
					union all
					select '5' bold, '530599' kode, 'JUMLAH BIAYA' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,1) in ('5')
					union all
					select '0' bold, '5305999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '6' bold, '53059999' kode, 'JUMLAH SURPLUS/DEFISIT DARI OPERASI' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4','5')
					order by kode";
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    if ($nil < 0){
                    	$lo1="("; $nilaix=$nil*-1; $lo01=")";}
                    else {
                    	$lo1=""; $nilaix=$nil; $lo01="";}
                    $nilai = number_format($nilaix,"2",",",".");
					
					if ($nil_lalu < 0){
                    	$lo2="("; $nilai_lalux=$nil_lalu*-1; $lo02=")";}
                    else {
                    	$lo2=""; $nilai_lalux=$nil_lalu; $lo02="";}
                    $nilai_lalu = number_format($nilai_lalux,"2",",",".");
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
		
                    
		
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
		$oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LO Konsol / $cbulan");
        $this->template->set('title', 'LO Konsol / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LO Konsol / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	
	function lap_lo($cbulan="", $kdskpd="", $pilih=1){// created by henri_tb
        $cetak='2';//$ctk;
        //$id     	= $this->session->userdata('kdskpd');
		$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
		
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
		
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN OPERASIONAL APBD DAN BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";

        $sqlmaplo="	select '1' bold, '4' kode, 'PENDAPATAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '41' kode, 'PENDAPATAN JASA LAYANAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '411' kode, 'Jasa Layanan Kesehatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411')
					union all
					select '4' bold, '412' kode, 'Penyesuaian Pendapatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('412')
					union all
					select '5' bold, '4129' kode, 'Jumlah Pendapatan Jasa Layanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411', '412')
					union all
					select '0' bold, '41299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '42' kode, 'PENDAPATAN HIBAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '421' kode, 'Hibah Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421')
					union all
					select '4' bold, '422' kode, 'Hibah Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('422')
					union all
					select '4' bold, '423' kode, 'Hibah Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('423')
					union all
					select '5' bold, '4239' kode, 'Jumlah Pendapatan Hibah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421','422','423')
					union all
					select '0' bold, '42399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '43' kode, 'HASIL KERJASAMA DENGAN PIHAK LAIN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '431' kode, 'Hasil Kerjasama Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431')
					union all
					select '4' bold, '432' kode, 'Pendapatan Sewa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('432')
					union all
					select '4' bold, '433' kode, 'Pendapatan Kerjasama Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('433')
					union all
					select '5' bold, '4339' kode, 'Jumlah Pendapatan Hasil Kerjasama' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431','432','433')
					union all
					select '0' bold, '43399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '44' kode, 'PENDAPATAN APBD' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '441' kode, 'APBD Kota Pontianak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441')
					union all
					select '4' bold, '442' kode, 'APBD Provinsi Kalimantan Barat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('442')
					union all
					select '4' bold, '443' kode, 'APBD Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('443')
					union all
					select '5' bold, '4439' kode, 'Jumlah Pendapatan APBD' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441','442','443')
					union all
					select '0' bold, '44399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '45' kode, 'PENDAPATAN APBN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '451' kode, 'APBN - Dana Dekonsentrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451')
					union all
					select '4' bold, '452' kode, 'APBN - Tugas Pembantuan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('452')
					union all
					select '4' bold, '453' kode, 'APBN - Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('453')
					union all
					select '5' bold, '4539' kode, 'Jumlah Pendapatan APBN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451','452','453')
					union all
					select '0' bold, '45399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '453999' kode, 'LAIN-LAIN PENDAPATAN BLUD YANG SAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '461' kode, 'Hasil Penjualan Kekayaan yang Tidak Dipisahkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461')
					union all
					select '4' bold, '462' kode, 'Hasil Pemanfaatan Kekayaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('462')
					union all
					select '4' bold, '463' kode, 'Jasa Giro' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('463')
					union all
					select '4' bold, '464' kode, 'Pendapatan Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('464')
					union all
					select '4' bold, '465' kode, 'Keuntungan Selisih Nilai Tukar Rupiah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('465')
					union all
					select '4' bold, '466' kode, 'Komisi dan Potongan Penjualan/Pengadaan Barang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('466')
					union all
					select '4' bold, '467' kode, 'Hasil Investasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('467')
					union all
					select '4' bold, '468' kode, 'Lain-lain Pendapatan BLUD yang Sah Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('468')
					union all
					select '5' bold, '4689' kode, 'Jumlah Lain-lain Pendapatan yang Sah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461','462','463','464','465','466','467','468')
					union all
					select '5' bold, '46899' kode, 'JUMLAH PENDAPATAN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4')
					union all
					select '0' bold, '468999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '5' kode, 'BIAYA' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '51' kode, 'BIAYA OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '511' kode, 'BIAYA PELAYANAN' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5111' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5111')
					union all
					select '4' bold, '5112' kode, 'Biaya Bahan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5112')
					union all
					select '4' bold, '5113' kode, 'Biaya Jasa Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5113')
					union all
					select '4' bold, '5114' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5114')
					union all
					select '4' bold, '5115' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5115')
					union all
					select '4' bold, '5116' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5116')
					union all
					select '4' bold, '5117' kode, 'Biaya Pelayanan Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5117')
					union all
					select '5' bold, '51179' kode, 'Jumlah Biaya Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('511')
					union all
					select '0' bold, '51179' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '512' kode, 'BIAYA UMUM DAN ADMINISTRASI' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5121' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5121')
					union all
					select '4' bold, '5122' kode, 'Biaya Administrasi Kantor' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5122')
					union all
					select '4' bold, '5123' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5123')
					union all
					select '4' bold, '5124' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5124')
					union all
					select '4' bold, '5125' kode, 'Biaya Promosi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5125')
					union all
					select '4' bold, '5126' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5126')
					union all
					select '4' bold, '5127' kode, 'Biaya Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5127')
					union all
					select '4' bold, '5128' kode, 'Biaya Umum dan Administrasi Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5128')
					union all
					select '5' bold, '51289' kode, 'Jumlah Biaya Umum dan Administrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('512')
					union all
					select '5' bold, '512899' kode, 'Jumlah Biaya Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,2) in ('51')
					union all
					select '0' bold, '5199999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '530' kode, 'BIAYA NON-OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5301' kode, 'Biaya Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5301')
					union all
					select '4' bold, '5302' kode, 'Biaya Administrasi Bank' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5302')
					union all
					select '4' bold, '5303' kode, 'Biaya Kerugian Penjualan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5303')
					union all
					select '4' bold, '5304' kode, 'Biaya Kerugian Penurunan Nilai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5304')
					union all
					select '4' bold, '5305' kode, 'Biaya Non-Operasional Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5305')
					union all
					select '5' bold, '53059' kode, 'Jumlah Biaya Non-Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('530')
					union all
					select '5' bold, '530599' kode, 'JUMLAH BIAYA' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,1) in ('5')
					union all
					select '0' bold, '5305999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '6' bold, '53059999' kode, 'JUMLAH SURPLUS/DEFISIT DARI OPERASI' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4','5')
					order by kode";
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    if ($nil < 0){
                    	$lo1="("; $nilaix=$nil*-1; $lo01=")";}
                    else {
                    	$lo1=""; $nilaix=$nil; $lo01="";}
                    $nilai = number_format($nilaix,"2",",",".");
					
					if ($nil_lalu < 0){
                    	$lo2="("; $nilai_lalux=$nil_lalu*-1; $lo02=")";}
                    else {
                    	$lo2=""; $nilai_lalux=$nil_lalu; $lo02="";}
                    $nilai_lalu = number_format($nilai_lalux,"2",",",".");
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
		$oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LO $id / $cbulan");
        $this->template->set('title', 'LO $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LO $id / $cbulan</title>");
			 echo $cRet;
        break;
		case 0;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	function cetak_neraca(){
        $data['page_title']= 'NERACA APBD & BLUD';
        $this->template->set('title', 'NERACA APBD & BLUD');   
        $this->template->load('template','akuntansi/cetak_neraca',$data) ; 
    }
	
	function cetak_neraca_blud(){
        $data['page_title']= 'NERACA BLUD';
        $this->template->set('title', 'NERACA BLUD');   
        $this->template->load('template','akuntansi/cetak_neraca_blud',$data) ; 
    }
	
	function cetak_lak(){
        $data['page_title']= 'LAK APBD & BLUD';
        $this->template->set('title', 'LAK APBD & BLUD');   
        $this->template->load('template','akuntansi/cetak_lak',$data) ; 
    }
	
	function cetak_lak_blud(){
        $data['page_title']= 'LAK BLUD';
        $this->template->set('title', 'LAK BLUD');   
        $this->template->load('template','akuntansi/cetak_lak_blud',$data) ; 
    }
	
	
	function cetak_lo(){
        $data['page_title']= 'LO APBD & BLUD';
        $this->template->set('title', 'LO APBD & BLUD');   
        $this->template->load('template','akuntansi/cetak_lo',$data) ; 
    }
	
	function cetak_lo_blud(){
        $data['page_title']= 'LO BLUD';
        $this->template->set('title', 'LO BLUD');   
        $this->template->load('template','akuntansi/cetak_lo_blud',$data) ; 
    }
	
	function lap_neraca_konsol($cbulan="", $pilih=1){// created by henri_tb *koreksi galih
        $cetak		='2';//$ctk;
        $id     	= $this->session->userdata('kdskpd');
		//$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
		
			
					if($cbulan<10){
					 $xbulan="0$cbulan";
					 }
					else{
					$xbulan=$cbulan;
					}
	
		
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
		
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		

			
		$sqllo1="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('4') and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$cbulan' and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo1= $this->db->query($sqllo1);
                    $penlo = $querylo1->row();
                    $pen_lo = $penlo->nilai;
                    $pen_lo1= number_format($penlo->nilai,"2",",",".");
        
		$sqllo2="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('4') and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo2= $this->db->query($sqllo2);
                    $penlo2 = $querylo2->row();
                    $pen_lo_lalu = $penlo2->nilai;
                    $pen_lo_lalu1= number_format($penlo2->nilai,"2",",",".");
		
		$sqllo3="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('5') and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$cbulan' and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo3= $this->db->query($sqllo3);
                    $bello = $querylo3->row();
                    $bel_lo = $bello->nilai;
                    $bel_lo1= number_format($bello->nilai,"2",",",".");
        
		$sqllo4="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('5') and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo4= $this->db->query($sqllo4);
                    $bello2 = $querylo4->row();
                    $bel_lo_lalu = $bello2->nilai;
                    $bel_lo_lalu1= number_format($bello2->nilai,"2",",",".");		

					$surplus_lo = $pen_lo - $bel_lo;
                    if ($surplus_lo < 0){
                    	$lo1="("; $surplus_lox=$surplus_lo*-1; $lo2=")";}
                    else {
                    	$lo1=""; $surplus_lox=$surplus_lo; $lo2="";}		
                    $surplus_lo1 = number_format($surplus_lox,"2",",",".");
                    
					$surplus_lo_lalu = $pen_lo_lalu - $bel_lo_lalu;
                    if ($surplus_lo_lalu < 0){
                    	$lo3="("; $surplus_lo_lalux=$surplus_lo_lalu*-1; $lo4=")";}
                    else {
                    	$lo3=""; $surplus_lo_lalux=$surplus_lo_lalu; $lo4="";}						
                    $surplus_lo_lalu1 = number_format($surplus_lo_lalux,"2",",",".");

					$selisih_surplus_lo = $surplus_lo - $surplus_lo_lalu;
                    if ($selisih_surplus_lo < 0){
                    	$lo5="("; $selisih_surplus_lox=$selisih_surplus_lo*-1; $lo6=")";}
                    else {
                    	$lo5=""; $selisih_surplus_lox=$selisih_surplus_lo; $lo6="";}
                    $selisih_surplus_lo1 = number_format($selisih_surplus_lox,"2",",",".");
                    
					if( $surplus_lo_lalu=='' or $surplus_lo_lalu==0){
					$persen2 = '0,00';
					}else{
					$persen2 = ($surplus_lo/$surplus_lo_lalu)*100;
					$persen2 = number_format($persen2,"2",",",".");
					}
					
		
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td rowspan=\"5\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
						 <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>NERACA APBD DAN BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";
				

        $sqlmaplo="select '1' bold, '1' kode, 'ASET' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '11' kode, 'ASET LANCAR' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '111' kode, 'Kas dan Setara Kas' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('111')
					union all
					select '4' bold, '112' kode, 'Investasi Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('112')
					union all
					select '4' bold, '113' kode, 'Piutang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('113')
					union all
					select '4' bold, '114' kode, 'Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('118')
					union all
					select '4' bold, '115' kode, 'Piutang Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('114')
					union all
					select '4' bold, '116' kode, 'Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('115')
					union all
					select '4' bold, '117' kode, 'Uang Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('116')
					union all
					select '4' bold, '118' kode, 'Biaya Dibayar di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('117')
					union all
					select '5' bold, '1189' kode, 'Jumlah Aset Lancar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('11')
					union all
					select '0' bold, '11899' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '12' kode, 'INVESTASI JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '121' kode, 'Investasi Non-Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('121')
					union all
					select '4' bold, '122' kode, 'Investasi Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('122')
					union all
					select '5' bold, '1229' kode, 'Jumlah Investasi Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('12')
					union all
					select '0' bold, '12299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '13' kode, 'ASET TETAP' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '131' kode, 'Tanah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('131')
					union all
					select '4' bold, '132' kode, 'Peralatan dan Mesin' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('132')
					union all
					select '4' bold, '133' kode, 'Gedung dan Bangunan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('133')
					union all
					select '4' bold, '134' kode, 'Jalan, Irigasi dan Jaringan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('134')
					union all
					select '4' bold, '135' kode, 'Aset Tetap Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('135')
					union all
					select '4' bold, '136' kode, 'Konstruksi dalam Pengerjaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('136')
					union all
					select '5' bold, '1369' kode, 'Jumlah Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('131','132','133','134','135','136')
					union all
					select '4' bold, '137' kode, 'Akumulasi Penyusutan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('137')
					union all
					select '5' bold, '1379' kode, 'Jumlah Nilai Buku Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('13')
					union all
					select '0' bold, '13799' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '14' kode, 'ASET LAINNYA' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '141' kode, 'Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('141')
					union all
					select '4' bold, '142' kode, 'Amortisasi Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('145')
					union all
					select '4' bold, '143' kode, 'Aset Kemitraan dengan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('142')
					union all
					select '4' bold, '144' kode, 'Aset Tetap Non-Produktif' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('143')
					union all
					select '4' bold, '145' kode, 'Aset Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('144')
					union all
					select '5' bold, '1459' kode, 'Jumlah Aset Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('14')
					union all
					select '5' bold, '14599' kode, 'JUMLAH ASET' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,1) in ('1')
					union all
					select '0' bold, '145999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '2' kode, 'KEWAJIBAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '21' kode, 'KEWAJIBAN JANGKA PENDEK' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '211' kode, 'Utang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('211')
					union all
					select '4' bold, '212' kode, 'Utang Pajak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('212')
					union all
					select '4' bold, '213' kode, 'Pendapatan Diterima di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('213')
					union all
					select '4' bold, '214' kode, 'Uang Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('214')
					union all
					select '4' bold, '215' kode, 'Biaya yang Masih Harus Dibayar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('215')
					union all
					select '4' bold, '216' kode, 'Titipan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('216')
					union all
					select '4' bold, '217' kode, 'Bagian Lancar Utang Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('217')
					union all
					select '4' bold, '218' kode, 'Utang Bunga Pinjaman' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '4' bold, '219' kode, 'Kewajiban Jangka Pendek Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '5' bold, '2199' kode, 'Jumlah Kewajiban Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('21')
					union all
					select '0' bold, '21999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '22' kode, 'KEWAJIBAN JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '221' kode, 'Utang Dalam Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('221')
					union all
					select '4' bold, '222' kode, 'Utang Luar Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('222')
					union all
					select '4' bold, '223' kode, 'Pendapatan yang Ditangguhkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('223')
					union all
					select '5' bold, '2239' kode, 'Jumlah Kewajiban Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('22')
					union all
					select '0' bold, '22399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '3' kode, 'EKUITAS' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '31' kode, 'EKUITAS TIDAK TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '311' kode, 'Ekuitas Awal' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('311')
					union all
					select '4' bold, '312' kode, 'Akumulasi Surplus/Defisit s.d. Tahun Lalu' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('312')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					union all	
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek,
					0 nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and LEFT(a.kd_rek5,3) in ('313')
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '4' bold, '314' kode, 'Ekuitas Donasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('314')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('31')
					union all
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '0' bold, '31499' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '32' kode, 'EKUITAS TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '321' kode, 'Ekuitas Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('321')
					union all
					select '4' bold, '322' kode, 'Ekuitas Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,3) in ('322')
					union all
					select '5' bold, '3229' kode, 'Jumlah Ekuitas Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,2) in ('32')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,1) in ('3')
					union all
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7)  and LEFT(a.kd_rek5,1) in ('2','3')
					union all
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					order by kode";
				   		
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					$nilai   	= number_format($nil,"2",",",".");
					$nilai_lalu = number_format($nil_lalu,"2",",",".");
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai_lalu</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$surplus_lo1$lo2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo3$surplus_lo_lalu1$lo4<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        $oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("NERACA_APBD_BLUD KONSOL / $cbulan");
        $this->template->set('title', 'NERACA_APBD_BLUD KONSOL / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>NERACA_APBD_BLUD KONSOL / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	

	function lap_neraca($cbulan="", $kdskpd="", $pilih=1){// created by henri_tb *koreksi galih
        $cetak		='2';//$ctk;
        //$id     	= $this->session->userdata('kdskpd');
		$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
		
			
					if($cbulan<10){
					 $xbulan="0$cbulan";
					 }
					else{
					$xbulan=$cbulan;
					}
	
		
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
		
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		

			
		$sqllo1="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('4') and month(b.tgl_voucher)<=$cbulan and b.kd_skpd='$id'";
                    $querylo1= $this->db->query($sqllo1);
                    $penlo = $querylo1->row();
                    $pen_lo = $penlo->nilai;
                    $pen_lo1= number_format($penlo->nilai,"2",",",".");
        
		$sqllo2="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('4') and b.kd_skpd='$id'";
                    $querylo2= $this->db->query($sqllo2);
                    $penlo2 = $querylo2->row();
                    $pen_lo_lalu = $penlo2->nilai;
                    $pen_lo_lalu1= number_format($penlo2->nilai,"2",",",".");
		
		$sqllo3="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('5') and month(b.tgl_voucher)<=$cbulan and b.kd_skpd='$id'";
                    $querylo3= $this->db->query($sqllo3);
                    $bello = $querylo3->row();
                    $bel_lo = $bello->nilai;
                    $bel_lo1= number_format($bello->nilai,"2",",",".");
        
		$sqllo4="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('5') and b.kd_skpd='$id'";
                    $querylo4= $this->db->query($sqllo4);
                    $bello2 = $querylo4->row();
                    $bel_lo_lalu = $bello2->nilai;
                    $bel_lo_lalu1= number_format($bello2->nilai,"2",",",".");		

					$surplus_lo = $pen_lo - $bel_lo;
                    if ($surplus_lo < 0){
                    	$lo1="("; $surplus_lox=$surplus_lo*-1; $lo2=")";}
                    else {
                    	$lo1=""; $surplus_lox=$surplus_lo; $lo2="";}		
                    $surplus_lo1 = number_format($surplus_lox,"2",",",".");
                    
					$surplus_lo_lalu = $pen_lo_lalu - $bel_lo_lalu;
                    if ($surplus_lo_lalu < 0){
                    	$lo3="("; $surplus_lo_lalux=$surplus_lo_lalu*-1; $lo4=")";}
                    else {
                    	$lo3=""; $surplus_lo_lalux=$surplus_lo_lalu; $lo4="";}						
                    $surplus_lo_lalu1 = number_format($surplus_lo_lalux,"2",",",".");

					$selisih_surplus_lo = $surplus_lo - $surplus_lo_lalu;
                    if ($selisih_surplus_lo < 0){
                    	$lo5="("; $selisih_surplus_lox=$selisih_surplus_lo*-1; $lo6=")";}
                    else {
                    	$lo5=""; $selisih_surplus_lox=$selisih_surplus_lo; $lo6="";}
                    $selisih_surplus_lo1 = number_format($selisih_surplus_lox,"2",",",".");
                    
					if( $surplus_lo_lalu=='' or $surplus_lo_lalu==0){
					$persen2 = '0,00';
					}else{
					$persen2 = ($surplus_lo/$surplus_lo_lalu)*100;
					$persen2 = number_format($persen2,"2",",",".");
					}
					
		
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td rowspan=\"5\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
						 <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd </strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>NERACA APBD DAN BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";


        $sqlmaplo="select '1' bold, '1' kode, 'ASET' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '11' kode, 'ASET LANCAR' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '111' kode, 'Kas dan Setara Kas' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('111')
					union all
					select '4' bold, '112' kode, 'Investasi Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('112')
					union all
					select '4' bold, '113' kode, 'Piutang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('113')
					union all
					select '4' bold, '114' kode, 'Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('118')
					union all
					select '4' bold, '115' kode, 'Piutang Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('114')
					union all
					select '4' bold, '116' kode, 'Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('115')
					union all
					select '4' bold, '117' kode, 'Uang Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('116')
					union all
					select '4' bold, '118' kode, 'Biaya Dibayar di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('117')
					union all
					select '5' bold, '1189' kode, 'Jumlah Aset Lancar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('11')
					union all
					select '0' bold, '11899' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '12' kode, 'INVESTASI JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '121' kode, 'Investasi Non-Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('121')
					union all
					select '4' bold, '122' kode, 'Investasi Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('122')
					union all
					select '5' bold, '1229' kode, 'Jumlah Investasi Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('12')
					union all
					select '0' bold, '12299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '13' kode, 'ASET TETAP' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '131' kode, 'Tanah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('131')
					union all
					select '4' bold, '132' kode, 'Peralatan dan Mesin' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('132')
					union all
					select '4' bold, '133' kode, 'Gedung dan Bangunan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('133')
					union all
					select '4' bold, '134' kode, 'Jalan, Irigasi dan Jaringan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('134')
					union all
					select '4' bold, '135' kode, 'Aset Tetap Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('135')
					union all
					select '4' bold, '136' kode, 'Konstruksi dalam Pengerjaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('136')
					union all
					select '5' bold, '1369' kode, 'Jumlah Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('131','132','133','134','135','136')
					union all
					select '4' bold, '137' kode, 'Akumulasi Penyusutan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('137')
					union all
					select '5' bold, '1379' kode, 'Jumlah Nilai Buku Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('13')
					union all
					select '0' bold, '13799' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '14' kode, 'ASET LAINNYA' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '141' kode, 'Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('141')
					union all
					select '4' bold, '142' kode, 'Amortisasi Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('145')
					union all
					select '4' bold, '143' kode, 'Aset Kemitraan dengan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('142')
					union all
					select '4' bold, '144' kode, 'Aset Tetap Non-Produktif' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('143')
					union all
					select '4' bold, '145' kode, 'Aset Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('144')
					union all
					select '5' bold, '1459' kode, 'Jumlah Aset Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('14')
					union all
					select '5' bold, '14599' kode, 'JUMLAH ASET' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,1) in ('1')
					union all
					select '0' bold, '145999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '2' kode, 'KEWAJIBAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '21' kode, 'KEWAJIBAN JANGKA PENDEK' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '211' kode, 'Utang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('211')
					union all
					select '4' bold, '212' kode, 'Utang Pajak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('212')
					union all
					select '4' bold, '213' kode, 'Pendapatan Diterima di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('213')
					union all
					select '4' bold, '214' kode, 'Uang Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('214')
					union all
					select '4' bold, '215' kode, 'Biaya yang Masih Harus Dibayar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('215')
					union all
					select '4' bold, '216' kode, 'Titipan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('216')
					union all
					select '4' bold, '217' kode, 'Bagian Lancar Utang Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('217')
					union all
					select '4' bold, '218' kode, 'Utang Bunga Pinjaman' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '4' bold, '219' kode, 'Kewajiban Jangka Pendek Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '5' bold, '2199' kode, 'Jumlah Kewajiban Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('21')
					union all
					select '0' bold, '21999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '22' kode, 'KEWAJIBAN JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '221' kode, 'Utang Dalam Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('221')
					union all
					select '4' bold, '222' kode, 'Utang Luar Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('222')
					union all
					select '4' bold, '223' kode, 'Pendapatan yang Ditangguhkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('223')
					union all
					select '5' bold, '2239' kode, 'Jumlah Kewajiban Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('22')
					union all
					select '0' bold, '22399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '3' kode, 'EKUITAS' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '31' kode, 'EKUITAS TIDAK TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '311' kode, 'Ekuitas Awal' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('311')
					union all
					select '4' bold, '312' kode, 'Akumulasi Surplus/Defisit s.d. Tahun Lalu' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('312')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					union all	
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek,
					0 nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and LEFT(a.kd_rek5,3) in ('313')
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '4' bold, '314' kode, 'Ekuitas Donasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('314')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and LEFT(a.kd_rek5,7)<>'3130101' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('31')
					union all
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '0' bold, '31499' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '32' kode, 'EKUITAS TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '321' kode, 'Ekuitas Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('321')
					union all
					select '4' bold, '322' kode, 'Ekuitas Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,3) in ('322')
					union all
					select '5' bold, '3229' kode, 'Jumlah Ekuitas Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,2) in ('32')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and LEFT(a.kd_rek5,7)<>'3130101' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,1) in ('3')
					union all
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','52','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and LEFT(a.kd_rek5,7)<>'3130101' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'  and LEFT(a.kd_rek5,1) in ('2','3')
					union all
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					order by kode";
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					$nilai   	= number_format($nil,"2",",",".");
					$nilai_lalu = number_format($nil_lalu,"2",",",".");
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and b.kd_skpd='$id'";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and b.kd_skpd='$id'";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai_lalu</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$surplus_lo1$lo2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo3$surplus_lo_lalu1$lo4<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioix= $rowttd->nm;
                    $jabatanx = $rowttd->jab;
                }	
        $oioi = strtoupper($oioix);
		$jabatan = strtoupper($jabatanx);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("NERACA_APBD_BLUD $id / $cbulan");
        $this->template->set('title', 'NERACA_APBD_BLUD $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>NERACA_APBD_BLUD $id / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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

	function lap_lak($cbulan="", $kdskpd="", $pilih=""){
        $cetak='2';//$ctk;
        //$id     = $this->session->userdata('kdskpd');
        $thn_ang = $this->session->userdata('pcThang');
        $thn_ang_1= $thn_ang-1;  
	   
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$kdskpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>PEMERINTAH KOTA PONTIANAK</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN ARUS KAS BLUD DAN APBD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"5\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"5\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"5\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";
		
				$sqlmaplo=" SELECT nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, SUM(blud_apbd) nil_lalu, reev2 reev FROM map_lak_blud WHERE kode='$kdskpd' 
							GROUP BY nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, reev2 ORDER BY seq";
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
			   
			   
                foreach ($querymaplo->result() as $loquery)
                {	
                    $nor        = $loquery->nor;
                    $uraian     = $loquery->uraian;
                    $cetak      = $loquery->cetak;
                    $seq      	= $loquery->seq;
                    $bold      	= $loquery->bold;
                    $tambah     = $loquery->tambah;
                    $kode_1     = $loquery->kode_1;
                    $kode_2     = $loquery->kode_2;
                    $kode_3     = $loquery->kode_3;
                    $nil_lalu   = $loquery->nil_lalu;
					$reev    	= $loquery->reev;						
										
						
				$quelo01   = "SELECT SUM($cetak) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,$kode_1) in ($kode_2)
				and year(tgl_voucher)$kode_3 $thn_ang and month(tgl_voucher)<=$cbulan and kd_skpd='$kdskpd' and tabel<>'5' and reev IN ($reev) $tambah
				";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil1     = $quelo03->nilai;	
					
					$nil = $nil1;

                    if ($nil < 0){
                    	$lo0="("; $nilx=$nil*-1; $lo00=")";}
                    else {
                    	$lo0=""; $nilx=$nil; $lo00="";}
                    $nilai = number_format($nilx,"2",",",".");
                    
					if ($nil_lalu < 0){
                    	$lol0="("; $nil_lalux=$nil_lalu*-1; $lol00=")";}
                    else {
                    	$lol0=""; $nil_lalux=$nil_lalu; $lol00="";}
                    $nilai_lalu = number_format($nil_lalux,"2",",",".");
					
                    $no       = $no + 1;
                    switch ($loquery->bold) {
					case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lo0$nilai$lo00</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lol0$nilai_lalu$lol00</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo0$nilai$lo00<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lol0$nilai_lalu$lol00<b></td>
                                 </tr>";
                        break;
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$kdskpd' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> Pontianak, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LAK_BLUD_APBD $kdskpd / $cbulan");
        $this->template->set('title', 'LAK_BLUD_APBD $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LAK_BLUD_APBD $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	
	function lap_lak_konsol($cbulan="", $pilih=""){
        $cetak='2';//$ctk;
        $id     = $this->session->userdata('kdskpd');
        $thn_ang = $this->session->userdata('pcThang');
        $thn_ang_1= $thn_ang-1;  
	   
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>PEMERINTAH KOTA PONTIANAK</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN ARUS KAS BLUD DAN APBD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"5\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"5\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"5\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";
		
				$sqlmaplo=" SELECT nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, SUM(blud_apbd) nil_lalu, reev2 reev FROM map_lak_blud WHERE LEFT(kode,7)=LEFT('$id',7) 
							GROUP BY nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, reev2 ORDER BY seq";
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {	
                    $nor        = $loquery->nor;
                    $uraian     = $loquery->uraian;
                    $cetak      = $loquery->cetak;
                    $seq      	= $loquery->seq;
                    $bold      	= $loquery->bold;
                    $tambah     = $loquery->tambah;
                    $kode_1     = $loquery->kode_1;
                    $kode_2     = $loquery->kode_2;
                    $kode_3     = $loquery->kode_3;
                    $nil_lalu   = $loquery->nil_lalu;
					$reev    	= $loquery->reev;					
										
						
				$quelo01   = "SELECT SUM($cetak) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,$kode_1) in ($kode_2) and year(tgl_voucher)$kode_3 $thn_ang and month(tgl_voucher)<=$cbulan and LEFT(kd_skpd,7)=LEFT('$id',7) and tabel<>'5' and reev IN ($reev) $tambah";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;	
					
                    if ($nil < 0){
                    	$lo0="("; $nilx=$nil*-1; $lo00=")";}
                    else {
                    	$lo0=""; $nilx=$nil; $lo00="";}
                    $nilai = number_format($nilx,"2",",",".");
                    
					if ($nil_lalu < 0){
                    	$lol0="("; $nil_lalux=$nil_lalu*-1; $lol00=")";}
                    else {
                    	$lol0=""; $nil_lalux=$nil_lalu; $lol00="";}
                    $nilai_lalu = number_format($nil_lalux,"2",",",".");
					
                    $no       = $no + 1;
                    switch ($loquery->bold) {
					case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lo0$nilai$lo00</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lol0$nilai_lalu$lol00</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo0$nilai$lo00<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lol0$nilai_lalu$lol00<b></td>
                                 </tr>";
                        break;
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> Pontianak, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LAK_BLUD_APBD_Konsol $id / $cbulan");
        $this->template->set('title', 'LAK_BLUD_APBD_Konsol $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LAK_BLUD_APBD_Konsol $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	

	
	function lap_lak_blud($cbulan="", $kdskpd="", $pilih=""){
        $cetak='2';//$ctk;
        //$id     = $this->session->userdata('kdskpd');
        $thn_ang = $this->session->userdata('pcThang');
        $thn_ang_1= $thn_ang-1;  
	   
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$kdskpd'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>PEMERINTAH KOTA PONTIANAK</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN ARUS KAS BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"5\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"5\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"5\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";
			
		
				$sqlmaplo=" SELECT nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, SUM(blud) nil_lalu FROM map_lak_blud WHERE kode='$kdskpd' 
							GROUP BY nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3 ORDER BY seq";
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {	
                    $nor        = $loquery->nor;
                    $uraian     = $loquery->uraian;
                    $cetak      = $loquery->cetak;
                    $seq      	= $loquery->seq;
                    $bold      	= $loquery->bold;
                    $tambah     = $loquery->tambah;
                    $kode_1     = $loquery->kode_1;
                    $kode_2     = $loquery->kode_2;
                    $kode_3     = $loquery->kode_3;
                    $nil_lalu   = $loquery->nil_lalu;		
				
					
				$quelo01   = "SELECT SUM($cetak) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd 
				WHERE left(kd_rek5,$kode_1) in ($kode_2) and year(tgl_voucher)$kode_3 $thn_ang and month(tgl_voucher)<=$cbulan and kd_skpd='$kdskpd' and tabel<>'5'  $tambah";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;	
			
					
                    if ($nil < 0){
                    	$lo0="("; $nilx=$nil*-1; $lo00=")";}
                    else {
                    	$lo0=""; $nilx=$nil; $lo00="";}
                    $nilai = number_format($nilx,"2",",",".");
                    
					if ($nil_lalu < 0){
                    	$lol0="("; $nil_lalux=$nil_lalu*-1; $lol00=")";}
                    else {
                    	$lol0=""; $nil_lalux=$nil_lalu; $lol00="";}
                    $nilai_lalu = number_format($nil_lalux,"2",",",".");
					
                    $no       = $no + 1;
                    switch ($loquery->bold) {
					case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lo0$nilai$lo00</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lol0$nilai_lalu$lol00</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo0$nilai$lo00<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lol0$nilai_lalu$lol00<b></td>
                                 </tr>";
                        break;
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$kdskpd' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> Pontianak, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LAK_BLUD $kdskpd / $cbulan");
        $this->template->set('title', 'LAK_BLUD $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LAK_BLUD $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	
	function lap_lak_blud_konsol($cbulan="", $pilih=""){
        $cetak='2';//$ctk;
        $id     = $this->session->userdata('kdskpd');
        $thn_ang = $this->session->userdata('pcThang');
        $thn_ang_1= $thn_ang-1;  
	   
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>PEMERINTAH KOTA PONTIANAK</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN ARUS KAS BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"5\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"5\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"5\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";
		
				$sqlmaplo=" SELECT nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, SUM(blud) nil_lalu, reev1 reev FROM map_lak_blud WHERE LEFT(kode,7)=LEFT('$id',7) 
							GROUP BY nor, uraian, cetak, seq, bold, tambah, kode_1, kode_2, kode_3, reev1 ORDER BY seq";
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {	
                    $nor        = $loquery->nor;
                    $uraian     = $loquery->uraian;
                    $cetak      = $loquery->cetak;
                    $seq      	= $loquery->seq;
                    $bold      	= $loquery->bold;
                    $tambah     = $loquery->tambah;
                    $kode_1     = $loquery->kode_1;
                    $kode_2     = $loquery->kode_2;
                    $kode_3     = $loquery->kode_3;
                    $nil_lalu   = $loquery->nil_lalu;
					$reev    	= $loquery->reev;					
										
						
				$quelo01   = "SELECT SUM($cetak) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,$kode_1) in ($kode_2) and year(tgl_voucher)$kode_3 $thn_ang and month(tgl_voucher)<=$cbulan and LEFT(kd_skpd,7)=LEFT('$id',7) and tabel<>'5' and reev IN ($reev) $tambah";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;	
					
                    if ($nil < 0){
                    	$lo0="("; $nilx=$nil*-1; $lo00=")";}
                    else {
                    	$lo0=""; $nilx=$nil; $lo00="";}
                    $nilai = number_format($nilx,"2",",",".");
                    
					if ($nil_lalu < 0){
                    	$lol0="("; $nil_lalux=$nil_lalu*-1; $lol00=")";}
                    else {
                    	$lol0=""; $nil_lalux=$nil_lalu; $lol00="";}
                    $nilai_lalu = number_format($nil_lalux,"2",",",".");
					
                    $no       = $no + 1;
                    switch ($loquery->bold) {
					case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$nor</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$uraian</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lo0$nilai$lo00</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$lol0$nilai_lalu$lol00</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$nor<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$uraian<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo0$nilai$lo00<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lol0$nilai_lalu$lol00<b></td>
                                 </tr>";
                        break;
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> Pontianak, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LAK_BLUD_Konsol $id / $cbulan");
        $this->template->set('title', 'LAK_BLUD_Konsol $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LAK_BLUD_Konsol $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	

	
	function ctk_jurum($dcetak='',$dcetak2='',$skpd=''){
   	        $csql11 = " select nm_skpd from ms_skpd_blud where kd_skpd = '$skpd'"; 
            $rs1 = $this->db->query($csql11);
            $trh1 = $rs1->row();
            $lcskpd = strtoupper ($trh1->nm_skpd);
            $tgl=$this->tukd_model->tanggal_format_indonesia($dcetak);
            $tgl2=$this->tukd_model->tanggal_format_indonesia($dcetak2);
            $tgl=strtoupper($tgl);
			$tgl2=strtoupper($tgl2);
			
		$cRet ="";	
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"60%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
            <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;\"><b>PEMERINTAH KOTA PONTIANAK
                </td>
            </tr>            
            <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;\"><b>$lcskpd
                </td>
            </tr>
             <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;\"><b>JURNAL UMUM APBD DAN BLUD
                </td>
            </tr>
            <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;border-bottom:solid 1px white;\"><b>PERIODE $tgl SAMPAI DENGAN $tgl2
                </td>
            </tr>
			</table>";
			
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"90%\" align=\"center\" border=\"2\" cellspacing=\"0\" cellpadding=\"4\">
            <thead>
			<tr>
                <td align=\"center\"bgcolor=\"#CCCCCC\" rowspan=\"2\"><b>Tanggal</td>
                <td align=\"center\" bgcolor=\"#CCCCCC\"rowspan=\"2\"><b>Nomor<br>Bukti</td>
                <td colspan=\"5\"bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\"><b>Kode<br>Rekening</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\" rowspan=\"2\"><b>Uraian</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\" rowspan=\"2\"><b>ref</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\" colspan=\"2\"><b>Jumlah Rp</td>
            </tr>
			<tr>
                <td align=\"center\" bgcolor=\"#CCCCCC\"><b>Debit</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\"><b>Kredit</td>
            </tr>
            <tr>
                <td align=\"center\" width=\"15%\";border-bottom:solid 1px red;\"><b>1</td>
                <td align=\"center\" width=\"10%\";border-bottom:solid 1px blue;\"><b>2</td>
                <td colspan=\"5\" align=\"center\" width=\"15%\"><b>3</td>
                <td align=\"center\" width=\"42%\"><b>4</td>
                <td align=\"center\" width=\"3%\"></td>
                <td align=\"center\" width=\"10%\"><b>5</td>
                <td align=\"center\" width=\"10%\"><b>6</td>
            </tr>
			</thead>
           ";
         
         $csql1 = "select count(*) as tot FROM 
                 trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher= b.no_voucher and a.kd_unit=b.kd_skpd 
                 where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd'"; 
         $rs = $this->db->query($csql1);
         $trh = $rs->row();
         
            
/*         $csql = "SELECT b.tgl_voucher,a.no_voucher,a.kd_rek5,(c.nm_rek64 + case when (pos='0') then '' else ''end) AS nm_rek5,a.debet,a.kredit FROM 
                  trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher= b.no_voucher join (SELECT kd_rek64,nm_Rek64 from ms_rek5 group by kd_rek64,nm_Rek64) c on a.kd_rek5=c.kd_rek64
                  where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd' 
                  ORDER BY b.tgl_voucher,a.no_voucher,a.urut,a.rk,a.kd_rek5";   
*/
		
		/* 25/10/2016
		$csql = "select b.tgl_voucher,a.no_voucher,a.kd_rek5, nm_rek5,a.debet,a.kredit,a.rk from trdju_blud a join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
				where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd' 
                  ORDER BY b.tgl_voucher,a.no_voucher,a.urut,a.rk,a.kd_rek5";*/
		
		$csql = "select b.tgl_voucher,a.no_voucher,a.kd_rek5, nm_rek5,a.debet,a.kredit,a.rk, left(a.kd_rek5,1) akun from trdju_blud a join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
				where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd' 
                 ORDER BY b.tgl_voucher,a.no_voucher,a.urut,a.rk,a.kd_rek5
                  ";
		
         $query = $this->db->query($csql);  
         $cnovoc = '';
         $lcno = 0;
         foreach($query->result_array() as $res){
                $lcno = $lcno + 1;
                if ($lcno==$trh->tot){
                    $cRet .="<tr>
                                <td style=\"border-bottom:none;border-top:none;\"></td>
                                <td style=\"border-bottom:none;border-top:none;\"></td>
                                <td style=\"border-bottom:none;\">".substr($res['kd_rek5'],0,1)."</td>";
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,1)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],2,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],4,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,2)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],6,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],5,2)."</td>";}
                                $cRet .="<td style=\"border-bottom:none;\">".$res['nm_rek5']."</td>
                                <td style=\"border-bottom:none;\"></td>";
                                if($res['rk']=='K'){
                                    $cRet .=" <td style=\"border-bottom:none;\"></td>
                                            <td style=\"border-bottom:none;\" align=\"right\">".number_format($res['kredit'],"2",",",".")."</td>";
                                }else{$cRet .="<td style=\"border-bottom:none;\" align=\"right\">".number_format($res['debet'],"2",",",".")."</td>
                                               <td style=\"border-bottom:none;\"></td>";                                    
                                }
                       
                       $cRet .="</tr>"; 
                }else{
                        if($cnovoc==$res['no_voucher']){
                            $cRet .="<tr>
                                <td style=\"border-bottom:none;border-top:none;\">&nbsp;</td>
                                <td style=\"border-bottom:none;border-top:none;\">&nbsp;</td>
                                <td style=\"border-bottom:none;\">".substr($res['kd_rek5'],0,1)."</td>";
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,1)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],2,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],4,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,2)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],6,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],5,2)."</td>";}
                                $cRet .="<td style=\"border-bottom:none;\">".$res['nm_rek5']."</td>
                                <td style=\"border-bottom:none;\"></td>";
                                if($res['rk']=='K'){
                                    $cRet .=" <td style=\"border-bottom:none;\"></td>
                                            <td style=\"border-bottom:none;\" align=\"right\">".number_format($res['kredit'],"2",",",".")."</td>";
                                }else{$cRet .="<td style=\"border-bottom:none;\" align=\"right\">".number_format($res['debet'],"2",",",".")."</td>
                                               <td style=\"border-bottom:none;\"></td>";                                    
                                }
                       
                       $cRet .="</tr>";                    
                        }else{
                        $cRet .="<tr>
                                <td align=\"center\" style=\"border-bottom:none\">".$this->tukd_model->tanggal_ind($res['tgl_voucher'])."</td>
                                <td style=\"border-bottom:none\">".$res['no_voucher']."</td>
                                <td style=\"border-bottom:none;\">".substr($res['kd_rek5'],0,1)."</td>";
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,1)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],2,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],4,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,2)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],6,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],5,2)."</td>";}
                                $cRet .="<td style=\"border-bottom:none;\">".$res['nm_rek5']."</td>
                                <td style=\"border-bottom:none;\"></td>";
                                if($res['rk']=='K'){
                                    $cRet .=" <td style=\"border-bottom:none;\"></td>
                                            <td style=\"border-bottom:none;\" align=\"right\">".number_format($res['kredit'],"2",",",".")."</td>";
                                }else{$cRet .="<td style=\"border-bottom:none;\" align=\"right\">".number_format($res['debet'],"2",",",".")."</td>
                                               <td style=\"border-bottom:none;\"></td>";                                    
                                }
                       
                       $cRet .="</tr>";
                        }
                        $cnovoc=$res['no_voucher'];
                }
                
            }
            
         $cRet .=" <tr>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                    </tr>  
         </table>
         ";

			$data['prev']=$cRet; //'JURNAL UMUM';
			echo $cRet;
            //$this->tukd_model->_mpdf('',$cRet,5,5,10,'0');	
	
	} 
    
	function lap_lo_blud_konsol($cbulan="", $pilih=1){// created by henri_tb
        $cetak='2';//$ctk;
        $id     	= $this->session->userdata('kdskpd');
		//$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
	   
	   $sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
	   
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
			
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN OPERASIONAL BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";

        $sqlmaplo="select '1' bold, '4' kode, 'PENDAPATAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '41' kode, 'PENDAPATAN JASA LAYANAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '411' kode, 'Jasa Layanan Kesehatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411') and reev IN ('0','2')
					union all
					select '4' bold, '412' kode, 'Penyesuaian Pendapatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('412') and reev IN ('0','2')
					union all
					select '5' bold, '4129' kode, 'Jumlah Pendapatan Jasa Layanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411', '412') and reev IN ('0','2')
					union all
					select '0' bold, '41299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '42' kode, 'PENDAPATAN HIBAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '421' kode, 'Hibah Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421') and reev IN ('0','2')
					union all
					select '4' bold, '422' kode, 'Hibah Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('422') and reev IN ('0','2')
					union all
					select '4' bold, '423' kode, 'Hibah Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('423') and reev IN ('0','2')
					union all
					select '5' bold, '4239' kode, 'Jumlah Pendapatan Hibah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421','422','423') and reev IN ('0','2')
					union all
					select '0' bold, '42399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '43' kode, 'HASIL KERJASAMA DENGAN PIHAK LAIN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '431' kode, 'Hasil Kerjasama Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431') and reev IN ('0','2')
					union all
					select '4' bold, '432' kode, 'Pendapatan Sewa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('432') and reev IN ('0','2')
					union all
					select '4' bold, '433' kode, 'Pendapatan Kerjasama Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('433') and reev IN ('0','2')
					union all
					select '5' bold, '4339' kode, 'Jumlah Pendapatan Hasil Kerjasama' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431','432','433') and reev IN ('0','2')
					union all
					select '0' bold, '43399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '44' kode, 'PENDAPATAN APBD' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '441' kode, 'APBD Kota Pontianak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441') and reev IN ('0','2')
					union all
					select '4' bold, '442' kode, 'APBD Provinsi Kalimantan Barat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('442') and reev IN ('0','2')
					union all
					select '4' bold, '443' kode, 'APBD Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('443') and reev IN ('0','2')
					union all
					select '5' bold, '4439' kode, 'Jumlah Pendapatan APBD' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441','442','443') and reev IN ('0','2')
					union all
					select '0' bold, '44399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '45' kode, 'PENDAPATAN APBN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '451' kode, 'APBN - Dana Dekonsentrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451') and reev IN ('0','2')
					union all
					select '4' bold, '452' kode, 'APBN - Tugas Pembantuan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('452') and reev IN ('0','2')
					union all
					select '4' bold, '453' kode, 'APBN - Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('453') and reev IN ('0','2')
					union all
					select '5' bold, '4539' kode, 'Jumlah Pendapatan APBN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451','452','453') and reev IN ('0','2')
					union all
					select '0' bold, '45399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '453999' kode, 'LAIN-LAIN PENDAPATAN BLUD YANG SAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '461' kode, 'Hasil Penjualan Kekayaan yang Tidak Dipisahkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461') and reev IN ('0','2')
					union all
					select '4' bold, '462' kode, 'Hasil Pemanfaatan Kekayaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('462') and reev IN ('0','2')
					union all
					select '4' bold, '463' kode, 'Jasa Giro' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('463') and reev IN ('0','2')
					union all
					select '4' bold, '464' kode, 'Pendapatan Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('464') and reev IN ('0','2')
					union all
					select '4' bold, '465' kode, 'Keuntungan Selisih Nilai Tukar Rupiah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('465') and reev IN ('0','2')
					union all
					select '4' bold, '466' kode, 'Komisi dan Potongan Penjualan/Pengadaan Barang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('466') and reev IN ('0','2')
					union all
					select '4' bold, '467' kode, 'Hasil Investasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('467') and reev IN ('0','2')
					union all
					select '4' bold, '468' kode, 'Lain-lain Pendapatan BLUD yang Sah Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('468') and reev IN ('0','2')
					union all
					select '5' bold, '4689' kode, 'Jumlah Lain-lain Pendapatan yang Sah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461','462','463','464','465','466','467','468') and reev IN ('0','2')
					union all
					select '5' bold, '46899' kode, 'JUMLAH PENDAPATAN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4') and reev IN ('0','2')
					union all
					select '0' bold, '468999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '5' kode, 'BIAYA' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '51' kode, 'BIAYA OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '511' kode, 'BIAYA PELAYANAN' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5111' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5111') and reev IN ('0','2')
					union all
					select '4' bold, '5112' kode, 'Biaya Bahan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5112') and reev IN ('0','2')
					union all
					select '4' bold, '5113' kode, 'Biaya Jasa Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5113') and reev IN ('0','2')
					union all
					select '4' bold, '5114' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5114') and reev IN ('0','2')
					union all
					select '4' bold, '5115' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5115') and reev IN ('0','2')
					union all
					select '4' bold, '5116' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5116') and reev IN ('0','2')
					union all
					select '4' bold, '5117' kode, 'Biaya Pelayanan Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5117') and reev IN ('0','2')
					union all
					select '5' bold, '51179' kode, 'Jumlah Biaya Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('511') and reev IN ('0','2')
					union all
					select '0' bold, '51179' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '512' kode, 'BIAYA UMUM DAN ADMINISTRASI' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5121' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5121') and reev IN ('0','2')
					union all
					select '4' bold, '5122' kode, 'Biaya Administrasi Kantor' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5122') and reev IN ('0','2')
					union all
					select '4' bold, '5123' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5123') and reev IN ('0','2')
					union all
					select '4' bold, '5124' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5124') and reev IN ('0','2')
					union all
					select '4' bold, '5125' kode, 'Biaya Promosi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5125') and reev IN ('0','2')
					union all
					select '4' bold, '5126' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5126') and reev IN ('0','2')
					union all
					select '4' bold, '5127' kode, 'Biaya Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5127') and reev IN ('0','2')
					union all
					select '4' bold, '5128' kode, 'Biaya Umum dan Administrasi Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5128') and reev IN ('0','2')
					union all
					select '5' bold, '51289' kode, 'Jumlah Biaya Umum dan Administrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('512') and reev IN ('0','2')
					union all
					select '5' bold, '512899' kode, 'Jumlah Biaya Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,2) in ('51') and reev IN ('0','2')
					union all
					select '0' bold, '5199999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '530' kode, 'BIAYA NON-OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5301' kode, 'Biaya Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5301') and reev IN ('0','2')
					union all
					select '4' bold, '5302' kode, 'Biaya Administrasi Bank' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5302') and reev IN ('0','2')
					union all
					select '4' bold, '5303' kode, 'Biaya Kerugian Penjualan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5303') and reev IN ('0','2')
					union all
					select '4' bold, '5304' kode, 'Biaya Kerugian Penurunan Nilai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5304') and reev IN ('0','2')
					union all
					select '4' bold, '5305' kode, 'Biaya Non-Operasional Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5305') and reev IN ('0','2')
					union all
					select '5' bold, '53059' kode, 'Jumlah Biaya Non-Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,3) in ('530') and reev IN ('0','2')
					union all
					select '5' bold, '530599' kode, 'JUMLAH BIAYA' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,1) in ('5') and reev IN ('0','2')
					union all
					select '0' bold, '5305999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '6' bold, '53059999' kode, 'JUMLAH SURPLUS/DEFISIT DARI OPERASI' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4','5') and reev IN ('0','2')
					order by kode";
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    if ($nil < 0){
                    	$lo1="("; $nilaix=$nil*-1; $lo01=")";}
                    else {
                    	$lo1=""; $nilaix=$nil; $lo01="";}
                    $nilai = number_format($nilaix,"2",",",".");
					
					if ($nil_lalu < 0){
                    	$lo2="("; $nilai_lalux=$nil_lalu*-1; $lo02=")";}
                    else {
                    	$lo2=""; $nilai_lalux=$nil_lalu; $lo02="";}
                    $nilai_lalu = number_format($nilai_lalux,"2",",",".");
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
		
                    
		
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
		$oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LO BLUD Konsol / $cbulan");
        $this->template->set('title', 'LO BLUD Konsol / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LO BLUD Konsol / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	
	function lap_lo_blud($cbulan="", $kdskpd="", $pilih=1){// created by henri_tb
        $cetak='2';//$ctk;
        //$id     	= $this->session->userdata('kdskpd');
		$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
		
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
				
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		
// created by henri_tb
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
						<td rowspan=\"5\" align=\"right\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
                         <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>LAPORAN OPERASIONAL BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";

        $sqlmaplo="select '1' bold, '4' kode, 'PENDAPATAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '41' kode, 'PENDAPATAN JASA LAYANAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '411' kode, 'Jasa Layanan Kesehatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411') and reev IN ('0','2')
					union all
					select '4' bold, '412' kode, 'Penyesuaian Pendapatan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('412') and reev IN ('0','2')
					union all
					select '5' bold, '4129' kode, 'Jumlah Pendapatan Jasa Layanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('411', '412') and reev IN ('0','2')
					union all
					select '0' bold, '41299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '42' kode, 'PENDAPATAN HIBAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '421' kode, 'Hibah Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421') and reev IN ('0','2')
					union all
					select '4' bold, '422' kode, 'Hibah Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('422') and reev IN ('0','2')
					union all
					select '4' bold, '423' kode, 'Hibah Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('423') and reev IN ('0','2')
					union all
					select '5' bold, '4239' kode, 'Jumlah Pendapatan Hibah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('421','422','423') and reev IN ('0','2')
					union all
					select '0' bold, '42399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '43' kode, 'HASIL KERJASAMA DENGAN PIHAK LAIN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '431' kode, 'Hasil Kerjasama Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431') and reev IN ('0','2')
					union all
					select '4' bold, '432' kode, 'Pendapatan Sewa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('432') and reev IN ('0','2')
					union all
					select '4' bold, '433' kode, 'Pendapatan Kerjasama Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('433') and reev IN ('0','2')
					union all
					select '5' bold, '4339' kode, 'Jumlah Pendapatan Hasil Kerjasama' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('431','432','433') and reev IN ('0','2')
					union all
					select '0' bold, '43399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '44' kode, 'PENDAPATAN APBD' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '441' kode, 'APBD Kota Pontianak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441') and reev IN ('0','2')
					union all
					select '4' bold, '442' kode, 'APBD Provinsi Kalimantan Barat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('442') and reev IN ('0','2')
					union all
					select '4' bold, '443' kode, 'APBD Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('443') and reev IN ('0','2')
					union all
					select '5' bold, '4439' kode, 'Jumlah Pendapatan APBD' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('441','442','443') and reev IN ('0','2')
					union all
					select '0' bold, '44399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '45' kode, 'PENDAPATAN APBN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '451' kode, 'APBN - Dana Dekonsentrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451') and reev IN ('0','2')
					union all
					select '4' bold, '452' kode, 'APBN - Tugas Pembantuan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('452') and reev IN ('0','2')
					union all
					select '4' bold, '453' kode, 'APBN - Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('453') and reev IN ('0','2')
					union all
					select '5' bold, '4539' kode, 'Jumlah Pendapatan APBN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('451','452','453') and reev IN ('0','2')
					union all
					select '0' bold, '45399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '453999' kode, 'LAIN-LAIN PENDAPATAN BLUD YANG SAH' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '461' kode, 'Hasil Penjualan Kekayaan yang Tidak Dipisahkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461') and reev IN ('0','2')
					union all
					select '4' bold, '462' kode, 'Hasil Pemanfaatan Kekayaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('462') and reev IN ('0','2')
					union all
					select '4' bold, '463' kode, 'Jasa Giro' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('463') and reev IN ('0','2')
					union all
					select '4' bold, '464' kode, 'Pendapatan Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('464') and reev IN ('0','2')
					union all
					select '4' bold, '465' kode, 'Keuntungan Selisih Nilai Tukar Rupiah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('465') and reev IN ('0','2')
					union all
					select '4' bold, '466' kode, 'Komisi dan Potongan Penjualan/Pengadaan Barang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('466') and reev IN ('0','2')
					union all
					select '4' bold, '467' kode, 'Hasil Investasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('467') and reev IN ('0','2')
					union all
					select '4' bold, '468' kode, 'Lain-lain Pendapatan BLUD yang Sah Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('468') and reev IN ('0','2')
					union all
					select '5' bold, '4689' kode, 'Jumlah Lain-lain Pendapatan yang Sah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('461','462','463','464','465','466','467','468') and reev IN ('0','2')
					union all
					select '5' bold, '46899' kode, 'JUMLAH PENDAPATAN' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4') and reev IN ('0','2')
					union all
					select '0' bold, '468999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '5' kode, 'BIAYA' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '51' kode, 'BIAYA OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '511' kode, 'BIAYA PELAYANAN' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5111' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5111') and reev IN ('0','2')
					union all
					select '4' bold, '5112' kode, 'Biaya Bahan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5112') and reev IN ('0','2')
					union all
					select '4' bold, '5113' kode, 'Biaya Jasa Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5113') and reev IN ('0','2')
					union all
					select '4' bold, '5114' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5114') and reev IN ('0','2')
					union all
					select '4' bold, '5115' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5115') and reev IN ('0','2')
					union all
					select '4' bold, '5116' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5116') and reev IN ('0','2')
					union all
					select '4' bold, '5117' kode, 'Biaya Pelayanan Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5117') and reev IN ('0','2')
					union all
					select '5' bold, '51179' kode, 'Jumlah Biaya Pelayanan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('511') and reev IN ('0','2')
					union all
					select '0' bold, '51179' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '512' kode, 'BIAYA UMUM DAN ADMINISTRASI' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5121' kode, 'Biaya Pegawai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5121') and reev IN ('0','2')
					union all
					select '4' bold, '5122' kode, 'Biaya Administrasi Kantor' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5122') and reev IN ('0','2')
					union all
					select '4' bold, '5123' kode, 'Biaya Pemeliharaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5123') and reev IN ('0','2')
					union all
					select '4' bold, '5124' kode, 'Biaya Barang dan Jasa' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5124') and reev IN ('0','2')
					union all
					select '4' bold, '5125' kode, 'Biaya Promosi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5125') and reev IN ('0','2')
					union all
					select '4' bold, '5126' kode, 'Biaya Penyusutan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5126') and reev IN ('0','2')
					union all
					select '4' bold, '5127' kode, 'Biaya Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5127') and reev IN ('0','2')
					union all
					select '4' bold, '5128' kode, 'Biaya Umum dan Administrasi Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5128') and reev IN ('0','2')
					union all
					select '5' bold, '51289' kode, 'Jumlah Biaya Umum dan Administrasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('512') and reev IN ('0','2')
					union all
					select '5' bold, '512899' kode, 'Jumlah Biaya Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,2) in ('51') and reev IN ('0','2')
					union all
					select '0' bold, '5199999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '530' kode, 'BIAYA NON-OPERASIONAL' nm_rek, 0 nilai, 0 nilai_l
					union all 
					select '4' bold, '5301' kode, 'Biaya Bunga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5301') and reev IN ('0','2')
					union all
					select '4' bold, '5302' kode, 'Biaya Administrasi Bank' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5302') and reev IN ('0','2')
					union all
					select '4' bold, '5303' kode, 'Biaya Kerugian Penjualan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5303') and reev IN ('0','2')
					union all
					select '4' bold, '5304' kode, 'Biaya Kerugian Penurunan Nilai' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5304') and reev IN ('0','2')
					union all
					select '4' bold, '5305' kode, 'Biaya Non-Operasional Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,4) in ('5305') and reev IN ('0','2')
					union all
					select '5' bold, '53059' kode, 'Jumlah Biaya Non-Operasional' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,3) in ('530') and reev IN ('0','2')
					union all
					select '5' bold, '530599' kode, 'JUMLAH BIAYA' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,1) in ('5') and reev IN ('0','2')
					union all
					select '0' bold, '5305999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '6' bold, '53059999' kode, 'JUMLAH SURPLUS/DEFISIT DARI OPERASI' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and month(tgl_voucher)<='$cbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and LEFT(a.kd_rek5,1) in ('4','5') and reev IN ('0','2')
					order by kode";
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    if ($nil < 0){
                    	$lo1="("; $nilaix=$nil*-1; $lo01=")";}
                    else {
                    	$lo1=""; $nilaix=$nil; $lo01="";}
                    $nilai = number_format($nilaix,"2",",",".");
					
					if ($nil_lalu < 0){
                    	$lo2="("; $nilai_lalux=$nil_lalu*-1; $lo02=")";}
                    else {
                    	$lo2=""; $nilai_lalux=$nil_lalu; $lo02="";}
                    $nilai_lalu = number_format($nilai_lalux,"2",",",".");
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$nilai$lo01<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo2$nilai_lalu$lo02<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        
		$oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("LO BLUD $id / $cbulan");
        $this->template->set('title', 'LO BLUD $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>LO BLUD $id / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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
	
	
	function lap_neraca_blud_konsol($cbulan="", $pilih=1){// created by henri_tb *koreksi galih
        $cetak		='2';//$ctk;
        $id     	= $this->session->userdata('kdskpd');
		//$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
		
			
					if($cbulan<10){
					 $xbulan="0$cbulan";
					 }
					else{
					$xbulan=$cbulan;
					}
	
		
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
		
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		

			
		$sqllo1="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('4') and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$cbulan' and reev IN ('0','2') and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo1= $this->db->query($sqllo1);
                    $penlo = $querylo1->row();
                    $pen_lo = $penlo->nilai;
                    $pen_lo1= number_format($penlo->nilai,"2",",",".");
        
		$sqllo2="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('4') and reev IN ('0','2') and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo2= $this->db->query($sqllo2);
                    $penlo2 = $querylo2->row();
                    $pen_lo_lalu = $penlo2->nilai;
                    $pen_lo_lalu1= number_format($penlo2->nilai,"2",",",".");
		
		$sqllo3="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('5') and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$cbulan' and reev IN ('0','2') and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo3= $this->db->query($sqllo3);
                    $bello = $querylo3->row();
                    $bel_lo = $bello->nilai;
                    $bel_lo1= number_format($bello->nilai,"2",",",".");
        
		$sqllo4="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('5') and reev IN ('0','2') and left(b.kd_skpd,7)=left('$id',7)";
                    $querylo4= $this->db->query($sqllo4);
                    $bello2 = $querylo4->row();
                    $bel_lo_lalu = $bello2->nilai;
                    $bel_lo_lalu1= number_format($bello2->nilai,"2",",",".");		

					$surplus_lo = $pen_lo - $bel_lo;
                    if ($surplus_lo < 0){
                    	$lo1="("; $surplus_lox=$surplus_lo*-1; $lo2=")";}
                    else {
                    	$lo1=""; $surplus_lox=$surplus_lo; $lo2="";}		
                    $surplus_lo1 = number_format($surplus_lox,"2",",",".");
                    
					$surplus_lo_lalu = $pen_lo_lalu - $bel_lo_lalu;
                    if ($surplus_lo_lalu < 0){
                    	$lo3="("; $surplus_lo_lalux=$surplus_lo_lalu*-1; $lo4=")";}
                    else {
                    	$lo3=""; $surplus_lo_lalux=$surplus_lo_lalu; $lo4="";}						
                    $surplus_lo_lalu1 = number_format($surplus_lo_lalux,"2",",",".");

					$selisih_surplus_lo = $surplus_lo - $surplus_lo_lalu;
                    if ($selisih_surplus_lo < 0){
                    	$lo5="("; $selisih_surplus_lox=$selisih_surplus_lo*-1; $lo6=")";}
                    else {
                    	$lo5=""; $selisih_surplus_lox=$selisih_surplus_lo; $lo6="";}
                    $selisih_surplus_lo1 = number_format($selisih_surplus_lox,"2",",",".");
                    
					if( $surplus_lo_lalu=='' or $surplus_lo_lalu==0){
					$persen2 = '0,00';
					}else{
					$persen2 = ($surplus_lo/$surplus_lo_lalu)*100;
					$persen2 = number_format($persen2,"2",",",".");
					}
					
		
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td rowspan=\"5\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
						 <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>NERACA BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";

        $sqlmaplo="select '1' bold, '1' kode, 'ASET' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '11' kode, 'ASET LANCAR' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '111' kode, 'Kas dan Setara Kas' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('111')
					union all
					select '4' bold, '112' kode, 'Investasi Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('112')
					union all
					select '4' bold, '113' kode, 'Piutang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('113')
					union all
					select '4' bold, '114' kode, 'Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('118')
					union all
					select '4' bold, '115' kode, 'Piutang Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('114')
					union all
					select '4' bold, '116' kode, 'Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('115')
					union all
					select '4' bold, '117' kode, 'Uang Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('116')
					union all
					select '4' bold, '118' kode, 'Biaya Dibayar di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('117')
					union all
					select '5' bold, '1189' kode, 'Jumlah Aset Lancar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('11')
					union all
					select '0' bold, '11899' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '12' kode, 'INVESTASI JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '121' kode, 'Investasi Non-Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('121')
					union all
					select '4' bold, '122' kode, 'Investasi Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('122')
					union all
					select '5' bold, '1229' kode, 'Jumlah Investasi Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('12')
					union all
					select '0' bold, '12299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '13' kode, 'ASET TETAP' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '131' kode, 'Tanah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('131')
					union all
					select '4' bold, '132' kode, 'Peralatan dan Mesin' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('132')
					union all
					select '4' bold, '133' kode, 'Gedung dan Bangunan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('133')
					union all
					select '4' bold, '134' kode, 'Jalan, Irigasi dan Jaringan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('134')
					union all
					select '4' bold, '135' kode, 'Aset Tetap Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('135')
					union all
					select '4' bold, '136' kode, 'Konstruksi dalam Pengerjaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('136')
					union all
					select '5' bold, '1369' kode, 'Jumlah Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('131','132','133','134','135','136')
					union all
					select '4' bold, '137' kode, 'Akumulasi Penyusutan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('137')
					union all
					select '5' bold, '1379' kode, 'Jumlah Nilai Buku Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('13')
					union all
					select '0' bold, '13799' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '14' kode, 'ASET LAINNYA' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '141' kode, 'Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('141')
					union all
					select '4' bold, '142' kode, 'Amortisasi Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('145')
					union all
					select '4' bold, '143' kode, 'Aset Kemitraan dengan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('142')
					union all
					select '4' bold, '144' kode, 'Aset Tetap Non-Produktif' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('143')
					union all
					select '4' bold, '145' kode, 'Aset Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('144')
					union all
					select '5' bold, '1459' kode, 'Jumlah Aset Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('14')
					union all
					select '5' bold, '14599' kode, 'JUMLAH ASET' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,1) in ('1')
					union all
					select '0' bold, '145999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '2' kode, 'KEWAJIBAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '21' kode, 'KEWAJIBAN JANGKA PENDEK' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '211' kode, 'Utang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('211')
					union all
					select '4' bold, '212' kode, 'Utang Pajak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('212')
					union all
					select '4' bold, '213' kode, 'Pendapatan Diterima di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('213')
					union all
					select '4' bold, '214' kode, 'Uang Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('214')
					union all
					select '4' bold, '215' kode, 'Biaya yang Masih Harus Dibayar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('215')
					union all
					select '4' bold, '216' kode, 'Titipan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('216')
					union all
					select '4' bold, '217' kode, 'Bagian Lancar Utang Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('217')
					union all
					select '4' bold, '218' kode, 'Utang Bunga Pinjaman' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '4' bold, '219' kode, 'Kewajiban Jangka Pendek Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '5' bold, '2199' kode, 'Jumlah Kewajiban Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('21')
					union all
					select '0' bold, '21999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '22' kode, 'KEWAJIBAN JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '221' kode, 'Utang Dalam Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('221')
					union all
					select '4' bold, '222' kode, 'Utang Luar Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('222')
					union all
					select '4' bold, '223' kode, 'Pendapatan yang Ditangguhkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('223')
					union all
					select '5' bold, '2239' kode, 'Jumlah Kewajiban Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('22')
					union all
					select '0' bold, '22399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '3' kode, 'EKUITAS' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '31' kode, 'EKUITAS TIDAK TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '311' kode, 'Ekuitas Awal' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('311')
					union all
					select '4' bold, '312' kode, 'Akumulasi Surplus/Defisit s.d. Tahun Lalu' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('312')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					union all	
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek,
					0 nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and LEFT(a.kd_rek5,3) in ('313')
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '4' bold, '314' kode, 'Ekuitas Donasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('314')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('31')
					union all
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '0' bold, '31499' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '32' kode, 'EKUITAS TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '321' kode, 'Ekuitas Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('321')
					union all
					select '4' bold, '322' kode, 'Ekuitas Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('322')
					union all
					select '5' bold, '3229' kode, 'Jumlah Ekuitas Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('32')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,1) in ('3')
					union all
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and reev IN ('0','2') and LEFT(a.kd_rek5,1) in ('2','3')
					union all
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where left(a.kd_unit,7)=left('$id',7) and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))
					) x
					group by x.bold,x.kode,x.nm_rek
					order by kode";
				   
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					$nilai   	= number_format($nil,"2",",",".");
					$nilai_lalu = number_format($nil_lalu,"2",",",".");
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and reev='0' and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and reev='0' and left(b.kd_skpd,7)=left('$id',7)";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai_lalu</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$surplus_lo1$lo2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo3$surplus_lo_lalu1$lo4<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        $oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("NERACA_BLUD KONSOL / $cbulan");
        $this->template->set('title', 'NERACA_BLUD KONSOL / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>NERACA_BLUD KONSOL / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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

	function lap_neraca_blud($cbulan="", $kdskpd="", $pilih=1){// created by henri_tb *koreksi galih
        $cetak		='2';//$ctk;
        //$id     	= $this->session->userdata('kdskpd');
		$id			= $kdskpd;
        $thn_ang 	= $this->session->userdata('pcThang');
        $thn_ang_1	= $thn_ang-1;  
	
	
					if($cbulan<10){
					 $xbulan="0$cbulan";
					 }
					else{
					$xbulan=$cbulan;
					}
	
	
		$sqldata="SELECT provinsi, kab_kota, daerah FROM sclient_blud WHERE kd_skpd='$id'";
                 $sqlpemda=$this->db->query($sqldata);
                 foreach ($sqlpemda->result() as $row)
                {
                    $provinsi=$row->provinsi;                    
                    $kab_kota= $row->kab_kota;
                    $daerah  = $row->daerah;
                }
		
       $sqldns="SELECT a.kd_urusan as kd_u,b.nm_urusan as nm_u,a.kd_skpd as kd_sk,a.nm_skpd as nm_sk FROM ms_skpd_blud a INNER JOIN ms_urusan_blud b ON a.kd_urusan=b.kd_urusan WHERE kd_skpd='$id'";
                 $sqlskpd=$this->db->query($sqldns);
                 foreach ($sqlskpd->result() as $rowdns)
                {
                    $kd_urusan=$rowdns->kd_u;                    
                    $nm_urusan= $rowdns->nm_u;
                    $kd_skpd  = $rowdns->kd_sk;
                    $nmskpd  = $rowdns->nm_sk;
                } 
		
		$nm_skpd = strtoupper($nmskpd);	
		

			
		$sqllo1="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('4') and month(b.tgl_voucher)<=$cbulan and reev IN ('0','2') and b.kd_skpd='$id'";
                    $querylo1= $this->db->query($sqllo1);
                    $penlo = $querylo1->row();
                    $pen_lo = $penlo->nilai;
                    $pen_lo1= number_format($penlo->nilai,"2",",",".");
        
		$sqllo2="select sum(kredit-debet) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('4') and reev IN ('0','2') and b.kd_skpd='$id'";
                    $querylo2= $this->db->query($sqllo2);
                    $penlo2 = $querylo2->row();
                    $pen_lo_lalu = $penlo2->nilai;
                    $pen_lo_lalu1= number_format($penlo2->nilai,"2",",",".");
		
		$sqllo3="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang and left(kd_rek5,1) in ('5') and month(b.tgl_voucher)<=$cbulan and reev IN ('0','2') and b.kd_skpd='$id'";
                    $querylo3= $this->db->query($sqllo3);
                    $bello = $querylo3->row();
                    $bel_lo = $bello->nilai;
                    $bel_lo1= number_format($bello->nilai,"2",",",".");
        
		$sqllo4="select sum(debet-kredit) as nilai from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd where year(tgl_voucher)=$thn_ang_1 and left(kd_rek5,1) in ('5') and reev IN ('0','2') and b.kd_skpd='$id'";
                    $querylo4= $this->db->query($sqllo4);
                    $bello2 = $querylo4->row();
                    $bel_lo_lalu = $bello2->nilai;
                    $bel_lo_lalu1= number_format($bello2->nilai,"2",",",".");		

					$surplus_lo = $pen_lo - $bel_lo;
                    if ($surplus_lo < 0){
                    	$lo1="("; $surplus_lox=$surplus_lo*-1; $lo2=")";}
                    else {
                    	$lo1=""; $surplus_lox=$surplus_lo; $lo2="";}		
                    $surplus_lo1 = number_format($surplus_lox,"2",",",".");
                    
					$surplus_lo_lalu = $pen_lo_lalu - $bel_lo_lalu;
                    if ($surplus_lo_lalu < 0){
                    	$lo3="("; $surplus_lo_lalux=$surplus_lo_lalu*-1; $lo4=")";}
                    else {
                    	$lo3=""; $surplus_lo_lalux=$surplus_lo_lalu; $lo4="";}						
                    $surplus_lo_lalu1 = number_format($surplus_lo_lalux,"2",",",".");

					$selisih_surplus_lo = $surplus_lo - $surplus_lo_lalu;
                    if ($selisih_surplus_lo < 0){
                    	$lo5="("; $selisih_surplus_lox=$selisih_surplus_lo*-1; $lo6=")";}
                    else {
                    	$lo5=""; $selisih_surplus_lox=$selisih_surplus_lo; $lo6="";}
                    $selisih_surplus_lo1 = number_format($selisih_surplus_lox,"2",",",".");
                    
					if( $surplus_lo_lalu=='' or $surplus_lo_lalu==0){
					$persen2 = '0,00';
					}else{
					$persen2 = ($surplus_lo/$surplus_lo_lalu)*100;
					$persen2 = number_format($persen2,"2",",",".");
					}
					
		
	 
	 $modtahun= $thn_ang%4;
	 
	 if ($modtahun = 0){
        $nilaibulan=".31 JANUARI.29 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
            else {
        $nilaibulan=".31 JANUARI.28 FEBRUARI.31 MARET.30 APRIL.31 MEI.30 JUNI.31 JULI.31 AGUSTUS.30 SEPTEMBER.31 OKTOBER.30 NOVEMBER.31 DESEMBER";}
	 
	 $arraybulan=explode(".",$nilaibulan);
        $cRet='';
        
       
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr>
                         <td rowspan=\"5\" align=\"center\" style=\"border-right:hidden\">
                        <img src=\"".base_url()."/image/logo.png\"  width=\"85\" height=\"85\" />
                        </td>
						 <td align=\"center\"><strong>$kab_kota</strong></td>                         
                    </tr>
					<tr>
                         <td align=\"center\"><strong>BADAN LAYANAN UMUM DAERAH (BLUD)</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong>$nm_skpd</strong></td>
                    </tr>
                    <tr>
                         <td align=\"center\"><h1><strong>NERACA BLUD</strong></h1></td>
                    </tr>                    
                    <tr>
                         <td align=\"center\"><strong>PER $arraybulan[$cbulan] $thn_ang DAN $thn_ang_1</strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
					<tr>
                         <td align=\"center\"><strong></strong></td>
                    </tr>
                  </table>";   
     
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>                       
                        <tr><td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>NO</b></td>                            
                            <td colspan =\"6\" bgcolor=\"#CCCCCC\" width=\"40%\" align=\"center\"><b>URAIAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"20%\" align=\"center\"><b>$thn_ang_1</b></td>
                        </tr>
                        
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td colspan =\"6\" style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                   
                     <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\" align=\"center\">&nbsp;</td>                            
                            <td colspan =\"6\" style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"40%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\">&nbsp;</td>
                        </tr>";

        $sqlmaplo="select '1' bold, '1' kode, 'ASET' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '11' kode, 'ASET LANCAR' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '111' kode, 'Kas dan Setara Kas' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('111')
					union all
					select '4' bold, '112' kode, 'Investasi Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('112')
					union all
					select '4' bold, '113' kode, 'Piutang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('113')
					union all
					select '4' bold, '114' kode, 'Penyisihan Piutang Tak Tertagih' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('118')
					union all
					select '4' bold, '115' kode, 'Piutang Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('114')
					union all
					select '4' bold, '116' kode, 'Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('115')
					union all
					select '4' bold, '117' kode, 'Uang Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('116')
					union all
					select '4' bold, '118' kode, 'Biaya Dibayar di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('117')
					union all
					select '5' bold, '1189' kode, 'Jumlah Aset Lancar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('11')
					union all
					select '0' bold, '11899' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '12' kode, 'INVESTASI JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '121' kode, 'Investasi Non-Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('121')
					union all
					select '4' bold, '122' kode, 'Investasi Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('122')
					union all
					select '5' bold, '1229' kode, 'Jumlah Investasi Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('12')
					union all
					select '0' bold, '12299' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '13' kode, 'ASET TETAP' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '131' kode, 'Tanah' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('131')
					union all
					select '4' bold, '132' kode, 'Peralatan dan Mesin' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('132')
					union all
					select '4' bold, '133' kode, 'Gedung dan Bangunan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('133')
					union all
					select '4' bold, '134' kode, 'Jalan, Irigasi dan Jaringan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('134')
					union all
					select '4' bold, '135' kode, 'Aset Tetap Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('135')
					union all
					select '4' bold, '136' kode, 'Konstruksi dalam Pengerjaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('136')
					union all
					select '5' bold, '1369' kode, 'Jumlah Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('131','132','133','134','135','136')
					union all
					select '4' bold, '137' kode, 'Akumulasi Penyusutan Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('137')
					union all
					select '5' bold, '1379' kode, 'Jumlah Nilai Buku Aset Tetap' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('13')
					union all
					select '0' bold, '13799' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '14' kode, 'ASET LAINNYA' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '141' kode, 'Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('141')
					union all
					select '4' bold, '142' kode, 'Amortisasi Aset Tak Berwujud' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('145')
					union all
					select '4' bold, '143' kode, 'Aset Kemitraan dengan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('142')
					union all
					select '4' bold, '144' kode, 'Aset Tetap Non-Produktif' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id'and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('143')
					union all
					select '4' bold, '145' kode, 'Aset Lain-lain' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('144')
					union all
					select '5' bold, '1459' kode, 'Jumlah Aset Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('14')
					union all
					select '5' bold, '14599' kode, 'JUMLAH ASET' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then debet-kredit else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then debet-kredit else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,1) in ('1')
					union all
					select '0' bold, '145999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '2' kode, 'KEWAJIBAN' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '21' kode, 'KEWAJIBAN JANGKA PENDEK' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '211' kode, 'Utang Usaha' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('211')
					union all
					select '4' bold, '212' kode, 'Utang Pajak' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('212')
					union all
					select '4' bold, '213' kode, 'Pendapatan Diterima di Muka' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('213')
					union all
					select '4' bold, '214' kode, 'Uang Persediaan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('214')
					union all
					select '4' bold, '215' kode, 'Biaya yang Masih Harus Dibayar' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('215')
					union all
					select '4' bold, '216' kode, 'Titipan Pihak Ketiga' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('216')
					union all
					select '4' bold, '217' kode, 'Bagian Lancar Utang Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('217')
					union all
					select '4' bold, '218' kode, 'Utang Bunga Pinjaman' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '4' bold, '219' kode, 'Kewajiban Jangka Pendek Lainnya' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('218')
					union all
					select '5' bold, '2199' kode, 'Jumlah Kewajiban Jangka Pendek' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('21')
					union all
					select '0' bold, '21999' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '22' kode, 'KEWAJIBAN JANGKA PANJANG' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '221' kode, 'Utang Dalam Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('221')
					union all
					select '4' bold, '222' kode, 'Utang Luar Negeri' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('222')
					union all
					select '4' bold, '223' kode, 'Pendapatan yang Ditangguhkan' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('223')
					union all
					select '5' bold, '2239' kode, 'Jumlah Kewajiban Jangka Panjang' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('22')
					union all
					select '0' bold, '22399' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '1' bold, '3' kode, 'EKUITAS' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '2' bold, '31' kode, 'EKUITAS TIDAK TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '311' kode, 'Ekuitas Awal' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('311')
					union all
					select '4' bold, '312' kode, 'Akumulasi Surplus/Defisit s.d. Tahun Lalu' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('312')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53'))  and reev IN ('0','2')
					union all	
					select '4' bold, '313' kode, 'Surplus/Defisit Tahun Berjalan' nm_rek,
					0 nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and LEFT(a.kd_rek5,3) in ('313')  and reev IN ('0','2')
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '4' bold, '314' kode, 'Ekuitas Donasi' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l  
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('314')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and LEFT(a.kd_rek5,7)<>'3130101' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('31')
					union all
					select '5' bold, '3149' kode, 'Jumlah Ekuitas Tidak Terikat' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53')) and reev IN ('0','2')
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select '0' bold, '31499' kode, '' nm_rek, 0 nilai, 0 nilai_l
					union all
					select '2' bold, '32' kode, 'EKUITAS TERIKAT' nm_rek, 0 nilai, 0 nilai_l 
					union all
					select '4' bold, '321' kode, 'Ekuitas Terikat Temporer' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('321')
					union all
					select '4' bold, '322' kode, 'Ekuitas Terikat Permanen' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,3) in ('322')
					union all
					select '5' bold, '3229' kode, 'Jumlah Ekuitas Terikat' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,2) in ('32')
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and LEFT(a.kd_rek5,7)<>'3130101' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,1) in ('3')
					union all
					select '5' bold, '32299' kode, 'JUMLAH EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53')) and reev IN ('0','2')
					) x
					group by x.bold,x.kode,x.nm_rek
					union all
					select x.bold,x.kode,x.nm_rek,sum(x.nilai) nilai,SUM(x.nilai_l) nilai_l from (
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang' and LEFT(a.kd_rek5,7)<>'3130101' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					isnull(sum(case when YEAR(tgl_voucher)<='$thn_ang_1' then kredit-debet else 0 end),0) nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and reev IN ('0','2') and LEFT(a.kd_rek5,1) in ('2','3')
					union all
					select '5' bold, '322999' kode, 'JUMLAH KEWAJIBAN DAN EKUITAS' nm_rek, 
					isnull(sum(case when YEAR(tgl_voucher)='$thn_ang' and left(CONVERT(char(15),tgl_voucher, 112),6)<='$thn_ang$xbulan' then kredit-debet else 0 end),0) nilai,
					0 nilai_l 
					from trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
					where a.kd_unit='$id' and tabel<>'5' and (LEFT(a.kd_rek5,1) in ('4') or Left(a.kd_rek5,2) in ('51','53')) and reev IN ('0','2')
					) x
					group by x.bold,x.kode,x.nm_rek
					order by kode";
					
                $querymaplo = $this->db->query($sqlmaplo);
                $no     = 0;                                  
               
                foreach ($querymaplo->result() as $loquery)
                {
                    $bold      	= $loquery->bold;
					$kode    	= $loquery->kode;
                    $nama     	= $loquery->nm_rek;   
                //  $n        	= $loquery->kode_1;
				//	$n		  	= ($n=="-"?"'-'":$n);
					$nil      	= $loquery->nilai;
					$nil_lalu  = $loquery->nilai_l;
					$nilai   	= number_format($nil,"2",",",".");
					$nilai_lalu = number_format($nil_lalu,"2",",",".");
					
		/*$quelo01   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang and month(b.tgl_voucher)<=$cbulan and reev='0' and b.kd_skpd='$id'";
                    $quelo02 = $this->db->query($quelo01);
                    $quelo03 = $quelo02->row();
                    $nil     = $quelo03->nilai;
                    $nilai    = number_format($quelo03->nilai,"2",",",".");
					
		$quelo04   = "SELECT SUM($normal) as nilai FROM trdju_blud a inner join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd WHERE left(kd_rek5,3) in ($n) and year(tgl_voucher)=$thn_ang_1 and reev='0' and b.kd_skpd='$id'";
                    $quelo05 = $this->db->query($quelo04);
                    $quelo06 = $quelo05->row();
                    $nil_lalu     = $quelo06->nilai;
                    $nilai_lalu    = number_format($quelo06->nilai,"2",",",".");*/
					
                    $real_nilai = $nil - $nil_lalu;
                    if ($real_nilai < 0){
                    	$lo0="("; $real_nilaix=$real_nilai*-1; $lo00=")";}
                    else {
                    	$lo0=""; $real_nilaix=$real_nilai; $lo00="";}
                    $real_nilai1 = number_format($real_nilaix,"2",",",".");
                    
					if( $nil_lalu=='' or $nil_lalu==0){
					$persen1 = '0,00';
					}else{
					$persen1 = ($nil/$nil_lalu)*100;
					$persen1 = number_format($persen1,"2",",",".");
					}
                    $no       = $no + 1;
                    switch ($loquery->bold) {
                    case 0:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 1:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td colspan =\"6\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 2:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"5\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"></td>
                                 </tr>";
                        break;
					case 3:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"4\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 4:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\">$no</td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"3\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\">$nama</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\">$nilai_lalu</td>
                                 </tr>";
                        break;	
					case 5:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td colspan =\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$nilai_lalu<b></td>
                                 </tr>";
                        break;
					case 6:
                         $cRet    .= "<tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"5%\" align=\"center\"><b>$no<b></td>                                     
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"2%\"></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;border-left: none;border-right: none;\" width=\"40%\"><b>$nama<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo1$surplus_lo1$lo2<b></td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"20%\" align=\"right\"><b>$lo3$surplus_lo_lalu1$lo4<b></td>
                                 </tr>";
                        break;
					
				}              
                    
                }
        
        $cRet .=       " </table>";
        
        	$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab FROM ms_ttd_blud where kd_skpd='$id' and kode='PA'";
            $sqlttd=$this->db->query($sqlttd1);
            foreach ($sqlttd->result() as $rowttd)
			
                {
                    $nip=$rowttd->nip;                    
                    $oioi= $rowttd->nm;
                    $jabatan = $rowttd->jab;
                }	
        $oioi = strtoupper($oioi);
		$jabatan = strtoupper($jabatan);
		
        $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> $daerah, $arraybulan[$cbulan] $thn_ang </td>
		 </tr>		
		 <tr>
		 <td align=\"center\" width=\"50%\">  </td>
		 <td align=\"center\" width=\"50%\"> $jabatan </td>
		 </tr>	
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		  <tr>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 <td align=\"center\" width=\"50%\"> &nbsp; </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"></td>
		 <td align=\"center\" width=\"50%\"> $oioi </td>
		 </tr>
		 <tr>
		 <td align=\"center\" width=\"50%\"> </td>
		 <td align=\"center\" width=\"50%\"> NIP :$nip </td>
		 </tr>
         </table>
		 ";
        
        $data['prev']= $cRet;
        $data['sikap'] = 'preview';
        $judul  = ("NERACA_BLUD $id / $cbulan");
        $this->template->set('title', 'NERACA_BLUD $id / $cbulan');        
        switch($pilih) {       
        case 1;
			echo ("<title>NERACA_BLUD $id / $cbulan</title>");
			 echo $cRet;
        break;
		case 4;
               $this->tukd_model->_mpdf('', $cRet, 10, 5, 10, '0');
				echo $cRet;
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

	function ctk_jurum_blud($dcetak='',$dcetak2='',$skpd=''){
   	        $csql11 = " select nm_skpd from ms_skpd_blud where kd_skpd = '$skpd'"; 
            $rs1 = $this->db->query($csql11);
            $trh1 = $rs1->row();
            $lcskpd = strtoupper ($trh1->nm_skpd);
            $tgl=$this->tukd_model->tanggal_format_indonesia($dcetak);
            $tgl2=$this->tukd_model->tanggal_format_indonesia($dcetak2);
            $tgl=strtoupper($tgl);
			$tgl2=strtoupper($tgl2);
			
		$cRet ="";	
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"60%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
            <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;\"><b>PEMERINTAH KOTA PONTIANAK
                </td>
            </tr>            
            <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;\"><b>$lcskpd
                </td>
            </tr>
             <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;\"><b>JURNAL UMUM BLUD
                </td>
            </tr>
            <tr>
                <td colspan=\"11\" align=\"center\" style=\"border: solid 1px white;border-bottom:solid 1px white;\"><b>PERIODE $tgl SAMPAI DENGAN $tgl2
                </td>
            </tr>
			</table>";
			
		$cRet .="<table style=\"border-collapse:collapse;\" width=\"90%\" align=\"center\" border=\"2\" cellspacing=\"0\" cellpadding=\"4\">
            <thead>
			<tr>
                <td align=\"center\"bgcolor=\"#CCCCCC\" rowspan=\"2\"><b>Tanggal</td>
                <td align=\"center\" bgcolor=\"#CCCCCC\"rowspan=\"2\"><b>Nomor<br>Bukti</td>
                <td colspan=\"5\"bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\"><b>Kode<br>Rekening</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\" rowspan=\"2\"><b>Uraian</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\" rowspan=\"2\"><b>ref</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\" colspan=\"2\"><b>Jumlah Rp</td>
            </tr>
			<tr>
                <td align=\"center\" bgcolor=\"#CCCCCC\"><b>Debit</td>
                <td align=\"center\"bgcolor=\"#CCCCCC\"><b>Kredit</td>
            </tr>
            <tr>
                <td align=\"center\" width=\"15%\";border-bottom:solid 1px red;\"><b>1</td>
                <td align=\"center\" width=\"10%\";border-bottom:solid 1px blue;\"><b>2</td>
                <td colspan=\"5\" align=\"center\" width=\"15%\"><b>3</td>
                <td align=\"center\" width=\"42%\"><b>4</td>
                <td align=\"center\" width=\"3%\"></td>
                <td align=\"center\" width=\"10%\"><b>5</td>
                <td align=\"center\" width=\"10%\"><b>6</td>
            </tr>
			</thead>
           ";
         
         $csql1 = "select count(*) as tot FROM 
                 trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher= b.no_voucher and a.kd_unit=b.kd_skpd 
                 where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd'"; 
         $rs = $this->db->query($csql1);
         $trh = $rs->row();
         
            
/*         $csql = "SELECT b.tgl_voucher,a.no_voucher,a.kd_rek5,(c.nm_rek64 + case when (pos='0') then '' else ''end) AS nm_rek5,a.debet,a.kredit FROM 
                  trdju_blud a LEFT JOIN trhju_blud b ON a.no_voucher= b.no_voucher join (SELECT kd_rek64,nm_Rek64 from ms_rek5 group by kd_rek64,nm_Rek64) c on a.kd_rek5=c.kd_rek64
                  where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd' 
                  ORDER BY b.tgl_voucher,a.no_voucher,a.urut,a.rk,a.kd_rek5";   
*/
		
		/* 25/10/2016
		$csql = "select b.tgl_voucher,a.no_voucher,a.kd_rek5, nm_rek5,a.debet,a.kredit,a.rk from trdju_blud a join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
				where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd' 
                  ORDER BY b.tgl_voucher,a.no_voucher,a.urut,a.rk,a.kd_rek5";*/
		
		$csql = "select b.tgl_voucher,a.no_voucher,a.kd_rek5, nm_rek5,a.debet,a.kredit,a.rk, left(a.kd_rek5,1) akun from trdju_blud a join trhju_blud b on a.no_voucher=b.no_voucher and a.kd_unit=b.kd_skpd
				where b.tgl_voucher >= '$dcetak' and b.tgl_voucher <= '$dcetak2' and b.kd_skpd = '$skpd'
                 ORDER BY b.tgl_voucher,a.no_voucher,a.urut,a.rk,a.kd_rek5
                  ";
		
         $query = $this->db->query($csql);  
         $cnovoc = '';
         $lcno = 0;
         foreach($query->result_array() as $res){
                $lcno = $lcno + 1;
                if ($lcno==$trh->tot){
                    $cRet .="<tr>
                                <td style=\"border-bottom:none;border-top:none;\"></td>
                                <td style=\"border-bottom:none;border-top:none;\"></td>
                                <td style=\"border-bottom:none;\">".substr($res['kd_rek5'],0,1)."</td>";
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,1)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],2,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],4,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,2)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],6,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],5,2)."</td>";}
                                $cRet .="<td style=\"border-bottom:none;\">".$res['nm_rek5']."</td>
                                <td style=\"border-bottom:none;\"></td>";
                                if($res['rk']=='K'){
                                    $cRet .=" <td style=\"border-bottom:none;\"></td>
                                            <td style=\"border-bottom:none;\" align=\"right\">".number_format($res['kredit'],"2",",",".")."</td>";
                                }else{$cRet .="<td style=\"border-bottom:none;\" align=\"right\">".number_format($res['debet'],"2",",",".")."</td>
                                               <td style=\"border-bottom:none;\"></td>";                                    
                                }
                       
                       $cRet .="</tr>"; 
                }else{
                        if($cnovoc==$res['no_voucher']){
                            $cRet .="<tr>
                                <td style=\"border-bottom:none;border-top:none;\">&nbsp;</td>
                                <td style=\"border-bottom:none;border-top:none;\">&nbsp;</td>
                                <td style=\"border-bottom:none;\">".substr($res['kd_rek5'],0,1)."</td>";
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,1)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],2,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],4,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,2)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],6,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],5,2)."</td>";}
                                $cRet .="<td style=\"border-bottom:none;\">".$res['nm_rek5']."</td>
                                <td style=\"border-bottom:none;\"></td>";
                                if($res['rk']=='K'){
                                    $cRet .=" <td style=\"border-bottom:none;\"></td>
                                            <td style=\"border-bottom:none;\" align=\"right\">".number_format($res['kredit'],"2",",",".")."</td>";
                                }else{$cRet .="<td style=\"border-bottom:none;\" align=\"right\">".number_format($res['debet'],"2",",",".")."</td>
                                               <td style=\"border-bottom:none;\"></td>";                                    
                                }
                       
                       $cRet .="</tr>";                    
                        }else{
                        $cRet .="<tr>
                                <td align=\"center\" style=\"border-bottom:none\">".$this->tukd_model->tanggal_ind($res['tgl_voucher'])."</td>
                                <td style=\"border-bottom:none\">".$res['no_voucher']."</td>
                                <td style=\"border-bottom:none;\">".substr($res['kd_rek5'],0,1)."</td>";
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],1,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,1)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],2,1)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],4,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],3,2)."</td>";}
								if($res['akun']=='5'){
                                $cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],6,2)."</td>";
								}else{$cRet .="<td style=\"border-bottom:none;\">".substr($res['kd_rek5'],5,2)."</td>";}
                                $cRet .="<td style=\"border-bottom:none;\">".$res['nm_rek5']."</td>
                                <td style=\"border-bottom:none;\"></td>";
                                if($res['rk']=='K'){
                                    $cRet .=" <td style=\"border-bottom:none;\"></td>
                                            <td style=\"border-bottom:none;\" align=\"right\">".number_format($res['kredit'],"2",",",".")."</td>";
                                }else{$cRet .="<td style=\"border-bottom:none;\" align=\"right\">".number_format($res['debet'],"2",",",".")."</td>
                                               <td style=\"border-bottom:none;\"></td>";                                    
                                }
                       
                       $cRet .="</tr>";
                        }
                        $cnovoc=$res['no_voucher'];
                }
                
            }
            
         $cRet .=" <tr>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                        <td style=\"border-top:none\"></td>
                    </tr>  
         </table>
         ";

			$data['prev']=$cRet; //'JURNAL UMUM';
			echo $cRet;
            //$this->tukd_model->_mpdf('',$cRet,5,5,10,'0');	
	
	} 
    
	
}
