<?php

namespace model;

interface EditObserver {
	public function redirectToHomePage();
	public function getRequestCurrentPassword();
	public function getRequestPassword();
	public function getRequestPasswordRepeat();
	public function getCookieUsername();
	public function setCookiePassword(string $password);
	public function setRequestMessage(string $message);
}