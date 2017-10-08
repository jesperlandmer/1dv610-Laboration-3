<?php

namespace model;

interface UserObserver {
	public function getRequestUsername(PersistantUser $user);
	public function getRequestErrors(PersistantUser $user);
}