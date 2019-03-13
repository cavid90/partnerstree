<?php
if(isset($_SESSION['gamer']))
{
    unset($_SESSION['gamer']);
}

header('Location: /');