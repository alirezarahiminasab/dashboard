<?php
// require_once __DIR__ . '\\event-module\\sample.php'; // Include the required classes
require_once __DIR__ . '\\event-module\\services\\EventService.php' ; 


class Events
{
    // Initialize the class
    function __construct()
    {
        // Add new actions for each API request
        add_action('wp_ajax_create_event', [$this, 'create_event']);
        add_action('wp_ajax_get_my_events', [$this, 'get_my_events']);
        // add_action('wp_ajax_get_event', [$this, 'get_event']);
        // add_action('wp_ajax_update_event', [$this, 'update_event']);
        // add_action('wp_ajax_delete_event', [$this, 'delete_event']);
        // add_action('wp_ajax_search_event', [$this, 'search_event']);
        // add_action('wp_ajax_create_user', [$this, 'create_user']);
        // add_action('wp_ajax_get_all_users', [$this, 'get_all_users']);
        // add_action('wp_ajax_update_user', [$this, 'update_user']);
        // add_action('wp_ajax_create_discount', [$this, 'create_discount']);
        // add_action('wp_ajax_get_all_discounts_by_event', [$this, 'get_all_discounts_by_event']);
        // add_action('wp_ajax_get_all_tickets_by_event', [$this, 'get_all_tickets_by_event']);
        // add_action('wp_ajax_create_shop', [$this, 'create_shop']);
        // add_action('wp_ajax_get_shops', [$this, 'get_shops']);
        // add_action('wp_ajax_get_stats', [$this, 'get_stats']);
        // add_action('wp_ajax_create_comment', [$this, 'create_comment']);
        // add_action('wp_ajax_get_all_comments', [$this, 'get_all_comments']);
        // add_action('wp_ajax_update_comment', [$this, 'update_comment']);
        // add_action('wp_ajax_get_all_rates', [$this, 'get_all_rates']);
        // add_action('wp_ajax_add_rate', [$this, 'add_rate']);
        // add_action('wp_ajax_update_rate', [$this, 'update_rate']);
        // add_action('wp_ajax_test', [$this, 'test_']);
    }


//    // Method to create an event
//    public function test_()
//    {
//        try {
//            $event_create_title = $_POST['event-create-title'];
           
//            // $result = CallSample::createEvent();
//            wp_send_json_success(['$event_create_title'=>$event_create_title]);
//        } catch (Exception $e) {
//            wp_send_json_error(['message' => $e->getMessage()]);
//        }
//    }

    public function upload_image($file_data,$file_name){
        $file_name = sanitize_file_name($file_name);

        // Decode the base64 file data
        $file_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file_data));

        // Get the WordPress upload directory
        $upload_dir = wp_upload_dir();
        $unique_file_name = wp_unique_filename($upload_dir['path'], $file_name);
        $upload_path = $upload_dir['path'] . '/' . $unique_file_name;

        // Save the file
        if (file_put_contents($upload_path, $file_data) !== false) {
            // Get the uploaded file's URL
            $uploaded_url = $upload_dir['url'] . '/' . $unique_file_name;
            return $uploaded_url;
            
        }
        return "";
    }

        // Method to create an event
    public function create_event()
    {
        try {
            $event_create_cover_URL = "";
            if(isset($_POST['event-create-cover-data'])){
                $event_create_cover_data = $_POST['event-create-cover-data']; 
                $event_create_cover_fileName = $_POST['event-create-cover-fileName']; 
                $event_create_cover_URL = $this->upload_image($event_create_cover_data,$event_create_cover_fileName);
            }
            
 
            $event_create_tags = $_POST['event-create-tags']; 
            $event_create_title = $_POST['event-create-title']; 

            $event_create_start_dateTime = $_POST['event-create-start-dateTime']; 
            $event_create_finish_dateTime = $_POST['event-create-finish-dateTime']; 
            // $event_create_session_start_dateTime = $_POST['event-create-session-start-dateTime']; 
            // $event_create_session_finish_dateTime = $_POST['event-create-session-finish-dateTime']; 
            $event_create_sale_start_dateTime = $_POST['event-create-sale-start-dateTime']; 
            $event_create_sale_finish_dateTime = $_POST['event-create-sale-finish-dateTime']; 

            // $event_create_session_title = $_POST['event-create-session-title']; 
            // $event_create_platform_link = $_POST['event-create-platform-link']; 
            $event_create_ticket_title = $_POST['event-create-ticket-title']; 
            $event_create_ticket_number = $_POST['event-create-ticket-number']; 
            $event_create_ticket_price = $_POST['event-create-ticket-price']; 
            $event_create_companion_name = $_POST['event-create-companion-name']; 
            
            $event_create_category = $_POST['event-create-category']; 
            $event_create_description = $_POST['event-create-description']; 
            // $event_create_session_description = $_POST['event-create-session-description']; 
            // $event_create_platform = $_POST['event-create-platform']; 
            

            $sessionsCards = json_decode(stripslashes($_POST['sessions']), true);
            
            $sessions = [];
            foreach ($sessionsCards as $card) {
                $sessions[] = [
                    "title" => $card['sessionTitleValue'],
                    "description" => $card['sessionDescription'],
                    "startDateTime" => $card['sessionStartUnix'],
                    "finishDateTime" => $card['sessionFinishUnix'],
                    "platform" => $card['sessionPlatformValue'],
                    "classUrl" => $card['sessionClassUrl']
                ];
            }            

            $companionsCards = json_decode(stripslashes($_POST['companions']), true);
            $companions = [];
            foreach ($companionsCards as $card) {
                $companion = ["name" => $card['companionName']];
                if($card['companionName'] !== ""){
                    $event_create_companion_logo_URL = $this->upload_image($card['companionLogo'],$card['companionLogoName']);
                    $companion["logoURL"] = $event_create_companion_logo_URL;
                }
                $companions[] = $companion;
            }

            $ticketsCards = json_decode(stripslashes($_POST['tickets']), true);
            $tickets = [];
            foreach ($ticketsCards as $card) {
                $tickets[] = [
                    "count" => $card['ticketNumber'],
                    "title" => $card['ticketTitle'],
                    "startDateTime" => $card['saleStartDate'],
                    "finishDateTime" => $card['saleFinishDate'],
                    "price" => $card['ticketPrice']
                ];
            }

            $data = [
                "title" => $event_create_title,
                "category" => $event_create_category,
                "tags" => explode("-", $event_create_tags),
                "imageURL" => $event_create_cover_URL,
                "description" => $event_create_description,
                "startDateTime" => $event_create_start_dateTime,
                "finishDateTime" => $event_create_finish_dateTime,
                "isOnline" => true,
                // "province": "تهران",
                // "city": "تهران",            
                "sessions" => $sessions,
                "tickets" => $tickets,
                "companions" => $companions 
            ];
            $result = EventService::createEvent($data);
            // $result = CallSample::createEvent($data);
            
            // $data = array(
            // 'test' => $test,
            // 'event_create_title' => $event_create_title,
            // 'event_create_cover' => $event_create_cover_URL,
            // // 'event_create_start_date' => $event_create_start_date,
            // // 'event_create_start_time' => $event_create_start_time,
            // // 'event_create_finish_date' => $event_create_finish_date,
            // // 'event_create_finish_time' => $event_create_finish_time,
            // 'event_create_session_title' => $event_create_session_title,
            // // 'event_create_session_date' => $event_create_session_date,
            // // 'event_create_session_start_time' => $event_create_session_start_time,
            // // 'event_create_session_finish_time' => $event_create_session_finish_time,
            // 'event_create_platform_link' => $event_create_platform_link,
            // 'event_create_ticket_title' => $event_create_ticket_title,
            // 'event_create_ticket_number' => $event_create_ticket_number,
            // 'event_create_ticket_price' => $event_create_ticket_price,
            // // 'event_create_sale_start_date' => $event_create_sale_start_date,
            // // 'event_create_sale_finish_date' => $event_create_sale_finish_date,
            // 'event_create_companion_name' => $event_create_companion_name,
            // 'event_create_companion_logo' => $event_create_companion_logo_URL,

            // 'event_create_category' => $event_create_category,
            // 'event_create_tags' => $event_create_tags,
            // 'event_create_description' => $event_create_description,
            // 'event_create_session_description' => $event_create_session_description,
            // 'event_create_platform' => $event_create_platform);
        
            
            // $result = CallSample::createEvent();
            wp_send_json_success($result);


        
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }


    // Method to get all events
    public function get_my_events()
    {
        try {
            $result = EventService::getMyEvents();
            wp_send_json_success($result);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get all events
    public function get_all_events()
    {
        try {
            $result = CallSample::getAllEvents();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get a specific event
    public function get_event()
    {
        try {
            $result = CallSample::getEvent();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to update an event
    public function update_event()
    {
        try {
            $result = CallSample::updateEvent();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to delete an event
    public function delete_event()
    {
        try {
            $result = CallSample::deleteEvent();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to search for events
    public function search_event()
    {
        try {
            $result = CallSample::searchEvent();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to create a user
    public function create_user()
    {
        try {
            $result = CallSample::createUser();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get all users
    public function get_all_users()
    {
        try {
            $result = CallSample::getAllUsers();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to update a user
    public function update_user()
    {
        try {
            $result = CallSample::updateUser();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to create a discount
    public function create_discount()
    {
        try {
            $result = CallSample::createDiscount();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get all discounts by event ID
    public function get_all_discounts_by_event()
    {
        try {
            $result = CallSample::getAllDiscountsByEvent();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get all tickets by event ID
    public function get_all_tickets_by_event()
    {
        try {
            $result = CallSample::getAllTicketsByEvent();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to create a shop
    public function create_shop()
    {
        try {
            $result = CallSample::createShop();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get shops by event ID
    public function get_shops()
    {
        try {
            $result = CallSample::getShops();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get stats
    public function get_stats()
    {
        try {
            $result = CallSample::getStats();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to create a comment
    public function create_comment()
    {
        try {
            $result = CallSample::createComment();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get all comments with date filters
    public function get_all_comments()
    {
        try {
            $result = CallSample::getAllComments();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to update a comment
    public function update_comment()
    {
        try {
            $result = CallSample::updateComment();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to get all rates of events
    public function get_all_rates()
    {
        try {
            $result = CallSample::getAllRates();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to add a rate
    public function add_rate()
    {
        try {
            $result = CallSample::addRate();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    // Method to update a rate
    public function update_rate()
    {
        try {
            $result = CallSample::updateRate();
            wp_send_json_success(['message' => $result]);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }
}

$events = new Events();
?>
