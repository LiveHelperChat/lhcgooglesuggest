<?php

$tpl = erLhcoreClassTemplate::getInstance('lhgooglesuggest/edit.tpl.php');

$item =  erLhcoreClassModelGoogleSuggestItem::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('googlesuggest/optionslist');
        exit ;
    }

    $Errors = erLhcoreClassGoogleSuggestValidator::validateSuggestItem($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();
            erLhcoreClassModule::redirect('googlesuggest/optionslist');
            exit;

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->setArray(array(
        'item' => $item,
));

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array('url' =>erLhcoreClassDesign::baseurl('googlesuggest/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Suggest')),
    array (
        'url' => erLhcoreClassDesign::baseurl('googlesuggest/optionslist'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Option List')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'Edit')
    )
);

?>