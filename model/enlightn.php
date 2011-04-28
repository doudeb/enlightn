<?php


class enlightn {
	
	function get_discussion ($user_guid, $discussion_type = 0) {
		
		if (!$user_guid) {
			return false;
		}
		$where = elgg_get_entity_type_subtype_where_sql('e', 'object', ENLIGHTN_DISCUSSION, null);
		$query = "Select e.*
From entities as e
Left Join entity_relationships As rel On e.guid = rel.guid_two And rel.guid_one = 404 And rel.relationship = '".ENLIGHTN_FOLLOW . "'
Where $where
And Case 
	When 0=$discussion_type Then rel.id Is not Null And e.access_id = 0#Only for membership
	When 1=$discussion_type Then e.access_id = 1 #All for logged user aka public
	Else Null
End 
Order By e.time_created desc";
		elgg_get_access_object()->set_ignore_access(true);
		return  get_data($query, 'entity_row_to_elggstar');
	}
	
}


?>