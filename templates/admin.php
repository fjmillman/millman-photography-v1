<?php $this->layout('base', ['title' => 'Admin']) ?>

<?php $this->start('page') ?>
<!-- Admin -->
<section id="admin">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Admin.</h1>
                <p>Mwuhaha! Looks like you have control!</p>
                <p><a href="/logout">You could lose your control!</a></p>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
