<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
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
            'title'     => 'Manajemen Kelas',
            'isi'       => 'backend/view_kelas'
        );
        $this->load->view('layout', $data);
        
    }
    function kelas_data(){
        $aColumns = array('nama_kelas', 'nama_kelas', 'harga', 'jumlah_stage', 'batas_peserta', 'id_guru', 'waktu_edit', 'status', 'nama_kelas'); 
        $sIndexColumn = "id_kelas"; //primary key
        if ($this->tipe_user=="admin") {
            $where = "id_kelas!=''";
        }elseif ($this->tipe_user=="guru") {
            $where = 'id_guru LIKE "%'.$this->id_user.'%" ';
        }
        
        $dt = $this->data('_kelas', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            if (!empty($data['id_guru'])) {
                $id_guru = count(explode(",", $data['id_guru']));
            }else{
                $id_guru = 0;
            }
            if($data['status']=='Y'){
                $status = "<label class='label label-success'>Aktif</label>";
            }else{
                $status = "<label class='label label-danger'>Tidak Aktif</label>";
            }

            if ($data['harga']==0) {
                $harga = "Gratis";
            }else{
                $harga = Tools::rupiah('Rp ',$data['harga']);
            }
            $output['data'][]=array(
                $nomor_urut,                
                $data['nama_kelas'],
                $harga,
                $data['jumlah_stage'],
                $data['batas_peserta'],
                $id_guru,
                "<span data-placement='top' data-toggle='tooltip' data-original-title='".'Tambah : '.Tools::tgl_indo($data['waktu_post'],'d-m-Y H:i:s').' / Ubah : '.Tools::tgl_indo($data['waktu_edit'],'d-m-Y H:i:s')."'>".Tools::tgl($data['waktu_edit'])."</span>",
                $status,
                "<a href='".base_url().$this->uri->segment(1)."/kelas_detail/".$this->encrypt->encode($data['id_kelas'])."' class='btn btn-warning btn-sm' data-original-title='Ubah Data' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
                <a href='javascript:;' data-nonaktif='".$this->encrypt->encode($data['id_kelas'])."' class='btn btn-danger btn-sm nonaktif' data-original-title='Non aktfikan kelas' data-toggle='tooltip'><i class='fa fa-power-off'></i></a>",                
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }

    function kelas_detail($id=NULL){
        $this->form_validation->set_rules('nama_kelas', 'Nama kelas', 'trim|required');
        $this->form_validation->set_rules('fee', 'Harga', 'trim|required');
        $this->form_validation->set_rules('jumlah_stage', 'Jumlah Stage', 'trim|required');
        $this->form_validation->set_rules('batas_peserta', 'Batas Peserta', 'trim|required');

        if ($this->form_validation->run() != false) { //insert                
            $id = $this->encrypt->decode($this->input->post('id'));
            if ($_FILES['cover']['name']) {                    
                $path   = '../assets/images/kelas/';
                $lokasi = realpath(APPPATH . $path);
                $nmfile = "kelas_".strtolower($this->input->post('nama_kelas'));
                $cover = $this->upload_foto($lokasi,$path,$nmfile);
            }else if(empty($_FILES['cover']['name'])){
                $cover=$this->input->post('covers');
            }
            if ($this->input->post('kategori')=='lainnya') {
                $kategori = $this->input->post('kategori1');
            }else{
                $kategori = $this->input->post('kategori');
            }
            $data  = array(
                'nama_kelas'    => $this->input->post('nama_kelas'),
                'kategori'      => $kategori,
                'harga'         => str_replace(".", "", str_replace("Rp. ", "", $this->input->post('harga'))),
                'foto'          => $cover,
                'slug'          => 'kelas_detail/'.slug($this->input->post('nama_kelas')).'.ej',
                'overview'      => $this->input->post('overview'),
                'jumlah_stage'  => $this->input->post('jumlah_stage'),
                'batas_peserta' => $this->input->post('batas_peserta'),
                'waktu_edit'    => date('Y-m-d H:i:s'),
                'status'        => 'Y'
            );
            if (empty($id)) {                
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('_kelas', $data);
            }else{
                $where = array('id_kelas'=>$id);                
                if (!empty($_FILES['cover']['name'])) {
                    $dt_foto = $this->model_admin->select_data('_kelas', null, $where);
                    $appath = realpath(APPPATH . '../assets/images/kelas/'.$dt_foto[0]['foto']);
                    $appath_thumb = realpath(APPPATH . '../assets/images/kelas/thumbnail/'.$dt_foto[0]['foto']);

                    if(!empty($dt_foto[0]['foto']) and file_exists($appath)){
                        unlink($appath);                        
                    }                   
                    if(!empty($dt_foto[0]['foto']) and file_exists($appath_thumb)){
                        unlink($appath_thumb);
                    }
                }                        
                $this->model_admin->update_data('_kelas', $data, $where);
            }
            redirect('kelas');
        }else{
            $id = $this->encrypt->decode($id);
            if (!empty($id)) {
                $where_cl = array('id_kelas'=>$id);
                $data = $this->model_admin->select_data('_kelas', null, $where_cl);
                #-------------------------------------------
                $id_guru = explode(",", str_replace("'", "", $data[0]['id_guru']));
                $guru_kelas = $this->model_admin->select_datast('users',null,null,'id_user',$id_guru);
                $stage = $this->model_admin->select_data('_stage',null,$where_cl);
                $materi = $this->model_admin->select_data('_materi',null,$where_cl);
                $min_kelas  = count($this->model_admin->select_data('pesanan',null,$where_cl));
            }else{
                $data       = '';
                $guru_kelas = '';
                $id_guru    = '';
                $stage      = '';
                $materi     = '';
                $min_kelas  = 1;
            }
            $data=array('title' => 'Data Kelas',
                'data'          => $data,
                'guru'          => $this->model_admin->select_data('users',null,array('tipe_user'=>'guru')),
                'guru_kelas'    => $guru_kelas,
                'id_guru'       => $id_guru,
                'stage'         => $stage,
                'materi'        => $materi,
                'min_kelas'     => $min_kelas,
                'kat'           => $this->model_admin->select_data('_kelas','DISTINCT(kategori) as kat',null,null,'kategori ASC'),
                'isi'           => 'backend/view_kelas_detail',
            );
            $this->load->view('layout', $data);
        }
    }

    function tambah_fasilitator(){
        $guru     = $this->input->post('guru');   
        $id_kelas = $this->input->post('id2');
        $id_guru  = '';
        for ($i=0; $i<count($guru) ; $i++) { 
            if ($i==count($guru)-1) {
                $id_guru .= $guru[$i];
            }else{
                $id_guru .= $guru[$i].',';
            }
        }
        $data = array(
            'id_guru' => $id_guru
        );
        $this->model_admin->update_data('_kelas',$data,array('id_kelas'=>$this->encrypt->decode($id_kelas)));
        $this->notif('success','Fasilitor berhasil diubah');
        redirect('kelas/kelas_detail/'.$id_kelas);
    }

    function tambah_stage(){
        $id_kelas   = $this->input->post('id_kelas1');
        $nama_kelas = $this->input->post('nama_kelas1');
        $id_guru    = $this->id_user;
        $nama_guru  = $this->nama;

        $dt = $this->model_admin->select_data('_stage','MAX(SUBSTRING(nama_stage,7,2)) as no_urut',array('id_kelas'=>$this->encrypt->decode($id_kelas)));
        if (!empty($dt)) { $no_urut = $this->kode2($dt[0]['no_urut']+1); }else{$no_urut = $this->kode2(1);}
        
        $data = array(
            'nama_stage'    => 'Stage '.$no_urut,
            'id_kelas'      => $this->encrypt->decode($id_kelas),
            'nama_kelas'    => $nama_kelas,
            'id_guru'       => $id_guru,
            'nama_guru'     => $nama_guru,
            'waktu_post'    => date("Y-m-d H:i:s"),
            'waktu_edit'    => date("Y-m-d H:i:s"),
        );
        $kelas = $this->model_admin->select_data('_kelas',null,array('id_kelas'=>$this->encrypt->decode($id_kelas)));
        $stage = $this->model_admin->select_data('_stage',null,array('id_kelas'=>$this->encrypt->decode($id_kelas)));
        if (count($stage)>=$kelas[0]['jumlah_stage']) {
            $this->notif('danger','Maaf jumlah stage sudah melebihi batas');
            redirect('kelas/kelas_detail/'.$id_kelas);
        }else{
            $this->model_admin->insert_data('_stage',$data);
            $this->notif('success','Stage berhasil ditambahkan');
            redirect('kelas/kelas_detail/'.$id_kelas);            
        }
    }

    function hapus_stage($id=null){
    }

    function kelas_nonaktif(){
        $id = $this->encrypt->decode($this->input->post('nonaktif'));
        if (!empty($id)) {
            $where = array('id_kelas'=>$id);
            $data = array(
                'status' => 'N'
            );
            $response = $this->model_admin->update_data('_kelas', $data, $where);
            echo json_encode($response);
        }
    }

    function peserta_kelas(){
        $data=array(
            'title'     => 'Peserta Kelas',
            'isi'       => 'backend/view_kelas_peserta'
        );
        $this->load->view('layout', $data);
    }

    function peserta_kelas_data(){
        $aColumns = array('id_peserta', 'nama_kelas', 'nama_siswa', 'tanggal_lahir', 'jk', 'agama', 'wa', 'foto', 'id_peserta'); 
        $sIndexColumn = "id_peserta"; //primary key
        if ($this->tipe_user=="admin") {
            $where = "id_peserta!=''";
        }elseif ($this->tipe_user=="guru") {
            $where = 'id_guru LIKE "%'.$this->id_user.'%" ';
        }
        $dt = $this->data('view_peserta_kelas', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            $foto = $data['foto'];
            $ada = file_exists(realpath(APPPATH . '../assets/images/user/thumbnail/'.$foto));
            if(!empty($foto) and $ada) {
                $images = base_url().'assets/images/user/thumbnail/'.$foto;
            }else{
                if ($data['jk']=="L") {
                    $images = base_url().'assets/images/avatar/male.jpg';
                }else{$images = base_url().'assets/images/avatar/female.jpg';

                }
            }
            $output['data'][]=array(
                $nomor_urut,
                $data['nama_kelas'],
                $data['nama_siswa'],
                Tools::tgl_indo($data['tanggal_lahir'],'d-m-Y'),
                $data['jk'],
                $data['agama'],
                $data['wa'],
                "<img src='".$images."' width='30'>",
                "<a href='".base_url().$this->uri->segment(1)."/kelas_detail/".$this->encrypt->encode($data['id_kelas'])."' type='button' class='btn btn-info btn-sm tooltips' data-original-title='Lihat Detail Kelas' data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-eye'></i></a>",
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
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
    function notif($button,$pesan){
        $this->session->set_flashdata('notif','<center><div class="alert alert-'.$button.'" role="alert" style="border:solid 1px;">'.$pesan.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }

    function kode2($ak){
        $kode = "";        
        if ($ak>0 and $ak<10) {
            $kode = "0".$ak;
        }elseif ($ak>=10 and $ak<100) {
            $kode = $ak;
        }
        return $kode;        
    }
   

}
