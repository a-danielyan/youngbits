<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('notes'); ?></h1>

    <?php if(+$this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR  || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES){ ?>
    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('notes/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>
    <?php } ?>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('notes/index'), 'mdl_projects'); ?>
    </div>


</div>

    <div id="content" class="table-content">
        <?php $this->layout->load_view('layout/alerts'); ?>



        <?php $this->layout->load_view('notes/partial_note_table_modal'); ?>

    </div>


