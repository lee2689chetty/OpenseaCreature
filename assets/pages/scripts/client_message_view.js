/**
 * Created by rock on 1/19/18.
 */
var currentChatId = 0;
var ContactListInit = function() {
    var HandleContactListInit = function() {
        $('div.item').on('click', function(e){
            $(this).find( $( "span.item-status" )).hide();
            e.preventDefault();
            App.blockUI({
                target:'#chats',
                animate:true
            });
            //block UI
            currentChatId = $(this).data('value');
            var formData = new FormData();
            formData.append("threadId", currentChatId);
            var getHistoryHandler = $.ajax({
                url: "../message/getHistory",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            getHistoryHandler.done(function (msg) {
                App.unblockUI('#chats');
                var jsonValue = JSON.parse(msg);
                UpdateNecessaryViewHandler.UpdateNecessaryViews(jsonValue);
            });

            getHistoryHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#chats');
            });

        });
    };

    var HandleSendInit = function() {
        $('#btSend').on('click', function(e){
            e.preventDefault();
            if($("#txtMessageContent").val() === "")
            {
                return;
            }
            if(currentChatId === 0)
            {
                return;
            }
            App.blockUI({
                target:'#chats',
                animate:true
            });


            //block UI
            var formData = new FormData();
            formData.append("threadId", currentChatId);
            formData.append("msgContent", $("#txtMessageContent").val());
            var getHistoryHandler = $.ajax({
                url: "../message/appendMessage",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            getHistoryHandler.done(function (msg) {
                App.unblockUI('#chats');
                var jsonValue = JSON.parse(msg);
                UpdateNecessaryViewHandler.AppendChatItem(jsonValue);
            });

            getHistoryHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#chats');
            });

        });
    };

    return {
        init: function() {
            HandleContactListInit();
            HandleSendInit();
        }
    };
}();


var UpdateNecessaryViewHandler = function()
{

    var UpdateNecessaryViews = function(jsonStringValue) {
        $("#containerChat li").remove();
        for(i = 0 ; i < jsonStringValue.length; i++)
        {
            $("#containerChat").append(jsonStringValue[i]);
        }
        var cont = $('#chats');
        var list = $('.chats', cont);
        GotoBottomOfScroll(list);
    };
    var AppendNecessaryViews = function(jsonStringValue) {

        var cont = $('#chats');
        var list = $('.chats', cont);
        var msg = list.append(jsonStringValue.result);
        GotoBottomOfScroll(list);
    };

    return {
        UpdateNecessaryViews: function(jsonStringValue){
            UpdateNecessaryViews(jsonStringValue);
        },
        AppendChatItem:function(jsonStringValue){
            AppendNecessaryViews(jsonStringValue);
        }
    }
}();

var GotoBottomOfScroll = function(list)
{
    var cont = $('#chats');
    var form = $('.chat-form', cont);
    var input = $('input', form);
    var btn = $('.btn', form);

    // var msg = list.append(jsonStringValue.result);
    $("#txtMessageContent").val("");

    var getLastPostPos = function() {
        var height = 0;
        cont.find("li.out, li.in").each(function() {
            height = height + $(this).outerHeight();
        });

        return height;
    };

    cont.find('.scroller').slimScroll({
        scrollTo: getLastPostPos()
    });
};
jQuery(document).ready(function() {
    ContactListInit.init();
});