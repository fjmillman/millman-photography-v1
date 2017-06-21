<?php $this->layout('base', ['title' => $post->getTitle()]) ?>

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
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $post->getBody() ?>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
