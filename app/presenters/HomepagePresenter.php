<?php

namespace App\Presenters;

use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
        if($this->user->isLoggedIn())
        {
            $this->redirect('GetParts:default');
        }
        else
        {
            $this->flashMessage('Nejste přihlášeni');
            $this->redirect('Login:default');
        }
	}

}
