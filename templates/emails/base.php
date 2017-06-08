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
        <table>
            <tr class="pre-header">
                Millman Photography
            </tr>
            <tr class="header">
                <td colspan="2">
                    <img class="signature" src="<?= $cid ?>" alt="logo">
                </td>
            </tr>
            <?= $this->section('email') ?>
            <tr class="footer">
                <td class="tag-line">
                    Photography by Freddie John Millman
                </td>
                <td class="copyright">
                    &#169 <?= date("Y"); ?> Millman Photography All Rights Reserved
                </td>
            </tr>
        </table>
    </body>
</html>
