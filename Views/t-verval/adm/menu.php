<div class="dlabnav">
    <div class="dlabnav-scroll">
        <div class="dropdown header-profile2 ">
            <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                <div class="header-info2 d-flex align-items-center border">
                    <img style="max-width: 50px; max-height: 50px; width: 50px; height: 50px;" src="<?= $user->image ? base_url('uploads/user') . '/' . $user->image : base_url() . '/assets/images/profile/pic1.jpg' ?>" alt="" />
                    <div class="d-flex align-items-center sidebar-info">
                        <div>
                            <span class="font-w700 d-block mb-2"><?= isset($user) ? $user->nama : '-' ?></span>
                            <small class="text-end font-w400"><?= isset($level_nama) ? $level_nama : '-' ?></small>
                        </div>
                        <i class="fas fa-sort-down ms-4"></i>
                    </div>

                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="<?= base_url('adm/profile') ?>" class="dropdown-item ai-icon ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="ms-2">Profile </span>
                </a>
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
            <li><a href="<?= base_url() ?>" class="" aria-expanded="false">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-table"></i>
                    <span class="nav-text">Masterdata</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('adm/masterdata/pengguna') ?>">Pengguna</a></li>
                    <li><a href="<?= base_url('adm/masterdata/sekolah') ?>">Sekolah</a></li>
                    <li><a href="<?= base_url('adm/masterdata/pd') ?>">Peserta Didik</a></li>
                    <li><a href="<?= base_url('adm/masterdata/kelurahan') ?>">Kelurahan</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-balance-scale"></i>
                    <span class="nav-text">Setting</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('adm/setting/kuota') ?>">Kuota Sekolah</a></li>
                    <li><a href="<?= base_url('adm/setting/zonasi') ?>">Zona Wilayah</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="nav-text">Layanan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('adm/layanan/pd') ?>">PD Tingkat Akhir</a></li>
                    <li><a href="<?= base_url('adm/layanan/akun') ?>">Akun PD</a></li>
                    <li><a href="<?= base_url('adm/layanan/panitia') ?>">Panitia PPDB</a></li>
                    <li><a href="<?= base_url('adm/layanan/cabutberkas') ?>">Cabut Berkas Verifikasi</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-table"></i>
                    <span class="nav-text">Validasi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('adm/validasi/pdakhir') ?>">Pd Tingkat Akhir</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-binoculars"></i>
                    <span class="nav-text">Analisis</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('adm/analisis/proses') ?>">Proses</a></li>
                </ul>
            </li>
            <li><a href="<?= base_url('adm/pengaduan') ?>" class="" aria-expanded="false">
                    <i class="fab fa-teamspeak"></i>
                    <span class="nav-text">Pengaduan</span>
                </a>
            </li>
        </ul>

        <div class="copyright">
            <p><strong>DISDIKBUD Kab. Lampung Tengah</strong> © 2024 All Rights Reserved</p>
            <p class="fs-12">Support <span class="heart"></span> by Esline.id</p>
        </div>
    </div>
</div>