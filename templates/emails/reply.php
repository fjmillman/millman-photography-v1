<?php $this->layout('emails/base', ['title' => 'Enquiry Sent']) ?>

<?php $this->start('email') ?>
<!-- Content -->
<section>
    <h1>
        Thank you for your Enquiry.
    </h1>
    <small>
        You sent you an Enquiry at <?= $this->e($enquiry->getDateCreated()->format('jS M Y')) ?>
    </small>
    <p>
        <?= $this->e($enquiry->getBody()) ?>
    </p>
    <p>
        I will be sure to get back to you as soon as possible.
    </p>
    <p>
        Kind regards,
        Fred
    </p>
</section>
<?php $this->stop() ?>
