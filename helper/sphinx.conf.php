<?php

global $CONFIG;

?>
#
# Sphinx configuration file for Elgg
#


# Your database information.  Copy details from elgg/engine/settings.php
source <?php echo $CONFIG->sitename; ?>
{
	type			= mysql

	sql_host		= <?php echo $CONFIG->dbhost; ?>

	sql_user		= <?php echo $CONFIG->dbuser; ?>

	sql_pass		= <?php echo $CONFIG->dbpass; ?>

	sql_db			= <?php echo $CONFIG->dbname; ?>

}

source metastrings_main : <?php echo $CONFIG->sitename; ?>
{
        sql_query_pre          = SET NAMES utf8
        sql_query              = Select msv.id \
                                    , msv.string \
                                    , msv.id as value_id \
                                    , 0 as guid \
                                    From metastrings msv \
									Inner join annotations a On a.value_id = msv.id \
                                    And msv.id>=$start AND msv.id<=$end
        sql_query_range         = SELECT 1, counter.count_value \
                                        From indexer_counter counter \
                                        Where counter.entity = 'metastrings'
        sql_attr_uint           = value_id
        sql_attr_uint           = guid
        #sql_query_range        = SELECT 1 , 100000
        #sql_range_step         = 100
        sql_query_post_index    = replace into indexer_counter (id,entity,count_value) values (1,'metastrings',$maxid);
        #sql_query_info          = SELECT * FROM enlightn_dev.annotations WHERE id=$id
}

source metastrings_delta : metastrings_main
{
        sql_query_pre          = SET NAMES utf8
        sql_query_range        = SELECT counter.count_value, (Select Max(id) From metastrings) \
                                        From indexer_counter counter \
                                        Where entity = 'metastrings'

        sql_query_post_index   = SET NAMES utf8;
}


index metastrings_main
{
	source			= metastrings_main
	path			= <?php echo $CONFIG->dataroot; ?>sphinx/indexes/metastrings_main
}

index metastrings_delta : metastrings_main
{
	source			= metastrings_delta
	path			= <?php echo $CONFIG->dataroot; ?>sphinx/indexes/metastrings_delta
}


source desc_title_main : <?php echo $CONFIG->sitename; ?>
{
        sql_query_pre          = SET NAMES utf8
        sql_query              = Select desc_title.guid id \
                                            , concat (desc_title.title, desc_title.description) as string\
                                            , a.value_id as value_id \
                                            , desc_title.guid \
                                    From objects_entity desc_title \
                                    Inner Join annotations a On a.entity_guid = desc_title.guid \
                                    Where desc_title.guid>=$start AND desc_title.guid<=$end
        sql_query_range        = SELECT 1, counter.count_value \
                                        From indexer_counter counter \
                                        Where counter.entity = 'desc_title'
        sql_attr_uint          = value_id
        sql_attr_uint          = guid
        #sql_range_step        = 100
        sql_query_post_index   = replace into indexer_counter (id,entity,count_value) values (1,'desc_title',$maxid);
        #sql_query_info        = SELECT * FROM annotations WHERE id=$id
}

source desc_title_delta : desc_title_main
{
        sql_query_pre          = SET NAMES utf8
        sql_query_range        = SELECT counter.count_value, (Select Max(guid) From objects_entity) \
                                        From indexer_counter counter \
                                        Where entity = 'desc_title'

        sql_query_post_index   = SET NAMES utf8;
}


index desc_title_main
{
	source			= desc_title_main
	path			= <?php echo $CONFIG->dataroot; ?>sphinx/indexes/desc_title_main
}

index desc_title_delta : desc_title_main
{
	source			= desc_title_delta
	path			= <?php echo $CONFIG->dataroot; ?>sphinx/indexes/desc_title_delta
}

indexer
{
	mem_limit		= 256M
}

searchd
{
	listen			= 9312
	log				= <?php echo $CONFIG->dataroot; ?>sphinx/log/searchd.log
	query_log		= <?php echo $CONFIG->dataroot; ?>sphinx/log/query.log
	read_timeout	= 5
	max_children	= 30
	pid_file		= <?php echo $CONFIG->dataroot; ?>sphinx/log/searchd.pid
	max_matches		= 1000
	seamless_rotate	= 1
	preopen_indexes	= 0
	unlink_old		= 1
}

# --eof--