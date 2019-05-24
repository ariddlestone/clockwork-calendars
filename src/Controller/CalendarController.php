<?php

namespace Riddlestone\Clockwork\Calendars\Controller;

use DateTime;
use DateTimeImmutable;
use Riddlestone\Clockwork\Calendars\Model\CalendarInterface;
use Riddlestone\Clockwork\Calendars\Model\ICalendar\Calendar;
use Riddlestone\Clockwork\Calendars\Model\Month;
use Zend\Http\Header\Accept;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class CalendarController
 * @package Riddlestone\Clockwork\Calendars
 *
 * @method Request getRequest()
 */
class CalendarController extends AbstractActionController
{
    /**
     * @var CalendarInterface[]
     */
    protected $calendars = [];

    /**
     * @var int
     */
    protected $weekStartsOn = 1;

    /**
     * @param CalendarInterface[] $calendars
     */
    public function setCalendars(array $calendars)
    {
        $this->calendars = $calendars;
    }

    /**
     * @param int $weekStartsOn
     */
    public function setWeekStartsOn(int $weekStartsOn)
    {
        $this->weekStartsOn = $weekStartsOn;
    }

    /**
     * Shows all calendar events in one year
     *
     * @return ViewModel|JsonModel
     */
    public function yearAction()
    {
        $year = $this->params('year', date('Y'));
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', sprintf('%u-01-01 00:00:00', $year));

        $months = [];
        while ($date->format('Y') == $year) {
            $months[] = $date;
            $date = $date->modify('+1 month');
        }

        return new ViewModel([
            'year' => sprintf('%04u', $year),
            'prevYear' => sprintf('%04u', $year - 1),
            'nextYear' => sprintf('%04u', $year + 1),
            'months' => $months,
        ]);
    }

    /**
     * Shows all calendar events in one month
     *
     * @return ViewModel|JsonModel
     * @throws \Exception
     */
    public function monthAction()
    {
        $year = (int)$this->params('year') ?: date('Y');
        $month = (int)$this->params('month') ?: date('n');

        $events = new Month($year, $month);
        foreach($this->calendars as $calendar) {
            $events->addEvents($calendar->getEvents($events->getFrom(), $events->getTo()));
        }

        $accept = $this->getRequest()->getHeaders()->get('Accept');
        if ($accept
            && ($accept instanceof Accept)
            && $accept->hasMediaType('application/json')
            && !$accept->hasMediaType('text/html')
        ) {
            return new JsonModel([
                'events' => $events,
            ]);
        }
        return new ViewModel([
            'events' => $events,
        ]);
    }
}
