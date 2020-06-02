
<div class="table-responsive">

    <table class="table table-striped">
        <thead>
        <tr>
            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_id', 'ip_suppliers'); ?>><?php _trans('id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_name', 'ip_suppliers'); ?>><?php _trans('supplier_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_email', 'ip_suppliers'); ?>><?php _trans('email_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_phone', 'ip_suppliers'); ?>><?php _trans('phone_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_web', 'ip_suppliers'); ?>><?php _trans('web_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_email_sent', 'ip_suppliers'); ?>><?php _trans('email_sent'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_city', 'ip_suppliers'); ?>><?php _trans('city'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_country', 'ip_suppliers'); ?>><?php _trans('country'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_responsible', 'ip_suppliers'); ?>><?php _trans('responsible'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_category', 'ip_suppliers'); ?>><?php _trans('category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'supplier_sell_services_products', 'ip_suppliers'); ?>><?php _trans("sell_services_products"); ?></a></th>
            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR|| $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS){ ?>
            <th><?php _trans('options'); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $supplier) : ?>
            <tr>
                <td><input type="checkbox" value="<?= $supplier->supplier_email ?>" class="sel" data-id="<?=$supplier->supplier_id?>"></td>
                <td><?=$supplier->supplier_id; ?></td>
                <td>
                    <a href="<?= base_url('suppliers/view/'.$supplier->supplier_id)?>" >
                        <?= $supplier->supplier_name ?>
                    </a>
                </td>



                <td class="supplier_email"><?php _htmlsc($supplier->supplier_email); ?></td>
                <td><?php _htmlsc($supplier->supplier_phone ? $supplier->supplier_phone : ''); ?></td>
                <td><a href="<?=(strpos($supplier->supplier_web, 'http://') !== false ||  strpos($supplier->supplier_web, 'https://') !== false)? $supplier->supplier_web : 'http://'.$supplier->supplier_web ?>" role="button" target="_blank" > <?= _htmlsc($supplier->supplier_web) ?></a></td>
                <td class="text-center"><?=($supplier->supplier_email_sent == 1)? '<img src="'.base_url().'assets/core/img/check_file.png" style="min-width: 30px;max-width: 30px"">' : '' ?></td>
                <td><?php _htmlsc($supplier->supplier_city); ?></td>
                <td class="text-center"><?php _htmlsc($supplier->supplier_country); ?></td>
                <td><?php _htmlsc($supplier->supplier_responsible); ?></td>
                <td><?php _htmlsc($supplier->supplier_category ? $supplier->supplier_category : ''); ?></td>
                <td><?php _htmlsc($supplier->supplier_sell_services_products); ?>
                </td>

                <?php if(in_array($this->session->userdata('user_type'), array(TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON)) ){ ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('suppliers/view/' . $supplier->supplier_id); ?>">
                                        <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('suppliers/form/' . $supplier->supplier_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('suppliers/delete/' . $supplier->supplier_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_supplier_warning'); ?>');">
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


        var email_address = $(this).parents('tr').find('.supplier_email').text();
        var supplier_id = $(this).data('id');

        if($.inArray(supplier_id,arr_email) == -1){
            arr_email.push(supplier_id);
        }else{
            arr_email.pop(supplier_id);
        }


        if(arr_email.length > 0 ){
            $('.sendMail').removeAttr('disabled')
        }else{
            $('.sendMail').attr('disabled','disabled')
        }




    });


    $(document).on('click', '.sendMail', function () {
        $.ajax({
            url:"   ../../mailer/supplier",
            type:'post',
            data:{arr_email:arr_email},

            success: function(data) {
                $('body').html(data);
            }
        });
    });

</script>
