<pre>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * @todo
 * *All cc and to are not retreived look into the php doc and comment
 * *Code a kind of replies formater (quoted replies)
 * *UTF8 damned....
 */


include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
require_once(dirname(dirname(__FILE__)) . "/model/format.class.php");

//Some basic var
gatekeeper();
global $enlightn, $profile_settings;
$user_guid = elgg_get_logged_in_user_guid();

$imapStream = new IMAP($profile_settings['emailserver'],$profile_settings['emailport'],$profile_settings['emaillogin'],$profile_settings['emailpasswd'],$profile_settings['emailservtype']);
$messages = $imapStream->imap_search("UNSEEN");
//$imapBox = $imapStream->imap_check();
foreach ($messages as $key=>$email_msgno) {
    $guid               = false;
    $email_headers      = $imapStream->imap_fetch_overview($email_msgno);
    $email_full_headers = $imapStream->imap_headerinfo( $email_headers[0]->msgno);
    $email_body         = $imapStream->view_message($email_headers[0]->uid);
    $email_attachement  = $imapStream->get_attachments($email_headers[0]->uid);
    $message_id         = $email_full_headers->message_id;
    //if the message laready exist, continue to the next entry
    $guid       = elgg_get_entities_from_metadata(array('metadata_names' => ENLIGHTN_EMAILMESSAGE_ID, 'metadata_values' => $message_id));
    if (isset($guid[0]->guid)) {
        add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid[0]->guid);
        continue;
    }
    //is this a new message
    if (empty($email_headers[0]->references) && empty($email_headers->in_reply_to)) {
        $guid = false;
    } else {
        //trying to retreive the message into the system
        //First let's work with the in_reply_to
        $guid       = elgg_get_entities_from_metadata(array('metadata_names' => ENLIGHTN_EMAILMESSAGE_ID, 'metadata_values' => $email_full_headers->in_reply_to));
        if (!isset($guid[0]->guid)) {
            $references = explode(" ", trim($email_full_headers->references));
            foreach ($references as $key => $reference_id) {
                $guid = false;
                $guid = elgg_get_entities_from_metadata(array('metadata_names' => ENLIGHTN_EMAILMESSAGE_ID, 'metadata_values' => $reference_id));
                if (isset($guid[0]->guid)) {
                    continue;
                }
            }
        }
    }
    if ($email_body['mime_type'] == 'html') {
        $message    = filter_tags($email_body["content"]);
    } else {
        $message    = nl2br($email_body["content"]);
    }
    $title          = FORMAT::decodeSubject($email_full_headers->subject);
    $owner_email    = $email_full_headers->from[0]->mailbox . '@' . $email_full_headers->from[0]->host;
    //Now retreive all followers
    $follower       = array();
    foreach ($email_full_headers->to as $value) {
        $email      = $value->mailbox . '@' . $value->host;
        $user_ent    = get_user_by_email(trim($email));
        if (!$user_ent) {
            $username = str_replace('@','',$email);
            $new_user_id = create_external_user($email, $username, $value->mailbox);
            $follower[] = $new_user_id;
        }
    }
    foreach ($email_full_headers->cc as $value) {
        $email      = $value->mailbox . '@' . $value->host;
        $user_ent    = get_user_by_email(trim($email));
        if (!$user_ent) {
            $username = str_replace('@','',$email);
            $new_user_id = create_external_user($email, $username, $value->mailbox);
            $follower[] = $new_user_id;
        }
    }
    foreach ($email_full_headers->bcc as $value) {
        $email      = $value->mailbox . '@' . $value->host;
        $user_ent    = get_user_by_email(trim($email));
        if (!$user_ent) {
            $username = str_replace('@','',$email);
            $new_user_id = create_external_user($email, $username, $value->mailbox);
            $follower[] = $new_user_id;
        }
    }
    $follower       = implode(',', $follower);
    $user_ent       = get_user_by_email(trim($owner_email));
    if (!$user_ent) {
        $username = str_replace('@','',$owner_email);
        $new_user_id = create_external_user($owner_email, $username, $email_full_headers->from[0]->personal);
        $user_ent[0] = get_entity($new_user_id);
    }
    $new_message = create_enlightn_discussion ($user_ent[0]->guid, ACCESS_PRIVATE,$message, $title,$tags, $follower,$guid[0]->guid);
    add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid[0]->guid);
    remove_entity_relationship($user_guid, ENLIGHTN_READED, $new_message['sucess']);
    $guid        = $new_message['guid'];
    add_entity_relationship($user_guid, ENLIGHTN_FOLLOW, $guid);
    $enlightndiscussion = get_entity($guid);
    create_metadata($guid, ENLIGHTN_EMAILMESSAGE_ID, $message_id, 'text', 0, ACCESS_PRIVATE,true);
    create_metadata($guid, ENLIGHTN_EMAILINREPLY_TO, $email_headers[0]->in_reply_to, 'text', 0, ACCESS_PRIVATE,true);
    create_metadata($guid, ENLIGHTN_EMAILREFERENCES, $email_headers[0]->references, 'text', 0, ACCESS_PRIVATE,true);
    //proceed attachement
    foreach ($email_attachement as $key => $attachement) {
        if (isset($attachement["filename"])) {
            create_attachement($new_message['success'],$attachement["filename"],$imapStream->get_attachments($email_headers[0]->uid,$attachement["filename"]));
        }
    }

}