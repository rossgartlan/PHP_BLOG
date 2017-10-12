<?php
require_once 'QuickToString.php';
class comments {
    use QuickToString;
    public $postId;
    public $postTitle , $postDesc , $postCont , $tags;
    public $postDate;      
    
    function __construct($postId, $postTitle , $postDesc , $postCont , $tags , $postDate ) {
        $this->postId = $postId;
        $this->postTitle = $postTitle;
        $this->postDesc = $postDesc;
        $this->postCont = $postCont;
        $this->tags = $tags;
        $this->postDate = $postDate;
    }
    
    function getPostId() {
        return $this->postId;
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

    function getTags() {
        return $this->tags;
    }

    function getPostDate() {
        return $this->postDate;
    }

    function setPostId($postId) {
        $this->postId = $postId;
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

    function setTags($tags) {
        $this->tags = $tags;
    }

    function setPostDate($postDate) {
        $this->postDate = $postDate;
    }



    
}
