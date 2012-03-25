<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Shandy
 * Date: 24.12.11
 * Time: 17:14
 * To change this template use File | Settings | File Templates.
 */
namespace AppUser\View\Helper;

use Zend\View\Helper\AbstractHelper;

class UserInfo extends AbstractHelper {

    public function __invoke(){
        $html = '';
        $auth = $this->getView()->getBroker()->getLocator()->get('auth-service');
        if ($auth->hasIdentity()){
            $info = $auth->getIdentity();
            $logout = $this->getView()->url('default', array('controller' => 'user', 'action' => 'logout'));
            $html =<<<HTML
<div id="accountBox">
  <ul>
    <li>Пользователь: <span>{$info['login']}</span></li>
    <li><span><a class="btn" href="{$logout}">Выйти</a></span></li>
  </ul>
</div>
HTML;
            /*
             *
             <div id="user-panel">
             <span class="info">Вы зашли как <strong>{$info['login']}</strong>,<br>{$info['branch_name']}</span>
             <span><a class="btn" href="{$logout}">Выйти</a></span>
             </div>
             */

        } else {
            $html = '';
        }
        return $html;

    }


}
