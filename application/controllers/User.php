<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    function __construct(){

        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
        if ($this->tipe_user=="admin" AND !empty($this->tipe_user)) {
        }else{
            show_404();
        }
    }    
    function index(){    
        $data=array(
            'title'     => 'Manajemen Pengguna',
            'isi'       => 'backend/view_user'
        );
        $this->load->view('layout', $data);
        
    }
    function user_data(){
        $aColumns = array('nama_lengkap', 'foto', 'nama_lengkap', 'tanggal_lahir', 'jk', 'wa', 'username', 'tipe_user', 'last_login', 'nama_lengkap', 'nama_lengkap'); 
        $sIndexColumn = "id_user"; //primary key
        $where = "id_user!=''";
        $dt = $this->data('users', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){            
            if ($data['id_user']==$this->id_user or $data['tipe_user']=="admin") {
                $aksi = "<a href='".base_url().$this->uri->segment(1)."/user_detail/".$this->encrypt->encode($data['id_user'])."' class='btn btn-warning btn-sm' data-original-title='Ubah Data' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>";
            }else{  
                $aksi = "<a href='".base_url().$this->uri->segment(1)."/user_detail/".$this->encrypt->encode($data['id_user'])."' class='btn btn-warning btn-sm' data-original-title='Ubah Data' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
                <a href='javascript:;' data-hapus='".$this->encrypt->encode($data['id_user'])."' class='btn btn-danger btn-sm hapus' data-original-title='Hapus Data' data-toggle='tooltip'><i class='fa fa-trash'></i></a>";
                
            }
            
            $ada = file_exists(realpath(APPPATH . '../assets/images/user/thumbnail/'.$data['foto']));
            if(!empty($data['foto']) and $ada) {
                $images = base_url().'assets/images/user/thumbnail/'.$data['foto'];
            }else{
                if ($data['jk']=="L") {
                    $images = base_url().'assets/images/avatar/male.jpg';
                }else{$images = base_url().'assets/images/avatar/female.jpg';

                }
            }
            $birthday = $data['tanggal_lahir'];
            $biday = new DateTime($birthday);
            $today = new DateTime();
            $diff = $today->diff($biday);
            $umur = $diff->y.' Tahun';
            $output['data'][]=array(
                $nomor_urut,                
                "<img width='40' src='".$images."' alt='pengguna'>",
                $data['nama_lengkap'],
                Tools::tgl_indo($data['tanggal_lahir'],'d-m-Y'),
                $umur,
                $data['jk'],
                $data['wa'],
                $data['username'],
                $data['tipe_user'],                
                "<span data-placement='top' data-toggle='tooltip' data-original-title='".'Tambah : '.Tools::tgl_indo($data['waktu_post'],'d-m-Y H:i:s').' / Ubah : '.Tools::tgl_indo($data['waktu_edit'],'d-m-Y H:i:s')."'>".Tools::tgl($data['last_login'])."</span>",
                "<a href='".base_url().$this->uri->segment(1)."/pass_detail/".$this->encrypt->encode($data['id_user'])."' class='btn btn-success btn-sm tooltips' data-original-title='Ubah Password' data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-key'></i></a>",
                $aksi,                
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }
    function user_detail($id=NULL){                  
        $this->form_validation->set_rules('nama_lengkap', 'Nama', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        if (empty($id)) {                
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        $this->form_validation->set_rules('tipe_user', 'Tipe User', 'trim|required');
        if ($this->form_validation->run() != false) { //insert                
            $id = $this->encrypt->decode($this->input->post('id'));
            if ($_FILES['cover']['name']) {                    
                $path   = '../assets/images/user/';
                $lokasi = realpath(APPPATH . $path);
                $nmfile = "user_".$this->input->post('username');
                $cover = $this->upload_foto($lokasi,$path,$nmfile);
            }else if(empty($_FILES['cover']['name'])){
                $cover=$this->input->post('covers');
            }
            $data  = array(
                'username'      => $this->input->post('username'),
                'tipe_user'     => $this->input->post('tipe_user'),
                'nama_lengkap'  => $this->input->post('nama_lengkap'),
                'nama_panggilan'=> $this->input->post('nama_panggilan'),
                'tanggal_lahir' => Tools::tgl_indo($this->input->post('tanggal_lahir'),'Y-m-d'),
                'tempat_lahir'  => $this->input->post('tempat_lahir'),
                'jk'            => $this->input->post('jk'),
                'foto'          => $cover,
                'agama'         => $this->input->post('agama'),
                'alamat'        => $this->input->post('alamat'),
                'wa'            => $this->input->post('wa'),
                'email'         => $this->input->post('email'),
                'facebook'      => $this->input->post('facebook'),
                'instagram'     => $this->input->post('instagram'),
                'twitter'       => $this->input->post('twitter'),
                'youtube'       => $this->input->post('youtube'),
                'tentang'       => $this->input->post('tentang'),
                'posisi'        => $this->input->post('posisi'),
                'nama_usaha'    => $this->input->post('nama_usaha'),
                'misi_usaha'    => $this->input->post('misi_usaha'),
                'publish'       => $this->input->post('publish'),
                'allow_login'   => $this->input->post('allow_login'),
                'waktu_edit'    => date('Y-m-d H:i:s')
            );
            if (empty($id)) {
                $data['password']       = md5($this->input->post('password'));
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('users', $data);
            }else{
                $where = array('id_user'=>$id);
                if(!empty($_FILES['cover']['name'])){
                    $dt_foto = $this->model_admin->select_data('users',null,$where);
                    $appath = realpath(APPPATH . '../assets/images/user/'.$dt_foto[0]['foto']);
                    $appath_thumb = realpath(APPPATH . '../assets/images/user/thumbnail/'.$dt_foto[0]['foto']);

                    if(!empty($dt_foto[0]['foto']) and file_exists($appath)){
                        unlink($appath);                        
                    }                   
                    if(!empty($dt_foto[0]['foto']) and file_exists($appath_thumb)){
                        unlink($appath_thumb);
                    }                        
                }
                $this->model_admin->update_data('users', $data, $where);
            }
            redirect('user');
        }else{
            $id = $this->encrypt->decode($id);
            if (!empty($id)) {
                $data=$this->model_admin->select_data('users', null, array('id_user'=>$id));
            }else{
                $data='';
            }
            $data=array('title' => 'Data Pengguna',
                'data'          => $data,
                'isi'           => 'backend/view_user_detail',
            );
            $this->load->view('layout', $data);
        }
    } 
    function user_hapus(){
        $id = $this->encrypt->decode($this->input->post('hapus'));
        if (!empty($id)) {
            $where = array('id_user'=>$id);
            $dt_foto = $this->model_admin->select_data('users',null,$where);
            $appath = realpath(APPPATH . '../assets/images/user/'.$dt_foto[0]['foto']);
            $appath_thumb = realpath(APPPATH . '../assets/images/user/thumbnail/'.$dt_foto[0]['foto']);

            if(!empty($dt_foto[0]['foto']) and file_exists($appath)){
                unlink($appath);                        
            }                   
            if(!empty($dt_foto[0]['foto']) and file_exists($appath_thumb)){
                unlink($appath_thumb);
            }
            $response = $this->model_admin->delete_data('users', $where);
            echo json_encode($response);
        }
    }
    function pass_detail($id=NULL){                                    
        $this->form_validation->set_rules('passLm', 'Password Lama', 'trim|required');
        $this->form_validation->set_rules('passBr', 'Password Baru', 'trim|required');
        $this->form_validation->set_rules('passUl', 'Ketika Ulang Password Baru', 'trim|required');
        if ($this->form_validation->run() != false) {
            $id = $this->encrypt->decode($this->input->post('id_user'));
            $where = array('id_user'=>$id);
            $data  = array(              
                'password'      => md5($this->input->post('passUl'))
            );                
            $this->model_admin->update_data('users', $data, $where);
            redirect('user');
        }else{                           
            $id_user = $this->encrypt->decode($id);
            $where = array('id_user'=>$id_user);                  
            $data=array('title' => 'Ubah Password',                    
                'data'          => $this->model_admin->select_data('users',null,$where),
                'isi'           => 'backend/view_user_pass_detail',
            );
            $this->load->view('layout', $data);
        }
    }
    function pass_reset($id=NULL){
        $id_user = $this->encrypt->decode($id);
        $where   = array('id_user'=>$id_user);
        $user = $this->model_admin->select_data('users',null,$where);
        $pass_br = Tools::random_number();
        $data  = array(              
            'password'      => md5($pass_br)
        );        
        $this->db->update('users', $data, $where);
        $this->notif('success','Password <b>'.$user[0]['nama_lengkap'].'</b> berhasil direset menjadi <b>'.$pass_br.'</b>');
        redirect('user');
            
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
    function cek_password($id_user){
        $id_user1       = $this->encrypt->decode($id_user);
        $password       = $this->input->post('passLm');
        $this->db->where('id_user',$id_user1);        
        $this->db->where('password',md5($password));
        $data = $this->db->get('users');
        echo count($data->result_array());
    }
    function cek_username($username){
        $username       = $this->input->post('username');
        $this->db->where('username',$username);
        $data = $this->db->get('users');
        echo count($data->result_array());
    }

}
