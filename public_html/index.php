<?php
require_once '../bootloader.php';

$form = [
    'fields' => [
        'money' => [
            'label' => '',
            'type' => 'number',
            'required' => true,
            'min' => 5,
            'max' => 50,
            'placeholder' => 'Invesk pinigo skaičių',
            'validate' => [
                'validate_not_empty',
                'validate_is_number'
            ]
        ]
    ],
    'buttons' => [
        'submit' => [
            'text' => 'Įnešti pinigų!'
        ]
    ],
    'validate' => [],
    'callbacks' => [
        'success' => [
        ],
        'fail' => []
    ],
    'errors' => []
];

$cookie = new \Core\Cookie('player');
$player = new \App\Player($cookie);

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);
    if ($form_success) {
        $player->setBalance(intval($safe_input['money']));
    }
}
$connection = new \Core\Database\Connection([
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'sindar5150'
        ]);
//$pdo = $connection->getPDO();
//$query = $pdo->prepare('INSERT INTO `my_db`.`users` '
//        . '(`email`, `password`, `full_name`, `age`, `gender`, `photo`)'
//        . 'VALUES(:email, :pass, :full_name, :age, :gender, :photo)');
//$credentials = [
//    'email' => 'alio@jebat666.com',
//    'password' => '12233',
//    'full_name' => 'Aloha, Zakardanovicius',
//    'age' => 666,
//    'gender' => 'm',
//    'photo' => 'uploads/shaitan.jpg'
//];
//$query->bindParam(':email', $credentials['email'], PDO::PARAM_STR);
//$query->bindParam(':pass', $credentials['password'], PDO::PARAM_STR);
//$query->bindParam(':full_name', $credentials['full_name'], PDO::PARAM_STR);
//$query->bindParam(':age', $credentials['age'], PDO::PARAM_INT);
//$query->bindParam(':gender', $credentials['gender'], PDO::PARAM_STR);
//$query->bindParam(':photo', $credentials['photo'], PDO::PARAM_STR);
//$query->execute();

$pdo = $connection->getPDO();
$query = $pdo->query('SELECT * FROM `my_db`.`users`');
$users = [];

$last_gender = '';
while ($row = $query->fetch(PDO::FETCH_LAZY)) {
    $gender = $row['gender'];
    $users[] = [
        $row['gender'],
        $row['age']
    ];
    /*
    $gender = $row['gender'];
    
    if ($last_gender == $gender && $gender == 'f') {
        break;
    } else {
        $last_gender = $gender;
        $users[] = $row;
    }*/
}

?>
<html>
    <head>
        <title>CASINO</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <nav>
            <a href="slot3x3.php">PLAY FOR NOOBS</a>
            <a href="slot5x3.php">PLAY FOR REAL MEN</a>
        </nav>
        <h1>P-OOPINIGU CASINO</h1>
        <?php if ($cookie->exists()): ?>
            <h2>Balansas: <?php print $player->getBalance(); ?>$</h2>
        <?php endif; ?>
        <div class="container">
            <?php require '../core/views/form.php'; ?>
        </div>
        <?php foreach ($users as $column): ?>
            <?php foreach ($column as $field): ?>
                <div><?php print $field; ?></div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </body>
</html>