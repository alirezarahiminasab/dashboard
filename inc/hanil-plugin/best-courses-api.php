<?php
/* 
* Best Courses Endpoint
*/

add_action('rest_api_init', function () {
    register_rest_route('hanil/v1', '/courses/(?P<category_name>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'get_courses_by_category',
    ));
});

function get_courses_by_category($data)
{
    $category_name = $data['category_name'];

    $args = array(
        'post_type' => 'courses',
        'posts_per_page' => 5,
        'tax_query' => array(
            array(
                'taxonomy' => 'course-category',
                'field' => 'slug',
                'terms' => $category_name,
            ),
        ),
    );

    $query = new WP_Query($args);
    $courses = [];
    $regularPrice = 0;
    $salePrice = 0;

    while ($query->have_posts()) {
        $query->the_post();
        $author_id = get_post_field('post_author', get_the_ID());
        $author = get_userdata($author_id);
        $rating = tutor_utils()->get_course_rating(get_the_ID());
        $price = tutor_utils()->get_raw_course_price(get_the_ID());
        $regularPrice = $price->regular_price;
        $salePrice = $price->sale_price;
        $rating_count = $rating->rating_count;
        $rating_avg = Edumall_Helper::number_format_nice_float($rating->rating_avg);
        ob_start();
        Edumall_Templates::render_rating($rating->rating_avg);
        $rating_stars = ob_get_clean();

        $author_img = edumall_get_avatar($author_id, 32);
        if (empty($author_img)) {
            ob_start();
            edumall_get_avatar($author_id, 32); // Assuming this function prints the avatar
            $author_img = ob_get_clean();
        }


        $courses[] = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'excerpt' => get_the_excerpt(),
            'image' => get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_stylesheet_directory_uri() . "/assets/images/404-image.png",
            'regular_price' => $regularPrice,
            'sale_price' => $salePrice,
            'author' => $author->display_name,
            'author_img' => $author_img,
            'rating' => $rating_avg,
            'rating_stars' => $rating_stars,
            'rating_count' => $rating_count
            // Add other course fields as needed
        ];
    }

    return $courses;
}
