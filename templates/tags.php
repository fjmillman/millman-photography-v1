<?php $this->layout('base', ['title' => 'Tags', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Tags -->
<section class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Tags</h2>
                <h3 class="section-subheading text-muted">A little bit of organisation</h3>
            </div>
        </div>
        <?php if (isset($tags)): ?>
            <?php foreach ($tags as $tag): ?>
                <?php if (isset($tag)) : ?>
                    <?php $this->insert('partials/tag', ['tag' => $tag]) ?>
                <?php endif ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-12">
                    <h4>No posts have been tagged</h4>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>
<?php $this->stop() ?>
