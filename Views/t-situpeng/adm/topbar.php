<?php $uri = current_url(true); ?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('situgu/adm/home') ?>">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "masterdata") ? ' active-menu-href' : '' ?>" href="javascript:;" id="topnav-masterdata" role="button">
                                <i class="bx bx-layout me-2"></i><span key="t-masterdata">MASTER DATA</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-masterdata">
                                <a href="<?= base_url('situpeng/adm/masterdata/pengawas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengawas") ? ' active-menu-href' : '' ?>" key="t-masterdata-pengawas">Pengawas</a>
                                <a href="<?= base_url('situpeng/adm/masterdata/pengguna') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengguna") ? ' active-menu-href' : '' ?>" key="t-masterdata-pengguna">Pengguna</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "verifikasi") ? ' active-menu-href' : '' ?>" href="#" id="topnav-verifikasi" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-verifikasi">VERIFIKASI</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-verifikasi">
                                <a href="<?= base_url('situpeng/adm/verifikasi/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-verifikasi-tpg">Tunjangan Profesi Guru</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "sptjm") ? ' active-menu-href' : '' ?>" href="#" id="topnav-sptjm" role="button">
                                <i class="bx bx-spreadsheet me-2"></i><span key="t-sptjm">SPTJM</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-sptjm">
                                <a href="<?= base_url('situpeng/adm/sptjm/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-sptjm-tpg">Tunjangan Profesi Guru</a>
                                <a href="<?= base_url('situpeng/adm/sptjm/verifikasi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "verifikasi") ? ' active-menu-href' : '' ?>" key="t-sptjm-tamsil">Verifikasi</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us") ? ' active-menu-href' : '' ?>" href="javascript:;" id="topnav-usulan" role="button">
                                <i class="bx bx-columns me-2"></i>
                                <span key="t-usulan"> USULAN</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-usulan">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('situpeng/adm/us/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('situpeng/adm/us/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situpeng/adm/us/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('situpeng/adm/us/tpg/siapsk') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "siapsk") ? ' active-menu-href' : '' ?>" key="t-us-siapsk">Siap SK</a>
                                            <a href="<?= base_url('situpeng/adm/us/tpg/skterbit') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "skterbit") ? ' active-menu-href' : '' ?>" key="t-us-skterbit">SK Terbit</a>
                                            <a href="<?= base_url('situpeng/adm/us/tpg/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "spj") ? ' active-menu-href' : '' ?>" href="javascript:;" id="topnav-spj" role="button">
                                <i class="bx bx-task me-2"></i>
                                <span key="t-spj"> SPJ</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-spj">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('situpeng/adm/spj/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-spj-antrian">Antrian</a>
                                            <a href="<?= base_url('situpeng/adm/spj/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-spj-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situpeng/adm/spj/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-spj-lolosberkas">Lolos Verifikasi</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "cs") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "cs") ? 'javascript:;' : base_url('situpeng/adm/cs') ?>">
                                <i class="bx bx-help-circle me-2"></i><span key="t-dashboards">ADUAN</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:aksiLogout(this);">
                                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i><span key="t-logout">Logout</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>