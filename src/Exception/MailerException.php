<?php declare(strict_types = 1);

namespace MillmanPhotography\Exception;

use Exception;

class MailerException extends Exception {

    /**
     * @param string $message
     */
    public function __construct($message) {
        parent::__construct($message);
    }
}
