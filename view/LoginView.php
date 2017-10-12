<?php

namespace view;

require_once(__DIR__ . '/../model/observers/LoginObserver.php');

class LoginView implements \model\LoginObserver {

	private static $login = "LoginView::Login";
	private static $logout = "LoginView::Logout";
	private static $name = "LoginView::UserName";
	private static $password = "LoginView::Password";
	private static $cookieName = "LoginView::CookieName";
	private static $cookiePassword = "LoginView::CookiePassword";
	private static $keep = "LoginView::KeepMeLoggedIn";
	private static $messageId = "LoginView::Message";

	public function __construct(\model\LoginModel $loginModel) 
	{
		$this->loginModel = $loginModel;
	}

	public function showResponse(bool $isLoggedIn) : string
	{
		$message = $this->getRequestMessage();
		$response = $this->generateLoginFormHTML($message);

		if ($isLoggedIn) {
			$response = $this->generateLogoutButtonHTML($message);
		}

		return $response;
	}

	private function generateLogoutButtonHTML(string $message) : string
	{
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	private function generateLoginFormHTML(string $message) : string
	{
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function isRequestLogin() : bool
	{
		return isset($_REQUEST[self::$login]);
	}

	public function isRequestLogout() : bool
	{
		return isset($_REQUEST[self::$logout]);
	}

	public function getRequestUserName() : string
	{
		return (isset($_REQUEST[self::$name])) ? $_REQUEST[self::$name] : "";
	}

	public function getRequestPassword() : string
	{
		return $_REQUEST[self::$password];
	}

	public function getRequestMessage() : string
	{
		return (isset($_REQUEST[self::$messageId])) ? $_REQUEST[self::$messageId] : "";
	}

	public function setRequestUserName(string $username)
	{
		$_REQUEST[self::$name] = $username;
	}

	public function setRequestMessage(string $message)
	{
		$_REQUEST[self::$messageId] = $message;
	}

	public function isCookieCredentials() : bool
	{
		return (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]));
	}

	public function isCookieCredentialsCorrect() : bool
	{
		return $this->loginModel->isLoggedInWithCookies($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword]);
	}

	public function setCookieCredentials(string $username, string $password)
	{
		setcookie(self::$cookieName, $username, time() + (86400 * 30), "/");
		setcookie(self::$cookiePassword, $password, time() + (86400 * 30), "/");
	}

	public function clearCookieCredentials() {
		setcookie(self::$cookieName, '', time() - 3600);
		setcookie(self::$cookiePassword, '', time() - 3600);
	}

	public function setLastUsernameInput(string $username)
	{
		$_REQUEST[self::$name] = $username;
	}

	public function refreshPage()
	{
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit;
	}
}