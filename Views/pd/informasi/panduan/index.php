<?= $this->extend('t-ppdb/pd/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Panduan Aplikasi PPDB</h4>
                            <span class="fs-12">Informasi panduan Aplikasi PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                        <div class="card-tabs mt-3 mt-sm-0">
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <style>
                            /* .image-container-panduan {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                width: 100vw;
                                height: 100vh;
                            } */

                            /* #current-image-panduan {
                                width: 100%;
                                max-height: 80%;

                            } */

                            .prev-btn-panduan,
                            .next-btn-panduan {
                                position: absolute;
                                bottom: 3%;
                                transform: translateY(-3%);
                                border: none;
                                cursor: pointer;
                            }

                            .prev-btn-panduan {
                                right: 90px;
                            }

                            .next-btn-panduan {
                                right: 10px;
                            }
                        </style>
                        <div class="image-container-panduan">
                            <img class="d-block w-100" src="<?= base_url() ?>/uploads/panduan/1.svg" alt="Image 1" id="current-image-panduan">
                            <button class="btn btn-info btn-xs prev-btn-panduan" style="min-width: 70px;">Previous</button>
                            <button class="btn btn-info btn-xs next-btn-panduan" style="min-width: 70px;">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-firsloginModal" class="modal fade content-firsloginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="content-firsloginModalLabel">Modal title</h5>
                </button>
            </div>
            <div class="content-firsloginBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>

<script>
    const currentImagePanduan = document.getElementById('current-image-panduan');
    const prevBtnPanduan = document.querySelector('.prev-btn-panduan');
    const nextBtnPanduan = document.querySelector('.next-btn-panduan');

    let imageIndexPanduan = 0;
    const imagesPanduan = ['<?= base_url() ?>/uploads/panduan/1.svg', '<?= base_url() ?>/uploads/panduan/2.svg', '<?= base_url() ?>/uploads/panduan/3.svg', '<?= base_url() ?>/uploads/panduan/4.svg', '<?= base_url() ?>/uploads/panduan/5.svg', '<?= base_url() ?>/uploads/panduan/6.svg', '<?= base_url() ?>/uploads/panduan/7.svg', '<?= base_url() ?>/uploads/panduan/8.svg', '<?= base_url() ?>/uploads/panduan/9.svg', '<?= base_url() ?>/uploads/panduan/10.svg', '<?= base_url() ?>/uploads/panduan/11.svg', '<?= base_url() ?>/uploads/panduan/12.svg', '<?= base_url() ?>/uploads/panduan/13.svg', '<?= base_url() ?>/uploads/panduan/14.svg', '<?= base_url() ?>/uploads/panduan/15.svg', '<?= base_url() ?>/uploads/panduan/16.svg', '<?= base_url() ?>/uploads/panduan/17.svg', '<?= base_url() ?>/uploads/panduan/18.svg', '<?= base_url() ?>/uploads/panduan/19.svg', '<?= base_url() ?>/uploads/panduan/20.svg', '<?= base_url() ?>/uploads/panduan/21.svg', '<?= base_url() ?>/uploads/panduan/22.svg', '<?= base_url() ?>/uploads/panduan/23.svg', '<?= base_url() ?>/uploads/panduan/24.svg', '<?= base_url() ?>/uploads/panduan/25.svg', '<?= base_url() ?>/uploads/panduan/26.svg', '<?= base_url() ?>/uploads/panduan/27.svg', '<?= base_url() ?>/uploads/panduan/28.svg', '<?= base_url() ?>/uploads/panduan/29.svg', '<?= base_url() ?>/uploads/panduan/30.svg', '<?= base_url() ?>/uploads/panduan/31.svg', '<?= base_url() ?>/uploads/panduan/32.svg', '<?= base_url() ?>/uploads/panduan/33.svg']; // Add more image paths here

    function showImagePanduan(index) {
        currentImagePanduan.src = imagesPanduan[index];
    }

    showImagePanduan(imageIndexPanduan);

    prevBtnPanduan.addEventListener('click', () => {
        imageIndexPanduan = imageIndexPanduan === 0 ? imagesPanduan.length - 1 : imageIndexPanduan - 1;
        showImagePanduan(imageIndexPanduan);
    });

    nextBtnPanduan.addEventListener('click', () => {
        imageIndexPanduan = imageIndexPanduan === imagesPanduan.length - 1 ? 0 : imageIndexPanduan + 1;
        showImagePanduan(imageIndexPanduan);
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<style>
    .lihatPetanya {
        background-color: #407d4a !important;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .lihatPetanya:hover {
        background-color: #d653c1 !important;
    }
</style>
<?= $this->endSection(); ?>