<?php
$tpl = erLhcoreClassTemplate::getInstance('lhgooglesuggest/new.tpl.php');

$item = new erLhcoreClassModelGoogleSuggestItem();

$tpl->set('item',$item);

if (ezcInputForm::hasPostData()) {

    $Errors = erLhcoreClassGoogleSuggestValidator::validateSuggestItem($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();
            erLhcoreClassModule::redirect('googlesuggest/optionslist');
            exit ;
        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' =>erLhcoreClassDesign::baseurl('googlesuggest/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Suggest')),
    array (
        'url' => erLhcoreClassDesign::baseurl('googlesuggest/optionslist'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Option List')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'New')
    )
);

?>