<?php
    require_once __DIR__ . '\..\util.php' ; // Include the User class

class ShopService
{

    // Method to create a shop
    public static function createShop($data)
    {
        return EventUtil::callApi('shops', $data, 'POST');
    }

    // Method to get shops by event ID and additional parameters
    public static function getShops($eventId, $additionalParams)
    {
        $params = http_build_query($additionalParams);
        return EventUtil::callApi("shops?eventID={$eventId}&{$params}", [], 'GET');
    }

    // Method to get shop stats (this needs more details)
    public static function getStats()
    {
        return EventUtil::callApi('shops/stats', [], 'GET');
    }
}

// Initialize the static properties
EventUtil::init();
