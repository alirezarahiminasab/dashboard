<?php
add_action('graphql_register_types', function () {

    register_graphql_object_type(
        'Student',
        [
            'description' => __('Student', 'bsr'),
            'fields'      => [
                'firstName' => [
                    'type'        => 'String',
                    'description' => 'first name'
                ],
                'lastName'  => [
                    'type'        => 'String',
                    'description' => 'last name'
                ],
                'uid'       => [
                    'type'        => 'String',
                    'description' => 'user id'
                ]
            ],
        ]
    );

    register_graphql_field(
        'RootQuery',
        'students',
        [
            'description' => __('Return Students', 'bsr'),
            'type'        => ['list_of' => 'student'],
            'resolve'     => function () {
                $students_arr = [];
                $students       = get_users(array(
                    'role__in' => 'student'
                ));

                foreach ($students as $p) {
                    $student = [
                        'firstName' => $p->first_name,
                        'lastName'  => $p->last_name,
                        'uid'       => $p->ID
                    ];

                    array_push($students_arr, $student);
                }

                return $students_arr;
            }
        ]
    );
});
