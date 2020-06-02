<div id="show_project" style="display: none">
<div id="headerbar">
    <h1 class="headerbar-title"><?php echo $project->project_name; ?></h1>
</div>


<div id="content">
    <?php if ($this->session->flashdata('alert_success')) { ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-12 col-md-4">

            <?php if (!empty($project->client_name)) : ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo format_client($project); ?></strong>
                    </div>
                    <div class="panel-body">
                        <div class="client-address">
                            <?php $this->layout->load_view('clients/partial_client_address', array('client' => $project)); ?>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="alert alert-info"><?php _trans('alert_no_client_assigned'); ?></div>

            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('group_name'); ?>
                </div>
                <div class="panel-body">
                    <div class="client-address">
                        <?php
                        $groups = array();
                        foreach ($user_groups as $user_group) {
                            foreach ($project_groups as $project_group) {
                                if ($project_group["group_id"] == $user_group->group_id) {
                                    array_push($groups, $user_group->group_name);
                                }
                            }
                        }
                        if (count($groups) > 0)
                        {
                            echo ucfirst(implode(", ", $groups));
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('notes'); ?>
                </div>
                <div class="panel-body">
                    <div id="notes_list">
                        <?=$partial_project; ?>
                    </div>

                </div>
            </div>


            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('appointments'); ?>
                </div>
                <div class="panel-body">
                    <div id="notes_list">
                        <?php foreach ($appointments as $appointment) : ?>
                            <div class="panel-default small">
                                <div class="panel-body">
                                    <?=nl2br(htmlsc($appointment->appointment_title)); ?>
                                    <span class="text-muted" style="margin-left: 5%">
                <?php echo date_from_mysql($appointment->create_date, true); ?>
            </span>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>
            </div>

        </div>
        <form action="<?php echo site_url('projects/view/' . $project->project_id); ?>" method = "get" name="form-tasks" id="form-tasks">

            <div class="col-xs-12 col-md-8">




                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('appointments'); ?>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-striped no-margin">
                                <thead>
                                <tr>
                                    <th><?php _trans('appointment_name'); ?></th>
                                    <th><?php _trans('appointment_created_date'); ?></th>
                                    <th><?php _trans('appointment_kilometers'); ?></th>
                                    <th><?php _trans('appointment_price_per_kilometer'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($appointments as $appointment) { ?>
                                    <?php if($appointment->appointment_product_id == 3 || $appointment->appointment_product_id == 8){?>
                                        <tr>
                                            <td>
                                                <label><?= htmlsc($appointment->appointment_title)?></label>
                                            </td>
                                            <td>
                                                <label><?= date('Y-m-d', strtotime($appointment->created_date))?></label>
                                            </td>
                                            <td>
                                                <label><?= htmlsc($appointment->appointment_kilometers)?></label>
                                            </td>
                                            <td>
                                                <label><?= htmlsc($appointment->appointment_price_per_kilometer)?></label>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
</div>

<script>

    function passWord() {

        if(+localStorage.getItem('user') === <?=+$project->client_id?>){
            document.getElementById("show_project").style.display = "block";
            return false
        }else
        var testV = true;

        var password = "<?=$project->project_guest_pass?>"

        if(password != ''){
            var pass1 = prompt('Please Enter Your Password','');
            while (testV) {
                /*if (!pass1)
                    history.go(-1);*/
                if (pass1== password) {
                    // .toLowerCase()
                    //     testV = false
                    /*alert('Password is correct');*/
                    document.getElementById("show_project").style.display = "block";

                    return
                }
                pass1 =
                    prompt('Access Denied - Password Incorrect, Please Try Again.','');
            }
            if (pass1.toLowerCase()!= "password" && !testV){
                history.go(-1);
            }
        }else{
            document.getElementById("show_project").style.display = "block";
        }

    }
    // console.log(localStorage.clear())

    passWord()
</script>