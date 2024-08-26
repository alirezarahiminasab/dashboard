<?php
require_once __DIR__ . '\\event-module\\util.php' ; 
require_once get_stylesheet_directory() . '\\inc\\date-conversion.php' ; 

class Events
{
    function __construct() {
        add_action('wp_ajax_create_event', [$this, 'create_event']);
        add_action('wp_ajax_get_shops', [$this, 'get_shops']);
        add_action('wp_ajax_get_stats', [$this, 'get_stats']);
        add_action('wp_ajax_delete_event', [$this, 'delete_event']);
    }

    public function delete_event() {
        $eventID = $_POST['eventID'];
        try {
            $result = EventUtil::callApi('events/'.$eventID, [], 'DELETE');
            wp_send_json_success($result);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }

    public function get_shops() {
        $eventID = $_POST['eventID'];
        try {
            $result = EventUtil::callApi('shops/students?eventID='.$eventID, [], 'GET');
            $content = $this->selected_event($result);
            wp_send_json_success($content);
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }



    public function get_stats() {
        $sort = $_POST['sort'];
        ob_start(); // Start output buffering

        try {
            // Call the API to fetch the stats based on the sorting criteria
            $result = EventUtil::callApi('shops/stats?sort='.$sort, [], 'GET');
            $decoded = json_decode($result, true);

            if ($decoded && $decoded['status'] === 'success') {
                $results = $decoded['data']['stats'];

                // Generate the HTML for the statistics table rows
                if (is_array($results) && count($results)) : 
                    foreach ($results as $event) : 
                        ?>
                        <div class="event-statistics-footer-item" data-students="<?php echo $event['count'] ?>">
                            <span>
                                <p>
                                    <?php echo $event['title'] ?>
                                </p>
                            </span>
                            <span>
                                <p>
                                    <?php echo $event['count'] ?>
                                </p>
                            </span>
                            <span>
                                <p>
                                    <?php echo $event['totalIncome'] ?>
                                </p>
                            </span>
                        </div>
                        <?php 
                    endforeach; 
                endif;
            } else {
                // Handle API error
                echo '<p>' . esc_html__('Error fetching data.', 'edumall-child') . '</p>';
            }
        } catch (Exception $e) {
            // Handle exception
            echo '<p>' . esc_html__('An error occurred: ', 'edumall-child') . $e->getMessage() . '</p>';
        }

        $html = ob_get_clean(); // Capture the output buffer and clean it
        wp_send_json_success(['html' => $html]); // Send the HTML as a JSON response
    }

    public function create_event() {
        try {
            $event_create_cover_URL = "";
            $event_create_cover_data = $_POST['event-create-cover-data']; 
            $event_create_cover_fileName = $_POST['event-create-cover-fileName']; 

            if($event_create_cover_fileName === "from_database" || $event_create_cover_fileName === "empty" ){
                $event_create_cover_URL = $event_create_cover_data;
            } else {
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
                // if(!empty($card['companionLogoName']) && strpos($card['companionLogoName'], 'wp-content/upload') === false){
                if($card['companionLogoName'] === "from_database"){
                    $companion["logoURL"] = $card['companionLogo'];
                } elseif($card['companionLogoName'] === ""){
                    $event_create_companion_logo_URL = "";
                } else {
                    $companion["logoURL"] = $this->upload_image($card['companionLogo'],$card['companionLogoName']);;
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
            if($_POST['is_edit']==="true"){
                $result = EventUtil::callApi('events/'.$_POST['eventID'], $data, 'PATCH');
            } else {
                $result = EventUtil::callApi('events', $data, 'POST');
            }
            wp_send_json_success($result);
        
        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }


    public function upload_image($file_data,$file_name) {
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
}

$events = new Events();
?>
