<?php

function get_db_config()
{
    $oldValue = libxml_disable_entity_loader(true);
    libxml_disable_entity_loader($oldValue);
    if (file_exists(DB_CONFIG)) {
        $xml = simplexml_load_file(DB_CONFIG, null, LIBXML_NOENT);
    } else {
        $xml['error'] = "Error Cannot Find DB File";
    }
    return $xml;
}

function get_db_tables()
{
    $xml = get_db_config();
    if (isset($xml['error'])) {
        $tables['error'] = $xml['error'];
        return $tables;
    }
    $tables['table']  = $xml->table;
    $tables['atable'] = $xml->atable;
    $tables['vtable'] = $xml->vtable;
    $tables['ttable'] = $xml->ttable;
    return $tables;
}

function connect_db()
{
    $xml = get_db_config();
    if (isset($xml['error'])) {
        $conn['error'] = $xml['error'];
        return $conn;
    }
    try {
        $connection = new mysqli($xml->servername, $xml->username, $xml->password, $xml->database);
    } catch (Exception $e) {
        $conn['error'] = "Error Creating Connection to DB";
        return $conn;
    }

    $conn['connection'] = $connection;
    return $conn;
}

function create_NAT_table($table)
{
    $sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
        userid VARCHAR(15) PRIMARY KEY,
        password VARCHAR(128) NOT NULL,
        firstname VARCHAR(128) NOT NULL,
        lastname VARCHAR(128) NOT NULL,
        mobilenumber VARCHAR(128) NOT NULL,
        email VARCHAR(128) NOT NULL UNIQUE,
        address VARCHAR(128) NOT NULL,
        city VARCHAR(128) NOT NULL,
        postalcode VARCHAR(128) NOT NULL,
        state VARCHAR(128) NOT NULL,
        country VARCHAR(128) NOT NULL,
        tier INT(1) NOT NULL,
        daily_purchase_limit FLOAT(24,2) NOT NULL,
        daily_start_date DATE NOT NULL,
        monthly_purchase_limit FLOAT(24,2) NOT NULL,
        monthly_start_date DATE NOT NULL,
        vip BOOLEAN NOT NULL,
        playerid VARCHAR(128) UNIQUE,
        active BOOLEAN NOT NULL
    )";
    return $sql;
}

function create_AF_table($table)
{
    $sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
        playerid VARCHAR(128) PRIMARY KEY,
        firstname VARCHAR(128) NOT NULL,
        lastname VARCHAR(128) NOT NULL,
        mobilenumber VARCHAR(128) NOT NULL,
        email VARCHAR(128) NOT NULL UNIQUE,
        address VARCHAR(128) NOT NULL,
        city VARCHAR(128) NOT NULL,
        postalcode VARCHAR(128) NOT NULL,
        state VARCHAR(128) NOT NULL,
        country VARCHAR(128) NOT NULL,
        visits INT(6) NOT NULL,
        emailed BOOL NOT NULL,
        userid VARCHAR(32) NOT NULL UNIQUE
    )";
    return $sql;
}

function create_ADMIN_table($table)
{
    $sql = "CREATE TABLE IF NOT EXISTS " . $table . " (
        userid VARCHAR(15) PRIMARY KEY,
        password VARCHAR(128) NOT NULL,
        is_admin BOOL NOT NULL
    )";
    return $sql;
}