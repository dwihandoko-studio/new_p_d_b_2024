<?= $this->extend('t-verval/su/index'); ?>

<?= $this->section('content'); ?>

<div class="content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0">
                                <div class="d-flex">
                                    <span class="mt-2">
                                        <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.812 34.64L3.2 39.6C2.594 40.054 1.784 40.128 1.106 39.788C0.428 39.45 0 38.758 0 38V2C0 0.896 0.896 0 2 0H30C31.104 0 32 0.896 32 2V38C32 38.758 31.572 39.45 30.894 39.788C30.216 40.128 29.406 40.054 28.8 39.6L22.188 34.64L17.414 39.414C16.634 40.196 15.366 40.196 14.586 39.414L9.812 34.64ZM28 34V4H4V34L8.8 30.4C9.596 29.802 10.71 29.882 11.414 30.586L16 35.172L20.586 30.586C21.29 29.882 22.404 29.802 23.2 30.4L28 34ZM14 20H18C19.104 20 20 19.104 20 18C20 16.896 19.104 16 18 16H14C12.896 16 12 16.896 12 18C12 19.104 12.896 20 14 20ZM10 12H22C23.104 12 24 11.104 24 10C24 8.896 23.104 8 22 8H10C8.896 8 8 8.896 8 10C8 11.104 8.896 12 10 12Z" fill="#717579" />
                                        </svg>
                                    </span>
                                    <div class="invoices">
                                        <h4>2,478</h4>
                                        <span>Jumlah PD Tingkat Akhir</span>
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
                                        <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#09BD3C" stroke="white" stroke-width="4" />
                                        </svg>
                                    </span>
                                    <div class="invoices">
                                        <h4>983</h4>
                                        <span>PD Terverifikasi</span>
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
                                        <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.78401 54.128 9.10602 53.788C8.42802 53.45 8.00002 52.758 8.00002 52V16C8.00002 14.896 8.89602 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FD5353" stroke="white" stroke-width="4" />
                                        </svg>

                                    </span>
                                    <div class="invoices">
                                        <h4>1,256</h4>
                                        <span>PD Belum Verifikasi</span>
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
                                        <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.812 48.64L11.2 53.6C10.594 54.054 9.784 54.128 9.106 53.788C8.428 53.45 8 52.758 8 52V16C8 14.896 8.896 14 10 14H38C39.104 14 40 14.896 40 16V52C40 52.758 39.572 53.45 38.894 53.788C38.216 54.128 37.406 54.054 36.8 53.6L30.188 48.64L25.414 53.414C24.634 54.196 23.366 54.196 22.586 53.414L17.812 48.64ZM36 48V18H12V48L16.8 44.4C17.596 43.802 18.71 43.882 19.414 44.586L24 49.172L28.586 44.586C29.29 43.882 30.404 43.802 31.2 44.4L36 48ZM22 34H26C27.104 34 28 33.104 28 32C28 30.896 27.104 30 26 30H22C20.896 30 20 30.896 20 32C20 33.104 20.896 34 22 34ZM18 26H30C31.104 26 32 25.104 32 24C32 22.896 31.104 22 30 22H18C16.896 22 16 22.896 16 24C16 25.104 16.896 26 18 26Z" fill="#44814E" />
                                            <circle cx="43.5" cy="14.5" r="12.5" fill="#FFAA2B" stroke="white" stroke-width="4" />
                                        </svg>


                                    </span>
                                    <div class="invoices">
                                        <h4>652</h4>
                                        <span>PD Antrian Approval</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="totalinvoicessent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-5 col-xxl-12 col-md-5">
                                        <h4 class="fs-20 text-black mb-4 font-w700">Spendings</h4>
                                        <div class="row">
                                            <div class="d-flex col-xl-12 col-xxl-6  col-md-12 col-6 mb-4">
                                                <svg class="me-3" width="14" height="54" viewBox="0 0 14 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-6.10352e-05" width="14" height="54" rx="7" fill="#AC39D4" />
                                                </svg>
                                                <div>
                                                    <p class="fs-14 mb-2">Investment</p>
                                                    <span class="fs-16 font-w600 text-light"><span class="text-black me-2 font-w700">$1,567</span>/$5,000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-6 mb-4">
                                                <svg class="me-3" width="14" height="54" viewBox="0 0 14 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-6.10352e-05" width="14" height="54" rx="7" fill="#40D4A8" />
                                                </svg>
                                                <div>
                                                    <p class="fs-14 mb-2">Installment</p>
                                                    <span class="fs-16 font-w600 text-light"><span class="text-black me-2 font-w700">$1,567</span>/$5,000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-6 mb-4">
                                                <svg class="me-3" width="14" height="54" viewBox="0 0 14 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-6.10352e-05" width="14" height="54" rx="7" fill="#1EB6E7" />
                                                </svg>
                                                <div>
                                                    <p class="fs-14 mb-2">Restaurant</p>
                                                    <span class="fs-16 font-w600 text-light"><span class="text-black me-2 font-w700">$1,567</span>/$5,000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-6 mb-4">
                                                <svg class="me-3" width="14" height="54" viewBox="0 0 14 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-6.10352e-05" width="14" height="54" rx="7" fill="#461EE7" />
                                                </svg>
                                                <div>
                                                    <p class="fs-14 mb-2">Property</p>
                                                    <span class="fs-16 font-w600 text-light"><span class="text-black me-2 font-w700">$1,567</span>/$5,000</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7  col-xxl-12 col-md-7">
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <div class="bg-gradient1 rounded text-center p-3">
                                                    <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                        <span class="donut1" data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(255, 255, 255, 0.2)"],   "innerRadius": 33, "radius": 10}'>5/8</span>
                                                        <small class="text-white">71%</small>
                                                    </div>
                                                    <span class="fs-14 text-white d-block">Investment</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-4">
                                                <div class="bg-gradient2 rounded text-center p-3">
                                                    <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                        <span class="donut1" data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(255, 255, 255, 0.2)"],   "innerRadius": 33, "radius": 10}'>3/8</span>
                                                        <small class="text-white">30%</small>
                                                    </div>
                                                    <span class="fs-14 text-white d-block">Installment</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-sm-0 mb-4">
                                                <div class="rounded text-center p-3 bg-gradient3">
                                                    <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                        <span class="donut1" data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(234, 234, 234, 0.2)"],   "innerRadius": 33, "radius": 10}'>1/8</span>
                                                        <small class="text-white">5%</small>
                                                    </div>
                                                    <span class="fs-14 text-white d-block">Restaurant</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-sm-0 mb-4">
                                                <div class="rounded text-center p-3 bg-gradient4">
                                                    <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                        <span class="donut1" data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(255, 255, 255, 0.2)"],   "innerRadius": 33, "radius": 10}'>9/10</span>
                                                        <small class="text-white">96%</small>
                                                    </div>
                                                    <span class="fs-14 text-white d-block">Property</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-sm-flex d-block border-0 pb-0">
                                <div class="pe-3 me-auto mb-sm-0 mb-3">
                                    <h4 class="fs-20 text-black mb-1 font-w700">Transaction Overview</h4>
                                    <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0)" class="btn btn-outline-primary me-3"><i class="las la-download text-primary scale5 me-3"></i>Download Report</a>

                                    <div class="dropdown">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chartBar" class="chartBar"></div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex">
                                        <label class="form-check-label font-w600 fs-16" for="flexSwitchCheckChecked1">Number</label>
                                        <div class="form-check form-switch toggle-switch">
                                            <input class="form-check-input custome" type="checkbox" id="flexSwitchCheckChecked1" checked>

                                        </div>
                                        <label class="form-check-label font-w600 fs-16" for="flexSwitchCheckChecked2">Analytics</label>
                                        <div class="form-check form-switch toggle-switch">
                                            <input class="form-check-input custome" type="checkbox" id="flexSwitchCheckChecked2" checked>

                                        </div>
                                    </div>
                                    <div>
                                        <span class="fs-16 font-w600">
                                            <svg class="me-2" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.639771" width="18.9471" height="19" rx="9.47357" fill="#09BD3C" />
                                            </svg>
                                            Income
                                        </span>
                                        <span class="fs-16 font-w600">
                                            <svg class="mx-2" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.344925" width="18.9471" height="19" rx="9.47357" fill="#FD5353" />
                                            </svg>
                                            Expense
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">
                            <div class="card-header d-sm-flex d-block border-0 pb-0">
                                <div class="mb-sm-0 mb-2">
                                    <p class="fs-14 mb-1 font-w700">Weekly Wallet Usage</p>
                                    <span class="mb-0">
                                        <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.9999 6L5.99994 -2.62268e-07L-6.10352e-05 6" fill="#2BC155" />
                                        </svg>
                                        <strong class="fs-32 text-black ms-2 me-3 font-w800">43%</strong>Than last week</span>
                                </div>
                                <span class="fs-12">
                                    <svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.999939 13.5C1.91791 12.4157 4.89722 9.22772 6.49994 7.5L12.4999 10.5L19.4999 1.5" stroke="#2BC155" stroke-width="2" />
                                        <path d="M6.49994 7.5C4.89722 9.22772 1.91791 12.4157 0.999939 13.5H19.4999V1.5L12.4999 10.5L6.49994 7.5Z" fill="url(#paint0_linear2)" />
                                        <defs>
                                            <linearGradient id="paint0_linear2" x1="10.2499" y1="3" x2="10.9999" y2="13.5" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="#2BC155" stop-opacity="0.73" />
                                                <stop offset="1" stop-color="#2BC155" stop-opacity="0" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    4% (30 days)</span>
                            </div>
                            <div class="card-body p-0">
                                <canvas id="widgetChart3" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-6 col-xxl-12 col-sm-6">
                                <div class="card">
                                    <div class="card-header border-0 pb-0">
                                        <div>
                                            <h4 class="mb-2 font-w700">Quick Transfer</h4>
                                            <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="user-bx">
                                            <img src="<?= base_url() ?>/assets/images/profile/small/pic1.jpg" alt="">
                                            <div>
                                                <h6 class="user-name">Samuel</h6>
                                                <span class="meta">@sam224</span>
                                            </div>
                                            <i class="las la-check-circle check-icon"></i>
                                        </div>
                                        <h4 class="mt-3 mb-3">Recent Friend<a href="javascript:void(0);" class="fs-16 float-end text-secondary font-w600">See More</a></h4>
                                        <ul class="user-list">
                                            <li><img src="<?= base_url() ?>/assets/images/avatar/1.jpg" alt=""></li>
                                            <li><img src="<?= base_url() ?>/assets/images/avatar/2.jpg" alt=""></li>
                                            <li><img src="<?= base_url() ?>/assets/images/avatar/3.jpg" alt=""></li>
                                            <li><img src="<?= base_url() ?>/assets/images/avatar/4.jpg" alt=""></li>
                                            <li><img src="<?= base_url() ?>/assets/images/avatar/5.jpg" alt=""></li>
                                            <li><img src="<?= base_url() ?>/assets/images/avatar/6.jpg" alt=""></li>
                                        </ul>
                                        <h4 class="mt-3 mb-0">Insert Amount</h4>
                                        <div class="format-slider">
                                            <input class="form-control amount-input" title="Formatted number" id="input-format">
                                            <div id="slider-format"></div>
                                        </div>
                                        <div class="text-secondary fs-16 d-flex justify-content-between font-w600 mt-4">
                                            <span>Your Balance</span>
                                            <span>$ 456,345.62</span>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 pt-0">
                                        <a href="javascript:void(0);" class="btn btn-primary d-block btn-lg text-uppercase">Transfer Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-xxl-12 col-sm-6">
                                <div class="card">
                                    <div class="card-header border-0 pb-0">
                                        <div>
                                            <h4 class="mb-2 fs-20 font-w700">Bar Spendings</h4>
                                            <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="progress default-progress">
                                            <div class="progress-bar bg-gradient1 progress-animated" style="width: 45%; height:20px;" role="progressbar">
                                                <span class="sr-only">45% Complete</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end mt-2 pb-3 justify-content-between">
                                            <span>Investment</span>
                                            <span class="fs-16 font-w600 text-light"><span class="text-black pe-2">$1415</span>/$2000</span>
                                        </div>
                                        <div class="progress default-progress mt-4">
                                            <div class="progress-bar bg-gradient2 progress-animated" style="width: 70%; height:20px;" role="progressbar">
                                                <span class="sr-only">70% Complete</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end mt-2 pb-3 justify-content-between">
                                            <span>Restaurant</span>
                                            <span class="fs-16 font-w600 text-light"><span class="text-black pe-2">$1567</span>/$5000</span>
                                        </div>
                                        <div class="progress default-progress mt-4">
                                            <div class="progress-bar bg-gradient4 progress-animated" style="width: 35%; height:20px;" role="progressbar">
                                                <span class="sr-only">35% Complete</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end mt-2 pb-3 justify-content-between">
                                            <span>Installment</span>
                                            <span class="fs-16 font-w600 text-light"><span class="text-black pe-2">$487</span>/$10000</span>
                                        </div>
                                        <div class="progress default-progress mt-4">
                                            <div class="progress-bar bg-gradient3 progress-animated" style="width: 95%; height:20px;" role="progressbar">
                                                <span class="sr-only">95% Complete</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end mt-2 justify-content-between">
                                            <span>Property</span>
                                            <span class="fs-16 font-w600 text-light"><span class="text-black pe-2">$3890</span>/$4000</span>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 pt-0">
                                        <a href="javascript:void(0);" class="btn btn-outline-primary d-block btn-lg">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-block d-sm-flex border-0 flex-wrap transactions-tab">
                                <div class="me-3 mb-3">
                                    <h4 class="card-title mb-2">Previous Transactions</h4>
                                    <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
                                </div>
                                <div class="card-tabs mt-3 mt-sm-0 mb-3 ">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="index.html#monthly" role="tab">Monthly</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="index.html#Weekly" role="tab">Weekly</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="index.html#Today" role="tab">Today</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body tab-content p-0">
                                <div class="tab-pane active show fade" id="monthly" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-responsive-md card-table transactions-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1" y="1" width="61" height="61" rx="29" stroke="#FF2E2E" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 19.0125C34.8937 19.6906 35.1836 20.5109 35.8617 20.8391C37.7484 21.7469 39.3453 23.1578 40.4828 24.9242C41.6476 26.7344 42.2656 28.8344 42.2656 31C42.2656 37.2125 37.2125 42.2656 31 42.2656C24.7875 42.2656 19.7344 37.2125 19.7344 31C19.7344 28.8344 20.3523 26.7344 21.5117 24.9187C22.6437 23.1523 24.2461 21.7414 26.1328 20.8336C26.8109 20.5055 27.1008 19.6906 26.7726 19.007C26.4445 18.3289 25.6297 18.0391 24.9461 18.3672C22.6 19.4937 20.6148 21.2437 19.2094 23.4422C17.7656 25.6953 17 28.3094 17 31C17 34.7406 18.4547 38.257 21.1015 40.8984C23.743 43.5453 27.2594 45 31 45C34.7406 45 38.257 43.5453 40.8984 40.8984C43.5453 38.2516 45 34.7406 45 31C45 28.3094 44.2344 25.6953 42.7851 23.4422C41.3742 21.2492 39.389 19.4937 37.0484 18.3672C36.3648 18.0445 35.55 18.3289 35.2219 19.0125Z" fill="#FF2E2E" />
                                                                <path d="M36.3211 30.2726C36.589 30.0047 36.7203 29.6547 36.7203 29.3047C36.7203 28.9547 36.589 28.6047 36.3211 28.3367L32.8812 24.8969C32.3781 24.3937 31.7109 24.1203 31.0055 24.1203C30.3 24.1203 29.6273 24.3992 29.1297 24.8969L25.6898 28.3367C25.1539 28.8726 25.1539 29.7367 25.6898 30.2726C26.2258 30.8086 27.0898 30.8086 27.6258 30.2726L29.6437 28.2547L29.6437 36.0258C29.6437 36.7804 30.2562 37.3929 31.0109 37.3929C31.7656 37.3929 32.3781 36.7804 32.3781 36.0258L32.3781 28.2492L34.3961 30.2672C34.9211 30.8031 35.7851 30.8031 36.3211 30.2726Z" fill="#FF2E2E" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">XYZ Store ID</a></h6>
                                                        <span class="fs-14">Cashback</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 4, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-success fs-16 font-w500 text-end d-block">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1.00002" y="1" width="61" height="61" rx="29" stroke="#2BC155" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 42.9875C34.8938 42.3094 35.1836 41.4891 35.8617 41.1609C37.7484 40.2531 39.3453 38.8422 40.4828 37.0758C41.6477 35.2656 42.2656 33.1656 42.2656 31C42.2656 24.7875 37.2125 19.7344 31 19.7344C24.7875 19.7344 19.7344 24.7875 19.7344 31C19.7344 33.1656 20.3523 35.2656 21.5117 37.0813C22.6437 38.8477 24.2461 40.2586 26.1328 41.1664C26.8109 41.4945 27.1008 42.3094 26.7727 42.993C26.4445 43.6711 25.6297 43.9609 24.9461 43.6328C22.6 42.5063 20.6148 40.7563 19.2094 38.5578C17.7656 36.3047 17 33.6906 17 31C17 27.2594 18.4547 23.743 21.1016 21.1016C23.743 18.4547 27.2594 17 31 17C34.7406 17 38.257 18.4547 40.8984 21.1016C43.5453 23.7484 45 27.2594 45 31C45 33.6906 44.2344 36.3047 42.7852 38.5578C41.3742 40.7508 39.3891 42.5063 37.0484 43.6328C36.3648 43.9555 35.55 43.6711 35.2219 42.9875Z" fill="#2BC155" />
                                                                <path d="M36.3211 31.7274C36.5891 31.9953 36.7203 32.3453 36.7203 32.6953C36.7203 33.0453 36.5891 33.3953 36.3211 33.6633L32.8812 37.1031C32.3781 37.6063 31.7109 37.8797 31.0055 37.8797C30.3 37.8797 29.6273 37.6008 29.1297 37.1031L25.6898 33.6633C25.1539 33.1274 25.1539 32.2633 25.6898 31.7274C26.2258 31.1914 27.0898 31.1914 27.6258 31.7274L29.6437 33.7453L29.6437 25.9742C29.6437 25.2196 30.2562 24.6071 31.0109 24.6071C31.7656 24.6071 32.3781 25.2196 32.3781 25.9742L32.3781 33.7508L34.3961 31.7328C34.9211 31.1969 35.7852 31.1969 36.3211 31.7274Z" fill="#2BC155" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Chef Renata</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 5, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">-$167</span></td>
                                                    <td><span class="text-light fs-16 font-w500 text-end d-block">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1" y="1" width="61" height="61" rx="29" stroke="#FF2E2E" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 19.0125C34.8937 19.6906 35.1836 20.5109 35.8617 20.8391C37.7484 21.7469 39.3453 23.1578 40.4828 24.9242C41.6476 26.7344 42.2656 28.8344 42.2656 31C42.2656 37.2125 37.2125 42.2656 31 42.2656C24.7875 42.2656 19.7344 37.2125 19.7344 31C19.7344 28.8344 20.3523 26.7344 21.5117 24.9187C22.6437 23.1523 24.2461 21.7414 26.1328 20.8336C26.8109 20.5055 27.1008 19.6906 26.7726 19.007C26.4445 18.3289 25.6297 18.0391 24.9461 18.3672C22.6 19.4937 20.6148 21.2437 19.2094 23.4422C17.7656 25.6953 17 28.3094 17 31C17 34.7406 18.4547 38.257 21.1015 40.8984C23.743 43.5453 27.2594 45 31 45C34.7406 45 38.257 43.5453 40.8984 40.8984C43.5453 38.2516 45 34.7406 45 31C45 28.3094 44.2344 25.6953 42.7851 23.4422C41.3742 21.2492 39.389 19.4937 37.0484 18.3672C36.3648 18.0445 35.55 18.3289 35.2219 19.0125Z" fill="#FF2E2E" />
                                                                <path d="M36.3211 30.2726C36.589 30.0047 36.7203 29.6547 36.7203 29.3047C36.7203 28.9547 36.589 28.6047 36.3211 28.3367L32.8812 24.8969C32.3781 24.3937 31.7109 24.1203 31.0055 24.1203C30.3 24.1203 29.6273 24.3992 29.1297 24.8969L25.6898 28.3367C25.1539 28.8726 25.1539 29.7367 25.6898 30.2726C26.2258 30.8086 27.0898 30.8086 27.6258 30.2726L29.6437 28.2547L29.6437 36.0258C29.6437 36.7804 30.2562 37.3929 31.0109 37.3929C31.7656 37.3929 32.3781 36.7804 32.3781 36.0258L32.3781 28.2492L34.3961 30.2672C34.9211 30.8031 35.7851 30.8031 36.3211 30.2726Z" fill="#FF2E2E" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>

                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Cindy Alexandro</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 5, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-danger fs-16 font-w500 text-end d-block">Canceled</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1.00002" y="1" width="61" height="61" rx="29" stroke="#2BC155" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 42.9875C34.8938 42.3094 35.1836 41.4891 35.8617 41.1609C37.7484 40.2531 39.3453 38.8422 40.4828 37.0758C41.6477 35.2656 42.2656 33.1656 42.2656 31C42.2656 24.7875 37.2125 19.7344 31 19.7344C24.7875 19.7344 19.7344 24.7875 19.7344 31C19.7344 33.1656 20.3523 35.2656 21.5117 37.0813C22.6437 38.8477 24.2461 40.2586 26.1328 41.1664C26.8109 41.4945 27.1008 42.3094 26.7727 42.993C26.4445 43.6711 25.6297 43.9609 24.9461 43.6328C22.6 42.5063 20.6148 40.7563 19.2094 38.5578C17.7656 36.3047 17 33.6906 17 31C17 27.2594 18.4547 23.743 21.1016 21.1016C23.743 18.4547 27.2594 17 31 17C34.7406 17 38.257 18.4547 40.8984 21.1016C43.5453 23.7484 45 27.2594 45 31C45 33.6906 44.2344 36.3047 42.7852 38.5578C41.3742 40.7508 39.3891 42.5063 37.0484 43.6328C36.3648 43.9555 35.55 43.6711 35.2219 42.9875Z" fill="#2BC155" />
                                                                <path d="M36.3211 31.7274C36.5891 31.9953 36.7203 32.3453 36.7203 32.6953C36.7203 33.0453 36.5891 33.3953 36.3211 33.6633L32.8812 37.1031C32.3781 37.6063 31.7109 37.8797 31.0055 37.8797C30.3 37.8797 29.6273 37.6008 29.1297 37.1031L25.6898 33.6633C25.1539 33.1274 25.1539 32.2633 25.6898 31.7274C26.2258 31.1914 27.0898 31.1914 27.6258 31.7274L29.6437 33.7453L29.6437 25.9742C29.6437 25.2196 30.2562 24.6071 31.0109 24.6071C31.7656 24.6071 32.3781 25.2196 32.3781 25.9742L32.3781 33.7508L34.3961 31.7328C34.9211 31.1969 35.7852 31.1969 36.3211 31.7274Z" fill="#2BC155" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Paipal</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 4, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-success fs-16 font-w500 text-end d-block">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1" y="1" width="61" height="61" rx="29" stroke="#FF2E2E" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 19.0125C34.8937 19.6906 35.1836 20.5109 35.8617 20.8391C37.7484 21.7469 39.3453 23.1578 40.4828 24.9242C41.6476 26.7344 42.2656 28.8344 42.2656 31C42.2656 37.2125 37.2125 42.2656 31 42.2656C24.7875 42.2656 19.7344 37.2125 19.7344 31C19.7344 28.8344 20.3523 26.7344 21.5117 24.9187C22.6437 23.1523 24.2461 21.7414 26.1328 20.8336C26.8109 20.5055 27.1008 19.6906 26.7726 19.007C26.4445 18.3289 25.6297 18.0391 24.9461 18.3672C22.6 19.4937 20.6148 21.2437 19.2094 23.4422C17.7656 25.6953 17 28.3094 17 31C17 34.7406 18.4547 38.257 21.1015 40.8984C23.743 43.5453 27.2594 45 31 45C34.7406 45 38.257 43.5453 40.8984 40.8984C43.5453 38.2516 45 34.7406 45 31C45 28.3094 44.2344 25.6953 42.7851 23.4422C41.3742 21.2492 39.389 19.4937 37.0484 18.3672C36.3648 18.0445 35.55 18.3289 35.2219 19.0125Z" fill="#FF2E2E" />
                                                                <path d="M36.3211 30.2726C36.589 30.0047 36.7203 29.6547 36.7203 29.3047C36.7203 28.9547 36.589 28.6047 36.3211 28.3367L32.8812 24.8969C32.3781 24.3937 31.7109 24.1203 31.0055 24.1203C30.3 24.1203 29.6273 24.3992 29.1297 24.8969L25.6898 28.3367C25.1539 28.8726 25.1539 29.7367 25.6898 30.2726C26.2258 30.8086 27.0898 30.8086 27.6258 30.2726L29.6437 28.2547L29.6437 36.0258C29.6437 36.7804 30.2562 37.3929 31.0109 37.3929C31.7656 37.3929 32.3781 36.7804 32.3781 36.0258L32.3781 28.2492L34.3961 30.2672C34.9211 30.8031 35.7851 30.8031 36.3211 30.2726Z" fill="#FF2E2E" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Hawkins Jr.</a></h6>
                                                        <span class="fs-14">Cashback</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 4, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-danger fs-16 font-w500 text-end d-block">Canceled</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="Weekly" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-responsive-md card-table transactions-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1.00002" y="1" width="61" height="61" rx="29" stroke="#2BC155" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 42.9875C34.8938 42.3094 35.1836 41.4891 35.8617 41.1609C37.7484 40.2531 39.3453 38.8422 40.4828 37.0758C41.6477 35.2656 42.2656 33.1656 42.2656 31C42.2656 24.7875 37.2125 19.7344 31 19.7344C24.7875 19.7344 19.7344 24.7875 19.7344 31C19.7344 33.1656 20.3523 35.2656 21.5117 37.0813C22.6437 38.8477 24.2461 40.2586 26.1328 41.1664C26.8109 41.4945 27.1008 42.3094 26.7727 42.993C26.4445 43.6711 25.6297 43.9609 24.9461 43.6328C22.6 42.5063 20.6148 40.7563 19.2094 38.5578C17.7656 36.3047 17 33.6906 17 31C17 27.2594 18.4547 23.743 21.1016 21.1016C23.743 18.4547 27.2594 17 31 17C34.7406 17 38.257 18.4547 40.8984 21.1016C43.5453 23.7484 45 27.2594 45 31C45 33.6906 44.2344 36.3047 42.7852 38.5578C41.3742 40.7508 39.3891 42.5063 37.0484 43.6328C36.3648 43.9555 35.55 43.6711 35.2219 42.9875Z" fill="#2BC155" />
                                                                <path d="M36.3211 31.7274C36.5891 31.9953 36.7203 32.3453 36.7203 32.6953C36.7203 33.0453 36.5891 33.3953 36.3211 33.6633L32.8812 37.1031C32.3781 37.6063 31.7109 37.8797 31.0055 37.8797C30.3 37.8797 29.6273 37.6008 29.1297 37.1031L25.6898 33.6633C25.1539 33.1274 25.1539 32.2633 25.6898 31.7274C26.2258 31.1914 27.0898 31.1914 27.6258 31.7274L29.6437 33.7453L29.6437 25.9742C29.6437 25.2196 30.2562 24.6071 31.0109 24.6071C31.7656 24.6071 32.3781 25.2196 32.3781 25.9742L32.3781 33.7508L34.3961 31.7328C34.9211 31.1969 35.7852 31.1969 36.3211 31.7274Z" fill="#2BC155" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">XYZ Store ID</a></h6>
                                                        <span class="fs-14">Cashback</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 4, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-success fs-16 font-w500 text-end d-block">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1" y="1" width="61" height="61" rx="29" stroke="#FF2E2E" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 19.0125C34.8937 19.6906 35.1836 20.5109 35.8617 20.8391C37.7484 21.7469 39.3453 23.1578 40.4828 24.9242C41.6476 26.7344 42.2656 28.8344 42.2656 31C42.2656 37.2125 37.2125 42.2656 31 42.2656C24.7875 42.2656 19.7344 37.2125 19.7344 31C19.7344 28.8344 20.3523 26.7344 21.5117 24.9187C22.6437 23.1523 24.2461 21.7414 26.1328 20.8336C26.8109 20.5055 27.1008 19.6906 26.7726 19.007C26.4445 18.3289 25.6297 18.0391 24.9461 18.3672C22.6 19.4937 20.6148 21.2437 19.2094 23.4422C17.7656 25.6953 17 28.3094 17 31C17 34.7406 18.4547 38.257 21.1015 40.8984C23.743 43.5453 27.2594 45 31 45C34.7406 45 38.257 43.5453 40.8984 40.8984C43.5453 38.2516 45 34.7406 45 31C45 28.3094 44.2344 25.6953 42.7851 23.4422C41.3742 21.2492 39.389 19.4937 37.0484 18.3672C36.3648 18.0445 35.55 18.3289 35.2219 19.0125Z" fill="#FF2E2E" />
                                                                <path d="M36.3211 30.2726C36.589 30.0047 36.7203 29.6547 36.7203 29.3047C36.7203 28.9547 36.589 28.6047 36.3211 28.3367L32.8812 24.8969C32.3781 24.3937 31.7109 24.1203 31.0055 24.1203C30.3 24.1203 29.6273 24.3992 29.1297 24.8969L25.6898 28.3367C25.1539 28.8726 25.1539 29.7367 25.6898 30.2726C26.2258 30.8086 27.0898 30.8086 27.6258 30.2726L29.6437 28.2547L29.6437 36.0258C29.6437 36.7804 30.2562 37.3929 31.0109 37.3929C31.7656 37.3929 32.3781 36.7804 32.3781 36.0258L32.3781 28.2492L34.3961 30.2672C34.9211 30.8031 35.7851 30.8031 36.3211 30.2726Z" fill="#FF2E2E" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Chef Renata</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 5, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">-$167</span></td>
                                                    <td><span class="text-light fs-16 font-w500 text-end d-block">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1.00002" y="1" width="61" height="61" rx="29" stroke="#2BC155" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 42.9875C34.8938 42.3094 35.1836 41.4891 35.8617 41.1609C37.7484 40.2531 39.3453 38.8422 40.4828 37.0758C41.6477 35.2656 42.2656 33.1656 42.2656 31C42.2656 24.7875 37.2125 19.7344 31 19.7344C24.7875 19.7344 19.7344 24.7875 19.7344 31C19.7344 33.1656 20.3523 35.2656 21.5117 37.0813C22.6437 38.8477 24.2461 40.2586 26.1328 41.1664C26.8109 41.4945 27.1008 42.3094 26.7727 42.993C26.4445 43.6711 25.6297 43.9609 24.9461 43.6328C22.6 42.5063 20.6148 40.7563 19.2094 38.5578C17.7656 36.3047 17 33.6906 17 31C17 27.2594 18.4547 23.743 21.1016 21.1016C23.743 18.4547 27.2594 17 31 17C34.7406 17 38.257 18.4547 40.8984 21.1016C43.5453 23.7484 45 27.2594 45 31C45 33.6906 44.2344 36.3047 42.7852 38.5578C41.3742 40.7508 39.3891 42.5063 37.0484 43.6328C36.3648 43.9555 35.55 43.6711 35.2219 42.9875Z" fill="#2BC155" />
                                                                <path d="M36.3211 31.7274C36.5891 31.9953 36.7203 32.3453 36.7203 32.6953C36.7203 33.0453 36.5891 33.3953 36.3211 33.6633L32.8812 37.1031C32.3781 37.6063 31.7109 37.8797 31.0055 37.8797C30.3 37.8797 29.6273 37.6008 29.1297 37.1031L25.6898 33.6633C25.1539 33.1274 25.1539 32.2633 25.6898 31.7274C26.2258 31.1914 27.0898 31.1914 27.6258 31.7274L29.6437 33.7453L29.6437 25.9742C29.6437 25.2196 30.2562 24.6071 31.0109 24.6071C31.7656 24.6071 32.3781 25.2196 32.3781 25.9742L32.3781 33.7508L34.3961 31.7328C34.9211 31.1969 35.7852 31.1969 36.3211 31.7274Z" fill="#2BC155" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Cindy Alexandro</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 5, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-danger fs-16 font-w500 text-end d-block">Canceled</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="Today" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-responsive-md card-table transactions-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1" y="1" width="61" height="61" rx="29" stroke="#FF2E2E" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 19.0125C34.8937 19.6906 35.1836 20.5109 35.8617 20.8391C37.7484 21.7469 39.3453 23.1578 40.4828 24.9242C41.6476 26.7344 42.2656 28.8344 42.2656 31C42.2656 37.2125 37.2125 42.2656 31 42.2656C24.7875 42.2656 19.7344 37.2125 19.7344 31C19.7344 28.8344 20.3523 26.7344 21.5117 24.9187C22.6437 23.1523 24.2461 21.7414 26.1328 20.8336C26.8109 20.5055 27.1008 19.6906 26.7726 19.007C26.4445 18.3289 25.6297 18.0391 24.9461 18.3672C22.6 19.4937 20.6148 21.2437 19.2094 23.4422C17.7656 25.6953 17 28.3094 17 31C17 34.7406 18.4547 38.257 21.1015 40.8984C23.743 43.5453 27.2594 45 31 45C34.7406 45 38.257 43.5453 40.8984 40.8984C43.5453 38.2516 45 34.7406 45 31C45 28.3094 44.2344 25.6953 42.7851 23.4422C41.3742 21.2492 39.389 19.4937 37.0484 18.3672C36.3648 18.0445 35.55 18.3289 35.2219 19.0125Z" fill="#FF2E2E" />
                                                                <path d="M36.3211 30.2726C36.589 30.0047 36.7203 29.6547 36.7203 29.3047C36.7203 28.9547 36.589 28.6047 36.3211 28.3367L32.8812 24.8969C32.3781 24.3937 31.7109 24.1203 31.0055 24.1203C30.3 24.1203 29.6273 24.3992 29.1297 24.8969L25.6898 28.3367C25.1539 28.8726 25.1539 29.7367 25.6898 30.2726C26.2258 30.8086 27.0898 30.8086 27.6258 30.2726L29.6437 28.2547L29.6437 36.0258C29.6437 36.7804 30.2562 37.3929 31.0109 37.3929C31.7656 37.3929 32.3781 36.7804 32.3781 36.0258L32.3781 28.2492L34.3961 30.2672C34.9211 30.8031 35.7851 30.8031 36.3211 30.2726Z" fill="#FF2E2E" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Chef Renata</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 5, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">-$167</span></td>
                                                    <td><span class="text-light fs-16 font-w500 text-end d-block">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1.00002" y="1" width="61" height="61" rx="29" stroke="#2BC155" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 42.9875C34.8938 42.3094 35.1836 41.4891 35.8617 41.1609C37.7484 40.2531 39.3453 38.8422 40.4828 37.0758C41.6477 35.2656 42.2656 33.1656 42.2656 31C42.2656 24.7875 37.2125 19.7344 31 19.7344C24.7875 19.7344 19.7344 24.7875 19.7344 31C19.7344 33.1656 20.3523 35.2656 21.5117 37.0813C22.6437 38.8477 24.2461 40.2586 26.1328 41.1664C26.8109 41.4945 27.1008 42.3094 26.7727 42.993C26.4445 43.6711 25.6297 43.9609 24.9461 43.6328C22.6 42.5063 20.6148 40.7563 19.2094 38.5578C17.7656 36.3047 17 33.6906 17 31C17 27.2594 18.4547 23.743 21.1016 21.1016C23.743 18.4547 27.2594 17 31 17C34.7406 17 38.257 18.4547 40.8984 21.1016C43.5453 23.7484 45 27.2594 45 31C45 33.6906 44.2344 36.3047 42.7852 38.5578C41.3742 40.7508 39.3891 42.5063 37.0484 43.6328C36.3648 43.9555 35.55 43.6711 35.2219 42.9875Z" fill="#2BC155" />
                                                                <path d="M36.3211 31.7274C36.5891 31.9953 36.7203 32.3453 36.7203 32.6953C36.7203 33.0453 36.5891 33.3953 36.3211 33.6633L32.8812 37.1031C32.3781 37.6063 31.7109 37.8797 31.0055 37.8797C30.3 37.8797 29.6273 37.6008 29.1297 37.1031L25.6898 33.6633C25.1539 33.1274 25.1539 32.2633 25.6898 31.7274C26.2258 31.1914 27.0898 31.1914 27.6258 31.7274L29.6437 33.7453L29.6437 25.9742C29.6437 25.2196 30.2562 24.6071 31.0109 24.6071C31.7656 24.6071 32.3781 25.2196 32.3781 25.9742L32.3781 33.7508L34.3961 31.7328C34.9211 31.1969 35.7852 31.1969 36.3211 31.7274Z" fill="#2BC155" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Cindy Alexandro</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 5, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-danger fs-16 font-w500 text-end d-block">Canceled</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1" y="1" width="61" height="61" rx="29" stroke="#FF2E2E" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 19.0125C34.8937 19.6906 35.1836 20.5109 35.8617 20.8391C37.7484 21.7469 39.3453 23.1578 40.4828 24.9242C41.6476 26.7344 42.2656 28.8344 42.2656 31C42.2656 37.2125 37.2125 42.2656 31 42.2656C24.7875 42.2656 19.7344 37.2125 19.7344 31C19.7344 28.8344 20.3523 26.7344 21.5117 24.9187C22.6437 23.1523 24.2461 21.7414 26.1328 20.8336C26.8109 20.5055 27.1008 19.6906 26.7726 19.007C26.4445 18.3289 25.6297 18.0391 24.9461 18.3672C22.6 19.4937 20.6148 21.2437 19.2094 23.4422C17.7656 25.6953 17 28.3094 17 31C17 34.7406 18.4547 38.257 21.1015 40.8984C23.743 43.5453 27.2594 45 31 45C34.7406 45 38.257 43.5453 40.8984 40.8984C43.5453 38.2516 45 34.7406 45 31C45 28.3094 44.2344 25.6953 42.7851 23.4422C41.3742 21.2492 39.389 19.4937 37.0484 18.3672C36.3648 18.0445 35.55 18.3289 35.2219 19.0125Z" fill="#FF2E2E" />
                                                                <path d="M36.3211 30.2726C36.589 30.0047 36.7203 29.6547 36.7203 29.3047C36.7203 28.9547 36.589 28.6047 36.3211 28.3367L32.8812 24.8969C32.3781 24.3937 31.7109 24.1203 31.0055 24.1203C30.3 24.1203 29.6273 24.3992 29.1297 24.8969L25.6898 28.3367C25.1539 28.8726 25.1539 29.7367 25.6898 30.2726C26.2258 30.8086 27.0898 30.8086 27.6258 30.2726L29.6437 28.2547L29.6437 36.0258C29.6437 36.7804 30.2562 37.3929 31.0109 37.3929C31.7656 37.3929 32.3781 36.7804 32.3781 36.0258L32.3781 28.2492L34.3961 30.2672C34.9211 30.8031 35.7851 30.8031 36.3211 30.2726Z" fill="#FF2E2E" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Paipal</a></h6>
                                                        <span class="fs-14">Transfer</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 4, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-success fs-16 font-w500 text-end d-block">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="1.00002" y="1" width="61" height="61" rx="29" stroke="#2BC155" stroke-width="2" />
                                                            <g clip-path="">
                                                                <path d="M35.2219 42.9875C34.8938 42.3094 35.1836 41.4891 35.8617 41.1609C37.7484 40.2531 39.3453 38.8422 40.4828 37.0758C41.6477 35.2656 42.2656 33.1656 42.2656 31C42.2656 24.7875 37.2125 19.7344 31 19.7344C24.7875 19.7344 19.7344 24.7875 19.7344 31C19.7344 33.1656 20.3523 35.2656 21.5117 37.0813C22.6437 38.8477 24.2461 40.2586 26.1328 41.1664C26.8109 41.4945 27.1008 42.3094 26.7727 42.993C26.4445 43.6711 25.6297 43.9609 24.9461 43.6328C22.6 42.5063 20.6148 40.7563 19.2094 38.5578C17.7656 36.3047 17 33.6906 17 31C17 27.2594 18.4547 23.743 21.1016 21.1016C23.743 18.4547 27.2594 17 31 17C34.7406 17 38.257 18.4547 40.8984 21.1016C43.5453 23.7484 45 27.2594 45 31C45 33.6906 44.2344 36.3047 42.7852 38.5578C41.3742 40.7508 39.3891 42.5063 37.0484 43.6328C36.3648 43.9555 35.55 43.6711 35.2219 42.9875Z" fill="#2BC155" />
                                                                <path d="M36.3211 31.7274C36.5891 31.9953 36.7203 32.3453 36.7203 32.6953C36.7203 33.0453 36.5891 33.3953 36.3211 33.6633L32.8812 37.1031C32.3781 37.6063 31.7109 37.8797 31.0055 37.8797C30.3 37.8797 29.6273 37.6008 29.1297 37.1031L25.6898 33.6633C25.1539 33.1274 25.1539 32.2633 25.6898 31.7274C26.2258 31.1914 27.0898 31.1914 27.6258 31.7274L29.6437 33.7453L29.6437 25.9742C29.6437 25.2196 30.2562 24.6071 31.0109 24.6071C31.7656 24.6071 32.3781 25.2196 32.3781 25.9742L32.3781 33.7508L34.3961 31.7328C34.9211 31.1969 35.7852 31.1969 36.3211 31.7274Z" fill="#2BC155" />
                                                            </g>
                                                            <defs>
                                                            </defs>
                                                        </svg>



                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 font-w600 mb-0"><a href="javascript:void(0);" class="text-black">Hawkins Jr.</a></h6>
                                                        <span class="fs-14">Cashback</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="fs-16 text-black font-w600 mb-0">June 4, 2020</h6>
                                                        <span class="fs-14">05:34:45 AM</span>
                                                    </td>
                                                    <td><span class="fs-16 text-black font-w600">+$5,553</span></td>
                                                    <td><span class="text-danger fs-16 font-w500 text-end d-block">Canceled</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
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

<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>

<script src="<?= base_url() ?>/assets/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/apexchart/apexchart.js"></script>
<script src="<?= base_url() ?>/assets/vendor/peity/jquery.peity.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/nouislider/nouislider.min.js"></script>
<script src="<?= base_url() ?>/assets/vendor/wnumb/wNumb.js"></script>
<script src="<?= base_url() ?>/assets/js/dashboard/dashboard-1.js"></script>
<script src="<?= base_url() ?>/assets/vendor/owl-carousel/owl.carousel.js"></script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>