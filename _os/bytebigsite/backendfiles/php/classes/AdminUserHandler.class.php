<?php

class AdminUserHandler
{
    private $__table;
    private $__db_connection;
    public function __construct()
    {
        $tables                = get_db_tables();
        $this->__table         = $tables['atable'];
        $conn                  = connect_db();
        $this->__db_connection = $conn['connection'];
    }

    /**************************************************************************************/

    public function create_user($userid, $password, $is_admin)
    {
        $conn     = $this->__db_connection;
        $table    = $this->__table;
        $password = encrypt($password, $userid);

        if ($sql = $conn->prepare("INSERT INTO " . $table . "
                                (userid, password, is_admin)
                                VALUES (?, ?, ?)")) {
        } else {
            return false;
        }
        $sql->bind_param("ssi", $userid, $password, $is_admin);
        $sql->execute();

        return true;
    }

    /**************************************************************************************/

    public function validate_login($userid, $input_password)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT password FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows > 0) {
            $sql->bind_result($col['password']);
            $sql->fetch();
            $password = $col['password'];
            if (decrypt($password, $userid) == $input_password) {
                return true;
            }
        }
        return false;
    }

    /**************************************************************************************/

    public function is_valid($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT * FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows < 1) {
            return false;
        }
        return true;
    }

    /**************************************************************************************/

    public function is_admin($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT is_admin FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows > 0) {
            $sql->bind_result($col['is_admin']);
            $sql->fetch();
            return $col['is_admin'];
        }
        return false;
    }
}
