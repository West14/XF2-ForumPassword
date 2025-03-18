<?php

namespace West\ForumPassword\XF\Pub\Controller;

use West\ForumPassword\XF\Entity\Forum;

class ThreadController extends XFCP_ThreadController
{
    use ForumPasswordTrait;

    protected function assertViewableThread($threadId, array $extraWith = [])
    {
        $parent = parent::assertViewableThread($threadId, $extraWith);

        /** @var Forum $forum */
        $forum = $parent->Forum;
        $this->checkForumPasswordAccess($forum);

        return $parent;
    }
}