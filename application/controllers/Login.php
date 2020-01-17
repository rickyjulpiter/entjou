<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_login');
        $this->load->model('model_admin');
        $this->load->library('user_agent');
        include 'Tools.php';
        //$this->ip = '180.251.245.141';
        /*if($this->ip()!=$this->ip){
            show_404();
        }*/
    }
    public function index(){
        $cookie = get_cookie('caricookie');

        if ($cookie <> '') {
            $db = $this->model_login->cek_cookie($cookie);
            if (!empty($db)) {
                if ($db[0]['allow_login'] != 'N' AND $db[0]['tipe_user'] == 'admin') {
                    $this->simpan_sesi($db);
                }else{
                    show_404();
                }
            }else{
                $data = array(
                    'title'     => 'Masuk',
                    'isi'       => 'frontend/login',
                );
                $this->load->view('layout_home',$data);
            }
        }else{
            $data = array(
                'ip'        => $this->ip(),
            );
            $data = array(
                'title'     => 'Masuk',
                'isi'       => 'frontend/login',
            );
            $this->load->view('layout_home',$data);
        }
    }
    public function cek_login() {
        $username = $this->security->xss_clean($this->input->post("username"));
        $password = $this->security->xss_clean($this->input->post("password"));
        $remember = $this->input->post("remember");
        $cek = $this->model_login->cek_login($username,md5($password));
        if(!empty($cek)){
            if ($cek[0]['allow_login'] != 'N') {
                if ($remember) {
                    $key = random_string('alnum', 64);
                    set_cookie('caricookie', $key, 3600*24*30); // expired 30 hari

                    $this->model_login->update_data('users', array('cookie' => $key), 'id_user="'.$cek[0]['id_user'].'"');
                }
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser().' '.$this->agent->version();
                }elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                }else{
                    $agent = 'Unknown';
                }
                $data=array(                    
                    'sesi'          => date('Ymd').time(),
                    'username'      => $cek[0]['username'],
                    'nama'          => $cek[0]['nama_lengkap'],
                    'tipe_user'     => $cek[0]['tipe_user'],
                    'ip'            => $this->ip(),
                    'waktu'         => date('Y-m-d H:i:s'),
                    'status'        => 'login',
                    'browser'       => $agent
                );
                $this->db->insert('log_login', $data);
                $this->simpan_sesi($cek);
            }else{
                $this->notif('danger', 'Maaf anda tidak dapat masuk lagi. Akun anda telah di blokir');
            }
        }else{
            $this->notif('danger', 'Username atau Password Salah !');
        }
        redirect('login');
    }
    function simpan_sesi($db){
        if (!empty($db)) {
            $this->session->set_userdata(array(
                'id_user'       => $this->encrypt->encode($db[0]['id_user']),
                'username'      => $this->encrypt->encode($db[0]['username']),
                'nama'          => $this->encrypt->encode($db[0]['nama_lengkap']),
                'tipe_user'     => $this->encrypt->encode($db[0]['tipe_user']),
                'jk'            => $db[0]['jk'],
                'allow_login'   => $this->encrypt->encode($db[0]['allow_login']),
                'foto'          => $db[0]['foto'],
                'sesi'			=> date('Ymd').time()
            ));
            $this->model_login->update_data('users', array('last_login'=> date('Y-m-d H:i:s')), 'id_user="'.$db[0]['id_user'].'"');
            if($db[0]['tipe_user']=='admin'){
                redirect('dashboard');
            }else if($db[0]['tipe_user']=='guru'){
                redirect('dashboard');                
            }elseif ($db[0]['tipe_user']=='siswa') {
                $this->notif('success', 'Anda berhasil masuk');
                redirect('siswa');
            }else{
                redirect('login');
            }
        }
    }
    function ip(){
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        return $ip;
    }
    /*function log($st,$id){
        $ip = $this->ip();
        $cek_log = $this->model_login->cek_log($ip,$st,$id);
        if(count($cek_log) == 0){
            $data=array(
                'waktu' => date('Y-m-d H:i:s'),
                'ip'    => $ip,
                'status'=> $st,
                'id'    => $id,
                'log'   => 1,
            );
            $this->db->insert('login_user',$data);
        } else {
            $data=array(
                'waktu' => date('Y-m-d H:i:s'),
                'log'   => $cek_log[0]['log']+1,
            );
            $where=array(
                'id'    => $id,
                'status'=> $st,
                'ip'    => $ip,
            );
            $this->db->update('login_user',$data,$where);
        }
    }*/
    public function logout(){
        $nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $username     = $this->encrypt->decode($this->session->userdata('username'));
        $tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));                
        $sesi 		= $this->session->userdata('sesi');
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Unknown';
        }
        $data=array(                    
            'sesi'          => $sesi,
            'username'      => $username,
            'nama'          => $nama,
            'tipe_user'     => $tipe_user,
            'ip'            => $this->ip(),
            'waktu'         => date('Y-m-d H:i:s'),
            'status'        => 'login',
            'browser'       => $agent
        );
        $data1 = array('status'=>'logout');
        $this->model_admin->update_data('log_login', $data1, array('sesi'=>$sesi));
        delete_cookie('caricookie');
        $this->session->sess_destroy();
        $this->notif('success','Kamu telah keluar dari akunmu');
        redirect('login');
    }
    function notif($button,$pesan){
        $this->session->set_flashdata('notif','<center><div class="alert alert-'.$button.'" role="alert" style="border:solid 1px;">'.$pesan.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }
    function limit_words($string, $word_limit){
        $words = explode(" ",$string);
        return implode(" ",array_splice($words,0,$word_limit));
    }    
    function tgl_indo($timestamp = '', $date_format = 'l, j F Y', $suffix = '') {
        if (trim ($timestamp) == ''){
            $timestamp = time ();
        } elseif (!ctype_digit ($timestamp)){
            $timestamp = strtotime ($timestamp);
        }
        $date_format = preg_replace ("/S/", "", $date_format);
        $pattern = array (
            '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
            '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
            '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
            '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
            '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
            '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
            '/April/','/June/','/July/','/August/','/September/','/October/',
            '/November/','/December/',
        );
        $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
            'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
            'Januari','Februari','Maret','April','Juni','Juli','Agustus','September',
            'Oktober','November','Desember',
        );
        $date = date ($date_format, $timestamp);
        $date = preg_replace ($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }
}