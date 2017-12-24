<?php

namespace Kanboard\Plugin\Telegram\Notification;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram as TelegramClass;
use Longman\TelegramBot\Exception\TelegramException;
use Kanboard\Core\Base;
use Kanboard\Core\Notification\NotificationInterface;
use Kanboard\Model\TaskModel;

/**
 * Telegram Notification
 *
 * @package  notification
 * @author   Manu Varkey
 */
 
class Telegram extends Base implements NotificationInterface
{
    /**
     * Send notification to a user
     *
     * @access public
     * @param  array     $user
     * @param  string    $eventName
     * @param  array     $eventData
     */
    public function notifyUser(array $user, $eventName, array $eventData)
    {
        $apikey = $this->userMetadataModel->get($user['id'], 'telegram_apikey', $this->configModel->get('telegram_apikey'));
        $bot_username = $this->userMetadataModel->get($user['id'], 'telegram_username', $this->configModel->get('telegram_username'));
        $chat_id = $this->userMetadataModel->get($user['id'], 'telegram_user_cid');
        if (! empty($apikey)) 
        {
            if ($eventName === TaskModel::EVENT_OVERDUE) 
            {
                foreach ($eventData['tasks'] as $task) 
                {
                    $project = $this->projectModel->getById($task['project_id']);
                    $eventData['task'] = $task;
                    $this->sendMessage($apikey, $bot_username, $chat_id, $project, $eventName, $eventData);
                }
            } 
            else 
            {
                $project = $this->projectModel->getById($eventData['task']['project_id']);
                $this->sendMessage($apikey, $bot_username, $chat_id, $project, $eventName, $eventData);
            }
        }
    }
    
    /**
     * Send notification to a project
     *
     * @access public
     * @param  array     $project
     * @param  string    $eventName
     * @param  array     $eventData
     */
    public function notifyProject(array $project, $eventName, array $eventData)
    {
        $apikey = $this->projectMetadataModel->get($project['id'], 'telegram_apikey', $this->configModel->get('telegram_apikey'));
        $bot_username = $this->projectMetadataModel->get($project['id'], 'telegram_username', $this->configModel->get('telegram_username'));
        $chat_id = $this->projectMetadataModel->get($project['id'], 'telegram_group_cid');
        if (! empty($apikey)) 
        {
            $this->sendMessage($apikey, $bot_username, $chat_id, $project, $eventName, $eventData);
        }
    }
    
    /**
     * Get message to send
     *
     * @access public
     * @param  array     $project
     * @param  string    $eventName
     * @param  array     $eventData
     * @return array
     */
    public function getMessage($chat_id, array $project, $eventName, array $eventData)
    {
        if ($this->userSession->isLogged()) 
        {
            $author = $this->helper->user->getFullname();
            $title = $this->notificationModel->getTitleWithAuthor($author, $eventName, $eventData);
        }
        else 
        {
            $title = $this->notificationModel->getTitleWithoutAuthor($eventName, $eventData);
        }
        
        $message = "\[".(isset($eventData['project_name']) ? $eventData['project_name'] : $eventData['task']['project_name'])."]\n";
        $message .= $title."\n";
        
        if ($this->configModel->get('application_url') !== '') 
        {
            $message .= "[".$eventData['task']['title']."](";
            $message .= $this->helper->url->to('TaskViewController', 'show', array('task_id' => $eventData['task']['id'], 'project_id' => $project['id']), '', true);
            $message .= ")";
        }
        else
        {
            $message .= $eventData['task']['title'];
        }
        
        return array('chat_id' => $chat_id, 'text' => $message, 'parse_mode' => 'Markdown');
    }
    
    /**
     * Send message to Telegram
     *
     * @access protected
     * @param  string    $chat_id
     * @param  array     $project
     * @param  string    $eventName
     * @param  array     $eventData
     */
    protected function sendMessage($apikey, $bot_username, $chat_id, array $project, $eventName, array $eventData)
    {
        $data = $this->getMessage($chat_id, $project, $eventName, $eventData);
        try
        {
            // Create Telegram API object
            $telegram = new TelegramClass($apikey, $bot_username);

            // Send message
            $result = Request::sendMessage($data);
        } 
        catch (TelegramException $e) 
        {
            // log telegram errors
            // echo $e->getMessage();
        }
    }
}
