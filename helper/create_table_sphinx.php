<?php

global $CONFIG;

?>

drop table if exists indexer_counter;
create table indexer_counter(id integer unsigned not null, entity varchar(200), count_value integer unsigned not null, unique (id, entity));
drop table if exists sphinx_metastrings;
Create Table sphinx_metastrings
(
    id          BIGINT UNSIGNED NOT NULL,
    weight      INTEGER NOT NULL,
    query       VARCHAR(3072) NOT NULL,
    value_id    INTEGER NOT NULL,
    INDEX(query)
) ENGINE=SPHINX CONNECTION="sphinx://127.0.0.1:9312/<?php echo $CONFIG->sitename; ?>_metastrings_main,<?php echo $CONFIG->sitename; ?>_metastrings_delta";
 replace into indexer_counter (id,entity,count_value) values (1,'metastrings',(Select Max(id) From metastrings));
 drop table if exists sphinx_search;
 Create Table sphinx_search
(
    id          BIGINT UNSIGNED NOT NULL,
    weight      INTEGER NOT NULL,
    query       VARCHAR(3072) NOT NULL,
    guid    INTEGER NOT NULL,
    value_id    INTEGER NOT NULL,
    INDEX(query)
) ENGINE=SPHINX CONNECTION="sphinx://127.0.0.1:9312";
  replace into indexer_counter (id,entity,count_value) values (1,'desc_title',(Select Max(guid) From objects_entity));