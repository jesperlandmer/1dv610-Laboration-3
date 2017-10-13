<?php

namespace model;

require_once("PersistantUser.php");
require_once("DatabaseModel.php");

class SearchModel
{

    private $searchedForUser;
    private $loginObserver;

    public function __construct()
    {
        $this->dbModel = new DatabaseModel();
    }

    public function newSearch(LoginObserver $observer)
    {
        $this->loginObserver = $observer;
        $this->searchedForUser = $observer->getRequestUsername();
        $this->executeSearch();
    }

    private function executeSearch()
    {
        if ($this->isUsernameInput() == false) {

            $this->doErrorNoUsername();
        } elseif ($this->isValidFormat() == false) {

            $this->doErrorInvalidFormat();
        } elseif ($this->existsSearchedForUser() == false) {

            $this->doErrorNoResult();
        } else {

            $this->searchSuccessful();
        }
    }

    private function doErrorNoUsername()
    {
      $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoUserNameInput);
    }

    private function doErrorInvalidFormat()
    {
      $this->loginObserver->setRequestMessage(\view\MessageView::ErrorInvalidFormat);
    }

    private function doErrorNoResult()
    {
      $this->loginObserver->setRequestMessage(\view\MessageView::ErrorSearchUsername);
    }

    private function searchSuccessful()
    {
        $result = \view\MessageView::SearchSuccessful . $this->getSearchedForUserName();
        $this->loginObserver->setRequestMessage($result);
    }

    private function isUsernameInput() : bool
    {
        return strlen($this->searchedForUser) > 0;
    }

    private function isValidFormat() : bool
    {
        return filter_var($this->searchedForUser, FILTER_SANITIZE_STRING) == $this->searchedForUser;
    }

    private function existsSearchedForUser() : bool
    {
      return $this->getSearchedForUserRow()->rowCount() > 0;
    }

    private function getSearchedForUserRow() : \PDOStatement
    {
      return $this->dbModel->getUserFromDatabase($this->searchedForUser);
    }

    private function getSearchedForUserName() : string
    {
      return $this->dbModel->getDBUserUsername($this->searchedForUser);
    }
}
