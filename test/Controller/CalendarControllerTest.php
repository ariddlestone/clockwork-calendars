<?php

namespace Riddlestone\Clockwork\Calendars\Test\Controller;

use Zend\Http\Header\ContentType;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class CalendarControllerTest
 * @package Riddlestone\Clockwork\Calendars\Test
 *
 * @method Request getRequest()
 * @method Response getResponse()
 */
class CalendarControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp()
    {
        $this->traceError = true;
        $this->setApplicationConfig(include __DIR__ . '/../application.config.php');
        parent::setUp();
    }

    /**
     * @throws \Exception
     */
    public function testCurrentMonthAction()
    {
        $this->dispatch('/calendar');
        $this->assertMatchedRouteName('calendar');
        $this->assertResponseStatusCode(200);
    }

    /**
     * @throws \Exception
     */
    public function testYearAction()
    {
        $this->dispatch('/calendar/2019');
        $this->assertMatchedRouteName('calendar/year');
        $this->assertResponseStatusCode(200);
    }

    /**
     * @throws \Exception
     */
    public function testMonthAction()
    {
        $this->dispatch('/calendar/2019/01');
        $this->assertMatchedRouteName('calendar/month');
        $this->assertResponseStatusCode(200);
    }

    /**
     * @throws \Exception
     */
    public function testMonthJsonAction()
    {
        $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
        $this->dispatch('/calendar/2019/01');
        $this->assertMatchedRouteName('calendar/month');
        $this->assertResponseStatusCode(200);
        $this->assertHasResponseHeader('Content-Type');
        /** @var ContentType $contentType */
        $contentType = $this->getResponse()->getHeaders()->get('Content-Type');
        $this->assertEquals('application/json', $contentType->getMediaType());
    }
}
