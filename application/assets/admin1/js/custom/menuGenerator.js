$(document).ready(function(){
	init();
});

function init()
{
	$('.dd').nestable({ maxDepth:100 });
	//hide_loader();
	updateParentList();

    $("#editModal").find("input[name='ItemLabel']").val('');
    $("#editModal").find("select[name='PageList']").val('').trigger('change');

	$('.dd').on('change', function() {
	   updateParentList();
	   updateChildren();
	});
}

function addNewMenuItem(element)
{
    var menuModal = $("#addModal");
	var pageID = $(element).parents('.panel').find("select[name='PageList']").val();
	if(pageID == ''){
		alert("Please select a page!");
	} else {
		var ItemLabel = $(element).parents('.panel').find("input[name='ItemLabel']").val();
		var MainMenuID = $(element).parents('.panel').find("input[name='MenuID']").val();
		var Parent = $(element).parents('.panel').find("select[name='ParentList']").val();

		var newMenuItemHTML = "";
		var PostData = { MenuID:MainMenuID, PageID:pageID, Label:ItemLabel, ParentID:Parent }
        $.magnificPopup.close();
		AjaxCall(siteURL + 'TAG/admin/menu/ajax-add-menu-item', "POST", PostData, "Json", "reloadOnResponse");
	}
}

function editMenuItem(element)
{
    var PostData = { ItemID:$(element).parent().attr('data-id') };
    AjaxCall(siteURL + 'TAG/admin/menu/ajax-menu-item-info', "POST", PostData, "Json", "responseEditMenuItem");
}

function responseEditMenuItem(response)
{
    var menuModal = $("#editModal");
    $.magnificPopup.open({
        items: {
            src: menuModal
        },
        callbacks: {
            beforeOpen: function() {
                updateParentList();
                var editLabel = response.details.item_label;
                var editSlug = response.details.item_slug;
                var editPageID = response.details.page_id;
                var editID = response.details.id;
                var editParentID = response.details.parent_id;
                menuModal.find(".panel-body").find("input[name='ItemLabel']").val(editLabel);
                menuModal.find(".panel-body").find("input[name='ItemSlug']").val(editSlug);
                menuModal.find(".panel-body").find("select[name='PageList']").children().each(function(key, element){
                    if($(element).val() == editPageID){
                        $(element).prop('selected', true);
                    } else {
                        $(element).removeAttr('selected');
                    }
                });
                menuModal.find(".panel-body").find("input[name='id']").val(editID);
                menuModal.find(".panel-body").find("select[name='ParentList']").children().each(function(key, element){
                    //do not show edit id as parent id, as an item cannot be its own parent
                    if($(element).val() == editID){
                        $(element).remove();
                    }

                    if($(element).val() == editParentID){
                        $(element).prop('selected', true);
                    } else {
                        $(element).removeAttr('selected');
                    }
                });
                menuModal.find(".panel").find("button[type='button']").html('Update');
                menuModal.find(".panel").find("button[type='button']").attr('onclick', 'updateMenuItem(this);');
            }
        }
    });
}

function updateMenuItem(element)
{
    var pageID = $(element).parents('.panel').find("select[name='PageList']").val();
	if(pageID == ''){
		alert("Please select a page!");
	} else {
        var ItemLabel = $(element).parents('.panel').find("input[name='ItemLabel']").val();
		var Parent = $(element).parents('.panel').find("select[name='ParentList']").val();
		var ID = $(element).parents('.panel').find("input[name='ItemID']").val();

		var PostData = { ItemID:ID, Label:ItemLabel, PageID:pageID, ParentID:Parent }
        $.magnificPopup.close();
		AjaxCall(siteURL + 'TAG/admin/menu/ajax-update-menu-item', "POST", PostData, "Json", "reloadOnResponse");
	}
}

function removeMenuItem(element)
{
	var ItemID = $(element).parent().attr('data-id');
	var PostData = { MenuID:$("#MenuID").val(), ID:ItemID }

	AjaxCall(siteURL + 'TAG/admin/menu/ajax-remove-menu-item', "POST", PostData, "Json", "reloadOnResponse");
}

function updateParentList()
{
	var parentListHtml = "<option value=''>No Parent</option>";
    var addModal = $("#addModal");
    var editModal = $("#editModal");
    var designMenu = $("#designMenu");
	if(designMenu.find(".parent-label").length > 0){
		designMenu.find(".parent-label").each(function(index, value){
			parentListHtml += "<option value='"+$(this).parents('.dd-item').attr('data-id')+"'>"+$(this).text()+"</option>";
		});
		addModal.find(".panel-body select[name='ParentList']").html("");
		addModal.find(".panel-body select[name='ParentList']").html(parentListHtml);

        editModal.find(".panel-body select[name='ParentList']").html("");
        editModal.find(".panel-body select[name='ParentList']").html(parentListHtml);
	}
}

function updateChildren()
{
	//show_loader();
	var jsonData = window.JSON.stringify($('.dd').nestable('serialize'));
	var PostData = { MenuID:$("#MenuID").val(), SerialData:jsonData };
	AjaxCall(siteURL+ 'TAG/admin/menu/ajax-update-children', "POST", PostData, "Json", "hide_loader");
}