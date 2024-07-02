<?php


class Search
{
    // Initialize the class
    function __construct()
    {
        add_action('wp_ajax_search', array($this, 'search'));
        add_action('wp_ajax_nopriv_search', array($this, 'search'));
    }

    public function search()
    {
        $query = sanitize_text_field($_POST['searchQuery']);
        $result = [];

        $content_args = array('s' => $query);
        $content_query = new WP_Query($content_args);

        $user_args = array('search' => $query);
        $user_query = new WP_User_Query($user_args);


        if ($content_query->found_posts > 0) :
            $result['contents'] = $this->get_contents($query);
        else :
            $result['contents'] = '';
        endif;


        if ($user_query->get_total() > 0) :
            $result['users'] = $this->get_users($query);
        else :
            $result['users'] = '';
        endif;

        wp_send_json(array('result' => $result));
    }

    public function get_contents($query)
    {
        $courses = [];
        $posts = [];
        $events = [];

        $courses_args = array(
            'post_type' => 'courses',
            'posts_per_page' => 2,
            's' => $query,
            'meta_key' => 'views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );
        $courses_query = new WP_Query($courses_args);

        $post_args = array(
            'post_type' => 'post',
            'posts_per_page' => 2,
            's' => $query,
            'meta_key' => 'views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );
        $post_query = new WP_Query($post_args);

        ob_start();
        if ($courses_query->have_posts()) :
            while ($courses_query->have_posts()) : $courses_query->the_post();
                $author_id = get_post_meta(get_the_ID(), 'post_author');
?>
                <div class="search-result-wrap">
                    <div class="search-result-wrap-thumb">
                        <?php if (!empty(get_the_post_thumbnail_url())) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
                        <?php else : ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo hanil 2.svg' ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="search-result-wrap-info">
                        <a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title(); ?></a>
                        <p><?php echo get_the_author_meta('display_name', $author_id) ?></p>
                    </div>
                </div>
        <?php
            endwhile;
        endif; ?>
        <?php $courses = ob_get_clean();

        ob_start();
        if ($post_query->have_posts()) :
            while ($post_query->have_posts()) : $post_query->the_post();
                $author_id = get_post_meta(get_the_ID(), 'post_author');
        ?>
                <div class="search-result-wrap">
                    <div class="search-result-wrap-thumb">
                        <?php if (!empty(get_the_post_thumbnail_url())) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
                        <?php else : ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo hanil 2.svg' ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="search-result-wrap-info">
                        <a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title(); ?></a>
                        <p><?php echo get_the_author_meta('display_name', $author_id) ?></p>
                    </div>
                </div>
            <?php
            endwhile;
        endif;
        $posts = ob_get_clean();

        return array('courses' => $courses, 'posts' => $posts, 'events' => $events);
    }

    public function get_users($query)
    {
        $user_args = array(
            'search' => '*' . esc_attr($query) . '*',
            'meta_key' => '_tutor_total_students',
            'orderby' => 'meta_value_num',
            // 'meta_query' => array(
            //     'relation' => 'OR',
            //     array(
            //         'key'     => 'first_name',
            //         'value'   => $query,
            //         'compare' => 'LIKE'
            //     ),
            //     array(
            //         'key'     => 'last_name',
            //         'value'   => $query,
            //         'compare' => 'LIKE'
            //     ),
            //     array(
            //         'key' => 'description',
            //         'value' => $query,
            //         'compare' => 'LIKE'
            //     )
            // )
        );
        $user_query = new WP_User_Query($user_args);
        $instructors = $user_query->get_results();

        ob_start();
        foreach ($instructors as $instructor) {
            $profile_url       = tutor_utils()->profile_url($instructor->ID);
            $job_title = get_user_meta($instructor->ID, '_tutor_profile_job_title', true);
            $user_meta = get_user_meta($instructor->ID);
            // print_r($user_meta);
            ?>
            <div class="search-result-wrap">
                <div class="search-result-wrap-thumb">
                    <?php if (!empty(get_the_post_thumbnail_url())) : ?>
                        <?php echo edumall_get_avatar($instructor->ID, 150); ?>
                    <?php else : ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo hanil 2.svg' ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="search-result-wrap-info">
                    <a href="<?php echo $profile_url ?>">
                        <?php echo esc_html($instructor->display_name); ?>
                    </a>
                    <p><?php echo esc_html($job_title); ?></p>
                </div>
            </div>
<?php
        }
        $posts = ob_get_clean();

        return  $posts;
    }
}

// Initialize the class
$search_init = new Search();
