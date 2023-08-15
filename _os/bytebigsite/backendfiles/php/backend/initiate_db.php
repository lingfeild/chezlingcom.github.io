<?php

include_once __DIR__ . "/../include.php";

$connection = connect_db();
$conn       = $connection['connection'];

$tables = get_db_tables();
$table  = $tables['table'];
$vtable = $tables['vtable'];
$atable = $tables['atable'];

$sql = create_AF_table($vtable);

if ($conn->query($sql) === true) {
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = create_NAT_table($table);

if ($conn->query($sql) === true) {
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = create_ADMIN_table($atable);

if ($conn->query($sql) === true) {
} else {
    echo "Error creating table: " . $conn->error;
}

$admin_user_handler = New AdminUserHandler();
$admin_user_handler->create_user("admin123", "1q2w3e4r5t", true);
$admin_user_handler->create_user("bitexchanger123", "6y7u8i9o0p", false);
exit;
