<?php

include 'classes/Location.php';

/**
 * Class Locator
 */
class IpGeoLocator implements Locator
{
    private $client;
    private $apiKey;

    public function __construct(HttpClient $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function locate(Ip $ip)
    {

        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query([
                'apiKey' => $this->apiKey,
                'ip' => $ip->getValue(),
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
            $data['country_name'],
            $data['state_prov'],
            $data['city']
        );
    }
}