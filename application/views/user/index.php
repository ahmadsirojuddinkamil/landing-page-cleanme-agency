<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- untuk memberitahu kalau sudah edit profile -->
    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-fluid rounded-start">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['name']; ?></h5>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text"><small class="text-muted">Terdaftar Sejak : <?= date('d F Y', $user['date_created']); ?></small></p>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-success"><a class="nav-link text-white" href="<?= base_url('mahasiswa'); ?>">Data Mahasiswa</a></button>
    <button type="button" class="btn btn-success"><a class="nav-link text-white" href="<?= base_url('absensi'); ?>">Absensi</a></button>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->