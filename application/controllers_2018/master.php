<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Master extends CI_Controller {

	function __construct(){	
		parent::__construct();
	}
    
    function test(){
    $this->load->dbutil();
    $query = $this->db->query("SELECT * FROM ms_bank_blud");
    $config = array (
                  'root'    => 'root',
                  'element' => 'element',
                  'newline' => "\n",
                  'tab'     => "\t"
                );
    echo $this->dbutil->xml_from_result($query, $config); 
    }
    
    function fungsi(){	
	 $this->index('0','ms_fungsi_blud','kd_fungsi','nm_fungsi','Fungsi','fungsi','');
	}
    
    function urusan(){	
	 $this->index('0','ms_urusan_blud','kd_urusan','nm_urusan','Urusan','urusan','');
	}
    
    function skpd(){	
	 $this->index('0','ms_skpd_blud','kd_skpd','nm_skpd','SKPD','skpd','');
	}
    
    function unit()
	{	
	 $this->index('0','ms_unit_blud','kd_unit','nm_unit','Unit Kerja','unit','');
	}
    
    function program()
	{	
	 $this->index('0','m_prog_blud','kd_program','nm_prog_bludram','Program','program','');
	}
    
    function kegiatan()
	{	
	 $this->index('0','m_giat_blud','kd_kegiatan','nm_kegiatan','Kegiatan','kegiatan','');
	}
//------------------------ rekening 1 Andika --------------------------------
    function rekening1()
    {
        $data['page_title']= 'Master Rekening 1 BLUD';
        $this->template->set('title', 'Master Rekening 1 BLUD');   
        $this->template->load('template','master/rek1_blud/mrek1_blud',$data) ; 
    }
    function load_rekening1_blud() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek1) like upper('%$kriteria%') or kd_rek1 like'%$kriteria%')";            
        }
        $sql = "SELECT * from ms_rek1_blud $where order by kd_rek1";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek1' => $resulte['kd_rek1'],
                        'nm_rek1' => $resulte['nm_rek1']                                                                                        
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
    
	function tambah_rek1_blud()
    {
        $config = array(
               array(
                     'field'   => 'kd_rek1',
                     'label'   => 'Kode Rekening 1',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek1',
                     'label'   => 'Nama Rekening 1',
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');
        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening 1 &raquo; Tambah";
        }
        else
        {                
            $data = array(
                        'kd_rek1' => $this->input->post('kd_rek1'),
                        'nm_rek1' => $this->input->post('nm_rek1'),
                        );
            $this->master_model->save('ms_rek1_blud',$data);
            $this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
            redirect('master/rek1_blud');
        }
        $this->template->set('title', 'Master Data rekening 1 &raquo; Tambah Data');
        $this->template->load('template', 'master/rek1_blud/tambah', $data);
    }
    
    // Ubah data
    function edit_rek1_blud()
    {
        $id = $this->uri->segment(3);
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek1_blud','kd_rek1',$id)->num_rows() <= 0 ) ) :
            redirect('master/rek1_blud');
        endif;
        $config = array(
               array(
                     'field'   => 'kd_rek1',
                     'label'   => 'Kode Rekening 1',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek1',
                     'label'   => 'Nama Rekening 1',
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');
        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening akun &raquo; Ubah Data";
            $data['rek1'] = $this->master_model->get_by_id('ms_rek1_blud','kd_rek1',$id)->row();
        }
        else
        {            
            $data = array(
                        'kd_rek1' => $this->input->post('kd_rek1'),
                        'nm_rek1' => $this->input->post('nm_rek1'),
                        );
            $this->master_model->update('ms_rek1_blud','kd_rek1',$id, $data);
            $this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
            redirect('master/rek1_blud');
        }
        $this->template->set('title', 'Master Data Rekening Akun  &raquo; Ubah Data');
        $this->template->load('template', 'master/rek1_blud/edit', $data);
    }
    
    // hapus data
    function hapus_rek1_blud()
    {
        $id = $this->uri->segment(3);
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek1_blud','kd_rek1',$id)->num_rows() <= 0 ) ) :
            redirect('master/rek1_blud');
        else:    
            $this->master_model->delete('ms_rek1_blud','kd_rek1',$id);
            $this->session->set_flashdata('notify', 'Data berhasil dihapus !');
            redirect('master/rek1_blud');
        endif;
    }

    function ambil_akun(){
        // $lccr = $this->input->post('q');
        // $where = '';
        $sql = "SELECT kd_rek1,nm_rek1 FROM ms_rek1_blud ORDER BY kd_rek1";
        $query1 = $this->db->query($sql);
        $result = array();
        $ii = 0;

        foreach($query1->result_array() as $resulte){
            $result[] = array(
                'id' => $ii,
                'kd_rek1' => $resulte['kd_rek1'],
                'nm_rek1' => $resulte['nm_rek1']
                );
            $ii++;
        }
        echo json_encode($result);
    }

    function urut_rek(){
        $hasil = array();
        $urut  = '0';               
        $i     = 0;

        $cjns  = $this->input->post('jns');
        
                                

        $query1 = $this->db->query("SELECT MAX(kd_rek2) AS kd_rek2 FROM ms_rek2_blud WHERE kd_rek1 = '$cjns'");
            
        foreach($query1->result_array() as $resulte){    
            $i++;
    
            $urut     =$resulte['kd_rek2'];              
        }

        $n_urut  =($urut*1)+1;
    
        if ($n_urut>=10000){
            $n_urut='1';
        }

        // if (strlen($n_urut)==1) $n_urut='000'.$n_urut; 
        // if (strlen($n_urut)==1) $n_urut='00'.$n_urut; 
        if (strlen($n_urut)==1) $n_urut='0'.$n_urut; 
        if (strlen($n_urut)==2) $n_urut="$n_urut";      

        $hasil=array(
                    'urut' => $n_urut                   
                    );
        
        return $hasil;
        

    }
	
	function urut_id(){
        $hasil = array();
        $urut  = '0';               
        $i     = 0;

        $query1 = $this->db->query("SELECT MAX(id_urut) AS id_urut FROM ms_ttd_blud");
            
        foreach($query1->result_array() as $resulte){    
            $i++;
    
            $urut     =$resulte['id_urut'];              
        }

        $n_urut  =($urut*1)+1;
    
        if ($n_urut>=10000){
            $n_urut='1';
        }

        if (strlen($n_urut)==1) $n_urut='0'.$n_urut; 
        if (strlen($n_urut)==2) $n_urut="$n_urut";      

        $hasil=array(
                    'urut' => $n_urut                   
                    );
        
        return $hasil;
        

    }

    function urut_rekening(){
        $nodokx=$this->urut_rek();
        $nodokx =$nodokx['urut'];
        
        $nextnodoks=array( 'urut'=>$nodokx);
        
        echo json_encode($nextnodoks);
    }
	
	function urut_nomor(){
        $nodokx=$this->urut_id();
        $nodokx =$nodokx['urut'];
        
        $nextnodoks=array( 'urut'=>$nodokx);
        
        echo json_encode($nextnodoks);
    }

//------------------------ END rekening 1 Andika --------------------------------
//------------------------ rekening 2 Andika --------------------------------
     function rekening2()
    {
        $data['page_title']= 'Master Rekening 2 BLUD';
        $this->template->set('title', 'Master Rekening 2 BLUD');   
        $this->template->load('template','master/rek2_blud/mrek2_blud',$data) ; 
    }
    function load_rekening2_blud() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
		$kriteria = '';
        $kriteria = $this->input->post('cari');
        
		$where ='';
        $where1 ='';
        
		if ($kriteria <> ''){                               
            $where="AND (upper(nm_rek2) like upper('%$kriteria%') or kd_rek2 like'%$kriteria%')";            
            $where1="WHERE (upper(nm_rek2) like upper('%$kriteria%') or kd_rek2 like'%$kriteria%')";            
        }
        
		 $sql = "SELECT count(*) as tot from ms_rek2_blud $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		
		$sql = "SELECT TOP $rows * from ms_rek2_blud WHERE kd_rek2 NOT IN (SELECT TOP $offset kd_rek2 FROM ms_rek2_blud $where1 ORDER BY kd_rek2) $where order by kd_rek2";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        
		foreach($query1->result_array() as $resulte)
        { 
            $row[] = array(
                        'id' => $ii,        
                        'kd_rek1' => $resulte['kd_rek1'],
                        'kd_rek2' => $resulte['kd_rek2'],
                        'nm_rek2' => $resulte['nm_rek2']                                                                                        
                        );
                        $ii++;
        }
		
		$result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    }
    function tambah_rek2_blud()
    {
        $config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening 2',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek2',
                     'label'   => 'Nama Rekening 2',
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');
        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening 1 &raquo; Tambah";
        }
        else
        {            
            $data = array(
                        'kd_rek2' => $this->input->post('kd_rek2'),
                        'nm_rek2' => $this->input->post('nm_rek2'),
                        );
            $this->master_model->save('ms_rek2_blud',$data);
            $this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
            redirect('master/rek2_blud');
        }
        $this->template->set('title', 'Master Data rekening 2 &raquo; Tambah Data');
        $this->template->load('template', 'master/rek2_blud/tambah', $data);
    }

    function edit_rek2_blud()
    {
        $id = $this->uri->segment(3);
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek2_blud','kd_rek2',$id)->num_rows() <= 0 ) ) :
            redirect('master/rek2_blud');
        endif;
        $config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening 2',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek2',
                     'label'   => 'Nama Rekening 2',
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');
        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening akun &raquo; Ubah Data";
            $data['rek2'] = $this->master_model->get_by_id('ms_rek2_blud','kd_rek2',$id)->row();
        }
        else
        {     
            $data = array(
                        'kd_rek2' => $this->input->post('kd_rek2'),
                        'nm_rek2' => $this->input->post('nm_rek2'),
                        );
            $this->master_model->update('ms_rek2_blud','kd_rek2',$id, $data);
            $this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
            redirect('master/rek2_blud');
        }
        $this->template->set('title', 'Master Data Rekening Akun  &raquo; Ubah Data');
        $this->template->load('template', 'master/rek2_blud/edit', $data);
    }
    
    // hapus data
    function hapus_rek2_blud()
    {
        $id = $this->uri->segment(3);
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek2_blud','kd_rek2',$id)->num_rows() <= 0 ) ) :
            redirect('master/rek2_blud');
        else:
            $this->master_model->delete('ms_rek2_blud','kd_rek2',$id);
            $this->session->set_flashdata('notify', 'Data berhasil dihapus !');
            redirect('master/rek2_blud');
        endif;
    }
//------------------------ END rekening 2 Andika --------------------------------
//------------------------ rekening 3 Andika --------------------------------
    function rekening3(){
        $data['page_title']= 'Master Rekening 3 BLUD';
        $this->template->set('title', 'Master Rekening 3 BLUD');   
        $this->template->load('template','master/rek3_blud/mrek3_blud',$data) ; 
    }
    function load_rekening3_blud() {
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
		$where1 ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(nm_rek3) like upper('%$kriteria%') or kd_rek3 like'%$kriteria%')";            
            $where1="WHERE (upper(nm_rek3) like upper('%$kriteria%') or kd_rek3 like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek3_blud $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT TOP $rows * from ms_rek3_blud WHERE kd_rek3 NOT IN (SELECT TOP $offset kd_rek3 FROM ms_rek3_blud $where1 ORDER BY kd_rek3) $where order by kd_rek3";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek3' => $resulte['kd_rek3'], 
                        'kd_rek2' => $resulte['kd_rek2'],       
                        'nm_rek3' => $resulte['nm_rek3']                                                                       
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
           
    }
    function ambil_rekening2_blud() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek2, nm_rek2 FROM ms_rek2_blud where upper(kd_rek2) like upper('%$lccr%') or upper(nm_rek2) like upper('%$lccr%') ORDER BY kd_rek2";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek2' => $resulte['kd_rek2'],  
                        'nm_rek2' => $resulte['nm_rek2']
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
    function tambah_rek3_blud()
    {
        $config = array(
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening 3',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek3',
                     'label'   => 'Nama Rekening 3',
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');
        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening 3 &raquo; Tambah";
        }
        else
        {      
            $data = array(
                        'kd_rek3' => $this->input->post('kd_rek3'),
                        'nm_rek3' => $this->input->post('nm_rek3'),
                        );
            $this->master_model->save('ms_rek3_blud',$data);
            $this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
            redirect('master/rek3_blud');
        }
        $this->template->set('title', 'Master Data rekening 3 &raquo; Tambah Data');
        $this->template->load('template', 'master/rek3_blud/tambah', $data);
    }
    
    // Ubah data
    function edit_rek3_blud()
    {
        $id = $this->uri->segment(3);
        
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek3_blud','kd_rek3',$id)->num_rows() <= 0 ) ) :
        
            redirect('master/rek3_blud');
        
        endif;
        
        $config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening jenis',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek3',
                     'label'   => 'Nama Rekening Jenis',
                     'rules'   => 'trim|required'
                  )
            );
            
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening Jenis &raquo; Ubah Data";
            $data['rek3'] = $this->master_model->get_by_id('ms_rek3_blud','kd_rek3',$id)->row();
            $lc = "select kd_rek2,nm_rek2 from ms_rek2 order by kd_rek2";
            $query = $this->db->query($lc);
            $data["kdrek2"]=$query->result();
        }
        else
        {
                                
            $data = array(
                        'kd_rek2' => $this->input->post('kd_rek2'),
                        'kd_rek3' => $this->input->post('kd_rek3'),
                        'nm_rek3' => $this->input->post('nm_rek3'),
                        );
                        
            $this->master_model->update('ms_rek3_blud','kd_rek3',$id, $data);
                        
            $this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
            
            redirect('master/rek3');

        }
        
        $this->template->set('title', 'Master Data Rekening Jenis  &raquo; Ubah Data');
        $this->template->load('template', 'master/rek3/edit', $data);
    }
    // hapus data
    function hapus_rek3_blud()
    {
        $id = $this->uri->segment(3);
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek3_blud','kd_rek3',$id)->num_rows() <= 0 ) ) :
            redirect('master/rek3_blud');
        else:
            $this->master_model->delete('ms_rek3_blud','kd_rek3',$id);
            $this->session->set_flashdata('notify', 'Data berhasil dihapus !');
            redirect('master/rek3_blud');
        endif;
    }

//------------------------ END rekening 3 Andika --------------------------------//
//------------------------ rekening 4 Andika --------------------------------//
    function rekening4()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening Objek');   
        $this->template->load('template','master/rek4_blud/mrek4_blud',$data) ; 
    }
    function ambil_rekening3_blud() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek3, nm_rek3 FROM ms_rek3_blud where upper(kd_rek3) like upper('%$lccr%') or upper(nm_rek3) like upper('%$lccr%') ORDER BY kd_rek3";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek3' => $resulte['kd_rek3'],  
                        'nm_rek3' => $resulte['nm_rek3']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }
    function load_rekening4_blud() {
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        $where1 ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(nm_rek4) like upper('%$kriteria%') or kd_rek4 like'%$kriteria%')";            
            $where1="WHERE (upper(nm_rek4) like upper('%$kriteria%') or kd_rek4 like'%$kriteria%')";            
        }
        $sql = "SELECT count(*) as tot from ms_rek4_blud $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT TOP $rows * from ms_rek4_blud WHERE kd_rek4 NOT IN (SELECT TOP $offset kd_rek4 FROM ms_rek4_blud $where1 ORDER BY kd_rek4) $where order by kd_rek4";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek4' => $resulte['kd_rek4'], 
                        'kd_rek3' => $resulte['kd_rek3'],       
                        'nm_rek4' => $resulte['nm_rek4']
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
           
    }
function cari_rek4_blud()
    {
    $lccr =  $this->input->post('pencarian');
    $this->index('0','ms_rek4_blud','kd_rek4','nm_rek4','Rekening Objek','rek4',$lccr);
    }
    
    function tambah_rek4_blud()
    {
        
        $config = array(
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek4',
                     'label'   => 'Kode Rekening Objek',
                     'rules'   => 'trim|required'
                  ),
               
               array(
                     'field'   => 'nm_rek4',
                     'label'   => 'Nama Rekening objek',
                     'rules'   => 'trim|required'
                  )
            );
            
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening Kelompok &raquo; Tambah";
            $lc = "select kd_rek3,nm_rek3 from ms_rek3_blud order by kd_rek3";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
        }
        else
        {
                                
            $data = array(
                        'kd_rek3' => $this->input->post('kd_rek3'),
                        'kd_rek4' => $this->input->post('kd_rek4'),
                        'nm_rek4' => $this->input->post('nm_rek4'),
                        );
                        
            $this->master_model->save('ms_rek4_blud',$data);
                        
            $this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
            
            redirect('master/rek4_buld');

        }
        
        $this->template->set('title', 'Master Data Rekening Objek &raquo; Tambah Data');
        $this->template->load('template', 'master/rek4_buld/tambah', $data);
    }
    
    // Ubah data
    function edit_rek4_blud()
    {
        $id = $this->uri->segment(3);
        
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek_buld4','kd_rek4',$id)->num_rows() <= 0 ) ) :
        
            redirect('master/rek4_buld');
        
        endif;
        
        $config = array(
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek4',
                     'label'   => 'Kode Rekening Objek',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek4',
                     'label'   => 'Nama Rekening Objek',
                     'rules'   => 'trim|required'
                  )
            );
            
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data Rekening Objek &raquo; Ubah Data";
            $data['rek4'] = $this->master_model->get_by_id('ms_rek_buld4','kd_rek4',$id)->row();
            $lc = "select kd_rek3,nm_rek3 from ms_rek3_buld order by kd_rek3";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
        }
        else
        {
                                
            $data = array(
                        'kd_rek3' => $this->input->post('kd_rek3'),
                        'kd_rek4' => $this->input->post('kd_rek4'),
                        'nm_rek4' => $this->input->post('nm_rek4'),
                        );
                        
            $this->master_model->update('ms_rek_buld4','kd_rek4',$id, $data);
                        
            $this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
            
            redirect('master/rek4_buld');

        }
        
        $this->template->set('title', 'Master Data Rekening Objek  &raquo; Ubah Data');
        $this->template->load('template', 'master/rek4_buld/edit', $data);
    }
    
    // hapus data
    function hapus_rek4_blud()
    {
        $id = $this->uri->segment(3);
        
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek_buld4','kd_rek4',$id)->num_rows() <= 0 ) ) :
        
            redirect('master/rek4_buld');
        
        else:
                        
            $this->master_model->delete('ms_rek4_buld','kd_rek4',$id);
                        
            $this->session->set_flashdata('notify', 'Data berhasil dihapus !');
            
            redirect('master/rek4_buld');
            
        endif;
    }

//------------------------ END rekening 4 Andika --------------------------------//
//------------------------ rekening 5 Andika --------------------------------//
    function rekening5()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening Objek');   
        $this->template->load('template','master/rek5_blud/mrek5_blud',$data) ; 
    }
    function ambil_rekening4_blud() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek4, nm_rek4 FROM ms_rek4_blud where upper(kd_rek4) like upper('%$lccr%') or upper(nm_rek4) like upper('%$lccr%') ORDER BY kd_rek4";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek4' => $resulte['kd_rek4'],  
                        'nm_rek4' => $resulte['nm_rek4']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }
    function load_rekening5_blud() {
        
        $result = array();
        $row    = array();
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        $where1 ='';
        if ($kriteria <> ''){                               
            $where = " AND upper(nm_rek5) like upper('%$kriteria%') or kd_rek5 like'%$kriteria%'";            
            $where1 = " where upper(nm_rek5) like upper('%$kriteria%') or kd_rek5 like'%$kriteria%'";            
        } 
             
        $sql = "SELECT count(*) as tot from ms_rek5_blud a $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT TOP $rows * FROM ms_rek5_blud WHERE kd_rek5 NOT IN (SELECT TOP $offset kd_rek5 FROM ms_rek5_blud $where1 ORDER BY kd_rek5 )$where order by kd_rek5 ";
		/*
		$sql = "
		SELECT top $rows no_terima,no_tetap,tgl_terima,tgl_tetap,kd_skpd,keterangan as ket,nilai, kd_rek5,kd_rek_lo,kd_kegiatan,sts_tetap from tr_terima WHERE kd_skpd='$skpd' AND jenis='2' 
		$where AND no_terima NOT IN (SELECT TOP $offset no_terima FROM tr_terima WHERE kd_skpd='$skpd' $where ORDER BY tgl_terima,no_terima ) ORDER BY tgl_terima,no_terima ";
		*/
		
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'kd_rek4' => $resulte['kd_rek4'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'nm_rek5' => $resulte['nm_rek5'],
                        'kelompok' => $resulte['kelompok']                                                                      
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
           
    }
//------------------------ END rekening 5 Andika --------------------------------//
//------------------------ rekening 6 Andika --------------------------------//
    function rekening6()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening Objek');   
        $this->template->load('template','master/rek6_blud/mrek6_blud',$data) ; 
    }
    function ambil_rekening5_blud() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5_blud where upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%') ";
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
    function load_rekening6_blud() {
        
        $result = array();
        $row    = array();
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where = " where upper(nm_rek6) like upper('%$kriteria%') or kd_rek6 like'%$kriteria%'";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek6_blud a $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * FROM ms_rek6_blud $where order by kd_rek6 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek6' => $resulte['kd_rek6'],
                        'nm_rek6' => $resulte['nm_rek6'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                 
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
           
    }
//------------------------ END rekening 6 Andika --------------------------------//
//------------------------ rekening 7 Andika --------------------------------//
    function rekening7()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening Objek');   
        $this->template->load('template','master/rek7_blud/mrek7_blud',$data) ; 
    }
     function ambil_rekening6_blud() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek6, nm_rek6 FROM ms_rek6_blud where upper(kd_rek6) like upper('%$lccr%') or upper(nm_rek6) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek6' => $resulte['kd_rek6'],  
                        'nm_rek6' => $resulte['nm_rek6']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }
    function ambil_rekening5_13() {
        $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where kd_rek5 in ('5210701','5222501','5233201','4151501')";
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
    function load_rekening7_blud() {
        
        $result = array();
        $row    = array();
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where = " where upper(nm_rek7) like upper('%$kriteria%') or kd_rek7 like'%$kriteria%'";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek7_blud a $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * FROM ms_rek7_blud $where order by kd_rek7 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'kd_rek6' => $resulte['kd_rek6'],
                        'kd_rek7' => $resulte['kd_rek7'],
                        'nm_rek7' => $resulte['nm_rek7'],
                        'kd_rek13' => $resulte['kd_rek13'],
                        'kd_rek4_13' => $resulte['kd_rek4_13'],                                                                                 
                        'nm_rek13' => $resulte['nm_rek13'],                                                                                 
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
           
    }
//------------------------ END rekening 7 Andika --------------------------------//
    function rek1()
	{	
	 $this->index('0','ms_rek1','kd_rek1','nm_rek1','Rekening Akun','rek1','');
	}
	
    function rek2()
	{	
	 $this->index('0','ms_rek2','kd_rek2','nm_rek2','Rekening Kelompok','rek2','');
	}
    
    function rek3()
	{	
	 $this->index('0','ms_rek3','kd_rek3','nm_rek3','Rekening Jenis','rek3','');
	}
    
    function rek4()
	{	
	 $this->index('0','ms_rek4','kd_rek4','nm_rek4','Rekening Objek','rek4','');
	}
    
    function rek5()
	{	
	 $this->index('0','ms_rek5','kd_rek5','nm_rek5','Rekening Rincian Objek','rek5','');
	}
    
    function ttd()
	{	
	 $this->index('0','ms_ttd_blud','nip','nama','Penandatangan','ttd','');
	}    
    
    function bank()
	{	
	 $this->index('0','ms_bank_blud','kode','nama','Bank','bank','');
	}
    function user()
	{	
	 $this->index('0','[user_blud]','id_user','nama','User','user','');
	}
   
    function sclient_blud()
    {
        $data['page_title']= 'MASTER sclient_blud';
        $this->template->set('title', 'INPUT MASTER sclient_blud');   
        $this->template->load('template','master/sclient_blud',$data) ; 
    }
    
     function tapd()
    {
        $data['page_title']= 'MASTER TAPD';
        $this->template->set('title', 'INPUT TAPD');   
        $this->template->load('template','master/tapd',$data) ; 
    }
    
    //add
    function user_group()
    {   
        $this->index2('0','h_user_group_blud','id_group','nm_group','User Group','user_group','');
    }
    
    function index2($offset=0,$lctabel,$field,$field1,$judul,$list,$lccari){
            $data['page_title'] = "Master Data $judul";
            if(empty($lccari)){
                        $total_rows = $this->master_model->get_count($lctabel);
                        $lc = "/.$lccari";
            }else{
                        $total_rows = $this->master_model->get_count_teang($lctabel,$field,$field1,$lccari);
                        $lc = "";
            }
            // pagination        
            if(empty($lccari)){
                   $config['base_url']      = site_url("master/".$list);
            }else{
                        $config['base_url']     = site_url("master/cari_".$list);    
            }
    $config['total_rows']   = $total_rows;
    $config['per_page']     = '10';
    $config['uri_segment']  = 3;
    $config['num_links']    = 5;
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
    $limit                  = $config['per_page'];  
    $offset                 = $this->uri->segment(3);  
    $offset                 = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
      
    if(empty($offset))  
    {  
        $offset=0;  
    }

            if(empty($lccari)){     
                   $data['list']    = $this->master_model->getgroup();
            }else {
                        $data['list']   = $this->master_model->getCari($lctabel,$field,$field1,$limit, $offset,$lccari);
            }
    $data['num']        = $offset;
    $data['total_rows']          = $total_rows;
    
    $this->pagination->initialize($config);
    $a=$judul;
    $this->template->set('title', 'Master Data ');
    $this->template->load('template', "master/".$list."/list", $data);
}
function index($offset=0,$lctabel,$field,$field1,$judul,$list,$lccari)
	{
		$data['page_title'] = "Master Data $judul";
		//echo CI_VERSION;
		//$total_rows = $this->master_model->get_count($lctabel);
        if(empty($lccari)){
            $total_rows = $this->master_model->get_count($lctabel);
            $lc = "/.$lccari";
        }else{
            $total_rows = $this->master_model->get_count_teang($lctabel,$field,$field1,$lccari);
            $lc = "";
        }
		// pagination        
        if(empty($lccari)){
		$config['base_url']		= site_url("master/".$list);
        }else{
        $config['base_url']		= site_url("master/cari_".$list);    
        }
		$config['total_rows'] 	= $total_rows;
		$config['per_page'] 	= '10';
		$config['uri_segment'] 	= 3;
		$config['num_links'] 	= 5;
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
		$limit            		= $config['per_page'];  
		$offset         		= $this->uri->segment(3);  
		$offset         		= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
			$offset=0;  
		}
	    //$data['isi']=$this->aktif_menu();
        //$data['isi']=$this->aktif_menu(); 
        //$data['isi']= $this->session->userdata('lcisi');         
		//$data['list'] 		= $this->master_model->getAll($lctabel,$field,$limit, $offset);
         if(empty($lccari)){     
		$data['list'] 		= $this->master_model->getAll($lctabel,$field,$limit, $offset);
        }else {
            $data['list'] 		= $this->master_model->getCari($lctabel,$field,$field1,$limit, $offset,$lccari);
        }
		$data['num']		= $offset;
		$data['total_rows'] = $total_rows;
		
				$this->pagination->initialize($config);
		$a=$judul;
		$this->template->set('title', 'Master Data ');
		$this->template->load('template', "master/".$list."/list", $data);
	}
    
    function cetak_fungsi(){
        	$data['page_title'] = "Master Data Fungsi";
            $data['list'] 		= $this->master_model->getAllc('ms_fungsi_blud','kd_fungsi');
           	//$this->template->load('template','master/fungsi/list_preview', $data);
            $this->load->view('master/fungsi/list_preview', $data);
    }
	
    
    function get_sclient_blud(){

        $sql = "SELECT kd_skpd,thn_ang,provinsi,kab_kota,daerah,tgl_rka,tgl_dpa,tgl_ubah,tgl_dppa,rek_kasda,rek_kasin,rek_kasout,rk_skpd,rk_skpkd,spd_head1,spd_head2,spd_head3,spd_head4,
               ingat1,ingat2,ingat3,ingat4,ingat5, no_qanun, tgl_qanun, no_perbup, tgl_perbup,no_perda_ubah,tgl_perda_ubah,no_perbup_ubah,tgl_perbup_ubah,lamp_perda,lamp_perbup,lamp_perda_ubah,lamp_perbup_ubah FROM sclient_blud";

        $query1 = $this->db->query($sql);

		
		//$test = "hai";
		$test = $query1->num_rows();
		
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                'id'               => $ii,
                'kd_skpd'          => $resulte['kd_skpd'],
                'thn_ang'          => $resulte['thn_ang'],
                'provinsi'         => $resulte['provinsi'],
                'kab_kota'         => $resulte['kab_kota'],
                'daerah'           => $resulte['daerah'],
                'tgl_rka'          => $resulte['tgl_rka'],
                'tgl_dpa'          => $resulte['tgl_dpa'],
                'tgl_ubah'         => $resulte['tgl_ubah'],
                'tgl_dppa'         => $resulte['tgl_dppa'],
                'rek_kasda'        => $resulte['rek_kasda'],
                'rek_kasin'        => $resulte['rek_kasin'],
                'rek_kasout'       => $resulte['rek_kasout'],
                'rk_skpd'          => $resulte['rk_skpd'],
                'rk_skpkd'         => $resulte['rk_skpkd'],
                'head1'            => $resulte['spd_head1'],
                'head2'            => $resulte['spd_head2'],
                'head3'            => $resulte['spd_head3'],
                'head4'            => $resulte['spd_head4'],
                'ingat1'           => $resulte['ingat1'],
                'ingat2'           => $resulte['ingat2'],
                'ingat3'           => $resulte['ingat3'],
                'ingat4'           => $resulte['ingat4'],
                'ingat5'           => $resulte['ingat5'],
                'no_qanun'         => $resulte['no_qanun'],
                'tgl_qanun'        => $resulte['tgl_qanun'],
                'no_perbup'        => $resulte['no_perbup'],
                'tgl_perbup'       => $resulte['tgl_perbup'],
                'no_perda_ubah'    => $resulte['no_perda_ubah'],
                'tgl_perda_ubah'   => $resulte['tgl_perda_ubah'],
                'no_perbup_ubah'   => $resulte['no_perbup_ubah'],
                'tgl_perbup_ubah'  => $resulte['tgl_perbup_ubah'],
                'lamp_perda'       => $resulte['lamp_perda'],
                'lamp_perbup'      => $resulte['lamp_perbup'],
                'lamp_perda_ubah'  => $resulte['lamp_perda_ubah'],
                'lamp_perbup_ubah' => $resulte['lamp_perbup_ubah'],

            );
            $ii++;
        }
		
		if ($test===0){
            $result = array(
                'kd_skpd' => '',
                'thn_ang' => '',
                'provinsi' => '',
                'kab_kota' => '',
                'daerah' => '',
                'tgl_rka' => '',
                'tgl_dpa' => '',
                'tgl_ubah' => '',
                'tgl_dppa' => '',
                'rek_kasda' => '',
                'rek_kasin' => '',
                'rek_kasout' => '',
                'rk_skpd' => '',
                'rk_skpkd' => '',
                'spd_head1' => '',
                'spd_head2' => '',
                'spd_head3' => '',
                'spd_head4' => '',
                'ingat1' => '',
                'ingat2' => '',
                'ingat3' => '',
                'ingat4' => '',
                'ingat5' => '',
                'no_qanun' => '',
                'tgl_qanun' => '',
                'no_perbup' => '',
                'tgl_perbup' => '',
                'no_perda_ubah'=> '',
                'tgl_perda_ubah'=> '',
                'no_perbup_ubah'=> '',
                'tgl_perbup_ubah'=> '',
                'lamp_perda'=> '',
                'lamp_perbup'=> '',
                'lamp_perda_ubah'=> '',
                'lamp_perbup_ubah'=> '',

                );
                $ii++;
            }
        echo json_encode($result);
    	$query1->free_result();   
    }
    
    function simpan_sclient_blud(){
        $tabel      = $this->input->post('tabel');
        $cskpd      = $this->input->post('cskpd');
        $cthn       = $this->input->post('cthn');
        $cprov      = $this->input->post('cprov');
        $ckab       = $this->input->post('ckab');
        $cibu       = $this->input->post('cibu');
        $ctgl_rka   = $this->input->post('ctgl_rka');
        $ctgl_dpa   = $this->input->post('ctgl_dpa');
        $ctgl_ubah  = $this->input->post('ctgl_ubah');
        $ctgl_dppa  = $this->input->post('ctgl_dppa');
        $crek_kasda = $this->input->post('crek_kasda');
        $crek_kasin = $this->input->post('crek_kasin');
        $crek_kasout = $this->input->post('crek_kasout');
        $crk_skpd   = $this->input->post('crk_skpd');
        $crk_skpkd  = $this->input->post('crk_skpkd');
        $chead1     = $this->input->post('chead1');
        $chead2     = $this->input->post('chead2');
        $chead3     = $this->input->post('chead3');
        $chead4     = $this->input->post('chead4');
        $cingat1    = $this->input->post('cingat1');
        $cingat2    = $this->input->post('cingat2');
        $cingat3    = $this->input->post('cingat3');
        $cingat4    = $this->input->post('cingat4');
        $cingat5    = $this->input->post('cingat5');
        $cno_qanun   = $this->input->post('cno_qanun');
        $ctgl_qanun  = $this->input->post('ctgl_qanun');
        $cno_perbup  = $this->input->post('cno_perbup');
        $ctgl_perbup = $this->input->post('ctgl_perbup');
        $cno_perda_ubah = $this->input->post('cno_perda_ubah');
        $ctgl_perda_ubah = $this->input->post('ctgl_perda_ubah');
        $cno_perbup_ubah = $this->input->post('cno_perbup_ubah');
        $ctgl_perbup_ubah = $this->input->post('ctgl_perbup_ubah');
        $cperda_susun = $this->input->post('cperda_susun');
        $cperbup_susun = $this->input->post('cperbup_susun');
        $cperda_ubah = $this->input->post('cperda_ubah');
        $cperbup_ubah = $this->input->post('cperbup_ubah');



        $sql = "delete from sclient_blud ";
        $asg = $this->db->query($sql);
        
        if($asg){
            $sql = "insert into sclient_blud(kd_skpd,thn_ang,provinsi,kab_kota,daerah,tgl_rka,tgl_dpa,tgl_ubah,tgl_dppa,rek_kasda,rek_kasin,rek_kasout,rk_skpd,rk_skpkd,
                    spd_head1,spd_head2,spd_head3,spd_head4,ingat1,ingat2,ingat3,ingat4,ingat5, no_qanun, tgl_qanun, no_perbup, tgl_perbup,no_perda_ubah,tgl_perda_ubah,no_perbup_ubah,tgl_perbup_ubah,lamp_perda,lamp_perbup,lamp_perda_ubah,lamp_perbup_ubah)
            values('$cskpd','$cthn','$cprov','$ckab','$cibu','$ctgl_rka','$ctgl_dpa','$ctgl_ubah','$ctgl_dppa','$crek_kasda','$crek_kasin','$crek_kasout','$crk_skpd','$crk_skpkd',
            '$chead1','$chead2','$chead3','$chead4','$cingat1','$cingat2','$cingat3','$cingat4','$cingat5', '$cno_qanun', '$ctgl_qanun', '$cno_perbup', '$ctgl_perbup','$cno_perda_ubah','$ctgl_perda_ubah','$cno_perbup_ubah','$ctgl_perbup_ubah','$cperda_susun','$cperbup_susun','$cperda_ubah','$cperbup_ubah')";
            $asg = $this->db->query($sql);
             
        }
       
    }
    
    //add
    
    function load_dyn_menu_blud($lc=""){
      if($lc==""){
            $query = $this->db->query("SELECT * FROM dyn_menu_blud ORDER BY page_id");
      }else{
            $query = $this->db->query("SELECT * FROM dyn_menu_blud a WHERE a.id NOT IN (SELECT id_menu FROM d_user_group_blud b WHERE id_group = '$lc') ORDER BY page_id");
      }
      $result = array();
      $ii = 0;

      foreach ($query->result_array() as $resulte) {
             $result[] = array(
                              'id'=> $resulte['id'],
                              'nama' => $resulte['title']);
             $ii++;
      }
      echo json_encode($result);
}

function load_d_user_group_blud($lc=""){
      $query = $this->db->query("SELECT a.id_group, a.id_menu, b.title FROM d_user_group_blud a INNER JOIN dyn_menu_blud b ON a.id_menu = b.id WHERE a.id_group = '$lc' order by a.id_menu");
      $result = array();
      $ii = 0;

      foreach ($query->result_array() as $resulte) {
             $result[] = array(
                              'id1'=> $resulte['id_menu'],
                              'nama1' => $resulte['title']);
             $ii++;
      }
      echo json_encode($result);
}
    
        function get_tapd(){
      
         $sql = "SELECT no,nip,nama,jabatan FROM tapd";
				
        $query1 = $this->db->query($sql);  

		
		//$test = "hai";
		$test = $query1->num_rows();
		
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']
                        );
                        $ii++;
        }
		
		if ($test===0){
            $result = array(
                        'nip' => '',
                        'nama' => '',
                        'jabatan' => ''
                        );
                        $ii++;
		}		
		
		
        echo json_encode($result);
    	$query1->free_result();   
    }
    
	// Tamba data
	function tambah_fungsi()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_fungsi',
                     'label'   => 'Kd Fungsi',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_fungsi',
                     'label'   => 'Nm Fungsi',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Fungsi &raquo; Tambah";
		}
		else
		{
								
			$data = array(
						'kd_fungsi' => $this->input->post('kd_fungsi'),
						'nm_fungsi' => $this->input->post('nm_fungsi'),
						);
						
			$this->master_model->save('ms_fungsi_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/fungsi');

		}
		
		$this->template->set('title', 'Master Data Fungsi &raquo; Tambah Data');
		$this->template->load('template', 'master/fungsi/tambah', $data);
	}
    
    function cari_fungsi()
	{
		
	    $lccr =  $this->input->post('pencarian');
        $this->index('0','ms_fungsi_blud','kd_fungsi','nm_fungsi','Fungsi','fungsi',$lccr);

	}
	
	// Ubah data
	function edit_fungsi()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_fungsi_blud','kd_fungsi',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/fungsi');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_fungsi',
                     'label'   => 'Kd Fungsi',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_fungsi',
                     'label'   => 'Nm Fungsi',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Fungsi &raquo; Ubah Data";
			$data['fungsi'] = $this->master_model->get_by_id('ms_fungsi_blud','kd_fungsi',$id)->row();
		}
		else
		{
								
			$data = array(
						'kd_fungsi' => $this->input->post('kd_fungsi'),
						'nm_fungsi' => $this->input->post('nm_fungsi'),
						);
						
			$this->master_model->update('ms_fungsi_blud','kd_fungsi',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/fungsi');

		}
		
		$this->template->set('title', 'Master Data Fungsi &raquo; Ubah Data');
		$this->template->load('template', 'master/fungsi/edit', $data);
	}
	
	// hapus data
	function hapus_fungsi()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_fungsi_blud','kd_fungsi',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/fungsi');
		
		else:
						
			$this->master_model->delete('ms_fungsi_blud','kd_fungsi',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/fungsi');
			
		endif;
	}
    
    function preview_fungsi(){
        $cRet='';
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>
                        <tr><td colspan=\"2\" style=\"text-align:center;border: solid 1px white;border-bottom:solid 1px black;\">MASTER FUNGSI</td></tr> 
                        <tr><td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>KODE FUNGSI</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"60%\" align=\"center\"><b>NAMA FUNGSI</b></td></tr>
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\" align=\"center\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"60%\">&nbsp;</td></tr>
                        ";
                 
                 //$query = $this->db->query('SELECT kd_fungsi,nm_fungsi FROM ms_fungsi_blud');
                 $query = $this->master_model->getAllc('ms_fungsi_blud','kd_fungsi');

                foreach ($query->result() as $row)
                {
                    $coba1=$row->kd_fungsi;
                    $coba2=$row->nm_fungsi;
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"center\">$coba1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"60%\">$coba2</td></tr>";
                }
              
        $cRet    .= "</table>";
        $data['prev']= $cRet;    
        $this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
                
    }
    
        function cari_urusan()
	{
		
	$lccr =  $this->input->post('pencarian');
        $this->index('0','ms_urusan_blud','kd_urusan','nm_urusan','Urusan','urusan',$lccr);
	}
	
	// Tamba data
	function tambah_urusan()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_urusan',
                     'label'   => 'Kd Urusan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_urusan',
                     'label'   => 'Nm Urusan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_fungsi',
                     'label'   => 'kd_fungsi',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data urusan &raquo; Tambah";
            $lc = "select kd_fungsi,nm_fungsi from ms_fungsi_blud  order by kd_fungsi";
            $query = $this->db->query($lc);
            $data["kdfungsi"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_urusan' => $this->input->post('kd_urusan'),
						'nm_urusan' => $this->input->post('nm_urusan'),
                        'kd_fungsi' => $this->input->post('kd_fungsi')
						);
						
			$this->master_model->save('ms_urusan_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/urusan');

		}
		
		$this->template->set('title', 'Master Data Urusan &raquo; Tambah Data');
		$this->template->load('template', 'master/urusan/tambah', $data);
	}
	
	// Ubah data
	function edit_urusan()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_urusan_blud','kd_urusan',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/urusan');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_urusan',
                     'label'   => 'Kd Urusan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_urusan',
                     'label'   => 'Nm Urusan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_fungsi',
                     'label'   => 'kd_fungsi',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data urusan &raquo; Ubah Data";
			$data['urusan'] = $this->master_model->get_by_id('ms_urusan_blud','kd_urusan',$id)->row();
            $lc = "select kd_fungsi,nm_fungsi from ms_fungsi_blud  order by kd_fungsi";
            $query = $this->db->query($lc);
            $data["kdfungsi"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_urusan' => $this->input->post('kd_urusan'),
						'nm_urusan' => $this->input->post('nm_urusan'),
                        'kd_fungsi' => $this->input->post('kd_fungsi')
						);
						
			$this->master_model->update('ms_urusan_blud','kd_urusan',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data  berhasil diupdate !');
			
			redirect('master/urusan');

		}
		
		$this->template->set('title', 'Master Data urusan &raquo; Ubah Data');
		$this->template->load('template', 'master/urusan/edit', $data);
	}
	
	// hapus data
	function hapus_urusan()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_urusan_blud','kd_urusan',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/urusan');
		
		else:
						
			$this->master_model->delete('ms_urusan_blud','kd_urusan',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/urusan');
			
		endif;
	}
    
    function preview_urusan(){
        $cRet='';
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>
                        <tr><td colspan=\"2\" style=\"text-align:center;border: solid 1px white;border-bottom:solid 1px black;\">MASTER URUSAN</td></tr> 
                        <tr><td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>KODE URUSAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"60%\" align=\"center\"><b>NAMA URUSAN</b></td></tr>
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\" align=\"center\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"60%\">&nbsp;</td></tr>
                        ";
                 
          /*      $query = $this->master_model->getAllc('ms_urusan_blud','kd_urusan');

                foreach ($query->result() as $row)
                {
                    $coba1=$row->kd_urusan;
                    $coba2=$row->nm_urusan;
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"center\">$coba1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"60%\">$coba2</td></tr>";
                }*/
              
        $cRet    .= "</table>";
        $data['prev']= $cRet;    
        //echo $cRet;
        $this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/urusan/list_preview',$data);
        
                
    }
    
    function cari_skpd()
	{
		
		$lccr =  $this->input->post('pencarian');
        $this->index('0','ms_skpd_blud','kd_skpd','nm_skpd','SKPD','skpd',$lccr);
	}
	
	// Tamba data
	function tambah_skpd()
	{
		$this->load->model('master_model');
		$config = array(
               array(
                     'field'   => 'kd_urusan',
                     'label'   => 'Kode Urusan',
                     'rules'   => 'trim|required'
                  ),               
               array(
                     'field'   => 'kd_skpd',
                     'label'   => 'Kode Skpd',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_skpd',
                     'label'   => 'Nama Skpd',
                     'rules'   => 'trim|required'
                  ),     
               array(
                     'field'   => 'npwp',
                     'label'   => 'NPWP',
                     'rules'   => 'trim|required'
                  )
               );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening SKPD &raquo; Tambah";
            $lc = "select a.kd_urusan,a.nm_urusan,a.kd_fungsi,b.nm_fungsi from ms_urusan_blud a inner join ms_fungsi_blud b on a.kd_fungsi=b.kd_fungsi where a.tipe='S' order by a.kd_urusan";
            $query = $this->db->query($lc);
            $data["kdurus"]=$query->result();

            
		}
		else
		{
								
			$data = array(
						'kd_urusan' => $this->input->post('kd_urusan'),                        
						'kd_skpd' => $this->input->post('kd_skpd'),
                        'nm_skpd' => $this->input->post('nm_skpd'),                        
                        'npwp' => $this->input->post('npwp')
                        );
						
			$this->master_model->save('ms_skpd_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/skpd');

		}
		
		$this->template->set('title', 'Master Data Rekening skpd &raquo; Tambah Data');
		$this->template->load('template', 'master/skpd/tambah', $data);
	}
	
	// Ubah data
	function edit_skpd()
	{
	   $this->load->model('master_model');
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_skpd_blud','kd_skpd',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/skpd');
		
		endif;
		
		$config = array(
             array(
                     'field'   => 'kd_urusan',
                     'label'   => 'Kode Urusan',
                     'rules'   => 'trim|required'
                  ),
             array(
                     'field'   => 'kd_skpd',
                     'label'   => 'Kode Skpd',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_skpd',
                     'label'   => 'Nama Skpd',
                     'rules'   => 'trim|required'
                  ),     
              array(
                     'field'   => 'npwp',
                     'label'   => 'NPWP',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data SKPD &raquo; Ubah Data";
			$data['skpd'] = $this->master_model->get_by_id('ms_skpd_blud','kd_skpd',$id)->row();
            $lc = "select kd_urusan,nm_urusan from ms_urusan_blud where tipe='S' order by kd_urusan";
            $query = $this->db->query($lc);
            $data["kdurus"]=$query->result();

            

		}
		else
		{
								
			$data = array(
						'kd_urusan' => $this->input->post('kd_urusan'),                        
						'kd_skpd' => $this->input->post('kd_skpd'),
                        'nm_skpd' => $this->input->post('nm_skpd'),                        
                        'npwp' => $this->input->post('npwp'),
						);
						
			$this->master_model->update('ms_skpd_blud','kd_skpd',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/skpd');

		}
		
		$this->template->set('title', 'Master Data Rekening SKPD &raquo; Ubah Data');
		$this->template->load('template', 'master/skpd/edit', $data);
	}
	
	// hapus data
	function hapus_skpd()
	{
	   $this->load->model('master_model');
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_skpd_blud','kd_skpd',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/skpd');
		
		else:
						
			$this->master_model->delete('ms_skpd_blud','kd_skpd',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/skpd');
			
		endif;
	}
    
     function preview_skpd(){
        $cRet='';
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>
                        <tr><td colspan=\"4\" style=\"text-align:center;border: solid 1px white;border-bottom:solid 1px black;\">MASTER SKPD</td></tr> 
                        <tr><td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>KODE SKPD</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>KODE URUSAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"60%\" align=\"center\"><b>NAMA SKPD</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"10%\" align=\"center\"><b>NPWP</b></td></tr>
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\" align=\"center\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"60%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"10%\">&nbsp;</td></tr>
                        ";
                 
                 //$query = $this->db->query('SELECT kd_fungsi,nm_fungsi FROM ms_fungsi_blud');
                 $query = $this->master_model->getAllc('ms_skpd_blud','kd_skpd');

                foreach ($query->result() as $row)
                {
                    $coba1=$row->kd_skpd;
                    $coba2=$row->kd_urusan;
                    $coba3=$row->nm_skpd;
                    $coba4=$row->npwp;
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"center\">$coba1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\">$coba2</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"60%\">$coba3</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\">$coba4</td></tr>";
                }
              
        $cRet    .= "</table>";
        $data['prev']= $cRet;    
        $this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
                
    }
    
    function tambah_unit()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_unit',
                     'label'   => 'kd_unit',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_unit',
                     'label'   => 'nm_unit',
                     'rules'   => 'trim|required'
                  ),               
               array(
                     'field'   => 'kd_skpd',
                     'label'   => 'Kode Skpd',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Unit Kerja &raquo; Tambah";
            $lc = "select kd_skpd,nm_skpd from ms_skpd_blud order by kd_skpd";
            $query = $this->db->query($lc);
            $data["skpd"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_unit' => $this->input->post('kd_unit'),
						'nm_unit' => $this->input->post('nm_unit'),                        
                        'kd_skpd'=>$this->input->post('kd_skpd')                                        
                        
						);
						
			$this->master_model->save('ms_unit_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/unit');

		}
		
		$this->template->set('title', 'Master Unit Kerja &raquo; Tambah Data');
		$this->template->load('template', 'master/unit/tambah', $data);
	}
	
	// Ubah data
	function edit_unit()
	{
		$id = $this->uri->segment(3);
        $id=str_replace('%20',' ',$id);
        //echo($id);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_unit_blud','kd_unit',$id)->num_rows() <= 0 ) ) :
		     echo($id); 
			redirect('master/unit');
		
		endif;
		
		$config = array(
                array(
                     'field'   => 'kd_unit',
                     'label'   => 'kd_unit',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_unit',
                     'label'   => 'nm_unit',
                     'rules'   => 'trim|required'
                  ),               
               array(
                     'field'   => 'kd_skpd',
                     'label'   => 'Kode Skpd',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Unit Kerja &raquo; Ubah Data";
			$data['unit'] = $this->master_model->get_by_id('ms_unit_blud','kd_unit',$id)->row();
            $lc = "select kd_skpd,nm_skpd from ms_skpd_blud order by kd_skpd";
            $query = $this->db->query($lc);
            $data["skpd"]=$query->result();
            
  
		}
		else
		{
								
			$data = array(
						'kd_unit' => $this->input->post('kd_unit'),
						'nm_unit' => $this->input->post('nm_unit'),                        
                        'kd_skpd'=>$this->input->post('kd_skpd')  
                        );
						
			$this->master_model->update('ms_unit_blud','kd_unit',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data berhasil diupdate !');
			
			redirect('master/unit');

		}
		
		$this->template->set('title', 'Master Unit Kerja &raquo; Ubah Data');
		$this->template->load('template', 'master/unit/edit', $data);
	}
	
	// hapus data
	function hapus_unit()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_unit_blud','kd_unit',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/unit');
		
		else:
						
			$this->master_model->delete('ms_unit_blud','kd_unit',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/unit');
			
		endif;
	}
    
    function cari_program()
	{
		
		$lccr =  $this->input->post('pencarian');
        $this->index('0','m_prog_blud','kd_program','nm_prog_bludram','Program','program',$lccr);
	}
	
	// Tamba data
	function tambah_program()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_program',
                     'label'   => 'Kd program',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_prog_bludram',
                     'label'   => 'Nm program',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Program &raquo; Tambah";
		}
		else
		{
								
			$data = array(
						'kd_program' => $this->input->post('kd_program'),
						'nm_prog_bludram' => $this->input->post('nm_prog_bludram'),
						);
						
			$this->master_model->save('m_prog_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data  berhasil disimpan !');
			
			redirect('master/program');

		}
		
		$this->template->set('title', 'Master Data Program &raquo; Tambah Data');
		$this->template->load('template', 'master/program/tambah', $data);
	}
	
	// Ubah data
	function edit_program()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('m_prog_blud','kd_program',$id)->num_rows() <= 0 ) ) :
		
			redirect('program');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_program',
                     'label'   => 'Kd program',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_prog_bludram',
                     'label'   => 'Nm program',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Program &raquo; Ubah Data";
			$data['program'] = $this->master_model->get_by_id('m_prog_blud','kd_program',$id)->row();
		}
		else
		{
								
			$data = array(
						'kd_program' => $this->input->post('kd_program'),
						'nm_prog_bludram' => $this->input->post('nm_prog_bludram'),
						);
						
			$this->master_model->update('m_prog_blud','kd_program',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data  berhasil diupdate !');
			
			redirect('master/program');

		}
		
		$this->template->set('title', 'Master Data Program &raquo; Ubah Data');
		$this->template->load('template', 'master/program/edit', $data);
	}
	
	// hapus data
	function hapus_program()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('m_prog_blud','kd_program',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/program');
		
		else:
						
			$this->master_model->delete('m_prog_blud','kd_program',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/program');
			
		endif;
	}
    
    function preview_program(){
        $cRet='';
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>
                        <tr><td colspan=\"2\" style=\"text-align:center;border: solid 1px white;border-bottom:solid 1px black;\">MASTER PROGRAM</td></tr> 
                        <tr><td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>KODE PROGRAM</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"60%\" align=\"center\"><b>NAMA PROGRAM</b></td></tr>
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\" align=\"center\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"60%\">&nbsp;</td></tr>
                        ";
                 
                $query = $this->master_model->getAllc('m_prog_blud','kd_program');

                foreach ($query->result() as $row)
                {
                    $coba1=$row->kd_program;
                    $coba2=$row->nm_prog_bludram;
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"center\">$coba1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"60%\">$coba2</td></tr>";
                }
              
        $cRet    .= "</table>";
        $data['prev']= $cRet;    
        $this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
                
    }
    
    function cari_kegiatan()
	{
		
		$lccr =  $this->input->post('pencarian');
        $this->index('0','m_giat_blud','kd_kegiatan','nm_kegiatan','Kegiatan','kegiatan',$lccr);
	}
	
	// Tamba data
	function tambah_kegiatan()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_program',
                     'label'   => 'Kd Program',
                     'rules'   => 'trim|required'
                    ),
                
               array(
                     'field'   => 'kd_kegiatan',
                     'label'   => 'Kd Kegiatan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_kegiatan',
                     'label'   => 'Nm Kegiatan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'jns_kegiatan',
                     'label'   => 'Jns Kegiatan',
                     'rules'   => 'trim|required'
               )
                  
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Kegiatan &raquo; Tambah";
            $lc = "select kd_program,nm_prog_bludram from m_prog_blud order by kd_program";
            $query = $this->db->query($lc);
            $data["program"]=$query->result();
            //$data["jumrow"]=$this->db->get('m_prog_blud')->num_rows();
		}
		else
		{
								
			$data = array(
						'kd_program' => $this->input->post('kd_program'),
						'kd_kegiatan' => $this->input->post('kd_kegiatan'),
                        'nm_kegiatan' => $this->input->post('nm_kegiatan'),
                        'jns_kegiatan' => $this->input->post('jns_kegiatan'),
						);
						
			$this->master_model->save('m_giat_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/kegiatan');

		}
		
		$this->template->set('title', 'Master Data Kegiatan &raquo; Tambah Data');
		$this->template->load('template', 'master/kegiatan/tambah', $data);
	}
	
	// Ubah data
	function edit_kegiatan()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('m_giat_blud','kd_kegiatan',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/kegiatan');
		
		endif;
		
		$config = array(
              array(
                     'field'   => 'kd_program',
                     'label'   => 'Kd Program',
                     'rules'   => 'trim|required'
                    ),
                
               array(
                     'field'   => 'kd_kegiatan',
                     'label'   => 'Kd Kegiatan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_kegiatan',
                     'label'   => 'Nm Kegiatan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'jns_kegiatan',
                     'label'   => 'Jns Kegiatan',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Kegiatan &raquo; Ubah Data";
			$data['kegiatan'] = $this->master_model->get_by_id('m_giat_blud','kd_kegiatan',$id)->row();
            $lc = "select kd_program,nm_prog_bludram from m_prog_blud order by kd_program";
            $query = $this->db->query($lc);
            $data["program"]=$query->result();
            $data["jumrow"]=$this->db->get('m_prog_blud')->num_rows();
  
            
            
   		}
		else
		{
								
			$data = array(
						'kd_program' => $this->input->post('kd_program'),
						'kd_kegiatan' => $this->input->post('kd_kegiatan'),
                        'nm_kegiatan' => $this->input->post('nm_kegiatan'),
                        'jns_kegiatan' => $this->input->post('jns_kegiatan'),
						);
						
			$this->master_model->update('m_giat_blud','kd_kegiatan',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/kegiatan');

		}
		
		$this->template->set('title', 'Master Data Kegiatan &raquo; Ubah Data');
		$this->template->load('template', 'master/kegiatan/edit', $data);
	}
	
	// hapus data
	function hapus_kegiatan()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('m_giat_blud','kd_kegiatan',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/kegiatan');
		
		else:
						
			$this->master_model->delete('m_giat_blud','kd_kegiatan',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/kegiatan');
			
		endif;
	}
    
    function preview_kegiatan(){
        $cRet='';
        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">
                     <thead>
                        <tr><td colspan=\"4\" style=\"text-align:center;border: solid 1px white;border-bottom:solid 1px black;\">MASTER KEGIATAN</td></tr> 
                        <tr><td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>KODE KEGIATAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"15%\" align=\"center\"><b>KODE PROGRAM</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"60%\" align=\"center\"><b>NAMA KEGIATAN</b></td>
                            <td bgcolor=\"#CCCCCC\" width=\"5%\" align=\"center\"><b>JENIS</b></td></tr>
                     </thead>
                     <tfoot>
                        <tr>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                            <td style=\"border-top: none;\"></td>
                         </tr>
                     </tfoot>
                        <tr><td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\" align=\"center\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"15%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"60%\">&nbsp;</td>
                            <td style=\"vertical-align:top;border-top: none;border-bottom: none;\" width=\"5%\">&nbsp;</td></tr>
                        ";
                 
                 //$query = $this->db->query('SELECT kd_fungsi,nm_fungsi FROM ms_fungsi_blud');
                 $query = $this->master_model->getAllc('m_giat_blud','kd_kegiatan');

                foreach ($query->result() as $row)
                {
                    $coba1=$row->kd_kegiatan;
                    $coba2=$row->kd_program;
                    $coba3=$row->nm_kegiatan;
                    $coba4=$row->jns_kegiatan;
                     $cRet    .= " <tr><td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"15%\" align=\"center\">$coba1</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\">$coba2</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"60%\">$coba3</td>
                                     <td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none;\" width=\"10%\">$coba4</td></tr>";
                }
              
        $cRet    .= "</table>";
        $data['prev']= $cRet;    
        $this->_mpdf('',$cRet,10,10,10,0);
        //$this->template->load('template','master/fungsi/list_preview',$data);
        
                
    }
    
    function tambah_rek1()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_rek1',
                     'label'   => 'Kode Rekening 1',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek1',
                     'label'   => 'Nama Rekening 1',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening 1 &raquo; Tambah";
		}
		else
		{
								
			$data = array(
						'kd_rek1' => $this->input->post('kd_rek1'),
						'nm_rek1' => $this->input->post('nm_rek1'),
						);
						
			$this->master_model->save('ms_rek1',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/rek1');

		}
		
		$this->template->set('title', 'Master Data rekening 1 &raquo; Tambah Data');
		$this->template->load('template', 'master/rek1/tambah', $data);
	}
	
	// Ubah data
	function edit_rek1()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek1','kd_rek1',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek1');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_rek1',
                     'label'   => 'Kode Rekening 1',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek1',
                     'label'   => 'Nama Rekening 1',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening akun &raquo; Ubah Data";
			$data['rek1'] = $this->master_model->get_by_id('ms_rek1','kd_rek1',$id)->row();
		}
		else
		{
								
			$data = array(
						'kd_rek1' => $this->input->post('kd_rek1'),
						'nm_rek1' => $this->input->post('nm_rek1'),
						);
						
			$this->master_model->update('ms_rek1','kd_rek1',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/rek1');

		}
		
		$this->template->set('title', 'Master Data Rekening Akun  &raquo; Ubah Data');
		$this->template->load('template', 'master/rek1/edit', $data);
	}
	
	// hapus data
	function hapus_rek1()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek1','kd_rek1',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek1');
		
		else:
						
			$this->master_model->delete('ms_rek1','kd_rek1',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/rek1');
			
		endif;
	}
    
    function tambah_rek2()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening 2',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek1',
                     'label'   => 'Kode Rekening 1',
                     'rules'   => 'trim|required'
                  ),

               array(
                     'field'   => 'nm_rek2',
                     'label'   => 'Nama Rekening 2',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Kelompok &raquo; Tambah";
            $lc = "select kd_rek1,nm_rek1 from ms_rek1 order by kd_rek1";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek2' => $this->input->post('kd_rek2'),
                        'kd_rek1' => $this->input->post('kd_rek1'),
						'nm_rek2' => $this->input->post('nm_rek2'),
						);
						
			$this->master_model->save('ms_rek2',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/rek2');

		}
		
		$this->template->set('title', 'Master Data Rekening Kelompok &raquo; Tambah Data');
		$this->template->load('template', 'master/rek2/tambah', $data);
	}
	
	// Ubah data
	function edit_rek2()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek2','kd_rek2',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek2');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek1',
                     'label'   => 'Kode Rekening Akun',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek2',
                     'label'   => 'Nama Rekening Kelompok',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Kelompok &raquo; Ubah Data";
			$data['rek2'] = $this->master_model->get_by_id('ms_rek2','kd_rek2',$id)->row();
            $lc = "select kd_rek1,nm_rek1 from ms_rek1 order by kd_rek1";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek2' => $this->input->post('kd_rek2'),
                        'kd_rek1' => $this->input->post('kd_rek1'),
						'nm_rek2' => $this->input->post('nm_rek2'),
						);
						
			$this->master_model->update('ms_rek2','kd_rek2',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/rek2');

		}
		
		$this->template->set('title', 'Master Data Rekening Kelompok  &raquo; Ubah Data');
		$this->template->load('template', 'master/rek2/edit', $data);
	}
	
	// hapus data
	function hapus_rek2()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek2','kd_rek2',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek2');
		
		else:
						
			$this->master_model->delete('ms_rek2','kd_rek2',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/rek2');
			
		endif;
	}
    
    function cari_rek3()
	{
	$lccr =  $this->input->post('pencarian');
    $this->index('0','ms_rek3','kd_rek3','nm_rek3','Rekening Jenis','rek3',$lccr);
	}
    
    function tambah_rek3()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening Jenis',
                     'rules'   => 'trim|required'
                  ),
               
               array(
                     'field'   => 'nm_rek3',
                     'label'   => 'Nama Rekening Jenis',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Kelompok &raquo; Tambah";
            $lc = "select kd_rek2,nm_rek2 from ms_rek2 order by kd_rek2";
            $query = $this->db->query($lc);
            $data["kdrek2"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek2' => $this->input->post('kd_rek2'),
                        'kd_rek3' => $this->input->post('kd_rek3'),
						'nm_rek3' => $this->input->post('nm_rek3'),
						);
						
			$this->master_model->save('ms_rek3',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/rek3');

		}
		
		$this->template->set('title', 'Master Data Rekening Jenis &raquo; Tambah Data');
		$this->template->load('template', 'master/rek3/tambah', $data);
	}
	
	// Ubah data
	function edit_rek3()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek3','kd_rek3',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek3');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_rek2',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening jenis',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek3',
                     'label'   => 'Nama Rekening Jenis',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Jenis &raquo; Ubah Data";
			$data['rek3'] = $this->master_model->get_by_id('ms_rek3','kd_rek3',$id)->row();
            $lc = "select kd_rek2,nm_rek2 from ms_rek2 order by kd_rek2";
            $query = $this->db->query($lc);
            $data["kdrek2"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek2' => $this->input->post('kd_rek2'),
                        'kd_rek3' => $this->input->post('kd_rek3'),
						'nm_rek3' => $this->input->post('nm_rek3'),
						);
						
			$this->master_model->update('ms_rek3','kd_rek3',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/rek3');

		}
		
		$this->template->set('title', 'Master Data Rekening Jenis  &raquo; Ubah Data');
		$this->template->load('template', 'master/rek3/edit', $data);
	}
	
	// hapus data
	function hapus_rek3()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek3','kd_rek3',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek3');
		
		else:
						
			$this->master_model->delete('ms_rek3','kd_rek3',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/rek3');
			
		endif;
	}
    
    function cari_rek4()
	{
	$lccr =  $this->input->post('pencarian');
    $this->index('0','ms_rek4','kd_rek4','nm_rek4','Rekening Objek','rek4',$lccr);
	}
    
    function tambah_rek4()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek4',
                     'label'   => 'Kode Rekening Objek',
                     'rules'   => 'trim|required'
                  ),
               
               array(
                     'field'   => 'nm_rek4',
                     'label'   => 'Nama Rekening objek',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Kelompok &raquo; Tambah";
            $lc = "select kd_rek3,nm_rek3 from ms_rek3 order by kd_rek3";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek3' => $this->input->post('kd_rek3'),
                        'kd_rek4' => $this->input->post('kd_rek4'),
						'nm_rek4' => $this->input->post('nm_rek4'),
						);
						
			$this->master_model->save('ms_rek4',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/rek4');

		}
		
		$this->template->set('title', 'Master Data Rekening Objek &raquo; Tambah Data');
		$this->template->load('template', 'master/rek4/tambah', $data);
	}
	
	// Ubah data
	function edit_rek4()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek4','kd_rek4',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek4');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_rek3',
                     'label'   => 'Kode Rekening kelompok',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek4',
                     'label'   => 'Kode Rekening Objek',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek4',
                     'label'   => 'Nama Rekening Objek',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Objek &raquo; Ubah Data";
			$data['rek4'] = $this->master_model->get_by_id('ms_rek4','kd_rek4',$id)->row();
            $lc = "select kd_rek3,nm_rek3 from ms_rek3 order by kd_rek3";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek3' => $this->input->post('kd_rek3'),
                        'kd_rek4' => $this->input->post('kd_rek4'),
						'nm_rek4' => $this->input->post('nm_rek4'),
						);
						
			$this->master_model->update('ms_rek4','kd_rek4',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/rek4');

		}
		
		$this->template->set('title', 'Master Data Rekening Objek  &raquo; Ubah Data');
		$this->template->load('template', 'master/rek4/edit', $data);
	}
	
	// hapus data
	function hapus_rek4()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek4','kd_rek4',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek4');
		
		else:
						
			$this->master_model->delete('ms_rek4','kd_rek4',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/rek4');
			
		endif;
	}
    
    function cari_rek5()
	{
	$lccr =  $this->input->post('pencarian');
    $this->index('0','ms_rek5','kd_rek5','nm_rek5','Rekening Rincian Objek','rek5',$lccr);
	}
    
    function tambah_rek5()
	{
		
		$config = array(
               array(
                     'field'   => 'kd_rek4',
                     'label'   => 'Kode Rekening Objek',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek5',
                     'label'   => 'Kode Rekening Rincian Objek',
                     'rules'   => 'trim|required'
                  ),
               
               array(
                     'field'   => 'nm_rek5',
                     'label'   => 'Nama Rekening Rincian Objek',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Rincian &raquo; Tambah";
            $lc = "select kd_rek4,nm_rek4 from ms_rek4 order by kd_rek4";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek4' => $this->input->post('kd_rek4'),
                        'kd_rek5' => $this->input->post('kd_rek5'),
						'nm_rek5' => $this->input->post('nm_rek5'),
						);
						
			$this->master_model->save('ms_rek5',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/rek5');

		}
		
		$this->template->set('title', 'Master Data Rekening Rincian Objek &raquo; Tambah Data');
		$this->template->load('template', 'master/rek5/tambah', $data);
	}
	
	// Ubah data
	function edit_rek5()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek5','kd_rek5',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek5');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kd_rek4',
                     'label'   => 'Kode Rekening Objek',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_rek5',
                     'label'   => 'Kode Rekening Rincian Objek',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nm_rek5',
                     'label'   => 'Nama Rekening Rincian Objek',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Rekening Rincian Objek &raquo; Ubah Data";
			$data['rek5'] = $this->master_model->get_by_id('ms_rek5','kd_rek5',$id)->row();
            $lc = "select kd_rek4,nm_rek4 from ms_rek4 order by kd_rek4";
            $query = $this->db->query($lc);
            $data["kdrek"]=$query->result();
		}
		else
		{
								
			$data = array(
						'kd_rek4' => $this->input->post('kd_rek4'),
                        'kd_rek5' => $this->input->post('kd_rek5'),
						'nm_rek5' => $this->input->post('nm_rek5'),
						);
						
			$this->master_model->update('ms_rek5','kd_rek5',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/rek5');

		}
		
		$this->template->set('title', 'Master Data Rekening Rincian Objek  &raquo; Ubah Data');
		$this->template->load('template', 'master/rek5/edit', $data);
	}
	
	// hapus data
	function hapus_rek5()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_rek5','kd_rek5',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/rek5');
		
		else:
						
			$this->master_model->delete('ms_rek5','kd_rek5',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/rek5');
			
		endif;
	}
    
    function cari_ttd()
	{
	$lccr =  $this->input->post('pencarian');
    $this->index('0','ms_ttd_blud','nip','nama','Penandatangan','ttd',$lccr);
	}
    
   	function tambah_ttd()
	{
		
		$config = array(
               array(
                     'field'   => 'nip',
                     'label'   => 'NIP',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'jabatan',
                     'label'   => 'Jabatan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'pangkat',
                     'label'   => 'pangkat',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_skpd',
                     'label'   => 'Kode Skpd',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kode',
                     'label'   => 'Kode',
                     'rules'   => 'trim|required'
                  )



            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Tanda tangan &raquo; Tambah";
            $lc = "select kd_skpd,nm_skpd from ms_skpd_blud order by kd_skpd";
            $query = $this->db->query($lc);
            $data["skpd"]=$query->result();
		}
		else
		{
								
			$data = array(
						'nip' => $this->input->post('nip'),
						'nama' => $this->input->post('nama'),
                        'jabatan'=>$this->input->post('jabatan'),
                        'pangkat'=>$this->input->post('pangkat'),
                        'kd_skpd'=>$this->input->post('kd_skpd'),
                        'kode'=>$this->input->post('kode')
                        
                        
						);
						
			$this->master_model->save('ms_ttd_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/ttd');

		}
		
		$this->template->set('title', 'Master Data Tanda Tangan &raquo; Tambah Data');
		$this->template->load('template', 'master/ttd/tambah', $data);
	}
	
	// Ubah data
	function edit_ttd()
	{
		$id = $this->uri->segment(3);
        $id=str_replace('%20',' ',$id);
        //echo($id);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_ttd_blud','nip',$id)->num_rows() <= 0 ) ) :
		     echo($id); 
			redirect('master/ttd');
		
		endif;
		
		$config = array(
                array(
                     'field'   => 'nip',
                     'label'   => 'NIP',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'jabatan',
                     'label'   => 'Jabatan',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'pangkat',
                     'label'   => 'pangkat',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kd_skpd',
                     'label'   => 'Kode Skpd',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'kode',
                     'label'   => 'Kode',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Tanda Tangan &raquo; Ubah Data";
			$data['ttd'] = $this->master_model->get_by_id('ms_ttd_blud','nip',$id)->row();
            $lc = "select kd_skpd,nm_skpd from ms_skpd_blud order by kd_skpd";
            $query = $this->db->query($lc);
            $data["skpd"]=$query->result();
            
  
		}
		else
		{
								
			$data = array(
						'nip' => $this->input->post('nip'),
						'nama' => $this->input->post('nama'),
                        'jabatan'=>$this->input->post('jabatan'),
                        'pangkat'=>$this->input->post('pangkat'),
                        'kd_skpd'=>$this->input->post('kd_skpd'),
                        'kode'=>$this->input->post('kode')
                        );
						
			$this->master_model->update('ms_ttd_blud','nip',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data berhasil diupdate !');
			
			redirect('master/ttd');

		}
		
		$this->template->set('title', 'Master Data Tanda tangan &raquo; Ubah Data');
		$this->template->load('template', 'master/ttd/edit', $data);
	}
	
	// hapus data
	function hapus_ttd()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_ttd_blud','nip',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/ttd');
		
		else:
						
			$this->master_model->delete('ms_ttd_blud','nip',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/ttd');
			
		endif;
	}
    
    function cari_bank()
	{
	$lccr =  $this->input->post('pencarian');
    $this->index('0','ms_bank_blud','kode','nama','Bank','bank',$lccr);
	}
    
    function tambah_bank()
	{
		
		$config = array(
               array(
                     'field'   => 'kode',
                     'label'   => 'Kode',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Bank &raquo; Tambah";
		}
		else
		{
								
			$data = array(
						'kode' => $this->input->post('kode'),
						'nama' => $this->input->post('nama'),
						);
						
			$this->master_model->save('ms_bank_blud',$data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil disimpan !');
			
			redirect('master/bank');

		}
		
		$this->template->set('title', 'Master Data Bank &raquo; Tambah Data');
		$this->template->load('template', 'master/bank/tambah', $data);
	}
	
	// Ubah data
	function edit_bank()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_bank_blud','kode',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/bank');
		
		endif;
		
		$config = array(
               array(
                     'field'   => 'kode',
                     'label'   => 'Kode',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  )
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data Bank &raquo; Ubah Data";
			$data['bank'] = $this->master_model->get_by_id('ms_bank_blud','kode',$id)->row();
		}
		else
		{
								
			$data = array(
						'kode' => $this->input->post('kode'),
						'nama' => $this->input->post('nama'),
						);
						
			$this->master_model->update('ms_bank_blud','kode',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data Berita berhasil diupdate !');
			
			redirect('master/bank');

		}
		
		$this->template->set('title', 'Master Data Bank &raquo; Ubah Data');
		$this->template->load('template', 'master/bank/edit', $data);
	}
	
	// hapus data
	function hapus_bank()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('ms_bank_blud','kode',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/bank');
		
		else:
						
			$this->master_model->delete('ms_bank_blud','kode',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/bank');
			
		endif;
	}
    
    
    ////my
    ////my
    function cari_user()
    {
        $lccr =  $this->input->post('pencarian');
        $this->index('0','user','user_name','nama','USER','user',$lccr);
    }


	  function edit_user()
    {
        
        $id = $this->uri->segment(3);
        
        $data['list']       = $this->db->query("SELECT a.*,b.user_id FROM dyn_menu_blud a LEFT JOIN (SELECT * FROM otori_blud WHERE user_id = '$id') b ON a.id = b.menu_id order by a.id");
        
        if ( ( $id == "" ) || ( $this->master_model->get_by_id('[user]','id_user',$id)->num_rows() <= 0 ) ) :
        
            redirect('master/user');
        
        endif;
        
        //*
        $config = array(
               array(
                     'field'   => 'id_user',
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'user_name',
                     'label'   => 'User Uame',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim'
                  ),
               array(
                     'field'   => 'type',
                     'label'   => 'Type',
                     'rules'   => 'trim'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  )
                  
            );
            
        $this->form_validation->set_message('required', '%s harus diisi !');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Master Data User &raquo; Ubah Data";
            $data['user'] = $this->master_model->get_by_id('[user]','id_user',$id)->row();
        }
        else
        {
            if((md5($this->input->post('password')) == $this->input->post('password_before')) || ($this->input->post('password') == ""))
            {
            $data = array(
                        'id_user' => $this->input->post('id_user'),
                        'user_name' => $this->input->post('user_name'),
                        'password' => $this->input->post('password_before'),
                        //'password' => md5($this->input->post('password')),
                        'nama' => $this->input->post('nama'),
                        'type' => $this->input->post('type')
                        
                        );
            }
            else
            {
            $data = array(
                        'id_user' => $this->input->post('id_user'),
                        'user_name' => $this->input->post('user_name'),
                        //'password' => $this->input->post('password'),
                        'password' => md5($this->input->post('password')),
                        'nama' => $this->input->post('nama'),
                        'type' => $this->input->post('type')
                        
                        );
            }
            $this->master_model->delete("otori_blud","user_id",$this->input->post('id_user'));



            //*
            $max=count($this->input->post('otori_blud_id')) - 1;
            for ($i = 0; $i <= $max; $i++) 
            {
            $id_menu = $this->input->post('otori_blud_id');
            
            $data_otori_blud = array(
                        'user_id' => $this->input->post('id_user'),
                        'menu_id' => $id_menu[$i],
                        'akses' => "1"
                        );
            $this->master_model->save('otori_blud',$data_otori_blud);
            }
            //*/
                        
            $this->master_model->update('[user]','id_user',$id, $data);
                        
            $this->session->set_flashdata('notify', 'Data User berhasil diupdate !');
            
            redirect('master/user');

        }
        
        $this->template->set('title', 'Master Data User &raquo; Ubah Data');
        $this->template->load('template', 'master/user/edit', $data);
        //*/
    }

    function tambah_user(){

	$data['list'] 	= $this->db->query("SELECT * FROM dyn_menu_blud ORDER BY page_id");
		
	$config = array(
               array(
                     'field'   => 'id_user',
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'user_name',
                     'label'   => 'User_name',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'type',
                     'label'   => 'Type',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  )
            );
			
	$this->form_validation->set_message('required', '%s harus diisi !');
	$this->form_validation->set_rules($config);
	$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

	if ($this->form_validation->run() == FALSE)
	{
		$data['page_title'] = "Master Data User &raquo; Tambah";
	}
	else
	{
							
		$data = array(
				'id_user' => $this->input->post('id_user'),
				'user_name' => $this->input->post('user_name'),
				'password' => md5($this->input->post('password')),
				'type' => $this->input->post('type'),
				'nama' => $this->input->post('nama')
				);
					
		$this->master_model->save('user',$data);
		
		//*
		$max=count($this->input->post('otori_blud_id')) - 1;
		for ($i = 0; $i <= $max; $i++) 
           	{
		$id_menu = $this->input->post('otori_blud_id');
		
		$data_otori_blud = array(
					'user_id' => $this->input->post('id_user'),
					'menu_id' => $id_menu[$i],
					'akses' => "1"
					);
		$this->master_model->save('otori_blud',$data_otori_blud);
		}
		//*/
		
		$this->session->set_flashdata('notify', 'Data User berhasil disimpan !');
		
		redirect('master/user');

	}
		
	$this->template->set('title', 'Master Data User &raquo; Tambah Data');
	$this->template->load('template', 'master/user/tambah', $data);
}
function hapus_user()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('user_blud','id_user',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/user');
		
		else:
			$this->master_model->delete("otori_blud","user_id",$id);
				
			$this->master_model->delete('user_blud','id_user',$id);
						
			$this->session->set_flashdata('notify', 'User Berhasil Terhapus !!!');
			
			redirect('master/user');
			
		endif;
	}

    //add
    
    function hapus_user_group(){
      $kode = $this->input->post('vkode');
      echo json_encode($kode);
}

function simpan_h_user_group_blud(){
      $kode = $this->input->post('vkode');
      $nama = $this->input->post('vnama');
      $status = $this->input->post('vstatus');

      $msg = array();

      if($status=="tambah"){
            $query = $this->db->query("insert into h_user_group_blud (id_group,nm_group) values ('$kode','$nama')");
      }else{
            $query = $this->db->query("update h_user_group_blud set nm_group= '$nama' where id_group = '$kode'");
      }
      
      if($query){
            $msg = array('pesan' => '0');
      }else{
            $msg = array('pesan' => '1');
      }
      echo json_encode($msg);
}

function load_h_user_group_blud(){
        $query = $this->db->query("SELECT * FROM h_user_group_blud ORDER BY CAST(id_group AS SIGNED)");
        $result = array();
        $ii = 0;

        foreach ($query->result_array() as $resulte) {
            $result[] = array(
                       'id_group'=> $resulte['id_group'],
                       'nm_group' => $resulte['nm_group']);
            $ii++;
        }
        echo json_encode($result);
}

function hapus_h_user_group_blud(){
      $kode = $this->input->post('vkode');
      $msg = array();

      $query = $this->db->query("delete from h_user_group_blud where id_group = '$kode'");
      if($query){
            $query1 = $this->db->query("delete from d_user_group_blud where id_group = '$kode'");
            if($query1){
                  $msg = array('pesan' => '0');
            }
      }else{
            $msg = array('pesan' => '1');
      }
      echo json_encode($msg);
}

function simpan_d_user_group_blud(){
      $kode = $this->input->post('vkode');
      $sql = $this->input->post('vsql');
      $msg = array();

      $query = $this->db->query("delete from d_user_group_blud where id_group = '$kode'");
      if($query){
            $sequel = "insert into d_user_group_blud (id_group, id_menu) ".$sql;
            $query1 = $this->db->query($sequel);
            if($query1){
                  $msg = array('pesan' => '0');
            }
            //$msg = array('csql' => $sequel);
      }else{
            $msg = array('pesan' => '1');
      }
      echo json_encode($msg);

}
    
        function cek_login_user(){
            $userId = $this->session->userdata('logged');
            $type = "";
            if($userId != ""){
                $sql = $this->db->query("select type from user_blud where id_user = '$userId'");
                foreach ($sql->result() as $row)
                {
                   $type = $row->type;
                }
            }            
            echo json_encode($type);
        }

    
    function error()
    {
        $data['page_title']= 'Dalam Penyesuaian';
        $this->template->set('title', 'Dalam Penyesuaian');   
        $this->template->load('template','master/error',$data) ; 
    }
    
    function mfungsi()
    {
        $data['page_title']= 'Master FUNGSI';
        $this->template->set('title', 'Master Fungsi');   
        $this->template->load('template','master/fungsi/mfungsi',$data) ; 
    }
    
    function sumber_dana_blud()
    {
        $data['page_title']= 'Master FUNGSI';
        $this->template->set('title', 'Master Fungsi');   
        $this->template->load('template','master/fungsi/mdana',$data) ; 
    }
    
    function murusan()
    {
        $data['page_title']= 'Master URUSAN';
        $this->template->set('title', 'Master Urusan');   
        $this->template->load('template','master/urusan/murusan',$data) ; 
    }
    
    function mskpd()
    {
        $data['page_title']= 'Master SKPD';
        $this->template->set('title', 'Master SKPD');   
        $this->template->load('template','master/skpd/mskpd',$data) ; 
    }
    
    function standar_harga()
    {
        $data['page_title']= 'Master Daftar Harga';
        $this->template->set('title', 'Master Daftar Harga');   
        $this->template->load('template','master/harga/standar_harga_ar_insert',$data) ; 
    }
    
    function munit()
    {
        $data['page_title']= 'Master UNIT';
        $this->template->set('title', 'Master UNIT');   
        $this->template->load('template','master/unit/munit',$data) ; 
    }

    function unit_layanan()
    {
        $data['page_title']= 'Master UNIT LAYANAN';
        $this->template->set('title', 'Master UNIT LAYANAN');   
        $this->template->load('template','master/unit/unit_layanan_blud',$data) ; 
    }
    function pelayanan_blud()
    {
        $data['page_title']= 'Master PELAYANAN BLUD';
        $this->template->set('title', 'Master PELAYANAN BLUD');   
        $this->template->load('template','master/layanan/pelayanan_blud',$data) ; 
    }
    
    function mprogram()
    {
        $data['page_title']= 'Master PROGRAM';
        $this->template->set('title', 'Master PROGRAM');   
        $this->template->load('template','master/program/mprogram',$data) ; 
    }
    
    function mkegiatan()
    {
        $data['page_title']= 'Master KEGIATAN';
        $this->template->set('title', 'Master KEGIATAN');   
        $this->template->load('template','master/kegiatan/mkegiatan',$data) ; 
    }
    
	function msubkegiatan()
    {
        $data['page_title']= 'Master SUB KEGIATAN';
        $this->template->set('title', 'Master SUB KEGIATAN');   
        $this->template->load('template','master/subkegiatan/msubkegiatan',$data) ; 
    }
	
     function mrek1()
    {
        $data['page_title']= 'Master Rekening Akun';
        $this->template->set('title', 'Master Rekening Akun');   
        $this->template->load('template','master/rek1/mrek1',$data) ; 
    }
    
    function mrek2()
    {
        $data['page_title']= 'Master Rekening Kelompok';
        $this->template->set('title', 'Master Rekening Kelompok');   
        $this->template->load('template','master/rek2/mrek2',$data) ; 
    }
    
    function mrek3()
    {
        $data['page_title']= 'Master Rekening Jenis';
        $this->template->set('title', 'Master Rekening Jenis');   
        $this->template->load('template','master/rek3/mrek3',$data) ; 
    }
    
    function mrek4()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening Objek');   
        $this->template->load('template','master/rek4/mrek4',$data) ; 
    }
    
    function mrek5()
    {
        $data['page_title']= 'Master Rekening Rincian Objek';
        $this->template->set('title', 'Master Rekening Rincian Objek');   
        $this->template->load('template','master/rek5/mrek5',$data) ;
        //echo CI_VERSION; 
    }
    
    function mrek1_64()
    {
        $data['page_title']= 'Master Rekening Akun';
        $this->template->set('title', 'Master Rekening Akun');   
        $this->template->load('template','master/rek1/mrek1_64',$data) ; 
    }
    
    function mrek2_64()
    {
        $data['page_title']= 'Master Rekening Kelompok';
        $this->template->set('title', 'Master Rekening Kelompok');   
        $this->template->load('template','master/rek2/mrek2_64',$data) ; 
    }
    
    function mrek3_64()
    {
        $data['page_title']= 'Master Rekening Jenis';
        $this->template->set('title', 'Master Rekening Jenis');   
        $this->template->load('template','master/rek3/mrek3_64',$data) ; 
    }
    
    function mrek4_64()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening Objek');   
        $this->template->load('template','master/rek4/mrek4_64',$data) ; 
    }    
    
    function mbank()
    {
        $data['page_title']= 'Master BANK';
        $this->template->set('title', 'Master Bank');   
        $this->template->load('template','master/bank/mbank',$data) ;
        //echo CI_VERSION; 
    }
    
    function mttd()
    {
        $data['page_title']= 'Master Penandatangan';
        $this->template->set('title', 'Master Penandatangan');   
        $this->template->load('template','master/ttd/mttd',$data) ;
        //echo CI_VERSION; 
    }
    
    function rekening_objek()
    {
        $data['page_title']= 'Master Rekening Objek';
        $this->template->set('title', 'Master Rekening');   
        $this->template->load('template','master/rek5/rincian_objek',$data) ; 
    }
    
    function load_rek1() {
    
        $sql = " SELECT kd_rek2,nm_rek2 FROM ms_rek2 ORDER BY kd_rek2 ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek2' => $resulte['kd_rek2'],  
                        'nm_rek2' => $resulte['nm_rek2']
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	    $query1->free_result();
	} 
    
   	function load_rek5($reke='') {
        $rek=$reke;
        $sql = " SELECT kd_rek4,kd_rek5,map_lra1,map_lo,nm_rek5 FROM ms_rek5  where substr(kd_rek5,1,2)='$rek' ORDER BY kd_rek5 ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek4' => $resulte['kd_rek4'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'map_lra1' => $resulte['map_lra1'],
                        'map_lo' => $resulte['map_lo'],  
                        'nm_rek5' => $resulte['nm_rek5']
                       
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	    $query1->free_result();
	}
    
    function simpan_rek5() {
       
		$rek4 = $this->input->post('rek4');
        $rek5 = $this->input->post('rek5');
        $rek_lra = $this->input->post('rek_lra');
        $rek_lo = $this->input->post('rek_lo');
        $nama = $this->input->post('nama');	
        	
		$query = $this->db->query(" delete from ms_rek5 where kd_rek4='$rek4' and kd_rek5='$rek5'");
		$query = $this->db->query(" insert into ms_rek5(kd_rek4,kd_rek5,map_lra1,map_lo,nm_rek5) values('$rek4','$rek5','$rek_lra','$rek_lo','$nama') ");	
		

		$this->select_rka($kegiatan);
    } 
    
     function load_fungsi() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_fungsi) like upper('%$kriteria%') or kd_fungsi like'%$kriteria%')";            
        }
        
        $sql = "SELECT * from ms_fungsi_blud $where order by kd_fungsi";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_fungsi' => $resulte['kd_fungsi'],
                        'nm_fungsi' => $resulte['nm_fungsi']                                                                                        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function ambil_fungsi() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_fungsi, nm_fungsi FROM ms_fungsi_blud where upper(kd_fungsi) like upper('%$lccr%') or upper(nm_fungsi) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_fungsi' => $resulte['kd_fungsi'],  
                        'nm_fungsi' => $resulte['nm_fungsi']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function ambil_kode_unit_layanan() {
        $lccr = $this->input->post('q');
        if($lccr == ''){
             $sql = "SELECT kd_unit, nm_unit FROM ms_unit_layanan_blud where level = '1'";
        }else{
             $sql = "SELECT kd_unit, nm_unit FROM ms_unit_layanan_blud where level = '1' AND upper(kd_unit) like upper('%$lccr%') or upper(nm_unit) like upper('%$lccr%')  ";
        }
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
           
    }
    function ambil_kode_pelayanan_blud() {
        $lccr = $this->input->post('q');
        if($lccr == ''){
             $sql = "SELECT kd_layanan, nm_layanan FROM ms_layanan_blud where level = '1'";
        }else{
             $sql = "SELECT kd_layanan, nm_layanan FROM ms_layanan_blud where level = '1' AND upper(kd_layanan) like upper('%$lccr%') or upper(nm_layanan) like upper('%$lccr%')  ";
        }
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_layanan' => $resulte['kd_layanan'],  
                        'nm_layanan' => $resulte['nm_layanan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }

    function ambil_kode_subpelayanan_blud() {
        $head = $this->uri->segment(3);
        $lccr = $this->input->post('q');
        if($lccr == ''){
             $sql = "SELECT kd_layanan, nm_layanan FROM ms_layanan_blud where level = '2' and parent ='".$head."'";
        }else{
             $sql = "SELECT kd_layanan, nm_layanan FROM ms_layanan_blud where level = '2' and parent ='".$head."' AND upper(kd_layanan) like upper('%$lccr%') or upper(nm_layanan) like upper('%$lccr%')  ";
        }
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_layanan' => $resulte['kd_layanan'],  
                        'nm_layanan' => $resulte['nm_layanan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }
    
    function load_urusan() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_urusan) like upper('%$kriteria%') or kd_urusan like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_urusan_blud $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_urusan_blud $where order by kd_urusan limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_urusan' => $resulte['kd_urusan'],        
                        'kd_fungsi' => $resulte['kd_fungsi'],
                        'nm_urusan' => $resulte['nm_urusan']                                                                                        
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function ambil_urusan() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_urusan, nm_urusan FROM ms_urusan_blud where upper(kd_urusan) like upper('%$lccr%') or upper(nm_urusan) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_urusan' => $resulte['kd_urusan'],  
                        'nm_urusan' => $resulte['nm_urusan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function load_skpd() {
        $result = array();
        $row 	= array();
      	$page 	= isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows 	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_skpd) like upper('%$kriteria%') or kd_skpd like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_skpd_blud $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_skpd_blud $where order by kd_skpd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_skpd' => $resulte['kd_skpd'],        
                        'kd_urusan' => $resulte['kd_urusan'],
                        'nm_skpd' => $resulte['nm_skpd'],
                        'npwp' => $resulte['npwp'],
                        'rekening' => $resulte['rekening'],                                                                                        
                        'bank' => $resulte['bank'],                                                                                       
                        'alamat' => $resulte['alamat'],                                                                                        
                        'bendahara' => $resulte['bendahara'],                                                                                        
                        'daerah' => $resulte['daerah'],                                                                                        
                        'kop' => $resulte['kop'],
						'obskpd' => $resulte['obskpd']		
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    //toni====================================
    
	function mrekening()
    {
        $data['page_title']= 'Master Rekening Bank';
        $this->template->set('title', 'Master Rekening Bank');   
        $this->template->load('template','master/rekening/mrekening',$data); 		
    }
	
    function load_skpd2() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 100;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_skpd) like upper('%$kriteria%') or kd_skpd like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_skpd_blud $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_skpd_blud $where order by kd_skpd limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_skpd' => $resulte['kd_skpd'],        
                        'kd_urusan' => $resulte['kd_urusan'],
                        'nm_skpd' => $resulte['nm_skpd'],
                        'npwp' => $resulte['npwp'],
                        'rekening' => $resulte['rekening']                                                                                        
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
	
	//AKBAR filter skpd user--------------------------
	function ambil_skpd_user() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_skpd, nm_skpd FROM ms_skpd_blud where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') ";
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
    	   
	}
    
    function load_jns() {
        $result = array();
        $row = array();
        $sql = "SELECT 'SIMAKDA' AS ctype, '1' as jenis UNION SELECT 'SIADINDA' AS ctype, '2' as jenis";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'type' => $resulte['jenis'],        
                        'jenis' => $resulte['ctype']                                                                                 
                        );
                        $ii++;
        }
        $result["rows"] = $row; 
        echo json_encode($result);
}
    
    /*function load_jns() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 2;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(jenis) like upper('%$kriteria%') or type like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from user $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT type,IF(TYPE=1,'SIMAKDA','SIADINDA') AS jenis FROM USER $where limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'type' => $resulte['type'],        
                        'jenis' => $resulte['jenis']                                                                                 
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}*/
    
    function simpan_toni(){
        $cidus = $this->input->post('cidus');
        $cus   = $this->input->post('cus');
        $cpa   = md5($this->input->post('cpa'));
        $cty   = $this->input->post('cty');
        $cnm   = $this->input->post('cnm');
        $csikd = $this->input->post('csikd');
        $csgroup = $this->input->post('cgroup');
            
        $sql   = "select id_user from user_blud where id_user='$cidus'";
        $res   = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into user_blud(user_name,password,type,nama,kd_skpd,id_group) values ('$cus','$cpa','$cty','$cnm','1.02.02.00','$csgroup')";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    
    
    function simpan_otori_bludsasi_user($cus='',$cgroup=''){
        $cus = $cus;
        $grup = $cgroup;
		$sql = " SELECT id_user FROM user_blud WHERE user_name = '$cus' ";
                 
        $query1 = $this->db->query($sql);
        foreach($query1->result_array() as $resulte){
            $jr=$resulte['id_user'];
        }
        $sql1 = "delete from otori_blud where user_id= '$jr' ";
        $this->db->query($sql1);
		
        $sql1 = "insert into otori_blud SELECT '$jr', id_menu, '1' from d_user_group_blud WHERE id_group = '$grup'";
        $this->db->query($sql1);
        //$sq = $this->db->query($sql1);   
        //if ($sq){
        //echo '2';}else{echo '0';}                     
    }
    
	
	
	//mas tio
  function update_toni(){
        
        $cidus = $this->input->post('cidus');
        $cus   = $this->input->post('cus');
        $cpas  = $this->input->post('cpa');
        $cpa   = md5($this->input->post('cpa'));
        $cty   = $this->input->post('cty');
        $cnm   = $this->input->post('cnm');
        /*$csikd = $this->input->post('csikd');*/
        $csgroup = $this->input->post('csgroup');
            
        $sql   = "select id_user from user_blud where id_user='$cidus'";
        $res   = $this->db->query($sql);
 
       
        $pass   =mysql_query("select password from user_blud where id_user='$cidus'");
        $resulte=mysql_fetch_array($pass);
        if($res->num_rows() > 0){
            if ($resulte['password'] == $cpas){
                $sql1 = "update user_blud set user_name='$cus',password='$cpas',type='$cty',nama='$cnm',id_group='$csgroup' where id_user='$cidus'";
                $asg1 = $this->db->query($sql1);
                if($asg1){
                    echo '2';
                }else{
                    echo '0';
                }
            }else{
                 $sql = "update user_blud set user_name='$cus',password='$cpa',type='$cty',nama='$cnm',id_group='$csgroup' where id_user='$cidus'";
                $asg = $this->db->query($sql);
                if($asg){
                    echo '2';
                }else{
                    echo '0';
                }
            }
        }else{
             echo '1';
        }
    }
    
    
	
	//mas tio
    function load_otori_bludsasi() {
        
        $test= $this->uri->segment(3);
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="and a.page_id<>'0' and a.title like '%$kriteria%' or a.id like '%$kriteria%'";            
        }

        $sql="select count(*) as tot FROM dyn_menu_blud a $where";
        $query1 = $this->db->query($sql);
        $trh = $query1->row();

        //$sql = "SELECT a.id as idx,a.title as title, (SELECT IF(b.akses=1,'YA','TIDAK') FROM otori_blud b where b.menu_id=a.id AND user_id='$test') AS status FROM dyn_menu_blud a $where ORDER BY a.id
        //        limit $offset,$rows ";
        
        $sql = "SELECT a.id AS idx, a.title AS title, IF(b.akses=1,'YA','TIDAK')  AS status FROM dyn_menu_blud a
        LEFT JOIN otori_blud b ON b.menu_id = a.id WHERE b.user_id='$test' $where ORDER BY a.id limit $offset,$rows";

        $query1 = $this->db->query($sql);  


        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 

            $coba[] = array(
                        'id' => $ii,  
                        'idx' => $resulte['idx'],
                        'title'  => $resulte['title'],
                        'status'  => $resulte['status'],
                        );
                        $ii++;
        }
        
        $result["rows"] = $coba;   
		$result["total"] = $trh->tot; 				
        echo json_encode($result);
    //	$query1->free_result();   
	}
    
	
	
	//mas tio
      function yatidak() {
	$result[] = array('status' => 'YA');
	$result[] = array('status' => 'TIDAK');                       
            echo json_encode($result);    	   
    }
    
	
	//otori_bludsasi user //mas tio
    function simpan_otori_bludsasi(){
        $tet        =$this->input->post('vids');	
		$idx		=$this->input->post('idx');	
		$tt   		=$this->input->post('tt');	
		$sta	    =trim($this->input->post('st'));	
        
        if ($sta=='YA'){
            $statue='1';
        }else{
             $statue='0';
        };
        
        $sql="select menu_id FROM otori_blud where user_id='$tet' and menu_id='$idx'  ";
        $query1 = $this->db->query($sql);

        if ($query1->num_rows()>0){
           $this->db->query("update otori_blud set akses='$statue' where menu_id='$idx' and user_id='$tet'");
        }else{
           $this->db->query("insert into otori_blud(user_id,menu_id,akses) values ('$tet','$idx','$statue')");
        }

	}
    //toni=============================
    
    function ambil_skpd() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_skpd, nm_skpd FROM ms_skpd_blud where upper(kd_skpd) like upper('%$lccr%') or upper(nm_skpd) like upper('%$lccr%') ";
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
    	   
	}
    
    function load_unit() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_unit) like upper('%$kriteria%') or kd_unit like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_unit_blud $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_unit_blud $where order by kd_unit limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_unit' => $resulte['kd_unit'],        
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_unit' => $resulte['nm_unit']                                                                                      
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_unit_skpd($kode='') {                
        $sql = "SELECT * from ms_unit_blud where kd_skpd='$kode' order by kd_unit";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,
                        'kd_unit' => $resulte['kd_unit'],        
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_unit' => $resulte['nm_unit']                                                                                      
                        );
                        $ii++;
        }           
        echo json_encode($result);    	   
        //echo $result;
	}
    
    function load_program() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_prog_bludram) like upper('%$kriteria%') or kd_program like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from m_prog_blud $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from m_prog_blud $where order by kd_program limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_program' => $resulte['kd_program'],        
                        'nm_prog_bludram' => $resulte['nm_prog_bludram']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function ambil_program() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_program, nm_prog_bludram FROM m_prog_blud where upper(kd_program) like upper('%$lccr%') or upper(nm_prog_bludram) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_program' => $resulte['kd_program'],  
                        'nm_prog_bludram' => $resulte['nm_prog_bludram']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function ambil_kegiatan() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_kegiatan, nm_kegiatan FROM m_giat_blud where upper(kd_kegiatan) like upper('%$lccr%') or upper(nm_kegiatan) like upper('%$lccr%') ";
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

    
    function load_kegiatan() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_kegiatan) like upper('%$kriteria%') or kd_kegiatan like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from m_giat_blud $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from m_giat_blud $where order by kd_kegiatan limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_kegiatan' => $resulte['kd_kegiatan'], 
                        'kd_program' => $resulte['kd_program'],       
                        'nm_kegiatan' => $resulte['nm_kegiatan'],
                        'jns_kegiatan' => $resulte['jns_kegiatan']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
	
	function load_kegiatan2() {
        $kd_desa  = $this->session->userdata('kddesa');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_kegiatan) like upper('%$kriteria%') or kd_kegiatan like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from m_giat_blud $where" ;
		//$sql = "SELECT count(*) as tot from m_giat_blud" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from m_giat_blud $where order by kd_kegiatan";
		//$sql = "SELECT * from m_giat_blud order by kd_kegiatan limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_kegiatan' => $resulte['kd_kegiatan'], 
                        'kd_program' => $resulte['kd_program'],       
                        'nm_kegiatan' => $resulte['nm_kegiatan'],
                        'jns_kegiatan' => $resulte['jns_kegiatan']                                                                                
                        );
                        $ii++;
        }
		
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
	
	function load_subkegiatan() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_subkegiatan) like upper('%$kriteria%') or kd_subkegiatan like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from m_subgiat $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from m_subgiat $where order by kd_subkegiatan limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_subkegiatan' => $resulte['kd_subkegiatan'], 
                        'kd_kegiatan' => $resulte['kd_kegiatan'],       
                        'nm_subkegiatan' => $resulte['nm_subkegiatan'],
                        'jns_kegiatan' => $resulte['jns_kegiatan']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_rekening1() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek1) like upper('%$kriteria%') or kd_rek1 like'%$kriteria%')";            
        }
        
        $sql = "SELECT * from ms_rek1 $where order by kd_rek1";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek1' => $resulte['kd_rek1'],
                        'nm_rek1' => $resulte['nm_rek1']                                                                                        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function load_rekening1_64() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek1) like upper('%$kriteria%') or kd_rek1 like'%$kriteria%')";            
        }
        
        $sql = "SELECT * from ms_rek1_64 $where order by kd_rek1";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek1' => $resulte['kd_rek1'],
                        'nm_rek1' => $resulte['nm_rek1']                                                                                        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function ambil_rekening1() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek1, nm_rek1 FROM ms_rek1 where upper(kd_rek1) like upper('%$lccr%') or upper(nm_rek1) like upper('%$lccr%') ORDER BY kd_rek1";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek1' => $resulte['kd_rek1'],  
                        'nm_rek1' => $resulte['nm_rek1']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening1_64() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek1, nm_rek1 FROM ms_rek1_64 where upper(kd_rek1) like upper('%$lccr%') or upper(nm_rek1) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek1' => $resulte['kd_rek1'],  
                        'nm_rek1' => $resulte['nm_rek1']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function load_rekening2() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek2) like upper('%$kriteria%') or kd_rek2 like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek2 $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_rek2 $where order by kd_rek2";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek2' => $resulte['kd_rek2'], 
                        'kd_rek1' => $resulte['kd_rek1'],       
                        'nm_rek2' => $resulte['nm_rek2'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_rekening2_64() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek2) like upper('%$kriteria%') or kd_rek2 like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek2_64 $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_rek2_64 $where order by kd_rek2 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek2' => $resulte['kd_rek2'], 
                        'kd_rek1' => $resulte['kd_rek1'],       
                        'nm_rek2' => $resulte['nm_rek2'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening2() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek2, nm_rek2 FROM ms_rek2 where upper(kd_rek2) like upper('%$lccr%') or upper(nm_rek2) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek2' => $resulte['kd_rek2'],  
                        'nm_rek2' => $resulte['nm_rek2']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening2_64() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek2, nm_rek2 FROM ms_rek2_64 where upper(kd_rek2) like upper('%$lccr%') or upper(nm_rek2) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek2' => $resulte['kd_rek2'],  
                        'nm_rek2' => $resulte['nm_rek2']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function load_rekening3() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        $where1 ='';
		
		if ($kriteria <> ''){                               
            $where="AND (upper(nm_rek3) like upper('%$kriteria%') or kd_rek3 like'%$kriteria%')";   
			$where1="WHERE (upper(nm_rek3) like upper('%$kriteria%') or kd_rek3 like'%$kriteria%')";   
		}
             
        $sql = "SELECT count(*) as tot from ms_rek3 $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT TOP $rows * from ms_rek3 WHERE kd_rek3 NOT IN (SELECT TOP $offset kd_rek3 FROM ms_rek3 $where1 ORDER BY kd_rek3) $where order by kd_rek3";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek3' => $resulte['kd_rek3'], 
                        'kd_rek2' => $resulte['kd_rek2'],       
                        'nm_rek3' => $resulte['nm_rek3'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_rekening3_64() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek3) like upper('%$kriteria%') or kd_rek3 like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek3_64 $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_rek3_64 $where order by kd_rek3 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek3' => $resulte['kd_rek3'], 
                        'kd_rek2' => $resulte['kd_rek2'],       
                        'nm_rek3' => $resulte['nm_rek3'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening3() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek3, nm_rek3 FROM ms_rek3 where upper(kd_rek3) like upper('%$lccr%') or upper(nm_rek3) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek3' => $resulte['kd_rek3'],  
                        'nm_rek3' => $resulte['nm_rek3']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening3_64() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek3, nm_rek3 FROM ms_rek3_64 where upper(kd_rek3) like upper('%$lccr%') or upper(nm_rek3) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek3' => $resulte['kd_rek3'],  
                        'nm_rek3' => $resulte['nm_rek3']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function load_rekening4() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        $where1 ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(nm_rek4) like upper('%$kriteria%') or kd_rek4 like'%$kriteria%')";
			$where1="WHERE (upper(nm_rek4) like upper('%$kriteria%') or kd_rek4 like'%$kriteria%')";
        }
             
        $sql = "SELECT count(*) as tot from ms_rek4 $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT TOP $rows * from ms_rek4 WHERE kd_rek4 NOT IN (SELECT TOP $offset kd_rek4 FROM ms_rek4 $where1 ORDER BY kd_rek4) $where order by kd_rek4";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek4' => $resulte['kd_rek4'], 
                        'kd_rek3' => $resulte['kd_rek3'],       
                        'nm_rek4' => $resulte['nm_rek4'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_rekening4_64() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek4_64) like upper('%$kriteria%') or kd_rek4_64 like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek4_64 $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_rek4_64 $where order by kd_rek4_64 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_rek4' => $resulte['kd_rek4_64'], 
                        'kd_rek3' => $resulte['kd_rek3_64'],       
                        'nm_rek4' => $resulte['nm_rek4_64'],
                        'kelompok' => $resulte['kelompok'],
                        'lra' => $resulte['lra']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening4() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek4, nm_rek4 FROM ms_rek4 where upper(kd_rek4) like upper('%$lccr%') or upper(nm_rek4) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek4' => $resulte['kd_rek4'],  
                        'nm_rek4' => $resulte['nm_rek4']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening4_64() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek4_64, nm_rek4_64 FROM ms_rek4_64 where upper(kd_rek4_64) like upper('%$lccr%') or upper(nm_rek4_64) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_rek4' => $resulte['kd_rek4_64'],  
                        'nm_rek4' => $resulte['nm_rek4_64']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_rekening5() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where left(kd_rek5,2)='52' and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) ";
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
    

	function load_rekening5() {
        
        $result = array();
        $row    = array();
      	$page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        $where1 ='';
        if ($kriteria <> ''){                               
            $where = " AND (upper(a.nm_rek64) like upper('%$kriteria%') or a.kd_rek64 like'%$kriteria%') or
                       (upper(a.nm_rek5) like upper('%$kriteria%') or a.kd_rek5 like'%$kriteria%') ";            
			$where1 = " where (upper(a.nm_rek64) like upper('%$kriteria%') or a.kd_rek64 like'%$kriteria%') or
                       (upper(a.nm_rek5) like upper('%$kriteria%') or a.kd_rek5 like'%$kriteria%') ";            
        }
             
        $sql = "SELECT count(*) as tot from ms_rek5 a $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT TOP $rows a.*,b.nm_rek64 AS nm_lo FROM ms_rek5 a LEFT JOIN ms_rek5 b ON a.map_lo=b.kd_rek64
				WHERE a.kd_rek5 NOT IN (SELECT TOP $offset kd_rek5 FROM ms_rek5 $where1 ORDER BY kd_rek64)
		$where order by kd_rek64";
        //$sql = "SELECT TOP $rows * FROM ms_rek5_blud WHERE kd_rek5 NOT IN (SELECT TOP $offset kd_rek5 FROM ms_rek5_blud $where1 ORDER BY kd_rek5 )$where order by kd_rek5 ";


	    $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'kd_rek4' => $resulte['kd_rek4'],
                        'kd_rek4_64' => $resulte['kd_rek4_64'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'kd_rek64' => $resulte['kd_rek64'],
                        'map_lra1' => $resulte['map_lra1'],
                        'map_lo' => $resulte['map_lo'],  
                        'nm_rek5' => $resulte['nm_rek5'],
                        'nm_rek64' => $resulte['nm_rek64'],
                        'nm_reklo' => $resulte['nm_lo']                                                                                 
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}

	
    
    function load_daftar_harga() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(uraian) like upper('%$kriteria%') or kd_harga like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from ms_harga $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from ms_harga $where order by kd_rek5 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'kd_harga' => $resulte['kd_harga'],
                        'kd_rek5' => $resulte['kd_rek5'],
                        'uraian' => $resulte['uraian'],
                        'satuan' => $resulte['satuan'],  
                        'harga' => $resulte['harga'],
                        'harga1' => number_format($resulte['harga'])                                                                                  
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_bank() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nama) like upper('%$kriteria%') or kode like'%$kriteria%')";            
        }
        
        $sql = "SELECT * from ms_bank_blud $where order by kode";
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
    
    function load_ttd() {
        $kd_skpd = $this->session->userdata('kdskpd');
		$result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        $where1 ='';
        if ($kriteria <> ''){                               
            $where="AND (upper(nama) like upper('%$kriteria%') or nip like'%$kriteria%')  AND kd_skpd='$kd_skpd'";            
            $where1="WHERE (upper(nama) like upper('%$kriteria%') or nip like'%$kriteria%')  AND kd_skpd='$kd_skpd'";            
        }
             
        $sql = "SELECT count(*) as tot from ms_ttd_blud $where1" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
    /*
		$sql = "SELECT TOP $rows * from ms_ttd_blud WHERE id_urut NOT IN (SELECT TOP $offset id_urut FROM ms_ttd_blud $where1 ORDER BY id_urut) $where  order by id_urut ";
       */ 
	$sql = "SELECT * from ms_ttd_blud WHERE kd_skpd='$kd_skpd'  order by id_urut ";
    	
	$query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan'],
                        'pangkat' => $resulte['pangkat'],  
                        'kd_skpd' => $resulte['kd_skpd'],
                        'kode' => $resulte['kode']                                                                                
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_tapd() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nama) like upper('%$kriteria%') or nip like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from tapd $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from tapd $where order by nip limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'nip' => $resulte['nip'],
                        'nama' => $resulte['nama'],
                        'jabatan' => $resulte['jabatan']                                                                               
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
       function simpan_master(){
        $cskpd = $this->input->post('cskpd');
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
        $sql = "select $cid from $tabel where $cid='$lcid' and kd_skpd='$cskpd'";
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
    
    function simpan_master5(){
        
        $tabel    = $this->input->post('tabel');
        $lckolom  = $this->input->post('kolom');
        $lcnilai  = $this->input->post('nilai');
        $lckolom1 = $this->input->post('kolom1');
        $lcnilai1 = $this->input->post('nilai1');
        $cid      = $this->input->post('cid');
        $lcid     = $this->input->post('lcid');
        $cid1     = $this->input->post('cid1');
        $lcid1    = $this->input->post('lcid1');
        
        $sql = "select $cid from $tabel where $cid='$lcid'";
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
        
        $sql = "select $cid1 from $tabel where $cid1='$lcid1'";
        $res = $this->db->query($sql);
        if($res->num_rows()<1){
            $sql = "insert into $tabel $lckolom1 values $lcnilai1";
            $asg = $this->db->query($sql);
        }
    
    }
    
    function simpan_tapd(){
        
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cnip = $this->input->post('lcid');
        
        
        $sql = "delete from $tabel where nip='$cnip'";
        $asg = $this->db->query($sql);
        if($asg){
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
        }
       
    }
    
   // function update_master(){
//        $query = $this->input->post('st_query');
//        $asg = $this->db->query($query);
//
//    }
    function update_master(){
        $query = $this->input->post('st_query');
        $query1 = $this->input->post('st_query1');
        $asg = $this->db->query($query);
        if($asg){
            echo '1';
        }else{
            echo '0';
        }
        $asg1 = $this->db->query($query1);
  

    }
    
    function hapus_master(){
        
        $ctabel = $this->input->post('tabel');
        $cid = $this->input->post('cid');
        $cnid = $this->input->post('cnid');
        
        $csql = "delete from $ctabel where $cid = '$cnid'";
                
        $asg = $this->db->query($csql);
        if ($asg){
            echo '1'; 
        } else{
            echo '0';
        }
                       
    }
    
     function hapus_tapd(){
        //no:cnomor,skpd:cskpd
        $ctabel = $this->input->post('tabel');
        $cid = $this->input->post('cid');
        
        
        $csql = "delete from $ctabel where nip = '$cid'";
                
        //$sql = "delete from mbidang where bidang='$ckdbid'";
        $asg = $this->db->query($csql);
        if ($asg){
            echo '1'; 
        } else{
            echo '0';
        }
                       
    }
    
    function neraca_awal()
    {
        $data['page_title'] = 'NERACA AWAL';
        $this->template->set('title', 'NERACA AWAL');
        $this->template->load('template', 'akuntansi/neraca_awal', $data);
    }
    
    function load_neraca_awal() {
        
        
        $sql = "SELECT * from rg_neraca  order by seq";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['kode'],
                        'seq' => $resulte['seq'],
                        'aset' => $resulte['aset'],  
                        'nilai_lalu' => number_format($resulte['nilai_lalu'])                                                                                         
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function lak_awal()
    {
        $data['page_title'] = 'LAK AWAL';
        $this->template->set('title', 'LAK AWAL');
        $this->template->load('template', 'akuntansi/lak_awal', $data);
    }
    
    function load_lak_awal() {
        
        
        $sql = "SELECT * from rg_lak  order by seq";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['nor'],
                        'seq' => $resulte['seq'],
                        'aset' => $resulte['uraian'],  
                        'nilai_lalu' => number_format($resulte['nilai_lalu'])                                                                                         
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function lpe_awal()
    {
        $data['page_title'] = 'LPE AWAL';
        $this->template->set('title', 'LPE AWAL');
        $this->template->load('template', 'akuntansi/lpe_awal', $data);
    }
    
    function load_lpe_awal() {
        
        
        $sql = "SELECT * from map_lpe  order by seq";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['nor'],
                        'seq' => $resulte['seq'],
                        'uraian' => $resulte['uraian'],  
                        'nilai_lalu' => number_format($resulte['thn_m1'])                                                                                         
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function lpsal_awal()
    {
        $data['page_title'] = 'LPSAL AWAL';
        $this->template->set('title', 'LPSAL AWAL');
        $this->template->load('template', 'akuntansi/lpsal_awal', $data);
    }
    
    function load_lpsal_awal() {
        
        
        $sql = "SELECT * from map_lpsal  order by seq";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kode' => $resulte['nor'],
                        'seq' => $resulte['seq'],
                        'uraian' => $resulte['uraian'],  
                        'nilai_lalu' => number_format($resulte['thn_m1'])                                                                                         
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function _mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font=12,$orientasi='') {
        
        ini_set("memory_limit","512M");
        $this->load->library('mpdf');
        
        /*
        $this->mpdf->progbar_altHTML = '<html><body>
	                                    <div style="margin-top: 5em; text-align: center; font-family: Verdana; font-size: 12px;"><img style="vertical-align: middle" src="'.base_url().'images/loading.gif" /> Creating PDF file. Please wait...</div>';        
        $this->mpdf->StartProgressBarOutput();
        */
        
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        
        //$this->mpdf->SetHeader('SIMAKDA||');
        $jam = date("H:i:s");
        //$this->mpdf->SetFooter('Printed on @ {DATE j-m-Y H:i:s} |Simakda| Page {PAGENO} of {nb}');
        $this->mpdf->SetFooter('Printed on @ {DATE j-m-Y H:i:s} |Halaman {PAGENO} / {nb}| ');
        
        $this->mpdf->AddPage($orientasi);
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);
         
        $this->mpdf->Output();
    }
    
    function load_dana() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = '';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_sdana) like upper('%$kriteria%') or kd_sdana like'%$kriteria%')";            
        }
        
        $sql    = "SELECT * from ms_dana_blud $where order by kd_sdana";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_sdana' => $resulte['kd_sdana'],
                        'jenis' => $resulte['jenis'],
                        'nm_sdana' => $resulte['nm_sdana']                                                                                        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}

    function load_unit_layanan() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = '';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_unit) like upper('%$kriteria%') or kd_unit like'%$kriteria%')";            
        }
        
        $sql    = "SELECT * from ms_unit_layanan_blud $where order by kd_unit";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_unit' => $resulte['kd_unit'],
                        'parent' => $resulte['parent'],
                        'nm_unit' => $resulte['nm_unit']                                                                                        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }

    function load_pelayanan_blud() {
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = '';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_layanan) like upper('%$kriteria%') or kd_layanan like'%$kriteria%')";            
        }
        
        $sql    = "SELECT * from ms_layanan_blud $where order by kd_layanan";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_layanan' => $resulte['kd_layanan'],
                        'parent' => $resulte['parent'],
                        'nm_layanan' => $resulte['nm_layanan']                                                                                        
                        );
                        $ii++;
        }
           
        echo json_encode($result);
           
    }
    
    function mhukum()
    {
        $data['page_title']= 'Master Dasar Hukum';
        $this->template->set('title', 'Master Dasar Hukum');   
        $this->template->load('template','master/fungsi/mhukum',$data) ; 
    }
    
    function load_dhukum(){
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = '';
        if ($kriteria <> ''){                               
            $where="where (upper(nm_hukum) like upper('%$kriteria%') or kd_hukum like'%$kriteria%')";            
        }
        
        $sql    = "SELECT * from m_hukum $where order by kd_hukum";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_hukum' => $resulte['kd_hukum'],
                        'nm_hukum' => $resulte['nm_hukum']                                                                                        
                        );
                        $ii++;
        }
        echo json_encode($result);
	}
    
    
    function load_daftar_harga_ar() {
       
        $result   = array();
        $row      = array();
      	$page     = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows     = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset   = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where    = '';
        
        if ($kriteria <> ''){                               
            $where="where (upper(nm_rek5) like upper('%$kriteria%') or kd_rek5 like'%$kriteria%')";            
        }
             
        $sql    = "SELECT count(*) as tot from trhharga $where" ;
        $query1 = $this->db->query($sql);
        $total  = $query1->row();
        
        $sql    = "SELECT * from trhharga $where order by kd_rek5 limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,        
                        'kd_rek5' => $resulte['kd_rek5'],
                        'nm_rek5' => $resulte['nm_rek5']
                        );
                        $ii++;
        }
        $result["total"] = $total->tot;
        $result["rows"]  = $row; 
        echo json_encode($result);
	}


    function load_daftar_harga_detail_ar($norek='') {
       
        $norek  = $this->input->post('rekening') ;

        $sql    = "SELECT * from trdharga where kd_rek5 = '$norek' order by no_urut ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'         => $ii,        
                        'no_urut'    => $resulte['no_urut'],
                        'kd_rek5'    => $resulte['kd_rek5'],
                        'uraian'     => $resulte['uraian'],
                        'merk'       => $resulte['merk'],
                        'satuan'     => $resulte['satuan'],
                        //'harga'      => number_format($resulte['harga'],"2",".",","),
                        'harga'      => $resulte['harga'],
                        'keterangan' => $resulte['keterangan']
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
    
    
    function simpan_detail_standar_harga() {
        
        $proses = $this->input->post('proses');
        if ( $proses == 'detail' ) {

                $tabel_detail = $this->input->post('tabel_detail');
                $sql_detail   = $this->input->post('sql_detail');
                $nomor        = $this->input->post('nomor');
                
                $sql          = " delete from trdharga where kd_rek5='$nomor' ";
                $asg          = $this->db->query($sql) ;
    
                $sql          = " insert into trdharga (no_urut,kd_rek5,uraian,merk,satuan,harga,keterangan)  "; 
                $asg_detail   = $this->db->query($sql.$sql_detail);
                
                if ( $asg_getail > 0 ){
                   echo '1';     
                } else {
                   echo '0';
                }
        }            
    }
    
    function load_daftar_harga_detail($norek='') {
       
        $norek  = $this->input->post('rekening') ;

        $sql    = "SELECT * from trdharga where kd_rek5 = '$norek' order by no_urut ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii     = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(
                        'id'         => $ii,        
                        'no_urut'    => $resulte['no_urut'],
                        'kd_rek5'    => $resulte['kd_rek5'],
                        'uraian'     => $resulte['uraian'],
                        'merk'       => $resulte['merk'],
                        'satuan'     => $resulte['satuan'],
                        //'harga'      => number_format($resulte['harga'],"2",".",","),
                        'harga'      => $resulte['harga'],
                        'keterangan' => $resulte['keterangan']
                        );
                        $ii++;
        }
        echo json_encode($result);
    }
    
    function ambil_rekening5_ar() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where left(kd_rek5,2)='52' and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) order by kd_rek5";
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
        

    function ambil_rekening5_all_ar_ms() {
        
        $lccr    = $this->input->post('q');
        $notin   = $this->input->post('reknotin');
        $jnskegi = $this->input->post('jns_kegi');
        
        if ( $notin <> ''){
            $where = " and kd_rek5 not in ($notin) ";
        } else {
            $where = " ";
        }
        
        if ( $jnskegi =='4' ) {
            $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where ( left(kd_rek5,1)='4' )
                    and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) $where order by kd_rek5";
        } elseif ( $jnskegi=='51' or $jnskegi=='52' ){
                $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where ( left(kd_rek5,1)='5')
                        and (upper(kd_rek5) like upper('%$lccr%') or upper(nm_rek5) like upper('%$lccr%')) $where order by kd_rek5";
            } else {
                $sql = "SELECT kd_rek5, nm_rek5 FROM ms_rek5 where ( left(kd_rek5,1)='6' or left(kd_rek5,1)='7' )
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
	
	function cmb_ttd(){
		$lccr	= $this->input->post('q');
		$skpd	= $this->input->post('skpd');
		$and_	= $this->input->post('and_');
		$sql	= "	SELECT nip, nama, jabatan FROM ms_ttd_blud WHERE kd_skpd = '$skpd'  $and_ 
					AND (UPPER(nip) LIKE UPPER('%$lccr%') OR UPPER(nama) LIKE UPPER('%$lccr%'))";
        $query1 = $this->db->query($sql);
        $result = array();
        $ii		= 0;
		$query1->free_result();
        foreach($query1->result_array() as $resulte){
			$result[] = array(
				'id'		=> $ii,
				'nip'		=> $resulte['nip'],
				'nama'		=> $resulte['nama'],
				'jabatan'	=> $resulte['jabatan']
			);
			$ii++;
		}
		echo json_encode($result);
	}
	

}
