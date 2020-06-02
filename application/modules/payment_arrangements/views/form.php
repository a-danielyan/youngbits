<script>
    $(function () {
        <?php $this->layout->load_view('clients/script_select2_client_id.js'); ?>
    });

</script>

<style>
    .warning{
        border: 1px solid red;
    }

    .amount_delete{
        background: red;
        color: white;
    }
</style>

<form method="post" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($payment_arrangements_id) { ?>
        <input type="hidden" name="payment_id" value="<?php echo $payment_arrangements_id; ?>">
    <?php } ?>

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('payment_arrangement_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="payment_arrangement_title" class="control-label"><?php _trans('payment_arrangement_title'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input name="payment_arrangement_title" id="payment_arrangement_title"
                       class="form-control"
                       value="<?php echo $this->mdl_payment_arrangements->form_value('payment_arrangement_title'); ?>">

            </div>
        </div>


        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="payment_arrangement_payment_number" class="control-label"><?php _trans('payment_arrangement_payment_number'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input name="payment_arrangement_payment_number" id="payment_arrangement_payment_number"
                       class="form-control"
                       value="<?php echo $this->mdl_payment_arrangements->form_value('payment_arrangement_payment_number'); ?>">

            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="payment_arrangement_client_id" class="control-label"><?php _trans('client'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <select name="payment_arrangement_client_id" id="payment_arrangement_client_id" class="client-id-select form-control"
                            autofocus="autofocus">
                        <?php if (!empty($client)) : ?>
                            <option value="<?php echo $client->client_id; ?>"><?php _htmlsc(format_client($client)); ?></option>
                        <?php endif; ?>
                    </select>
                    <span id="toggle_permissive_search_clients" class="input-group-addon"
                          title="<?php _trans('enable_permissive_search_clients'); ?>" style="cursor:pointer;">
                        <i class="fa fa-toggle-<?php echo get_setting('enable_permissive_search_clients') ? 'on' : 'off' ?> fa-fw"></i>
                    </span>
                </div>
            </div>

        </div>


        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="payment_arrangement_total_amount" class="control-label"><?php _trans('payment_arrangement_total_amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="number" min="0" step="0.01" name="payment_arrangement_total_amount" id="payment_arrangement_total_amount" class="form-control"
                       value="<?= $this->mdl_payment_arrangements->form_value('payment_arrangement_total_amount'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="payment_note" class="control-label"><?php _trans('payment_arrangement_text'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="payment_arrangement_text"
                          class="form-control"><?php echo $this->mdl_payment_arrangements->form_value('payment_arrangement_text', true); ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="payment_arrangement_balance" class="control-label"><?php _trans('payment_arrangement_balance'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input id="payment_arrangement_show_balance" class="form-control payment_arrangement_show_balance"
                       value="" disabled >

                <input type="hidden" min="0" step="0.01" name="payment_arrangement_balance" id="payment_arrangement_balance" class="form-control payment_arrangement_balance"
                       value="" >
            </div>
        </div>



        <div class="form-group">
            <hr>

            <div class="col-xs-12 col-sm-8 text-right text-left-xs">
                <button class="btn btn-primary create_amount" type="button">+ Add amount</button>
            </div>

        </div>
        <div class="form-group">

            <div class="amounts">
            <?php if(!empty($payment_arrangement_amount)){ ?>
                <?php foreach ($payment_arrangement_amount as $key => $amount){?>
                    <div class="form-group amount_form">
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="payment_arrangement_balance" class="control-label"><?php _trans('amount'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="number" min="0" name="payment_arrangement_amount[amout][]" class="form-control payment_arrangement_amount" value="<?=$amount->amount; ?>" >
                                    <span class="input-group-addon amount_delete"
                                          title="<?php _trans('delete'); ?>" style="cursor:pointer;">
                                         <i class="fa fa-trash-o fa-margin"></i>
                                </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                                        <label for="payment_date" class="control-label"><?php _trans('date'); ?></label>
                                    </div>
                                    <div class="col-xs-11 col-md-10">
                                        <div class="input-group">
                                            <input name="payment_arrangement_amount[data][]" id="payment_date"
                                                   class="form-control datepicker"
                                                   value="<?= ($amount->date)?$amount->date:''; ?>">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-fw"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php }?>
            <?php } ?>
            </div>
        </div>
    </div>
</form>


<script>

    $(document).ready(function () {
        var balanc =+$('#payment_arrangement_total_amount').val();
        let sum =  0;
        let all_amount =  $('.payment_arrangement_amount');
        for (let i = 0; i < all_amount.length ; i++) {
            let x =+$(all_amount[i]).val();
            sum+=x;
        }
        $('#payment_arrangement_show_balance').attr('value',balanc-sum);
        $('#payment_arrangement_balance').attr('value',balanc);


        $(document).on('change', '#payment_arrangement_total_amount', function () {
            var val=$(this).val();

            var balanc =+$('#payment_arrangement_show_balance').val();
            let sum =  0;
            let all_amount =  $('.payment_arrangement_amount');
            for (let i = 0; i < all_amount.length ; i++) {
                let x =+$(all_amount[i]).val();
                sum+=x;
            }

            $('.payment_arrangement_balance').attr('value',val);
            balanc=val-sum;
               $('#payment_arrangement_show_balance').attr('value',balanc);

                if(+$('.payment_arrangement_show_balance').val() < 0){

                    $('.payment_arrangement_amount').addClass('warning');
                    $('.payment_arrangement_show_balance').addClass('warning');
                    $('button').attr('disabled','disabled')
                }else{
                    success();
                }



        });

        $(document).on('click', '.create_amount', function () {
                var elm_amount = `<div class="form-group amount_form">
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="payment_arrangement_balance" class="control-label"><?php _trans('amount'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                        <div class="col-md-6">
                            <div class="input-group">
                                      <input type="number" min="0" name="payment_arrangement_amount[amout][]" class="form-control payment_arrangement_amount" value="" placeholder='0'>
                                <span class="input-group-addon amount_delete"
                                       style="cursor:pointer;">
                                         <i class="fa fa-trash-o fa-margin"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="input-group">
                                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                                        <label for="payment_date" class="control-label"><?php _trans('date'); ?></label>
                                    </div>
                                    <div class="col-xs-11 col-md-10">
                                        <div class="input-group">
                                           <input name="payment_arrangement_amount[data][]" id="payment_date"
                                                   class="form-control datepicker"
                                                   value="<?= date('m-d-Y'); ?>" data-provide="datepicker">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-fw"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>`;
            $('.amounts').prepend(elm_amount);

            $('.datepicker').datepicker({
                weekStart: 2019
            });
        })

        $(document).on('change', '.payment_arrangement_amount', function () {
            let balance = $('.payment_arrangement_show_balance').val();

            let amount = +$('.payment_arrangement_amount').val();
            let new_balance = +$('#payment_arrangement_balance').val();
            let new_b = 0;
            let sum =  0;
            let all_amount =  $('.payment_arrangement_amount');
            for (let i = 0; i < all_amount.length ; i++) {
                let x =+$(all_amount[i]).val();
                sum+=x;
            }




            if(balance >= 0 && balance >=amount){
                new_b = new_balance - sum;
                $('.payment_arrangement_show_balance').attr('value',new_b);
                success()
            }else{
                new_b = new_balance - sum;
                $('.payment_arrangement_show_balance').attr('value',new_b);

                $('.payment_arrangement_amount').addClass('warning');
                $('.payment_arrangement_show_balance').addClass('warning');
                $('button').attr('disabled','disabled')
            }

            if(+$('.payment_arrangement_show_balance').val() >= 0){
                success()
            }
        })

        $(document).on('click', '.amount_delete', function () {

            $(this).parents('.amount_form').remove();

            var new_balance = +$('#payment_arrangement_balance').val();
            var all_amount =  $('.payment_arrangement_amount');
            var sum =  0;
            for (var i = 0; i < all_amount.length ; i++) {
                let x =+$(all_amount[i]).val();
                sum+=x;
            }
            new_balance-=sum;
            if(new_balance >= 0){
                $('.payment_arrangement_show_balance').attr('value',new_balance);
            }
            success();
        })


        function success() {
            $('.payment_arrangement_amount').removeClass('warning');
            $('.payment_arrangement_show_balance').removeClass('warning');
            $('button').removeAttr('disabled');
        }

    })
</script>