<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Millman Photography">
        <meta name="author" content="Freddie John Millman">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $this->e($title)?> · Millman Photography</title>
    </head>
    <body>
        <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide:all;">
            Millman Photography
        </div>
        <div class="header">
            <table>
                <td>
                    <img class="signature" src="<?= $cid ?>" alt="logo">
                </td>
                <td>
                    <ul class="social-button-group">
                        <li class="facebook-button">
                            <a href="https://facebook.com/millmanphotography" target="_blank">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="instagram-button">
                            <a href="https://instagram.com/millmanphotography" target="_blank">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="five-hundred-px-button">
                            <a href="https://500px.com/millmanphotography" target="_blank">
                                <i class="fa fa-500px" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </td>
            </table>
        </div>

        <?= $this->section('email') ?>

        <div class="footer">
            <span class="tag-line">
                Photography by Freddie John Millman
            </span>
            <span class="copyright">
                <i id="copyright" class="fa fa-copyright"></i>
                <?= date("Y"); ?> Millman Photography All Rights Reserved
            </span>
        </div>
    </body>
</html>
