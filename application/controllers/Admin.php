<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    // digunakan kalau belum login ga bisa akses hal admin
    public function __construct()
    {
        parent::__construct();
        // Helper kalau tidak ada kepentingan untuk masuk
    }

    // setingan untuk admin
    public function index()
    {
        $data['title'] = 'Menu Pilihan :';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // mengambil tampilan dari setiap komponen view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    // setingan untuk role
    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // query / minta ke database tabel user_role
        $data['role'] = $this->db->get('user_role')->result_array();

        // mengambil tampilan dari setiap komponen view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    // setingan untuk akses ke setiap role
    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // query / minta ke database tabel user_role
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        // admin [1] tidak boleh ada di menu, karena bisa kehapus
        $this->db->where('id !=', 1);

        // minta ke db untuk tampilin semua user
        $data['menu'] = $this->db->get('user_menu')->result_array();

        // mengambil tampilan dari setiap komponen view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    // method untuk ajax jquery
    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        // daftar tabel yang pengen dicari
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        // minta data di db apakah ada data ini
        $result = $this->db->get_where('user_access_menu', $data);

        // setelah dicari, liat kalau nilai nya 1 maka boleh
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            // kalau bukan 1 ga boleh
            $this->db->delete('user_access_menu', $data);
        }

        // pesan ketika berhasil berubah
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Mengubah!</div>');
    }
}
