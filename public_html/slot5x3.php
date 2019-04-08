<?php
require '../bootloader.php';

$form = [
    'fields' => [
    ],
    'buttons' => [
        'submit' => [
            'text' => 'SPIN & WIN!'
        ]
    ],
    'validate' => [
        'validate_balance'
    ],
    'callbacks' => [
        'success' => [
        ],
        'fail' => []
    ]
];

function validate_balance() {
    $cookie = new Core\Cookie('player');
    $player = new App\Player($cookie);
    $slot5x3 = new App\SlotMachine5x3();
    if ($player->getBalance() >= $slot5x3->getBandymoKaina()) {
        return true;
    }

    return false;
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);

    if ($form_success) {
        $cookie = new Core\Cookie('player');
        $slot5x3 = new App\SlotMachine5x3();
        $slot5x3->Shuffle();
        $player = new App\Player($cookie);
        $player->setBalance($slot5x3->Outcome());
    }
}
?>
<html>
    <head>
        <title>Casino ple</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="relative">
            <div class="casino">
                <nav>
                    <a href="index.php">HOME</a>
                    <a href="slot3x3.php">WANT SOME MORE?</a>
                </nav>
                <h1>IN SPIN WE TRUST 5x3</h1>
                <?php if (isset($slot5x3)): ?>
                    <div class="slotmachine">
                        <?php foreach ($slot5x3->getState() as $column): ?>
                            <div class="row">
                                <?php foreach ($column as $col_data): ?>
                                    <div class="element element-<?php print $col_data; ?>"></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($slot5x3->isWin()): ?>
                        <h2>YOU WIN</h2>
                    <?php else: ?>
                        <h2>PLAY AGAIN</h2>
                    <?php endif; ?>
                <?php endif; ?>   
                <?php require '../core/views/form.php'; ?>
            </div>
        </div>
    </body>
</html>