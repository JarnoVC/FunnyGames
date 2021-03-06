<?php

include_once(__DIR__ . "/Database.php");

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
} else {
    $id = $_SESSION["id"];
}

class Post
{
    private $image;
    private $description;
    private $user_id;

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
        $user_id = $this->getUser_id();

        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":user_id", $user_id);

        $result = $statement->execute();
        return $result;
    }

    public function getCorrectUser($post_id)
    {
        $conn = DB::Connection();
        $statement = $conn->prepare("SELECT * FROM user INNER JOIN post ON user.id = post.user_id WHERE post.id = :post_id");
        $statement->bindValue(':post_id', $post_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getCorrectPost($user_id)
    {
        $conn = DB::Connection();
        $statement = $conn->prepare("SELECT * FROM post WHERE user_id = :user_id");
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
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
}
