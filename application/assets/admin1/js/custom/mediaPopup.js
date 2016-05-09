var lastAttributeReference = '';
var previousAttributeReference = '';
$(document).ready(function() {
    $("#gallery").click(function() {
        getAllMedia();
    });

    Dropzone.options.mediaDropZone = {
        paramName: "Image",
        acceptedFiles: 'image/*',
        maxFilesize: 5, // MB
        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i> \
                                         <span class="main-text"><b>Drop Files</b> to upload</span> <br /> \
                                         <span class="sub-text">(or click)</span> \
                                        ',
        dictResponseError: 'Server not Configured',
        init: function () {
            this.on("success", function (file, response) {
                this.removeFile(file);
                $("#gallery").trigger('click');

            });
        }
    };
});

function getAllMedia()
{
    var RunRouteURL = siteURL + "TAG/admin/media/ajax-get-media";
    var Type = "POST";
    var PostData = {};
    AjaxCall(RunRouteURL, Type, PostData, "Json", "responseFillMediaLibrary");
}

function responseFillMediaLibrary(response)
{
    var html = '';
    if(response.media != undefined){
        $.each(response.media, function (index, element){
            html += '<div class="mix" style="display:inline-block !important; padding:5px;">';
            html += '<div class="panel p6"><div class="of-h">';
            html += '<img src="'+siteImageURL + element.path +'" class="h-170" title="media image" lang="'+element.id+'" onclick="getMediaInfo(this);" onerror="this.src=' + siteURL + 'TAG/public/assets/admin/images/stock/7.jpg' + '">';
            html += '</div></div></div>';
        });
        $("#mix-container").html('');
        $("#mix-container").append(html);
    } else {
        html += '<div class="fail-message text-center p10"><span>No items were found matching the selected filters</span></div>';
        $("#mix-container").html('');
        $("#mix-container").append(html);
    }
}

function getMediaInfo(e)
{
    if(previousAttributeReference.length > 0)
        previousAttributeReference.removeClass('media-selected');
    previousAttributeReference = lastAttributeReference = $(e).parents('div.mix');
    lastAttributeReference.addClass('media-selected');
    var RunRouteURL = siteURL + "TAG/admin/media/ajax-get-media-info";
    var Type = "POST";
    var PostData = { id: $(e).attr('lang') };
    AjaxCall(RunRouteURL, Type, PostData, "Json", "responseFillMediaInfo");
}

function responseFillMediaInfo(response)
{
    var title = response.mediaInfo.name.split('.');
    $("#previewMedia").attr('src', siteImageURL+response.mediaInfo.path);
    $("#mediaInfoURL").val(siteImageURL+response.mediaInfo.path);
    $("#mediaInfoPath").val(response.mediaInfo.path);
    $("#mediaInfoTitle").val(title[0]);
    $("#mediaInfoAltText").val(title[0]);
    $("#mediaInfoDimensions").text(response.mediaInfo.width + 'x' + response.mediaInfo.height);
}

function insertMedia()
{
    var imgText = '<img data-mce-src="'+ $("#mediaInfoURL").val()+'" src="'+ $("#mediaInfoURL").val() +'" title="'+$("#mediaInfoTitle").val()+'" alt="'+$("#mediaInfoAltText").val()+'">';
    var htmledit = tinyMCE.activeEditor.getContent();
    htmledit += imgText;
    tinyMCE.activeEditor.setContent(htmledit);
    $.magnificPopup.close();
}

function deleteMedia()
{
    var RunRouteURL = siteURL + "TAG/admin/media/ajax-delete-media";
    var Type = "POST";
    var PostData = { id:lastAttributeReference.find('img').attr('lang') };
    AjaxCall(RunRouteURL, Type, PostData, "Json", "responseUpdateMediaLibrary");
}

function responseUpdateMediaLibrary()
{
    lastAttributeReference.remove();
    $("#previewMedia").attr('src', '');
    $("#mediaInfoURL").val('');
    $("#mediaInfoTitle").val('');
    $("#mediaInfoAltText").val('');
    $("#mediaInfoDimensions").text('');
    lastAttributeReference = '';
}