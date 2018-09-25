<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Millman Photography">
        <meta name="author" content="Freddie John Millman">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Title -->
        <title><?= isset($title) ? $this->e($title) . ' · ' : '' ?>Millman Photography</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/bootstrap.min.css')) ?>">
        <link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/bootstrap-grid.min.css')) ?>">
        <link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/bootstrap-reboot.min.css')) ?>">

        <!-- Fonts -->
        <link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/font-awesome.min.css')) ?>">

        <!-- CSS -->
        <link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/millman-photography.min.css')) ?>">

        <?= $this->section('styles') ?>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar fixed-top navbar-toggleable-md">
            <div class="container nav-container">
                <?php $this->insert('partials/social-media-buttons') ?>

                <?php if (isset($sections)): ?>
                    <!-- Navigation Toggle -->
                    <button class="nav-button navbar-toggler collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#navbar"
                            aria-controls="navbar"
                            aria-expanded="false"
                            aria-label="Toggle navigation">
                        <i class="fa fa-bars fa-lg"></i>
                    </button>
                <?php endif ?>

                <!-- Logo -->
                <a class="navbar-brand" href="<?= isset($title) ? $this->baseUrl() : '#top' ?>">
                    <img class="logo" src="<?= $this->baseUrl($this->asset('img/signature.png')) ?>">
                </a>

                <?php if (isset($sections)): ?>
                    <!-- Navigation Bar -->
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav navigation">
                            <?php foreach ($sections as $key => $section): ?>
                                <?php if ($key == 'Images' && !isset($user)) continue; ?>
                                <?php if (is_array($section)): ?>
                                    <li class="nav-item navigation-button underline page-scroll dropdown">
                                        <a class="nav-link navigation-link"
                                           href="<?= isset($title) ? $this->baseUrl(strtolower($key)) : '#' . $this->e(strtolower($key)) ?>">
                                            <?= $this->e($key) ?>
                                        </a>
                                        <a class="dropdown-arrow dropdown-toggle"
                                           href=""
                                           id="blog-dropdown"
                                           data-toggle="dropdown"
                                           aria-expanded="false"></a>
                                        <div class="dropdown-menu" aria-labelledby="blog-dropdown">
                                            <?php foreach ($section as $label => $dropdown): ?>
                                                <?php if ($label != 'Images'): ?>
                                                    <a class="dropdown-item" href="<?= $this->baseUrl($dropdown) ?>">
                                                        <?= $this->e($label) ?>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach ?>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item navigation-button underline page-scroll">
                                        <a class="nav-link navigation-link"
                                           href="<?= isset($title) || (!isset($title) && $key == 'Images') ? $this->baseUrl($section) : '#' . $this->e($section) ?>">
                                            <?= $this->e($key) ?>
                                        </a>
                                    </li>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
        </nav>

        <?= $this->section('page') ?>

        <!-- Footer -->
        <footer class="text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <span class="tag-line">Photography by Freddie John Millman</span>
                        <?php if (isset($user)): ?>
                            <a class="admin-button" href="<?= $this->baseUrl('logout') ?>" target="_self">
                                <i class="fa fa-sign-out"></i>
                            </a>
                        <?php else: ?>
                            <a class="admin-button" href="<?= $this->baseUrl('login') ?>" target="_self">
                                <i class="fa fa-sign-in"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6">
                        <span class="copyright">
                            &#169 <?= date("Y"); ?> Millman Photography All Rights Reserved
                        </span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JQuery -->
        <script src="<?= $this->baseUrl($this->asset('js/jquery.min.js')) ?>"></script>

        <!-- Tether -->
        <script src="<?= $this->baseUrl($this->asset('js/tether.min.js')) ?>"></script>

        <!-- Bootstrap -->
        <script src="<?= $this->baseUrl($this->asset('js/bootstrap.min.js')) ?>"></script>

        <!-- Javascript -->
        <script src="<?= $this->baseUrl($this->asset('js/millman-photography.min.js')) ?>"></script>
    </body>
</html>
