<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fasolincristopher
 * Date: 08/06/12
 * Time: 08.25
 * To change this template use File | Settings | File Templates.
 */
class Table
{
    private $attributeList = null;
    private $primary_key;
    private $tablename = "";
    /**
     * @var Db
     */
    private $Obj_db;

    public function getTable()
    {
        return $this->tablename;
    }

    public function getColumns()
    {
           return $this->attributeList;
    }

    public function getPrimaryKey()
    {
        return $this->primary_key;
    }

    public function Table($p_tablename)
    {
        $this->Obj_db = new Db();
        $this->tablename = $p_tablename;
        $this->attributeList = array();
        $this->Load();
    }

    public function Load()
    {
        $query = "SHOW COLUMNS FROM {$this->tablename}";
        $result = $this->Obj_db->Query($query);
        while ($row = $this->Obj_db->GetRow($result)) {
            $this->addAttribute(Attribute::LoadInfo($row));
            if ($row['Key'] == 'PRI')
                $this->primary_key = $row['Field'];
        }
    }


    public function getAttributes()
    {
        return $this->attributeList;
    }

    public function addAttribute(Attribute $attributeObj)
    {

        $this->attributeList[] = $attributeObj;
    }

    public function toString()
    {
        print_r($this->attributeList);

    }

    public function toWebForm($canEcho = true)
    {
        $out = "<form>";
        //$attributeObj = new Attribute();
        foreach ($this->attributeList as $attributeObj) {

            $out .= $attributeObj->getHtmlInput() . "<br/>";
        }
        $out .= "</form>";

        if ($canEcho)
            echo $out;

        return $out;
    }

    public function toPhpClass($canEcho = true)
    {
        $oPhpBuilder = new PhpBuilder($this->getTable());
        $out = $oPhpBuilder->Get();
        if ($canEcho)
            echo $out;

        return $out;
    }

    public function toCShapClass($canEcho = true)
    {
        $out="not implemented";
        if ($canEcho)
            echo $out;

        return $out;
    }


}

//public function AddColumn($column)
//{
//    $pattern = "([a-z]{1,})[\(]{0,}([0-9]{0,})[\)]{0,}";
//    $matches = array();
//    @ereg($pattern,$column['Type'],$matches);
//    $column['Type']   = $matches[1];
//    $column['Length'] = $matches[2];
//    $this->columns[] = $column;
//    if( $column['Key'] == 'PRI' )
//        $this->primary_key = $column['Field'];
//}
//
//