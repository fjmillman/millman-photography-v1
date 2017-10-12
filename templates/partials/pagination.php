<div class="pagination row">
    <?php if (isset($next)): ?>
        <div class="col-md-<?= (isset($previous)) ? '6' : '12' ?>">
            <div class="float-left">
                <a href="<?= $this->baseUrl(($next instanceof \MillmanPhotography\Entity\Post ? 'blog/post/' : 'gallery/') . $this->e($next->getSlug())) ?>"
                   class="pagination">
                    <?= ($next instanceof \MillmanPhotography\Entity\Post ? $this->e($next->getDateCreated()->format('jS \of F Y')) . ': ' : '')
                    . $this->e($next->getTitle()) ?>
                </a>
            </div>
        </div>
    <?php endif ?>
    <?php if (isset($previous)): ?>
        <div class="col-md-<?= (isset($next)) ? '6' : '12' ?>">
            <div class="float-right">
                <a href="<?= $this->baseUrl(($previous instanceof \MillmanPhotography\Entity\Post ? 'blog/post/' : 'gallery/') . $this->e($previous->getSlug())) ?>"
                   class="pagination">
                    <?= ($previous instanceof \MillmanPhotography\Entity\Post ? $this->e($previous->getDateCreated()->format('jS \of F Y')) . ': ' : '')
                    . $this->e($previous->getTitle()) ?>
                </a>
            </div>
        </div>
    <?php endif ?>
</div>
