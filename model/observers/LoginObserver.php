<?php

namespace model;

interface LoginObserver {
	public function refreshPage();
	public function getRequestUsername();
	public function getRequestPassword();
	public function setCookieCredentials(string $username, string $password);
	public function setRequestMessage(string $message);
}