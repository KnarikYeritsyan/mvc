<h1>Home page...</h1>

<div align="center">
    <button type="button" name="add" id="add" class="btn btn-info">Add new task</button>
</div>
<br />
<table class="table table-bordered table-striped">
    <tr>
        <th width=\"40%\">Name <a href="index?page=<?php echo $tasks['current_page']?>&field=name&sort=ASC" class='fa fa-arrow-up <?php if ($tasks['field']!='name' || $tasks['sort']!='ASC')echo 'ui-priority-secondary'?>'></a><a href="index?page=<?php echo $tasks['current_page']?>&field=name&sort=DESC" class='fa fa-arrow-down <?php if ($tasks['field']!='name' || $tasks['sort']!='DESC')echo 'ui-priority-secondary'?>'></a></th>
        <th width=\"10%\">Email <a href="index?page=<?php echo $tasks['current_page']?>&field=email&sort=ASC" class='fa fa-arrow-up <?php if ($tasks['field']!='email' || $tasks['sort']!='ASC')echo 'ui-priority-secondary'?>'></a><a href="index?page=<?php echo $tasks['current_page']?>&field=email&sort=DESC" class='fa fa-arrow-down <?php if ($tasks['field']!='email' || $tasks['sort']!='DESC')echo 'ui-priority-secondary'?>'></a></th>
        <th width=\"10%\">Text</th>
        <th width=\"10%\">Status <a href="index?page=<?php echo $tasks['current_page']?>&field=status&sort=ASC" class='fa fa-arrow-up <?php if ($tasks['field']!='status' || $tasks['sort']!='ASC')echo 'ui-priority-secondary'?>'></a><a href="index?page=<?php echo $tasks['current_page']?>&field=status&sort=DESC" class='fa fa-arrow-down <?php if ($tasks['field']!='status' || $tasks['sort']!='DESC')echo 'ui-priority-secondary'?>'></a></th>
    </tr>
<?php foreach($tasks['tasks'] as $task) {?>
    <tr>
        <td><?php echo $task['name']?></td>
        <td><?php echo $task['email'] ?></td>
        <td><?php echo $task['text']?></td>
        <td><?php echo $task['status']?"<span class='fa fa-check'></span>Done":'' ?></td>
    </tr>
<?php }?>
</table>
<br />
<?php if ($tasks['total_pages']>1){ ?>
<div class="text-center">
<ul class="pagination">
    <li><a href="index?page=1<?php if (isset($tasks['field']) && isset($tasks['sort']))echo "&field=".$tasks['field']."&sort=".$tasks['sort']; ?>">First</a></li>
    <li class="<?php if($tasks['current_page'] <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($tasks['current_page'] <= 1){ echo '#'; } else { echo "index?page=".($tasks['current_page'] - 1);if (isset($tasks['field']) && isset($tasks['sort']))echo "&field=".$tasks['field']."&sort=".$tasks['sort']; } ?>">&lt;</a>
    </li>
    <li class="disabled">
        <a href="#"><?php echo $tasks['current_page'] ?></a>
    </li>
    <li class="<?php if($tasks['current_page'] >= $tasks['total_pages']){ echo 'disabled'; } ?>">
        <a href="<?php if($tasks['current_page'] >= $tasks['total_pages']){ echo '#'; } else { echo "index?page=".($tasks['current_page'] + 1);if (isset($tasks['field']) && isset($tasks['sort']))echo "&field=".$tasks['field']."&sort=".$tasks['sort'];} ?>">&gt;</a>
    </li>
    <li><a href="index?page=<?php echo $tasks['total_pages'];if (isset($tasks['field']) && isset($tasks['sort']))echo "&field=".$tasks['field']."&sort=".$tasks['sort']; ?>">Last</a></li>
</ul>
</div>
<?php }?>
<div id="taskModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss ="modal">&times</button>
            <h4 class="modal-title">Add task</h4>
        </div>
        <div class="modal-body">
            <form id="task_form" method="post" enctype="multipart/form-data">
                <div class = "form-inline">
                    <label >Name</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Name"/>
                </div>
                <div class = "form-inline">
                    <label >Email</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="Email"/>
                    <span id="email-error" class="text-danger"></span>
                </div>
                <br>
                <div class = "form-inline">
                    <label >Text</label>
                    <textarea class="form-control" name="text" id="text" placeholder="Write a comment"></textarea>
                </div>
                <div class = "row">
                    <div class="col-lg-8">
                        <label></label><span class="text-danger" id="error"></span>
                    </div>
                </div>
                <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss ="modal">Close</button>
        </div>
    </div>
</div>
<script>
    function validEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    $(document).ready(function(){
        $('#add').click(function () {
            $('#taskModal').modal('show');
        });
        $('#task_form').submit(function (event) {
            event.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var text = $('#text').text;
            if ($.trim(name).length > 0 && $.trim(email).length > 0 && $.trim(text).length > 0)
            {
                $('#error').text("");
                if(validEmail($.trim(email))){
                    $.ajax({
                        url: "<?php echo URL;?>index/create",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            alert(data);
                            $('#task_form')[0].reset();
                            $('#taskModal').modal('hide');
                            location.reload();
                        },
                        error:function (data) {
                            $('#error').text(data.responseJSON.message);
                        }
                    })
                }else {
                    $('#email-error').text("Invalid Email");
                    document.getElementById("email").style.borderColor = "red";
                }
            }else{
                $('#error').text("Please fill important fields");
                document.getElementById("name").style.borderColor = "red";
                document.getElementById("email").style.borderColor = "red";
                document.getElementById("text").style.borderColor = "red";
                return false;
            }
                });
    });
</script>
