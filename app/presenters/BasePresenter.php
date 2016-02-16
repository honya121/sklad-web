<?php

namespace App\Presenters;

use Nette;
use App\Model;
use App\Model\Facade;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected $historyFacade;
    protected $partFacade;
    protected $queueFacade;
    protected $socketFacade;
    protected $userFacade;
    
    public function injectFacades(Facade\HistoryFacade $historyFacade,
                                  Facade\PartFacade $partFacade,
                                  Facade\QueueFacade $queueFacade,
                                  Facade\SocketFacade $socketFacade,
                                  Facade\UserFacade $userFacade)
    {
        $this->historyFacade = $historyFacade;
        $this->partFacade = $partFacade;
        $this->queueFacade = $queueFacade;
        $this->socketFacade = $socketFacade;
        $this->userFacade = $userFacade;
    }
}
