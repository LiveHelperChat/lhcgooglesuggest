<?php

class erLhcoreClassExtensionLhcgooglesuggest
{
    public function __construct()
    {

    }

    public function run()
    {
        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('chat.genericbot_handler', array($this,'genericHandler'));
        $dispatcher->listen('chat.genericbot_event_handler', array($this,'genericHandlerEvent'));
    }

    public function genericHandlerEvent($params) 
    {
        if ($params['render'] == 'google_search') {
            $trigger = erLhcoreClassModelGenericBotTrigger::fetch($params['render_args']['valid']);

            $response = $this->executeRequest($params['payload']);

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

            $trigger = erLhcoreClassModelGenericBotTrigger::fetch($params['render_args_event']['valid']);

            $response = $this->executeRequest($params['render_args']['msg']->msg);

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

    public function executeRequest($msg)
    {
        $query = '?' . http_build_query(array(
            'key' => (isset($this->settings['key']) && $this->settings['key'] != '') ? $this->settings['key'] : '',
            'cx' => (isset($this->settings['cx']) && $this->settings['cx'] != '') ? $this->settings['cx'] : '',
            'fields' => (isset($this->settings['fields']) && $this->settings['fields'] != '') ? $this->settings['fields'] : 'items(title,link)',
            'q' => $msg,
        ));

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

}


