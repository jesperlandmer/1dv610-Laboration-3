<?php

namespace controller;

require_once(__DIR__ . '/../model/SearchModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class SearchController
{
    public function __construct()
    {
        $this->searchModel = new \model\SearchModel();
        $this->loginView = new \view\LoginView();
        
		if ($this->loginView->isRequestSearch()) {
            $this->searchModel->newSearch($this->loginView);
        }
    }
}
