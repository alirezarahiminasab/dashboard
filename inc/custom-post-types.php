<?php
class Custom_Post_Type
{
    public function __construct()
    {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type()
    {
        $labels = array(
            'name'               => __('تبلیغات', 'edumall-child'),
            'singular_name'      => __('تبلیغ', 'edumall-child'),
            'menu_name'          => __('تبلیغات', 'edumall-child'),
            'name_admin_bar'     => __('تبلیغ', 'edumall-child'),
            'add_new'            => __('افزودن جدید', 'edumall-child'),
            'add_new_item'       => __('افزودن تبلیغ جدید', 'edumall-child'),
            'new_item'           => __('تبلیغ جدید', 'edumall-child'),
            'edit_item'          => __('ویرایش تبلیغ', 'edumall-child'),
            'view_item'          => __('مشاهده تبلیغ', 'edumall-child'),
            'all_items'          => __('همه تبلیغات', 'edumall-child'),
            'search_items'       => __('جستجوی تبلیغات', 'edumall-child'),
            'parent_item_colon'  => __('تبلیغات والد:', 'edumall-child'),
            'not_found'          => __('تبلیغی یافت نشد.', 'edumall-child'),
            'not_found_in_trash' => __('تبلیغی در زباله‌دان یافت نشد.', 'edumall-child'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'ads'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'thumbnail'),
            'show_in_rest'       => true,
            'menu_icon'          => 'dashicons-megaphone', // Dashicon for ads
        );

        register_post_type('ads', $args);
    }

    public function add_meta_boxes()
    {
        add_meta_box(
            'ads_link_meta_box', // ID
            __('لینک تبلیغ', 'text_domain'), // Title
            array($this, 'show_ads_link_meta_box'), // Callback
            'ads', // Post type
            'normal', // Context
            'high' // Priority
        );
    }

    public function show_ads_link_meta_box($post)
    {
        $ads_link = get_post_meta($post->ID, 'ads_link', true);
?>
        <label for="ads_link"><?php _e('لینک تبلیغ', 'text_domain'); ?></label>
        <input type="url" name="ads_link" id="ads_link" value="<?php echo esc_attr($ads_link); ?>" />
<?php
    }

    public function save_meta_boxes($post_id)
    {
        if (array_key_exists('ads_link', $_POST)) {
            update_post_meta(
                $post_id,
                'ads_link',
                $_POST['ads_link']
            );
        }
    }
}

new Custom_Post_Type();
?>