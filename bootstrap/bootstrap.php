<?php
#[\AllowDynamicProperties]
class erLhcoreClassExtensionLhcgooglesuggest
{
    public function __construct()
    {

    }

    public function run()
    {
        $this->registerAutoload ();

        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('chat.genericbot_handler', array($this,'genericHandler'));
        $dispatcher->listen('chat.genericbot_event_handler', array($this,'genericHandlerEvent'));

        $dispatcher->listen('instance.extensions_structure', array(
            $this,
            'checkStructure'
        ));

        $dispatcher->listen('instance.registered.created', array(
            $this,
            'instanceCreated'
        ));
    }

    /**
     * Checks automated hosting structure
     *
     * This part is executed once in manager is run this cronjob.
     * php cron.php -s site_admin -e instance -c cron/extensions_update
     *
     * */
    public function checkStructure()
    {
        erLhcoreClassUpdate::doTablesUpdate(json_decode(file_get_contents('extension/lhcgooglesuggest/doc/structure.json'), true));
    }

    public function instanceCreated($params)
    {
        try {
            // Instance created trigger
            $this->instanceManual = $params['instance'];

            // Just do table updates
            erLhcoreClassUpdate::doTablesUpdate(json_decode(file_get_contents('extension/lhcgooglesuggest/doc/structure.json'), true));

        } catch (Exception $e) {
            erLhcoreClassLog::write(print_r($e, true));
        }
    }

    public function registerAutoload() {
        spl_autoload_register ( array (
            $this,
            'autoload'
        ), true, false );
    }

    public function autoload($className) {
        $classesArray = array (
            'erLhcoreClassModelGoogleSuggestItem'  => 'extension/lhcgooglesuggest/classes/erlhcoreclassmodelgooglesuggestitem.php',
            'erLhcoreClassGoogleSuggestValidator'  => 'extension/lhcgooglesuggest/classes/erlhcoreclassgooglesuggestvalidator.php',
        );

        if (key_exists ( $className, $classesArray )) {
            include_once $classesArray [$className];
        }
    }



    public function genericHandlerEvent($params) 
    {
        if ($params['render'] == 'google_search' || strpos($params['render'],'google_search') !== false) {

            $identifier = str_replace('google_search_','',$params['render']);

            $paramsExecution = array();

            if (!empty($identifier)) {
                $suggestionItem = erLhcoreClassModelGoogleSuggestItem::findOne(array('filter' => array('identifier' => $identifier)));
                if ($suggestionItem instanceof erLhcoreClassModelGoogleSuggestItem){
                    $paramsExecution = array (
                        'key' => $suggestionItem->configuration_array['key'],
                        'fields' => $suggestionItem->field,
                        'cx' => $suggestionItem->search_id,
                        'custom_arguments' => $suggestionItem->custom_arguments
                    );
                }
            }

            if (empty($paramsExecution)) {
                $paramsExecution = array(
                    'key' => (isset($this->settings['key']) && $this->settings['key'] != '') ? $this->settings['key'] : '',
                    'cx' => (isset($this->settings['cx']) && $this->settings['cx'] != '') ? $this->settings['cx'] : '',
                    'fields' => (isset($this->settings['fields']) && $this->settings['fields'] != '') ? $this->settings['fields'] : 'items(title,link)',
                );
            }

            $trigger = erLhcoreClassModelGenericBotTrigger::fetch($params['render_args']['valid']);

            $response = $this->executeRequest($params['payload'], $paramsExecution);

            $data = json_decode($response, true);

            if (isset($data['items'])) {
                $actionsUpdated = array();

                $actions = $trigger->actions_front;
                foreach ($actions as $action) {
                    if ($action['type'] == 'buttons') {

                        $limit = count($action['content']['buttons']);

                        $buttons = array();
                        foreach ($data['items'] as $index => $itemData) {
                            if ($index < $limit) {
                                $buttons[] = array(
                                    'type' => 'url',
                                    'content' => array(
                                        'name' => $itemData['title'],
                                        'payload' => $itemData['link'],
                                    ),
                                );
                            }
                        }

                        $action['content']['buttons'] = $buttons;
                        $actionsUpdated[] = $action;

                    } else {
                        $actionsUpdated[] = $action;
                    }
                }

                $trigger->actions_front = $actionsUpdated;
                erLhcoreClassGenericBotWorkflow::processTrigger($params['chat'], $trigger, true, array());
            } else {
                $trigger = erLhcoreClassModelGenericBotTrigger::fetch($params['render_args']['invalid']);
                erLhcoreClassGenericBotWorkflow::processTrigger($params['chat'], $trigger, true, array());
            }
        }
    }
    
    public function genericHandler($params)
    {
        if ($params['render'] == 'google_search' && $params['event'] === null) {

            $identifier = str_replace('google_search_','',$params['render']);

            $paramsExecution = array();

            if (!empty($identifier)) {
                $suggestionItem = erLhcoreClassModelGoogleSuggestItem::findOne(array('filter' => array('identifier' => $identifier)));
                if ($suggestionItem instanceof erLhcoreClassModelGoogleSuggestItem){
                    $paramsExecution = array (
                        'key' => $suggestionItem->configuration_array['key'],
                        'fields' => $suggestionItem->field,
                        'cx' => $suggestionItem->search_id,
                        'custom_arguments' => $suggestionItem->custom_arguments
                    );
                }
            }

            if (empty($paramsExecution)) {
                $paramsExecution = array(
                    'key' => (isset($this->settings['key']) && $this->settings['key'] != '') ? $this->settings['key'] : '',
                    'cx' => (isset($this->settings['cx']) && $this->settings['cx'] != '') ? $this->settings['cx'] : '',
                    'fields' => (isset($this->settings['fields']) && $this->settings['fields'] != '') ? $this->settings['fields'] : 'items(title,link)',
                );
            }

            $trigger = erLhcoreClassModelGenericBotTrigger::fetch($params['render_args_event']['valid']);

            $response = $this->executeRequest($params['render_args']['msg']->msg,$paramsExecution);

            $data = json_decode($response, true);

            if (isset($data['items'])) {
                $actionsUpdated = array();

                $actions = $trigger->actions_front;
                foreach ($actions as $action) {
                    if ($action['type'] == 'buttons') {

                        $limit = count($action['content']['buttons']);

                        $buttons = array();
                        foreach ($data['items'] as $index => $itemData) {
                            if ($index < $limit) {
                                $buttons[] = array(
                                    'type' => 'url',
                                    'content' => array(
                                        'name' => $itemData['title'],
                                        'payload' => $itemData['link'],
                                    ),
                                );
                            }
                        }

                        $action['content']['buttons'] = $buttons;
                        $actionsUpdated[] = $action;

                    } else {
                        $actionsUpdated[] = $action;
                    }
                }

                $trigger->actions_front = $actionsUpdated;

                return array(
                    'status' => erLhcoreClassChatEventDispatcher::STOP_WORKFLOW,
                    'trigger' => $trigger
                );

            } else {
                $trigger = erLhcoreClassModelGenericBotTrigger::fetch($params['render_args_event']['invalid']);

                return array(
                    'status' => erLhcoreClassChatEventDispatcher::STOP_WORKFLOW,
                    'trigger' => $trigger
                );
            }
        }
    }

    public function __get($var) {
        switch ($var) {

            case 'settings' :
                $this->settings = (array)erLhcoreClassModelChatConfig::fetch('googlesuggest_options')->data;
                return $this->settings;
                break;

            default :
                ;
                break;
        }
    }

    public function executeRequest($msg, $paramsExecution)
    {
        $args = array(
            'key' => $paramsExecution['key'],
            'cx' =>  $paramsExecution['cx'],
            'fields' => $paramsExecution['fields'],
            'q' => $msg,
        );

        if (isset($paramsExecution['custom_arguments']) && !empty($paramsExecution['custom_arguments'])) {
            $pairs = explode("\n",$paramsExecution['custom_arguments']);
            foreach ($pairs as $pair) {
                $pairData = explode('==',$pair);
                $args[$pairData[0]] = $pairData[1];
            }
        }

        $query = '?' . http_build_query($args);

        erLhcoreClassLog::write(print_r($args,true));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/customsearch/v1" . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if (isset($this->settings['referrer']) && $this->settings['referrer'] != '') {
            curl_setopt($ch, CURLOPT_REFERER, $this->settings['referrer']);
        }

        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        return curl_exec($ch);
    }

    public static function getSession() {
        if (! isset ( self::$persistentSession )) {
            self::$persistentSession = new ezcPersistentSession ( ezcDbInstance::get (), new ezcPersistentCodeManager ( './extension/lhcgooglesuggest/pos' ) );
        }
        return self::$persistentSession;
    }

    private static $persistentSession;
}


