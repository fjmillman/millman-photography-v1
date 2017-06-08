<?php $this->layout('emails/base', ['title' => 'Enquiry Sent', 'cid' => $cid]) ?>

<?php $this->start('email') ?>
<div class="section">
    <h1>
        Thank you for your Enquiry.
    </h1>
    <small>
        You sent you an Enquiry on the <?= $this->e($enquiry->getDateCreated()->format('jS M Y')) ?>
    </small>
    <p>
        <?= $this->e($enquiry->getMessage()) ?>
    </p>
    <p>
        I will be sure to get back to you as soon as possible.
    </p>
    <p>
        Kind regards,
        <br>
        Freddie John Millman
    </p>
</div>
<?php $this->stop() ?>
