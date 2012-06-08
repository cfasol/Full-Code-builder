<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fasolincristopher
 * Date: 08/06/12
 * Time: 09.17
 * To change this template use File | Settings | File Templates.
 */
$database_connection_information = "
define(DB_HOST,'127.0.0.1');
define(DB_USER,'root');
define(DB_PASS,'');
define(DB_BASE,'immobiliare');
";

eval($database_connection_information);


class Db
{
    private $dblink = null;

    public function __construct(){

    }
    public function __destruct()
    {
        if (is_resource($this->dblink))
            mysql_close($this->dblink);
    }

    public function Connect()
    {
        $ret = $this->dblink;
        if (is_null($this->dblink)) {
            $ret = $this->getDbLink();
        }
        return $ret;
    }

    public function Query($q)
    {
        $result = mysql_query($q, $this->Connect());
        return $result;
    }

    public function GetRow($r)
    {
        return mysql_fetch_assoc($r);
    }

    public function getDbLink()
    {
        if (!is_resource($this->dblink)) {
            $dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_BASE);
            $this->dblink = $dblink;
        }
        return $this->dblink;
    }

}
