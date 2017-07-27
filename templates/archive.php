<?php $this->layout('base', ['title' => 'Archive', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Blog -->
<section class="blog text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Archive</h2>
                <h3 class="section-subheading text-muted">Check out my older posts</h3>
            </div>
        </div>
        <div class="row">
            <?php if (count($posts) === 0) : ?>
                <div class="col-lg-12">
                    <h3>I appear to be empty right now!</h3>
                </div>
            <?php else : ?>
                <?php foreach ($posts as $post): ?>
                    <?php $this->insert('partials/post', ['post' => $post]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $this->stop() ?>
