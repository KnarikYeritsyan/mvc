<h1><?php echo $title ?></h1>
<div style = "padding: 100px 100px 10px;">
    <form class = "bs-example bs-example-form"  action="login/auth" method="post" id="MyForm" novalidate>
        <div class = "row">
            <div class = "col-lg-8">
                <div class = "form-inline">
                    <label >Username</label>
                    <input type = "text" class = "form-control" name = "username" placeholder="Enter username" id="username" required />
                </div>
                <span class="error"></span>
            </div><br>
            <div class = "col-lg-8">
                <div class = "form-inline">
                    <label >Password</label>
                    <input type="password" name = "password" placeholder="Enter password" class = "form-control" id="password" required />
                </div>
                <div class = "row">
                    <div class="col-lg-8">
                        <label></label><span id="error"></span>
                    </div>
                </div>
                <br />
                <label></label><input class="btn btn-primary"  type="submit" value="Log In" name="login"/>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('#MyForm').submit(function (event) {
            event.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();
            var tab_id = btoa(Math.random()).slice(0,20);
            if ($.trim(username).length > 0 && $.trim(password).length > 0)
            {
                $.ajax({
                    url:"<?php echo URL; ?>login/auth",
                    method:"POST",
                    data:{username:username, password:password,tab_id:tab_id},
                    cashe:false,
                    success:function (data) {
                        if (data)
                        {
                            sessionStorage.setItem("tab",tab_id);
                            $("body").hide();
                            window.location.href= "<?php echo URL; ?>dashboard";
                        }
                        else
                        {
                            $('#error').html("<span class='text-danger'>Invalid username or password</span>");
                            document.getElementById("username").style.borderColor = "red";
                            document.getElementById("password").style.borderColor = "red";
                        }
                    },
                    error:function (data) {
                        $('#error').html("<span class='text-danger'>Something went wrong</span>");
                    }
                });
            }
            else
            {
                $('#error').html("<span class='text-danger'>Please fill important fields</span>");
                document.getElementById("username").style.borderColor = "red";
                document.getElementById("password").style.borderColor = "red";
                return false;
            }
        });
    });
</script>
