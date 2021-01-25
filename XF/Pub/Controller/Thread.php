<?php

namespace West\ForumPassword\XF\Pub\Controller;

class Thread extends XFCP_Thread
{
    use ForumPasswordTrait;

    protected function assertViewableThread($threadId, array $extraWith = [])
    {
        $parent = parent::assertViewableThread($threadId, $extraWith);

        /** @var \West\ForumPassword\XF\Entity\Forum $forum */
        $forum = $parent->Forum;
        $this->checkForumPasswordAccess($forum);

        return $parent;
    }
}