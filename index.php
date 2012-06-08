<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fasolincristopher
 * Date: 07/06/12
 * Time: 22.45
 * To change this template use File | Settings | File Templates.
 */

require_once ("includes.conf.php");

?>
<form>
    <input type="hidden" name="action" value="do">
    <select name="tablename">
        <?php
            $db= new Db();
            $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".DB_BASE."'";
            $result=$db->Query($query);
            while ($row = $db->GetRow($result)) {

                ?>

                    <option><?php echo $row["TABLE_NAME"]?></option>

                <?
            }
        ?>
    </select>
        <input type="submit" value="vai">

</form>

<?php
     if(isset($_REQUEST["action"])){


         $table= new Table($_REQUEST["tablename"]);

         echo "<textarea rows='20' cols='35'>".htmlspecialchars($table->toWebForm(False))."</textarea>";
         echo "<textarea rows='20' cols='35'>".$table->toPhpClass(False)."</textarea>";
         echo "<textarea rows='20' cols='35'>".$table->toCShapClass(False)."</textarea>";
     }



/*
$action = $_POST['action'];

if(!isset($action))
    $action="login_db";

switch (strtolower($action)) {
    case "login_db":
        include_once ("db_login.php");
        break;
    case "tbl_s":
       $h=$_POST["host"];
       $u=$_POST["username"];
       $p=$_POST["username"];
       $dbname=$_POST["dbname"];
       if(isset($p))
       $connection=mysql_connect($h,$u,$p);
       else
           $connection=mysql_connect($h,$u);
       mysql_select_db($dbname,$connection);

        break;



} */