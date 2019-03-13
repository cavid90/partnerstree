<div class="container">
    <div class="starter-template">
        <h1>Battleship game</h1>
        <h3>Top 10 players</h3>
        <div class="row">
            <a class="btn btn-primary" href="?route=game/index">Start Game</a>
            <hr>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <th>Place</th>
                <th>Fullname</th>
                <th>Wins</th>
                </thead>
                <tbody class="text-left">
                <?php
                $results = \Classes\Db::getInstance()->raw("SELECT `fullname`, `wins` FROM `gamers` ORDER BY `wins` DESC LIMIT 10 ");
                if($results):
                    $i=1;
                    foreach ($results as $result):
                        ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$result['fullname']?></td>
                            <td><?=$result['wins']?></td>
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