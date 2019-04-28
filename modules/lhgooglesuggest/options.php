<?php

$tpl = erLhcoreClassTemplate::getInstance('lhgooglesuggest/options.tpl.php');

$gsOptions = erLhcoreClassModelChatConfig::fetch('googlesuggest_options');
$data = (array)$gsOptions->data;

if ( isset($_POST['StoreOptions']) ) {

    $definition = array(
        'fields' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'cx' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'key' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'referrer' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( $form->hasValidData( 'fields' )) {
        $data['fields'] = $form->fields;
    } else {
        $data['fields'] = 'items(title,link)';
    }

    if ( $form->hasValidData( 'cx' )) {
        $data['cx'] = $form->cx;
    } else {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'Please enter search engine id!');
    }

    if ( $form->hasValidData( 'key' )) {
        $data['key'] = $form->key;
    } else {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'Please enter your API Key!');
    }

    if ( $form->hasValidData( 'referrer' )) {
        $data['referrer'] = $form->referrer;
    } else {
        $data['referrer'] = '';
    }

    if (empty($Errors)) {
        $gsOptions->explain = '';
        $gsOptions->type = 0;
        $gsOptions->hidden = 1;
        $gsOptions->identifier = 'googlesuggest_options';
        $gsOptions->value = serialize($data);
        $gsOptions->saveThis();
        $tpl->set('updated','done');
    } else {
        $tpl->set('errors',$Errors);
    }

}

$tpl->set('gs_options',$data);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('googlesuggest/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'Google Suggest')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest', 'Options')
    )
);

?>