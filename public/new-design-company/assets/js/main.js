$(function(){


    //Password View
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

    /**
     * Replace all SVG images with inline SVG
     */
    jQuery('img.svg').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });

    //Slide animation

    $(document).on('click','.menu_toggle_btn',function(){

        $(this).stop().toggleClass('show');
        $('.cs_menus').stop().slideToggle();

    });




    //Stop Reconfirmation
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }


    //hideshownav
    $('.tabs_links_btns[href^="#"]').on('click', function(event) {
        $('.tabs_links_btns').removeClass('active');
        $(this).addClass('active');
        $('.resume').hide();
        var target = $(this).attr('href');

        $(target).show();
        console.log(target);

    });


    // Side Menu Edit
    $(document).on('click','.close_modal_action',function(){
        $(this).stop().toggleClass('show');
        if($(this).hasClass('show')){
            $('#add_new_bookings').css({'margin-right':'00px','transition':'all 400ms linear'});
        }
        else{
            $('#add_new_bookings').css({'margin-right':'-660px','transition':'all 400ms linear'});
        }
    });
    $(document).on('click','.add_new_booking_btn',function(){
            $('.close_modal_action').addClass('show');
            $('#add_new_bookings').css({'margin-right':'0px','transition':'all 400ms linear'});

    });
    $(document).on('click','.addNewBtn_cs ',function(){
            $('.close_modal_action').addClass('show');
            $('#add_new_bookings').css({'margin-right':'0px','transition':'all 400ms linear'});

    });

    // Side Menu View
    $(document).on('click','.close_modal_action_view',function(){
        $(this).stop().toggleClass('show');
        if($(this).hasClass('show')){
            $('#view_booking').css({'margin-right':'00px','transition':'all 400ms linear'});
        }
        else{
            $('#view_booking').css({'margin-right':'-660px','transition':'all 400ms linear'});
        }
    });
//slider Table
$(window).on('load',function(){
    if($(window).width() < 430 ){
        $('.form_add_managers').hide();

        $('.slider_table').on('click',function(){
            $('.edit_box').hide();
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                $(this).parents('.dashbaord_bodycontent').find('.form_add_managers').stop().slideDown();
            }
            else{
                $(this).parents('.dashbaord_bodycontent').find('.form_add_managers').stop().slideUp();
            }

        });
    }
});




    // Disable right-click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    function ctrlShiftKey(e, keyCode) {
        // return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }

    document.onkeydown = (e) => {
    // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
    // if (
    //     event.keyCode === 123 ||
    //     ctrlShiftKey(e, 'I') ||
    //     ctrlShiftKey(e, 'J') ||
    //     ctrlShiftKey(e, 'C') ||
    //     (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
    // )
    //     return false;
    };

});
