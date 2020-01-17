<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    function __construct(){
        parent::__construct();        
        $this->load->model('model_admin');
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        if (($this->tipe_user=="admin" OR $this->tipe_user=="guru") AND !empty($this->tipe_user)) {
            
        }else{
            show_404();
        }
    }
    public function index(){     
    	$data = $this->model_admin->select_data('_kelas','id_guru');
    	$id_guru = array();
    	foreach ($data as $key => $value) {
    		$id_guru [] = $value['id_guru'];

    	}

    	$x = "";
    	foreach ($id_guru as $key => $value) {
    		$x .= $value.',';
    	}
    	$y = explode(",", $x);
    	$z = array_unique($y);
    	
    	$guru    = count($z)-1;
    	$peserta = count($this->model_admin->select_data('pesanan','id_pesanan',array('status'=>'dibayar')));
    	$materi  = count($this->model_admin->select_data('_materi','id_materi'));
        $blog    = count($this->model_admin->select_data('blog','id_post',array('publish'=>'Y')));
        $pesanan = count($this->model_admin->select_data('pesanan','id_pesanan',array('status'=>'menunggu_bayar')));
        $checkup = count($this->model_admin->select_data('checkup','id_checkup',array('status'=>'N')));
        $data = array(
            'title'     => 'Dashboard',
            'guru'		=> $guru,
            'peserta'	=> $peserta,
            'materi'	=> $materi,
            'blog'      => $blog,
            'pesanan'   => $pesanan,
            'checkup'   => $checkup,
            'isi'       => 'backend/view_dashboard'
        );   
        $this->load->view('layout',$data);
        
    }
    
}