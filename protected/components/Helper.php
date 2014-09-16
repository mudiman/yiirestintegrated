<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author mudassar
 */
class Helper {

    //put your code here
    public static function  generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds') {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if (!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
    
    public static function sendEmail($email, $subject, $message) {

        $to = $email;
// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
        $headers .= 'From: WearXplay <' . Yii::app()->params->adminEmail . '>' . "\r\n";


// Mail it
        mail($to, $subject, $message, $headers);
//
//
//
//        $email = Yii::app()->email;
//        $email->to = $email;
//        $email->from = Yii::app()->params->adminEmail;
//        $email->subject = $subject;
//        $email->message = $message;
//        $email->send();
    }
    
    public static function _saveImageFromBas64($base64,$path) {
        $decoded = base64_decode($base64);
        $path = realpath($path);

        $file_name = uniqid() . ".jpeg";
        file_put_contents($path . "/" . $file_name, $decoded);
        //return Yii::app()->request->baseUrl . "/images/$file_name";
        return $file_name;
    }

}
