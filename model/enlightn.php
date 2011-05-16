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
	
	function search ($user_guid, $words, $users_guid = '', $date_begin = '""', $date_end = '""') {
		
		$query = "Select a.*
					, msn.string as name
					, msv.string as value
					, ent_title.title
					, ent_title.guid
From entities ent
Inner Join objects_entity ent_title On ent.guid = ent_title.guid
Inner Join annotations a on ent.guid = a.entity_guid
Inner Join metastrings msn on a.name_id = msn.id
Inner Join metastrings msv on a.value_id = msv.id
Where ((Exists( 
			Select id 
			From entity_relationships As rel 
			Where ent.guid = rel.guid_two 
			And rel.guid_one = $user_guid
			And rel.relationship = '". ENLIGHTN_FOLLOW . "')
		And ent.access_id = 0)
	Or ent.access_id = 2)
And
	Case 
		When length('$words') > 2 And length('$words') <= @@ft_min_word_len Then 
			ent_title.title Like '%$words%' Or msv.string Like '%$words%'
		When length('$words') > @@ft_min_word_len Then 
			(MATCH (ent_title.title,msv.string) AGAINST ('+$words' IN BOOLEAN MODE))
		Else true
	End
And
	Case
		When length('$users_guid') > 0 And locate(',','$users_guid') = 0 Then
			a.owner_guid = '$users_guid'
		When length('$users_guid') > 0 And locate(',','$users_guid') > 0 Then
			a.owner_guid in ('$users_guid')
		Else true
	End
And
	Case
		When length($date_begin) > 0 And length($date_end) > 0 Then
			ent.time_created Between $date_begin And $date_end
		Else true
	End
Order By
Case
	When locate('$words',ent_title.title) Then 1
	When locate('$words',msv.string) Then 2
	Else false
End
,ent.time_created Desc;";
		//echo $query;
		return  get_data($query, 'row_to_elggannotation');
	}	
}


?>