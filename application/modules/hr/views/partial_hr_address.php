<?php $this->load->helper('country'); ?>

<span class="hr-address-street-line">
    <?php echo($hr->hr_address_1 ? htmlsc($hr->hr_address_1) . '<br>' : ''); ?>
</span>
<span class="hr-address-street-line">
    <?php echo($hr->hr_address_2 ? htmlsc($hr->hr_address_2) . '<br>' : ''); ?>
</span>
<span class="hr-adress-town-line">
    <?php echo($hr->hr_city ? htmlsc($hr->hr_city) . ' ' : ''); ?>
    <?php echo($hr->hr_state ? htmlsc($hr->hr_state) . ' ' : ''); ?>
    <?php echo($hr->hr_zip ? htmlsc($hr->hr_zip) : ''); ?>
</span>
<span class="hr-adress-country-line">
    <?php echo($hr->hr_country ? '<br>' . get_country_name(trans('cldr'), $hr->hr_country) : ''); ?>
</span>
