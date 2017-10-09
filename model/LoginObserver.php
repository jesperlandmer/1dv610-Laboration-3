<?php

namespace model;

interface LoginObserver {
	public function getRequestUsername();
	public function getRequestPassword();
	public function setRequestMessage(string $message);
}