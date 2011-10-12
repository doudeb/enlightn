<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
global $CONFIG;
if (!function_exists('elgg_get_data_path')) {
    function elgg_get_data_path () {
        global $CONFIG;
        return $CONFIG->dataroot;
    }
}
function sphinx_write_conf() {
        $handle = fopen(elgg_get_data_path() . 'sphinx/sphinx.conf', 'w');

        ob_start();
        include dirname(__FILE__) . '/sphinx.conf.php';
        $conf = ob_get_clean();

        fwrite($handle, $conf);
        fclose($handle);
        chmod(elgg_get_data_path() . 'sphinx/sphinx.conf',770);

}

function create_tables () {
    $handle = fopen('create_table_sphinx.sql','w');

    ob_start();
    include 'create_table_sphinx.php';
    $conf = ob_get_clean();

    fwrite($handle, $conf);
    fclose($handle);
    die();
    return run_sql_script('create_table_sphinx.sql');
}

$sphinx_path = elgg_get_data_path() . 'sphinx';

mkdir("$sphinx_path");
//chmod("$sphinx_path",770);
mkdir("$sphinx_path/indexes");
//chmod("$sphinx_path/indexes",770);
mkdir("$sphinx_path/log");
//chmod("$sphinx_path/log",770);

sphinx_write_conf();
create_tables();
echo '15 2 * * 1 indexer --config  ' . elgg_get_data_path() . '/sphinx/sphinx.conf --rotate --index ' . $CONFIG->sitename . '_main';
echo '*/15 * * * * indexer --config  ' . elgg_get_data_path() . '/sphinx/sphinx.conf --rotate --index ' . $CONFIG->sitename . '_delta';