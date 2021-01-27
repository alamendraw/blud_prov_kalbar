<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller master data kegiatan
 */

class Tukd_blud extends CI_Controller {

	public $org_keu = "";
	public $skpd_keu = "";

	function __construct()
	{	
		parent::__construct();
		$this->load->model('M_Sts');
		$this->load->model('M_Penagihan');
	}
    
    function penerimaan()
    {
        $data['page_title']= 'INPUT PENERIMAAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'INPUT PENERIMAAN');
        $this->template->load('template','tukd/penerimaan/penerimaan_blud_sdana',$data) ;
        //$this->tukd_model->set_log_activity();  
        
    }
	
	function lap_trm_str(){
        $data['page_title']= 'BUKU PENERIMAAN DAN PENYETORAN';
		$data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'BUKU PENERIMAAN DAN PENYETORAN');   
        $this->template->load('template','tukd/laporan/trm_str',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }
	
	function lap_rincian_objek(){
        $data['page_title']= 'BUKU PENERIMAAN DAN PENYETORAN';
		$data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'BUKU PENERIMAAN DAN PENYETORAN');   
        $this->template->load('template','tukd/laporan/rincian_objek',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }
	
	function penerimaan_lalu()
    {
        $data['page_title']= 'INPUT PENERIMAAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'INPUT PENERIMAAN ATAS PIUTANG TAHUN LALU');
        $this->template->load('template','tukd/penerimaan/penerimaan_lalu',$data) ;
        //$this->tukd_model->set_log_activity(); 
        
    } 

	function sts_kas()
    {
        $data['page_title']= 'INPUT SETOR KAS BLUD';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'INPUT SETOR KAS BLUD');
        $this->template->load('template','tukd/penerimaan/sts_kas',$data) ;
        //$this->tukd_model->set_log_activity(); 
    }
	
	function daftar_penguji()
    {
        $data['page_title']= 'INPUT DAFTAR PENGUJI';
		 $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'INPUT DAFTAR PENGUJI');   
        $this->template->load('template','tukd/sp2d/daftar_penguji',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }
	
    function lpj_blud()
    {
        $data['page_title']= 'INPUT LPJ BLUD';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'INPUT LPJ BLUD');
        $this->template->load('template','tukd/transaksi/lpj_blud',$data) ;
        //$this->tukd_model->set_log_activity(); 
        
    }

    function register_blud()
    {
        $data['page_title']= 'REGISTER PENERIMAAN';
        $this->template->set('title', 'REGISTER PENERIMAAN');
        $this->template->load('template','tukd/laporan/register_blud',$data) ;

        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }

     function bku_penerimaan()
    {
        $data['page_title']= 'BKU PENERIMAAN';
        $this->template->set('title', 'BKU PENERIMAAN');
        $this->template->load('template','tukd/laporan/bku_penerimaan',$data) ;

        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }

    function bku_pengeluaran(){
        $data['page_title']= 'BKU PENGELUARAN';
        $this->template->set('title', 'BKU PENGELUARAN');
        $this->template->load('template','tukd/laporan/bku_pengeluaran',$data) ;

        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }
	
	function lap_pendapatan(){
        $data['page_title']= 'LAP. PENDAPATAN';
        $this->template->set('title', 'LAP. PENDAPATAN');
        $this->template->load('template','tukd/laporan/lap_pendapatan',$data) ;

        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }
	
	function lap_pengeluaran (){
        $data['page_title']= 'LAP. PENGELUARAN';
        $this->template->set('title', 'LAP. PENGELUARAN');
        $this->template->load('template','tukd/laporan/lap_pengeluaran',$data) ;

        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }
	
	function lap_matrix_pendapatan(){
        $data['page_title']= 'LAP. MATRIX PENERIMAAN';
        $this->template->set('title', 'LAP. MATRIX PENERIMAAN');
        $this->template->load('template','tukd/laporan/matrix_penerimaan',$data) ;

        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }

    function register_pengeluaran_blud(){
        $data['page_title']= 'INPUT PENERIMAAN';
        $this->template->set('title', 'INPUT PENERIMAAN');
        $this->template->load('template','tukd/laporan/register_pengeluaran_blud',$data) ; 
        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity(); 
        
    }

    function spj_pengeluaran(){
        $data['page_title']= 'INPUT PENERIMAAN';
        $this->template->set('title', 'INPUT PENGELUARAN');
        $this->template->load('template','tukd/laporan/spj_pengeluaran',$data) ;
        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity();  
        
    }

	
     function spj_penerimaan()
    {
        $data['page_title']= 'INPUT PENERIMAAN';
        $this->template->set('title', 'INPUT PENERIMAAN');
        $this->template->load('template','tukd/laporan/spj_terima',$data) ;
        $iduser     = $this->session->userdata('Display_name');
        $session_id = $this->session->userdata('session_id');
        $skpd       = $this->session->userdata('kdskpd');
        //$this->tukd_model->set_log_activity();  
        
    }

	function sts_ini(){
        $data['page_title']= 'INPUT STS';
        $this->template->set('title', 'INPUT STS');   
        $this->template->load('template','tukd/penerimaan/penyetoran_ini',$data) ; 
    }
	
	function sts_lalu(){
        $data['page_title']= 'INPUT STS LALU';
        $this->template->set('title', 'INPUT STS LALU');   
        $this->template->load('template','tukd/penerimaan/penyetoran_lalu',$data) ; 
    }
	
	function penagihan_ls(){
        $data['page_title']= 'INPUT PENAGIHAN LS';
        $this->template->set('title', 'INPUT PENAGIHAN LS');   
        $this->template->load('template','tukd/transaksi/penagihan_ls',$data) ; 
    }
	
	
	function kartu_kendali()
    {
        $data['page_title']= 'KARTU KENDALI KEGIATAN ';
        $this->template->set('title', 'KARTU KENDALI KEGIATAN');   
        $this->template->load('template','tukd/transaksi/kartu_kendali',$data) ; 
    }
	
	function dth()
    {
        $data['page_title']= 'CETAK DTH';
        $this->template->set('title', 'CETAK DTH');   
        $this->template->load('template','tukd/transaksi/dth',$data) ; 
    }
	
	function skpd__pend() {
		$usernm      = $this->session->userdata('pcNama');
        $kd_skpd = $this->session->userdata('kdskpd');
       
			$sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd_blud where kd_skpd = '$kd_skpd' ";
	
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_skpd' => $resulte['kd_skpd'],  
                        'nm_skpd' => $resulte['nm_skpd'],  
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result(); 	  
	}	
	
	
	function load_ttd($ttd){
        $kd_skpd = $this->session->userdata('kdskpd'); 
		$sql = "SELECT * FROM ms_ttd_blud WHERE kd_skpd= '$kd_skpd' and kode='$ttd'";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
	}

        function load_ttd_konsol($ttd){
        $kd_skpd = $this->session->userdata('kdskpd'); 
        $oke=$this->input->post('q');
        $sql = "SELECT * FROM ms_ttd_blud where upper(nama) like upper('%$oke%') ";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
           
    }
	
	function load_jns_str(){
        $lccr ='[{   
        "id":"1",  
        "text":"Melewati Bendahara"  
    },{  
        "id":"5",  
        "text":"Langsung Ke Kas BLUD"  
    },{  
        "id":"6",  
	"text":"Pengembalian Silpa" }]';  
    echo $lccr;
    }  

	function load_pay(){
        $lccr ='[{   
        "id":"Tunai",  
        "text":"TUNAI"  
    },{  
        "id":"Bank",  
        "text":"BANK"  
    }]';  
    echo $lccr;
    }  
	
	function load_sp2d_sts($cskpd='') {
			$lccr = $this->input->post('q');
            $kode = $this->uri->segment(3);
            $lcskpd  = $this->session->userdata('kdskpd');
           
			$sql = "SELECT distinct no_sp2d,jns_spp, CASE jns_spp WHEN '4' THEN 'LS GAJI' WHEN '5' THEN 'LS GAJI DAN PENAGIHAN' WHEN '6' THEN 'LS BARANG/JASA' WHEN '1' THEN 'UP' WHEN '2' THEN 'GU' ELSE 'TU' END AS jns_cp from trhtransout_blud  WHERE kd_skpd = '$lcskpd' AND upper(no_sp2d) like upper('%$lccr%') order by jns_cp" ;
			
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'no_sp2d' => $resulte['no_sp2d'],
							'jns_spp' => $resulte['jns_spp'],
							'jns_cp' => $resulte['jns_cp']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
        	   
    	}
	
	function load_trskpd_sts_ag() {
            $sp2d='';        
			$sp2d = str_replace('123456789','/',$this->uri->segment(3));
            $lcskpd  = $this->session->userdata('kdskpd');
			
            $sql = "select distinct b.kd_kegiatan, b.nm_kegiatan from trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti
			        where b.no_sp2d='$sp2d' and b.kd_skpd='$lcskpd'";  

			
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kd_kegiatan' => $resulte['kd_kegiatan'],  
                            'nm_kegiatan' => $resulte['nm_kegiatan']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
        	   
    	}
		
	function cetak_dth($lcskpd='',$nbulan='',$ctk=''){
        $nomor = str_replace('123456789',' ',$this->uri->segment(6));
		$nip2 = str_replace('123456789',' ',$this->uri->segment(7));
		$tanggal_ttd = $this->tukd_model->tanggal_format_indonesia($this->uri->segment(8));
        $atas = $this->uri->segment(9);
        $bawah = $this->uri->segment(10);
        $kiri = $this->uri->segment(11);
        $kanan = $this->uri->segment(12);

        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where nip='$nip2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where nip = '$nomor'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		
			$cRet ='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>DAFTAR TRANSAKSI HARIAN BELANJA DAERAH (DTH) <br>
											BULAN '.strtoupper($this->tukd_model->getBulan($nbulan)).'</TD>
					</TR>
					</TABLE><br/>';

			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%">
					 <TR>
						<TD align="left" width="20%" >SKPD</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kepala SKPD</TD>
						<TD align="left">: '.$nama.'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="2" cellpadding="2" align="center">
					 <thead>
					 <TR>
						<TD rowspan="2" width="80" bgcolor="#CCCCCC" align="center" >No.</TD>
                        <TD colspan="2" width="90"  bgcolor="#CCCCCC" align="center" >SPM/SPD</TD>
						<TD colspan="2" width="150"  bgcolor="#CCCCCC" align="center" >SP2D </TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >Akun Belanja</TD>
						<TD colspan="3" width="150" bgcolor="#CCCCCC" align="center" >Potongan Pajak</TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >NPWP</TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >Nama Rekanan</TD>
						<TD rowspan="2" width="80" bgcolor="#CCCCCC" align="center" >NTPN</TD>
						<TD rowspan="2" width="150" bgcolor="#CCCCCC" align="center" >Ket</TD>
					 </TR>
					 <TR>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" >No. SPM</TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" >Nilai Belanja(Rp)</TD>						
						<TD width="150"  bgcolor="#CCCCCC" align="center" >No. SP2D </TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >Nilai Belanja (Rp)</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >Akun Potongan</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >Jenis</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" >jumlah (Rp)</TD>
					 </TR>
					 </thead>
					 ';
			
			
				$query = $this->db->query("select 1 urut, c.no_spm,c.total,c.no_sp2d,x.nil_trans as nilai_belanja,'' no_bukti,'' kode_belanja,
					'' as kd_rek5,'' as jenis_pajak,0 as nilai_pot,'' as npwp,
					'' as nmrekan,z.banyak, ''ket,c.jns_spp, '' ntpn
					FROM trhstrpot_blud a  
					INNER JOIN trdstrpot_blud b 
					ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c 
					ON a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					LEFT JOIN 
					(SELECT b.kd_skpd, a.no_sp2d, SUM(a.nilai) as nil_trans FROM trdtransout_blud a 
					INNER JOIN trhtransout_blud b ON a.kd_skpd=b.kd_skpd AND a.no_bukti=b.no_bukti
					WHERE b.kd_skpd='$lcskpd'
					GROUP BY b.kd_skpd, a.no_sp2d) x
					ON a.kd_skpd=x.kd_skpd AND a.no_sp2d=x.no_sp2d
					LEFT JOIN 
					(SELECT b.kd_skpd,b.no_sp2d, COUNT(b.no_sp2d) as banyak
					FROM trdstrpot_blud a JOIN trhstrpot_blud b ON a.no_bukti = b.no_bukti and a.kd_skpd=b.kd_skpd
					WHERE b.kd_skpd = '$lcskpd' AND month(b.tgl_bukti)='$nbulan' 
					AND RTRIM(a.kd_rek5) IN ('2130301','2130101','2130201','2130401','2130501','2130601')
					GROUP BY b.kd_skpd,b.no_sp2d)z 
					ON a.kd_skpd=z.kd_skpd and a.no_sp2d=z.no_sp2d
					WHERE a.kd_skpd = '$lcskpd' AND month(a.tgl_bukti)='$nbulan'
					AND b.kd_rek5 IN ('2130301','2130101','2130201','2130401','2130501','2130601')
					GROUP BY c.no_spm,c.total,c.no_sp2d,x.nil_trans,z.banyak,c.jns_spp
					UNION ALL
					SELECT 2 as urut, '' as no_spm,0 as nilai,b.no_sp2d as no_sp2d,0 as nilai_belanja,
					a.no_bukti, kd_kegiatan+'.'+a.kd_rek_trans as kode_belanja,RTRIM(a.kd_rek5),'' as jenis_pajak,a.nilai as nilai_pot,npwp,
					nmrekan,0 banyak, 'No Set: '+a.no_bukti as ket,'' jns_spp, a.ntpn
					FROM trdstrpot_blud a JOIN trhstrpot_blud b ON a.no_bukti = b.no_bukti and a.kd_skpd=b.kd_skpd
					WHERE b.kd_skpd = '$lcskpd' AND month(b.tgl_bukti)='$nbulan'
					AND RTRIM(a.kd_rek5) IN ('2130301','2130101','2130201','2130401','2130501','2130601')
					ORDER BY no_sp2d,urut,no_spm,kode_belanja,kd_rek5");  
				$lcno=0;
				$tot_nilai=0;
				$tot_nilai_belanja=0;
				$tot_nilai_pot=0;
				foreach ($query->result() as $row) {
                    $no_spm = $row->no_spm; 
                    $nilai = $row->total;    
					$nilai_belanja =$row->nilai_belanja;
                    $no_sp2d = $row->no_sp2d;
                    $jns_spp = $row->jns_spp;
					if($jns_spp=='2'){
					$nilai_belanja =$nilai;	
					}
                    $kode_belanja=$row->kode_belanja;
                    $kd_rek5 = $row->kd_rek5;
                    $jenis_pajak = $row->jenis_pajak;
                    $nilai_pot = $row->nilai_pot;
                    $npwp = $row->npwp;
					$ntpn = $row->ntpn;
                    $nmrekan  = $row->nmrekan;
                    $ket  = $row->ket;
					$banyak  = ($row->banyak)+1;
					if (($row->urut)==1){
						   $lcno = $lcno + 1;
					   } 
					
					if($kd_rek5=='2130301'){
						$kd_rek5='411211';
						$jenis_pajak='PPn';
					}
					if($kd_rek5=='2130101'){
						$kd_rek5='411121';
						$jenis_pajak='PPh 21';
					}
					if($kd_rek5=='2130201'){
						$kd_rek5='411122';
						$jenis_pajak='PPh 22';
					}
					if($kd_rek5=='2130401'){
						$kd_rek5='411124';
						$jenis_pajak='PPh 23';
					}
					if($kd_rek5=='2130501'){
						$kd_rek5='411128';
						$jenis_pajak='PPh 4';
					}
					if($kd_rek5=='2130601'){
						$kd_rek5='411128';
						$jenis_pajak='PPh 4 Ayat (2)';
					}
					
				if (($row->urut)==1){
							$cRet.='<TR>
								<TD width="80" valign="top" align="center">'.$lcno.'</TD>
								<TD width="90" valign="top" >'.$no_spm.'</TD>
								<TD width="150" valign="top" align="right" >'.number_format($nilai,'2','.',',').'</TD>								
								<TD width="150" valign="top" >'.$no_sp2d.'</TD>
								<TD width="150" valign="top" align="right" >'.number_format($nilai_belanja,'2','.',',').'</TD>
								<TD width="150" align="right" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" align="left" ></TD>
								<TD width="150" valign="top" align="left" > </TD>
							 </TR>';	
						} else{
							$cRet.='<TR>
								<TD align="right" style="border-top:hidden;" ></TD>
								<TD align="right" style="border-top:hidden;" ></TD>
								<TD align="right" style="border-top:hidden;"></TD>
								<TD align="right" style="border-top:hidden;"></TD>
								<TD align="right" style="border-top:hidden;"></TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$kode_belanja.'</TD>
								<TD width="150" valign="top" align="center"  style="border-top:hidden;">'.$kd_rek5.'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$jenis_pajak.'</TD>
								<TD width="150" valign="top" align="right" style="border-top:hidden;" >'.number_format($nilai_pot,'2','.',',').'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$npwp.'</TD>
								<TD width="150" valign="top" align="left"  style="border-top:hidden;">'.$nmrekan.'</TD>
								<TD align="right" style="border-top:hidden;">'.$ntpn.'</TD>
								<TD style="border-top:hidden;" width="150" valign="top" align="left" >'.$ket.'</TD>
							 </TR>';
							
						}
				$tot_nilai=$tot_nilai+$nilai;
				$tot_nilai_belanja=$tot_nilai_belanja+$nilai_belanja;
				$tot_nilai_pot=$tot_nilai_pot+$nilai_pot;
				}
			$cRet .='<TR>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" >Total</TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" >'.$lcno.'</TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="right" >'.number_format($tot_nilai,'2','.',',').'</TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ></TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="right" >'.number_format($tot_nilai_belanja,'2','.',',').'</TD>
                        <TD width="90"  bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150"  bgcolor="#CCCCCC" align="center" ></TD>						
						<TD width="150"  bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="right" >'.number_format($tot_nilai_pot,'2','.',',').'</TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
						<TD width="150" bgcolor="#CCCCCC" align="center" ></TD>
					 </TR>';
			

			$cRet .='</TABLE>';
			
			$cRet .='<TABLE style="font-size:14px;" width="100%" align="center">
					<TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" >Mengetahui,</TD>
						<TD width="50%" align="center" >'.$daerah.', '.$tanggal_ttd.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" >'.$jabatan.'</TD>
						<TD width="50%" align="center" >'.$jabatan1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
					 <TR>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
						<TD width="50%" align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" ><b><u>'.$nama.'</u></b><br>'.$pangkat.'</TD>
						<TD width="50%" align="center" ><b><u>'.$nama1.'</u></b><br>'.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD width="50%" align="center" >'.$nip.'</TD>
						<TD width="50%" align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'DTH';
             switch ($ctk)
        {
            case 0;
			echo ("<title>DTH</title>");
				echo $cRet;
				break;
            case 1;
				$this->_mpdf_margin('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);
			   break;
		}
	}

    function sp3b(){
        $data['page_title']= 'CETAK SP3B';
        $this->template->set('title', 'CETAK SP3B');   
        $this->template->load('template','tukd/laporan/sp3b',$data) ;   
    }

    function preview_sp3b($cbulan="12", $pilih=1){
        $id  = $this->session->userdata('kdskpd');
        $thn = $this->session->userdata('pcThang');
        $tanggalttd = $this->uri->segment(5);
        $ttd1 = str_replace('a',' ',$this->uri->segment(6));
        $ctgl_ttd = $this->tukd_model->tanggal_format_indonesia($tanggalttd);

        echo "$id, $thn";

        $cRet ='<table style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
                    <tr></tr>
                    <tr>
                        <td align="center" ><b>PEMERINTAH KOTA PONTIANAK  <br> SURAT PERNYATAAN PENGESAHAN PENDAPATAN DAN BELANJA (SP3B) <br> TAHUN '.$thn.'</b> <br>Tanggal : '.$ctgl_ttd.' &emsp; Nomor : 03/'.$id.'/SP3B/'.substr($tanggalttd,0,4).'<hr/></td>
                    </tr>
                </table>'; 

        $oke="
        SELECT sum(satu) modal, sum(dua) barang, sum(tiga) pegawai, sum(empat) pendapatan from (
        SELECT isnull(sum(nilai_real),0) satu, 0 dua, 3 tiga, 4 empat FROM data_realisasi_keg4_blud(12,2,2019)
        WHERE kd_skpd='1.02.01.24' and left(kd_rek5,2)=53
        union ALL
        SELECT 0 satu, isnull(sum(nilai_real),0) dua, 0 tiga, 4 empat FROM data_realisasi_keg4_blud(12,2,2019)
        WHERE kd_skpd='1.02.01.24' and left(kd_rek5,2)=52
        union all
        SELECT 0 satu, 0 dua, sum(nilai_real) tiga, 0 empat FROM data_realisasi_keg4_blud(12,2,2019)
        WHERE kd_skpd='1.02.01.24' and left(kd_rek5,2)=51
        union ALL
        SELECT 0 satu, 0 dua,0 tiga, isnull(sum(nilai_real),0) empat FROM data_realisasi_keg4_blud(12,2,2019)
        WHERE kd_skpd='1.02.01.24' and left(kd_rek5,1)=4)oke";
        

        $jiwa=$this->db->query($oke);
        foreach($jiwa->result() as $a){
            $pegawai  =$a->pegawai;
            $barang   =$a->barang;
            $modal    =$a->modal;
            $pendapatan=$a->pendapatan;
            $total=$pegawai+$barang+$modal;
        }

        $cRet .='<table style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
                    <tr>
                        <td colspan="2">
                            Kepala SKPD Dinas Kesehatan Kota Pontianak memohon kepada : <br> Bendahara Umum Daerah Selaku PPKD <br> Agar mengesahkan dan membukukan pendapatan dan belanja dana BLUD sejumlah :
                        </td>
                    </tr>
                    <tr>
                        <td align="left" width="25%" > &emsp; &emsp;
                            1. Saldo Awal               <br>&emsp; &emsp;
                            2. Pendapatan               <br>&emsp; &emsp;
                            3. Belanja                  <br>&emsp; &emsp;&emsp; &emsp;
                              a. Pegawai                <br> &emsp; &emsp;&emsp; &emsp;
                              b. Barang dan Jasa        <br> &emsp; &emsp;&emsp; &emsp;
                              c. Modal                  <br> &emsp; &emsp;
                            4. Saldo Akhir              <br>
                        </td>
                        <td>
                            : <br>
                            : Rp. '.number_format($pendapatan,'2','.',',').'<br>
                              <br>
                            : Rp. '.number_format($pegawai,'2','.',',').'<br>
                            : Rp. '.number_format($barang,'2','.',',').'<br>
                            : Rp. '.number_format($modal,'2','.',',').'<br>
                            : 
                        </td>
                    </tr>
                </table>'; 
        $cRet .='<table style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="0" cellpadding="1" align=center>
                    <tr>
                        <td colspan="4">dsd</td>
                    </tr>
                    <tr>
                        <td width="25%">Dasar Pengesahan</td>
                        <td width="25%">Urusan <br> 1.01 Kesehatan</td>
                        <td width="25%">Organisasi <br> '.$id.'</td>
                        <td width="25%">sdsd</td>
                    </tr>
                </table>';


        $cRet .='<table style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="0" cellpadding="1" align=center>
                    <thead>
                    <tr>
                        <td colspan="2" align="center"><b>Pendapatan</b></td>
                        <td colspan="3"align="center"><b>Belanja</b></td>
                    </tr>
                    <tr>
                        <td width="20%" align="center"><b>Kode Rekening</b></td>
                        <td width="20%" align="center"><b>Jumlah</b></td>
                        <td width="30%" align="center" colspan="2"><b>Kode Rekening</b></td>
                        <td width="20%" align="center"><b>Jumlah</b></td>
                    </tr>
                    </thead>';
        $oke="SELECT *, b.nm_rek5 FROM data_realisasi_keg4_blud(12,2,2019) a
            inner join ms_rek5_blud b on a.kd_rek5=b.kd_rek5
            where kd_skpd='1.02.01.24' and nilai_real <> 0 and left(a.kd_rek5,1)=4";
        $jiwa=$this->db->query($oke);
        foreach($jiwa->result() as $a){
            $kd_rek5    =$a->kd_rek5;
            $nilai_real  =$a->nilai_real;
            $nm_rek5= $a->nm_rek5;
        

            $cRet .='   <tr>
                            <td width="20%" align="center">'.$kd_rek5.'</td>
                            <td width="20%" align="right">&ensp; '.number_format($nilai_real,'2','.',',').' &ensp;</td>
                            <td width="10%" align="center"></td>
                            <td width="20%" align="center"></td>
                            <td width="20%" align="right"></td>
                        </tr>';
        }

        $oke="SELECT *, b.nm_rek5 FROM data_realisasi_keg4_blud(12,2,2019) a
            inner join ms_rek5_blud b on a.kd_rek5=b.kd_rek5
            where kd_skpd='1.02.01.24' and nilai_real <> 0 and left(a.kd_rek5,1)=5";
        $jiwa=$this->db->query($oke);
        foreach($jiwa->result() as $a){
            $kd_rek5    =$a->kd_rek5;
            $nilai_real  =$a->nilai_real;
            $nm_rek5= $a->nm_rek5;
        

            $cRet .='   <tr>
                            <td width="20%" align="center"></td>
                            <td width="20%" align="right">&ensp;&ensp;</td>
                            <td width="10%" align="center">'.$kd_rek5.'</td>
                            <td width="20%" align="left">'.$nm_rek5.'</td>
                            <td width="20%" align="right">'.number_format($nilai_real,'2','.',',').' </td>
                        </tr>';
        }

        $cRet .='   <tr>
                        <td width="20%" align="center"><b>Jumlah Pendapatan</b></td>
                        <td width="20%" align="center">Rp. '.number_format($pendapatan,'2','.',',').'</td>
                        <td width="30%" align="center" colspan="2"><b>Jumlah Belanja</b></td>
                        <td width="20%" align="right">Rp. '.number_format($total,'2','.',',').'</td>
                    </tr>

                </table>';


        $oke="SELECT nm_skpd from ms_skpd_blud where kd_skpd='$id'";
        $jiwa=$this->db->query($oke);
        foreach($jiwa->result() as $a ){
            $nm_skpd=$a->nm_skpd;
        }
        $cRet .='<table style="border-collapse:collapse; font-size:14px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
                    <tr>
                        <td width="70%">&emsp;</td>
                        <td width="30%" align="center">
                            <br>Pontianak, '.$ctgl_ttd.' <br>
                            Kepala '.$nm_skpd.'
                            <br>
                            <br>
                            <br>
                            <br><u>Oke Jiwa S.Oj </u><br>
                            12344567898765
                        </td>
                    </tr>

                </table>';  
echo "$cRet";

    }
	


function proses_rekal_lpj(){

        $user     = $this->session->userdata('pcNama');
        $skpd_bp  = "1.02.01.00";
        $inittw   = 8;
        $last_update = date('Y-m-d H:i:s');
        
        if($inittw=='1'){
            $init_bulan1 = '1';
            $init_bulan2 = '1'; 
            $int_tw      = '01';
            $int_tw2     = 'JANUARI';
            $cket        = 'JANUARI TAHUN 2019';
            $ntgllpj     = '2019-01-31';
            
            $csql1 = "DELETE FROM trhlpj_blud";
            $query = $this->db->query($csql1);
        
            $csql2 = "DELETE FROM trlpj_blud";
            $query = $this->db->query($csql2);
        
            $csql3 = "DELETE FROM trhsp3b_blud";
            $query = $this->db->query($csql3);
        
            $csql4 = "DELETE FROM trsp3b_blud";
            $query = $this->db->query($csql4);
        
        }else
        if($inittw=='2'){
            $init_bulan1 = '2';
            $init_bulan2 = '2'; 
            $int_tw      = '02';
            $int_tw2     = 'FEBRUARI';
            $cket        = 'FEBRUARI TAHUN 2019';
            $ntgllpj     = '2019-02-28';
        }else
        if($inittw=='3'){
            $init_bulan1 = '3';
            $init_bulan2 = '3'; 
            $int_tw      = '03';
            $int_tw2     = 'MARET';
            $cket        = 'MARET TAHUN 2019';
            $ntgllpj     = '2019-03-31';
        }else
        if($inittw=='4'){
            $init_bulan1 = '4';
            $init_bulan2 = '4'; 
            $int_tw      = '04';
            $int_tw2     = 'APRIL';
            $cket        = 'APRIL TAHUN 2019';
            $ntgllpj     = '2019-04-30';
        }else
        if($inittw=='5'){
            $init_bulan1 = '5';
            $init_bulan2 = '5'; 
            $int_tw      = '05';
            $int_tw2     = 'MEI';
            $cket        = 'MEI TAHUN 2019';
            $ntgllpj     = '2019-04-31';
        }else
        if($inittw=='6'){
            $init_bulan1 = '6';
            $init_bulan2 = '6'; 
            $int_tw      = '06';
            $int_tw2     = 'JUNI';
            $cket        = 'JUNI TAHUN 2019';
            $ntgllpj     = '2019-06-30';
        }else
        if($inittw=='7'){
            $init_bulan1 = '7';
            $init_bulan2 = '7'; 
            $int_tw      = '07';
            $int_tw2     = 'JULI';
            $cket        = 'JULI TAHUN 2019';
            $ntgllpj     = '2019-07-31';
        }else
        if($inittw=='8'){
            $init_bulan1 = '8';
            $init_bulan2 = '8'; 
            $int_tw      = '08';
            $int_tw2     = 'AGUSTUS';
            $cket        = 'AGUSTUS TAHUN 2019';
            $ntgllpj     = '2019-08-31';
        }else
        if($inittw=='9'){
            $init_bulan1 = '9';
            $init_bulan2 = '9'; 
            $int_tw      = '09';
            $int_tw2     = 'SEPTEMBER';
            $cket        = 'SEPTEMBER TAHUN 2019';
            $ntgllpj     = '2019-09-30';
        }else
        if($inittw=='10'){
            $init_bulan1 = '10';
            $init_bulan2 = '10'; 
            $int_tw      = '10';
            $int_tw2     = 'OKTOBER';
            $cket        = 'OKTOBER TAHUN 2019';
            $ntgllpj     = '2019-12-31';
        }else
        if($inittw=='11'){
            $init_bulan1 = '11';
            $init_bulan2 = '11'; 
            $int_tw      = '11';
            $int_tw2     = 'NOVEMBER';
            $cket        = 'NOVEMBER TAHUN 2019';
            $ntgllpj     = '2019-11-30';
        }    else
        if($inittw=='12'){
            $init_bulan1 = '12';
            $init_bulan2 = '12'; 
            $int_tw      = '12';
            $int_tw2     = 'DESEMBER';
            $cket        = 'DESEMBER TAHUN 2019';
            $ntgllpj     = '2019-12-31';
        }                         
        
        $sql_skpd    = "select kd_skpd,nm_skpd from ms_skpd_blud order by kd_skpd";           
        $query_skpd = $this->db->query($sql_skpd);          
        
        $number = $this->db->query("select count(number_sp2b) as number from trhsp3b_blud")->row();
        $number_sp3b = $number->number;
        
        $ii     = 0;
        foreach($query_skpd->result_array() as $hasil)
        { 
           $ii = $number_sp3b+1; 
           $initskpd = $hasil['kd_skpd'];
           $initnmskpd = $hasil['nm_skpd'];      
       
        $nlpj  = $int_tw."/".$initskpd."/LPJ/".$int_tw2."/2019"; 
        $nsp3b = $int_tw."/".$initskpd."/SP2B/".$int_tw2."/2019"; 
        $nsp2b = $ii."/".$int_tw."/".$initskpd."/SPB/".$int_tw2."/2019";         
        
        $csql_hlpj = "INSERT INTO trhlpj_blud (no_lpj,kd_skpd,keterangan,tgl_lpj,status,bulan,jenis) values ('$nlpj','$initskpd','$cket','$ntgllpj','0','$init_bulan2','1')";
        $query1 = $this->db->query($csql_hlpj);
        
        $cload_total = $this->db->query("       
                   SELECT sum(c.total) total FROM(
                   SELECT isnull(sum(a.nilai*-1),0) as total
                   FROM TRDINLAIN_blud a inner join TRHINLAIN_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='initskpd' and b.jns_beban='16'
                   union all
                   SELECT isnull(sum(a.nilai),0) as total
                   FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd')c")->row();
        $total_sp3b = $cload_total->total;                      
        
        $csql_sp3b = "insert into trhsp3b_blud(no_sp3b,kd_skpd,tgl_sp3b,keterangan,status,no_lpj,total,skpd,bulan,username,tgl_update,status_bud,no_sp2b,tgl_sp2b,number_sp2b) 
                        values('$nsp3b','$initskpd','$ntgllpj','$cket','1','$nlpj','$total_sp3b','$skpd_bp','$init_bulan2','DIKNAS','$last_update','1','$nsp2b','$ntgllpj','$ii')";                              
        $query1 = $this->db->query($csql_sp3b);
        
        $csql_dlpj = "INSERT INTO trlpj_blud (no_lpj,no_bukti,tgl_lpj,keterangan,kd_kegiatan,kd_rek5,nm_rek5,nilai,kd_skpd)       
                    select c.no_lpj,c.no_bukti,c.tgl_lpj,c.keterangan,c.kd_kegiatan,c.kd_rek5,c.nm_rek5,c.nilai,c.kd_skpd from(
                    SELECT '$nlpj' as no_lpj, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, a.kd_kegiatan,a.kd_rek5,a.nm_rek5,a.nilai,b.kd_skpd 
                    FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                    month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd'
                   union all
                    SELECT '$nlpj' as no_lpj, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, b.kd_kegiatan,a.kd_rek5,'Koreksi Belanja' nm_rek5,a.nilai*-1 nilai,b.kd_skpd 
                    FROM TRDINLAIN_blud a inner join TRHINLAIN_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                    month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd' and b.jns_beban='16' )c order by cast (c.no_bukti as int)
                   "; 
                   echo "$csql_dlpj<br>";         
        $query1 = $this->db->query($csql_dlpj);  
        
        $csql_dsp3b = "INSERT INTO trsp3b_blud(no_sp3b,no_bukti,tgl_sp3b,keterangan,kd_kegiatan,kd_rek5,nm_rek5,nilai,kd_skpd,no_lpj)       
                    SELECT c.no_sp3b,c.no_bukti,c.tgl_lpj,c.keterangan,c.kd_kegiatan,c.kd_rek5,c.nm_rek5,c.nilai,c.kd_skpd,c.no_lpj from(
                    SELECT '$nsp3b' as no_sp3b, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, a.kd_kegiatan,a.kd_rek5,a.nm_rek5,a.nilai,b.kd_skpd,'$nlpj' as no_lpj 
                    FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd'
                    union all
                    SELECT '$nsp3b' as no_sp3b, a.no_bukti, '$ntgllpj' as tgl_lpj,'$cket' as keterangan, b.kd_kegiatan,a.kd_rek5,'Koreksi Belanja' nm_rek5,a.nilai*-1 nilai,b.kd_skpd,'$nlpj' as no_lpj 
                    FROM TRDINLAIN_blud a inner join TRHINLAIN_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE 
                   month(b.tgl_bukti) >= '$init_bulan1' AND month(b.tgl_bukti) <= '$init_bulan2' 
                   and b.kd_skpd='$initskpd' and b.jns_beban='16')c
                   order by cast (c.no_bukti as int)
                   ";  
        echo "$csql_dsp3b";
        $query1 = $this->db->query($csql_dsp3b); 

        
        }
        
        echo '1';   
    }


	
	function load_giat_trans(){
        $kd_skpd = $this->session->userdata('kdskpd'); 
		$sql = "SELECT a.kd_kegiatan,a.nm_kegiatan FROM trdtransout_blud a inner join trhtransout_blud b ON a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd
				AND b.kd_skpd='$kd_skpd' GROUP BY a.kd_kegiatan,a.nm_kegiatan order by a.kd_kegiatan ";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],  
                        'nm_kegiatan' => $resulte['nm_kegiatan']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
	}
	
	function cetak_kartu_kendali($lcskpd='',$giat='',$ctk=''){
		$spasi = $this->uri->segment(9);
        $nomor = str_replace('123456789',' ',$this->uri->segment(6));
		$nip2 = str_replace('123456789',' ',$this->uri->segment(7));
		$tanggal_ttd = $this->tukd_model->tanggal_format_indonesia($this->uri->segment(8));
		$nbulan= $this->tukd_model->ambil_bulan($this->uri->segment(8));
		$skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient_blud=$this->db->query($sqlsc);
                 foreach ($sqlsclient_blud->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where nip='$nip2' AND kd_skpd='$lcskpd' AND kode='PA'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where nip = '$nomor' AND kd_skpd='$lcskpd' AND kode='PT'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		
			$cRet ='<TABLE style="border-collapse:collapse;font-size:12px" width="100%" border="0" cellspacing="0" cellpadding="1" align=center>
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
                    <TR>
						<TD align="center" ><b>KARTU KENDALI KEGIATAN </b></TD>
					</TR>
					</TABLE>';
			$cRet .='<TABLE style="border-collapse:collapse;font-size:12px" width="90%" border="0" cellspacing="0" cellpadding="0" align=center>
					<TR>
						<TD align="left" width="10%"><b>SKPD</b> </TD>
						<TD align="left" width="2%"><b>:</b> </TD>
						<TD align="left" width="88%"><b>'.$lcskpd.' - '.$skpd.'</b> </TD>
					</TR>
					<TR>
						<TD align="left" width="10%"><b>Nama Program</b> </TD>
						<TD align="left" width="2%"><b>:</b> </TD>
						<TD align="left" width="88%"><b>'.$this->tukd_model->left($giat,18).' - '.$this->tukd_model->get_nama($this->tukd_model->left($giat,18),'nm_program','trskpd','kd_program').'</b> </TD>
					</TR>
					<TR>
						<TD align="left" width="10%"><b>Nama Kegiatan</b> </TD>
						<TD align="left" width="2%"><b>:</b> </TD>
						<TD align="left" width="88%"><b>'.$giat.' - '.$this->tukd_model->get_nama($giat,'nm_kegiatan','trskpd','kd_kegiatan').'</b> </TD>
					</TR>
					<TR>
						<TD align="left" width="10%"><b>Nama PPTK</b> </TD>
						<TD align="left" width="2%"><b>:</b> </TD>
						<TD align="left" width="88%"><b>'.$nip1.' - '.$nama1.'</b> </TD>
					</TR>
					</TABLE> <p/>';		
			$cRet .="<table style=\"border-collapse:collapse; font-size:12px\" width=\"90%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$spasi\">
            <thead>
			<tr>
                <td rowspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\"><b>No Urut</b></td>
                <td rowspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\"><b>KODE REKENING</b></td>
                <td colspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\"><b>PAGU ANGGARAN</b></td>
                <td rowspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\"><b>URAIAN</b></td>
                <td colspan =\"3\" align=\"center\" bgcolor=\"#CCCCCC\"><b>REALISASI KEGIATAN</b></td>
                <td rowspan =\"2\" align=\"center\" bgcolor=\"#CCCCCC\"><b>SISA PAGU</b></td>
            </tr>
			<tr>
				<td align=\"center\" bgcolor=\"#CCCCCC\"><b>MURNI</b></td>
                <td align=\"center\" bgcolor=\"#CCCCCC\"><b>UBAH</b></td>
                <td align=\"center\" bgcolor=\"#CCCCCC\"><b>LS</b></td>
                <td align=\"center\" bgcolor=\"#CCCCCC\"><b>UP/GU</b></td>
                <td align=\"center\" bgcolor=\"#CCCCCC\"><b>TU</b></td>
            </tr>
			</thead>
           ";
				$query = $this->db->query("exec cetak_kartu_kendali '$lcskpd',$nbulan,'$giat'");
					$no=0;				
                   foreach ($query->result() as $row) {
					$no=$no+1;
                    $kd_rek5 = $row->kd_rek5; 
                    $nilai = $row->nilai;                   
                    $nilai_ubah = $row->nilai_ubah;                   
                    $uraian = $row->uraian;                   
                    $real_ls = $row->real_ls;
                    $real_up =$row->real_up;
                    $real_tu=$row->real_tu;
                    $sisa = $row->sisa;
					
					$nilai1  = empty($nilai) || $nilai == 0 ? '' :number_format($nilai,"2",",",".");	
					$nilai_ubah1  = empty($nilai_ubah) || $nilai_ubah == 0 ? '' :number_format($nilai_ubah,"2",",",".");	
					$real_ls1  = empty($real_ls) || $real_ls == 0 ? number_format(0,"2",",",".") :number_format($real_ls,"2",",",".");
					$real_up1  = empty($real_up) || $real_up == 0 ? number_format(0,"2",",",".") :number_format($real_up,"2",",",".");
					$real_tu1  = empty($real_tu) || $real_tu == 0 ? number_format(0,"2",",",".") :number_format($real_tu,"2",",",".");
					$sisa1  = empty($sisa) || $sisa == 0 ? number_format(0,"2",",",".") :number_format($sisa,"2",",",".");
			$cRet .="
				<tr>
                <td align=\"center\" >$no</td>
                <td align=\"left\" >$kd_rek5</td>
                <td align=\"right\" >$nilai1</td>
                <td align=\"right\" >$nilai_ubah1</td>
                <td align=\"left\" >$uraian</td>
                <td align=\"right\" >$real_ls1</td>
                <td align=\"right\" >$real_up1</td>
                <td align=\"right\" >$real_tu1</td>
                <td align=\"right\" >$sisa1</td>
				</tr>
				";
					
            
			}
						
			$cRet .="</table>";
			$cRet .='<TABLE width="100%" style="font-size:12px" border="0" cellspacing="0">
					<TR>
						<TD align="center" width="50%"><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$tanggal_ttd.'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" ><u><b>'.$nama.' </b><br></u> '.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u><b>'.$nama1.' </b><br></u> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'DTH';
             switch ($ctk)
        {
            case 0;
			echo ("<title>KARTU KENDALI</title>");
				echo $cRet;
				break;
            case 1;
	    $this->_mpdf('',$cRet,10,10,10,'L',0,'');
               break;
		}
	}
	
	
	function sp2d_list_uji() {
	   $lccr = $this->input->post('q');
        $sql   = " select no_sp2d, tgl_sp2d,no_spm,tgl_spm,total from trhsp2d_blud where jns_spp='5' AND no_sp2d not in 
                    (select no_sp2d from trhuji_blud a inner join trduji_blud b on a.no_uji=b.no_uji) and upper(no_sp2d) like upper('%$lccr%') ";
            
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'no_sp2d' => $resulte['no_sp2d'],  
                        'tgl_sp2d' => $resulte['tgl_sp2d'],
                        'no_spm' => $resulte['no_spm'],
                        'tgl_spm' => $resulte['tgl_spm'],
                        'nilai' => $resulte['total']						
                        );
                        $ii++;
        }
           
        echo json_encode($result);
		$query1->free_result();	   
	}
	
	function load_data_sp2d_uji($dtgl1='',$dtgl2='') {
    
        $dtgl1  = $this->input->post('tgl1');
        $dtgl2  = $this->input->post('tgl2');

        $sql    = " SELECT no_sp2d, tgl_sp2d,no_spm,tgl_spm,SUM(b.nilai) as nilai from trhsp2d_blud a
					INNER JOIN trdspp b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd
					WHERE tgl_sp2d BETWEEN '$dtgl1' AND '$dtgl2' AND 
					no_sp2d not in (select no_sp2d from trhuji_blud a inner join trduji_blud b on a.no_uji=b.no_uji) 
					GROUP BY no_sp2d, tgl_sp2d,no_spm,tgl_spm
					ORDER BY tgl_sp2d,no_sp2d"; 
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'no_sp2d' => $resulte['no_sp2d'],  
                        'tgl_sp2d' =>$resulte['tgl_sp2d'],
						'no_spm' => $resulte['no_spm'],
						'tgl_spm' => $resulte['tgl_spm'],
						'nilai' =>number_format($resulte['nilai'],"2",".",",") 				
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result();	
    }
	
	
	function load_d_uji() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
	
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $skriteria = $this->input->post('vkriteria');
        $where    = " ";
        
        if($skriteria!=''){
            if ($kriteria <> ''){                               
                $where="  and (upper(a.no_uji) like upper('%$kriteria%') or a.tgl_uji like '%$kriteria%' or b.no_sp2d like '%$kriteria%') ";            
            }
    
    
            $sql = "SELECT count(*) as tot from trhuji_blud" ;
            $query1 = $this->db->query($sql);
            $total = $query1->row();
    
    		 $sql = "SELECT top $rows a.no_uji, a.tgl_uji from trhuji_blud a
    				INNER JOIN trduji_blud b ON a.no_uji=b.no_uji 
    				where a.no_uji not in (SELECT TOP $offset  no_uji from  
                    trhuji_blud order by tgl_uji,no_uji ) $where
    				GROUP BY a.no_uji, a.tgl_uji order by a.tgl_uji, a.no_uji ";
        }else{
            if ($kriteria <> ''){                               
                $where="  and (upper(a.no_uji) like upper('%$kriteria%') or a.tgl_uji like '%$kriteria%') ";            
            }
    
    
            $sql = "SELECT count(*) as tot from trhuji_blud" ;
            $query1 = $this->db->query($sql);
            $total = $query1->row();
    
    		 $sql = "SELECT top $rows a.no_uji, a.tgl_uji from trhuji_blud a 
    				where a.no_uji not in (SELECT TOP $offset  no_uji from  
                    trhuji_blud order by tgl_uji,no_uji ) $where
    				GROUP BY a.no_uji, a.tgl_uji order by a.tgl_uji, a.no_uji ";          
        }
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
		
		  { 
           
            $row[] = array(
                        'id' => $ii,
						'no_uji'    => $resulte['no_uji'],
						'tgl_uji'    => $resulte['tgl_uji']
                        );
                        $ii++;
        }						           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	$query1->free_result();    
		
	}
	
	function pilih_ttd_bud() {
		
        $sql = "SELECT nip,nama,jabatan FROM ms_ttd_blud where kode='BK' group by  nip,nama,jabatan ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],  
                        'nama' => $resulte['nama'],  
                        'jabatan' => $resulte['jabatan']
                   
                        );
                        $ii++;
        }
           
        echo json_encode($result);
     $query1->free_result();	   
	}
	
	function cek_uji($vno_uji='') {

    $luji = $this->input->post('vno_uji');
   
   
        $sql = "SELECT top 1 isnull(b.no_kas,'') [no_kas] FROM trduji_blud a inner join trhsp2d_blud b on a.no_sp2d=b.no_sp2d WHERE no_uji='$luji' 
                order by b.no_kas desc ";
        
        $query1 = $this->db->query($sql);  
        $result = '';
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result =$resulte['no_kas'];	
        }
   
           echo json_encode($result);
     $query1->free_result();
    }	
	
	
	function select_detail_uji($vno_uji='') {

    $luji = $this->input->post('vno_uji');
   
   
        $sql = "SELECT no_uji, tgl_uji, a.no_sp2d,b.tgl_sp2d,no_spm,tgl_spm,total 
				FROM trduji_blud a inner join trhsp2d_blud b on a.no_sp2d=b.no_sp2d WHERE no_uji='$luji'";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'idx'        => $ii, 						
                        'no_sp2d'    => $resulte['no_sp2d'],     
                        'tgl_sp2d'   => $resulte['tgl_sp2d'],  
                        'no_spm'     => $resulte['no_spm'], 						 
                        'tgl_spm'    => $resulte['tgl_spm'], 						 
                        'nilai1'     => number_format($resulte['total'])
                        );
                        $ii++;
        }
           
        echo json_encode($result);
		$query1->free_result();
    }
	
	function hhapusuji() {    	
		$nomor = $this->input->post('no');        
        $query = $this->db->query("delete from trhuji_blud_blud where no_uji='$nomor'");
        $query = $this->db->query("delete from trduji_blud where no_uji='$nomor'");
         $query->free_result();
    }
	
	function simpan_daftar_uji(){
        $tabel    = $this->input->post('tabel');        
		$no_uji = $this->input->post('no_uji');		
		$tgl_uji = $this->input->post('tgl_uji');
		$no_blk = $this->input->post('no_blk');
		$cwaktu = date("Y-m-d H:i:s");		
		$user =  $this->session->userdata('pcNama'); 
		$lcst=$this->input->post('lcst');
		$r_nomor='2';
		
		if ($tabel == 'trhuji_blud') {	
		$sql = "Select isnull(Max((no_urut)),0) As maks From trhuji_blud";
		$hasil = $this->db->query($sql);
		$nomor7 = $hasil->row();
		$nomor7_urut=$nomor7->maks+1;
		$r_nomor=strval($nomor7_urut).$no_blk;

        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;		
    	$csql = "INSERT INTO trhuji_blud (no_uji,tgl_uji,username,tgl_update,no_urut) values ('$r_nomor','$tgl_uji','$user','$cwaktu','$nomor7_urut')";
    	$query1 = $this->db->query($csql);   
		$this->db->db_debug = $db_debug;	
                if($query1){
                    echo json_encode($r_nomor);
                }else{
                    echo '0';
                }
		}
		else if ($tabel == 'trduji_blud') {
			$nomor_baru = $this->input->post('nomor_baru');
			$csql     = $this->input->post('sql');            
            // Simpan Detail //                       
 				$sql = "delete from trduji_blud where no_uji='$nomor_baru'";
                $asg = $this->db->query($sql);
				
				
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $db_debug = $this->db->db_debug;
                    $this->db->db_debug = FALSE;
					$sql = "insert into trduji_blud (no_uji,tgl_uji,no_sp2d)"; 
                    $asg = $this->db->query($sql.$csql);
					$this->db->db_debug = $db_debug;
					
					if (!($asg)){
                      
						echo json_encode('0');
					}  else {
                      
						echo json_encode('1');
					}
                }
			
		}
    }
	
	function edit_daftar_uji(){
        $tabel    = $this->input->post('tabel');        
		$no_uji = $this->input->post('no_uji');		
		$no_uji_hide = $this->input->post('no_uji_hide');		
		$tgl_uji = $this->input->post('tgl_uji');
		$cwaktu = date("Y-m-d H:i:s");		
		$user =  $this->session->userdata('pcNama'); 
				
		if ($tabel == 'trhuji_blud') {
		$csql = "update trhuji_blud set tgl_uji='$tgl_uji',username='$user',tgl_update='$cwaktu' where no_uji='$no_uji_hide'";
    	$query1 = $this->db->query($csql);	
    	        if($query1){
                    echo json_encode($no_uji);
                }else{
                    echo '0';
                }
		}
		else if ($tabel == 'trduji_blud') {
			$csql     = $this->input->post('sql');            
            // Simpan Detail //                       
				$sql = "delete from trduji_blud where no_uji='$no_uji_hide'";
                $asg = $this->db->query($sql);
				
				
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "insert into trduji_blud(no_uji,tgl_uji,no_sp2d)"; 
                    $asg = $this->db->query($sql.$csql);
					
					
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                    
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
			
		}
    }
	
	function simpan_detail_d_uji(){
	  
		$no_uji = $this->input->post('no_uji');		
		$tgl_uji = $this->input->post('tgl_uji');
		$no_sp2d = $this->input->post('no_sp2d');
        
    	$csql = "INSERT INTO trduji_blud (no_uji,tgl_uji,no_sp2d) values ('$no_uji','$tgl_uji','$no_sp2d')";
    	$query1 = $this->db->query($csql);
    					
                if($query1){
                    echo '2';
                }else{
                    echo '0';
                }
            }
 
 function cetak_daftar_penguji($no_uji='',$ttd='',$dcetak='',$cetak='',$atas='',$bawah='',$kiri='',$kanan=''){
	$print = $cetak;
	
			$no_uji = str_replace('123456789','/',$this->uri->segment(3));
			$lcttd = str_replace('abcdefg',' ',$this->uri->segment(4));
		
		    $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kode='BK' and nip='$lcttd'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
					$pangkat=$rowttd->pangkat;
                }
			$sqlcount="SELECT COUNT(a.no_sp2d) as jumlah FROM trduji_blud a INNER JOIN trhuji_blud b ON a.no_uji=b.no_uji WHERE a.no_uji='$no_uji'";
                 $sql123=$this->db->query($sqlcount);
                 foreach ($sql123->result() as $rowcount)
                {
                    $jumlah=$rowcount->jumlah;                    
                   
                }
			$PageCount='$page';	
			$cRet ='';
			$cRet .="<table style=\"border-collapse:collapse;font-weight:bold;font-family:Tahoma; font-size:12px\" border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">
            <tr >
                <td width=\"100%\" align=\"center\" colspan=4 style=\"font-size:18px\">DAFTAR PENGUJI / PENGANTAR<br>SURAT PERINTAH PENCAIRAN DANA</td></tr>
					 <TR >
						<TD align=\"left\" width=\"10%\">Tanggal </TD>
						<TD align=\"left\" width=\"70%\">: ".$this->tukd_model->tanggal_format_indonesia($dcetak)."</TD>
						<TD align=\"left\" width=\"10%\"></TD>
						<TD align=\"right\"  width=\"20%\">Lembaran ke 1</TD>
					 </TR>					 
					 <TR>
						<TD align=\"left\"> Nomor</TD>
						<TD align=\"left\"  >: ".$no_uji."</TD>
						<TD align=\"left\" > </TD>
						<TD align=\"right\" >Terdiri dari ".$jumlah." lembar </TD>
					 </TR>
					 </TABLE>";

			$cRet .=" <table style=\"border-collapse:collapse;font-family:Tahoma; font-size:11px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">               
				<thead>
			   <tr style=\"font-size:12px;font-weight:bold;\">
                    <td width=\"5%\" align=\"center\"><b>NO</b></td>
                    <td width=\"10%\" align=\"center\" ><b>TANGGAL DAN<br>NOMOR SP2D</b></td>
                     <td  width=\"28%\" align=\"center\"><b>ATAS NAMA<br>( YANG BERHAK )</b>
					 </td>
					 <td width=\"20%\" align=\"center\" ><b>SKPD</b>        
                    </td>
                    <td  width=\"10%\" align=\"center\"><b>JUMLAH KOTOR<br>(Rp)</b>
					 </td>					 
                    <td width=\"10%\" align=\"center\" ><b>JUMLAH<br>POTONGAN</b>
                    </td>
                    <td width=\"10%\" align=\"center\"><b>JUMLAH<br>BERSIH</b>
                    </td>
                    <td  width=\"10%\" align=\"center\"><b>TANGGAL<br>TRANSFER</b>
                    </td>
                   
                </tr>
				<tr style=\"font-size:11px;font-weight:bold;\">	
					<td align=\"center\" >1
                    </td>
					<td align=\"center\" >2
                    </td>
					<td align=\"center\" >3
                    </td>
					<td align=\"center\" >4
                    </td>
					<td align=\"center\" >5
                    </td>
					<td align=\"center\" >6
                    </td>
					<td align=\"center\" >7
                    </td>
					<td align=\"center\" >8
                    </td>
				</tr>
				</thead>
				";
			
			  $sql = "select b.no_sp2d,c.tgl_sp2d,c.nmrekan,c.pimpinan,c.alamat,c.kd_skpd,c.nm_skpd
						,c.jns_spp,'' jenis_beban,c.kotor,c.pot FROM trhuji_blud a inner join trduji_blud b on a.no_uji=b.no_uji LEFT join (
						SELECT a.*,ISNULL(SUM(b.nilai),0)pot FROM (select no_sp2d,no_spm,tgl_sp2d,a.rekanan as nmrekan,a.alamat,a.pimpinan,
						a.kd_skpd,d.nm_skpd,a.jns_spp,'' jenis_beban, isnull(SUM(z.nilai),0)kotor
						from trhsp2d_blud a 
						INNER JOIN trdspp z ON a.no_spp=a.no_spp AND a.kd_skpd=z.kd_skpd
						INNER JOIN ms_skpd_blud d on a.kd_skpd=d.kd_skpd
						GROUP BY no_sp2d,no_spm,tgl_sp2d,a.rekanan,a.alamat,a.pimpinan,
						a.kd_skpd,d.nm_skpd,a.jns_spp)a 
						LEFT JOIN 
						trspmpot_blud b ON a.no_spm=b.no_spm and a.kd_skpd=b.kd_skpd
						GROUP BY no_sp2d,a.no_spm,tgl_sp2d,nmrekan,a.alamat,a.pimpinan,
						a.kd_skpd,a.nm_skpd,a.jns_spp,a.jenis_beban,a.kotor) c on b.no_sp2d=c.no_sp2d WHERE a.no_uji='$no_uji'";
			 $hasil = $this->db->query($sql);
                    $lcno = 0;
                     $total_kotor=0;
                     $total_pot=0;
					 
					 foreach ($hasil->result() as $row)
                    {
                       $lcno = $lcno + 1;
					   $no_sp2d=empty($row->no_sp2d) || $row->no_sp2d == '' ? ' ' :$row->no_sp2d;
					   
					   $nmrekan=empty($row->nmrekan) || $row->nmrekan == '' ? ' ' :$row->nmrekan;
					   $pimpinan=empty($row->pimpinan) || $row->pimpinan == '' ? ' ' :$row->pimpinan;
					   $alamat=empty($row->alamat) || $row->alamat == '' ? ' ' :$row->alamat;
					   $kd_skpd=empty($row->kd_skpd) || $row->kd_skpd == '' ? ' ' :$row->kd_skpd;
					   $nm_skpd=empty($row->nm_skpd) || $row->nm_skpd == '' ? ' ' :$row->nm_skpd;
					   $jns=empty($row->jns_spp) || $row->jns_spp == '' ? ' ' :$row->jns_spp;
					   $jns_bbn=empty($row->jenis_beban) || $row->jenis_beban == '' ? ' ' :$row->jenis_beban;
					   $kotor=empty($row->kotor) || $row->kotor == '' ? 0 :$row->kotor;
					   $pot=empty($row->pot) || $row->pot == '' ? 0 :$row->pot;
					   $total_kotor=$kotor+$total_kotor;
					   $total_pot=$pot+$total_pot;
					  
					   $tgl_sp2d=empty($row->tgl_sp2d) || $row->tgl_sp2d == '' ? ' ' :$this->tukd_model->tanggal_ind($row->tgl_sp2d);
			
						$sqlnam="SELECT TOP 1 * FROM ms_ttd_blud WHERE kd_skpd = '$kd_skpd' AND kode='BK'";
							 $sqlnam=$this->db->query($sqlnam);
							 foreach ($sqlnam->result() as $rownam)
							{
								$nama_ben=$rownam->nama;                    
								$jabat_ben=$rownam->jabatan;                    
							}
						$nama_ben = empty($nama_ben) || $nama_ben == 'NULL' ? 'Belum Ada data Bendahara' :$nama_ben;
						$jabat_ben = empty($jabat_ben) || $jabat_ben == 0 ? ' ' :$jabat_ben;
						
						
	
		  $cRet .=" <tr >
                    <td valign=\"top\" align=\"center\" >$lcno  
                    </td>
                    <td valign=\"top\" align=\"center\" >$no_sp2d <br> $tgl_sp2d
					</td>					
                    <td valign=\"top\" align=\"left\" >$nama_ben <br>$jabat_ben $nm_skpd
					</td>					
                    <td valign=\"top\" align=\"left\" >$kd_skpd<br>$nm_skpd
					</td>					
                    <td valign=\"top\" align=\"right\" >".number_format($kotor,"2",",",".")."&nbsp; 
					 </td>
					<td valign=\"top\" align=\"right\" >".number_format($pot,"2",",",".")."&nbsp; 
                    </td>
                    <td valign=\"top\" align=\"right\" >".number_format($kotor-$pot,"2",",",".")."&nbsp; 
					 </td>
					<td valign=\"top\" align=\"center\" >&nbsp; 
					</td>
									 
                </tr>
				";
			
	
				};
				
			 $cRet .=" <tr style=\"font-size:11px;font-weight:bold;\">
                    <td colspan=\"4\" align=\"center\" >TOTAL
                    </td>
                    <td  align=\"right\" >".number_format($total_kotor,"2",",",".")."&nbsp; 
					</td>
					<td  align=\"right\" >".number_format($total_pot,"2",",",".")."&nbsp; 
					</td>
					<td  align=\"right\" >".number_format($total_kotor-$total_pot,"2",",",".")."&nbsp;
					</td>
					<td  align=\"center\" >&nbsp; 
					</td>
                </tr>
				";
			$cRet .='</table>';
			
			$cRet .=" <table style=\"border-collapse:collapse;font-weight:bold;font-family:Tahoma; font-size:11px;\" border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">
			
			<tr >
				<td align=\"left\" width=\"70%\" style=\"height: 30px;\" >&nbsp;&nbsp;Diterima oleh : ................................................</td>
				<td align=\"center\" width=\"30%\" >$jabatan</td>
				
				</tr>
			<tr>
				<td>&nbsp;&nbsp;.....................................................</td>
				<td align=\"center\">Kuasa Bendahara Umum Daerah</td>
				</tr>
			<tr>
				<td colspan=\"2\" ><br>&nbsp;&nbsp;Petugas Bank / Pos</td>
				</tr>
			<tr >
				<td width=\"100%\" colspan=\"2\" style=\"height: 50px;\" >&nbsp;</td>
				</tr>
			<tr>
				<td>&nbsp;</td>
				<td align=\"center\"><u>$nama</u></td>
				</tr>
			<tr>
				<td>&nbsp;</td>
				<td align=\"center\">$pangkat</td>
				</tr>
			<tr>
				<td><align=\"left\" style=\"width: 250px;\">__________________________________</td>
				<td align=\"center\">NIP. $nip</td>
				</tr>
				</table>";

			$data['prev']= 'Daftar Penguji';
			if ($print==1){
			
	    $this->_mpdf_daftar_penguji('',$cRet,10,10,10,'L',0,'',$atas,$bawah,$kiri,$kanan);

				

		} else{
		  $cRet = str_replace('$page', '', $cRet);
		  echo ("<title>LAPORAN DAFTAR PENGUJI</title>");
		  echo $cRet;
		}
	
	}
	
 
	
	function simpan_detail_d_uji_hapus()
	{
           $no_uji  = trim($this->input->post('no_uji'));

               $sql     = " delete trduji_blud where no_uji='$no_uji' ";
               $asg     = $this->db->query($sql); 	
               if ($asg > 0){  	
                    echo '1';
                    exit();
               } else {
                    echo '0';
                    exit();
               }
    }   

	
    function load_no_tetap() { 
        $kd_skpd  = $this->session->userdata('kdskpd');  
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ="where kd_skpd='$kd_skpd' ";
        if ($kriteria <> ''){                               
            $where="where kd_skpd='$kd_skpd' AND (upper(no_tetap) like upper('%$kriteria%') or tgl_tetap like '%$kriteria%' or kd_skpd like'%$kriteria%' or
            upper(keterangan) like upper('%$kriteria%')) and ";            
        }

		$where2 =" AND no_tetap not in(select no_tetap from tr_terima_blud where kd_skpd='$kd_skpd')";
        $sql = "SELECT no_tetap, tgl_tetap, kd_skpd, keterangan, nilai, kd_rek5, kd_rek_blud,
				(SELECT a.nm_rek5 FROM ms_rek5_blud a WHERE a.kd_rek5=tr_tetap_blud.kd_rek5) as nm_rek,kd_kegiatan FROM tr_tetap_blud $where $where2
				UNION ALL
				SELECT no_tetap,tgl_tetap,kd_skpd,keterangan,ISNULL(nilai,0)-ISNULL(nilai_terima,0) as nilai,kd_rek5,kd_rek_blud,a.nm_rek,a.kd_kegiatan				
				FROM 
				(SELECT *,(SELECT a.nm_rek5 FROM ms_rek5_blud a WHERE a.kd_rek5=tr_tetap_blud.kd_rek5) as nm_rek FROM tr_tetap_blud $where )a
				LEFT JOIN
				(SELECT no_tetap as tetap,ISNULL(SUM(nilai),0) as nilai_terima from tr_terima_blud $where GROUP BY no_tetap)b
				ON a.no_tetap=b.tetap
				WHERE nilai !=nilai_terima 
				order by no_tetap";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_tetap' => $resulte['no_tetap'],
                        'tgl_tetap' => $resulte['tgl_tetap'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['keterangan'],    
                        'nilai' => $resulte['nilai'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'nm_rek5' => $resulte['nm_rek'],
                        'kd_rek_blud' => $resulte['kd_rek_blud']                                                                                           
                        );
                        $ii++;
        }
        echo json_encode($result);
	} 
    
	//mulai
	function lpj()
    {
        $data['page_title']= 'INPUT LPJ UP';
		$data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'INPUT LPJ UP');   
        $this->template->load('template','tukd/transaksi/tambah_lpj',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }
	
	function load_lpj() {
		$row 	= array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = " ";
        if ($kriteria <> ''){                               
            $where=" and (upper(no_lpj) like upper('%$kriteria%') or tgl_lpj like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%')) ";            
        }

		$sql = "SELECT count(*) as tot from trhlpj_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '1' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
                
      	$sql = "SELECT TOP $rows *,(SELECT a.nm_skpd FROM ms_skpd_blud a where a.kd_skpd = '$kd_skpd') as nm_skpd FROM trhlpj_blud WHERE kd_skpd = '$kd_skpd' AND jenis = '1' $where 
				AND no_lpj NOT IN (SELECT TOP $offset no_lpj FROM trhlpj_blud WHERE kd_skpd = '$kd_skpd' AND jenis = '1' $where ORDER BY tgl_lpj,no_lpj) ORDER BY tgl_lpj,no_lpj";
		
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
		
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(
                        'id' => $ii,
						'kd_skpd'    => $resulte['kd_skpd'],      
						'nm_skpd'    => $resulte['nm_skpd'],                          
                        'ket'   => $resulte['keterangan'],
                        'no_lpj'   => $resulte['no_lpj'],
                        'tgl_lpj'      => $resulte['tgl_lpj'],
                        'status'      => $resulte['status'],
                        'tgl_awal'      => $resulte['tgl_awal'],
                        'tgl_akhir'      => $resulte['tgl_akhir']
                        );
                        $ii++;
        }
           
       $result["total"] = $total->tot;
       $result["rows"] = $row; 
       $query1->free_result();   
       echo json_encode($result);
	}
     
	function select_data1_lpj_ag($lpj='') {
		$kd_skpd  = $this->session->userdata('kdskpd');
		$lpj = $this->input->post('lpj');
        $sql = "SELECT a.kd_skpd, a.no_lpj,a.no_bukti,a.kd_kegiatan,a.kd_rek5,a.nm_rek5,a.kd_rek_blud,a.nm_rek_blud, a.nilai FROM trlpj_blud a INNER JOIN trhlpj_blud b ON a.no_lpj=b.no_lpj AND a.kd_skpd=b.kd_skpd
				WHERE a.no_lpj='$lpj' AND a.kd_skpd='$kd_skpd'";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'idx'        => $ii,
                        'no_bukti'   => $resulte['no_bukti'],  						
                        'kdkegiatan' => $resulte['kd_kegiatan'],     
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'nmrek5'     => $resulte['nm_rek5'], 
						'kdrekblud'     => $resulte['kd_rek_blud'], 
						'nmrekblud'     => $resulte['nm_rek_blud'], 						
                        'nilai1'      => number_format($resulte['nilai'])

                        );
                        $ii++;
        }
           
           echo json_encode($result);
     $query1->free_result();
    }
	
	function load_giat_lpj(){

		$nomor = $this->input->post('lpj');
        $query1 = $this->db->query("
		select a.kd_kegiatan, c.nm_kegiatan
		from trlpj_blud a 
		INNER JOIN trhlpj_blud b ON a.no_lpj=b.no_lpj AND a.kd_skpd=b.kd_skpd
		LEFT JOIN trskpd_blud c ON a.kd_kegiatan=c.kd_kegiatan AND a.kd_skpd=c.kd_skpd
		WHERE a.no_lpj = '$nomor'
		GROUP BY a.kd_kegiatan,c.nm_kegiatan
		ORDER BY a.kd_kegiatan");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],                       
                        'nm_kegiatan' => $resulte['nm_kegiatan']                      
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
           $query1->free_result();	
	}
	
	function config_up(){
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT ISNULL(SUM(a.nilai),0) as nilai FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd = '$skpd' AND b.jns_spp='1'"; 
        $query1 = $this->db->query($sql);  
		
		$test = $query1->num_rows();
		
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'nilai_up' => $resulte['nilai']
                        );
                        $ii++;
        }
        echo json_encode($result);
    	$query1->free_result();   
    }
	
	function tambah_tanggal(){
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT DATEADD(DAY,1,MAX(tgl_akhir)) as tanggal_awal FROM trhlpj_blud WHERE jenis='1' AND kd_skpd = '$skpd'";
        $query1 = $this->db->query($sql);  
		
		$test = $query1->num_rows();
		
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'tgl_awal' => $resulte['tanggal_awal']
                        
                        );
                        $ii++;
        }
		

		
		
        echo json_encode($result);
    	$query1->free_result();   
    }
    
	function simpan_hlpj(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$ntgllpj = $this->input->post('tgllpj');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$cket = $this->input->post('ket');
		
    	$csql = "INSERT INTO trhlpj_blud (no_lpj,kd_skpd,keterangan,tgl_lpj,status,tgl_awal,tgl_akhir,jenis) values ('$nlpj','$kdskpd','$cket','$ntgllpj','0','$tgl_awal','$tgl_akhir','1')";
    	$query1 = $this->db->query($csql);
    					
                if($query1){
                    echo '2';
                }else{
                    echo '0';
                }
            }
    
	function simpan_lpj(){
	  
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$csql     = $this->input->post('sql');            
  		
		$sql = "delete from trlpj_blud where no_lpj='$nlpj' AND kd_skpd='$kdskpd'";
                $asg = $this->db->query($sql);
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "INSERT INTO trlpj_blud (no_lpj,no_bukti,tgl_lpj,keterangan,kd_kegiatan,kd_rek5,nm_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd)"; 
                    $asg = $this->db->query($sql.$csql);
					
					
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
            }
		
    function update_hlpj_up(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$no_simpan = $this->input->post('no_simpan');
		$ntgllpj = $this->input->post('tgllpj');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$cket = $this->input->post('ket');

        $csql = "delete from trhlpj_blud where no_lpj= '$no_simpan'  and kd_skpd='$kdskpd'";
    	$query1 = $this->db->query($csql);
		$csql = "delete from trlpj_blud where no_lpj= '$no_simpan' and kd_skpd='$kdskpd' ";
    	$query1 = $this->db->query($csql);
    	$csql = "INSERT INTO trhlpj_blud (no_lpj,kd_skpd,keterangan,tgl_lpj,status,tgl_awal,tgl_akhir,jenis) values ('$nlpj','$kdskpd','$cket','$ntgllpj','0','$tgl_awal','$tgl_akhir','1')";
    	$query1 = $this->db->query($csql);
    					
                if($query1){
                    echo '2';
                }else{
                    echo '0';
                }
        }
       
	function simpan_lpj_update(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$no_simpan = $this->input->post('no_simpan');
		$csql     = $this->input->post('sql');            
  		
		$sql = "delete from trlpj_blud where no_lpj='$no_simpan' AND kd_skpd='$kdskpd'";
                $asg = $this->db->query($sql);
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "INSERT INTO trlpj_blud (no_lpj,no_bukti,tgl_lpj,keterangan,kd_kegiatan,kd_rek5,nm_rek5,kd_rekblud,nm_rekblud,nilai,kd_skpd)"; 
                    $asg = $this->db->query($sql.$csql);
					
					
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
        
    	
            }
		
	function load_sum_lpj(){
		$xlpj = $this->input->post('lpj');
        //$query1 = $this->db->query("SELECT SUM(b.nilai)AS jml FROM trhtransout a INNER JOIN trdtransout b ON a.no_bukti=b.no_bukti 
        //          INNER JOIN trlpj c ON b.no_bukti=c.no_bukti WHERE no_lpj='$xlpj' ");  
		$skpd = $this->session->userdata('kdskpd');
		$query1 = $this->db->query("SELECT SUM(a.nilai)AS jml FROM trlpj_blud a INNER JOIN trhlpj_blud b ON a.no_lpj=b.no_lpj AND a.kd_skpd=b.kd_skpd
                  WHERE b.no_lpj='$xlpj' AND a.kd_skpd='$skpd' ");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'cjumlah'  =>  $resulte['jml']                       
                        );
                        $ii++;
        }
		echo json_encode($result);
        $query1->free_result();	
	}

	function load_sum_data_transaksi_lpj($dtgl1='',$dtgl2='') {
        $dtgl1  = $this->input->post('tgl1');
        $dtgl2  = $this->input->post('tgl2');
        $kdskpd  = $this->session->userdata('kdskpd');	

        $sql    = "SELECT SUM(a.nilai) as jumlah FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd WHERE (a.no_bukti+a.kd_kegiatan+a.kd_rek5) NOT IN(SELECT (no_bukti+kd_kegiatan+kd_rek5) FROM trlpj_blud) AND b.tgl_bukti >= '$dtgl1' and b.tgl_bukti <= '$dtgl2' and b.jns_spp in ('1','2') and b.kd_skpd='$kdskpd' 
                   "; 
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx' => $ii,
                        'jumlah' => $resulte['jumlah']
                        );
                        $ii++;
        }
           echo json_encode($result);
           $query1->free_result();
    }
	
	function load_sum_tran(){
		$skpd = $this->session->userdata('kdskpd');
		$id = $this->input->post('no_bukti');
        $query1 = $this->db->query("select sum(nilai) as rektotal from trdtransout_blud where no_bukti='$id' AND kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal'  => $resulte['rektotal'],
                        'rektotal1' => $resulte['rektotal']                       
                        );
                        $ii++;
        }
           
		   echo json_encode($result);
            $query1->free_result();	
	}
    
	function sisa_spd_global(){
		$skpd = $this->session->userdata('kdskpd');
        $query1 = $this->db->query("SELECT ISNULL(nilai_spd,0) spd, ISNULL(transaksi,0) transaksi, isnull(nilai_spd,0)-isnull(transaksi,0) sisa_spd FROM(
									select 1 as nomor, SUM(nilai) as nilai_spd from trhspd a 
									INNER JOIN trdspd b ON a.no_spd=b.no_spd
									WHERE kd_skpd = '$skpd' AND RIGHT(kd_kegiatan,5) !='00.51' AND status='1'
									) a LEFT JOIN (
									SELECT 1 as nomor, SUM(b.nilai) as transaksi FROM trhspp a 
									INNER JOIN trdspp b ON a.kd_skpd=b.kd_skpd AND a.no_spp=b.no_spp
									WHERE a.kd_skpd = '$skpd' AND RIGHT(b.kd_kegiatan,5) !='00.51'
									) b ON a.nomor=b.nomor");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'spd'  => $resulte['spd'],
                        'transaksi' => $resulte['transaksi'],                       
                        'sisa_spd' => $resulte['sisa_spd']                       
                        );
                        $ii++;
        }
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	function select_data1_lpj($lpj='') {
		$kd_skpd  = $this->session->userdata('kdskpd');
		$lpj = $this->input->post('lpj');
        $sql = "SELECT a.kd_skpd,a.nm_skpd,a.no_bukti,b.kd_kegiatan,b.kd_rek5,b.nm_rek5,b.nilai,c.no_lpj,c.tgl_lpj FROM trhtransout_blud a INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti 
				AND a.kd_skpd=b.kd_skpd INNER JOIN trlpj_blud c ON b.no_bukti=c.no_bukti AND b.kd_skpd=c.kd_skpd WHERE no_lpj='$lpj' AND a.kd_skpd='$kd_skpd' ORDER BY no_bukti,kd_kegiatan,kd_rek5";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'idx'        => $ii,
                        'no_bukti'   => $resulte['no_bukti'],  						
                        'kdkegiatan' => $resulte['kd_kegiatan'],     
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'nmrek5'     => $resulte['nm_rek5'], 						 
                        'nilai1'      => number_format($resulte['nilai'])

                        );
                        $ii++;
        }
           
           echo json_encode($result);
     $query1->free_result();
    }
	
	function dsimpan_lpj(){
	       $no_lpj      = $this->input->post('cnolpj');
           $vno_bukti   = $this->input->post('cnobukti');
                        
           $sql = "delete from trlpj_blud where no_lpj='$no_lpj' and no_bukti='$vno_bukti' ";
           $asg = $this->db->query($sql);

           echo '1';
	}
		
	function hhapuslpj() {    
  		$kd_skpd  = $this->session->userdata('kdskpd');
		$nomor = $this->input->post('no');        
        $query = $this->db->query("delete from trlpj_blud where no_lpj='$nomor' AND kd_skpd='$kd_skpd'");
        $query = $this->db->query("delete from trhlpj_blud where no_lpj='$nomor' AND kd_skpd='$kd_skpd'");
		echo '1';
    }
  
	function cetaklpjup_ag(){
		
		$cskpd  = $this->uri->segment(4);
        $ttd1   = str_replace('a',' ',$this->uri->segment(3));
        $ttd2   = str_replace('a',' ',$this->uri->segment(6));
		$ctk =   $this->uri->segment(5);
        $nomor1   = str_replace('abcdefghij','/',$this->uri->segment(7));
        $nomor   = str_replace('123456789',' ',$nomor1);
		$jns =   $this->uri->segment(8);
        $atas = $this->uri->segment(9);
        $bawah = $this->uri->segment(10);
        $kiri = $this->uri->segment(11);
        $kanan = $this->uri->segment(12);
		$lctgl1 = $this->rka_model->get_nama2($nomor,'tgl_awal','trhlpj_blud','no_lpj','kd_skpd',$cskpd);
		$lctgl2 = $this->rka_model->get_nama2($nomor,'tgl_akhir','trhlpj_blud','no_lpj','kd_skpd',$cskpd);
		$lctglspp = $this->rka_model->get_nama2($nomor,'tgl_lpj','trhlpj_blud','no_lpj','kd_skpd',$cskpd);


		
          
        $sqlsc = "SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$cskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                 }
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kd_skpd='$cskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip='Nip. '.$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$cskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1='Nip. '.$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		$cRet  =" <table style=\"border-collapse:collapse;font-size:15px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
    					<tr>
    						<td align='center'> <b>$kab</b></td>
    					</tr>
    					<tr>
    						<td align='center'><b>LAPORAN PERTANGGUNG JAWABAN UANG PERSEDIAAN</b></td>
    					</tr>
    					<tr>
    						<td align='center'><b>".strtoupper($jabatan1)."</b></td>
    					</tr>
						<tr>
    						<td align='center'><b>&nbsp;</b></td>
    					</tr>
		          </table>				
				";

		$cRet .=" <table border='0' style='font-size:12px' width='100%'>
    					<tr>
    						<td align='left' width='10%' valign=\"top\"> SKPD&nbsp;&nbsp;&nbsp;</td>
    						<td align='center' width='2%' valign=\"top\">:</td>
    						<td align='left' valign=\"top\"> ".$cskpd." ".$this->tukd_model->get_nama($cskpd,'nm_skpd','ms_skpd_blud','kd_skpd')." </td>
    					</tr>
    					<tr>
    						<td align='left' valign=\"top\">PERIODE&nbsp;&nbsp;&nbsp;</td>
    						<td align='center' valign=\"top\">:</td>
    						<td align='left' valign=\"top\">".$this->tukd_model->tanggal_format_indonesia($lctgl1).' s/d '.$this->tukd_model->tanggal_format_indonesia($lctgl2)."</td>
    					</tr>
		           </table>				
				";		

		$cRet .=" <table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
					<THEAD>
					<tr>
						<td bgcolor='#CCCCCC' align='center' width='5%'><b>NO</b></td>
						<td bgcolor='#CCCCCC' align='center' width='30%'><b>KODE REKENING</b></td>
						<td bgcolor='#CCCCCC' align='center' width='50%'><b>URAIAN</b></td>
						<td bgcolor='#CCCCCC' align='center' width='20%'><b>JUMLAH</b></td>
					</tr>
					<tr>
						<td bgcolor='#CCCCCC' align='center' width='5%'><b>1</b></td>
						<td bgcolor='#CCCCCC' align='center' width='30%'><b>2</b></td>
						<td bgcolor='#CCCCCC' align='center' width='50%'><b>3</b></td>
						<td bgcolor='#CCCCCC' align='center' width='20%'><b>4</b></td>
					</tr>
					</THEAD>
				";		
			
				if($jns=='0'){
				$sql = "SELECT 1 as urut, LEFT(a.kd_kegiatan,18) as kode, b.nm_program as uraian, SUM(a.nilai) as nilai
						FROM trlpj_blud a LEFT JOIN (SELECT DISTINCT kd_program,nm_program,kd_skpd FROM trskpd_blud GROUP BY kd_program,nm_program,kd_skpd)b 
						ON LEFT(a.kd_kegiatan,18) =b.kd_program AND a.kd_skpd=b.kd_skpd
						WHERE a.no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY LEFT(a.kd_kegiatan,18), b.nm_program
						UNION ALL
						SELECT 2 as urut, a.kd_kegiatan as kode, b.nm_kegiatan as uraian, SUM(a.nilai) as nilai
						FROM trlpj_blud a LEFT JOIN trskpd_blud b ON a.kd_kegiatan=b.kd_kegiatan AND a.kd_skpd=b.kd_skpd
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY a.kd_kegiatan, b.nm_kegiatan
						UNION ALL
						SELECT 3 as urut, kd_kegiatan+'.'+LEFT(a.kd_rek5,2) as kode, b.nm_rek2 as uraian, SUM(nilai) as nilai FROM trlpj_blud a
						INNER JOIN ms_rek2_blud b ON LEFT(a.kd_rek5,2)=b.kd_rek2
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY kd_kegiatan, LEFT(a.kd_rek5,2), b.nm_rek2
						UNION ALL
						SELECT 4 as urut, kd_kegiatan+'.'+LEFT(a.kd_rek5,3) as kode, b.nm_rek3 as uraian, SUM(nilai) as nilai FROM trlpj_blud a
						INNER JOIN ms_rek3_blud b ON LEFT(a.kd_rek5,3)=b.kd_rek3
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY kd_kegiatan, LEFT(a.kd_rek5,3), b.nm_rek3
						UNION ALL
						SELECT 5 as urut, kd_kegiatan+'.'+LEFT(a.kd_rek5,5) as kode, b.nm_rek4 as uraian, SUM(nilai) as nilai FROM trlpj_blud a
						INNER JOIN ms_rek4_blud b ON LEFT(a.kd_rek5,5)=b.kd_rek4
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY kd_kegiatan, LEFT(a.kd_rek5,5), b.nm_rek4
						UNION ALL
						SELECT 6 as urut, kd_kegiatan + '.' + left(kd_rek5,1)+'.'+substring(kd_rek5,2,1)+'.'+substring(kd_rek5,3,1)+'.'+substring(kd_rek5,4,2)+'.'+substring(kd_rek5,6,2) AS kode, nm_rek5 as uraian, SUM(nilai) as nilai FROM trlpj_blud
						WHERE no_lpj='$nomor' AND kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY kd_kegiatan, kd_rek5, nm_rek5
						ORDER BY kode";		
				$query1 = $this->db->query($sql); 
				$total=0;
				$i=0;
				foreach ($query1->result() as $row) {
                    $kode=$row->kode;                    
                    $urut=$row->urut;                    
                    $uraian= $row->uraian;
                    $nilai  = $row->nilai;
					
					if ($urut==1){
					$i=$i+1;	
						$cRet .="<tr>
									<td valign='top' align='center' ><i><b>$i</b></i></td>
									<td valign='top' align='left' ><i><b>$kode</b></i></td>
									<td valign='top' align='left' ><i><b>$uraian</b></i></td>
									<td valign='top' align='right'><i><b>".number_format($nilai,"2",",",".")."</b></i></td>
								</tr>";
					} else if ($urut==2){
							$cRet .="<tr>
									<td valign='top' align='center' ><b></b></td>
									<td valign='top' align='left' ><b>$kode</b></td>
									<td valign='top' align='left' ><b>$uraian</b></td>
									<td valign='top' align='right'><b>".number_format($nilai,"2",",",".")."</b></td>
								</tr>";
					}else if ($urut==6){
							$total=$total+$nilai;
							$cRet .="<tr>
									<td valign='top' align='center' ></td>
									<td valign='top' align='left' >$kode</td>
									<td valign='top' align='left' >$uraian</td>
									<td valign='top' align='right'>".number_format($nilai,"2",",",".")."</td>
								</tr>";
					}
					else{
						$cRet .="<tr>
									<td valign='top' align='left' ></td>
									<td valign='top' align='left' >$kode</td>
									<td valign='top' align='left' >$uraian</td>
									<td valign='top' align='right' >".number_format($nilai,"2",",",".")."</td>
								</tr>";	
					}

				}
				} else{
				$sql = "SELECT 1 as urut, LEFT(a.kd_kegiatan,18) as kode, b.nm_program as uraian, SUM(a.nilai) as nilai
						FROM trlpj_blud a LEFT JOIN (SELECT DISTINCT kd_program,nm_program,kd_skpd FROM trskpd_blud GROUP BY kd_program,nm_program,kd_skpd)b 
						ON LEFT(a.kd_kegiatan,18) =b.kd_program AND a.kd_skpd=b.kd_skpd
						WHERE a.no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY LEFT(a.kd_kegiatan,18), b.nm_program
						UNION ALL
						SELECT 2 as urut, a.kd_kegiatan as kode, b.nm_kegiatan as uraian, SUM(a.nilai) as nilai
						FROM trlpj_blud a LEFT JOIN trskpd_blud b ON a.kd_kegiatan=b.kd_kegiatan AND a.kd_skpd=b.kd_skpd
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND no_bukti IN (SELECT no_bukti FROM trhtransout_blud WHERE kd_skpd='$cskpd'
						AND jns_spp IN ('1','2','3'))
						GROUP BY a.kd_kegiatan, b.nm_kegiatan
						ORDER BY kode";		
				$query1 = $this->db->query($sql); 
				$total=0;
				$i=0;
				foreach ($query1->result() as $row) {
                    $kode=$row->kode;                    
                    $urut=$row->urut;                    
                    $uraian= $row->uraian;
                    $nilai  = $row->nilai;
					
					if ($urut==1){
					$i=$i+1;	
						$cRet .="<tr>
									<td valign='top' align='center' ><b>$i</b></td>
									<td valign='top' align='left' ><b>$kode</b></td>
									<td valign='top' align='left' ><b>$uraian</b></td>
									<td valign='top' align='right'><b>".number_format($nilai,"2",",",".")."</b></td>
								</tr>";
					} else{
						$total=$total+$nilai;
						$cRet .="<tr>
									<td valign='top' align='left' ></td>
									<td valign='top' align='left' >$kode</td>
									<td valign='top' align='left' >$uraian</td>
									<td valign='top' align='right' >".number_format($nilai,"2",",",".")."</td>
								</tr>";	
					}

				}	
				}


				$sqlp = " SELECT SUM(a.nilai) AS nilai FROM trdspp_blud a LEFT JOIN trhsp2d_blud b ON b.no_spp=a.no_spp  
						  WHERE b.kd_skpd='$cskpd' AND (b.jns_spp=1)";
				$queryp = $this->db->query($sqlp);  	
				foreach($queryp->result_array() as $nlx){ 
						$persediaan=$nlx["nilai"];
				}

				$cRet .="
						<tr>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='right' >&nbsp;</td>
						</tr>					
						<tr>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='right' ><b>Total</b></td>
							<td align='right' ><b>".number_format($total,"2",",",".")."</b></td>
						</tr>					
						<tr>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='right' ><b>Uang Persediaan Awal Periode</b></td>
							<td align='right' ><b>".number_format($persediaan,"2",",",".")."</b></td>
						<tr>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='right' ><b>Uang Persediaan Ahir Periode</b></td>
							<td align='right' ><b>".number_format($persediaan-$total,"2",",",".")."</b></td>
						</tr>
						</tr>
					    ";


				$cRet .="</table><p>";				
//.$this->tukd_model->tanggal_format_indonesia($this->uri->segment(7)).
 		$cRet .=" <table width='100%' style='font-size:12px' border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
					<tr>
						<td valign='top' align='center' width='50%'>Mengetahui <br> $jabatan	</td>
						<td valign='top' align='center' width='50%'>$daerah, ".$this->tukd_model->tanggal_format_indonesia($lctglspp)." <br> $jabatan1</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'><b><u>$nama</u></b><br>$pangkat</td>
						<td align='center' width='50%'><b><u>$nama1</u></b><br>$pangkat1</td>
					</tr>
					<tr>
						<td align='center' width='50%'>$nip</td>
						<td align='center' width='50%'>$nip1</td>
					</tr>
				  </table>
				";		

        $data['prev']= $cRet; 

		switch ($ctk)
        {
            case 0;
			   echo ("<title> LPJ UP</title>");
				echo $cRet;		
				break;
            case 1;
				$this->_mpdf_margin('',$cRet,10,10,10,'0',1,'',$atas,$bawah,$kiri,$kanan);
				//$this->_mpdf('',$cRet,10,10,10,'0',0,'');
               break;
		}
	}
    
	function cetaklpjup_ag_rinci(){
		
		$cskpd  = $this->uri->segment(4);
        $ttd1   = str_replace('a',' ',$this->uri->segment(3));
        $ttd2   = str_replace('a',' ',$this->uri->segment(6));
		$ctk =   $this->uri->segment(5);
        $nomor   = str_replace('abcdefghij','/',$this->uri->segment(7));
        $nomor   = str_replace('123456789',' ',$nomor);
		$kegiatan =   $this->uri->segment(8);
        $atas = $this->uri->segment(9);
        $bawah = $this->uri->segment(10);
        $kiri = $this->uri->segment(11);
        $kanan = $this->uri->segment(12);

		$lctgl1 = $this->rka_model->get_nama2($nomor,'tgl_awal','trhlpj_blud','no_lpj','kd_skpd',$cskpd);
		$lctgl2 = $this->rka_model->get_nama2($nomor,'tgl_akhir','trhlpj_blud','no_lpj','kd_skpd',$cskpd);
		$lctglspp = $this->rka_model->get_nama2($nomor,'tgl_lpj','trhlpj_blud','no_lpj','kd_skpd',$cskpd);
		/*
		$lctgl1 = $this->tukd_model->get_nama($nomor,'tgl_awal','trhlpj','no_lpj');
		$lctgl2 = $this->tukd_model->get_nama($nomor,'tgl_akhir','trhlpj','no_lpj');
		$lctglspp = $this->tukd_model->get_nama($nomor,'tgl_lpj','trhlpj','no_lpj');
		*/
          
        $sqlsc = "SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$cskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
                 }
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kd_skpd='$cskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip='Nip. '.$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$cskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1='Nip. '.$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		$cRet  =" <table style=\"border-collapse:collapse;font-size:15px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
    					<tr>
    						<td align='center'> <b>$kab</b></td>
    					</tr>
    					<tr>
    						<td align='center'><b>LAPORAN PERTANGGUNG JAWABAN UANG PERSEDIAAN</b></td>
    					</tr>
    					<tr>
    						<td align='center'><b>".strtoupper($jabatan1)."</b></td>
    					</tr>
						<tr>
    						<td align='center'><b>&nbsp;</b></td>
    					</tr>
		          </table>				
				";

		$cRet .=" <table border='0' style='font-size:12px' width='100%'>
    					<tr>
    						<td align='left' width='12%'>SKPD&nbsp;&nbsp;&nbsp;</td>
    						<td align='center' width='3%'>:&nbsp;&nbsp;&nbsp;</td>
    						<td align='left' width='85%'> ".$cskpd." ".$this->tukd_model->get_nama($cskpd,'nm_skpd','ms_skpd_blud','kd_skpd')." </td>
    					</tr>
    					<tr>
    						<td align='left' >PERIODE&nbsp;&nbsp;&nbsp;</td>
    						<td align='center' >:&nbsp;&nbsp;&nbsp;</td>
    						<td align='left' >".$this->tukd_model->tanggal_format_indonesia($lctgl1).' s/d '.$this->tukd_model->tanggal_format_indonesia($lctgl2)."</td>
    					</tr>
						<tr>
    						<td align='left' >Kegiatan&nbsp;&nbsp;&nbsp;</td>
    						<td align='center' >:&nbsp;&nbsp;&nbsp;</td>
    						<td align='left' >$kegiatan - ".$this->tukd_model->get_nama($kegiatan,'nm_kegiatan','trskpd_blud','kd_kegiatan')."</td>
    					</tr>
						<tr>
    						<td align='left' >&nbsp;&nbsp;&nbsp;</td>
    						<td align='center' >&nbsp;&nbsp;&nbsp;</td>
    						<td align='left' ></td>
    					</tr>
		           </table>				
				";		

		$cRet .=" <table style=\"border-collapse:collapse;font-size:12px\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
					<THEAD>
					<tr>
						<td bgcolor='#CCCCCC' align='center' width='5%'><b>NO</b></td>
						<td bgcolor='#CCCCCC' align='center' width='28%'><b>KODE REKENING</b></td>
						<td bgcolor='#CCCCCC' align='center' width='49%'><b>URAIAN</b></td>
						<td bgcolor='#CCCCCC' align='center' width='18%'><b>JUMLAH</b></td>
					</tr>
					<tr>
						<td bgcolor='#CCCCCC' align='center' ><b>1</b></td>
						<td bgcolor='#CCCCCC' align='center' ><b>2</b></td>
						<td bgcolor='#CCCCCC' align='center' ><b>3</b></td>
						<td bgcolor='#CCCCCC' align='center' ><b>4</b></td>
					</tr>
					</THEAD>
				";		
			
				
				$sql = "SELECT 1 as urut, a.kd_kegiatan as kode, a.kd_kegiatan as rek, b.nm_kegiatan as uraian, SUM(a.nilai) as nilai
						,'' [tgl_bukti],0 [no_bukti]
						FROM trlpj_blud a LEFT JOIN trskpd_blud b ON a.kd_kegiatan=b.kd_kegiatan AND a.kd_skpd=b.kd_skpd
						INNER JOIN trhtransout_blud c ON a.no_bukti=c.no_bukti AND a.kd_skpd=c.kd_skpd
						
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND a.kd_kegiatan='$kegiatan'
						GROUP BY a.kd_kegiatan, b.nm_kegiatan
						UNION ALL
						SELECT 2 as urut, kd_kegiatan+'.'+LEFT(a.kd_rek5,2) as kode, LEFT(a.kd_rek5,2) as rek,  nm_rek2 as uraian, SUM(nilai) as nilai,
						'' [tgl_bukti],0 [no_bukti] FROM trlpj_blud a
						INNER JOIN ms_rek2_blud b ON LEFT(a.kd_rek5,2)=b.kd_rek2
						INNER JOIN trhtransout_blud c ON a.no_bukti=c.no_bukti AND a.kd_skpd=c.kd_skpd
						
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND a.kd_kegiatan='$kegiatan'
						GROUP BY kd_kegiatan, LEFT(a.kd_rek5,2), nm_rek2
						UNION ALL
						SELECT 2 as urut, kd_kegiatan+'.'+LEFT(a.kd_rek5,3) as kode, LEFT(a.kd_rek5,3) as rek,  nm_rek3 as uraian, SUM(nilai) as nilai,
						'' [tgl_bukti],0 [no_bukti] FROM trlpj_blud a
						INNER JOIN ms_rek3_blud b ON LEFT(a.kd_rek5,3)=b.kd_rek3
						INNER JOIN trhtransout_blud c ON a.no_bukti=c.no_bukti AND a.kd_skpd=c.kd_skpd
						
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND a.kd_kegiatan='$kegiatan'
						GROUP BY kd_kegiatan, LEFT(a.kd_rek5,3), nm_rek3
						UNION ALL
						SELECT 2 as urut, kd_kegiatan+'.'+LEFT(a.kd_rek5,5) as kode, LEFT(a.kd_rek5,5) as rek,  nm_rek4 as uraian, SUM(nilai) as nilai 
						,'' [tgl_bukti],0 [no_bukti] FROM trlpj_blud a
						INNER JOIN ms_rek4_blud b ON LEFT(a.kd_rek5,5)=b.kd_rek4
						INNER JOIN trhtransout_blud c ON a.no_bukti=c.no_bukti AND a.kd_skpd=c.kd_skpd
						
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND a.kd_kegiatan='$kegiatan'
						GROUP BY kd_kegiatan, LEFT(a.kd_rek5,5), nm_rek4
						UNION ALL
						SELECT 2 as urut, kd_kegiatan+'.'+kd_rek5 as kode, kd_rek5 as rek,  nm_rek5 as uraian, SUM(nilai) as nilai
						,'' [tgl_bukti],0 [no_bukti]
						FROM trlpj_blud a
						INNER JOIN trhtransout_blud c ON a.no_bukti=c.no_bukti AND a.kd_skpd=c.kd_skpd
						
						WHERE no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND kd_kegiatan='$kegiatan'
						GROUP BY kd_kegiatan, kd_rek5, nm_rek5
						UNION ALL
						SELECT 3 as urut, a.kd_kegiatan+'.'+a.kd_rek5+'.1' as kode,'' as rek, c.ket+' \\ No BKU: '+a.no_bukti as uraian, sum(a.nilai) as nilai,
						c.tgl_bukti,a.no_bukti 
						FROM trlpj_blud a 
						INNER JOIN trhlpj_blud b ON a.no_lpj=b.no_lpj AND a.kd_skpd=b.kd_skpd
						INNER JOIN trhtransout_blud c ON a.no_bukti=c.no_bukti AND a.kd_skpd=c.kd_skpd
						
						WHERE a.no_lpj='$nomor' AND a.kd_skpd='$cskpd'
						AND a.kd_kegiatan='$kegiatan'
						GROUP BY a.kd_kegiatan, a.kd_rek5,nm_rek5,a.no_bukti, ket,tgl_bukti
						ORDER BY kode,tgl_bukti,no_bukti	";		
				$query1 = $this->db->query($sql); 
				$total=0;
				$i=0;
				foreach ($query1->result() as $row) {
                    $kode=$row->kode;                    
                    $rek=$row->rek;                    
                    $urut=$row->urut;                    
                    $uraian= $row->uraian;
                    $nilai  = $row->nilai;
					
					if ($urut==1){
					$i=$i+1;	
						$cRet .="<tr>
									<td valign='top' align='center' ><i><b>$i</b></i></td>
									<td valign='top' align='left' ><i><b>$kode</b></i></td>
									<td valign='top' align='left' ><i><b>$uraian</b></i></td>
									<td valign='top' align='right'><i><b>".number_format($nilai,"2",",",".")."</b></i></td>
								</tr>";
					} else if ($urut==2){
							$cRet .="<tr>
									<td valign='top' align='center' ><b></b></td>
									<td valign='top' align='left' ><b>$kode</b></td>
									<td valign='top' align='left' ><b>$uraian</b></td>
									<td valign='top' align='right'><b>".number_format($nilai,"2",",",".")."</b></td>
								</tr>";
					}else{
						$total=$total+$nilai;
						$cRet .="<tr>
									<td valign='top' align='left' ></td>
									<td valign='top' align='left' >$rek</td>
									<td valign='top' align='left' >$uraian</td>
									<td valign='top' align='right' >".$this->rp_minus($nilai)."</td>
								</tr>";	
					}

				}
				

				$cRet .="
						<tr>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='right' >&nbsp;</td>
						</tr>					
						<tr>
							<td align='left' >&nbsp;</td>
							<td align='left' >&nbsp;</td>
							<td align='right' ><b>Total</b></td>
							<td align='right' ><b>".number_format($total,"2",",",".")."</b></td>
						</tr>					
						
					    ";


				$cRet .="</table><p>";				
//.$this->tukd_model->tanggal_format_indonesia($this->uri->segment(7)).
 		$cRet .=" <table width='100%' style='font-size:12px' border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
					<tr>
						<td valign='top' align='center' width='50%'>Mengetahui <br> $jabatan	</td>
						<td valign='top' align='center' width='50%'>$daerah, ".$this->tukd_model->tanggal_format_indonesia($lctglspp)." <br> $jabatan1</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'>&nbsp;</td>
						<td align='center' width='50%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center' width='50%'><b><u>$nama</u></b><br>$pangkat</td>
						<td align='center' width='50%'><b><u>$nama1</u></b><br>$pangkat1</td>
					</tr>
					<tr>
						<td align='center' width='50%'>$nip</td>
						<td align='center' width='50%'>$nip1</td>
					</tr>
				  </table>
				";		

        $data['prev']= $cRet; 

		switch ($ctk)
        {
            case 0;
			   echo ("<title> LPJ UP</title>");
				echo $cRet;		
				break;
            case 1;
				$this->_mpdf_margin('',$cRet,10,10,10,'0',1,'',$atas,$bawah,$kiri,$kanan);
				//$this->_mpdf('',$cRet,10,10,10,'0',0,'');
               break;
		}
	}
	
	function cetaksptb_lpj(){
		$print = $this->uri->segment(3);
        $nomor   = str_replace('abcdefghij','/',$this->uri->segment(4));
        $nomor   = str_replace('123456789',' ',$nomor);
        $jns   = $this->uri->segment(5);
        $kd    = $this->uri->segment(6);
		$PA = str_replace('a',' ',$this->uri->segment(7));

        
        $alamat_skpd = $this->rka_model->get_nama($kd,'alamat','ms_skpd_blud','kd_skpd');		
        $kodepos = '';//$this->rka_model->get_nama($kd,'kodepos','ms_skpd_blud','kd_skpd');
		$nm_skpd = $this->rka_model->get_nama($kd,'nm_skpd','ms_skpd_blud','kd_skpd');
		 
		if($kodepos==''){
				$kodepos = "-------";
			} else {
				$kodepos = "$kodepos";
			}
        
       
		$sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where nip='$PA' and kode = 'PA' AND kd_skpd='$kd' ";
		 $sqlttd=$this->db->query($sqlttd1);
		 foreach ($sqlttd->result() as $rowttd)
		{
			$nip=$rowttd->nip;                    
			$nama= $rowttd->nm;
			$jabatan  = $rowttd->jab;
			$pangkat  = $rowttd->pangkat;
		}
        $stsubah =$this->rka_model->get_nama($kd,'status_ubah','trhrka_blud','kd_skpd');
		if($stsubah == 0){
			$sqldpa="SELECT no_dpa as no , tgl_dpa as tgl from trhrka_blud where kd_skpd = '$kd'";
		} else {
			$sqldpa="SELECT no_dpa_ubah as no, tgl_dpa_ubah as tgl from trhrka_blud where kd_skpd = '$kd'";
		}
		$sqldpa=$this->db->query($sqldpa);
		 foreach ($sqldpa->result() as $rowdpa)
		{
			$no_dpa=$rowdpa->no;                    
			$tgl_dpa = $this->tanggal_format_indonesia($rowdpa->tgl);
		}
		
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$kd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                {
                    $kab     = $rowsc->kab_kota;
                    $daerah  = $rowsc->daerah;
					$thn_ang = $rowsc->thn_ang;
                   
                }		

        $cRet='';
       $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
						<td rowspan=\"5\" align=\"right\">
                        <img src=\"".base_url()."/image/logoHP.bmp\"  width=\"75\" height=\"100\" />
                        </td>
					    <td colspan=\"2\" align=\"center\" style=\"font-size:14px\"><strong>PEMERINTAH PROVINSI KALIMANTAN BARAT </strong></td></tr>";

 
        
        if(substr($kd,0,7)==$this->org_keu && $kd!=$this->skpd_keu ){
                $nm_org = $this->rka_model->get_nama($this->skpd_keu,'nm_skpd','ms_skpd_blud','kd_skpd');           
                $cRet .="<tr><td align=\"center\" style=\"font-size:13px\">$nm_org</tr>";
        }

       $cRet .="    
                    <tr><td align=\"center\" style=\"font-size:13px\"><pre style=\"font-family: Times New Roman;\">$nm_skpd</pre></td></tr>
					<tr><td align=\"center\" style=\"font-size:12px\">$alamat_skpd</td></tr>
                    <tr><td align=\"right\">".strtoupper($daerah)." &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
					&nbsp;&nbsp; &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp;  Kode Pos: $kodepos &nbsp; &nbsp;</td>	</tr>
					</table>
					<hr  width=\"100%\"> 
					
									
				<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr><td align=\"center\"><strong><u>SURAT PERNYATAAN TANGGUNG JAWABAN BELANJA</u></strong></td></tr>
                    <tr><td align=\"center\">&nbsp;</td></tr>
                  </table>

		        <table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">";
                                  
                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">1. SKPD </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$kd - $nm_skpd</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">2. Satuan Kerja</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$kd - $nm_skpd</td>
                                     </tr>";				 

                    $cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">3. Tanggal/NO. DPA</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$tgl_dpa dan $no_dpa</td>
                                     </tr>";
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">4. Tahun Anggaran</td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									$thn_ang</td>
                                     </tr>";									 
				
      if ($jns==1){ //SPTB LPJ UP
		$sql1="select sum(nilai) [nilai],b.tgl_lpj from trlpj_blud a join trhlpj_blud b on a.no_lpj=b.no_lpj and a.kd_skpd=b.kd_skpd 
				where a.no_lpj='$nomor' and b.jenis='$jns'  and  a.kd_skpd='$kd' group by b.tgl_lpj ";
                 
                 $query = $this->db->query($sql1);
                                                  
                foreach ($query->result() as $row)
                {
					$tgl=$row->tgl_lpj;
                    $tanggal = $this->tanggal_format_indonesia($tgl);         
                    $nilai=number_format($row->nilai,"2",",",".");
                    //echo($a);
                }
                            

					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">5. Jumlah Belanja </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\">:</td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									Rp. $nilai</td>
                                     </tr>";

									 
		}
	  
	  
					$cRet    .= " <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"20%\" align=\"left\">&nbsp; </td> 
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"2%\" align=\"center\"></td>                                     
									<td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"75%\" align=\"justify\">
									&nbsp;</td>
                                     </tr>";					
        $cRet .=       " </table>";
       
		 $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    
                    <tr><td align=\"justify\">Yang bertanda tangan di bawah ini adalah $jabatan Satuan Kerja $nm_skpd Menyatakan bahwa saya bertanggung jawab penuh atas segala pengeluaran-pengeluaran
					yang telah dibayar lunas oleh Bendahara Pengeluaran kepada yang berhak menerima, sebagaimana tertera dalam Laporan Pertanggung Jawaban Ganti Uang di sampaikan oleh Bendahara Pengeluaran
					<br>
					<br>
					Bukti-bukti belanja tertera dalam Laporan Pertanggung Jawaban Ganti Uang disimpan sesuai ketentuan yang berlaku pada sistem Satuan Kerja $nm_skpd
					untuk kelengkapan administrasi dan keperluan pemeriksaan aparat pengawasan Fungsional
					<br>
					<br>
					Demikian Surat Pernyataan ini dibuat dengan sebenarnya</td></tr>
                    <tr><td align=\"left\">&nbsp;</td></tr>
                  </table>";
        $cRet .="<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$daerah, $tanggal</td></tr>
                    <tr><td align=\"center\" width=\"25%\"></td>                    
                    <td align=\"center\" width=\"25%\">$jabatan</td></tr>
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                    <tr><td align=\"center\" width=\"25%\"> </td>                    
                    <td align=\"center\" width=\"25%\"><b><u>$nama</u></b><br>
					 $pangkat <br>
					 NIP. $nip</td></tr>                              
                    <tr><td align=\"center\" width=\"25%\">&nbsp;</td>                    
                    <td align=\"center\" width=\"25%\">&nbsp;</td></tr>
                  </table>";
        
        $data['prev']= $cRet;
        if($print=='1'){
			
			//_mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='')
			
			$this->_mpdf('',$cRet,10,10,10,'0',1,''); 
			}
		if($print=='0'){
		echo $cRet;
		}
            
    }
	
	function load_data_transaksi_lpj($dtgl1='',$dtgl2='',$kdskpd='') {
        $dtgl1  = $this->input->post('tgl1');
        $dtgl2  = $this->input->post('tgl2');
        $kdskpd = $this->input->post('kdskpd');

        $sql    = "SELECT a.kd_kegiatan,a.nm_kegiatan,a.kd_rek5,a.nm_rek5,a.kd_rek_blud,a.nm_rek_blud,a.nilai, a.no_bukti FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE (a.no_bukti+a.kd_kegiatan+a.kd_rek5) NOT IN(SELECT (no_bukti+kd_kegiatan+kd_rek5) FROM trlpj_blud) 
				   AND b.tgl_bukti >= '$dtgl1' and b.tgl_bukti <= '$dtgl2' and b.jns_spp in ('1','2') and b.kd_skpd='$kdskpd' 
                   "; 
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx' => $ii,
                        'kdkegiatan' => $resulte['kd_kegiatan'],
                        'nmkegiatan' => $resulte['nm_kegiatan'],       
                        'kdrek5'     => $resulte['kd_rek5'],  
                        'nmrek5'     => $resulte['nm_rek5'],
						'kdrekblud'     => $resulte['kd_rek_blud'],  
                        'nmrekblud'     => $resulte['nm_rek_blud'],						
                        'nilai1'     => number_format($resulte['nilai'],2,'.',','),
                        'no_bukti'   => $resulte['no_bukti']
                        );
                        $ii++;
        }
           echo json_encode($result);
           $query1->free_result();
    }
	
	//akhir
    
	//mulai bk tunai
	function buku_tunai(){
        $data['page_title']= 'BUKU TUNAI';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'Buku Kas Tunai');   
        $this->template->load('template','tukd/transaksi/kas_tunai',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }
/*	
	function cetak_kas_tunai(){
			$print = $this->uri->segment(3);
			$thn_ang = $this->session->userdata('pcThang');
			$kd_skpd  = $this->session->userdata('kdskpd');
			$bulan= $_REQUEST['tgl1'];
			$spasi= $_REQUEST['spasi'];
			$adinas=$this->db->query("select * from sclient_blud WHERE kd_skpd='$kd_skpd'");
			$dinas=$adinas->row();
			$prov=$dinas->provinsi;
			$daerah=$dinas->daerah;
			$hasil = $this->db->query("SELECT * from ms_skpd_blud where kd_skpd = '$kd_skpd'");
			$trsk = $hasil->row();          
			$nm_skpd = $trsk->nm_skpd;
			
            $lcperiode = $this->tukd_model->getBulan($bulan);
       
			$tgl_ttd= $_REQUEST['tgl_ttd'];
         
			$ttd1 = str_replace('123456789',' ',$_REQUEST['ttd1']);
			$ttd2 = str_replace('123456789',' ',$_REQUEST['ttd2']);
			$csql="SELECT a.nama, a.nip,a.jabatan,a.pangkat FROM ms_ttd_blud a WHERE kode = 'BK' AND a.kd_skpd = '$kd_skpd' and nip='$ttd1'";
			$hasil = $this->db->query($csql);
			$trh2 = $hasil->row();          
			$lcNmBP = $trh2->nama;
			$lcNipBP = $trh2->nip;
			$lcJabBP = $trh2->jabatan;
			$lcPangkatBP = $trh2->pangkat;
			$csql="SELECT a.nama, a.nip,a.jabatan,a.pangkat FROM ms_ttd_blud a WHERE kode = 'PA' AND a.kd_skpd = '$kd_skpd' and nip='$ttd2'";
			$hasil = $this->db->query($csql);
			$trh2 = $hasil->row();          
			$lcNmPA = $trh2->nama;
			$lcNipPA = $trh2->nip; 			
			$lcJabPA = $trh2->jabatan; 			
			$lcPangkatPA = $trh2->pangkat; 			
		
		$esteh="SELECT 
				SUM(case when jns=1 then jumlah else 0 end ) AS terima,
				SUM(case when jns=2 then jumlah else 0 end) AS keluar
				FROM (
				SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
				select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
					from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
					where jns_trans NOT IN ('4','2') 
					GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd				
				UNION ALL
				SELECT	a.tgl_bukti AS tgl,	a.no_bukti AS bku, a.ket AS ket, SUM(z.nilai) - isnull(pot, 0) AS jumlah, '2' AS jns, a.kd_skpd AS kode
								FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
								LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
								LEFT JOIN (SELECT no_spm, SUM (nilai) pot	FROM trspmpot_blud GROUP BY no_spm) c
								ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
								AND MONTH(a.tgl_bukti)<'$bulan' and a.kd_skpd='$kd_skpd' 
								AND a.no_bukti NOT IN(
								select no_bukti from trhtransout_blud 
								where no_sp2d in 
								(SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)<'$bulan' and  no_kas not in
								(SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)<'$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd')
								GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
						UNION ALL
				SELECT	tgl_bukti AS tgl,	no_bukti AS bku, ket AS ket,  isnull(total, 0) AS jumlah, '2' AS jns, kd_skpd AS kode
								from trhtransout_blud 
								WHERE pay = 'TUNAI' and no_sp2d in 
								(SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)<'$bulan' and  no_kas not in
								(SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)<'$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd'
				
				UNION ALL
				SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION ALL
				SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI'
				) a 
				where month(a.tgl)<'$bulan' and kode='$kd_skpd'";
		$hasil = $this->db->query($esteh);
				
		$okok = $hasil->row();  
		$tox_awal="SELECT isnull(saldo_lalu,0) AS jumlah FROM ms_skpd_blud where kd_skpd='$kd_skpd'";
					 $hasil = $this->db->query($tox_awal);					 
					 $tox = $hasil->row('jumlah');
					 $terima = $okok->terima;
					 $keluar = $okok->keluar;					 
					 $saldotunai=($terima+$tox)-$keluar;
         $cRet = '';
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"6\" style=\"font-size:14px;border: solid 1px white;\"><b>$prov<br>BUKU KAS TUNAI<br>BENDAHARA PENGELUARAN</b></td>
            </tr>
              <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\"></td>
            </tr>
            </tr>
              <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\"></td>
            </tr>            
            <tr>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;\">SKPD</td>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;\">: $kd_skpd &nbsp; $nm_skpd</td> 
            </tr>
            <tr>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;\">PERIODE</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;\">: $lcperiode</td>
            </tr>
            
           
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;\">&nbsp;</td>
            </tr>
            
           
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;\">&nbsp;</td>
            </tr>
			</table>";

             $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"$spasi\">
            <thead>
			<tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" style=\"font-size:12px;\" >Tanggal.</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" style=\"font-size:12px;\">No. BKU</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Uraian</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Penerimaan</td> 
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Pengeluaran</td>  
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Saldo</td>            
            </tr> 
			</thead>
			<tr>
			
                <td align=\"center\" style=\"font-size:12px;\" ></td>
                <td align=\"center\" style=\"font-size:12px;\"></td>
                <td align=\"right\" style=\"font-size:12px;\">Saldo Lalu</td>
                <td align=\"center\" style=\"font-size:12px;\"></td> 
                <td align=\"center\" tyle=\"font-size:12px;\"></td>  
				<td align=\"right\" style=\"font-size:12px;\">".number_format($saldotunai,"2",",",".")."</td>            
            </tr> ";
			
			
				$sql="SELECT * FROM (
						SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS masuk,0 AS keluar,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
						
						
						select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, 0 as masuk,SUM(b.rupiah) as keluar, a.kd_skpd as kode 
								from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
								where jns_trans NOT IN ('4','2') 
								GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd	
						UNION ALL
						SELECT a.tgl_bukti AS tgl,a.no_bukti AS bku,a.ket AS ket,0 AS masuk, SUM(z.nilai)-isnull(pot,0)  AS keluar,a.kd_skpd AS kode 
								FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
								LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
								LEFT JOIN (SELECT no_spm, SUM (nilai) pot	FROM trspmpot_blud GROUP BY no_spm) c
								ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
								AND MONTH(a.tgl_bukti)='$bulan' and a.kd_skpd='$kd_skpd' 
								AND a.no_bukti NOT IN(
								select no_bukti from trhtransout_blud 
								where no_sp2d in 
								(SELECT ISNULL(no_sp2d,'') as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
								(SELECT ISNULL(min(z.no_kas),'') as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)='$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd')
								GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
						UNION ALL
						select tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,0 AS masuk, ISNULL(total,0)  AS keluar,kd_skpd AS kode 
								from trhtransout_blud 
								WHERE pay = 'TUNAI' AND no_sp2d in 
								(SELECT ISNULL(no_sp2d,'') as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
								(SELECT ISNULL(min(z.no_kas),'') as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)='$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd'

						UNION ALL
						
						SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket, 0 as masuk,nilai AS keluar,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION  ALL
						SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai as masuk,0 AS keluar,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI')a
						where month(a.tgl)='$bulan' and kode='$kd_skpd' ORDER BY a.tgl,CAST(bku AS int)";
                        $hasil = $this->db->query($sql);       
                        $saldo=$saldotunai;
						$total_terima=0;
						$total_keluar=0;
                        foreach ($hasil->result() as $row){
                           $bku =$row->bku ;
                           $tgl =$row->tgl;
                           $uraian  =$row->ket; 
                           $terimatunai   =$row->masuk;
                           $keluartunai   =$row->keluar;
                           $tgl = $this->tukd_model->tanggal_ind($tgl);
                           if ($keluartunai==1){ 
                           $saldo=$saldo+$terimatunai-$keluartunai;
						   $total_terima=$total_terima+$terimatunai;
						   $total_keluar=$total_keluar+$keluartunai;
                           
                            $cRet .="<tr>
							<td valign=\"top\" align=\"center\" style=\"font-size:12px;\">$tgl</td>
							<td valign=\"top\" align=\"center\" style=\"font-size:12px;\">$bku</td>
							<td valign=\"top\" align=\"left\" style=\"font-size:12px;\">$uraian</td>
							<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($terimatunai,"2",",",".")."</td>
							<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($keluartunai,"2",",",".")."</td>
							<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($saldo,"2",",",".")."</td>
                                      </tr>";                     
                           }else{
                           $saldo=$saldo+$terimatunai-$keluartunai;
						   $total_keluar=$total_keluar+$keluartunai;
						   $total_terima=$total_terima+$terimatunai;
                           $cRet .="<tr>
						<td valign=\"top\" align=\"center\" style=\"font-size:12px;\">$tgl</td>
						<td valign=\"top\" align=\"left\" style=\"font-size:12px;\">$bku</td>
						<td valign=\"top\" align=\"left\" style=\"font-size:12px;\">$uraian</td>
						<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($terimatunai,"2",",",".")."</td>
						<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($keluartunai,"2",",",".")."</td>
						<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($saldo,"2",",",".")."</td>
													  </tr>"; 
                                       
                           }           
                        }
		$cRet .="<tr>
        <td bgcolor=\"#CCCCCC\" colspan=\"3\" valign=\"top\" align=\"center\" style=\"font-size:12px;\">JUMLAH</td>
        <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($total_terima,"2",",",".")."</td>
        <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($total_keluar,"2",",",".")."</td>
        <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($total_terima-$total_keluar+$saldotunai,"2",",",".")."</td>
                                      </tr>"; 				
                 $cRet .="</table>";
      
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
		 <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">Mengetahui:</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$daerah, ".$this->tanggal_format_indonesia($tgl_ttd)."</td>                                                                                                                                                                                
                </tr>
                <tr>                
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$lcJabPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$lcJabBP</td>                    
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmPA</u></b><br>$lcPangkatPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmBP</u></b><br>$lcPangkatBP</td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"> NIP. $lcNipPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">NIP. $lcNipBP</td>
      
                </tr>";        
                                  
                
        $cRet .='</table>';
         if($print==0){
			 $data['prev']= $cRet;    
			 echo ("<title>Kas Tunai </title>");
			 echo $cRet;
			 }
		 else{
			$this->_mpdf('',$cRet,10,10,10,'0',0,'');
			}
    }
  */
	//akhir bk tunai 
	
//koreksi ali

	function cetak_kas_tunai(){
			$print = $this->uri->segment(3);
			$thn_ang = $this->session->userdata('pcThang');
			$kd_skpd  = $this->session->userdata('kdskpd');
			$bulan= $_REQUEST['tgl1'];
			$spasi= $_REQUEST['spasi'];
			$adinas=$this->db->query("select * from sclient_blud WHERE kd_skpd='$kd_skpd'");
			$dinas=$adinas->row();
			$prov=$dinas->provinsi;
			$daerah=$dinas->daerah;
			$hasil = $this->db->query("SELECT * from ms_skpd_blud where kd_skpd = '$kd_skpd'");
			$trsk = $hasil->row();          
			$nm_skpd = $trsk->nm_skpd;
			
            $lcperiode = $this->tukd_model->getBulan($bulan);
       
			$tgl_ttd= $_REQUEST['tgl_ttd'];
         
			$ttd1 = str_replace('123456789',' ',$_REQUEST['ttd1']);
			$ttd2 = str_replace('123456789',' ',$_REQUEST['ttd2']);
			$csql="SELECT a.nama, a.nip,a.jabatan,a.pangkat FROM ms_ttd_blud a WHERE kode = 'BK' AND a.kd_skpd = '$kd_skpd' and nip='$ttd1'";
			$hasil = $this->db->query($csql);
			$trh2 = $hasil->row();          
			$lcNmBP = $trh2->nama;
			$lcNipBP = $trh2->nip;
			$lcJabBP = $trh2->jabatan;
			$lcPangkatBP = $trh2->pangkat;
			$csql="SELECT a.nama, a.nip,a.jabatan,a.pangkat FROM ms_ttd_blud a WHERE kode = 'PA' AND a.kd_skpd = '$kd_skpd' and nip='$ttd2'";
			$hasil = $this->db->query($csql);
			$trh2 = $hasil->row();          
			$lcNmPA = $trh2->nama;
			$lcNipPA = $trh2->nip; 			
			$lcJabPA = $trh2->jabatan; 			
			$lcPangkatPA = $trh2->pangkat; 			
		
		$esteh="SELECT 
				SUM(case when jns=1 then jumlah else 0 end ) AS terima,
				SUM(case when jns=2 then jumlah else 0 end) AS keluar
				FROM (
				SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud
								
				UNION ALL
				SELECT	a.tgl_bukti AS tgl,	a.no_bukti AS bku, a.ket AS ket, SUM(z.nilai) - isnull(pot, 0) AS jumlah, '2' AS jns, a.kd_skpd AS kode
								FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
								LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
								LEFT JOIN (SELECT no_spm, SUM (nilai) pot	FROM trspmpot_blud GROUP BY no_spm) c
								ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
								AND MONTH(a.tgl_bukti)<'$bulan' and a.kd_skpd='$kd_skpd' 
								AND a.no_bukti NOT IN(
								select no_bukti from trhtransout_blud 
								where no_sp2d in 
								(SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)<'$bulan' and  no_kas not in
								(SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)<'$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd')
								GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
						UNION ALL
				SELECT	tgl_bukti AS tgl,	no_bukti AS bku, ket AS ket,  isnull(total, 0) AS jumlah, '2' AS jns, kd_skpd AS kode
								from trhtransout_blud 
								WHERE pay = 'TUNAI' and no_sp2d in 
								(SELECT no_sp2d as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)<'$bulan' and  no_kas not in
								(SELECT min(z.no_kas) as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)<'$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd'
				
				UNION ALL
				SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION ALL
				SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI'
				) a 
				where month(a.tgl)<'$bulan' and kode='$kd_skpd'";
		$hasil = $this->db->query($esteh);
				
		$okok = $hasil->row();  
		$tox_awal="SELECT isnull(saldo_lalu,0) AS jumlah FROM ms_skpd_blud where kd_skpd='$kd_skpd'";
					 $hasil = $this->db->query($tox_awal);					 
					 $tox = $hasil->row('jumlah');
					 $terima = $okok->terima;
					 $keluar = $okok->keluar;					 
					 $saldotunai=($terima+$tox)-$keluar;
         $cRet = '';
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"6\" style=\"font-size:14px;border: solid 1px white;\"><b>$prov<br>BUKU KAS TUNAI<br>BENDAHARA PENGELUARAN</b></td>
            </tr>
              <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\"></td>
            </tr>
            </tr>
              <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;\"></td>
            </tr>            
            <tr>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;\">SKPD</td>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;\">: $kd_skpd &nbsp; $nm_skpd</td> 
            </tr>
            <tr>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;\">PERIODE</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;\">: $lcperiode</td>
            </tr>
            
           
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;\">&nbsp;</td>
            </tr>
            
           
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;\">&nbsp;</td>
            </tr>
			</table>";

             $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"$spasi\">
            <thead>
			<tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" style=\"font-size:12px;\" >Tanggal.</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\" style=\"font-size:12px;\">No. BKU</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Uraian</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Penerimaan</td> 
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Pengeluaran</td>  
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;\">Saldo</td>            
            </tr> 
			</thead>
			<tr>
			
                <td align=\"center\" style=\"font-size:12px;\" ></td>
                <td align=\"center\" style=\"font-size:12px;\"></td>
                <td align=\"right\" style=\"font-size:12px;\">Saldo Lalu</td>
                <td align=\"center\" style=\"font-size:12px;\"></td> 
                <td align=\"center\" tyle=\"font-size:12px;\"></td>  
				<td align=\"right\" style=\"font-size:12px;\">".number_format($saldotunai,"2",",",".")."</td>            
            </tr> ";
			
			
				$sql="SELECT * FROM (
						SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS masuk,0 AS keluar,kd_skpd AS kode FROM tr_ambilsimpanan_blud UNION ALL
						
						SELECT a.tgl_bukti AS tgl,a.no_bukti AS bku,a.ket AS ket,0 AS masuk, SUM(z.nilai)-isnull(pot,0)  AS keluar,a.kd_skpd AS kode 
								FROM trhtransout_blud a INNER JOIN trdtransout_blud z ON a.no_bukti=z.no_bukti AND a.kd_skpd=z.kd_skpd
								LEFT JOIN trhsp2d_blud b ON z.no_sp2d = b.no_sp2d
								LEFT JOIN (SELECT no_spm, SUM (nilai) pot	FROM trspmpot_blud GROUP BY no_spm) c
								ON b.no_spm = c.no_spm WHERE pay = 'TUNAI' 
								AND MONTH(a.tgl_bukti)='$bulan' and a.kd_skpd='$kd_skpd' 
								AND a.no_bukti NOT IN(
								select no_bukti from trhtransout_blud 
								where no_sp2d in 
								(SELECT ISNULL(no_sp2d,'') as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
								(SELECT ISNULL(min(z.no_kas),'') as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)='$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd')
								GROUP BY a.tgl_bukti,a.no_bukti,a.ket,a.no_sp2d,z.no_sp2d,a.total,pot,a.kd_skpd
						UNION ALL
						select tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,0 AS masuk, ISNULL(total,0)  AS keluar,kd_skpd AS kode 
								from trhtransout_blud 
								WHERE pay = 'TUNAI' AND no_sp2d in 
								(SELECT ISNULL(no_sp2d,'') as no_bukti FROM trhtransout_blud where kd_skpd='$kd_skpd' GROUP BY no_sp2d HAVING COUNT(no_sp2d)>1)
								AND MONTH(tgl_bukti)='$bulan' and  no_kas not in
								(SELECT ISNULL(min(z.no_kas),'') as no_bukti FROM trhtransout_blud z WHERE z.jns_spp in (4,5,6) and kd_skpd='$kd_skpd' 
								AND MONTH(tgl_bukti)='$bulan'
								GROUP BY z.no_sp2d HAVING COUNT(z.no_sp2d)>1)
								and jns_spp in (4,5,6) and kd_skpd='$kd_skpd'

						UNION ALL
						
						SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket, 0 as masuk,nilai AS keluar,kd_skpd AS kode FROM tr_setorsimpanan_blud WHERE jenis ='2' UNION  ALL
						SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,nilai as masuk,0 AS keluar,kd_skpd AS kode FROM trhINlain_blud WHERE pay='TUNAI')a
						where month(a.tgl)='$bulan' and kode='$kd_skpd' ORDER BY a.tgl,CAST(bku AS int)";
                        $hasil = $this->db->query($sql);       
                        $saldo=$saldotunai;
						$total_terima=0;
						$total_keluar=0;
                        foreach ($hasil->result() as $row){
                           $bku =$row->bku ;
                           $tgl =$row->tgl;
                           $uraian  =$row->ket; 
                           $terimatunai   =$row->masuk;
                           $keluartunai   =$row->keluar;
                           $tgl = $this->tukd_model->tanggal_ind($tgl);
                           if ($keluartunai==1){ 
                           $saldo=$saldo+$terimatunai-$keluartunai;
						   $total_terima=$total_terima+$terimatunai;
						   $total_keluar=$total_keluar+$keluartunai;
                           
                            $cRet .="<tr>
							<td valign=\"top\" align=\"center\" style=\"font-size:12px;\">$tgl</td>
							<td valign=\"top\" align=\"center\" style=\"font-size:12px;\">$bku</td>
							<td valign=\"top\" align=\"left\" style=\"font-size:12px;\">$uraian</td>
							<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($terimatunai,"2",",",".")."</td>
							<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($keluartunai,"2",",",".")."</td>
							<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($saldo,"2",",",".")."</td>
                                      </tr>";                     
                           }else{
                           $saldo=$saldo+$terimatunai-$keluartunai;
						   $total_keluar=$total_keluar+$keluartunai;
						   $total_terima=$total_terima+$terimatunai;
                           $cRet .="<tr>
						<td valign=\"top\" align=\"center\" style=\"font-size:12px;\">$tgl</td>
						<td valign=\"top\" align=\"left\" style=\"font-size:12px;\">$bku</td>
						<td valign=\"top\" align=\"left\" style=\"font-size:12px;\">$uraian</td>
						<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($terimatunai,"2",",",".")."</td>
						<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($keluartunai,"2",",",".")."</td>
						<td valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($saldo,"2",",",".")."</td>
													  </tr>"; 
                                       
                           }           
                        }
		$cRet .="<tr>
        <td bgcolor=\"#CCCCCC\" colspan=\"3\" valign=\"top\" align=\"center\" style=\"font-size:12px;\">JUMLAH</td>
        <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($total_terima,"2",",",".")."</td>
        <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($total_keluar,"2",",",".")."</td>
        <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;\">".number_format($total_terima-$total_keluar+$saldotunai,"2",",",".")."</td>
                                      </tr>"; 				
                 $cRet .="</table>";
      
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
		 <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">Mengetahui:</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$daerah, ".$this->tanggal_format_indonesia($tgl_ttd)."</td>                                                                                                                                                                                
                </tr>
                <tr>                
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$lcJabPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$lcJabBP</td>                    
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmPA</u></b><br>$lcPangkatPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmBP</u></b><br>$lcPangkatBP</td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"> NIP. $lcNipPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">NIP. $lcNipBP</td>
      
                </tr>";        
                                  
                
        $cRet .='</table>';
         if($print==0){
			 $data['prev']= $cRet;    
			 echo ("<title>Kas Tunai </title>");
			 echo $cRet;
			 }
		 else{
			$this->_mpdf('',$cRet,10,10,10,'0',0,'');
			}
    }	
	
	//bprincianobyek
	function cetak_rincian_objek($dcetak='',$ttd1='',$skpd='',$rek5='',$dcetak2='',$giat='',$tgl_ctk='',$ttd2='',$ctk=''){
			 $spasi = $this->uri->segment(12);
           $ttd1 = str_replace('123456789',' ',$ttd1);
			$ttd2 = str_replace('123456789',' ',$ttd2);
			$sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$skpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $nm_prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kd_skpd='$skpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kd_skpd='$skpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
				
		   if($giat<>''){
                $keg='1';
                $giat=$giat;
                $nm_giat=$this->tukd_model->get_nama($giat,'nm_kegiatan','trskpd_blud','kd_kegiatan');
                //$nm_prov=$this->tukd_model->get_sclient('provinsi','sclient');
				}else{
                $keg='0';
                $giat='';
                $nm_giat='KESELURUHAN';
            }
            			
            //echo $dcetak .'/'. $ttd.'/'.$skpd.'/'.$rek5.'/'.$dcetak2.'/'.$giat.'/'.$keg;
		

			$cRet ='<TABLE width="100%">
					 <TR>                        
						<TD colspan="2" align="center" ><b>'.$nm_prov.'</TD>					
					 </TR>
					 <TR>                        
						<TD colspan="2" align="center" ><b>BUKU PEMBANTU RINCIAN OBJEK </TD>					
					 </TR>
					 </TABLE>
					 <TABLE style="font-size:12px" width="100%">
 					 <TR>                        
						<TD colspan="2" align="center" >&nbsp; </TD>					
					 </TR>
 					 <TR>                        
						<TD colspan="2" align="center" >&nbsp;</TD>					
					 </TR>
                     <TR>                        
						<TD align="left" width="15%" >SKPD </TD>
						<TD align="left" width="85%" >: '.$skpd.' '.$this->tukd_model->get_nama($skpd,'nm_skpd','ms_skpd_blud','kd_skpd').'</TD>
					 </TR>
                     <TR>
						<TD align="left" width="15%" >Kegiatan</TD>
						<TD align="left" width="85%" >: '.$giat.' '.$nm_giat.'</TD>
					 </TR>
					 <TR>
						<TD align="left" width="15%" >Rekening </TD>
						<TD align="left" width="85%" >: '.$rek5.' '.$this->tukd_model->get_nama($rek5,'nm_rek5','ms_rek5_blud','kd_rek5').'</TD>
					 </TR>
					 <TR>
						<TD align="left" width="15%" >Periode</TD>
						<TD align="left" width="85%" >: '.$this->tukd_model->tanggal_format_indonesia($dcetak).' s/d '.$this->tukd_model->tanggal_format_indonesia($dcetak2).'</TD>
					 </TR>
                     <TR>                        
						<TD colspan="2" align="center" >&nbsp;</TD>					
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse;font-size:12px" border="1" cellspacing="0" cellpadding="'.$spasi.'" width="100%" >
					<THEAD>
					 <TR>
						<TD width="40%" rowspan="2" colspan="2"  align="center" ><b>Nomor dan Tanggal BKU</b></TD>
						<TD width="60%" colspan="4"  align="center" ><b>Pengeluaran (Rp)</b></TD>					
					 </TR>
                     <TR>
 		                <TD width="15%" align="center"><b>LS</b></TD>
                        <TD width="15%"  align="center"><b>UP/GU</b></TD>
                        <TD width="15%"  align="center"><b>TU</b></TD>
                        <TD width="15%"  align="center"><b>JUMLAH</b></TD>
                     </TR>
					 </THEAD>';    
                   
                    $query = $this->db->query("SELECT ISNULL(a.no_bukti,'') as no_bukti
												,b.tgl_bukti
												,ISNULL(a.no_sp2d,'') as no_sp2d
												,SUM(CASE WHEN jns_spp IN ('1','2') THEN a.nilai ELSE 0 END) AS up
												,SUM(CASE WHEN jns_spp IN ('3') THEN a.nilai ELSE 0 END) AS gu
												,SUM(CASE WHEN jns_spp IN ('4','5','6') THEN a.nilai ELSE 0 END) AS ls
												FROM trdtransout_blud a 
												LEFT JOIN trhtransout_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd
												WHERE a.kd_kegiatan='$giat' 
												and a.kd_rek_blud='$rek5' 
												AND b.kd_skpd='$skpd' 
												and b.tgl_bukti>='$dcetak' 
												and b.tgl_bukti<='$dcetak2' 
												GROUP BY a.no_bukti, b.tgl_bukti,a.no_sp2d
												ORDER BY b.tgl_bukti,a.no_bukti
												");
				$i=0;
				$jumls=0;
				$jumup=0;
				$jumgu=0;
   	            $jml=0;  
				foreach($query->result_array() as $res){					
        							$cetak[1] = empty($res['no_bukti']) || $res['no_bukti']== null ?'&nbsp;' :$res['no_bukti'];
        							$cetak[2] = empty($res['no_sp2d']) || $res['no_sp2d']== null ?'&nbsp;' :$res['no_sp2d'];
        							$cetak[3] = empty($res['ls']) || $res['ls'] == null ?'&nbsp;' :$res['ls'];
        							$cetak[4] = empty($res['up']) || $res['up'] == null ?0 :$res['up'];
        							$cetak[5] = empty($res['gu']) || $res['gu'] == null ?0 :$res['gu'];
        							$cetak[6] = empty($res['tgl_bukti']) || $res['tgl_bukti'] == null ?0 :$res['tgl_bukti'];
                        $cRet .='<tr>
    								<td style="border-bottom:hidden;border-right:hidden;" align="left" ><b>&nbsp;'.$cetak[1].'</b> </td>
    								<td style="border-bottom:hidden;border-left:hidden;" align="right" >'.$this->tukd_model->tanggal_format_indonesia($cetak[6]).'&nbsp;</td>
									<td rowspan="2" align="right" >'.number_format($cetak[3],"2",",",".").'</td>
    								<td rowspan="2" align="right" >'.number_format($cetak[4],"2",",",".").'</td>
    								<td rowspan="2" align="right" >'.number_format($cetak[5],"2",",",".").'</td>
    								<td rowspan="2" align="right" >'.number_format($cetak[3]+$cetak[4]+$cetak[5],"2",",",".").'</td></tr>
								 <tr>
									<td colspan="2" align="left" ><i>&nbsp;SP2D: '.$cetak[2].'</i> </td>
    								
    							 </tr>';
                                     
                $jumls=$jumls+$cetak[3];
				$jumup=$jumup+$cetak[4];
				$jumgu=$jumgu+$cetak[5];
                $jml=$jml+$cetak[3]+$cetak[4]+$cetak[5];        
						
						
				}  
               
               
				$cRet .='<TR>				
					<TD colspan="2" align="left" ><i><b>Jumlah</i></b></TD>
					<TD align="right" ><b>'.number_format($jumls,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($jumup,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($jumgu,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($jml,"2",",",".").'</b></TD>					
				 </TR>';
				 
                $query = $this->db->query("SELECT SUM(CASE WHEN jns_spp IN ('1','2') THEN a.nilai ELSE 0 END) AS lalu_up
												,SUM(CASE WHEN jns_spp IN ('3') THEN a.nilai ELSE 0 END) AS lalu_gu
												,SUM(CASE WHEN jns_spp IN ('4','5','6') THEN a.nilai ELSE 0 END) AS lalu_ls
												FROM trdtransout_blud a 
												LEFT JOIN trhtransout_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd = b.kd_skpd
												WHERE a.kd_kegiatan='$giat' 
												and a.kd_rek_blud='$rek5' 
												AND b.kd_skpd='$skpd' 
												and b.tgl_bukti<'$dcetak' 
												");
                foreach($query->result_array() as $res){										
					$lalu_up=$res['lalu_up'];
					$lalu_gu=$res['lalu_gu'];
					$lalu_ls=$res['lalu_ls'];
				}
                $jml_lalu=$lalu_up+$lalu_gu+$lalu_ls;
                $tot=$jumup+$lalu_up;
                $tot1=$jumgu+$lalu_gu;
                $tot2=$jumls+$lalu_ls;
                $total=$tot+$tot1+$tot2;			 					
                $cRet .='<TR>				
					<TD colspan="2" align="left" ><i><b>Jumlah s/d periode lalu </i></b></TD>
					<TD align="right" ><b>'.number_format($lalu_ls,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($lalu_up,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($lalu_gu,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($jml_lalu,"2",",",".").'</b></TD>					
				 </TR>';
                 $cRet .='<TR>				
					<TD colspan="2" align="left" ><b><i>Jumlah s/d periode ini<i></b></TD>
					<TD align="right" ><b>'.number_format($tot2,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($tot,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($tot1,"2",",",".").'</b></TD>
					<TD align="right" ><b>'.number_format($total,"2",",",".").'</b></TD>					
				 </TR>';
			$cRet .='</TABLE>';
			$cRet .='<TABLE style="font-size:12px" width="100%" border="0">
					<TR>
						<TD align="center" width="50%"><b>&nbsp;</TD>
						<TD align="center" width="50%"><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" width="50%">Mengetahui,</TD>
						<TD align="center" width="50%">'.$daerah.', '.$this->tukd_model->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" width="50%">'.$jabatan.'</TD>
						<TD align="center" width="50%">'.$jabatan1.'</TD>
					</TR>
                    <TR>
						<TD align="center" width="50%"><b>&nbsp;</TD>
						<TD align="center" width="50%"><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" width="50%"><b>&nbsp;</TD>
						<TD align="center" width="50%"><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" width="50%"><u><b>'.$nama.'</b></u><br>'.$pangkat.'</TD>
						<TD align="center" width="50%"><u><b>'.$nama1.'</b></u><br>'.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" width="50%">'.$nip.'</TD>
						<TD align="center" width="50%">'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';
			$data['prev']= 'RINCIAN OBJEK';
            switch ($ctk) {
				case 0;
					echo ("<title> BP RINCIAN OBJEK</title>");
					echo $cRet;
					break;
				case 1;
					$this->rka_model->_mpdf('',$cRet,10,10,10,'P',0,'',15,15,15,15);
					break;
			}
	} 
	
	//akhirbprincianobyek
	
	
	//mulai buku bank
	function buku_bank(){
        $data['page_title']= 'Buku Simpanan Bank';
		$data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'Buku Simpanan Bank');   
        $this->template->load('template','tukd/transaksi/kas_bank',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }

	function cetak_simpanan_bank(){
			$print = $this->uri->segment(3);
			$thn_ang = $this->session->userdata('pcThang');
			$kd_skpd  = $this->session->userdata('kdskpd');
			$nm_skpd =$this->session->userdata('nm_skpd');
            $bulan= $_REQUEST['tgl1'];
            $lcperiode = $this->tukd_model->getBulan($bulan);
			$tgl_ttd= $_REQUEST['tgl_ttd'];
			$spasi= $_REQUEST['spasi'];
			$ttd1 = str_replace('123456789',' ',$_REQUEST['ttd1']);
			$ttd2 = str_replace('123456789',' ',$_REQUEST['ttd2']);
			$csql="SELECT a.nama, a.nip, jabatan, pangkat FROM ms_ttd_blud a WHERE kode = 'BK' AND a.kd_skpd = '$kd_skpd' and nip='$ttd1'";
			$hasil = $this->db->query($csql);
			$trh2 = $hasil->row();          
			$lcNmBP = $trh2->nama;
			$lcNipBP = $trh2->nip;
			$lcJabBP = $trh2->jabatan;
			$lcPangkatBP = $trh2->pangkat;
			$csql="SELECT a.nama, a.nip, jabatan, pangkat FROM ms_ttd_blud a WHERE kode = 'PA' AND a.kd_skpd = '$kd_skpd' and nip='$ttd2'";
			$hasil = $this->db->query($csql);
			$trh2 = $hasil->row();          
			$lcNmPA = $trh2->nama;
			$lcNipPA = $trh2->nip; 			
			$lcJabPA = $trh2->jabatan; 			
			$lcPangkatPA = $trh2->pangkat; 			
	
			$hasil = $this->db->query("SELECT * from ms_skpd_blud where kd_skpd = '$kd_skpd'");
			$trsk = $hasil->row();          
			$nm_skpd = $trsk->nm_skpd;
			
			$prv = $this->db->query("SELECT * from sclient_blud WHERE kd_skpd='$kd_skpd'");
			$prvn = $prv->row();          
			$prov = $prvn->provinsi;
			$daerah = $prvn->daerah;
			

			$asql="SELECT terima-keluar as sisa FROM(select
			SUM(case when jns=1 then jumlah else 0 end) AS terima,
			SUM(case when jns=2 then jumlah else 0 end) AS keluar
			from (
			select tgl_kas tgl,no_kas bku,'Terima SP2D '+no_sp2d ket,total jumlah,'1' jns,kd_skpd kode from trhsp2d_blud where no_kas<>'' and jns_spp in ('1','2','3')  union
			SELECT b.tgl_kas AS tgl,b.no_kas AS bku,b.keterangan_sp2d AS ket,b.total - isnull(pot, 0) AS jumlah,'1' AS jns,b.kd_skpd AS kode FROM trhsp2d_blud b LEFT JOIN (SELECT no_spm,SUM (nilai) pot FROM trspmpot_blud GROUP BY no_spm) c ON b.no_spm = c.no_spm where no_kas<>'' and b.jns_spp not in('1','2','3') union
			
			SELECT tgl_kas AS tgl,no_kas AS bku,keterangan as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud union
			SELECT tgl_bukti AS tgl,no_bukti AS bku,ket as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='BANK' union
			SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,a.total-isnull(pot,0) AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhtransout_blud a join trhsp2d_blud b on a.no_sp2d=b.no_sp2d and a.kd_skpd=b.kd_skpd left join (select no_spm, sum(nilai)pot from trspmpot_blud group by no_spm) c on b.no_spm=c.no_spm WHERE pay='BANK' UNION
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'2' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where a.jenis<>'3' and a.jns_spp in ('1','2','3')  and a.pay='BANK' union 
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'1' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where  a.jenis='3' and a.jns_spp in ('1','2','3')  and a.pay='BANK' union 
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'1' AS jns,a.kd_skpd AS kode FROM trhtrmpot_blud a inner join trdtrmpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union 
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhstrpot_blud a inner join trdstrpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union
			
			select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
					from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
					where jns_trans NOT IN ('4','2')   and a.pay='Bank'
					GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd union
			SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud) a
			where month(tgl)<'$bulan' and kode='$kd_skpd') a ";
	
		$hasil=$this->db->query($asql);
		$bank=$hasil->row();
		$sisa=$bank->sisa;
		$saldobank=$sisa;
			            
         $cRet = '';
         $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
            <tr>
                <td align=\"center\" colspan=\"6\" style=\"font-size:14px;border: solid 1px white;\"><b>$prov<br>BUKU PEMBANTU SIMPANAN BANK<br>BENDAHARA PENGELUARAN</b></td>
            </tr>
              <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
              <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
            
            <tr>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;border: solid 1px white;\">SKPD</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\">: $kd_skpd - $nm_skpd</td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"0\" style=\"font-size:12px;border: solid 1px white;\">PERIODE</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\">: $lcperiode</td>
            </tr>
            
           
            <tr>
                <td align=\"left\" colspan=\"2\" style=\"font-size:12px;border: solid 1px white;border-bottom:solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;border-bottom:solid 1px white;\">&nbsp;</td>
            </tr>
			</table>";
			
           $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"$spasi\">
		<thead>		   
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\" >Tanggal.</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">No. BKU</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"35%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">Uraian</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">Penerimaan</td> 
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">Pengeluaran</td>  
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">Saldo</td>            
            </tr> 
		</thead>
            <tr>
                <td align=\"center\" width=\"10%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\" ></td>
                <td align=\"center\" width=\"10%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\"></td>
                <td align=\"right\" width=\"35%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">Saldo Lalu</td>
                <td align=\"center\" width=\"15%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\"></td> 
                <td align=\"center\" width=\"15%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\"></td>  
                <td align=\"right\" width=\"15%\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black;\">".number_format($saldobank,"2",",",".")."</td>            
            </tr>";
            
            
             $sql = "SELECT * FROM (
			select tgl_kas tgl,no_kas bku,'Terima SP2D '+no_sp2d ket,total jumlah,'1' jns,kd_skpd kode from trhsp2d_blud where no_kas<>'' and jns_spp in ('1','2','3')  union
			SELECT b.tgl_kas AS tgl,b.no_kas AS bku,b.keterangan_sp2d AS ket,b.total - isnull(pot, 0) AS jumlah,'1' AS jns,b.kd_skpd AS kode FROM trhsp2d_blud b LEFT JOIN (SELECT no_spm,SUM (nilai) pot FROM trspmpot_blud GROUP BY no_spm) c ON b.no_spm = c.no_spm where no_kas<>'' and b.jns_spp not in('1','2','3') union
			
			SELECT tgl_kas AS tgl,no_kas AS bku,keterangan as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM tr_setorsimpanan_blud union
			SELECT tgl_bukti AS tgl,no_bukti AS bku,ket as ket,nilai AS jumlah,'1' AS jns,kd_skpd AS kode FROM trhINlain_blud WHERE pay='BANK' union
			SELECT tgl_bukti AS tgl,no_bukti AS bku,ket AS ket,a.total-isnull(pot,0) AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhtransout_blud a join trhsp2d_blud b on a.no_sp2d=b.no_sp2d and a.kd_skpd=b.kd_skpd left join (select no_spm, sum(nilai)pot from trspmpot_blud group by no_spm) c on b.no_spm=c.no_spm WHERE pay='BANK' UNION
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'2' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where a.jenis<>'3' and a.jns_spp in ('1','2','3') and a.pay='BANK' union 
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.total AS jumlah,'1' AS jns,a.kd_skpd AS kode  FROM trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti where  a.jenis='3' and a.jns_spp in ('1','2','3') and a.pay='BANK' union 
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'1' AS jns,a.kd_skpd AS kode FROM trhtrmpot_blud a inner join trdtrmpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union 
			SELECT tgl_bukti AS tgl,a.no_bukti AS bku,ket AS ket,a.nilai AS jumlah,'2' AS jns,a.kd_skpd AS kode FROM trhstrpot_blud a inner join trdstrpot_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti union
			
			select a.tgl_sts as tgl,a.no_sts as bku, a.keterangan as ket, SUM(b.rupiah) as jumlah, '2' as jns, a.kd_skpd as kode 
					from trhkasin_blud a INNER JOIN trdkasin_blud b ON a.no_sts=b.no_sts AND a.kd_skpd=b.kd_skpd 
					where jns_trans NOT IN ('4','2')   and a.pay='Bank'
					GROUP BY a.tgl_sts,a.no_sts, a.keterangan,a.kd_skpd union
			SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud) a
             where month(a.tgl)='$bulan' and kode='$kd_skpd' ORDER BY a.tgl,Cast(bku  as int), jns";
                                                                
                    $hasil = $this->db->query($sql);       
                    $saldo=$saldobank;
					$total_terima=0;
					$total_keluar=0;
                    foreach ($hasil->result() as $row)
                    {
                       $bku   =$row->bku ;
                       $tgl     =$row->tgl;
                       $uraian  =$row->ket; 
                       $nilai   =$row->jumlah;
                       $jns     =$row->jns; 
                                         
                       if ($jns==1){ 
                       $saldo=$saldo+$nilai;
					   $total_terima=$total_terima+$nilai;
                        $cRet .="<tr>
                                  <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">$tgl</td>
                                  <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">$bku</td>
                                  <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">$uraian</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($nilai,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\"></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($saldo,"2",",",".")."</td>
                                  </tr>";                     
                                                        
                       }else{
                            $saldo=$saldo-$nilai;
							$total_keluar=$total_keluar+$nilai;
                            $cRet .="<tr>
                                  <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">$tgl</td>
                                  <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">$bku</td>
                                  <td valign=\"top\" align=\"left\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">$uraian</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\"></td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($nilai,"2",",",".")."</td>
                                  <td valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($saldo,"2",",",".")."</td>
                                  </tr>"; 
                                   
                       }           
                    }
          $cRet .="<tr>
                                  <td bgcolor=\"#CCCCCC\" colspan=\"3\" valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">JUMLAH</td>
                                  <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($total_terima,"2",",",".")."</td>
                                  <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($total_keluar,"2",",",".")."</td>
                                  <td bgcolor=\"#CCCCCC\" valign=\"top\" align=\"right\" style=\"font-size:12px;border-bottom:solid 1px black;border-top:solid 1px black\">".number_format($total_terima-$total_keluar+$saldobank,"2",",",".")."</td>
                                  </tr>"; 
         $cRet .="<tr>
                    <td align=\"left\" colspan=\"6\" style=\"font-size:12px;border:solid 1px white\">&nbsp;</td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>                
                    <td align=\"center\" colspan=\"3\" style=\"font-size:13px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:13px;border: solid 1px white;\">&nbsp;</td>                    
                </tr>				
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:13px;border: solid 1px white;\">Mengetahui:</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:13px;border: solid 1px white;\">$daerah, ".$this->tanggal_format_indonesia($tgl_ttd)."</td>                                                                                                                                                                                
                </tr>
               <tr>                
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$lcJabPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">$lcJabBP</td>                    
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                    <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"></td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmPA</u></b><br>$lcPangkatPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"><b><u>$lcNmBP</u></b><br>$lcPangkatBP</td>
                </tr>
                <tr>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\"> NIP. $lcNipPA</td>
                    <td align=\"center\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">NIP. $lcNipBP</td>
      
                </tr>";        
        $cRet .='</table>';
        $data['prev']= $cRet;    
        if($print==0){
			 $data['prev']= $cRet;    
			 echo ("<title>Simpanan Bank </title>");
			 echo $cRet;
			 }
		 else{
			$this->_mpdf('',$cRet,10,10,10,'0',0,'');
			}	
    }
    
	//akhir bk bank
	
	//mulai pajak
	function pajak(){
        $data['page_title']= 'PAJAK';
		$data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set('title', 'PAJAK');   
        $this->template->load('template','tukd/transaksi/pajak',$data) ; 
		//$this->tukd_model->set_log_activity(); 
    }
	
	function load_pasal_pajak(){
        $kd_skpd = $this->session->userdata('kdskpd'); 
		$sql = "SELECT a.kd_rek5, b.nm_rek5 FROM trdtrmpot_blud a 
				INNER JOIN ms_pot_blud b ON a.kd_rek5=b.kd_rek5
				GROUP BY a.kd_rek5,b.nm_rek5";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;        
        foreach($mas->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5']
                        );
                        $ii++;
        }           
           
        echo json_encode($result);
        $mas->free_result();
    	   
	}
	
	function cetak_pajak($lcskpd='',$nbulan='',$ctk='',$ttd1='',$tgl_ctk='',$ttd2='', $jns=''){
		$spasi = $this->uri->segment(10);
        $ttd1 = str_replace('123456789',' ',$ttd1);
		$ttd2 = str_replace('123456789',' ',$ttd2);
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab,pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		$querypaj="SELECT 
					sum(case when jns=1 then terima else 0 end) as debet,
					sum(case when jns=2 then keluar else 0 end ) as kredit
					FROM(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+no_sp2d) AS ket,SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+no_terima) AS ket,'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_terima, a.kd_skpd) a WHERE MONTH(tgl)<'$nbulan' AND kd_skpd='$lcskpd'";
				$querypjk=$this->db->query($querypaj);
				foreach ($querypjk->result() as $rowpjk)
				{
					$debet=$rowpjk->debet;
					$kredit=$rowpjk->kredit;
					$saldopjk=$debet-$kredit;
				}
			$cRet ='<TABLE width="100%" style="font-size:16px">
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>BUKU PAJAK </TD>
					</TR>
					</TABLE><br/>';

			$cRet .='<TABLE width="100%" style="font-size:14px">
					 <TR>
						<TD align="left" width="20%" >B L U D</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kepala B L U D</TD>
						<TD align="left">: '.$nama.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bendahara </TD>
						<TD align="left">: '.$nama1.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bulan </TD>
						<TD align="left">: '.$this->tukd_model->getBulan($nbulan).'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse;font-size:14px" border="1" cellspacing="0" cellpadding="'.$spasi.'" width="100%" >
					 <THEAD>
					 <TR>
						<TD width="80" align="center" >NO</TD>
                        <TD width="90" align="center" >Tanggal</TD>
						<TD width="400" align="center" >Uraian</TD>						
						<TD width="150" align="center" >Pemotongan (Rp)</TD>
						<TD width="150" align="center" >Penyetoran (Rp)</TD>
						<TD width="150" align="center" >Saldo</TD>
					 </TR>
					 </THEAD>
					 <TR>
						<TD width="80" align="center" ></TD>
                        <TD width="90" align="center" ></TD>
						<TD width="350" align="left" >Saldo Lalu</TD>						
						<TD width="100" align="center" ></TD>
						<TD width="100" align="center" ></TD>
						<TD width="120" align="right" >'.number_format($saldopjk).'</TD>
					 </TR>';
			

			
				$query = $this->db->query("SELECT * FROM(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+no_sp2d) AS ket,SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+no_terima) AS ket,'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_terima, a.kd_skpd ) a 
				    WHERE MONTH(tgl)='$nbulan' AND kd_skpd='$lcskpd' ORDER BY tgl,Cast(bku as decimal) ");  
				
				$saldo=$saldopjk;
				$jumlahin=0;
				$jumlahout=0;
				foreach ($query->result() as $row) {
                     $bukti = $row->bku; 
                    $tanggal = $row->tgl;                   
                    $ket = $row->ket;
                    $in =$row->terima;
                    $out=$row->keluar;                    
					if ($row->jns=='1'){					
						$saldo=$saldo+$row->terima;
                        $sal = empty($saldo) || $saldo == 0 ? '' :number_format($saldo,"2",",",".");
					}else{
						$saldo=$saldo-$row->keluar;
                        $sal = empty($saldo) || $saldo == 0 ? '' :number_format($saldo,"2",",",".");
					}
					$jumlahin=$jumlahin+$in;
					$jumlahout=$jumlahout+$out;
					$cRet .='<TR>
								<TD width="80" align="left" >'.$bukti.'</TD>
                                <TD width="90" align="left" >'.$this->tanggal_indonesia($tanggal).'</TD>
								<TD width="400" align="left" >'.$ket.'</TD>								
								<TD width="150" align="right" >'.number_format($in,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($out,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($saldo,"2",",",".").'</TD>
							 </TR>';					
			
				}
				
				$cRet .='<TR>
								<TD colspan ="3" width="80" align="center" >JUMLAH</TD>
								<TD width="150" align="right" >'.number_format($jumlahin,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($jumlahout,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($jumlahin-$jumlahout+$saldopjk,"2",",",".").'</TD>
							 </TR>';
									

			$cRet .='</TABLE>';
			
			$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
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
						<TD align="center" ><u>'.$nama.' </u> <br> '.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama1.'</u> <br> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'BUKU PAJAK PPN/PPh';
	switch ($ctk)
        {
            case 0;
			 echo ("<title> BP Pajak</title>");
				echo $cRet;
				break;
            case 1;
			$this->_mpdf('',$cRet,10,10,10,'0',1,'');
               break;
		}
	}
	
	function cetak_pajak2($lcskpd='',$nbulan='',$ctk='',$ttd1='',$tgl_ctk='',$ttd2='', $jns='', $rinci=''){
		$spasi = $this->uri->segment(11);
        $ttd1 = str_replace('123456789',' ',$ttd1);
		$ttd2 = str_replace('123456789',' ',$ttd2);
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
			if($jns=='1'){
			$cRet ='<TABLE width="100%">
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>BUKU PAJAK PPN/PPh (SPJ UP/GU/TU)</TD>
					</TR>
					</TABLE><br/>';
			} else{
			$cRet ='<TABLE width="100%">
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>BUKU PAJAK PPN/PPh (SP2D LS)</TD>
					</TR>
					</TABLE><br/>';	
			}
			$cRet .='<TABLE width="100%">
					 <TR>
						<TD align="left" width="20%" >SKPD</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kepala SKPD</TD>
						<TD align="left">: '.$nama.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bendahara </TD>
						<TD align="left">: '.$nama1.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bulan </TD>
						<TD align="left">: '.$this->tukd_model->getBulan($nbulan).'</TD>
					 </TR>
					 </TABLE>';

			if(($jns=='1') and ($rinci=='0')){
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					 <THEAD>
					 <TR>
						<TD rowspan="2" width="5" align="center" >NO</TD>
                        <TD rowspan="2" width="10" align="center" >Tanggal</TD>
						<TD rowspan="2" width="20" align="center" >Uraian</TD>						
						<TD colspan="5" width="20" align="center" >Potongan Belanja Barang dan Modal</TD>
						<TD rowspan="2" width="15" align="center" >Pemotongan (Rp)</TD>
						<TD rowspan="2" width="15" align="center" >Penyetoran (Rp)</TD>
						<TD rowspan="2" width="15" align="center" >Saldo</TD>
					 </TR>
					 <TR>
						<TD width="15" align="center" >PPh Pasal 21</TD>
                        <TD width="15" align="center" >PPh Pasal 22</TD>
						<TD width="15" align="center" >PPh Pasal 23</TD>						
						<TD width="15" align="center" >PPn</TD>
						<TD width="15" align="center" >Lain-Lain</TD>
					 </TR>
					 </THEAD>
					 <TR>
						<TD align="center" >1</TD>
                        <TD align="center" >2</TD>
						<TD align="center" >3</TD>						
						<TD align="center" >4</TD>
						<TD align="center" >5</TD>
						<TD align="center" >6</TD>
						<TD align="center" >7</TD>
						<TD align="center" >8</TD>
						<TD align="center" >9=(4+5+6+7+8)</TD>
						<TD align="center" >10</TD>
						<TD align="center" >11=(9-10)</TD>
					 </TR>';
			

			
				$query = $this->db->query("
								SELECT a.bulan, ISNULL(SUM(pph21),0) as pph21, ISNULL(SUM(pph22),0) as pph22, ISNULL(SUM(pph23),0) as pph23,
								ISNULL(SUM(pphn),0) as pphn, ISNULL(SUM(lain),0) as lain, ISNULL(SUM(pot),0) as pot, ISNULL(SUM(setor),0) as setor,
								ISNULL(SUM(pot)-SUM(setor),0) as saldo
								FROM
								(SELECT 1 as bulan UNION ALL
								SELECT 2 as bulan UNION ALL
								SELECT 3 as bulan UNION ALL
								SELECT 4 as bulan UNION ALL
								SELECT 5 as bulan UNION ALL
								SELECT 6 as bulan UNION ALL
								SELECT 7 as bulan UNION ALL
								SELECT 8 as bulan UNION ALL
								SELECT 9 as bulan UNION ALL
								SELECT 10 as bulan UNION ALL
								SELECT 11 as bulan UNION ALL
								SELECT 12 as bulan)a
								LEFT JOIN 
								(SELECT MONTH(tgl_bukti) as bulan, 
								SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai ELSE 0 END) AS pph21,
								SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai ELSE 0 END) AS pph22,
								SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai ELSE 0 END) AS pph23,
								SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai ELSE 0 END) AS pphn,
								SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301') THEN a.nilai ELSE 0 END) AS lain,
								SUM(a.nilai) as pot,
								0 as setor
								FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('1','2','3')  AND a.kd_skpd='$lcskpd'
								GROUP BY month(tgl_bukti)
								UNION ALL
								SELECT MONTH(tgl_bukti) as bulan, 
								0 AS pph21,
								0 AS pph22,
								0 AS pph23,
								0 AS pphn,
								0 AS lain,
								0 as pot,
								SUM(a.nilai) as setor
								FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('1','2','3') AND a.kd_skpd='$lcskpd'
								GROUP BY month(tgl_bukti)
								) b
								ON a.bulan=b.bulan
								WHERE a.bulan<='$nbulan'
								GROUP BY a.bulan
								ORDER BY a.bulan");  
				
				$jum_pph21=0;
				$jum_pph22=0;
				$jum_pph23=0;
				$jum_pphn=0;
				$jum_lain=0;
				$jum_pot=0;
				$jum_setor=0;
				$jum_saldo=0;
				$ii=0;
				foreach ($query->result() as $row) {
                    $bulan = $row->bulan; 
                    $pph21 = $row->pph21;                   
                    $pph22 = $row->pph22;
                    $pph23 =$row->pph23;
                    $pphn=$row->pphn;                    
                    $lain=$row->lain;                    
                    $pot=$row->pot;                    
                    $setor=$row->setor;                    
                    $saldo=$row->saldo; 
					$ii=$ii+1;
                    $pph21_1 = empty($pph21) || $pph21 == 0 ? number_format(0,"2",",",".") :number_format($pph21,"2",",",".");
                    $pph22_1 = empty($pph22) || $pph22 == 0 ? number_format(0,"2",",",".") :number_format($pph22,"2",",",".");
                    $pph23_1 = empty($pph23) || $pph23 == 0 ? number_format(0,"2",",",".") :number_format($pph23,"2",",",".");
                    $pphn_1 = empty($pphn) || $pphn == 0 ? number_format(0,"2",",",".") :number_format($pphn,"2",",",".");
                    $lain_1 = empty($lain) || $lain == 0 ? number_format(0,"2",",",".") :number_format($lain,"2",",",".");
                    $pot_1 = empty($pot) || $pot == 0 ? number_format(0,"2",",",".") :number_format($pot,"2",",",".");
                    $setor_1 = empty($setor) || $setor == 0 ? number_format(0,"2",",",".") :number_format($setor,"2",",",".");
                    $saldo_1 = empty($saldo) || $saldo == 0 ? number_format(0,"2",",",".") :number_format($saldo,"2",",",".");
					$jum_pph21=$jum_pph21+$pph21;
					$jum_pph22=$jum_pph22+$pph22;
					$jum_pph23=$jum_pph23+$pph23;
					$jum_pphn=$jum_pphn+$pphn;
					$jum_lain=$jum_lain+$lain;
					$jum_pot=$jum_pot+$pot;
					$jum_setor=$jum_setor+$setor;
					$jum_saldo=$jum_saldo+$saldo;
					
					$cRet .=' <TR>
							<TD align="center" >'.$ii.'</TD>
							<TD align="center" ></TD>
							<TD align="left" >'.$this->tukd_model->getBulan($bulan).'</TD>						
							<TD align="right" >'.$pph21_1.'</TD>
							<TD align="right" >'.$pph22_1.'</TD>
							<TD align="right" >'.$pph23_1.'</TD>
							<TD align="right" >'.$pphn_1.'</TD>
							<TD align="right" >'.$lain_1.'</TD>
							<TD align="right" >'.$pot_1.'</TD>
							<TD align="right" >'.$setor_1.'</TD>
							<TD align="right" >'.$saldo_1.'</TD>
							 </TR>';					
				}
			$cRet .=' <TR>
			<TD colspan="3" align="center" >JUMLAH</TD>
			<TD align="right" >'.number_format($jum_pph21,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph22,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph23,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pphn,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_lain,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pot,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_setor,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_saldo,"2",",",".").'</TD>
							 </TR>';
						 
			$cRet .='</TABLE>';
			}
			if(($jns=='1') and ($rinci=='1')){
			$querypaj="SELECT  SUM(pph21) as pph21, SUM(pph22) as pph22, SUM(pph23) as pph23,
					SUM(pphn) as pphn, SUM(lain) as lain, SUM(pot) as pot, SUM(setor) as setor,
					SUM(pot)-SUM(setor) as saldo FROM 
					(SELECT a.no_bukti,tgl_bukti, ket,
					SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai ELSE 0 END) AS pph21,
					SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai ELSE 0 END) AS pph22,
					SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai ELSE 0 END) AS pph23,
					SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai ELSE 0 END) AS pphn,
					SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301') THEN a.nilai ELSE 0 END) AS lain,
					SUM(a.nilai) as pot,
					0 as setor,
					1 as urut
					FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b on a.no_bukti=b.no_bukti 
					AND a.kd_skpd=b.kd_skpd
					WHERE jns_spp in('1','2','3')  AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)<'$nbulan'
					GROUP BY a.no_bukti,tgl_bukti,ket
					UNION ALL
					SELECT a.no_bukti, tgl_bukti, ket, 
					SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai*-1 ELSE 0 END) AS pph21,
					SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai*-1 ELSE 0 END) AS pph22,
					SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai*-1 ELSE 0 END) AS pph23,
					SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai*-1 ELSE 0 END) AS pphn,
					SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301') THEN a.nilai*-1 ELSE 0 END) AS lain,
					0 as pot,
					SUM(a.nilai) as setor,
					2 as urut
					FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b on a.no_bukti=b.no_bukti 
					AND a.kd_skpd=b.kd_skpd
					WHERE jns_spp in('1','2','3') AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)<'$nbulan'
					GROUP BY a.no_bukti,tgl_bukti, ket)z";
				$querypjk=$this->db->query($querypaj);
				foreach ($querypjk->result() as $rowpjk)
				{
					$salpph21=$rowpjk->pph21;
					$salpph22=$rowpjk->pph22;
					$salpph23=$rowpjk->pph23;
					$salpphn=$rowpjk->pphn;
					$sallain=$rowpjk->lain;
					$salpot=$rowpjk->pot;
					$salset=$rowpjk->setor;
					$saldopjk=$rowpjk->saldo;
				}	
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					 <THEAD>
					 <TR>
						<TD rowspan="2" width="5" align="center" >NO</TD>
                        <TD rowspan="2" width="10" align="center" >Tanggal</TD>
						<TD rowspan="2" width="20" align="center" >Uraian</TD>						
						<TD colspan="5" width="20" align="center" >Potongan Belanja Barang dan Modal</TD>
						<TD rowspan="2" width="15" align="center" >Pemotongan (Rp)</TD>
						<TD rowspan="2" width="15" align="center" >Penyetoran (Rp)</TD>
						<TD rowspan="2" width="15" align="center" >Saldo</TD>
					 </TR>
					 <TR>
						<TD width="15" align="center" >PPh Pasal 21</TD>
                        <TD width="15" align="center" >PPh Pasal 22</TD>
						<TD width="15" align="center" >PPh Pasal 23</TD>						
						<TD width="15" align="center" >PPn</TD>
						<TD width="15" align="center" >Lain-Lain</TD>
					 </TR>
					 <TR>
						<TD align="center" >1</TD>
                        <TD align="center" >2</TD>
						<TD align="center" >3</TD>						
						<TD align="center" >4</TD>
						<TD align="center" >5</TD>
						<TD align="center" >6</TD>
						<TD align="center" >7</TD>
						<TD align="center" >8</TD>
						<TD align="center" >9=(4+5+6+7+8)</TD>
						<TD align="center" >10</TD>
						<TD align="center" >11=(9-10)</TD>
					 </TR>
					 <TR>
						<TD align="center" >&nbsp;</TD>
                        <TD align="center" ></TD>
						<TD align="center" ></TD>						
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
					 </TR>
					 </THEAD>
					 ';
			
				$cRet .=' <TR>
							<TD align="center" ></TD>
							<TD align="center" ></TD>
							<TD align="center" >Saldo s/d Bulan Lalu</TD>
							<TD align="right" >'.number_format($salpph21,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpph22,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpph23,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpphn,"2",",",".").'</TD>
							<TD align="right" >'.number_format($sallain,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpot,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salset,"2",",",".").'</TD>
							<TD align="right" >'.number_format($saldopjk,"2",",",".").'</TD>
					 </TR>
					  <TR>
						<TD align="center" >&nbsp;</TD>
                        <TD align="center" ></TD>
						<TD align="center" ></TD>						
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
					 </TR>';
			
				$query = $this->db->query("
								SELECT * FROM (SELECT a.no_bukti bku,tgl_bukti, ket,
								SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai ELSE 0 END) AS pph21,
								SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai ELSE 0 END) AS pph22,
								SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai ELSE 0 END) AS pph23,
								SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai ELSE 0 END) AS pphn,
								SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301') THEN a.nilai ELSE 0 END) AS lain,
								SUM(a.nilai) as pot,
								0 as setor,
								1 as urut
								FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('1','2','3')  AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)='$nbulan'
								GROUP BY a.no_bukti,tgl_bukti,ket
								UNION ALL
								SELECT a.no_bukti bku, tgl_bukti, ket, 
								0 AS pph21,
								0 AS pph22,
								0 AS pph23,
								0 AS pphn,
								0 AS lain,
								0 as pot,
								SUM(a.nilai) as setor,
								2 as urut
								FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('1','2','3') AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)='$nbulan'
								GROUP BY a.no_bukti,tgl_bukti, ket)a
								ORDER BY tgl_bukti, Cast(bku as decimal), urut");  
				
				$jum_pph21=0;
				$jum_pph22=0;
				$jum_pph23=0;
				$jum_pphn=0;
				$jum_lain=0;
				$jum_pot=0;
				$jum_setor=0;
				$jum_saldo=0;
				$saldo=$saldopjk;
				foreach ($query->result() as $row) {
                    $no_bukti = $row->bku; 
                    $tgl_bukti = $row->tgl_bukti; 
                    $ket = $row->ket; 
                    $pph21 = $row->pph21;                   
                    $pph22 = $row->pph22;
                    $pph23 =$row->pph23;
                    $pphn=$row->pphn;                    
                    $lain=$row->lain;                    
                    $pot=$row->pot;                    
                    $setor=$row->setor;                    
                    $saldo=$saldo+$pot-$setor; 
                    $pph21_1 = empty($pph21) || $pph21 == 0 ? number_format(0,"2",",",".") :number_format($pph21,"2",",",".");
                    $pph22_1 = empty($pph22) || $pph22 == 0 ? number_format(0,"2",",",".") :number_format($pph22,"2",",",".");
                    $pph23_1 = empty($pph23) || $pph23 == 0 ? number_format(0,"2",",",".") :number_format($pph23,"2",",",".");
                    $pphn_1 = empty($pphn) || $pphn == 0 ? number_format(0,"2",",",".") :number_format($pphn,"2",",",".");
                    $lain_1 = empty($lain) || $lain == 0 ? number_format(0,"2",",",".") :number_format($lain,"2",",",".");
                    $pot_1 = empty($pot) || $pot == 0 ? number_format(0,"2",",",".") :number_format($pot,"2",",",".");
                    $setor_1 = empty($setor) || $setor == 0 ? number_format(0,"2",",",".") :number_format($setor,"2",",",".");
                    $saldo_1 = empty($saldo) || $saldo == 0 ? number_format(0,"2",",",".") :number_format($saldo,"2",",",".");
					$jum_pph21=$jum_pph21+$pph21;
					$jum_pph22=$jum_pph22+$pph22;
					$jum_pph23=$jum_pph23+$pph23;
					$jum_pphn=$jum_pphn+$pphn;
					$jum_lain=$jum_lain+$lain;
					$jum_pot=$jum_pot+$pot;
					$jum_setor=$jum_setor+$setor;
					$jum_saldo=$jum_saldo+$saldo;
					
					$cRet .=' <TR>
							<TD align="center" >'.$no_bukti.'</TD>
							<TD align="center" >'.$this->tanggal_indonesia($tgl_bukti).'</TD>
							<TD align="left" >'.$ket.'</TD>						
							<TD align="right" >'.$pph21_1.'</TD>
							<TD align="right" >'.$pph22_1.'</TD>
							<TD align="right" >'.$pph23_1.'</TD>
							<TD align="right" >'.$pphn_1.'</TD>
							<TD align="right" >'.$lain_1.'</TD>
							<TD align="right" >'.$pot_1.'</TD>
							<TD align="right" >'.$setor_1.'</TD>
							<TD align="right" >'.$saldo_1.'</TD>
							 </TR>';					
				}
			$cRet .=' <TR>
			<TD colspan="3" align="center" >JUMLAH</TD>
			<TD align="right" >'.number_format($jum_pph21,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph22,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph23,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pphn,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_lain,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pot,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_setor,"2",",",".").'</TD>
			<TD align="right" >'.number_format($saldo,"2",",",".").'</TD>
							 </TR>';
						 
			$cRet .='</TABLE>';
			}
			if(($jns=='4') and ($rinci=='0')){
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					 <THEAD>
					 <TR>
						<TD rowspan="2" width="5" align="center" >NO</TD>
                        <TD rowspan="2" width="5" align="center" >Tanggal</TD>
						<TD rowspan="2" width="5" align="center" >Uraian</TD>						
						<TD rowspan="2" width="5" align="center" >PPh Pasal 21</TD>						
						<TD rowspan="2" width="5" align="center" >PPh Pasal 22</TD>						
						<TD rowspan="2" width="5" align="center" >PPh.Pasal.23</TD>						
						<TD rowspan="2" width="5" align="center" >PPN</TD>						
						<TD rowspan="2" width="5" align="center" >Lain-Lain</TD>						
						<TD colspan="3" width="5" align="center" >Potongan Belanja Pegawai</TD>
						<TD rowspan="2" width="5" align="center" >Pemotongan (Rp)</TD>
						<TD rowspan="2" width="5" align="center" >Penyetoran (Rp)</TD>
						<TD rowspan="2" width="5" align="center" >Saldo</TD>
					 </TR>
					 <TR>
						<TD width="5" align="center" >IWP</TD>
                        <TD width="5" align="center" >TAPERUM</TD>
						<TD width="5" align="center" >HKGP</TD>						
					 </TR>
					 <TR>
						<TD align="center" >1</TD>
                        <TD align="center" >2</TD>
						<TD align="center" >3</TD>						
						<TD align="center" >4</TD>
						<TD align="center" >5</TD>
						<TD align="center" >6</TD>
						<TD align="center" >7</TD>
						<TD align="center" >8</TD>
						<TD align="center" >9</TD>
						<TD align="center" >10</TD>
						<TD align="center" >11</TD>
						<TD align="center" >12</TD>
						<TD align="center" >13</TD>
						<TD align="center" >14</TD>
					 </TR>
					 </THEAD>
					 ';
			

			
				$query = $this->db->query("
								SELECT a.bulan, ISNULL(SUM(pph21),0) as pph21, ISNULL(SUM(pph22),0) as pph22, ISNULL(SUM(pph23),0) as pph23,
								ISNULL(SUM(pphn),0) as pphn, ISNULL(SUM(lain),0) as lain, ISNULL(SUM(iwp),0) as iwp, ISNULL(SUM(taperum),0) as taperum, 
								ISNULL(SUM(hkpg),0) as hkpg, ISNULL(SUM(pot),0) as pot, ISNULL(SUM(setor),0) as setor,
								ISNULL(SUM(pot)-SUM(setor),0) as saldo
								FROM
								(SELECT 1 as bulan UNION ALL
								SELECT 2 as bulan UNION ALL
								SELECT 3 as bulan UNION ALL
								SELECT 4 as bulan UNION ALL
								SELECT 5 as bulan UNION ALL
								SELECT 6 as bulan UNION ALL
								SELECT 7 as bulan UNION ALL
								SELECT 8 as bulan UNION ALL
								SELECT 9 as bulan UNION ALL
								SELECT 10 as bulan UNION ALL
								SELECT 11 as bulan UNION ALL
								SELECT 12 as bulan)a
								LEFT JOIN 
								(SELECT MONTH(tgl_bukti) as bulan, 
								SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai ELSE 0 END) AS pph21,
								SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai ELSE 0 END) AS pph22,
								SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai ELSE 0 END) AS pph23,
								SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai ELSE 0 END) AS pphn,
								SUM(CASE WHEN a.kd_rek5 in ('2110701','2110702','2110703') THEN a.nilai ELSE 0 END) AS iwp,
								SUM(CASE WHEN a.kd_rek5='2110501' THEN a.nilai ELSE 0 END) AS taperum,
								SUM(CASE WHEN a.kd_rek5='2110801' THEN a.nilai ELSE 0 END) AS hkpg,
								SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301','2110701','2110702','2110703','2110501','2110801') THEN a.nilai ELSE 0 END) AS lain,
								SUM(a.nilai) as pot,
								0 as setor
								FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('4','5','6')  AND a.kd_skpd='$lcskpd'
								GROUP BY month(tgl_bukti)
								UNION ALL
								SELECT MONTH(tgl_bukti) as bulan, 
								0 AS pph21,
								0 AS pph22,
								0 AS pph23,
								0 AS pphn,
								0 AS iwp,
								0 AS taperum,
								0 AS hkpg,
								0 AS lain,
								0 as pot,
								SUM(a.nilai) as setor
								FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('4','5','6') AND a.kd_skpd='$lcskpd'
								GROUP BY month(tgl_bukti)
								) b
								ON a.bulan=b.bulan
								WHERE a.bulan<='$nbulan'
								GROUP BY a.bulan
								ORDER BY a.bulan");  
				
				$jum_pph21=0;
				$jum_pph22=0;
				$jum_pph23=0;
				$jum_pphn=0;
				$jum_lain=0;
				$jum_pot=0;
				$jum_setor=0;
				$jum_saldo=0;
				$jum_iwp=0;
				$jum_taperum=0;
				$jum_hkpg=0;
				$ii=0;
				foreach ($query->result() as $row) {
                    $bulan = $row->bulan; 
                    $pph21 = $row->pph21;                   
                    $pph22 = $row->pph22;
                    $pph23 =$row->pph23;
                    $pphn=$row->pphn;                    
                    $lain=$row->lain;                    
                    $iwp=$row->iwp;                    
                    $taperum=$row->taperum;                    
                    $hkpg=$row->hkpg;                    
                    $pot=$row->pot;                    
                    $setor=$row->setor;                    
                    $saldo=$row->saldo; 
					$ii=$ii+1;
                    $pph21_1 = empty($pph21) || $pph21 == 0 ? number_format(0,"2",",",".") :number_format($pph21,"2",",",".");
                    $pph22_1 = empty($pph22) || $pph22 == 0 ? number_format(0,"2",",",".") :number_format($pph22,"2",",",".");
                    $pph23_1 = empty($pph23) || $pph23 == 0 ? number_format(0,"2",",",".") :number_format($pph23,"2",",",".");
                    $pphn_1 = empty($pphn) || $pphn == 0 ? number_format(0,"2",",",".") :number_format($pphn,"2",",",".");
                    $lain_1 = empty($lain) || $lain == 0 ? number_format(0,"2",",",".") :number_format($lain,"2",",",".");
                    $iwp_1 = empty($iwp) || $iwp == 0 ? number_format(0,"2",",",".") :number_format($iwp,"2",",",".");
                    $taperum_1 = empty($taperum) || $taperum == 0 ? number_format(0,"2",",",".") :number_format($taperum,"2",",",".");
                    $hkpg_1 = empty($hkpg) || $hkpg == 0 ? number_format(0,"2",",",".") :number_format($hkpg,"2",",",".");
                    $pot_1 = empty($pot) || $pot == 0 ? number_format(0,"2",",",".") :number_format($pot,"2",",",".");
                    $setor_1 = empty($setor) || $setor == 0 ? number_format(0,"2",",",".") :number_format($setor,"2",",",".");
                    $saldo_1 = empty($saldo) || $saldo == 0 ? number_format(0,"2",",",".") :number_format($saldo,"2",",",".");
					$jum_pph21=$jum_pph21+$pph21;
					$jum_pph22=$jum_pph22+$pph22;
					$jum_pph23=$jum_pph23+$pph23;
					$jum_pphn=$jum_pphn+$pphn;
					$jum_lain=$jum_lain+$lain;
					$jum_iwp=$jum_iwp+$iwp;
					$jum_taperum=$jum_taperum+$taperum;
					$jum_hkpg=$jum_hkpg+$hkpg;
					$jum_pot=$jum_pot+$pot;
					$jum_setor=$jum_setor+$setor;
					$jum_saldo=$jum_saldo+$saldo;
					
					$cRet .=' <TR>
							<TD align="center" >'.$ii.'</TD>
							<TD align="center" ></TD>
							<TD align="left" >'.$this->tukd_model->getBulan($bulan).'</TD>						
							<TD align="right" >'.$pph21_1.'</TD>
							<TD align="right" >'.$pph22_1.'</TD>
							<TD align="right" >'.$pph23_1.'</TD>
							<TD align="right" >'.$pphn_1.'</TD>
							<TD align="right" >'.$lain_1.'</TD>
							<TD align="right" >'.$iwp_1.'</TD>
							<TD align="right" >'.$taperum_1.'</TD>
							<TD align="right" >'.$hkpg_1.'</TD>
							<TD align="right" >'.$pot_1.'</TD>
							<TD align="right" >'.$setor_1.'</TD>
							<TD align="right" >'.$saldo_1.'</TD>
							 </TR>';					
				}
			$cRet .=' <TR>
			<TD colspan="3" align="center" >JUMLAH</TD>
			<TD align="right" >'.number_format($jum_pph21,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph22,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph23,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pphn,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_lain,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_iwp,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_taperum,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_hkpg,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pot,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_setor,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_saldo,"2",",",".").'</TD>
							 </TR>';
			$cRet .='</TABLE>';
			}
			if(($jns=='4') and ($rinci=='1')){
			$querypaj="SELECT  SUM(pph21) as pph21, SUM(pph22) as pph22, SUM(pph23) as pph23,
					SUM(pphn) as pphn, SUM(ppnpn) as ppnpn, SUM(lain) as lain, ISNULL(SUM(iwp),0) as iwp, ISNULL(SUM(taperum),0) as taperum, 
					ISNULL(SUM(hkpg),0) as hkpg, ISNULL(SUM(pot),0) as pot, ISNULL(SUM(setor),0) as setor,
					ISNULL(SUM(pot)-SUM(setor),0) as saldo FROM 
					(SELECT a.no_bukti,tgl_bukti, ket,
					SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai ELSE 0 END) AS pph21,
					SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai ELSE 0 END) AS pph22,
					SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai ELSE 0 END) AS pph23,
					SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai ELSE 0 END) AS pphn,
					SUM(CASE WHEN a.kd_rek5='2110901' THEN a.nilai ELSE 0 END) AS ppnpn,
					SUM(CASE WHEN a.kd_rek5 in ('2110701','2110702','2110703') THEN a.nilai ELSE 0 END) AS iwp,
					SUM(CASE WHEN a.kd_rek5='2110501' THEN a.nilai ELSE 0 END) AS taperum,
					SUM(CASE WHEN a.kd_rek5='2110801' THEN a.nilai ELSE 0 END) AS hkpg,
					SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301','2110701','2110702','2110703','2110501','2110801','2110901') THEN a.nilai ELSE 0 END) AS lain,
					SUM(a.nilai) as pot,
					0 as setor,
					1 as urut
					FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b on a.no_bukti=b.no_bukti 
					AND a.kd_skpd=b.kd_skpd
					WHERE jns_spp in('4','5','6')  AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)<'$nbulan'
					GROUP BY a.no_bukti,tgl_bukti,ket
					UNION ALL
					SELECT a.no_bukti, tgl_bukti, ket, 
					SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai*-1 ELSE 0 END) AS pph21,
					SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai*-1 ELSE 0 END) AS pph22,
					SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai*-1 ELSE 0 END) AS pph23,
					SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai*-1 ELSE 0 END) AS pphn,
					SUM(CASE WHEN a.kd_rek5='2110901' THEN a.nilai*-1 ELSE 0 END) AS ppnpn,
					SUM(CASE WHEN a.kd_rek5 in ('2110701','2110702','2110703') THEN a.nilai*-1 ELSE 0 END) AS iwp,
					SUM(CASE WHEN a.kd_rek5='2110501' THEN a.nilai*-1 ELSE 0 END) AS taperum,
					SUM(CASE WHEN a.kd_rek5='2110801' THEN a.nilai*-1 ELSE 0 END) AS hkpg,
					SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301','2110701','2110702','2110703','2110501','2110801','2110901') THEN a.nilai*-1 ELSE 0 END) AS lain,
					0 as pot,
					SUM(a.nilai) as setor,
					2 as urut
					FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b on a.no_bukti=b.no_bukti 
					AND a.kd_skpd=b.kd_skpd
					WHERE jns_spp in('4','5','6') AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)<'$nbulan'
					GROUP BY a.no_bukti,tgl_bukti, ket)z";
				$querypjk=$this->db->query($querypaj);
				foreach ($querypjk->result() as $rowpjk)
				{
					$salpph21=$rowpjk->pph21;
					$salpph22=$rowpjk->pph22;
					$salpph23=$rowpjk->pph23;
					$salpphn=$rowpjk->pphn;
					$salppnpn=$rowpjk->ppnpn;
					$sallain=$rowpjk->lain;
					$saliwp=$rowpjk->iwp;
					$saltaperum=$rowpjk->taperum;
					$salhkpg=$rowpjk->hkpg;
					$salpot=$rowpjk->pot;
					$salset=$rowpjk->setor;
					$saldopjk=$rowpjk->saldo;
				}	
			$cRet .='<TABLE style="border-collapse:collapse; font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					 <THEAD>
					  <TR>
						<TD rowspan="2" width="5" align="center" >NO</TD>
                        <TD rowspan="2" width="10" align="center" >Tanggal</TD>
						<TD rowspan="2" width="20" align="center" >Uraian</TD>						
						<TD rowspan="2" width="15" align="center" >PPh Pasal 21</TD>						
						<TD rowspan="2" width="15" align="center" >PPh Pasal 22</TD>						
						<TD rowspan="2" width="15" align="center" >PPh Pasal 23</TD>						
						<TD rowspan="2" width="15" align="center" >PPN</TD>						
						<TD rowspan="2" width="15" align="center" >PPNPN</TD>						
						<TD rowspan="2" width="15" align="center" >Lain-Lain</TD>						
						<TD colspan="3" width="20" align="center" >Potongan Belanja Pegawai</TD>
						<TD rowspan="2" width="15" align="center" >Pemotongan (Rp)</TD>
						<TD rowspan="2" width="15" align="center" >Penyetoran (Rp)</TD>
						<TD rowspan="2" width="15" align="center" >Saldo</TD>
					 </TR>
					 <TR>
						<TD width="15" align="center" >IWP</TD>
                        <TD width="15" align="center" >TAPERUM</TD>
						<TD width="15" align="center" >HKGP</TD>						
					 </TR>
					 <TR>
						<TD align="center" >1</TD>
                        <TD align="center" >2</TD>
						<TD align="center" >3</TD>						
						<TD align="center" >4</TD>
						<TD align="center" >5</TD>
						<TD align="center" >6</TD>
						<TD align="center" >7</TD>
						<TD align="center" >8</TD>
						<TD align="center" >9</TD>
						<TD align="center" >10</TD>
						<TD align="center" >11</TD>
						<TD align="center" >12</TD>
						<TD align="center" >13</TD>
						<TD align="center" >14</TD>
						<TD align="center" >15</TD>
					 </TR>
					 <TR>
						<TD align="center" >&nbsp;</TD>
                        <TD align="center" ></TD>
						<TD align="center" ></TD>						
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
					 </TR>
					 </THEAD>
					 ';
			
				$cRet .=' <TR>
							<TD align="center" ></TD>
							<TD align="center" ></TD>
							<TD align="center" >Saldo s/d Bulan Lalu</TD>
							<TD align="right" >'.number_format($salpph21,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpph22,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpph23,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpphn,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salppnpn,"2",",",".").'</TD>
							<TD align="right" >'.number_format($sallain,"2",",",".").'</TD>
							<TD align="right" >'.number_format($saliwp,"2",",",".").'</TD>
							<TD align="right" >'.number_format($saltaperum,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salhkpg,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salpot,"2",",",".").'</TD>
							<TD align="right" >'.number_format($salset,"2",",",".").'</TD>
							<TD align="right" >'.number_format($saldopjk,"2",",",".").'</TD>
					 </TR>
					  <TR>
						<TD align="center" >&nbsp;</TD>
                        <TD align="center" ></TD>
						<TD align="center" ></TD>						
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
						<TD align="center" ></TD>
					 </TR>';
			
				$query = $this->db->query(" SELECT * FROM(
								SELECT a.no_bukti bku,tgl_bukti, ket,
								SUM(CASE WHEN a.kd_rek5='2130101' THEN a.nilai ELSE 0 END) AS pph21,
								SUM(CASE WHEN a.kd_rek5='2130201' THEN a.nilai ELSE 0 END) AS pph22,
								SUM(CASE WHEN a.kd_rek5='2130401' THEN a.nilai ELSE 0 END) AS pph23,
								SUM(CASE WHEN a.kd_rek5='2130301' THEN a.nilai ELSE 0 END) AS pphn,
								SUM(CASE WHEN a.kd_rek5='2110901' THEN a.nilai ELSE 0 END) AS ppnpn,
								SUM(CASE WHEN a.kd_rek5 in ('2110701','2110702','2110703') THEN a.nilai ELSE 0 END) AS iwp,
								SUM(CASE WHEN a.kd_rek5='2110501' THEN a.nilai ELSE 0 END) AS taperum,
								SUM(CASE WHEN a.kd_rek5='2110801' THEN a.nilai ELSE 0 END) AS hkpg,
								SUM(CASE WHEN a.kd_rek5 NOT IN ('2130101','2130201','2130401','2130301','2110701','2110702','2110703','2110501','2110801','2110901') THEN a.nilai ELSE 0 END) AS lain,
								SUM(a.nilai) as pot,
								0 as setor,
								1 as urut
								FROM trdtrmpot_blud a INNER JOIN trhtrmpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('4','5','6')  AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)='$nbulan'
								GROUP BY a.no_bukti,tgl_bukti,ket
								UNION ALL
								SELECT a.no_bukti bku, tgl_bukti, ket, 
								0 AS pph21,
								0 AS pph22,
								0 AS pph23,
								0 AS pphn,
								0 AS ppnpn,
								0 AS iwp,
								0 AS taperum,
								0 AS hkpg,
								0 AS lain,
								0 as pot,
								SUM(a.nilai) as setor,
								2 as urut
								FROM trdstrpot_blud a INNER JOIN trhstrpot_blud b on a.no_bukti=b.no_bukti 
								AND a.kd_skpd=b.kd_skpd
								WHERE jns_spp in('4','5','6') AND a.kd_skpd='$lcskpd' AND MONTH(tgl_bukti)='$nbulan'
								GROUP BY a.no_bukti,tgl_bukti, ket) a
								ORDER BY tgl_bukti,CAST(bku as numeric), urut ");  
				
				$jum_pph21=0;
				$jum_pph22=0;
				$jum_pph23=0;
				$jum_pphn=0;
				$jum_ppnpn=0;
				$jum_lain=0;
				$jum_pot=0;
				$jum_setor=0;
				$jum_saldo=0;
				$jum_iwp=0;
				$jum_taperum=0;
				$jum_hkpg=0;
				$saldo=$saldopjk;
				foreach ($query->result() as $row) {
                    $no_bukti = $row->bku; 
                    $tgl_bukti = $row->tgl_bukti; 
                    $ket = $row->ket; 
                    $pph21 = $row->pph21;                   
                    $pph22 = $row->pph22;
                    $pph23 =$row->pph23;
                    $pphn=$row->pphn;                    
                    $ppnpn=$row->ppnpn;                    
                    $lain=$row->lain;                    
                    $iwp=$row->iwp;                    
                    $taperum=$row->taperum;                    
                    $hkpg=$row->hkpg;                    
                    $pot=$row->pot;                    
                    $setor=$row->setor;                    
                    $saldo=$saldo+$pot-$setor; 
                    $pph21_1 = empty($pph21) || $pph21 == 0 ? number_format(0,"2",",",".") :number_format($pph21,"2",",",".");
                    $pph22_1 = empty($pph22) || $pph22 == 0 ? number_format(0,"2",",",".") :number_format($pph22,"2",",",".");
                    $pph23_1 = empty($pph23) || $pph23 == 0 ? number_format(0,"2",",",".") :number_format($pph23,"2",",",".");
                    $pphn_1 = empty($pphn) || $pphn == 0 ? number_format(0,"2",",",".") :number_format($pphn,"2",",",".");
                    $ppnpn_1 = empty($ppnpn) || $ppnpn == 0 ? number_format(0,"2",",",".") :number_format($ppnpn,"2",",",".");
                    $lain_1 = empty($lain) || $lain == 0 ? number_format(0,"2",",",".") :number_format($lain,"2",",",".");
                    $iwp_1 = empty($iwp) || $iwp == 0 ? number_format(0,"2",",",".") :number_format($iwp,"2",",",".");
                    $taperum_1 = empty($taperum) || $taperum == 0 ? number_format(0,"2",",",".") :number_format($taperum,"2",",",".");
                    $hkpg_1 = empty($hkpg) || $hkpg == 0 ? number_format(0,"2",",",".") :number_format($hkpg,"2",",",".");
                    $pot_1 = empty($pot) || $pot == 0 ? number_format(0,"2",",",".") :number_format($pot,"2",",",".");
                    $setor_1 = empty($setor) || $setor == 0 ? number_format(0,"2",",",".") :number_format($setor,"2",",",".");
                    $saldo_1 = empty($saldo) || $saldo == 0 ? number_format(0,"2",",",".") :number_format($saldo,"2",",",".");
					$jum_pph21=$jum_pph21+$pph21;
					$jum_pph22=$jum_pph22+$pph22;
					$jum_pph23=$jum_pph23+$pph23;
					$jum_pphn=$jum_pphn+$pphn;
					$jum_ppnpn=$jum_ppnpn+$ppnpn;
					$jum_lain=$jum_lain+$lain;
					$jum_iwp=$jum_iwp+$iwp;
					$jum_taperum=$jum_taperum+$taperum;
					$jum_hkpg=$jum_hkpg+$hkpg;
					$jum_pot=$jum_pot+$pot;
					$jum_setor=$jum_setor+$setor;
					$jum_saldo=$jum_saldo+$saldo;
					
					$cRet .=' <TR>
							<TD align="center" >'.$no_bukti.'</TD>
							<TD align="center" >'.$this->tanggal_indonesia($tgl_bukti).'</TD>
							<TD align="left" >'.$ket.'</TD>						
							<TD align="right" >'.$pph21_1.'</TD>
							<TD align="right" >'.$pph22_1.'</TD>
							<TD align="right" >'.$pph23_1.'</TD>
							<TD align="right" >'.$pphn_1.'</TD>
							<TD align="right" >'.$ppnpn_1.'</TD>
							<TD align="right" >'.$lain_1.'</TD>
							<TD align="right" >'.$iwp_1.'</TD>
							<TD align="right" >'.$taperum_1.'</TD>
							<TD align="right" >'.$hkpg_1.'</TD>
							<TD align="right" >'.$pot_1.'</TD>
							<TD align="right" >'.$setor_1.'</TD>
							<TD align="right" >'.$saldo_1.'</TD>
							 </TR>';					
				}
			$cRet .=' <TR>
			<TD colspan="3" align="center" >JUMLAH</TD>
			<TD align="right" >'.number_format($jum_pph21,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph22,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pph23,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pphn,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_ppnpn,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_lain,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_iwp,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_taperum,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_hkpg,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_pot,"2",",",".").'</TD>
			<TD align="right" >'.number_format($jum_setor,"2",",",".").'</TD>
			<TD align="right" >'.number_format($saldo,"2",",",".").'</TD>
							 </TR>';
						 
			$cRet .='</TABLE>';
			}
			$cRet .='<TABLE width="100%" style="border-collapse:collapse; font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
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
						<TD align="center" ><u>'.$nama.' </u><br> '.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama1.' </u><br> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'BUKU PAJAK PPN/PPh';
	switch ($ctk)
        {
            case 0;
			 echo ("<title> BP Pajak</title>");
				echo $cRet;
				break;
            case 1;
			$this->_mpdf('',$cRet,10,10,10,'L',0,'');
               break;
		}
	}
    
	function cetak_pajak3($lcskpd='',$nbulan='',$ctk='',$ttd1='',$tgl_ctk='',$ttd2='', $jns=''){
		$spasi = $this->uri->segment(11);
        $ttd1 = str_replace('123456789',' ',$ttd1);
		$ttd2 = str_replace('123456789',' ',$ttd2);
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		if($jns=='2'){
		$querypaj="SELECT SUM(terima) as terima, SUM(keluar) as keluar  FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'		
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)<'$nbulan'";
		} else {
		$querypaj="SELECT SUM(terima) as terima, SUM(keluar) as keluar  FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'		
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)<'$nbulan'";	
		}
				$querypjk=$this->db->query($querypaj);
				foreach ($querypjk->result() as $rowpjk)
				{
					$terima=$rowpjk->terima;
					$keluar=$rowpjk->keluar;
					$saldopjk=$terima-$keluar;
				}
			$cRet ='<TABLE style="border-collapse:collapse;font-size:12px" width="100%">
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>BUKU PAJAK </TD>
					</TR>
					</TABLE><br/>';

			$cRet .='<TABLE style="border-collapse:collapse;font-size:14px" width="100%">
					 <TR>
						<TD align="left" width="20%" >SKPD</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kepala SKPD</TD>
						<TD align="left">: '.$nama.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bendahara </TD>
						<TD align="left">: '.$nama1.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bulan </TD>
						<TD align="left">: '.$this->tukd_model->getBulan($nbulan).'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse; font-size:14px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					<THEAD>
					<TR>
						<TD width="80" align="center" >NO</TD>
                        <TD width="90" align="center" >Tanggal</TD>
						<TD width="400" align="center" >Uraian</TD>						
						<TD width="150" align="center" >Pemotongan (Rp)</TD>
						<TD width="150" align="center" >Penyetoran (Rp)</TD>
						<TD width="150" align="center" >Saldo</TD>
					 </TR>
					 </THEAD>
					 <TR>
						<TD width="80" align="center" ></TD>
                        <TD width="90" align="center" ></TD>
						<TD width="350" align="left" >Saldo Lalu</TD>						
						<TD width="100" align="center" ></TD>
						<TD width="100" align="center" ></TD>
						<TD width="120" align="right" >'.number_format($saldopjk).'</TD>
					 </TR>';
			

				if ($jns=='2'){
				$query = $this->db->query("SELECT * FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'		
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)='$nbulan' 
					ORDER BY tgl, Cast(bku as decimal)");  
				}else{
				$query = $this->db->query("SELECT * FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'		
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)='$nbulan' 
					ORDER BY tgl, Cast(bku as decimal)"); 	
				}
				$saldo=$saldopjk;
				$jumlahin=0;
				$jumlahout=0;
				foreach ($query->result() as $row) {
                     $bukti = $row->bku; 
                    $tanggal = $row->tgl;                   
                    $ket = $row->ket;
                    $in =$row->terima;
                    $out=$row->keluar;                    
					$saldo=$saldo+$row->terima-$row->keluar;
                    $sal = empty($saldo) || $saldo == 0 ? '' :number_format($saldo,"2",",",".");
					$jumlahin=$jumlahin+$in;
					$jumlahout=$jumlahout+$out;
					$cRet .='<TR>
								<TD width="80" align="left" >'.$bukti.'</TD>
                                <TD width="90" align="left" >'.$this->tanggal_indonesia($tanggal).'</TD>
								<TD width="400" align="left" >'.$ket.'</TD>								
								<TD width="150" align="right" >'.number_format($in,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($out,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($saldo,"2",",",".").'</TD>
							 </TR>';					
			
				}
				
				$cRet .='<TR>
								<TD colspan ="3" width="80" align="center" >JUMLAH</TD>
								<TD width="150" align="right" >'.number_format($jumlahin,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($jumlahout,"2",",",".").'</TD>
								<TD width="150" align="right" >'.number_format($jumlahin-$jumlahout+$saldopjk,"2",",",".").'</TD>
							 </TR>';
									

			$cRet .='</TABLE>';
			
			$cRet .='<TABLE style="border-collapse:collapse;font-size:12px" width="100%">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
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
						<TD align="center" ><u>'.$nama.'</u><br> '.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama1.'</u><br> '.$pangkat1.' </TD>
					</TR>
                    <TR>
						<TD align="center" >'.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'BUKU PAJAK PPN/PPh';
	switch ($ctk)
        {
            case 0;
			 echo ("<title> BP Pajak</title>");
				echo $cRet;
				break;
            case 1;
			$this->_mpdf('',$cRet,10,10,10,'0',1,'');
               break;
		}
	}
	
	function cetak_pajak4($lcskpd='',$nbulan='',$ctk='',$ttd1='',$tgl_ctk='',$ttd2='', $jns=''){
		$spasi = $this->uri->segment(11);
        $ttd1 = str_replace('123456789',' ',$ttd1);
		$ttd2 = str_replace('123456789',' ',$ttd2);
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat  FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		
			$cRet ='<TABLE width="100%">
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>BUKU PAJAK </TD>
					</TR>
					</TABLE><br/>';

			$cRet .='<TABLE width="100%">
					 <TR>
						<TD align="left" width="20%" >SKPD</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kepala SKPD</TD>
						<TD align="left">: '.$nama.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bendahara </TD>
						<TD align="left">: '.$nama1.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bulan </TD>
						<TD align="left">: '.$this->tukd_model->getBulan($nbulan).'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse;font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					<THEAD>
					<TR>
						<TD rowspan="2" align="center" >NO</TD>
						<TD rowspan="2" align="center" >URAIAN</TD>						
						<TD colspan="3" align="center" >PENERIMAAN</TD>
						<TD colspan="3" align="center" >PENYETORAN</TD>
						<TD rowspan="2" align="center" >SISA BELUM DISETOR</TD>
					 </TR>
					 <TR>
						<TD  align="center" >S/D BULAN LALU</TD>
                        <TD  align="center" >BULAN INI</TD>
						<TD  align="center" >S/D BULAN INI</TD>						
						<TD  align="center" >S/D BULAN LALU</TD>
						<TD  align="center" >BULAN INI</TD>
						<TD  align="center" >S/D BULAN INI</TD>
					 </TR>
					  <TR>
						<TD  align="center" >1</TD>
                        <TD  align="center" >2</TD>
						<TD  align="center" >3</TD>						
						<TD  align="center" >4</TD>
						<TD  align="center" >5</TD>
						<TD  align="center" >6</TD>
						<TD  align="center" >7</TD>
						<TD  align="center" >8</TD>
						<TD  align="center" >9</TD>
					 </TR>
					 </THEAD>
					<TR>
						<TD  align="center" >&nbsp;</TD>
                        <TD  align="center" ></TD>
						<TD  align="center" ></TD>						
						<TD  align="center" ></TD>
						<TD  align="center" ></TD>
						<TD  align="center" ></TD>
						<TD  align="center" ></TD>
						<TD  align="center" ></TD>
						<TD  align="center" ></TD>
					 </TR>
					 ';
			

				if ($jns=='2'){
				$query = $this->db->query("	SELECT a.kd_rek5, a.nm_rek5, ISNULL(SUM(terima_lalu),0) as terima_lalu, ISNULL(SUM(terima_ini),0) as terima_ini, ISNULL(SUM(terima),0) as terima,
											ISNULL(SUM(setor_lalu),0) as setor_lalu, ISNULL(SUM(setor_ini),0) as setor_ini, ISNULL(SUM(setor),0) as setor, 
											ISNULL(SUM(terima)-SUM(setor),0) as sisa
											FROM
											(SELECT RTRIM(kd_rek5) as kd_rek5,nm_rek5 FROM ms_pot_blud WHERE kd_rek5 IN ('2110501','2110701','2110702','2110703','2110901','2130101','2130201','2130301','2130401','2130501'))a
											LEFT JOIN 
											(SELECT b.kd_rek5, b.nm_rek5,a.kd_skpd,
											SUM(CASE WHEN MONTH(tgl_bukti)<'$nbulan' THEN b.nilai ELSE 0 END) AS terima_lalu,
											SUM(CASE WHEN MONTH(tgl_bukti)='$nbulan' THEN b.nilai ELSE 0 END) AS terima_ini,
											SUM(CASE WHEN MONTH(tgl_bukti)<='$nbulan' THEN b.nilai ELSE 0 END) AS terima,
											0 as setor_lalu,
											0 as setor_ini,
											0 as setor
											FROM trhtrmpot_blud a
											INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
											LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
											WHERE a.kd_skpd='$lcskpd'									
											GROUP BY  b.kd_rek5, b.nm_rek5, a.kd_skpd 

											UNION ALL

											SELECT b.kd_rek5, b.nm_rek5,a.kd_skpd,
											0 as terima_lalu,
											0 as terima_ini,
											0 as terima,
											SUM(CASE WHEN MONTH(tgl_bukti)<'$nbulan' THEN b.nilai ELSE 0 END) AS setor_lalu,
											SUM(CASE WHEN MONTH(tgl_bukti)='$nbulan' THEN b.nilai ELSE 0 END) AS setor_ini,
											SUM(CASE WHEN MONTH(tgl_bukti)<='$nbulan' THEN b.nilai ELSE 0 END) AS setor
											FROM trhstrpot_blud a
											INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
											LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
											WHERE a.kd_skpd='$lcskpd'					
											GROUP BY  b.kd_rek5, b.nm_rek5, a.kd_skpd)b
											ON a.kd_rek5=b.kd_rek5
											GROUP BY a.kd_rek5, a.nm_rek5
											ORDER BY kd_rek5");  
				}else if ($jns=='3'){
				$query = $this->db->query(" SELECT a.kd_rek5, a.nm_rek5, ISNULL(SUM(terima_lalu),0) as terima_lalu, ISNULL(SUM(terima_ini),0) as terima_ini, ISNULL(SUM(terima),0) as terima,
											ISNULL(SUM(setor_lalu),0) as setor_lalu, ISNULL(SUM(setor_ini),0) as setor_ini, ISNULL(SUM(setor),0) as setor,
											ISNULL(SUM(terima)-SUM(setor),0) as sisa
											FROM
											(SELECT RTRIM(kd_rek5) as kd_rek5,nm_rek5 FROM ms_pot_blud WHERE kd_rek5 IN ('2110501','2110701','2110702','2110703','2110901','2130101','2130201','2130301','2130401','2130501'))a
											LEFT JOIN 
											(SELECT b.kd_rek5, b.nm_rek5,a.kd_skpd,
											SUM(CASE WHEN MONTH(tgl_bukti)<'$nbulan' THEN b.nilai ELSE 0 END) AS terima_lalu,
											SUM(CASE WHEN MONTH(tgl_bukti)='$nbulan' THEN b.nilai ELSE 0 END) AS terima_ini,
											SUM(CASE WHEN MONTH(tgl_bukti)<='$nbulan' THEN b.nilai ELSE 0 END) AS terima,
											0 as setor_lalu,
											0 as setor_ini,
											0 as setor
											FROM trhtrmpot_blud a
											INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
											LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
											WHERE a.kd_skpd='$lcskpd'									
											GROUP BY  b.kd_rek5, b.nm_rek5, a.kd_skpd 

											UNION ALL

											SELECT b.kd_rek5, b.nm_rek5,a.kd_skpd,
											0 as terima_lalu,
											0 as terima_ini,
											0 as terima,
											SUM(CASE WHEN MONTH(tgl_bukti)<'$nbulan' THEN b.nilai ELSE 0 END) AS setor_lalu,
											SUM(CASE WHEN MONTH(tgl_bukti)='$nbulan' THEN b.nilai ELSE 0 END) AS setor_ini,
											SUM(CASE WHEN MONTH(tgl_bukti)<='$nbulan' THEN b.nilai ELSE 0 END) AS setor
											FROM trhstrpot_blud a
											INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
											LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
											WHERE a.kd_skpd='$lcskpd'					
											GROUP BY  b.kd_rek5, b.nm_rek5, a.kd_skpd)b
											ON a.kd_rek5=b.kd_rek5
											GROUP BY a.kd_rek5, a.nm_rek5
											ORDER BY kd_rek5
											"); 	
				} else{
				$query = $this->db->query("	SELECT a.kd_rek5, a.nm_rek5, ISNULL(SUM(terima_lalu),0) as terima_lalu, ISNULL(SUM(terima_ini),0) as terima_ini, ISNULL(SUM(terima),0) as terima,
											ISNULL(SUM(setor_lalu),0) as setor_lalu, ISNULL(SUM(setor_ini),0) as setor_ini, ISNULL(SUM(setor),0) as setor, 
											ISNULL(SUM(terima)-SUM(setor),0) as sisa
											FROM
											(SELECT RTRIM(kd_rek5) as kd_rek5,nm_rek5 FROM ms_pot_blud WHERE kd_rek5 IN ('2110501','2110701','2110702','2110703','2110901','2130101','2130201','2130301','2130401','2130501'))a
											LEFT JOIN 
											(SELECT b.kd_rek5, b.nm_rek5,a.kd_skpd,
											SUM(CASE WHEN MONTH(tgl_bukti)<'$nbulan' THEN b.nilai ELSE 0 END) AS terima_lalu,
											SUM(CASE WHEN MONTH(tgl_bukti)='$nbulan' THEN b.nilai ELSE 0 END) AS terima_ini,
											SUM(CASE WHEN MONTH(tgl_bukti)<='$nbulan' THEN b.nilai ELSE 0 END) AS terima,
											0 as setor_lalu,
											0 as setor_ini,
											0 as setor
											FROM trhtrmpot_blud a
											INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
											LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
											WHERE a.kd_skpd='$lcskpd'									
											GROUP BY  b.kd_rek5, b.nm_rek5, a.kd_skpd 

											UNION ALL

											SELECT b.kd_rek5, b.nm_rek5,a.kd_skpd,
											0 as terima_lalu,
											0 as terima_ini,
											0 as terima,
											SUM(CASE WHEN MONTH(tgl_bukti)<'$nbulan' THEN b.nilai ELSE 0 END) AS setor_lalu,
											SUM(CASE WHEN MONTH(tgl_bukti)='$nbulan' THEN b.nilai ELSE 0 END) AS setor_ini,
											SUM(CASE WHEN MONTH(tgl_bukti)<='$nbulan' THEN b.nilai ELSE 0 END) AS setor
											FROM trhstrpot_blud a
											INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
											LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
											WHERE a.kd_skpd='$lcskpd'					
											GROUP BY  b.kd_rek5, b.nm_rek5, a.kd_skpd)b
											ON a.kd_rek5=b.kd_rek5
											GROUP BY a.kd_rek5, a.nm_rek5
											ORDER BY kd_rek5");  	
				}
				$i=0;
				$jum_terima_lalu=0;
				$jum_terima_ini=0;
				$jum_terima=0;
				$jum_setor_lalu=0;
				$jum_setor_ini=0;
				$jum_setor=0;
				foreach ($query->result() as $row) {
					$i=$i+1;
                    $uraian = $row->nm_rek5; 
                    $terima_lalu = $row->terima_lalu;                   
                    $terima_ini = $row->terima_ini;
                    $terima =$row->terima;
                    $setor_lalu=$row->setor_lalu;                    
                    $setor_ini=$row->setor_ini;                    
                    $setor=$row->setor;                    
                    $sisa=$row->sisa;                    
					$jum_terima_lalu=$jum_terima_lalu+$terima_lalu;
					$jum_terima_ini=$jum_terima_ini+$terima_ini;
					$jum_terima=$jum_terima+$terima;
					$jum_setor_lalu=$jum_setor_lalu+$setor_lalu;
					$jum_setor_ini=$jum_setor_ini+$setor_ini;
					$jum_setor=$jum_setor+$setor;
					$cRet .='<TR>
								<TD  align="left" >'.$i.'</TD>
                                <TD  align="left" >'.$uraian.'</TD>
								<TD  align="right" >'.number_format($terima_lalu,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($terima_ini,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($terima,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($setor_lalu,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($setor_ini,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($setor,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($sisa,"2",",",".").'</TD>
							 </TR>';					
			
				}
				
				$cRet .='<TR>
								<TD colspan ="2"  align="center" >JUMLAH</TD>
								<TD  align="right" >'.number_format($jum_terima_lalu,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($jum_terima_ini,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($jum_terima,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($jum_setor_lalu,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($jum_setor_ini,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($jum_setor,"2",",",".").'</TD>
								<TD  align="right" >'.number_format($jum_terima-$jum_setor,"2",",",".").'</TD>
							 </TR>';
									

			$cRet .='</TABLE>';
			
			$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
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
						<TD align="center" ><u>'.$nama.' <br> '.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama1.' <br> '.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'BUKU PAJAK PPN/PPh';
	switch ($ctk)
        {
            case 0;
			 echo ("<title> BP Pajak</title>");
				echo $cRet;
				break;
            case 1;
				$this->_mpdf('',$cRet,10,10,10,'L',0,'');
               break;
		}
	}
	
	function cetak_pajak5($lcskpd='',$nbulan='',$ctk='',$ttd1='',$tgl_ctk='',$ttd2='', $jns='', $rinci='', $pasal=''){
		$spasi = $this->uri->segment(12);
        $ttd1 = str_replace('123456789',' ',$ttd1);
		$ttd2 = str_replace('123456789',' ',$ttd2);
        $skpd = $this->tukd_model->get_nama($lcskpd,'nm_skpd','ms_skpd_blud','kd_skpd');
        $sqlsc="SELECT tgl_rka,provinsi,kab_kota,daerah,thn_ang FROM sclient_blud WHERE kd_skpd='$lcskpd'";
                 $sqlsclient=$this->db->query($sqlsc);
                 foreach ($sqlsclient->result() as $rowsc)
                 {
                    $kab     = $rowsc->kab_kota;
                    $prov     = $rowsc->provinsi;
                    $daerah  = $rowsc->daerah;
                    $thn     = $rowsc->thn_ang;
                 }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='PA' and nip='$ttd2'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip=$rowttd->nip;                    
                    $nama= $rowttd->nm;
                    $jabatan  = $rowttd->jab;
                    $pangkat  = $rowttd->pangkat;
                }
        $sqlttd1="SELECT nama as nm,nip as nip,jabatan as jab, pangkat FROM ms_ttd_blud where kd_skpd='$lcskpd' and kode='BK' and nip='$ttd1'";
                 $sqlttd=$this->db->query($sqlttd1);
                 foreach ($sqlttd->result() as $rowttd)
                {
                    $nip1=$rowttd->nip;                    
                    $nama1= $rowttd->nm;
                    $jabatan1  = $rowttd->jab;
                    $pangkat1  = $rowttd->pangkat;
                }
		if($jns=='2'){
		$querypaj="SELECT SUM(terima) as terima, SUM(keluar) as keluar  FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					AND b.kd_rek5='$pasal'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'
					AND b.kd_rek5='$pasal'					
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)<'$nbulan'";
		} else if ($jns=='2') {
		$querypaj="SELECT SUM(terima) as terima, SUM(keluar) as keluar  FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)<'$nbulan'";	
		} else{
		$querypaj="SELECT SUM(terima) as terima, SUM(keluar) as keluar  FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE  a.kd_skpd='$lcskpd'
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE  a.kd_skpd='$lcskpd'	
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)<'$nbulan'";	
		}
				$querypjk=$this->db->query($querypaj);
				foreach ($querypjk->result() as $rowpjk)
				{
					$terima=$rowpjk->terima;
					$keluar=$rowpjk->keluar;
					$saldopjk=$terima-$keluar;
				}
			$cRet ='<TABLE width="100%">
					<TR>
						<TD align="center" ><b>'.$prov.' </TD>
					</TR>
					<tr></tr>
                    <TR>
						<TD align="center" ><b>BUKU PAJAK </TD>
					</TR>
					</TABLE><br/>';

			$cRet .='<TABLE width="100%">
					 <TR>
						<TD align="left" width="20%" >SKPD</TD>
						<TD align="left" width="100%" >: '.$lcskpd.' '.$skpd.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kepala SKPD</TD>
						<TD align="left">: '.$nama.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Bendahara </TD>
						<TD align="left">: '.$nama1.'</TD>
					 </TR>
					 <TR>
						<TD align="left">Kode/Nama Rekening </TD>
						<TD align="left">: '.$pasal.' / '.$this->tukd_model->get_nama($pasal,'nm_rek5','ms_pot_blud','kd_rek5').' </TD>
					 </TR>
					 <TR>
						<TD align="left">Bulan </TD>
						<TD align="left">: '.$this->tukd_model->getBulan($nbulan).'</TD>
					 </TR>
					 </TABLE>';

			$cRet .='<TABLE style="border-collapse:collapse;font-size:12px" width="100%" border="1" cellspacing="0" cellpadding="'.$spasi.'" align=center>
					<THEAD>
					<TR>
						<TD width="20" align="center" >No Urut</TD>
                        <TD width="90" align="center" >Tanggal</TD>
						<TD width="50" align="center" >No. Buku Kas</TD>						
						<TD width="400" align="center" >Uraian</TD>						
						<TD width="150" align="center" >Pemotongan (Rp)</TD>
						<TD width="150" align="center" >Penyetoran (Rp)</TD>
					 </TR>
					 <TR>
						<TD align="center" >1</TD>
                        <TD align="center" >2</TD>
                        <TD align="center" >3</TD>
						<TD align="center" >4</TD>						
						<TD align="center" >5</TD>
						<TD align="center" >6</TD>
					 </TR>
					 </THEAD>
					 ';
			

				if ($jns=='2'){
				$query = $this->db->query("SELECT * FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					AND b.kd_rek5='$pasal'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)='$nbulan' 
					ORDER BY tgl, Cast(bku as decimal)");  
				}elseif ($jns=='3'){
				$query = $this->db->query("SELECT * FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'
					AND b.kd_rek5='$pasal'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)='$nbulan' 
					ORDER BY tgl, Cast(bku as decimal)"); 	
				}else{
				$query = $this->db->query("SELECT * FROM
					(
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  no sp2d:'+a.no_sp2d) AS ket,
					SUM(b.nilai) AS terima,'0' AS keluar,'1' as jns,a.kd_skpd, c.no_sp2d
					FROM trhtrmpot_blud a
					INNER JOIN trdtrmpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'
					AND b.kd_rek5='$pasal'	
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, c.no_sp2d
					UNION ALL
					SELECT a.no_bukti AS bku,a.tgl_bukti AS tgl,(ket+'  terima:'+a.no_terima) AS ket,
					'0' AS terima,SUM(b.nilai) AS keluar,'2' as jns,a.kd_skpd, c.no_sp2d
					FROM trhstrpot_blud a
					INNER JOIN trdstrpot_blud b on a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd
					LEFT JOIN trhsp2d_blud c on a.kd_skpd=c.kd_skpd AND a.no_sp2d=c.no_sp2d
					WHERE a.kd_skpd='$lcskpd'	
					AND b.kd_rek5='$pasal'
					GROUP BY a.no_bukti, a.tgl_bukti, a.ket, a.no_sp2d, a.kd_skpd, a.no_terima, c.no_sp2d
					) z WHERE MONTH(tgl)='$nbulan' 
					ORDER BY tgl, Cast(bku as decimal)"); 	
				}
				$saldo=$saldopjk;
				$jumlahin=0;
				$jumlahout=0;
				$i=0;
				foreach ($query->result() as $row) {
					$i=$i+1;
                    $bukti = $row->bku; 
                    $tanggal = $row->tgl;                   
                    $ket = $row->ket;
                    $in =$row->terima;
                    $out=$row->keluar;                    
					$saldo=$saldo+$row->terima-$row->keluar;
                    $sal = empty($saldo) || $saldo == 0 ? '' :number_format($saldo,"2",",",".");
					$jumlahin=$jumlahin+$in;
					$jumlahout=$jumlahout+$out;
					$cRet .='<TR>
								<TD align="left" >'.$i.'</TD>
                                <TD align="left" >'.$this->tanggal_indonesia($tanggal).'</TD>
								<TD align="left" >'.$bukti.'</TD>								
								<TD align="left" >'.$ket.'</TD>								
								<TD align="right" >'.number_format($in,"2",",",".").'</TD>
								<TD align="right" >'.number_format($out,"2",",",".").'</TD>
							 </TR>';					
			
				}
				
				$cRet .='<TR>
							<TD colspan ="4" align="left" >JUMLAH BULAN INI<br> JUMLAH S/D BULAN LALU <br>JUMLAH SELURUHNYA</TD>
							<TD align="right" >'.number_format($jumlahin,"2",",",".").' <br> '.number_format($terima,"2",",",".").' 
							<br> '.number_format($terima+$jumlahin,"2",",",".").'  </TD>
							<TD align="right" >'.number_format($jumlahout,"2",",",".").'<br> '.number_format($keluar,"2",",",".").'
							<br> '.number_format($keluar+$jumlahout,"2",",",".").'  </TD>

						 </TR>
						 <TR>
							<TD colspan ="4" align="left" >SISA YANG BELUM DISETOR</TD>
							<TD colspan ="2" align="right" >'.number_format(($terima+$jumlahin)-($keluar+$jumlahout),"2",",",".").'</TD>
						 </TR>	 ';
									

			$cRet .='</TABLE>';
			
			$cRet .='<TABLE width="100%" style="font-size:12px">
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
					<TR>
						<TD align="center" ><b>&nbsp;</TD>
					</TR>
                    <TR>
						<TD align="center" >Mengetahui,</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$daerah.', '.$this->tanggal_format_indonesia($tgl_ctk).'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$jabatan.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$jabatan1.'</TD>
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
						<TD align="center" ><u>'.$nama.'<br>'.$pangkat.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" ><u>'.$nama1.'<br>'.$pangkat1.'</TD>
					</TR>
                    <TR>
						<TD align="center" >'.$nip.'</TD>
						<TD align="center" ><b>&nbsp;</TD>
						<TD align="center" >'.$nip1.'</TD>
					</TR>
					</TABLE><br/>';

			$data['prev']= 'BUKU PAJAK PPN/PPh';
	switch ($ctk)
        {
            case 0;
			 echo ("<title> BP Pajak</title>");
				echo $cRet;
				break;
            case 1;
			$this->_mpdf('',$cRet,10,10,10,'0',1,'');
            break;
		}
	}
  
	function  tanggal_indonesia($tgl){
        $tanggal  =  substr($tgl,8,2);
        $bulan  = substr($tgl,5,2);
        $tahun  =  substr($tgl,0,4);
        return  $tanggal.'-'.$bulan.'-'.$tahun;

        }
  
	//akhir pajak
	
	
    function load_data_transaksi_jum() {
        $jload = $this->input->post ( 'jload' );
        $beban = $this->input->post ( 'jbeban' );
        
        if ($jload == '1') {
            $kdskpd = $this->session->userdata ( 'kdskpd' );
            $dtgl1 = $this->input->post ( 'tgl1' );
            $dtgl2 = $this->input->post ( 'tgl2' );
        } else {
            $kdskpd = '';
            $dtgl1 = '';
            $dtgl2 = '';
        }
        
        $sql = "SELECT SUM(nilai) AS total FROM (SELECT DISTINCT a.kd_kegiatan,a.nm_kegiatan,a.kd_rek7,a.nm_rek7,a.nilai, a.no_bukti FROM trdtransout_blud a 
INNER JOIN trhtransout_blud b ON a.no_bukti=b.no_bukti WHERE  b.tgl_bukti >= '$dtgl1' AND b.tgl_bukti <= '$dtgl2'  AND b.kd_skpd='$kdskpd' 
AND b.jns_spp='10') a WHERE CONCAT(a.no_bukti,a.kd_kegiatan,a.kd_rek7) NOT IN(SELECT CONCAT(no_bukti,kd_kegiatan,kd_rek7) FROM trlpj_blud 
WHERE SUBSTR(kd_kegiatan,6,10)='$kdskpd')";
        
        $query1 = $this->db->query ( $sql );
        $hasil = $query1->row ();
        $result = array (
                'total' => $hasil->total 
        );
        
        echo json_encode ( $result );
        $query1->free_result ();
    }

    function cek_lpj() {
        $nlpj = $this->input->post ( 'nlpj' );
        
        $sql = "select count(*)as jml from trlpj_blud where no_lpj='$nlpj' ";
        
        $query1 = $this->db->query ( $sql );
        $config = $query1->row ();
        $result = array (
                'jml' => $config->jml 
        );
        
        echo json_encode ( $result );
        $query1->free_result ();
    }

     function update_lpj() {
        $nlpj      = $this->input->post ( 'nlpj' );
        $nbukti    = $this->input->post ( 'no_bukti1' );
        $ntgllpj   = $this->input->post ( 'tgllpj' );
        $ntglawal  = $this->input->post ( 'tglawal' );
        $ntglakhir = $this->input->post ( 'tglakhir' );
        $cket      = $this->input->post ( 'ket' );
        $cnilai    = $this->input->post ( 'nilai1' );
        $xnkdgiat  = $this->input->post ( 'cnkdgiat' );
        $xnkdrek   = $this->input->post ( 'cnkdrek' );
        $cwaktu    = date ( "Y-m-d H:i:s" );
        $user      = $this->session->userdata ( 'pcNama' );

        $kode_rek5        = $this->tukd_model->get_kode($xnkdrek,'kd_rek13','ms_rek7_blud','kd_rek7');
        
        $csql = "delete from trlpj where no_lpj= '$nlpj' and no_bukti= '$nbukti' ";
        $query1 = $this->db->query ( $csql );
         $csql = "delete from trlpj_blud where no_lpj= '$nlpj' and no_bukti= '$nbukti' ";
        $query1 = $this->db->query ( $csql );
        
        $csql = "INSERT INTO trlpj (no_lpj,no_bukti,tgl_lpj,tgl_awal,tgl_akhir,keterangan,kd_kegiatan,kd_rek5,username,tgl_update,nilai) values 
        ('$nlpj','$nbukti','$ntgllpj','$ntglawal','$ntglakhir','$cket','$xnkdgiat','$kode_rek5','$user','$cwaktu','$cnilai')";
        $query1 = $this->db->query ( $csql );


         $csql = "INSERT INTO trlpj_blud (no_lpj,no_bukti,tgl_lpj,tgl_awal,tgl_akhir,keterangan,kd_kegiatan,kd_rek5,username,tgl_update,nilai) values 
        ('$nlpj','$nbukti','$ntgllpj','$ntglawal','$ntglakhir','$cket','$xnkdgiat','$xnkdrek','$user','$cwaktu','$cnilai')";
        $query1 = $this->db->query ( $csql );

        if ($query1 > 0) {
            echo '2';
        } else {
            echo '0';
        }
    }

    function load_terima() {
		$skpd   = $this->session->userdata('kdskpd');
        $result = array();
        $row 	= array();
      	$page 	= isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows 	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where=" AND no_terima LIKE '%$kriteria%' OR tgl_terima LIKE '%$kriteria%' OR keterangan LIKE '%$kriteria%' ";            
        }
        $sql = "SELECT count(*) as total from tr_terima_blud WHERE kd_skpd = '$skpd' $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();
		
		$sql = " SELECT top $rows no_terima,no_tetap,tgl_terima,tgl_tetap,kd_skpd,keterangan as ket,
		nilai, kd_rek5,kd_rek_blud,kd_kegiatan,sts_tetap FROM tr_terima_blud
		WHERE kd_skpd='$skpd' AND (jenis <> '2' or jenis is null)		
		$where AND no_terima NOT IN (SELECT TOP $offset no_terima 
		FROM tr_terima_blud WHERE kd_skpd='$skpd' $where ORDER BY tgl_terima,no_terima) 
		ORDER BY tgl_terima,no_terima ";
		$query1 = $this->db->query($sql); 
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(  
                        'id' => $ii,        
                        'no_terima' => $resulte['no_terima'],
                        'no_tetap' => $resulte['no_tetap'],
                        'tgl_terima' => $resulte['tgl_terima'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['ket'],    
                        'nilai' => number_format($resulte['nilai'], 2, '.', ','),
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
						'kd_kegiatan' => $resulte['kd_kegiatan'],
						'tgl_tetap' => $resulte['tgl_tetap'],
                        'sts_tetap' =>$resulte['sts_tetap']                                                                                            
                        );
                        $ii++;
        }
        $result["rows"] = $row; 
        echo json_encode($result);
        $query1->free_result();	
    }
	
	function load_sts_kas() {
		 $result = array();
        $row = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$kd_skpd = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(a.no_sts) like upper('%$kriteria%') or a.tgl_sts like '%$kriteria%')";            
        }

		$sql = "SELECT count(*) as total from trhkasin_blud a WHERE  kd_skpd = '$kd_skpd' and jns_trans in ('1','5','6') and pay in ('Bank','Tunai')  $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		$result["total"] = $total->total; 
        $query1->free_result();
        
        $sql = "SELECT TOP $rows a.*,b.kd_kegiatan,b.no_sp2d ,(SELECT nm_skpd FROM ms_skpd_blud WHERE kd_skpd = a.kd_skpd) AS nm_skpd from trhkasin_blud a inner join trdkasin_blud b on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts 
				where a.kd_skpd='$kd_skpd' and a.jns_trans in ('1','5','6') and a.pay in ('Bank','Tunai') $where and a.no_sts not in (
				SELECT TOP $offset a.no_sts from trhkasin_blud a WHERE  a.kd_skpd='$kd_skpd' and a.jns_trans in ('1','5','6') and a.pay in ('Bank','Tunai') order by CAST(no_sts as int)) 
				order by CAST(a.no_sts as int)";
        $query1 = $this->db->query($sql);  
        $ii = 0;
       
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'no_sts' => $resulte['no_sts'],
                        'tgl_sts' => $resulte['tgl_sts'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['keterangan'],    
                        'total' =>  number_format($resulte['total'],2,'.',','),
                        'kd_kegiatan' => $resulte['kd_kegiatan'],
                        'jns_trans' => $resulte['jns_trans'],
                        'no_sp2d' => $resulte['no_sp2d'],
                        'jns_cp' => $resulte['jns_spp'],
                        'pay' => $resulte['pay'],
                        'nm_skpd' => $resulte['nm_skpd']                                                                                           
                        );
                        $ii++;
        }
           
       $result["rows"] = $row; 
         echo json_encode($result);
        $query1->free_result();	
    	   
	}
	
	function load_dsts_sisa() {    
        $lcskpd  = $this->session->userdata('kdskpd');
        $kriteria = $this->input->post('no');
        $sql = "SELECT a.* from trdkasin_blud a where a.no_sts = '$kriteria'  AND a.kd_skpd = '$lcskpd' and left(a.kd_rek_blud,1)<>'4' order by a.no_sts";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_sts' => $resulte['no_sts'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'kd_rek5' => $resulte['kd_rek_blud'],
                        'kd_rek_ang' => $resulte['kd_rek5'],
                        'nm_rek' => $resulte['nm_rek_blud'],
                        'rupiah' =>  number_format($resulte['rupiah'],2,'.',',')
						);
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
      
	
    function load_detail_terima(){

        $skpd           = $this->session->userdata('kdskpd');
        $no_terima  = $this->input->post('no_terima');

        $row = array();$result = array();
         $sql = "SELECT 
                a.no_terima, a.`kd_kegiatan`, a.kd_rek7,kd_rek13,a.`kd_sdana`, a.`kd_rek_lo`, a.`nilai`, b.`nm_rek7`
                FROM tr_terima_blud_blud a INNER JOIN ms_rek7_blud b ON a.`kd_rek7` = b.`kd_rek7`
                WHERE a.kd_skpd ='$skpd' AND a.no_terima='$no_terima' ORDER BY a.kd_rek7"; 
     
        $query1 = $this->db->query($sql);  
        $ii = 0;

        $total = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(
                        'id'          => $ii,        
                        'no_terima'   => $resulte['no_terima'],
                        'kd_kegiatan' => $resulte['kd_kegiatan'],
                        'kd_rek5'     => $resulte['kd_rek7'],
                        'kd_rek'      => $resulte['kd_rek13'],
                        'kd_rek_lo'   => $resulte['kd_rek_lo'],
                        'nilai'       => number_format($resulte['nilai'], 2, '.', ','),
                        'sdana'    => $resulte['kd_sdana'],
                        'nm_rek5'     => $resulte['nm_rek7']
                        );
                        $ii++;
            $total += $resulte['nilai'];
        }

        $footer[] = array('nm_rek5' => 'Total : ', 'nilai' => number_format($total,'2','.',','));

        $result["rows"] = $row;  
        $result["footer"] = $footer;

        echo json_encode($result);
    }

    function simpan_terima(){

        $arr_terima       = $this->input->post('arr_terima');
        $arr_terima_murni = $this->input->post('arr_terima_murni');
        $no_hide          = $this->input->post('cno_hide');
        $lcsts            = $this->input->post('lcstatus');
        $total_detail     = $this->input->post('total_detail');
        $no_tetap         = $arr_terima[0]['no_tetap'];
        $kd_skpd          = $arr_terima[0]['kd_skpd'];
        $last_update      = date('Y-m-d H:i:s');
        
        $lcid             = $arr_terima[0]['no_terima'];
        $msg              = array();
        

        
        if($lcsts == "tambah"){
            $cek            = "select no_terima from tr_terima_blud_blud where no_terima = '$lcid'";
            $res            = $this->db->query($cek);
            if ( $res->num_rows() > 0 ) {
                    $msg    = array('pesan'=>'1');
                    echo json_encode($msg);
                    return;
            }else{
            
                    if($no_tetap <> ''){
                        $cektetap=$this->db->query("select ifnull(sum(nilai),0) as nilai from tr_tetap_blud_blud where kd_skpd='$kd_skpd' and no_tetap='$no_tetap'")->row();
                        $tot_tetap=$cektetap->nilai;
                        
                        $cekterima=$this->db->query("select ifnull(sum(nilai),0) as nilai from tr_terima_blud_blud where kd_skpd='$kd_skpd' and no_tetap='$no_tetap'")->row();
                        $tot_terima=$cekterima->nilai;
                        
                        $jum_tot_terima=$total_detail+$tot_terima;
                        
                        if($tot_tetap < $jum_tot_terima){
                            $msg    = array('pesan'=>'2');
                            echo json_encode($msg);
                            return;
                        }
                    }
            
            }
            
        }else{

            if($no_tetap <> ''){
                $cektetap=$this->db->query("select ifnull(sum(nilai),0) as nilai from tr_tetap_blud_blud where kd_skpd='$kd_skpd' and no_tetap='$no_tetap'")->row();
                $tot_tetap=$cektetap->nilai;
                
                $ceknilterima=$this->db->query("select ifnull(sum(nilai),0) as nilai from tr_terima_blud_blud where kd_skpd='$kd_skpd' and no_terima='$lcid'")->row();
                $nil_terima=$ceknilterima->nilai;
                
                $cekterima=$this->db->query("select ifnull(sum(nilai),0) as nilai from tr_terima_blud_blud where kd_skpd='$kd_skpd' and no_tetap='$no_tetap'")->row();
                $tot_terima=$cekterima->nilai;
                
                $tot_terima=$tot_terima-$nil_terima;
                $jum_tot_terima=$tot_terima+$total_detail;
                
                
                if($tot_tetap < $jum_tot_terima){
                    $msg    = array('pesan'=>'2');
                    echo json_encode($msg);
                    return;
                }
            }
                
                
            $this->db->delete('tr_terima_blud_blud', array('no_terima' => $no_hide, 'kd_skpd'=>$kd_skpd)); 
            $this->db->delete('tr_terima_blud', array('no_terima' => $no_hide, 'kd_skpd'=>$kd_skpd)); 

            $header_ju = array('trhju', 'trhju_pkd','trhju_blud');
            $this->db->delete($header_ju, array('no_voucher' => $no_hide, 'kd_skpd'=>$kd_skpd)); 

            $detail_ju = array('trdju', 'trdju_pkd','trdju_blud');
            $this->db->delete($detail_ju, array('no_voucher' => $no_hide));             
        }

        $ins1              = $this->db->insert_batch("tr_terima_blud_blud", $arr_terima);
        if($ins1){


            $sql ="SELECT a.kd_gabungan,a.no_terima,a.tgl_terima,a.kd_skpd,a.kd_kegiatan,a.kd_rek7,b.kd_rek13,a.kd_sdana,a.kd_rek_lo,SUM(a.nilai) as nilai,a.keterangan,a.kd_skpd_str,a.nm_str 
            FROM tr_terima_blud_blud a
            LEFT JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7`
            WHERE no_terima='$lcid' GROUP BY b.kd_rek13";

            $asgsql1=$this->db->query($sql);
            foreach ($asgsql1->result_array() as $row2)
                {
                    $kd_gabungan = $row2['kd_gabungan'];
                    $no_terima   = $row2['no_terima'];
                    $tgl_terima  = $row2['tgl_terima'];
                    $kd_skpd     = $row2['kd_skpd'];
                    $kd_kegiatan = $row2['kd_kegiatan'];
                    $kd_rek5     = $row2['kd_rek13'];
                    $kd_rek_lo   = $row2['kd_rek_lo'];
                    $nilai       = $row2['nilai'];
                    $keterangan  = $row2['keterangan'];
                    $kd_skpd_str = $row2['kd_skpd_str'];
                    $nm_str      = $row2['nm_str'];

                    $insert ="insert into tr_terima_blud 
                    (kd_gabungan,no_terima,tgl_terima,kd_skpd,kd_kegiatan,kd_rek5,kd_rek_lo,nilai,keterangan,kd_skpd_str,nm_str) values 
                    ('$kd_gabungan','$no_terima','$tgl_terima','$kd_skpd','$kd_kegiatan','$kd_rek5','$kd_rek_lo','$nilai','$keterangan','$kd_skpd_str','$nm_str')";

                    $asg=$this->db->query($insert);
                }

                
        }else{
            $msg    = array('pesan'=>'3');
        }

        $arr_header_ju    = array(
        'no_voucher'      => $arr_terima[0]['no_terima'],
        'tgl_voucher'     => $arr_terima[0]['tgl_terima'],
        'kd_skpd'         => $arr_terima[0]['kd_skpd'],
        'nm_skpd'         => $this->tukd_model->get_nama($arr_terima[0]['kd_skpd'],'nm_skpd','ms_skpd_blud','kd_skpd'),
        'ket'             => $arr_terima[0]['keterangan'],
        'tgl_update'      => $last_update,
        'username'        => $this->session->userdata('pcNama'),
        'total_d'         => $total_detail,
        'total_k'         => $total_detail,
        'tabel'           => '4'
        );

        $arr_header_jublud    = array(
        'no_voucher'      => $arr_terima[0]['no_terima'],
        'tgl_voucher'     => $arr_terima[0]['tgl_terima'],
        'kd_skpd'         => $arr_terima[0]['kd_skpd'],
        'kd_unit'         => $arr_terima[0]['kd_unit'],
        'nm_skpd'         => $this->tukd_model->get_nama($arr_terima[0]['kd_skpd'],'nm_skpd','ms_skpd_blud','kd_skpd'),
        'ket'             => $arr_terima[0]['keterangan'],
        'tgl_update'      => $last_update,
        'username'        => $this->session->userdata('pcNama'),
        'total_d'         => $total_detail,
        'total_k'         => $total_detail,
        'tabel'           => '4'
        );
        
        

         $ins2 = $this->db->insert('trhju', $arr_header_ju);
         $ins3 = $this->db->insert('trhju_pkd', $arr_header_ju);
         $ins4 = $this->db->insert('trhju_blud', $arr_header_jublud);
          
        

        for($i=0; $i<count($arr_terima); $i++){
            $no_terima      = $arr_terima[$i]['no_terima'];
            $sdana          = $arr_terima[$i]['kd_sdana'];
            $kd_kegiatan    = $arr_terima[$i]['kd_kegiatan'];
            $kd_rek_lo      = $arr_terima[$i]['kd_rek_lo'];
            $nm_rekening_lo = $this->tukd_model->get_nama($kd_rek_lo,'nm_rek5','ms_rek5','kd_rek5');
            $nilai          = $arr_terima[$i]['nilai'];

            //rekening blud
            $kd_rek7_blud     = $arr_terima[$i]['kd_rek7'];
            $nm_rekening_blud = $this->tukd_model->get_nama($arr_terima[$i]['kd_rek7']        ,'nm_rek7','ms_rek7_blud','kd_rek7');
            
            //rekening 13
            $kode_rek5        = $this->tukd_model->get_kode($arr_terima[$i]['kd_rek7']        ,'kd_rek13','ms_rek7_blud','kd_rek7');
            $kd_rek5          = $kode_rek5;
            $nm_rekening      = $this->tukd_model->get_nama($kode_rek5        ,'nm_rek5','ms_rek5','kd_rek5');
            
            //rekening 64
/*            $kd_rek64         = $this->tukd_model->get_nama($kode_rek5        ,'kd_rek64','ms_rek5','kd_rek5');
            $nmrek64          = $this->tukd_model->get_nama($kode_rek5        ,'nm_rek64','ms_rek5','kd_rek5');*/
            
            
            $nmgiat           = $this->tukd_model->get_nama($arr_terima[$i]['kd_kegiatan']    ,'nm_kegiatan','trskpd','kd_kegiatan');  
            $kd_rek_piutang   = $this->tukd_model->get_nama($kode_rek5,'piutang_utang','ms_rek5','kd_rek5');
            $nm_rek_piutang   = $this->tukd_model->get_nama($kode_rek5,'nm_rek5','ms_rek5','kd_rek5'); 
                        
                //BLUD
            
                $sqlx2 = "insert into trdju_blud (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek7, kd_sdana,    nm_rek7,                debet,  kredit, rk, jns,    urut,   pos) 
                        values              ('$no_terima',  '$kd_kegiatan', '$nmgiat',      '0000000', '$sdana',  'Perubahan SAL',        $nilai, 0,      'D',        '', '1',    '0')";
                $asgx2 = $this->db->query($sqlx2);          

                $sqlx3 = "insert into trdju_blud (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek7, kd_sdana,   nm_rek7,        debet,  kredit, rk, jns,    urut,   pos) 
                        values              ('$no_terima',  '$kd_kegiatan', '$nmgiat',      '$kd_rek7_blud', '$sdana', '$nm_rekening_blud',0,       $nilai, 'K',    '', '2',        '1')";
                $asgx3 = $this->db->query($sqlx3);              
                
                $sqlx4 = "insert into trdju_blud (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek7, kd_sdana,   nm_rek7,                        debet,  kredit, rk, jns,    urut,   pos) 
                        values              ('$no_terima',  '$kd_kegiatan', '$nmgiat',      '1110201', '$sdana',  'Kas di Bendahara Penerimaan',  $nilai, 0,      'D',    '', '3',        '1')";
                $asgx4 = $this->db->query($sqlx4);          

                $sqlx5 = "insert into trdju_blud (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek7,  kd_sdana,      nm_rek7,            debet,  kredit, rk, jns,    urut,   pos) 
                        values              ('$no_terima',  '$kd_kegiatan', '$nmgiat',      '$kd_rek_lo', '$sdana',   '$nm_rekening_lo',  0,      $nilai, 'K',    '', '4',        '1')";
                $asgx5 = $this->db->query($sqlx5); 

//====================================================================================  

        }

       $sqldata ="SELECT a.`no_voucher`,kd_kegiatan,nm_kegiatan,b.kd_rek7,b.`nm_rek13`,b.kd_rek13,c.`kd_rek64`,c.`nm_rek64`,c.`map_lo`,SUM(debet) as debet,SUM(kredit) as kredit,rk,jns,urut,pos FROM trdju_blud a 
       INNER JOIN ms_rek7_blud b ON a.`kd_rek7`=b.`kd_rek7` 
       LEFT JOIN ms_rek5 c ON b.`kd_rek13`=c.`kd_rek5`
       WHERE no_voucher='$lcid'
       GROUP BY b.kd_rek13";
       
       $asgdata=$this->db->query($sqldata);
       foreach ($asgdata->result_array() as $row2)
       {
       $no_voucher  =$row2['no_voucher'];
       $kd_kegiatan =$row2['kd_kegiatan'];
       $nm_kegiatan =$row2['nm_kegiatan'];
       $kd_rek7     =$row2['kd_rek7'];
       $nm_rek13    =$row2['nm_rek13'];
       $kd_rek13    =$row2['kd_rek13'];
       $kd_rek64    =$row2['kd_rek64'];
       $map_lo      =$row2['map_lo'];
       $debet       =$row2['debet'];
       $kredit      =$row2['kredit'];
       $rk          =$row2['rk'];
       $jns         =$row2['jns'];
       $urut        =$row2['urut'];
       $pos         =$row2['pos'];
       
       $kd_rek64         = $this->tukd_model->get_nama($kd_rek13        ,'kd_rek64','ms_rek5','kd_rek5');
       $nmrek64          = $this->tukd_model->get_nama($kd_rek13        ,'nm_rek64','ms_rek5','kd_rek5');

       $nm_maplo          = $this->tukd_model->get_nama($map_lo        ,'nm_rek5','ms_rek5','kd_rek5');
       
       //permen 64
       
       $sql2 = "insert into trdju_pkd  (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,    nm_rek5,            debet,  kredit, rk, jns,    urut,   pos) 
       values                  ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '0000000',  'Perubahan SAL',    $kredit, 0,      'D',    '', '1',        '0')";
       $asg2 = $this->db->query($sql2);                
       
       $sql3 = "insert into trdju_pkd  (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,        nm_rek5,        debet,  kredit, rk, jns,    urut,   pos) 
       values                  ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '$kd_rek64',    '$nmrek64', 0,      $kredit, 'K',    '', '2',        '1')";
       $asg3 = $this->db->query($sql3);
       
       $sql4 = "insert into trdju_pkd  (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,    nm_rek5,                        debet,  kredit, rk, jns,    urut,   pos) 
       values                  ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '1110201',  'Kas di Bendahara Penerimaan',$kredit,   0,      'D',    '', '3',        '1')";
       $asg4 = $this->db->query($sql4);                
       
       $sql5 = "insert into trdju_pkd  (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,        nm_rek5,            debet,  kredit, rk, jns,    urut,   pos) 
       values                  ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '$map_lo',   '$nm_maplo',  0,      $kredit, 'K',    '', '4',        '1')";
       $asg5 = $this->db->query($sql5); 
       
       
       //permen 13
       
       $sqlx2 = "insert into trdju (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,    nm_rek5,                debet,  kredit, rk, jns,    urut,   pos) 
       values              ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '0000000',  'Perubahan SAL',        $kredit, 0,      'D',        '', '1',    '0')";
       $asgx2 = $this->db->query($sqlx2);          
       
       $sqlx3 = "insert into trdju (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,    nm_rek5,        debet,  kredit, rk, jns,    urut,   pos) 
       values              ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '$kd_rek13', '$nm_rek13',0,       $kredit, 'K',    '', '2',        '1')";
       $asgx3 = $this->db->query($sqlx3);              
       
       $sqlx4 = "insert into trdju (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,    nm_rek5,                        debet,  kredit, rk, jns,    urut,   pos) 
       values              ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '1110201',  'Kas di Bendahara Penerimaan',  $kredit, 0,      'D',    '', '3',        '1')";
       $asgx4 = $this->db->query($sqlx4);          
       
       $sqlx5 = "insert into trdju (no_voucher,    kd_kegiatan,    nm_kegiatan,    kd_rek5,        nm_rek5,            debet,  kredit, rk, jns,    urut,   pos) 
       values              ('$no_voucher',  '$kd_kegiatan', '$nm_kegiatan',      '$map_lo',   '$nm_maplo',  0,      $kredit, 'K',    '', '4',        '1')";
       $asgx5 = $this->db->query($sqlx5);   
       
       
       }               


        if($ins1 && $ins2 && $ins3 && $ins4){
    
            $msg    = array('pesan'=>'0');
            
        }else{
            $msg    = array('pesan'=>'3');
        }

        echo json_encode($msg); 
    }

    
    function load_detail_tetap_terima(){
        $skpd           = $this->session->userdata('kdskpd');
        $no_tetap   = $this->input->post('no_tetap');

        $row = array();$result = array();
    
         $sql = "SELECT a.no_tetap,a.kd_kegiatan,a.kd_rek5,a.kd_rek_lo,a.sisa as nilai,b.nm_rek5 FROM (SELECT a.*,b.nilai AS nilaiter,(a.nilai-IF(b.nilai IS NULL,0,b.nilai)) AS sisa FROM (SELECT * FROM tr_tetap_blud WHERE kd_skpd='$skpd' AND LEFT(kd_rek5,1) = '4' AND LEFT(kd_rek5,2) = '41') a
                LEFT JOIN 
                (SELECT no_tetap,kd_rek5,SUM(nilai) AS nilai FROM tr_terima_blud_blud WHERE kd_skpd='$skpd' AND no_tetap IS NOT NULL AND no_tetap <> '' GROUP BY no_tetap,kd_rek5) b 
                ON a.no_tetap=b.no_tetap AND a.kd_rek5=b.kd_rek5) a LEFT JOIN ms_rek5 b ON a.kd_rek5=b.kd_rek5 WHERE a.sisa > 0 AND a.no_tetap='$no_tetap'"; 
        
        $query1 = $this->db->query($sql);  
        $ii = 0;

        $total = 0;
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(
                        'id' => $ii,        
                        'no_tetap' => $resulte['no_tetap'],
                        'kd_kegiatan'=> $resulte['kd_kegiatan'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_lo' => $resulte['kd_rek_lo'],
                        'nilai' => number_format($resulte['nilai']),
                        'nm_rek5' => $resulte['nm_rek5']
                        );
                        $ii++;
            $total += $resulte['nilai'];
        }

        $footer[] = array('nm_rek5' => 'Total : ', 'nilai' => number_format($total,'2','.',','));

        $result["rows"] = $row;  
        $result["footer"] = $footer;

        echo json_encode($result);
    }

    function skpd() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd_blud where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') order by kd_skpd ";
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

    function skpd_filter() {
        $lccr = $this->input->post('q');
        $skpd = $this->session->userdata('kdskpd');
        $sql = "SELECT kd_skpd,nm_skpd FROM ms_skpd_blud where (kd_skpd='$skpd') and upper(nm_skpd) like upper('%$lccr%') order by kd_skpd ";
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


    function unit() {
        $lccr = $this->input->post('q');
        //$skpd = $this->session->userdata('kdskpd');
        $sql = "SELECT kd_unit,nm_unit FROM ms_unit_layanan where level='2' and upper(nm_unit) like upper('%$lccr%') order by kd_unit ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_unit' => $resulte['kd_unit'],  
                        'nm_unit' => $resulte['nm_unit']
                        );
                        $ii++;
        }
           
            echo json_encode($result);
            $query1->free_result();
    }

    function ambil_rek_tetap() {
        $lccr = $this->input->post('q');
        $lckdskpd = $this->uri->segment(3);
        $sql = "SELECT distinct b.kd_rek5 as kd_rek5,b.nm_rek5 AS nm_rek,b.map_lo as kd_rek, c.nm_rek4, a.kd_kegiatan FROM 
        trdrka_blud a left join ms_rek5 b on right(a.no_trdrka,7)=b.kd_rek5 left join ms_rek4 c on left(a.kd_rek5,5)=c.kd_rek4 
		where a.kd_skpd = '$lckdskpd' and left(a.kd_rek5,1)='4' and 
        (upper(a.kd_rek5) like upper('%$lccr%') or b.nm_rek5 like '%$lccr%') order by kd_rek5";
        //echo($sql);
		
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek' => $resulte['kd_rek'],  
                        'nm_rek' => $resulte['nm_rek'],
						'nm_rek4' => $resulte['nm_rek4'],
                        'kd_kegiatan' => $resulte['kd_kegiatan']                  
                        );
                        $ii++;
        }
        echo json_encode($result);
	}
	
	function ambil_rek_sts() {
        $lccr = $this->input->post('q');
        $lckdskpd = $this->uri->segment(3);
        $lcgiat = $this->uri->segment(4);
        $lcfilt = $this->uri->segment(6);
        $jnscp = $this->uri->segment(7);
		$sp2d = str_replace('123456789','/',$this->uri->segment(5));
        $lc = '';
        if ($lcfilt!=''){
            $lcfilt = str_replace('A',"'",$lcfilt);
            $lcfilt = str_replace('B',",",$lcfilt);
            $lc = " and a.kd_rek_blud not in ($lcfilt)";
        }
        
		
		if($jnscp>=4){
			$sql = "SELECT z.*, nilai-isnull(transaksi,0) as sisa FROM (SELECT a.kd_rek_blud,a.nm_rek_blud,SUM(a.nilai) as nilai,
					(SELECT sum(nilai) FROM trdtransout_blud WHERE no_sp2d=c.no_sp2d and kd_kegiatan=a.kd_kegiatan and kd_rek_blud=a.kd_rek_blud) as transaksi
					FROM trdspp_blud a INNER JOIN trhsp2d_blud c ON c.no_spp = a.no_spp and c.kd_skpd=a.kd_skpd where c.no_sp2d ='$sp2d'
					AND c.kd_skpd = '$lckdskpd' and a.kd_kegiatan = '$lcgiat' 
					AND upper(a.kd_rek_blud) like upper('%$lccr%') $lc GROUP BY kd_rek_blud,nm_rek_blud,no_sp2d,a.kd_kegiatan)z";		
		}else{
			$sql = "SELECT b.kd_rek_blud, b.nm_rek_blud, isnull(sum(b.nilai),0) as nilai, isnull(sum(b.nilai),0) as transaksi, 0 as sisa 
					from trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti
					where b.no_sp2d='$sp2d' and b.kd_skpd='$lckdskpd'
					group by b.kd_rek_blud, b.nm_rek_blud";
		}   
       echo "$sql";
        
        //echo $sql; upper(a.kd_rek5) like upper('%$lccr%') $lc
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek_blud'],  
                        'nm_rek5' => $resulte['nm_rek_blud'],                  
                        'nilai' => $resulte['nilai'] ,                 
                        'transaksi' => $resulte['transaksi'],                  
                        'sisa' => $resulte['sisa']                  
                        );
                        $ii++;
        } 
           
        echo json_encode($result);
    	   
	}
	
	 function ambil_rek_blud() {
        $lccr = $this->input->post('q');
        $skpd = $this->input->post('skpd');
        $giat = $this->input->post('giat');
        $rek5 = $this->input->post('kd_rek5');
		$no_trdrka = $skpd.'.'.$giat.'.'.$rek5;
        $sql = " SELECT DISTINCT a.kd_rek5,b.nm_rek5 FROM trdpo_blud a 
				 LEFT JOIN ms_rek5_blud b ON a.kd_rek5=b.kd_rek5 
				 WHERE a.no_trdrka = '$no_trdrka' AND 
				 (UPPER(a.kd_rek5) like UPPER('%$lccr%') or b.nm_rek5 like '%$lccr%') order by kd_rek5";
                // echo " $sql";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5_blud' => $resulte['kd_rek5'],
                        'nm_rek5_blud' => $resulte['nm_rek5']                 
                        );
                        $ii++;
        }
        echo json_encode($result);
	}

     function ambil_sdana() {
        $lccr       = $this->input->post('q');
        $rek5       = $this->input->post('rek5');
        $lckdskpd   = $this->session->userdata('kdskpd');
        $not_in     = $this->input->post('not_in');

        if($not_in == ""){
        $not = "''";
        }else{
        $not = implode(",", array_map(function($x){return"'$x'";}, $not_in));
        }
 
        $sql = "SELECT a.`kd_skpd`,a.`kd_kegiatan`,a.`kd_rek7`,c.`nm_sdana`,a.`nilai`,a.`nilai_ubah`,a.kd_sdana 
        FROM detail_sdana_trdrka a
        INNER JOIN trdrka_blud b ON a.`kd_kegiatan`=b.`kd_kegiatan` AND a.`kd_skpd`=b.`kd_skpd` AND a.`kd_rek7`=b.`kd_rek7`
        INNER JOIN ms_dana_blud c ON c.`kd_sdana`=a.`kd_sdana`
        WHERE a.kd_skpd = '$lckdskpd' AND LEFT(a.kd_rek7,1)='4' AND a.kd_rek7 = '$rek5'
        and a.kd_sdana NOT IN($not)
        AND upper(a.kd_rek7) like upper('%$lccr%')";

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){  
                $result[]     = array(
                'id'          => $ii,        
                'nm_sdana'     => $resulte['nm_sdana'],
                'kd_sdana'     => $resulte['kd_sdana']
            );
            $ii++;
        } 
        echo json_encode($result);
    }


  function ambil_sdana_trans() {
        $lccr       = $this->input->post('q');
        $giat        = $this->input->post ( 'giat' );
        $skpd        = $this->input->post ( 'skpd' );
        $nomor       = $this->input->post ( 'no' );
        $rek         = $this->input->post ( 'rek' );
        $rek5        = $this->input->post ( 'rek5' );
        $dasar_nilai = $this->input->post ( 'peraturan' );
        
        if ($rek != '') {
            $notIn = " and a.kd_sdana not in ($rek) ";
        } else {
            $notIn = "";
        }
        
        $stsubah = $dasar_nilai;
        if ($stsubah == "susun") {
            $field = "a.nilai";
            $sts = "susun";
        } else {
            $field = "a.nilai_ubah";
            $sts = "ubah";
        }
 
        $sql = "SELECT a.`kd_skpd`,a.`kd_kegiatan`,a.`kd_rek7`,a.kd_sdana, c.`nm_sdana`,
        (SELECT SUM(d.nilai) FROM trdtransout_blud d INNER JOIN trhtransout_blud e ON d.no_bukti=e.no_bukti 
        WHERE d.kd_kegiatan = a.kd_kegiatan AND e.kd_skpd=a.kd_skpd  AND d.kd_rek7=a.kd_rek7 AND e.no_bukti <> '$nomor') AS lalu,
        $field as anggaran
        FROM detail_sdana_trdrka a
        INNER JOIN trdrka_blud b ON a.`kd_kegiatan`=b.`kd_kegiatan` AND a.`kd_skpd`=b.`kd_skpd` AND a.`kd_rek7`=b.`kd_rek7`
        INNER JOIN ms_dana_blud c ON c.`kd_sdana`=a.`kd_sdana`
        WHERE a.kd_skpd = '$skpd' AND a.kd_kegiatan='$giat' AND LEFT(a.kd_rek7,1)='5' AND a.kd_rek7 = '$rek5' $notIn
        AND upper(a.kd_rek7) like upper('%$lccr%')";

       // print_r($sql);

        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){  
                $result[]     = array(
                'id'       => $ii,        
                'nm_sdana' => $resulte['nm_sdana'],
                'kd_sdana' => $resulte['kd_sdana'],
                'lalu'     => $resulte['lalu'],
                'anggaran' => $resulte['anggaran']
            );
            $ii++;
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

    function transout_blud() {
        $data ['page_title'] = 'INPUT PEMBAYARAN TRANSAKSI';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT PEMBAYARAN TRANSAKSI' );
        $this->template->load ( 'template', 'tukd/transaksi/transout_blud', $data );
        //$this->tukd_model->set_log_activity(); 
    }

	function ambil_simpanan() {
        $data ['page_title'] = 'INPUT AMBIL SIMPANAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT AMBIL SIMPANAN' );
        $this->template->load ( 'template', 'tukd/transaksi/ambil_simpanan', $data );
        //$this->tukd_model->set_log_activity(); 
    }
	
	function setor_simpanan() {
        $data ['page_title'] = 'INPUT SETOR SIMPANAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT SETOR SIMPANAN' );
        $this->template->load ( 'template', 'tukd/transaksi/setor_simpanan', $data );
        //$this->tukd_model->set_log_activity(); 
    }
	
	function setor_penerimaan() {
        $data ['page_title'] = 'INPUT SETOR PENERIMAAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT SETOR PENERIMAAN' );
        $this->template->load ( 'template', 'tukd/transaksi/setor_penerimaan', $data );
        ////$this->tukd_model->set_log_activity(); 
    }
	
	
    function load_no_penagihan() { // wahyu
        $cskpd = $this->session->userdata ( 'kdskpd' );
        $lccr = $this->input->post ( 'q' );
        
        $sql = "SELECT no_bukti,tgl_bukti,kd_skpd,total,ket from trhtagih where kd_skpd='$cskpd' and (upper(kd_skpd) like upper('%$lccr%') or  
                upper(no_bukti) like upper('%$lccr%')) and no_bukti not in(SELECT no_tagih as no_bukti FROM trhtransout_blud WHERE no_tagih<>'') and sts_tagih='0' order by no_bukti";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $result [] = array (
                    'id' => $ii,
                    'no_tagih' => $resulte ['no_bukti'],
                    'tgl_tagih' => $resulte ['tgl_bukti'],
                    'kd_skpd' => $resulte ['kd_skpd'],
                    'ket' => $resulte ['ket'],
                    'nila' => number_format ( $resulte ['total'], 2, ',', '.' ),
                    'nil' => $resulte ['total'] 
            );
            $ii ++;
        }
        
        echo json_encode ( $result );
    }

     function load_transout() {
        $kd_skpd = $this->session->userdata ( 'kdskpd' );
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post ( 'cari' );
        $where = '';
        if ($kriteria != '') {
            $where = " and (upper(a.no_bukti) like upper('%$kriteria%') or a.tgl_bukti like '%$kriteria%' or upper(a.nm_skpd) like 
                    upper('%$kriteria%') or upper(a.ket) like upper('%$kriteria%')) ";
        }
        
        $sql = "SELECT count(*) as tot from trhtransout_blud a where a.kd_skpd='$kd_skpd'  $where ";
       $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        $sql = "SELECT * FROM trhtransout_blud ";
        $query1 = $this->db->query ( $sql );
        $result = array();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $row [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_kas'   	  => $resulte ['no_kas'],
                    'tgl_bukti'   => $resulte ['tgl_bukti'],
                    'tgl_kas' 	  => $resulte ['tgl_kas'],
                    'ket'         => $resulte ['ket'],
                    'username'    => $resulte ['username'],
                    'tgl_update'  => $resulte ['tgl_update'],
                    'kd_skpd'     => $resulte ['kd_skpd'],
                    'nm_skpd'     => $resulte ['nm_skpd'],
                    'total'       => $resulte ['total'],
                    'pay'         => $resulte ['pay']
                    
            );
            $ii ++;
        }
        $result["total"] = $total->tot;
        $result["rows"] = $row;
        echo json_encode($result);
        $query1->free_result();
    } 



     function load_dtransout() {
        $nomor = $this->input->post ( 'no' );
        $skpd = $this->input->post ( 'kd_skpd' );
        $sql = "SELECT * FROM trdtransout_blud WHERE no_bukti ='$nomor' AND kd_skpd='$skpd'";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'          => $ii,
                    'no_bukti'    => $resulte ['no_bukti'],
                    'no_sp2d'     => $resulte ['no_sp2d'],
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan'],
                    'kd_rek5'     => $resulte ['kd_rek5'],
                    'kd_rek_blud' => $resulte ['kd_rek_blud'],
                    'nm_rek5'     => $resulte ['nm_rek5'],
                    'nm_rek_blud' => $resulte ['nm_rek_blud'],
                    'nilai'       => $resulte ['nilai'],
                    'status'      => $resulte ['status']
            );
            $ii ++;
        }
        echo json_encode ( $result );
        $query1->free_result ();
    }

     
    function load_trskpd() {
        $giat = $this->input->post ( 'giat' );
        $cskpd = $this->input->post ( 'kd' );
        $jns_beban = '';
        $cgiat = '';
        if ($giat != '') {
            $cgiat = " and a.kd_kegiatan not in ($giat)";
        }
        $lccr = $this->input->post ( 'q' );
        $sql = "SELECT a.kd_kegiatan,a.nm_kegiatan, SUM(nilai) as nilai, SUM(nilai_ubah) as nilai_ubah FROM trdrka_blud a
				GROUP BY a.kd_kegiatan,a.nm_kegiatan
				ORDER BY a.kd_kegiatan,a.nm_kegiatan
		";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $result [] = array (
                    'id' => $ii,
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan'],
                    'kd_program' => '',
                    'nm_program' => '',
                    'total' => $resulte ['nilai'] 
            );
            $ii ++;
        }
        
        echo json_encode ( $result );
        $query1->free_result ();
    }
 
    function load_rek() {
        $giat        = $this->input->post ( 'giat' );
        $kode        = $this->input->post ( 'kd' );
        $nomor       = $this->input->post ( 'no' );
        $rek         = $this->input->post ( 'rek' );
        $cunit         = $this->input->post ( 'cunit' );
        $lccr        = $this->input->post ( 'q' );
        $dasar_nilai = $this->input->post ( 'dasar_nilai' );
        
        if ($rek != '') {
            $notIn = "and a.kd_rek7 not in ($rek) ";
        } else {
            $notIn = "";
        }
        
        $stsubah = $dasar_nilai;
        if ($stsubah == "susun") {
            $field = "nilai";
            $sts = "susun";
        } else {
            $field = "nilai_ubah";
            $sts = "ubah";
        }
        
       
   $sql ="SELECT a.kd_rek5, a.nm_rek5 FROM trdrka_blud a  WHERE a.kd_kegiatan= '$giat' AND a.kd_skpd = '$kode'  $notIn";
        
        // echo $sql;
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            $result [] = array (
                    'id'       => $ii,
                    'kd_rek5'  => $resulte ['kd_rek5'],
                    'nm_rek5'  => $resulte ['nm_rek5'],
                    'kd_rek13' => '',
                    'nm_rek13' => ''
                   
            );
            $ii ++;
        }
        echo json_encode ( $result );
        $query1->free_result ();
    }

    function cek_verify(){
         $nomor    = $this->input->post ( 'no' );
         $skpd     = $this->input->post ( 'skpd' );
         $sql = "select * from trhtransout_blud where kd_skpd='$skpd' and no_bukti='$nomor'";
         $asg = $this->db->query ( $sql );
         if ($asg->num_rows()>0){
            echo 0;
         }else{
            echo 1;
         }
    }

    
	//----- Tambahan-----//
	
	function config_tahun() {
        $result = array();
         $tahun  = $this->session->userdata('pcThang');
		 $result = $tahun;
         echo json_encode($result);
	}
	
	function penetapan(){
        $data['page_title']= 'INPUT PENETAPAN';
        $this->template->set('title', 'INPUT PENETAPAN');   
        $this->template->load('template','tukd/penerimaan/penetapan',$data) ; 
    }
	
	function load_tetap() {
		 $skpd     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where=" AND a.no_tetap LIKE '%$kriteria%' OR a.tgl_tetap LIKE '%$kriteria%' OR a.keterangan LIKE '%$kriteria%' ";            
        }
       
        $sql = "SELECT count(*) as total from tr_tetap_blud a WHERE a.kd_skpd = '$skpd' $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();
		
		
		//$sql = "SELECT  * from tr_panjar where kd_skpd='$kd_skpd'";
        
        
		$sql = "
		SELECT top $rows a.*, (SELECT b.nm_rek5 FROM ms_rek5_blud b WHERE a.kd_rek5=b.kd_rek5) as nm_rek5 FROM tr_tetap_blud a WHERE a.kd_skpd='$skpd'
		$where AND a.no_tetap NOT IN (SELECT TOP $offset a.no_tetap FROM tr_tetap_blud a WHERE a.kd_skpd='$skpd' $where 
		ORDER BY a.tgl_tetap,a.no_tetap ) ORDER BY tgl_tetap,no_tetap ";
     

		$query1 = $this->db->query($sql); 
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(  
						'id' => $ii,        
                        'no_tetap' => $resulte['no_tetap'],
                        'tgl_tetap' => $resulte['tgl_tetap'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['keterangan'],    
                        'nilai' => number_format($resulte['nilai']),
                        'kd_rek5' => $resulte['kd_rek5'],
                        'nm_rek5' => $resulte['nm_rek5'],
                        'kd_rek' => $resulte['kd_rek_blud']                                                                                            
                        );
                        $ii++;
        }
       $result["rows"] = $row; 
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
	
	function cek_simpan(){
	    $nomor    = $this->input->post('no');
	    $tabel   = $this->input->post('tabel');
	    $field    = $this->input->post('field');
	    $field2    = $this->input->post('field2');
	    $tabel2   = $this->input->post('tabel2');
		$kd_skpd  = $this->session->userdata('kdskpd');        
		if ($field2==''){
		$hasil=$this->db->query(" select count(*) as jumlah FROM $tabel where $field='$nomor' and kd_skpd = '$kd_skpd' ");
		} else{
		$hasil=$this->db->query(" select count(*) as jumlah FROM (select $field as nomor FROM $tabel WHERE kd_skpd = '$kd_skpd' UNION ALL
		SELECT $field2 as nomor FROM $tabel2 WHERE kd_skpd = '$kd_skpd')a WHERE a.nomor = '$nomor' ");		
		}
		foreach ($hasil->result_array() as $row){
		$jumlah=$row['jumlah'];	
		}
		if($jumlah>0){
		$msg = array('pesan'=>'1');
        echo json_encode($msg);
		} else{
		$msg = array('pesan'=>'0');
        echo json_encode($msg);
		}
		
	}

	function simpan_tetap_ag() {
            $tabel          = $this->input->post('tabel');
            $lckolom        = $this->input->post('kolom');
            $lcnilai        = $this->input->post('nilai');
            $cid            = $this->input->post('cid');
            $lcid           = $this->input->post('lcid');
			
			$sql        	= "insert into $tabel $lckolom values $lcnilai";
			$asg       	 = $this->db->query($sql);
			if ( $asg > 0 ) {
				echo '2';
			} else {
				echo '0';
				exit();
			}
		
	}
	
	function update_tetap_ag() {
            $tabel          = $this->input->post('tabel');
            $lckolom        = $this->input->post('kolom');
            $lcnilai        = $this->input->post('nilai');
            $cid            = $this->input->post('cid');
            $lcid           = $this->input->post('lcid');
			$nohide       = $this->input->post('no_hide');
			$skpd  = $this->session->userdata('kdskpd');
			
			
			$sql = "delete from tr_tetap_blud where kd_skpd='$skpd' and no_tetap='$nohide'";
            $asg = $this->db->query($sql);
            if ($asg){
				$sql        	= "insert into $tabel $lckolom values $lcnilai";
				$asg       	 = $this->db->query($sql);
				if ( $asg > 0 ) {
					echo '2';
				} else {
					echo '0';
					exit();
				}
			}
	}   	
    
	function hapus_tetap(){
        //no:cnomor,skpd:cskpd
        $nomor = $this->input->post('no');
        $skpd = $this->input->post('skpd');
        
        $sql = "delete from tr_tetap_blud where no_tetap='$nomor' and kd_skpd = '$skpd'";
        $asg = $this->db->query($sql);
        if ($asg){
            echo '1'; 
        } else{
            echo '0';
        }
                       
    }
	
	function hapus_penagihan(){
        $nomor = $this->input->post('no');
        $skpd = $this->input->post('skpd');
        $msg = array();
		$sql = "delete from trhtagih_blud where no_bukti='$nomor' and kd_skpd = '$skpd'";
		$asg = $this->db->query($sql);
		$sql = "delete from trdtagih_blud where no_bukti='$nomor' and kd_skpd = '$skpd'";
        $asg = $this->db->query($sql);
		$msg = array('pesan'=>'1');
        echo json_encode($msg);
                       
    }
	
		
	/* function ctk_trm_str($dcetak='',$dcetak2='',$skpd='', $jns='',$jnsctk,$spasi,$jns_ttd){
   	        $lcskpd2 = $skpd;
            if($jnsctk=='1'){
                $skpd = $skpd;
            }
            
           
			$csql11 = " select nm_skpd from ms_skpd_blud where left(kd_skpd,len('$skpd')) = '$skpd'"; 
            $rs1 = $this->db->query($csql11);
            $trh1 = $rs1->row();
            $lcskpd = strtoupper ($trh1->nm_skpd);
         
		 if($jns_ttd==1){
				 $tgl_ttd= $_REQUEST['tgl_ttd'];
				 $nippa = str_replace('123456789',' ',$_REQUEST['ttd']);		     
				 if($nippa==''){
							 $lcNmPA = '';
							 $lcNipPA = '';
							 $lcJabatanPA = '';
							 $lcPangkatPA = '';
					
				 }else{   		 
					 $csql="SELECT nip as nip,nama,jabatan,pangkat  FROM ms_ttd_blud WHERE nip = '$nippa' AND kd_skpd = '$lcskpd2' AND kode='PA'";
							 $hasil = $this->db->query($csql);
							 $trh2 = $hasil->row(); 
							 
							 $lcNmPA = $trh2->nama;
							 $lcNipPA = $trh2->nip;
							 $lcJabatanPA = $trh2->jabatan;
							 $lcPangkatPA = $trh2->pangkat;
				 }
				 $nipbp = str_replace('123456789',' ',$_REQUEST['ttd2']);		     
				 if($nipbp==''){
					 $lcNmBP = '';
					 $lcNipBP = '';
					 $lcPangkatBP = '';
					 $lcJabatanBP = '';		  
				 }else{
					 $csql="SELECT nip,nama,jabatan,pangkat FROM ms_ttd_blud WHERE nip = '$nipbp' AND kd_skpd = '$lcskpd2' AND kode='BP'";
					 $hasil3 = $this->db->query($csql);
					 $trh3 = $hasil3->row(); 	
					 $lcNmBP = $trh3->nama;
					 $lcNipBP = $trh3->nip;
					 $lcPangkatBP = $trh3->pangkat;
					 $lcJabatanBP = $trh3->jabatan;
				 }            
		 }

		 $prv = $this->db->query("SELECT provinsi,daerah from sclient_blud WHERE kd_skpd='$lcskpd2' ");
			$prvn = $prv->row();          
			$prov = $prvn->provinsi;         
			$daerah = $prvn->daerah;
            
            $cRet='';

			$cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
             <tr>
                <td align=\"center\" colspan=\"11\" style=\"font-size:14px;border: solid 1px white;\"><b>$lcskpd<br>BUKU PENERIMAAN DAN PENYETORAN <br> BENDAHARA PENERIMAAN</b></td>
            </tr>
           
            <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"6\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"3\" style=\"border: solid 1px white;\">B L U D</td>
                <td align=\"left\" colspan=\"6\" style=\"border: solid 1px white;\">:&nbsp;$lcskpd</td>
            </tr>
            
            <tr>
                <td align=\"left\" colspan=\"3\" style=\"border: solid 1px white;border-bottom:solid 1px white;\">PERIODE</td>
                <td align=\"left\" colspan=\"8\" style=\"border: solid 1px white;border-bottom:solid 1px white;\">:&nbsp;".$this->tukd_model->tanggal_format_indonesia($dcetak)." S.D ".$this->tukd_model->tanggal_format_indonesia($dcetak2)."</td>
            </tr>
			</table>";
			
			$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$spasi\">
            <thead>
			<tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\">NO</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"6\">Penerimaan</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\">Penyetoran</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\">Ket.</td>
            </tr>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Tgl</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">No Bukti</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Cara Pembayaran</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Kode Rekening</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Uraian</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Jumlah</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Tgl</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">No STS</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Jumlah</td>
            </tr>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\">1</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"8%\">2</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">3</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\">4</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\">5</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"20%\">6</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">7</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"9%\">8</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">9</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">10</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"18%\">11</td>
            </tr>
			</thead>
           ";
					
              $sql1="select a.tgl_terima, a.no_terima, a.kd_rek_blud as kd_rek5, b.nm_rek5, a.nilai, c.tgl_sts, c.no_sts, c.rupiah as total, a.keterangan 
						from tr_terima_blud a LEFT JOIN ms_rek5_blud b on a.kd_rek_blud=b.kd_rek5
						LEFT JOIN 
						(select x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima, SUM(y.rupiah) as rupiah from trhkasin_blud x inner join trdkasin_blud y on x.no_sts=y.no_sts and x.kd_skpd=y.kd_skpd
						 group by x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima) c
						 on a.no_terima=c.no_terima and a.kd_skpd=c.kd_skpd
						 where a.kd_skpd='$skpd' AND a.tgl_terima BETWEEN '$dcetak' AND '$dcetak2'
						 order by a.tgl_terima, a.no_terima";
                 
                 $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                $lcno = 0;
                $lnnilai = 0;                                 
                $lntotal = 0;                                 
                foreach ($query->result() as $row)
                {   
                    $lcno = $lcno + 1;
                    $lnnilai = $lnnilai + $row->nilai;
                    $lntotal = $lntotal + $row->total;
                    $tgl=$row->tgl_terima;
                    $bukti=$row->no_terima;
                    $rek=$row->kd_rek5;                    
                    $uraian=$row->nm_rek5;
                    $nilai=number_format($row->nilai,"2",",",".");
                    $tgl_sts=$row->tgl_sts;
					$ket=$row->keterangan;
					if($tgl_sts==''){
						$tgl_sts='';
					} else{
						$tgl_sts=$this->tukd_model->tanggal_ind($tgl_sts);
					}
                    $nosts=$row->no_sts;
                    $total=number_format($row->total,"2",",","."); 
					
                     $cRet    .= " <tr><td align=\"center\" >$lcno</td>
                                        <td align=\"center\" >".$this->tukd_model->tanggal_ind($tgl)."</td>
                                        <td align=\"center\" >$bukti</td>
                                        <td align=\"center\" >Tunai</td>
                                        <td align=\"center\" >$rek</td>
                                        <td align=\"left\" >$uraian</td>
                                        <td align=\"right\" >$nilai</td>
                                        <td align=\"center\" >$tgl_sts</td>
                                        <td align=\"center\" >$nosts</td>
                                        <td align=\"right\" >$total</td>
                                        <td align=\"left\">$ket</td>
                                     </tr>
                                     ";
                }
				
			//lalu
			$total_tlalu = $this->db->query("select SUM(nilai) nilai, SUM(total) total from (
											select nilai,total from (
											select a.tgl_terima, a.no_terima, a.kd_rek_blud as kd_rek5, b.nm_rek5, a.nilai, c.tgl_sts, c.no_sts, c.rupiah as total, a.keterangan 
											from tr_terima_blud a LEFT JOIN ms_rek5_blud b on a.kd_rek_blud=b.kd_rek5
											LEFT JOIN 
											(select x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima, SUM(y.rupiah) as rupiah from trhkasin_blud x inner join trdkasin_blud y on x.no_sts=y.no_sts and x.kd_skpd=y.kd_skpd
											 group by x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima) c
											 on a.no_terima=c.no_terima and a.kd_skpd=c.kd_skpd
											 where a.kd_skpd='$skpd' AND a.tgl_terima < '$dcetak'
											 ) z ) x");
			$ttl_tlalu = $total_tlalu->row();          
			$nil_lalu = $ttl_tlalu->nilai;
			$tot_lalu = $ttl_tlalu->total;
			
			//sd_ini
			$total_sdini = $this->db->query("select SUM(nilai) nilai, SUM(total) total, SUM(nilai)-SUM(total) sisa from (
											select nilai,total from (
											select a.tgl_terima, a.no_terima, a.kd_rek_blud as kd_rek5, b.nm_rek5, a.nilai, c.tgl_sts, c.no_sts, c.rupiah as total, a.keterangan 
											from tr_terima_blud a LEFT JOIN ms_rek5_blud b on a.kd_rek_blud=b.kd_rek5
											LEFT JOIN 
											(select x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima, SUM(y.rupiah) as rupiah from trhkasin_blud x inner join trdkasin_blud y on x.no_sts=y.no_sts and x.kd_skpd=y.kd_skpd
											 group by x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima) c
											 on a.no_terima=c.no_terima and a.kd_skpd=c.kd_skpd
											 where a.kd_skpd='$skpd' AND a.tgl_terima <= '$dcetak2'
											 ) z ) x");
			$ttl_sdini = $total_sdini->row();          
			$nil_sdini = $ttl_sdini->nilai;
			$tot_sdini = $ttl_sdini->total;
			$sisa_sdini = $ttl_sdini->sisa;
			
			$cRet    .= " <tr><td colspan=\"6\" align=\"center\"><b>Jumlah Periode Ini</b></td>
								<td align=\"right\" ><b>".number_format($lnnilai,"2",",",".")."</b></td>
								<td align=\"center\" ></td>
								<td align=\"center\" ></td>
								<td align=\"right\" ><b>".number_format($lntotal,"2",",",".")."</b></td>
								<td align=\"left\" ></td>
							 </tr>
							<tr><td colspan=\"6\" align=\"center\"><b>Jumlah Periode Lalu</b></td>
								<td align=\"right\" ><b>".number_format($nil_lalu,"2",",",".")."</b></td>
								<td align=\"center\" ></td>
								<td align=\"center\" ></td>
								<td align=\"right\" ><b>".number_format($tot_lalu,"2",",",".")."</b></td>
								<td align=\"left\" ></td>
							 </tr>
							 <tr><td colspan=\"6\" align=\"center\"><b>Jumlah s/d Periode Ini</b></td>
								<td align=\"right\" ><b>".number_format($nil_sdini,"2",",",".")."</b></td>
								<td align=\"center\" ></td>
								<td align=\"center\" ></td>
								<td align=\"right\" ><b>".number_format($tot_sdini,"2",",",".")."</b></td>
								<td align=\"left\" ></td>
							 </tr>
							 <tr><td colspan=\"6\" align=\"right\"><b>Sisa</b></td>
								<td align=\"right\" ><b></b></td>
								<td align=\"center\" ></td>
								<td align=\"center\" ></td>
								<td align=\"right\" ><b>".number_format($nil_sdini-$tot_sdini,"2",",",".")."</b></td>
								<td align=\"left\" ></td>
							 </tr>
							 </table>";
			
			if($jns_ttd==1){				 
				$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
				<tr>
				<td align=\"center\" width=\"50%\">Mengetahui</td>
				<td align=\"center\" width=\"50%\">".$daerah.", ".$this->tanggal_format_indonesia($tgl_ttd)."</td>
				</tr>
				<tr>
				<td align=\"center\" width=\"50%\">$lcJabatanPA</td>
				<td align=\"center\" width=\"50%\">$lcJabatanBP</td>
				</tr>
				<tr>
				<td align=\"center\" width=\"50%\">&nbsp;</td>
				<td align=\"center\" width=\"50%\"></td>
				</tr>
				<tr>
				<td align=\"center\" width=\"50%\">&nbsp;</td>
				<td align=\"center\" width=\"50%\"></td>
				</tr>

				<tr>
						<td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"><b><u>$lcNmPA</u></b><br>$lcPangkatPA</td>
						<td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"><b><u>$lcNmBP</u></b><br>$lcPangkatBP</td>
					</tr>
					<tr>
						<td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\">NIP. $lcNipPA</td>
						 <td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\">NIP. $lcNipBP</td>
					</tr>
					</table>"
				;
			}
			
			$data['prev']= '';
			if ($jns==1){
			$this->_mpdf('',$cRet,10,10,10,'1',1,''); 
			} else{
				echo ("<title>Buku Penerimaan Penyetoran</title>");
				echo $cRet;
				}

	}
     */
	
    function simpan_terima_ag() {
            $tabel          = $this->input->post('tabel');
            $lckolom        = $this->input->post('kolom');
            $lcnilai        = $this->input->post('nilai');
            $cid            = $this->input->post('cid');
            $lcid           = $this->input->post('lcid');
			
			$sql        	= "insert into $tabel $lckolom values $lcnilai";
			$asg       	 = $this->db->query($sql);
			if ( $asg > 0 ) {
				echo '2';
			} else {
				echo '0';
				exit();
			}
		
	}

	function update_terima_ag() {
            $tabel          = $this->input->post('tabel');
            $lckolom        = $this->input->post('kolom');
            $lcnilai        = $this->input->post('nilai');
            $cid            = $this->input->post('cid');
            $lcid           = $this->input->post('lcid');
			$nohide       = $this->input->post('no_hide');
			$skpd  = $this->session->userdata('kdskpd');
			
			
			$sql = "delete from tr_terima_blud where kd_skpd='$skpd' and no_terima='$nohide'";
            $asg = $this->db->query($sql);
            if ($asg){
				$sql        = "insert into $tabel $lckolom values $lcnilai";
				$asg       	 = $this->db->query($sql);
				if ( $asg > 0 ) {
					echo '2';
				} else {
					echo '0';
					exit();
				}
			}
	}	
    
	function hapus_terima(){
        $nomor = $this->input->post('no');
        $skpd = $this->input->post('skpd');
        $sql = "delete from tr_terima_blud where no_terima='$nomor' and kd_skpd = '$skpd'";
        $asg = $this->db->query($sql);
        if ($asg){
            echo '1'; 
        } else{
            echo '0';
		}
	}
		
		
		
	function load_terima_tl() {
		$skpd     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where=" AND no_terima LIKE '%$kriteria%' OR tgl_terima LIKE '%$kriteria%'";            
        }
       
        $sql = "SELECT count(*) as total from tr_terima_blud WHERE kd_skpd = '$skpd' $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();
		
		
		//$sql = "SELECT  * from tr_panjar where kd_skpd='$kd_skpd'";
        
        
		$sql = "
		SELECT top $rows no_terima,no_tetap,tgl_terima,tgl_tetap,kd_skpd,keterangan as ket,nilai, kd_rek5,kd_rek_blud,kd_kegiatan,sts_tetap from tr_terima_blud WHERE kd_skpd='$skpd' AND jenis='2' 
		$where AND no_terima NOT IN (SELECT TOP $offset no_terima FROM tr_terima_blud WHERE kd_skpd='$skpd' $where ORDER BY tgl_terima,no_terima ) ORDER BY tgl_terima,no_terima ";

		$query1 = $this->db->query($sql); 
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(  
                        'id' => $ii,        
                        'no_terima' => $resulte['no_terima'],
                        'no_tetap' => $resulte['no_tetap'],
                        'tgl_terima' => $resulte['tgl_terima'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'keterangan' => $resulte['ket'],    
                        'nilai' => number_format($resulte['nilai']),
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
						'kd_kegiatan' => $resulte['kd_kegiatan'],
						'tgl_tetap' => $resulte['tgl_tetap'],
                        'sts_tetap' =>$resulte['sts_tetap']                                                                                            
                        );
                        $ii++;
        }
       $result["rows"] = $row; 
        echo json_encode($result);
        $query1->free_result();	
    }

                       
    function load_rek_blud_trans($kd_rek='',$kd_giat='') {  
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT a.kd_skpd, a.kd_kegiatan, a.kd_rek5, a.kd_rek_blud, a.nm_rek5,ISNULL(murni, 0) as murni,
				ISNULL(ubah,0) as ubah, ISNULL(nilai,0) as nilai
				FROM (SELECT LEFT(a.no_trdrka,10) as kd_skpd, SUBSTRING(no_trdrka,12,21) as kd_kegiatan,
				RIGHT(RTRIM(no_trdrka),7) as kd_rek5,RTRIM(a.kd_rek5) kd_rek_blud, RTRIM(b.nm_rek5) as nm_rek5, SUM(total) as murni, SUM(total_ubah) as ubah
				FROM trdpo_blud a LEFT JOIN ms_rek5_blud b ON a.kd_rek5=b.kd_rek5
				WHERE RIGHT(RTRIM(no_trdrka),7)= '$kd_rek' AND LEFT(a.no_trdrka,10)='$skpd' AND SUBSTRING(no_trdrka,12,21)='$kd_giat'
				GROUP BY LEFT(a.no_trdrka,10),SUBSTRING(no_trdrka,12,21),RIGHT(RTRIM(no_trdrka),7),a.kd_rek5,b.nm_rek5) a
				LEFT JOIN
				(SELECT a.kd_skpd,b.kd_kegiatan,b.kd_rek5,b.kd_rek_blud,SUM(b.nilai) as nilai FROM trhtransout_blud a INNER JOIN trdtransout_blud b 
				ON a.no_bukti=b.no_bukti and a.kd_skpd=b.kd_skpd 
				GROUP BY a.kd_skpd,b.kd_kegiatan,b.kd_rek5,b.kd_rek_blud) b
				ON a.kd_skpd=b.kd_skpd AND a.kd_kegiatan=b.kd_kegiatan 
				AND a.kd_rek5=b.kd_rek5 AND a.kd_rek_blud=b.kd_rek_blud";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id' => $ii,
                        'kd_rek5' => $resulte['kd_rek_blud'],                         
                        'nm_rek5' => $resulte['nm_rek5'],                        
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
 
	function cek_status_ang(){
        $tgl_spp = $this->input->post('tgl_cek');
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "select case when statu=1  and status_ubah=1 and '$tgl_spp'>=tgl_dpa_ubah then 'Perubahan' 
				when statu=1 and status_ubah=1 and '$tgl_spp'<tgl_dpa_ubah then 'Penyusunan'
				when statu=1 and status_ubah=0 and '$tgl_spp'<tgl_dpa_ubah then 'Penyusunan'
				when statu=1 and status_ubah=0 and '$tgl_spp'>=tgl_dpa then 'Penyusunan'
				else 'Penyusunan' end as anggaran from trhrka_blud where kd_skpd ='$skpd'";
        $query1 = $this->db->query($sql);  
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'status_ang' => $resulte['anggaran']
                        );
                        $ii++;
        }
        echo json_encode($result);
    }

	function load_ambilsimpanan() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$kd_skpd = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(no_kas) like upper('%$kriteria%')) "; 
        }
		$sql = "SELECT count(*) as tot from tr_ambilsimpanan_blud WHERE  kd_skpd = '$kd_skpd' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
                
        $sql = "SELECT TOP $rows * from tr_ambilsimpanan_blud WHERE  kd_skpd = '$kd_skpd' $where and no_kas not in (
				SELECT TOP $offset no_kas from tr_ambilsimpanan_blud WHERE  kd_skpd = '$kd_skpd' $where order by CAST(no_kas AS INT)) order by CAST(no_kas AS INT),kd_skpd";
        
		$query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte) { 
            $row[] = array(
                        'id'          => $ii,        
                        'no_kas'      => $resulte['no_kas'],
                        'no_bukti'      => $resulte['no_bukti'],
                        //'tgl_kas'     => $this->tukd_model->rev_date($resulte['tgl_kas']),
                        'tgl_kas'     => $resulte['tgl_kas'],
                        'tgl_bukti'     => $resulte['tgl_bukti'],
                        'kd_skpd'     => $resulte['kd_skpd'],
                        'nilai'       => number_format($resulte['nilai']),
                        'bank'        => $resulte['bank'],
                        'nm_rekening' => $resulte['nm_rekening'],
                        'keterangan'  => $resulte['keterangan']    
                        );
                        $ii++;
        }
			$result["total"] = $total->tot;
			$result["rows"] = $row; 
			//$query1->free_result();   
			echo json_encode($result);
		}
    function config_bank_simpanan() {
        $lccr   = $this->input->post('q');
        $sql    = "SELECT kode, nama FROM ms_bank_blud where upper(kode) like '%$lccr%' or upper(nama) like '%$lccr%' order by kode ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['kode'],  
                        'nama' => $resulte['nama']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
	}
	
	function load_sisa_bank_lain(){
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $query1 = $this->db->query("SELECT 0 AS terima, 0 AS keluar");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        //'rekspm' => number_format($resulte['rekspm'],2,'.',','),
                        'sisa' => number_format(($resulte['terima'] - $resulte['keluar']),2,'.',',')                      
                        );
                        $ii++;
        }
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}

	
	function load_sisa_bank(){
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $query1 = $this->db->query("SELECT SUM(case when jns=1 then jumlah else 0 end) AS terima,
			SUM(case when jns=2 then jumlah else 0 end) AS keluar
			FROM (
			SELECT tgl_kas AS tgl, no_kas AS bku, b.keterangan_sp2d as ket, SUM(a.nilai) AS jumlah, '1' AS jns, a.kd_skpd AS kode FROM trdspp_blud a INNER JOIN trhsp2d_blud b ON a.no_spp=b.no_spp AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd='$kd_skpd' GROUP BY tgl_kas, no_kas, b.keterangan_sp2d, a.kd_skpd UNION ALL
			SELECT a.tgl_bukti AS tgl, a.no_bukti AS bku, ket AS ket, b.nilai as jumlah, '2' as jns, a.kd_skpd as kode FROM trhtransout_blud a INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd WHERE a.kd_skpd='$kd_skpd' AND pay='BANK' UNION ALL
			SELECT tgl_kas AS tgl,no_kas AS bku,keterangan AS ket,nilai AS jumlah,'2' AS jns,kd_skpd AS kode FROM tr_ambilsimpanan_blud WHERE kd_skpd='$kd_skpd' ) a
			where  kode='$kd_skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        //'rekspm' => number_format($resulte['rekspm'],2,'.',','),
                        'sisa' => number_format(($resulte['terima'] - $resulte['keluar']),2,'.',',')                      
                        );
                        $ii++;
        }
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	function load_sisa_penerimaan(){
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $query1 = $this->db->query("SELECT SUM(case when jenis=1 then nilai else 0 end) AS terima,
			SUM(case when jenis=2 then nilai else 0 end) AS keluar
			FROM (select '1' jenis, rupiah as nilai , a.kd_skpd from trdkasin_blud a inner join trhkasin_blud b 
			on a.no_sts=b.no_sts and a.kd_skpd=b.kd_skpd where jns_trans in ('2','4','1','5') and left(kd_rek_blud,1) IN ('4','1','5') UNION ALL
			select '1' jenis, saldo_lalu as nilai , kd_skpd from ms_skpd_blud UNION ALL
			select '2' jenis, a.nilai as nilai , a.kd_skpd from trdspp_blud a inner join trhsp2d_blud b 
			on a.no_spp=b.no_spp and a.kd_skpd=b.kd_skpd where jns_spp in ('1','2','3','4','5','6','10') UNION ALL
			select '2' jenis, nilai as nilai , kd_skpd from tr_setorsimpanan_blud WHERE jenis='1' )a
						where  kd_skpd='$kd_skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        //'rekspm' => number_format($resulte['rekspm'],2,'.',','),
                        'sisa' => number_format(($resulte['terima'] - $resulte['keluar']),2,'.',',')                      
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	function load_sisa_tunai_lain($sp2d=""){
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $query1 = $this->db->query("SELECT SUM(case when jenis=1 then nilai else 0 end) AS terima,
			SUM(case when jenis=2 then nilai else 0 end) AS keluar
			FROM (select '1' jenis, nilai as nilai , kd_skpd from tr_setorsimpanan_blud WHERE jenis='1' AND kd_skpd='$kd_skpd' AND no_bukti='$sp2d' UNION ALL
			SELECT '2' jenis, sum(b.nilai) as nilai,  a.kd_skpd as kode FROM trhtransout_blud a INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd WHERE jenis='10' AND a.kd_skpd='$kd_skpd' AND b.no_sp2d='$sp2d' group by a.kd_skpd
			)a");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        //'rekspm' => number_format($resulte['rekspm'],2,'.',','),
                        'sisa' => number_format(($resulte['terima'] - $resulte['keluar']),2,'.',',')                      
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	
	function load_sisa_tunai(){
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $query1 = $this->db->query("SELECT SUM(case when jenis=1 then nilai else 0 end) AS terima,
			SUM(case when jenis=2 then nilai else 0 end) AS keluar
			FROM (select '1' jenis, nilai as nilai , kd_skpd from tr_ambilsimpanan_blud UNION ALL
			SELECT '2' jenis, b.nilai as nilai,  a.kd_skpd as kode FROM trhtransout_blud a INNER JOIN trdtransout_blud b ON a.no_bukti=b.no_bukti AND a.kd_skpd=b.kd_skpd WHERE pay='TUNAI' UNION ALL
			select '2' jenis, nilai as nilai , kd_skpd from tr_setorsimpanan_blud WHERE jenis='2' )a
						where  kd_skpd='$kd_skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        //'rekspm' => number_format($resulte['rekspm'],2,'.',','),
                        'sisa' => number_format(($resulte['terima'] - $resulte['keluar']),2,'.',',')                      
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	function simpan_ambil_simpanan(){
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
    	$kd_skpd  = $this->session->userdata('kdskpd');
        $sql = "select $cid from $tabel where $cid='$lcid' AND kd_skpd='$kd_skpd'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }

	function simpan_setor_simpanan(){
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
    	$kd_skpd  = $this->session->userdata('kdskpd');
        $sql = "select $cid from $tabel where $cid='$lcid' AND kd_skpd='$kd_skpd'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }

	
	function update_ambilsimpanan(){
        $query  = $this->input->post('st_query');
        $asg    = $this->db->query($query);
		 if(!$asg){
            echo "0";
        } else {
			echo "1";
		}
    }
    
 
	function load_setorsimpanan() {
       $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$kd_skpd = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(no_kas) like upper('%$kriteria%')) ";            
        }

		$sql = "SELECT count(*) as tot from tr_setorsimpanan_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '2' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
                
        $sql = "SELECT TOP $rows * from tr_setorsimpanan_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '2' $where and no_kas not in (
				SELECT TOP $offset no_kas from tr_setorsimpanan_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '2' $where order by CAST(no_kas AS INT)) order by CAST(no_kas AS INT),kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $row[] = array(
                        'id'          => $ii,        
                        'no_kas'      => $resulte['no_kas'],
                        'no_bukti'      => $resulte['no_bukti'],
                        //'tgl_kas'     => $this->tukd_model->rev_date($resulte['tgl_kas']),
                        'tgl_kas'     => $resulte['tgl_kas'],
                        'tgl_bukti'     => $resulte['tgl_bukti'],
                        'kd_skpd'     => $resulte['kd_skpd'],
                        'nilai'       => number_format($resulte['nilai'],"2",".",","),
                        'bank'        => $resulte['bank'],
                        'nm_rekening' => $resulte['nm_rekening'],
                        'keterangan'  => $resulte['keterangan']    
                        );
                        $ii++;
        }
       $result["total"] = $total->tot;
        $result["rows"] = $row; 
        $query1->free_result();   
        echo json_encode($result);
	}
    
	function load_setorterima() {
       $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$kd_skpd = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(no_kas) like upper('%$kriteria%')) ";            
        }

		$sql = "SELECT count(*) as tot from tr_setorsimpanan_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '1' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
                
        $sql = "SELECT TOP $rows * from tr_setorsimpanan_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '1' $where and no_kas not in (
				SELECT TOP $offset no_kas from tr_setorsimpanan_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '1' $where order by CAST(no_kas AS INT)) order by CAST(no_kas AS INT),kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $row[] = array(
                        'id'          => $ii,        
                        'no_kas'      => $resulte['no_kas'],
                        'no_bukti'      => $resulte['no_bukti'],
                        //'tgl_kas'     => $this->tukd_model->rev_date($resulte['tgl_kas']),
                        'tgl_kas'     => $resulte['tgl_kas'],
                        'tgl_bukti'     => $resulte['tgl_bukti'],
                        'kd_skpd'     => $resulte['kd_skpd'],
                        'nilai'       => number_format($resulte['nilai'],"2",".",","),
                        'bank'        => $resulte['bank'],
                        'nm_rekening' => $resulte['nm_rekening'],
                        'keterangan'  => $resulte['keterangan']    
                        );
                        $ii++;
        }
       $result["total"] = $total->tot;
        $result["rows"] = $row; 
        $query1->free_result();   
        echo json_encode($result);
	}
 
 
	function hapus_ambilsimpanan() {    	
		$no    = $this->input->post('no');
        $skpd  = $this->input->post('skpd');        
        $query = $this->db->query("delete from tr_ambilsimpanan_blud where no_kas='$no' and kd_skpd='$skpd' ");
       // $query->free_result();
    }
	function hapus_setorsimpanan() {    	
		$no    = $this->input->post('no');
        $skpd  = $this->input->post('skpd');        
        $query = $this->db->query("delete from tr_setorsimpanan_blud where no_kas='$no' and kd_skpd='$skpd' ");
        ///$query->free_result();
    }
	
	function trm_pot() {
        $data ['page_title'] = 'INPUT TERIMA POTONGAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT TERIMA POTONGAN' );
        $this->template->load ( 'template', 'tukd/transaksi/trmpot', $data );
        //$this->tukd_model->set_log_activity(); 
    }
	
	function str_pot() {
        $data ['page_title'] = 'INPUT SETOR POTONGAN';
        $data['kdskpd']   = $this->session->userdata ('kdskpd' );
        $data['tahun']  = $this->session->userdata ( 'pcThang' );
        $this->template->set ( 'title', 'INPUT SETOR POTONGAN' );
        $this->template->load ( 'template', 'tukd/transaksi/strpot', $data );
        //$this->tukd_model->set_log_activity(); 
    }
	
	function load_kegiatan_pot(){
		$skpd   = $this->session->userdata ('kdskpd' );
        $query1 = $this->db->query("SELECT DISTINCT a.kd_kegiatan,a.nm_kegiatan FROM trdtransout_blud a
			INNER JOIN trhtransout_blud c ON a.no_bukti = c.no_bukti
			AND a.kd_skpd = c.kd_skpd
			WHERE a.kd_skpd = '$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_giat' => $resulte['kd_kegiatan'],                     
                        'nm_giat' => $resulte['nm_kegiatan'],                     
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	function load_no_trans_pot(){
		$skpd   = $this->session->userdata ('kdskpd' );
        $query1 = $this->db->query("select a.no_bukti, b.kd_kegiatan, (select nm_kegiatan from trdrka_blud where kd_kegiatan=b.kd_kegiatan group by kd_kegiatan,nm_kegiatan) nm_kegiatan,b.kd_rek5, (select nm_rek5 from ms_rek5 where kd_rek5=b.kd_rek5 group by kd_rek5, nm_rek5) nm_rek5,  b.kd_rek_blud, (select nm_rek5 from ms_rek5_blud where kd_rek5=b.kd_rek_blud group by kd_rek5, nm_rek5) nm_rek_blud, b.nilai  from trhtransout_blud a inner join trdtransout_blud b on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti
		where a.kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_bukti' => $resulte['no_bukti'],                     
                        'kd_giat' => $resulte['kd_kegiatan'],                     
                        'nm_giat' => $resulte['nm_kegiatan'],                     
                        'kd_rek' => $resulte['kd_rek5'],                     
                        'nm_rek' => $resulte['nm_rek5'],                     
                        'kd_rek_blud' => $resulte['kd_rek_blud'],                     
                        'nm_rek_blud' => $resulte['nm_rek_blud'],                     
                        'nilai' => $resulte['nilai']                     
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	
	function load_rek_pot(){
		$kd_giat_pot = $this->uri->segment(3);
        $query1 = $this->db->query("SELECT a.kd_rek5, a.nm_rek5 FROM trdtransout_blud a
			INNER JOIN trhtransout_blud b ON a.no_bukti = b.no_bukti AND a.kd_skpd = b.kd_skpd WHERE
			  a.kd_kegiatan = '$kd_giat_pot'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek' => $resulte['kd_rek5'],                     
                        'nm_rek' => $resulte['nm_rek5'],                     
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
            $query1->free_result();	
	}
	
	function perusahaan() {                 
        $lccr = $this->input->post('q');
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $sql = "	SELECT TOP 5 nmrekan, pimpinan, npwp, alamat FROM trhtrmpot_blud WHERE LEN(nmrekan)>1 AND kd_skpd = '$kd_skpd'   
					AND UPPER(nmrekan) LIKE UPPER('%$lccr%')
					GROUP BY nmrekan, pimpinan, npwp, alamat";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id' => $ii,        
                        'nmrekan' => $resulte['nmrekan'],  
                        'pimpinan' => $resulte['pimpinan'],      
                        'npwp' => $resulte['npwp'],
                        'alamat' => $resulte['alamat'],
                        );
                        $ii++;
        }
        echo json_encode($result);
        $query1->free_result();
    }

	function rek_pot() {
        $lccr   = $this->input->post('q') ;
        $sql    = " SELECT kd_rek5,nm_rek5 FROM ms_pot_blud where ( upper(kd_rek5) like upper('%$lccr%')
                    OR upper(nm_rek5) like upper('%$lccr%') )  ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
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
     $query1->free_result();	   
	}
    
	
	function simpan_potongan(){
        $tabel    = $this->input->post('tabel');        
        $nomor    = $this->input->post('no');
        $tgl      = $this->input->post('tgl');
        $skpd     = $this->input->post('skpd');
        $nmskpd   = $this->input->post('nmskpd');       
        $ket      = $this->input->post('ket');
        $total    = $this->input->post('total'); 
        $npwp    = $this->input->post('npwp');      
        $kd_giat     = $this->input->post('kd_giat');            
        $nm_giat     = $this->input->post('nm_giat');            
        $kd_rek     = $this->input->post('kd_rek');            
        $nm_rek     = $this->input->post('nm_rek');            
        $rekanan     = $this->input->post('rekanan');            
        $dir     = $this->input->post('dir');            
        $alamat     = $this->input->post('alamat');            
        $csql     = $this->input->post('sql');            
        $usernm   = $this->session->userdata('pcNama');
		$csqljur     = $this->input->post('sqljur');            
		$cno_tans     = $this->input->post('no_tans');            
		$ckd_rek_blud     = $this->input->post('kd_rek_blud');            
		$cnm_rek_blud     = $this->input->post('nm_rek_blud');            

       // $update     = date('y-m-d H:i:s');      
        $msg        = array();

		// Simpan Header //
        if ($tabel == 'trhtrmpot_blud') {
			$sql = "delete from trhtrmpot_blud where kd_skpd='$skpd' and no_bukti='$nomor'";
			$asg = $this->db->query($sql);
			

            if ($asg){
                
				$sql = "insert into trhtrmpot_blud(no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,nilai,npwp,jns_spp,status,no_sp2d,kd_kegiatan, nm_kegiatan, kd_rek5,nm_rek5,nmrekan, pimpinan,alamat,no_bukti_trans) 
                        values('$nomor','$tgl','$ket','$usernm','','$skpd','$nmskpd','$total','$npwp','','0','','$kd_giat','$nm_giat','$kd_rek','$nm_rek','$rekanan','$dir','$alamat','$cno_tans')";
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
            
        }elseif($tabel == 'trdtrmpot_blud') {
		$total2    = $this->input->post('total'); 
            
            // Simpan Detail //                       
                $sql = "delete from trdtrmpot_blud where no_bukti='$nomor' AND kd_skpd='$skpd'";
                $asg = $this->db->query($sql);
						
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "insert into trdtrmpot_blud(no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,kd_rek_blud)"; 
                    $asg = $this->db->query($sql.$csql);
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
        }
    }
	
	
	function simpan_potongan_edit(){
        $tabel    = $this->input->post('tabel'); 
		$no_bku   = $this->input->post('no_bku');
        $nomor    = $this->input->post('no');
        $tgl      = $this->input->post('tgl');
        $skpd     = $this->input->post('skpd');
        $nmskpd   = $this->input->post('nmskpd');       
        $ket      = $this->input->post('ket');
        $total    = $this->input->post('total'); 
        $npwp    = $this->input->post('npwp');      
        $csql     = $this->input->post('sql');            
        $kd_giat     = $this->input->post('kd_giat');            
        $nm_giat     = $this->input->post('nm_giat');            
        $kd_rek     = $this->input->post('kd_rek');            
        $nm_rek     = $this->input->post('nm_rek');            
        $rekanan     = $this->input->post('rekanan');            
        $dir     = $this->input->post('dir');            
        $alamat     = $this->input->post('alamat');            
        $csql     = $this->input->post('sql');            
        $usernm   = $this->session->userdata('pcNama');
		$csqljur     = $this->input->post('sqljur'); 
		$cno_tans     = $this->input->post('no_tans');            
		$ckd_rek_blud     = $this->input->post('kd_rek_blud');            
		$cnm_rek_blud     = $this->input->post('nm_rek_blud');

       // $update     = date('y-m-d H:i:s');      
        $msg        = array();

		// Simpan Header //
        if ($tabel == 'trhtrmpot_blud') {
			$sql = "delete from trhtrmpot_blud where kd_skpd='$skpd' and no_bukti='$no_bku'";
			$asg = $this->db->query($sql);
			
			if ($asg){
                
				$sql = "insert into trhtrmpot_blud(no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,nilai,npwp,jns_spp,status,no_sp2d,kd_kegiatan, nm_kegiatan, kd_rek5,nm_rek5,nmrekan, pimpinan,alamat,no_bukti_trans) 
                        values('$nomor','$tgl','$ket','$usernm','','$skpd','$nmskpd','$total','$npwp','','0','','$kd_giat','$nm_giat','$kd_rek','$nm_rek','$rekanan','$dir','$alamat','$cno_tans')";
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
            
        }elseif($tabel == 'trdtrmpot_blud') {
		$total2    = $this->input->post('total'); 
            
            // Simpan Detail //                       
                $sql = "delete from trdtrmpot_blud where no_bukti='$no_bku' AND kd_skpd='$skpd'";
                $asg = $this->db->query($sql);
				
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "insert into trdtrmpot_blud(no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,kd_rek_blud)"; 
                    $asg = $this->db->query($sql.$csql);
					
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }

			
        }
    }
	
	
	function load_pot_in(){
        $kd_skpd     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(no_bukti) like upper('%$kriteria%') or tgl_bukti like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%')) ";            
        }
       
        $sql = "SELECT count(*) as total from trhtrmpot_blud where kd_skpd='$kd_skpd' $where " ;
        //$sql = "SELECT count(*) as total from trhtransout_blud a where a.kd_skpd='$kd_skpd' and a.jns_spp in ('1','2','3') $where " ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();        
		$sql = "SELECT top $rows a.* from trhtrmpot_blud a where a.kd_skpd='$kd_skpd' AND a.no_bukti not in (SELECT top $offset no_bukti FROM trhtrmpot_blud where kd_skpd='$kd_skpd' order by no_bukti) $where order by a.no_bukti,a.kd_skpd";
		/*$sql = "SELECT TOP 70 PERCENT a.*,b.no_bukti AS nokas_pot,b.tgl_bukti AS tgl_pot,b.ket AS kete FROM trhtransout_blud a LEFT JOIN trhtrmpot_blud b ON  a.no_kas_pot=b.no_bukti 
        WHERE  a.kd_skpd='$kd_skpd' $where order by tgl_bukti,no_bukti,kd_skpd ";//limit $offset,$rows";
		*/
        $query1 = $this->db->query($sql); 
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
           if ($resulte['status']=='1'){
				$s1='&#10004';
			}else{
				$s1='&#10008';			
			}
            $row[] = array(
                         'id' => $ii,
                        'no_bukti' => $resulte['no_bukti'],
                        'tgl_bukti' => $resulte['tgl_bukti'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],        
                        'ket' => $resulte['ket'],
                        'no_sp2d' => $resulte['no_sp2d'],
                        'nilai' => $resulte['nilai'],
                        'kd_giat' => $resulte['kd_kegiatan'],
                        'nm_giat' => $resulte['nm_kegiatan'],
                        'kd_rek' => $resulte['kd_rek5'],
                        'nm_rek' => $resulte['nm_rek5'],
                        'rekanan' => $resulte['nmrekan'],
                        'dir' => $resulte['pimpinan'],
                        'alamat' => $resulte['alamat'],
                        'npwp' => $resulte['npwp'],
                        'jns_beban' => $resulte['jns_spp'],
                        'status' => $resulte['status'],                                                                                           
                        'no_bukti_trans' => $resulte['no_bukti_trans'],                                                                                           
                        'kd_rek_blud' => '',                                                                                           
                        'simbol' => $s1                                                                                         
                        );
                        $ii++;
        }
       	$result["rows"] = $row; 
        echo json_encode($result);
        $query1->free_result();
    }
	
	function load_trm_pot(){
		$skpd = $this->session->userdata('kdskpd');
		$bukti = $this->input->post('bukti');
        //$id=str_replace('123456789','/',$spp);
        $query1 = $this->db->query("select sum(nilai) as rektotal from trdtrmpot_blud where no_bukti='$bukti' AND kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal' => number_format($resulte['rektotal'],"2",",","."),
                        'rektotal1' => $resulte['rektotal']                       
                        );
                        $ii++;
        }
           
           //return $result;
		   echo json_encode($result);
           $query1->free_result();	
	}
    
	function trdtrmpot_blud_list() {
        $kd_skpd     = $this->session->userdata('kdskpd');
        $nomor = $this->input->post('nomor');
		
        $sql = "SELECT * FROM trdtrmpot_blud where no_bukti='$nomor' AND kd_skpd ='$kd_skpd' order by kd_rek5";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,   
                        'kd_rek_trans' => $resulte['kd_rek_trans'],  
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        //'pot' => $resulte['pot'],
                        //'nilai' => $resulte['nilai']
						'nilai' => number_format($resulte['nilai'],2,'.',',')
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	 //$query1->free_result();   
	}
    
	
	function hapus_trmpot(){
        $nomor = $this->input->post('no');
		$kd_skpd  = $this->session->userdata('kdskpd');
        $msg = array();
		$sql = "delete from trdtrmpot_blud where no_bukti='$nomor' AND kd_skpd='$kd_skpd'";
        $asg = $this->db->query($sql);
        $sql = "delete from trhtrmpot_blud where no_bukti='$nomor' AND kd_skpd='$kd_skpd'";
        $asg = $this->db->query($sql);
        $msg = array('pesan'=>'1');
        echo json_encode($msg);
    }
    
	function trmpot_() {
		$kd_skpd = $this->session->userdata('kdskpd');
        $lccr = $this->input->post('q');
        $sql = "SELECT a.* FROM trhtrmpot_blud a 
				WHERE a.kd_skpd = '$kd_skpd'  AND a.status='0'
				AND upper(a.no_bukti) like upper('%$lccr%')";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,
                        'no_bukti' => $resulte['no_bukti'],
                        'tgl_bukti' => $resulte['tgl_bukti'], 
                        'ket' => $resulte['ket'],
                        'no_sp2d' => $resulte['no_sp2d'],
                        'npwp' => $resulte['npwp'],
                        'jns_spp' => $resulte['jns_spp'],
                        'kd_giat' => $resulte['kd_kegiatan'],
                        'nm_giat' => $resulte['nm_kegiatan'],
                        'kd_rek' => $resulte['kd_rek5'],
                        'nm_rek' => $resulte['nm_rek5'],
                        'alamat' => $resulte['alamat'],
                        'rekanan' => $resulte['nmrekan'],
                        'dir' => $resulte['pimpinan'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	 $query1->free_result();   
	}
	
    function trmpot__() {
		$kd_skpd = $this->session->userdata('kdskpd');
        $lccr = $this->input->post('q');
        $sql = "SELECT a.*, b.kd_rek_blud, b.nm_rek_blud FROM trhtrmpot_blud a LEFT JOIN (select x.no_bukti, x.kd_skpd, x.kd_rek_blud, z.nm_rek5 as nm_rek_blud from trdtrmpot_blud x LEFT JOIN ms_rek5_blud z on x.kd_rek_blud=z.kd_rek5 group by x.no_bukti, x.kd_skpd, x.kd_rek_blud, z.nm_rek5) b
on a.kd_skpd=b.kd_skpd and a.no_bukti=b.no_bukti 
				WHERE a.kd_skpd = '$kd_skpd'  AND a.status='0'
				AND upper(a.no_bukti) like upper('%$lccr%')";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,
                        'no_bukti' => $resulte['no_bukti'],
                        'tgl_bukti' => $resulte['tgl_bukti'], 
                        'ket' => $resulte['ket'],
                        'no_sp2d' => $resulte['no_sp2d'],
                        'npwp' => $resulte['npwp'],
                        'jns_spp' => $resulte['jns_spp'],
                        'kd_giat' => $resulte['kd_kegiatan'],
                        'nm_giat' => $resulte['nm_kegiatan'],
                        'kd_rek' => $resulte['kd_rek5'],
                        'nm_rek' => $resulte['nm_rek5'],
                        'alamat' => $resulte['alamat'],
                        'rekanan' => $resulte['nmrekan'],
                        'dir' => $resulte['pimpinan'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd'],
                        'kd_rek_blud' => $resulte['kd_rek_blud'],
                        'nm_rek_blud' => $resulte['nm_rek_blud'],
                        'no_bukti_trans' => $resulte['no_bukti_trans']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	 $query1->free_result();   
	} 
    
	function pot() {
        $kd_skpd     = $this->session->userdata('kdskpd');
        $spm=$this->input->post('spm');
        $sql = "SELECT * FROM trspmpot_blud where no_spm='$spm' AND kd_skpd='$kd_skpd' order by kd_rek5 ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'kd_trans' => $resulte['kd_trans'],  
                        'nm_rek5' => $resulte['nm_rek5'],  
                        'pot' => $resulte['pot'],
                        'nilai' => $resulte['nilai']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	 //$query1->free_result();   
	}
    
    function pot_in() {
        $kd_skpd     = $this->session->userdata('kdskpd');
        $bukti=$this->input->post('bukti');
        $sql = "SELECT * FROM trdtrmpot_blud where no_bukti='$bukti' AND kd_skpd='$kd_skpd'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],
                        'nilai' => $resulte['nilai'],
						'ntpn' => $resulte['ntpn']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	 //$query1->free_result();   
	}
	
	
	function load_pot_out() {
       $kd_skpd     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                             
            $where="AND (upper(no_bukti) like upper('%$kriteria%') or tgl_bukti like '%$kriteria%') ";            
        }
        $sql = "SELECT count(*) as total from trhstrpot_blud where kd_skpd='$kd_skpd' $where " ;
        //$sql = "SELECT count(*) as total from trhtransout_blud a where a.kd_skpd='$kd_skpd' and a.jns_spp in ('1','2','3') $where " ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
       	$result["total"] = $total->total; 
        $query1->free_result();
  
        $sql = "SELECT top $rows no_bukti,no_ntpn,tgl_bukti,no_terima,kd_skpd,no_sp2d,RTRIM(jns_spp) as jns_spp,
				nm_skpd,nm_kegiatan,kd_kegiatan,nmrekan,pimpinan, alamat,npwp,ket,nilai
		from trhstrpot_blud where kd_skpd='$kd_skpd' $where AND no_bukti not in (SELECT top $offset no_bukti FROM trhstrpot_blud where kd_skpd='$kd_skpd' $where order by no_bukti)  order by no_bukti,kd_skpd";
        $query1 = $this->db->query($sql);  
        //$result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'no_bukti' => $resulte['no_bukti'],
                        'no_ntpn' => $resulte['no_ntpn'],
                        'tgl_bukti' => $resulte['tgl_bukti'],
                        'no_terima' => $resulte['no_terima'],
                        'kd_skpd' => $resulte['kd_skpd'],
                        'no_sp2d' => $resulte['no_sp2d'],
                        'jns_spp' => $resulte['jns_spp'],
                        'nm_skpd' => $resulte['nm_skpd'],        
                        'nm_kegiatan' => $resulte['nm_kegiatan'],        
                        'kd_kegiatan' => $resulte['kd_kegiatan'],        
                        'nmrekan' => $resulte['nmrekan'],        
                        'pimpinan' => $resulte['pimpinan'],        
                        'alamat' => $resulte['alamat'],        
                        'ket' => $resulte['ket'],                       
                        'nilai' => $resulte['nilai'],
                        'npwp' => $resulte['npwp']
						                                                                           
                        );
                        $ii++;
        }
           
        $result["rows"] = $row; 
        echo json_encode($result);
        $query1->free_result();   
	} 
     
	 function tambah_strpot(){
		$no_terima= $this->input->post('no_terima');                         
		$no_bku= $this->input->post('no_bku');                         
		$rek= $this->input->post('rek');                         
		$skpd= $this->input->post('skpd');                         
		$ntpn= $this->input->post('ntpn');                         
			$query3 ="UPDATE trdtrmpot_blud set ntpn='$ntpn' where no_bukti='$no_terima' and kd_skpd='$skpd' and kd_rek5='$rek'";
                    $asg3 = $this->db->query($query3);	
					
          echo '1';
          
	}	
    
	function edit_strpot()	{
		$no_terima= $this->input->post('no_terima');       
		$no_bukti= $this->input->post('no_bukti');                         
		$no_bku= $this->input->post('no_bku');                         
		$rek= $this->input->post('rek');                         
		$skpd= $this->input->post('skpd');                         
		$ntpn= $this->input->post('ntpn');                         
			$query3 ="UPDATE trdstrpot_blud set ntpn='$ntpn' where no_bukti='$no_bukti' and kd_skpd='$skpd' and kd_rek5='$rek'";
                    $asg3 = $this->db->query($query3);	
			$query3 ="UPDATE trdtrmpot_blud set ntpn='$ntpn' where no_bukti='$no_terima' and kd_skpd='$skpd' and kd_rek5='$rek'";
                    $asg3 = $this->db->query($query3);	
          echo '1';
          
	}	
    
	function simpan_strpot(){
		$no_bukti = $this->input->post('no_bukti');
		$no_ntpn = $this->input->post('no_ntpn');
		$tgl_bukti = $this->input->post('tgl_bukti');
		$no_terima = $this->input->post('no_terima');
		$ket = $this->input->post('ket');
		$kd_skpd = $this->input->post('kd_skpd');
		$nm_skpd = $this->input->post('nm_skpd');
		$npwp = $this->input->post('npwp');
		$nilai= $this->input->post('nilai');                         
		$kd_giat= $this->input->post('kd_giat');                         
		$nm_giat= $this->input->post('nm_giat');                         
		$kd_rek= $this->input->post('kd_rek');                         
		$nm_rek= $this->input->post('nm_rek');                         
		$rekanan= $this->input->post('rekanan');                         
		$dir= $this->input->post('dir');                         
		$alamat= $this->input->post('alamat');                         
		$usernm= $this->session->userdata('pcNama');
		//date_default_timezone_set('Asia/Bangkok');
		//$last_update=  date('d-m-y H:i:s');
                       
                        
           $sql = "delete from trhstrpot_blud where no_bukti='$no_bukti' AND kd_skpd='$kd_skpd' ";
           $asg = $this->db->query($sql);       
           $query2 ="insert into trhstrpot_blud(no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,no_terima,npwp,jns_spp,nilai,no_sp2d,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nmrekan,pimpinan,alamat,no_ntpn) 
                    values('$no_bukti','$tgl_bukti','$ket','$usernm','','$kd_skpd','$nm_skpd','$no_terima','$npwp','','$nilai','','$kd_giat','$nm_giat','$kd_rek','$nm_rek','$rekanan','$dir','$alamat','$no_ntpn') ";
                    $asg2 = $this->db->query($query2);    

			$query3 ="UPDATE trhtrmpot_blud SET status = '1' WHERE no_bukti = '$no_terima' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);	
			
			$query3 ="DELETE FROM trdstrpot_blud WHERE no_bukti = '$no_bukti' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);

			$query3 ="INSERT INTO trdstrpot_blud (no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,ntpn) 
						SELECT $no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,ntpn FROM trdtrmpot_blud WHERE no_bukti = '$no_terima' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);	
				
          echo '1';
          //$asg->free_result();
//          $query1->free_result();  
	}
	
	function simpan_strpot_edit(){
		$no_bku = $this->input->post('no_bku');
		$no_ntpn = $this->input->post('no_ntpn');
		$trmpot_lama = $this->input->post('trmpot_lama');
		$no_bukti = $this->input->post('no_bukti');
		$tgl_bukti = $this->input->post('tgl_bukti');
		$no_terima = $this->input->post('no_terima');
		$ket = $this->input->post('ket');
		$kd_skpd = $this->input->post('kd_skpd');
		$nm_skpd = $this->input->post('nm_skpd');
		$npwp = $this->input->post('npwp');
		$nilai= $this->input->post('nilai');                         
		$kd_giat= $this->input->post('kd_giat');                         
		$nm_giat= $this->input->post('nm_giat');                         
		$kd_rek= $this->input->post('kd_rek');                         
		$nm_rek= $this->input->post('nm_rek');                         
		$rekanan= $this->input->post('rekanan');                         
		$dir= $this->input->post('dir');                         
		$alamat= $this->input->post('alamat');                         
		$usernm= $this->session->userdata('pcNama');
                       
                        
           $sql = "delete from trhstrpot_blud where no_bukti='$no_bku' AND kd_skpd='$kd_skpd' ";
           $asg = $this->db->query($sql);       
           $query2 ="insert into trhstrpot_blud(no_bukti,tgl_bukti,ket,username,tgl_update,kd_skpd,nm_skpd,no_terima,npwp,jns_spp,nilai,no_sp2d,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nmrekan,pimpinan,alamat,no_ntpn) 
                    values('$no_bukti','$tgl_bukti','$ket','$usernm','','$kd_skpd','$nm_skpd','$no_terima','$npwp','','$nilai','','$kd_giat','$nm_giat','$kd_rek','$nm_rek','$rekanan','$dir','$alamat','$no_ntpn') ";
                    $asg2 = $this->db->query($query2);    
			
			$query3 ="UPDATE trhtrmpot_blud SET status = '0' WHERE no_bukti = '$trmpot_lama' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);
			
			$query3 ="UPDATE trhtrmpot_blud SET status = '1' WHERE no_bukti = '$no_terima' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);	
			
			$query3 ="DELETE FROM trdstrpot_blud WHERE no_bukti = '$no_bku' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);

			$query3 ="INSERT INTO trdstrpot_blud (no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,ntpn) 
						SELECT $no_bukti,kd_rek5,nm_rek5,nilai,kd_skpd,kd_rek_trans,ntpn FROM trdtrmpot_blud WHERE no_bukti = '$no_terima' AND kd_skpd='$kd_skpd' ";
                    $asg3 = $this->db->query($query3);	
				
          echo '1';
	}
	
	function pot_setor() {
       $kd_skpd     = $this->session->userdata('kdskpd');
        $bukti=$this->input->post('bukti');
        $sql = "SELECT * FROM trdstrpot_blud where no_bukti='$bukti' AND kd_skpd='$kd_skpd'";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],  
                        'nm_rek5' => $resulte['nm_rek5'],
                        'nilai' => $resulte['nilai'],
                        'ntpn' => $resulte['ntpn']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
	}
     
	 function load_str_pot(){
		$skpd = $this->session->userdata('kdskpd');
		$bukti = $this->input->post('bukti');
        $query1 = $this->db->query("select sum(nilai) as rektotal from trdstrpot_blud where no_bukti='$bukti' AND kd_skpd='$skpd'");  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'rektotal' => number_format($resulte['rektotal'],"2",",","."),
                        'rektotal1' => $resulte['rektotal']                       
                        );
                        $ii++;
        }
		   echo json_encode($result);
           $query1->free_result();	
	}
	
	
	
	function hapus_strpot() {    	
		$nom = $this->input->post('no'); 
		$no_terima = $this->input->post('no_terima'); 
		$kd_skpd  = $this->session->userdata('kdskpd');
		$msg = array();
		$sql = "delete from trdstrpot_blud where no_bukti='$nom' AND kd_skpd='$kd_skpd'";
        $asg = $this->db->query($sql);
		$sql = "delete from trhstrpot_blud where no_bukti='$nom' AND kd_skpd='$kd_skpd'";
        $asg = $this->db->query($sql);
		$query3 ="UPDATE trhtrmpot_blud SET status = '0' WHERE no_bukti = '$no_terima' AND kd_skpd='$kd_skpd'";
                    $asg3 = $this->db->query($query3);
        $msg = array('pesan'=>'1');
        echo json_encode($msg);	
	}		
    
	function no_urut(){
    $kd_skpd = $this->session->userdata('kdskpd'); 
	$query1 = $this->db->query("select case when max(nomor+1) is null then 1 else max(nomor+1) end as nomor from (
	select no_bukti nomor,'Setor Uang Penerimaan' ket,kd_skpd from tr_setorsimpanan_blud where isnumeric(no_kas)=1  union ALL
	select no_bukti+1 nomor,'Setor Simpanan' ket,kd_skpd from tr_setorsimpanan_blud where isnumeric(no_kas)=1 and jenis=2 union ALL
	select no_bukti+1 nomor, 'Ambil Simpanan' ket,kd_skpd from tr_ambilsimpanan_blud where  isnumeric(no_bukti)=1 union ALL
	select no_bukti nomor,'koreksi pendapatan' ket,kd_skpd from trhinlain_blud where isnumeric(no_bukti)=1 union ALL
	select no_bukti nomor, 'Penerimaan Potongan' ket,kd_skpd from trhtrmpot_blud where  isnumeric(no_bukti)=1  union ALL
	select no_bukti nomor, 'Penyetoran Potongan' ket,kd_skpd from trhstrpot_blud where  isnumeric(no_bukti)=1 union ALL
	select no_bukti nomor, 'Pembayaran Transaksi' ket, kd_skpd from trhtransout_blud where  isnumeric(no_bukti)=1 UNION ALL
	select no_kas nomor, 'Pencairan SP2D' ket, kd_skpd from trhsp2d_blud where  isnumeric(no_kas)=1 AND status_sp2d='1' UNION ALL
	select count(no_sts) nomor, 'Pengembalian Transaksi' ket, kd_skpd from trhkasin_blud where jns_trans <> 4 and isnumeric(no_sts)=1  group by kd_skpd
	) z WHERE KD_SKPD = '$kd_skpd'");
	    $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'no_urut' => $resulte['nomor']
                        );
                        $ii++;
        }
        echo json_encode($result);
    	$query1->free_result();   
    }
	
	function list_no_terima() {
		$kd_skpd = $this->session->userdata('kdskpd');
		$lccr 	 = $this->input->post('q');
		$data	 = $this->M_Sts->list_no_terima($kd_skpd,$lccr);				
		echo json_encode($data);
	}
	
	function simpan_sts_pendapatan(){
        $tabel       = $this->input->post('tabel');
        $nomor       = $this->input->post('no');
        $tgl         = $this->input->post('tgl');
        $skpd        = $this->input->post('skpd');
        $ket         = $this->input->post('ket');
        $jnsrek      = $this->input->post('jnsrek');
        $giat        = $this->input->post('giat');
        $sp2d        = $this->input->post('sp2d');
        $pay        = $this->input->post('pay');
        $jns_cp        = $this->input->post('jns_cp');
        $total       = $this->input->post('total');
        $lckdrek     = $this->input->post('kdrek');
        $lnil_rek    = $this->input->post('nilai');
        $lcnilaidet  = $this->input->post('value_det');
		$no_terima   = $this->input->post('no_terima');  
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	 	 = $this->M_Sts->simpan_sts_pendapatan($tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$pay,$jns_cp,$total,$lckdrek,$lnil_rek,$lcnilaidet,$no_terima,$usernm,$last_update,$sp2d);				
		echo json_encode($data);
    }
	
	function simpan_setor_kas(){
        $tabel       = $this->input->post('tabel');
        $nomor       = $this->input->post('no');
        $tgl         = $this->input->post('tgl');
        $skpd        = $this->input->post('skpd');
        $ket         = $this->input->post('ket');
        $jnsrek      = $this->input->post('jnsrek');
        $giat        = $this->input->post('giat');
        $sp2d        = $this->input->post('sp2d');
        $pay        = $this->input->post('pay');
        $jns_cp        = $this->input->post('jns_cp');
        $total       = $this->input->post('total');
        $lckdrek     = $this->input->post('kdrek');
        $lnil_rek    = $this->input->post('nilai');
        $lcnilaidet  = $this->input->post('value_det');
		$no_terima   = $this->input->post('no_terima');  
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	 	 = $this->M_Sts->simpan_setor_kas($tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$pay,$jns_cp,$total,$lckdrek,$lnil_rek,$lcnilaidet,$no_terima,$usernm,$last_update,$sp2d);				
		echo json_encode($data);
    }
	
	
	function update_sts_pendapatan_ag(){
        $nohide      = $this->input->post('nohide');
        $tabel       = $this->input->post('tabel');
        $nomor       = $this->input->post('no');
        $tgl         = $this->input->post('tgl');
        $skpd        = $this->input->post('skpd');
        $ket         = $this->input->post('ket');
        $jnsrek      = $this->input->post('jnsrek');
        $giat        = $this->input->post('giat');
		$sp2d        = $this->input->post('sp2d');
        $pay        = $this->input->post('pay');
        $jns_cp        = $this->input->post('jns_cp');
        $total       = $this->input->post('total');
        $lckdrek     = $this->input->post('kdrek');
        $lnil_rek    = $this->input->post('nilai');
        $lcnilaidet  = $this->input->post('value_det');
		$no_terima   = $this->input->post('no_terima');  
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	 = $this->M_Sts->update_sts_pendapatan_ag($nohide,$tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$pay,$jns_cp,$total,$lckdrek,$lnil_rek,$lcnilaidet,$no_terima,$usernm,$last_update,$sp2d);				
		echo json_encode($data);
    }
	
	function ctk_trm_str($dcetak='',$dcetak2='',$skpd='', $jns='',$jnsctk,$spasi,$jns_ttd){
   	        $lcskpd2 = $skpd;
            if($jnsctk=='1'){
                $skpd = $skpd;
            }
            
           
			$csql11 = " select nm_skpd from ms_skpd_blud where left(kd_skpd,len('$skpd')) = '$skpd'"; 
            $rs1 = $this->db->query($csql11);
            $trh1 = $rs1->row();
            $lcskpd = strtoupper ($trh1->nm_skpd);
         
		 if($jns_ttd==1){
				 $tgl_ttd= $_REQUEST['tgl_ttd'];
				 $nippa = str_replace('123456789',' ',$_REQUEST['ttd']);		     
				 if($nippa==''){
							 $lcNmPA = '';
							 $lcNipPA = '';
							 $lcJabatanPA = '';
							 $lcPangkatPA = '';
					
				 }else{   		 
					 $csql="SELECT nip as nip,nama,jabatan,pangkat  FROM ms_ttd_blud WHERE nip = '$nippa' AND kd_skpd = '$lcskpd2' AND kode='PA'";
							 $hasil = $this->db->query($csql);
							 $trh2 = $hasil->row(); 
							 
							 $lcNmPA = $trh2->nama;
							 $lcNipPA = $trh2->nip;
							 $lcJabatanPA = $trh2->jabatan;
							 $lcPangkatPA = $trh2->pangkat;
				 }
				 $nipbp = str_replace('123456789',' ',$_REQUEST['ttd2']);		     
				 if($nipbp==''){
					 $lcNmBP = '';
					 $lcNipBP = '';
					 $lcPangkatBP = '';
					 $lcJabatanBP = '';		  
				 }else{
					 $csql="SELECT nip,nama,jabatan,pangkat FROM ms_ttd_blud WHERE nip = '$nipbp' AND kd_skpd = '$lcskpd2' AND kode='BP'";
					 $hasil3 = $this->db->query($csql);
					 $trh3 = $hasil3->row(); 	
					 $lcNmBP = $trh3->nama;
					 $lcNipBP = $trh3->nip;
					 $lcPangkatBP = $trh3->pangkat;
					 $lcJabatanBP = $trh3->jabatan;
				 }            
		 }

		 $prv = $this->db->query("SELECT provinsi,daerah from sclient_blud WHERE kd_skpd='$lcskpd2' ");
			$prvn = $prv->row();          
			$prov = $prvn->provinsi;         
			$daerah = $prvn->daerah;
            
            $cRet='';

			$cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
             <tr>
                <td align=\"center\" colspan=\"11\" style=\"font-size:14px;border: solid 1px white;\"><b>$lcskpd<br>BUKU PENERIMAAN DAN PENYETORAN <br> BENDAHARA PENERIMAAN</b></td>
            </tr>
           
            <tr>
                <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
                <td align=\"left\" colspan=\"6\" style=\"font-size:12px;border: solid 1px white;\"></td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"3\" style=\"border: solid 1px white;\">B L U D</td>
                <td align=\"left\" colspan=\"6\" style=\"border: solid 1px white;\">:&nbsp;$lcskpd</td>
            </tr>
            
            <tr>
                <td align=\"left\" colspan=\"3\" style=\"border: solid 1px white;border-bottom:solid 1px white;\">PERIODE</td>
                <td align=\"left\" colspan=\"8\" style=\"border: solid 1px white;border-bottom:solid 1px white;\">:&nbsp;".$this->tukd_model->tanggal_format_indonesia($dcetak)." S.D ".$this->tukd_model->tanggal_format_indonesia($dcetak2)."</td>
            </tr>
			</table>";
			
			$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"$spasi\">
            <thead>
			<tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\">NO</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"6\">Penerimaan</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\">Penyetoran</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\">Ket.</td>
            </tr>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Tgl</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">No Bukti</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Cara Pembayaran</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Kode Rekening</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Uraian</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Jumlah</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Tgl</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">No STS</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\">Jumlah</td>
            </tr>
            <tr>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\">1</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"8%\">2</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">3</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\">4</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"5%\">5</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"20%\">6</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">7</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"9%\">8</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">9</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\">10</td>
                <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"18%\">11</td>
            </tr>
			</thead>
           ";
					
              $sql1="select a.tgl_terima, a.no_terima, a.kd_rek_blud as kd_rek5, b.nm_rek5, a.nilai, c.tgl_sts, c.no_sts, c.rupiah as total, a.keterangan 
						from tr_terima_blud a LEFT JOIN ms_rek5_blud b on a.kd_rek_blud=b.kd_rek5
						LEFT JOIN 
						(select x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima, SUM(y.rupiah) as rupiah from trhkasin_blud x inner join trdkasin_blud y on x.no_sts=y.no_sts and x.kd_skpd=y.kd_skpd
						 group by x.tgl_sts, x.no_sts, x.kd_skpd, y.no_terima) c
						 on a.no_terima=c.no_terima and a.kd_skpd=c.kd_skpd
						 where a.kd_skpd='$skpd' AND a.tgl_terima BETWEEN '$dcetak' AND '$dcetak2'
						 order by a.tgl_terima, a.no_terima";
                         //echo "$sql1";
                 
                 $query = $this->db->query($sql1);
                 //$query = $this->skpd_model->getAllc();
                $lcno = 0;
                $lnnilai = 0;                                 
                $lntotal = 0;                                 
                foreach ($query->result() as $row)
                {   
                    $lcno = $lcno + 1;
                    $lnnilai = $lnnilai + $row->nilai;
                    $lntotal = $lntotal + $row->total;
                    $tgl=$row->tgl_terima;
                    $bukti=$row->no_terima;
                    $rek=$row->kd_rek5;                    
                    $uraian=$row->nm_rek5;
                    $nilai=number_format($row->nilai,"2",",",".");
                    $tgl_sts=$row->tgl_sts;
					$ket=$row->keterangan;
					if($tgl_sts==''){
						$tgl_sts='';
					} else{
						$tgl_sts=$this->tukd_model->tanggal_ind($tgl_sts);
					}
                    $nosts=$row->no_sts;
                    $total=number_format($row->total,"2",",","."); 
					
                     $cRet    .= " <tr><td align=\"center\" >$lcno</td>
                                        <td align=\"center\" >".$this->tukd_model->tanggal_ind($tgl)."</td>
                                        <td align=\"center\" >$bukti</td>
                                        <td align=\"center\" >Tunai</td>
                                        <td align=\"center\" >$rek</td>
                                        <td align=\"left\" >$uraian</td>
                                        <td align=\"right\" >$nilai</td>
                                        <td align=\"center\" >$tgl_sts</td>
                                        <td align=\"center\" >$nosts</td>
                                        <td align=\"right\" >$total</td>
                                        <td align=\"left\">$ket</td>
                                     </tr>
                                     ";
                }
			
			$cRet    .= " <tr><td colspan=\"6\" align=\"center\"><b>Jumlah</b></td>
								<td align=\"right\" ><b>".number_format($lnnilai,"2",",",".")."</b></td>
								<td align=\"center\" ></td>
								<td align=\"center\" ></td>
								<td align=\"right\" ><b>".number_format($lntotal,"2",",",".")."</b></td>
								<td align=\"left\" ></td>
							 </tr>
							 </table>";
			
			if($jns_ttd==1){				 
				$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
				<tr>
				<td align=\"center\" width=\"50%\">Mengetahui</td>
				<td align=\"center\" width=\"50%\">".$daerah.", ".$this->tanggal_format_indonesia($tgl_ttd)."</td>
				</tr>
				<tr>
				<td align=\"center\" width=\"50%\">$lcJabatanPA</td>
				<td align=\"center\" width=\"50%\">$lcJabatanBP</td>
				</tr>
				<tr>
				<td align=\"center\" width=\"50%\">&nbsp;</td>
				<td align=\"center\" width=\"50%\"></td>
				</tr>
				<tr>
				<td align=\"center\" width=\"50%\">&nbsp;</td>
				<td align=\"center\" width=\"50%\"></td>
				</tr>

				<tr>
						<td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"><b><u>$lcNmPA</u></b><br>$lcPangkatPA</td>
						<td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"><b><u>$lcNmBP</u></b><br>$lcPangkatBP</td>
					</tr>
					<tr>
						<td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\">NIP. $lcNipPA</td>
						 <td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\">NIP. $lcNipBP</td>
					</tr>
					</table>"
				;
			}
			
			$data['prev']= '';
			if ($jns==1){
			$this->_mpdf('',$cRet,10,10,10,'1',1,''); 
			} else{
				echo ("<title>Buku Penerimaan Penyetoran</title>");
				echo $cRet;
				}

	}
	
	function load_sts() {
		$kd_skpd  	= $this->session->userdata('kdskpd');
		$kriteria 	= $this->input->post('cari');
		$data	 	= $this->M_Sts->load_sts($kd_skpd,$kriteria);				
		echo json_encode($data);
	}
	
	function load_dsts() {    
        $lcskpd  	= $this->session->userdata('kdskpd');
        $kriteria 	= $this->input->post('no');
		$data	 	= $this->M_Sts->load_dsts($lcskpd,$kriteria);				
		echo json_encode($data);
	}
      
	function hapus_sts(){
		$kd_skpd= $this->session->userdata('kdskpd');
        $nomor 	= $this->input->post('no');
		$data	= $this->M_Sts->hapus_sts($kd_skpd,$nomor);				
		echo json_encode($data);
    }
	
	
	function ambil_rek_ag2() {
        $lccr = $this->input->post('q');
        $lckdskpd = $this->uri->segment(3);
		$data	= $this->M_Sts->ambil_rek_ag2($lccr,$lckdskpd);				
		echo json_encode($data);
	}
	
	
	function simpan_sts_pendapatan_tlalu(){
        $tabel       = $this->input->post('tabel');
        $nomor       = $this->input->post('no');
        $tgl         = $this->input->post('tgl');
        $skpd        = $this->input->post('skpd');
        $ket         = $this->input->post('ket');
        $jnsrek      = $this->input->post('jnsrek');
        $giat        = $this->input->post('giat');
        $total       = $this->input->post('total');
        $lcnilaidet  = $this->input->post('value_det');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data		 = $this->M_Sts->simpan_sts_pendapatan_tlalu($tabel,$nomor,$tgl,$skpd,$ket,$jnsrek,$giat,$total,$lcnilaidet,$usernm,$last_update);				
		echo json_encode($data);
    }
	
	function load_sts_tl() {
		$kd_skpd    = $this->session->userdata('kdskpd');
        $kriteria 	= $this->input->post('cari');
		$data		= $this->M_Sts->load_sts_tl($kd_skpd,$kriteria);				
		echo json_encode($data);
	}

	
	function load_dsts_lalu() {    
        $lcskpd  	= $this->session->userdata('kdskpd');
        $kriteria 	= $this->input->post('no');
		$data		= $this->M_Sts->load_dsts_lalu($lcskpd,$kriteria);
		echo json_encode($data);
	}
      
	  
	function update_sts_pendapatan_ag_tlalu(){
        $tabel       = $this->input->post('tabel');
        $nomor       = $this->input->post('no');
        $nohide      = $this->input->post('nohide');
        $tgl         = $this->input->post('tgl');
        $skpd        = $this->input->post('skpd');
        $ket         = $this->input->post('ket');
        $jnsrek      = $this->input->post('jnsrek');
		$giat        = $this->input->post('giat');
        $total       = $this->input->post('total');
        $lcnilaidet  = $this->input->post('value_det');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data		= $this->M_Sts->update_sts_pendapatan_ag_tlalu($tabel,$nomor,$nohide,$tgl,$skpd,$ket,$jnsrek,$giat,$total,$lcnilaidet,$usernm,$last_update);
        echo json_encode($data);
    }
	
	function load_rek_penagihan() {                      
        $jenis  = $this->input->post('jenis');
        $giat   = $this->input->post('giat');  
        $kode   = $this->input->post('kd');
        $nomor  = $this->input->post('no');
        $rek    = $this->input->post('rek');        
        $lccr   = $this->input->post('q');
        $data	= $this->M_Penagihan->load_rek_penagihan($jenis,$giat,$kode,$nomor,$rek,$lccr);
		echo json_encode($data);
	}
	
	function simpan_penagihan_ls(){
        $nomor       = $this->input->post('cno');
        $sts_tagih 	 = $this->input->post('cjenis_bayar');
        $tgl         = $this->input->post('ctgl');
        $skpd        = $this->input->post('cskpd');
		$nm_skpd   	 = $this->input->post('cnmskpd');
        $ket         = $this->input->post('cket');
        $jns      	 = $this->input->post('jns');
        $kontrak     = $this->input->post('kontrak');
        $cjenis      = $this->input->post('cjenis');
        $sql_detail  = $this->input->post('sql_detail');
        $ctotal      = $this->input->post('ctotal');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Penagihan->simpan_penagihan_ls($nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update);
		echo json_encode($data);
    }
	
	function update_penagihan_ls(){
        $no_hide       = $this->input->post('cnohide');
        $nomor       = $this->input->post('cno');
        $sts_tagih 	 = $this->input->post('cjenis_bayar');
        $tgl         = $this->input->post('ctgl');
        $skpd        = $this->input->post('cskpd');
		$nm_skpd   	 = $this->input->post('cnmskpd');
        $ket         = $this->input->post('cket');
        $jns      	 = $this->input->post('jns');
        $kontrak     = $this->input->post('kontrak');
        $cjenis      = $this->input->post('cjenis');
        $sql_detail  = $this->input->post('sql_detail');
        $ctotal      = $this->input->post('ctotal');
        $usernm      = $this->session->userdata('pcNama');
		$last_update = date('Y-m-d H:i:s');
		$data	= $this->M_Penagihan->update_penagihan_ls($no_hide,$nomor,$sts_tagih,$tgl,$skpd,$nm_skpd,$ket,$jns,$kontrak,$cjenis,$sql_detail,$ctotal,$usernm,$last_update);
		echo json_encode($data);
    }
	
	
	
	function load_dtagih(){        
        $nomor 	= $this->input->post('no');    
        $skpd 	= $this->input->post('skpd'); 
		$data	= $this->M_Penagihan->load_dtagih($nomor,$skpd);
		echo json_encode($data);
    }
	
	function load_tot_tagih(){
		$no 	= $this->input->post('no');
		$skpd 	= $this->input->post('skpd');
		$data	= $this->M_Penagihan->load_tot_tagih($no,$skpd);
		echo json_encode($data);
	}
    
	function kontrak() {                 
        $lccr 		= $this->input->post('q');
		$kd_skpd  	= $this->session->userdata('kdskpd');    
		$data		= $this->M_Penagihan->kontrak($lccr,$kd_skpd);
		echo json_encode($data);		
    }
	
	function config_bank(){
		$lccr   = $this->input->post('q');
        $sql    = "SELECT kode, nama FROM ms_bank_blud where upper(kode) like '%$lccr%' or upper(nama) like '%$lccr%' order by kode ";
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_bank' => $resulte['kode'],
                        'nama_bank' => $resulte['nama']                                                                                        
                        );
                        $ii++;
        }
		echo json_encode($result);
    	$query1->free_result();   
    }
    
	function perusahaan_ls() {                 
        $lccr = $this->input->post('q');
		$kd_skpd  = $this->session->userdata('kdskpd');        
        $sql = "SELECT TOP 5 rekanan, pimpinan, npwp,no_rek,a.kd_bank,b.nama FROM trhsp2d_blud a
				LEFT JOIN ms_bank_blud b ON a.kd_bank=b.kode
				WHERE jns_spp IN ('6','5') AND kd_skpd = '$kd_skpd'   
					AND UPPER(rekanan) LIKE UPPER('%$lccr%')
					GROUP BY rekanan, pimpinan, npwp, no_rek,a.kd_bank,b.nama";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {            
            $result[] = array(
                        'id' => $ii,        
                        'nmrekan' => $resulte['rekanan'],  
                        'pimpinan' => $resulte['pimpinan'],      
                        'npwp' => $resulte['npwp'],
                        'no_rek' => $resulte['no_rek'],
                        'bank' => $resulte['kd_bank'],
                        'nama_bank' => $resulte['nama'],
                        );
                        $ii++;
        }
        echo json_encode($result);
        $query1->free_result();
    }
	
    function _mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font='',$orientasi='',$hal='', $fonsize='') {
                

        ini_set("memory_limit","-1M");
        ini_set("MAX_EXECUTION_TIME","-1");
        $this->load->library('mpdf');
		//$this->mpdf->SetHeader('||Halaman {PAGENO} /{nb}');
        
        
        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 3;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = I;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
		$sa=1;
		$tes=0;
		if ($hal==''){
		$hal1=1;
		} 
		if($hal!==''){
		$hal1=$hal;
		}
		if ($fonsize==''){
		$size=12;
		}else{
		$size=$fonsize;
		} 
		
		$this->mpdf = new mPDF('utf-8', array(215,330),$size); //folio
							//$this->mpdf->useOddEven = 1;						

        $this->mpdf->AddPage($orientasi,'',$hal,'1','off',10,10,3,10);
		if ($hal==''){
			$this->mpdf->SetFooter("Printed on Simakda SKPD ||  ");
		}
		else{
			$this->mpdf->SetFooter("Printed on Simakda SKPD || Halaman {PAGENO}  ");
		}
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
		case  0:
        return  "-";
        break;
		
    }
    }
    
	
	
	function koreksi_pend(){
        $data['page_title']= 'INPUT KOREKSI PENDAPATAN';
        $this->template->set('title', 'INPUT KOREKSI PENDAPATAN');   
        $this->template->load('template','tukd/pendapatan/sts_koreksi',$data) ; 
    }
	
	function load_sp2d_sts_belanja_new($cskpd='') {
			$lccr = $this->input->post('q');
            $kode = $this->uri->segment(3);

			
			$sql = "SELECT a.no_sts,a.tgl_sts,a.total total from trhkasin_blud a left join trdkasin_blud b
                    on a.kd_skpd=b.kd_skpd and a.no_sts=b.no_sts
                    where a.kd_skpd='$kode' and a.jns_trans in ('4','2')
                    order by a.tgl_sts" ;
                    			
                
            //echo $sql;    
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'no_sts' => $resulte['no_sts'],
                            'tgl_sts' => $resulte['tgl_sts'],
							'total' => $resulte['total']
													
                            );
                            $ii++;
            }
               
            echo json_encode($result);
        	   
    	}
		
		function load_trskpd_sts_belanja_ag() {
            //$sp2d='';        
			//$sp2d = str_replace('123456789','/',$this->uri->segment(3));
			//$stsx = $this->uri->segment(3);
            $no_sx  = $this->input->post('no_sx');
        
            $lcskpd  = $this->uri->segment(3);
            //$lcskpd = $this->uri->segment(4);
            $sql = "select a.kd_kegiatan,a.tgl_sts,b.nm_kegiatan from trhkasin_blud a left join m_giat b on a.kd_kegiatan=b.kd_kegiatan
            where a.no_sts='$no_sx' and a.kd_skpd='$lcskpd' order by a.kd_kegiatan";    
            //echo $sql;    
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kd_kegiatan' => $resulte['kd_kegiatan'],  
                            'nm_kegiatan' => $resulte['nm_kegiatan'],
                            'tgl_sts' => $resulte['tgl_sts']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
        	   
    	}
	
	function simpan_sts_belanja(){
        
        $tabel   = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid     = $this->input->post('cid');
        //$lcid    = $this->input->post('lcid');
        //$lcnotagih = $this->input->post('tagih');
        $skpd  = $this->session->userdata('kdskpd');
        

        
        
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            
               if (!($asg)){
                      
						echo json_encode('0');
					}  else {
                      
						echo json_encode('2');
					}

        
       
    }
	
	
	function load_sts_koreksi() {    
       
		$kriteria = $this->input->post('no');
        $sql = "SELECT a.no_bukti,a.kd_skpd,a.pay,a.tgl_bukti,a.ket,a.no_sts,a.nilai,a.tgl_trans,b.total as nil_awal
				from trhinlain_blud a left join trhkasin_blud b on a.no_sts=b.no_sts";
       
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'no_bukti' => $resulte['no_bukti'],
                        'tgl_bukti' => $resulte['tgl_bukti'],
						'tgl_trans' => $resulte['tgl_trans'],
                        'ket' => $resulte['ket'],
                        'no_sts' => $resulte['no_sts'],
						'pay' => $resulte['pay'],
						'kd_skpd' => $resulte['kd_skpd'],
                        'nilai' =>  number_format($resulte['nilai'],2,'.',','),
						'nilai_ed' =>  $resulte['nilai'],
						'nilai_awal' =>  $resulte['nil_awal']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
         
  }
  
  
  function hapus_sts_pen(){
        $nomor = $this->input->post('cno_kas');
		$skpdx  = $this->input->post('cskpdx');
        
        
        
            $sql = "delete from trhinlain_blud where no_bukti='$nomor' and kd_skpd ='$skpdx'";
            $asg = $this->db->query($sql);
            
        
        echo '1';                
    }


	function lpj_tu()
    {
        $data['page_title']= 'INPUT LPJ TU';
        $this->template->set('title', 'INPUT LPJ TU');   
        $this->template->load('template','tukd/transaksi/tambah_lpj_tu',$data) ; 
    }
	
	
			function load_lpj_tu() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$kd_skpd  = $this->session->userdata('kdskpd');
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = " ";
        if ($kriteria <> ''){                               
            $where=" and (upper(no_lpj) like upper('%$kriteria%') or tgl_lpj like '%$kriteria%' or upper(kd_skpd) like 
                    upper('%$kriteria%')) ";            
        }

		$sql = "SELECT count(*) as tot from trhlpj_blud WHERE  kd_skpd = '$kd_skpd' AND jenis = '3' $where ";
        $query1 = $this->db->query($sql);
        $total = $query1->row();
                
      	$sql = "SELECT TOP $rows kd_skpd,keterangan,no_lpj,tgl_lpj,ISNULL(status,0) as status, tgl_awal,no_sp2d,(SELECT a.nm_skpd FROM ms_skpd_blud a where a.kd_skpd = '$kd_skpd') as nm_skpd FROM trhlpj_blud WHERE kd_skpd = '$kd_skpd' AND jenis = '3' $where 
				AND no_lpj NOT IN (SELECT TOP $offset no_lpj FROM trhlpj_blud WHERE kd_skpd = '$kd_skpd' AND jenis = '3' $where ORDER BY tgl_lpj,no_lpj) ORDER BY tgl_lpj,no_lpj";
		
        $query1 = $this->db->query($sql);  
        $result = array();
        $row = array();        
        $ii = 0;
		
        foreach($query1->result_array() as $resulte){ 
            $row[] = array(
                        'id' 	  => $ii,
						'kd_skpd' => $resulte['kd_skpd'],      
						'nm_skpd' => $resulte['nm_skpd'],                          
                        'ket'     => $resulte['keterangan'],
                        'no_lpj'  => $resulte['no_lpj'],
                        'tgl_lpj' => $resulte['tgl_lpj'],
                        'status'  => $resulte['status'],
                        'tgl_sp2d'=> $resulte['tgl_awal'],
                        'sp2d'    => $resulte['no_sp2d']
                        );
                        $ii++;
        }
           
       $result["total"] = $total->tot;
        $result["rows"] = $row; 
        $query1->free_result();   
        echo json_encode($result);
	}

		function load_sp2d_lpj_tu() {
            
            $lcskpd  = $this->session->userdata('kdskpd');
            //$lcskpd = $this->uri->segment(4);
			
			$sql = "SELECT a.no_sp2d,a.tgl_sp2d,b.kd_skpd,b.nm_skpd FROM trhsp2d_blud a left join ms_skpd_blud b 
					on a.kd_skpd =b.kd_skpd
					WHERE
					a.jns_spp = '3' and a.status_sp2d='1'
					and a.kd_skpd = '$lcskpd' and a.no_sp2d NOT IN (SELECT ISNULL(no_sp2d,'') FROM trhlpj_blud)" ;
			
            //echo $sql;    
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'no_sp2d' => $resulte['no_sp2d'],
							'tgl_cair' => $resulte['tgl_sp2d'],
							'kd_skpd' => $resulte['kd_skpd'],
							'nm_skpd' => $resulte['nm_skpd']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
        	   
    	}


function load_data_transaksi_lpj_tu() {
        $kdskpd  = $this->session->userdata('kdskpd');	
         $cek = substr($kdskpd,8,2);
        if($cek=="00"){
           $hasil = "left(b.kd_skpd,7)=left('$kdskpd',7)"; 
        }else{
           $hasil = "b.kd_skpd='$kdskpd'"; 
        }
        $no_sp2d  = $this->input->post('no_sp2d');
        $sql    = "SELECT a.kd_kegiatan,a.nm_kegiatan,a.kd_rek5,a.nm_rek5,a.kd_rek_blud,a.nm_rek_blud,a.nilai, a.no_bukti,a.kd_skpd as kd_skpd1 FROM trdtransout_blud a inner join trhtransout_blud b on 
                   a.no_bukti=b.no_bukti and a.kd_skpd = b.kd_skpd WHERE (a.no_bukti+a.kd_kegiatan+a.kd_rek5) NOT IN(SELECT (no_bukti+kd_kegiatan+kd_rek5) FROM trlpj_blud) AND a.no_sp2d = '$no_sp2d' and $hasil 
                   ORDER BY a.no_bukti, a.kd_kegiatan, a.kd_rek5"; 
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'idx' => $ii,
                        'kd_bp_skpd'   => $resulte['kd_skpd1'],
                        'kdkegiatan' => $resulte['kd_kegiatan'],
                        'nmkegiatan' => $resulte['nm_kegiatan'],       
                        'kdrek5'     => $resulte['kd_rek5'], 
						'kdrek5blud' => $resulte['kd_rek_blud'],						
                        'nmrek5'     => $resulte['nm_rek5'], 
						'nmrek5blud' => $resulte['nm_rek_blud'],  						
                        'nilai1'     => number_format($resulte['nilai']),
                        'no_bukti'   => $resulte['no_bukti']
                        );
                        $ii++;
        }
           echo json_encode($result);
           $query1->free_result();
    }

	
	
	function simpan_lpj_tu_update(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$no_simpan = $this->input->post('no_simpan');
		$csql     = $this->input->post('sql');            
  		
		$sql = "delete from trlpj_blud where no_lpj='$no_simpan' AND kd_skpd='$kdskpd'";
                $asg = $this->db->query($sql);
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "INSERT INTO trlpj_blud (no_lpj,no_bukti,tgl_lpj,kd_kegiatan,keterangan,kd_rek5,nm_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd,kd_bp_skpd)"; 
                    $asg = $this->db->query($sql.$csql);
					
					
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
        
    	
            }
			
	function update_hlpj_tu(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$no_simpan = $this->input->post('no_simpan');
		$ntgllpj = $this->input->post('tgllpj');
		$tgl_sp2d = $this->input->post('tgl_sp2d');
		$sp2d = $this->input->post('sp2d');
		$cket = $this->input->post('ket');
        $csql = "delete from trhlpj_blud where no_lpj= '$no_simpan' AND kd_skpd='$kdskpd' ";
    	$query1 = $this->db->query($csql);
    	$csql = "INSERT INTO trhlpj_blud (no_lpj,kd_skpd,keterangan,tgl_lpj,status,tgl_awal,no_sp2d,jenis) values ('$nlpj','$kdskpd','$cket','$ntgllpj','0','$tgl_sp2d','$sp2d','3')";
    	$query1 = $this->db->query($csql);
    					
                if($query1){
                    echo '2';
                }else{
                    echo '0';
                }
            }

	function simpan_lpj_tu_blud(){
	  
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$csql     = $this->input->post('sql');            
  		
		$sql = "delete from trlpj_blud where no_lpj='$nlpj' AND kd_skpd='$kdskpd'";
                $asg = $this->db->query($sql);
				if (!($asg)){
                    $msg = array('pesan'=>'0');
                    echo json_encode($msg);
                    exit();
                }else{            
                    $sql = "INSERT INTO trlpj_blud (no_lpj,no_bukti,tgl_lpj,kd_kegiatan,keterangan,kd_rek5,nm_rek5,kd_rek_blud,nm_rek_blud,nilai,kd_skpd)"; 
                    $asg = $this->db->query($sql.$csql);
					
					
					if (!($asg)){
                       $msg = array('pesan'=>'0');
                        echo json_encode($msg);
                     //   exit();
                    }  else {
                       $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }
                }
            }
	
	
	function simpan_hlpj_tu(){
		$kdskpd  = $this->session->userdata('kdskpd');	
		$nlpj = $this->input->post('nlpj');
		$ntgllpj = $this->input->post('tgllpj');
		$tgl_sp2d = $this->input->post('tgl_sp2d');
		$sp2d = $this->input->post('sp2d');
		$cket = $this->input->post('ket');
		
    	$csql = "INSERT INTO trhlpj_blud (no_lpj,kd_skpd,keterangan,tgl_lpj,status,tgl_awal,no_sp2d,jenis) values ('$nlpj','$kdskpd','$cket','$ntgllpj','0','$tgl_sp2d','$sp2d','3')";
    	$query1 = $this->db->query($csql);
    					
                if($query1){
                    echo '2';
                }else{
                    echo '0';
                }
            }
			

	function ambil_rek_sts_silpa() {

        $lckdskpd = $this->uri->segment(3);

        $lc = '';

		
			$sql = "SELECT kd_rek5 as kd_rek_blud,nm_rek5 as nm_rek_blud,sum(nilai) nilai,sum(trans) transaksi,
sum(nilai)-sum(trans) as sisa
from(
select '1110302' kd_rek5,
'Kas di Bendahara Pengeluaran BLUD' nm_rek5,saldo_lalu as nilai,0 as trans from ms_skpd_blud
where kd_skpd ='$lckdskpd'
union
select a.kd_rek5,a.nm_rek5,0 as nilai, sum(a.nilai) as trans from trdtransout_blud a
join trhtransout_blud b on a.no_bukti=b.no_bukti and a.kd_skpd =b.kd_skpd
where b.jenis ='11' and a.kd_skpd ='$lckdskpd'
group by a.kd_rek5,a.nm_rek5
)x
group by kd_rek5,nm_rek5";

		  
       
        
        //echo $sql; upper(a.kd_rek5) like upper('%$lccr%') $lc
        
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek_blud'],  
                        'nm_rek5' => $resulte['nm_rek_blud'],                  
                        'nilai' => $resulte['nilai'] ,                 
                        'transaksi' => $resulte['transaksi'],                  
                        'sisa' => $resulte['sisa']                  
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
	
	
	
	function load_trskpd_baru() {
        $giat = $this->input->post ( 'giat' );
        $cskpd = $this->input->post ( 'kode' );
        $jns_beban = '';
        $cgiat = '';
        if ($giat != '') {
            $cgiat = " and a.kd_kegiatan not in ($giat)";
        }
        $lccr = $this->input->post ( 'q' );
        $sql = "SELECT a.kd_kegiatan,a.nm_kegiatan, SUM(nilai) as nilai, SUM(nilai_ubah) as nilai_ubah FROM trdrka_blud a
				where a.kd_skpd ='$cskpd'
				GROUP BY a.kd_kegiatan,a.nm_kegiatan
				ORDER BY a.kd_kegiatan,a.nm_kegiatan
		";
        $query1 = $this->db->query ( $sql );
        $result = array ();
        $ii = 0;
        foreach ( $query1->result_array () as $resulte ) {
            
            $result [] = array (
                    'id' => $ii,
                    'kd_kegiatan' => $resulte ['kd_kegiatan'],
                    'nm_kegiatan' => $resulte ['nm_kegiatan'],
                    'kd_program' => '',
                    'nm_program' => '',
                    'total' => $resulte ['nilai'] 
            );
            $ii ++;
        }
        
        echo json_encode ( $result );
        $query1->free_result ();
    }


    function rekap_pengeluaran(){
        $data['page_title']= 'REKAP PENGELUARAN';
        $this->template->set('title', 'REKAP PENGELUARAN');   
        $this->template->load('template','tukd/transaksi/rekap_pengeluaran',$data) ;   
    } 
    
    function rekappengeluaran($jns=''){
        
        $ctk='
             <table style="width:100%; border: 1px solid black; border-collapse:collapse;" cellspacing="0" cellpadding="4">';
        
        $ctk.='<tr style="border: 1px solid black; " align="center" cellpadding="4">
                    <td colspan="13" style="border: 1px solid black;" align="center"><h3>REKAP PENGELUARAN<br></h3></td>
              </tr>';
            
        $ctk.='<tr style="border: 1px solid black;" bgcolor="#CCCCCC" align="center" cellpadding="100">        
                    <td style="border: 1px solid black;" align="center"><b>Unit</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Januari</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Februari</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Maret</b></td>
                    <td style="border: 1px solid black;" align="center"><b>April</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Mei</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Juni</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Juli</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Agustus</b></td>
                    <td style="border: 1px solid black;" align="center"><b>September</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Oktober</b></td>
                    <td style="border: 1px solid black;" align="center"><b>November</b></td>
                    <td style="border: 1px solid black;" align="center"><b>Desember</b></td>
            </tr>';

        $sql="  SELECT h.kd_skpd, 
                isnull(sum(i.jan),0) jan, isnull(sum(i.feb),0) feb, isnull(sum(i.mar),0) mar,
                isnull(sum(i.apl),0) apl, isnull(sum(i.mei),0) mei, isnull(sum(i.jun),0) jun,
                isnull(sum(i.jul),0) jul, isnull(sum(i.ags),0) ags, isnull(sum(i.sep),0) sep,
                isnull(sum(i.okt),0) okt, isnull(sum(i.nov),0) nov, isnull(sum(i.des),0) des 
                from trhrka_blud h
                left join (  
                SELECT kd_skpd,
                case when bulan=1 then nilai end as jan, 
                case when bulan=2 then nilai end as feb, 
                case when bulan=3 then nilai end as mar, 
                case when bulan=4 then nilai end as apl, 
                case when bulan=5 then nilai end as mei, 
                case when bulan=6 then nilai end as jun, 
                case when bulan=7 then nilai end as jul, 
                case when bulan=8 then nilai end as ags, 
                case when bulan=9 then nilai end as sep, 
                case when bulan=10 then nilai end as okt,
                case when bulan=11 then nilai end as nov, 
                case when bulan=12 then nilai end as des  
                from (
                select month(a.tgl_bukti) bulan, b.kd_skpd,  sum(b.nilai) nilai from trdtransout_blud b
                inner join trhtransout_blud a on a.no_bukti=b.no_bukti and b.no_sp2d=a.no_sp2d  
                GROUP BY b.kd_skpd, month(a.tgl_bukti))oke )i
                on i.kd_skpd=h.kd_skpd  where i.kd_skpd !='1.02.01.00'
                GROUP BY h.kd_skpd";
        $query=$this->db->query($sql);
        foreach($query->result() as $a){

            $unit=$a->kd_skpd;
            $jan=number_format($a->jan,'2','.',','); 
            $feb=number_format($a->feb,'2','.',',');
            $mar=number_format($a->mar,'2','.',',');
            $apl=number_format($a->apl,'2','.',',');
            $mei=number_format($a->mei,'2','.',',');
            $jun=number_format($a->jun,'2','.',',');
            $jul=number_format($a->jul,'2','.',',');
            $ags=number_format($a->ags,'2','.',',');
            $sep=number_format($a->sep,'2','.',',');
            $okt=number_format($a->okt,'2','.',',');
            $nov=number_format($a->nov,'2','.',',');
            $des=number_format($a->des,'2','.',',');

            $ctk.='<tr style="border: 1px solid black;" align="right">        
                        <td style="border: 1px solid black;" align="center">'.$unit.'</td>
                        <td style="border: 1px solid black;" align="right">'.$jan.'</td>
                        <td style="border: 1px solid black;" align="right">'.$feb.'</td>
                        <td style="border: 1px solid black;" align="right">'.$mar.'</td>
                        <td style="border: 1px solid black;" align="right">'.$apl.'</td>
                        <td style="border: 1px solid black;" align="right">'.$mei.'</td>
                        <td style="border: 1px solid black;" align="right">'.$jun.'</td>
                        <td style="border: 1px solid black;" align="right">'.$jul.'</td>
                        <td style="border: 1px solid black;" align="right">'.$ags.'</td>
                        <td style="border: 1px solid black;" align="right">'.$sep.'</td>
                        <td style="border: 1px solid black;" align="right">'.$okt.'</td>
                        <td style="border: 1px solid black;" align="right">'.$nov.'</td>
                        <td style="border: 1px solid black;" align="right">'.$des.'</td>
                </tr>';
        } //endforeach


        $ctk.='</table>';
        if($jns==1){
            echo "$ctk";
        }else if($jns==2){
            $this->tukd_model->_mpdf('',$ctk,10,10,10,'1');
        } else {
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= Rekap_Pengeluaran.xls");
            echo $ctk;
        }
         
    }
    
	
}