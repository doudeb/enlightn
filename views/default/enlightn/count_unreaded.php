<?php
if (is_array($vars['discussion_unreaded'])) {
	foreach ($vars['discussion_unreaded'] as $key => $discussion) {
		if ($discussion->guid == $vars['entity']->guid) {
			echo '(' . $discussion->unreaded . ')';
			return;
		}
	}
}
?>
