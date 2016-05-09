$(document).ready(function() {
    $('button.to-grid').addClass('active');
    var totalLoad = 1;
    var loading  = false;
    var totalGroups = $("#totalMediaCount").val();

    //$('.uploadedMedia').load("autoload_process.php", {'groupNumber':track_load}, function() {track_load++;}); //load first group

    $(window).scroll(function() {

        if($(window).scrollTop() + $(window).height() == $(document).height())
        {
            if(totalLoad <= totalGroups && loading == false)
            {
                loading = true;
                var PostData = {'groupNumber': totalLoad};
                $.ajax({
                    url: siteURL + "TAG/admin/media/ajax-lazy-load-image",
                    type: "POST",
                    data: PostData,
                    cache: false,
                    dataType: "Json",
                    success: function (data) {
                        var html = '';
                        if(data.media != ''){
                            $.each(data.media, function(index, element){

                                // check if media layout is grid or list
                                if($('button.to-grid').hasClass('active'))
                                    html += '<div class="mix" style="display:inline-block !important; padding:5px;">';
                                else
                                    html += '<div class="mix" style="display:block !important; padding:5px;">';

                                html += '<div class="panel p6 pbn">';
                                html += '<div class="of-h">';
                                html += '<img src="' + siteImageURL + element.path + '" lang="'+element.id+'" width="200" height="200" title="gallery image" onclick="openMediaInfo(this);">';
                                html += '<div class="row table-layout"><div class="col-md-8 va-m pln"><h6>'+element.name+'</h6></div>';
                                html += '<div class="col-md-4 text-right va-m prn"><span class="fa fa-eye-slash fs12 text-muted"></span><span class="fa fa-circle fs10 text-info ml10"></span></div>';
                                html += '</div></div></div></div>';
                            });
                            $(html).hide().appendTo(".uploadedMedia").fadeIn('slow');
                            totalLoad++;
                            loading = false;
                            $(".mix").show();
                        } else {
                            console.log('Media completed');
                        }
                    },
                    error: function (e, errorMsg) {
                        alert(errorMsg);
                        loading = false;
                    }

                });
            }
        }
    });
});

function getInitialMedia()
{
    var RunRouteURL = siteURL + "TAG/admin/media/ajax-get-initial-media";
    var Type = "POST";
    var PostData = {};
    AjaxCall(RunRouteURL, Type, PostData, "Json", "responseFillGallery");
}

function responseFillGallery(response)
{
    var html = '';
    if(response.media != undefined){
        $.each(response.media, function (index, element){
            if($('button.to-grid').hasClass('active'))
                html += '<div class="mix" style="display:inline-block !important; padding:5px;">';
            else
                html += '<div class="mix" style="display:block !important; padding:5px;">';

            html += '<div class="panel p6 pbn">';
            html += '<div class="of-h">';
            html += '<img src="' + siteImageURL + element.path + '" lang="'+element.id+'" width="200" height="200" title="gallery image" onclick="openMediaInfo(this);">';
            html += '<div class="row table-layout"><div class="col-md-8 va-m pln"><h6>'+element.name+'</h6></div>';
            html += '<div class="col-md-4 text-right va-m prn"><span class="fa fa-eye-slash fs12 text-muted"></span><span class="fa fa-circle fs10 text-info ml10"></span></div>';
            html += '</div></div></div></div>';
        });
        $(html).hide().appendTo(".uploadedMedia").fadeIn('slow');
    }
}

function openMediaInfo(e)
{
    progressJs().start().autoIncrease(4, 500);
    lastAttributeReference = $(e).parents('.mix');
    var PostData = { id:$(e).attr('lang') };
    AjaxCall(siteURL+ 'TAG/admin/media/ajax-get-media-info', "POST", PostData, "Json", "responseFillMediaInfo");
}

function responseFillMediaInfo(response)
{
    if(response.status == 'success'){
        $.magnificPopup.open({
            items: {
                src: $("#modal-panel")
            },
            callbacks: {
                beforeOpen: function(e) {
                    $("#mediaImage").attr('src', siteImageURL + response.mediaInfo.path);
                    $("#mediaInfoDimensions").text(response.mediaInfo.width + ' x ' + response.mediaInfo.height);
                    $("#mediaInfoURL").val(siteImageURL + response.mediaInfo.path);
                    $("#mediaID").val(response.mediaInfo.id);
                    $("#mediaInfoDate").text('Uploaded on: ' + response.mediaInfo.created_at);
                    $("#mediaInfoName").text(response.mediaInfo.name);
                }
            }
        });
    } else {
        alert("Problem retrieving media information!");
    }
    progressJs().end();
}

function deleteMedia()
{
    var RunRouteURL = siteURL + "TAG/admin/media/ajax-delete-media";
    var Type = "POST";
    var PostData = { id:$("#mediaID").val() };
    AjaxCall(RunRouteURL, Type, PostData, "Json", "responseCloseModal");
}

function responseCloseModal()
{
    lastAttributeReference.remove();
    $.magnificPopup.close();
}