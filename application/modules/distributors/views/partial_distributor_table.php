
<div class="table-responsive">

    <table class="table table-striped">
        <thead>
        <tr>
            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_id', 'ip_distributors'); ?>><?php _trans('id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_name', 'ip_distributors'); ?>><?php _trans('distributor_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_email', 'ip_distributors'); ?>><?php _trans('email_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_phone', 'ip_distributors'); ?>><?php _trans('phone_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_web', 'ip_distributors'); ?>><?php _trans('web_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_email_sent', 'ip_distributors'); ?>><?php _trans('email_sent'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_city', 'ip_distributors'); ?>><?php _trans('city'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_country', 'ip_distributors'); ?>><?php _trans('country'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_responsible', 'ip_distributors'); ?>><?php _trans('responsible'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_category', 'ip_distributors'); ?>><?php _trans('category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'distributor_sell_services_products', 'ip_distributors'); ?>><?php _trans("sell_services_products"); ?></a></th>
            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR|| $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS){ ?>
            <th><?php _trans('options'); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $distributor) : ?>
            <tr>
                <td><input type="checkbox" value="<?= $distributor->distributor_email ?>" class="sel" data-id="<?=$distributor->distributor_id?>"></td>
                <td><?=$distributor->distributor_id; ?></td>
                <td>
                    <a href="<?= base_url('distributors/view/'.$distributor->distributor_id)?>" >
                        <?= $distributor->distributor_name ?>
                    </a>
                </td>



                <td class="distributor_email"><?php _htmlsc($distributor->distributor_email); ?></td>
                <td><?php _htmlsc($distributor->distributor_phone ? $distributor->distributor_phone : ''); ?></td>
                <td><a href="<?=(strpos($distributor->distributor_web, 'http://') !== false ||  strpos($distributor->distributor_web, 'https://') !== false)? $distributor->distributor_web : 'http://'.$distributor->distributor_web ?>" role="button" target="_blank" > <?= _htmlsc($distributor->distributor_web) ?></a></td>
                <td class="text-center"><?=($distributor->distributor_email_sent == 1)? '<img src="'.base_url().'assets/core/img/check_file.png" style="min-width: 30px;max-width: 30px"">' : '' ?></td>
                <td><?php _htmlsc($distributor->distributor_city); ?></td>
                <td class="text-center"><?php _htmlsc($distributor->distributor_country); ?></td>
                <td><?php _htmlsc($distributor->distributor_responsible); ?></td>
                <td><?php _htmlsc($distributor->distributor_category ? $distributor->distributor_category : ''); ?></td>
                <td><?php _htmlsc($distributor->distributor_sell_services_products); ?>
                </td>

                <?php if(in_array($this->session->userdata('user_type'), array(TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON)) ){ ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('distributors/view/' . $distributor->distributor_id); ?>">
                                        <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('distributors/form/' . $distributor->distributor_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('distributors/delete/' . $distributor->distributor_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_distributor_warning'); ?>');">
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


        var email_address = $(this).parents('tr').find('.distributor_email').text();
        var distributor_id = $(this).data('id');

        if($.inArray(distributor_id,arr_email) == -1){
            arr_email.push(distributor_id);
        }else{
            arr_email.pop(distributor_id);
        }


        if(arr_email.length > 0 ){
            $('.sendMail').removeAttr('disabled')
        }else{
            $('.sendMail').attr('disabled','disabled')
        }




    });


    $(document).on('click', '.sendMail', function () {
        $.ajax({
            url:"   ../../mailer/distributor",
            type:'post',
            data:{arr_email:arr_email},

            success: function(data) {
                $('body').html(data);
            }
        });
    });

</script>
