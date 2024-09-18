<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />

<body class="dashboard dashboard_1" style="font-family:sans-serif; font-size:14px;">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar_blog_1">
                    <div class="sidebar-header">
                        <div class="logo_section">
                            <a href="index.html"><img class="logo_icon img-responsive"
                                    src="<?= base_url() ?>images/logo/SafarLogo1.png" alt="Logo"></a>
                        </div>
                    </div>
                    <div class="sidebar_user_info">
                        <div class="icon_setting"></div>
                        <div class="user_profle_side">
                            <div class="user_img">
                                <img class="img-responsive" style="margin-top: 20px;"
                                    src="<?= base_url('images/logo/SafarLogo1.png') ?>" alt="User Image">
                            </div>
                            <div class="user_info">
                                <h6>Welcome! <?= $this->session->userdata('fname') ?></h6>
                                <p><span class="online_animation"></span> Online</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar_blog_2">
                    <h4>GENERAL</h4>
                    <ul class="list-unstyled components">
                        <li class="active">
                            <a href="<?= base_url('welcome') ?>"><i class="fas fa-tachometer-alt yellow_color"></i>
                                <span>DASHBOARD</span></a>
                        </li>
                        <li>
                            <a href="<?= base_url('label') ?>"><i class="fas fa-barcode green_color"></i>
                                <span>GENERATE LABEL</span></a>
                        </li>
                        <li>
                            <a href="<?= base_url('godownstock') ?>"><i class="fas fa-briefcase blue_color"></i>
                                <span>STOCK IN GODOWN</span></a>
                        </li>
                        <li>
                            <a href="<?= base_url('inward') ?>"><i class="fas fa-download purple_color2"></i>
                                <span>INWARD</span></a>
                        </li>
                        <li>
                            <a href="<?= base_url('outward') ?>"><i class="fas fa-truck blue_color1"></i>
                                <span>OUTWARD / DISPATCH</span></a>
                        </li>
                        <li>
                            <a href="<?= base_url('stock') ?>"><i class="far fa-clock orange_color"></i>
                                <span>STOCK</span></a>
                        </li>
                        <li class="active">
                            <a href="#jobsheet" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                                    class="fas fa-clipboard-list red_color"></i>
                                <span>JOB SHEET</span></a>
                            <ul class="collapse list-unstyled" id="jobsheet">
                                <li><a href="<?= base_url('jobsheet') ?>"><i class="fas fa-tasks orange_color"></i>
                                        <span>MANAGE</span></a></li>
                                <li><a href="<?= base_url('jobsheet/status') ?>"><i
                                            class="fas fa-chart-line orange_color"></i>
                                        <span>STATUS</span></a></li>
                                <?php $user = $this->session->userdata();
                                if ($user['role'] == 'admin') { ?>
                                    <li><a href="<?= base_url('jobsheet/payment') ?>"><i
                                                class="fas fa-money-bill-wave orange_color"></i>
                                            <span>PAYMENT</span></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="active">
                            <a href="#material" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                                    class="fas fa-database green_color"></i>
                                <span>RAW MATERIAL</span></a>
                            <ul class="collapse list-unstyled" id="material">
                                <li><a href="<?= base_url('rawmaterial/less_rawmaterial') ?>"><i class="fas fa-tasks orange_color"></i>
                                        <span>MANAGE</span></a></li>
                                
                            </ul>
                        </li>
                        <?php $user = $this->session->userdata();
                        if ($user['role'] == 'admin') { ?>
                        <li class="active">
                            <a href="#reader" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                                    class="fas fa-barcode purple_color2"></i>
                                <span>BARCODE READER</span></a>
                            <ul class="collapse list-unstyled" id="reader">
                                <li><a href="<?= base_url('reader') ?>"><i class="fas fa-tasks orange_color"></i>
                                        <span>MANAGE</span></a></li>
                                <li><a href="<?= base_url('reader/status') ?>"><i
                                            class="fas fa-chart-line orange_color"></i>
                                        <span>STATUS</span></a></li>
                                    </ul>
                                </li>
                                <?php } ?>
                    </ul>
                    <?php $user = $this->session->userdata();
                    if ($user['role'] == 'admin') { ?>
                        <ul class="list-unstyled components">
                            <h4>MASTER TABLES</h4>
                            <li class="active">
                                <a href="#artical" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                                        class="fas fa-database red_color"></i>
                                    <span>MASTER</span></a>
                                <ul class="collapse list-unstyled" id="artical">
                                    <li><a href="<?= base_url('article') ?>"><i class="fas fa-newspaper yellow_color"></i>
                                            <span>ARTICLE</span></a></li>
                                    <li><a href="<?= base_url('color') ?>"><i class="fas fa-palette yellow_color"></i>
                                            <span>COLOR</span></a></li>
                                    <li><a href="<?= base_url('package') ?>"><i class="fas fa-box yellow_color"></i>
                                            <span>PACKAGE SIZE</span></a></li>
                                    <li><a href="<?= base_url('category') ?>"><i class="fas fa-sitemap yellow_color"></i>
                                            <span>CATEGORY</span></a></li>
                                    <li><a href="<?= base_url('type') ?>"><i class="fas fa-tags yellow_color"></i>
                                            <span>TYPE</span></a></li>
                                    <li><a href="<?= base_url('godown') ?>"><i class="fas fa-warehouse yellow_color"></i>
                                            <span>GODOWN</span></a></li>
                                    <li><a href="<?= base_url('contractor') ?>"><i class="fas fa-hard-hat yellow_color"></i>
                                            <span>CONTRACTOR</span></a></li>
                                    <li><a href="<?= base_url('payment_article') ?>"><i
                                                class="fas fa-money-bill-wave yellow_color"></i>
                                            <span>PAYMENT PER ARTICLE</span></a></li>
                                    <li><a href="<?= base_url('rawmaterial/material_required') ?>"><i
                                                class="fas fa-cubes yellow_color"></i>
                                            <span>MATERIAL PER ARTICLE</span></a></li>
                                    <li><a href="<?= base_url('supplier') ?>"><i
                                                class="fas fa-truck-loading yellow_color"></i>
                                            <span>SUPPLIER DETAILS</span></a></li>
                                    <a href="#MATERIAL" data-toggle="collapse" aria-expanded="false"
                                        class="dropdown-toggle"><i class="fas fa-database red_color"></i>
                                        <span>RAW MATERIAL</span></a>
                                    <ul class="collapse list-unstyled" id="MATERIAL">
                                        <li><a href="<?= base_url('rawmaterial') ?>"><i
                                                    class="fas fa-cubes yellow_color"></i>
                                                <span>RAW MATERIAL 1</span></a></li>
                                        <li><a href="<?= base_url('rawmaterial/raw_material2') ?>"><i
                                                    class="fas fa-cubes yellow_color"></i>
                                                <span>RAW MATERIAL 2</span></a></li>


                                    </ul>

                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </nav>
            <!-- end sidebar -->
            <!-- end sidebar -->