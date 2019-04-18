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
$pdo = $connection->getPDO();
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
//$pdo = $connection->getPDO();
//$query = $pdo->query('SELECT * FROM `my_db`.`users`');
//$users = [];
//
//$last_gender = '';
//while ($row = $query->fetch(PDO::FETCH_LAZY)) {
//    $gender = $row['gender'];
//    $users[] = [
//        $row['gender'],
//        $row['age']
//    ];
/*
  $gender = $row['gender'];

  if ($last_gender == $gender && $gender == 'f') {
  break;
  } else {
  $last_gender = $gender;
  $users[] = $row;
  } */
//}
//$query = $pdo->query("SELECT * FROM `my_db`.`users` WHERE (`gender`='f') AND (`age`='26')");
//$arr = $query->fetchAll(PDO::FETCH_ASSOC);
//var_dump($arr);
//$sql = strtr('SELECT * FROM @db . @users WHERE (@gender = @f) AND (@age = @value)',[
//    '@db' => Core\Database\SQLBuilder::schema('my_db'),
//    '@users' => Core\Database\SQLBuilder::table('users'),
//    '@gender' => Core\Database\SQLBuilder::column('gender'),
//    '@f' => Core\Database\SQLBuilder::value('f'),
//    '@age' => Core\Database\SQLBuilder::column('age'),
//    '@value' => Core\Database\SQLBuilder::value('26')
//]);
// $query = $pdo->query($sql);
// $arr = $query->fetchAll(PDO::FETCH_ASSOC);
//var_dump($arr);
//$sql = strtr('UPDATE @db . @users SET @gender = @m, @age = @value',[
//    '@db' => Core\Database\SQLBuilder::schema('my_db'),
//    '@users' => Core\Database\SQLBuilder::table('users'),
//    '@gender' => Core\Database\SQLBuilder::column('gender'),
//    '@m' => Core\Database\SQLBuilder::value('m'),
//    '@age' => Core\Database\SQLBuilder::column('age'),
//    '@value' => Core\Database\SQLBuilder::value(rand(0 ,100))
//]);
//
//
// $query = $pdo->exec($sql);

$row = [
    'email' => 'pizdabol@jebat.com ',
    'password' => '66666',
    'full_name' => 'Brtalomejus Freakas ',
    'age' => 666,
    'gender' => 'm',
    'photo' => 'somewhere/far/beyond'
];
//$sql = strtr('INSERT INTO @db . @users (@columns) VALUES (@values)',[
//    '@db' => Core\Database\SQLBuilder::schema('my_db'),
//    '@users' => Core\Database\SQLBuilder::table('users'),
//    '@columns' => Core\Database\SQLBuilder::columns(array_keys($row)),
//    '@values' => Core\Database\SQLBuilder::values(array_values($row))
//]);
$sql = strtr('INSERT INTO @db . @users (@columns) VALUES (@values)',[
    '@db' => Core\Database\SQLBuilder::schema('my_db'),
    '@users' => Core\Database\SQLBuilder::table('users'),
    '@columns' => Core\Database\SQLBuilder::columns(array_keys($row)),
    '@values' => Core\Database\SQLBuilder::binds(array_keys($row))
]);
$query = $pdo->prepare($sql);

var_dump($sql);
//$query -> bindParam(':email', $row['email'], PDO::PARAM_STR);


foreach ($row  as $column => $value) {
        $query->bindValue(Core\Database\SQLBuilder::bind($column), $value);
    }
    $query->execute();

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