<?php

namespace West\ForumPassword\XF\Admin\Controller;

use XF\Mvc\FormAction;

class ForumController extends XFCP_ForumController
{
    protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
    {
        parent::saveTypeData($form, $node, $data);

        $data->wfp_password = $this->filter('wfp_password', '?str');
    }
}