<?php
    // require_once __DIR__ . '\\services\\CommentService.php' ; 
    // require_once __DIR__ . '\\services\\DiscountService.php' ; 
    require_once __DIR__ . '\\services\\EventService.php' ; 
    // require_once __DIR__ . '\\services\\RateService.php' ; 
    // require_once __DIR__ . '\\services\\ShopService.php' ; 
    // require_once __DIR__ . '\\services\\TicketService.php' ;
    // require_once __DIR__ . '\\services\\UserService.php' ; 

class CallSample
{
    public static function createEvent($data)
    {        
        $response = EventService::createEvent($data);
        return "Create Event Response: " . $response;
    }

    // public static function getAllEvents()
    // {
    //     $response = EventService::getAllEvents();
    //     return "Get All Events Response: " . $response;
    // }

    // public static function getEvent()
    // {
    //     $eventId = "666016494f7b7e1059691291";
    //     $response = EventService::getEvent($eventId);
    //     return "Get Event Response: " . $response;
    // }

    // public static function updateEvent()
    // {
    //     $eventId = "668502c42ec3ce41b450b991";
    //     $data = ["rate" => ["score" => 6]];
    //     $response = EventService::updateEvent($eventId, $data);
    //     return "Update Event Response: " . $response;
    // }

    // public static function deleteEvent()
    // {
    //     $eventId = "665c59ff12a8c81404b5c910";
    //     $response = EventService::deleteEvent($eventId);
    //     return "Delete Event Response: " . $response;
    // }

    // public static function searchEvent()
    // {
    //     $name = "li";
    //     $response = EventService::searchEvent($name);
    //     return "Search Event Response: " . $response;
    // }

    // public static function createUser()
    // {
    //     $data = [
    //         [
    //             "role" => "teacher",
    //             "name" => "Alireza",
    //             "userName" => "ali",
    //             "city" => "tehran",
    //             "professions" => ["react", "node"],
    //             "phoneNumber" => "09156151017",
    //             "ssn" => "092313423",
    //             "specialization" => "web development"
    //         ],
    //         [
    //             "role" => "student",
    //             "name" => "Hanie Maherani",
    //             "userName" => "Hanie_mah",
    //             "imageUrl" => "fjjdfxhjkkspwkgjk",
    //             "Age" => 19,
    //             "city" => "Isfahan",
    //             "phoneNumber" => "09917397824"
    //         ]
    //     ];

    //     $response = UserService::createUser($data);
    //     return "Create User Response: " . $response;
    // }

    // public static function getAllUsers()
    // {
    //     $response = UserService::getAllUsers();
    //     return "Get All Users Response: " . $response;
    // }

    // public static function updateUser()
    // {
    //     $userId = "6682b7398c0a4f932aa502f3";
    //     $data = ["phoneNumber" => "09381290081"];
    //     $response = UserService::updateUser($userId, $data);
    //     return "Update User Response: " . $response;
    // }

    // public static function createDiscount()
    // {
    //     $data = [
    //         "count" => 20,
    //         "title" => "کد تخفیف اول",
    //         "ticketID" => "665c726a6532926ac71f739f",
    //         "startDate" => "1397-1-1",
    //         "finishDate" => "1390-2-2",
    //         "price" => 20000
    //     ];

    //     $response = DiscountService::createDiscount($data);
    //     return "Create Discount Response: " . $response;
    // }

    // public static function getAllDiscountsByEvent()
    // {
    //     $eventId = "6666dc09c2bd889f279e9064";
    //     $response = DiscountService::getAllDiscountsByEvent($eventId);
    //     return "Get All Discounts by Event Response: " . $response;
    // }

    // public static function getAllTicketsByEvent()
    // {
    //     $eventId = "668bb7bc58f5584c3622d4ac";
    //     $response = TicketService::getAllTicketsByEvent($eventId);
    //     return "Get All Tickets by Event Response: " . $response;
    // }

    // public static function createShop()
    // {
    //     $data = [
    //         "ticketID" => "668502c72ec3ce41b450b997",
    //         "userID" => "6682b75d8c0a4f932aa502f5"
    //     ];

    //     $response = ShopService::createShop($data);
    //     return "Create Shop Response: " . $response;
    // }

    // public static function getShops()
    // {
    //     $eventId = "666016494f7b7e1059691291";
    //     $additionalParams = ["open[eventID]" => "title"];
    //     $response = ShopService::getShops($eventId, $additionalParams);
    //     return "Get Shops Response: " . $response;
    // }

    // public static function getStats()
    // {
    //     $response = ShopService::getStats();
    //     return "Get Stats Response: " . $response;
    // }

    // public static function createComment()
    // {
    //     $data = [
    //         "userID" => "6682b7398c0a4f932aa502f3",
    //         "eventID" => "668502c42ec3ce41b450b991",
    //         "text" => "کامنت دوم",
    //         "replyID" => "66891c52b1eef99d6d400f51"
    //     ];

    //     $response = CommentService::createComment($data);
    //     return "Create Comment Response: " . $response;
    // }

    // public static function getAllComments()
    // {
    //     $dateFilters = [
    //         "date[lte]" => "1403-3-21",
    //         "date[gte]" => "1403-3-20"
    //     ];

    //     $response = CommentService::getAllComments($dateFilters);
    //     return "Get All Comments Response: " . $response;
    // }

    // public static function updateComment()
    // {
    //     $commentId = "66769e2b2ed518aa1b63a956";
    //     $data = ["status" => "reject"];
    //     $response = CommentService::updateComment($commentId, $data);
    //     return "Update Comment Response: " . $response;
    // }

    // public static function getAllRates()
    // {
    //     $eventId = "66769afa2ed518aa1b63a7b3";
    //     $additionalParams = ["open[userID]" => null];
    //     $response = RateService::getAllRates($eventId, $additionalParams);
    //     return "Get All Rates Response: " . $response;
    // }

    // public static function addRate()
    // {
    //     $data = [
    //         "score" => 4,
    //         "eventID" => "66769afa2ed518aa1b63a7b3"
    //     ];

    //     $response = RateService::addRate($data);
    //     return "Add Rate Response: " . $response;
    // }

    // public static function updateRate()
    // {
    //     $rateId = "668b74222f8b22592fe3e418";
    //     $data = [
    //         "score" => 8,
    //         "eventID" => "66769afa2ed518aa1b63a7b3"
    //     ];

    //     $response = RateService::updateRate($rateId, $data);
    //     return "Update Rate Response: " . $response;
    // }
}

// Usage examples
// CallSample::createEvent();
// CallSample::getAllEvents();
// CallSample::getEvent();
// CallSample::updateEvent();
// CallSample::deleteEvent();
// CallSample::searchEvent();
// CallSample::createUser();
// CallSample::getAllUsers();
// CallSample::updateUser();
// CallSample::createDiscount();
// CallSample::getAllDiscountsByEvent();
// CallSample::getAllTicketsByEvent();
// CallSample::createShop();
// CallSample::getShops();
// CallSample::getStats();
// CallSample::createComment();
// CallSample::getAllComments();
// CallSample::updateComment();
// CallSample::getAllRates();
// CallSample::addRate();
// CallSample::updateRate();
