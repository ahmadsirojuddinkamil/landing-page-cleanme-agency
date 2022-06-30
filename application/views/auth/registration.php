<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- setingan registrasi -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <!-- judul -->
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun</h1>
                        </div>

                        <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                            <!-- untuk nama -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name" value="<?= set_value('name') ?>">
                                <!-- belum diisi nama -->
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <!-- untuk email -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" value="<?= set_value('email') ?>">
                                <!-- belum diisi email -->
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group row">
                                <!-- untuk pasword 1 -->
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                    <!-- belum diisi paspod -->
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>

                                <!-- untuk pasword 2 -->
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulangi Password">
                                </div>
                            </div>

                            <!-- tombol kirim data daftar -->
                            <button type="submit" class="btn btn-info btn-user btn-block">
                                Register Akun
                            </button>
                        </form>
                        <hr>

                        <!-- balik ke tampilan login, karena udah punya akun -->
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth') ?>">Sudah punya akun? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>