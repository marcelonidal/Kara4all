<?php
//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

//====================================================
// USERS
//====================================================

//====================================================
// CRIA A TABELA DE USERS NO BANCO SE NAO EXISTIR
//====================================================
$sql = 'CREATE TABLE IF NOT EXISTS USERS(
        U_ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
        U_NAME VARCHAR (80),
        U_EMAIL VARCHAR (100) UNIQUE,
        U_USERNAME VARCHAR (50) UNIQUE,
        U_PSW VARCHAR (50),
        FB_ID VARCHAR (50)
        )';

$query = mysqli_query($con, $sql);

//====================================================
// CATEGORY
//====================================================

//====================================================
// CRIA A TABELA DE NAC NO BANCO SE NAO EXISTIR
//====================================================
$sql = 'CREATE TABLE IF NOT EXISTS NAC(
        N_ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
        N_ARTIST VARCHAR (100),
        N_MUSIC VARCHAR (150)
        )';

$query = mysqli_query($con, $sql);

//====================================================
// CRIA A TABELA DE INT NO BANCO SE NAO EXISTIR
//====================================================
$sql = 'CREATE TABLE IF NOT EXISTS INTER(
        I_ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
        I_ARTIST VARCHAR (100),
        I_MUSIC VARCHAR (150)
        )';

$query = mysqli_query($con, $sql);

//====================================================
// EVENTS
//====================================================

//====================================================
// CRIA A TABELA EVENTS NO BANCO SE NAO EXISTIR
//====================================================
$sql = 'CREATE TABLE IF NOT EXISTS EVENTS(
        E_ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
        E_DATA VARCHAR (100),
        E_LOCAL VARCHAR (400)
        )';

$query = mysqli_query($con, $sql);

//====================================================
// QUEUE
//====================================================

//====================================================
// CRIA A TABELA QUEUE NO BANCO SE NAO EXISTIR
//====================================================
$sql = 'CREATE TABLE IF NOT EXISTS QUEUE(
        Q_ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
        Q_USER_ID INT,
        Q_NAME VARCHAR (150),
        Q_COD_MUSIC INT,
        Q_MUSIC varchar (300),
        Q_DATE varchar (100),
        Q_ORDERS INT
        )';

$query = mysqli_query($con, $sql);

$con->close();