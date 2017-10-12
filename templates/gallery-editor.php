<?php $this->layout('base', ['title' => isset($gallery) ? 'Edit Gallery' : 'Create New Gallery', 'sections' => $sections]) ?>

<?php $this->start('page') ?>
<!-- Gallery Editor -->
<section class="editor text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><?= isset($gallery) ? 'Edit gallery' : 'Create a new gallery' ?></h1>
                <form id="gallery-form"
                      method="post"
                      action="<?= isset($gallery)
                          ? $this->baseUrl('/gallery/edit/' . $gallery->getSlug())
                          : $this->baseUrl('/gallery/new') ?>">
                    <?php $this->insert('partials/csrf', ['csrf' => $csrfToken]) ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-0"></div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group center-block">
                                <input name="title"
                                       id="title"
                                       placeholder="Title *"
                                       class="form-control"
                                       maxlength="50"
                                       required value="<?= isset($gallery) ? $gallery->getTitle() : '' ?>">
                            </div>
                            <div class="form-group center-block">
                                <input name="description"
                                       id="description"
                                       title="description"
                                       placeholder="Description *"
                                       class="form-control"
                                       required value="<?= isset($gallery) ? $gallery->getDescription() : '' ?>">
                            </div>
                            <div class="form-group center-block">
                                <label for="is_front">Include on the front page?</label>
                                <input type="checkbox"
                                       name="is_front"
                                       id="is_front"
                                       value="is_front"
                                       <?= isset($gallery) && $gallery->getIsFront() ? 'checked="checked"' : '' ?>>
                            </div>
                            <input id="images"
                                   type="hidden"
                                   name="images"
                                   value="">
                        </div>
                        <div class="col-lg-12">
                            <div id="selectable-gallery"
                                 class="gallery-set"
                                 data-image-data='<?= isset($imageData) ? $imageData : '' ?>'></div>
                        </div>
                        <div class="col-md-12">
                            <button id="submit"
                                    name="submit"
                                    value="submit"
                                    class="btn btn-xl">
                                <?= isset($gallery) ? 'Publish changes' : 'Publish' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
