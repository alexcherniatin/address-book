<?php

namespace AddressBook\Core;

/**
 * Basic abstract controller
 */
abstract class Controller
{
    /**
     * Show json response
     *
     * @param array $body The body of response
     * @param int $code The http code of response
     *
     * @return void 
     */
    public function response(array $body, int $code = 200): void
    {
        $httpStatusCodeDetails = $this->httpStatusCodeDetails($code);

        header('Content-Type: application/json; charset=utf-8');

        header("HTTP/1.1 " . $httpStatusCodeDetails['code'] . " " . $httpStatusCodeDetails['text']);

        echo json_encode($body);
    }

    /**
     * Get http status by code
     *
     * @param int $code The http code
     *
     * @return array 
     */
    private function httpStatusCodeDetails(int $code): array
    {
        $statuses = [
            200 => 'OK',
            400 => 'Bad request',
            401 => 'Unauthorized',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];

        return ($statuses[$code]) ? ['code' => $code, 'text' => $statuses[$code]] : ['code' => 500, 'text' => $statuses[500]];
    }
}
