<?php
/**
 * Elgg friend collections add/edit
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['object'] Optionally, the collection edit
 */

// var_export($vars['collection'][0]->id);

// Set title, form destination
if (isset($vars['collection'])) {
	$action = "pg/editcollection";
	$title = $vars['collection'][0]->name;
	$highlight = 'default';
} else  {
	$action = "enlightn/collection/addcollection";
	$title = "";
	$highlight = 'all';
}


$form_body = "<div class='contentWrapper'><p><label>" . elgg_echo("friends:collectionname") . "<br />" .
	elgg_view("input/text", array(
		"internalname" => "collection_name",
		"value" => $title,
	)) . "</label></p>";

$form_body .= "<p>";

if($vars['collection_members']){
	$form_body .= elgg_echo("friends:collectionfriends") . "<br />";
	foreach($vars['collection_members'] as $mem){
		$form_body .= elgg_view("profile/icon",array('entity' => $mem, 'size' => 'tiny'));
		$form_body .= $mem->name;
	}
}

$form_body .= "</p>";

$form_body .= "<p><label>" . elgg_echo("enlightn:addmembers") . "</label>".
			elgg_view('friends/picker',array('entities' => $vars['friends'], 'internalname' => 'friends_collection', 'highlight' => $highlight)) . "</p>";

$form_body .= "<p>";
if (isset($vars['collection'])) {
	$form_body .= elgg_view('input/hidden', array('internalname' => 'collection_id', 'value' => "{$vars['collection'][0]->id}"));
}
$form_body .= elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));
$form_body .= "</p></div>";

echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$vars['url']}action/$action"));