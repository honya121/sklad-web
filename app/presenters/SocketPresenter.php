<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour\DataGrid\Grid,
    Mesour\DataGrid\Components\Link,
    Mesour\DataGrid\ArrayDataSource;


class SocketPresenter extends BasePresenter
{

    public function actionFree($socketId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
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
    }
    
    public function createComponentSocketListGrid($name)
    {
        $grid = new Grid($this, $name);
        
        $source = new ArrayDataSource($this->socketFacade->getSocketsTable());
        
        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setDataSource($source);
        $grid->setDefaultOrder('position', 'ASC');
        $grid->addNumber('position', 'Pozice');
        $grid->addNumber('level', 'Patro');
        $grid->addText('part_name', 'Součástka');
        $grid->addNumber('amount', 'Počet');
        
        $actions = $grid->addActions('');
        $actions->addButton()
            ->setType('btn-success')
            ->setText('Přiřadit')
            ->setAttribute('href', new Link('Socket:assign', array('socketId' => '{'.$primaryKey.'}')));
        $actions->addButton()
            ->setType('btn-primary')
            ->setText('Uvolnit')
            ->setAttribute('href', new Link('Socket:free', array('socketId' => '{'.$primaryKey.'}')));
        return $grid;
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
