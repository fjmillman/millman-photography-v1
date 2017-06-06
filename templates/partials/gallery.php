<div class="col-md-4 col-sm-6 project-item">
    <a href="<?= $this->baseUrl('gallery/' . $gallery->getSlug()) ?>" class="project-link">
        <img src="<?= $this->asset('asset/img/' . $this->e($gallery->getCoverImage()) . '.jpg') ?>" class="img-fluid" alt="">
    </a>
    <div class="project-caption">
        <h4>
            <?= $this->e($gallery->getTitle()) ?>
        </h4>
        <p>
            <?= $this->e($gallery->getDescription()) ?>
        </p>
    </div>
</div>
