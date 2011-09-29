<?php
set_include_path(get_include_path().PATH_SEPARATOR.'/home/simran/ZendFramework-1.11.10-minimal/library');
require_once 'RssFeedMerger.php';
require_once 'Zend/Loader.php';


Zend_Loader::registerAutoload();


$rssMerger = new RssFeedMerger(array('http://www.feedforall.com/knowledgebase.php'), 'my merged feed', 'http://localhost/feed.php');
print $rssMerger->fetch();
?>
