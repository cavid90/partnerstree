<?php
$data = [
    'success' => false
];
$errors = [];

/**
 * Get POST data
 */

$email       = array_key_exists('email',$_POST) ? $_POST['email'] : '';
$fullname    = array_key_exists('fullname', $_POST) ? $_POST['fullname'] : '';

/**
 * Check inputs
 */
if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) == false)
{
    $errors['email'] = 'Email is wrong or empty';
}

if (empty($fullname))
{
    $errors['fullname'] = 'Fullname should not be empty';
}

/**
 * Send data to client
 */
if (count($errors) == 0)
{
   $find_gamer = \Classes\Db::getInstance()->raw("SELECT `id`, `fullname`, `wins`, `fails` FROM `gamers` WHERE `email` = '".$email."' ")->fetch(PDO::FETCH_ASSOC);
   if (!$find_gamer)
   {
       $gamer = [
           'email'    => $email,
           'fullname' => $fullname,
           'wins'     => 0,
           'fails'     => 0
       ];
       $id = \Classes\Db::getInstance()->insert('gamers', $gamer);
       $gamer['id'] = $id;
       $find_gamer = $gamer;
   }

   $data['gamer']       = $find_gamer;
   $data['success']     = true;
   $_SESSION['gamer']   = $find_gamer;
   http_response_code(200);

}
else
{
    $data['errors'] = $errors;
    http_response_code(400);
}

echo json_encode($data);