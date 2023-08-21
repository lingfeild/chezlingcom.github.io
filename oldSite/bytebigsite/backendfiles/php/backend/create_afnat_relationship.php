<?php

include_once __DIR__ . "/../include.php";

$connection = connect_db();
$conn       = $connection['connection'];

$tables = get_db_tables();
$table  = $tables['table'];
$vtable = $tables['vtable'];

$sql      = "SELECT playerid, email FROM " . $vtable . " WHERE userid IS NULL";
$vip_data = $conn->query($sql);

while ($vip_row = $vip_data->fetch_assoc()) {
    $playerid  = $vip_row['playerid'];
    $vip_email = decrypt($vip_row['email'], $playerid);

    $userid = search_NAT_emails($conn, $table, $vtable, $playerid, $vip_email);

    if ($userid != false) {
        set_vip_userid($conn, $vtable, $playerid, $userid);
        set_nat_playerid($conn, $table, $userid, $playerid);
    }
}
$conn->close();
exit;

/***************************************************************************/

function search_NAT_emails($conn, $table, $vtable, $playerid, $vip_email)
{
    $sql      = "SELECT userid, email FROM " . $table . " WHERE playerid IS NULL";
    $nat_data = $conn->query($sql);

    while ($nat_row = $nat_data->fetch_assoc()) {
        $userid    = $nat_row['userid'];
        $nat_email = decrypt($nat_row['email'], $userid);

        if ($nat_email == $vip_email) {
            return $userid;
        }
    }
    return false;
}

function set_vip_userid($conn, $table, $playerid, $userid)
{
    $sql = $conn->prepare("UPDATE " . $table . " SET userid=? WHERE playerid=?");
    if (!$sql) {
        $conn->close();
        echo false;
        exit;
    }
    $sql->bind_param('ss', $userid, $playerid);
    $sql->execute();
}

function set_nat_playerid($conn, $table, $userid, $playerid)
{
    $sql = $conn->prepare("UPDATE " . $table . " SET playerid=? WHERE userid=?");
    if (!$sql) {
        $conn->close();
        echo false;
        exit;
    }
    $sql->bind_param('ss', $playerid, $userid);
    $sql->execute();
}
