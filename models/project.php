<?php
require_once('connection.php');

class Project implements JsonSerializable
{
    public $id;
    public $name;
    public $user;

    /**
     * Constructs a new project.
     * @param $id string ID of the project.
     * @param $name string Name of the project.
     * @param $user string Creator of the project.
     */
    public function __construct($id, $name, $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->user = $user;
    }

    /**
     * Inserts a new project into the database.
     * @param $name string Name of the project.
     * @param $user string Creator of th project.
     * @return int ID of the project that was inserted.
     */
    public static function insert($name, $user)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('INSERT INTO projects (p_name, p_user) VALUES (?, ?)');
        $stmt->bind_param("ss", $name, $user);
        $stmt->execute();
        return $stmt->insert_id;
    }

    /**
     * Updates the values of the project with the given ID in the database.
     * @param $id string ID of the project.
     * @param $name string New name of the project.
     */
    public static function update($id, $name)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('UPDATE projects SET p_name = ? WHERE p_id = ?');
        $stmt->bind_param("ss", $name, $id);
        $stmt->execute();
    }

    /**
     * Deletes the project with the given ID from the database.
     * @param $id string ID of the project.
     */
    public static function delete($id)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('DELETE FROM projects WHERE p_id = ?');
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }

    /**
     * Returns all existing projects.
     * @return array
     */
    public static function getAll()
    {
        $list = [];
        $conn = Db::getInstance();
        $stmt = $conn->prepare('SELECT p_id, p_name, p_user FROM projects ORDER BY p_name');
        $stmt->execute();
        $stmt->bind_result($id, $name, $user);
        while ($stmt->fetch()) {
            $list[] = new Project($id, $name, $user);
        }
        return $list;
    }

    /**
     * Returns the project with the given ID.
     * @param $id ID of the project.
     * @return Project
     */
    public static function find($id)
    {
        $conn = Db::getInstance();
        $stmt = $conn->prepare('SELECT p_id, p_name, p_user FROM projects WHERE p_id = ?');
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($id, $name, $user);
        $stmt->fetch();
        return new Project($id, $name, $user);
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