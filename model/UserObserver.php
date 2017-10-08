<?php

namespace model;

/**
 * Model observer
 */
interface UserObserver {
	public function saveUserToDatabase(string $username, string $password);
	public function getUserFromDatabase(string $username);
}