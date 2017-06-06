<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Metadata -->
        <meta http-equiv="Content-Type" content="text/html;" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Millman Photography">
        <meta name="author" content="Freddie John Millman">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Title -->
        <title><?= $this->e($title)?> · Millman Photography</title>

        <!-- CSS -->
        <style type="text/css">
            #outlook a {
                padding: 0;
            }

            .ReadMsgBody {
                width: 100%;
            }

            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div,
            .ExternalClass * {
                line-height: 100%;
            }

            body, table, td, a {
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }

            table, td {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }

            img {
                -ms-interpolation-mode: bicubic;
            }

            body {
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            img {
                border: 0;
                height: auto;
                line-height: 100%;
                outline: none;
                text-decoration: none;
            }

            table {
                border-collapse: collapse !important;
            }

            div[style*="margin: 16px 0"] {
                margin: 0 !important;
                font-size: 100% !important;
            }

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }

            @media only screen and (max-width: 599px) {
                .content-table {
                    width: 100% !important;
                }

                img[class="img-max"] {
                    width: 100% !important;
                    height: auto !important;
                }

                table[class="mobile-button-wrap"] {
                    margin: 0 auto;
                    width: 100% !important;
                }

                a[class="mobile-button"] {
                    width: 80% !important;
                    padding: 8px !important;
                    border: 0 !important;
                }

                .mobile-align-center {
                    text-align: center !important;
                    margin-right: auto;
                    margin-left: auto;
                }
            }

            nav {
                position:fixed;
                top:0;
                color: #000;
                height:auto;
                width:100%;
                background: #ffffff;
                box-shadow:0 1px 15px #232323;
                z-index:10;
            }

            ul.social-button-group {
                padding-top: 15px;
            }

            ul.social-button-group li {
                display: inline-block;
            }

            ul.social-button-group li a {
                display: inline-block;
                line-height: 30px;
                height: 30px;
                width: 30px;
                font-size: 25px;
                text-align: center;
                color: #000000;
                background-color: #ffffff;
                -webkit-transition: all .3s;
                -moz-transition: all .3s;
                transition: all .3s;
                -o-transition: all .3s;
            }

            ul.social-button-group li.facebook-button:hover a,
            ul.social-button-group li.facebook-button:focus a,
            ul.social-button-group li.facebook-button:active a {
                color: #3b5998;
            }

            ul.social-button-group li.instagram-button:hover a,
            ul.social-button-group li.instagram-button:focus a,
            ul.social-button-group li.instagram-button:active a {
                color: #fb3958;
            }

            ul.social-button-group li.five-hundred-px-button:hover a,
            ul.social-button-group li.five-hundred-px-button:focus a,
            ul.social-button-group li.five-hundred-px-button:active a {
                color: #696969;
            }

            section {

            }

            footer {
                padding:15px;
                width:100%;
                background: #ffffff;
                position: absolute;
                right: 0;
                bottom: 0;
                left: 0;
            }

            footer .copyright {
                font-size: small;
                text-transform: uppercase;
            }

            footer .tag-line {
                font-size: small;
                text-transform: uppercase;
            }
        </style>

        <!-- Fonts -->
        <script src="https://use.fontawesome.com/b114e5fdf4.js"></script>
    </head>
    <body style="margin: 0 !important; padding: 0 !important;">
        <!-- Pre-Header -->
        <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;mso-hide:all;">
            Millman Photography
        </div>

        <!-- Header -->
        <header>
            <!-- Social Buttons -->
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
        </header>

        <?= $this->section('email') ?>

        <!-- Footer -->
        <footer>
                    <span class="tag-line">
                        Photography by Freddie John Millman
                    </span>
            <span class="copyright">
                        <i id="copyright" class="fa fa-copyright"></i>
                <?= date("Y"); ?> Freddie John Millman All Rights Reserved
                    </span>
        </footer>
    </body>
</html>
