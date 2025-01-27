<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber\Actions;

use App\Event\PageActionsEvent;

class PermissionsSubscriber extends AbstractActionsSubscriber
{
    public static function getActionName(): string
    {
        return 'user_permissions';
    }

    public function onActions(PageActionsEvent $event): void
    {
        // the "create role" page
        if (!$event->isIndexView() && $this->isGranted('role_permissions')) {
            //$event->addBack($this->path('admin_user_permissions'));
        }

        if ($this->isGranted('role_permissions')) {
            $event->addCreate($this->path('admin_user_roles'), !$event->isView('role'));
        }

        $event->addHelp($this->documentationLink('permissions.html'));
    }
}
