<?php
include_once(__DIR__ . "/Database.php");

class Comment
{
    private $comment;
    private $post_id;
    private $user_id;
    private $date;

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of post_id
     */
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

    public function savecomment()
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('INSERT INTO comments (comment, post_id, user_id) values (:comment, :post_id, :user_id)');

        $comment = $this->getComment();
        $post_id = $this->getPost_id();
        $user_id = $this->getUser_id();

        $statement->bindValue(":comment", $comment);
        $statement->bindValue(":post_id", $post_id);
        $statement->bindValue(":user_id", $user_id);

        $result = $statement->execute();
        return $result;
    }

    public static function getPostId($post_id)
    {
        $conn = DB::Connection();
        $statement = $conn->prepare('SELECT * FROM user INNER JOIN comments ON user.id = comments.user_id WHERE post_id = :post_id');
        $statement->bindValue(":post_id", $post_id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
