<?php $this->layout('base', ['title' => isset($gallery) ? 'Edit Image' : 'Upload New Image', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Image Editor -->
<section class="editor text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><?= isset($image) ? 'Edit image' : 'Upload a new image' ?></h1>
                <form id="image-form"
                      method="post"
                      action="<?= isset($image)
                          ? $this->baseUrl('/image/edit/' . $image->getFilename())
                          : $this->baseUrl('/image/new') ?>"
                      enctype="multipart/form-data">
                    <?php $this->insert('partials/csrf', ['csrf' => $csrfToken]) ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-0"></div>
                        <div class="col-md-6 col-sm-12">
                            <?php if (!isset($image)): ?>
                                <div class="form-group center-block">
                                    <input name="file"
                                           type="file"
                                           class="form-control"
                                           placeholder="Image *"
                                           id="image"
                                           accept='image/*'
                                           required
                                           data-validation-required-message="Please select an image." />
                                </div>
                            <?php endif; ?>
                            <div class="form-group center-block">
                                <input name="title"
                                       id="title"
                                       placeholder="Title *"
                                       class="form-control"
                                       maxlength="50"
                                       required
                                       data-validation-required-message="Please enter a title."
                                       value="<?= isset($image) ? $image->getTitle() : '' ?>" />
                            </div>
                            <div class="form-group center-block">
                                <input name="caption"
                                       id="caption"
                                       title="caption"
                                       placeholder="Caption *"
                                       class="form-control"
                                       required
                                       data-validation-required-message="Please enter a caption."
                                       value="<?= isset($image) ? $image->getCaption() : '' ?>" />
                            </div>
                            <div class="form-group center-block">
                                <label for="is_showcase">Showcase image?</label>
                                <input type="checkbox"
                                       name="is_showcase"
                                       id="is_showcase"
                                       value="is_showcase"
                                       <?= isset($image) && $image->getShowcaseImage() ? 'checked="checked"' : '' ?> />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button id="submit"
                                    name="submit"
                                    value="submit"
                                    class="btn btn-xl">
                                <?= isset($image) ? 'Publish changes' : 'Upload' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
