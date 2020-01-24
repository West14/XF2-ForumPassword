<?php

namespace West\ForumPassword\XF\Pub\Controller;

class Thread extends XFCP_Thread
{
	protected function assertViewableThread($threadId, array $extraWith = [])
    {
        $parent = parent::assertViewableThread($threadId, $extraWith);

        $forum = $parent->Forum;
        if ($forum->wfp_password)
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

        return $parent;
    }
}