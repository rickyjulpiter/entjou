<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->username     = $this->encrypt->decode($this->session->userdata('username'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
        $this->where        = array('id_user'=>$this->id_user);
        $this->where1        = array('id_siswa'=>$this->id_user);
        if ($this->tipe_user=="siswa" AND !empty($this->tipe_user)) {
        }else{
            show_404();
        }
    }    
    function index(){
        $data = array(
            'title'     => 'Profil Siswa',
            'isi'       => 'frontend/siswa_profil',
            'profil'    => $this->model_admin->select_data('users',null,$this->where)
        );
        $this->load->view('layout_home', $data);
    }
    /*-------------------- Profil ----------------------*/
    function profil_update(){
        $data = array(
            'nama_lengkap'      => $this->input->post('nama_lengkap'),
            'nama_panggilan'    => $this->input->post('nama_panggilan'),
            'tanggal_lahir'     => Tools::tgl_indo($this->input->post('tanggal_lahir'),'Y-m-d'),
            'tempat_lahir'      => $this->input->post('tempat_lahir'),
            'jk'                => $this->input->post('jk'),
            'agama'             => $this->input->post('agama'),
            'alamat'            => $this->input->post('alamat'),
            'wa'                => $this->input->post('wa'),
            'email'             => $this->input->post('email'),
            'facebook'          => $this->input->post('facebook'),
            'instagram'         => $this->input->post('instagram'),
            'twitter'           => $this->input->post('twitter'),
            'youtube'           => $this->input->post('youtube'),
            'tentang'           => $this->input->post('tentang'),
            /*'nama_usaha'        => $this->input->post('nama_usaha'),
            'misi_usaha'        => $this->input->post('misi_usaha'),*/
            'waktu_edit'        => date('Y-m-d H:i:s')
            
        );
        $this->model_admin->update_data('users', $data, $this->where);
        $this->notif('success','Biodata anda berhasil diupdate');
        redirect('siswa');
    }
    function pass_update(){
        $data  = array(
            'password'      => md5($this->input->post('passUl'))
        );                
        $this->model_admin->update_data('users', $data, $this->where);
        $this->notif('success', 'Kata sandi anda berhasil diubah');
        redirect('siswa');
    }
    function unggah_foto(){
        if ($_FILES['cover']['name']) {                    
            $path   = '../assets/images/user/';
            $lokasi = realpath(APPPATH . $path);
            $nmfile = "user_".$this->username;
            $foto = $this->upload_foto($lokasi,$path,$nmfile);

        }else if(empty($_FILES['cover']['name'])){
            $foto=$this->input->post('covers');
        }
        $dt_foto = $this->model_admin->select_data('users',null,$this->where);
        $appath = realpath(APPPATH . '../assets/images/user/'.$dt_foto[0]['foto']);
        $appath_thumb = realpath(APPPATH . '../assets/images/user/thumbnail/'.$dt_foto[0]['foto']);

        if(!empty($dt_foto[0]['foto']) and file_exists($appath)){
            unlink($appath);                        
        }                   
        if(!empty($dt_foto[0]['foto']) and file_exists($appath_thumb)){
            unlink($appath_thumb);
        }
        $data = array(
            'foto'  => $foto
        );
        $this->model_admin->update_data('users', $data, $this->where);
        $this->notif('success', 'Foto anda berhasil di unggah');
        redirect('siswa');
    }
    /*-------------------- /Profil ----------------------*/
    /*-------------------- Misi ----------------------*/
    function misi(){
        $checkup         = $this->model_admin->select_data('checkup',null,$this->where1 );
        $form_checkup    = $this->model_admin->select_data('form_checkup',null,null,null,'id_form ASC');
        $hasil_checkup   = $this->model_admin->select_data('hasil_checkup',null, $this->where1);
       /* $peserta_materi  = $this->model_admin->select_data('_peserta_materi',null,$this->where1);
        $peserta_kelas   = $this->model_admin->select_data('_peserta_kelas', null, $this->where1);*/
        $pesanan         = $this->model_admin->select_data('pesanan',null,array('id_siswa'=>$this->id_user,'status'=>'dibayar'));
        $ar_idkelas = array();
        foreach ($pesanan as $key => $value) {
            $ar_idkelas [] = $value['id_kelas'];
        }
        $materi          = $this->model_admin->select_datast('_materi',null,null,'id_kelas',$ar_idkelas,'nama_kelas ASC, nama_stage ASC, judul_materi ASC ');
        #-------------------------------
        /*$ar_idmat = array();
        foreach ($peserta_materi as $key => $value) {
            $ar_idmat [] = $value['id_materi'];
        }
        $materi          = $this->model_admin->select_datast('_materi',null,null,'id_materi',$ar_idmat);*/
        $data = array(
            'title'         => 'Misi',
            'isi'           => 'frontend/siswa_misi',
            'checkup'       => $checkup,
            'form_checkup'  => $form_checkup,
            'hasil_checkup' => $hasil_checkup,
            /*'peserta_materi'=> $peserta_materi,
            'peserta_kelas' => $peserta_kelas,*/
            'materi'        => $materi,
            'pesanan'       => $pesanan
        );
        $this->load->view('layout_home',$data);
    }   
    function checkup_insert(){
        $data = array(
            'id_siswa'      => $this->id_user,
            'nama_siswa'    => $this->nama,
            'waktu'         => date('Y-m-d H:i:s')
        );
        for ($i=1; $i<=32 ; $i++) { 
            $kol = 'p'.$i;
            $data[$kol] = $this->input->post($kol);
        }
        $this->model_admin->insert_data('checkup',$data);
        $this->notif('success', 'Terima kasih!. Kami akan mempelajari jabawan-jawaban kamu dan memberikan rekomendasi terbaik untuk kamu menjadi seorang Entrepreneur.');
        redirect('siswa/misi');
    }
    /*-------------------- /Misi ----------------------*/
    /*-------------------- Agenda ----------------------*/
    function agenda(){
        $where_today = array(
            'id_siswa'      => $this->id_user,
            'start'       => date('Y-m-d')

        );
        $where_coming = array(
            'id_siswa'      => $this->id_user,
            'start>'         => date('Y-m-d')         
        );        
        $where_yest = array(
            'id_siswa'      => $this->id_user,
            'start<'        => date('Y-m-d')         
        );        
        $data = array(
            'title'         => 'Agenda',
            'isi'           => 'frontend/siswa_agenda',
            'agenda_today' => $this->model_admin->select_data('agenda',null,$where_today,null,'waktu_post DESC'),
            'agenda_coming' => $this->model_admin->select_data('agenda',null,$where_coming,null,'start DESC'),
            'agenda_yest' => $this->model_admin->select_data('agenda',null,$where_yest,null,'start DESC')
        );
        $this->load->view('layout_home',$data);
    }
    function get_agenda(){
        $data = $this->model_admin->get_agenda();
        echo json_encode($data);
    }
    function agenda_add(){
        $data = $this->model_admin->add_agenda();
        echo $data;
    }
    function agenda_update(){
        $data = $this->model_admin->update_agenda();
        echo $data;
    }
    function agenda_delete(){
        $data = $this->model_admin->delete_agenda();
        echo $data;
    }
    function agenda_drag_update(){   
        $data = $this->model_admin->drag_update_agenda();
        echo $data;
    }
    function agenda_konfirmasi(){
        if (!empty($this->input->post('durasi_mulai'))) {
            $durasi_mulai = Tools::tgl_indo($this->input->post('durasi_mulai'),'Y-m-d');
        }else{
            $durasi_mulai = NULL;
        }
        if (!empty($this->input->post('durasi_selesai'))) {
            $durasi_selesai = Tools::tgl_indo($this->input->post('durasi_selesai'),'Y-m-d');
        }else{
            $durasi_selesai = NULL;
        }
        if (!empty($this->input->post('waktu_lanjutan'))) {
            $waktu_lanjutan = Tools::tgl_indo($this->input->post('waktu_lanjutan'),'Y-m-d');
        }else{
            $waktu_lanjutan = NULL;
        }
        $data = array(
            'status'        => $this->input->post('status'),
            'durasi_mulai'  => $durasi_mulai,
            'durasi_selesai'=> $durasi_selesai,
            'waktu_lanjutan'=> $waktu_lanjutan
        );
        $where = array('id_agenda'=>$this->input->post('id_agenda'));
        $this->model_admin->update_data('agenda',$data,$where);
        $this->notif('success','Agenda kamu berhasil di konfirmasi');
        redirect('siswa/agenda');
    }
    /*-------------------- /Agenda ----------------------*/
    /*-------------------- Pesanan ----------------------*/
    function pesanan(){
        $data = array(
            'title'         => 'Pesanan',
            'isi'           => 'frontend/siswa_pesanan',
            'profil'        => $this->model_admin->select_data('users',null,$this->where),
            'pesanan'       => $this->model_admin->select_data('pesanan',null,$this->where1,null,'waktu DESC')
        );
        $this->load->view('layout_home',$data);
    }
    function unggah_bukti(){
        if ($_FILES['cover']['name']) {                    
            $path   = '../assets/bukti_pembayaran/';
            $lokasi = realpath(APPPATH . $path);
            $nmfile = date('Y-m-d H-i-s').'_'.$this->id_user.'_'.$this->input->post('id_pesanan');
            $file = $this->upload_foto($lokasi,$path,$nmfile);

        }else if(empty($_FILES['cover']['name'])){
            $file=NULL;
        }
        $data = array(
            'waktu_bayar'   => Tools::tgl_indo($this->input->post('waktu_bayar'),'Y-m-d'),
            'id_pesanan'    => $this->input->post('id_pesanan'),
            'nominal'       => str_replace(".", "", $this->input->post('nominal')),
            'atas_nama'     => $this->input->post('atas_nama'),
            'bank_tujuan'   => $this->input->post('bank_tujuan'),
            'bank_pengirim' => $this->input->post('bank_pengirim'),
            'file'          => $file,
            'waktu_post'    => date('Y-m-d H:i:s')
        );
        $where1 = array('id_pesanan'=>$this->input->post('id_pesanan'));
        $data1 = array('status'=>'proses');
        $this->model_admin->update_data('pesanan',$data1,$where1);
        $this->model_admin->insert_data('pembayaran', $data);
        $this->notif('success','Bukti pembayaran kamu berhasil diunggah. Harap tunggu verifikasi dari admin');
        redirect('siswa/pesanan');
    }
    /*-------------------- /Pesanan ----------------------*/
    /*--------------------- Pengumuman --------------------*/
    function pengumuman(){
        $data = array(
            'title'     => 'Pengumuman',
            'isi'       => 'frontend/siswa_pengumuman',
            'profil'    => $this->model_admin->select_data('users',null,$this->where),
            'pengumuman'=> $this->model_admin->select_data('pengumuman',null,array('publish'=>'Y'),null,'waktu_post DESC')
        );
        $this->load->view('layout_home', $data);
    }
    /*--------------------- Pengumuman --------------------*/
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

    
}
