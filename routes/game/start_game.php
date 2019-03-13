<?php
/**
 * Check if game exists and send game matrix to client in order to set ShipPlacement array in javascript.
 * This will help to make shot withour refreshing page
 */
if(isset($_SESSION['game_matrix'])) {
    $data['game_matrix'] = $_SESSION['game_matrix'];
    $data['total_targets'] = $_SESSION['total_targets'];
    http_response_code(200);
}
else
{
    $data['game_matrix'] = false;
    $data['errors'] = ['Game board is not ready'];
    http_response_code(400);
}

echo json_encode($data);