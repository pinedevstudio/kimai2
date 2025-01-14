<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Controller\Reporting;

use App\Entity\User;
use App\Tests\Controller\ControllerBaseTest;
use App\Tests\DataFixtures\ActivityFixtures;
use App\Tests\DataFixtures\CustomerFixtures;
use App\Tests\DataFixtures\ProjectFixtures;
use App\Tests\DataFixtures\TimesheetFixtures;

/**
 * @group integration
 */
class ProjectViewControllerTest extends ControllerBaseTest
{
    public function testProjectViewIsSecure()
    {
        $this->assertUrlIsSecured('/reporting/project_view');
    }

    public function testProjectViewReport()
    {
        $client = $this->getClientForAuthenticatedUser(User::ROLE_ADMIN);

        $customers = new CustomerFixtures();
        $customers->setIsVisible(true);
        $customers->setAmount(1);
        $customers = $this->importFixture($customers);

        $projects = new ProjectFixtures();
        $projects->setCustomers($customers);
        $projects->setAmount(2);
        $projects->setIsVisible(true);
        $projects = $this->importFixture($projects);

        $activities = new ActivityFixtures();
        $activities->setAmount(5);
        $activities->setIsGlobal(true);
        $activities = $this->importFixture($activities);

        $timesheets = new TimesheetFixtures();
        $timesheets->setAmount(50);
        $timesheets->setActivities($activities);
        $timesheets->setUser($this->getUserByRole(User::ROLE_TEAMLEAD));
        $this->importFixture($timesheets);

        $this->assertAccessIsGranted($client, '/reporting/project_view');
        self::assertStringContainsString('<div class="box-body project-view-reporting-box', $client->getResponse()->getContent());
        $rows = $client->getCrawler()->filterXPath("//table[@id='dt_project_view_reporting']/tbody/tr");
        self::assertGreaterThan(0, $rows->count());
    }
}
