<?php
/**
 * Created by PhpStorm.
 * User: Andriy
 * Date: 25.01.2021
 * Time: 13:55
 * Made with <3 by West from TechGate Studio
 */

namespace West\ForumPassword\XF\Pub\Controller;


trait ForumPasswordTrait
{
    protected function checkForumPasswordAccess(\West\ForumPassword\XF\Entity\Forum $forum)
    {
        if ($forum->wfp_password)
        {
            if (\XF::visitor()->hasPermission('general', 'wfpAccessProtectedNodes'))
            {
                if (!$forum->isPasswordAccessGranted())
                {
                    throw $this->exception(
                        $this->rerouteController(
                            'XF:Forum',
                            'Password',
                            $forum->toArray()
                        )
                    );
                }
            }
            else
            {
                throw $this->exception($this->noPermission());
            }
        }
    }
}