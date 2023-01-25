<?php

/**
 * Class InputSecurity
 * Allow to secure the input of application
 */
class InputSecurity{

    private static $errorReturnByFonction = "Invalid";
    private static $errorEmptyInput = "Input is empty, please check it and try again";
    private static $errorMailFormat = "Invalid mail address format, please check it and try again";
    private static $errorStringFormat = "Invalid string format, please check it and try again";
    private static $errorNumberFormat = "Invalid number format, please check it and try again";
    private static $errorPasswordLength = "Invalid password length, please do a password with 8 characters minimum";

    /**
    * delete all tags from parameter
    * @author Nikola Chevalliot
    * @param string $input
    * 
    * @return string
    */
    public static function validateWithoutTags($input): string{
        $inputProcessing = strip_tags($input);
        $inputProcessing = stripslashes($inputProcessing);
        $inputProcessing = trim($inputProcessing);
        $inputProcessing = mb_strtolower($inputProcessing);

        return $inputProcessing;
    }

    /**
    * create a new $_SESSION variable that stores an error message
    * @author Nikola Chevalliot
    * 
    * @param string $message
    * @return string default error message 
    */
    public static function returnError($message): string{
        if(isset($_SESSION)){
            $_SESSION['ERROR'] = $message;
        }
        else{
            session_start();
            $_SESSION['ERROR'] = $message;
        }
        return InputSecurity::$errorReturnByFonction;
    }

    /**
     * create a new $_SESSION variable that stores an error message
     * @author Nikola Chevalliot
    * @param string
    *
    */
    public static function returnMessage($message){
        if(isset($_SESSION)){
            $_SESSION['MESSAGE'] = $message;
        }
        else{
            session_start();
            $_SESSION['MESSAGE'] = $message;
        }
    }

    /**
     * Allow to destroy ERROR variable from session
     * @author Nikola Chevalliot
     */
    public static function destroyError(){
        if(isset($_SESSION['ERROR'])){
            unset($_SESSION['ERROR']);
        }
    }

    /**
    * check if parameter is empty
    * @author Nikola Chevalliot
    * @param string $input
    * 
    * @return string return the input values if is not empty
    */
    public static function isEmpty($input): string{
        if(!empty($input)){
            $inputProcessing = InputSecurity::validateWithoutTags($input);
            return $inputProcessing;
        }
        else{
            return InputSecurity::returnError(InputSecurity::$errorEmptyInput);
        }
    }

    /**
    * checks if the parameter matches an email address format 
    * @author Nikola Chevalliot
    * @param string $input
    * 
    * @return string
    */
    public static function validateMail($input): string{
        $inputProcessing = InputSecurity::isEmpty($input);
        $inputProcessing = mb_strtolower($inputProcessing);
        $REGEX = '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';
        if(preg_match($REGEX , $inputProcessing)){
            return $inputProcessing;
        }
        else{
            return InputSecurity::returnError(InputSecurity::$errorMailFormat);
        }
    }

    /**
    * checks if the parameter is without number if the second parameter is set with LastName or FirstName return a special formatting
    * @author Nikola Chevalliot
    * @param string $input 
    * 
    * @return string
    */
    public static function validateWithoutNumber($input): string{
        $inputProcessing = InputSecurity::isEmpty($input);

        if(!filter_var($inputProcessing , FILTER_SANITIZE_NUMBER_INT)){
            return $inputProcessing;
        }
        else{
           return InputSecurity::returnError(InputSecurity::$errorStringFormat);
        }
    }

    /**
    * check if the parameter is without letter
    * @author Nikola Chevalliot
    * @param string $input
    * @param string $format optional if param ==  phoneNumber => $regexPhone else if param == licensePlate => $regexPlate else => $regexNumber
    * 
    * @return string
    */
    public static function validateWithoutLetter($input , ?string $format = null){
        $REGEX = "";

        switch($format){
            case null:
                    //all number without space
                    $REGEX = "/[\d]{1,}/";
                break;
            case "phoneNumber":
                    //phone number french format
                    $REGEX = "/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/";
                break;
            case "licensePlate":
                    //license plate french format
                    $REGEX = "/[A-Z]{2}([-])[0-9]{3}([-])[A-Z]{2}/";
                break;
        }

        $inputProcessing = InputSecurity::isEmpty($input);

        if(preg_match($REGEX , $inputProcessing)){
            return $inputProcessing;
        }
        else{
           return InputSecurity::returnError(InputSecurity::$errorNumberFormat);
        }
    }

    /**
    * check if the parameter is a strong password
    * @author Nikola Chevalliot
    * @param string $input
    * 
    * @return string
    */
    public static function validatePassWord($input){
        $inputProcessing = InputSecurity::isEmpty($input);
        $REGEX = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        if(preg_match($REGEX , $inputProcessing)){
            return $inputProcessing;
        }
        else{
           return InputSecurity::returnError(InputSecurity::$errorPasswordLength);
        }
    }

    public static function validatePicture($input){
        
    }

    /**
     * Allow to format the string return according to selected format 
     * @author Nikola Chevalliot
     * @param string $input which must be formatted
     * @param string $format optional param list : LastName , FirstName, Position , PhoneNumber
     * 
     * @return string 
     */
    public static function displayWithFormat($input , ?string $format = null){
        $inputProcessing = InputSecurity::validateWithoutTags($input);
        switch($format){
            case null:
                    return mb_strtolower($inputProcessing);
                break;
            case "LastName":
                    return mb_strtoupper($inputProcessing);
                break;
            case "FirstName":
                    return mb_convert_case($inputProcessing , MB_CASE_TITLE);
                break;
            case "Position":
                    return mb_strtoupper($inputProcessing);
                break;
            case "PhoneNumber":
                        $inputProcessing = str_split($inputProcessing , 2);
                   return implode(" " , $inputProcessing);
                break;
        }
    }


    /**
     * Allow to generate a token to verify if the 
     * @param int 
     * 
     * @return string 
     */
    public static function generateToken(int $n) : string{
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomStr = '';
      
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($str) - 1);
            $randomStr .= $str[$index];
        }
      
        return $randomStr;
    }
}

?>