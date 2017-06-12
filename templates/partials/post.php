<div class="col-md-4 col-sm-6 project-item">
    <a href="<?= $this->baseUrl('blog/post/' . $post->getSlug()) ?>" class="project-link">
        <img src="<?= $this->baseUrl($this->asset('img/' . $this->e($post->getCoverImage()) . '.jpg')) ?>"
             class="img-fluid"
             alt="<?= $post->getTitle() ?>">
    </a>
    <div class="project-caption">
        <h4>
            <?= $this->e($post->getTitle()) ?>
        </h4>
        <small>
            <?= $this->e($post->getDateCreated()->format('jS \of F Y')) ?>
        </small>
        <p>
            <?= $this->e($post->getDescription()) ?>
        </p>
    </div>
</div>
