var siteURL = window.location.protocol + "//" + window.location.host +"/";
if(window.location.host == "localhost" || window.location.host == "192.168.1.129")
{
    siteURL = window.location.protocol + "//" + window.location.host + "/DollarTune/";
}else{
    siteURL = "/php/DollarTune/";
}
var siteImageURL = siteURL + "/app/Uploads/";

$(window).load(function() {
    $(".se-pre-con").fadeOut("slow");
});

$.ajaxSetup({
    headers: {
        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function AjaxCall(URL, Type, PostData, DataType, Method, ParamObj,_async) {
    $.ajax({
        url: URL,
        type: Type,
        data: PostData,
        cache: false,
        dataType: DataType,
        async:_async,
        success: function (data) {
            if (ParamObj == undefined || ParamObj == null || ParamObj == "") {
                window[Method](data);
            }
            else {
                window[Method](data, ParamObj);
            }
        },
        error: function (e, errorMsg) {
            window["errorAlert"](e, errorMsg, ParamObj);
        }

    });
    _async="";
}

function AjaxFileCall(URL, Type, PostData, Method) {
    $.ajax({
        url: URL,
        type: Type,
        data: PostData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            window[Method](data);
        },
        error: errorAlert
    });
}

function errorAlert(e, errorMsg, ParamObj) {
    alert("Your request was not successful: " + errorMsg);
    //LoadMask(false);
};

function show_loader(){
    error_message_close();
    $('.overlay').removeClass('hide');
}
function hide_loader(){
    $('.overlay').addClass('hide');
}

function error_message_html(){
    return '<div class="alert alert-_CLASS_"><button data-dismiss="alert" class="close" type="button">×</button><i class="fa fa-ok-sign"></i>_MESSAGE_</div>';
}

function error_message_close(){
    $(".ajax-message").html('').addClass('hide');
}

function error_message_animation_close(){
    setTimeout(function() {
        $(".ajax-message").children().fadeOut(500, function(){
            $(this).remove();
        });
    }, 1000);
    // $(".ajax-message").html('').addClass('hide');
}

function reloadOnResponse()
{
    location.reload();
}

function menu_select($_role_name, $_page_name)
{
    $.each($(".role_menu li"),function(key,li){
        if($(li).attr('rolename') != undefined && $(li).attr('rolename') == $_role_name)
        {
            var $_ul = $(li).children('ul');
            $(li).addClass('active');
            if($_ul.length > 0)
            {
                $.each($_ul.find('li'),function(parent_key,parent_li){
                    if($(parent_li).attr('pagename') == $_page_name)
                    {
                        $(parent_li).addClass('active');
                    }
                });
            }
        }
    });
}