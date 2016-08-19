<?php
require_once 'config.php';

if (isset($_POST['submit'])) {
    if (md5($_POST['password']) == md5('proudhorny2016')) {
        $_SESSION['admin'] = 'true';
        header('Location: admin.php');
    }
}
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
                <form class="form-inline" action="login.php" method="post">
                    <label for="password" class="sr-only">Admin Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Admin Password" required autofocus />
                    <button id="submit" name="submit" class="btn btn-primary" type="submit">&raquo;</button>
                </form>
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
