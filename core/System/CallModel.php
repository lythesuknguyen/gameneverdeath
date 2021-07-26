<?php
namespace Packages\System;

class CallModel {
    use \Packages\System\Libs;

    public function Call($module, $page, $model){
        if(file_exists(ROOTPATH ."/mvc/model/$module/$page/$model.php")){
            return ROOTPATH ."/mvc/model/$module/$page/$model.php";
        }
    }
}
