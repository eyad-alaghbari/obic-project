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
    // 'product' => [
    //     'name_required' => 'The name product is required.',
    //     'description_string' => 'The description must be a string.',
    //     'price_required' => 'The price product is required.',
    //     'price_numeric' => 'The price product must be numeric.',
    //     'stock_required' => 'The stock product is required.',
    //     'stock_numeric' => 'The stock product must be numeric.',
    // ],
    'category' => [
        'name_required' => 'The category name is required.',
        'parent_id_exists' => 'The parent category must be valid.',
        'description_string' => 'The description must be a string.',
    ],
    'customization' => [
        'name_required' => 'The customization name is required.',
        'name_max' => 'The customization name must not exceed :max characters.',
        'name_string' => 'The customization name must be a string.',
    ],
    'customization_option' => [
        'value_required' => 'The customization option value is required.',
        'value_max' => 'The customization option value must not exceed :max characters.',
        'value_string' => 'The customization option value must be a string.',
        'customization_id_required' => 'The customization option customization id is required.',
        'customization_id_integer' => 'The customization option customization id must be an integer.',
        'customization_id_exists' => 'The customization option customization id must be valid.',
    ],
];
