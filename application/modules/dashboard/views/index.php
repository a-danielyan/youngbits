
<div class="col header_welcome_img_block">
    <img style="width: 100%;" src=' <?=($login_quote && $login_quote->quote_document_link)? $login_quote->quote_document_link:base_url('/uploads/quotes/default.png');?>'/>
    <div class="container-fluid">
        <div class="col-md-5 header_welcome_inf">
            <h1>Welcome <?=$this->session->userdata('user_name')?></h1>
            <h4 class="welcome_appointments">No appointments today</h4>
            <div class="welcome_border"></div>
            <h4 class="welcome_birthday">No birthdays today</h4>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <?php echo $this->layout->load_view('layout/alerts'); ?>
    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_SALESPERSON, TYPE_CLIENTS)) ): ?>
        <div class="col panel_quick_actions">
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 action_title">
                <b><?php _trans('quick_actions'); ?></b>
            </div>
            <div class="col-lg-7 col-md-8 col-xs-12 text-right respons_text_center pr-0">
                <div class="btn-group">

                    <?php if ( !in_array($this->session->userdata('user_type'), array(TYPE_ADMINISTRATOR, TYPE_SALESPERSON,TYPE_CLIENTS)) ){ ?>
                        <a href="<?php echo site_url('leads/form'); ?>" class="btn btn-default menu_link">
                            <div class="action_item">
                                <!-- add prospect -->
                                <span><?php _trans('add_lead'); ?></span>
                            </div>
                        </a>

                        <a href="<?php echo site_url('clients/form'); ?>" class="btn btn-default menu_link">
                            <div class="action_item">
                                <span><?php _trans('add_client'); ?></span>
                            </div>
                        </a>


                        <?php  if (USE_QUOTES) { ?>
                            <a href="javascript:void(0)" class="create-quote btn btn-default menu_link">
                                <div class="action_item">
                                    <span><?php _trans('create_quote'); ?></span>
                                </div>
                            </a>
                        <?php } ?>

                        <a href="javascript:void(0)" class="create-invoice btn btn-default menu_link">
                            <div class="action_item">
                                <span><?php _trans('create_invoice'); ?></span>
                            </div>
                        </a>
                    <?php } ?>

                    <a href="<?php echo site_url('inventory/form'); ?>" class="btn btn-default menu_link" style="border-right: 0">
                        <div class="action_item">
                            <span><?php _trans('enter_inventory'); ?></span>
                        </div>
                    </a>


                </div>

            </div>

            <div class="clearfix"></div>
        </div>
    <?php endif; ?>


    <div class="col bg-white mt-3 welc_back_div">
        <div class="action_title p-3">
            <b><?php _trans('status_business'); ?></b>
        </div>

        <div class="result_block justify-content-center respons_hidden">


                <div class="col-lg-4 col-md-4 col-xs-4 pl-0">
                    <div class="col">
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('reveune_last_year'))?></h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?=$revenue_results; ?> %</h5></div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="col mt-2">
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('overdue_invoices'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?= $percentage_overdue; ?> %</h5></div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                <div class="col">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('monthly_cashflow'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5> <span class="currency"> € <?=$result_monthly; ?></span> </h5></div>
                    <?php } ?>

                    <div class="clearfix"></div>
                </div>
                <div class="col mt-2">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('runway'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5> <?=$runway?>  <?=_(trans('months'))?></h5></div>
                    <?php } ?>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                <div class="col">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('uncapitalized_sales'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?= $sales_pipeline_results; ?> %</h5></div>
                    <?php } ?>

                    <div class="clearfix"></div>
                </div>
                <div class="col mt-2">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('total_users'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?=$total_users; ?></h5></div>
                    <?php } ?>

                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="clearfix"></div>

        </div>
        <div class="result_block justify-content-center mobile">
            <?php if (! in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS,TYPE_CLIENTS)) ) { ?>
                <div class="col-md-12 pl-0">
                    <div class="col">
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('reveune_last_year'))?></h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?=$revenue_results; ?> %</h5></div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="col mt-2">
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('overdue_invoices'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?= $percentage_overdue; ?> %</h5></div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-12 pl-0 mt-2">
                <!-- ORDINARY -->
                <div class="col">
                   <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT,)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('monthly_cashflow'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5> <span class="currency"> € <?=$result_monthly; ?></span> </h5></div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col mt-2">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT,TYPE_SALESPERSON)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('runway'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5> <?=$runway?> <?=_(trans('months'))?></h5></div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="col-md-12 pl-0 mt-2">
                <div class="col">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT,TYPE_SALESPERSON)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('uncapitalized_sales'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?= $sales_pipeline_results; ?> %</h5></div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col mt-2">
                    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_MANAGERS, TYPE_ADMINISTRATOR, TYPE_ACCOUNTANT,TYPE_SALESPERSON)) ){ ?>
                        <div class="col-lg-7 col-md-8 col-xs-8 xs-p-0"><h5><?=_(trans('total_users'))?>:</h5></div>
                        <div class="col-lg-5 col-md-4 col-xs-4 p-0"><h5><?=$total_users; ?></h5></div>
                     <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

    <!-- Dashboard content 1 page -->

    <?php  if (!in_array($this->session->userdata('user_type'), array(TYPE_MANAGERS,TYPE_FREELANCERS)) ) { ?>

        <!--DISABLED FIRST BLOCK MANAGER-->
        <div class="sec_block sec_block_1 mt-3">
            <?php  if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ACCOUNTANT,TYPE_ADMINISTRATOR)) ) { ?>
                <div class="sec img_revenue">
                    <div class="col sec_header">
                        <div class="icon revenue_icon"></div>
                        <span class="uppercase"><?=_(trans('revenue'))?></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col sec_title">
                        <span><?=_(trans('current_revenue'))?></span>
                        <span>€ <?=$invoice_amount_last_year?></span>
                    </div>
                    <div class="col sec_title">
                        <span><?=_(trans('last_revenue'))?></span>
                        <span>€ <?=$invoice_amount_revenue_year?></span>
                    </div>
                    <div class="col sec_title">
                        <span><?=_(trans('overdue_invoices'))?></span>
                        <span>€ <?=$invoice_amount_overdue; ?></span>
                    </div>
                    <div class="col sec_title">
                        <span> <?=_(trans('draft_invoices'))?></span>
                        <span>€ <?=$invoice_amount_draft_year?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>


            <?php   if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ACCOUNTANT,TYPE_ADMINISTRATOR)) )  { ?>
                <div class="sec img_finances">
                    <div class="col sec_header">
                        <div class="icon finances_icon"></div>
                        <span class="uppercase"><?=_(trans('monthly_finances'))?></span>
                        <div class="clearfix"></div>
                    </div>

                    <?php  if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN)) ) { ?>
                        <div class="col sec_title">
                            <span><?=_(trans('company_savings'))?></span>
                            <span>€ <?=(!empty($company_saving->company_saving_text))?$company_saving->company_saving_text : 0;?></span>
                        </div>
                    <?php  } ?>

                    <div class="col sec_title">
                        <span><?=_(trans('recurring_invoices'))?></span>
                        <span>€ <?=$recurring_invoices_quarter?></span>
                    </div>

                    <div class="col sec_title">
                        <span><?=_(trans('recurring_income'))?></span>
                        <span>€ <?=$other_recurring_income_total_quarter; ?></span>
                    </div>


                    <?php  if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN,TYPE_ADMINISTRATOR,TYPE_ACCOUNTANT)) ) { ?>
                        <div class="col sec_title">
                            <span> <?=_(trans('subscriptions'))?></span>
                            <span>€ <?=$subscription_amount_month?></span>
                        </div>
                    <?php  } ?>
                    <div class="clearfix"></div>
                </div>
            <?php  }?>

            <?php  if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN,TYPE_ACCOUNTANT,TYPE_MANAGERS,TYPE_ADMINISTRATOR)) ) { ?>
                <div class="sec img_other">
                    <div class="col sec_header">
                        <div class="icon other_icon"></div>
                        <span class="uppercase"><?=_(trans('other_finances'))?></span>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col sec_title">
                        <span><?=_(trans('expenses'))?></span>
                        <span>$ <?=$total_expenses['dollar']?> / € <?=$total_expenses['euro']?></span>
                    </div>

                    <div class="col sec_title">
                        <span><?=_(trans('kilometers'))?></span>
                        <span>€ <?=$total_kilometers?></span>
                    </div>

                    <div class="col sec_title">
                        <span><?=_(trans('legal_issues'))?></span>
                        <span>€ <?=$legal_issues_total_amount; ?></span>
                    </div>

                    <div class="col sec_title">
                        <span> <?=_(trans('upfront_payments'))?></span>
                        <span>€ <?=$upfront_payments_amount_overdue_year?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php  }?>

            <?php   if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN, TYPE_ACCOUNTANT,TYPE_ADMINISTRATOR)) )  { ?>
                <div class="sec img_sales">
                    <div class="col sec_header">
                        <div class="icon sales_icon"></div>
                        <span class="uppercase"><?=_(trans('quarterly_finances'))?></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col sec_title">
                        <span><?=_(trans('1st_quarter'))?></span>
                        <span>€ <?=$paid_4quarter['1st']?></span>
                    </div>
                    <div class="col sec_title">
                        <span><?=_(trans('2nd_quarter'))?></span>
                        <span>€ <?=$paid_4quarter['2nd']?></span>
                    </div>

                    <div class="col sec_title">
                        <span><?=_(trans('3nd_quarter'))?></span>
                        <span>€ <?=$paid_4quarter['3nd']; ?></span>
                    </div>

                    <div class="col sec_title">
                        <span> <?=_(trans('4th_quarter'))?></span>
                        <span>€ <?=$paid_4quarter['4th']?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <!-- Dashboard content 2 page -->

    <?php  if (in_array($this->session->userdata('user_type'), array(TYPE_MANAGERS,TYPE_FREELANCERS,TYPE_SALESPERSON,TYPE_CLIENTS)) ) { ?>
        <div class="sec_block sec_block_2 mt-3">
    <?php }else { ?>
            <div class="sec_block sec_block_2 d-none mt-3">
    <?php } ?>


                <?php  if (!in_array($this->session->userdata('user_type'), array(TYPE_CLIENTS)) ) { ?>
                    <div class="sec img_revenue">
                        <div class="col sec_header">
                            <div class="icon revenue_icon"></div>
                            <span class="uppercase"><?=_(trans('general_sales'))?></span>
                            <div class="clearfix"></div>
                        </div>


                        <div class="col sec_title">
                            <span><?=_(trans('clients'))?></span>
                            <span><?=$clients_count_year?></span>
                        </div>
                        <div class="col sec_title">
                            <span><?=_(trans('leads'))?></span>
                            <span><?=$leads_count_year?></span>
                        </div>
                        <?php  if (! in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS, TYPE_EMPLOYEES)) ) { ?>
                        <div class="col sec_title">
                            <span><?=_(trans('distributors'))?></span>
                            <span><?=$distributors_count?></span>
                        </div>
                        <?php } ?>
                        <div class="col sec_title">
                            <span><?=_(trans('suppliers'))?></span>
                            <span><?=$suppliers_count?></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="sec img_finances">
            <div class="col sec_header">
                <div class="icon finances_icon"></div>
                <span class="uppercase"><?=_(trans('sales_winners'))?></span>
                <div class="clearfix"></div>
            </div>
            <div class="col sec_title">
                <span><?=_(trans('this_week'))?></span>
                <span>Rene</span>
            </div>
            <div class="col sec_title">
                <span><?=_(trans('last_week'))?></span>
                <span>Jakub</span>
            </div>

            <div class="col sec_title">
                <span><?=_(trans('this_month'))?></span>
                <span>Arman</span>
            </div>

            <div class="col sec_title">
                <span> <?=_(trans('this_year'))?></span>
                <span>David</span>
            </div>
            <div class="clearfix"></div>
        </div>
                <?php } ?>
                    <div class="sec img_other">
            <div class="col sec_header">
                <div class="icon sales_icon"></div>
                <span class="uppercase"><?=_(trans('webshop'))?></span>
                <div class="clearfix"></div>
            </div>
            <div class="col sec_title">
                <span><?=_(trans('inventory_system'))?></span>
                <span><?=$count_inventory?></span>
            </div>
            <?php  if (! in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS, TYPE_EMPLOYEES,TYPE_CLIENTS)) ) { ?>
                <div class="col sec_title">
                    <span><?=_(trans('inventory_total_sale_price'))?> </span>
                    <span>€ <?=$inventory_total_sale_price?></span>
                </div>
                <div class="col sec_title">
                    <span><?=_(trans('inventory_total_regular_price'))?></span>
                    <span>€ <?=$inventory_total_amount?></span>
                </div>

                <div class="col sec_title">
                    <span> <?=_(trans('sold_amount'))?></span>
                    <span>€ <?=$inventory_total_sold?></span>
                </div>
            <?php } ?>


            <div class="clearfix"></div>
        </div>
                <?php  if (!in_array($this->session->userdata('user_type'), array(TYPE_CLIENTS)) ) { ?>
                    <div class="sec img_sales">
            <div class="col sec_header">
                <div class="icon other_icon"></div>
                <span class="uppercase"><?=_(trans('best_sold_products'))?></span>
                <div class="clearfix"></div>
            </div>
            <div class="col sec_title">
                <span><?=_(trans('this_week_winner'))?></span>
                <span>Product Y</span>
            </div>
            <div class="col sec_title">
                <span><?=_(trans('last_week_winner'))?></span>
                <span>Product X</span>
            </div>

            <div class="col sec_title">
                <span><?=_(trans('this_month_winner'))?></span>
                <span>Product Z</span>
            </div>

            <div class="col sec_title">
                <span> <?=_(trans('this_year_winner'))?></span>
                <span>Product I</span>
            </div>

            <div class="clearfix"></div>


        </div>
                <?php } ?>

    </div>



    <!-- Dashboard footer -->

    <div class="col text-center mt-5 mb-4">
        <?php  if (!in_array($this->session->userdata('user_type'), array(TYPE_MANAGERS,TYPE_FREELANCERS,TYPE_CLIENTS)) ) { ?>
            <div class="model-pager btn-group btn-group-sm mb-4 <?=($this->session->userdata('user_type') != TYPE_SALESPERSON)? '' :'d-none'  ?>">
                <button class="btn btn-default sec_block_prev disabled"  title="Prev"><i class="fa fa-backward no-margin"></i></button>
                <button class="btn btn-default sec_block_next" title="Next"><i class="fa fa-forward no-margin"></i></button>
            </div>
        <?php } ?>
        <h4><?=_(trans('productive_day'))?></h4>
        <h5 class="mt-3"><a href="https://spudu.com/en/versions-spudu/" target="_blank"><?=_(trans('version_spudu'))?></a></h5>
    </div>

</div>


<script>

    /*Dashboard content NEXT*/
    $(document).on('click', '.sec_block_next', function(){
        $('.sec_block_2').removeClass('d-none')
        $('.sec_block_prev').removeClass('disabled')
        $('.sec_block_1').addClass('d-none')
        $('.sec_block_next').addClass('disabled')
    })

    /*Dashboard content PREV*/
    $(document).on('click', '.sec_block_prev', function(){
        $('.sec_block_1').removeClass('d-none')
        $('.sec_block_next').removeClass('disabled')
        $('.sec_block_2').addClass('d-none')
        $('.sec_block_prev').addClass('disabled')
    })


</script>




