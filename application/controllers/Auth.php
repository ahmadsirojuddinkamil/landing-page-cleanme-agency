<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        // memanggil method konstruktor di ci
        parent::__construct();
        $this->load->library('form_validation');
    }

    // setingan untuk login
    public function index()
    {
        // Setingan kalau udah login harus logout dulu baru bisa keluar
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        // SETINGAN KALAU INPUT LOGIN TIDAK DIISI
        // =====================================
        // untuk email
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        // untuk password
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // kalau login gagal tampilkan halaman login ulang
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // kalau berhasil login [pake external]
            $this->_login();
        }
    }

    // setingan pengecekan untuk masuk login [external untuk index login]
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // kirim ke database
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika akun sudah dibuat
        if ($user) {
            // user aktif
            if ($user['is_active'] == 1) {
                // cek paspod nya [benar]
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    // paspod salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda salah!</div>');
                    // balik ke tampilan login
                    redirect('auth');
                }
            } else {
                // pesan ketika akun belum aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun belum aktif!</div>');
                // balik ke tampilan login
                redirect('auth');
            }
        } else {
            // pesan ketika akun belum dibuat
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun belum terdaftar!</div>');
            // balik ke tampilan login
            redirect('auth');
        }
    }

    // setingan untuk registrasi
    public function registration()
    {
        // Setingan kalau udah login harus logout dulu baru bisa keluar
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        // SETINGAN KALAU INPUT REGISTRASI TIDAK DIISI
        // ===============================
        // untuk nama
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        // untuk email
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email sudah digunakan!'
        ]);
        // untuk password [1] minimal 6 karakter
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'password dont match!',
            'min_length' => 'Password Kependekan!'
        ]);
        // untuk password [2] minimal 6 karakter
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        // kalau validasi gagal tampilkan ulang
        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            // kalau berhasil bawa data ke database
            $data = [
                // isi datanya
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                // password di enkripsi
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            // untuk membawa ke database
            $this->db->insert('user', $data);
            // pesan ketika berhasil bikin akun
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Membuat Akun! Silahkan Login</div>');
            // setelah login masuk ke aplikasinya
            redirect('auth');
        }
    }

    // setingan untuk logout
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        // pesan ketika berhasil logout
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Logout!</div>');
        // setelah logout kembali ke halaman login
        redirect('auth');
    }

    // setingan untuk memblokir user mau masuk ke admin
    public function blocked()
    {
        // mengambil komponen view
        $this->load->view('auth/blocked');
    }
}
