<?php
$messages_unreaded = count_unreaded_messages($vars['entity']->guid);
if ($messages_unreaded[0]->messages_unreaded > 0) {
    echo "<span class='unreaded_messages'>" . $messages_unreaded[0]->messages_unreaded . "</span>";
} else {
    return false;
}