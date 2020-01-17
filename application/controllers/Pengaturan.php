<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
    }    
    function index(){
        $data=array('title' => 'Pengaturan',            
            'isi'           => 'backend/pengaturan',
            'data'          => $this->model_admin->select_data('pengaturan',null,array('id_pengaturan'=>'1'))
        );
        $this->load->view('layout', $data);
    }
    function pengaturan_simpan(){
        $this->load->library('image_lib');
        $this->load->library('upload');
        $dtFoto = $this->model_admin->select_data('pengaturan',null,array('id_pengaturan'=>1));
        if ($_FILES['inputImage']['name']) {
            $fav  = $dtFoto[0]['logo'];
            $path = realpath(APPPATH . '../assets/images/'.$fav);
            $ada  = file_exists($path);
            if(!empty($fav) and $ada){
                unlink($path);
            }
            $nmfile = 'logo.png';
            $config['upload_path'] = realpath(APPPATH . '../assets/images/');
            $config['allowed_types'] = 'gif|png|jpg|jpeg|bmp';          
            $config['file_name'] = $nmfile;

            $this->upload->initialize($config);
            $this->upload->do_upload('inputImage');
            $foto = $this->upload->file_name;

            $config1y['source_image'] = realpath(APPPATH.'../assets/images/'.$foto);
            $config1y['width']        = 400;
            $config1y['quality']      = 80;

            $this->image_lib->initialize($config1y);
            $this->image_lib->resize();         

        }else if(empty($_FILES['inputImage']['name'])){
            $foto=$dtFoto[0]['logo'];
        }
        $data = array(
            'logo'          => $foto,
            'nama_website'  => $this->input->post('nama_website'),
            'hape'          => $this->input->post('hape'),            
            'alamat'        => $this->input->post('alamat'),
            'deskripsi'     => $this->input->post('deskripsi'),            
            'email'         => $this->input->post('email'),            
            'facebook'      => $this->input->post('facebook'),
            'instagram'     => $this->input->post('instagram'),
            'twitter'       => $this->input->post('twitter'),
            'youtube'       => $this->input->post('youtube'),
        );
        $this->db->update('pengaturan',$data,array('id_pengaturan'=>1));
        $this->notif('success','Data pengaturan website berhasil disimpan');
        redirect('pengaturan');
    }
    function notif($button,$pesan){
        $this->session->set_flashdata('notif','<center><div class="alert alert-'.$button.'" role="alert" style="border:solid 1px;">'.$pesan.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }

}
