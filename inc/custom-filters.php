<?php

// Modify Nav Items
add_filter('tutor_dashboard/nav_items',  'add_items_to_menu');
add_filter('tutor_dashboard/bottom_nav_items', 'remove_bottom_items');
add_filter('after_register_frontend_report_nav_item', 'remove_instructor_items');
add_filter('after_register_frontend_report_nav_item', 'add_instructor_menu_items');

function add_items_to_menu()
{
    $menus = array(
        'profile-edit'    => array(
            'title' => __('ویرایش اطلاعات پروفایل یادگیری', 'edumall-child'),
            'icon'  => 'user-edit',
            'active'  => true,
        ),
        'enrolled-courses' => array(
            'title' => __('My Courses', 'edumall-child'),
            'icon'  => 'monitor-recorder',
            'active'  => true,
        ),
        'my-events' => array(
            'title' => __('رویداد‌های من', 'edumall-child'),
            'icon'  => 'calendar-tick',
            'active'  => false,
        ),
        'bookmarks'            => array(
            'title' => __('نشان شده‌ها', 'edumall-child'),
            'icon'  => 'bookmarks',
            'active'  => true,
        ),
        'notifications'       => array(
            'title' => __('Notifications', 'edumall-child'),
            'icon'  => 'notifications',
            'active'  => false,
        ),
        'wishlist'         => array(
            'title' => __('Wishlist', 'edumall-child'),
            'icon'  => 'heart-bio',
            'active'  => false,
        ),
        'support'          => array(
            'title' => __('Support', 'edumall-child'),
            'icon'  => 'support-ticket',
            'active'  => true,
        ),
        'my-communication' => array(
            'title' => __('گفتگو‌های من', 'edumall-child'),
            'icon'  => 'messages',
            'active'  => false,
            'sub_menu' => array(
                'comm-jikpik' => ['icon' => 'comm-jikpik', 'title' => 'جیک و پیک'],
                'comm-course' => ['icon' => 'comm-course', 'title' => 'دوره'],
                'comm-instructor' => ['icon' => 'comm-instructor', 'title' => 'مدرس'],
            )

        ),
        'settings' => array(
            'title' => __('تنظیمات', 'edumall-child'),
            'icon'  => 'setting',
            'active'  => true,
            'sub_menu' => array('change-password' => ['icon' => 'key', 'title' => 'تغییر رمز عبور'])
        ),
        'logout'      => array(
            'title' => __('خروج از حساب کاربری', 'edumall-child'),
            'icon'  => 'logout',
            'active'  => true,
        ),
    );
    return $menus;
}

function add_instructor_menu_items()
{
    $other_menus = array(
        'edit-instructor-info' => array(
            'title'    => __('ویرایش اطلاعات پروفایل تدریس', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'     => 'instructor-edit-icon',
            'active'  => true,
        ),
        'course'      => array(
            'title'    => __('Courses', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'     => 'instructor-course-icon',
            'active'  => true,
            'sub_menu' => array(
                'course-create' => ['icon' => 'instructor-create', 'title' => 'ایجاد دوره جدید'],
                'course-status' => ['icon' => 'instructor-course-status', 'title' => 'دوره‌های ایجاد شده'],
                'course-students' => ['icon' => 'instructor-students', 'title' => 'لیست فراگیران'],
                'course-statistics' => ['icon' => 'instructor-statistics', 'title' => 'آمار دوره‌ها']
            )
        ),
        'referral-code' => array(
            'title'    => __('کد معرف', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'     => 'instructor-referral-icon',
            'active'  => false,
        ),
        'events' => array(
            'title'    => __('Events', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'     => 'instructor-event-icon',
            'active'  => true,
            'sub_menu' => array(
                'events-create-online' => ['icon' => 'instructor-create', 'title' => 'ایجاد رویداد آنلاین جدید'],
                'events-create-personal' => ['icon' => 'instructor-create', 'title' => 'ایجاد رویداد حضوری جدید'],
                'events-status' => ['icon' => 'instructor-events-status', 'title' => 'رویداد‌های ایجاد شده'],
                'events-students' => ['icon' => 'instructor-students', 'title' => 'لیست فراگیران'],
                'events-statistics' => ['icon' => 'instructor-statistics', 'title' => 'آمار رویدادها']
            )
        ),
        'magazine' => array(
            'title'    => __('Magazine', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'     => 'instructor-mag-icon',
            'active'  => false,
            'sub_menu' => array(
                'mag-create' => ['icon' => 'instructor-create', 'title' => 'ایجاد پست‌ جدید'],
                'mag-status' => ['icon' => 'instructor-mag-status', 'title' => 'پست‌های ایجاد شده'],
                'mag-statistics' => ['icon' => 'instructor-statistics', 'title' => 'آمار پست‌ها']
            )
        ),
        'withdrawal' => array(
            'title'    => __('Withdrawal', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'     => 'instructor-withdrawal-icon',
            'active'  => true,
            'sub_menu' => array(
                'withdrawal-info' => ['icon' => 'withdrawal-clear', 'title' => 'تسویه حساب'],
                'withdrawal-account' => ['icon' => 'withdrawal-account', 'title' => 'اطلاعات حساب بانکی'],
            )
        ),
        'log-out'      => array(
            'title' => __('خروج از حساب کاربری', 'edumall-child'),
            'auth_cap' => tutor()->instructor_role,
            'icon'  => 'logout',
            'active'  => true,
        ),
    );
    return $other_menus;
}

function remove_bottom_items()
{
    return [];
}

function remove_instructor_items()
{
    return [];
}
