jQuery(function () {
    // Toggle Button
    $(".btn_toggle_nav").on("click", function () {
        $(".sideBar_menu").stop().slideToggle();
    });

    //ActiveClass Selected List
    $(".input_radio_selected").on("click", function () {
        $(document).find(".list-group-item").removeClass("selected");
        // if ($(this).is(":checked")) {
            $(this).parents(".list-group-item").addClass("selected");
        // } else {
        //     $(this).parents(".list-group-item").removeClass("selected");
        // }
    });


    $(window).resize(function(){
        console.log('hello');
    });

});
