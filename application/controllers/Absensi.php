<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Absensi_model"); //load model absen
    }

    //method pertama yang akan di eksekusi
    public function index()
    {
        $data["title"] = "Data Absensi";
        //ambil fungsi getAll untuk menampilkan semua data Absensi
        $data["data_absensi"] = $this->Absensi_model->getAll();
        //load view header.php pada folder views/templates_sekolah
        $this->load->view('templates_sekolah/header', $data);
        $this->load->view('templates_sekolah/menu');
        //load view index.php pada folder views/absensi
        $this->load->view('absensi/index', $data);
        $this->load->view('templates_sekolah/footer');
    }

    //method add digunakan untuk menampilkan form tambah data Absensi
    public function add()
    {
        $Absensi = $this->Absensi_model; //objek model
        $validation = $this->form_validation; //objek form validation
        //menerapkan rules validasi pada absensi_model
        $validation->set_rules($Absensi->rules());
        //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method save pada absensi_model
        if ($validation->run()) {
            $Absensi->save();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Absensi berhasil disimpan. 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect("absensi");
        }
        $data["title"] = "Tambah Data Absensi";
        $this->load->view('templates_sekolah/header', $data);
        $this->load->view('templates_sekolah/menu');
        $this->load->view('absensi/add', $data);
        $this->load->view('templates_sekolah/footer');
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('absensi');

        $Absensi = $this->Absensi_model;
        $validation = $this->form_validation;
        $validation->set_rules($Absensi->rules());

        if ($validation->run()) {
            $Absensi->update();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Absensi berhasil disimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect("absensi");
        }
        $data["title"] = "Edit Data Absensi";
        $data["data_absensi"] = $Absensi->getById($id);
        if (!$data["data_absensi"]) show_404();
        $this->load->view('templates_sekolah/header', $data);
        $this->load->view('templates_sekolah/menu');
        $this->load->view('absensi/edit', $data);
        $this->load->view('templates_sekolah/footer');
    }

    public function delete()
    {
        $id = $this->input->get('id');
        if (!isset($id)) show_404();
        $this->Absensi_model->delete($id);
        $msg['success'] = true;
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Absensi berhasil dihapus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button></div>');
        $this->output->set_output(json_encode($msg));
    }
}
