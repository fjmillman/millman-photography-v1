<?php foreach ($csrfToken as $key => $value): ?>
    <input id="<?= ($key == 'csrf_name') ? 'csrfName' : 'csrfValue' ?>" type="hidden" name="<?= $this->e($key) ?>" value="<?= $this->e($value) ?>">
<?php endforeach; ?>