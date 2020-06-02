
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('financial_reports'); ?></h1>

   <!--  <div class="headerbar-item pull-right">
        <?php // echo pager(site_url('invoices/reports/'.$status.$this->uri->segment(4)), 'mdl_invoices'); ?>
    </div> -->

	<div class="headerbar-item pull-right">
        <?php //echo $links; ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('invoices/reports/invoices'); ?>"
               class="btn <?php echo $status == 'invoices' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('invoices'); ?>
            </a>
            <a href="<?php echo site_url('invoices/reports/euro_expenses'); ?>"
               class="btn <?php echo $status == 'euro_expenses' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('euro_expenses'); ?>
            </a>
            <a href="<?php echo site_url('invoices/reports/dollar_expenses'); ?>"
               class="btn <?php echo $status == 'dollar_expenses' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('dollar_expenses'); ?>
            </a>
        </div>
    </div>


</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>



    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
            

                <th><?php _trans('id'); ?></th>
                <th><?php _trans('quarter'); ?></th>
                <th><?php _trans('category'); ?></th>
                <th><?php _trans('total_amount')._trans('(incl.')._trans('taxes)'); ?></th>
                <th><?php _trans('total_vat_taxes'); ?></th>
                <th><?php _trans('total_amount')._trans('(excl.')._trans('taxes)'); ; ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($financial_reports as $key => $category) { 
            	foreach ($category as $quarter => $category_item) {
            ?>
                <tr>
                    <td><?php _htmlsc($start); ?></td>
<!--                    --><?php //var_dump(str_replace(' ','_',$quarter));?>
                    <td><?= anchor('invoices/quarter/'.str_replace(' ','_',$quarter),$quarter); ?></td>
                    <td><?php _trans($category_item['category']); ?></td>
                    <td><?php _htmlsc($category_item['total_amount_with_taxes']); ?></td>
                    <td><?php _htmlsc($category_item['total_taxes']); ?></td>
                    <td><?php _htmlsc($category_item['total_amount_without_taxes']); ?></td>
                </tr>
            <?php 
            	if ($start<$length) {
            		# code...
            	}
            	$start += 1;
            	}
        	} ?>
            </tbody>

        </table>
    </div>

</div>
