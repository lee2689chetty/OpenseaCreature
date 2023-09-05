var FormValidator = function(){
    var InitCurrencyFormat = function () {
        $('#initialBalance').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
    };
    var validateFormInit = function(){

        $('#contentForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                accountNumber: {
                    required: true
                },
                userName: {
                    required: true
                },
                accountType: {
                    required: true
                },
                feeType: {
                    required: true
                },

                userStatus: {
                    required: true
                },
                initialBalance: {
                    required: true
                },
                radioPayoutOptions:{
                    required:true
                },
                payoutDay:
                {
                    required:true
                }

            },

            messages: { // custom messages for radio buttons and checkboxes

            },

            invalidHandler: function(event, validator) { //display error alert on form submit

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    };

    var ChangeCardViewLayout = function(){
      $('#accountType').on('change', function(){
         if(parseInt(this.value) === 3)
         {
             jQuery('#divCardCVC').show();
             jQuery('#divValidYear').show();
             jQuery('#divValidMonth').show();
             jQuery('#divCardHolder').show();

             jQuery('#cardCVC').rules('add', 'required');
             jQuery('#cardHolder').rules('add', 'required');

         }
         else
         {
             jQuery('#divCardCVC').hide();
             jQuery('#divValidYear').hide();
             jQuery('#divValidMonth').hide();
             jQuery('#divCardHolder').hide();
             jQuery('#cardCVC').rules('remove', 'required');
             jQuery('#cardHolder').rules('remove', 'required');
         }

         switch (parseInt(this.value))
         {
             case 3:
                 //card
                 jQuery('#spAccountNumberPrefix').text('C-');
                 break;
             case 2:
                 //vIBAN
                 jQuery('#spAccountNumberPrefix').text('V-');
                 break;
             case 1:
                 //eWallet
                 jQuery('#spAccountNumberPrefix').text('W-');
                 break;
             case 0:
                 //none
                 jQuery('#spAccountNumberPrefix').text('');
                 break;
         }
      });
    };
    return{
        init:function(){
            InitCurrencyFormat();
            validateFormInit();
            ChangeCardViewLayout();
        }
    };
}();


var initCardViewLayout = function()
{
    jQuery('#divCardCVC').hide();
    jQuery('#divValidYear').hide();
    jQuery('#divValidMonth').hide();
    jQuery('#divCardHolder').hide();
};

jQuery(document).ready(function() {
    FormValidator.init();
    initCardViewLayout();
});