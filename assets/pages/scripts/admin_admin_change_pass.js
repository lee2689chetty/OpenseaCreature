var FormValidator = function(){

    var initPasswordStrength = function() {
        var e = !1
            , s = $("#newPassword");
        s.keydown(function() {
            e === !1 && (s.pwstrength({
                raisePower: 1.4,
                minChar: 8,
                verdicts: ["Weak", "Normal", "Medium", "Strong", "Very Strong"],
                scores: [17, 26, 40, 50, 60]
            }),
                s.pwstrength("addRule", "demoRule", function(e, s, a) {
                    return s.match(/[a-z].[0-9]/) && a
                }, 10, !0),
                e = !0)
        })
    };

    var validateUserNameFormInit = function(){
        $('#formPassUpdate').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                oldPassword: {
                    required: true
                },
                newPassword: {
                    required: true
                },
                confirmPassword: {
                    required: true,
                    equalTo: "#newPassword"
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
          initPasswordStrength();
          validateUserNameFormInit();
      }
    };
}();

jQuery(document).ready(function() {
    FormValidator.init();
});