$(document).ready(function(){
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

    $noConf("#ItemID").dropdown({
        change : function(curSelVal){
            if( curSelVal != undefined ){
                if( curSelVal == "" ){
                    $noConf("#ItemID > option:selected").attr('selected', false);
                    $noConf("#ItemID option:first").attr('selected','selected');
                }else{
                    $noConf("#ItemID option:first").attr('selected',false);
                }
            }
        }
    });

    $noConf("#InterestID").dropdown({
        change : function(curSelVal){
            if( curSelVal != undefined ){
                if( curSelVal == "" ){
                    $noConf("#InterestID > option:selected").attr('selected', false);
                    $noConf("#InterestID option:first").attr('selected','selected');
                }else{
                    $noConf("#InterestID option:first").attr('selected',false);
                }
            }
        }
    });

    $noConf("#CountryID").dropdown({
        change : function(curSelVal){
            if( curSelVal != undefined ){
                if( curSelVal == "" ){
                    $noConf("#CountryID > option:selected").attr('selected', false);
                    $noConf("#CountryID option:first").attr('selected','selected');
                }else{
                    $noConf("#CountryID option:first").attr('selected',false);
                }
                state();
            }
        }
    });

    $noConf("#StateID").dropdown({
        change : function(curSelVal){
            if( curSelVal != undefined ){
                if( curSelVal == "" ){
                    $noConf("#StateID > option:selected").attr('selected', false);
                    $noConf("#StateID option:first").attr('selected','selected');
                }else{
                    $noConf("#StateID option:first").attr('selected',false);
                }
            }
            city();
        }
    });

    $noConf("#CityID").dropdown({
        change : function(curSelVal){
            if( curSelVal != undefined ){
                if( curSelVal == "" ){
                    $noConf("#CityID > option:selected").attr('selected', false);
                    $noConf("#CityID option:first").attr('selected','selected');
                }else{
                    $noConf("#CityID option:first").attr('selected',false);
                }
            }
        }
    });

    $("#advancedSetting").change(function(){
        if($(this).is(":checked"))
        {
            $(".localization").removeClass("hide");
        }else{
            $(".localization").addClass("hide");
        }
    });

    $("#LocationSpecific").change(function(){
        if($(this).is(":checked"))
        {
            state();
            $(".location-specific").removeClass("hide");
            $(".location-specific-div").addClass("hide");
        }else{
            $(".location-specific").addClass("hide");
            $(".location-specific-div").removeClass("hide");
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
        }
    });
});

function state()
{
    show_loader();
    var RunRouteURL = siteURL + "admin/campaign/state-ajax";
    var Type = "POST";
    var PostData = {'CountryID':$("#CountryID").val(), '_token': $('meta[name="csrf-token"]').attr('content')};
    AjaxCall(RunRouteURL, Type, PostData, "Json", "resState",edit_state_id,false);
}

function city()
{
    show_loader();
    var RunRouteURL = siteURL + "admin/campaign/city-ajax";
    var Type = "POST";
    var PostData = {'StateID':$("#StateID").val(), '_token': $('meta[name="csrf-token"]').attr('content')};
    AjaxCall(RunRouteURL, Type, PostData, "Json", "resCity",edit_city_id,false);
}
function resState(response,state_id)
{
    var text = "Doesn't Matter";
    var select_option = "<option value='' label='"+text+"'>"+text+"</option>";
    if(response.length > 0)
    {
        var state_array = state_id.split(",");
        $noConf.each(response, function(key, input){
            var select = "";
            if($noConf.inArray(input.StateID.toString(), state_array) !== -1)
            {
                select = "selected='selected'";
            }
            select_option += "<option "+select+" value='"+input.StateID+"' label='"+input.StateName+"'>"+input.StateName+"</option>";
        });
    }else{
        $("#ddSelOptHolder_StateID").find('span').remove();
        $("#ddSelOptHolder_StateID").append('<span rel="" class="ddSelectedOptSpan">'+text+'</span>');

        $("#ddSelOptHolder_CityID").find('span').remove();
        $("#ddSelOptHolder_CityID").append('<span rel="" class="ddSelectedOptSpan">'+text+'</span>');
    }
    $("#StateID").html("");
    $("#StateID").html(select_option);
    hide_loader();
    if(state_id != "")
    {
        city();
    }
}

function resCity(response, city_id)
{
    var text = "Doesn't Matter";
    var select_option = "<option value='' label='"+text+"'>"+text+"</option>";
    if(response.length > 0)
    {
        var last_state_id = "";
        var city_array = city_id.split(",");
        $noConf.each(response, function(key, input){
            var select = "";
            var option_group = "";
            var option_group_end = ""
            if($noConf.inArray(input.CityID.toString(), city_array) !== -1)
            {
                select = "selected='selected'";
            }

            if(last_state_id == "")
            {
                option_group = '<optgroup label="'+input.StateName+'">';
                option_group_end = '</optgroup>';
            }else if(last_state_id != "" && last_state_id != input.StateID)
            {
                option_group = '<optgroup label="'+input.StateName+'">';
                option_group_end = '</optgroup>';
            }
            select_option += option_group + "<option "+select+" value='"+input.CityID+"'>"+input.CityName+"</option>"+option_group_end;
            last_state_id = input.StateID;
        });
    }else{
        $("#ddSelOptHolder_CityID").find('span').remove();
        $("#ddSelOptHolder_CityID").append('<span rel="" class="ddSelectedOptSpan">'+text+'</span>');
    }
    $("#CityID").html("");
    $("#CityID").html(select_option);
    hide_loader();
}
function getItemByAdvertiser(AdvertiserID,$CampaignID){
    show_loader();
    postData = AdvertiserID;
    var RunRouteURL = siteURL + "admin/item/item-by-advertiser-id";
    var Type = "POST";
    var PostData = {'AdvertiserId':AdvertiserID,'CampaignID':$CampaignID, '_token': $('meta[name="csrf-token"]').attr('content')};
    AjaxCall(RunRouteURL, Type, PostData, "Json", "getItemByAdvertiser_res",'',false);
}
function getItemByAdvertiser_res(response){
    hide_loader();
    var option = '<option value="" label="select">Select</option>';
    if(response != null ){
        if(response.item_list.length > 0){
            $noConf.each(response.item_list,function(key, input){
                var select = '';
                if(response.selected_item_list.length > 0){
                    $noConf.each(response.selected_item_list,function(key,value){
                        if(input.ItemDetailID == value.ItemDetailID){
                            select = "selected='selected'";
                        }
                    });
                }
                option += '<option label="'+input.Name+'" '+select+' value="'+input.ItemDetailID+'">'+input.Name +'</option>';
            });
        }

    }
    $("#ItemID").html(option);
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