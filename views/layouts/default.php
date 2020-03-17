<?php Session::init(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <link rel="stylesheet" type="text/css" href = "<?php echo URL; ?>public/css/default.css" />
    <link rel="stylesheet" href = "<?php echo URL; ?>public/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href = "<?php echo URL; ?>public/bootstrap/css/jquery-ui.css" />
    <link rel="stylesheet" href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>public/bootstrap/js/bootstrap.min.js"></script>
</head>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL; ?>">Home</a>
        <?php if (Session::get('loggedIn')==true):?>
            <a class="navbar-brand" href="<?php echo URL; ?>dashboard">Admin</a>
            <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle"
                   data-toggle="dropdown">Log out<b class="caret"></b>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo URL; ?>dashboard/logout">Log out</a></li>
                    </ul>
                </a>
            </li>
        </ul>
        <?php else:?>
            <a class="navbar-brand" href="<?php echo URL; ?>login">Login</a>
        <?php endif; ?>
    </div>
</nav>
<body>
<div id="content">
    <?php echo $layout_content; ?>
</div>
<div class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="container">
        <div class="navbar-text pull-left">
            <p>(C) Copyright <?php echo date('Y') ?></p>
        </div>
    </div>
</div>
</body>
</html>