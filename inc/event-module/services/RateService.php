<?php
    require_once __DIR__ . '\..\util.php' ; // Include the User class

class RateService
{
    // Method to get all rates of events
    public static function getAllRates($eventId, $additionalParams)
    {
        $params = http_build_query($additionalParams);
        return EventUtil::callApi("rates/{$eventId}?{$params}", [], 'GET');
    }

    // Method to add a rate
    public static function addRate($data)
    {
        return EventUtil::callApi('rates', $data, 'POST');
    }

    // Method to update a rate by ID
    public static function updateRate($rateId, $data)
    {
        return EventUtil::callApi("rates/{$rateId}", $data, 'PATCH');
    }
}

// Initialize the static properties
EventUtil::init();
