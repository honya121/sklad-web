<?php

namespace App\Presenters;

class HomepagePresenter extends BasePresenter
{
    public function renderDefault()
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect('GetParts:simple');
        } else {
            $this->flashMessage('Nejste přihlášeni');
            $this->redirect('Login:default');
        }
    }

    public function actionAdd()
    {
        $this->userFacade->addUser(
            'honya121',
            'qweasd',
            'admin',
            'Jan Priessnitz',
            'honya121@gmail.com'
        );
        $this->redirect('Homepage:default');
    }

    public function actionInitialize()
    {
        $this->socketFacade->initialize();
        $this->redirect('Homepage:default');
    }
}
