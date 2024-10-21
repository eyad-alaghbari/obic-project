<?php
return [
    'auth' => [
            'name' => [
                'required' => 'The name field is required.',
                'min' => 'The name must be at least :min characters long.',
            ],
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'Please provide a valid email address.',
                'exists' => 'The provided email does not exist.',
                'min' => 'The email must be at least :min characters long.',
                'max' => 'The email must not exceed :max characters.',
                'unique' => 'The email has already been taken.',
            ],
            'password' => [
                'required' => 'The password field is required.',
                'min' => 'The password must be at least :min characters long.',
            ],
            'c_password' => [
                'required' => 'The confirm password field is required.',
                'same' => 'The confirm password does not match.',
            ],
    ],
    'vendor' => [
        'name_required' => 'The name vendor is required',
        'email_required' => 'The email field is required.',
        'email_unique' => 'The email has already been taken.',
        'status_required' => 'The status vendor is required.',
        'status_boolean' => 'The status vendor is boolean',
        'logo_mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, svg.',
        'logo_max' => 'The logo must not be greater than :max kilobytes.',
        'logo_image' => 'The logo must be an image.',
    ],
    'category' => [
        'name_required' => 'The category name is required.',
        'parent_id_exists' => 'The parent category must be valid.',
        'description_string' => 'The description must be a string.',
    ],
];
