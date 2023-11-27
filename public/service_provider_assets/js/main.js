$(function(){
    $('.moreOptions').fadeOut();
    
    //Password View 
    $(document).on('click','.password_icon', function(){
        var Inputtype = $(this).parents('.field').find('.input_text').attr('type');
        if(Inputtype == 'password'){
            $(this).parents('.field').find('.input_text').attr({'type':'text'});
            $(this).css({'opacity':'1'});
        }
        else{
            $(this).parents('.field').find('.input_text').attr({'type':'password'});
            $(this).css({'opacity':'.5'});
        }
    });

    //Show more
    $('.showmore').on('click',function(){
        $(this).parents('.list-group-item').fadeOut();
        $(this).parents('.checklistcars').find('.moreOptions').fadeIn();
    });

});