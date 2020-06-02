<?php $this->load->helper('country'); ?>

<span class="target-address-street-line">
    <?php echo($target->target_address_1 ? htmlsc($target->target_address_1) . '<br>' : ''); ?>
</span>
<span class="target-adress-town-line">
    <?php echo($target->target_city ? htmlsc($target->target_city) . ' ' : ''); ?>
    <?php echo($target->target_state ? htmlsc($target->target_state) . ' ' : ''); ?>
    <?php echo($target->target_zip ? htmlsc($target->target_zip) : ''); ?>
</span>
<span class="target-adress-country-line">
    <?php echo($target->target_country ? '<br>' . get_country_name(trans('cldr'), $target->target_country) : ''); ?>
</span>
