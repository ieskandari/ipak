function key_up_select_input(obj) {
    var parent = obj.parent();
    var img = parent.children('img').eq(0);

    var element = parent.children('select').eq(0);
    document.getElementById(element.attr('id')).size = 5;
    count_click_live++;

    setTimeout(function () {
        count_click_live_send++;
        if (count_click_live_send == count_click_live) {
            img.css('display', 'block');
            var url=BaseUrl+element.attr('just-plugin')+'/'+ element.attr('just-model')+'?api_select=' + element.attr('model-name') + '&has_parent_json_field=' + element.attr('has-parent-json-field') + '&has_parent_json=' + element.attr('has-parent-json') + '&field_key=' + element.attr('field-key') + '&just_plugin=' + element.attr('just-plugin') + '&just_model=' + element.attr('just-model') + '&field_name=' + element.attr('field-name') + '&field_id=' + element.attr('field-id') + '&word=' + obj.val();      
            $.ajax({
                type: 'POST',
                url: url,
                data: {},
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (msg) {
                    var jss = msg;
                    element.html('<option value="0">خالی</option>');
                    var flag = 0;
                    jss.forEach(function (item, index) {
                        element.append('<option title=\"' + item.name + '\" value=\"' + item.id + '\">' + item.name + '</option>');
                    });
                    img.css('display', 'none');
                },
                error: function (error) {
                    //Message
                    console.error(error.responseText);
                }
            });
        }
    }, 1000);
}
var start_select_init_dropdown = 0;
var dropdown_option_changed_flag = 0;
var dropdown_option_changed_flag_body = 0;
var dropdown_option_changed_flag_show = 0;
var element_dropdown_option_changed;

function dropdown_option_changed(obj) {

    dropdown_option_changed_flag = 1;
   // console.log('s1:'+dropdown_option_changed_flag);
    dropdown_option_changed_flag_show = 0;
    var parent = obj.parent();
    var element = parent.children('input').eq(0);
    element.css('display', 'none');
    parent.children('i').eq(0).css('display', 'none');
    obj.css('top', '0px');
    obj.css('z-index', '1000');
    document.getElementById(obj.attr('id')).size = 1;
    var img = parent.children('img').eq(0);
    input = parent.children('input').eq(0);
    img.css('display', 'none');
    input.val('');
}

function dropdown_on_click(obj) {
  //  console.log('s2:'+dropdown_option_changed_flag);
    if (dropdown_option_changed_flag == 0) {
        var list = $('.parent-select-dropdown select');
        for (var i = 0; i < list.length; i++) {
            dropdown_option_changed($('.parent-select-dropdown select').eq(i));
        }

        
        var parent = obj.parent();
        var element = parent.children('input').eq(0);
        element.css('display', 'block');
        element.focus();
        parent.children('i').eq(0).css('display', 'block');
        obj.css('top', '28px');
        obj.css('z-index', '1001');
        document.getElementById(obj.attr('id')).size = 5;
        dropdown_option_changed_flag_show = 1;
        
    }
    dropdown_option_changed_flag = 0;
    dropdown_option_changed_flag_body = 1;
    element_dropdown_option_changed = obj;
    start_select_init_dropdown=1;
}
var count_click_live = 0;
var count_click_live_send = 0;
function dropdown_input_select(obj) {
    count_click_live = 0;
    count_click_live_send = 0;
    dropdown_option_changed_flag_body = 1;
}
$(document).ready(function () {
    $("body").click(function () {
       // console.log('s3');
        if (dropdown_option_changed_flag_body == 0 && dropdown_option_changed_flag_show == 1) {
            var list = $('.parent-select-dropdown select');
            for (var i = 0; i < list.length; i++) {
                dropdown_option_changed($('.parent-select-dropdown select').eq(i));
            }
            dropdown_option_changed_flag_show = 0;
        }
        dropdown_option_changed_flag = 0;
        dropdown_option_changed_flag_body = 0;
    });
});