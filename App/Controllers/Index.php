<?php

namespace App\Controllers;

use UNIS\Controller\Action;
use UNIS\Di\Container;
use App\Models\TaskResult;
use App\Models\TaskFormat;

class Index extends Action
{
	private $task;
	private $form;

	public function __construct()
	{
		parent::__construct();
		$this->task = Container::getClass('task');
		$this->form = Container::getClass('form');
	}

	public function index()
	{
		if(!is_null($this->getParam())) {
			$this->view->result = $this->getParam();
		}

		$this->view->taskList = $this->task->fetchAll();
		TaskFormat::taskListFormat($this->view->taskList);

		$this->form->setAction('index');
		$this->view->form = $this->form;
		
		$this->render('index');
	}

	public function add()
	{
		$addResult = TaskResult::ADD_OK;
		if($this->task->add($_POST) !== true) {
			$addResult = TaskResult::ADD_ERROR;
		}
		
		$this->redirect("/index/{$addResult}");
	}

	public function edit()
	{
		$this->view->taskEdit = $this->task->find($this->getParam());

		if($this->view->taskEdit == false) {
			$this->redirect("/index");
		}

		$this->form->setAction('edit');
		$this->view->form = $this->form;

		$this->render('edit');
	}

	public function update()
	{
		$result = $this->task->update($_POST, $_POST['id']);
		
		$editResult = TaskResult::EDIT_ERROR;
		if($result === 1) {
			$editResult = TaskResult::EDIT_OK;
		}
		if($result === 0) {
			$editResult = null;
		}
		
		$this->redirect("/index/{$editResult}");
	}

	public function delete()
	{
		$result = $this->task->delete($this->getParam());

		$deleteResult = TaskResult::DELETE_ERROR;
		if($result === 1) {
			$deleteResult = TaskResult::DELETE_OK;
		}
		if($result === 0) {
			$deleteResult = null;
		}

		$this->redirect("/index/{$deleteResult}");

	}
}