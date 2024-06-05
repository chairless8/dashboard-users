<?php
return [

'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register', 'videos', 'groups'],

'allowed_methods' => ['*'],

'allowed_origins' => ['http://localhost:5173'],

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],

'exposed_headers' => false,

'max_age' => false,

'supports_credentials' => false,

];
