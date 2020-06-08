<?php

include 'classes/Location.php';

/**
 * Class Locator
 */
class IpInfoLocator implements Locator
{
    private $client;
    private $token;

    public function __construct(HttpClient $client, string $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    public function locate(Ip $ip)
    {

        $url = 'https://ip.io?' . http_build_query([
                'token' => $this->token,
                'ip' => $ip->getValue(), //TODO  to detalize this info
            ]);

        $response = $this->client->get($url);
        $data = json_decode($response, true);

        function func($value)
        {
            return $value !== '-' ? $value : null;
        }

        $data = array_map('func', $data);
        if (empty($data['country_name'])) {
            return null;
        }

        return new Location(
            $data['country'],
            $data['region'],
            $data['city']
        );
    }
}