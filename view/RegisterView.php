<?php

namespace view;

require_once(__DIR__ . '/../model/observers/RegisterObserver.php');

class RegisterView implements \model\RegisterObserver {

	private static $register = "RegisterView::Register";
	private static $registerName = "RegisterView::UserName";
	private static $registerPassword = "RegisterView::Password";
	private static $registerPasswordRepeat = "RegisterView::PasswordRepeat";
	private static $registerMessageId = "RegisterView::Message";

	/**
	 * @return  void BUT writes to standard output!
	 */
	public function response() 
	{
		$message = "";
		if ($this->isMessage()) {
			$message = $this->getRequestMessage();
		}
		
		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

	/**
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
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

	/**
	* @return  void
	*/
	public function redirectToHomePage()
	{
		header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]));
		exit;
	}
	/**
	* @return  boolean
	*/
	public function isRegister()
	{
		return isset($_REQUEST[self::$register]);
	}
	/**
	* @return  boolean
	*/
	public function isRequestUserName()
	{
		return isset($_REQUEST[self::$registerName]);
	}
	/**
	* @return  boolean
	*/
	public function isMessage() 
	{
		return isset($_REQUEST[self::$registerMessageId]);
	}
	/**
	* @return  string
	*/
	public function getRequestUserName() 
	{
		return (isset($_REQUEST[self::$registerName])) ? $_REQUEST[self::$registerName] : "";
	}
	/**
	* @return  string
	*/
	public function getRequestPassword() 
	{
		return $_REQUEST[self::$registerPassword];
	}
	/**
	* @return  string
	*/
	public function getRequestPasswordRepeat() 
	{
		return $_REQUEST[self::$registerPasswordRepeat];
	}
	/**
	* @return  void
	*/
	public function getRequestMessage()
	{
		return $_REQUEST[self::$registerMessageId];
	}
	/**
	* @return  void
	*/
	public function setRequestMessage(string $message) 
	{
		$_REQUEST[self::$registerMessageId] = $message;
	}
	/**
	* @return  void
	*/
	public function setLastUsernameInput(string $username) 
	{
		$_REQUEST[self::$registerName] = $username;
	}
}


