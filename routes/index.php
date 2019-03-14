<div class="container">
    <div class="starter-template">
        <a href="?route=game/index" class="btn btn-info">Go to game</a>
    </div>
    <hr>
    <h3>Battleship game</h3>
    <h4>Installation</h4>

    <ul>
        <li>1. Open <b>config/database.php</b> file and replace database credentials with yours</li>
        <li>2. Start install.php file (Example: <b>http://yoursite.com/install.php</b>) or <a href="install.php">Click Here</a></li>
        <li>3. By default target ships colors are visible. Just set show_target_ships to 0 in config/app.php file</li>
    </ul>

    <h4>What and Where</h4>
    <ul>
        <li>Routes are placed in routes folder file by file in related folder: index, game, gamers</li>
        <li>Javascript is written in <b>assets/js/custom.js</b></li>
        <li>There is config function which is written in functions.php file</li>
        <li>Composer works, can add packages. But there was no need.</li>
        <li>
            For adding new route-view: create a folder or file inside routes folder.
            <br/>
            The the url will be, for example: <b>/?route=folderName/fileName.php</b>
        </li>
        <li>Database sql file is in <b>database</b> folder</li>
    </ul>
</div><!-- /.container -->