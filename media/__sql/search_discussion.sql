Delimiter //
DROP PROCEDURE IF EXISTS search_discussion// 
Create Procedure search_discussion (In user_guid int
									, In access_level int
									, In words varchar(100)
									, In users_guid varchar(255)
									, In date_begin int
									, In date_end int
									, In subtype varchar(100)
									, In offset_pag int signed
									, In limit_pag int signed
									, In ACCESS_PUBLIC varchar(100)
									, In ACCESS_PRIVATE varchar(100)
									, In ENLIGHTN_FOLLOW varchar(100)
									, In ENLIGHTN_FAVORITE varchar(100))
Begin
set @rownum:=0;

	Select * From(
		Select a.*
							, msv.string as value
							, ent_title.title
							, a.entity_guid as guid
							, (@rownum:=@rownum+1) as Rownumber
		From annotations a
		Inner Join objects_entity ent_title On a.entity_guid = ent_title.guid
		Inner Join metastrings msv on a.value_id = msv.id
		Where 
			Case
				When access_level = 1 Then #Public Only 
					a.access_id = ACCESS_PUBLIC
				When access_level = 2 Then #Private Followed And Public Folowed 
					(
						Exists( 
							Select id 
							From entity_relationships As rel 
							Where a.entity_guid = rel.guid_two 
							And rel.guid_one = user_guid
							And rel.relationship = ENLIGHTN_FOLLOW
						) And a.access_id IN(ACCESS_PRIVATE ,ACCESS_PUBLIC)
					)
				When access_level = 3 Then #Favorite Private an Public
					Exists( 
						Select id 
						From entity_relationships As rel 
						Where a.entity_guid = rel.guid_two 
						And rel.guid_one = user_guid
						And rel.relationship = ENLIGHTN_FAVORITE
						And a.access_id IN(ACCESS_PRIVATE ,ACCESS_PUBLIC)
					)
				When access_level = 4 Then #Private Folowed or Public
					(
						Exists( 
							Select id 
							From entity_relationships As rel 
							Where a.entity_guid = rel.guid_two 
							And rel.guid_one = user_guid
							And rel.relationship = ENLIGHTN_FOLLOW
							And a.access_id  = ACCESS_PRIVATE 
						)
					) Or a.access_id  = ACCESS_PUBLIC			
				Else false
			End
		And
			Case 
				When length(words) > 2 And length(words) <= @@ft_min_word_len Then 
					ent_title.title Like concat("%", words, "%") Or msv.string Like concat("%", words, "%")
				When length(words) > @@ft_min_word_len Then 
					MATCH (ent_title.title,msv.string) AGAINST (words IN BOOLEAN MODE) 
				Else true
			End
		And
			Case
				When length(users_guid) > 0 And locate(',',users_guid) = 0 Then
					a.owner_guid = users_guid
				When length(users_guid) > 0 And locate(',',users_guid) > 0 Then
					a.owner_guid in (users_guid)
				Else true
			End
		And
			Case
				When length(date_begin) > 0 And length(date_end) > 0 Then
					a.time_created Between date_begin And date_end
				Else true
			End
		And
			Case 
				When length(subtype) > 0 Then 
					Exists(Select mst.string 
								From metastrings mst
								Where a.name_id = mst.id
								And mst.string = subtype)
				Else true
			End
		Group By 
			Case 
				When length(words)  = 0 Then
			 		a.entity_guid
			 	Else a.id
			End
		Order By a.time_created Desc
		,Case
			When locate(words,ent_title.title) Then 1
			When locate(words,msv.string) Then 2
			Else false
		End) as res
	Where Rownumber > offset_pag 
	And Rownumber <= (offset_pag + limit_pag);
End // 
Delimiter ; 