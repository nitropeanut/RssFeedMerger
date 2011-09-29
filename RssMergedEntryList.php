<?php

/**
 *
 * @author simran
 */
class RssMergedEntryList extends SplMaxHeap 
{

    public function compare($value1, $value2) 
    {
        $v1Time = strtotime($value1->lastUpdate);
        $v2Time = strtotime($value2->lastUpdate);

        if ($v1Time == $v2Time)
        {
            return 0;
        }
        
        if ($v1Time > $v2Time)
        {
            return -1;
        }
        else
        {
            return 1;
        }
    }
    
}

?>
