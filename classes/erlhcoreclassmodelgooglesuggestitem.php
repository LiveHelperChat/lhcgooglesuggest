<?php

class erLhcoreClassModelGoogleSuggestItem
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_googlesugest_item';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionLhcgooglesuggest::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'identifier' => $this->identifier,
            'configuration' => $this->configuration,
            'field' => $this->field,
            'search_id' => $this->search_id,
            'referrer' => $this->referrer,
            'custom_arguments' => $this->custom_arguments
        );
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'configuration_array':
                $this->configuration_array = array();
                if ($this->configuration != '') {
                    $this->configuration_array = json_decode($this->configuration,true);
                }
                return $this->configuration_array;
                break;

            default:
                ;
                break;
        }
    }

    public $id = null;

    public $name = '';

    public $identifier = '';

    public $configuration = '';

    public $custom_arguments = '';

    public $field = 'items(title,link)';

    public $search_id = '';

    public $referrer = '';

}

?>