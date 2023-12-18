$(function(){
    "use strict";
    $('.scroll-to-top-button').hide();
    //onscroll window
    $(document).ready(function(){
        if($(window).scrollTop() >= 5){
            $('.primary_navbar').addClass('addbg');
            $('.scroll-to-top-button').fadeIn();
        }
        else{
            $('.scroll-to-top-button').fadeOut();
            $('.primary_navbar').removeClass('addbg');
        }
    });
    $(window).on('scroll',function(){
        if($(window).scrollTop() >= 5){
            $('.primary_navbar').addClass('addbg');
            $('.scroll-to-top-button').fadeIn();
        }
        else{
            $('.scroll-to-top-button').fadeOut();
            $('.primary_navbar').removeClass('addbg');
        }
    });


    //Menu Collapse
    $('.clickcloppase').on('click',function(){
        if($(window).width() <= 991){
            $(this).parents('.header_container').find('.navbar-toggler').addClass('collapsed');
            $(this).parents('.header_container').find('.bartoggler').addClass('fa-bars').removeClass('fa-times');
            $(this).parents('#primaryNav').removeClass('show');
        }
    });

    //Button Toggler
    $('.navbar-toggler').on('click',function(){
        if($(this).hasClass('collapsed')){
            $(this).find('.fas').addClass('fa-bars').removeClass('fa-times');
        }
        else{
            $(this).find('.fas').removeClass('fa-bars').addClass('fa-times');
        }
    });

    //Contact form validation
    $('.field_necessary').on('blur',function(){
        if($(this).val() != ''){
            $(this).css({'border-color':'#eaeaea'});
            $(this).parents('.form-group').find('.error_msg').css({'display':'none'});
        }
        else {
            
            $(this).css({'border-color':'#f00'});
            $(this).parents('.form-group').find('.error_msg').css({'display':'block'});
        }
    });

    //formvalidaion
    $('.send_form_contact').on('submit',function(event){
        event.preventDefault();
        $('.input_box').val('');
       
        $('.send_msg_done').fadeIn();
        setTimeout(function() {
            $('.send_msg_done').fadeOut();
        }, 9000);
    });


    //ODO metter section
    $('.counter').countUp({
        'time': 2000,
        'delay': 10
    });

    //FAQs
    $('.accordion-button').on('click',function(){
        $('.accordion-button').removeClass('dullLight');
        $('.accordion-button').find('.questionMarks').addClass('fa-question').removeClass('fa-exclamation');
        if(!$(this).hasClass('collapsed')){
            $(this).addClass('dullLight');
            $(this).find('.questionMarks').addClass('fa-exclamation').removeClass('fa-question');
        }
        else{
            $(this).removeClass('dullLight');
            $(this).find('.questionMarks').addClass('fa-question').removeClass('fa-exclamation');
        }
    });

    //eng and german
    $('.german').on('click',function(){
        $('.eng').removeClass('default');
        $(this).addClass('default');
    });
    $('.eng').on('click',function(){
        $('.german').removeClass('default');
        $(this).addClass('default');
    });

    $('.lang_selecter').on('click',function(){
       $(this).toggleClass('show');
    });

    

});