<?php

namespace Riddlestone\Clockwork\Calendars\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class EventController extends AbstractActionController
{
    /**
     * Shows a single event
     *
     * @return ViewModel|JsonModel
     */
    public function viewAction()
    {
        return new ViewModel();
    }
}
