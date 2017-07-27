<?php $this->layout('base', ['title' => $post->getTitle(), 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Post -->
<section class="post text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-black">
                    <?= $this->e($post->getTitle()) ?>
                </h2>
                <h3 class="section-subheading text-muted">
                    <?= $this->e($post->getDateCreated()->format('jS \of F Y')) ?>
                </h3>
                <?php if (isset($user)): ?>
                    <ol class="button-group">
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
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $post->getBody() ?>
            </div>
        </div>
        <?php if (isset($next) || isset($previous))
            $this->insert('partials/pagination', ['next' => $next, 'previous' => $previous])
        ?>
    </div>
</section>
<?php $this->stop() ?>
