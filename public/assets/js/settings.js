
$(function(){


    $('.headerFontFamily ').on('change', function() {
        var newFont = $(this).val();
        document.documentElement.style.setProperty('--primary-font-family', newFont, 'important');
        });
    
        $('.headerBg ').on('change', function() {
        var newColor = $(this).val();
        document.documentElement.style.setProperty('--primary-color', newColor, 'important');
        });
         
    
        $('.headerFont ').on('change', function() {
        var newFontColor = $(this).val();
        document.documentElement.style.setProperty('--primary-font-color', newFontColor, 'important');
        });
    
    });