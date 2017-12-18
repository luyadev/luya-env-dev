<?php

namespace luya\envdev\envdevcmd;

use luya\console\Command;
use luya\helpers\FileHelper;
use yii\helpers\Json;

class BaseCommand extends Command
{
    public $configFile = '@envdevroot/cachestorage.json';
    
    public function readConfig()
    {
        $data = FileHelper::getFileContent($this->configFile);
        
        if ($data) {
            return Json::decode($data);
        }
        
        return false;
    }
    
    public function getConfig($key)
    {
        $config = $this->readConfig();
        
        return isset($config[$key]) ? $config[$key] : false;
    }
    
    public function saveConfig($key, $value)
    {
        $content = $this->readConfig();
     
        if (!$content) {
            $content = [];
        }
        
        $content[$key] = $value;
        
        $save = FileHelper::writeFile($this->configFile, Json::encode($content));
        
        if (!$save) {
            return $this->outputError("Unable to find config file " . $this->configFile. ". Please create and provide Permissions.");
        }
        
        return $value;
    }
}