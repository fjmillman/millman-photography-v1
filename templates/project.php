<div class="col-md-4 col-sm-6 project-item">
    <a href="/blog" class="project-link">
        <img src="<?= $this->asset('asset/img/swaledale.jpg') ?>" class="img-fluid" alt="">
    </a>
    <div class="project-caption">
        <h4>
            <?= $this->e($post->getTitle()) ?>
        </h4>
        <small>
            <?= $this->e($post->getDateCreated()->format('jS M Y')) ?>
        </small>
        <p>
            <?= $this->e($post->getDescription()) ?>
        </p>
    </div>
</div>
