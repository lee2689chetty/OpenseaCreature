var FormValidator = function(){

    var validateUserNameFormInit = function(){
        $('#formProfileUpdate').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                levelType: {
                    required: true
                },
                fullName: {
                    required: true
                },
                accountName: {
                    required: true
                },
                userInfoEmail: {
                    required: true
                },
                userStatus: {
                    required: true
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

    return {
      init:function(){
          validateUserNameFormInit();
      }
    };
}();

jQuery(document).ready(function() {
    FormValidator.init();
});