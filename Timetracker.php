<?php

namespace McGun;

class Timetracker
{
    private $starttime;
    private $timestamps = [];
    private $counter;
    private const TABLEMAXLEN = 70;
    private const DESCSTRLEN = 40;

    public function __construct($description = "Init")
    {
        $this->starttime = microtime(true);
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

    private function formatTime($millisecondsInput) {
        $niceTime = [
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'miliseconds' => 0
        ];

        $periods = [
            'hours'         => 3600000,
            'minutes'       => 60000,
            'seconds'       => 1000,
            'miliseconds'   => 1
        ];

        foreach ($periods as $unit => $unitInMilliseconds) {
            $niceTime[$unit] = floor($millisecondsInput / $unitInMilliseconds);
            $millisecondsInput = $millisecondsInput % $unitInMilliseconds;
        }

        return sprintf(
            '%02d:%02d:%02d.%03d',
            $niceTime['hours'],
            $niceTime['minutes'],
            $niceTime['seconds'],
            $niceTime['miliseconds']
        );
    }

    public function add($description = "")
    {
        $this->timestamps[] = [
            $this->counter,
            $description,
            microtime(true) - $this->starttime
        ];
        $this->counter++;

    }

    public function logTable()
    {
        $mask = "|%5.5s |%6.6s%%|%13.13s | %-38.38s |\n";
        $total = 0;

        // Header
        echo "\nTiming table:\n";
        printf("|%s|\n", str_pad('', self::TABLEMAXLEN, '-'));
        printf($mask, 'Num', 'Perc ', 'Time', 'Description');
        printf("|%s|\n", str_pad('', self::TABLEMAXLEN, '-'));

        for ($i = 1; $i < $this->counter; $i++) {
            $time = $this->timestamps[$i][2] - $this->timestamps[$i - 1][2];
            $total += $time;

            $percentage = round($time / ($this->timestamps[$this->counter - 1][2] - $this->timestamps[0][2]), 2) * 100;

            $description = $this->prepareDescription($this->timestamps[$i - 1][1] . " -> " . $this->timestamps[$i][1]);

            printf($mask, $i, $percentage, $this->formatTime($time * 1000), $description);
        }
        
        printf($mask, null, 100, $this->formatTime($total * 1000), "Total time");
        printf("|%s|\n\n", str_pad('', self::TABLEMAXLEN, '_'));
    }
}
