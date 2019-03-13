<?php
$data = [
    'success' => false
];
$errors = [];

/**
 * Get POST data
*/

$has_won  = array_key_exists('has_won',$_POST) ? $_POST['has_won'] : 0;

/**
 * Send data to client
 */
$gamer = $_SESSION['gamer'];
$game = [
    'gamer_id' => $gamer['id'],
    'has_won'  => $has_won,
    'game_start' => $_SESSION['game_start'],
    'game_end' => date('Y-m-d H:i:s')
];

$save_game = \Classes\Db::getInstance()->insert('games', $game);
if ($has_won == 1)
{
    \Classes\Db::getInstance()->raw("UPDATE `gamers` SET `wins` = `wins` + 1 WHERE `id` = '".$gamer['id']."'");
}
else
{
    \Classes\Db::getInstance()->raw("UPDATE `gamers` SET `fails` = `fails` + 1 WHERE `id` = '".$gamer['id']."' ");
}
$gamer = \Classes\Db::getInstance()->raw("SELECT `id`, `fullname`, `wins`, `fails` FROM `gamers` WHERE `id` = '".$gamer['id']."' ")->fetch(PDO::FETCH_ASSOC);

if($gamer) {$_SESSION['gamer'] = $gamer;}

$data['message']     = 'Your game has been saved';
$data['success']     = true;
http_response_code(200);

echo json_encode($data);