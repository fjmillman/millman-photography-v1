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
        <?php if (isset($user)): ?>
            <ol class="project-button-group">
                <li class="edit-button">
                    <a href="<?= $this->baseUrl('/blog/post/edit/' . $post->getSlug()) ?>" title="Edit this post">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="delete-button">
                    <a href="<?= $this->baseUrl('/blog/post/delete/' . $post->getSlug()) ?>" title="Delete this post">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </li>
                <?php if (!$post->getInArchive()): ?>
                    <li class="archive-button">
                        <a href="<?= $this->baseUrl('/blog/post/archive/' . $post->getSlug()) ?>" title="Archive this post">
                            <i class="fa fa-archive" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="restore-button">
                        <a href="<?= $this->baseUrl('/blog/post/restore/' . $post->getSlug()) ?>" title="Restore this post">
                            <i class="fa fa-undo" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php endif ?>
            </ol>
        <?php endif ?>
        <small>
            <?= $this->e($post->getDateCreated()->format('jS \of F Y')) ?>
        </small>
        <p>
            <?= $this->e($post->getDescription()) ?>
        </p>
    </div>
</div>
