<?php $this->layout('base', ['sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Header -->
<span class="anchor" id="top"></span>
<header class="fix-panel-background text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 banner">
                <img class="signature img-fluid" src="<?= $this->asset('asset/img/signature.png') ?>">
                <h2 class="header-heading">Millman Photography</h2>
                <h3 class="header-subheading text-muted">Photography by Freddie John Millman</h3>
            </div>
        </div>
    </div>
</header>

<!-- Blog -->
<span class="anchor" id="blog"></span>
<section class="blog text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Blog.</h2>
                <h3 class="section-subheading text-muted">Check out what I have been up to.</h3>
            </div>
        </div>
        <div class="row">
            <?php foreach ($blogItems as $blogItem): ?>
                <div class="col-md-4 col-sm-6 project-item">
                    <a href="<?= $this->e($blogItem['link']) ?>" class="project-link">
                        <img src="<?= $this->asset('asset/img/' . $blogItem['image'] . '.jpg') ?>" class="img-fluid" alt="">
                    </a>
                    <div class="project-caption">
                        <h4><?= $this->e($blogItem['title']) ?></h4>
                        <p><?= $this->e($blogItem['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-xl button" href="<?= $this->baseUrl('blog') ?>">Check out my blog</a>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<span class="anchor" id="about"></span>
<section class="about fix-panel-background text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Who am I?</h2>
                <h3 class="section-subheading text-muted">That is a very good question.</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <img src="<?= $this->asset('asset/img/portrait.jpg') ?>" aria-label="Portrait" class="img-fluid portrait">
            </div>
            <div class="col-lg-6">
                <div class="text-block">
                    <p>I am a Yorkshire-born student of Computer Science based in the UNESCO world heritage city of Bath in the United Kingdom.</p>
                    <p>I began my path into photography by picking up a DSLR and joining up with the University of Bath's Photography Society in my first year.</p>
                    <p>Over the course of the year I was able advantage of the opportunities that the Photography Society had to offer.</p>
                    <p>My main interests in photography lie firmly in Landscapes, although I have dabbled in Portraits, and Architecture.</p>
                    <p>Check out my work in the Gallery.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery -->
<span class="anchor" id="gallery"></span>
<section class="gallery text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Gallery.</h2>
                <h3 class="section-subheading text-muted">Time to show off my work.</h3>
            </div>
        </div>
        <div class="row">
            <?php foreach ($galleryItems as $galleryItem): ?>
                <div class="col-md-4 col-sm-6 project-item">
                    <a href="<?= $this->e($galleryItem['link']) ?>" class="project-link">
                        <img src="<?= $this->asset('asset/img/' . $galleryItem['image'] . '.jpg') ?>" class="img-fluid" alt="">
                    </a>
                    <div class="project-caption">
                        <h4><?= $this->e($galleryItem['title']) ?></h4>
                        <p><?= $this->e($galleryItem['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-xl button" href="<?= $this->baseUrl('gallery') ?>">Check out my gallery</a>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<span class="anchor" id="services"></span>
<section class="services fix-panel-background text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Services.</h2>
                <h3 class="section-subheading text-white">What I can do for you.</h3>
            </div>
        </div>
        <div class="row service-group">
            <div class="col-md-4">
                <i class="fa fa-camera fa-3x text-white" aria-hidden="true"></i>
                <h4 class="service-heading">Photography</h4>
                <p class="text-white">My services in photography.</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-battery fa-3x text-white" aria-hidden="true"></i>
                <h4 class="service-heading">Events</h4>
                <p class="text-white">My services in events.</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-print fa-3x text-white" aria-hidden="true"></i>
                <h4 class="service-heading">Prints</h4>
                <p class="text-white">My services in prints.</p>
            </div>
        </div>
    </div>
</section>

<!-- Enquiry -->
<span class="anchor" id="enquiry"></span>
<section class="enquiry text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Enquiry.</h2>
                <h3 class="section-subheading text-muted">Get in touch.</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="enquiry-form" method="post" action="/enquiry" role="form">
                    <?php $this->insert('csrf', ['csrf' => $csrfToken]) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" type="text" class="form-control" placeholder="Name *" id="name" required data-validation-required-message="Please enter your name.">
                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control" placeholder="Email *" id="email" required data-validation-required-message="Please enter your email address.">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea name="message" class="form-control" placeholder="Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
