<?php
class IAttributeTypeEnum
{
    /*INT CONST */
    const TINYINT_IATENUM = 0;
    const SMALLINT_IATENUM = 1;
    const MEDIUMINT_IATENUM = 2;
    const INT_IATENUM = 3;
    const BIGINT_IATENUM = 4;

    const DECIMAL_IATENUM = 5;
    const FLOAT_IATENUM = 6;
    const DOUBLE_IATENUM = 7;
    const REAL_IATENUM = 8;

    const BIT_IATENUM = 9;
    const BOOLEAN_IATENUM = 11;
    const SERIAL_IATENUM = 12;
    const DATE_IATENUM = 13;
    const DATETIME_IATENUM = 14;
    const TIMESTAMP_IATENUM = 15;
    const TIME_IATENUM = 16;
    const YEAR_IATENUM = 17;

    const CHAR_IATENUM = 18;
    const VARCHAR_IATENUM = 19;

    const TINYTEXT_IATENUM = 20;
    const TEXT_IATENUM = 21;
    const MEDIUMTEXT_IATENUM = 22;
    const LONGTEXT_IATENUM = 23;

    const BINARY_IATENUM = 24;
    const VARBINARY_IATENUM = 25;
    const TINYBLOB_IATENUM = 26;
    const MEDIUMBLOB_IATENUM = 27;
    const BLOB_IATENUM = 28;
    const LONGBLOB_IATENUM = 29;
    const ENUM_IATENUM = 30;
    const SET_IATENUM = 31;


    const GEOMETRY_IATENUM = 32;
    const POINT_IATENUM = 33;
    const LINESTRING_IATENUM = 34;
    const POLYGON_IATENUM = 35;
    const MULTIPOINT_IATENUM = 36;
    const MULTILINESTRING_IATENUM = 37;
    const MULTIPOLYGON_IATENUM = 38;
    const GEOMETRYCOLLECTION_IATENUM = 39;
}

class SAttributeTypeEnum
{
    /*STRING CONST*/
    const TINYINT_SATENUM = "TINYINT";
    const SMALLINT_SATENUM = "SMALLINT";
    const MEDIUMINT_SATENUM = "MEDIUMINT";
    const INT_SATENUM = "INT";
    const BIGINT_SATENUM = "BIGINT";

    const DECIMAL_SATENUM = "DECIMAL";
    const FLOAT_SATENUM = "FLOAT";
    const DOUBLE_SATENUM = "DOUBLE";
    const REAL_SATENUM = "REAL";

    const BIT_SATENUM = "BIT";
    const BOOLEAN_SATENUM = "BOOLEAN";
    const SERIAL_SATENUM = "SERIAL";
    const DATE_SATENUM = "DATE";
    const DATETIME_SATENUM = "DATETIME";
    const TIMESTAMP_SATENUM = "TIMESTAMP";
    const TIME_SATENUM = "TIME";
    const YEAR_SATENUM = "YEAR";
    const CHAR_SATENUM = "CHAR";
    const VARCHAR_SATENUM = "VARCHAR";

    const TINYTEXT_SATENUM = "TINYTEXT";
    const TEXT_SATENUM = "TEXT";
    const MEDIUMTEXT_SATENUM = "MEDIUMTEXT";
    const LONGTEXT_SATENUM = "LONGTEXT";

    const BINARY_SATENUM = "BINARY";
    const VARBINARY_SATENUM = "VARBINARY";

    const TINYBLOB_SATENUM = "TINYBLOB";
    const MEDIUMBLOB_SATENUM = "MEDIUMBLOB";
    const BLOB_SATENUM = "BLOB";
    const LONGBLOB_SATENUM = "LONGBLOB";

    const ENUM_SATENUM = "ENUM";
    const SET_SATENUM = "SET";
    const GEOMETRY_SATENUM = "GEOMETRY";
    const POINT_SATENUM = "POINT";
    const LINESTRING_SATENUM = "LINESTRING";
    const POLYGON_SATENUM = "POLYGON";
    const MULTIPOINT_SATENUM = "MULTIPOINT";
    const MULTILINESTRING_SATENUM = "MULTILINESTRING";
    const MULTIPOLYGON_SATENUM = "MULTIPOLYGON";
    const GEOMETRYCOLLECTION_SATENUM = "GEOMETRYCOLLECTION";


}

class Attribute
{
    private $attribute_name;
    private $attribute_length;
    private $attribute_type;
    private $is_required;
    private $can_null;
    private $is_primary;

    public function setAttributeName($p_attribute_name)
    {
        $this->attribute_name = $p_attribute_name;
    }

    public function setAttributeLength($p_attribute_length)
    {
        $this->attribute_length = $p_attribute_length;
    }

    public function setAttributeType($p_attribute_type)
    {
        $this->attribute_type = $p_attribute_type;
    }

    public function setIsRequired($p_is_required)
    {
        $this->is_required = $p_is_required;
    }

    public function setCanNull($p_can_null)
    {
        $this->can_null = $p_can_null;
    }

    public function setIsPrimary($p_is_primary)
    {
        $this->is_primary = $p_is_primary;
    }

    public function getAttributeName()
    {
        return $this->attribute_name;
    }

    public function getAttributeLength()
    {
        return $this->attribute_length;
    }

    public function getAttributeType()
    {
        return $this->attribute_type;
    }

    public function getIsRequired()
    {
        return $this->is_required;
    }

    public function getCanNull()
    {
        return $this->can_null;
    }

    public function getIsPrimary()
    {
        return $this->is_primary;
    }


    /**
     * @param $name nome attributo
     * @param AttributeTypeEnum $type
     * @param $length lunghezza campo
     * @param boolean $isRequired campo richiesto
     * @param boolean $allowNull ammesso null;
     */
    public function Attribute($name, $type, $length, $isRequired, $allowNull, $isPrimary = false)
    {
        $this->attribute_name = $name;
        $this->attribute_type = $type;
        $this->attribute_length = $length;
        $this->is_required = $isRequired;
        $this->can_null = $allowNull;
        $this->is_primary = $isPrimary;
    }

    public function getHtmlInput()
    {
        switch ($this->attribute_type) {
            case SAttributeTypeEnum::INT_SATENUM:
                $format = "<label for='%s'>%s</label> <input type='%s' name='%s' id='%s' %s class='%s' value=''/>";
                $type = "text";
                $class = "$type $this->attribute_type";
                $maxl = ($this->attribute_length != "MAX") ? "maxlength='" . $this->attribute_length . "'" : "";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $type, $this->attribute_name, $this->attribute_name, $maxl, $class);
                break;
            case SAttributeTypeEnum::VARCHAR_SATENUM:
                $format = "<label for='%s'>%s</label> <input type='%s' name='%s' id='%s' %s class='%s' value=''/>";
                $type = "text";
                $class = "$type $this->attribute_type";
                $maxl = ($this->attribute_length != "MAX") ? "maxlength='" . $this->attribute_length . "'" : "";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $type, $this->attribute_name, $this->attribute_name, $maxl, $class);
                break;
            case SAttributeTypeEnum::DATE_SATENUM:
                $format = "<label for='%s'>%s</label> <input type='%s' name='%s' id='%s' class='%s' value='gg/mm/yyyy'/>";
                $type = "text";
                $class = "$type $this->attribute_type";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $type, $this->attribute_name, $this->attribute_name, $class);
                break;
            case SAttributeTypeEnum::DATETIME_SATENUM:
                $format = "<label for='%s'>%s</label> <input type='%s' name='%s' id='%s' class='%s' value='gg/mm/yyyy hh:mm:ss'/>";
                $type = "text";
                $class = "$type $this->attribute_type";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $type, $this->attribute_name, $this->attribute_name, $class);
                break;
            case SAttributeTypeEnum::TIMESTAMP_SATENUM:
                $format = "<label for='%s'>%s</label> <input type='%s' name='%s' id='%s' class='%s' value='gg/mm/yyyy hh:mm:ss'/>";
                $type = "text";
                $class = "$type $this->attribute_type";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $type, $this->attribute_name, $this->attribute_name, $class);
                break;
            case SAttributeTypeEnum::TEXT_SATENUM:
                $format = "<label for='%s'>%s</label> <textarea name='%s' id='%s' class='%s' rows='8' cols='30'></textarea>";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $this->attribute_name, $this->attribute_name, $class);
                break;
            case SAttributeTypeEnum::TINYINT_SATENUM:
                $format = "<label for='%s'>%s</label> <input type='%s' name='%s' id='%s' class='%s' value='1'/>";
                $type = "checkbox";
                $class = "$type $this->attribute_type";
                $ret = sprintf($format, $this->attribute_name, $this->attribute_name, $type, $this->attribute_name, $this->attribute_name, $class);
                break;
            default:
                throw new Exception(__CLASS__ . " - " . __FUNCTION__ . ": Attributo [" . $this->attribute_type . "] non parsificato");

        }

        return $ret;
    }

    public static function LoadInfo($row)
    {
        $isReq = ($row["Null"] == "NO") ? TRUE : FALSE;
        $canNull = ($row["Null"] == "NO") ? FALSE : TRUE;

        $type = $row["Type"];


        $start = strpos($type, '(');

        $end = strpos($type, ')');
        $length = "MAX";
        if ($start != FALSE)
            $length = substr($type, $start + 1, ($end - $start) - 1);

        $hasFind = FALSE;
        $type = strtoupper($type);
        if ($length != "MAX") {
            $type = str_replace("(" . $length . ")", "", $type);
        }
        $find = Utility::FindConstantsFromObject(SAttributeTypeEnum, '/^' . $type . '(.*)/');
        $hasFind = (count($find) > 0) ? TRUE : FALSE;

        if (!$hasFind) {
            throw new Exception("Type mismatch in AttributeTypeEnum $type");
        }


        $isPrimary = $row['Key'] == 'PRI' ? TRUE : FALSE;

        $attribute = new Attribute($row["Field"], $type, $length, $isReq, $canNull, $isPrimary);
        return $attribute;


    }

}