<?php

namespace App\Model\Service;

use Nette;

class PartService extends Nette\Object
{
    public function rowsToSimpleTable($rows)
    {
        $table = array();
        foreach($rows as $row)
        {
            $tableRow = array(
                'socketId' => $row->id,
                'partId' => $row->part->id,
                'socketPosition' => $row->position,
                'partName' => $row->part->name,
                'partType' => $row->part->type->name,
                'available' => $row->available
            );
            $table[] = $tableRow;
        }
        return $table;
    }
}
