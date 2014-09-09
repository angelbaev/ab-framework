<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author gatakka
 */
namespace Controllers;
class Index extends \ABPHPF\Controller{
    public function index2(){        
        
        $view=  \ABPHPF\View::getInstance();
        $view->username='gatakka1111';
        $view->append('body','admin.index');
        $view->append('body2','index');
        $view->render('layouts.admin.default',array('c'=>array(1,2,3,4,8)),false);        
    }
}

