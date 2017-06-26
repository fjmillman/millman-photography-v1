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
        <link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/millmanphotography.min.css')) ?>">
    </head>
    <body>
        <!-- Navigation -->
        <nav role="navigation" class="navbar fixed-top navbar-toggleable-md">
            <div class="container">
                    <!-- Social Buttons -->
                    <ol class="social-button-group navbar-toggler-right">
                        <li class="facebook-button">
                            <a href="https://facebook.com/millmanphotography" target="_blank">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="instagram-button">
                            <a href="https://instagram.com/millmanphotography" target="_blank">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="five-hundred-px-button">
                            <a href="https://500px.com/millmanphotography" target="_blank">
                                <i class="fa fa-500px" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ol>

                    <?php if (isset($sections)): ?>
                        <!-- Navigation Toggle -->
                        <button class="navbar-toggler collapsed"
                                type="button"
                                data-toggle="collapse"
                                data-target="#navbar"
                                aria-controls="navbar"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <i class="fa fa-bars fa-lg"></i>
                        </button>
                    <?php endif; ?>

                    <!-- Logo -->
                    <a class="navbar-brand" href="<?= isset($title) ? $this->baseUrl() : '#top' ?>">
                        <img class="logo" src="<?= $this->baseUrl($this->asset('img/signature.png')) ?>">
                    </a>

                    <?php if (isset($sections)): ?>
                        <!-- Navigation Bar -->
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="navbar-nav mr-auto" id="navigation">
                                <?php foreach ($sections as $section): ?>
                                    <a class="navigation-button underline page-scroll"
                                       href="<?= isset($title) ? $this->baseUrl('#' . $section) : '#'.$this->e($section) ?>">
                                        <li class="navigation"><?= $this->e($section) ?></li>
                                    </a>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
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
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <a class="admin-button" href="<?= $this->baseUrl('login') ?>" target="_self">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>
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
        <script src="<?= $this->baseUrl($this->asset('js/millmanphotography.min.js')) ?>"></script>
    </body>
</html>
