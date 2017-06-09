<?php $this->layout('base', ['title' => 'Gallery']) ?>

<?php $this->start('page') ?>
<!-- Gallery -->
<section class="gallery text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gallery.</h2>
                <h3 class="section-subheading text-muted">Time to show off my work.</h3>
            </div>
        </div>
        <div class="row">
            <?php if (count($galleries) === 0) : ?>
                <li>
                    <h2>Watch this space!</h2>
                </li>
            <?php else : ?>
                <?php foreach ($galleries as $gallery): ?>
                    <?php $this->insert('partials/gallery', ['gallery' => $gallery]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $this->stop() ?>
