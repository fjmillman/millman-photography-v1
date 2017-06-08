<?php $this->layout('emails/base', ['title' => 'Enquiry Sent', 'cid' => $cid]) ?>

<?php $this->start('email') ?>
<tr class="section">
    <td colspan="2">
        <h1>
            Thank you for your Enquiry.
        </h1>
        <p class="small">
            You sent you an Enquiry on the <?= $this->e($enquiry->getDateCreated()->format('jS M Y')) ?>
        </p>
        <p>
            <?= nl2br($this->e($enquiry->getMessage())) ?>
        </p>
        <p>
            I will be sure to get back to you as soon as possible.
        </p>
        <p>
            Kind regards,
            <br>
            Freddie John Millman
        </p>
    </td>
</tr>
<?php $this->stop() ?>
