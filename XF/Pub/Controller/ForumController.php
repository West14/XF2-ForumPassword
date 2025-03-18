<?php

namespace West\ForumPassword\XF\Pub\Controller;

use XF\Entity\Forum;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

class ForumController extends XFCP_ForumController
{
    use ForumPasswordTrait;

    public function actionPassword(ParameterBag $params): AbstractReply
    {
        $forum = $this->assertRecordExists(Forum::class, $params->node_id);

        if (!$forum) return $this->notFound();

        $redirectUrl = $this->getDynamicRedirectIfNot(
            $this->buildLink('canonical:forums/password', $forum),
            $this->buildLink('forums', $forum)
        );

        if (!$forum->wfp_password || $forum->isPasswordAccessGranted())
            return $this->redirect($redirectUrl);

        if ($this->isPost())
        {
            $session = \XF::app()->session();
            $data = $session->get('wfp_data');

            is_array($data) ?: $data = [];
            $data[$forum->node_id] = $this->filter('password', 'str');

            $session->set('wfp_data', $data);
            return $this->redirect($redirectUrl);
        }
        else
        {
            return $this->view('West\ForumPassword:Forum\Password', 'wfp_forum_password', [
                'forum' => $forum,
                'threadId' => $params->threadId ?? null
            ]);
        }
    }

    protected function assertViewableForum($nodeIdOrName, array $extraWith = [])
    {
        /** @var \West\ForumPassword\XF\Entity\Forum $parent */
        $parent = parent::assertViewableForum($nodeIdOrName, $extraWith);

        $this->checkForumPasswordAccess($parent);

        return $parent;
    }
}