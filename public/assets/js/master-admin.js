$(function(){


    if ($(this).width() < 769) {
        $('.search_icons').addClass('trigger_btn');
        $('.sidebar').addClass('notshow');

    }
    else {
        $('.search_icons').removeClass('trigger_btn');
        $('.sidebar').removeClass('notshow');
    }

    $(window).on('resize', function(){
        if ($(this).width() < 769) {
            $('.search_icons').addClass('trigger_btn');
            $('.sidebar').addClass('notshow');
        }
        else {
            $('.search_icons').removeClass('trigger_btn');
            $('.sidebar').removeClass('notshow');
        }
    });


    $(document).on('click','.password_icon', function(){
        var Inputtype = $(this).parents('.field').find('.loginField').attr('type');
        if(Inputtype == 'password'){
            $(this).parents('.field').find('.loginField').attr({'type':'text'});
            $(this).css({'opacity':'1'});
        }
        else{
            $(this).parents('.field').find('.loginField').attr({'type':'password'});
            $(this).css({'opacity':'.5'});
        }
    });
    

    //Collapse
    $(document).on('click','.trigger_btn',function(){
        
        $(this).stop().toggleClass('activeShow');
        if($(this).hasClass('activeShow')){
            $('.target').slideUp();
            $(this).parents('.trigger_parent').find('.target').slideDown();
        }
        else{
            $(this).parents('.trigger_parent').find('.target').slideUp();
        }
       

    });


    $('.sidebarToggler').on('click',function(){
        $('.sidebar').toggleClass('notshow');
    });


    //Validation
    $(document).on('click','.company_profile',function(){
        $('.action_tabs_btn').removeClass('active');
       $(this).addClass('active');
       $('#Editcompany').removeClass('hiddenblock');
       $('#EditAdmin').addClass('hiddenblock');
       
      
    });
    $(document).on('click','.admin_profile',function(){
        $('.action_tabs_btn').removeClass('active');
       $(this).addClass('active');
      
        $('#Editcompany').addClass('hiddenblock');
        $('#EditAdmin').removeClass('hiddenblock');
    });

    $('.edit_btn').on('click',function(){
        $('.editoptions').slideDown();
    });

    $('.parent_checkbox').on('change',function(){
        if($(this).is(':Checked')){
            $('.child_checkbox').prop('checked',true);
        }
        else{
            $('.child_checkbox').prop('checked',false);
        }
    })


    

    $('#phone, #phone_edit,#phone_edit_number').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.]/g,'');
    });
    
    $("#phone, #phone_edit").on("blur", function(e){

        var conuntrycode = $('#country_code').val();
        var mobNum = $(this).val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(mobNum)) {
            return true;
            // if(mobNum.length==10){
            //     return true;  
            // } else {
            //     $(this).val('')
            //     return false;
            // }
        }
        else if(mobNum.startsWith("+")){
            var temp = mobNum.substring(conuntrycode.length + 1 , mobNum.length);
            mobile = temp;
            $(this).val(mobile)
            return true; 
        } else {
            $(this).val('')
            return false;
        }

    });


    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "ch";
                success(countryCode);
            });
        },
        initialCountry:"ch",
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
        autoFormat: false,
        nationalMode: true,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "";
        },
    });

    iti.promise.then(function() {
        input.addEventListener("countrychange", function() {
            var selectedCountryData = iti.getSelectedCountryData();
            $('#country_code').val(selectedCountryData.dialCode);
        });
    });

    var inputEdit = document.querySelector("#phone_edit");
    var itiEdit = window.intlTelInput(inputEdit, {
        initialCountry: "auto",
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        initialCountry:"us",
        nationalMode: true,
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
        autoFormat: false,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "";
        },
    });
    itiEdit.promise.then(function() {
        inputEdit.addEventListener("countrychange", function() {
            var selectedCountryData = itiEdit.getSelectedCountryData();
            $('#country_code_edit').val(selectedCountryData.dialCode);
        });
    });

        $(document).ready(function(){
            var code = $('#country_code').val();  
            var phone = $('#phone').val();
            setTimeout(() => {
                iti.setNumber("+"+code + phone);
                $("#phone").val(phone);

            }, 500);
            
        });
    
        
});