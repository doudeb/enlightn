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

source <?php echo $CONFIG->sitename; ?>_main : <?php echo $CONFIG->sitename; ?>
{
        sql_query_pre          = SET NAMES utf8
        sql_query               = Select a.id \
                                        , title.guid \
                                        , title.title \
                                        , (Select string From enlightn_dev.metastrings Where a.value_id = id) as content \
                                        , a.time_created created \
                                From enlightn_dev.annotations a \
                                Inner Join enlightn_dev.objects_entity title On title.guid = a.entity_guid \
                                Where a.id>=$start AND a.id<=$end
        sql_attr_uint           = guid
        sql_attr_timestamp      = created
        sql_query_range         = SELECT 1, counter.count_value \
                                        From indexer_counter counter \
                                        Where counter.entity = '<?php echo $CONFIG->sitename; ?>'
        #sql_query_range                = SELECT 1 , 100000
        #sql_range_step         = 100
        sql_query_post_index    = replace into indexer_counter (id,entity,count_value) values (1,'<?php echo $CONFIG->sitename; ?>',$maxid);
        #sql_query_info          = SELECT * FROM enlightn_dev.annotations WHERE id=$id
}

source <?php echo $CONFIG->sitename; ?>_delta : <?php echo $CONFIG->sitename; ?>_main
{
        sql_query_range         = SELECT counter.count_value, (Select Max(id) From annotations) \
                                        From indexer_counter counter \
                                        Where entity = '<?php echo $CONFIG->sitename; ?>'

        sql_query_post_index   = SET NAMES utf8;
}


index <?php echo $CONFIG->sitename; ?>_main
{
	source			= <?php echo $CONFIG->sitename; ?>_main
	path			= <?php echo $CONFIG->dataroot; ?>sphinx/indexes/<?php echo $CONFIG->sitename; ?>_main
}

index <?php echo $CONFIG->sitename; ?>_delta : <?php echo $CONFIG->sitename; ?>_main
{
	source			= <?php echo $CONFIG->sitename; ?>_delta
	path			= <?php echo $CONFIG->dataroot; ?>sphinx/indexes/<?php echo $CONFIG->sitename; ?>_delta
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