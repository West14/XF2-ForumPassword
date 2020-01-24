<?php

namespace West\ForumPassword\XF\Entity;

/**
 * Class Forum
 * @package West\ForumPassword\XF\Entity
 *
 * @property string wfp_password
 */

class Forum extends XFCP_Forum
{
    public function isPasswordAccessGranted()
    {
        $nodeId = $this->node_id;
        $data = \XF::session()->get('wfp_data');

        if ($data && isset($data[$nodeId]))
        {
            if (\XF\Util\Hash::hashText($this->wfp_password) == $data[$nodeId]) return true;
        }

        return false;
    }
}