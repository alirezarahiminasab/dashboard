<?php
    require_once __DIR__ . '\..\util.php' ; // Include the User class

class CommentService
{
    // Method to create a comment
    public static function createComment($data)
    {
        return EventUtil::callApi('comments', $data, 'POST');
    }

    // Method to get all comments with date filters
    public static function getAllComments($dateFilters)
    {
        $filters = http_build_query($dateFilters);
        return EventUtil::callApi("comments?{$filters}", [], 'GET');
    }

    // Method to update a comment by ID
    public static function updateComment($commentId, $data)
    {
        return EventUtil::callApi("comments/{$commentId}", $data, 'PATCH');
    }
}

// Initialize the static properties
EventUtil::init();
