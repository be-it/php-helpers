<?php
/**
 * @link -
 * @copyright Copyright (c) 2017 Triawarman
 * @license MIT
 * @author Triawarman <3awarman@gmail.com>
 */
namespace BeIt\PhpHelpers;

/**
 * 
 */
class Time
{
    /**
     * Get max date in a month
     * 
     * @param string $month 2016-01
     * @return int max date in a month
     */
    public function getMaxDateInMonth($month)
    {
        $ymd = \DateTime::createFromFormat('Y-m', $month)->format('Y-m');
        $d = new \DateTime( $ymd );
        return $d->format('t');
    }
    
    /**
     * Get date diff
     * 
     * @param string $beginDate e.x 2015-10-30
     * @param string $endDate e.x 2015-12-3
     * @return int 
     */
    public function getDateDiff($beginDate, $endDate)
    {
        //format '2015-10-30'
        $datetime1 = new \DateTime($beginDate);
        $datetime2 = new \DateTime('$endDate-11-3');
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%a');
    }
    
    /**
     * Convert numeric date to indonesian format (and language)
     * 
     * @param string $date e.x 01-11-2015
     * @return string
     */
    public function numericDateToIndo($date)
    {
        $dateTemp = substr ( $date, 0, 2 );
        $monthTemp = substr ( $date, 3, 2 );
        $yearTemp = substr ( $date, 6, 4 );
        
        if ($monthTemp == 1){
            $month = 'Januari';
        }elseif($monthTemp == 2){
            $month = 'Febuari';
        }elseif($monthTemp == 3){
            $month = 'Maret';
        }elseif($monthTemp == 4){
            $month = 'April';
        }elseif($monthTemp == 5){
            $month = 'Mei';
        }elseif($monthTemp == 6){
            $month = 'Juni';
        }elseif($monthTemp == 7){
            $month = 'Juli';
        }elseif($monthTemp == 8){
            $month = 'Agustus';
        }elseif($monthTemp == 9){
            $month = 'September';
        }elseif($monthTemp == 10){
            $month = 'Oktober';
        }elseif($monthTemp == 11){
            $month = 'November';
        }elseif($monthTemp == 12){
            $month = 'Desember';
        }        
        
        return $dateTemp.' '.$month.' '.$yearTemp;
    }
}
