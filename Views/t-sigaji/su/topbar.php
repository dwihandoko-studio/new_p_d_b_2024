<?php $uri = current_url(true); ?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('sigaji/su/home') ?>">
                                <i class="bx bx-home-circle me-2"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata") ? ' active-menu-href' : '' ?>" href="#" id="topnav-masterdata" role="button">
                                <i class="bx bx-layout me-2"></i><span key="t-masterdata">MASTER DATA</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-masterdata">
                                <a href="<?= base_url('sigaji/su/masterdata/pegawai') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pegawai") ? ' active-menu-href' : '' ?>" key="t-masterdata-pegawai">Pegawai</a>
                                <!-- <a href="<?= base_url('sigaji/su/masterdata/ptk') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "ptk") ? ' active-menu-href' : '' ?>" key="t-masterdata-ptk">PTK</a> -->
                                <!-- <a href="<?= base_url('sigaji/su/masterdata/refgaji') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "refgaji") ? ' active-menu-href' : '' ?>" key="t-masterdata-refgaji">Referensi Gaji</a> -->
                                <a href="<?= base_url('sigaji/su/masterdata/refbulan') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "refbulan") ? ' active-menu-href' : '' ?>" key="t-masterdata-refbulan">Referensi Tahun Bulan</a>
                                <!-- <a href="<?= base_url('sigaji/su/masterdata/pengguna') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengguna") ? ' active-menu-href' : '' ?>" key="t-masterdata-pengguna">Pengguna</a> -->
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "potongan") ? ' active-menu-href' : '' ?>" href="#" id="topnav-rekap" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-potongan">POTONGAN</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-potongan">
                                <a href="<?= base_url('sigaji/su/potongan/korpri') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "potongan" && $uri->getSegment(4) == "korpri") ? ' active-menu-href' : '' ?>" key="t-potongan-korpri">Korpri</a>
                                <a href="<?= base_url('sigaji/su/potongan/dharmawanita') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "potongan" && $uri->getSegment(4) == "dharmawanita") ? ' active-menu-href' : '' ?>" key="t-potongan-dharmawanita">Dharma Wanita</a>
                                <a href="<?= base_url('sigaji/su/potongan/infak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "potongan" && $uri->getSegment(4) == "infak") ? ' active-menu-href' : '' ?>" key="t-potongan-infak">Infak</a>
                                <a href="<?= base_url('sigaji/su/potongan/thr') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "potongan" && $uri->getSegment(4) == "thr") ? ' active-menu-href' : '' ?>" key="t-potongan-thr">THR</a>
                                <a href="<?= base_url('sigaji/su/potongan/gaji13') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "potongan" && $uri->getSegment(4) == "gaji13") ? ' active-menu-href' : '' ?>" key="t-potongan-thr">Gaji 13</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload") ? ' active-menu-href' : '' ?>" href="#" id="topnav-upload" role="button">
                                <i class="bx bxs-cloud-upload me-2"></i><span key="t-upload">UPLOAD</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-upload">
                                <a href="<?= base_url('sigaji/su/upload/pegawai') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "pegawai") ? ' active-menu-href' : '' ?>" key="t-upload-pegawai">Gaji SIPD</a>
                                <a href="<?= base_url('sigaji/su/upload/tagihanbank') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tagihanbank") ? ' active-menu-href' : '' ?>" key="t-upload-tagihanbank">Tagihan Bank</a>
                                <a href="<?= base_url('sigaji/su/upload/meninggal') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "meninggal") ? ' active-menu-href' : '' ?>" key="t-upload-meninggal">Data Meninggal</a>
                                <a href="<?= base_url('sigaji/su/upload/zakat') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "zakat") ? ' active-menu-href' : '' ?>" key="t-upload-zakat">Zakat</a>
                                <a href="<?= base_url('sigaji/su/upload/shodaqoh') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "shodaqoh") ? ' active-menu-href' : '' ?>" key="t-upload-shodaqoh">Shodaqoh</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "gagal") ? ' active-menu-href' : '' ?>" href="#" id="topnav-gagal" role="button">
                                <i class="bx bxs-cloud-upload me-2"></i><span key="t-gagal">GAGAL UPLOAD</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-gagal">
                                <a href="<?= base_url('sigaji/su/gagal/uploadtagihan') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "gagal" && $uri->getSegment(4) == "uploadtagihan") ? ' active-menu-href' : '' ?>" key="t-gagalupload-tagihanbank">Tagihan Bank</a>
                                <a href="<?= base_url('sigaji/su/gagal/uploadinstansi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "gagal" && $uri->getSegment(4) == "uploadinstansi") ? ' active-menu-href' : '' ?>" key="t-gagalupload-updateinstansi">Update Instansi</a>
                                <a href="<?= base_url('sigaji/su/gagal/uploadmeninggal') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "gagal" && $uri->getSegment(4) == "uploadmeninggal") ? ' active-menu-href' : '' ?>" key="t-gagalupload-uploadmeninggal">Data Meninggal</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan") ? ' active-menu-href' : '' ?>" href="#" id="topnav-rekap" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-tagihan">TAGIHAN</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-tagihan">
                                <a href="<?= base_url('sigaji/su/tagihan/kpn') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "kpn") ? ' active-menu-href' : '' ?>" key="t-tagihan-kpn">KPN</a>
                                <a href="<?= base_url('sigaji/su/tagihan/wajibkpn') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "wajibkpn") ? ' active-menu-href' : '' ?>" key="t-tagihan-wajibkpn">Wajib KPN</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bri') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bri") ? ' active-menu-href' : '' ?>" key="t-tagihan-bri">BRI</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bni') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bni") ? ' active-menu-href' : '' ?>" key="t-tagihan-bni">BNI</a>
                                <a href="<?= base_url('sigaji/su/tagihan/btn') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "btn") ? ' active-menu-href' : '' ?>" key="t-tagihan-btn">BTN</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bpdbandar') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bpdbandar") ? ' active-menu-href' : '' ?>" key="t-tagihan-bpdbandar">BPD Bandar Jaya</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bpdkoga') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bpdkoga") ? ' active-menu-href' : '' ?>" key="t-tagihan-bpdkoga">BPD Kota Gajah</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bpdmetro') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bpdmetro") ? ' active-menu-href' : '' ?>" key="t-tagihan-bpdmetro">BPD Metro</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bpdkalirejo') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bpdkalirejo") ? ' active-menu-href' : '' ?>" key="t-tagihan-bpdkalirejo">BPD Kalirejo</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bankekabandar') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bankekabandar") ? ' active-menu-href' : '' ?>" key="t-tagihan-bankekabandar">Bank Eka Bandar Jaya</a>
                                <a href="<?= base_url('sigaji/su/tagihan/bankekametro') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "tagihan" && $uri->getSegment(4) == "bankekametro") ? ' active-menu-href' : '' ?>" key="t-tagihan-bankekametro">Bank Eka Metro</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "rekap") ? ' active-menu-href' : '' ?>" href="#" id="topnav-rekap" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-rekap">REKAP</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-rekap">
                                <a href="<?= base_url('sigaji/su/rekap/tagihan') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "rekap" && $uri->getSegment(4) == "tagihan") ? ' active-menu-href' : '' ?>" key="t-rekap-tagihan">Tagihan</a>
                                <a href="<?= base_url('sigaji/su/rekap/laporaninstansi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "rekap" && $uri->getSegment(4) == "laporaninstansi") ? ' active-menu-href' : '' ?>" key="t-rekap-laporaninstansi">Laporan Per Instansi</a>
                            </div>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us") ? ' active-menu-href' : '' ?>" href="javascript:;" id="topnav-usulan" role="button">
                                <i class="bx bx-columns me-2"></i>
                                <span key="t-usulan"> USULAN</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-usulan">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('sigaji/su/us/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('sigaji/su/us/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('sigaji/su/us/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('sigaji/su/us/tpg/siapsk') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "siapsk") ? ' active-menu-href' : '' ?>" key="t-us-siapsk">Siap SK</a>
                                            <a href="<?= base_url('sigaji/su/us/tpg/skterbit') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "skterbit") ? ' active-menu-href' : '' ?>" key="t-us-skterbit">SK Terbit</a>
                                            <a href="<?= base_url('sigaji/su/us/tpg/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6> TAMSIL</h6>
                                        <div>
                                            <a href="<?= base_url('sigaji/su/us/tamsil/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('sigaji/su/us/tamsil/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('sigaji/su/us/tamsil/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('sigaji/su/us/tamsil/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload") ? ' active-menu-href' : '' ?>" href="javascript:;" id="topnav-upload" role="button">
                                <i class="bx bx-cloud-upload me-2"></i>
                                <span key="t-upload"> UPLOAD</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-upload">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('sigaji/su/upload/tpg/matching') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "matching") ? ' active-menu-href' : '' ?>" key="t-upload-tpg-matching">Matching Simtun</a>
                                            <a href="<?= base_url('sigaji/su/upload/tpg/skterbit') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "skterbit") ? ' active-menu-href' : '' ?>" key="t-upload-tpg-skterbit">SK Terbit</a>
                                            <a href="<?= base_url('sigaji/su/upload/tpg/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-upload-tpg-prosestransfer">Proses Transfer</a>
                                            <a href="<?= base_url('sigaji/su/upload/tpg/lanjutkantw') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lanjutkantw") ? ' active-menu-href' : '' ?>" key="t-upload-tpg-lanjutkantw">Lanjutkan TW</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6> TAMSIL</h6>
                                        <div>
                                            <a href="<?= base_url('sigaji/su/upload/tamsil/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-upload-tamsil-prosestransfer">Proses Transfer</a>
                                            <a href="<?= base_url('sigaji/su/upload/tamsil/lanjutkantw') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "upload" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lanjutkantw") ? ' active-menu-href' : '' ?>" key="t-upload-tamsil-lanjutkantw">Lanjutkan TW</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "sptjm") ? ' active-menu-href' : '' ?>" href="#" id="topnav-sptjm" role="button">
                                <i class="bx bx-spreadsheet me-2"></i><span key="t-sptjm">SPTJM</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-sptjm">
                                <a href="<?= base_url('sigaji/su/sptjm/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-sptjm-tpg">Tunjangan Profesi Guru</a>
                                <a href="<?= base_url('sigaji/su/sptjm/tamsil') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "tamsil") ? ' active-menu-href' : '' ?>" key="t-sptjm-tamsil">Tamsil</a>
                                <a href="<?= base_url('sigaji/su/sptjm/verifikasi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "verifikasi") ? ' active-menu-href' : '' ?>" key="t-sptjm-tamsil">Verifikasi</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "spj") ? ' active-menu-href' : '' ?>" href="#" id="topnav-spj" role="button">
                                <i class="bx bx-spreadsheet me-2"></i><span key="t-spj">SPJ</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-spj">
                                <a href="<?= base_url('sigaji/su/spj/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-spj-tpg">Tunjangan Profesi Guru</a>
                                <a href="<?= base_url('sigaji/su/spj/tamsil') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil") ? ' active-menu-href' : '' ?>" key="t-spj-tamsil">Tamsil</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting") ? ' active-menu-href' : '' ?>" href="#" id="topnav-setting" role="button">
                                <i class="bx bx-cog me-2"></i><span key="t-setting">SETTING</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-setting">
                                <a href="<?= base_url('sigaji/su/setting/informasi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "informasi") ? ' active-menu-href' : '' ?>" key="t-setting-informasi">Informasi</a>
                                <a href="<?= base_url('sigaji/su/setting/role') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "role") ? ' active-menu-href' : '' ?>" key="t-setting-role">Role Access</a>
                                <a href="<?= base_url('sigaji/su/setting/grantedverifikasi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "grantedverifikasi") ? ' active-menu-href' : '' ?>" key="t-setting-grantedverifikasi">Acess Verifikasi</a>
                                <a href="<?= base_url('sigaji/su/setting/sptjm') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "sptjm") ? ' active-menu-href' : '' ?>" key="t-setting-sptjm">SPTJM</a>
                                <a href="<?= base_url('sigaji/su/setting/verifikasi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "verifikasi") ? ' active-menu-href' : '' ?>" key="t-setting-verifikasi">Verifikasi</a>
                                <a href="<?= base_url('sigaji/su/setting/upspj') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "upspj") ? ' active-menu-href' : '' ?>" key="t-setting-upspj">Upload SPJ</a>
                                <a href="<?= base_url('sigaji/su/setting/mt') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "mt") ? ' active-menu-href' : '' ?>" key="t-setting-mt">Maintenance</a>
                                <a href="<?= base_url('sigaji/su/setting/accessmt') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "accessmt") ? ' active-menu-href' : '' ?>" key="t-setting-accessmt">Granted Access MT</a>
                                <a href="<?= base_url('sigaji/su/setting/accesstugu') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "accesstugu") ? ' active-menu-href' : '' ?>" key="t-setting-accessmt">Granted Access Admin sigaji</a>
                                <a href="<?= base_url('sigaji/su/setting/grantedsynbakbone') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "grantedsynbakbone") ? ' active-menu-href' : '' ?>" key="t-setting-grantsyncrone">Granted Access Syncrone Backbone</a>
                                <a href="<?= base_url('sigaji/su/setting/granteduploadspj') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "granteduploadspj") ? ' active-menu-href' : '' ?>" key="t-setting-granteduploadspj">Granted Upload SPJ</a>
                                <a href="<?= base_url('sigaji/su/setting/grantedverifikasispj') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "grantedverifikasispj") ? ' active-menu-href' : '' ?>" key="t-setting-grantedverifikasidspj">Granted Verifikasi SPJ</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "cs") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "cs") ? 'javascript:;' : base_url('sigaji/su/cs') ?>">
                                <i class="bx bx-help-circle me-2"></i><span key="t-dashboards">ADUAN</span>
                            </a>
                        </li> -->
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