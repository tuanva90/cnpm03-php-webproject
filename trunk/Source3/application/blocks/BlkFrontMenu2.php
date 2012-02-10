<?php
class Block_BlkFrontMenu2 extends Zend_View_Helper_Abstract
{
    public function blkFrontMenu2 ()
    {
        $view = $this->view;
        $arrParam = $view->arrParam;
        try {
            $menu_data = Front_Model_Menu::makeMenu(null);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        require_once (APPLICATION_PATH . DS . DS . 'blocks' . DS .
         'BlkFrontMenu2' . DS . 'default.php');
    }
}