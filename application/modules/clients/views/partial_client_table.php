<div class="table-responsive">


    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" class="checkAllSel"> </th>
                    <th><a <?= orderableTH($this->input->get(), 'client_id', 'ip_clients'); ?>><?php _trans('id'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client_name'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_email', 'ip_clients'); ?>><?php _trans('email_address'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_phone', 'ip_clients'); ?>><?php _trans('phone_number'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_web_address', 'ip_clients'); ?>><?php _trans('web_address'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_city', 'ip_clients'); ?>><?php _trans('city'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_country', 'ip_clients'); ?>><?php _trans('country'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_responsible', 'ip_clients'); ?>><?php _trans('responsibles'); ?></a></th>
                    <th class=""><a <?= orderableTH($this->input->get(), 'client_invoice_balance', 'INDEPENDENT '); ?>><?php _trans('balance'); ?></a></th>
                    <th><?php _trans("group"); ?></th>
                    <th><?php _trans('options'); ?></th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($records as $client) : ?>
            <tr>
                <td><input type="checkbox" value="<?= $client->client_email ?>" class="sel"></td>
                <td><?php _htmlsc($client->client_id); ?></td>
                <td>
                    <a href="<?= base_url('index.php/clients/view/'.$client->client_id)?>" >
                        <?= $client->client_name ?>
                    </a>
                </td>

                <td><?php _htmlsc($client->client_email); ?></td>
                <td><?php _htmlsc($client->client_phone ? $client->client_phone : ''); ?></td>
                <td><a href="<?=(strpos($client->client_web, 'http://') !== false ||  strpos($client->client_web, 'https://') !== false)?  $client->client_web: 'http://'.$client->client_web ?>"  role="button" target="_blank" > <?= _htmlsc($client->client_web) ?></a>
                <td><?php _htmlsc($client->client_city); ?></td>
                <td class="text-center"><?php _htmlsc($client->client_country); ?></td>
                <td><?php _htmlsc($client->client_responsible); ?></td>
                <td class=""><?php echo format_currency($client->client_invoice_balance); ?></td>

                <td>
                    <?php
                    $groups = array();
                    foreach ($user_groups as $user_group) {
                        foreach ($client->client_groups as $client_group) {
                            if ($client_group["group_id"] == $user_group->group_id) {
                                array_push($groups, $user_group->group_name);
                            }
                        }
                    }
                    if (count($groups) > 0)
                    {
                        echo ucfirst(implode(", ", $groups));
                    }
                    ?>

                </td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('clients/view/' . $client->client_id); ?>">
                                    <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                </a>
                            </li>


                            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS){ ?>
                                <!-- 12.09.2019 -->
                                <?php //if($this->session->userdata('user_type') == TYPE_MANAGERS && count($client->client_groups) <= 1):?>
                                    <!-- <li>
                                        <a href="<?php // echo site_url('clients/form/' . $client->client_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php // _trans('edit'); ?>
                                        </a>
                                    </li> -->
                                <?php //endif;?>
                                <?php if($this->session->userdata('user_type') == TYPE_ADMIN):?>
                                    <li>
                                        <a href="<?php echo site_url('clients/form/' . $client->client_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                <?php endif;?>

                                <li>
                                    <a href="#" class="client-create-quote"
                                       data-client-id="<?php echo $client->client_id; ?>">
                                        <i class="fa fa-file fa-margin"></i> <?php _trans('create_quote'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="client-create-invoice"
                                       data-client-id="<?php echo $client->client_id; ?>">
                                        <i class="fa fa-file-text fa-margin"></i> <?php _trans('create_invoice'); ?>
                                    </a>
                                </li>
                            <?php  } ?>

                                <?php  if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                                <li>
                                    <a href="<?php echo site_url('clients/delete/' . $client->client_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_client_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                                <?php }?>

                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
