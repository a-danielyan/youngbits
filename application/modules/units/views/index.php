<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('units'); ?></h1>


    <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS){ ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('units/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('units/index'), 'mdl_units'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'unit_name', 'ip_units'); ?>><?php _trans('unit_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'unit_name_plrl', 'ip_units'); ?>><?php _trans('unit_name_plrl'); ?></a></th>
                <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS ){ ?>
                <th><?php _trans('options'); ?></th>
                <?php } ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($units as $unit) { ?>
                <tr>
                    <td><?php _htmlsc($unit->unit_name); ?></td>
                    <td><?php _htmlsc($unit->unit_name_plrl); ?></td>
                    <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS){ ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('units/form/' . $unit->unit_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('units/delete/' . $unit->unit_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>

</div>
