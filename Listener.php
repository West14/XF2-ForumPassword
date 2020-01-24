<?php
/**
 * Created by PhpStorm.
 * User: Andriy
 * Date: 1/24/2020
 * Time: 17:45
 * Made with <3 by West from TechGate Studio
 */

namespace West\ForumPassword;


use XF\Mvc\Entity\Entity;

class Listener
{
    public static function forumEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->columns['wfp_password'] = ['type' => Entity::STR, 'maxLength' => 64, 'nullable' => true, 'default' => null];
    }
}