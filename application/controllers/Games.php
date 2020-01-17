<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');   
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
        if (($this->tipe_user=="admin" OR $this->tipe_user=="guru") AND !empty($this->tipe_user)) {
        }else{
            show_404();
        }
    }    
    function index(){        
        $data=array(
            'title'     => 'Manajemen Games',
            'isi'       => 'backend/view_materi'
        );
        $this->load->view('layout', $data);
        
    }
    function games_detail(){                 
        $this->form_validation->set_rules('judul_games', 'Judul', 'trim|required');
                
        if ($this->form_validation->run() != false) { //insert                
            $id = $this->input->post('id_games');
            if ($_FILES['cover']['name']) {                    
                $path   = '../assets/games/';
                $lokasi = realpath(APPPATH . $path);
                $nmfile = "games_".strtolower($this->input->post('judul_games'));
                $cover = $this->upload_foto($lokasi,$path,$nmfile);
            }else if(empty($_FILES['cover']['name'])){
                $cover=$this->input->post('covers');
            }
            $id_materi  = $this->input->post('id_materi');
            $id_stage   = $this->input->post('id_stage');
            $id_kelas   = $this->input->post('id_kelas');
            $nama_stage = $this->input->post('nama_stage');
            $nama_kelas = $this->input->post('nama_kelas');
            $data  = array(
                'id_materi'     => $id_materi,
                'id_stage'      => $id_stage,
                'id_kelas'      => $id_kelas,
                'judul_games'   => $this->input->post('judul_games'),
                'detail_games'  => $this->input->post('detail_games'),
                'id_user'       => $this->id_user,
                'file_games'    => $cover,
                'nama_user'     => $this->nama,
                'waktu_edit'    => date('Y-m-d H:i:s')
            );
            if (empty($id)) {                
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('_games', $data);
                $this->notif('success','Games <b>"'.$this->input->post('judul_games').'"</b> Berhasil ditambahkan');
            }else{
                $where = array('id_materi'=>$id_materi);
                if(!empty($_FILES['cover']['name'])){
                    $dt_foto = $this->model_admin->select_data('_games',null,$where);
                    $appath = realpath(APPPATH . '../assets/games/'.$dt_foto[0]['file_games']);
                    $appath_thumb = realpath(APPPATH . '../assets/games/thumbnail/'.$dt_foto[0]['file_games']);

                    if(!empty($dt_foto[0]['file_games']) and file_exists($appath)){
                        unlink($appath);                        
                    }                   
                    if(!empty($dt_foto[0]['file_games']) and file_exists($appath_thumb)){
                        unlink($appath_thumb);
                    }                        
                }
                $this->model_admin->update_data('_games', $data, $where);
                $this->notif('success','Games <b>"'.$this->input->post('judul_games').'"</b> Berhasil diperbarui');
            }            
            redirect('materi');
        }else{
            $id = $this->encrypt->decode($this->input->get('id_materi'));
            if (!empty($id)) {
                $data=$this->model_admin->select_data('_games', null, array('id_materi'=>$id));
            }else{
                $data='';
            }
            $data=array('title' => 'Data Games',
                'data'          => $data,
                'isi'           => 'backend/view_games_detail',
            );
            $this->load->view('layout', $data);
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
        $quality = 75; // 0 = worst / smaller file, 100 = better / bigger file 
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

