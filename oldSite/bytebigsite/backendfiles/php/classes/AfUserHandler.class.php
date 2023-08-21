<?php

class AfUserHandler
{
    private $__table;
    private $__db_connection;
    public function __construct()
    {
        $tables                = get_db_tables();
        $this->__table         = $tables['vtable'];
        $conn                  = connect_db();
        $this->__db_connection = $conn['connection'];
    }

    /**************************************************************************************/

    public function create_user($data)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $data            = encrypt_user_data($data, $data['player_id']);
        $data['visits']  = 1;
        $data['emailed'] = false;

        $conn = $this->__db_connection;

        if ($sql = $conn->prepare("INSERT INTO " . $table . "
                            (playerid, firstname, lastname, mobilenumber, email, address, city, postalcode,
                            state, country, visits, emailed, userid)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        } else {
            return false;
        }
        $sql->bind_param("ssssssssssiis", $data['player_id'], $data['fname'], $data['lname'], $data['phone'],
            $data['email'], $data['street'], $data['city'], $data['postal_code'], $data['state'],
            $data['country'], $data['visits'], $data['emailed'], $data['user_id']);
        $sql->execute();

        return true;
    }

    /**************************************************************************************/

    public function update_user($data)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $data = encrypt_user_data($data, $data['player_id']);
        $data['visits'] += 1;

        $conn = $this->__db_connection;

        if ($sql = $conn->prepare("UPDATE " . $table . " SET firstname=?, lastname=?, mobilenumber=?, email=?, address=?, city=?, postalcode=?,
            state=?, country=?, visits=? WHERE playerid=?")) {
        } else {
            echo ($conn->error);
            return false;
        }
        $sql->bind_param("sssssssssis", $data['fname'], $data['lname'], $data['phone'],
            $data['email'], $data['street'], $data['city'], $data['postal_code'],
            $data['state'], $data['country'], $data['visits'], $data['player_id']);
        $sql->execute();

        return true;
    }

    /**************************************************************************************/

    public function get_user_data($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;
        $playerid = $userid;

        $sql = $conn->prepare("SELECT userid, firstname, lastname, mobilenumber, address,
        email, city, postalcode, state, country FROM " . $table . " WHERE playerid=?");
        if (!$sql) {
            $user_data['error'] = "Error Selecting User";
            return $user_data;
        }
        $sql->bind_param('s', $playerid);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($row["userid"], $row["firstname"], $row["lastname"], $row["mobilenumber"],
            $row["address"], $row["email"], $row["city"], $row["postalcode"], $row["state"], $row["country"]);
        $sql->fetch();

        $user_data['playerid']      = $playerid;
        $user_data['userid']        = $row["userid"];
        $user_data['fname']         = decrypt($row["firstname"], $playerid);
        $user_data['lname']         = decrypt($row["lastname"], $playerid);
        $user_data['mobile']        = decrypt($row["mobilenumber"], $playerid);
        $user_data['address']       = decrypt($row["address"], $playerid);
        $user_data['email_address'] = decrypt($row["email"], $playerid);
        $user_data['city']          = decrypt($row["city"], $playerid);
        $user_data['zip']           = decrypt($row["postalcode"], $playerid);
        $user_data['state']         = decrypt($row["state"], $playerid);
        $user_data['country']       = decrypt($row["country"], $playerid);

        return $user_data;
    }

    /**************************************************************************************/

    public function exists_user($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT * FROM " . $table . " WHERE playerid=?");
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

    public function get_visits($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT visits FROM " . $table . " WHERE playerid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows > 0) {
            $sql->bind_result($col['visits']);
            $sql->fetch();
            $visits = $col['visits'];
            return $visits;
        } else {
            return false;
        }
    }

    /**************************************************************************************/

    public function get_emailed_data($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;
        $playerid = $userid;

        $sql = $conn->prepare('SELECT email, emailed, userid FROM ' . $table . ' WHERE playerid = ?');
        if (!$sql) {
            echo ("Error Selecting User");
            return;
        }
        $sql->bind_param('s', $playerid);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($col['email'], $col['emailed'], $col['userid']);
        $sql->fetch();

        $emailed_data['was_emailed'] = $col["emailed"];
        $emailed_data['userid']      = $col["userid"];
        $emailed_data['user_email']  = decrypt($col["email"], $playerid);

        return $emailed_data;
    }

    /**************************************************************************************/

    public function set_emailed($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;
        $playerid = $userid;

        $sql = $conn->prepare("UPDATE " . $table . " SET emailed=" . true . " WHERE playerid=? ");
        if (!$sql) {
            echo ("Error Selecting User");
            return;
        }
        $sql->bind_param('s', $playerid);
        $sql->execute();
    }

}
