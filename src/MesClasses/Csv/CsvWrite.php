<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/MesClasses/Csv/CsvWrite.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 18/05/2018
 * Time: 12:52
 */

namespace App\MesClasses\Csv;

use function get_class;
use function is_object;
use function is_string;

/**
 * Class CsvWrite
 * @package App\MesClasses\Csv
 */
abstract class CsvWrite
{
    public const FORMAT_DATETIME = 'DateTime';
    public const FORMAT_STRING = 'string';
    public const ECHAPPEMENT = '"';

    /**
     * @param        $value
     * @param string $key
     *
     * @return string
     */
    public static function writeField($value, $key = ''): string
    {
        $field = '';
        $field .= $key;


        if (is_string($value)) {
            $field .= self::ECHAPPEMENT . $value . self::ECHAPPEMENT;
        } /* if ($data instanceof \DateTimeImmutable || $data instanceof \DateTime) {
            return $data;
        }*/

        elseif (is_object($value)) {
            if (get_class($value) === self::FORMAT_DATETIME) {
                $field .= $value->format('d-m-Y');
            }
        } else {
            $field .= $value;
        }


        return $field;
    }
}
