<?php
require_once __DIR__ . '\..\util.php' ; // Include the User class

class TicketService
{
    private static $endpoint = 'http://events.services.hanil.life/';

    // Method to get all tickets by event ID
    public static function getAllTicketsByEvent($eventId)
    {
        return EventUtil::callApi("tickets/{$eventId}", [], 'GET');
    }
}

// Initialize the static properties
EventUtil::init();
