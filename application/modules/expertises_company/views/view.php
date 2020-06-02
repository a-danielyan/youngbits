
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
</style>


<div id="content">
    <?php if ($this->session->flashdata('alert_success')) { ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
    <?php } ?>
    <div class="row">

        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default no-margin">
                <h5 class="panel-heading"><?= $user_groups->group_name; ?></h5>
            </div>
        </div>

    </div>



    <div class="mt-5" >
        <h2 style="margin-bottom: 2rem;"><?php _trans('expertises'); ?></h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?php _trans('expertise_name'); ?></th>
                <th ><?php _trans('created_user'); ?></th>
                <th><?php _trans('created_date'); ?></th>
            </tr>
            </thead>
            <tbody>

            <?php


            foreach ($expertises as $expertis) {
                ?>
                <tr>
                    <td><?=$expertis->expertise_name;?></td>
                    <td width="950"><?=$expertis->user_name;?></td>
                    <td><?=$expertis->expertise_created_date;?></td>




                </tr>
            <?php } ?>





            </tbody>
        </table>
    </div>


