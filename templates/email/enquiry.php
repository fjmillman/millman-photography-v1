<?php $this->layout('email/body', ['title' => $title, 'cid' => $cid]) ?>

<?php $this->start('email') ?>
<tr class="section">
    <td>
        <h1>
            YOU HAVE RECEIVED AN ENQUIRY.
        </h1>
        <p class="small">
            <?= $this->e($enquiry->getName()) ?> sent you an Enquiry at <?= $this->e($enquiry->getDateCreated()->format('jS \of F Y')) ?>
        </p>
        <p class="message">
            <br />
            <?= nl2br($this->e($enquiry->getMessage())) ?>
            <br />
            <br />
        </p>
        <p>
            Reply to
            <a href="mailto:<?= $this->e($enquiry->getEmail()) ?>" style="text-decoration: none; color: black;">
                <?= $this->e($enquiry->getName()) ?>
            </a>
        </p>
    </td>
</tr>
<?php $this->stop() ?>
