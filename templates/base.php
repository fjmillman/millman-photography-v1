<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Millman Photography">
        <meta name="author" content="Freddie John Millman">

        <!-- Title -->
        <title><?= isset($title) ? $this->e($title) . ' · ' : '' ?>Millman Photography</title>

        <!-- Bootstrap -->
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
              integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
              crossorigin="anonymous">

        <!-- Fonts -->
        <script src="https://use.fontawesome.com/b114e5fdf4.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="<?= $this->asset('asset/css/millmanphotography.css') ?>">
    </head>
    <body>
        <!-- Navigation -->
        <nav role="navigation" class="navbar fixed-top navbar-toggleable-md">
            <div class="container">
                <!-- Social Buttons -->
                <ul class="social-button-group navbar-toggler-right">
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
                </ul>

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
                    <img class="signature" src="<?= $this->asset('asset/img/signature.png') ?>">
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
                    </div>
                    <div class="col-lg-6">
                        <span class="copyright">
                            <i id="copyright" class="fa fa-copyright"></i>
                            <?= date("Y"); ?> Freddie John Millman All Rights Reserved
                        </span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
                crossorigin="anonymous"></script>

        <!-- Tether -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
                integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
                crossorigin="anonymous"></script>

        <!-- Bootstrap Javascript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
                integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
                crossorigin="anonymous"></script>

        <!-- Javascript -->
        <script src="<?= $this->asset('asset/js/millmanphotography.js') ?>"></script>
    </body>
</html>
