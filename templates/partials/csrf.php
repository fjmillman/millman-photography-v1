<?php foreach ($csrfToken as $key => $value): ?>
    <input class="csrf" type="hidden" name="<?= $this->e($key) ?>" value="<?= $this->e($value) ?>">
<?php endforeach; ?>
