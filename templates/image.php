<?php $this->layout('base', ['title' => 'Images', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Images -->
<section class="image text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Image</h2>
                <h3 class="section-subheading text-muted">Check out this image</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <ol class="project-button-group">
                    <li class="edit-button">
                        <a href="<?= $this->baseUrl('/image/edit/' . $image->getFilename()) ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </li>
                    <li class="delete-button">
                        <a href="<?= $this->baseUrl('/image/delete/' . $image->getFilename()) ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row image-set">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <h4><?= $image->getTitle() ?></h4>
                <h5><?= $image->getCaption() ?></h5>
                <br>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <img src="<?= $this->baseUrl($this->getUrl($image->getFilename(), ['w' => '1024'])) ?>"
                     class="img-fluid"
                     alt="<?= $image->getTitle() ?>">
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
