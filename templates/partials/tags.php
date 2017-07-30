<?php if (isset($postTags) && count($postTags) !== 0) : ?>
    <ol class="tags">
        <li class="tag text-muted">
            Tags:
        </li>
        <?php foreach ($postTags as $postTag) : ?>
            <li class="tag">
                <a href="<?= $this->baseUrl('blog/tag/' . $postTag->getTag()->getSlug()) ?>">
                    <?= $postTag->getTag()->getName() ?>
                </a>
            </li>
        <?php endforeach ?>
    </ol>
<?php endif ?>
