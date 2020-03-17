<h1>Dashboard...</h1>

<div align="center">
    <button type="button" name="add" id="add" class="btn btn-info">Add new task</button>
</div>
<br />
<table class="table table-bordered table-striped">
    <tr>
        <th width=\"40%\">Name</th>
        <th width=\"10%\">Email</th>
        <th width=\"10%\">Text</th>
        <th width=\"10%\">Status</th>
        <th width=\"10%\">Save</th>
    </tr>
    <?php foreach($tasks as $task) {?>
        <tr>
            <td><?php echo $task['name']?></td>
            <td><?php echo $task['email'] ?></td>
            <td><textarea id="text<?php echo $task['id']?>"><?php echo $task['text']?></textarea>
                <br><span id="text-error<?php echo $task['id']?>" class="text-danger"></span>
            </td>
            <td>
                <fieldset>
                    <label for="checkbox-<?php echo $task['id']?>">Done</label>
                    <input <?php if($task['status'])echo "checked" ?> type="checkbox" class="check-done" name="checkbox-<?php echo $task['id']?>" data-id="<?php echo $task['id']?>" id="checkbox-<?php echo $task['id']?>">
                    <br><span id="check-error<?php echo $task['id']?>" class="text-danger"></span>
                </fieldset>
            <br><?php echo $task['text_status']?"<span class='fa fa-check'></span>Edited":'' ?>
            </td>
            <td><button type="button" name='update' class='btn btn-success bt-xs update' data-id="<?php echo $task['id']?>">Save</button></td>
        </tr>
    <?php }?>
</table>
<br />
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
        $(document).on('change','.check-done',function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            if($('#checkbox-'+id).is(":checked")) {
                var check =1;
            } else {
                check =0;
            }
                $.ajax({
                    url: "<?php echo URL;?>dashboard/update_check",
                    method: "POST",
                    data: {id:id,status:check},
                    success: function (data) {
                        if (data) {
                            alert(data);
                            location.reload();
                        }else {
                            $('#check-error'+id).text('Could not be updated');
                        }
                    },
                    error:function (data) {
                        $('#check-error'+id).text(data.responseJSON.message);
                    }
                })
        });
        $(document).on('click','.update',function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var text = $('#text'+id).val();
                $.ajax({
                    url: "<?php echo URL;?>dashboard/update",
                    method: "POST",
                    data: {id:id,text:text},
                    success: function (data) {
                        if (data) {
                            alert(data);
                            location.reload();
                        }else {
                            $('#text-error'+id).text('Could not be updated');
                        }
                    },
                    error:function (data) {
                        $('#text-error'+id).text(data.responseJSON.message);
                    }
                })
        });
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
                            if (data) {
                                alert(data);
                                $('#task_form')[0].reset();
                                $('#taskModal').modal('hide');
                                location.reload();
                            }else {
                                $('#error').text("Could not be created");
                            }
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
