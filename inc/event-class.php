<?php
// require_once __DIR__ . '\\event-module\\sample.php'; // Include the required classes
require_once __DIR__ . '\\event-module\\util.php' ; 
require_once get_stylesheet_directory() . '\\inc\\date-conversion.php' ; 

class Events
{
    // Initialize the class
    function __construct()
    {
        // Add new actions for each API request
        add_action('wp_ajax_create_event', [$this, 'create_event']);
        add_action('wp_ajax_get_shops', [$this, 'get_shops']);
        // add_action('wp_ajax_get_my_events', [$this, 'get_my_events']);
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
        // add_action('wp_ajax_get_stats', [$this, 'get_stats']);
        // add_action('wp_ajax_create_comment', [$this, 'create_comment']);
        // add_action('wp_ajax_get_all_comments', [$this, 'get_all_comments']);
        // add_action('wp_ajax_update_comment', [$this, 'update_comment']);
        // add_action('wp_ajax_get_all_rates', [$this, 'get_all_rates']);
        // add_action('wp_ajax_add_rate', [$this, 'add_rate']);
        // add_action('wp_ajax_update_rate', [$this, 'update_rate']);
        // add_action('wp_ajax_test', [$this, 'test_']);
    }



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

           
            $event_create_category = $_POST['event-create-category']; 
            $event_create_description = $_POST['event-create-description']; 
            

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
            // $result = EventService::createEvent($data);
            $result = EventUtil::callApi('events', $data, 'POST');
                  
            // $result = CallSample::createEvent();
            wp_send_json_success($result);


        
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }



    // Method to get shops by event ID
    public function get_shops()
    {
        $eventID = $_POST['eventID'];
        try {
            $result = EventUtil::callApi('shops/students?eventID='.$eventID, [], 'GET');
            $content = $this->selected_event($result);
            wp_send_json_success($content);
            // wp_send_json_success($result);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }
    
    public function fetch_user_meta($userId) {
        return [
            'full_name' => get_user_meta($userId, 'first_name', true) . " " .  get_user_meta($userId, 'last_name', true),
            'marriage' => get_user_meta($userId, '_instructor_marriage', true),
            'birth_date' => get_user_meta($userId, '_instructor_birth_date', true),
            'profile_pic' => get_user_meta($userId, '_instructor_profile_pic', true),
            'city' => get_user_meta($userId, '_instructor_city', true)
        ];
    }
    
    public function selected_event($students)
    {
        $default_thumbnail_src =
"data:/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI3NjAiIGhlaWdodD0iNDgwIiBmaWxsPSJub25lIj48cGF0aCBmaWxsPSIjRUZGMUY3IiBkPSJNMCAwaDc2MHY0ODBIMHoiLz48cGF0aCBmaWxsPSIjRTNFNkVCIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0zNDguOSAzMjAuNTdhMzAgMzAgMCAwIDAtNDIuNy0yLjFMMTMxIDQ3OS44MmgzNjBMMzQ4LjkgMzIwLjU3WiIgY2xpcC1ydWxlPSJldmVub2RkIi8+PHBhdGggZmlsbD0iI0MwQzNDQiIgZmlsbC1ydWxlPSJldmVub2RkIiBkPSJNNTQwLjk5IDIzOS44YTMwIDMwIDAgMCAwLTQ0LjA1LS4zNUwyNzEgNDc5LjgyaDQ4OC41MUw1NDAuOTkgMjM5LjhaIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIG9wYWNpdHk9Ii4zIi8+PHBhdGggZmlsbD0iI0NEQ0ZENSIgZmlsbC1ydWxlPSJldmVub2RkIiBkPSJNMTg2LjUgMTg4YTQ1LjUgNDUuNSAwIDEgMCAwLTkxIDQ1LjUgNDUuNSAwIDAgMCAwIDkxWiIgY2xpcC1ydWxlPSJldmVub2RkIi8+PC9zdmc+";


        $decoded = json_decode($students, true);
        if (json_last_error() !== JSON_ERROR_NONE) {    
            error_log(print_r("Error decoding JSON: " . json_last_error_msg(),true));
            return false;
        }
    
        if ($decoded['status'] !== 'success') {
            error_log(print_r("Response status is not 'success'.",true));
            return false;
        }
    
        $studentList = $decoded['data']['shops'];
        // Fetch user metadata from WordPress
        foreach ($studentList as &$student) {
            $student['meta'] = $this->fetch_user_meta($student['USERID']);
        }
        unset($student); 

        // error_log(print_r($studentList,true));

        
        ob_start();

        foreach ($studentList as $student) : ?>
            
            <div class="student-box" data-date="$student_registered_date">
                <div class="student-box-info">
                    <div class="student-box-info-avatar">
                        <img src="<?php echo !empty($student['meta']['profile_pic']) ? $student['meta']['profile_pic'] : $default_thumbnail_src ?>" alt="">
                    </div>
                    <h6 class="student-box-info-name"><?php echo $student['meta']['full_name'] ?></h6>
                </div>
                <div class="student-box-meta">
                    <div class="student-box-meta-top">

                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-2.svg' ?>" alt="">
                            <p> <?php echo jdate('Y/m/d', $student['createDateTime']) ?> </p>
                        </div>
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/location.svg' ?>" alt="">
                            <p> <?php echo $student['meta']['city'] ?> </p>
                        </div>
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/discount-circle.svg' ?>" alt="">
                            <?php echo array_key_exists('discountID', $student)?'کد تخفیف':'' ?>
                        </div>

                        
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                    </div>

                    <div class="student-box-meta-bottom">
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/heart-tick.svg' ?>" alt="">
                            <?php echo $student['meta']['marriage'] ?>
                        </div>
                        <div class="student-box-meta-item">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-circle.svg' ?>" alt="">
                            <?php echo $student['meta']['birth_date'] ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;

        $output = ob_get_clean();
        return $output;
    }

    // // Method to get my events
    // public function get_my_events()
    // {
    //     try {
    //         // $result = EventService::getMyEvents();
    //         $result = EventUtil::callApi('events/me', [], 'GET');
    //         wp_send_json_success($result);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }


    // // Method to get all events
    // public function get_all_events()
    // {
    //     try {
    //         $result = CallSample::getAllEvents();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to get a specific event
    // public function get_event()
    // {
    //     try {
    //         $result = CallSample::getEvent();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to update an event
    // public function update_event()
    // {
    //     try {
    //         $result = CallSample::updateEvent();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to delete an event
    // public function delete_event()
    // {
    //     try {
    //         $result = CallSample::deleteEvent();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to search for events
    // public function search_event()
    // {
    //     try {
    //         $result = CallSample::searchEvent();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to create a user
    // public function create_user()
    // {
    //     try {
    //         $result = CallSample::createUser();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to get all users
    // public function get_all_users()
    // {
    //     try {
    //         $result = CallSample::getAllUsers();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to update a user
    // public function update_user()
    // {
    //     try {
    //         $result = CallSample::updateUser();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to create a discount
    // public function create_discount()
    // {
    //     try {
    //         $result = CallSample::createDiscount();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to get all discounts by event ID
    // public function get_all_discounts_by_event()
    // {
    //     try {
    //         $result = CallSample::getAllDiscountsByEvent();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to get all tickets by event ID
    // public function get_all_tickets_by_event()
    // {
    //     try {
    //         $result = CallSample::getAllTicketsByEvent();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to create a shop
    // public function create_shop()
    // {
    //     try {
    //         $result = CallSample::createShop();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }


    // // Method to get stats
    // public function get_stats()
    // {
    //     try {
    //         $result = CallSample::getStats();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to create a comment
    // public function create_comment()
    // {
    //     try {
    //         $result = CallSample::createComment();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to get all comments with date filters
    // public function get_all_comments()
    // {
    //     try {
    //         $result = CallSample::getAllComments();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to update a comment
    // public function update_comment()
    // {
    //     try {
    //         $result = CallSample::updateComment();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to get all rates of events
    // public function get_all_rates()
    // {
    //     try {
    //         $result = CallSample::getAllRates();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to add a rate
    // public function add_rate()
    // {
    //     try {
    //         $result = CallSample::addRate();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }

    // // Method to update a rate
    // public function update_rate()
    // {
    //     try {
    //         $result = CallSample::updateRate();
    //         wp_send_json_success(['message' => $result]);
    //     } catch (Exception $e) {
    //         wp_send_json_error(['message' => $e->getMessage()]);
    //     }
    // }
}

$events = new Events();
?>
