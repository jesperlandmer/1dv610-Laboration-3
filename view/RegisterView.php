<?php

namespace view;

class RegisterView {
	private static $register = "RegisterView::Register";
	private static $registerName = "RegisterView::UserName";
	private static $registerPassword = "RegisterView::Password";
	private static $registerPasswordRepeat = "RegisterView::PasswordRepeat";
	private static $registerMessageId = "RegisterView::Message";

	/**
	 * @return  void BUT writes to standard output!
	 */
	public function response(string $message) 
	{
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
					<input type="text" name="' . self::$registerName . '" id="' . self::$registerName . '" value="">
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

	public function isRegister()
	{
		return isset($_REQUEST[self::$register]);
	}

	public function getRequestUserName() 
	{
		return $_REQUEST[self::$registerName];
	}

	public function getRequestPassword() 
	{
		return $_REQUEST[self::$registerPassword];
	}

	public function getRequestPasswordRepeat() 
	{
		return $_REQUEST[self::$registerPasswordRepeat];
	}

}


