<?php

namespace model;

interface RegisterObserver {
	public function redirectToHomePage();
	public function getRequestUsername();
	public function getRequestPassword();
	public function getRequestPasswordRepeat();
	public function setRequestMessage(string $message);
}