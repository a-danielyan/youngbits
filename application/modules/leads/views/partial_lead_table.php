
<div class="table-responsive">

    <table class="table table-striped">
        <thead>
        <tr>
            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'lead_id', 'ip_leads'); ?>><?php _trans('id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_name', 'ip_leads'); ?>><?php _trans('lead_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_email', 'ip_leads'); ?>><?php _trans('email_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_phone', 'ip_leads'); ?>><?php _trans('phone_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_web', 'ip_leads'); ?>><?php _trans('web_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_email_sent', 'ip_leads'); ?>><?php _trans('email_sent'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_city', 'ip_leads'); ?>><?php _trans('city'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_country', 'ip_leads'); ?>><?php _trans('country'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_responsible', 'ip_leads'); ?>><?php _trans('responsible'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_category', 'ip_leads'); ?>><?php _trans('category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'lead_sell_services_products', 'ip_leads'); ?>><?php _trans("sell_services_products"); ?></a></th>
            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR|| $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS){ ?>
            <th><?php _trans('options'); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $lead) : ?>
            <tr>
                <td><input type="checkbox" value="<?= $lead->lead_email ?>" class="sel" data-id="<?=$lead->lead_id?>"></td>
                <td><?=$lead->lead_id; ?></td>
                <td>
                    <a href="<?= base_url('leads/view/'.$lead->lead_id)?>" >
                        <?= $lead->lead_name ?>
                    </a>
                </td>



                <td class="lead_email"><?php _htmlsc($lead->lead_email); ?></td>
                <td><?php _htmlsc($lead->lead_phone ? $lead->lead_phone : ''); ?></td>
                <td><a href="<?=(strpos($lead->lead_web, 'http://') !== false ||  strpos($lead->lead_web, 'https://') !== false)? $lead->lead_web : 'http://'.$lead->lead_web ?>" role="button" target="_blank" > <?= _htmlsc($lead->lead_web) ?></a></td>
                <td class="text-center"><?=($lead->lead_email_sent == 1)? '<img src="'.base_url().'assets/core/img/check_file.png" style="min-width: 30px;max-width: 30px"">' : '' ?></td>
                <td><?php _htmlsc($lead->lead_city); ?></td>
                <td class="text-center"><?php _htmlsc($lead->lead_country); ?></td>
                <td><?php _htmlsc($lead->lead_responsible); ?></td>
                <td><?php _htmlsc($lead->lead_category ? $lead->lead_category : ''); ?></td>
                <td><?php _htmlsc($lead->lead_sell_services_products); ?>
                </td>

                <?php if(in_array($this->session->userdata('user_type'), array(TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON)) ){ ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('leads/view/' . $lead->lead_id); ?>">
                                        <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('leads/form/' . $lead->lead_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('leads/delete/' . $lead->lead_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_lead_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    var arr_email = [];

    $(document).on('change', '.sel', function () {


        var email_address = $(this).parents('tr').find('.lead_email').text();
        var lead_id = $(this).data('id');

        if($.inArray(lead_id,arr_email) == -1){
            arr_email.push(lead_id);
        }else{
            arr_email.pop(lead_id);
        }


        if(arr_email.length > 0 ){
            $('.sendMail').removeAttr('disabled')
        }else{
            $('.sendMail').attr('disabled','disabled')
        }




    });


    $(document).on('click', '.sendMail', function () {
        $.ajax({
            url:"   ../../mailer/prospect",
            type:'post',
            data:{arr_email:arr_email},

            success: function(data) {
                $('body').html(data);
            }
        });
    });

</script>
