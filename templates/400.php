<?php $this->layout('base', ['title' => '404']) ?>

<?php $this->start('page') ?>
<!-- 404 -->
<section id="404">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p><?= $this->e($message) ?></p>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
