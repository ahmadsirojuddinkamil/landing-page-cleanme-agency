<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // minta data ke table user_menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        // setingan kalau tambah menu ga diisi
        if ($this->form_validation->run() == false) {
            // mengambil tampilan dari setiap komponen view
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            // kalau diisi tambah menu
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            // berhasil tambah menu
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menambahkan menu!</div>');
            // balik ke daftar menu
            redirect('menu');
        }
    }
    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if ($this->form_validation->run() == false) {
            // mengambil tampilan dari setiap komponen view
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            // berhasil tambah sub menu
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menambahkan sub menu!</div>');
            // balik ke daftar menu
            redirect('menu/submenu');
        }
    }
}
