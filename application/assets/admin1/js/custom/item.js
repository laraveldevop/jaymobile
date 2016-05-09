$(document).ready(function() {
    $("ul.sidebar-menu li").each(function(index, element) {
        if($(element).attr('page') == "item")
        {
            $(element).addClass("select");
        }
    });

    $('#AllServiceProvider').click(function() {
        var $_flag = false;
        if($(this).is(":checked"))
        {
            $_flag = true;
        }
        $('#CallerTuneServiceProviderCSV option').prop('selected', $_flag);
    });

    $(".popup-form-validate").on('submit', function(e) {
        var f = $(this);
        f.parsley().validate();
        if (f.parsley().isValid()) {
            var RunRouteURL = siteURL + "admin/interest/save-update-ajax";
            var Type = "POST";
            var PostData = {'InterestID':$("#popupInterestID").val(),'InterestName':$("#InterestTitle").val(), '_token': $('meta[name="csrf-token"]').attr('content')};
            AjaxCall(RunRouteURL, Type, PostData, "Json", "update_interest_box",$("#InterestTitle").val(),false);
        }
        e.preventDefault();
    });

    $("#advancedSetting").change(function(){
        if($(this).is(":checked"))
        {
            $(".localization").removeClass("hide");
        }else{
            $(".localization").addClass("hide");
            resetAgeGroupSpecific();resetGenderSpecific();resetInterestSpecific();resetLocationSpecific();
        }
    });

    $("#ItemTypeID").change(function(){
        var item_type = $("#ItemTypeID option:selected").text();
        //resetItemTypeOption();
        switch (item_type.toLowerCase()){
            case "application":
                applicationAdsRequired()
                break;
            case "audio ad":
                audioAdsRequired()
                break;
            case "caller tune":
                callerTuneAdsRequired();
                break;
            case "image ad":
                imageAdsRequired();
                break;
            case "taxt ad":
                textAdsRequired();
                break;
            case "video ad":
                videoAdsRequired();
                break;
            default:
                $("#inlineRadio1").attr("checked",true).trigger('click').parent().removeClass('hide');
                $(".Source").removeClass('hide');
                $(".CallerTuneID").addClass("hide");
                $(".TextAdDetail").addClass("hide");
                $(".Application").addClass('hide');
                $(".Link").addClass('hide');
        }
    });

    $(".source").change(function(){
        if($(this).val() == "Path")
        {
            $(".Link").addClass("hide");
            $(".Path").removeClass("hide");
        }else if($(this).val() == "Link")
        {
            $(".Path").addClass("hide");
            $(".Link").removeClass("hide");
        }
    });

    $("#LocationSpecific").change(function(){
        if($(this).is(":checked"))
        {
            $("#CountryID").trigger("change");
            $(".location-specific").removeClass("hide");
            $(".location-specific-div").addClass("hide");
        }else{
            $(".location-specific").addClass("hide");
            $(".location-specific-div").removeClass("hide");
            resetLocationSpecific();
        }
    });

    $("#GenderSpecific").change(function(){
        if($(this).is(":checked"))
        {
            $(".gender-specific").removeClass("hide");
            $(".gender-specific-div").addClass("hide");
        }else{
            $(".gender-specific").addClass("hide");
            $(".gender-specific-div").removeClass("hide");
            resetGenderSpecific();
        }
    });

    $("#InterestSpecific").change(function(){
        if($(this).is(":checked"))
        {
            $(".interest-specific").removeClass("hide");
            $(".interest-specific-div").addClass("hide");
        }else{
            $(".interest-specific").addClass("hide");
            $(".interest-specific-div").removeClass("hide");
            resetInterestSpecific();
        }
    });

    $("#AgeSpecific").change(function(){
        if($(this).is(":checked"))
        {
            $(".age-specific").removeClass("hide");
            $(".age-specific-div").addClass("hide");
        }else{
            $(".age-specific").addClass("hide");
            $(".age-specific-div").removeClass("hide");
            resetAgeGroupSpecific();
        }
    });

    $("#CountryID").change(function(){
        show_loader();
        var RunRouteURL = siteURL + "admin/item/state-ajax";
        var Type = "POST";
        var PostData = {'CountryID':$(this).val(), '_token': $('meta[name="csrf-token"]').attr('content')};
        AjaxCall(RunRouteURL, Type, PostData, "Json", "resCountry",edit_state_id,false);
    });

    $("#StateID").change(function(){
        show_loader();
        var RunRouteURL = siteURL + "admin/item/city-ajax";
        var Type = "POST";
        var PostData = {'StateID':$(this).val(), '_token': $('meta[name="csrf-token"]').attr('content')};
        AjaxCall(RunRouteURL, Type, PostData, "Json", "resState",edit_city_id,false);
    });
});

function actionUpdate(element)
{
    if($(element).is(":checked"))
    {
        $(element).parent('div').parent('div').find('.numeric').removeAttr("disabled");
    }else{
        $(element).parent('div').parent('div').find('.numeric').attr("disabled", true);
    }
}

function resetLocationSpecific()
{
    $("#CountryID").trigger("change");
}

function resetGenderSpecific()
{
    $("#inlineRadio22").removeAttr("checked");
    $("#inlineRadio11").attr("checked",true).trigger("click");
}

function resetInterestSpecific()
{
    $("#InterestID").val("0").trigger("change");
}

function resetAgeGroupSpecific()
{
    $("#AgeGroup").val("").trigger("change");
}

function resetItemTypeOption()
{
    $("#inlineRadio2").removeAttr("checked",true);
    $("#inlineRadio1").attr("checked",true).trigger("click");
    $("#CallerTuneCode").val("");
    $("#CallerTuneServiceProviderCSV option:selected").removeAttr("selected");
    CKEDITOR.instances.TextAdDetail.setData("");
}
function applicationAdsRequired()
{
    $(".Source").removeClass('hide');
    $(".Application").removeClass('hide');
    $(".CallerTuneID").addClass("hide");
    $(".TextAdDetail").addClass("hide");
    $(".Path").addClass('hide');
    $("#inlineRadio1").attr("checked",false).parent().addClass('hide');
    $("#inlineRadio2").attr("checked",true).trigger('click');
}

function audioAdsRequired()
{
    $(".Source").removeClass('hide');
    $(".Application").addClass('hide');
    $(".TextAdDetail").addClass("hide");
    $("#inlineRadio1").attr("checked",true).trigger('click').parent().removeClass('hide');
    $(".CallerTuneID").addClass("hide");
    $(".Link").addClass('hide');
}

function callerTuneAdsRequired()
{
    $(".Source").removeClass('hide');

    $(".Application").addClass('hide');
    $(".TextAdDetail").addClass("hide");
    $(".CallerTuneID").removeClass("hide");

    $("#inlineRadio1").attr("checked",true).trigger('click').parent().removeClass('hide');
    $(".Link").addClass('hide');
}

function imageAdsRequired()
{
    $(".Source").removeClass('hide');
    $(".Application").addClass('hide');
    $(".TextAdDetail").addClass("hide");
    $("#inlineRadio1").attr("checked",true).trigger('click').parent().removeClass('hide');
    $(".CallerTuneID").addClass("hide");
    $(".Link").addClass('hide');
}

function textAdsRequired()
{
    $(".Source").addClass('hide');
    $(".Application").addClass('hide');
    $(".CallerTuneID").addClass("hide");
    $(".TextAdDetail").removeClass("hide");
}

function videoAdsRequired()
{
    $(".TextAdDetail").addClass("hide");
    $(".Application").addClass('hide');
    $(".Source").removeClass('hide');
    $(".Link").addClass('hide');
    $("#inlineRadio1").attr("checked",true).trigger('click').parent().removeClass('hide');
    $(".CallerTuneID").addClass("hide");
}


function resCountry(response,state_id)
{
    var select_option = "<option value=''>Select</option>";
    if(response.length > 0)
    {
        $.each(response, function(key, input){
            var select = "";
            if(input.StateID == state_id)
            {
                select = "selected='selected'";
            }
            select_option += "<option "+select+" value='"+input.StateID+"'>"+input.StateName+"</option>";
        });
    }
    $("#StateID").html("");
    $("#StateID").html(select_option);
    $("#CityID").html("");
    $("#CityID").html("<option value=''>Select</option>");
    hide_loader();
    if(state_id != "")
    {
        $("#StateID").trigger("change");
    }
}

function resState(response, city_id)
{
    var select_option = "<option value=''>Select</option>";
    if(response.length > 0)
    {
        $.each(response, function(key, input){
            var select = "";
            if(input.CityID == city_id)
            {
                select = "selected='selected'";
            }
            select_option += "<option "+select+" value='"+input.CityID+"'>"+input.CityName+"</option>";
        });
    }
    $("#CityID").html("");
    $("#CityID").html(select_option);
    hide_loader();
}

function update_interest_box(response,title)
{
    if(response.status == "Success")
    {
        if(response.action == "Add")
        {
            var option = '<option value="'+response.payload+'" >'+title+'</option>';
            $("#InterestID").append(option).select();
        }
        if(response.action == "Update")
        {
            $("#InterestID option").each(function() {
                if($(this).val() == response.payload)
                {
                    $(this).text(title);
                }
            });
        }
        $('#interestModal').modal('hide');
    }else{
        //console.log(jQuery.type(response.payload));
        if(jQuery.type(response.payload) === 'string')
        {
            alert(response.payload);
        }
        if(jQuery.type(response.payload) === 'object')
        {
            $.each(response.payload,function(index,value){
                console.log(index + "  ::  "+value);
            });
        }
    }
}

function resetInterestForm()
{
    $('.popup-form-validate').parsley().destroy();
    $("#popupInterestID").val("");
    $(".popup-form-validate")[0].reset();
}

function showPopupForm()
{
    resetInterestForm();
    $('#interestModal').modal('show');
}

function editPopupForm()
{
    if( $("#InterestID").val() == '0')
    {
        alert("Please select Interest first!");
        return false;
    }
    resetInterestForm();
    $("#popupInterestID").val($("#InterestID").val())
    $("#InterestTitle").val($("#InterestID option:selected").text());
    $('#interestModal').modal('show');
}

function deleteInterest()
{
    if($("#InterestID").val() == '0')
    {
        alert("Please select Interest first!");
        return false;
    }
    if(confirm('Are You Sure Delete Record!'))
    {
        var RunRouteURL = siteURL + "admin/interest/delete-ajax";
        var Type = "POST";
        var PostData = {'InterestID':$("#InterestID").val(),'_token': $('meta[name="csrf-token"]').attr('content')};
        AjaxCall(RunRouteURL, Type, PostData, "Json", "delete_interest_res",$("#InterestID").val(),false);
    }else{
        return false;
    }
}

function delete_interest_res(response,id)
{
    if(response.status == "Success")
    {
        $("#InterestID option").each(function() {
            if($(this).val() == id)
            {
                $(this).remove();
            }
        });
        $("#InterestID").val("0").select();
    }else{
        alert(response.payload);
    }
}