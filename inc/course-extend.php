<?php


namespace CourseExtend;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Edumall_Tutor;
use Exception;

define('AWS_ACCESS_KEY_ID', '9bad323b-38bf-451e-a224-c999cf54719b');
define('AWS_SECRET_ACCESS_KEY', '0f1ac9754be7930756b1db0f05cea93ae289d3b64203e24b35aa9813ee4ae21d');
define('AWS_BUCKET_NAME', 'hanil');
define('AWS_REGION', 'ir-thr-at1'); // e.g., 'us-east-1'
define('AWS_ENDPOINT', 'https://s3.ir-thr-at1.arvanstorage.ir'); // e.g., 'us-east-1'

$client = new S3Client([
    'region' => AWS_REGION,
    'version' => '2006-03-01',
    'endpoint' => AWS_ENDPOINT,
    'credentials' => [
        'key' => AWS_ACCESS_KEY_ID,
        'secret' => AWS_SECRET_ACCESS_KEY
    ],
    // Set the S3 class to use objects. arvanstorage.ir/bucket
    // instead of bucket.objects. arvanstorage.ir
    'use_path_style_endpoint' => true
]);

class CourseExtend
{
    // Define the meta key for FAQ fields
    private $merchantCode = "fb482232-633d-4cc0-b5dd-489b8a2f0cd1";
    // Initialize the class
    function __construct()
    {
        add_action('wp_ajax_like_course', [$this, 'like_course']);

        add_action('wp_ajax_place_rating', [$this, 'place_rating']);

        add_action('wp_ajax_add_to_cart', [$this, 'add_to_cart']);
        add_action('wp_ajax_nopriv_add_to_cart', [$this, 'add_to_cart']);

        add_action('wp_ajax_send_verification_code', [$this, 'send_verification_code']);
        add_action('wp_ajax_nopriv_send_verification_code', [$this, 'send_verification_code']);

        add_action('wp_ajax_save_user_meta', [$this, 'save_user_meta']);
        add_action('wp_ajax_nopriv_save_user_meta', [$this, 'save_user_meta']);

        add_action('wp_ajax_save_user_favorites', [$this, 'save_user_favorites']);
        add_action('wp_ajax_nopriv_save_user_favorites', [$this, 'save_user_favorites']);

        add_action('wp_ajax_child_user_login', [$this, 'child_user_login']);
        add_action('wp_ajax_nopriv_child_user_login', [$this, 'child_user_login']);

        add_action('wp_ajax_like_course', [$this, 'like_course']);
        add_action('wp_ajax_nopriv_like_course', [$this, 'like_course']);

        add_action('init', [$this, 'create_ticket_post_type']);

        add_action('init', [$this, 'enable_comments_for_tickets']);

        add_action('admin_post_submit_ticket', [$this, 'handle_ticket_submission']);
        add_action('admin_post_nopriv_submit_ticket', [$this, 'handle_ticket_submission']);

        add_filter('preprocess_comment', [$this, 'auto_approve_ticket_comments']);

        add_action('add_meta_boxes', [$this, 'support_meta_boxes']);

        add_action('save_post', [$this, 'save_admin_reply_metabox']);


        add_action('wp_ajax_submit_ticket_comment', [$this, 'handle_submit_ticket_comment']);
        add_action('wp_ajax_nopriv_submit_ticket_comment', [$this, 'handle_submit_ticket_comment']);

        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_ticket_script']);

        add_action('wp_ajax_save_admin_reply', [$this, 'handle_save_admin_reply']);

        add_action('wp_ajax_save_user_metadata', array($this, 'save_user_metadata'));
        add_action('wp_ajax_nopriv_save_user_metadata', array($this, 'save_user_metadata'));

        add_action('wp_ajax_save_bookmark', array($this, 'bookmark_course'));

        add_filter('wp_get_attachment_url', [$this, 'rewrite_attachment_url'], 10, 2);
        add_filter('wp_get_attachment_metadata', [$this, 'rewrite_attachment_metadata'], 10, 2);
        add_filter('wp_handle_upload', [$this, 'handle_upload']);

        add_action('wp_ajax_create_order_on_cart_page', [$this, 'create_order_on_cart_page']);
        add_action('wp_ajax_nopriv_create_order_on_cart_page', [$this, 'create_order_on_cart_page']);

        add_action('wp_ajax_save_user_accountant', [$this, 'save_user_accountant']);
        add_action('wp_ajax_nopriv_save_user_accountant', [$this, 'save_user_accountant']);

        add_action('wp_ajax_get_courses_prerequisites', [$this, 'get_courses_prerequisites']);
        add_action('wp_ajax_nopriv_get_courses_prerequisites', [$this, 'get_courses_prerequisites']);
    }

    public function get_courses_prerequisites()
    {
        $course_name = sanitize_text_field($_POST['courseName']);
        $courses_exist = isset($_POST['existCourse']) ? $_POST['existCourse'] : array();

        $courses_exist_arr = explode(',', $courses_exist);

        $courses_pre = get_posts(array(
            's' => $course_name,
            'post_type' => 'courses',
            'post__not_in' => $courses_exist_arr,
            'posts_per_page' => -1, // Retrieve all posts
            'post_status' => 'publish', // Only retrieve published posts
        ));

        if (!empty($courses_pre)) :
            wp_send_json_success(['courses' => $courses_pre]);
        else :
            wp_send_json_error('خطای نامشخص');
        endif;
    }

    public function save_user_accountant()
    {
        $instructor_id = !empty($_POST['userID']) ? sanitize_text_field($_POST['userID']) : get_current_user_id();
        $instructor_bank_name = sanitize_text_field($_POST['bankName']);
        $instructor_account_number = sanitize_text_field($_POST['accountNumber']);
        $instructor_account_shaba = sanitize_text_field($_POST['accountShaba']);
        $instructor_first_name = sanitize_text_field($_POST['accountFirstName']);
        $instructor_last_name = sanitize_text_field($_POST['accountLastName']);
        $instructor_deposit_id = sanitize_text_field($_POST['accountDepositID']);

        try {
            update_user_meta($instructor_id, '_instructor_bank_name', $instructor_bank_name);
            update_user_meta($instructor_id, '_instructor_account_number', $instructor_account_number);
            update_user_meta($instructor_id, '_instructor_account_shaba', $instructor_account_shaba);
            update_user_meta($instructor_id, '_instructor_first_name', $instructor_first_name);
            update_user_meta($instructor_id, '_instructor_last_name', $instructor_last_name);
            update_user_meta($instructor_id, '_instructor_deposit_id', $instructor_deposit_id);
            wp_send_json_success(array(
                "result" => true
            ));
        } catch (Exception $e) {
            wp_send_json_error(array(
                "result" => $e
            ));
        }
    }

    public static function complete_course_enroll($order_id)
    {
        if (!CourseExtend::is_tutor_order($order_id)) {
            return;
        }

        global $wpdb;

        $enrolled_ids_with_course = CourseExtend::get_course_enrolled_ids_by_order_id($order_id);
        if ($enrolled_ids_with_course) {
            $enrolled_ids = wp_list_pluck($enrolled_ids_with_course, 'enrolled_id');

            if (is_array($enrolled_ids) && count($enrolled_ids)) {
                foreach ($enrolled_ids as $enrolled_id) {
                    $wpdb->update($wpdb->posts, array('post_status' => 'completed'), array('ID' => $enrolled_id));
                }
            }
        }
    }

    public static function is_tutor_order($order_id)
    {
        return get_post_meta($order_id, '_is_tutor_order_for_course', true);
    }

    public static function get_course_enrolled_ids_by_order_id($order_id)
    {
        global $wpdb;

        if ('wc' === tutor_utils()->get_option('monetize_by')) {
            // phpcs:disable WordPress.DB.PreparedSQLPlaceholders.LikeWildcardsInQuery
            $courses_ids = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT *
					FROM 	{$wpdb->prefix}wc_orders_meta
					WHERE	order_id = %d
							AND meta_key LIKE '_tutor_order_for_course_id_%'",
                    $order_id
                )
            );
        } else {
            $courses_ids = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT *
					FROM 	{$wpdb->postmeta}
					WHERE	post_id = %d
							AND meta_key LIKE '_tutor_order_for_course_id_%'
				",
                    $order_id
                )
            );
        }
        // phpcs:enable WordPress.DB.PreparedSQLPlaceholders.LikeWildcardsInQuery

        if (is_array($courses_ids) && count($courses_ids)) {
            $course_enrolled_by_order = array();
            foreach ($courses_ids as $courses_id) {
                $course_id                  = str_replace('_tutor_order_for_course_id_', '', $courses_id->meta_key);
                $course_enrolled_by_order[] = array(
                    'course_id'   => $course_id,
                    'enrolled_id' => $courses_id->meta_value,
                    'order_id'    => $courses_id->post_id ?? $courses_id->order_id,
                );
            }
            return $course_enrolled_by_order;
        }
        return false;
    }

    public function SendRequestToZarinPal($action, $params)
    {
        try {
            $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/' . $action . '.json');
            curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params)
            ));
            $result = curl_exec($ch);
            return json_decode($result, true);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function Send_to_ZarinPal_Gateway($order_id, $courses_ids)
    {
        global $woocommerce;
        $woocommerce->session->order_id_zarinpal = $order_id;
        $order = new \WC_Order($order_id);
        $currency = $order->get_currency();
        $currency = apply_filters('WC_ZPal_Currency', $currency, $order_id);

        $Amount = intval($order->get_total());
        $Amount = apply_filters('woocommerce_order_amount_total_IRANIAN_gateways_before_check_currency', $Amount, $currency);
        $strToLowerCurrency = strtolower($currency);

        if (strtolower($currency) === strtolower('IRHT')) {
            $Amount *= 1000;
        } else if (strtolower($currency) === strtolower('IRHR')) {
            $Amount *= 100;
        }
        /*else if (strtolower($currency) === strtolower('IRR')) {
           $Amount /= 10;
       }*/
        update_post_meta($order_id, '_is_tutor_order_for_course', true);


        $Amount = apply_filters('woocommerce_order_amount_total_IRANIAN_gateways_after_check_currency', $Amount, $currency);
        $Amount = apply_filters('woocommerce_order_amount_total_IRANIAN_gateways_irt', $Amount, $currency);
        $Amount = apply_filters('woocommerce_order_amount_total_ZarinPal_gateway', $Amount, $currency);

        $scheme = 'https';

        $CallbackUrl = add_query_arg(['wc_order' => $order_id, "course" => wp_json_encode($courses_ids)], trailingslashit(home_url('/cart/', $scheme)));

        $products = array();
        $order_items = $order->get_items();
        foreach ($order_items as $product) {
            $products[] = $product['name'] . ' (' . $product['qty'] . ') ';
        }
        $products = implode(' - ', $products);

        $Description = 'خرید به شماره سفارش : ' . $order->get_order_number() . ' | خریدار : ' . $order->get_billing_first_name()  . ' ' . $order->get_billing_last_name();
        $Mobile = $order->get_billing_phone();
        $Email = $order->get_billing_email();
        $Payer = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $ResNumber = (int)$order->get_order_number();

        //Hooks for iranian developer
        $Description = apply_filters('WC_ZPal_Description', $Description, $order_id);
        $Mobile = apply_filters('WC_ZPal_Mobile', $Mobile, $order_id);

        $Email = apply_filters('WC_ZPal_Email', $Email, $order_id);
        $Payer = apply_filters('WC_ZPal_Paymenter', $Payer, $order_id);
        $ResNumber = apply_filters('WC_ZPal_ResNumber', $ResNumber, $order_id);
        do_action('WC_ZPal_Gateway_Payment', $order_id, $Description, $Mobile);
        $Email = !filter_var($Email, FILTER_VALIDATE_EMAIL) === false ? $Email : '';


        if (preg_match('/^(\+989|989|\+9809|9809)([0-9]{9})$/i', $Mobile, $matches)) {
            $Mobile = '09' . $matches[2];
        } elseif (preg_match('/^9[0-7]{1}[0-9]{8}$/i', $Mobile)) {
            $Mobile = preg_replace('/^9/', '0$0', $Mobile);
        } else {
            $Mobile = preg_match('/^09[0-7]{1}[0-9]{8}$/i', $Mobile) ? $Mobile : '';
        }

        if (strtolower($currency) === strtolower('IRR')) {

            $data = array(
                'merchant_id' => $this->merchantCode,
                'amount' => $Amount,
                'callback_url' => $CallbackUrl,
                'description' => $Description,
                "currency" => "IRR",

                "metadata" => ["order_id" => "سفارش شماره $order_id"]
            );

            if ($Mobile) {
                $data['metadata']['mobile'] = $Mobile;
            }
            if ($Email) {
                $data['metadata']["email"] = $Email;
            }
        } else if (
            ($strToLowerCurrency === strtolower('IRT')) ||
            ($strToLowerCurrency === strtolower('TOMAN')) ||
            $strToLowerCurrency === strtolower('Iran TOMAN') ||
            $strToLowerCurrency === strtolower('Iranian TOMAN') ||
            $strToLowerCurrency === strtolower('Iran-TOMAN') ||
            $strToLowerCurrency === strtolower('Iranian-TOMAN') ||
            $strToLowerCurrency === strtolower('Iran_TOMAN') ||
            $strToLowerCurrency === strtolower('Iranian_TOMAN') ||
            $strToLowerCurrency === strtolower('IRHT')  ||
            $strToLowerCurrency === strtolower('تومان') ||
            $strToLowerCurrency === strtolower('IRHR') ||
            $strToLowerCurrency === strtolower(
                'تومان ایران'
            )
        ) {
            $data = array(
                'merchant_id' => $this->merchantCode,
                'amount' => $Amount,
                'callback_url' => $CallbackUrl,
                'description' => $Description,
                "currency" => "IRT",

                "metadata" => ["order_id" => "سفارش شماره $order_id"]
            );

            if ($Mobile) {
                $data['metadata']['mobile'] = $Mobile;
            }
            if ($Email) {
                $data['metadata']["email"] = $Email;
            }
        }

        $result = $this->SendRequestToZarinPal('request', json_encode($data));

        if ($result === false) {
            return esc_html('cURL Error #:');
        } else if ($result['data']['code'] == 100) {
            return "https://www.zarinpal.com/pg/StartPay/" . $result['data']["authority"];
        } else {

            $Message = ' تراکنش ناموفق بود- کد خطا : ' . $result['errors']['code'];

            return $Message;
        }
    }

    public function create_order_on_cart_page()
    {
        // Check for nonce security
        check_ajax_referer('create_order_nonce', 'security');

        // Create a new order
        $order = wc_create_order();
        $courses_ids = [];

        // Add products to the order
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            $courses_ids[] = tutor_utils()->product_belongs_with_course($product_id)->post_id;
            $order->add_product(wc_get_product($product_id), $quantity);
        }

        // Calculate totals
        $order->calculate_totals();

        // Update the order status
        $order->update_status('pending', 'Order created on the cart page.');

        $payment_url = $this->Send_to_ZarinPal_Gateway($order->get_id(), $courses_ids);

        if ($payment_url) {
            wp_send_json_success(array(
                'order_id'    => $order->get_id(),
                'payment_url' => $payment_url,
            ));
        } else {
            wp_send_json_error('Failed to initiate payment.');
        }
    }

    public static function get_instructor_video_story($user_id)
    {
        global $client;

        $file_format = '.mp4';
        // Construct the file name based on user ID
        $file_name = 'user_' . $user_id . '_story' . $file_format;

        $bucket = 'hanil';

        try {
            $checkFileExist = $client->doesObjectExist($bucket, $file_name);

            if (boolval($checkFileExist)) :

                $resp = $client->headObject([
                    'Bucket' => $bucket,
                    'Key' => $file_name,
                ]);

                return ['url' => 'https://s3.ir-thr-at1.arvanstorage.ir/hanil/' . $file_name, 'name' => $file_name, 'format' => $file_format, 'fileSize' => $resp['ContentLength'], 'result' => boolval($checkFileExist)];

            else :
                return ['result' => boolval($checkFileExist)];
            endif;
        } catch (AwsException $e) {
            // output error message if fails
            return ['result' => false];
        }
    }

    public function rewrite_attachment_metadata($data, $attachment_id)
    {
        $file_path = get_post_meta($attachment_id, 'attached_file_size', true);
        $data['filesize'] = $file_path;
        return $data;
    }

    public function get_bookmarks(string $type)
    {
        global $wpdb;

        $user_id          = get_current_user_id();

        $page_posts = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                FROM	{$wpdb->usermeta}
                WHERE 	user_id = %d
                        AND meta_key = '_tutor_{$type}_bookmark'
			",
                $user_id,
            ),
            OBJECT
        );

        return $page_posts;
    }

    public function upload_to_s3($file)
    {
        $s3 = new S3Client([
            'version' => '2006-03-01',
            'region'  => AWS_REGION,
            'endpoint' => AWS_ENDPOINT,
            'credentials' => [
                'key'    => AWS_ACCESS_KEY_ID,
                'secret' => AWS_SECRET_ACCESS_KEY,
            ],
        ]);

        // Generate the file path based on the current date and a unique identifier
        $upload_dir = wp_upload_dir();
        $subdir = $upload_dir['subdir'];
        $filename = basename($file['file']);
        $unique_id = uniqid(); // Generate a unique ID
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename_without_ext = pathinfo($filename, PATHINFO_FILENAME);
        $new_filename = $filename_without_ext . '-' . $unique_id . '.' . $ext;
        $key = ltrim($subdir . '/' . $new_filename, '/');

        try {
            $result = $s3->putObject([
                'Bucket' => AWS_BUCKET_NAME,
                'Key'    => $key,
                'SourceFile' => $file['file'],
                'ACL'    => 'public-read',
            ]);

            // Optional: delete the local file if upload is successful
            unlink($file['file']);

            return array('url' => $result['ObjectURL'], 'name' => $key);
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function handle_upload($file)
    {
        if (str_starts_with($file['type'], 'image/')) {
            return $file; // No need to do anything, the file is already uploaded locally
        } else {
            // Upload to S3
            $uploaded_url = $this->upload_to_s3($file);
            if ($uploaded_url) {
                $file['url'] = $uploaded_url['url'];
                $file['file'] = str_replace(wp_upload_dir()['basedir'], '', $uploaded_url['name']);
                // Save the new file name in post meta
                // Find or create the attachment ID
                $attachment_id = attachment_url_to_postid($file['url']);
                if (!$attachment_id) {
                    // Create the attachment post
                    $filetype = wp_check_filetype(basename($file['file']), null);
                    $attachment = array(
                        'guid' => $uploaded_url['url'],
                        'post_mime_type' => $filetype['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );

                    // Insert the attachment
                    $attachment_id = wp_insert_attachment($attachment, $file['file']);
                    // Generate attachment metadata and update the database record
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attachment_id, $file['file']);
                    wp_update_attachment_metadata($attachment_id, $attach_data);
                }

                // Update attachment metadata with S3 info
                update_post_meta($attachment_id, '_wp_attached_file', $uploaded_url['name']);
                // Update attachment URL
                update_post_meta($attachment_id, '_wp_attachment_metadata', [
                    's3' => $uploaded_url['url']
                ]);

                return $file;
            } else {
                error_log('Failed to upload file to S3.');
                return false;
            }
        }
    }

    public function rewrite_attachment_url($url, $post_id)
    {
        $s3_base_url = 'https://' . AWS_BUCKET_NAME . '.s3.' . AWS_REGION . '.arvanstorage.ir/';
        $file_path = get_post_meta($post_id, '_wp_attached_file', true);
        $metadata = wp_get_attachment_metadata($post_id);

        if ($file_path && !$metadata) {
            return $s3_base_url . ltrim($file_path, '/');
        }
        return $url;
    }


    public function save_user_metadata()
    {
        $instructor_picture = sanitize_text_field($_POST['user_pic']);
        $instructor_phone = sanitize_text_field($_POST['phone']);
        $instructor_username = sanitize_text_field($_POST['username']);
        $instructor_name = sanitize_text_field($_POST['name']);
        $instructor_national_code = sanitize_text_field($_POST['national_code']);
        $instructor_birth_date = sanitize_text_field($_POST['birth_date']);
        $instructor_education = sanitize_text_field($_POST['education']);
        $instructor_city = sanitize_text_field($_POST['city']);
        $instructor_marriage = sanitize_text_field($_POST['marriage']);
        $instructor_children = sanitize_text_field($_POST['children']);
        $instructor_favs = array_map('sanitize_text_field', (array)$_POST['favs']);
        $instructor_id = !empty($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : get_current_user_id();
        $profile_url  = apply_filters('edumall_user_profile_url', '');


        if (!empty($instructor_username)) {
            update_user_meta($instructor_id, '_instructor_username', $instructor_username);
        }

        if (!empty($instructor_favs)) {
            update_user_meta($instructor_id, '_instructor_favs', $instructor_favs);
        }

        if (!empty($instructor_phone)) {
            update_user_meta($instructor_id, '_instructor_phone', $instructor_phone);
        }

        if (!empty($instructor_name)) {
            update_user_meta($instructor_id, '_instructor_name', $instructor_name);
        }

        if (!empty($instructor_national_code)) {
            update_user_meta($instructor_id, '_instructor_national_code', $instructor_national_code);
        }

        if (!empty($instructor_birth_date)) {
            update_user_meta($instructor_id, '_instructor_birth_date', $instructor_birth_date);
        }

        if (!empty($instructor_education)) {
            update_user_meta($instructor_id, '_instructor_education', $instructor_education);
        }

        if (!empty($instructor_city)) {
            update_user_meta($instructor_id, '_instructor_city', $instructor_city);
        }

        if (!empty($instructor_marriage)) {
            update_user_meta($instructor_id, '_instructor_marriage', $instructor_marriage);
        }

        if (!empty($instructor_children)) {
            update_user_meta($instructor_id, '_instructor_children', $instructor_children);
        }

        update_user_meta($instructor_id, '_instructor_profile_pic', $instructor_picture);

        if (!empty($_POST['user_id'])) {
            $user = get_user_by('id', $instructor_id);

            update_user_meta($instructor_id, '_tutor_instructor_status', true);

            if ($user) {
                // Set the current user
                wp_set_current_user($instructor_id, $user->user_login);

                // Set authentication cookies
                wp_set_auth_cookie($instructor_id);

                // Redirect to the desired page after login
                wp_send_json(['result' => true]);
                exit;
            } else {
                // Handle the error if user does not exist
                wp_die('User does not exist.');
            }
        } else {
            update_user_meta($instructor_id, '_tutor_instructor_status', true);
            wp_send_json_success(array('result' => 'بروزرسانی پروفایل انجام شد', 'url' => $profile_url));
        }
    }

    public function handle_save_admin_reply()
    {
        if (!isset($_POST['admin_reply']) || !isset($_POST['post_id'])) {
            wp_send_json_error('Invalid data.');
            return;
        }

        $admin_reply = sanitize_textarea_field($_POST['admin_reply']);
        $post_id = intval($_POST['post_id']);

        // Save admin reply as post meta
        update_post_meta($post_id, '_admin_reply', $admin_reply);

        // Add admin reply as a comment
        $commentdata = array(
            'comment_post_ID' => $post_id,
            'comment_author' => 'Admin',
            'comment_author_email' => '',
            'comment_content' => $admin_reply,
            'comment_type' => '',
            'comment_parent' => 0,
            'user_id' => get_current_user_id(),
            'comment_approved' => 1,
        );
        wp_insert_comment($commentdata);

        update_post_meta($post_id, '_new_admin_comment', true);

        wp_send_json_success('Reply saved.');
    }

    public function enqueue_admin_ticket_script()
    {
        global $post_type;

        if ('ticket' == $post_type) {
            wp_enqueue_style('font-admin', get_stylesheet_directory_uri() . '/admin-style.css', false);
            wp_enqueue_script('admin-ticket-script', get_stylesheet_directory_uri() . '/build/admin/index.js', array('jquery'), time(), true);
            wp_localize_script('admin-ticket-script', 'ajax_params', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
            wp_enqueue_style('admin-ticket-style', get_stylesheet_directory_uri()  . '/build/admin/style-index.css');
        }
    }

    public function handle_submit_ticket_comment()
    {
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        $post_id = intval($_POST['comment_post_ID']);

        $commentdata = array(
            'comment_post_ID' => $post_id,
            'comment_author' => wp_get_current_user()->display_name,
            'comment_content' => sanitize_textarea_field($_POST['comment']),
            'comment_type' => '',
            'comment_parent' => intval($_POST['comment_parent']),
            'user_id' => get_current_user_id(),
            'comment_approved' => 1,
        );

        $comment_id = wp_insert_comment($commentdata);

        update_post_meta(sanitize_textarea_field($post_id), '_new_admin_comment', false);

        if ($comment_id) {
            wp_send_json_success('Comment submitted');
        } else {
            wp_send_json_error('Failed to submit comment');
        }
    }

    public function save_admin_reply_metabox($post_id)
    {
        if (isset($_POST['ticket_status'])) {
            update_post_meta($post_id, '_ticket_status', sanitize_text_field($_POST['ticket_status']));
        }
    }

    public function support_meta_boxes()
    {
        add_meta_box(
            'last_message_and_reply_metabox',
            'User Message and Admin Reply',
            [$this, 'display_last_message_and_reply_metabox'],
            'ticket',
            'normal',
            'high'
        );

        add_meta_box(
            'ticket_status_metabox',
            'Ticket Status',
            [$this, 'display_ticket_status_metabox'],
            'ticket',
            'side',
            'high'
        );
    }

    public function display_ticket_status_metabox($post)
    {
        $ticket_status = get_post_meta($post->ID, '_ticket_status', true);
        $statuses = array(
            'wait' => 'در انتظار پاسخ',
            'check' => 'در حال بررسی',
            'replied' => 'پاسخ داده شده',
            'closed' => 'بسته شده'
        );
?>
        <select name="ticket_status" id="ticket_status">
            <?php foreach ($statuses as $key => $value) : ?>
                <option value="<?php echo esc_attr($key) ?>" data-status="<?php echo esc_html($value) ?>" <?php echo selected($ticket_status, $key, false) ?>><?php echo esc_html($value) ?></option>
            <?php endforeach; ?>
        </select>
    <?php }

    public function display_last_message_and_reply_metabox($post)
    {
        // Fetch the last user comment
        $comments = get_comments(array(
            'post_id' => $post->ID,
            'status' => 'approve',
            'order' => 'ASC',
        ));
    ?>
        <div class="admin-messages-wrap">
            <div class="admin-chat user">
                <p>
                    <?php esc_html_e('کاربر: ', 'edumall-child'); ?>
                </p>
                <p>
                    <?php echo get_the_content(null, false, $post->ID) ?>
                </p>
            </div>
            <?php foreach ($comments as $comment) :
                $is_admin = user_can($comment->user_id, 'administrator'); ?>
                <?php if ($is_admin) : ?>
                    <div class="admin-chat admin">
                        <p>
                            <?php esc_html_e('ادمین: ', 'edumall-child'); ?>
                        </p>
                        <p><?php echo esc_html($comment->comment_content) ?></p>
                    </div>
                <?php else : ?>
                    <div class="admin-chat user">
                        <p>
                            <?php esc_html_e('کاربر: ', 'edumall-child'); ?>
                        </p>
                        <p><?php echo esc_html($comment->comment_content) ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div id="admin-ticket-reply" class="admin-ticket-reply">
            <input type="text" id="admin_reply" name="admin_reply" placeholder="جواب به کاربر">
            <input type="hidden" id="post_id" name="post_id" value="<?php echo get_the_ID() ?>" />
            <button type="button" name="submit">
                ارسال
            </button>
        </div>
<?php
    }

    public function auto_approve_ticket_comments($commentdata)
    {
        if (get_post_type($commentdata['comment_post_ID']) == 'ticket') {
            $commentdata['comment_approved'] = 1;
        }
        return $commentdata;
    }

    public function handle_ticket_submission()
    {
        if (isset($_POST['submit-ticket'])) {
            if (!is_user_logged_in()) {
                wp_redirect(home_url());
                exit;
            }

            $profile_url  = apply_filters('edumall_user_profile_url', '');

            $subject = sanitize_text_field($_POST['ticket-subject']);
            $priority = sanitize_text_field($_POST['ticket-priority']);
            $category = sanitize_text_field($_POST['ticket-category']);
            $description = sanitize_textarea_field($_POST['ticket-description']);
            $user_id = get_current_user_id();

            $ticket_data = array(
                'post_title'   => $subject,
                'post_content' => $description,
                'post_status'  => 'publish',
                'post_author'  => $user_id,
                'post_type'    => 'ticket',
                'meta_input'   => array(
                    'ticket_priority' => $priority,
                    'ticket_category' => $category,
                ),
            );

            $post_id = wp_insert_post($ticket_data);

            // Handle file upload
            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $uploadedfile = $_FILES['ticket-attachment'];
            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
                // File is uploaded successfully
                update_post_meta($post_id, 'ticket_attachment', $movefile['url']);
            } else {
                // Handle the error condition
                echo $movefile['error'];
            }

            wp_redirect(add_query_arg('ticket_submitted', 'true', $profile_url . 'support'));
            exit;
        }
    }

    public function enable_comments_for_tickets()
    {
        add_post_type_support('ticket', 'comments');
    }

    public function create_ticket_post_type()
    {
        $labels = array(
            'name'                  => 'Tickets',
            'singular_name'         => 'Ticket',
            'menu_name'             => 'Tickets',
            'name_admin_bar'        => 'Ticket',
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New Ticket',
            'new_item'              => 'New Ticket',
            'edit_item'             => 'Edit Ticket',
            'view_item'             => 'View Ticket',
            'all_items'             => 'All Tickets',
            'search_items'          => 'Search Tickets',
            'not_found'             => 'No tickets found.',
            'not_found_in_trash'    => 'No tickets found in Trash.',
        );

        $args = array(
            'labels'                => $labels,
            'public'                => false,
            'publicly_queryable'    => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'ticket'),
            'capability_type'       => 'post',
            'has_archive'           => false,
            'hierarchical'          => false,
            'menu_position'         => null,
            'supports'              => array('title', 'author'),
            'show_in_rest'          => true,
            'menu_icon'             => 'dashicons-phone'
        );

        register_post_type('ticket', $args);
    }

    public function is_bookmarked($post_id = 0, $user_id = 0, $type = 'course')
    {
        global $wpdb;

        $user_id   = $user_id;

        if (!$user_id) {
            return false;
        }

        $if_added_to_list = (bool) $wpdb->get_row(
            $wpdb->prepare(
                "SELECT *
			FROM	{$wpdb->usermeta}
			WHERE 	user_id = %d
					AND meta_key = '_tutor_{$type}_bookmark'
					AND meta_value = %d;
			",
                $user_id,
                $post_id
            )
        );

        return $if_added_to_list;
    }

    public function add_or_delete_wishlist($user_id, $post_id, $type)
    {
        global $wpdb;

        $if_added_to_list = $this->is_bookmarked($post_id, $user_id, $type);

        $result = '';

        if ($if_added_to_list) {
            $wpdb->delete(
                $wpdb->usermeta,
                array(
                    'user_id'    => $user_id,
                    'meta_key'   => "_tutor_{$type}_bookmark",
                    'meta_value' => $post_id,
                )
            );

            $result = 'removed';
        } else {
            add_user_meta($user_id, "_tutor_{$type}_bookmark", $post_id);

            $result = 'added';
        }

        return $result;
    }

    public function bookmark_course()
    {
        tutor_utils()->checking_nonce();
        $type = sanitize_text_field($_POST['type']);
        $id = sanitize_text_field($_POST['id']);
        $callback = sanitize_text_field($_POST['callback']);

        // Redirect login since only logged in user can add courses to wishlist.
        if (!is_user_logged_in()) {
            wp_send_json_error(
                array(
                    'redirect_to' => wp_login_url(wp_get_referer()),
                )
            );
        }

        $user_id   = get_current_user_id();

        $result = $this->add_or_delete_wishlist($user_id, $id, $type);

        if ('added' === $result) {
            wp_send_json_success(
                array(
                    'status'  => 'added',
                    'message' => __("$callback به لیست نشان شده ها اضافه شد", 'edumall_child'),
                )
            );
        } else {
            wp_send_json_success(
                array(
                    'status'  => 'removed',
                    'message' => __("$callback از لیست نشان شده ها حذف شد", 'edumall_child'),
                )
            );
        }
    }

    public function get_course_likes_number($course_id = 0)
    {
        global $wpdb;

        // Table name
        $table_name = $wpdb->prefix . 'usermeta';

        // SQL query to count rows
        $query = $wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE meta_key = %s AND meta_value = %s",
            '_tutor_course_wishlist',
            $course_id
        );

        // Execute the query and get the count
        $count = $wpdb->get_var($query);

        return $count;
    }

    public function child_user_login()
    {
        $user = '';

        if (!empty($_POST['phone_number'])) :
            $user_login = sanitize_text_field($_POST['phone_number']);
            $user = get_user_by('login', $user_login);
        else :
            $user_id = sanitize_text_field($_POST['user_id']);
            $user = get_user_by('id', $user_id);
        endif;


        if ($user) {

            // Set the current user
            wp_set_current_user($user->ID, $user->user_login);

            // Set authentication cookies
            wp_set_auth_cookie($user->ID);

            // Redirect to the desired page after login
            wp_send_json(['result' => true]);
            exit;
        } else {
            // Handle the error if user does not exist
            wp_die('User does not exist.');
        }
    }

    public function save_user_favorites()
    {
        $favorites = $_POST['favorites'];
        $user_id = $_POST['user_id'];

        update_user_meta($user_id, 'favorites', $favorites);

        wp_send_json(array('result' => true));
    }

    public function save_user_meta()
    {
        $phone_number = sanitize_text_field($_POST['phone_number']);
        $name = sanitize_text_field($_POST['name']);
        $refer = sanitize_text_field($_POST['refer']);

        // Insert the user into the database
        $user_id = wp_create_user($phone_number, '', ''); // Using phone number as username, no password

        // Check for errors
        if (empty($user_id)) {
            wp_send_json_error(new WP_Error('username_exists', __('Username already exists.')));
        }

        // User created successfully
        update_user_meta($user_id, 'refer_code', $refer);
        update_user_meta($user_id, 'first_name', $name);
        wp_send_json(array('result' => true, 'user_id' => $user_id));
    }

    public function send_verification_code()
    {
        $phone_number = sanitize_text_field($_POST['phone_number']);

        $verification_code = $this->generateRandomString();

        // URL to which the fetch request will be made
        $api_url = "https://api.kavenegar.com/v1/3070465848757A397941356A736D5448693038314A42684A4469316F654C4E704F64502B476F77464732493D/verify/lookup.json?receptor={$phone_number}&token=" . $verification_code . "&template=hanil-login-code";
        // $api_url = "https://fakestoreapi.com/products/1";

        // Get the username from the AJAX request

        // Check if the username exists
        $exists = username_exists($phone_number);

        // Check if the username already exists

        // Initialize cURL session
        $ch = curl_init($api_url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it directly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (use it cautiously, it's better to have SSL enabled)


        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        if ($exists) :
            $user = get_user_by('login', $phone_number);

            $has_password = false;

            if (!empty($user->user_pass)) {
                $has_password = true;
            }
            wp_send_json(array('status' => true, 'verify_code' => $verification_code, 'has_password' => $has_password));
        else :
            wp_send_json(array('status' => false, 'verify_code' => $verification_code,));
        endif;
        // Send the response back to the client
    }

    public function generateRandomString($length = 4)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function add_to_cart()
    {
        ob_start();
        // phpcs:disable WordPress.Security.NonceVerification.Missing
        if (!isset($_POST['product_id'])) {
            return;
        }

        $product_id        = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $product           = wc_get_product($product_id);
        $quantity          = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status    = get_post_status($product_id);
        $variation_id      = !empty($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
        $variation         = array();

        if ($product && 'variation' === $product->get_type() && empty($variation_id)) {
            $variation_id = $product_id;
            $product_id   = $product->get_parent_id();
        }

        foreach ($_POST as $key => $value) {
            if ('attribute_' !== substr($key, 0, 10)) {
                continue;
            }

            $variation[sanitize_title(wp_unslash($key))] = wp_unslash($value);
        }


        if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            \WC_AJAX::get_refreshed_fragments();
        } else {

            // If there was an error adding to the cart, redirect to the product page to show any errors.
            $data = array(
                'error'       => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id),
            );

            wp_send_json($data);
        }
    }

    public function place_rating()
    {
        $rating    = sanitize_text_field(tutor_utils()->avalue_dot('rating', $_POST));
        $course_id = sanitize_text_field(tutor_utils()->avalue_dot('course_id', $_POST));
        $review    = wp_kses_post(tutor_utils()->avalue_dot('review', $_POST));

        $result = $this->add_review($course_id, $rating, $review);

        if ($result instanceof WP_Error) {
            wp_send_json_error();
        } else {
            wp_send_json_success($result);
        }

        exit;
    }

    public function add_review($course_id, $rating, $review)
    {
        global $wpdb;

        if (empty($course_id)) {
            return new WP_Error('failed', esc_html__('Please select a course', 'edumall'));
        }

        if (empty($review)) {
            return new WP_Error('failed', esc_html__('Please input your review', 'edumall'));
        }

        $rating = intval($rating);
        $rating = min($rating, 5);
        $rating = max($rating, 1);

        $user_id = get_current_user_id();
        $user    = get_userdata($user_id);
        $date    = date('Y-m-d H:i:s', tutor_time());

        if (!Edumall_Tutor::instance()->has_enrolled_content_access('course', $course_id)) {
            return new WP_Error('failed', esc_html__('Access Denied', 'edumall'));
        }

        do_action('tutor_before_rating_placed');

        $previous_rating_id = $wpdb->get_var($wpdb->prepare("select comment_ID from {$wpdb->comments} WHERE comment_post_ID = %d AND user_id = %d AND comment_type = 'tutor_course_rating' LIMIT 1;", $course_id, $user_id));

        $review_ID = $previous_rating_id;
        if ($previous_rating_id) {
            $wpdb->update(
                $wpdb->comments,
                array('comment_content' => esc_sql($review)),
                array('comment_ID' => $previous_rating_id)
            );

            $rating_info = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->commentmeta} WHERE comment_id = %d AND meta_key = 'tutor_rating'; ", $previous_rating_id));
            if ($rating_info) {
                $wpdb->update($wpdb->commentmeta, array('meta_value' => $rating), array(
                    'comment_id' => $previous_rating_id,
                    'meta_key'   => 'tutor_rating',
                ));
            } else {
                $wpdb->insert($wpdb->commentmeta, array(
                    'comment_id' => $previous_rating_id,
                    'meta_key'   => 'tutor_rating',
                    'meta_value' => $rating,
                ));
            }
        } else {
            $data = array(
                'comment_post_ID'  => esc_sql($course_id),
                'comment_approved' => 'hold',
                'comment_type'     => 'tutor_course_rating',
                'comment_date'     => $date,
                'comment_date_gmt' => get_gmt_from_date($date),
                'user_id'          => $user_id,
                'comment_author'   => $user->user_login,
                'comment_agent'    => 'TutorLMSPlugin',
            );
            if ($review) {
                $data['comment_content'] = $review;
            }

            $wpdb->insert($wpdb->comments, $data);
            $comment_id = (int) $wpdb->insert_id;
            $review_ID  = $comment_id;

            if ($comment_id) {
                $result = $wpdb->insert($wpdb->commentmeta, array(
                    'comment_id' => $comment_id,
                    'meta_key'   => 'tutor_rating',
                    'meta_value' => $rating,
                ));

                do_action('tutor_after_rating_placed', $comment_id);
            }
        }

        /**
         * Custom code.
         */
        $this->update_course_rating($course_id);

        return array(
            'review_id' => $review_ID,
            'review'    => $review,
        );
    }

    public function update_course_rating($post_id)
    {
        /**
         * Custom code here.
         * Save meta for post.
         */
        $course_rating = tutor_utils()->get_course_rating($post_id);

        /**
         * Set post meta
         * Used for sorting.
         */
        update_post_meta($post_id, '_course_average_rating', $course_rating->rating_avg);

        /**
         * Set post term visibility.
         * Used for filtering.
         */

        // Remove old rated term.
        $tags           = wp_get_post_terms($post_id, 'course-visibility');
        $tags_to_delete = [
            'rated-1',
            'rated-2',
            'rated-3',
            'rated-4',
            'rated-5',
        ];
        $tags_to_keep   = [];
        foreach ($tags as $t) {
            if (!in_array($t->name, $tags_to_delete)) {
                $tags_to_keep[] = $t->name;
            }
        }
        $int_rating_average = round($course_rating->rating_avg);
        $current_term_rated = 'rated-' . $int_rating_average;

        $tags_to_keep[] = $current_term_rated;

        wp_set_post_terms($post_id, $tags_to_keep, 'course-visibility', false);
    }

    public function like_course()
    {
        $course_id = sanitize_text_field($_POST['courseId']);
        $course_like_count = intval(get_post_meta($course_id, '_course_like', true));
        update_post_meta($course_id, '_course_like', $course_like_count + 1);
    }

    public function get_total_earnings_by_product_id($product_id)
    {
        // Get the product object
        $product = wc_get_product($product_id);
        if (!$product) {
            return '0';
        }

        // Setup the order query
        $query = new \WC_Order_Query(array(
            'limit'        => -1,  // Query all orders
            'orderby'      => 'date',
            'order'        => 'DESC',
            'return'       => 'ids',
            'status'       => array('wc-completed'), // Only count orders that are completed or processing
        ));

        // Get the order IDs
        $order_ids = $query->get_orders();

        $total_sales = 0;

        // Loop through each order ID to access the order object and its line items
        foreach ($order_ids as $order_id) {
            $order = wc_get_order($order_id);
            foreach ($order->get_items() as $item_id => $item) {
                // Check if the line item is the product we're interested in
                if ($item->get_product_id() == $product_id) {
                    // Add the line item total to the total sales
                    $total_sales += $item->get_total(); // get_total() returns the total (including taxes) of this line item
                }
            }
        }

        return $total_sales;
    }

    public function time_ago($time)
    {
        $bndate = \bn_parsidate::getInstance();
        $time = $bndate->gregorian_date('Y-m-d H:i:s', $time);
        $time_difference = current_time('timestamp') - strtotime($time);

        if ($time_difference < 1) {
            return 'اکنون';
        }
        $condition = array(
            12 * 30 * 24 * 60 * 60 =>  'سال',
            30 * 24 * 60 * 60      =>  'ماه',
            24 * 60 * 60           =>  'روز',
            60 * 60                =>  'ساعت',
            60                     =>  'دقیقه',
            1                      =>  'ثانیه'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;
            if ($d >= 1) {
                $t = round($d);
                return $t . ' ' . $str . ' پیش';
            }
        }
    }


    public function get_price_indicator($price)
    {
        // Count zeros
        $zero_count = substr_count($price, '0');

        // Calculate the length of the price excluding zeros
        $length = strlen($price) - $zero_count;

        // Format the price based on its length
        if ($length + $zero_count > 9) {
            $formatted = round($price / 1000000000, 2) . ' میلیارد تومان';
        } elseif ($length + $zero_count > 6) {
            $formatted = round($price / 1000000, 2) . ' میلیون تومان';
        } elseif ($length + $zero_count > 3) {
            $formatted = round($price / 1000, 2) . ' هزار تومان';
        } else {
            $formatted = $price;
        }

        return $formatted;
    }
}

// Initialize the class
$course_extend = new CourseExtend();
