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
    

});