<?php $this->layout('base', ['title' => $tag->getName(), 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Tag -->
<section class="tagged text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Tag</h2>
                <h3 class="section-subheading text-muted"><?= $this->e($tag->getName()) ?></h3>
            </div>
        </div>
        <div class="row">
            <?php if (count($tag->getPostTag()) !== 0): ?>
                <?php foreach ($tag->getPostTag() as $postTag): ?>
                    <?php $this->insert('partials/post', ['post' => $postTag->getPost()]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12">
                    <p>No posts have been tagged with <?= $this->e(strtolower($tag->getName())) ?></p>
                </div>
            <?php endif ?>
        </div>
        <?php if (isset($next) || isset($previous)) : ?>
            <?php $this->insert('partials/pagination-tags', ['previous' => $previous, 'next' => $next]) ?>
        <?php endif ?>
    </div>
</section>
<?php $this->stop() ?>
