<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['(:any)/(:any)/(:any)/(:any)'] = 'home/blog_detail';
$route['fitur_detail/(:any)'] = 'home/blog_detail';
$route['kelas_detail/(:any)'] = 'home/kelas_detail';
$route['pengumuman_detail/(:any)'] = 'home/pengumuman_detail';

/*$route['login']		= 'home/login';*/
$route['profil']	= 'siswa/profil';



$route['berita'] = 'home/berita';
//$route['berita/(:any)'] = 'home/berita/$1';
$route['kontak'] = 'home/kontak';
$route['kontaktoko'] = 'home/kontaktoko';

$route['toko'] = 'home/toko';
$route['keranjang'] = 'home/keranjang';
$route['cekpesanan'] = 'home/cekpesanan';
$route['produk/(:any)'] = $route['produk/(:num)/(:any)'] = $route['produk/detail/(:any)'] = 'home/produk_detail';
$route['produk'] = $route['produk'] = $route['produk/(:any)'] = $route['produk/(:any)/(:any)'] = 'home/produk';

$route['(:any)/(:num)/(:num)/(:any)'] = 'home/berita_detail';
$route['konten/(:any)'] = 'home/konten_detail';
$route['cari_kategori'] = 'home/berita_kategori';
$route['cari_arsip'] = 'home/berita_arsip';
$route['cari_berita'] = 'home/berita_cari';