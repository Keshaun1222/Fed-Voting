<?php
require_once 'config.php';

/*use Erpk\Harvester\Module\Citizen\CitizenModule;

$module = new CitizenModule($client);

$citizen = $module->getProfile(5065893);
print_r($citizen);
echo "\r\n";
//if ($citizen['party']['id'] == $fedsID) echo 'A FED!!!!';*/
$date = date("Y-m-d H:i:s", time() - (60 * 60 * 2));
$query = $mysqli->query("SELECT * FROM elections WHERE startTime < $date  AND endTime > $date");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Federalist Party Voting System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="css/cover.css" type="text/css" rel="stylesheet" />
    <link href="css/style.css" />

    <script src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</head>
<body>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">The Federalist Party</h3>
                </div>
            </div>
            <div class="inner cover">
                <?php
                if ($query->num_rows == 0) {
                    ?>
                    <div id="electionError" class="alert alert-danger" role="alert">
                        There is no election going on at this moment.
                    </div>
                    <?php
                } else {
                    $election = $query->fetch_array();
                    if (strtotime($election['endTime']) < time()) {
                        ?>
                        <div id="electionEnded" class="alert alert-info" role="alert">
                            An election has recently ended. Please wait for the results to be announced.
                        </div>
                        <?php
                    } else {
                    ?>
                    <!--<h1 class="cover-heading">Enter Your eRepublik ID</h1>-->
                    <form class="form-inline" action="check.php" method="post">
                        <label for="id" class="sr-only">eRepublik ID</label>
                        <input type="number" id="id" name="id" class="form-control" placeholder="eRep ID" required
                               autofocus/>
                        <button id="submit" name="submit" class="btn btn-primary" type="submit">&raquo;</button>
                    </form>
                    <div id="fedError" class="alert alert-danger" role="alert" style="display: none;">
                        You must be a member of the <a href="http://www.erepublik.com/en/party/federalist-party-2263/1"
                                                       target="_blank">Federalist Party in order to vote.
                    </div>
                    <div id="citError" class="alert alert-danger" role="alert" style="display: none;">
                        The eRep ID you provided does not match an existing citizen.
                    </div>
                    <div id="deadError" class="alert alert-danger" role="alert" style="display: none;">
                        The citizen associated with the provided eRep ID is either dead or banned.
                    </div>
                <?php
                if (isset($_SESSION['error'])) {
                if ($_SESSION['error'] == 'fed') {
                ?>
                    <script>
                        $("#fedError").show();
                    </script>
                <?php
                } else if ($_SESSION['error'] == 'cit') {
                ?>
                    <script>
                        $("#citError").show();
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        $("#deadError").show();
                    </script>
                    <?php
                }

                    unset($_SESSION['error']);
                }
                }
                }
                ?>
            </div>
            <div class="mastfoot">
                <div class="inner">
                    <!--<p>&copy; Copyright <a href="http://www.eotir.com/" target="_blank">Era of the Imperial Republic RPG</a></p>-->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
