<?php

include_once(__DIR__ . "/Database.php");

session_start();

class Post
{
    private $image;
    private $description;
    private $hashtag;

    //GETTERS EN SETTERS//

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
        if (empty($image)) {
            throw new Exception("Choose your image!");
        }

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

        if (!empty($hashtag)) {
            $this->hashtag = $hashtag;
            return $this;
        } else {
            return false;
        }
    }

    //FUNCTIONS//

    public function save()
    {
        $conn = DB::Connection();


        $statement = $conn->prepare('INSERT INTO post (image, description, user_id) values (:image, :description, :user_id)');

        $image = $this->getImage();
        $description = $this->getDescription();

        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":user_id", $_SESSION['id']);


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

    //STATIC FUNCTIONS//

    public static function getAll()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare("SELECT * from post");
        $statement->execute();
        $post = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $post;
    }

    public static function getHash()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare("SELECT * from hashtag");
        $statement->execute();
        $hash = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $hash;
    }
}
