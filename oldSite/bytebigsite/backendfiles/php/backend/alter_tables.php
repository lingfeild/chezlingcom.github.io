<?php

include_once __DIR__ . "/../include.php";

$connection = connect_db();
$conn       = $connection['connection'];

$tables = get_db_tables();
$table  = $tables['table'];
$vtable = $tables['vtable'];
$atable = $tables['atable'];

// Array(table, col_name, function)
$col_list = array(
    array('table' => $vtable, 'col_name' => 'emailed', 'function' => 'add_emailed_col'),
    array('table' => $vtable, 'col_name' => 'userid', 'function' => 'add_userid_col'),
    array('table' => $table, 'col_name' => 'playerid', 'function' => 'add_playerid_col'),
    array('table' => $table, 'col_name' => 'active', 'function' => 'add_active_col'),
    array('table' => $table, 'col_name' => 'monthly_start_date', 'function' => 'change_purchase_cols'),
    array('table' => $atable, 'col_name' => 'is_admin', 'function' => 'add_is_admin_col'),
);

foreach ($col_list as $col) {
    if (!if_col_exists($conn, $col['table'], $col['col_name'])) {
        $col['function']($conn, $col['table']);
    }
}

if (get_col_data_type($conn, $vtable, "playerid") != "varchar(128)") {
    change_playerid_col($conn, $vtable, $table);
}

$conn->close();
exit;

/*********************************************************************/

function if_col_exists($conn, $table, $col_name)
{
    $sql    = "SHOW COLUMNS FROM " . $table . " LIKE '" . $col_name . "'";
    $result = $conn->query($sql);
    if ($result->{'num_rows'} > 0) {
        return true;
    }
}

function get_col_data_type($conn, $table, $col_name)
{
    $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $table . "' AND COLUMN_NAME = '" . $col_name . "'";

    $result = $conn->query($sql);
    if ($result->{'num_rows'} > 0) {
        while($row = $result->fetch_array()) {
            return $row['COLUMN_TYPE'];
        }
    }
}

function add_emailed_col($conn, $table)
{
    $sql = "ALTER TABLE " . $table . " ADD COLUMN emailed BOOL DEFAULT 1";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error adding emailed";
    }
}

function add_userid_col($conn, $table)
{
    $sql = "ALTER TABLE " . $table . " ADD COLUMN userid VARCHAR(32) UNIQUE DEFAULT NULL";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error adding userid";
    }
}

function add_playerid_col($conn, $table)
{
    $sql = "ALTER TABLE " . $table . " ADD COLUMN playerid VARCHAR(32) UNIQUE DEFAULT NULL";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error adding playerid";
    }
}

function add_active_col($conn, $table)
{
    $sql = "ALTER TABLE " . $table . " ADD COLUMN active BOOL DEFAULT 1";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error adding active";
    }
}

function change_purchase_cols($conn, $table)
{
    $sql = "ALTER TABLE " . $table . " CHANGE datem monthly_start_date DATE NOT NULL, ";
    $sql .= "CHANGE dated daily_start_date DATE NOT NULL, ";
    $sql .= "CHANGE purchased daily_purchase_limit FLOAT(24,2) NOT NULL, ";
    $sql .= "CHANGE purchasem monthly_purchase_limit FLOAT(24,2) NOT NULL";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error changing purchase columns";
    }
}

function add_is_admin_col($conn, $table)
{
    $sql = "ALTER TABLE " . $table . " ADD COLUMN is_admin BOOL DEFAULT 1";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error adding admin bool";
    }
}

function change_playerid_col($conn, $vtable, $table)
{
    $sql = "ALTER TABLE " . $vtable . " CHANGE playerid playerid VARCHAR(128)";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error changing af playerid column";
    }

    $sql = "ALTER TABLE " . $table . " CHANGE playerid playerid VARCHAR(128) UNIQUE";

    if ($conn->query($sql) === true) {
    } else {
        echo "Error changing nat playerid column";
    }
}
