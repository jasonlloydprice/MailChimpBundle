<?php

namespace Pombai\MailChimpBundle\Service;

class MailChimp 
{
    protected $listId;
    protected $apiKey;
    protected $errorCode;
    protected $errorMessage;
    protected $campaignId;
    protected $testCampaign;
    /**
     * @param array $listId 
     */
    function __construct($listId, $apiKey)
    {
        $this->listId = $listId;
        $this->apiKey = $apiKey;
    }

    function getErrorCode()
    {
        return $this->errorCode;
    }

    function getErrorMessage()
    {
        return $this->errorMessage;
    }

    function hasErrors()
    {
        return $this->errorCode != null ? true : false;
    }

    function getCampaignId()
    {
        return $this->campaignId;
    }

    function getListId()
    {
        return $this->listId;
    }

    function campaignCreate($email, $opts)
    {
        $api = new \MCAPI($this->apiKey);
        $type = 'regular';

        $opts['list_id'] = $this->listId;
        $opts['subject'] = 'Pombai newsletter';
        $opts['from_email'] = 'info@pombai.com'; 
        $opts['from_name'] = 'Pombai';
        $opts['title'] =  'Pombai newsletter '.date('Y-m-d');

        $content = array('html'=>'<html></html>', 
                  'text' => 'text'
                );

        $this->campaignId = $api->campaignCreate($type, $opts, $content);

        if ($api->errorCode){
            $this->errorCode = $api->errorCode;
            $this->errorMessage = $api->errorMessage;
        }  
        else{
            $emails = array('jason.price14@gmail.com');
            $this->testCampaign = $api->campaignSendTest($this->campaignId, $emails);      
        }
        return $this;        
    }
}