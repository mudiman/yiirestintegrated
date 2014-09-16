<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadData
 *
 * @author mudassar
 */
class TestCommand extends CConsoleCommand {

    //put your code here



    public function __construct($name, $runner) {
        parent::__construct($name, $runner);

    }
    
   
    
    public function run($args) {
         $userfriend = UserFriends::model()->find("id=5", array(":USERID" => 5, ":FRIENDID" => 6));
         print $userfriend->id;
        
    }


}
