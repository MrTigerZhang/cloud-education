<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Library\Utils;

class ServerInfo
{

    static function disk($dir = '/')
    {
        $free = disk_free_space($dir);
        $total = disk_total_space($dir);
        $usage = $total - $free;
        $percent = 100 * $usage / $total;

        return [
            'total' => self::size($total),
            'free' => self::size($free),
            'usage' => self::size($usage),
            'percent' => round($percent),
        ];
    }

    static function memory()
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            // Windows: use wmic
            $output = [];
            exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value', $output);
            $total = 0;
            $free = 0;
            foreach ($output as $line) {
                if (preg_match('/TotalVisibleMemorySize=(\d+)/', $line, $m)) {
                    $total = (int)$m[1] * 1024; // KB -> bytes
                }
                if (preg_match('/FreePhysicalMemory=(\d+)/', $line, $m)) {
                    $free = (int)$m[1] * 1024; // KB -> bytes
                }
            }
            $usage = $total - $free;
            $percent = $total > 0 ? 100 * $usage / $total : 0;
        } else {
            // Linux: use /proc/meminfo
            $mem = @file_get_contents('/proc/meminfo');
            $total = 0;
            $free = 0;
            if (preg_match('/MemTotal:\s+(\d+) kB/', $mem, $totalMatches)) {
                $total = $totalMatches[1];
            }
            if (preg_match('/MemFree:\s+(\d+) kB/', $mem, $freeMatches)) {
                $free = $freeMatches[1];
            }
            $usage = $total - $free;
            $percent = $total > 0 ? 100 * $usage / $total : 0;
        }

        return array(
            'total' => self::size($total),
            'free' => self::size($free),
            'usage' => self::size($usage),
            'percent' => round($percent),
        );
    }

    static function cpu()
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            // Windows: use wmic to get CPU load
            $output = [];
            exec('wmic cpu get loadpercentage /value', $output);
            foreach ($output as $line) {
                if (preg_match('/LoadPercentage=(\d+)/', $line, $m)) {
                    return [$m[1] / 100, $m[1] / 100, $m[1] / 100];
                }
            }
            return ['0.00', '0.00', '0.00'];
        } else {
            $load = @sys_getloadavg();
            if ($load === false) {
                return ['0.00', '0.00', '0.00'];
            }
            return array_map(function ($value) {
                return sprintf('%.2f', $value);
            }, $load);
        }
    }

    static function size($bytes)
    {
        if (!$bytes) return 0;

        $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        $exp = floor(log($bytes) / log(1024));

        return sprintf('%.2f ' . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
    }

}