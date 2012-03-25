<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 24.12.11
 * Time: 17:14
 * To change this template use File | Settings | File Templates.
 */
namespace Client\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CurrentInfo extends AbstractHelper {

    public function __invoke($appeal_id = null){

        if (is_null($appeal_id)) return;
        $view = $this->getView();
        $locator = $view->getBroker()->getLocator();
        $appealTable = $locator->get('Product\Model\AppealTable');
        $vars = array();
        $vars = $appealTable->getClientByAppeal((int)$appeal_id);
        
        return $view->render('client/current-info-block.phtml',$vars);
    }


}
