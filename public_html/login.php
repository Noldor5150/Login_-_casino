<?php
require_once '../bootloader.php';

//$db = new \Core\FileDB(DB_FILE);
//$repository = new \Core\User\Repository($db, TABLE_USERS);

$form = [
    'fields' => [
        'password' => [
            'label' => 'Password',
            'type' => 'password',
            'placeholder' => '********',
            'validate' => [
                'validate_not_empty'
            ]
        ],
        'email' => [
            'label' => 'Email',
            'type' => 'text',
            'placeholder' => 'email@gmail.com',
            'validate' => [
                'validate_not_empty'
            ]
        ],
    ],
    'validate' => [
        'validate_login'
    ],
    'buttons' => [
        'submit' => [
            'text' => 'LOGIN!'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function form_success($safe_input, $form) {
//    $user = new Core\User\User([
//        'email' => $safe_input['email'],
//        'password' => $safe_input['password'],
//        'is_active' => true
//    ]);
//    $db = new Core\FileDB(DB_FILE);
//    $repo = new Core\User\Repository($db, TABLE_USERS);
//    $repo->insert($user);
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);
    if ($form_success) {
        $success_msg = strtr('User "@email" sėkmingai pajungtas', [
            '@email' => $safe_input['email']
        ]);
    }
}

function validate_login(&$safe_input, &$form) {
    $db = new \Core\FileDB(DB_FILE);
    $repo = new \Core\User\Repository($db, TABLE_USERS);
    $session = new \Core\User\Session($repo);
    $status = $session->login($safe_input['email'], $safe_input['password']);
    if ($status === \Core\User\Session::LOGIN_SUCCESS) {
        return true;
    }

    $form['error_msg'] = 'Bad things happened';
}
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="login">
            <?php require '../core/views/form.php'; ?>
            <?php if (isset($success_msg)): ?>
                <h3><?php print $success_msg; ?></h3>
            <?php endif; ?>
        </div>
    </body>



