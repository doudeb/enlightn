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
        $jabber_host_name = pathinfo($vars['config']->url,PATHINFO_BASENAME);
    ?>
<script>

$(document).ready(function(){
    var jid = '<?php echo strtolower($user_ent->username) ?>@<?php echo $jabber_host_name ?>';
    var password ='<?php echo $user_ent->password;?>';
    var contactList = $("#contacts");
    var sid = getCookie('sid');
    var rid = getCookie('rid');


    //An example of bosh server. This site is working but it can change or go down.
    //If you are going to have a production site, you must install your own BOSH server
    var url ="<?php echo $vars['url']?>http-bind/";
    var conn = new Strophe.Connection(url);
    if (sid != 'null' && rid != 'null') {
        conn.attach(jid,sid,rid,OnAttachStatus);
    } else {
        conn.connect(jid, password, OnConnectionStatus);
    }

    function OnConnectionStatus(nStatus)
    {
        console.log(nStatus);
        if (nStatus == Strophe.Status.CONNECTING) {
            } else if (nStatus == Strophe.Status.CONNFAIL) {
            } else if (nStatus == Strophe.Status.DISCONNECTING) {
            } else if (nStatus == Strophe.Status.DISCONNECTED) {
            } else if (nStatus == Strophe.Status.CONNECTED) {
                OnConnected();
        }
    }

    function OnAttachStatus (nStatus) {
                console.log(nStatus);

        if (nStatus == Strophe.Status.DISCONNECTED) {
            conn.connect(jid, password, OnConnectionStatus);
        } else if (nStatus == Strophe.Status.ATTACHED) {
            OnConnected();
        }
    }

    function OnConnected()
    {
        conn.addHandler(OnPresenceStanza, null, "presence");
        conn.addHandler(OnMessageStanza, null, "message");
        conn.send($pres());
    }

    function OnMessageStanza(stanza)
    {
        var sFrom = $(stanza).attr('from');
        var sType = $(stanza).attr('type');
        var sBareJid = Strophe.getBareJidFromJid(sFrom);
        var sBody = $(stanza).find('body').text();
        var split = sBareJid.split('@'),
                        username = split[0];
        var conversation = $("#chat_"+ username);
        if(conversation.length == 0){
                openChat({to:sBareJid});
        }
        conversation = $("#chat_"+ username);
        conversation.find(".conversation").append("<div>"+ username +": "+ sBody +"</div>").animate({ scrollTop: conversation.prop('scrollHeight') });
        // do something, e.g. show sBody with jQuery
        return true;
    }

    function OnPresenceStanza(stanza)
    {
        var sFrom = $(stanza).attr('from'),
            sBareJid = Strophe.getBareJidFromJid(sFrom),
            sRid = Strophe.getResourceFromJid(sFrom),
            contactList = $("#contacts");
        if (sBareJid == jid) {
            return true;
        }
        console.log(stanza);

        contactList.find('li').each(function () {
            if ($(this).attr('data-username') == sBareJid) {
                return true;
            }
        })
        // do something, e.g. show status icon with jQuery
        var contact = $("<li data-username=" + sBareJid +">");
        contact.append("<span class=\"ico\"/>"+ sBareJid +"")
                .click(function() {
                        var id = sBareJid;
                        var conversation = $("#"+id);
                        if(conversation.length == 0)
                                openChat({to:sBareJid});
                });
        contactList.append(contact);
        return true;
    }
    function openChat(options){
            var id = options.to,
                        split = options.to.split('@'),
                        username = split[0],
                        chatOpen = $("body").find('.chat'),
                        chat = $("#chat_"+id);
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
                        var message = input.val();
                        if(message && options.to){
                            var reply = $msg({
                                    to: options.to,
                                    type: 'chat'
                            })
                            .cnode(Strophe.xmlElement('body', message));
                            conn.send(reply.tree());
                        }
                        split = jid.split('@');
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
    $(window).unload( function () {
        setCookie ('rid',conn.rid,1);
        setCookie ('sid',conn.sid,1);
    });


    function log(msg)
    {
        $('#log').append('<div></div>').append(document.createTextNode(msg));
    }
    Strophe.log = function (level, msg) { log('LOG: ' + msg); };
});
</script>
<div id="presence">
    <div class="header">Chat</div>
    <ul id="contacts"></ul>
</div>
<div id="log"></div>
<?php
    }
?>
</body>
</html>