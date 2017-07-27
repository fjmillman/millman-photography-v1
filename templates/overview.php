<?php $this->layout('base', ['sections' => $sections]) ?>

<?php $this->start('page') ?>
    <!-- Background -->
    <div id="background-image" class="background-image" style="background-image: url('<?= $this->baseUrl($this->asset('img/ashness-jetty.jpg')) ?>')"></div>

    <!-- Header -->
    <span class="anchor" id="top"></span>
    <header class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 banner">
                    <img class="signature img-fluid" src="<?= $this->baseUrl($this->asset('img/signature.png')) ?>">
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
                    <h2 class="section-heading">Blog</h2>
                    <h3 class="section-subheading text-muted">Check out what I have been up to</h3>
                </div>
            </div>
            <div class="row">
                <?php if (isset($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <?php $this->insert('partials/post', ['post' => $post]) ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>
                        <h2>Watch this space!</h2>
                    </li>
                <?php endif ?>
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
    <section class="about text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-heading">Who am I?</h2>
                    <h3 class="section-subheading text-white">That is a very good question</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <img src="<?= $this->asset('img/portrait.jpg') ?>" aria-label="Portrait" class="img-fluid portrait">
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
                    <h2 class="section-heading">Gallery</h2>
                    <h3 class="section-subheading text-muted">Time to show off my work</h3>
                </div>
            </div>
            <div class="row">
                <?php if (isset($galleries)): ?>
                    <?php foreach ($galleries as $gallery): ?>
                        <?php $this->insert('partials/gallery', ['gallery' => $gallery]) ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>
                        <h2>Watch this space!</h2>
                    </li>
                <?php endif ?>
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
    <section class="services text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-heading">Services</h2>
                    <h3 class="section-subheading text-white">What I can do for you</h3>
                </div>
            </div>
            <div class="row service-group">
                <div class="col-md-4">
                    <i class="fa fa-camera fa-3x text-white" aria-hidden="true"></i>
                    <h4 class="service-heading text-white">Photography</h4>
                    <p class="text-white">Perhaps you would like to give me my next challenge and commission me to capture a scene</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-battery fa-3x text-white" aria-hidden="true"></i>
                    <h4 class="service-heading text-white">Events</h4>
                    <p class="text-white">If you would like me to photography an event, please get in touch with me</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-print fa-3x text-white" aria-hidden="true"></i>
                    <h4 class="service-heading text-white">Prints</h4>
                    <p class="text-white">My photography is available to you as prints and canvases, just let me know what you would like</p>
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
                    <h2 class="section-heading">Enquiry</h2>
                    <h3 class="section-subheading text-muted">Get in touch</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="enquiry-form" method="post" action="/enquiry" role="form">
                        <?php $this->insert('partials/csrf', ['csrf' => $csrfToken]) ?>
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
                                <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $this->stop() ?>
