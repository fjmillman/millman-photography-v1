<?php declare(strict_types = 1);

namespace MillmanPhotography\Exception;

use Exception;

class UploadException extends Exception
{
    const INCORRECT_FILE_FORMAT = 9;

    /**
     * @param int $code
     */
    public function __construct(int $code) {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    /**
     * @param $code
     * @return string $message
     */
    private function codeToMessage($code) :string
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            case UPLOAD_ERR_FORM_SIZE:
                return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            case UPLOAD_ERR_PARTIAL:
                return "The uploaded file was only partially uploaded";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk";
            case UPLOAD_ERR_EXTENSION:
                return "File upload stopped by extension";
            case self::INCORRECT_FILE_FORMAT:
                return 'The file uploaded is not in the correct format.';
            default:
                return "Unknown upload error";
        }
    }
}
