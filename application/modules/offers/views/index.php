<?php
//ok
?>
<div id="headerbar">

    <h1 class="headerbar-title"><?php _trans('offers'); ?></h1>

    <div class="headerbar-item pull-right">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
        </button>
        <a class="create-offer btn btn-sm btn-primary" href="#">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('offers/status/' . $this->uri->segment(3)), 'mdl_offers'); ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('offers/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
            <a href="<?php echo site_url('offers/status/draft'); ?>"
               class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('draft'); ?>
            </a>
            <a href="<?php echo site_url('offers/status/sent'); ?>"
               class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('sent'); ?>
            </a>
            <a href="<?php echo site_url('offers/status/viewed'); ?>"
               class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('viewed'); ?>
            </a>
            <a href="<?php echo site_url('offers/status/accepted'); ?>"
               class="btn  <?php echo $status == 'accepted' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('accepted'); ?>
            </a>
            <a href="<?php echo site_url('offers/status/declined'); ?>"
               class="btn  <?php echo $status == 'declined' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('declined'); ?>
            </a>
        </div>
    </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('offers/status/' . $this->uri->segment(3)), 'mdl_offers'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('offers/status/all'); ?>"
                   class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('all'); ?>
                </a>
                <a href="<?php echo site_url('offers/status/draft'); ?>"
                   class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('draft'); ?>
                </a>
                <a href="<?php echo site_url('offers/status/sent'); ?>"
                   class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('sent'); ?>
                </a>
                <a href="<?php echo site_url('offers/status/viewed'); ?>"
                   class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('viewed'); ?>
                </a>
                <a href="<?php echo site_url('offers/status/accepted'); ?>"
                   class="btn  <?php echo $status == 'accepted' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('accepted'); ?>
                </a>
                <a href="<?php echo site_url('offers/status/declined'); ?>"
                   class="btn  <?php echo $status == 'declined' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('declined'); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<div id="content" class="table-content">
    <div id="filter_results">
        <?php $this->layout->load_view('offers/partial_offer_table', array('offers' => $offers)); ?>
    </div>
</div>
