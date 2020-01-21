<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');

        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->foto         = $this->session->userdata('foto');
        include 'Tools.php';
    }
    function index()
    {
        $data = array(
            'title'     => 'Beranda',
            'isi'       => 'frontend/view_home',
            'slider'    => $this->model_admin->select_data('slider', null, array('publish' => 'Y'), null, 'waktu_edit DESC'),
            'blog'      => $this->model_admin->select_data('blog', null, array('publish' => 'Y', 'kategori' => 'blog'), null, 'waktu_post DESC', 3),
            'pengumuman' => $this->model_admin->select_data('pengumuman', null, array('publish' => 'Y', 'kategori' => 'umum'), null, 'waktu_post DESC', 3),
            'kelas'     => $this->model_admin->select_data('_kelas'),
            'pengaturan' => $this->model_admin->select_data('pengaturan'),
            'fasilitator' => $this->model_admin->select_data('users', null, array('tipe_user' => 'guru')),
            'testimoni' => $this->model_admin->select_data('testimoni'),
            'program'   => $this->model_admin->select_data('program_partner', 'foto,link', array('kategori' => 'program', 'publish' => 'Y')),
            'partner'   => $this->model_admin->select_data('program_partner', 'foto,link', array('kategori' => 'partner', 'publish' => 'Y')),

        );
        $this->load->view('layout_home', $data);
    }

    function coba2()
    {
        /*$file = file_get_contents("./assets/materi/pdf_0 menyusun strategi perang (bmc).txt");
        $berkas = "data:application/pdf;base64,".$file."#toolbar=0";
        echo $berkas;        */
        $data = file_get_contents("./assets/materi/abc.pdf");
        $base64 = 'data:application/pdf;base64,' . base64_encode($data) . "#toolbar=0";
        /*$base64 = base_url().'assets/materi/Prototype.pdf#toolbar=0';*/
        echo $base64;
        /*echo $base64;*/
    }
    function coba()
    {
        $this->load->view('frontend/materi');
    }

    function daftar_proses()
    {
        $data = array(
            'username'          => $this->input->post('username'),
            'password'          => md5($this->input->post('password2')),
            'secret_quest'      => $this->input->post('secret_quest'),
            'secret_ans'        => $this->input->post('secret_ans'),
            'tipe_user'         => 'siswa',
            'nama_lengkap'      => $this->input->post('nama_lengkap'),
            'nama_panggilan'    => $this->input->post('nama_panggilan'),
            'tanggal_lahir'     => Tools::tgl_indo($this->input->post('tanggal_lahir'), 'Y-m-d'),
            'tempat_lahir'      => $this->input->post('tempat_lahir'),
            'jk'                => $this->input->post('jk'),
            'agama'             => $this->input->post('agama'),
            'alamat'            => $this->input->post('alamat'),
            'wa'                => $this->input->post('wa'),
            'email'             => $this->input->post('email'),
            'tentang'           => $this->input->post('tentang'),
            'waktu_post'        => date('Y-m-d H:i:s'),
            'waktu_edit'        => date('Y-m-d H:i:s')
        );
        $this->model_admin->insert_data('users', $data);
        $this->notif('success', 'Anda berhasil mendaftar. Silahkan masuk menggunakan akun yang sudah dibuat');
        redirect('login');
    }
    function pass_update()
    {
        $where = array('username' => $this->input->post('username2'));
        $data  = array(
            'password'      => md5($this->input->post('passUl'))
        );
        $this->model_admin->update_data('users', $data, $where);
        $this->notif('success', 'Kata sandi anda berhasil diubah. Silahkan masuk menggunakan kata sandi yang baru.');
        redirect('login');
    }
    /*--------------- Kelas -----------------*/
    function kelas()
    {
        $kelas = $this->model_admin->select_data('_kelas', null, array('status' => 'Y'));

        $id = $this->input->get('per_page');
        //pengaturan pagination
        $config['page_query_string'] = TRUE;
        $config['base_url']   = base_url() . 'home/kelas';
        $config['total_rows'] = count($kelas);
        $config['per_page']   = '5';
        $config['first_link'] = 'Awal';
        $config['last_link']  = 'Akhir';
        $config['next_page']  = '«';
        $config['prev_page']  = '»';
        //inisialisasi config
        $this->pagination->initialize($config);
        $data = array(
            'title'     => 'Kelas',
            'isi'       => 'frontend/view_kelas_list',
            'halaman'   => $this->pagination->create_links(),
            'nourut'    => $id,
            'total'     => count($kelas),
            'kelas'      => $this->model_admin->select_data('_kelas', null, array('status' => 'Y'), null, 'waktu_edit DESC', $config['per_page'], $id),
        );
        $this->load->view('layout_home', $data);
    }
    function kelas_detail()
    {
        $where = array(
            'slug'      => uri_string()
        );

        $kelas  = $this->model_admin->select_data('_kelas', null, $where);
        $id_kelas = $kelas[0]['id_kelas'];

        /*$peserta = $this->model_admin->select_data('_peserta_kelas',null,array('id_kelas'=>$id_kelas,'id_siswa'=>$this->id_user));*/

        $review = $this->model_admin->select_data('review', null, array('id_kelas' => $id_kelas));

        $anoun  = $this->model_admin->select_data('pengumuman', null, array('id_kelas' => $id_kelas, 'kategori' => 'kelas'), null, 'waktu_post DESC');

        $pesanan = $this->model_admin->select_data('pesanan', null, array('id_kelas' => $id_kelas, 'id_siswa' => $this->id_user));

        $stage  = $this->model_admin->select_data('_stage', null, array('id_kelas' => $id_kelas));

        $id_guru = explode(",", str_replace("'", "", $kelas[0]['id_guru']));
        $guru = $this->model_admin->select_datast('users', null, null, 'id_user', $id_guru);

        $materi = $this->model_admin->select_data('_materi', null, array('id_kelas' => $id_kelas), null, 'judul_materi ASC');

        $ambil_kelas = $this->model_admin->select_data('pesanan', null, array('id_kelas' => $id_kelas));

        $data = array(
            'title'     => $kelas[0]['nama_kelas'],
            'isi'       => 'frontend/view_kelas_detail',
            'kelas'     => $kelas,
            'guru'      => $guru,
            'review'    => $review,
            'pengumuman' => $anoun,
            'pesanan'   => $pesanan,
            'stage'     => $stage,
            'materi'    => $materi,
            'ambil_kelas' => count($ambil_kelas)
        );
        $this->load->view('layout_home', $data);
    }
    function kelas_order()
    {
        $dt = $this->model_admin->select_data('pesanan', 'MAX(SUBSTRING(id_pesanan,13,4)) as no_urut', array('SUBSTRING(id_pesanan,5,8)' => date('Ymd')));
        if (!empty($dt)) {
            $no_urut = $this->kode4($dt[0]['no_urut'] + 1);
        } else {
            $no_urut = $this->kode4(1);
        }
        $data = array(
            'id_pesanan'    => 'ENTJ' . date('Ymd') . $no_urut,
            'id_kelas'      => $this->input->post('id_kelas'),
            'nama_kelas'    => $this->input->post('nama_kelas'),
            'id_siswa'      => $this->id_user,
            'nama_siswa'    => $this->nama,
            'total'         => $this->input->post('total'),
            'waktu'         => date('Y-m-d H:i:s')
        );
        $this->model_admin->insert_data('pesanan', $data);
        $this->notif('success', 'Kelas "' . $this->input->post('nama_kelas') . '" berhasil di ambil. Silahkan lakukan pembayaran.');
        redirect($this->input->post('slug'));
    }
    function review_add()
    {
        $data = array(
            'id_kelas'      => $this->input->post('id_kelas'),
            'nama_kelas'    => $this->input->post('nama_kelas'),
            'judul'         => $this->input->post('judul'),
            'isi'           => $this->input->post('isi'),
            'rating'        => $this->input->post('rating'),
            'id_siswa'      => $this->id_user,
            'nama_siswa'    => $this->nama,
            'foto'          => $this->foto
        );
        $this->model_admin->insert_data('review', $data);
        $this->notif('success', 'Review kamu berhasil ditambahkan!');
        redirect($this->input->post('slug'));
    }
    /*--------------- Kelas -----------------*/
    /*--------------- Materi -----------------*/
    function materi_detail($id_kelas)
    {
        $id_kelas = $this->encrypt->decode($id_kelas);
        $pesanan  = $this->model_admin->select_data('pesanan', null, array('id_kelas' => $id_kelas, 'id_siswa' => $this->id_user));
        $kelas    = $this->model_admin->select_data('_kelas', 'harga', array('id_kelas' => $id_kelas));
        if (!empty($pesanan)) {
            $status = $pesanan[0]['status'];
        } else {
            $status = "";
        }

        if (($status == "dibayar" or $kelas[0]['harga'] == 0) and !empty($this->id_user)) {
            $stage  = $this->model_admin->select_data('_stage', null, array('id_kelas' => $id_kelas));

            $id_stage = $this->input->get('stage');
            if ($id_stage == "") {
                $materi = "";
            } else {
                $materi = $this->model_admin->select_data('_materi', null, array('id_kelas' => $id_kelas, 'id_stage' => $id_stage), null, 'judul_materi ASC');
            }
            $tipe = $this->input->get('tipe');
            if ($tipe == "") {
                $konten = 'frontend/konten_learning/materi';
            }
            if ($tipe == "materi") {
                $konten = 'frontend/konten_learning/materi';
            } elseif ($tipe == "games") {
                $konten = 'frontend/konten_learning/games';
            } elseif ($tipe == "quiz") {
                $konten = 'frontend/konten_learning/quiz';
            } elseif ($tipe == "project") {
                $konten = 'frontend/konten_learning/project';
            }

            $data = array(
                'title'     => 'Detail Materi',
                'konten'    => $konten,
                'stage'     => $stage,
                'materi'    => $materi

            );
            $this->load->view('frontend/materi_detail', $data);
        } else {
            show_404();
        }
    }
    function materi_selesai($id_materi)
    {
        $data = array('selesai' => 'Y');
        $where = array('id_materi' => $this->encrypt->decode($id_materi));
        $this->model_admin->update_data('_materi', $data, $where);
    }
    function get($table, $id_materi, $id_tambahan = "")
    {
        $where = array('id_materi' => $id_materi);
        if ($id_tambahan != "") {
            $where['id_siswa'] = $id_tambahan;
        }
        $data = $this->model_admin->select_data($table, null, $where);
        return $data;
    }
    function quiz_add()
    {
        $this->load->library('upload');
        if ($_FILES['inputPdf']['name']) {
            $nmfile = 'tugas_' . $this->input->post('id_quiz') . '-' . str_replace(".", "", strtolower($this->nama));
            $config['upload_path'] = realpath(APPPATH . '../assets/tugas_siswa/');
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $nmfile;

            $this->upload->initialize($config);
            $this->upload->do_upload('inputPdf');
            $tugas = $this->upload->file_name;
        }
        $data = array(
            'id_quiz'       => $this->input->post('id_quiz'),
            'id_materi'     => $this->input->post('id_materi'),
            'id_stage'      => $this->input->post('id_stage'),
            'id_kelas'      => $this->input->post('id_kelas'),
            'jawaban_pg'    => $this->input->post('jawaban_pg'),
            'jawaban_isian' => $this->input->post('jawaban_isian'),
            'upload_tugas'  => $tugas,
            'id_siswa'      => $this->id_user,
            'nama_siswa'    => $this->nama,
            'waktu_post'    => date('Y-m-d H:i:s'),
        );
        $response = $this->model_admin->insert_data('_quiz_hasil', $data);
        $this->notif('success', 'Quiz kamu berhasil disubmit dan dalam proses penilaian');
        redirect($this->input->post('url'));
    }
    function project_add()
    {
        $data = array(
            'id_materi'     => $this->input->post('id_materi'),
            'judul_materi'  => $this->input->post('judul_materi'),
            'title'         => $this->input->post('title'),
            'deskripsi'     => $this->input->post('deskripsi'),
            'id_siswa'      => $this->id_user,
            'nama_siswa'    => $this->nama,
            'color'         => '#FF0000',
            'waktu_post'    => date('Y-m-d H:i:s'),
            'start'         => Tools::tgl_indo($this->input->post('start'), 'Y-m-d'),
            'end'           => Tools::tgl_indo($this->input->post('start'), 'Y-m-d'),
            'allDay'        => 'true'
        );
        $this->model_admin->insert_data('agenda', $data);
        $this->notif('success', 'Kamu berhasil menambahkan project ini ke agenda');
        redirect($this->input->post('url'));
    }
    /*--------------- Materi -----------------*/
    /*------- frontend --------*/
    function kontak()
    {
        $data = array(
            'title'     => 'kontak',
            'isi'       => 'frontend/view_kontak',
            'kontak'    => $this->model_admin->select_data('pengaturan', null, array('id_pengaturan' => 1)),
        );
        $this->load->view('layout_home', $data);
    }

    function blog()
    {
        $id = $this->input->get('per_page');
        //pengaturan pagination
        $config['page_query_string'] = TRUE;
        $config['base_url']   = base_url() . 'home/blog';
        $config['total_rows'] = count($this->model_admin->select_data('blog', null, array('publish' => 'Y')));
        $config['per_page']   = '6';
        $config['first_link'] = 'Awal';
        $config['last_link']  = 'Akhir';
        $config['next_page']  = '«';
        $config['prev_page']  = '»';
        //inisialisasi config
        $this->pagination->initialize($config);
        $data = array(
            'title'     => 'Blog',
            'isi'       => 'frontend/view_blog_list',
            'halaman'   => $this->pagination->create_links(),
            'nourut'    => $id,
            'total'     => count($this->model_admin->select_data('blog', null, array('publish' => 'Y'))),
            'data'      => $this->model_admin->select_data('blog', null, array('publish' => 'Y'), null, 'waktu_post DESC', $config['per_page'], $id),
            'data2'      => $this->model_admin->select_data('blog', null, array('publish' => 'Y'), null, 'waktu_post DESC', 4)
        );
        $this->load->view('layout_home', $data);
    }
    function blog_detail()
    {
        $where = array(
            'slug'      => uri_string()
        );
        $blog       = $this->model_admin->select_data('blog', null, $where);
        $komentar   = $this->model_admin->select_data('blog_komentar', null, array('id_post' => $blog[0]['id_post']), null, 'waktu_post DESC');
        $data = array(
            'title'     => $blog[0]['judul'],
            'isi'       => 'frontend/view_blog_detail',
            'blog'      => $blog,
            'komentar'  => $komentar
        );
        $this->load->view('layout_home', $data);
    }
    function curhat_tambah()
    {
        $nama       = $this->input->post('nama');
        $nowa    = $this->input->post('nowa');
        $email       = $this->input->post('email');
        $namausaha      = $this->input->post('namausaha');
        $deskripsi    = $this->input->post('deskripsi');
        $curhatan   = $this->input->post('curhatan');

        $data = array(
            'nama'     => strip_tags($nama),
            'nowa'   => strip_tags($nowa),
            'email'  => strip_tags($email),
            'namausaha'  => strip_tags($namausaha),
            'deskripsi'  => strip_tags($deskripsi),
            'curhatan'  => strip_tags($curhatan)
        );
        $this->model_admin->insert_data('curhat', $data);
        $this->notif('success', 'Terimakasih sudah curhat bisnis bersama kami. Curhatan kamu akan ditanggapi 1x24 jam oleh KaSha (Kawan Sharing) terbaik kami melalui WA. Semangat ya untuk bisnis kamu, mari kita ciptakan bisnis besar yang mampu membantu banyak orang. Semangat!');
        redirect(base_url('home'));
    }
    function komentar_tambah()
    {
        $slug       = $this->input->post('slug');
        $id_post    = $this->input->post('id_post');
        $nama       = $this->input->post('nama');
        $email      = $this->input->post('email');
        $website    = $this->input->post('website');
        $komentar   = $this->input->post('komentar');

        $data = array(
            'id_post'   => $id_post,
            'nama_user' => strip_tags(ucwords($nama)),
            'email'     => strip_tags($email),
            'website'   => strip_tags($website),
            'komentar'  => strip_tags($komentar),
            'waktu_post' => date('Y-m-d H:i:s'),
        );
        $this->model_admin->insert_data('blog_komentar', $data);
        if ($website != "kontak") {
            $this->notif('success', 'Komentar anda berhasil diterbitkan');
        } else {
            $this->notif('success', 'Pesan anda sudah kami terima. Jawaban akan kami kirim ke alamat email yang anda masukan');
        }
        redirect(base_url('home/') . $slug . '#komentar');
    }
    function pengumuman_detail()
    {
        $where = array(
            'slug'      => uri_string()
        );
        $pengumuman       = $this->model_admin->select_data('pengumuman', null, $where);
        $data = array(
            'title'     => $pengumuman[0]['judul'],
            'isi'       => 'frontend/pengumuman_detail',
            'pengumuman' => $pengumuman,
        );
        $this->load->view('layout_home', $data);
    }
    function pengumuman()
    {
        $id = $this->input->get('per_page');
        //pengaturan pagination
        $config['page_query_string'] = TRUE;
        $config['base_url']   = base_url() . 'home/pengumuman';
        $config['total_rows'] = count($this->model_admin->select_data('pengumuman', null, array('publish' => 'Y')));
        $config['per_page']   = '6';
        $config['first_link'] = 'Awal';
        $config['last_link']  = 'Akhir';
        $config['next_page']  = '«';
        $config['prev_page']  = '»';
        //inisialisasi config
        $this->pagination->initialize($config);
        $data = array(
            'title'     => 'Pengumuman',
            'isi'       => 'frontend/pengumuman_list',
            'halaman'   => $this->pagination->create_links(),
            'nourut'    => $id,
            'total'     => count($this->model_admin->select_data('pengumuman', null, array('publish' => 'Y'))),
            'data'      => $this->model_admin->select_data('pengumuman', null, array('publish' => 'Y', 'kategori' => 'umum'), null, 'waktu_post DESC', $config['per_page'], $id),
            'data2'      => $this->model_admin->select_data('pengumuman', null, null, null, 'waktu_post DESC', 4)
        );
        $this->load->view('layout_home', $data);
    }
    function notif($button, $pesan)
    {
        $this->session->set_flashdata('notif', '<center><div class="alert alert-' . $button . '" role="alert" style="border:solid 1px;">' . $pesan . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }

    function kode4($ak)
    {
        $kode = "";
        if ($ak > 0 and $ak < 10) {
            $kode = "000" . $ak;
        } elseif ($ak >= 10 and $ak < 100) {
            $kode = "00" . $ak;
        } elseif ($ak >= 100 and $ak < 1000) {
            $kode = "0" . $ak;
        } elseif ($ak >= 1000 and $ak < 10000) {
            $kode = $ak;
        }
        return $kode;
    }
    function cek_username($username = null)
    {
        $username       = $this->input->post('username');
        $this->db->where('username', $username);
        $data = $this->db->get('users');
        echo count($data->result_array());
    }
    function cek_username1($username = null)
    {
        $this->db->where('username', $username);
        $this->db->where('tipe_user', 'siswa');
        $data = $this->db->get('users');
        $res = $data->result_array();
        if (!empty($res)) {
            echo $res[0]['secret_quest'];
        } else {
            echo "kosong";
        }
    }
    function cek_ans($username = null, $ans = null)
    {
        $this->db->where('username', $username);
        $this->db->where('secret_ans', $ans);
        $data = $this->db->get('users');
        echo count($data->result_array());
    }
}
