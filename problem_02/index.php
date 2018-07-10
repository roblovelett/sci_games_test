<html>
    <head></head>
    <body>
        <!-- 
            
            Problem 2: Implement a basic spin results end point
            
            Description

            Slot Machine Spin Results is our server end point that updates all player data and features when a spin is 
            completed on the client. We do hundreds of millions of these requests per day, and we would like to see you 
            make a very basic MySQL driven version. This can be just a normal PHP file that gets called, or you can 
            implement more modern routing if you would like
            
            Data Storage
            Create a MySQL database that contains a player table with the following fields:
            
            Player ID
            Name
            Credits
            Lifetime Spins
            Salt Value
            Code
            
            Your code should validate the following request data: hash, coins won, coins bet, player ID
            Update the player data in MySQL if the data is valid
            
            Generate a JSON response with the following data:
            
            Player ID
            Name
            Credits
            Lifetime Spins
            Lifetime Average Return
            
            You can assume that the client making the request has the salt value to make the hash.
            Submission Please upload your code and MySQL schema to either Bit Bucket or Github

        -->
        <?php
            
            $host = "scigames";
            $user = "root";
            $password = "";
            $database = "sci_games_test";

            $db = new mysqli($host, $user, $password, $database);

            if (isset($_POST['submit'])) {
                
                $player_id = $_REQUEST['player_id'];
                $coins_won = $_REQUEST['coins_won'];
                $coins_bet = $_REQUEST['coins_bet'];

                $validated = FALSE;
                $valid_msg = 'must be a number';
                
                if (!is_numeric($player_id)) {
                    echo('Player ID '.$valid_msg.'.');
                    break;
                } else if (!is_numeric($coins_won)) {
                    echo('Coins Won '.$valid_msg.'.');
                    break;
                } else if (!is_numeric($coins_bet)) {
                    echo ('Coins Bet '.$valid_msg.'.');
                    break;
                } else {

                    $valid_msg = $valid_msg.' greater than zero.';
                    
                    if ($player_id < 1 ){
                        echo('Player ID '.$valid_msg);
                        break;
                    } else if ($coins_won < 0) {
                        echo('Coins Won '.$valid_msg);
                        break;
                    } else if ($coins_bet < 0) {
                        echo('Coins Bet '.$valid_msg);
                        break;
                    } else {
                        $validated = TRUE;
                    };
                };

                if ($validated) {

                    $player_id_col = $db->query("SELECT * FROM player WHERE player_id=".$player_id.";");
                    $player_id_exists = $player_id_col->num_rows;
                    
                    if (!$player_id_exists) {
                        echo 'Player ID'.$player_id.' does not exist';
                        break;
                    } else {

                        // read
                        $credits = mysqli_fetch_array($db->query("SELECT credits FROM player WHERE player_id=".$player_id.";"), MYSQLI_NUM);
                        $credits = $credits[0];

                        $lifetime_spins = mysqli_fetch_array($db->query("SELECT lifetime_spins FROM player WHERE player_id=".$player_id.";"), MYSQLI_NUM);
                        $lifetime_spins = $lifetime_spins[0];
                        
                        $name = mysqli_fetch_array($db->query("SELECT name FROM player WHERE player_id=".$player_id.";"), MYSQLI_NUM);
                        $name = $name[0];

                        $credits = $credits - $coins_bet + $coins_won;
                        $lifetime_spins++;
                        $returns = $credits/$lifetime_spins;
                        $avg_return = $returns/$lifetime_spins;
                        
                        // update
                        $db->query("UPDATE player SET credits=".$credits." WHERE player_id=".$player_id.";");
                        $db->query("UPDATE player SET lifetime_spins=".$lifetime_spins." WHERE player_id=".$player_id.";");

                        // create json obj
                        $res = new stdClass();
                        $res->player_id = $player_id;
                        $res->name = $name;
                        $res->credits = $credits;
                        $res->lifetime_spins = $lifetime_spins;
                        $res->avg_return = $avg_return;

                        // write json
                        $fp = fopen('output.json', 'w');
                        fwrite($fp, json_encode((array)$res));
                        fclose($fp);

                    };
                };
            };
            
        ?>

        <form name="form" action="" method="post">
            Player ID: <input type="text" name="player_id" id="player_id" value="" /><br />
            Coins Won: <input type="text" name="coins_won" id="coins_won" value="" /><br />
            Coins Bet: <input type="text" name="coins_bet" id="coins_bet" value="" /><br />
            <input type="submit" name="submit" />
        </form>
    </body>
</html>