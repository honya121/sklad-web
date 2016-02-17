<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Mesour\DataGrid\Grid,
    Mesour\DataGrid\Components\Link,
    Mesour\DataGrid\ArrayDataSource;


class PartPresenter extends BasePresenter
{

	public function renderList()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }
    
    public function renderNew()
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }
    
    public function renderEdit($partId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
    }
    
    public function actionDelete($partId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->partFacade->deletePart($partId);
        $this->flashMessage('Součástka byla vymazána');
        $this->redirect('Part:list');
    }
    
    public function renderAssign($partId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->template->part = $this->partFacade->get($partId);
    }
    
    public function actionAssign2($partId, $socketId)
    {
        if(!$this->user->isLoggedIn())
        {
            $this->redirect('Login:default');
        }
        $this->socketFacade->assignPart($socketId, $partId);
        $this->flashMessage('Součástka byla úspěšně přiřazena do přihrádky');
        $this->redirect('Socket:list');
    }
    public function createComponentPartListGrid($name)
    {
        $source = new ArrayDataSource($this->partFacade->getPartsTable());
        
        $grid = new Grid($this, $name);
        
        $primaryKey = 'id';
        $grid->setDataSource($source);
        $grid->setPrimaryKey($primaryKey);
        
        $grid->addText('name', 'Název');
        $grid->addNumber('width', 'Šířka');
        $grid->addNumber('length', 'Délka');
        $grid->addText('description', 'Popis');
        
        $actions = $grid->addActions('');
        
        $actions->addButton()
            ->setType('btn-success')
            ->setText('Přiřadit')
            ->setAttribute('href', new Link('Part:assign', array('partId' => '{'.$primaryKey.'}')));
        $actions->addButton()
            ->setType('btn-primary')
            ->setText('Upravit')
            ->setAttribute('href', new Link('Part:edit', array('partId' => '{'.$primaryKey.'}')));
        $actions->addButton()
            ->setType('btn-danger')
            ->setText('Smazat')
            ->setAttribute('href', new Link('Part:delete', array('partId' => '{'.$primaryKey.'}')));
            
        return $grid;
    }
    
    public function createComponentNewPartForm()
    {
        $form = new Nette\Application\UI\Form;
        $form->addText('name', 'Název')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Název musí být vyplněn');
        $form->addText('width', 'Šířka')
            ->addRule(Nette\Application\UI\Form::INTEGER, 'Šířka musí být číslo');
        $form->addText('length', 'Délka')
            ->addRule(Nette\Application\UI\Form::INTEGER, 'Délka musí být číslo');
        $form->addText('description', 'Popis');
        $form->addSubmit('submit', 'Vytvořit');
        
        $form->onSuccess[] = $this->newPartFormSucceeded;
        $form->addProtection();
        return $form;
    }
    public function newPartFormSucceeded($form)
    {
        $values = $form->getValues();
        $this->partFacade->addPart($values);
        $this->flashMessage('Nová součástka byla úspěšně vytvořena');
        $this->redirect('Part:list');
    }
    
    public function createComponentEditPartForm()
    {
        $partId = $this->getParameter('partId');
        $part = $this->partFacade->get($partId);
        $form = new Nette\Application\UI\Form;
        $form->addText('name', 'Název')
            ->addRule(Nette\Application\UI\Form::FILLED, 'Název musí být vyplněn')
            ->setDefaultValue($part->name);
        $form->addText('width', 'Šířka')
            ->addRule(Nette\Application\UI\Form::INTEGER, 'Šířka musí být číslo')
            ->setDefaultValue($part->width);
        $form->addText('length', 'Délka')
            ->addRule(Nette\Application\UI\Form::INTEGER, 'Délka musí být číslo')
            ->setDefaultValue($part->length);
        $form->addText('description', 'Popis')
            ->setDefaultValue($part->description);
        $form->addSubmit('submit', 'Upravit');
        
        $form->onSuccess[] = $this->editPartFormSucceeded;
        $form->addProtection();
        return $form;
    }
    public function editPartFormSucceeded($form)
    {
        $partId = $this->getParameter('partId');
        $values = $form->getValues();
        $this->partFacade->updatePart($partId, $values);
        $this->flashMessage('Součástka byla úspěšně změněna');
        $this->redirect('Part:list');
    }
    
    public function createComponentAssignPartGrid($name)
    {
        $partId = $this->getParameter('partId');
        $source = new ArrayDataSource($this->socketFacade->getFreeSocketsTable());
        $grid = new Grid($this, $name);
        
        $primaryKey = 'id';
        $grid->setPrimaryKey($primaryKey);
        $grid->setDataSource($source);
        
        $grid->addNumber('position', 'Pozice');
        $grid->addNumber('level', 'Patro');
        
        $actions = $grid->addActions('');
        
        $actions->addButton()
            ->setType('btn-success')
            ->setText('Přiřadit')
            ->setAttribute('href', new Link('Part:assign2', array('partId' => $partId, 'socketId' => '{'.$primaryKey.'}')));
        
        return $grid;
        
    }    
}
