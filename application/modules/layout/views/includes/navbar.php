<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid row">
        <div class="navbar-header float-right">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#ip-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <?= trans('menu') ?> &nbsp; <i class="fa fa-bars"></i>
            </button>
        </div>

        <?php
        $statuses = $this->session->userdata('statuses');
        $selected = $this->session->userdata('mytemp');
        $template = $this->session->userdata('templates');
//                var_dump($data);die;
        $template = $selected[0]['template_name'];
        $selected =json_decode($selected[0]["template_data"]);
        if ($selected == null){
            $template = 'No Template';

        }
//var_dump($statuses);die;
//        var_dump($selected[0]->group_name);die;


        ?>

        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="ip-navbar-collapse">

                <div class="col-md-2 col-xs-2">
                    <a href="<?= base_url('/index.php/dashboard') ?>" class="header_logo header_padding">
                        <img src="<?= base_url('uploads/logo1.png') ?>" alt="">
                    </a>
                </div>
                <ul class="nav navbar-nav header_padding">
                    <!-- Accounting -->

                    <li class="dropdown <?= get_setting('projects_enabled') == 1 ?: 'hidden'; ?>">
                        <a href="#" class="dropdown-toggle navbar_link" data-toggle="dropdown">
                            <span class="hidden-md"><?php _trans('apps'); ?></span>
                            <i class="fa fa-chevron-down" aria-hidden="true"></i> &nbsp;
                            <i class="visible-md-inline fa fa-check-square-o"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_CLIENTS))) { ?>

                                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                                    <?php if ($statuses[0]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('appointments/form', trans('create_appointment')); ?></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($statuses[0]['part_status'] == 'checked') : ?>
                                    <li><?= anchor('appointments/index', trans('show_appointments')); ?></li>
                                <?php endif; ?>

                                <?php if ($statuses[1]['part_status'] == 'checked') : ?>
                                    <li><?= anchor('calendars/index', trans('show_calendar')); ?></li>
                                <?php endif; ?>

                                <?php if ($this->session->userdata('user_type') == TYPE_ADMIN): ?>
                                    <!-- TYPE_ADMINISTRATOR -->

                                    <?php if ($statuses[2]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('maps', trans('show_map')); ?> </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php } ?>
                            <?php  if ($template == 'No Template') : ?>
                                <li><?= anchor('appointments/form', trans('create_appointment')); ?></li>
                                <li><?= anchor('appointments/index', trans('show_appointments')); ?></li>
                                <li><?= anchor('calendars/index', trans('show_calendar')); ?></li>
                                <li><?= anchor('maps', trans('show_map')); ?> </li>
                                <li class="header_menu_group_title"><?= trans('staywaykey_app') ?></li>
                                <li><?= anchor('appointments/form', trans('add_ride')); ?></li>
                                <li><?= anchor('rides/list_rides', trans('list_rides')); ?></li>

                            <?php endif; ?>

                            <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_CLIENTS))) { ?>
                                <?php if ($statuses[3]['part_status'] == 'checked') : ?>
                                    <li class="header_menu_group_title"><?= trans('staywaykey_app') ?></li>
                                <?php endif; ?>


                                <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS))) { ?>
                                    <!-- TYPE_ADMINISTRATOR -->
                                    <li><?= anchor('fleets/index', trans('fleetmanagement')); ?></li>
                                    <li><?= anchor('fleets/form', trans('fleet_create')); ?> </li>
                                <?php } ?>


                                <?php if ($this->session->userdata('user_type') == TYPE_ACCOUNTANT): ?>
                                    <!-- TYPE_ACCOUNTANT -->
                                    <li><?= anchor('fleets/index', trans('fleetmanagement')); ?></li>
                                <?php endif; ?>
                                <?php if ($statuses[3]['part_status'] == 'checked') : ?>
                                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                                        <li><?= anchor('appointments/form', trans('add_ride')); ?></li>
                                    <?php endif; ?>
                                    <li><?= anchor('rides/list_rides', trans('list_rides')); ?></li>
                                <?php endif; ?>


                            <?php } ?>

                            <?php if ($statuses[4]['part_status'] == 'checked') : ?>

                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_SALESPERSON, TYPE_CLIENTS))): ?>

                                    <li class="header_menu_group_title"><?= trans('webshop_app') ?></li>


                                    <?php if ($this->session->userdata('user_type') != TYPE_CLIENTS): ?>
                                        <li><?= anchor('inventory/tablet_form', trans('enter_inventory')); ?></li>
                                    <?php endif; ?>
                                    <li><?= anchor('inventory/index', trans('view_inventory')); ?></li>
                                <?php endif; ?>
                             <?endif; ?>
                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_SALESPERSON, TYPE_CLIENTS))): ?>
                                    <?php if ($statuses[33]['part_status'] == 'checked') : ?>
                                        <li class="header_menu_group_title"><?= trans('Touristdoc') ?></li>


                                        <?php if ($this->session->userdata('user_type') != TYPE_CLIENTS): ?>
                                            <li><?= anchor('', trans('Enter doctors')); ?></li>
                                        <?php endif; ?>
                                        <li><?= anchor('', trans('View doctors')); ?></li>
                                        <?php if ($this->session->userdata('user_type') != TYPE_CLIENTS): ?>
                                            <li><?= anchor('', trans('Enter specialties')); ?></li>
                                        <?php endif; ?>
                                        <li><?= anchor('', trans('View specialties')); ?></li>

                                        <li><?= anchor('', trans('View requests')); ?></li>
                                        <li><?= anchor('', trans('View prescriptions')); ?></li>
                                        <li>
                                            <br>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                if ($template != 'No Template'){
                                    foreach ($selected as $val){
                                        if (($val->part_status == 'checked') && ($val->group_name == 'app' )){ ?>

                                            <li><?= anchor('', trans($val->part_name)); ?></li>

                                        <?php }
                                    }
                                }

                                ?>

                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_SALESPERSON, TYPE_CLIENTS))): ?>

                                    <li class="header_menu_group_title"><?= trans('Api') ?></li>
                                    <?php
                                    if ($template != 'No Template'){
                                        foreach ($selected as $val){
                                            if (($val->part_status == 'checked') && ($val->group_name == 'api' )){

//                                                var_dump($val->part_name);
                                                ?>
                                                <li><?= anchor('', trans($val->part_name)); ?></li>
                                            <?php }
                                        }}
                                    ?>



                                <?php endif; ?>
                                <?php if ($this->session->userdata('user_type') == TYPE_ACCOUNTANT): ?>
                                    <li class="header_menu_group_title"><?= trans('webshop_app') ?></li>
                                    <li><?= anchor('inventory/index', trans('view_inventory')); ?></li>
                                <?php endif; ?>

                            <?php if (in_array($this->session->userdata('user_type'), array(TYPE_CLIENTS))) { ?>
                                <li class="header_menu_group_title"><?= trans('custom_apps') ?></li>
                                <li><?= anchor('/', trans('upwork')); ?></li>
                                <li><?= anchor('/', trans('mobile_de')); ?></li>
                                <li><?= anchor('/', trans('ebay_kleinanzeigen')); ?></li>
                                <li><?= anchor('/', trans('wordpress')); ?></li>
                                <li><?= anchor('/', trans('joomla')); ?></li>
                                <li><?= anchor('/', trans('wix')); ?></li>
                            <?php } ?>

                        </ul>
                    </li>
                    <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_CLIENTS))) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle navbar_link" data-toggle="dropdown">
                                <span class="hidden-md"><?php _trans('finance'); ?></span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i> &nbsp;
                                <i class="visible-md-inline fa fa-users"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($this->session->userdata('user_type') != TYPE_FREELANCERS): ?>

                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ACCOUNTANT))): ?>
                                        <?php if (!$this->session->userdata('user_type') == TYPE_ACCOUNTANT) { ?>
                                            <li><a href="#"
                                                   class="create-invoice"><?php _trans('create_invoice'); ?></a></li>
                                        <?php } ?>
                                        <li><?= anchor('invoices/index', trans('view_invoices')); ?></li>
                                        <li><?= anchor('invoices/recurring/index', trans('view_recurring_invoices')); ?></li>
                                        <?php if ($statuses[5]['part_status'] == 'checked') : ?>
                                            <li>
                                                <?= anchor('bank_statements/index', trans('bank_statements')); ?>
                                            </li>
                                        <?php endif; ?>

                                        <li>
                                            <hr>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                                        <li><?= anchor('payments/form', trans('enter_payment')); ?></li>
                                    <?php } ?>

                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ACCOUNTANT))) { ?>
                                        <li><?= anchor('payments/index', trans('view_payments')); ?></li>
                                        <?php if ($statuses[6]['part_status'] == 'checked') : ?>
                                            <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ACCOUNTANT, TYPE_ADMINISTRATOR))) { ?>
                                                <li><?= anchor('upfront_payments/index', trans('upfront_payments_view')); ?></li>
                                                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT) { ?>
                                                    <li><?= anchor('upfront_payments/form', trans('upfront_payments_add')); ?></li>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php endif; ?>

                                        <li>
                                            <hr>
                                        </li>
                                    <?php } ?>

                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ACCOUNTANT))) { ?>
                                        <?php if ($statuses[7]['part_status'] == 'checked') : ?>
                                            <li><?= anchor('invoices/reports', trans('financial_reports')); ?></li>
                                        <?php endif; ?>
                                        <?php if ($statuses[31]['part_status'] == 'checked') : ?>
                                            <li><?= anchor('company_savings/index', trans('show_company_savings')); ?></li>
                                        <?php endif; ?>

                                    <?php } ?>
                                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ACCOUNTANT): ?>
                                        <!-- <li><?= anchor('reports/invoice_aging', trans('invoice_aging')); ?></li> -->
                                        <!-- <li><?= anchor('reports/payment_history', trans('payment_history')); ?></li> -->
                                        <li>
                                            <hr>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($statuses[28]['part_status'] == 'checked') : ?>
                                        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                                            <li><?= anchor('recurring_income/form', trans('recurring_income_create')); ?></li>
                                            <li><?= anchor('recurring_income/index', trans('recurring_income_show')); ?></li>
                                            <li>
                                                <hr>
                                            </li>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <?php if ($statuses[29]['part_status'] == 'checked') : ?>
                                        <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS, TYPE_EMPLOYEES, TYPE_SALESPERSON))) { ?>
                                            <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT) { ?>
                                                <li><?= anchor('subscriptions/form', trans('create_subscriptions')); ?></li>
                                            <?php } ?>
                                            <li><?= anchor('subscriptions/index', trans('view_subscriptions')); ?></li>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <?php if ($statuses[30]['part_status'] == 'checked') : ?>
                                        <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS, TYPE_EMPLOYEES, TYPE_SALESPERSON))) { ?>
                                            <li><?= anchor('expenses/index', trans('expenses_view')); ?></li>
                                        <?php } ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($statuses[30]['part_status'] == 'checked') : ?>
                                    <!--add_expenses_tablet-->
                                    <li><?= anchor('expenses/tablet_form', trans('expenses_add')); ?></li>
                                <?php endif; ?>
                                <?php
                                if ($template != 'No Template'){

                                    foreach ($selected as $val){
                                        if (($val->part_status == 'checked') && ($val->group_name == 'finance' )){ ?>

                                            <li><?= anchor('', trans($val->part_name)); ?></li>

                                        <?php }
                                    }
                                }
                                ?>



                                <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                                    <!-- <li><hr></li> -->
                                    <!-- <li><?= anchor('company_savings/form', trans('add_company_saving')); ?></li> -->
                                    <!-- <li><?= anchor('company_savings/index', trans('show_company_savings')); ?></li> -->
                                <?php } ?>

                                <li>
                                    <hr>
                                </li>
                                <li class="header_menu_group_title"><?= trans('taxes') ?></li>

                                <?php
                                if ($template != 'No Template'){

                                foreach ($selected as $val){
                                        if (($val->part_status == 'checked') && ($val->group_name == 'taxes' )){ ?>

                                            <li><?= anchor('', trans($val->part_name)); ?></li>

                                        <?php }
                                    }
                                }
                                ?>

                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Sales -->
                    <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS, TYPE_EMPLOYEES, TYPE_CLIENTS))): ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle navbar_link" data-toggle="dropdown">
                                <span class="hidden-md"><?php _trans('sales'); ?></span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i> &nbsp;
                                <i class="visible-md-inline fa fa-users"></i>
                            </a>
                            <ul class="dropdown-menu">

                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ACCOUNTANT))) { ?>
                                    <?php if (USE_QUOTES): ?>
                                        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                                            <li><a href="#" class="create-quote"><?php _trans('create_quote'); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <li><?= anchor('quotes/index', trans('view_quotes')); ?></li>
                                        <li>
                                            <hr>
                                        </li>
                                    <?php endif; ?>
                                <?php } ?>

                                <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_SALESPERSON))) { ?>
                                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                                        <li><?= anchor('products/form', trans('create_product')); ?></li>
                                    <?php endif; ?>
                                    <li><?= anchor('products/index', trans('view_products')); ?></li>
                                    <li><?= anchor('families/index', trans('product_families')); ?></li>
                                    <li><?= anchor('units/index', trans('product_units')); ?></li>
                                    <li>
                                        <hr>
                                    </li>
                                <?php } ?>
                                <?php if ($statuses[14]['part_status'] == 'checked') : ?>
                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS))) : ?>
                                        <!-- Menu TYPE_EMPLOYEES and TYPE_FREELANCERS -->
                                        <li><?= anchor('clients/form', trans('add_client')); ?></li>
                                        <li><?= anchor('clients/index', trans('view_clients')); ?></li>
                                        <li>
                                            <hr>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS))): ?>
                                    <?php if ($statuses[72]['part_status'] == 'checked') : ?>
                                        <?php if ($this->session->userdata('user_type') != TYPE_CLIENTS): ?>
                                            <li><?= anchor('', trans('Enter Inventory')); ?></li>
                                        <?php endif; ?>
                                        <li><?= anchor('', trans('View Inventory')); ?></li>
                                        <li>
                                            <hr>
                                        </li>
                                    <?php endif; ?>

                                <?php endif; ?>
                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR))): ?>
                                    <?php if ($statuses[15]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('reports/sales_by_client', trans('sales_by_client')); ?></li>
                                    <?php endif; ?>
                                    <?php if ($statuses[16]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('reports/sales_by_year', trans('sales_by_date')); ?></li>
                                    <?php endif; ?>


                                    <li>
                                        <hr>
                                    </li>
                                <?php endif; ?>

                                <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_SALESPERSON))): ?>
                                    <?php if ($statuses[32]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('leads/form', trans('add_lead')); ?></li>
                                        <li><?= anchor('leads/index', trans('view_leads')); ?></li>
                                    <?php endif; ?>
                                    <li>
                                        <hr>
                                    </li>
                                    <?php if ($statuses[17]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('distributors/form', trans('add_distributor')); ?></li>
                                        <li><?= anchor('distributors/index', trans('view_distributors')); ?></li>
                                    <?php endif; ?>

                                    <li>
                                        <hr>
                                    </li>
                                    <?php if ($statuses[18]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('suppliers/form', trans('add_supplier')); ?></li>
                                        <li><?= anchor('suppliers/index', trans('view_suppliers')); ?></li>
                                    <?php endif; ?>

                                    <?php if ($statuses[19]['part_status'] == 'checked') : ?>
                                        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN): ?>
                                            <li>
                                                <hr>
                                            </li>
                                            <li><?= anchor('legal_issues/form', trans('enter_legal_issues')); ?></li>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                <?php endif; ?>
                                <?php if ($statuses[19]['part_status'] == 'checked') : ?>
                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ACCOUNTANT))): ?>
                                        <li><?= anchor('legal_issues/index', trans('view_legal_issues')); ?></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php
                                if ($template != 'No Template'){

                                foreach ($selected as $val){
                                    if (($val->part_status == 'checked') && ($val->group_name == 'sales' )){?>
                                        <li><?= anchor('', trans($val->part_name)); ?></li>
                                    <?php }
                                }}
                                ?>

                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- END SALES -->


                    <!-- Projects -->
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <li class="dropdown <?= get_setting('projects_enabled') == 1 ?: 'hidden'; ?>">
                            <a href="#" class="dropdown-toggle navbar_link" data-toggle="dropdown">
                                <span class="hidden-md"><?php _trans('projects'); ?></span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i> &nbsp;
                                <i class="visible-md-inline fa fa-check-square-o"></i>
                            </a>
                            <ul class="dropdown-menu">

                                <?php if ($statuses[20]['part_status'] == 'checked') : ?>
                                    <li><?= anchor('notes/form', trans('create_note')); ?></li>
                                    <li><?= anchor('notes/index', trans('show_notes')); ?></li>
                                <?php endif; ?>

                                <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS))): ?>
                                    <!-- Menu view Projects -->
                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ADMINISTRATOR, TYPE_MANAGERS))): ?>
                                        <?php if ($statuses[21]['part_status'] == 'checked') : ?>
                                            <li>
                                                <hr>
                                            </li>
                                            <?php if (!in_array($this->session->userdata('user_type'), array(TYPE_MANAGERS))): ?>
                                                <li><?= anchor('website_access/form', trans('create_website_access')); ?></li>
                                            <?php endif; ?>
                                            <li><?= anchor('website_access/index', trans('website_access')); ?></li>
                                        <?php endif; ?>

                                        <?php if ($this->session->userdata('user_type') != TYPE_ADMINISTRATOR): ?>
                                            <li>
                                                <hr>
                                            </li>
                                            <li><?= anchor('projects/form', trans('create_project')); ?></li>
                                            <li><?= anchor('projects/index', trans('show_projects')); ?></li>
                                        <?php endif; ?>
                                    <?php endif; ?>


                                    <?php if ($this->session->userdata('user_type') != TYPE_ADMINISTRATOR): ?>
                                        <li>
                                            <hr>
                                        </li>
                                        <?php if ($this->session->userdata('user_type') == TYPE_ACCOUNTANT): ?>
                                            <!-- TYPE_ACCOUNTANT -->
                                            <li><?= anchor('tickets/status/all', trans('view_tickets')); ?></li>
                                        <?php endif; ?>
                                    <?php endif; ?>


                                    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ADMINISTRATOR, TYPE_MANAGERS))): ?>
                                        <li><?= anchor('todo_tickets/form', trans('todo_form')); ?></li>
                                    <?php endif; ?>

                                <?php endif; ?>
                                <li><?= anchor('todo_tickets/status/all', trans('todo_tickets')); ?></li>
                                <?php
                                if ($template != 'No Template'){

                                foreach ($selected as $val){
                                    if (($val->part_status == 'checked') && ($val->group_name == 'project' )){?>
                                        <li><?= anchor('', trans($val->part_name)); ?></li>
                                    <?php }
                                }}
                                ?>

                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- END Projects -->


                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN && USE_OFFERS) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle navbar_link" data-toggle="dropdown">
                                <span class="hidden-md"><?php _trans('offers'); ?></span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i> &nbsp;
                                <i class="visible-md-inline fa fa-plus-square"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="create-offer"><?php _trans('create_offer'); ?></a></li>
                                <li><?= anchor('offers/index', trans('view_offers')); ?></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <!-- Mobility -->
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle navbar_link" data-toggle="dropdown">
                                <span class="hidden-md"><?php _trans('resources'); ?></span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i> &nbsp;
                                <i class="visible-md-inline fa fa-credit-card"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($statuses[22]['part_status'] == 'checked') : ?>
                                    <li><?= anchor('expertises/index', trans('expertise_list')); ?></li>
                                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR) { ?>
                                        <li><?= anchor('expertises_company/index', trans('expertises_company')); ?></li>
                                    <?php } ?>
                                <?php endif; ?>

                                <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                                    <?php
                                    if ($template != 'No Template'){

                                        foreach ($selected as $val){
                                        if (($val->part_status == 'checked') && ($val->group_name == 'project' )){?>
                                            <li><?= anchor('', trans($val->part_name)); ?></li>
                                        <?php }
                                    }}
//                                    var_dump($statuses[0]);die;
                                    ?>
                                    <?php if ($statuses[23]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('hr/freelancers', trans('freelancers')); ?></li>
                                    <?php endif; ?>
                                    <?php if ($statuses[24]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('hr/influencers', trans('Influencers')); ?></li>
                                    <?php endif; ?>
                                    <?php if ($statuses[25]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('hr/employees', trans('employees')); ?></li>
                                    <?php endif; ?>
                                    <?php if ($statuses[26]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('hr/managers', trans('managers')); ?></li>
                                    <?php endif; ?>
                                    <?php if ($statuses[27]['part_status'] == 'checked') : ?>
                                        <li><?= anchor('hr/other_users', trans('other_users')); ?></li>
                                    <?php endif; ?>

                                    <li>
                                        <hr>
                                    </li>
                                <?php } ?>
                                <?php if ($statuses[73]['part_status'] == 'checked') : ?>
                                    <li><?= anchor('', trans('Enter study program')); ?></li>
                                    <li><?= anchor('', trans('View study program')); ?></li>
                                    <li>
                                        <hr>
                                    </li>
                                <?php endif; ?>
                                <?php if ($statuses[74]['part_status'] == 'checked') : ?>
                                    <li><?= anchor('', trans('Enter students')); ?></li>
                                    <li><?= anchor('', trans('View students')); ?></li>
                                    <li><?= anchor('', trans('In-progress grades')); ?></li>
                                <?php endif; ?>
                                <?php
                                if ($template != 'No Template'){

                                foreach ($selected as $val){
                                    if (($val->part_status == 'checked') && ($val->group_name == 'resource' )){?>
                                        <li><?= anchor('', trans($val->part_name)); ?></li>
                                    <?php }
                                }}
                                ?>
                                <?php  if ($template == 'No Template') : ?>

                                    <li><?= anchor('hr/freelancers', trans('freelancers')); ?></li>
                                    <li><?= anchor('hr/influencers', trans('Influencers')); ?></li>
                                    <li><?= anchor('hr/employees', trans('employees')); ?></li>
                                    <li><?= anchor('hr/managers', trans('managers')); ?></li>
                                    <li><?= anchor('hr/other_users', trans('other_users')); ?></li>


                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php } ?>

                </ul>

                <ul class="nav navbar-nav navbar-right header_padding">
                    <li><p style="margin-top: 15px"><?php echo $template ?></p></li>
                    <li>
                        <a href="https://spudu.com/en/get-started/" target="_blank"
                           class="tip icon" title="<?php _trans('documentation'); ?>"
                           data-placement="bottom">
                            <i class="fa fa-question-circle"></i>
                            <span class="visible-xs">&nbsp;<?php _trans('documentation'); ?></span>
                        </a>
                    </li>


                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR) { ?>
                        <li class="dropdown">
                            <div class="clearfix"></div>
                            <a href="#" class="tip icon dropdown-toggle" data-toggle="dropdown"
                               title="<?php _trans('settings'); ?>"
                               data-placement="bottom">
                                <i class="fa fa-cogs"></i>
                                <span class="visible-xs">&nbsp;<?php _trans('settings'); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                                    <li><?= anchor('custom_fields/index', trans('custom_fields')); ?></li>
                                    <li><?= anchor('email_templates/index', trans('email_templates')); ?></li>
                                    <li><?= anchor('appointments_templates/index', trans('appointments_templates')); ?></li>
                                    <li><?= anchor('expenses_templates/index', trans('expenses_templates')); ?></li>
                                    <li><?= anchor('inventory_templates/index', trans('inventory_templates')); ?></li>
                                    <li><?= anchor('invoice_groups/index', trans('invoice_groups')); ?></li>
                                    <li><?= anchor('invoices/archive', trans('invoice_archive')); ?></li>
                                    <!-- // temporarily disabled
                            <li><?= anchor('item_lookups/index', trans('item_lookups')); ?></li>
                            -->
                                    <li><?= anchor('payment_methods/index', trans('payment_methods')); ?></li>
                                    <li><?= anchor('tax_rates/index', trans('tax_rates')); ?></li>
                                    <li><?= anchor('commission_rates/index', trans('commission_rates')); ?></li>
                                    <li><?= anchor('users/index', trans('user_accounts')); ?></li>
                                    <li><?= anchor('user_groups/index', trans('user_groups')); ?></li>

                                    <li><?= anchor('companies/index', trans('companies')); ?></li>
                                    <li><?= anchor('login_quotes/index', trans('dashboard_to_slogans')); ?></li>
                                    <li class="divider hidden-xs hidden-sm"></li>
                                    <li><?= anchor('settings', trans('system_settings')); ?></li>
                                    <li><?= anchor('import', trans('import_data')); ?></li>
                                <?php } elseif ($this->session->userdata('user_type') == TYPE_ADMINISTRATOR) { ?>
                                    <li><?= anchor('expenses_templates/index', trans('expenses_templates')); ?></li>
                                    <li><?= anchor('login_quotes/index', trans('dashboard_to_slogans')); ?></li>
                                <?php } else { ?>
                                    <li><?= anchor('login_quotes/index', trans('dashboard_to_slogans')); ?></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <li>
                        <a href="<?= site_url('users/form/' .
                            $this->session->userdata('user_id')); ?>"
                           class="tip icon" data-placement="bottom"
                           title="<?php
                           _htmlsc($this->session->userdata('user_name'));
                           if ($this->session->userdata('user_company')) {
                               print(" (" . htmlsc($this->session->userdata('user_company')) . ")");
                           }
                           ?>">
                            <i class="fa fa-user"></i>
                            <span class="visible-xs">&nbsp;<?php
                                _htmlsc($this->session->userdata('user_name'));
                                if ($this->session->userdata('user_company')) {
                                    print(" (" . htmlsc($this->session->userdata('user_company')) . ")");
                                }
                                ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('sessions/logout'); ?>"
                           class="tip icon logout" data-placement="bottom"
                           title="<?php _trans('logout'); ?>">
                            <i class="fa fa-power-off"></i>
                            <span class="visible-xs">&nbsp;<?php _trans('logout'); ?></span>
                        </a>
                    </li>
                </ul>

                <?php if (isset($filter_display) and $filter_display == true) { ?>
                    <?php $this->layout->load_view('filter/jquery_filter'); ?>
                    <div class="col-sm-12 hidden-lg">
                        <form class="navbar-form navbar-left m-0" role="search" onsubmit="return false;">
                            <div class="form-group">
                                <input id="filter" type="text" class="search-query form-control input-sm"
                                       placeholder="<?= $filter_placeholder; ?>">
                            </div>
                        </form>
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>
</nav>
