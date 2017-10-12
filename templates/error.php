<?php $this->layout('base', ['title' => $code]) ?>

<?php $this->start('page') ?>
<!-- Error -->
<section id="error">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1><?= $this->e($code) . ' : ' . $this->e($title) ?></h1>
                <p><?= $this->e($message) ?></p>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
