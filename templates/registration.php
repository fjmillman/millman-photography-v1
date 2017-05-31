<?php $this->layout('base') ?>

<?php $this->start('page') ?>
<!-- Register -->
<section class="register text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Registration.</h1>
                <p>Be the admin that you want to be.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="registration-form" method="post" action="/register" role="form">
                    <?php $this->insert('csrf', ['csrf' => $csrfToken]) ?>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input id="username" type="text" class="form-control" placeholder="Username *" required data-validation-required-message="Please enter a username.">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input id="password" type="password" class="form-control" placeholder="Password *" required data-validation-required-message="Please enter a password.">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input id="confirm-password" type="password" class="form-control" placeholder="Confirm Password *" required data-validation-required-message="Please enter the same password again.">
                    </div>
                    <button id="submit" type="submit" name="submit" value="submit" class="btn btn-xl">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $this->stop() ?>
