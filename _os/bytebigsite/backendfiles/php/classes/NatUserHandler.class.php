<?php

class NatUserHandler
{
    private $__table;
    private $__db_connection;
    public function __construct()
    {
        $tables                = get_db_tables();
        $this->__table         = $tables['table'];
        $conn                  = connect_db();
        $this->__db_connection = $conn['connection'];
    }

    /**************************************************************************************/

    public function create_username($firstname, $lastname, $tier_choice)
    {
        $user_id = $this->__generate_username($firstname, $lastname, $tier_choice);
        while (!$this->__is_unique_userid($this->__table, $user_id)) {
            $user_id = $this->__generate_username($firstname, $lastname, $tier_choice);
        }
        return $user_id;
    }

    private function __generate_username($firstname, $lastname, $tier_choice)
    {
        $cutfname   = strtolower(substr($firstname, 0, 3));
        $cutlname   = strtolower(substr($lastname, 0, 3));
        $randomnum1 = rand(1, 9);
        $randomnum2 = rand(1, 9);
        $randomnum3 = rand(1, 9);
        $user_id    = $cutfname . $tier_choice . $cutlname . $randomnum1 . $randomnum2 . $randomnum3;
        return $user_id;
    }

    private function __is_unique_userid($table, $user_id)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare('SELECT userid FROM ' . $table . ' WHERE userid = ?');
        if (!$sql) {
            echo ("Error Selecting User");
            exit;
        }
        $sql->bind_param('s', $user_id);
        $sql->execute();
        $sql->store_result();

        if ($sql->num_rows > 0) {
            return false;
        }
        return true;
    }

    /**************************************************************************************/

    public function create_user($data)
    {
        $data           = encrypt_user_data($data, $data['user_id']);
        $data['date']   = date("Y-m-d");
        $data['amount'] = 0;

        $conn  = $this->__db_connection;
        $table = $this->__table;

        if ($sql = $conn->prepare("INSERT INTO " . $table . "
                            (userid, password, firstname, lastname, mobilenumber, email, address, city,
                            postalcode, state, country, tier, daily_purchase_limit, daily_start_date, monthly_purchase_limit, monthly_start_date, vip, playerid, active)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        } else {
            return false;
        }
        $sql->bind_param("sssssssssssiisisisi", $data['user_id'], $data['password'], $data['fname'], $data['lname'],
            $data['phone'], $data['email'], $data['street'], $data['city'], $data['postal_code'], $data['state'],
            $data['country'], $data['tier_choice'], $data['amount'], $data['date'], $data['amount'], $data['date'], $data['is_vip'], $data['player_id'],
            $data['active']);
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

    public function get_user_email($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT email FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return null;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows > 0) {
            $sql->bind_result($col['email']);
            $sql->fetch();
            $user_email = decrypt($col['email'], $userid);
            return $user_email;
        } else {
            return null;
        }
    }

    /**************************************************************************************/

    public function change_password($userid, $new_pw)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("UPDATE " . $table . " SET password=? WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('ss', $new_pw, $userid);
        $sql->execute();
        return true;
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

    public function is_active($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT active FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows > 0) {
            $sql->bind_result($col['active']);
            $sql->fetch();
            $active = $col['active'];
            return $active;
        } else {
            return false;
        }
    }

    /**************************************************************************************/

    public function change_active_status($userid, $is_active)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("UPDATE " . $table . " SET active=? WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('is', $is_active, $userid);
        $sql->execute();
        return true;
    }

    /**************************************************************************************/

    public function get_password($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare('SELECT password FROM ' . $table . ' WHERE userid = ?');
        if (!$sql) {
            return null;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($col['password']);
        $sql->fetch();

        $userpw = decrypt($col['password'], $userid);
        return $userpw;
    }

    /**************************************************************************************/

    public function is_unique_email($email)
    {
        $conn            = $this->__db_connection;
        $table           = $this->__table;
        $is_unique_email = true;

        $sql = $conn->prepare("SELECT userid, email FROM " . $table);
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($row['userid'], $row['email']);

        while ($sql->fetch()) {
            if (decrypt($row['email'], $row['userid']) == $email) {
                $is_unique_email = false;
            }
        }
        return $is_unique_email;
    }

    /**************************************************************************************/

    public function get_user_data($user)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT firstname, lastname, mobilenumber, address, email, city, postalcode,
        state, country, monthly_start_date, daily_start_date, monthly_purchase_limit, daily_purchase_limit,
        tier, vip, playerid FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $user_data['error'] = "Error Selecting User";
            return $user_data;
        }
        $sql->bind_param('s', $user);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($row["firstname"], $row["lastname"], $row["mobilenumber"], $row["address"],
            $row["email"], $row["city"], $row["postalcode"], $row["state"], $row["country"], $row["monthly_start_date"],
            $row["daily_start_date"], $row["monthly_purchase_limit"], $row["daily_purchase_limit"], $row["tier"], $row["vip"],
            $row['playerid']);
        $sql->fetch();

        $user_data['userid']                 = $user;
        $user_data['firstname']              = decrypt($row["firstname"], $user);
        $user_data['lastname']               = decrypt($row["lastname"], $user);
        $user_data['mobile']                 = decrypt($row["mobilenumber"], $user);
        $user_data['address']                = decrypt($row["address"], $user);
        $user_data['email_address']          = decrypt($row["email"], $user);
        $user_data['city']                   = decrypt($row["city"], $user);
        $user_data['postal_code']            = decrypt($row["postalcode"], $user);
        $user_data['state']                  = decrypt($row["state"], $user);
        $user_data['country']                = decrypt($row["country"], $user);
        $user_data['monthly_start_date']     = $row["monthly_start_date"];
        $user_data['daily_start_date']       = $row["daily_start_date"];
        $user_data['monthly_purchase_total'] = $row["monthly_purchase_limit"];
        $user_data['daily_purchase_total']   = $row["daily_purchase_limit"];
        $user_data['tier']                   = $row["tier"];
        $user_data['is_vip']                 = $row["vip"];
        if ($row['playerid'] != null) {
            $user_data['playerid'] = $row["playerid"];
        } else {
            $user_data['playerid'] = "";
        }

        $user_data        = $this->__get_tier_limits($user_data);
        $user_data['key'] = create_nonce(900, $user_data['userid']);

        return $user_data;
    }

    private function __get_tier_limits($user_data)
    {
        $transaction_limit = TIER_TRANSACTION_LIMITS[$user_data['tier']];
        $daily_limit       = TIER_DAILY_LIMITS[$user_data['tier']];
        $monthly_limit     = TIER_MONTHLY_LIMITS[$user_data['tier']];

        $current_date = date("Y-m-d");

        if ($user_data['daily_start_date'] < $current_date) {
            $user_data['daily_purchase_total'] = 0;
        }

        $monthly_purchases_start_date = strtotime($user_data['monthly_start_date']);
        $current_date_time            = strtotime($current_date);

        $user_data['min_date'] = strtotime("+1 MONTH", $monthly_purchases_start_date);

        if ($user_data['min_date'] < $current_date_time) {
            $user_data['monthly_purchase_total'] = 0;
        }

        $user_data['min_date'] = date('Y-m-d', $user_data['min_date']);

        $user_data['transaction_limit']       = $transaction_limit;
        $user_data['remaining_daily_limit']   = $daily_limit - $user_data['daily_purchase_total'];
        $user_data['remaining_monthly_limit'] = $monthly_limit - $user_data['monthly_purchase_total'];

        return $user_data;
    }

    /**************************************************************************************/

    public function change_tier($userid, $new_tier)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("UPDATE " . $table . " SET tier=? WHERE userid=? ");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('is', $new_tier, $userid);
        $sql->execute();
        return true;
    }

    /**************************************************************************************/

    public function get_tier($userid)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $sql = $conn->prepare("SELECT tier FROM " . $table . " WHERE userid=?");
        if (!$sql) {
            $conn->close();
            return false;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $num_of_rows = $sql->num_rows;

        if ($num_of_rows > 0) {
            $sql->bind_result($col['tier']);
            $sql->fetch();
            $tier = $col['tier'];
            return $tier;
        } else {
            return false;
        }
    }

    /**************************************************************************************/

    public function get_purchase_limits($userid, $amount)
    {
        $conn            = $this->__db_connection;
        $table           = $this->__table;
        $purchase_limits = array();

        $sql = $conn->prepare('SELECT daily_purchase_limit, daily_start_date, monthly_purchase_limit, monthly_start_date
            FROM ' . $table . ' WHERE userid = ?');
        if (!$sql) {
            echo ("Error Selecting User");
            return;
        }
        $sql->bind_param('s', $userid);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($col["daily_purchase_limit"], $col["daily_start_date"],
            $col["monthly_purchase_limit"], $col["monthly_start_date"]);
        $sql->fetch();

        $daily_purchase_total   = $col["daily_purchase_limit"];
        $monthly_purchase_total = $col["monthly_purchase_limit"];

        $purchase_limits['sum_daily_purchases']   = $daily_purchase_total + $amount;
        $purchase_limits['sum_monthly_purchases'] = $monthly_purchase_total + $amount;
        $purchase_limits['daily_start_date']      = $col["daily_start_date"];
        $purchase_limits['monthly_start_date']    = $col["monthly_start_date"];

        return $purchase_limits;
    }

    public function update_daily_limits($userid, $amount, $daily_start_date, $sum_daily_purchases)
    {
        $conn         = $this->__db_connection;
        $table        = $this->__table;
        $current_date = date("Y-m-d");

        // if today is the same day of their last transcation ----> daily_purchase_limit += amount
        if ($daily_start_date == $current_date) {
            $sql = $conn->prepare("UPDATE " . $table . " SET daily_purchase_limit=? WHERE userid=?");
            if (!$sql) {
                echo ("Error Updating Daily Purchases");
                return;
            }
            $sql->bind_param('ds', $sum_daily_purchases, $userid);
            $sql->execute();
        }
        // Else ----> daily_purchase_limit = amount and last daily trans = current_date
        else {
            $sql = $conn->prepare("UPDATE " . $table . " SET daily_purchase_limit=?, daily_start_date=? WHERE userid=?");
            if (!$sql) {
                echo ("Error Updating Daily Purchases");
                return;
            }
            $sql->bind_param('dss', $amount, $current_date, $userid);
            $sql->execute();
        }
    }

    public function update_monthly_limits($userid, $amount, $monthly_start_date, $sum_monthly_purchases)
    {
        $conn  = $this->__db_connection;
        $table = $this->__table;

        $monthly_start_date = strtotime($monthly_start_date);
        $current_date       = date("Y-m-d");
        $current_date_time  = strtotime($current_date);
        $monthly_start_date = strtotime("+1 MONTH", $monthly_start_date);

        // If monthly_start_date + 1 month < date  ------> monthly_purchase_limit = amount, monthly_start_date = current date
        if ($monthly_start_date < $current_date_time) {
            $sql = $conn->prepare("UPDATE " . $table . " SET monthly_purchase_limit=?, monthly_start_date=? WHERE userid=?");
            if (!$sql) {
                echo ("Error Updating Monthly Purchases");
                return;
            }
            $sql->bind_param('dss', $amount, $current_date, $userid);
            $sql->execute();
        }

        // If monthly_start_date + 1 month > date  ------> monthly_purchase_limit += amount;
        else {
            $sql = $conn->prepare("UPDATE " . $table . " SET monthly_purchase_limit=? WHERE userid=?");
            if (!$sql) {
                echo ("Error Updating Monthly Purchases");
                return;
            }
            $sql->bind_param('ds', $sum_monthly_purchases, $userid);
            $sql->execute();
        }
    }
}
