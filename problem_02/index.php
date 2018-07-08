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

                // validation
                if (is_numeric($player_id)) {

                    $player_id_col = $db->query("SELECT * FROM player WHERE player_id=".$player_id.";");
                    $player_id_exists = $player_id_col->num_rows;
                    
                    if (!$player_id_exists) {
                        echo 'Player ID'.$player_id.' does not exist';
                        break;
                    };

                } else {
                    echo('Player ID must be a number.');
                    break;
                };

                if (is_numeric($coins_won)) {
                    //
                } else {
                    echo('Coins Won must be a number.');
                    break;
                };

                if (is_numeric($coins_bet)) {
                    //
                } else {
                    echo('Coins Bet must be a number.');
                    break;
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