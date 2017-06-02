<?php $this->layout('base', ['title' => 'Login']) ?>

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
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="username" id="username" type="text" class="form-control" placeholder="Username *" required data-validation-required-message="Please enter a username.">
                            </div>
                            <div class="form-group">
                                <input name="password" id="password" type="password" class="form-control" placeholder="Password *" required data-validation-required-message="Please enter a password.">
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-lg-12">
                            <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl">Login</button>
                            <button id="forgot" type="button" name="forgot" value="forgot" class="btn btn-xl">Forgot Password?</button>
                            <p><a href="/register">Don't have an account?</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
