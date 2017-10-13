<?php

namespace view;

require_once(__DIR__ . '/../model/observers/EditObserver.php');
require_once("LoginView.php");

class EditView implements \model\EditObserver {

	private static $edit = "EditView::Edit";
	private static $currentPassword = "EditView::CurrentPassword";
	private static $password = "EditView::Password";
	private static $passwordRepeat = "EditView::PasswordRepeat";
	private static $cookieName = "LoginView::CookieName";
	private static $messageId = "EditView::Message";

	public function __construct()
	{
		$this->loginView = new LoginView();
	}

	public function showResponse(bool $isLoggedIn) : string
	{
		assert($isLoggedIn == true);

		$message = $this->getRequestMessage();
		$response = $this->generateEditFormHTML($message);

		return $response;
	}
	
	private function generateEditFormHTML(string $message) : string
	{
		return '
			<form method="post" > 
				<fieldset>
					<legend>Change Password - enter Current and New Password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$currentPassword . '">Current Password :</label>
					<input type="password" id="' . self::$currentPassword . '" name="' . self::$currentPassword . '" />
					<br>

					<label for="' . self::$password . '">New Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<br>

					<label for="' . self::$passwordRepeat . '">Repeat Password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
					<br>
					
					<input type="submit" name="' . self::$edit . '" value="Save changes" />
				</fieldset>
			</form>
		';
	}

	public function isRequestEdit() : bool
	{
		return isset($_REQUEST[self::$edit]);
	}

	public function getCookieUsername() : string
	{
		return $this->loginView->getCookieUsername();
	}

	public function setCookiePassword(string $password)
	{
		echo $password;
		$this->loginView->updateCookiePassword($password);
		echo var_dump($_COOKIE);
	}

	public function getRequestCurrentPassword() : string
	{
		return $_REQUEST[self::$currentPassword];
	}

	public function getRequestPassword() : string
	{
		return $_REQUEST[self::$password];
	}

	public function getRequestPasswordRepeat() : string
	{
		return $_REQUEST[self::$passwordRepeat];
	}

	public function getRequestMessage() : string
	{
		return (isset($_REQUEST[self::$messageId])) ? $_REQUEST[self::$messageId] : "";
	}

	public function setRequestMessage(string $message)
	{
		$_REQUEST[self::$messageId] = $message;
	}

	public function redirectToHomePage()
	{
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit;
	}
}