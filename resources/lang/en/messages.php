<?php

return [
    // Auth messages
    "auth" => [
        "logout" => "User logout has been successful",
        "login" => "User login has been successful",
        "valid" => "User token is valid",
        "already_logged" => "User already logged in",
        "errors" => [
            "unauthenticated" => "Unauthenticated",
            "unauthorized" => "Unauthorized",
            "token_not_created" => "User token has not been created"
        ]
    ],

    // Normal request messages
    "request" => [
        "process_success" => "The process has been successful",
        "update" => ":module has been update",
        "errors" => [
            "bad" => "Bad request",
            "invalid-format" => "Bad request, invalid format file",
            "required" => ":field is required"
        ]
    ],

    // General messages for models
    "models" => [
        "store" => ":model has been created",
        "update" => ":model has been updated",
        "destroy" => ":model has been deleted",
        "mass" => "All :model have been processed successfully",
        "errors" => [
            "not_found" => ":model not found"
        ],
        "permissions" => [
            "index" => "List all records for the :model model",
            "show" => "Show an record for the :model model",
            "store" => "Create a new record for the :model model",
            "update" => "Update a record for the :model model",
            "destroy" => "Delete a record for the :model model"
        ]
    ],

    // Modules messages
    "acl" => [
        "assign" => "Assign permissions to user or roles",
        "errors" => [
            "level" => "You do not have the level required for this request, your level is :lvl this request required :req",
            "eq_level" => "You can not change or store records with your same level",
        ]
    ],

    "inventory" => [
        "permissions" => [
            "input" => "Allow add product inputs to inventory",
            "output" => "Allow add product outputs to inventory",
            "mass" => "Allows mass operations"
        ]
    ],
    "user" => [
        "permissions" => [
            "message" => "Allow send mail message to users",
        ]
    ],
    "notifications" => [
        "welcome" => [
            "title" => "Welcome to platform, :name.",
            "message" => "Dear :name, we are pleased to welcome you to our platform. Your default password is :password, you must enter the platform and modify it as soon as possible."
        ],
        "comment" => [
            "title" => "You have been mentioned in a comment on :target #:target_id",
            "message" => ":username: :message"
        ]
    ]

];
