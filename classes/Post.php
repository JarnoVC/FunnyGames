<?php

include_once(__DIR__ . "/Database.php");

session_start();

class Post
{
    private $image;
    private $description;
    private $date;
    private $user_id;
    private $hashtag;
    private $hashtag_id;




    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {

        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {

        if (empty($description)) {
            throw new Exception("Caption must be filled in!");
        }

        $this->description = $description;
    }


    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of hashtag
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * Set the value of hashtag
     *
     * @return  self
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;

        return $this;
    }
    public function getPost_id()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */
    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }
    /**
     * Get the value of post_id
     */

    /**
     * Get the value of hashtag_id
     */
    public function getHashtag_id()
    {
        return $this->hashtag_id;
    }

    /**
     * Set the value of hashtag_id
     *
     * @return  self
     */
    public function setHashtag_id($hashtag_id)
    {
        $this->hashtag_id = $hashtag_id;

        return $this;
    }




    public function save()
    {
        $conn = DB::Connection();


        $statement = $conn->prepare('INSERT INTO post (image, description, user_id) values (:image, :description, :user_id)');


        $image = $this->getImage();
        $description = $this->getDescription();
        $user_id = ($_SESSION['id']);



        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":user_id", $user_id);


        $result = $statement->execute();
        return $result;
    }

    public function hashtag()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('INSERT INTO hashtag (title) values (:title)');

        $hashtag = $this->getHashtag();

        $statement->bindValue(":title", $hashtag);

        $result = $statement->execute();
        return $result;
    }

    /*public function post_hashtag()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('INSERT INTO post_hashtag (post_id, hashtag_id) values (:post_id, :hashtag_id)');

        $post_id = $this->getPost_id();
        $hashtag_id = $this->getHashtag_id();

        $statement->bindValue(":post_id", $post_id);
        $statement->bindValue(":hashtag_id", $hashtag_id);

        $result = $statement->execute();
        return $result;
    }*/



    public static function getAll()
    {
        $conn = DB::Connection();

        $statement = $conn->prepare("SELECT * from post");


        /* $statement = $conn->prepare("SELECT post.id, post.image, post.description, post.date, hashtag.title 
        from post
        inner join post_hashtag on (post.id = post_hashtag.post_id)
        inner join hashtag on (hashtag.id = post_hashtag.hashtag_id)
        ");*/


        $statement->execute();
        $post = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $post;
    }



    /* public static function getHash()
    {
        $conn = DB::Connection();

        $statement = $conn->prepare("SELECT * from hashtag");

        $statement->execute();
        $post = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $post;
    }*/
}
