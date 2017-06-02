<?php

namespace MillmanPhotography\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface as File;

use MillmanPhotography\Exception\UploadException;

class UploadController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $files = $request->getUploadedFiles();

        if (empty($files['file'])) {
            return $response->withStatus(404);
        }

        return $this->processFile($files['file'], $response);
    }

    private function processFile(File $file, Response $response)
    {
        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new UploadException($file['error']);
        }

        $filename = $file->getClientFilename();
        $file->moveTo('/asset/img/' . $filename);

        return $response->withStatus(302);
    }
}
