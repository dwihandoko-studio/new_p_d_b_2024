<?php $uri = current_url(true); ?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "opk" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "opk" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('sigaji/opk/home') ?>">
                                <i class="bx bx-home-circle me-2"></i>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "opk" && $uri->getSegment(3) == "rekap") ? ' active-menu-href' : '' ?>" href="#" id="topnav-rekap" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-rekap">REKAP</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-rekap">
                                <!-- <a href="<?= base_url('sigaji/opk/rekap/tagihan') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "opk" && $uri->getSegment(3) == "rekap" && $uri->getSegment(4) == "tagihan") ? ' active-menu-href' : '' ?>" key="t-rekap-tagihan">Tagihan</a> -->
                                <a href="<?= base_url('sigaji/opk/rekap/laporaninstansi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "opk" && $uri->getSegment(3) == "rekap" && $uri->getSegment(4) == "laporaninstansi") ? ' active-menu-href' : '' ?>" key="t-rekap-laporaninstansi">Laporan Per Instansi</a>
                            </div>
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