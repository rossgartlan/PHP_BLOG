<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comments
 *
 * @author Rossco
 */
class Comments {
    private $postID;
    private $posterID;
    private $commentID;
    private $comment;
    private $date;
    private $likes;
    
    function __construct($postID, $posterID, $commentID, $comment, $date, $likes) {
        $this->postID = $postID;
        $this->posterID = $posterID;
        $this->commentID = $commentID;
        $this->comment = $comment;
        $this->date = $date;
        $this->likes = $likes;
    }
    
    function getPostID() {
        return $this->postID;
    }

    function getPosterID() {
        return $this->posterID;
    }

    function getCommentID() {
        return $this->commentID;
    }

    function getComment() {
        return $this->comment;
    }

    function getDate() {
        return $this->date;
    }

    function getLikes() {
        return $this->likes;
    }

    function setPostID($postID) {
        $this->postID = $postID;
    }

    function setPosterID($posterID) {
        $this->posterID = $posterID;
    }

    function setCommentID($commentID) {
        $this->commentID = $commentID;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setLikes($likes) {
        $this->likes = $likes;
    }



}


