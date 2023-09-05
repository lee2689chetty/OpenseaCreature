var DropDownLists = function () {

    var initCountryDropDown = function () {
        $('#countryList').change(function() {
            if(this.value !== "") {
                App.blockUI({
                    target:'#contentForm',
                    animate:true
                });

                var formData = new FormData();
                formData.append("COUNTRY", this.value);
                var uploadHandler = $.ajax({
                    url: "../../admin/profile/getCitiesFromCountry",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false
                });

                uploadHandler.done(function (msg) {
                    App.unblockUI('#contentForm');
                    var jsonValue = JSON.parse(msg);
                    UpdateNecessaryViews(jsonValue);
                });

                uploadHandler.fail(function (jqXHR, textStatus) {
                    App.unblockUI('#contentForm');
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
        $('#cityList').empty();
        $('#cityList').append('<option value="" data-content = "--NONE--">--NONE--</option>');
        $('#cityList').selectpicker('refresh');
    };

    var UpdateNecessaryViews = function(jsonValue)
    {
            $('#cityList').empty();
            for(i = 0 ; i < jsonValue.length ; i++)
            {
                $('#cityList').append('<option value="'+jsonValue[i].ID+'" data-content = "'+jsonValue[i].DESCRIPTION+'">'+jsonValue[i].DESCRIPTION+'</option>');
            }
            $('#cityList').selectpicker('refresh');
    };

    var initProfileKindDropDown = function(){
        $('#profileType').on('change', function(){
            if(parseInt(this.value) === 2) {
                // personal
                jQuery('#divCompanyName').show();
                jQuery('#companyName').rules('add', 'required');
            }
            else {
                // company
                jQuery('#divCompanyName').hide();
                jQuery('#companyName').rules('remove', 'required');
            }
        });
    };

    var initPasswordStrength = function() {
        var e = !1
            , s = $("#passwordInput");
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
    return {
        //main function to initiate the module
        init: function () {
            initCountryDropDown();
            initProfileKindDropDown();
            initPasswordStrength();
        }
    };
}();


var CheckFormatter = function(){
    var CheckFormatterHandler = function(){
        $('#chkSamePhysical').on('change', function(){
            if($(this).is(":checked"))
            {
                $('#mailingAddress').attr('value', $('#physicalAddress').val());
                $('#mailing2ndAddress').attr('value', $('#physical2ndAddress').val());
                $('#mailingCity').attr('value', $('#physicalCity').val());
                $('#mailingProvince').attr('value', $('#physicalState').val());
                $('#mailingZipPostal').attr('value', $('#physicalZipPostal').val());

                $('#mailingCountry').val($('#physicalCountry').val()).trigger('change');
                // $('#mailingCountry').attr('value', $('#physicalCountry').value);
                // $('#mailingCountry').select2('refresh');

                $('#mailingPhone').attr('value', $('#physicalPhone').val());
            }
        });
        $('#physicalAddress').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailingAddress').attr('value', $('#physicalAddress').val());
            }
        });
        $('#physical2ndAddress').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailing2ndAddress').attr('value', $('#physical2ndAddress').val());
            }
        });
        $('#physicalCity').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailingCity').attr('value', $('#physicalCity').val());
            }
        });
        $('#physicalState').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailingProvince').attr('value', $('#physicalState').val());
            }
        });
        $('#physicalZipPostal').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailingZipPostal').attr('value', $('#physicalZipPostal').val());
            }
        });
        $('#physicalCountry').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailingCountry').val($('#physicalCountry').val()).trigger('change');
                // $('#mailingCountry').attr('value', $('#physicalCountry').value);
                // $('#mailingCountry').selectpicker('refresh');
            }
        });
        $('#physicalPhone').on('change paste keyup', function(){
            if($('#chkSamePhysical').is(":checked"))
            {
                $('#mailingPhone').attr('value', $('#physicalPhone').val());
            }
        });
    };
    return{
        init:function(){
            CheckFormatterHandler();
        }
    };
}();

var FormValidator = function(){
    var validateFormInit = function(){
        $('#contentForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                profileType: {
                    required: true
                },
                firstName: {
                    required: true
                },
                lastName: {
                    required: true
                },
                userName: {
                    required: true
                },

                emailAddress: {
                    required: true,
                    email: true
                },

                confirmEmail: {
                    required: true,
                    equalTo: "#emailAddress"
                },

                passwordInput: {
                    required:true,
                    minlength:6
                },

                confirmPassword: {
                    required:true,
                    equalTo: "#passwordInput"
                },

                statusList: {
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
    return{
      init:function(){
          validateFormInit();
      }
    };
}();

jQuery(document).ready(function() {
    DropDownLists.init();
    FormValidator.init();
    CheckFormatter.init();
    jQuery('#divCompanyName').hide();
    jQuery('#companyName').rules('remove', 'required');
});