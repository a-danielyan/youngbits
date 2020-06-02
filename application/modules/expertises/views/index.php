<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('expertise_list'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('expertises/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('expertises/index'), 'mdl_expertises'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <table class="table table-striped">

        <thead>
        <tr>
            <th><?php _trans('id'); ?></th>
            <th><?php _trans('expertise_name'); ?></th>
            <th><?php _trans('created_user'); ?></th>
            <th><?php _trans('created_date'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($expertises as $expertise) { ?>
            <tr>
                <td><?php _htmlsc($expertise->expertise_id); ?></td>
                <td><?php _htmlsc($expertise->expertise_name); ?></td>
                <td><?=$expertise->user_name?></td>
                <td><?= $expertise->expertise_created_date ?></td>

                <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  ):?>
                <td>
                    <div class="options btn-group btn-group-sm">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>


                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('expertises/form/' . $expertise->expertise_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('expertises/delete/' . $expertise->expertise_id); ?>"
                                   onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                </a>
                            </li>
                        </ul>





                    </div>
                </td>
                <?php else: ?>
                    <?php if($this->session->userdata('user_id')  ==  $expertise->expertise_created_user_id ):?>
                      <td>
                          <a href="<?php echo site_url('expertises/form/' . $expertise->expertise_id); ?>">
                              <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                          </a>
                      </td>
                    <?php else: ?>
                    <td></td>
                    <?php endif;?>
                <?php endif;?>

            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>
