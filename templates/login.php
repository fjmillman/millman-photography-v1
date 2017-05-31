<?php $this->layout('base') ?>

<?php $this->start('page') ?>
<!-- Login -->
<section class="login text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Login.</h1>
                <p>Do you remember who you were?</p>
                <form id="login-form" method="post" action="/login" role="form">
                    <?php $this->insert('csrf', ['csrf' => $csrfToken]) ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input id="username" type="text" class="form-control" placeholder="Username *" required data-validation-required-message="Please enter a username.">
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control" placeholder="Password *" required data-validation-required-message="Please enter your password.">
                            </div>
                            <div class="form-group">
                                <input id="confirm-password" type="password" class="form-control" placeholder="Confirm Password *" required data-validation-required-message="Please enter your password again.">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
