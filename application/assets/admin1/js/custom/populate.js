var populateCasteTimer = "";
var populateStateTimer = "";
var populateAnnualIncomeTimer = "";
var populateCityTimer = "";
var populateWorkingAsTimer = "";
function initSearch() {
    var B = $("#search_form_container #subtabs > li.selected").attr("id");
    var A = "";
    switch (B) {
        case"who_is_online":
            A = "/search/index/whoisonline";
            break;
        case"smart_search":
            A = "/search/index/smart";
            break;
        case"basic_search":
            A = "/search/index/basic";
            break;
        case"special_case":
            A = "/search/index/special-cases";
            break;
        case"astrology_search":
            A = "/search/index/astrology";
            break
    }
    $("#reset_form_anchor").bind({
        click: function () {
            $("#reset_form").html('<a href="javascript:void(0);" class="light_blue">Reset</a>');
            load_form(B, A, "", "Y");
            return false
        }
    });
    $("#member_matches").live("click", function () {
        get_profile_matches(this.id, "mymatches-unviewed");
        return false
    });
    $("#my_partner_matches").live("click", function () {
        get_profile_matches(this.id, "personalmatches");
        return false
    });
    $("#broader_matches").live("click", function () {
        get_profile_matches(this.id, "broadermatches-unviewed");
        return false
    });
    $("#who_is_online").live("click", function () {
        if (!$(this).hasClass("selected")) {
            load_form(this.id, "/search/index/whoisonline");
            return false
        }
    });
    $("#smart_search").live("click", function () {
        if (!$(this).hasClass("selected")) {
            load_form(this.id, "/search/index/smart");
            return false
        }
    });
    $("#basic_search").live("click", function () {
        if (!$(this).hasClass("selected")) {
            load_form(this.id, "/search/index/basic");
            return false
        }
    });
    $("#special_case").live("click", function () {
        if (!$(this).hasClass("selected")) {
            load_form(this.id, "/search/index/special-cases");
            return false
        }
    });
    $("#astrology_search").live("click", function () {
        if ($(this).find("a").attr("onClick") == undefined) {
            if (!$(this).hasClass("selected")) {
                load_form(this.id, "/search/index/astrology")
            }
        }
        return false
    });
    $("div.search_heads").die("click");
    $("div.search_heads").live("click", function (C) {
        if ($(this).next("div.collapsible_content").is(":visible")) {
            $(this).find("span.src_collapse").addClass("src_expand").removeClass("src_collapse")
        } else {
            $(this).find("span.src_expand").addClass("src_collapse").removeClass("src_expand")
        }
        $(this).next("div.collapsible_content").slideToggle("slow");
        $(this).find("span.src_field_det").toggle()
    })
}
function reset_form(A) {
    var B = random_string();
    $("#reset_form").html("<a class='light_blue' href='#'>Reset</a>");
    $.ajax({
        type: "GET", url: A + "?rand=" + B, success: function (C) {
            $(".src_main_form").html(C)
        }, error: function (C, E, D) {
        }
    })
}
function check_maritalstatus(A) {
    if (A == "maritalstatus-") {
        if ($("#maritalstatus-").is(":checked")) {
            $(".marital_status").attr("checked", false);
            $("#maritalstatus-").attr("checked", true)
        }
    } else {
        if ($("#maritalstatus-").is(":checked")) {
            $("#maritalstatus-").attr("checked", false)
        }
    }
}
function load_form(E, B, D, A) {
    if (D != undefined) {
        if (D.match("savedsearch_name")) {
            extend_url = "&" + D
        } else {
            extend_url = "&pg_searchresults_id=" + D
        }
    } else {
        extend_url = ""
    }
    var C = random_string();
    if (A != "Y") {
        $("#preloader").removeClass("none");
        $(".src_main_form").html("");
        $(".subtabs-wrap-inactive").removeClass("none");
        $(".subtabs-wrap").addClass("none");
        $(".subtabs-wrap-inactive > ul > li").removeClass("selected");
        $(".subtabs-wrap > ul > li").removeClass("selected");
        $("#" + E + "").addClass("selected");
        $("#" + E + "-inactive").addClass("selected")
    }
    $.ajax({
        type: "POST", data: "", url: B + "?rand=" + C + extend_url, success: function (F) {
            $("#preloader").addClass("none");
            $(".src_main_form").html(F);
            $(".subtabs-wrap-inactive").addClass("none");
            $(".subtabs-wrap").removeClass("none");
            $("#reset_form_anchor").bind({
                click: function () {
                    $("#reset_form").html('<a href="javascript:void(0);" class="light_blue">Reset</a>');
                    load_form(E, B, D, "Y");
                    return false
                }
            });
            if (E == "smart_search") {
                expand_advance_form()
            }
        }, error: function (F, H, G) {
            $(".subtabs-wrap-inactive").addClass("none");
            $(".subtabs-wrap").removeClass("none");
            $("#preloader").addClass("none")
        }
    })
}
function get_profile_matches(C, B) {
    var A = random_string();
    $("#" + C + "_inactive > a > .loader_1").css("visibility", "visible");
    $(".my_matches_tab_inactive").removeClass("none");
    $(".my_matches_tab").addClass("none");
    $(".my_matches_tab_inactive > ul > li > a").removeClass("selected");
    $(".my_matches_tab > ul > li > a").removeClass("selected");
    $("#" + C + "_inactive > a").addClass("selected");
    $("#" + C + " > a").addClass("selected");
    $.ajax({
        type: "POST", url: "/search/index/my-matches?rand=" + A, data: "srch_name=" + B, success: function (D) {
            $("#my_matches_content").html(D);
            $("#" + C + "_inactive > a > .loader_1").css("visibility", "hidden");
            $(".my_matches_tab_inactive").addClass("none");
            $(".my_matches_tab").removeClass("none")
        }, error: function (D, F, E) {
            $("#" + C + "_inactive > a > .loader_1").css("visibility", "hidden");
            $(".my_matches_tab_inactive").addClass("none");
            $(".my_matches_tab").removeClass("none")
        }
    })
}
function random_string() {
    var D = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var E = 15;
    var C = "";
    for (var B = 0; B < E; B++) {
        var A = Math.floor(Math.random() * D.length);
        C += D.substring(A, A + 1)
    }
    return C
}
function set_mt_caste() {
    $("#mothertongue").val("");
    $("#caste").val("")
}
function which_community(com, gen, fn) {
    var wio_final_array = new Array();
    wio_final_array.Muslim = new Array("All", "Bengali", "Dawoodi Bohra", "Shia", "Sunni");
    wio_final_array.Christian = new Array("All", "Born Again", "Protestant", "Roman Catholic");
    wio_final_array.Sikh = new Array("All", "Gurusikh", "Jat", "Khatri", "Ramgharia");
    wio_final_array.Jain = new Array("All", "Digambar", "Shwetamber", "Vania");
    wio_final_array.Parsi = new Array("parsi");
    wio_final_array.Buddhist = new Array("Buddhist");
    wio_final_array.Jewish = new Array("Jewish");
    wio_final_array.NoReligion = new Array("No Religion");
    wio_final_array.SpiritualNoReligious = new Array("Spiritual - Not Religious");
    wio_final_array.Other = new Array("Other");
    if (com == "" || com == " ") {
        $("#show_hide_caste").addClass("none")
    } else {
        if (com == "Hindu") {
            $("#show_hide_caste").addClass("none")
        } else {
            var d = eval("document." + fn);
            var caste_object = d.elements.caste;
            caste_object.options.length = 0;
            if (com.match("Spiritual")) {
                com = "SpiritualNoReligious"
            } else {
                com = com.replace(/\s/, "")
            }
            if (wio_final_array[com].length > 1) {
                caste_object[0] = new Option("Doesn't Matter", " ", false);
                for (var i = 0; i < wio_final_array[com].length; i++) {
                    if (wio_final_array[com][i] == "All") {
                        caste_object[i + 1] = new Option(wio_final_array[com][i], "", false)
                    } else {
                        caste_object[i + 1] = new Option(wio_final_array[com][i], com + ":" + wio_final_array[com][i], false)
                    }
                }
                $("#show_hide_caste").removeClass("none")
            } else {
                $("#show_hide_caste").addClass("none")
            }
        }
    }
}
function populate_state(G, C, H, B, F, A, D) {
    if (D == "Y") {
        clear_city()
    }
    check_state_obj = B;
    var E = "/ajax/populate-states?country=" + escape(G) + "&state=" + escape(C) + "&city=" + escape(H);
    if (G == "") {
        B.options.length = 0;
        B[0] = new Option("Select state", "");
        return false
    }
    $("#state_only").removeClass("none");
    $("#stateofresidence").addClass("none");
    if ($("#loading_state").length > 0) {
        $("#loading_state").html('<img src="' + IMG_PATH + '/imgs/profiles/ver2/loading.gif" height="15" width="15" border="0" alt="Loading" title="Loading">')
    }
    if (C == "-") {
        check_selected_state = "Other"
    } else {
        check_selected_state = C
    }
    if (A == "Y") {
        B.options.length = 0
    }
    $.ajax({
        type: "GET", url: E, success: function (L) {
            myString = new String(L);
            splitString = myString.split("|");
            check_state_obj.options.length = 0;
            check_state_obj[0] = new Option("Select state", "");
            for (var J = 0; J < splitString.length; J++) {
                var K = $.trim(splitString[J]);
                var I;
                if (K == "Other") {
                    I = "-"
                } else {
                    I = K
                }
                check_selected_state_spilt_string = check_selected_state.split("|");
                if (InArray(check_selected_state_spilt_string, K) >= 0) {
                    check_state_obj[J + 1] = new Option(K, I, false, true);
                    check_state_obj[J + 1].selected = true
                } else {
                    check_state_obj[J + 1] = new Option(K, I)
                }
            }
            if ($("#loading_state").length > 0) {
                $("#loading_state").html("")
            }
            $("#stateofresidence").removeClass("none")
        }, error: function (I, K, J) {
            $("#state_only").addClass("none")
        }
    });
    if (C) {
        populate_city(G, C, H, "", "", "Y")
    }
}
function populate_city(G, C, B, A, E, D) {
    if (D == "Y") {
    }
    var F = "/ajax/populate-search-city?country=" + escape(G) + "&state=" + escape(C) + "&state_option=" + escape(E) + "&from_page=" + escape(A);
    show_grid_loading("nearest_city");
    if (C == "" && (G == "India" || G == "USA")) {
        empty_left_grid("nearest_city");
        $("#loading_city").html("");
        $("#searchby-city").attr("checked", false);
        $("#city_only").addClass("none");
        return false
    }
    show_city_grid();
    $.ajax({
        type: "GET", url: F, success: function (H) {
            if (clear_city == "Y") {
            }
            myString = new String(H);
            populate_multiselect_grid("nearest_city", myString, B, myString);
            hide_grid_loading("nearest_city")
        }, error: function (H, J, I) {
            hide_grid_loading("nearest_city");
            $("#city_only").addClass("none")
        }
    })
}
function populate_children() {
    if ($("#maritalstatus").val() == "Never Married") {
        $("[name^='children']").attr("checked", false);
        $("#have_children").hide()
    } else {
        if ($("[name^='children']").is(":checked") == false) {
            $("[name^='children']").filter('[value=""]').attr("checked", true)
        }
        $("#have_children").show()
    }
}
function set_search_by(B) {
    var A = "Y";
    if (B == "searchby-city") {
        if ($("#searchby-city").attr("checked")) {
            if ($.trim($("#countryofresidence").val()) != "") {
                $("#city_only").removeClass("none");
                if (($.trim($("#countryofresidence").val()) == "India" || $.trim($("#countryofresidence").val()) == "USA") && $.trim($("#stateofresidence").val()) == "") {
                    $("#city_only").addClass("none")
                }
            }
        } else {
            empty_right_grid("nearest_city");
            $("#city_only").addClass("none")
        }
    }
    if (B == "searchby-profession") {
        if ($("#searchby-profession").attr("checked")) {
            $("#occupation_wrapper_div").removeClass("none")
        } else {
            clear_all("working_with");
            clear_all("occupation_area");
            clear_all("occupation");
            $("#occupation_wrapper_div").addClass("none")
        }
    }
    if (B == "searchby-keyword") {
        if ($("#searchby-keyword").attr("checked")) {
            $("#keyword_div").removeClass("none")
        } else {
            $("#keyword").val("");
            $("#keyword_div").addClass("none")
        }
    }
    if (B == "searchby-caste") {
        if ($("#searchby-caste").attr("checked")) {
            $("#caste").removeAttr("disabled");
            $("#show_hide_caste").removeClass("none")
        } else {
            $("#caste").val("");
            $("#caste").attr("disabled", true);
            $("#show_hide_caste").addClass("none")
        }
    }
    if (B == "searchby-country") {
        if ($("#searchby-country").attr("checked")) {
            $("#show_hide_country").removeClass("none")
        } else {
            $("#countryofresidence").val("");
            $("#show_hide_country").addClass("none");
            $("#stateofresidence").val("");
            $("#state_only").addClass("none");
            empty_right_grid("nearest_city");
            $("#city_only").addClass("none")
        }
    }
    if ($("#searchby-city").attr("checked") || $("#searchby-profession").attr("checked") || $("#searchby-keyword").attr("checked")) {
        A = "N"
    }
    if (A == "Y") {
        $("#searchby-wrapper").css("display", "none");
        $("#searchby-spacer").css("display", "block")
    } else {
        $("#searchby-wrapper").css("display", "block");
        $("#searchby-spacer").css("display", "none")
    }
}
function show_mt_caste(E, D, A, C, B) {
    if (E == "") {
        if (A != "new_home_page") {
            $("#show_hide_mothertongue").css("display", "none");
            $("#show_hide_caste").css("display", "none")
        }
    } else {
        if (E == "doesn't_matter") {
            if (A == "new_home_page") {
                $("#show_hide_mothertongue").css("display", "block");
                $("#show_hide_caste").css("display", "block")
            } else {
                $("#show_hide_mothertongue").css("display", "block");
                $("#show_hide_caste").css("display", "none")
            }
        } else {
            if (document.getElementById("loading_caste")) {
                if (A == "new_home_page") {
                    $("#loading_caste").html('<img src="' + C + '/imgs/loading.gif" align="absmiddle">')
                } else {
                    $("#loading_caste").html('<img src="' + C + '/imgs/loading.gif" align="absmiddle">')
                }
            }
            $("#show_hide_mothertongue").css("display", "block");
            $("#show_hide_caste").css("display", "block");
            $("#caste").css("display", "none");
            if (typeof B === "undefined") {
                B = ""
            }
            display_dropdown_caste_new(A, B, D)
        }
    }
}
function populate_caste(A) {
    clearTimeout(populateCasteTimer);
    populateCasteTimer = setTimeout(function () {
        var H = $("#" + A + " [name^=community]");
        var C = $("#" + A + " [name^=mothertongue]");
        var B = $("#" + A + " [name^=caste]");
        var E = $("#" + A + " [name^=gender]");
        if (E.length == 0) {
            E = $("#" + A + " [name^=hid_gender]")
        }
        var D = ($(H).val() == null) ? "" : $(H).val().join("|");
        var G = ($(C).val() == null) ? "" : $(C).val().join("|");
        var F = ($(B).val() == null) ? "" : $(B).val().join("|");
        D = (D == 0) ? "" : D;
        G = (G == 0) ? "" : G;
        F = (F == 0) ? "" : F;
        $("#show_hide_caste").show();
        $("#caste").empty();
        $("#caste").append('<option value="">Doesn\'t Matter</option>');
        if (((D && G) || (D)) && $(E).val()) {
            beforePopulateCaste();
            $.ajax({
                url: "/search/ajax/populate-caste?community=" + escape(D) + "&mothertongue=" + escape(G) + "&gender=" + escape($(E).val()) + "&caste=" + escape(F),
                success: function (I) {
                    if (!I) {
                        $("#show_hide_caste").hide();
                        afterPopulateCaste();
                        return false
                    }
                    $("#caste").replaceWith(I);
                    afterPopulateCaste()
                },
                error: function (K, I, J) {
                    $("#show_hide_caste").hide()
                }
            })
        } else {
            $("#show_hide_caste").hide()
        }
    }, 300)
}
function beforePopulateCaste() {
    if (!$("#ddOptHolderWrapper_caste .ddSelOptHolder").hasClass("ddLabelLoading")) {
        $("#ddOptHolderWrapper_caste .ddSelOptHolder").addClass("ddLabelLoading")
    }
}
function afterPopulateCaste() {
    $("#caste").dropdown({
        update: true, change: function (A) {
            if (A != undefined) {
                if (A == "") {
                    $("#caste > optgroup > option:selected").removeAttr("selected");
                    $("#caste option:first").attr("selected", "selected")
                } else {
                    $("#caste option:first").removeAttr("selected")
                }
            }
            $("input[name='castenobar'][value=No]").attr("checked", "checked")
        }
    })
}
function populate_state(B, A, C) {
    clearTimeout(populateStateTimer);
    populateStateTimer = setTimeout(function () {
        var J = $("#" + B + " [name^=countryofresidence]");
        var G = $("#" + B + " [name^=stateofresidence]");
        var E = $("#" + B + " [name^=nearest_city]");
        var H = ($(J).val() == null) ? "" : $(J).val().join("|");
        var F = ($(G).val() == null) ? "" : $(G).val().join("|");
        var D = ($(E).val() == null) ? "" : $(E).val().join("|");
        $("#state_only").show();
        $("#stateofresidence").empty();
        $("#stateofresidence").append('<option value="">Doesn\'t Matter</option>');
        $("#nearest_city").empty();
        $("#nearest_city").append('<option value="">Doesn\'t Matter</option>');
        $("#city_only").hide();
        if (H == "") {
            $("#state_only").hide();
            return false
        }
        var I = "/search/ajax/populate-states?country=" + escape(H) + "&state=" + escape(F);
        beforePopulateState();
        $.ajax({
            url: I, success: function (K) {
                if (!K) {
                    $("#state_only").hide();
                    afterPopulateState(B, "");
                    return false
                }
                $("#stateofresidence").replaceWith(K);
                afterPopulateState(B, D)
            }, error: function (M, K, L) {
                $("#state_only").hide();
                $("#city_only").hide()
            }
        })
    }, 300)
}
function beforePopulateState() {
    if (!$("#ddOptHolderWrapper_stateofresidence div.ddSelOptHolder").hasClass("ddLabelLoading")) {
        $("#ddOptHolderWrapper_stateofresidence div.ddSelOptHolder").addClass("ddLabelLoading")
    }
}
function afterPopulateState(B, A) {
    $("#stateofresidence").dropdown({
        update: true, change: function (C) {
            hideTGStatePopup();
            if (C != undefined) {
                if (C == "") {
                    $("#stateofresidence > optgroup > option:selected").removeAttr("selected");
                    $("#stateofresidence option:first").attr("selected", "selected")
                } else {
                    showTGStatePopup(C);
                    $("#stateofresidence option:first").removeAttr("selected")
                }
            }
            populate_city_bycountry_and_bystate(B, "")
        }
    });
    populate_city_bycountry_and_bystate(B, A)
}
function selectTGState() {
    $("#ddOptionHolder_stateofresidence li").each(function (A) {
        var B = unescape($(this).attr("rel"));
        if (B == "India:Telangana") {
            $(this).trigger("click")
        }
    });
    hideTGStatePopup()
}
function hideTGStatePopup() {
    if ($("#tool_top_d10tl").is(":visible")) {
        set_tooltip_timeout("tool_top_d10tl");
        dismissAlert({type: "tg_state_popup", permanent: true}, "tool_top_d10tl")
    }
}
function showTGStatePopup(B) {
    if (typeof SHOW_TG_STATE_POPUP != "undefined" && SHOW_TG_STATE_POPUP) {
        var A = unescape(B);
        if (A == "India:Andhra Pradesh") {
            setTimeout(function () {
                var C = false;
                $("#ddSelOptHolder_stateofresidence span").each(function (D) {
                    if ($(this).attr("rel") == "India:Telangana") {
                        C = true
                    }
                });
                if (!C) {
                    show_bubble_tool_tip_popup($("#ddSelOptHolder_stateofresidence").find("span[rel=" + A + "]"), "tool_top_d10tl")
                }
            }, 200)
        }
    }
}
function populate_annualincome_mapping() {
    var A = $("#basecurrency").val().toLowerCase();
    var B = $("#annualincome_" + A + "_from").val();
    var C = $("#annualincome_" + A + "_to").val();
    var D = "/search/ajax/populate-annualincome-mapping?basecurrency=" + escape(A) + "&annualincome_from=" + B + "&annualincome_to=" + C;
    set_manual_annualincome();
    populateAnnualIncomeTimer = setTimeout(function () {
        $.ajax({
            url: D, success: function (E) {
                if (!E) {
                    return false
                }
                afterPopulateAnnualincomeMapping($.parseJSON(E))
            }, error: function (G, E, F) {
            }
        })
    }, 200)
}
function afterPopulateAnnualincomeMapping(A) {
    $('select[id^="annualincome_"].income_section').each(function () {
        var B = $(this).attr("id").split("_");
        var D = B[1].toUpperCase();
        var C = B[2];
        if (A.hasOwnProperty(D) && A[D].hasOwnProperty(C) && A[D][C] != null) {
            $(this).val(A[D][C]).click()
        }
    })
}
function getCurrencyType(B) {
    var A = {India: "INR", Pakistan: "PKR", "United Kingdom": "GBP", "United Arab Emirates": "AED", Australia: "AUD"};
    B = $.trim(B);
    if (A[B]) {
        return A[B]
    } else {
        return "USD"
    }
}
function getAnnualIncomeCurrencyOrder() {
    var B = ["USD", "GBP", "INR", "AUD", "AED", "PKR"];
    B.reverse();
    var C = getCurrencyType($("#loggercountryofresidence").val());
    var A = $.inArray(C, B);
    if (A != -1) {
        B.splice(A, 1)
    }
    B.push(C);
    B.reverse();
    return B
}
function getCountryofresidenceCurrency() {
    var A = $("#ddSelOptHolder_countryofresidence").children("span").map(function () {
        return $(this).attr("rel")
    }).get();
    var B = [];
    $.map(A, function (C) {
        if (C != undefined && C != "") {
            var D = getCurrencyType(C);
            if ($.inArray(D, B) < 0) {
                B.push(D)
            }
        }
    });
    if (B.length == 0) {
        B = getAnnualIncomeCurrencyOrder()
    }
    B.reverse();
    return B
}
function show_annualincome() {
    var C = $('input[name^="annualincome_auto"]').is(":visible");
    var A = $("#ddSelOptHolder_countryofresidence").children("span").map(function () {
        if ($(this).attr("rel") != "") {
            return $(this).attr("rel")
        }
    }).get();
    if (A.length == 0) {
        $("#annualincome_applicable-").attr("checked", "checked");
        show_hide_annualincome()
    } else {
        var B = getCountryofresidenceCurrency();
        if (B.length > 1) {
            $("#annualincome_auto_container").show();
            if ($('input[name^="annualincome_auto"]').attr("checked")) {
                set_country_currency($("#basecurrency").val())
            } else {
                if (!C) {
                    set_manual_annualincome();
                    $('input[name^="annualincome_auto"]').attr("checked", true);
                    set_auto_annualincome()
                } else {
                    set_manual_annualincome()
                }
            }
        } else {
            set_manual_annualincome()
        }
    }
}
function set_manual_annualincome() {
    var A = getCountryofresidenceCurrency();
    $('div[id^="annualincome_manual_"]').hide();
    $('div[id^="annualincome_manual_"] .currency_country').show();
    $('div[id^="annualincome_manual_"] .basecurrency_holder').remove();
    if (A.length > 1) {
        $.map(A, function (D) {
            var B = $("#annualincome_" + D.toLowerCase() + "_from").val();
            var E = $("#annualincome_" + D.toLowerCase() + "_to").val();
            $('div[id^="annualincome_manual_' + D.toLowerCase() + '"]').show();
            var C = $('div[id^="annualincome_manual_' + D.toLowerCase() + '"]');
            $("#annualincome_container").after(C.clone());
            C.remove();
            $("#annualincome_" + D.toLowerCase() + "_from").val(B).click();
            $("#annualincome_" + D.toLowerCase() + "_to").val(E).click()
        });
        $("#annualincome_auto_container").show()
    } else {
        if (A.length == 0) {
            $('div[id^="annualincome_manual_' + getCurrencyType($("#loggercountryofresidence").val()).toLowerCase() + '"]').show()
        } else {
            $('div[id^="annualincome_manual_' + A.pop().toLowerCase() + '"]').show()
        }
        $("#annualincome_auto_container").hide();
        $('input[name^="annualincome_auto"]').attr("checked", false)
    }
}
function set_auto_annualincome() {
    var D = getCountryofresidenceCurrency();
    var A = getCurrencyType($("#loggercountryofresidence").val());
    if ($.inArray(A, D) > -1) {
        var B = "annualincome_manual_" + A.toLowerCase()
    } else {
        var B = "annualincome_manual_" + D.pop().toLowerCase()
    }
    if ($('input[name^="annualincome_auto"]').attr("checked")) {
        $('div[id^="annualincome_manual_"]').hide();
        $('div[id^="annualincome_manual_"] .currency_country').hide();
        $("#" + B).show();
        $('div[id^="' + B + '"] .currency_country').after($("#basecurrency_container_template").html());
        var C = $('div[id^="' + B + '"] .basecurrency_holder .income_section');
        $(C).attr("id", $(C).attr("id").replace("_template", ""));
        $(C).attr("name", $(C).attr("name").replace("_template", ""));
        set_country_currency(B.replace("annualincome_manual_", ""))
    } else {
        populate_annualincome_mapping()
    }
}
function change_basecurrency() {
    var B = $("#basecurrency").val().toLowerCase();
    $('div[id^="annualincome_manual_"]').hide();
    $('div[id^="annualincome_manual_"] .basecurrency_holder').remove();
    $('div[id^="annualincome_manual_' + B + '"]').show();
    $('div[id^="annualincome_manual_' + B + '"] .currency_country').hide();
    $('div[id^="annualincome_manual_' + B + '"] .currency_country').after($("#basecurrency_container_template").html());
    var A = $('div[id^="annualincome_manual_' + B + '"] .basecurrency_holder .income_section');
    $(A).attr("id", $(A).attr("id").replace("_template", ""));
    $(A).attr("name", $(A).attr("name").replace("_template", ""));
    set_country_currency(B)
}
function set_country_currency(A) {
    var B = getCountryofresidenceCurrency();
    $("#basecurrency option").remove();
    $("#basecurrency").html($("#basecurrency_template option").clone());
    $("#basecurrency option").each(function () {
        if ($.inArray($(this).val(), B) < 0) {
            $(this).remove()
        }
    });
    $("#basecurrency").val(A.toUpperCase())
}
function show_hide_annualincome() {
    var B = $("input[name=annualincome_applicable]:checked").val();
    if (B != undefined && B != "") {
        $("#annualincome_holder").show();
        var A = getCountryofresidenceCurrency();
        if (A.length > 1) {
            set_manual_annualincome();
            $('input[name^="annualincome_auto"]').attr("checked", true);
            set_auto_annualincome()
        }
        $('input[name^="annualincome_notspecified"]').attr("checked", true)
    } else {
        $("#annualincome_holder").hide();
        $.map($("select[id^='annualincome_']"), function (C) {
            if ($(C).attr("id").indexOf("_from") != -1) {
                $(C).val($(C).find("option:first-child").val()).click()
            } else {
                if ($(C).attr("id").indexOf("_to") != -1) {
                    $(C).val($(C).find("option:last-child").val()).click()
                }
            }
        })
    }
}
function fixAnnualIncomeRange() {
    $("select[id^='annualincome_']").die("click");
    $("select[id^='annualincome_']").live("click", function () {
        var A = $(this).attr("id");
        if (A.indexOf("_from") != -1) {
            var C = A.replace("_from", "_to");
            var B = $("#" + C).find("option[value='" + $(this).val() + "']");
            if (B.length > 0) {
                $("#" + C + " option").attr("disabled", "disabled");
                B.nextAll().removeAttr("disabled");
                if ($(this).val() == $("#" + C).val() || $("#" + C).find("option[value='" + $("#" + C).val() + "']").is(":disabled")) {
                    B.next().attr("selected", "selected")
                }
            } else {
                $("#" + C + " option").removeAttr("disabled")
            }
        }
    });
    $("select[id^='annualincome_']").click()
}
function populate_city_bycountry_and_bystate(A, B) {
    clearTimeout(populateCityTimer);
    populateCityTimer = setTimeout(function () {
        var E = $("#" + A + " [name^=stateofresidence]");
        var J = $("#" + A + " [name^=nearest_city]");
        var D = ($(E).val() == null) ? "" : $(E).val().join("|");
        var I = ($(J).val() == null) ? "" : $(J).val().join("|");
        B = (typeof B == "null" || typeof B == "undefined" || B == "") ? I : B;
        $("#city_only").show();
        $("#nearest_city").empty();
        $("#nearest_city").append('<option value="">Doesn\'t Matter</option>');
        if (D == "") {
            $("#city_only").hide();
            return false
        }
        if (D == "") {
            $("#city_only").hide();
            return false
        }
        var G = new Array();
        var K = new Array();
        var F = "";
        var H = 0;
        state_arr = D.split("|");
        $.each(state_arr, function (N, L) {
            L = $.trim(L);
            if (L != "") {
                var M = L.split(":");
                if ($.inArray(M[0], G) == -1) {
                    G[H] = M[0];
                    H++;
                    K[M[0]] = M[0] + "@" + M[1] + ","
                } else {
                    K[M[0]] += M[1] + ","
                }
            }
        });
        $.each(G, function (L, M) {
            M = $.trim(M);
            F += K[M] + "|"
        });
        var C = "/search/ajax/populate-city?state_str=" + escape(F) + "&city=" + escape(B);
        beforePopulateCity();
        $.ajax({
            url: C, success: function (L) {
                if (!L) {
                    $("#city_only").hide();
                    afterPopulateCity();
                    return false
                }
                $("#nearest_city").replaceWith(L);
                afterPopulateCity()
            }, error: function (L, N, M) {
                $("#city_only").hide()
            }
        })
    }, 300)
}
function beforePopulateCity() {
    if (!$("#ddOptHolderWrapper_nearest_city div.ddSelOptHolder").hasClass("ddLabelLoading")) {
        $("#ddOptHolderWrapper_nearest_city div.ddSelOptHolder").addClass("ddLabelLoading")
    }
}
function afterPopulateCity() {
    $("#nearest_city").dropdown({
        update: true, change: function (A) {
            if (A != undefined) {
                if (A == "") {
                    $("#nearest_city > optgroup > option:selected").removeAttr("selected");
                    $("#nearest_city option:first").attr("selected", "selected")
                } else {
                    $("#nearest_city option:first").removeAttr("selected")
                }
            }
        }
    })
}
function populate_working_as(C) {
    var B = $("#" + C + " [name^=occupation_area]");
    var A = ($(B).val() == null) ? "" : $(B).val().join("|");
    $("#occupation").empty();
    $("#occupation").append('<option value="">Doesn\'t Matter</option>');
    $("#working_as_div").show();
    if (A == "") {
        $("#working_as_div").hide();
        return false
    }
    var D = "/search/ajax/populate-working-as?strPA=" + escape(A);
    clearTimeout(populateWorkingAsTimer);
    beforePopulateWorkingAs();
    populateWorkingAsTimer = setTimeout(function () {
        $.ajax({
            url: D, success: function (E) {
                if (!E) {
                    $("#working_as_div").hide();
                    afterPopulateWorkingAs();
                    return false
                }
                $("#occupation").replaceWith(E);
                afterPopulateWorkingAs()
            }, error: function (G, E, F) {
                $("#working_as_div").hide()
            }
        })
    }, 500)
}
function beforePopulateWorkingAs() {
    if (!$("#ddOptHolderWrapper_workingas div.ddSelOptHolder").hasClass("ddLabelLoading")) {
        $("#ddOptHolderWrapper_workingas div.ddSelOptHolder").addClass("ddLabelLoading")
    }
}
function afterPopulateWorkingAs() {
    $("#occupation").dropdown({
        update: true, change: function (A) {
            if (A != undefined) {
                if (A == "") {
                    $("#occupation > optgroup > option:selected").removeAttr("selected");
                    $("#occupation option:first").attr("selected", "selected")
                } else {
                    $("#occupation option:first").removeAttr("selected")
                }
            }
        }
    })
}
function populate_caste_grid(G, F, E) {
    empty_left_grid("castearray");
    var H = [];
    var D = [];
    var C = false;
    if (E == "" || E == undefined) {
        $("input[name^='communityarray[]']").each(function () {
            H.push(this.value)
        })
    } else {
        H.push(E)
    }
    $("input[name^='communityarray_checkbox[]']").each(function () {
        $(this).attr("disabled", true)
    });
    $("input[name^='mothertonguearray[]']").each(function () {
        D.push(this.value)
    });
    $("input[name^='mothertonguearray_checkbox[]']").each(function () {
        $(this).attr("disabled", true)
    });
    show_grid_loading("castearray");
    $("#caste_only").removeClass("none");
    if (H.length < 1) {
        $("#loading_caste").html("");
        $("#caste_only").addClass("none");
        $("input[name^='communityarray_checkbox[]']").each(function () {
            $(this).attr("disabled", false)
        });
        $("input[name^='mothertonguearray_checkbox[]']").each(function () {
            $(this).attr("disabled", false)
        });
        $("#castenobar-No").attr("checked", true);
        check_castenobar();
        return false
    }
    var A = "";
    var B = "";
    if (D) {
        B = D.join("|")
    }
    if (H) {
        A = H.join("|")
    }
    if (((A && B) || (A)) && $("#gender").val()) {
        $.ajax({
            url: "/ajax/show-mt-caste?community=" + escape(A) + "&mothertongue=" + escape(B) + "&gender=" + escape($("#gender").val()),
            success: function (N) {
                if (!N) {
                    $("#loading_caste").html("");
                    return false
                }
                N = N.replace("<br><b>&nbsp;No matches</b><br><br><br>", "");
                splitString = N.split("|");
                var J = new Array();
                var I = new Array();
                var M = new Array();
                var L = "";
                var P = "";
                var K = 0;
                $.each(splitString, function (R, S) {
                    S = $.trim(S);
                    if (S.indexOf("@") == -1 && S != "") {
                        var Q = S.split(":");
                        if ($.inArray(Q[0], J) == -1) {
                            J[K] = Q[0];
                            K++;
                            I[Q[0]] = Q[0] + "@" + Q[1] + "|";
                            M[Q[0]] = ""
                        } else {
                            I[Q[0]] += Q[1] + "|"
                        }
                        M[Q[0]] += S + "|"
                    }
                });
                $.each(J, function (R, Q) {
                    Q = $.trim(Q);
                    P += I[Q];
                    L += M[Q]
                });
                var O = get_no_caste_religion_response(A, "Y");
                if (O != "") {
                    no_caste_rel_str_arr = O.split("!#!");
                    P += no_caste_rel_str_arr[0];
                    L += no_caste_rel_str_arr[1]
                }
                if (P.substring(P.length - 1, P.length) == "|") {
                    P = P.slice(0, -1)
                }
                populate_multiselect_grid("castearray", P, F, L);
                hide_grid_loading("castearray");
                $("input[name^='communityarray_checkbox[]']").each(function () {
                    $(this).attr("disabled", false)
                });
                $("input[name^='mothertonguearray_checkbox[]']").each(function () {
                    $(this).attr("disabled", false)
                });
                check_castenobar()
            },
            error: function (I, K, J) {
                hide_grid_loading("castearray");
                $("#caste_only").addClass("none")
            }
        })
    }
}
function get_no_caste_religion_response(B, D) {
    var E = "";
    var C = "";
    var A = "";
    if (D == "Y") {
        if (B.search(/spiritual/i) > -1) {
            E += "Spiritual@Spiritual - not religious|";
            C += "Spiritual - not religious|"
        }
        if (B.search(/other/i) > -1) {
            E += "Other@Other|";
            C += "Other|"
        }
        if (B.search(/no religion/i) > -1) {
            E += "No Religion@No Religion|";
            C += "No Religion|"
        }
        if (B.search(/jewish/i) > -1) {
            E += "Jewish@Jewish|";
            C += "Jewish|"
        }
        if (B.search(/buddhist/i) > -1) {
            E += "Buddhist@Buddhist|";
            C += "Buddhist|"
        }
        if (B.search(/parsi/i) > -1) {
            E += "Parsi@Parsi|";
            C += "Parsi|"
        }
        if (E != "") {
            A += E + "!#!" + C
        }
    } else {
        if (B.search(/spiritual/i) > -1) {
            E += "Spiritual@|Spiritual - not religious|"
        }
        if (B.search(/other/i) > -1) {
            E += "Other@|Other|"
        }
        if (B.search(/no religion/i) > -1) {
            E += "No Religion@|No Religion|"
        }
        if (B.search(/jewish/i) > -1) {
            E += "Jewish@|Jewish|"
        }
        if (B.search(/buddhist/i) > -1) {
            E += "Buddhist@|Buddhist|"
        }
        if (B.search(/parsi/i) > -1) {
            E += "Parsi@|Parsi|"
        }
        if (E.substring(E.length - 1, E.length) == "|") {
            E = E.slice(0, -1)
        }
        A = E
    }
    return A
}
function check_castenobar(A) {
    if (A.value == "Yes") {
        $("select[name^='caste'] > optgroup > option:selected").attr("selected", false);
        $("select[name^='caste']").find("option[value='']").attr("selected", "selected");
        $("#caste").dropdown({
            update: true, change: function (B) {
                if (B != undefined) {
                    if (B == "") {
                        $("#caste > optgroup > option:selected").removeAttr("selected");
                        $("#caste option:first").attr("selected", "selected")
                    } else {
                        $("#caste option:first").removeAttr("selected")
                    }
                }
                $("input[name='castenobar'][value=No]").attr("checked", "checked")
            }
        })
    }
}
function InArray(A, C) {
    for (var B = 0; B < A.length; B++) {
        if (A[B] == C) {
            return B
        }
    }
    return -1
}
function clear_city() {
    if ($("#city_only").length > 0) {
        $("#city_only").addClass("none")
    }
}
function empty_mt_caste() {
    $("#caste").val("")
}
function show_action_links(A) {
    $("#action_links_" + A).css("display", "block");
    $("#action_links_div_" + A).html('<a href="javascript:void(0);" onclick="hide_action_links(\'' + A + '\');" class="collapse_arrow_ic"></a>')
}
function hide_action_links(A) {
    $("#action_links_" + A).css("display", "none");
    $("#action_links_div_" + A).html('<a href="javascript:void(0);" onclick="show_action_links(\'' + A + '\');" class="expand_arrow_ic"></a>')
}
function get_my_saved_searches() {
    var B = random_string();
    var A = get_saved_search_loader_html();
    $("#my_saved_searches_content").html(A);
    $.ajax({
        type: "POST", data: "", url: "/search/index/my-saved-searches/rand/" + B, success: function (C) {
            $("#my_saved_searches_content").html(C)
        }, error: function (C, E, D) {
            $("#my_saved_searches_content").html("");
            $("#my_saved_searches_content").removeClass("none")
        }
    })
}
function delete_saved_search(A) {
    var C = A.searchname;
    var D = A.encSearchname;
    if (confirm('Delete Search: "' + C + ' "  Are you sure?')) {
        var B = random_string();
        loader_html = get_saved_search_loader_html();
        $("#my_saved_searches_content").html(loader_html);
        $.ajax({
            type: "POST",
            url: "/search/saved-search/delete/rand/" + B,
            data: {savedsearch_name: D},
            success: function (E) {
                setTimeout("get_my_saved_searches()", 2000)
            },
            error: function (E, G, F) {
            }
        })
    }
}
function delete_saved_search_from_list(C, A) {
    var B = A.searchname;
    var F = A.id;
    var E = A.encSearchname;
    if (confirm('Delete Search: "' + B + '"  Are you sure?')) {
        var D = {};
        D.savedsearch_name = E;
        D.rand = random_string();
        $("#container_" + F).after('<div class="del_search_container loader bg_pos_cc"></div>');
        $("#container_" + F).addClass("none");
        $.ajax({
            type: "GET", url: "/search/saved-search/delete", data: D, success: function (G) {
                if (G == "success") {
                    setTimeout(function () {
                        $("#container_" + F).siblings(".del_search_container").remove();
                        $("#container_" + F).remove();
                        $("#max_saved_search").remove();
                        if ($(".save_search_container").length < 1) {
                            $("#zero_saved_search").removeClass("none")
                        }
                    }, 500)
                } else {
                    alert("Unexpected error occurred!");
                    $("#container_" + F).removeClass("none");
                    $("#container_" + F).siblings(".del_search_container").remove()
                }
            }, error: function (G, I, H) {
                alert("Unexpected error occurred!");
                $("#container_" + F).removeClass("none");
                $("#container_" + F).siblings(".del_search_container").remove()
            }
        })
    }
}
function change_saved_search_frequency(B, D, A) {
    var C = {};
    C.savedsearch_name = A;
    C.frequency = $(B).val();
    C.rand = random_string();
    $(B).attr("disabled", "disabled");
    $("#frequency_loader_" + D).removeClass("none");
    $.ajax({
        type: "POST",
        url: "/search/saved-search/change-frequency",
        data: C,
        dataType: "json",
        success: function (E) {
            if (E.status == "success") {
                $("#frequency_status_" + D).html("Email frequency has changed");
                $("#frequency_status_" + D).show()
            } else {
                $("#frequency_status_" + D).html("Unexpected error occurred!");
                $("#frequency_status_" + D).show()
            }
            hide_out("#frequency_status_" + D);
            $("#frequency_loader_" + D).addClass("none");
            $(B).removeAttr("disabled")
        },
        error: function (E, G, F) {
            $("#frequency_status_" + D).html("Unexpected error occurred!");
            $("#frequency_status_" + D).show();
            hide_out("#frequency_status_" + D);
            $("#frequency_loader_" + D).addClass("none");
            $(B).removeAttr("disabled")
        }
    })
}
function bind_state_events() {
    $("input[name^='stateofresidencearray_checkbox[]']").each(function () {
        $("#" + this.id).bind({
            click: function () {
                populate_state_grid("smart", "")
            }
        })
    })
}
function check_doesnt_matter_checkbox(A, B) {
    if (B == "") {
        $("input[name^='" + A + "']").each(function () {
            if (this.value != "") {
                $(this).attr("checked", false)
            }
        })
    } else {
        $("input[name^='" + A + "']").each(function () {
            if (this.value == "") {
                $(this).attr("checked", false)
            }
        })
    }
}
function get_saved_search_loader_html() {
    html = '<div class="loader" style="height:50px; background-position:center center;"></div>';
    return html
}
function cls(A) {
    A.value = "";
    return
}
function set_advance_search() {
    empty_advance_form_elements();
    if ($("#advance_form").attr("class") == "none") {
        $("#advance_form").removeClass("none");
        $("#advance_form").addClass("wrap_2");
        $("#ex_co_btn").removeClass("expand_ic");
        $("#ex_co_btn").addClass("collapse_ic")
    } else {
        $("#advance_form").removeClass("wrap_2");
        $("#advance_form").addClass("none");
        $("#ex_co_btn").removeClass("collapse_ic");
        $("#ex_co_btn").addClass("expand_ic")
    }
}
function empty_advance_form_elements() {
    $("#smokearray-").attr("checked", true);
    $("#specialcases-").attr("checked", true);
    $("#hiv_positive-No").attr("checked", true);
    $("#manglikarray-").attr("checked", true);
    $("input[name^='postedbyarray[]']").each(function () {
        if ($(this).val() == "") {
            $(this).attr("checked", true)
        } else {
            $(this).attr("checked", false)
        }
    });
    $("input[name^='bodytypearray[]']").each(function () {
        if ($(this).val() == "") {
            $(this).attr("checked", true)
        } else {
            $(this).attr("checked", false)
        }
    });
    $("input[name^='complexionarray[]']").each(function () {
        if ($(this).val() == "") {
            $(this).attr("checked", true)
        } else {
            $(this).attr("checked", false)
        }
    });
    $("input[name^='dietarray[]']").each(function () {
        if ($(this).val() == "") {
            $(this).attr("checked", true)
        } else {
            $(this).attr("checked", false)
        }
    });
    $("input[name^='drinkarray[]']").each(function () {
        if ($(this).val() == "") {
            $(this).attr("checked", true)
        } else {
            $(this).attr("checked", false)
        }
    });
    clear_grid("occupationarray");
    clear_grid("education_area_array")
}
function expand_advance_form() {
    var A = false;
    if (!($("#smokearray-").attr("checked"))) {
        A = true
    }
    if (!($("#specialcases-").attr("checked"))) {
        A = true
    }
    if (!($("#hiv_positive-No").attr("checked"))) {
        A = true
    }
    if (!($("#manglikarray-").attr("checked"))) {
        A = true
    }
    $("input[name^='postedbyarray[]']").each(function () {
        if ($(this).val() == "") {
            if (!($(this).attr("checked"))) {
                A = true
            }
        }
    });
    $("input[name^='bodytypearray[]']").each(function () {
        if ($(this).val() == "") {
            if (!($(this).attr("checked"))) {
                A = true
            }
        }
    });
    $("input[name^='complexionarray[]']").each(function () {
        if ($(this).val() == "") {
            if (!($(this).attr("checked"))) {
                A = true
            }
        }
    });
    $("input[name^='dietarray[]']").each(function () {
        if ($(this).val() == "") {
            if (!($(this).attr("checked"))) {
                A = true
            }
        }
    });
    $("input[name^='drinkarray[]']").each(function () {
        if ($(this).val() == "") {
            if (!($(this).attr("checked"))) {
                A = true
            }
        }
    });
    if ($("#occupationarray-dm").length > 0) {
    } else {
        A = true
    }
    if ($("#education_area_array-dm").length > 0) {
    } else {
        A = true
    }
    if (A) {
        $("#advance_form").removeClass("none");
        $("#advance_form").addClass("wrap_2");
        $("#ex_co_btn").removeClass("expand_ic");
        $("#ex_co_btn").addClass("collapse_ic")
    }
}
function show_city_grid() {
    if ($("#searchby-city").length > 0) {
        if ($("#searchby-city").attr("checked") && !$("#searchby-city").attr("disabled")) {
            $("#city_only").removeClass("none")
        } else {
            $("#city_only").addClass("none")
        }
    } else {
        $("#city_only").removeClass("none")
    }
}
function show_grid_loading(A) {
    $("#" + A + "_grid_loading").html('<img src="' + IMG_PATH + '/imgs/profiles/ver2/loading.gif" height="15" width="15" border="0" alt="Loading" title="Loading"><br clear="all" />');
    $("#" + A + "_grid_data").removeClass("fl mrg_lf");
    $("#" + A + "_grid_data").addClass("none")
}
function hide_grid_loading(A) {
    $("#" + A + "_grid_loading").html("");
    $("#" + A + "_grid_data").removeClass("none");
    $("#" + A + "_grid_data").addClass("fl mrg_lf")
}
function enable_disable_city_checkbox(D, C) {
    $("#searchby-city").attr("disabled", true);
    var B = "";
    var A = "";
    if (typeof D != "undefined" && D != null) {
        B = D
    }
    if (typeof C != "undefined" && C != null) {
        A = C
    }
    if (B != "") {
        if (B == "India" || B == "USA") {
            if (A != "") {
                $("#searchby-city").attr("disabled", false)
            }
        } else {
            $("#searchby-city").attr("disabled", false)
        }
    }
}
function check_uncheck_city_checkbox(E, C) {
    $("#searchby-city").attr("checked", false);
    $("#city_only").addClass("none");
    var B = "";
    var A = "";
    var D = "";
    if (typeof E != "undefined" && E != null) {
        B = E
    }
    if (typeof C != "undefined" && C != null) {
        A = C
    }
    if (B != "") {
        if (B == "India" || B == "USA") {
            if (A != "") {
                $("#searchby-city").attr("checked", true);
                $("#city_only").removeClass("none")
            }
        } else {
            $("#searchby-city").attr("checked", true);
            $("#city_only").removeClass("none")
        }
    }
}
function enable_disable_caste_checkbox() {
    $("#searchby-caste").attr("disabled", true);
    var A = $("#community").val();
    if (A != "") {
        $("#searchby-caste").attr("disabled", false)
    }
}
function set_caste_no_bar() {
    if ($("#castearray-dm").length > 0) {
        $("#castearray-dm").html('<input type="hidden" name="castenobar" value="Yes">&nbsp;Doesn\'t Matter / Caste (Sect) &nbsp;No Bar')
    }
}
function check_special_cases(B) {
    var A = "Physically challenged from birth|Physically challenged due to accident|Mentally challenged from birth|Mentally challenged due to accident|Physical abnormality affecting only looks|Physical abnormality affecting bodily functions|Physically and mentally challenged|HIV positive";
    var C = A.replace(/\|/g, "");
    C = C.replace(/ /g, "");
    if (typeof B == "undefined") {
        B = ""
    }
    all_checked = true;
    if (B == A) {
        if ($("#specialcasesarray-" + C).attr("checked")) {
            $("input[name^='specialcasesarray[]']").each(function () {
                $(this).attr("checked", true)
            })
        } else {
            $("input[name^='specialcasesarray[]']").each(function () {
                $(this).attr("checked", false)
            })
        }
    } else {
        $("input[name^='specialcasesarray[]']").each(function (D, E) {
            if (D > 0) {
                if (!$(this).attr("checked")) {
                    all_checked = false
                }
            }
        });
        if (all_checked) {
            $("#specialcasesarray-" + C).attr("checked", true)
        } else {
            $("#specialcasesarray-" + C).attr("checked", false)
        }
    }
}
function show_hide_caste_dropdown() {
    if ($("#searchby-caste").length > 0) {
        if ($("#searchby-caste").attr("checked")) {
            $("#show_hide_caste").removeClass("none")
        } else {
            $("#show_hide_caste").addClass("none")
        }
    }
}
function check_veg_nonveg() {
    if ($("#dietarray-NonVeg").is(":checked") || $("#dietarray-Veg").is(":checked")) {
        $('#dietarray-Eggetarian, label[for="dietarray-Eggetarian"]').show()
    } else {
        $('#dietarray-Eggetarian, label[for="dietarray-Eggetarian"]').hide();
        $("#dietarray-Eggetarian").attr("checked", false)
    }
}
function set_manglik_options(A) {
    if (A != "") {
        $("#manglikdiv2").css("display", "block");
        $('input[name^="manglik_dontknow"]').attr("checked", true)
    } else {
        $("#manglikdiv2").css("display", "none");
        $('input[name^="manglik_dontknow"]').attr("checked", true)
    }
}
function hide_out(A) {
    setTimeout("$('" + A + "').css('display','none')", 5000)
}
function cancel_delete(A) {
    $("#confirm_del_" + A).addClass("none");
    $("#delete_" + A).show()
}
function confirm_delete(A) {
    $("#confirm_del_" + A).removeClass("none");
    $("#delete_" + A).hide()
}
function selectFrequency() {
    var A = "daily";
    if ($("#exsitingsearches").val() != "") {
        A = saved_search_frequencies[$("#exsitingsearches").val()]
    }
    $("#frequency-" + A).attr("checked", "checked")
}
function toggleSavedSearchFields(B) {
    if (typeof member_gender == "undefined") {
        return
    }
    var A = $.trim($(B).val());
    if (member_gender.toLowerCase() == A.toLowerCase()) {
        $("p.save_src").hide();
        $("#saved_search_elements").hide()
    } else {
        $("p.save_src").show();
        $("#saved_search_elements").show()
    }
}
function toggleAgeByGender(C) {
    var A = $.trim($(C).val());
    var B = [20, 19, 18];
    $.each(B, function (E, D) {
        if (A.toLowerCase() == "male") {
            $("#agefrom").children("option[value=" + D + "]").remove();
            $("#ageto").children("option[value=" + D + "]").remove()
        } else {
            if ($("#agefrom").children("option[value=" + D + "]").length <= 0) {
                $("#agefrom").prepend('<option value="' + D + '" label="' + D + '">' + D + "</option>");
                $("#ageto").prepend('<option value="' + D + '" label="' + D + '">' + D + "</option>")
            }
        }
    });
    $("#agefrom option:first").attr("selected", "selected")
}
function showHideManglik() {
    var A = false;
    $("#community option:selected").each(function () {
        if ($(this).val() == "Hindu" || $(this).val() == "Jain") {
            A = true
        }
    });
    if (A) {
        $("#show_hide_manglik").show()
    } else {
        $("#show_hide_manglik").hide()
    }
}
function showHideGotra() {
    if (!$("#show_hide_gotra").length) {
        return
    }
    var A = false;
    $("#community option:selected").each(function () {
        if ($(this).val() == "Hindu" || $(this).val() == "Jain") {
            A = true
        }
    });
    if (A) {
        $("#show_hide_gotra").show()
    } else {
        $("#show_hide_gotra").hide()
    }
}
function setClick(A) {
    if ($(A).val() == "") {
        $("input[name=" + $(A).attr("name") + "]").each(function (B) {
            if ($(this).val() != "") {
                $(this).attr("checked", false)
            }
        })
    } else {
        $("input[name=" + $(A).attr("name") + '][value=""]').attr("checked", false)
    }
    if ($("input[name=" + $(A).attr("name") + "]:checked").length == 0) {
        $("input[name=" + $(A).attr("name") + '][value=""]').attr("checked", true)
    }
}
function onFocusKeyword(A) {
    if ($(A).val() == "e.g. MBA, traditional, music, etc") {
        $(A).val("")
    }
}
function onBlurKeyword(A) {
    if (!$(A).val()) {
        $(A).val("e.g. MBA, traditional, music, etc")
    }
}
var hideFreeSearchTooltipid = 0;
var freemembershipTip = 0;
function showFreeSearchTooltip(D) {
    if (hideFreeSearchTooltipid) {
        return
    }
    var C = $(".photo_setting_lock");
    C.addClass("photo_setting_lock_hover");
    $.shactivity.drawPopUp("premuimSearchTooltip");
    $("#premuimSearchTooltip #pop_inner_content").html($("#freeupgradeSearch").html());
    var B = 330;
    var A = (parseInt($(".pop").css("padding-left")) * 2) + (parseInt($(".pop").css("border-left-width")) * 2);
    var E = $.shactivity.elementPosition(C, A);
    $("#premuimSearchTooltip #pop_inner_content .pop_pointer_left").css({top: $("#premuimSearchTooltip").outerHeight(true) / 2 - 17 + "px"});
    freemembershipTip = setTimeout(function () {
        $("#premuimSearchTooltip").css({
            top: ((E.top) - $("#premuimSearchTooltip").outerHeight(true) / 2 + 17) + "px",
            width: B + "px",
            left: E.left + 30 + "px"
        }).show();
        hideFreeSearchTooltipid = setTimeout(function () {
            hideFreeSearchTooltip(this)
        }, 30000)
    }, 200);
    $("#premuimSearchTooltip").find(".popclose").click(function (F) {
        F.preventDefault();
        $(".photo_setting_lock").unbind("mouseover");
        hideFreeSearchTooltip(this);
        return false
    })
}
function hideFreeSearchTooltip(A) {
    clearTimeout(freemembershipTip);
    clearTimeout(hideFreeSearchTooltipid);
    $(".photo_setting_lock").removeClass("photo_setting_lock_hover");
    $("#premuimSearchTooltip").hide();
    hideFreeSearchTooltipid = 0
}
$(document).ready(function () {
    if (typeof hideFreeMembershipTooltip !== "undefined") {
        hideFreeMembershipTooltip({})
    }
    $(".photo_settings_disabled :input").attr("disabled", true)
});
function deleteCltCookie() {
    $.cookie("clt", "", {expires: -1, path: "/"})
};