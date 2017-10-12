<?php

namespace view;

require_once(__DIR__ . '/../model/observers/RegisterObserver.php');

class RegisterView implements \model\RegisterObserver {

	private static $register = "RegisterView::Register";
	private static $registerName = "RegisterView::UserName";
	private static $registerPassword = "RegisterView::Password";
	private static $registerPasswordRepeat = "RegisterView::PasswordRepeat";
	private static $registerMessageId = "RegisterView::Message";

	public function showResponse(bool $isLoggedIn) : string
	{
		assert($isLoggedIn == false);

		$message = $this->getRequestMessage();
		$response = $this->generateRegisterFormHTML($message);

		return $response;
	}

	private function generateRegisterFormHTML($message) : string
	{
		return '
			<h2>Register new user</h2>
			<form method="post">
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$registerMessageId . '">' . $message . '</p>
			
					<label for="' . self::$registerName . '">Username :</label>
					<input type="text" name="' . self::$registerName . '" id="' . self::$registerName . '" value="' . $this->getRequestUserName() . '">
					<br>
			
					<label for="' . self::$registerPassword . '">Password  :</label>
					<input type="password" name="' . self::$registerPassword . '" id="' . self::$registerPassword . '" value="">
					<br>
			
					<label for="' . self::$registerPasswordRepeat . '">Repeat password  :</label>
					<input type="password" name="' . self::$registerPasswordRepeat . '" id="' . self::$registerPasswordRepeat . '" value="">
					<br>
			
					<input id="submit" type="submit" name="' . self::$register . '" value="Register">
					<br>
				</fieldset>
			</form>
		';
	}

	public function isRegister() : bool
	{
		return isset($_REQUEST[self::$register]);
	}

	public function isRequestUserName() : bool
	{
		return isset($_REQUEST[self::$registerName]);
	}

	public function isMessage() : bool
	{
		return isset($_REQUEST[self::$registerMessageId]);
	}

	public function getRequestUserName() : string
	{
		return (isset($_REQUEST[self::$registerName])) ? $_REQUEST[self::$registerName] : "";
	}

	public function getRequestPassword() : string
	{
		return $_REQUEST[self::$registerPassword];
	}

	public function getRequestPasswordRepeat() : string
	{
		return $_REQUEST[self::$registerPasswordRepeat];
	}

	public function getRequestMessage() : string
	{
		return (isset($_REQUEST[self::$registerMessageId])) ? $_REQUEST[self::$registerMessageId] : "";
	}

	public function setRequestMessage(string $message)
	{
		$_REQUEST[self::$registerMessageId] = $message;
	}

	public function setLastUsernameInput(string $username)
	{
		$_REQUEST[self::$registerName] = $username;
	}

	public function redirectToHomePage()
	{
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit;
	}
}


