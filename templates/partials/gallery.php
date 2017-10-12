<div class="col-md-4 col-sm-6 project-item">
    <a href="<?= $this->baseUrl('gallery/' . $gallery->getSlug()) ?>" class="project-link">
        <img src="<?= $this->baseUrl($this->getUrl($gallery->getCoverImage(), ['w' => '350'])) ?>"
             class="img-fluid"
             alt="<?= $this->e($gallery->getTitle()) ?>">
    </a>
    <div class="project-caption">
        <h4>
            <?= $this->e($gallery->getTitle()) ?>
        </h4>
        <?php if (isset($user)): ?>
            <ol class="project-button-group">
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
        <p>
            <?= $this->e($gallery->getDescription()) ?>
        </p>
    </div>
</div>
