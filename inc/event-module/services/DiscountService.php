<?php
require_once __DIR__ . '\..\util.php' ; // Include the User class

class DiscountService
{

    // Method to create a discount
    public static function createDiscount($data)
    {
        return EventUtil::callApi('discounts', $data, 'POST');
    }

    // Method to get all discounts by event ID
    public static function getAllDiscountsByEvent($eventId)
    {
        return EventUtil::callApi("discounts/{$eventId}", [], 'GET');
    }
}

// Initialize the static properties
EventUtil::init();
