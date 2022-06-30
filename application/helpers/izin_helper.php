<?php

// ngecek apakah udah login
function is_logged_in()
{
    // memanggil librari CI ke helper
    $ci = get_instance();

    // kalau ga belom login, ya ga boleh masuk
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        // kalau udah masuk, kita cek dia itu statusnya apa user / admin
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $querMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $querMenu['id'];

        // minta ke database untuk mencari role_id dan menu_id
        $userAcess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        // dari DB, kalau isinya bukan 1 ga boleh masuk ke admin
        if ($userAcess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}


// untuk mengecek akses
function check_access($role_id, $menu_id)
{
    // memanggil librari CI ke helper
    $ci = get_instance();

    // minta tolong carikan role id & menu id di database
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);

    $result = $ci->db->get('user_access_menu');

    // kalau di tabel user acces menu ada nilai 0 maka cheked
    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
