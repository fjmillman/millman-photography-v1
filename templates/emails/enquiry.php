<?php $this->layout('emails/base', ['title' => 'Enquiry Received']) ?>

<?php $this->start('email') ?>
<!-- Content -->
<section>
    <h1>
        You have received an Enquiry.
    </h1>
    <small>
        <?= $this->e($enquiry->getName()) ?> sent you an Enquiry at <?= $this->e($enquiry->getDateCreated()->format('jS M Y')) ?>
    </small>
    <p>
        <?= $this->e($enquiry->getBody()) ?>
    </p>
    <p>
        Reply to <a href="mailto:<?= $this->e($enquiry->getName()) ?>"
    </p>
</section>
<?php $this->stop() ?>
