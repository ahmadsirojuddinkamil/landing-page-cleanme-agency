<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Absensi</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary mb-2" href="<?= base_url('absensi/add'); ?>">Tambah Data Absensi</a>
            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php if ($this->session->flashdata('message')) :
                    echo $this->session->flashdata('message');
                endif; ?>
            </div>

            <!-- Tombol untuk menampilkan hasil rekap -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Rekap Absensi
            </button>
            <!-- Selesai Tombol untuk menampilkan hasil rekap -->

            <!-- Hasil rekap absen -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <!-- judul -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hasil Rekap</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Isi rekap -->
                        <div class="modal-body">
                            <table class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                    <tr class="table-success">
                                        <th>NAMA</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_absensi as $row) : ?>
                                        <tr>
                                            <td><?= $row->Nama ?></td>
                                            <td><?= $row->Kehadiran ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Selesai rekap absen -->

            <br><br>

            <!-- absensi -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tableAbsensi">
                            <thead>
                                <tr class="table-success">
                                    <th>PILIHAN</th>
                                    <th>NAMA</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_absensi as $row) : ?>
                                    <tr>
                                        <td>
                                            <!-- setingan untuk edit -->
                                            <a href="<?= site_url('absensi/edit/' . $row->IdMhsw) ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
                                            <!-- setingan untuk hapus -->
                                            <a href="javascript:void(0);" data="<?= $row->IdMhsw ?>" class="btn btn-danger btn-sm item-delete"><i class="fa fa-trash"></i> </a>
                                        </td>
                                        <td><?= $row->Nama ?></td>
                                        <td><?= $row->Kehadiran ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- selesai absensi -->
        </div>
    </div>
</div>

<!-- Modal dialog hapus data-->
<div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="myModalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalDeleteLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="btdelete">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
<!-- Selesai Modal dialog hapus data-->

<script>
    // ===========================
    // setingan search untuk absen
    // ===========================

    //menampilkan data ketabel dengan plugin datatables
    $('#tableAbsensi').DataTable();

    //menampilkan modal dialog saat tombol hapus ditekan
    $('#tableAbsensi').on('click', '.item-delete', function() {
        //ambil data dari atribute data 
        var id = $(this).attr('data');
        $('#myModalDelete').modal('show');
        //ketika tombol lanjutkan ditekan, data id akan dikirim ke method delete 
        //pada controller Absensi
        $('#btdelete').unbind().click(function() {
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                url: '<?php echo base_url() ?>absensi/delete/',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#myModalDelete').modal('hide');
                    location.reload();
                }
            });
        });
    });


    // ===========================
    // setingan search untuk rekap
    // ===========================

    //menampilkan data ketabel dengan plugin datatables
    $('#tableRekap').DataTable();
</script>