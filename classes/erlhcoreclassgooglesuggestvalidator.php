<?php
#[\AllowDynamicProperties]
class erLhcoreClassGoogleSuggestValidator
{
    public static function validateSuggestItem(erLhcoreClassModelGoogleSuggestItem & $item)
    {
            $definition = array(
                'name' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'identifier' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'key' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'field' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'search_id' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'referrer' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ),
                'custom_arguments' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                )
            );

            $form = new ezcInputForm( INPUT_POST, $definition );
            $Errors = array();

            if ( $form->hasValidData( 'name' ) && $form->name != '')
            {
                $item->name = $form->name;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please enter name!');
            }

            if ( $form->hasValidData( 'identifier' ) && $form->identifier != '')
            {
                $item->identifier = $form->identifier;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please enter identifier!');
            }

            if ( $form->hasValidData( 'field' ) && $form->field != '') {
                $item->field = $form->field;
            } else {
                $item->field = 'items(title,link)';
            }

            if ( $form->hasValidData( 'search_id' ) && $form->search_id != '') {
                $item->search_id = $form->search_id;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please enter search engine id!');
            }

            if ( $form->hasValidData( 'referrer' ) && $form->referrer != '')
            {
                $item->referrer = $form->referrer;
            } else {
                $item->referrer = '';
            }

            if ( $form->hasValidData( 'custom_arguments' ) && $form->custom_arguments != '')
            {
                $item->custom_arguments = $form->custom_arguments;
            } else {
                $item->custom_arguments = '';
            }
            
            $configurationArray = $item->configuration_array;

            if ( $form->hasValidData( 'key' ) && $form->key != '') {
                $configurationArray['key'] = $form->key;
            } else {
                $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('xmppservice/operatorvalidator','Please enter your API Key!');
            }

            $item->configuration_array = $configurationArray;

            $item->configuration = json_encode($configurationArray);

            return $Errors;        
    }
}