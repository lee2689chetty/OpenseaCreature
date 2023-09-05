var DropDownLists = function () {

    var initPasswordStrength = function() {
        var e = !1
            , s = $("#userInfoNewPassword");
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

    var initCountryDropDown = function () {
        $('#userInfoCountryList').change(function() {
            if(this.value !== "") {
                App.blockUI({
                    target:'#formProfileUpdate',
                    animate:true
                });

                var formData = new FormData();
                formData.append("COUNTRY", this.value);
                var uploadHandler = $.ajax({
                    url: "../profile/getCitiesFromCountry",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false
                });

                uploadHandler.done(function (msg) {
                    App.unblockUI('#formProfileUpdate');
                    var jsonValue = JSON.parse(msg);
                    UpdateNecessaryViews(jsonValue);
                });

                uploadHandler.fail(function (jqXHR, textStatus) {
                    App.unblockUI('#formProfileUpdate');
                    InitNecessaryViews();
                });

            }
            else
            {
                InitNecessaryViews();
            }

        });
    };

    var InitNecessaryViews = function()
    {
        $('#userInfoCityList').empty();
        $('#userInfoCityList').append('<option value="" data-content = "--NONE--">--NONE--</option>');
        $('#userInfoCityList').selectpicker('refresh');
    };

    var UpdateNecessaryViews = function(jsonValue)
    {
            $('#userInfoCityList').empty();
            for(i = 0 ; i < jsonValue.length ; i++)
            {
                $('#userInfoCityList').append('<option value="'+jsonValue[i].ID+'" data-content = "'+jsonValue[i].DESCRIPTION+'">'+jsonValue[i].DESCRIPTION+'</option>');
            }
            $('#userInfoCityList').selectpicker('refresh');
    };
    return {
        //main function to initiate the module
        init: function () {
            initPasswordStrength();
            initCountryDropDown();
        }
    };
}();

var FormValidator = function(){
    var validateFormInit = function(){
        $('#formProfileUpdate').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                profileType: {
                    required: true
                },
                userInfoFirstName: {
                    required: true
                },
                userInfoLastName: {
                    required: true
                },
                // userInfoCurrentPassword:{
                //     required:true
                // },


                userInfoEmail: {
                    required: true,
                    email: true
                },

                userInfoConfirmEmail: {
                    required: true,
                    equalTo: "#userInfoEmail"
                }

                // userInfoNewPassword: {
                //     required:true,
                //     minlength:6
                // },

                // userInfoConfirmNewPassword: {
                //     required:true,
                //     equalTo: "#userInfoNewPassword"
                // }
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

    var validatePassChangeFormInit = function(){
        $('#formPassChange').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                userInfoCurrentPassword:{
                    required:true
                },

                userInfoNewPassword: {
                    required:true,
                    minlength:6
                },

                userInfoConfirmNewPassword: {
                    required:true,
                    equalTo: "#userInfoNewPassword"
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
                // form.submit();
            }
        });
    };

    return{
      init:function(){
          validateFormInit();
          validatePassChangeFormInit();
      }
    };
}();

var CheckFormatter = function(){
    var CheckFormatterHandler = function(){
        var mailingCountryList = $('#mailingCountryList');
        var physicalCountryList = $('#physicalCountryList');

        $('#physicalCheck').on('change', function(){
            if($(this).is(":checked"))
            {


                $('#mailingAddress').attr('value', $('#physicalAddress').val());
                $('#mailingAddress_2').attr('value', $('#physicalAddress_2').val());
                $('#mailingCity').attr('value', $('#physicalCity').val());
                $('#mailingState').attr('value', $('#physicalState').val());
                $('#mailingZip').attr('value', $('#physicalZip').val());

                mailingCountryList.val(physicalCountryList.val());
                mailingCountryList.attr('value', physicalCountryList.value);
                mailingCountryList.selectpicker('refresh');

                $('#mailingPhoneNumber').attr('value', $('#physicalPhone').val());
            }
        });
        $('#physicalAddress').on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                $('#mailingAddress').attr('value', $('#physicalAddress').val());
            }
        });
        $('#physicalAddress_2').on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                $('#mailingAddress_2').attr('value', $('#physicalAddress_2').val());
            }
        });
        $('#physicalCity').on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                $('#mailingCity').attr('value', $('#physicalCity').val());
            }
        });
        $('#physicalState').on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                $('#mailingState').attr('value', $('#physicalState').val());
            }
        });
        $('#physicalZip').on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                $('#mailingZip').attr('value', $('#physicalZip').val());
            }
        });
        physicalCountryList.on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                mailingCountryList.val(physicalCountryList.val());
                mailingCountryList.attr('value', physicalCountryList.value);
                mailingCountryList.selectpicker('refresh');
            }
        });
        $('#physicalPhone').on('change paste keyup', function(){
            if($('#physicalCheck').is(":checked"))
            {
                $('#mailingPhoneNumber').attr('value', $('#physicalPhone').val());
            }
        });
    };
    return{
        init:function(){
            CheckFormatterHandler();
        }
    };
}();

var ChangePass = function(){
    var ChangePassSubmit = function(){
        //submit change pass
        $('#formPassChange').on('submit', function(e){
            e.preventDefault(e);

            var currentPassError  = jQuery('#userInfoCurrentPassword').closest('.form-group').hasClass('has-error');
            var newPassError = jQuery('#userInfoNewPassword').closest('.form-group').hasClass('has-error');
            var confPassError = jQuery('#userInfoConfirmNewPassword').closest('.form-group').hasClass('has-error');
            if(!currentPassError && !newPassError && !confPassError){
                console.log('form submit with ajax');
                var formData = new FormData();
                formData.append("userInfoCurrentPassword", jQuery('#userInfoCurrentPassword').val());
                formData.append("userInfoNewPassword", jQuery('#userInfoNewPassword').val());
                formData.append("userInfoConfirmNewPassword", jQuery('#userInfoConfirmNewPassword').val());

                 var uploadHandler = $.ajax({
                    url: "../profile/updatepass",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false
                });

                uploadHandler.done(function (msg) {
                    App.unblockUI('#formPassChange');
                    cleanAllNotification();
                    var jsonValue = JSON.parse(msg);
                    if(jsonValue.result === 'match'){
                        jQuery('#alertNewPassMatch').show();
                    }
                    else if(jsonValue.result === 'wrong'){
                        jQuery('#alertCurrentPassError').show();
                    }
                    else if(jsonValue.result === 'success'){
                        jQuery('#alertChangePass').show();
                    }
                });

                uploadHandler.fail(function (jqXHR, textStatus) {
                    App.unblockUI('#formPassChange');
                    cleanAllNotification();
                    jQuery('#alertFailedPasswordChange').show();
                });
            }
        });
    };

    var cleanAllNotification = function(){
        jQuery('#alertChangePass').hide();//.show();
        jQuery('#alertNewPassMatch').hide();
        jQuery('#alertCurrentPassError').hide();
    };

    return{
        init:function(){
            ChangePassSubmit();
        }
    };
}();
jQuery(document).ready(function() {
    DropDownLists.init();
    FormValidator.init();
    CheckFormatter.init();
    ChangePass.init();
});