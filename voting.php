<?php
require_once 'config.php';

use Erpk\Harvester\Module\Citizen\CitizenModule;

if (!isset($_SESSION['citizen'])) {
    header("Location: index.php");
}

$module = new CitizenModule($client);

$date = date("Y-m-d H:i:s");
$query = $mysqli->query("SELECT * FROM elections WHERE startTime < '$date' AND endTime > '$date'");

if ($query->num_rows == 0) {
    header("Location: index.php");
}

$election = $query->fetch_array();

$query = $mysqli->query("SELECT * FROM votes WHERE election = {$election['id']} AND erep_id = {$_SESSION['citizen']}");
if ($query->num_rows == 0) {
    $vote = false;
} else {
    $vote = $query->fetch_array();
}

//Types: 1 => CP Election, 2 => PP Election

$isCandidate = false;
$candidates = array();
$query = $mysqli->query("SELECT * FROM candidates WHERE election = {$election['id']}");
while ($result = $query->fetch_array()) {
    if ($_SESSION['citizen'] == $result['erep_id']) $isCandidate = true;
    $id = $result['id'];
    $candidates[$id] = $module->getProfile($result['erep_id']);
}

$monthYear = date("F Y", strtotime($election['endTime']));
$type = ($election['type'] == 1) ? 'Country President' : 'Party President';

$current = (!$vote) ? 'None' : (($vote['single'] == 0 || !$vote['single']) ? 'Abstain' : $candidates[$vote['single']]['name']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Federalist Party Voting System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="css/cover.css" type="text/css" rel="stylesheet" />
    <link href="css/style.css" />

    <script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
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
                <h1 class="cover-heading"><u><b><?php echo $monthYear . " " . $type ?> Election</b></u></h1>
                <h3 class="cover-heading"><b>Current Vote:</b> <i><?php echo $current ?></i></h3>
                <!--<h3 class="cover-heading">Current Results</h3>
                --><?php
/*                foreach ($candidates as $i => $candidate) {
                    $q = $mysqli->query("SELECT * FROM votes WHERE single = $i");
                    $votes = $q->num_rows;
                }
                */?>
                <form class="" action="vote.php" method="post">
                    <div class="radio">
                        <label>
                            <input type="radio" name="vote" value="0" required <?php if ($vote && $vote['single'] == 0) echo 'checked' ?> />
                            Abstain
                        </label>
                    </div>
                    <?php
                    foreach ($candidates as $i => $candidate) {
                        ?>
                        <div class="radio">
                            <label>
                                <input type="radio" name="vote" value="<?php echo $i ?>" required <?php if ($vote && $vote['single'] == $i) echo 'checked' ?> />
                                <?php echo $candidate['name']; ?>
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                    <span id="submitVote" <?php if ($isCandidate) echo 'data-toggle="tooltip" data-placement="bottom" title="You are not allowed to vote in an election you are running in."' ?>>
                        <button type="submit" class="btn btn-primary" <?php if ($isCandidate) echo 'disabled="disabled"' ?>>Submit Vote</button>
                    </span>
                </form>
                <div id="error" class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    We were unable to place your vote.
                </div>
                <div id="success" class="alert alert-success alert-dismissible" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Your vote has been placed!
                </div>
                <?php
                if (isset($_SESSION['success'])) {
                    if ($_SESSION['success'] == 'no') {
                        ?>
                        <script>
                            $("#error").show();
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            $("#success").show();
                        </script>
                        <?php
                    } unset($_SESSION['success']);
                }
                ?>
            </div>
            <div class="mastfoot">
                <div class="inner">
                    <p>&copy; Copyright Federalist Party 2016</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

