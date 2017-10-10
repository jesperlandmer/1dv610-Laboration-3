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

	/**
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response(string $message) 
	{
		if ($this->isMessage()) {
			$message = $this->getRequestMessage();
		}

		$response = $this->generateLoginFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	/**
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML(string $message) 
	{
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML(string $message) 
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

	/**
	* @return  void
	*/
	public function refreshPage()
	{
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit;
	}
	/**
	* @return  boolean
	*/
	public function isLogin()
	{
		return isset($_REQUEST[self::$login]);
	}
	/**
	* @return  boolean
	*/
	public function isLogout()
	{
		return isset($_REQUEST[self::$logout]);
	}
	/**
	* @return  boolean
	*/
	public function isMessage() 
	{
		return isset($_REQUEST[self::$messageId]);
	}
	/**
	* @return  string
	*/
	public function getRequestUserName()
	{
		return (isset($_REQUEST[self::$name])) ? $_REQUEST[self::$name] : "";
	}
	/**
	* @return  string
	*/
	public function getRequestPassword() 
	{
		return $_REQUEST[self::$password];
	}
	/**
	* @return  void
	*/
	public function getRequestMessage() 
	{
		return $_REQUEST[self::$messageId];
	}
	/**
	* @return  void
	*/
	public function setRequestMessage(string $message) 
	{
		$_REQUEST[self::$messageId] = $message;
	}
	/**
	* @return  boolean
	*/
	public function setCookieCredentials(string $username, string $password)
	{
		return isset($_REQUEST[self::$login]);
	}
	/**
	* @return  void
	*/
	public function setLastUsernameInput(string $username) 
	{
		$_REQUEST[self::$name] = $username;
	}
}