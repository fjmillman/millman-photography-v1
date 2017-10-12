<div class="tag-row row">
    <div class="col-lg-12">
        <h4>
            <a href="<?= $this->baseUrl('blog/tag/' . $tag->getSlug()) ?>">
                <?= $this->e($tag->getName()) ?>
            </a>
        </h4>
    </div>
    <?php foreach ($tag->getPostTag() as $postTag): ?>
            <?php $this->insert('partials/post', ['post' => $postTag->getPost()]) ?>
    <?php endforeach ?>
</div>
