<nav class="navbar navbar-expand-md bg-info">
    <!-- Brand -->
    <a class="navbar-brand text-white" href="<?= base_url('user'); ?>">Aplikasi CI</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link text-white text-white" href="<?= base_url('mahasiswa'); ?>">Data Mahasiswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="<?= base_url('absensi'); ?>">Absensi</a>
            </li>
            <a class="nav-link text-white" href="<?= base_url('user') ?>">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>My Profile</span>
            </a>
            <a class="nav-link text-white" href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </ul>
    </div>
</nav>