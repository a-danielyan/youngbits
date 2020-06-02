<?php $this->load->helper('country'); ?>

<span class="lead-address-street-line">
    <?php echo($lead->lead_address_1 ? htmlsc($lead->lead_address_1) . '<br>' : ''); ?>
</span>
<span class="lead-adress-town-line">
    <?php echo($lead->lead_city ? htmlsc($lead->lead_city) . ' ' : ''); ?>
    <?php echo($lead->lead_state ? htmlsc($lead->lead_state) . ' ' : ''); ?>
    <?php echo($lead->lead_zip ? htmlsc($lead->lead_zip) : ''); ?>
</span>
<span class="lead-adress-country-line">
    <?php echo($lead->lead_country ? '<br>' . get_country_name(trans('cldr'), $lead->lead_country) : ''); ?>
</span>
