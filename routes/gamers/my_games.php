<?php
if(isset($_SESSION['gamer'])):
    $gamer = $_SESSION['gamer'];
?>
<div class="container">
    <div class="starter-template">
        <h1>Battleship game</h1>
        <h3>My finished games</h3>
        <div class="row">
            <a class="btn btn-primary" href="?route=game/index">Start Game</a>
            <hr>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <th>Game started</th>
                <th>Game ended</th>
                <th>Has Won ?</th>
                </thead>
                <tbody class="text-left">
                <?php

                $results = \Classes\Db::getInstance()->raw("SELECT `game_start`, `game_end`, `has_won` FROM `games` WHERE `gamer_id` = '".$gamer['id']."' ");
                if($results):
                    $i=1;
                    foreach ($results as $result):
                        ?>
                        <tr>
                            <td><?=$result['game_start']?></td>
                            <td><?=$result['game_end']?></td>
                            <td><?=($result['has_won'] == 1) ? 'Yes':'No'?></td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- /.container -->
<?php
else:
    header('Location: /');
endif;
?>