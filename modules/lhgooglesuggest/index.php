<?php
$tpl = erLhcoreClassTemplate::getInstance('lhgooglesuggest/index.tpl.php');

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('googlesuggest/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'Google Suggest')
    )
);

?>