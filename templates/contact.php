<?php $this->layout('base', ['title' => 'Contact']) ?>

<?php $this->start('page') ?>
<!-- Gallery -->
<section id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p><?= $this->e($message) ?></p>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
