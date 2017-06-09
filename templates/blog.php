<?php $this->layout('base', ['title' => 'Blog']) ?>

<?php $this->start('page') ?>
<!-- Blog -->
<section class="blog text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Blog.</h2>
                <h3 class="section-subheading text-muted">Check out what I have been up to.</h3>
            </div>
        </div>
        <div class="row">
            <?php if (count($posts) === 0) : ?>
                <li>
                    <h2>Watch this space!</h2>
                </li>
            <?php else : ?>
                <?php foreach ($posts as $post): ?>
                    <?php $this->insert('partials/post', ['post' => $post]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $this->stop() ?>
