<?php

namespace Riddlestone\Clockwork\Calendars\Model;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * Class Month
 * @package Riddlestone\Clockwork\Calendars
 */
class Month
{
    /**
     * @var int
     */
    protected $year;

    /**
     * @var int
     */
    protected $month;

    /**
     * @var DateTimeImmutable
     */
    protected $from;

    /**
     * @var DateTimeImmutable
     */
    protected $to;

    /**
     * @var EventInterface[]
     */
    protected $events;

    /**
     * @var bool
     */
    protected $eventsSorted = false;

    /**
     * Month constructor.
     * @param int $year
     * @param int $month
     * @param int $weekStartsOn
     * @throws \Exception
     */
    public function __construct(int $year, int $month, int $weekStartsOn = 1)
    {
        $this->year = $year;
        $this->month = $month;

        $from = new DateTime();
        $from->setTime(0, 0, 0);
        $from->setDate($year, $month, 1);
        $from->modify(sprintf('-%u days', (7 - $this->getWeekdayDifference($from->format('N'), $weekStartsOn)) % 7));

        $to = new DateTime();
        $to->setTime(23, 59, 59);
        $to->setDate($year, $month + 1, 0);
        $to->modify(sprintf('+%u days', $this->getWeekdayDifference($to->format('N'), ($weekStartsOn + 6))));

        $this->from = DateTimeImmutable::createFromMutable($from);
        $this->to = DateTimeImmutable::createFromMutable($to);
        $this->events = [];
    }

    protected function getWeekdayDifference($fromDay, $toDay)
    {
        $diff = ($toDay - $fromDay) % 7;
        return $diff >= 0 ? $diff : $diff + 7;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getFrom(): DateTimeImmutable
    {
        return $this->from;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTo(): DateTimeImmutable
    {
        return $this->to;
    }

    /**
     * @param EventInterface $event
     */
    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
        $this->eventsSorted = false;
    }

    /**
     * @param EventInterface[] $events
     */
    public function addEvents(array $events)
    {
        $this->events = array_merge($this->events, $events);
        $this->eventsSorted = false;
    }

    /**
     * @return DateTimeImmutable[]
     */
    public function getDates()
    {
        $dates = [];
        $date = $this->getFrom();
        while ($date < $this->getTo()) {
            $dates[] = $date;
            $date = $date->modify('+1 day');
        }
        return $dates;
    }

    /**
     * @param DateTimeInterface|null $date
     * @return EventInterface[]
     */
    public function getEvents(DateTimeInterface $date = null)
    {
        if(!$this->eventsSorted) {
            $this->sortEvents();
        }
        if (!$date) {
            return $this->events;
        }
        $end = DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'), $date->getTimezone());
        $end->modify('+1 day');
        $events = [];
        foreach($this->events as $event) {
            if($event->getStart() >= $end) {
                // we're past the day we're looking for
                break;
            }
            if($event->getStart() < $end && $event->getEnd() >= $date) {
                $events[] = $event;
            }
        }
        return $events;
    }

    /**
     * @return bool
     */
    protected function sortEvents()
    {
        return $this->eventsSorted = usort($this->events, function($a, $b){
            /**
             * @var EventInterface $a
             * @var EventInterface $b
             */
            return $a->getStart() <=> $b->getStart();
        });
    }
}
