<div class="container">
    <div class="starter-template">
        <h1>Battleship game</h1>

        <div class="row">
            <br>
            <?php

            if(isset($_SESSION['gamer'])):
                $gamer = $_SESSION['gamer']; // set gamer to session
                $_SESSION['game_start'] = date('Y-m-d H:i:s'); // set start time of game

                // Create game board and place ships
                $LShip =  \Classes\Games\Battleship\Ships\LShip::getSize();
                $IShip =  \Classes\Games\Battleship\Ships\IShip::getSize();
                $DotShip =  \Classes\Games\Battleship\Ships\DotShip::getSize();

                $game = new \Classes\Games\Battleship\BattleShip([$LShip,$IShip,$DotShip,$DotShip]);
                $matrix = $game->getMatrix();
                $_SESSION['game_matrix'] = $matrix;
                $_SESSION['total_targets'] = $game->getTargetCount();
            ?>
            <div class="row">
                <h5>Hello, <b><?=$gamer['fullname']?></b>. You have <b class="text-success"><?=$gamer['wins']?></b> wins and <b class="text-danger"><?=$gamer['fails']?></b> fails of battles</h5>
                <a class="btn btn-danger" href="?route=gamers/logout">Logout</a>
                <a class="btn btn-primary" href="?route=game/top">Top 10</a>
                <a class="btn btn-primary" href="?route=gamers/my_games">My finished games</a>
                <hr>
                <form class="start_game" method="POST" action="?route=game/start_game">
                    <div><button class="start_game_btn btn btn-success">Click To Start</button></div>
                </form>
                <br>

            </div>
            <br>
            <form class="row battle_area hidden" method="POST" action="?route=game/save">
                <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                    <h4 class="hit_counter"><b>Hit counter:</b> <span class="hit_number text-success">0</span></h4>
                    <h4 class="miss_counter"><b>Miss counter:</b> <span class="miss_number text-danger">0</span></h4>
                    <br>
                    <h4><b>Maximum allowed misses:</b> <span class="text-info"><?=config('max_misses')?></span></h4>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 text-center">
                    <table class="center-block text-danger">
                        <tbody>
                        <?php foreach ($matrix as $mkey => $rows): ?>
                            <tr>
                                <?php foreach ($rows as $key=>$value): ?>
                                    <td class="col-md-1 col-sm-1 col-xs-1 battle_area_square <?= ($value) == 1 && config('show_target_ships') == 1 ? 'bg-danger':''?>" data-row="<?=$mkey?>" data-column="<?=$key?>" id="bas_<?=$mkey.'_'.$key?>"></td>
                                <?php endforeach;?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="clearfix"></div>

            </form>

            <?php else: ?>
            <form method="POST" action="?route=gamers/new" id="new_gamer">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email" value="">
                </div>
                <div class="form-group">
                    <label>Fullname</label>
                    <input type="text" class="form-control" name="fullname" value="">
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Start game</button>
                </div>
            </form>
            <?php endif; ?>

        </div>
        <hr>
    </div>

</div><!-- /.container -->