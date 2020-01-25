<?php

namespace West\ForumPassword\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionPassword(ParameterBag $params)
    {
        /** @var \West\ForumPassword\XF\Entity\Forum|null $forum */
        $forum = $this->assertRecordExists('XF:Forum', $params->node_id);

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

        if ($parent->wfp_password)
        {
            if (!$parent->isPasswordAccessGranted())
            {
                throw $this->exception(
                    $this->rerouteController(
                        'XF:Forum',
                        'Password',
                        $parent->toArray()
                    )
                );
            }
        }

        return $parent;
    }
}