<?php

namespace McGun;

class Memtracker
{
    private $memstamps = [];
    private $counter;
    private const TABLEMAXLEN = 70;
    private const DESCSTRLEN = 40;

    public function __construct($description = "Init")
    {
        $this->starttime = round(microtime(1) * 1000, 2);
        $this->counter = 0;
        $this->add($description);
    }

    private function prepareDescription(string $string)
    {
        if (strlen($string) > self::DESCSTRLEN) {
            return substr($string, 0, (self::DESCSTRLEN - 3)) . "...";
        }
        
        return $string;
    }

    private function convertMemoryUnit($size)
    {
        $unit = ['B', 'K', 'MB', 'GB', 'TB', 'PB'];

        return sprintf(
            "%d %s",
            number_format(
                $size / pow(1024, ($i = floor(log($size, 1024)))),
                0,
                ',',
                ' '
            ),
            $unit[$i]
        );
    }

    public function add($description = "")
    {
        $this->memstamps[] = [
            $this->counter,
            $description,
            memory_get_usage()
        ];
        $this->counter++;
    }

    public function logTable()
    {
        $mask = "|%5.5s |%6.6s%%|%11.11s | %-40.40s |\n";
        $peak = memory_get_peak_usage(true);

        // Header
        echo "\nMemory table:\n";
        printf("Peaking at: %s\n", $this->convertMemoryUnit($peak));

        printf("|%s|\n", str_pad('', self::TABLEMAXLEN, '-'));
        printf($mask, 'Num', 'Perc ', 'Memory', 'Description');
        printf("|%s|\n", str_pad('', self::TABLEMAXLEN, '-'));


        for ($i = 1; $i < $this->counter; $i++) {
            $percentage = round($this->memstamps[$i][2] / $peak, 2) * 100;
            
            $mem = $this->convertMemoryUnit($this->memstamps[$i][2]);

            $description = $this->prepareDescription($this->memstamps[$i - 1][1] . " -> " . $this->memstamps[$i][1]);

            printf($mask, $i, $percentage, $mem, $description);
        }
        printf("|%s|\n\n", str_pad('', self::TABLEMAXLEN, '_'));
    }
}
