<?php $this->layout('emails/base', ['title' => 'Enquiry Received', 'cid' => $cid]) ?>

<?php $this->start('email') ?>
<div class="section">
    <h1>
        You have received an Enquiry.
    </h1>
    <small>
        <?= $this->e($enquiry->getName()) ?> sent you an Enquiry at <?= $this->e($enquiry->getDateCreated()->format('jS M Y')) ?>
    </small>
    <p>
        <?= $this->e($enquiry->getMessage()) ?>
    </p>
    <p>
        Reply to
        <a href="mailto:<?= $this->e($enquiry->getEmail()) ?>" style="text-decoration: none; color: black;">
            <?= $this->e($enquiry->getName()) ?>
        </a>
    </p>
</div>
<?php $this->stop() ?>
