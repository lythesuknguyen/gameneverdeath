<?php
namespace Packages\System;

class CallView {

    use \Packages\System\Libs;
    

    public function PortalView($module, $page, $view, $params = array())
    {
        if(file_exists(ROOTPATH. "/mvc/view/$module/pages/$page/$view.php"))
        {  
            if(isset($params))
            {
                require $params;
            }    
            require ROOTPATH. "/mvc/view/$module/layout/header.php";
            require ROOTPATH. "/mvc/view/$module/layout/menu.php";
            require ROOTPATH. "/mvc/view/$module/pages/$page/$view.php";
            require ROOTPATH. "/mvc/view/$module/layout/footer.php";
        } else 
        {
            echo $this->SysMsg('Failed to load view');  
        }
        
    }

    function LandingView($module, $page, $view, $params = array())
    {
        if(file_exists(ROOTPATH. "/mvc/view/$module/content/$page/$view.php"))
        {  
            if(isset($params))
            {
                require $params;
            }  
            require ROOTPATH. "/mvc/view/$module/layout/header.php";  
            require ROOTPATH. "/mvc/view/$module/content/$page/$view.php";
            require ROOTPATH. "/mvc/view/$module/layout/footer.php"; 
        } else 
        {
            echo $this->SysMsg('Failed to load view');  
        }
    }

    function AdminView()
    {

    }

}
