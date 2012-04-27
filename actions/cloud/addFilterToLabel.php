<?php
global $CONFIG;
$guid                               = get_input('guid');
$label_guid                         = get_input('labelGuid');


disable_right($guid);
echo json_encode(add_entity_relationship($guid,ENLIGHTN_FILTER_ATTACHED,$label_guid));
exit();