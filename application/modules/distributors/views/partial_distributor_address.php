<?php $this->load->helper('country'); ?>

<span class="distributor-address-street-line">
    <?php echo($distributor->distributor_address_1 ? htmlsc($distributor->distributor_address_1) . '<br>' : ''); ?>
</span>
<span class="distributor-adress-town-line">
    <?php echo($distributor->distributor_city ? htmlsc($distributor->distributor_city) . ' ' : ''); ?>
    <?php echo($distributor->distributor_state ? htmlsc($distributor->distributor_state) . ' ' : ''); ?>
    <?php echo($distributor->distributor_zip ? htmlsc($distributor->distributor_zip) : ''); ?>
</span>
<span class="distributor-adress-country-line">
    <?php echo($distributor->distributor_country ? '<br>' . get_country_name(trans('cldr'), $distributor->distributor_country) : ''); ?>
</span>
