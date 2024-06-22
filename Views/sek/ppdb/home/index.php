<?= $this->extend('t-ppdb/sek/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <?php if (isset($is_negeri)) { ?>
                        <?php if ($is_negeri) { ?>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-2">
                                                <i class="la la-users" style="font-size: 3vw;"></i>
                                                <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_pendaftar" id="jumlah_pendaftar"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Jumlah Pendaftar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="totalInvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-1">
                                                <i class="la la-user-check" style="font-size: 3vw;"></i>
                                                <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#09BD3C" stroke="white" stroke-width="4" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_terverifikasi" id="jumlah_terverifikasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Jumlah Terverifikasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="paidinvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-1">
                                                <i class="la la-user-alt-slash" style="font-size: 3vw;"></i>
                                                <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FD5353" stroke="white" stroke-width="4" />
                                        </svg> -->

                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_belum_verifikasi" id="jumlah_belum_verifikasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Jumlah Belum Verifikasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="unpaidinvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-2">
                                                <i class="la la-users" style="font-size: 3vw;"></i>
                                                <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_pendaftar_afirmasi" id="jumlah_pendaftar_afirmasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Pendaftar Afirmasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="totalInvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-1">
                                                <i class="la la-user-check" style="font-size: 3vw;"></i>
                                                <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#09BD3C" stroke="white" stroke-width="4" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_pendaftar_zonasi" id="jumlah_pendaftar_zonasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Pendaftar Zonasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="paidinvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-1">
                                                <i class="la la-user-alt-slash" style="font-size: 3vw;"></i>
                                                <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FD5353" stroke="white" stroke-width="4" />
                                        </svg> -->

                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_pendaftar_mutasi" id="jumlah_pendaftar_mutasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Pendaftar Mutasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="unpaidinvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-1">
                                                <i class="la la-user-lock" style="font-size: 3vw;"></i>
                                                <!-- <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.784 54.128 9.106 53.788C8.428 53.45 8 52.758 8 52V16C8 14.896 8.896 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FFAA2B" stroke="white" stroke-width="4" />
                                        </svg> -->


                                            </span>
                                            <div class="invoices">
                                                <h4 class="jumlah_pendaftar_prestasi" id="jumlah_pendaftar_prestasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Pendaftar Prestasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="totalinvoicessent"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-2">
                                                <i class="la la-users" style="font-size: 3vw;"></i>
                                                <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="total_pendaftar" id="total_pendaftar"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Jumlah Pendaftar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="totalInvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-2">
                                                <i class="la la-users" style="font-size: 3vw;"></i>
                                                <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="total_terverifikasi" id="total_terverifikasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Jumlah Terverifikasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="totalInvoices"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0">
                                        <div class="d-flex">
                                            <span class="mt-2">
                                                <i class="la la-users" style="font-size: 3vw;"></i>
                                                <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                            </span>
                                            <div class="invoices">
                                                <h4 class="total_belum_verifikasi" id="total_belum_verifikasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                                <span>Jumlah Belum Terverifikasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div id="totalInvoices"></div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card overflow-hidden">
                                <div class="card-header border-0">
                                    <div class="d-flex">
                                        <span class="mt-2">
                                            <i class="la la-users" style="font-size: 3vw;"></i>
                                            <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                        </span>
                                        <div class="invoices">
                                            <h4 class="jumlah_pendaftar" id="jumlah_pendaftar"><i class="fa fa-spinner fa-spin"></i></h4>
                                            <span>Jumlah Pendaftar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">

                                    <div id="totalInvoices"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card overflow-hidden">
                                <div class="card-header border-0">
                                    <div class="d-flex">
                                        <span class="mt-2">
                                            <i class="la la-users" style="font-size: 3vw;"></i>
                                            <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                        </span>
                                        <div class="invoices">
                                            <h4 class="jumlah_terverifikasi" id="jumlah_terverifikasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                            <span>Jumlah Terverifikasi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">

                                    <div id="totalInvoices"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card overflow-hidden">
                                <div class="card-header border-0">
                                    <div class="d-flex">
                                        <span class="mt-2">
                                            <i class="la la-users" style="font-size: 3vw;"></i>
                                            <!-- <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg> -->
                                        </span>
                                        <div class="invoices">
                                            <h4 class="jumlah_belum_verifikasi" id="jumlah_belum_verifikasi"><i class="fa fa-spinner fa-spin"></i></h4>
                                            <span>Jumlah Belum Terverifikasi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">

                                    <div id="totalInvoices"></div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block d-sm-flex border-0 transactions-tab">
                        <div class="me-3">
                            <h4 class="card-title mb-2">Dashboard Informasi</h4>
                            <span class="fs-12">Informasi seputar PPDB Kab. Lampung Tengah Tahun 2024/2025</span>
                        </div>
                        <div class="card-tabs mt-3 mt-sm-0">
                            <!-- <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">Monthly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#Weekly" role="tab">Weekly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#Today" role="tab">Today</a>
                                </li>
                            </ul> -->
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="monthly" role="tabpanel">
                            <div id="accordion-one" class="accordion style-1">
                                <!-- <div class="accordion-item">
                                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#default_collapseOne2">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/2.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip31)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip31">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">Olivia Brownlee</a></h6>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-success light" href="javascript:void(0);">Completed</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne2" class="collapse accordion_body show" data-bs-parent="#accordion-one">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#default_collapseOne3">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/3.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip32)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip32">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">Angela Moss</a></h6>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-dark light" href="javascript:void(0);">Canceled</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne3" class="collapse accordion_body" data-bs-parent="#accordion-one">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Weekly" role="tabpanel">
                            <div id="accordion-one1" class="accordion style-1">
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#default_collapseOne11">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/1.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip35)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip35">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">XYZ Store ID</a></h6>
                                                <span class="fs-14">Online Shop</span>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-danger light" href="javascript:void(0);">Pending</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne11" class="collapse accordion_body" data-bs-parent="#accordion-one1">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#default_collapseOne21">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/2.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip36)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip36">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">Olivia Brownlee</a></h6>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-success light" href="javascript:void(0);">Completed</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne21" class="collapse accordion_body show" data-bs-parent="#accordion-one1">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#default_collapseOne31">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/3.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip37)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip37">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">Angela Moss</a></h6>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-dark light" href="javascript:void(0);">Canceled</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne31" class="collapse accordion_body" data-bs-parent="#accordion-one1">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#default_collapseOne41">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/4.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip38)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip38">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">XYZ Store ID</a></h6>
                                                <span class="fs-14">Online Shop</span>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-danger light" href="javascript:void(0);">Pending</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne41" class="collapse accordion_body" data-bs-parent="#accordion-one1">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Today" role="tabpanel">
                            <div id="accordion-one2" class="accordion style-1">
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#default_collapseOne12">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/1.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip39)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip39">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">XYZ Store ID</a></h6>
                                                <span class="fs-14">Online Shop</span>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-danger light" href="javascript:void(0);">Pending</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne12" class="collapse accordion_body" data-bs-parent="#accordion-one2">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#default_collapseOne22">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/2.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip310)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip310">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">Olivia Brownlee</a></h6>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-success light" href="javascript:void(0);">Completed</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne22" class="collapse accordion_body show" data-bs-parent="#accordion-one2">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#default_collapseOne32">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image">
                                                <img src="https://invome.dexignlab.com/codeigniter/demo/public/assets/images/avatar/3.jpg" alt="">
                                                <span class="bg-success">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip311)">
                                                            <path d="M10.4125 14.85C10.225 14.4625 10.3906 13.9937 10.7781 13.8062C11.8563 13.2875 12.7688 12.4812 13.4188 11.4719C14.0844 10.4375 14.4375 9.23749 14.4375 7.99999C14.4375 4.44999 11.55 1.56249 8 1.56249C4.45 1.56249 1.5625 4.44999 1.5625 7.99999C1.5625 9.23749 1.91562 10.4375 2.57812 11.475C3.225 12.4844 4.14062 13.2906 5.21875 13.8094C5.60625 13.9969 5.77187 14.4625 5.58437 14.8531C5.39687 15.2406 4.93125 15.4062 4.54062 15.2187C3.2 14.575 2.06562 13.575 1.2625 12.3187C0.4375 11.0312 -4.16897e-07 9.53749 -3.49691e-07 7.99999C-2.56258e-07 5.86249 0.83125 3.85312 2.34375 2.34374C3.85313 0.831242 5.8625 -7.37314e-06 8 -7.2797e-06C10.1375 -7.18627e-06 12.1469 0.831243 13.6563 2.34374C15.1688 3.85624 16 5.86249 16 7.99999C16 9.53749 15.5625 11.0312 14.7344 12.3187C13.9281 13.5719 12.7938 14.575 11.4563 15.2187C11.0656 15.4031 10.6 15.2406 10.4125 14.85Z" fill="white" />
                                                            <path d="M11.0407 8.41563C11.1938 8.56876 11.2688 8.76876 11.2688 8.96876C11.2688 9.16876 11.1938 9.36876 11.0407 9.52188L9.07503 11.4875C8.78753 11.775 8.40628 11.9313 8.00315 11.9313C7.60003 11.9313 7.21565 11.7719 6.93127 11.4875L4.96565 9.52188C4.6594 9.21563 4.6594 8.72188 4.96565 8.41563C5.2719 8.10938 5.76565 8.10938 6.0719 8.41563L7.22502 9.56876L7.22502 5.12814C7.22502 4.69689 7.57503 4.34689 8.00628 4.34689C8.43753 4.34689 8.78753 4.69689 8.78753 5.12814L8.78753 9.57188L9.94065 8.41876C10.2407 8.11251 10.7344 8.11251 11.0407 8.41563Z" fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip311">
                                                                <rect width="16" height="16" fill="white" transform="matrix(-4.37114e-08 1 1 4.37114e-08 0 -7.62939e-06)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="user-info">
                                                <h6 class="fs-16 font-w700 mb-0"><a href="javascript:void(0)">Angela Moss</a></h6>
                                            </div>
                                        </div>
                                        <span>June 5, 2020, 08:22 AM</span>
                                        <span>+$5,553</span>
                                        <span>MasterCard 404</span>
                                        <a class="btn btn-dark light" href="javascript:void(0);">Canceled</a>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="default_collapseOne32" class="collapse accordion_body" data-bs-parent="#accordion-one2">
                                        <div class="payment-details accordion-body-text">
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">ID Payment</p>
                                                <span class="font-w500">#00123521</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Payment Method</p>
                                                <span class="font-w500">MasterCard 404</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Invoice Date</p>
                                                <span class="font-w500">April 29, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Due Date</p>
                                                <span class="font-w500">June 5, 2020</span>
                                            </div>
                                            <div class="me-3 mb-3">
                                                <p class="fs-12 mb-2">Date Paid</p>
                                                <span class="font-w500">June 4, 2020</span>
                                            </div>
                                            <div class="info mb-3">
                                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72022 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#fff" />
                                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#fff" />
                                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#fff" />
                                                </svg>
                                                <p class="mb-0 fs-14">Lorem ipsum dolor sit amet, <br>consectetur </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="content-firsloginBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>

<script src="<?= base_url() ?>/assets/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/apexchart/apexchart.js"></script>
<script src="<?= base_url() ?>/assets/vendor/peity/jquery.peity.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/wnumb/wNumb.js"></script>
<!-- <script src="<?= base_url() ?>/assets/js/dashboard/dashboard-1.js"></script> -->
<script src="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.js"></script>
<script>
    $(document).ready(function() {

        <?php if ($firs_login) { ?>
            $.ajax({
                url: "./edit",
                type: 'POST',
                data: {
                    id: 'edit',
                },
                dataType: 'JSON',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Sedang Loading . . .',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(resul) {
                    if (resul.status !== 200) {
                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                    } else {
                        Swal.close();
                        $('#content-firsloginModalLabel').html('LENGKAPI DATA');
                        $('.content-firsloginBodyModal').html(resul.data);
                        $('.content-firsloginModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-firsloginModal').modal('show');
                    }
                }
            });
        <?php } ?>

        getStatistikTop();
    });

    function getStatistikTop() {
        $.ajax({
            url: "./statistik",
            type: 'POST',
            data: {
                id: 'get',
            },
            dataType: 'JSON',
            beforeSend: function() {
                // Swal.fire({
                //     title: 'Sedang Loading . . .',
                //     allowEscapeKey: false,
                //     allowOutsideClick: false,
                //     didOpen: () => {
                //         Swal.showLoading();
                //     }
                // });
            },
            success: function(resul) {
                <?php if (isset($is_negeri)) { ?>
                    <?php if ($is_negeri) { ?>
                        if (resul.status !== 200) {
                            $('.jumlah_pendaftar').html("0");
                            $('.jumlah_terverifikasi').html("0");
                            $('.jumlah_belum_verifikasi').html("0");
                            $('.jumlah_pendaftar_afirmasi').html("0");
                            $('.jumlah_pendaftar_zonasi').html("0");
                            $('.jumlah_pendaftar_mutasi').html("0");
                            $('.jumlah_pendaftar_prestasi').html("0");
                        } else {
                            $('.jumlah_pendaftar').html(resul.data.total_pendaftar);
                            $('.jumlah_terverifikasi').html(resul.data.total_terverifikasi);
                            $('.jumlah_belum_verifikasi').html(resul.data.total_belum_verifikasi);
                            $('.jumlah_pendaftar_afirmasi').html(resul.data.afirmasi);
                            $('.jumlah_pendaftar_zonasi').html(resul.data.zonasi);
                            $('.jumlah_pendaftar_mutasi').html(resul.data.mutasi);
                            $('.jumlah_pendaftar_prestasi').html(resul.data.prestasi);
                        }
                    <?php } else { ?>
                        if (resul.status !== 200) {
                            $('.jumlah_pendaftar').html("0");
                            $('.jumlah_terverifikasi').html("0");
                            $('.jumlah_belum_verifikasi').html("0");
                        } else {
                            $('.jumlah_pendaftar').html(resul.data.total_swasta);
                            $('.jumlah_terverifikasi').html(resul.data.total_swasta_terverifikasi);
                            $('.jumlah_belum_verifikasi').html(resul.data.total_swasta_belum_terverifikasi);
                        }
                    <?php } ?>
                <?php } else { ?>
                    if (resul.status !== 200) {
                        $('.jumlah_pendaftar').html("0");
                        $('.jumlah_terverifikasi').html("0");
                        $('.jumlah_belum_verifikasi').html("0");
                        $('.jumlah_tertolak').html("0");
                    } else {
                        $('.jumlah_pendaftar').html(resul.data.total);
                        $('.jumlah_terverifikasi').html(resul.data.verified);
                        $('.jumlah_belum_verifikasi').html(resul.data.notverified);
                        $('.jumlah_tertolak').html(resul.data.generate);
                    }
                <?php } ?>
            }
        });
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>