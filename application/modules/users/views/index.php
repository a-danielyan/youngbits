<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('users'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('users/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('users/index'), 'mdl_users'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><?php _trans('name'); ?></th>
                <th><?php _trans('user_type'); ?></th>
                <th><?php _trans('email_address'); ?></th>
                <th><?php _trans('hour_rate'); ?></th>
                <th><?php _trans('multiplier'); ?></th>

                <th><?php _trans('contract_signed'); ?></th>
                <th><?php _trans('expertises'); ?></th>
                <th><?php _trans('groups'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($users as $user) {

                ?>
                <tr>
                    <td><?php _htmlsc($user->user_name); ?></td>
                    <td><?php echo $user_types[$user->user_type]; ?></td>
                    <td><?php echo $user->user_email; ?></td>
                    <td><?php echo $user->default_hour_rate; ?></td>
                    <td><?php echo $user->multiplier; ?></td>




                    <td>
                        <?php



                        if(!empty(unserialize($user->user_document_link)[0])){ ?>
                            <a href="<?= unserialize($user->user_document_link)[0] ?>" target="_blank"><?=unserialize($user->user_document_link)[0] ?></a>
                        <?php } ?>
                    </td>

                    <td style="position: relative">
                        <?php if(!empty($user->user_expertises)){ ?>
                        <span class="open_all_expertises"><?=end($user->user_expertises)?> <b style="font-weight: bold; font-size: 18px">+</b></span>
                        <div class="list_expertises">
                            <ul class="list-group">
                                <?php foreach ($user->user_expertises as $user_expertise){ ?>
                                    <li class="list-group-item"><?=$user_expertise?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                    </td>


                    <td><?php echo $user->group_name; ?></td>

                    <td>
                        <div class="options btn-group btn-group-sm">
                            <?php if ($user->user_type == 2) : ?>
                                <a href="<?php echo site_url('user_clients/user/' . $user->user_id); ?>"
                                   class="btn btn-default">
                                    <i class="fa fa-list fa-margin"></i> <?php _trans('assigned_clients'); ?>
                                </a>
                            <?php endif; ?>
                            <a class="btn btn-default dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('users/form/' . $user->user_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <?php if ($user->user_id <> 1) { ?>
                                    <li>
                                        <a href="<?php echo site_url('users/delete/' . $user->user_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </td>


                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>


<script>


    $('.open_all_expertises').click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('.list_expertises').hide()
        $(this).parent().find('.list_expertises').toggle()
    })

    $('body').on('click', '*:not( .open_all_expertises, .list_expertises )', function () {
        $('.list_expertises ').hide()
    })
</script>