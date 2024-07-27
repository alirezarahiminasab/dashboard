<?php

require_once __DIR__ . '\..\util.php' ; // Include the User class

class EventService
{    
  
    // Method to create an event
    public static function createEvent($data)
    {
        return EventUtil::callApi('events', $data, 'POST');
    }

    // Method to get my events
    public static function getMyEvents()
    {
        return EventUtil::callApi('events/me', [], 'GET');
    }

    // // Method to get all events
    // public static function getAllEvents()
    // {
    //     return EventUtil::callApi('events', [], 'GET');
    // }

    // // Method to get a single event by ID
    // public static function getEvent($eventId)
    // {
    //     return EventUtil::callApi("events/{$eventId}", [], 'GET');
    // }

    // // Method to update an event by ID
    // public static function updateEvent($eventId, $data)
    // {
    //     return EventUtil::callApi("events/{$eventId}", $data, 'PATCH');
    // }

    // // Method to delete an event by ID
    // public static function deleteEvent($eventId)
    // {
    //     return EventUtil::callApi("events/{$eventId}", [], 'DELETE');
    // }

    // // Method to search events
    // public static function searchEvent($name)
    // {
    //     return EventUtil::callApi("events/search?name={$name}", [], 'GET');
    // }
}

// Initialize the static properties
EventUtil::init();
