/* =============================================================================
   Spudu
   Custom JS

   All changes made in this file will override the default styles.
   ========================================================================== */
 
var base_url = document.location.origin;
var amount_value = 0

$(".sel").on('change',function () {
    if($(".sel:checked").length > 0){
        $('.downloadPDF').attr('disabled',false);
    }else{
        $('.downloadPDF').attr('disabled',true);
    }
})

$(".sel").on('change',function () {
    var data_amount = $(this).data('amount');

    if ($(this).prop('checked')) {
        amount_value += eval(data_amount)
    }else {
        amount_value -= eval(data_amount)
    }

    if (parseFloat(Math.round(amount_value * 100) / 100) > 0) {
        $.ajax({
            url:"http://localhost/invoiceplane/index.php/invoices/total_price",
            type:'post',
            data:{email:'sad'},
            dataType: "json",
            success: function(data) {
                console.log(data)
            }
        });

        $('.sum_content .amount_val').text('$' + parseFloat(Math.round(amount_value * 100) / 100).toFixed(2));
        if ($('.sum_content .selected_amt').hasClass('hide_amt')) { $('.sum_content .selected_amt').removeClass('hide_amt')}
        $('.sum_content .selected_amt').addClass('show_amt')
    }else {
        $('.sum_content .amount_val').text('$' + parseFloat(Math.round(amount_value * 100) / 100).toFixed(2));
        if ($('.sum_content .selected_amt').hasClass('show_amt')) { $('.sum_content .selected_amt').removeClass('show_amt')}
        $('.sum_content .selected_amt').addClass('hide_amt')
    }

    if($(".sel:checked").length > 0){
        $('.sendMultiMail').attr('disabled',false);
    }else{
        $('.sendMultiMail').attr('disabled',true);
    }
})

$('.checkAllSel').on('change',function () {

    if($(this).is(':checked')){
        amount_value = 0;
        $(".sel").prop('checked',true).change();
    }else{
        $(".sel").prop('checked',false).change();
    }
})

$('.downloadPDF').on('click', function () {
    var url = $(this).data('url');
    var chkArray = '';

    $(".sel:checked").each(function() {
        chkArray += $(this).val()+'_';
    });

    if(chkArray.length > 0){
        chkArray = chkArray.substring(0, chkArray.length - 1);
        window.open(url+chkArray, '_blank');
    }
})

$('.sendMultiMail').on('click', function () {
    var url = $(this).data('url');
    var chkArray = '';

    $(".sel:checked").each(function() {
        if($(this).val() !== ''){
            chkArray += $(this).val()+',';
        }
    });

    if(chkArray.length > 0){
        location.href = "mailto:"+chkArray;

        //window.open(url+chkArray, '_blank');

    }

})