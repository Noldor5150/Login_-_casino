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
    $slot3x3 = new App\SlotMachine3x3();
    if ($player->getBalance() >= $slot3x3->getBandymoKaina()) {
        return true;
    }

    return false;
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);

    if ($form_success) {
        $cookie = new Core\Cookie('player');
        $slot3x3 = new App\SlotMachine3x3();
        $slot3x3->Shuffle();
        $player = new App\Player($cookie);
        $player->setBalance($slot3x3->Outcome());
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
                    <a href="slot5x3.php">WANT SOME MORE?</a>
                </nav>
                <h1>IN SPIN WE TRUST 3x3</h1>
                <?php if (isset($slot3x3)): ?>
                    <div class="slotmachine">
                        <?php foreach ($slot3x3->getState() as $column): ?>
                            <div class="row">
                                <?php foreach ($column as $col_data): ?>
                                    <div class="element element-<?php print $col_data; ?>"></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($slot3x3->isWin()): ?>
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