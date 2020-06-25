<script>
    $(function () {
        $('#btn_generate_cron_key').click(function () {
            $.post("<?php echo site_url('settings/ajax/get_cron_key'); ?>", function (data) {
                $('#cron_key').val(data);
            });
        });
        $('.taxes_item').click(function () {

            $('.tax_input').css("display", "block");
            $('.tax_input').one('keypress', function (e) {
                if(e.which === 13){

                    var item_name = $('.tax_input').val();
                    var new_input = "<input type='checkbox'  name='' value='' >"+item_name+"<br>";
                    $('.new_tax_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/additem',
                        data:{
                            item_name : item_name,
                            group_name: 'taxes'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);

                        }
                    })
                    $('.tax_input').css("display", "none");
                }
            });

        });
        $('.api_item').click(function () {

            $('.api_input').css("display", "block");
            $('.api_input').one('keypress', function (e) {
                if(e.which === 13){

                    var api_name = $('.api_input').val();
                    var new_input = "<input type='checkbox'  name='' value='' >"+api_name+"<br>";
                    $('.new_api_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/addapi',
                        data:{
                            api_name : api_name,
                            group_name: 'api'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);

                        }
                    })
                    $('.api_input').css("display", "none");

                }
            });

        });
        $('.sales_item').click(function () {

            $('.sales_input').css("display", "block");
            $('.sales_input').one('keypress', function (e) {
                if(e.which === 13){

                    var item_name = $('.sales_input').val();
                    var new_input = "<input type='checkbox'  name='' value='' >"+item_name+"<br>";
                    $('.new_sales_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/additem',
                        data:{
                            item_name : item_name,
                            group_name: 'sales'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);

                        }
                    })
                    $('.sales_input').css("display", "none");
                }
            });

        });
        $('.project_item').click(function () {

            $('.project_input').css("display", "block");
            $('.project_input').one('keypress', function (e) {
                if(e.which === 13){

                    var item_name = $('.project_input').val();
                    var new_input = "<input type='checkbox'  name='' value='' >"+item_name+"<br>";
                    $('.new_project_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/additem',
                        data:{
                            item_name : item_name,
                            group_name: 'project'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);

                        }
                    })
                    $('.project_input').css("display", "none");
                }
            });

        });
        $('.resource_item').click(function () {

            $('.resource_input').css("display", "block");
            $('.resource_input').one('keypress', function (e) {
                if(e.which === 13){

                    var item_name = $('.resource_input').val();
                    var new_input = "<input type='checkbox'  name='' value='' >"+item_name+"<br>";
                    $('.new_resource_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/additem',
                        data:{
                            item_name : item_name,
                            group_name: 'resource'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);

                        }
                    })
                    $('.resource_input').css("display", "none");
                }
            });

        });
        $('.finance_item').click(function () {

            $('.finance_input').css("display", "block");
            $('.finance_input').one('keypress', function (e) {
                if(e.which === 13){

                    var item_name = $('.finance_input').val();
                    var new_input = "<input type='checkbox'  name='' value='' >"+item_name+"<br>";
                    $('.new_finance_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/additem',
                        data:{
                            item_name : item_name,
                            group_name: 'finance'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);

                        }
                    })
                    $('.finance_input').css("display", "none");
                }
            });

        });
        $('.app_item').click(function () {

            $('.app_input').css("display", "block");
            $('.app_input').one('keypress', function (e) {
                if(e.which === 13){

                    var item_name = $('.app_input').val();
                    var new_input = "<input type='checkbox' name='' value='' >"+item_name+"<br>";
                    $('.new_app_item').append(new_input);
                    $.ajax({
                        method: 'post',
                        url:'settings/additem',
                        data:{
                            item_name : item_name,
                            group_name: 'app'

                        },
                        dataType: 'json',
                        success :function(data){
                            alert(data);


                        }
                    })
                    $('.app_input').css("display", "none");
                }
            });

        });


    });

</script>

<div class="col-xs-12 col-md-8 col-md-offset-2">
    <?php
    $template = $this->session->userdata('templates');
    $template = $template['template_name'];
    $mytemplate = $this->session->userdata('mytemp');
//    var_dump($mytemplate);
    if (empty($mytemplate)){

        $s = $template;

    }
    else{
        $s = $selected[0]['template_name'];
    }
    if($this->session->userdata('templates')){
        $template = $this->session->userdata('templates');
        $template = $template['template_name'];
    }
   else{
       $template['template_name'] = 'No Template';
       $template = $template['template_name'];
   }

    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('general'); ?>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[default_language]">
                            <?php _trans('language'); ?>
                        </label>
                        <select name="settings[default_language]" id="settings[default_language]"
                                class="form-control simple-select">
                            <?php foreach ($languages as $language) {
                                $sys_lang = get_setting('default_language');
                                ?>
                                <option value="<?php echo $language; ?>" <?php check_select($sys_lang, $language) ?>>
                                    <?php echo ucfirst($language); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[system_theme]">
                            <?php _trans('theme'); ?>
                        </label>
                        <select name="settings[system_theme]" id="settings[system_theme]"
                                class="form-control simple-select">
                            <?php foreach ($available_themes as $theme_key => $theme_name) { ?>
                                <option value="<?php echo $theme_key; ?>" <?php check_select(get_setting('system_theme'), $theme_key); ?>>
                                    <?php echo $theme_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[first_day_of_week]">
                            <?php _trans('first_day_of_week'); ?>
                        </label>
                        <select name="settings[first_day_of_week]" id="settings[first_day_of_week]"
                                class="form-control simple-select">
                            <?php foreach ($first_days_of_weeks as $first_day_of_week_id => $first_day_of_week_name) { ?>
                                <option value="<?php echo $first_day_of_week_id; ?>"
                                    <?php check_select(get_setting('first_day_of_week'), $first_day_of_week_id); ?>>
                                    <?php echo $first_day_of_week_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[date_format]">
                            <?php _trans('date_format'); ?>
                        </label>
                        <select name="settings[date_format]" id="settings[date_format]"
                                class="form-control simple-select">
                            <?php foreach ($date_formats as $date_format) { ?>
                                <option value="<?php echo $date_format['setting']; ?>"
                                    <?php check_select(get_setting('date_format'), $date_format['setting']); ?>>
                                    <?php echo $current_date->format($date_format['setting']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[default_country]">
                            <?php _trans('default_country'); ?>
                        </label>
                        <select name="settings[default_country]" id="settings[default_country]"
                                class="form-control simple-select">
                            <option value=""><?php _trans('none'); ?></option>
                            <?php foreach ($countries as $cldr => $country) { ?>
                                <option value="<?php echo $cldr; ?>" <?php check_select(get_setting('default_country'), $cldr); ?>>
                                    <?php echo $country ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('Templates'); ?>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[mytemplate]">
                            <?php _trans('Select Template'); ?>
                        </label>
                        <select name="settings[mytemplate]" id="settings[mytemplate]"
                                class="form-control simple-select">
                            <option value="<?php echo $s ?>"><?php echo $s ?></option>
                            <?php if ($templates != null){ ?>
                            <?php foreach ($templates as $temp) {
                                $my_temp = $template['template_name'];
                                ?>

                                <option value="<?php echo $temp['template_name']; ?>" >
                                    <?php echo ucfirst($temp['template_name']); ?>
                                </option>
                            <?php } ?>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[template]">
                            <?php _trans('Create Template'); ?>
                        </label>
                        <input type="text" name="settings[template]" id="settings[template]"
                               class="form-control"
                               value="">
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-2">
                    <label style="font-weight: bold">Apps</label>
                    <div class="form-group">

                        <input type="checkbox"  name="set[Create_appointments]" value="Create appointments"
                            <?php if($status[0]['part_status'] === 'checked') echo 'checked="checked"';?>
                        >Appointments<br>
                        <input type="checkbox"  name="set[Showcalendar]" value="Show calendar"
                            <?php if($status[1]['part_status'] === 'checked') echo 'checked="checked"';?>>Show calendar<br>
                        <input type="checkbox" name="set[Show_map]" value="Show map"
                            <?php if($status[2]['part_status'] === 'checked') echo 'checked="checked"';?>>Show map<br>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Staywaykey]" value="Staywaykey"
                            <?php if($status[3]['part_status'] === 'checked') echo 'checked="checked"';?>>Staywaykey<br>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Web_shop]" value="Webshop/Inventory"
                            <?php if($status[4]['part_status'] === 'checked') echo 'checked="checked"';?>>Webshop/Inventory<br>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Touristdoc]" value="Touristdoc"
                            <?php if($status[33]['part_status'] === 'checked') echo 'checked="checked"';?>>Touristdoc<br>
                    </div>
                    <div class="form-group">
                        <?php foreach ($status as $val ) {
                            if ($val['group_name'] == 'app'){ ?>
                                <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                            <?php }
                        } ?>
                        <div class="new_app_item"></div>
                        <input type="text" class="app_input" style="display: none"  name="" value="Item Name" ><br>

                        <a class="app_item btn btn-xs btn-primary" >
                            <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                        </a><br>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bolder" > Api</label><br>
                        <?php foreach ($status as $val ) {
                            if ($val['group_name'] == 'api'){ ?>
                                <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                            <?php }
                        } ?>

                        <div class="new_api_item"></div>
                        <input type="text" class="api_input" style="display: none"  name="" value="Api Name" ><br>

                        <a class="api_item btn btn-xs btn-primary" >
                            <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <label style="font-weight: bold">Finance</label>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Bank_statements]" value="Bank statements"
                            <?php if($status[5]['part_status'] === 'checked') echo 'checked="checked"';?>>Bank statements<br>

                    </div>
                    <div class="form-group">

                        <input type="checkbox"  name="set[View_upfront_payments]" value="View upfront payments"
                            <?php if($status[6]['part_status'] === 'checked') echo 'checked="checked"';?>>View/Add upfront payments<br>

                    </div>
                    <div class="form-group">

                        <input type="checkbox" name="set[Financial_reports]" value="Financial reports"
                            <?php if($status[7]['part_status'] === 'checked') echo 'checked="checked"';?>>Financial reports<br>
                        <input type="checkbox"  name="set[Show_company_savings]" value="Show company savings"
                            <?php if($status[31]['part_status'] === 'checked') echo 'checked="checked"';?>>Show company savings<br>
                    </div>

                    <div class="form-group">

                        <input type="checkbox"  name="set[financial_agreement]" value="Financial agreements"
                            <?php if($status[28]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View financial agreements<br>
                    </div>
                    <div class="form-group">

                        <input type="checkbox"  name="set[Add_subscriptions]" value="Subscriptions"
                            <?php if($status[29]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View subscriptions<br>
                        <input type="checkbox"  name="set[View_expenses]" value="View expenses"
                            <?php if($status[30]['part_status'] === 'checked') echo 'checked="checked"';?> >Add/View expenses<br>
                    </div>
                    <div class="form-group">
                        <?php foreach ($status as $val ) {
                            if ($val['group_name'] == 'finance'){ ?>
                                <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                            <?php }
                        } ?>
                        <div class="new_finance_item"></div>
                        <input type="text" class="finance_input" style="display: none" name="" value="Item Name" ><br>

                        <a class="finance_item btn btn-xs btn-primary" >
                            <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                        </a>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bolder" > Taxes</label><br>
                        <?php foreach ($status as $val ) {
                            if ($val['group_name'] == 'taxes'){ ?>
                              <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                            <?php }
                        } ?>


                       <div class="new_tax_item"></div>
                        <input type="text" class="tax_input" style="display: none"  name="" value="Item Name" ><br>

                        <a class="taxes_item btn btn-xs btn-primary">
                            <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                        </a>

                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <label style="font-weight: bold">Sales</label>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Enter inventory]" value="Enter inventory" <?php if($status[72]['part_status'] === 'checked') echo 'checked="checked"';?>>Enter/View inventory<br>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Add_client]" value="Add client" <?php if($status[14]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View client<br>

                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Sales_by_client]" value="Sales by client" <?php if($status[15]['part_status'] === 'checked') echo 'checked="checked"';?>>Sales by client<br>
                        <input type="checkbox"  name="set[Sales_by_date]" value="Sales by date"<?php if($status[16]['part_status'] === 'checked') echo 'checked="checked"';?>>Sales by date<br>
                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Add_prospect]" value="Add prospect" <?php if($status[32]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View prospects<br>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="set[Add_distributor]" value="Add distributor" <?php if($status[17]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View distributor<br>

                    </div>
                    <div class="form-group">

                        <input type="checkbox"  name="set[Add_supplier]" value="Add supplier"<?php if($status[18]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View suppliers <br>

                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Enter_legal_issues]" value="Enter legal issues" <?php if($status[19]['part_status'] === 'checked') echo 'checked="checked"';?>>Enter/View legal issues<br>
                    </div>
                    <?php foreach ($status as $val ) {
                        if ($val['group_name'] == 'sales'){ ?>
                            <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                        <?php }
                    } ?>
                    <div class="new_sales_item"></div>
                    <input type="text" class="sales_input" style="display: none"  name="" value=" Sales Item" ><br>

                    <a class="sales_item btn btn-xs btn-primary" >
                        <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                    </a>

                </div>
                <div class="col-xs-12 col-md-3">
                    <label style="font-weight: bold">Projects</label>
                    <div class="form-group">

                        <input type="checkbox"  name="set[Create_note]" value="Create note"<?php if($status[20]['part_status'] === 'checked') echo 'checked="checked"';?> >Create/Show notes<br>

                    </div>
                    <div class="form-group">
                        <input type="checkbox"  name="set[Add_domain_name]" value="Add domain name" <?php if($status[21]['part_status'] === 'checked') echo 'checked="checked"';?>>Add/View domain names<br>

                    </div>
                    <?php foreach ($status as $val ) {
                        if ($val['group_name'] == 'project'){ ?>
                            <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                        <?php }
                    } ?>
                    <div class="new_project_item"></div>
                    <input type="text" class="project_input" style="display: none"  name="" value="Project Item" ><br>

                    <a class="project_item btn btn-xs btn-primary" >
                        <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                    </a>
                </div>
                <div class="col-xs-12 col-md-2">
                    <label style="font-weight: bold">Resources</label>
                    <div class="form-group">

                        <input type="checkbox"  name="set[Expertises_list]" value="Expertises list" <?php if($status[22]['part_status'] === 'checked') echo 'checked="checked"';?>>Expertises <br>
                    </div>

                    <div class="form-group">
                        <labeel></labeel><br>
                        <input type="checkbox"  name="set[Freelancers]" value="Freelancers" <?php if($status[23]['part_status'] === 'checked') echo 'checked="checked"';?>>Freelancers<br>
                        <input type="checkbox" name="set[Influencers]" value="Influencers"<?php if($status[24]['part_status'] === 'checked') echo 'checked="checked"';?> >Influencers<br>
                        <input type="checkbox"  name="set[Employees]" value="Employees"<?php if($status[25]['part_status'] === 'checked') echo 'checked="checked"';?>>Employees<br>
                        <input type="checkbox"  name="set[Managers]" value="Managers"<?php if($status[26]['part_status'] === 'checked') echo 'checked="checked"';?>>Managers<br>
                        <input type="checkbox"  name="set[Administrators]" value="Administrators" <?php if($status[27]['part_status'] === 'checked') echo 'checked="checked"';?>>Administrators<br>
                    </div>
                    <div class="form-group">
                        <labeel></labeel><br>
                        <input type="checkbox"  name="set[Enter_study_program]" value="Enter study program" <?php if($status[73]['part_status'] === 'checked') echo 'checked="checked"';?>>Study program<br>
                    </div>
                    <div class="form-group">
                        <labeel></labeel><br>
                        <input type="checkbox"  name="set[Enter_students]" value="Enter students" <?php if($status[74]['part_status'] === 'checked') echo 'checked="checked"';?>>Enter/View students<br>
                    </div>
                    <?php foreach ($status as $val ) {
                        if ($val['group_name'] == 'resource'){ ?>
                            <input type="checkbox" id="set[<?php echo $val['part_name'] ?>]" name="set[set<?php echo $val['id'] ?>]" value="<?php echo $val['part_name'] ?>" <?php if($val['part_status'] === 'checked') echo 'checked="checked"';?>><?php echo $val['part_name'] ?> <br>

                        <?php }
                    } ?>
                    <div class="new_resource_item"></div>
                    <input type="text" class="resource_input" style="display: none"  name="" value="Resource Item" ><br>

                    <a class="resource_item btn btn-xs btn-primary" >
                        <i class="fa fa-plus" style="color: white"></i> <?php _trans('new'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('amount_settings'); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[currency_symbol]">
                            <?php _trans('currency_symbol'); ?>
                        </label>
                        <input type="text" name="settings[currency_symbol]" id="settings[currency_symbol]"
                               class="form-control"
                               value="<?php echo get_setting('currency_symbol', '', true); ?>">
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[currency_symbol_placement]">
                            <?php _trans('currency_symbol_placement'); ?>
                        </label>
                        <select name="settings[currency_symbol_placement]" id="settings[currency_symbol_placement]"
                                class="form-control simple-select">
                            <option value="before" <?php check_select(get_setting('currency_symbol_placement'), 'before'); ?>>
                                <?php _trans('before_amount'); ?>
                            </option>
                            <option value="after" <?php check_select(get_setting('currency_symbol_placement'), 'after'); ?>>
                                <?php _trans('after_amount'); ?>
                            </option>
                            <option value="afterspace" <?php check_select(get_setting('currency_symbol_placement'), 'afterspace'); ?>>
                                <?php _trans('after_amount_space'); ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[currency_code]">
                            <?php _trans('currency_code'); ?>
                        </label>
                        <select name="settings[currency_code]"
                                id="settings[currency_code]"
                                class="input-sm form-control simple-select">
                            <?php foreach ($gateway_currency_codes as $val => $key) { ?>
                                <option value="<?php echo $val; ?>"
                                    <?php check_select(get_setting('currency_code', '', true), $val); ?>>
                                    <?php echo $val; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="tax_rate_decimal_places">
                            <?php _trans('tax_rate_decimal_places'); ?>
                        </label>
                        <select name="settings[tax_rate_decimal_places]" class="form-control simple-select"
                                id="tax_rate_decimal_places">
                            <option value="2" <?php check_select(get_setting('tax_rate_decimal_places'), '2'); ?>>
                                2
                            </option>
                            <option value="3" <?php check_select(get_setting('tax_rate_decimal_places'), '3'); ?>>
                                3
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[thousands_separator]">
                            <?php _trans('thousands_separator'); ?>
                        </label>
                        <input type="text" name="settings[thousands_separator]" id="settings[thousands_separator]"
                               class="form-control"
                               value="<?php echo get_setting('thousands_separator', '', true); ?>">
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[decimal_point]">
                            <?php _trans('decimal_point'); ?>
                        </label>
                        <input type="text" name="settings[decimal_point]" id="settings[decimal_point]"
                               class="form-control"
                               value="<?php echo get_setting('decimal_point', '', true); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="default_list_limit">
                            <?php _trans('default_list_limit'); ?>
                        </label>
                        <select name="settings[default_list_limit]" class="form-control simple-select"
                                id="default_list_limit">
                            <option value="15" <?php check_select(get_setting('default_list_limit'), '15'); ?>>
                                15
                            </option>
                            <option value="25" <?php check_select(get_setting('default_list_limit'), '25'); ?>>
                                25
                            </option>
                            <option value="50" <?php check_select(get_setting('default_list_limit'), '50'); ?>>
                                50
                            </option>
                            <option value="100" <?php check_select(get_setting('default_list_limit'), '100'); ?>>
                                100
                            </option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('dashboard'); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <?php
                if (USE_QUOTES) {
                ?>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[quote_overview_period]">
                            <?php _trans('quote_overview_period'); ?>
                        </label>
                        <select name="settings[quote_overview_period]" id="settings[quote_overview_period]"
                                class="form-control simple-select">
                            <option value="this-month" <?php check_select(get_setting('quote_overview_period'), 'this-month'); ?>>
                                <?php _trans('this_month'); ?>
                            </option>
                            <option value="last-month" <?php check_select(get_setting('quote_overview_period'), 'last-month'); ?>>
                                <?php _trans('last_month'); ?>
                            </option>
                            <option value="this-quarter" <?php check_select(get_setting('quote_overview_period'), 'this-quarter'); ?>>
                                <?php _trans('this_quarter'); ?>
                            </option>
                            <option value="last-quarter" <?php check_select(get_setting('quote_overview_period'), 'last-quarter'); ?>>
                                <?php _trans('last_quarter'); ?>
                            </option>
                            <option value="this-year" <?php check_select(get_setting('quote_overview_period'), 'this-year'); ?>>
                                <?php _trans('this_year'); ?>
                            </option>
                            <option value="last-year" <?php check_select(get_setting('quote_overview_period'), 'last-year'); ?>>
                                <?php _trans('last_year'); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <?php
                }
                ?>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[invoice_overview_period]">
                            <?php _trans('invoice_overview_period'); ?>
                        </label>
                        <select name="settings[invoice_overview_period]" id="settings[invoice_overview_period]"
                                class="form-control simple-select">
                            <option value="this-month" <?php check_select(get_setting('invoice_overview_period'), 'this-month'); ?>>
                                <?php _trans('this_month'); ?>
                            </option>
                            <option value="last-month" <?php check_select(get_setting('invoice_overview_period'), 'last-month'); ?>>
                                <?php _trans('last_month'); ?>
                            </option>
                            <option value="this-quarter" <?php check_select(get_setting('invoice_overview_period'), 'this-quarter'); ?>>
                                <?php _trans('this_quarter'); ?>
                            </option>
                            <option value="last-quarter" <?php check_select(get_setting('invoice_overview_period'), 'last-quarter'); ?>>
                                <?php _trans('last_quarter'); ?>
                            </option>
                            <option value="this-year" <?php check_select(get_setting('invoice_overview_period'), 'this-year'); ?>>
                                <?php _trans('this_year'); ?>
                            </option>
                            <option value="last-year" <?php check_select(get_setting('invoice_overview_period'), 'last-year'); ?>>
                                <?php _trans('last_year'); ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="disable_quickactions">
                            <?php _trans('disable_quickactions'); ?>
                        </label>
                        <select name="settings[disable_quickactions]" class="form-control simple-select"
                                id="disable_quickactions">
                            <option value="0">
                                <?php _trans('no'); ?>
                            </option>
                            <option value="1" <?php check_select(get_setting('disable_quickactions'), '1'); ?>>
                                <?php _trans('yes'); ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('interface'); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="disable_sidebar">
                            <?php _trans('disable_sidebar'); ?>
                        </label>
                        <select name="settings[disable_sidebar]" class="form-control simple-select"
                                id="disable_sidebar">
                            <option value="0">
                                <?php _trans('no'); ?>
                            </option>
                            <option value="1" <?php check_select(get_setting('disable_sidebar'), '1'); ?>>
                                <?php _trans('yes'); ?>
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="settings[custom_title]">
                            <?php _trans('custom_title'); ?>
                        </label>
                        <input type="text" name="settings[custom_title]" id="settings[custom_title]"
                               class="form-control"
                               value="<?php echo get_setting('custom_title', '', true); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="monospace_amounts">
                            <?php _trans('monospaced_font_for_amounts'); ?>
                        </label>
                        <select name="settings[monospace_amounts]" class="form-control simple-select"
                                id="monospace_amounts">
                            <option value="0"><?php _trans('no'); ?></option>
                            <option value="1" <?php check_select(get_setting('monospace_amounts'), '1'); ?>>
                                <?php _trans('yes'); ?>
                            </option>
                        </select>

                        <p class="help-block">
                            <?php _trans('example'); ?>:
                            <span style="font-family: Monaco, Lucida Console, monospace">
                        <?php echo format_currency(123456.78); ?>
                    </span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="login_logo">
                            <?php _trans('login_logo'); ?>
                        </label>
                        <?php if (get_setting('login_logo')) { ?>
                            <br/>
                            <img class="personal_logo"
                                 src="<?php echo base_url(); ?>uploads/<?php echo get_setting('login_logo'); ?>"><br>
                            <?php echo anchor('settings/remove_logo/login', trans('remove_logo')); ?><br/>
                        <?php } ?>
                        <input type="file" name="login_logo" id="login_logo" class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="login_bottom_logo">
                            <?php _trans('login_bottom_logo'); ?>
                        </label>
                        <?php if (get_setting('login_bottom_logo')) { ?>
                            <br/>
                            <img class="personal_logo"
                                 src="<?php echo base_url(); ?>uploads/<?php echo get_setting('login_bottom_logo'); ?>"><br>
                            <?php echo anchor('settings/remove_logo/login_bottom', trans('remove_logo')); ?><br/>
                        <?php } ?>
                        <input type="file" name="login_bottom_logo" id="login_bottom_logo" class="form-control"/>
                    </div>

                </div>
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="settings[reports_in_new_tab]">
                            <?php _trans('open_reports_in_new_tab'); ?>
                        </label>
                        <select name="settings[reports_in_new_tab]" id="settings[reports_in_new_tab]"
                                class="form-control simple-select">
                            <option value="0"><?php _trans('no'); ?></option>
                            <option value="1" <?php check_select(get_setting('reports_in_new_tab'), '1'); ?>>
                                <?php _trans('yes'); ?>
                            </option>
                        </select>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('system_settings'); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="settings[bcc_mails_to_admin]">
                            <?php _trans('bcc_mails_to_admin'); ?>
                        </label>
                        <select name="settings[bcc_mails_to_admin]" id="settings[bcc_mails_to_admin]"
                                class="form-control simple-select">
                            <option value="0"><?php _trans('no'); ?></option>
                            <option value="1" <?php check_select(get_setting('bcc_mails_to_admin'), '1'); ?>>
                                <?php _trans('yes'); ?>
                            </option>
                        </select>

                        <p class="help-block"><?php _trans('bcc_mails_to_admin_hint'); ?></p>
                    </div>

                </div>
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="cron_key">
                            <?php _trans('cron_key'); ?>
                        </label>
                        <div class="input-group">
                            <input type="text" name="settings[cron_key]" id="cron_key" class="form-control" readonly
                                   value="<?php echo get_setting('cron_key'); ?>">
                            <div class="input-group-btn">
                                <button id="btn_generate_cron_key" type="button" class="btn btn-primary btn-block">
                                    <i class="fa fa-recycle fa-margin"></i> <?php _trans('generate'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
