<?php


class ChainLocator implements Locator
{
    private $locators;

    public function __construct(Locator ...$locators)
    {
        $this->locators = $locators;
    }

    public function locate(Ip $ip)
    {
        foreach ($this->locators as $locator) {
            $location = $locator->locate($ip);
            if ($location !== null) {
                return $location;
            }
        }
        return null;
    }
}