<?php
// require from database "bloger" with PHP (PDO) on mySQL


function validation(array $fields, array $rules,)
{
    $errors=[];
    if (!$rules)
        return false;

    $rulesArray = (listingRules($rules));
    foreach ($rulesArray as $fieldName => $arrayRules) {
        foreach ($arrayRules as $rule) {

            //Required rules
            if ($rule === 'required') {
                if (!required($fields[$fieldName])) {
                    $errors[$fieldName][] = "Field '$fieldName' is required!";
                }
            }
            //min_lenghth rules
            if (mb_strpos($rule, 'min_lenghth') !== false) {
                preg_match("/\[(\d+)\]/", $rule, $matches);
                $length = $matches[1];
                if (!minLength($fields[$fieldName], $length)) {
                    $errors[$fieldName][] = "Field '$fieldName' must be longest then $length";
                }
            }
            //min_lenghth rules
            if (mb_strpos($rule, 'max_lenghth') !== false) {
                preg_match("/\[(\d+)\]/", $rule, $matches2);
                $length2 = $matches2[1];
                if (!maxLength($fields[$fieldName], $length2)) {
                    $errors[$fieldName][] = "Field '$fieldName' must be shortest then $length2";
                }
            }
            //email validation rules chek free password
            if ($rule === 'email') {
                if (emailValidation("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z\-\.]+$/Du", $fields['email']) > 0) {
                    $errors['email'][] = "In field '$fieldName' must be used this form |A-Z.a-z,0-9,_,-,|@|A-Z.a-z,0-9|.|a-z|";
                }

            }
            //chek used symbols in password
            if ($rule === 'symbol') {


                if ((chekPaswword("^\S*(?=\S{0,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^", $fields['password']) > 0)) {
                    $errors['password'][] = "Must use at least one lowercase, one uppercase letter and at least one number";
                }
            }
            //chek password confirm
            if ($rule === 'confirmPassword') {
                if (confirmPassword($fields['password'], $fields['confirmPassword'])) {
                    $errors['confirmPassword'][] = "Password not confirm";
                }
            }

        }
    }
    return $errors;
}

/**
 * listing rules as string
 * @param array $rules
 * @return array
 */
function listingRules(array $rules): array
{
    $allRules = [];
    foreach ($rules as $fieldName => $rulesString) {
        $allRules[$fieldName] = explode('|', $rulesString);
    }
    return $allRules;
}

/**
 * check if value exist
 * @param string $value
 * @return bool
 */
function required(string $value): bool
{
    if ($value) {
        return true;
    }
    return false;
}

/** Chek minimal length
 * @param string $string
 * @param int $length
 * @return bool
 */
function minLength(string $string, int $length): bool
{
    return (mb_strlen($string) > $length);
}

/** Chek minimal length
 * @param string $string2
 * @param int $length2
 * @return bool
 */
function maxLength(string $string2, int $length2): bool
{
    return (mb_strlen($string2) < $length2);
}

/**
 * chek email
 * @param string $chekType
 * @param string $email
 * @return bool
 */
function emailValidation(string $chekType, string $email): bool
{
    if (!(preg_match($chekType, $email) > 0)) {
        return true;
    }
    return false;
}

/**
 * chek password symbols
 * @param string $chekPass
 * @param string $password
 * @return bool
 */
function chekPaswword(string $chekPass, string $password): bool
{
    if (!(preg_match($chekPass, $password) > 0)) {
        return true;
    }
    return false;
}

/**
 * chek password confirm
 * @param string $password
 * @param string $passwordConfirm
 * @return bool
 */
function confirmPassword(string $password, string $passwordConfirm): bool
{
    if (!($password === $passwordConfirm)) {
        return true;
    }
    return false;
}



