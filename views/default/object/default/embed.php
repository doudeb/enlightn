<?php

if ($vars['entity'] instanceof ElggObject) {
	$title = htmlspecialchars($vars['entity']->title, ENT_QUOTES);
	echo "<a class=\"embed_document\" rel=\"facebox\" href=\"" . '' . "{$vars['entity']->getURL()}\" target=\"_blank\">$title</a>";
}