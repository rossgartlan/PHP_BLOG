<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blog
 *
 * @author Rossco
 */
class Blog {
    
    private $postID;
    private $authid;
    private $name;
    private $postTitle;
    private $postDesc;
    private $postCont;
    private $postDate;
    private $tags;
    private $commentsEnabled;
    
    function __construct($postID, $authid, $name, $postTitle, $postDesc, $postCont, $postDate, $tags, $commentsEnabled) {
        $this->postID = $postID;
        $this->authid = $authid;
        $this->name = $name;
        $this->postTitle = $postTitle;
        $this->postDesc = $postDesc;
        $this->postCont = $postCont;
        $this->postDate = $postDate;
        $this->tags = $tags;
        $this->commentsEnabled = $commentsEnabled;
    }
    function getPostID() {
        return $this->postID;
    }

    function getAuthid() {
        return $this->authid;
    }

    function getPostTitle() {
        return $this->postTitle;
    }

    function getPostDesc() {
        return $this->postDesc;
    }

    function getPostCont() {
        return $this->postCont;
    }

    function getPostDate() {
        return $this->postDate;
    }

    function getTags() {
        return $this->tags;
    }

    function getCommentsEnabled() {
        return $this->commentsEnabled;
    }

    function setPostID($postID) {
        $this->postID = $postID;
    }

    function setAuthid($authid) {
        $this->authid = $authid;
    }

    function setPostTitle($postTitle) {
        $this->postTitle = $postTitle;
    }

    function setPostDesc($postDesc) {
        $this->postDesc = $postDesc;
    }

    function setPostCont($postCont) {
        $this->postCont = $postCont;
    }

    function setPostDate($postDate) {
        $this->postDate = $postDate;
    }

    function setTags($tags) {
        $this->tags = $tags;
    }

    function setCommentsEnabled($commentsEnabled) {
        $this->commentsEnabled = $commentsEnabled;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }


}
