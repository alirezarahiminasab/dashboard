<?php
/* 
* Disable default endpoints
*/

// Function to handle course enrollment
function enroll_user_in_course($user_id, $course_id)
{
    // Enroll the user in the course using Tutor LMS function
    tutor_utils()->do_enroll($course_id, 0, $user_id);
}

// Custom permission callback function
function my_custom_permission_callback($request)
{
    // Check if the current user is logged in
    if (!is_user_logged_in()) {
        return new WP_Error('rest_forbidden', esc_html__('You cannot view this resource.', 'my-text-domain'), array('status' => 401));
    }

    // Get the current user ID
    $user_id = get_current_user_id();

    // Extract course ID from the request parameters
    $course_id = $request['course_id'];

    // Enroll the user in the course
    enroll_user_in_course($user_id, $course_id);

    // Allow access if enrollment is successful
    return true;
}

// Register REST route with custom permission callback
add_action('rest_api_init', function () {
    register_rest_route('hanil/v1', '/courses/(?P<course_id>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'my_custom_endpoint_function',
        'permission_callback' => '__return_true', // Public access
    ));
});

// Function to handle the custom endpoint
function my_custom_endpoint_function(WP_REST_Request $request)
{
    $course_id = $request['course_id'];
    $user_id = 37;

    $enrolled_id = tutor_utils()->do_enroll($course_id, 384, $user_id);
    $order = complete_course_enroll($enrolled_id);

    // Prepare the response
    $response = array(
        'status' => 'success',
        'message' => 'User enrolled in course successfully',
        'course_id' => $course_id,
        'user_id' => $user_id,
        "enrolled_id" => $order
    );

    return new WP_REST_Response($response, 200);
}




// add_filter('rest_endpoints', function ($endpoints) {
//     foreach ($endpoints as $route => $endpoint) {
//         // Check if the endpoint is not one of your custom endpoints
//         if (!in_array($route, ['/v1/courses'])) {
//             unset($endpoints[$route]);
//         }
//     }
//     return $endpoints;
// });

include(dirname(__FILE__) . "/hanil-plugin/best-courses-api.php");
include(dirname(__FILE__) . "/hanil-plugin/best-events-api.php");
