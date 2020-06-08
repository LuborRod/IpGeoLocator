<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//require 'Location.php';
require 'IpGeoLocator.php';
require 'IpInfoLocator.php';
require 'classes/Ip.php';

$handler = new ErrorHandler(new Logger());
$client = new HttpClient();
$cache = new Cache();
$locator = new ChainLocatorAdvanced(
    new CacheLocator(
        new MuteLocator(
            new IpGeoLocator($client, '0f190b8112b941fc963fed0ead6e1b62'),
            $handler
        ),
        $cache,
        'cache_1',
        3600
    ),
    new CacheLocator(
        new MuteLocator(
            new IpInfoLocator($client, '3e18a87bc15fe0'),
            $handler
        ),
        $cache,
        'cache_2',
        3600
    )
);

$location = $locator->locate(new Ip($ip));
