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
    <script>
        function check_login() {
            var tab_id = sessionStorage.getItem("tab");
            $.ajax({
                url: "<?php echo URL; ?>index/check",
                method: "POST",
                data: {tab_id:tab_id},
                success: function (data) {
                    console.log(data)
                    if(data == 'yes tab'){
                        if(window.location.href == "<?php echo URL; ?>login"){
                            window.location.href= "<?php echo URL; ?>dashboard";
                        }
                        $('#login-div').html(
                            '            <a class="navbar-brand" href="<?php echo URL; ?>dashboard">Admin</a>' +
                            '            <ul class="nav navbar-nav navbar-left">' +
                            '            <li class="dropdown">' +
                            '                <a href="#" class="dropdown-toggle"' +
                            '                   data-toggle="dropdown">Log out<b class="caret"></b>' +
                            '                    <ul class="dropdown-menu">' +
                            '                        <li><a onclick="event.preventDefault();sessionStorage.clear();document.getElementById(\'logout-form\').submit();" href="<?php echo URL; ?>dashboard/logout">Log out</a></li>' +
                            '                        <form id="logout-form" action="dashboard/logout" method="POST" style="display: none;">' +
                            '                        </form>' +
                            '                    </ul>' +
                            '                </a>' +
                            '            </li>' +
                            '        </ul>'
                        )
                    }else {
                        if(window.location.href == "<?php echo URL; ?>dashboard"){
                            window.location.href= "<?php echo URL; ?>login";
                        }
                        $('#login-div').html(
                            '<a class="navbar-brand" href="<?php echo URL; ?>login">Login</a>'
                        )
                    }
                }
            })
        }
        window.onload = function () {
            check_login();
        };
        setInterval(function(){
            check_login()
        }, 5000);
    </script>
</head>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL; ?>">Home</a>
        <div id="login-div"></div>
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