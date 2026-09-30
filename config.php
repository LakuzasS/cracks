<?php
define('ADMIN_EMAIL', '<insert email>@etu-bourgogne.fr');

chdir(__DIR__);

require_once './tSingleton.php';
require_once './Auth.php';
require_once './Markdown.php';

$dbConfig = json_decode(trim(file_get_contents('./db.json')), true);
$databasePath = __DIR__.'/database/cracks.db';

if(!is_dir(dirname($databasePath))) {
    mkdir(dirname($databasePath), 0775, true);
}

$databaseExists = file_exists($databasePath);

$db = new PDO($dbConfig['dsn'], 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

if(!$databaseExists) {
    $db->exec(file_get_contents(__DIR__.'/init.sql'));
}


function displayCrack($crack) {
    $voteable = !empty($_SESSION['userid']);
    echo '<div class="crack voteable" data-cid="' . htmlspecialchars($crack['id'], ENT_QUOTES, 'UTF-8') . '">';
    if($voteable) {
        echo '<div class="votebar">'
                . '<span class="dovote" data-val="1">👍</span>'
                . '[<span class="votes">-</span>]'
                . '<span class="dovote" data-val="-1">👎</span>'
            . '</div>';
    }
    echo '<p>'.Markdown::_($crack['content']).'</p>';
    if(!empty($crack['login'])) {
        echo '<footer>Envoyé par '.$crack['login'].' le '.date('Y-m-d H:i', intval($crack['datesend'])).'</footer>';
    }
    echo '</div>';
    if($voteable) {
        echo '<script type="text/javascript">loadVoteBar('.$crack['id'].', '.$_SESSION['userid'].');</script>';
    }
}
