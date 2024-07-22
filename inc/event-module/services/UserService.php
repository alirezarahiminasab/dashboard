<?php
require_once __DIR__ . '\..\util.php' ; // Include the User class

class UserService
{

    // Method to create a user
    public static function createUser($data)
    {
        return EventUtil::callApi('users', $data, 'POST');
    }

    // Method to get all users
    public static function getAllUsers()
    {
        return EventUtil::callApi('users', [], 'GET');
    }

    // Method to update a user by ID
    public static function updateUser($userId, $data)
    {
        return EventUtil::callApi("users/{$userId}", $data, 'PATCH');
    }
}

// Initialize the static properties
EventUtil::init();
