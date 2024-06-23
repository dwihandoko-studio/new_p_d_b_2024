<?= $this->extend('t-dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">
    <div class="container-fluid" style="padding-top: 0.5rem;">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profil Sekolah</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $sekolah->nama ?></a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo rounded"></div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img style="max-width: 100px; max-height: 100px; width: 100px; height: 100px;" src="<?= $sekolah->image ? base_url('uploads/user') . '/' . $sekolah->image : base_url() . '/assets/images/profile/profile.png' ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"><?= $sekolah->nama ?></h4>
                                    <p><?= $sekolah->npsn ?></p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $sekolah->email ?? '-' ?></h4>
                                    <p>Email</p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= $sekolah->website ?? '-' ?></h4>
                                    <p>Website</p>
                                </div>
                            </div>
                            <p>Alamat Sekolah: <?= $sekolah->alamat_jalan ?>, <?= $sekolah->desa_kelurahan ?> - <?= $sekolah->kecamatan ?>, <?= $sekolah->kabupaten ?> - <?= $sekolah->provinsi ?> (Kode Pos: <?= $sekolah->kode_pos ?>)</p>
                        </div>
                    </div>

                </div>
            </div>

            <?= $this->include('t-dashboard/bottom'); ?>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>