<?php

namespace view;

class LoginView {
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
		$response = $this->generateLoginFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	/**
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
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
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function isLogin()
	{
		return isset($_REQUEST[self::$login]);
	}

	public function isLogout()
	{
		return isset($_REQUEST[self::$logout]);
	}

	public function getRequestUserName() 
	{
		return $_REQUEST[self::$name];
	}

	public function getRequestPassword() 
	{
		return $_REQUEST[self::$password];
	}
}