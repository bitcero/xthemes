/*!
xThemes for XOOPS
Author:     Eduardo Cortés (www.eduardocortes.mx)
License:    GPL 2 or newer
Url:        http://www.redmexico.com.mx
*/

// @prepros-prepend 'json_encode.js';

var processMenu = {
    /**
    * Start the transformation of nested list to menus
    * @param container <ol> Jquery object
    */
    transform : function(container, $mn){
        
        var menu = new Array();
        var id = $(container).attr("id").replace("menu-");
        
        $(container+" ol > li").each(function(i){
            $(this).attr("data", $mn+'-'+i);
        });
        
        $(container+" > ol > li").each(function(i){
            id = $(this).attr("data");
            menu[i] = {
                'id'            : id,
                'url'           : $("li[data='"+id+"'] input[name='url']").val(),
                'title'         : $("li[data='"+id+"'] input[name='title']").val(),
                'rel'           : $("li[data='"+id+"'] input[name='rel']").val(),
                'target'        : $("li[data='"+id+"'] input[name='target']").val(),
                'extra'         : $("li[data='"+id+"'] input[name='extra']").val(),
                'description'   : $("li[data='"+id+"'] textarea").val(),
                'submenu'       : processMenu.submenu('li[data="'+id+'"]')
            }

        })
        
        return menu;
    },
    
    /**
    * Extract all submenus for a single <li> object
    * @param container <li> jQuery object
    */
    submenu: function(container){
        
        var menu = new Array();
        
        $(container+" > ol > li").each(function(i){
            id = $(this).attr("data");
            menu[i] = {
                'url'         : $("li[data='"+id+"'] input[name='url']").val(),
                'title'         : $("li[data='"+id+"'] input[name='title']").val(),
                'rel'           : $("li[data='"+id+"'] input[name='rel']").val(),
                'target'        : $("li[data='"+id+"'] input[name='target']").val(),
                'extra'         : $("li[data='"+id+"'] input[name='extra']").val(),
                'description'   : $("li[data='"+id+"'] textarea").val(),
                'submenu'       : processMenu.submenu('li[data="'+id+'"]')
            }
        });
        
        return menu;
    },
    
    /**
    * Convert the menu array to a valid params in order to send by post
    */
    parametrize: function(menu){
        
        return menu[0].toSource();
        
    }
}

$(document).ready(function(){
    var $themes;

    $("a.theme-adetails").click(function(){

        var p = $(this).parents('.theme-options');
        var container = $(p).find(".theme-details");
        $(p).parents('.available-theme').toggleClass('x2');
        $(container).slideToggle(300, function(){
            $themes.masonry('layout');
        });
        
        return false;
    });
    
    $("a.theme_apreview").click(function(){
        
        var id = $(this).attr("id").replace("preview-", '');
        var url = 'themes.php?action=preview&amp;dir='+id;
        var name = $("#available-"+id+" > .available_details > h6").html();
        var iframe = '<iframe src="'+url+'"></iframe>';
        $("#xt-previewer > .title > span:first-child").html(name);
        $("#xt-previewer > .website").html(iframe);
        $("body").css("overflow", 'hidden');
        $("#xt-previewer-blocker").fadeIn('fast', function(){
            $("#xt-previewer").fadeIn('fast');
        });
        
        return false;
        
    });
    
    $("#xt-previewer > .title > .close, #xt-previewer-blocker").click(function(){
        
        $("#xt-previewer").fadeOut('fast', function(){
            
            $("#xt-previewer-blocker").fadeOut('fast');
            $("#xt-previewer > .title > span:first-child").html('');
            $("#xt-previewer > .website").html('');
            $("body").css("overflow",'auto');
            
        });
        
    });
    
    $(".add-menu").click(function(){
        
        $(".xt-menus-container").each(function(i){
            
            if($(this).is(":visible")){
                $(this).children("ol").append($("#copy").html());
            }
            
        });
        
    });
    
    $("#menus-select > li > a").click(function(){
        
        $(".xt-menus-container").hide();
        $("#"+$(this).attr("rel")).show();
        $("#menus-select > li > a").removeClass("selected");
        $(this).addClass('selected');
        
    });
    
    $(".xt-menus-container").on('click', '.menu_opt_display', function(){
       
        $(this).parent().children(".options").slideToggle('fast');
        if ( $(this).hasClass( 'displayed' ) )
            $(this).removeClass( 'displayed' );
        else
            $(this).addClass( 'displayed' );
        
    });
    
    $(".xt-menus-container").on('click', '.menu_delete', function(){
       
        if(confirm(lang_delete))
            $(this).parent().parent().remove();
        
    });
    
    $("body").on('keyup', '.xt-menus-container input[name="title"]', function(){
        var ele =  $(this).parents("li").find(".title");
        $(ele).html($(this).val());
    });
    
    $("a.save-menu").click(function(){
        
        var menu = new Array();
        var menus = new Array();

        $("#xt-messages").hide();
        
        $(".xt-menus-container").each(function(i){
            menu[i] = {
                id: $(this).attr("id").replace("menu-", ''),
                content: processMenu.transform("#"+$(this).attr("id"), $(this).attr("id").replace("menu-", ''))
            };
        });
        
        var params = json_encode(menu);

        $.post('navigation.php', {action: 'save', params: params}, function(data){
            $("#xt-messages > span:first-child").html(data.message);
             $("#xt-messages").removeClass();
            
            if(data.error){
                
                $("#xt-messages").addClass('xt-msg-error');
                
            } else {
                
                $("#xt-messages").addClass('xt-msg-success');
                
            }
            
            $("#xt-messages").slideDown('fast');
        },'json');
        
    });
    
    $("#xt-messages .close").click(function(){
        $("#xt-messages").slideUp("fast");
    });
    
    $("ul.w_sections > li > a").click(function(){
        var id = $(this).attr("class").replace("section-", '');
        $(".xt-configuration-section").hide();
        $("#xt-section-"+id).show();
        $("ul.w_sections > li").removeClass("xt-section-visible");
        $(this).parent().addClass("xt-section-visible");
        $.cookie('xtsection', id, { expires: 365});
        return false;
    });
    
    $("ul.w_sections").parent().css("padding",'0');
    $("ul.w_sections").css('border-radius', $("ul.w_sections").parent().css('border-radius'));

    // Add block level
    $("input[type='text'], select, textarea").addClass("input-block-level");

    // Masonry
    if ( $("#themes-items").length > 0 ) {

        $themes = $("#themes-items");
        $themes.imagesLoaded(
            function() {
                $themes.masonry({
                    itemSelector: '.available-theme'
                });
            }
        );

    }
    
});	

