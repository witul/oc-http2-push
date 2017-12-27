<?php namespace Infoadvisor\Push\Classes;

use Url;
use Cms\Classes\Theme;
use Cms\Classes\Asset;

class PushService{
    protected $assets=[
//        'css'=>[],
//        'js'=>[]
    ];
    protected $theme;
    protected $asset;

    protected function calculateChecksum($file){
        return substr(md5_file($file),0,8);
    }

    public function __construct(){
        $this->theme=Theme::getActiveTheme();
        $this->asset=new Asset($this->theme);
    }

    public function addJs($path){
        $this->addAsset($path,'js');
    }

    public function assetsDiff($current){
        return array_diff_assoc($this->assets,$current);
    }

    public function addAsset($path,$type=null){

        if(!array_key_exists($path,$this->assets)){
            $filepath=$this->asset->getFilePath($path);
            $urlPath='/themes/'.$this->theme->getDirName().'/assets/'.$path;
            $this->assets[$urlPath]=$this->calculateChecksum($filepath);
//                'type'=>$type
        }
    }

    public function listData(){
            return $this->assets;
//        else return
    }
}


