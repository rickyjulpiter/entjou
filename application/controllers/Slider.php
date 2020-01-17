<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {
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
        $data=array(
            'title'     => 'Manajemen Slider',
            'isi'       => 'backend/view_slider',
        );
        $this->load->view('layout', $data);
        
    }
    function slider_data(){
        $aColumns = array('id_slider', 'judul', 'deskripsi', 'publish', 'waktu_edit', 'id_slider'); 
        $sIndexColumn = "id_slider"; //primary key
        $where = "id_slider!=''";
        $dt = $this->data('slider', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            if ($data['publish']=="Y") {
                $publish = "<label class='label label-success'>Tampil</label>";
            }else{
                $publish = "<label class='label label-danger'>Tidak Tampil</label>";
            }
            if (empty($data['judul']) || $data['judul']==NULL) {
                $judul = '-';
            }else{
                $judul = $data['judul'];
            }

            if (empty($data['deskripsi']) || $data['deskripsi']==NULL) {
                $deskripsi = '-';
            }else{
                $deskripsi = strip_tags(Tools::limit_words($data['deskripsi'],10)).' ....';
            }
            $appath = realpath(APPPATH . '../assets/images/slider/thumbnail/'.$data['foto']);
            if(!empty($data['foto']) and file_exists($appath)){
                $image = base_url().'assets/images/slider/thumbnail/'.$data['foto'];
            }else{
                $image = base_url().'assets/images/no-image.jpg';

            }
            $foto = '<img src="'.$image.'" width="50" alt="slider">';
            $output['data'][]=array(
                $nomor_urut, 
                $foto,               
                $judul,
                $deskripsi,
                $publish,                
                $data['waktu_edit'],                
                "<a href='".base_url().$this->uri->segment(1)."/slider_detail/".$this->encrypt->encode($data['id_slider'])."' class='btn btn-warning btn-sm' data-original-title='Ubah Data' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
                <a href='javascript:;' data-hapus='".$this->encrypt->encode($data['id_slider'])."' class='btn btn-danger btn-sm hapus' data-original-title='Hapus Data' data-toggle='tooltip'><i class='fa fa-trash'></i></a>"
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }
    function slider_detail($id=NULL){                  

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');        
        
        if ($this->form_validation->run() != false) { //insert                
            $id = $this->encrypt->decode($this->input->post('id'));
            if ($_FILES['cover']['name']) {                    
                $path   = '../assets/images/slider/';
                $lokasi = realpath(APPPATH . $path);
                $nmfile = "slider_".date('Y-m-d H-i-s').'_'.strtolower($this->input->post('judul'));
                $cover = $this->upload_foto($lokasi,$path,$nmfile);
            }else if(empty($_FILES['cover']['name'])){
                $cover=$this->input->post('covers');
            }
            $data  = array(
                'judul'         => $this->input->post('judul'),
                'deskripsi'     => $this->input->post('deskripsi'),
                'foto'          => $cover,                
                'publish'       => $this->input->post('publish'),
                'id_user_edit'  => $this->id_user,
                'nama_user_edit'=> $this->nama,
                'waktu_edit'    => date('Y-m-d H:i:s')
            );
            if (empty($id)) {
                $data['id_user_post']   = $this->id_user;
                $data['nama_user_post'] = $this->nama;
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('slider', $data);
            }else{
                $where = array('id_slider'=>$id);
                if(!empty($_FILES['cover']['name'])){
                    $dt_foto = $this->model_admin->select_data('slider',null,$where);
                    $appath = realpath(APPPATH . '../assets/images/slider/'.$dt_foto[0]['foto']);
                    $appath_thumb = realpath(APPPATH . '../assets/images/slider/thumbnail/'.$dt_foto[0]['foto']);

                    if(!empty($dt_foto[0]['foto']) and file_exists($appath)){
                        unlink($appath);                        
                    }                   
                    if(!empty($dt_foto[0]['foto']) and file_exists($appath_thumb)){
                        unlink($appath_thumb);
                    }                        
                }
                $this->model_admin->update_data('slider', $data, $where);
            }
            redirect('slider');
        }else{
            $id = $this->encrypt->decode($id);
            if (!empty($id)) {
                $data=$this->model_admin->select_data('slider', null, array('id_slider'=>$id));
            }else{
                $data='';
            }
            $data=array('title' => 'Data Slider',
                'data'          => $data,
                'isi'           => 'backend/view_slider_detail',
            );
            $this->load->view('layout', $data);
        }
    } 
    function slider_hapus(){
        $id = $this->encrypt->decode($this->input->post('hapus'));
        if (!empty($id)) {
            $where = array('id_slider'=>$id);
            $dt_foto = $this->model_admin->select_data('slider',null,$where);
            $appath = realpath(APPPATH . '../assets/images/slider/'.$dt_foto[0]['foto']);
            $appath_thumb = realpath(APPPATH . '../assets/images/slider/thumbnail/'.$dt_foto[0]['foto']);

            if(!empty($dt_foto[0]['foto']) and file_exists($appath)){
                unlink($appath);                        
            }                   
            if(!empty($dt_foto[0]['foto']) and file_exists($appath_thumb)){
                unlink($appath_thumb);
            }
            $response = $this->model_admin->delete_data('slider', $where);
            echo json_encode($response);
        }
    }
   
    /*--------------------- <tools> ----------------------*/
    function data($table, $where, $sIndexColumn, $aColumns){  
        error_reporting(0);
        $sLimit = "";if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' ){$sLimit = "LIMIT ".$this->security->xss_clean( $_REQUEST['iDisplayStart'] ).", ".$this->security->xss_clean( $_REQUEST['iDisplayLength'] );}$numbering = $this->security->xss_clean( $_REQUEST['iDisplayStart'] );$page = 1;/*//pagging // ordering*/if ( isset( $_REQUEST['iSortCol_0'] ) ){$sOrder = "ORDER BY  ";for ( $i=0 ; $i<intval( $_REQUEST['iSortingCols'] ) ; $i++ ){if ( $_REQUEST[ 'bSortable_'.intval($_REQUEST['iSortCol_'.$i]) ] == "true" ){$sOrder .= $aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ]." ".$this->security->xss_clean( $_REQUEST['sSortDir_'.$i] ) .", ";}}$sOrder = substr_replace( $sOrder, "", -2 );if ( $sOrder == "ORDER BY" ){$sOrder = "";}}/*// filtering*/$sWhere = "";if ( $_REQUEST['sSearch'] != "" ){$sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){$sWhere .= $aColumns[$i]." LIKE '%".$this->security->xss_clean( $_REQUEST['sSearch'] )."%' OR ";}$sWhere = substr_replace( $sWhere, "", -3 );$sWhere .= ')';}/*// individual column filtering*/for ( $i=0 ; $i<count($aColumns) ; $i++ ){if ( $_REQUEST['bSearchable_'.$i] == "true" && $_REQUEST['sSearch_'.$i] != '' ){if ( $sWhere == "" ){$sWhere = "WHERE ";}else{$sWhere .= " AND ";}$sWhere .= $aColumns[$i]." LIKE '%".$this->security->xss_clean($_REQUEST['sSearch_'.$i])."%' ";}}
        
        $rResult = $this->model_admin->get_data($table,$where,$aColumns, $sWhere, $sOrder, $sLimit, 'x'); 
        $iFilteredTotal = 10;
        $rResultTotal = $this->model_admin->get_data($table,$where,$aColumns, $sWhere, NULL, NULL, $sIndexColumn); 
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;
        
        $output = array("sEcho" => intval($_REQUEST['sEcho']),"iTotalRecords" => $iTotal,"iTotalDisplayRecords" => $iFilteredTotal,"data" => array());
        
        $nomor_urut=$_REQUEST['iDisplayStart']+1;

        return array($nomor_urut, $rResult, $output);
    }
    function input($post,$data){
        if($this->input->post($post)){
            echo $this->input->post($post);
        }elseif (!empty($data)) {
            echo $data;
        }
    }
    function notif($button,$pesan){
        $this->session->set_flashdata('notif','<center><div class="alert alert-'.$button.'" role="alert" style="border:solid 1px;">'.$pesan.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }
     /*-------------------------upload foto------------------------*/ 
    function resize($letakhasil, $width) {
        $config['source_image'] = $letakhasil;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;

        $this->load->library('image_lib', $config);
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        
        return $this->compress_img($letakhasil);
    }
    function thumbnail($lokasi, $gambar, $width) {
        $config['source_image'] = $lokasi.'/'.$gambar;
        $config['new_image'] = $lokasi.'/thumbnail/'.$gambar;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;

        $this->load->library('image_lib', $config);
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
        
        return $this->compress_img($config['new_image']);
    }    
    function compress_img($picture){
        $tipe = pathinfo($picture, PATHINFO_EXTENSION);
        $output = str_replace(".$tipe", '', $picture);
        if($tipe == 'png' or $tipe == 'PNG'){
            $image = imagecreatefrompng($picture);
        }else if($tipe == 'jpeg' or $tipe == 'jpg' or $tipe == 'JPG' or $tipe == 'JPEG'){
            $image = imagecreatefromjpeg($picture);
        }else if($tipe == 'gif'){
            $image = imagecreatefromgif($picture);
        }else{
            show_error('Terjadi Kesalahan', '400 Bad Request', $heading = '400 Bad Request');
        }            
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
        rename($picture, $output . ".jpg");
        imagejpeg($bg, $output . ".jpg", $quality);
        imagedestroy($bg);
        $name=pathinfo($picture, PATHINFO_FILENAME).'.jpg';

        return $name;
    }    
    function upload_foto($lokasi,$path,$nmfile){        
        $config['upload_path']      = $lokasi;
        $config['allowed_types']    = 'jpg||png||PNG||jpeg||bmp';
        $config['file_name']        = $nmfile;
        $config['remove_spaces']    = TRUE;
        $this->load->library('upload', $config);
        $this->upload->do_upload('cover');
        $cover = $this->upload->file_name;
        $letakhasil   = realpath(APPPATH . $path.$cover);
        //rotate
        $rot = $this->input->post('rotate');
        if ($rot!=0) {
            if ($rot < 0) {$rotate = 360 - str_replace('-', '', $rot);}else{$rotate = $rot;}
            $config['source_image'] = $letakhasil;
            $config['rotation_angle'] = $rotate;
            $this->load->library('image_lib', $config);
            $this->image_lib->initialize($config);
            $this->image_lib->rotate();
            $this->image_lib->clear();
            $config = array();
        }
        //flip
        if ($this->input->post('flipx') == -1) {
            if ($rotate == 90 OR $rotate == 270) {$rot = 'hor';}else{$rot = 'vrt';}
            $config['source_image'] = $letakhasil;
            $config['rotation_angle'] = $rot;
            $this->load->library('image_lib', $config);
            $this->image_lib->initialize($config);
            $this->image_lib->rotate();
        }
        if ($this->input->post('flipy') == -1) {
            if ($rotate == 90 OR $rotate == 270) {$rot = 'vrt';}else{$rot = 'hor';}
            $config['source_image'] = $letakhasil;
            $config['rotation_angle'] = $rot;
            $this->load->library('image_lib', $config);
            $this->image_lib->initialize($config);
            $this->image_lib->rotate();
            $this->image_lib->clear();
            $config = array();
        }
        //crop
        $config['source_image'] = $letakhasil;
        $config['maintain_ratio'] = false;
        $config['width']  = $this->input->post('width');
        $config['height'] = $this->input->post('height');
        $config['x_axis'] = $this->input->post('x');
        $config['y_axis'] = $this->input->post('y');
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        $this->image_lib->crop();
        $cover = $this->resize($letakhasil, 600);
        $cover = explode('.', $cover);
        $cover = $this->thumbnail($lokasi, $cover[0].'.jpg', 200);
        return $cover;
    }
    /*-------------------------/upload foto------------------------*/
    function by($id_user){
        $data = $this->model_admin->select_data('users',null,array('id_user'=>$id_user));
        return $data;
    }

}
