<?php
global $CONFIG;
if (elgg_is_logged_in()) {
    echo elgg_view('enlightn/discussion_edit');
    echo elgg_view('input/uploadForm');
    $user_ent = elgg_get_logged_in_user_entity();
    //echo elgg_view('input/media_autocomplete');
}
$en_plugin          = elgg_get_calling_plugin_entity();
?>
    <div class="dialog-overlay"></div>
    <div id="footer">
        <?php echo elgg_view('expages/footer_menu');?>
        <div class="copyright">Enlightn - <?php /*echo $en_plugin->getManifest()*/?></div>
    </div>
    <?php if(elgg_is_logged_in()) { ?>
     <div id="debug"></div>
    <?php }
    if (elgg_get_plugin_setting('chat_activated','enlightn')==1) {
    ?>
<script>

$(document).ready(function(){
                var jid = '<?php echo $user_ent->username ?>@<?php echo $vars['config']->sitename ?>';
		var password ='<?php echo $user_ent->password;?>';
		var logContainer = $("#log");
		var contactList = $("#contacts");

		//An example of bosh server. This site is working but it can change or go down.
		//If you are going to have a production site, you must install your own BOSH server
		var url ="<?php echo $vars['url']?>http-bind/";

		var xmpp = $.xmpp.connect({url:url, jid: jid, password: password,
			onConnect: function(){
                            $.xmpp.setPresence(null);
			},
			onPresence: function(presence){
                                var split = presence.from.split('@'),
                                    username = split[0],
                                    loggedUserList = contactList.find('li'),
                                    loggedUsername = new Array();
                                loggedUserList.each(function () {
                                    loggedUsername.push($(this).attr('data-username'));
                                });
                                if(!loggedUsername.in_array(username) && presence.show != "unavailable") {
                                    var contact = $("<li data-username=" + username +">");
                                    contact.append("<span class=\"ico\"/>"+ username +"");
                                    contact.click(function(){
                                                    var id = MD5.hexdigest(username);
                                                    var conversation = $("#"+id);
                                                    if(conversation.length == 0)
                                                            openChat({to:presence.from});
                                    });
                                    contactList.append(contact);
                                } else if (presence.show == "unavailable") {
                                    $.each(contactList.find("li"),function(i,element){
                                            try{
                                                var e = $(element);
                                                    if(e.attr("data-username") == username && username != '<?php echo $user_ent->username;?>') {
                                                        e.remove();
                                                    } else if (username == '<?php echo $user_ent->username;?>') {
                                                        $.xmpp.setPresence(null);
                                                    }
                                            } catch(e){}
                                    });
                                }
			},
			onDisconnect: function() {
				logContainer.html("Disconnected");
			},
			onMessage: function(message){
				var jid = message.from.split("/");
				var id = MD5.hexdigest(message.from),
                                                split = message.from.split('@'),
                                                username = split[0];
				var conversation = $("#chat_"+username);
				if(conversation.length == 0){
					openChat({to:message.from});
				}
				conversation = $("#chat_"+username);
				conversation.find(".conversation").append("<div>"+ username +": "+ message.body +"</div>").animate({ scrollTop: conversation.prop('scrollHeight') });
			},onError:function(error){
				alert(error.error);
			}
		});

	$("#disconnectBut").click(function(){
		$.xmpp.disconnect();
	});
        $(window).unload( function () { $.xmpp.disconnect(); } );

    function openChat(options){
            var id = MD5.hexdigest(options.to),
                        split = options.to.split('@'),
                        username = split[0],
                        chatOpen = $("body").find('.chat'),
                        chat = $("#chat_"+username);
            chatOpen.each(function () {
                pos = $(this).offset();
            });
            if(typeof elmLeft == 'undefined') {
                pos = $("#presence").offset();
            }
            elmLeft = (pos.left - 183) + 'px';
            if(chat.length == 0){
                var chat = $('<div class="chat" style="left : ' + elmLeft + '">\n\
                                <div class="header"><span class="close">&times;</span>'+username+'</div>\n\
                                <div class="content" id="chat_'+username+'">\n\
                                    <div style="overflow: auto;max-height : 200px;height : 100%" class="conversation"></div><textarea />\n\
                                </div>\n\
                            </div>');
                var conversation = chat.find(".conversation"),
                        input = chat.find("textarea"),
                        close = chat.find(".close");
                input.keyup(function(e){
                    if(e.keyCode == 13) {
                            $.xmpp.sendMessage({to:options.to, body: input.val()});
                            split = $.xmpp.jid.split('@');
                            username = split[0];
                            conversation.append("<div>"+ username +": "+ input.val() +"</div>");
                            input.val("");
                            conversation.animate({ scrollTop: conversation.prop('scrollHeight') });
                    }
                });
                close.click( function(){
                    chat.remove();
                });
                $("body").append(chat);
                chat.draggable({
                        drag: function () {

                        }
                    });
            } else {
                var input = chat.find("textarea");
            }
            input.focus();
    }

});


</script>
<div id="presence">
    <div class="header">Chat</div>
    <ul id="contacts"></ul>
</div>
<?php
    }
?>
</body>
</html>