<?php

namespace LCM\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_admin")
     * @Template()
     */
    public function indexAction()
    {
        $dirname = '../src/LCM/AdminBundle/Entity/';
        $dir = opendir($dirname);
        
        $list = Array();
        
        while($file = readdir($dir)) {
            if($file != '.' && $file != '..' && !is_dir($dirname.$file) && substr($file, -4) != "php~")
            {
                $list[] = substr($file, 0, -4);
            }
        }
        
        closedir($dir);
        
        sort($list);
        
        return array("entities" => $list);
    }
}
