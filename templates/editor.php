<?php $this->layout('base', ['title' => isset($post) ? 'Edit Post' : 'Create New Post', 'sections' => $sections]) ?>

<?php $this->start('styles') ?>
<!-- Tokenfield -->
<link rel="stylesheet" href="<?= $this->baseUrl($this->asset('css/tokenfield.min.css')) ?>">
<?php $this->end() ?>

<?php $this->start('page') ?>
<!-- Editor -->
<section class="editor text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><?= isset($post) ? 'Edit post' : 'Create a new post' ?></h1>
                <form class="post-form"
                      method="post"
                      action="<?= isset($post)
                          ? $this->baseUrl('/blog/post/edit/' . $post->getSlug())
                          : $this->baseUrl('/blog/post/new') ?>">
                    <?php $this->insert('partials/csrf', ['csrf' => $csrfToken]) ?>
                    <div class = "row">
                        <div class="col-md-6">
                            <div class="form-group center-block">
                                <input name="title"
                                       id="title"
                                       placeholder="Title *"
                                       class="form-control"
                                       maxlength="50"
                                       required value="<?= isset($post) ? $post->getTitle() : '' ?>">
                            </div>
                            <div class="form-group center-block">
                                <input name="description"
                                       id="description"
                                       placeholder="Description *"
                                       class="form-control"
                                       maxlength="50"
                                       required value="<?= isset($post) ? $post->getDescription() : '' ?>">
                            </div>
                            <input id="tags"
                                   name="tags"
                                   placeholder="Tags"
                                   class="tokenfield-input"
                                   data-tag-data=<?= isset($tagData) ? $tagData : '' ?>>
                            <input id="images"
                                   type="hidden"
                                   name="images"
                                   value="">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group center-block">
                                <textarea name="body"
                                          id="body"
                                          title="body"
                                          placeholder="Content *"
                                          class="form-control"
                                ><?= isset($post) ? $post->getBody() : '' ?></textarea>
                            </div>
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
                                <?= isset($post) ? 'Publish changes' : 'Publish' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
