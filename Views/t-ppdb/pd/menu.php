<div class="dlabnav">
    <div class="dlabnav-scroll">
        <div class="dropdown header-profile2 ">
            <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                <div class="header-info2 d-flex align-items-center border">
                    <img style="max-width: 50px; max-height: 50px; width: 50px; height: 50px;" src="<?= $user->image ? base_url('uploads/user') . '/' . $user->image : base_url() . '/assets/images/profile/pic1.jpg' ?>" alt="" />
                    <div class="d-flex align-items-center sidebar-info">
                        <div>
                            <span class="font-w700 d-block mb-2"><?= isset($user) ? $user->username : '-' ?></span>
                            <small class="text-end font-w400"><?= isset($level_nama) ? $level_nama : '-' ?></small>
                        </div>
                        <i class="fas fa-sort-down ms-4"></i>
                    </div>

                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- <a href="<?= base_url('pd/profile') ?>" class="dropdown-item ai-icon ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="ms-2">Profile </span>
                </a> -->
                <a href="javascript:aksiLogout(this);" class="dropdown-item ai-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ms-2">Logout </span>
                </a>
            </div>
        </div>
        <ul class="metismenu" id="menu">
            <li><a href="<?= base_url('pd/home') ?>" class="" aria-expanded="false">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-address-card"></i>
                    <span class="nav-text">Pendaftaran</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('pd/daftar/afirmasi') ?>"><i class="fas fa-credit-card"></i> Jalur Afirmasi</a></li>
                    <li><a href="<?= base_url('pd/daftar/zonasi') ?>"><i class="fas fa-map-marked-alt"></i> Jalur Zonasi</a></li>
                    <li><a href="<?= base_url('pd/daftar/mutasi') ?>"><i class="fas fa-route"></i> Jalur Mutasi</a></li>
                    <li><a href="<?= base_url('pd/daftar/prestasi') ?>"><i class="fas fa-trophy"></i> Jalur Prestasi</a></li>
                    <li><a href="<?= base_url('pd/daftar/swasta') ?>"><i class="fas fa-school"></i> Sekolah Swasta</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-bullhorn"></i>
                    <span class="nav-text">Informasi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('pd/informasi/profil') ?>"><i class="fas fa-chalkboard-teacher"></i> Profil Peserta</a></li>
                    <li><a href="<?= base_url('pd/informasi/riwayat') ?>"><i class="fas fa-file-signature"></i> Riwayat</a></li>
                    <li><a href="<?= base_url('pd/informasi/pengumuman') ?>"><i class="fas fa-newspaper"></i> Pengumuman</a></li>
                    <li><a href="<?= base_url('pd/informasi/panduan') ?>"><i class="fas fa-parking"></i> Panduan Pendaftaran</a></li>

                </ul>
            </li>
            <!-- <li><a href="<?= base_url('pan/pd') ?>" class="" aria-expanded="false">
                    <i class="fas fa-book-reader"></i>
                    <span class="nav-text">PD Tingkat Akhir</span>
                </a>
            </li>
            <li><a href="<?= base_url('pan/pd/edit') ?>" class="" aria-expanded="false">
                    <i class="fas fa-address-card"></i>
                    <span class="nav-text">Edit Domisili</span>
                </a>
            </li>
            <li><a href="<?= base_url('pan/akun') ?>" class="" aria-expanded="false">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Generate Akun PPDB</span>
                </a>
            </li> -->
        </ul>

        <div class="copyright">
            <p><strong>DISDIKBUD Kab. Lampung Tengah</strong> © 2024 All Rights Reserved</p>
            <p class="fs-12">Support <span class="heart"></span> by Esline.id</p>
        </div>
    </div>
</div>