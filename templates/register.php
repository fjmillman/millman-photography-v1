<?php $this->layout('base', ['title' => 'Register']) ?>

<?php $this->start('page') ?>
<!-- Register -->
<section class="register text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Registration.</h1>
                <p>Be the admin that you want to be.</p>
                <form id="registration-form" method="post" action="/register" role="form">
                    <?php $this->insert('csrf', ['csrf' => $csrfToken]) ?>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group center-block">
                                <input name="username" id="username" type="text" class="form-control" placeholder="Username *" required data-validation-required-message="Please enter a username.">
                            </div>
                            <div class="form-group center-block">
                                <input name="password" id="password" type="password" class="form-control" placeholder="Password *" required data-validation-required-message="Please enter a password.">
                            </div>
                            <div class="form-group center-block">
                                <input name="password_confirmation" id="password-confirmation" type="password" class="form-control" placeholder="Confirm Password *" required data-validation-required-message="Please enter the same password again.">
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-lg-12">
                            <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl">Register</button>
                            <p><a href="/login">Already have an account?</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
