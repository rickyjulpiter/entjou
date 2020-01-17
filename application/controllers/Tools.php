<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');

    }    
    /*------------------------------- Tools -------------------------------*/ 
    public static function limit_words($string, $word_limit){
        $words = substr($string, 0, $word_limit);
        return $words;
    }   
    public static function tgl_indo($timestamp = '', $date_format = 'l, j F Y', $suffix = '') {
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
    public static function tgl($ptime){
        $estimate_time = time() - strtotime($ptime);
        if( $estimate_time < 1 ){
            return 'kurang dari 1 menit yang lalu';
        }
        $condition = array( 
            12 * 30 * 24 * 60 * 60  =>  'tahun',
            30 * 24 * 60 * 60       =>  'bulan',
            24 * 60 * 60            =>  'hari',
            60 * 60                 =>  'jam',
            60                      =>  'menit',
            1                       =>  'detik'
        );
        foreach( $condition as $secs => $str ){
            $d = $estimate_time / $secs;
            if( $d >= 1 ){
                $r = round( $d );
                return $r.' '.$str.' yang lalu';
            }
        }
    }  
          
    function kode5($ak){
        $kode = "";        
        if ($ak>0 and $ak<10) {
            $kode = "0000".$ak;
        }elseif ($ak>=10 and $ak<100) {
            $kode = "000".$ak;
        }elseif ($ak>=100 and $ak<1000) {
            $kode = "00".$ak;
        }elseif ($ak>=1000 and $ak<10000) {
            $kode = "0".$ak;
        }elseif ($ak>=10000 and $ak<100000) {
            $kode = $ak;
        }
        return $kode;        
    }
    function kode4($ak){
        $kode = "";        
        if ($ak>0 and $ak<10) {
            $kode = "000".$ak;
        }elseif ($ak>=10 and $ak<100) {
            $kode = "00".$ak;
        }elseif ($ak>=100 and $ak<1000) {
            $kode = "0".$ak;
        }elseif ($ak>=1000 and $ak<10000) {
            $kode = $ak;
        }
        return $kode;        
    }
    function kode3($ak){
        $kode = "";        
        if ($ak>0 and $ak<10) {
            $kode = "00".$ak;
        }elseif ($ak>=10 and $ak<100) {
            $kode = "0".$ak;
        }elseif ($ak>=100 and $ak<1000) {
            $kode = $ak;
        }
        return $kode;        
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
    public static function rupiah($rp="",$angka=""){        
        if ($rp=="") {
            $hasil_rupiah = number_format($angka,0,',','.');
        }else{
            $hasil_rupiah = "Rp ".number_format($angka,0,',','.');
        }        
        return $hasil_rupiah;     
    }
    
    public static function random_number(){
        $ar = array(1,2,3,4,5,6,7,8,9,0);
        $rand = array_rand($ar,6);
        $res = "";
        for ($i=0; $i < sizeof($rand); $i++) { 
            $res .= $rand[$i];
        }
        return $res;
    }  
}
