<?php

namespace App\Presenters;

use Nette;
use App\Model;

class GetPartsPresenter extends BasePresenter
{
    public function renderDefault()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->template->sockets = $this->socketFacade->getOccupiedSocketsArray();
    }
    public function createComponentGetPartsForm()
    {
        $form = new Nette\Application\UI\Form;
        $socketsArray = $this->socketFacade->getOccupiedSocketsArray();
        foreach($socketsArray as $socket)
        {
            $form->addText('amount_'.$socket['id'])
                ->addRule(Nette\Application\UI\Form::INTEGER);
            $form->addSubmit('submit_'.$socket['id'], 'Vybrat');
        }
        $form->onSuccess[] = $this->getPartsFormSucceeded;
        $form->addProtection();
        return $form;
    }
    public function getPartsFormSucceeded($form)
    {
        $socketsArray = $this->socketFacade->getOccupiedSocketsArray();
        foreach($socketsArray as $socket)
		{
			if(isset($this->request->post['submit_'.$socket['id']]) and $this->request->post['amount_'.$socket['id']] > 0)
			{
				if($this->request->post['amount_'.$socket['id']] > $socket['available'])
				{
					$this->flashMessage("Není možné vybrat tolik součástek");
					$this->redirect("GetParts:default");
				}
                $this->queueFacade->request($this->socketFacade->get($socket['id']),
                                            $this->userFacade->get($this->getUser()->getId()),
                                            $this->request->post['amount_'.$socket['id']]);
				break;
			}
		}
    }
}