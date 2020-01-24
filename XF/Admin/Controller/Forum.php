<?php

namespace West\ForumPassword\XF\Admin\Controller;

use XF\Mvc\FormAction;

class Forum extends XFCP_Forum
{
	protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
    {
        parent::saveTypeData($form, $node, $data);

        $form->setup(function () use ($data)
        {
            $data->wfp_password = $this->filter('wfp_password', '?str');
        });
    }
}