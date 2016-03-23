<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour;


class SocketPresenter extends BasePresenter
{

    public function actionFree($socketId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        if(!$this->user->isInRole('manager') and !$this->user->isInRole('admin'))
        {
          $this->flashMessage('Nemáte oprávnění');
          $this->redirect('Homepage:default');
        }
        $this->socketFacade->freeSocket($socketId);
        $this->flashMessage('Přihrádka byla úspěšně uvolněna');
        $this->redirect('Socket:list');
    }

    public function renderFill()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        if(!$this->user->isInRole('manager') and !$this->user->isInRole('admin'))
        {
          $this->flashMessage('Nemáte oprávnění');
          $this->redirect('Homepage:default');
        }
        $this->template->sockets = $this->socketFacade->getOccupiedSocketsArray();
    }

    public function renderList()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }

    public function renderAssign($socketId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        if(!$this->user->isInRole('manager') and !$this->user->isInRole('admin'))
        {
          $this->flashMessage('Nemáte oprávnění');
          $this->redirect('Homepage:default');
        }
    }

    public function createComponentSocketListGrid($name)
    {
        $gridControl = new Model\Mesour\EmptyGridControl($this, $name);
        $grid = $gridControl->grid;
        $source = new Mesour\DataGrid\Sources\ArrayGridSource($this->socketFacade->getSocketsTable());

        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setSource($source);
        $grid->setDefaultOrder('position', 'ASC');
        $grid->addNumber('position', 'Pozice');
        $grid->addNumber('level', 'Patro');
        $grid->addText('part_name', 'Součástka');
        $grid->addNumber('amount', 'Počet');

        $link = new Mesour\Bridges\Nette\Link($this);

        $actions = $grid->addContainer('actions', 'Akce');
        $actions->addButton('assign')
            ->setType('success')
            ->setText('Přiřadit')
            ->setAttribute('href', $link->create('Socket:assign', array('socketId' => '{'.$primaryKey.'}')));
        $actions->addButton('free')
            ->setType('primary')
            ->setText('Uvolnit')
            ->setAttribute('href', $link->create('Socket:free', array('socketId' => '{'.$primaryKey.'}')));
        return $gridControl->create();
    }

    public function createComponentFillSocketForm()
    {
        $form = new Nette\Application\UI\Form;
        $sockets = $this->socketFacade->getOccupiedSocketsArray();
        foreach($sockets as $socket)
        {
            $form->addText('amount_'.$socket['id'])
                ->addRule(Nette\Application\UI\Form::INTEGER)
                ->setDefaultValue($socket['amount']);
            $form->addSubmit('submit_'.$socket['id'], 'Doplnit');
        }
        $form->onSuccess[] = $this->fillSocketFormSucceeded;
        $form->addProtection();
        return $form;
    }
    public function fillSocketFormSucceeded($form)
    {
        $sockets = $this->socketFacade->getOccupiedSocketsArray();
        $values = $form->getValues();
        foreach($sockets as $socket)
        {
            if(isset($this->request->post['submit_'.$socket['id']]) and $this->request->post['amount_'.$socket['id']] > 0)
            {
                $this->socketFacade->fillSocket($socket['id'], $this->request->post['amount_'.$socket['id']],
                $this->user->id);
                $this->flashMessage('Přihrádka byla úspěšně doplněna');
                $this->redirect('Socket:list');
                break;
            }
        }
    }
}
