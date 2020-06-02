<?php
//ok
?>
<script>
    $(function () {
        $('#modal_delete_offer_confirm').click(function () {
            offer_id = $(this).data('offer-id');
            window.location = '<?php echo site_url('offers/delete'); ?>/' + offer_id;
        });
    });
</script>

<div id="delete-offer" class="modal modal-lg" role="dialog" aria-labelledby="delete-offer" aria-hidden="true">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('delete_offer'); ?></h4>
        </div>
        <div class="modal-body">

            <div class="alert alert-danger"><?php _trans('delete_offer_warning'); ?></div>

        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <a href="#" id="modal_delete_offer_confirm" class="btn btn-danger"
                   data-offer-id="<?php echo $offer->offer_id; ?>">
                    <i class="fa fa-trash-o"></i>
                    <?php echo trans('confirm_deletion') ?>
                </a>
                <a href="#" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
                </a>
            </div>
        </div>
    </div>

</div>
