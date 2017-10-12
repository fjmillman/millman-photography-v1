<?php $this->layout('base', ['title' => $gallery->getTitle(), 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Gallery -->
<section class="gallery text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-black">
                    <?= $this->e($gallery->getTitle()) ?>
                </h2>
                <h3 class="section-subheading text-muted">
                    <?= $this->e($gallery->getDateCreated()->format('jS \of F Y')) ?>
                </h3>
                <p>
                    <?= $this->e($gallery->getDescription()) ?>
                </p>
                <?php if (isset($user)): ?>
                    <ol class="button-group">
                        <li class="edit-button">
                            <a href="<?= $this->baseUrl('/gallery/edit/' . $gallery->getSlug()) ?>" title="Edit this gallery">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="delete-button">
                            <a href="<?= $this->baseUrl('/gallery/delete/' . $gallery->getSlug()) ?>" title="Delete this gallery">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ol>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="lightbox-gallery" class="gallery-set" data-image-data='<?= isset($imageData) ? $imageData : '' ?>'></div>
            </div>
        </div>
        <?php if (isset($next) || isset($previous))
            $this->insert('partials/pagination', ['next' => $next, 'previous' => $previous])
        ?>
    </div>
</section>
<?php $this->stop() ?>
