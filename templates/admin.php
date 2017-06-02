<?php $this->layout('base', ['title' => 'Admin', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Admin -->
<section class="admin text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Admin.</h1>
                <p>Mwuhaha! Looks like you have control!</p>
                <p><a href="/logout">You could lose your control!</a></p>
            </div>
        </div>
    </div>
</section>

<!-- Image -->
<span class="image" id="image"></span>
<section class="image text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Image.</h2>
                <h3 class="section-subheading text-muted">Upload an image.</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="upload-form" method="post" action="/upload" enctype="multipart/form-data" role="form">
                    <?php $this->insert('csrf', ['csrf' => $csrfToken]) ?>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="file" type="file" class="form-control" placeholder="Name *" id="name" required data-validation-required-message="Please enter your name.">
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-lg-12">
                            <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
