<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fasolincristopher
 * Date: 08/06/12
 * Time: 10.40
 * To change this template use File | Settings | File Templates.
 */
class PhpBuilder
{
    private $buffer;
    private $validate;
    /**@var Table*/
    private $table_descriptor;
    private $variable_types = array(
        "INT"       => "int",
        "TEXT"      => "string",
        "BOOL"      => "bool",
        "DATE"      => "int",
        "BLOB"      => "int",
        "FLOAT"     => "int",
        "DOUBLE"    => "int",
        "BIGINT"    => "int",
        "TINYINT"   => "int",
        "LONGINT"   => "int",
        "VARCHAR"   => "string",
        "SMALLINT"  => "int",
        "DATETIME"  => "int",
        "TIMESTAMP" => "int"
    );

    public function __construct($table='',$validate=false)
    {
        $this->table_descriptor = new Table($table);
        $this->validate = $validate;
        $this->Load();
    }

    private function Load()
    {
        $buf = "";
        if( Settings::$validator_written == false )
        {
            $buf .= "class validate\n";
            $buf .= "{\n";
            $buf .= "\tpublic function isstring(\$string)\n";
            $buf .= "\t{\n";
            $buf .= "\t\treturn (is_string(\$string));\n";
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function isint(\$int)\n";
            $buf .= "\t{\n";
            $buf .= "\t\treturn (preg_match(\"/^([0-9.,-]+)$/\", \$int) > 0);\n";
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function isbool(\$bool)\n";
            $buf .= "\t{\n";
            $buf .= "\t\t\$b = 1 * \$bool;\n";
            $buf .= "\t\treturn (\$b == 1 || \$b == 0);\n";
            $buf .= "\t}\n";
            $buf .= "}\n\n";

            Settings::$validator_written = true;
        }

        $buf .= "/******************************************************************************\n";
        $buf .= "* Class for " . DB_BASE . "." . $this->table_descriptor->getTable() . "\n";
        $buf .= "*******************************************************************************/\n\n";
        $buf .= "class {$this->table_descriptor->getTable()}\n{\n";
        //$column= new Attribute();//perautocomplete
        foreach($this->table_descriptor->getColumns() as $column)
        {
            $column_name = str_replace('-','_',$column->getAttributeName());
            $buf .= "\t/**\n";
            $buf .= "\t* @var {$this->variable_types[$column->getAttributeType()]}\n";
            if( $column->getAttributeName() == $this->table_descriptor->getPrimaryKey() )
            {
                $buf .= "\t* Class Unique ID\n";
            }
            $buf .= "\t*/\n";
            $buf .= "\tprivate \$$column_name;\n\n";
        }

        if( $this->table_descriptor->getPrimaryKey() != '' )
        {
            $pk   = $this->table_descriptor->getPrimaryKey();
            $buf .= "\tpublic function __construct(\$$pk='')\n";
            $buf .= "\t{\n";
            $buf .= "\t\t\$this->set{$pk}(\$$pk);\n";
            $buf .= "\t\t\$this->Load();\n";
            $buf .= "\t}\n\n";

            $buf .= "\tprivate function Load()\n";
            $buf .= "\t{\n";
            $buf .= "\t\t\$dblink = null;\n\n";

            $buf .= "\t\ttry\n";
            $buf .= "\t\t{\n";
            $buf .= "\t\t\t\$dblink = mysql_connect(DB_HOST,DB_USER,DB_PASS);\n";
            $buf .= "\t\t\tmysql_select_db(DB_BASE,\$dblink);\n";
            $buf .= "\t\t}\n";
            $buf .= "\t\tcatch(Exception \$ex)\n";
            $buf .= "\t\t{\n";
            $buf .= "\t\t\techo \"Could not connect to \" . DB_HOST . \":\" . DB_BASE . \"\\n\";\n";
            $buf .= "\t\t\techo \"Error: \" . \$ex->message;\n";
            $buf .= "\t\t\texit;\n";
            $buf .= "\t\t}\n";
            $buf .= "\t\t\$query = \"SELECT * FROM " . $this->table_descriptor->getTable() . " WHERE `$pk`='{\$this->get$pk()}'\";\n\n";
            $buf .= "\t\t\$result = mysql_query(\$query,\$dblink);\n\n";
            $buf .= "\t\twhile(\$row = mysql_fetch_assoc(\$result) )\n";
            $buf .= "\t\t\tforeach(\$row as \$key => \$value)\n";
            $buf .= "\t\t\t{\n";
            $buf .= "\t\t\t\t\$column_name = str_replace('-','_',\$key);\n";
            $buf .= "\t\t\t\t\$this->{\"set\$column_name\"}(\$value);\n\n";
            $buf .= "\t\t\t}\n";
            $buf .= "\t\tif(is_resource(\$dblink)) mysql_close(\$dblink);\n";
            $buf .= "\t}\n\n";

            $update_columns = "";

            foreach($this->table_descriptor->getColumns() as $column)
            {
                if( $column->getAttributeName() != $this->table_descriptor->getPrimaryKey() )
                {
                    $column_name = str_replace('-','_',$column->getAttributeName());
                    $update_columns .= "\n\t\t\t\t\t\t`{$column->getAttributeName()}` = '\" . mysql_real_escape_string(\$this->get$column_name(),\$dblink) . \"',";
                }
            }
            $update_columns = rtrim($update_columns,',');

            $buf .= "\tpublic function Save()\n";
            $buf .= "\t{\n";
            $buf .= "\t\t\$dblink = null;\n\n";

            $buf .= "\t\ttry\n";
            $buf .= "\t\t{\n";
            $buf .= "\t\t\t\$dblink = mysql_connect(DB_HOST,DB_USER,DB_PASS);\n";
            $buf .= "\t\t\tmysql_select_db(DB_BASE,\$dblink);\n";
            $buf .= "\t\t}\n";
            $buf .= "\t\tcatch(Exception \$ex)\n";
            $buf .= "\t\t{\n";
            $buf .= "\t\t\techo \"Could not connect to \" . DB_HOST . \":\" . DB_BASE . \"\\n\";\n";
            $buf .= "\t\t\techo \"Error: \" . \$ex->message;\n";
            $buf .= "\t\t\texit;\n";
            $buf .= "\t\t}\n";
            $buf .= "\t\t\$query = \"UPDATE " . $this->table_descriptor->getTable() . " SET $update_columns \n\t\t\t\t\t\tWHERE `$pk`='{\$this->get$pk()}'\";\n\n";
            $buf .= "\t\tmysql_query(\$query,\$dblink);\n\n";
            $buf .= "\t\tif(is_resource(\$dblink)) mysql_close(\$dblink);\n";
            $buf .= "\t}\n\n";
        }

        $insert_columns = "";
        $insert_values  = "";
        foreach($this->table_descriptor->getColumns() as $column)
        {
            if( $column->getAttributeName() != $this->table_descriptor->getPrimaryKey() )
            {
                $column_name = str_replace('-','_',$column->getAttributeName());
                $insert_columns .= "`{$column->getAttributeName()}`,";
                $insert_values  .= "'\" . mysql_real_escape_string(\$this->get$column_name(),\$dblink) . \"',";
            }
        }
        $insert_columns = rtrim($insert_columns,',');
        $insert_values  = rtrim($insert_values,',');

        $buf .= "\tpublic function Create()\n";
        $buf .= "\t{\n";
        $buf .= "\t\t\$dblink = null;\n\n";

        $buf .= "\t\ttry\n";
        $buf .= "\t\t{\n";
        $buf .= "\t\t\t\$dblink = mysql_connect(DB_HOST,DB_USER,DB_PASS);\n";
        $buf .= "\t\t\tmysql_select_db(DB_BASE,\$dblink);\n";
        $buf .= "\t\t}\n";
        $buf .= "\t\tcatch(Exception \$ex)\n";
        $buf .= "\t\t{\n";
        $buf .= "\t\t\techo \"Could not connect to \" . DB_HOST . \":\" . DB_BASE . \"\\n\";\n";
        $buf .= "\t\t\techo \"Error: \" . \$ex->message;\n";
        $buf .= "\t\t\texit;\n";
        $buf .= "\t\t}\n";
        $buf .= "\t\t\$query =\"INSERT INTO {$this->table_descriptor->getTable()} ($insert_columns) VALUES ($insert_values);\";\n";
        $buf .= "\t\tmysql_query(\$query,\$dblink);\n\n";
        $buf .= "\t\tif(is_resource(\$dblink)) mysql_close(\$dblink);\n";
        $buf .= "\t}\n\n";

        foreach($this->table_descriptor->getColumns() as $column)
        {
            $column_name = str_replace('-','_',$column->getAttributeName());
            $buf .= "\tpublic function set$column_name(\$$column_name='')\n";
            $buf .= "\t{\n";
            if( $this->validate )
            {
                $buf .= "\t\tif(validate::is{$this->variable_types[$column->getAttributeType()]}(\$$column_name))\n";
                $buf .= "\t\t{\n";
                $buf .= "\t\t\t\$this->$column_name = \$$column_name;\n";
                $buf .= "\t\t\treturn true;\n";
                $buf .= "\t\t}\n";
                $buf .= "\t\treturn false;\n";
            }
            else
            {
                $buf .= "\t\t\$this->$column_name = \$$column_name;\n";
                $buf .= "\t\treturn true;\n";
            }
            $buf .= "\t}\n\n";

            $buf .= "\tpublic function get$column_name()\n";
            $buf .= "\t{\n";
            $buf .= "\t\treturn \$this->$column_name;\n";
            $buf .= "\t}\n\n";
        }

        $buf .= "} // END class {$this->table_descriptor->getTable()}\n\n";
        $this->buffer = $buf;
    }

    public function Get() { return $this->buffer; }

}
