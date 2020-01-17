<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {
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
            'title'     => 'Manajemen Materi',
            'isi'       => 'backend/view_materi'
        );
        $this->load->view('layout', $data);
        
    }
    function kelas_guru(){
        $id_guru = "'".$this->id_user."'";
        $guru = $this->model_admin->select_data('_kelas','id_kelas, id_guru',array('status'=>'Y'),null,null,null,null,'id_guru',$id_guru);
        $id_kelas_guru = "";
        $ar_id_kelas_guru = array();
        foreach ($guru as $key => $value) {
            if ($key==(count($guru)-1)) {
                $id_kelas_guru .= $value['id_kelas'];
            }else{
                $id_kelas_guru .= $value['id_kelas'].',';
            }
            $ar_id_kelas_guru [] = $value['id_kelas'];
            
        }
        return array($id_kelas_guru,$ar_id_kelas_guru);
    }

    function materi_data(){
        $id_kelas   = $this->input->get('id_kelas');
        $nama_kelas = $this->input->get('nama_kelas');
        $id_stage   = $this->input->get('id_stage');
        $nama_stage = $this->input->get('nama_stage');
        if (!empty($id_kelas)) {
            $where = 'id_kelas="'.$this->encrypt->decode($id_kelas).'" AND id_stage="'.$this->encrypt->decode($id_stage).'"';
        }else{
            if ($this->tipe_user=="admin") {
                $where = 'id_materi!=""';
            }elseif ($this->tipe_user=="guru") {
                $where = "id_kelas IN (".$this->kelas_guru()[0].")";
            }
        }
        $aColumns = array('id_materi', 'nama_kelas', 'nama_stage', 'judul_materi', 'id_materi', 'id_materi', 'id_materi', 'id_materi'); 
        $sIndexColumn = "id_materi"; //primary key
        
        $dt = $this->data('_materi', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            $id_kelas   = $this->encrypt->encode($data['id_kelas']);
            $nama_kelas = $data['nama_kelas'];
            $id_stage   = $this->encrypt->encode($data['id_stage']);
            $nama_stage = $data['nama_stage'];
            
            $games      = $this->get('_games',$data['id_materi']);
            $quiz       = $this->get('_quiz',$data['id_materi']);
            $project    = $this->get('agenda',$data['id_materi']);
            if (empty($games)) {
                $style_g = "style='border:2px solid red;color:red'";
                $fw_g    = "<i class='fa fa-times'></i>";
                $title_g = "Games belum ada. Silahkan tambah!";                
            }else{
                $style_g   = "";
                $fw_g    = "<i class='fa fa-gamepad'></i>";
                $title_g = "Lihat Games";
            }
            if(empty($quiz)){
                $style_q = "style='border:2px solid red;color:red;'";
                $fw_q    = "<i class='fa fa-times'></i>";
                $title_q = "Quiz belum ada. Silahkan tambah!";
            }else{
                $style_q   = "";
                $fw_q    = "<i class='fa fa-puzzle-piece'></i>";
                $title_q = "Lihat Quiz";
            }
            if (empty($project)) {
                $style_p = "style='border:2px solid red;color:red;'";
                $fw_p    = "<i class='fa fa-times'></i>";
                $title_p = "Project belum ada";
            }else{
                $style_p = "";
                $fw_p    = "<i class='fa fa-rocket'>";
                $title_p = "Lihat Project";
            }

            $materi = "<a href='".base_url()."materi/materi_detail?id_kelas=".$id_kelas.'&nama_kelas='.$nama_kelas.'&id_stage='.$id_stage.'&nama_stage='.$nama_stage."&id_materi=".$this->encrypt->encode($data['id_materi'])."' class='btn btn-warning btn-sm tooltips' data-original-title='Lihat Materi' data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-laptop'></i></a>";
            $games  = "<a href='".base_url()."games/games_detail?id_kelas=".$id_kelas.'&nama_kelas='.$nama_kelas.'&id_stage='.$id_stage.'&nama_stage='.$nama_stage."&id_materi=".$this->encrypt->encode($data['id_materi'])."' class='btn btn-info btn-sm tooltips' data-original-title='$title_g' data-toggle='tooltip' data-placement='top' $style_g>$fw_g</a>";
            $quiz   = "<a href='".base_url()."quiz/quiz_detail?id_kelas=".$id_kelas.'&nama_kelas='.$nama_kelas.'&id_stage='.$id_stage.'&nama_stage='.$nama_stage."&id_materi=".$this->encrypt->encode($data['id_materi'])."' class='btn btn-primary btn-sm tooltips' data-original-title='$title_q' data-toggle='tooltip' data-placement='top' $style_q>$fw_q</a>";
            $project= "<a href='".base_url()."project?id_kelas=".$id_kelas.'&nama_kelas='.$nama_kelas.'&id_stage='.$id_stage.'&nama_stage='.$nama_stage."&id_materi=".$this->encrypt->encode($data['id_materi']).'&judul_materi='.$data['judul_materi']."' class='btn btn-success btn-sm tooltips' data-original-title='$title_p' data-toggle='tooltip' data-placement='top' $style_p>$fw_p</i></a>";
            $hapus   = "<a href='javascript:;' data-hapus='".$this->encrypt->encode($data['id_materi'])."' type='button' class='btn btn-danger btn-sm tooltips hapus' data-original-title='Hapus Data' data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-trash'></i></a>";
                
            //}
            $output['data'][]=array(
                $nomor_urut,                
                $data['nama_kelas'],
                $data['nama_stage'],
                ucwords(strtolower($data['judul_materi'])),
                $materi,
                $games,
                $quiz,
                $project,
                $hapus
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }

    function coba(){
        $file = file_get_contents("./assets/materi/pdf_0 menyusun strategi perang (bmc).txt");
        $berkas = "data:application/pdf;base64,".$file."#toolbar=0";
        echo $berkas;        
        /*$data = file_get_contents("./assets/materi/Prototype.pdf");
        $base64 = 'data:application/pdf;base64,'. base64_encode($data);
        echo $base64;*/
        /*echo $base64;*/
    }

    function coba1(){
        $this->load->view('backend/coba');
    }        
    
    function materi_detail(){
        $this->load->library('upload'); 
        $this->form_validation->set_rules('judul_materi', 'Judul', 'trim|required');
        
        if ($this->form_validation->run() != false) { //insert                
            $id_materi = $this->input->post('id_materi');

            $dtFile = $this->model_admin->select_data('_materi',null,array('id_materi'=>$id_materi));

            /*------------ Input file video --------------*/
            if ($this->input->post('jenis')=="video") {
                if ($_FILES['inputVideo']['name']) {
                    $db_file = $dtFile[0]['file_materi'];
                    $path = realpath(APPPATH . '../assets/materi/'.$db_file);
                    $ada  = file_exists($path);
                    if(!empty($db_file) and $ada){
                        unlink($path);
                    }
                    $nmfile = 'video_'.str_replace(".", "", strtolower($this->input->post('judul_materi')));
                    $config['upload_path'] = realpath(APPPATH . '../assets/materi/');
                    $config['allowed_types'] = 'mp4|flv|wmv|ogg|webm|mpeg|mpg';          
                    $config['file_name'] = $nmfile;

                    $this->upload->initialize($config);
                    $this->upload->do_upload('inputVideo');
                    $namafile = $this->upload->file_name;
                }else if(empty($_FILES['inputVideo']['name'])){
                	if (!empty($id_materi)) {
                		$namafile = $dtFile[0]['file_materi'];
                	}else{
                		$namafile = "";
                	}
                    
                }
            }
            /*------------ Input file pdf --------------*/
            elseif ($this->input->post('jenis')=="pdf") {
                if ($_FILES['inputPdf']['name']) {
                    $db_file = $dtFile[0]['file_materi'];
                    $path = realpath(APPPATH . '../assets/materi/'.$db_file);
                    $ada  = file_exists($path);
                    if(!empty($db_file) and $ada){
                        unlink($path);
                    }
                    $nmfile = 'pdf_'.str_replace(".", "", strtolower($this->input->post('judul_materi')));
                    $config['upload_path'] = realpath(APPPATH . '../assets/materi/');
                    $config['allowed_types'] = 'pdf';          
                    $config['file_name'] = $nmfile;

                    $this->upload->initialize($config);
                    $this->upload->do_upload('inputPdf');
                    $namafile = $this->upload->file_name;
                }else if(empty($_FILES['inputPdf']['name'])){
                	if (!empty($id_materi)) {
                		$namafile = $dtFile[0]['file_materi'];
                	}else{
                		$namafile = "";
                	}
                    
                }
            }
            
            $kelas = explode("#", $this->input->post('kelas'));
            $stage = explode("#", $this->input->post('stage'));
            $data  = array(
                'id_stage'      => $stage[0],
                'nama_stage'    => $stage[1],
                'id_kelas'      => $kelas[0],
                'nama_kelas'    => $kelas[1],
                'judul_materi'  => ucwords($this->input->post('judul_materi')),
                'file_materi'   => $namafile,
                'jenis'         => $this->input->post('jenis'),
                'detail_materi' => $this->input->post('detail_materi'),
                'id_user'       => $this->id_user,
                'nama_user'     => $this->nama,                
                'waktu_edit'    => date('Y-m-d H:i:s')
            );
            if (empty($id_materi)) {
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('_materi', $data);
                $this->notif('success','Materi <b>"'.$this->input->post('judul_materi').'"</b> Berhasil ditambahkan');
            }else{
                $where = array('id_materi'=>$id_materi);                
                $this->model_admin->update_data('_materi', $data, $where);
                $this->notif('success','Materi <b>"'.$this->input->post('judul_materi').'"</b> Berhasil diperbarui');
            }
            redirect('materi');
        }else{
            $id_materi = $this->encrypt->decode($this->input->get('id_materi'));
            if (!empty($id_materi)) {
                $where_mt = array('id_materi'=>$id_materi);
                $data   = $this->model_admin->select_data('_materi', null, $where_mt);
            }else{
                $data   = '';
            }
            if ($this->tipe_user=="admin") {
                $kelas = $this->model_admin->select_data('_kelas');
            }elseif ($this->tipe_user=="guru") {
                $kelas = $this->model_admin->select_datast('_kelas','id_kelas,nama_kelas',null,'id_kelas',$this->kelas_guru()[1]);
            }
            $data=array('title' => 'Data Materi Pembelajaran',
                'data'          => $data,
                'kelas'         => $kelas,
                'isi'           => 'backend/view_materi_detail',
            );
            $this->load->view('layout', $data);
        }
    }
    
    function get_stage(){
        $id_kelas = $this->input->post('id_kelas');
        $data = $this->model_admin->select_data('_stage',null,array('id_kelas'=>$id_kelas));
        echo json_encode($data);
    }
    function get($table,$id_materi){
        $data = $this->model_admin->select_data($table,null, array('id_materi'=>$id_materi));
        return $data;
    }
    function materi_hapus(){
        $id = $this->encrypt->decode($this->input->post('hapus'));
        if (!empty($id)) {
            $where = array('id_materi'=>$id);

            /*------- Materi -------*/
            $dt_materi   = $this->model_admin->select_data('_materi',null,$where);
            $file_materi = $dt_materi[0]['file_materi'];

            $appath = realpath(APPPATH . '../assets/materi/'.$file_materi);
            $appath_thumb = realpath(APPPATH . '../assets/materi/thumbnail/'.$file_materi);

            if(!empty($file_materi) and file_exists($appath)){
                unlink($appath);                        
            }                   
            if(!empty($file_materi) and file_exists($appath_thumb)){
                unlink($appath_thumb);
            }

            /*----- Games ---------*/
            $dt_games   = $this->model_admin->select_data('_games',null,$where);
            if (!empty($dt_games)) {
                $file_games = $dt_games[0]['file_games'];
                $appath1 = realpath(APPPATH . '../assets/games/'.$file_games);
                $appath_thumb1 = realpath(APPPATH . '../assets/games/thumbnail/'.$file_games);

                if(!empty($file_games) and file_exists($appath1)){
                    unlink($appath1);                        
                }                   
                if(!empty($file_games) and file_exists($appath_thumb1)){
                    unlink($appath_thumb1);
                }
                $this->model_admin->delete_data('_games', $where);
            }

            $dt_quiz = $this->model_admin->select_data('_quiz',null,$where);
            if (!empty($dt_quiz)) {
                $this->model_admin->delete_data('_quiz', $where);
            }

            $response = $this->model_admin->delete_data('_materi', $where);
            echo json_encode($response);
        }
    }

    //Upload image summernote
    function upload_image(){
        $this->load->library('upload');        
        if(isset($_FILES["image"]["name"])){
            $config['upload_path'] = './assets/materi/summernote/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                $this->upload->display_errors();
                return FALSE;
            }else{
                $data = $this->upload->data();
                //Compress Image
                $config['image_library']='gd2';
                $config['source_image']='./assets/materi/summernote/'.$data['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['quality']= '60%';
                $config['width']= 800;
                $config['height']= 800;
                $config['new_image']= './assets/materi/summernote/'.$data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url().'assets/materi/summernote/'.$data['file_name'];
            }
        }
    }

    //Delete image summernote
    function delete_image(){
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if(unlink($file_name)){
            echo 'File Delete Successfully';
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
