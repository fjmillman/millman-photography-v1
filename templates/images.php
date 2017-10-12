<?php $this->layout('base', ['title' => 'Images', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Images -->
<section class="images text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Images</h2>
                <h3 class="section-subheading text-muted">Manage your photos</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="linkable-gallery"
                     class="gallery-set"
                     data-image-data='<?= isset($imageData) ? $imageData : '' ?>'></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-xl button" href="<?= $this->baseUrl('/image/new') ?>">
                    Upload a new image
                </a>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
