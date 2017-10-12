<div class="pagination row">
    <?php if (isset($next) && count($next->getPostTag()) !== 0): ?>
        <div class="col-md-<?= (isset($previous) && count($previous->getPostTag()) !== 0) ? '6' : '12' ?>">
            <div class="float-left">
                <a href="<?= $this->baseUrl('blog/tag/' . $this->e($next->getSlug())) ?>"
                   class="pagination">
                    <?= $this->e($next->getName()) ?>
                </a>
            </div>
        </div>
    <?php endif ?>
    <?php if (isset($previous) && count($previous->getPostTag()) !== 0): ?>
        <div class="col-md-<?= (isset($next) && count($next->getPostTag()) !== 0) ? '6' : '12' ?>">
            <div class="float-right">
                <a href="<?= $this->baseUrl('blog/tag/' . $this->e($previous->getSlug())) ?>"
                   class="pagination">
                    <?= $this->e($previous->getName()) ?>
                </a>
            </div>
        </div>
    <?php endif ?>
</div>
