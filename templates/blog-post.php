<li>
    <h2>
        <a href="/blog">
            <?= $this->e($post->getTitle()) ?>
        </a>

        <small class="post-date">
            <?= $post->getDateCreated()->format('jS M Y') ?>
        </small>
    </h2>
    <p>
        <?= $this->e($post->getDescription()) ?>
    </p>
</li>
