<?php


class HttpClient
{
    public function get($url)
    {
        $response = @file_get_contents($url);
        if($response === false) {
            throw new \http\Exception\RuntimeException(error_get_last());
        }

        return $response;
    }
}