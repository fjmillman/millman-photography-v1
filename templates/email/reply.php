<?php $this->layout('email/body', ['title' => $title, 'cid' => $cid]) ?>

<?php $this->start('email') ?>
<tr class="section">
    <td>
        <h1>
            THANK YOU FOR YOUR ENQUIRY.
        </h1>
        <p class="small">
            You sent me a message on the <?= $this->e($enquiry->getDateCreated()->format('jS \of F Y')) ?>
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
