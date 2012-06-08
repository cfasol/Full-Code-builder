<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fasolincristopher
 * Date: 08/06/12
 * Time: 09.52
 * To change this template use File | Settings | File Templates.
 */
class Utility
{
    public static function FindConstantsFromObject($object, $filter = null, $find_value = null)
    {
        $reflect = new ReflectionClass($object);
        $constants = $reflect->getConstants();

        foreach ($constants as $name => $value)
        {
            if (!is_null($filter) && !preg_match($filter, $name))
            {
                unset($constants[$name]);
                continue;
            }

            if (!is_null($find_value) && $value != $find_value)
            {
                unset($constants[$name]);
                continue;
            }
        }

        return $constants;
    }

}
