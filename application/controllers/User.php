<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    // digunakan kalau belum login ga bisa akses hal admin
    public function __construct()
    {
        parent::__construct();
        // Helper kalau tidak ada kepentingan untuk masuk
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // mengambil tampilan dari setiap komponen
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    // =========================
    // SETINGAN UNTUK EDIT PROFIL
    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // peringatan kalau belum isi edit nama
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        // kalau salah tampilkan halaman edit lagi
        if ($this->form_validation->run() == false) {
            // mengambil tampilan dari setiap komponen view
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // kalau berhasil isi nama & gambar
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // setingan untuk upload gambar
            $upload_image = $_FILES['image']['name'];

            // hanya boleh upload gambar ga boleh yang lain
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                // lalu kalau yang diupload bener gambar
                if ($this->upload->do_upload('image')) {
                    // setingan untuk menghapus gambar yang lama
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            // pesan ketika berhasil edit profil
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Mengubah Profil!</div>');
            // setelah edit kembali ke profil
            redirect('user');
        }
    }
}
