
<style>
    /* The container */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        /*margin-bottom: 12px;*/
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
    }

    .container-checkbox label {
        margin-bottom: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #5cb85c;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .mt-5{
        margin-top: 5rem;

    }

    .confirm{
        color: limegreen;
        font-size: 30px;
        margin: auto;
    }
    .in_progress{
        color: #ff9b00;
        font-size: 30px;
        margin: auto;
    }

    .not_finished{
        color:red;
    }

    .table-hover>tbody>tr:hover {
        background-color: #d7d7d7;
    }

    .anyClass {
        height:150px;
        overflow-y: scroll;
    }

    .style-1::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }


    .style-1::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .style-1::-webkit-scrollbar
    {
        width: 7px;
        background-color: #F5F5F5;
    }

    .errorValidation{
        border: solid 1px red;
    }

    .p-0{
        padding: 0 !important;
    }

    #validation_errors{
        color: red;
    }
</style>
<?php if($this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ADMIN) {
    $admin_or_manager = true;
} else {
    $admin_or_manager = false;
}?>
<div id="headerbar">
    <h1 class="headerbar-title"><?php echo $ticket->todo_ticket_name; ?></h1>

    <div class="headerbar-item pull-right">
        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <div class="btn-group btn-group-sm">
                <a href="<?php echo site_url('todo_tickets/form/' . $ticket->todo_ticket_id); ?>" class="btn btn-default">
                    <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
                </a>
                <a class="btn btn-danger"
                   href="<?php echo site_url('tickets/delete/' . $ticket->todo_ticket_id); ?>"
                   onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                    <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>


<div id="content">
    <?php if ($this->session->flashdata('alert_success')) { ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
    <?php } ?>
    <div class="row">

        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default no-margin">
                <div class="panel-heading"><?php _trans('ticket'); ?></div>
                <div class="panel-body table-content">
                    <table class="table no-margin">
                        <tr>
                            <th><?php _trans('status'); ?></th>
                            <td><?php _htmlsc($ticket_statuses["$ticket->todo_ticket_status"]['label']); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('todo_number'); ?></th>
                            <td><?php _htmlsc($ticket->todo_ticket_number); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('todo_name'); ?></th>
                            <td><?php _htmlsc($ticket->todo_ticket_name); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('assign_to'); ?></th>
                            <td><?php echo anchor('users/form/' . $ticket->todo_ticket_assigned_user_id, $ticket->todo_ticket_assigned_user_name); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('todo_description'); ?></th>
                            <td><?php _htmlsc($ticket->todo_ticket_description); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('guest_url'); ?></th>
                            <td><a href="<?php echo site_url('guest/view/todo_ticket/' .$ticket->todo_ticket_url_key) ?>"><?php echo site_url('guest/view/todo_ticket/' .$ticket->todo_ticket_url_key) ?></a></td>
                        </tr>
                        <tr>
                            <th><?php _trans('attachment'); ?></th>
                            <td><a href="<?php echo $ticket->ticket_document_link; ?>"><?php echo $ticket->ticket_document_link; ?></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="col-lg-8 text-center">
                <div class="well">
                    <h4>What is on your mind?</h4>
                    <div class="input-group" style="margin-top: 5%;">



                        <div class="comment_header">
                            <div class="col-md-8 p-0">
                                <textarea name="todo_comment" class="form-control input-sm chat-input" rows="1" placeholder="Write your comment here..."></textarea>
                            </div>
                            <div class="col-md-4 p-0">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm add_comment" data-ticket-id="<?=$ticket->todo_ticket_id?>"><i class="fa fa-comments" aria-hidden="true"></i> Add Comment</button>
                                </span>
                            </div>
                        </div>
                        <div id="validation_errors"></div>


                    </div>
                    <hr>
                    <ul id="sortable" class="list-unstyled ui-sortable anyClass style-1 comments_list" style="padding-right: 10px">

                        <?php foreach ($tickets_comments as $tickets_comment) { ?>
                            <strong class="pull-left primary-font"><?_htmle($tickets_comment->user_name)?></strong>
                            <small class="pull-right text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i><?_htmle($tickets_comment->ticket_created_date)?> </small>
                            </br>
                            <li class="ui-state-default text-left" style="margin-left: 5%">
                                - <?_htmle($tickets_comment->ticket_comment)?>
                            </li>
                            </br>
                        <?php } ?>


                    </ul>
                </div>
            </div>
            <?php if ($admin_or_manager) { ?>
                <div class="col-lg-4 col-12 text-center grade_ticket_block">
                    <div class="form-group col-8">
                        <label for="grade_ticket"><?php _trans('grade_ticket'); ?></label>
                        <select class="form-control" name="grade_ticket">
                            <option>Select a grade</option>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                    <option value="<?= $i ?>" <?= isset($current_grade) && $current_grade == $i ? 'selected' : ''?> ><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <button class="btn btn-success grade_ticket" id="grade_ticket">Grade</button>
                    </div>
                </div>
            <?php } else {
                $color = 'green';
                if (!isset($current_grade) || !$current_grade) {
                    $current_grade = 'Not graded yet!';
                    $color = 'red';
                }
                echo "<div class='col-lg-4 col-12 text-center grade_ticket_block'>
                    <div class='form-group col-8'><p class='' style='padding-top: 15px; color:" .  $color . "'>Ticket grade - " . $current_grade . "</p></div>
                </div>";
            }?>
    </div>

</div>



    <div class="mt-5" >
        <h2><?php _trans('todo_tasks'); ?></h2>
        <table class="table table-hover">
            <thead>
            <tr>
                <th><?php _trans('id'); ?></th>
                <th ><?php _trans('todo_task'); ?></th>
                <th ><?php _trans('project'); ?></th>
                <th><?php _trans('created_date'); ?></th>
                <th><?php _trans('deadline'); ?></th>
                <th><?php _trans('todo_task_number_of_hours'); ?></th>
                <th><?php _trans('attachment'); ?></th>
                <th><?php _trans('status'); ?></th>
                <th><?php _trans('task_grade'); ?></th>

            </tr>
            </thead>
            <tbody>

            <?php


            foreach ($todo_tasks as $key => $todo_task) {
                ?>
                <tr>
                    <td><?=$todo_task->todo_ticket_todo_task_id;?></td>
                    <td width="950"><?=$todo_task->todo_task_text;?></td>
                    <td><?=$todo_task->project_name;?></td>
                    <td  class="text-center"><?=$todo_task->todo_task_created_date;?></td>
                    <td  class="text-center"><?=(!empty($todo_task->todo_task_deadline))?date('Y-m-d', strtotime($todo_task->todo_task_deadline)):'';?></td>
                    <td  class="text-center"><?=$todo_task->todo_task_number_of_hours;?></td>
                    <td><?= ($todo_task->todo_task_document_link ? '<a href="' . $todo_task->todo_task_document_link . '">' . $todo_task->todo_task_document_link . '</a>' : '' )?> </td>
                    <td class="text-center" style="min-width: 220px;">


                        <?php
                        $todo_task_time = explode(':',$todo_task->todo_task_number_of_hours);
                        if($todo_task_time[0] > 0 || $todo_task_time[1] > 0): ?>
                            <?php if($this->session->userdata('user_id') == $ticket->todo_ticket_assigned_user_id && $this->session->userdata('user_id') == $ticket->todo_ticket_created_user_id  ):  ?>
                                <?php _trans('no_status'); ?>
                            <?php else: ?>

                                <?php if($this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ADMIN ): ?>

                                    <?php if($this->session->userdata('user_id') != $ticket->todo_ticket_assigned_user_id ): ?>



                                       <?php if($todo_task->todo_task_status == 0): ?>
                                            <button class="btn btn-success finish" value="1" name="todo_test_status" data-id="<?=$todo_task->todo_task_id;?>"> <?php _trans('accepted'); ?> </button>
                                            <button class="btn btn-danger finish" value="2" name="todo_test_status" data-id="<?=$todo_task->todo_task_id;?>"> <?php _trans('not_accepted'); ?> </button>
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 1): ?>
                                            <b style="color: orange"><?php _trans('in_progress'); ?></b>
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 2): ?>
                                            <b style="color: #a94442;"><?php _trans('not_accepted'); ?></b>
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 3 ): ?>
                                                <b style="color: #5bc0de;"><?php _trans('working_today'); ?></b>
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 4): ?>
                                                <b style="color: #5bc0de;"><?php _trans('working_tomorrow'); ?></b>
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 5): ?>
                                                <b style="color: #5bc0de;"><?php _trans('in_planning'); ?></b>
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 6): ?>
                                            <div class="form-group">
                                                <select name="todo_task_status" id="todo_task_status"  class="form-control simple-select select2-hidden-accessible" tabindex="-1" aria-hidden="true"  data-id="<?=$todo_task->todo_task_id?>">
                                                    <option> <?php _trans('select_status'); ?></option>
                                                    <option value="7"  <?= ($todo_task->todo_task_status == 7)? 'selected' : '' ; ?>>  <?php _trans('finished'); ?> </option>
                                                    <option value="8" <?= ($todo_task->todo_task_status == 8)? 'selected' : '' ; ?>> <?php _trans('not_finished'); ?></option>
                                                    <option value="9" <?= ($todo_task->todo_task_status ==9)? 'selected' : '' ; ?>> <?php _trans('paid'); ?></option>
                                                </select>
                                            </div>
<!--                                            <button class="btn btn-success finish" value="7" name="todo_test_status" data-id="--><?//=$todo_task->todo_task_id;?><!--"> --><?php //_trans('confirm'); ?><!-- </button>-->
                                        <?php endif;?>

                                        <?php if($todo_task->todo_task_status == 7 || $todo_task->todo_task_status == 8): ?>
                                                <div class="form-group">
                                                    <select name="todo_task_status" id="todo_task_status"  class="form-control simple-select select2-hidden-accessible" tabindex="-1" aria-hidden="true"  data-id="<?=$todo_task->todo_task_id?>">
                                                        <option> <?php _trans('select_status'); ?></option>
                                                        <option value="7"  <?= ($todo_task->todo_task_status == 7)? 'selected' : '' ; ?>>  <?php _trans('finished'); ?> </option>
                                                        <option value="8"  <?= ($todo_task->todo_task_status == 8)? 'selected' : '' ; ?>>  <?php _trans('not_finished'); ?> </option>
                                                        <option value="9" <?= ($todo_task->todo_task_status == 9)? 'selected' : '' ; ?>> <?php _trans('paid'); ?></option>
                                                    </select>
                                                </div>
                                        <?php endif;?>
                                 <?php endif;?>
                                <?php endif;?>

                                <?php if($this->session->userdata('user_id') == $ticket->todo_ticket_assigned_user_id ): ?>
                                            <?php if($todo_task->todo_task_status == 0): ?>
                                                <b style="color: #928e8e"><?php _trans('sent_to_client'); ?></b>
                                            <?php endif;?>

                                            <?php if($todo_task->todo_task_status >= 1 && $todo_task->todo_task_status < 6 ): ?>
                                                    <?php if($todo_task->todo_task_status == 2): ?>
                                                        <b style="color: #a94442;"><?php _trans('not_accepted'); ?></b>
                                                    <?php else: ?>
                                                        <div class="form-group">
                                                            <select name="todo_task_status" id="todo_task_status" class="form-control simple-select select2-hidden-accessible" tabindex="-1" aria-hidden="true" data-id="<?=$todo_task->todo_task_id?>">
                                                                <option> <?php _trans('select_status'); ?></option>
                                                                <option value="3" <?= ($todo_task->todo_task_status == 3)? 'selected' : '' ; ?>> <?php _trans('working_today'); ?></option>
                                                                <option value="4" <?= ($todo_task->todo_task_status == 4)? 'selected' : '' ; ?>>  <?php _trans('working_tomorrow'); ?> </option>
                                                                <option value="5" <?= ($todo_task->todo_task_status == 5)? 'selected' : '' ; ?> >  <?php _trans('in_planning'); ?> </option>
                                                                <option value="6" >  <?php _trans('finished'); ?> </option>
                                                            </select>
                                                        </div>
                                                    <?php endif; ?>
                                            <?php endif;?>

                                            <?php if($todo_task->todo_task_status == 6): ?>
                                                <b style="color: orange"><?php _trans('in_progress'); ?></b>
                                            <?php endif;?>

                                            <?php if($todo_task->todo_task_status == 7): ?>
                                                <b style="color: green"><?php _trans('finished'); ?></b>
                                            <?php endif;?>

                                            <?php if($todo_task->todo_task_status == 8 ): ?>

                                                <div class="form-group">
                                                    <span class="not_finished">( <?php _trans('not_finished'); ?> )</span>
                                                    <select name="todo_task_status" id="todo_task_status" class="form-control simple-select select2-hidden-accessible" tabindex="-1" aria-hidden="true" data-id="<?=$todo_task->todo_task_id?>">
                                                        <option> <?php _trans('select_status'); ?></option>
                                                        <option value="3" <?= ($todo_task->todo_task_status == 3)? 'selected' : '' ; ?>> <?php _trans('working_today'); ?></option>
                                                        <option value="4" <?= ($todo_task->todo_task_status == 4)? 'selected' : '' ; ?>>  <?php _trans('working_tomorrow'); ?> </option>
                                                        <option value="5" <?= ($todo_task->todo_task_status == 5)? 'selected' : '' ; ?> >  <?php _trans('in_planning'); ?> </option>
                                                        <option value="6" >  <?php _trans('finished'); ?> </option>
                                                    </select>
                                                </div>
                                            <?php endif;?>

                                            <?php if($todo_task->todo_task_status == 9): ?>
                                                <b style="color: green"><?php _trans('paid'); ?></b>
                                            <?php endif;?>
                                        <?php endif;?>

                            <?php endif;?> <!--Assigned user-->

                        <?php else: ?>
                            <span class="text-danger"><b><?_trans('not_started_yet'); ?></b></span>
                        <?php endif;?>


                    </td>

                    <td class="col-12 text-center grade_per_task_block" style="min-width: 110px;">
                        <?php if ( $admin_or_manager ) { ?>
                         <select class="form-control" id="grade_per_task" name="grade_per_task" data-task-id="<?=$todo_task->todo_task_id;?>">
                             <option>Select</option>
                             <?php for ($i = 1; $i <= 10; $i++) { ?>
                                  <option class="per_grade" value="<?= $i ?>" <?= isset($todo_task->task_grade) && $todo_task->task_grade == $i ? 'selected' : ''?> ><?= $i ?></option>
                             <?php } ?>
                         </select>

                        <?php } else {?>
                            <div> <?= $todo_task->grade; ?></div>
                        <?php }?>
                    </td>



                </tr>
            <?php } ?>





            </tbody>
        </table>
    </div>

    <script>




        $(document).on('click', '.add_comment', function(){
                var _this = $(this);
                var ticket_id = _this.data('ticket-id');
                var ticket_comment = $('textarea[name="todo_comment"]').val();
                var ticket_user_id = <?=$this->session->userdata('user_id')?>;


                if(ticket_comment == ''){
                    $('textarea[name="todo_comment"]').addClass('errorValidation')
                    $('#validation_errors').html(`<p>The Ticket name field is required.</p>`);
                }


            $.ajax({
                url:"../../todo_tickets/todo_comment",
                type:'post',
                data:{ticket_id:+ticket_id,ticket_comment:ticket_comment,ticket_user_id :ticket_user_id,_ip_csrf:Cookies.get('ip_csrf_cookie')},
                success: function(data) {
                    var jsonPositions = JSON.parse(data);

                    $('textarea[name="todo_comment"]').val('')
                        if(jsonPositions.success === 0){
                            $('textarea[name="todo_comment"]').addClass('errorValidation')
                            $('#validation_errors').html(jsonPositions.validation_errors.ticket_comment)
                        }


                    $('.comments_list').prepend(`
                     <strong class="pull-left primary-font">${jsonPositions.user_name}</strong>
                            <small class="pull-right text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i>${jsonPositions.ticket_created_date}</small>
                            </br>
                            <li class="ui-state-default text-left" style="margin-left: 5%">
                                - ${jsonPositions.ticket_comment}
                            </li>
                            </br>
                        `);

                }
            });

        })


        $('#grade_ticket').click(function () {
            var _this = $(this);
            var grade = _this.parents('.grade_ticket_block').find('select[name=grade_ticket]').val();
            var todo_ticket_id = "<?= $ticket->todo_ticket_id; ?>";
            var user_id = "<?= $this->session->userdata('user_id'); ?>";
            var class_info = '';
            _this.html('<i class="fa fa-spinner"></i>')
            _this.attr('disabled', 'disabled')
            $.ajax({
                url:"../../todo_tickets/todo_ticket_grade",
                type:'post',
                data:{
                    ticket_grade: grade,
                    ticket_id: todo_ticket_id,
                    user_id: user_id,
                    _ip_csrf: Cookies.get('ip_csrf_cookie')
                },
                success: function(data) {
                    _this.removeAttr('disabled')
                    _this.html('Grade')
                    data = JSON.parse(data)
                    if(data.status == 'error') {
                        class_info = 'alert alert-danger';
                    } else {
                        class_info = 'alert alert-success';
                    }
                    $('.grade_response_info').remove();
                    _this.parents('.grade_ticket_block').append(`<div class="grade_response_info form-group col-12 ${class_info}">${data.msg}</div>`)

                }
            });

        })

        $(document).on('change', '#grade_per_task', function(){
            var _this = $(this);
            var grade = _this.val();
            var todo_ticket_id = "<?= $ticket->todo_ticket_id; ?>";
            var todo_task_id = _this.data('task-id');
            var user_id = "<?= $this->session->userdata('user_id'); ?>";
            var class_info = '';

            _this.attr('disabled', 'disabled')
            $.ajax({
                url:"../../todo_tickets/todo_task_grade",
                type:'post',
                data:{
                    task_grade: grade,
                    ticket_id: todo_ticket_id,
                    task_id: todo_task_id,
                    user_id: user_id,
                    _ip_csrf: Cookies.get('ip_csrf_cookie')
                },
                success: function(data) {
                    _this.removeAttr('disabled')
                    data = JSON.parse(data);
                    console.log(data);
                    if(data.status == 'error') {
                        class_info = 'color: red;';
                    } else {
                        class_info = 'color: green;';
                    }
                    $('.grade_response_info').remove();
                    _this.after(`<span class="grade_response_info" style="${class_info}">${data.msg}</span>`);

                }
            });

        })

        $(document).on('change', '#todo_task_status', function(){
                var _this = $(this);
                var todo_task_status = _this.val();
                var todo_task_id = _this.data('id');

            $.ajax({
                url:"../../todo_tickets/todo_task_status",
                type:'post',
                data:{todo_task_id:todo_task_id,todo_task_status:todo_task_status,_ip_csrf:Cookies.get('ip_csrf_cookie')},

                success: function(data) {

                    if(data == 6){
                        $(_this).parent().html(" <b style='color: green'><?php _trans('finished'); ?></b>");
                    }
                }
            });

        })


        $(document).on('click', '.finish', function(){

            var _this = $(this);
            var todo_task_id = $(_this).data('id');
            var todo_task_status = +$(_this).val();


            $.ajax({
                url:"../../todo_tickets/todo_task_status",
                type:'post',
                data:{todo_task_id:todo_task_id,todo_task_status:todo_task_status,_ip_csrf:Cookies.get('ip_csrf_cookie')},

                success: function(data) {

                    <?php if($this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ADMIN ): ?>
                        if(data == 1){
                            $(_this).parent().html(" <b style='color: orange'><?php _trans('in_progress'); ?></b>");
                        }else if(data == 2){
                            $(_this).parent().html("<b style='color: #a94442;'><?php _trans('not_accepted'); ?></b>");

                        }else if(data == 7){
                            $(_this).parent().html(`
                            <div class="form-group">
                                <select name="todo_task_status" id="todo_task_status"  class="form-control simple-select todo_task_status" tabindex="-1" data-id="${todo_task_id}">
                                    <option> <?php _trans('select_status'); ?></option>
                                    <option value="7" selected>  <?php _trans('finished'); ?> </option>
                                    <option value="8" > <?php _trans('paid'); ?></option>
                                </select>
                            </div>
                            `);
                        }
                    <?php endif; ?>
                    <?php if($this->session->userdata('user_id') == $ticket->todo_ticket_assigned_user_id ): ?>
                    if(data == 3){
                        $(_this).parent().html(" <b style='color: orange'><?php _trans('in_progress'); ?></b>");
                    }
                    <?php endif; ?>

                }
            });

        })
    </script>


