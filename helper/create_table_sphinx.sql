
drop table if exists indexer_counter;
create table indexer_counter(id integer unsigned not null, entity varchar(200), count_value integer unsigned not null, unique (id, entity));
drop table if exists sphinx_search;
Create Table sphinx_metastrings
(
    id          INTEGER UNSIGNED NOT NULL,
    weight      INTEGER NOT NULL,
    query       VARCHAR(3072) NOT NULL,
    guid        INTEGER,
    created INTEGER,
    INDEX(query)
) ENGINE=SPHINX CONNECTION="sphinx://127.0.0.1:9312/enlightn-dev_metastrings_main,enlightn-dev_metastrings_delta";
 replace into indexer_counter (id,entity,count_value) values (1,'metastrings',(Select Max(id) From metastrings));