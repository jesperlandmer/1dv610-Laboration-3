<?php

namespace view;

class MessageView
{
    const ErrorUsernameLength = "Username has too few characters, at least 3 characters. <br>";
    const ErrorPasswordLength = "Password has too few characters, at least 6 characters. <br>";
    const ErrorPasswordMatch = "Passwords do not match. <br>";
    const ErrorUserExists = "User exists, pick another username. <br>";
    const ErrorInvalidFormat = "Username contains invalid characters. <br>";

    const ErrorNoUserNameInput = "Username is missing <br>";
    const ErrorNoPasswordInput = "Password is missing <br>";
    const ErrorNoUserFound = "Wrong name or password <br>";
    
    const RegisterSuccessful = "Registered new user.";
    const LoginSuccessful = "Welcome";
    const LogoutSuccessful = "Bye bye!";
}
