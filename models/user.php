<?php
require_once('connection.php');

class User implements JsonSerializable
{
    public $name;
    public $email;

    /**
     * Constructs a new User.
     * @param $name string Name of the user.
     * @param $email string Email of the user.
     */
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Inserts a user into the database.
     * @param $name string Name of the user.
     * @param $email string Email of the user.
     */
    public static function insert($name, $email)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('INSERT INTO users (u_name, u_email) VALUES (?, ?)');
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
    }

    /**
     * Updates a user in the database.
     * @param $name string Name of the user.
     * @param $email string New email of the user.
     */
    public static function update($name, $email)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('UPDATE users SET u_email = ? WHERE u_name = ?');
        $stmt->bind_param("ss", $email, $name);
        $stmt->execute();
    }

    /**
     * Deletes a user in the database.
     * @param $name string Name of the user.
     */
    public static function delete($name)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('DELETE FROM users WHERE u_name = ?');
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }

    /**
     * Returns all users.
     * @return array
     */
    public static function getAll()
    {
        $list = [];
        $conn = Db::getInstance();
        $stmt = $conn->prepare('SELECT u_name, u_email FROM users ORDER BY u_name');
        $stmt->execute();
        $stmt->bind_result($name, $email);
        while ($stmt->fetch()) {
            $list[] = new User($name, $email);
        }
        return $list;
    }

    /**
     * Returns the user with the given name.
     * @param $name string Name of the user to be returned.
     * @return User
     */
    public static function find($name)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT u_name, u_email FROM users WHERE u_name = ?');
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($name, $email);
        $stmt->fetch();
        return new User($name, $email);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return (array) $this;
    }
}