<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Rossco
 */
class User {
    
    //private $id;
    private $id;
    private $name;
    private $email;
    private $password;
    private $usertype;
    //private $avatar;
    
    function __construct($id, $name, $email, $password,$usertype) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->usertype = $usertype;
    }

    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }


    function getUsertype() {
        return $this->usertype;
    }

    function setUsertype($usertype) {
        $this->usertype = $usertype;
    }



    
    




    
            
}
