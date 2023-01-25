<?php 

class Month{

    public $days = ['Lundi' , 'Mardi' , 'Mercredi' , 'Jeudi' , 'Vendredi' , 'Samedi' , 'Dimanche'];
    private $months = ['Janvier' , 'Février' , 'Mars' , 'Avril' , 'Mai' , 'Juin' , 'Juillet' , 'Août' , 'Septembre' , 'Octobre' , 'Novembre' , 'Décembre'];

    private $date;

    public $year;
    public $month;
    public $week;
    public $day;


    /**
     * month constructor
     * 
     * @param int $month the months is between 1 and 12
     * @param int $year current year of calendar
     * @param int $week the num of week between 1 and 5 or 6 
     * @param int $day the num of day between 1 and 30 or 31
     */

    public function __construct(?int $month = null , ?int $year = null , ?int $week = null , ?int $day = null)
    {
        if($month === null || $month < 1 || $month > 12){
            $month = intval(date('m'));
        }

        if($year === null){
            $year = intval(date('Y'));
        }

        if($week === null || $week < 1 || $week > 6){
            $week = 1;
        }

        if($day === null || $day < 1 || $day > 31){
            $day = intval(date('d'));
        }

        $this->year = $year;
        $this->month = $month;
        $this->week = $week;
        $this->day = $day;
    }

    /**
     * return the first day of month 
     * 
     * @return DateTimeImmutable
     */
    public function getFirstDay(){
        return new DateTimeImmutable("{$this->year}-{$this->month}-01");
    }

    /**
     * add 0 if day between 1 and 9  else return $dayDate
     * @param int $dayDate day numero 
     * 
     * @return string date format
     */
    public function formatDayNumber($dayDate){
        if($dayDate > 1 && $dayDate <= 9){
            return '0'.date($dayDate);
        }
        else{
            return $dayDate;
        }
    }


    /**
     * return the month in full letters
     * 
     * @return string
     */
    public function toStringMonth(){
        return $this->months[$this->month - 1].' '. $this->year;
    }

    /**
     * return the number of weeks in the month
     * 
     * @return int
     */
    public function getWeeks(){
        $start = $this->getFirstDay();
        $end = $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));

        if($endWeek === 1 ){
            $endWeek = intval($end->modify('- 7 days')->format('W')) + 1;
        }
        $weeks = $endWeek - $startWeek + 1;

        if($weeks < 0 ){
            $weeks = intval($end->format('W'));
        }

        if($this->getFirstDay()->modify('next Sunday')->modify('-7 days') == $this->getFirstDay()){
            $weeks = $weeks + 1;
        }

        return $weeks;
    }

    /**
     * test if the day is in current month
     * 
     * @param DateTimeImmutable $date
     * @return bool
     */
    public function withinMonth($date){
        return $this->getFirstDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * return month after current month
     * 
     * @return month
     */
    public function nextMonth(){
        $year = $this->year;
        $month = $this->month + 1;
        $week = 1;
        $day = 1;

        if($month > 12){
            $year += 1;
            $month = 1;
            $week = 1;
            $day = 1;
        }

        return new Month($month, $year, $week , $day);
    }

    /**
     * return month before current month
     * 
     * @return month
     */
    public function previousMonth(){
        $year = $this->year;
        $month = $this->month - 1;
        $week = $this->getWeeks();
        $day = intval(date('t'));

        if($month < 1){
            $year -= 1;
            $month = 12;
        }
        return new Month($month, $year , $week , $day);
    }

    /**
     * convert num week to day number
     * 
     * @return int 
     */
    private function convertWeek($week){
        if($week >= 1 && $week < 7){
            switch($week){
                case 1:
                    return 0;
                    break;
                case 2:
                    return 7*1;
                    break;
                case 3:
                    return 7*2;
                    break;
                case 4:
                    return 7*3;
                    break;
                case 5:
                    return 7*4;
                    break;
                case 6:
                    return 7*5;
                    break;
            }
        }
    }

    /**
     * Allow to setup the right week to display
     * 
     * @return int 
     */
    public function setupWeek($week){

        if($week <= 0){
            $this->previousMonth();
            return $this->getWeeks();
        }

        if($week > $this->getWeeks()){
            $this->nextMonth();
            return 1;
        }

        if($week >=1 && $week < 7){
            return $this->convertWeek($week);
        }
    }

    /**
     * return the week at the format day to day month
     * 
     * @return string 
     */
    public function toStringWeek($date){
        $this->date = $date;
        return "Du ". $date->modify('- 6 day')->format("d")." au ". $date->format("d") . " " . $this->months[$this->month - 1] . " " . $this->year;
    }

    /**
     * test if the current day is between monday and Sunday of week
     * 
     * @return bool
     */
    private function withinWeek(\DateTimeImmutable $firstWeekDay){
        $currentDay = date('Y-m-d');
        $firstWeekDay = $firstWeekDay;
        $lastWeekDay = $firstWeekDay->modify('+' . 6 . 'days');

        $firstWeekDay = $firstWeekDay->format('Y-m-d');
        $lastWeekDay = $lastWeekDay->format('Y-m-d');
        return $currentDay >= $firstWeekDay && $currentDay <= $lastWeekDay;
    }

    /**
     * return the numero of current week
     * 
     * @return int
     */
    public function getCurrentWeek(){
        $numWeek = 1;
        $monday = $this->getFirstDay()->modify('last Monday');

        // if(){
        //     return $numWeek;
        // }

        for($numWeek; $numWeek < $this->getWeeks(); $numWeek++){
            if($this->withinWeek($monday)){
                return $numWeek;
            }
            else{
               $monday = $monday->modify('+' . 7 . 'days');
            }
        }
    }

    /**
     * return week after current week
     * 
     * @return Month
     */
    public function nextWeek(){
        $year = $this->year;
        $month = $this->month;
        $week = $this->week + 1;
        $day = $this->date->modify('- 6 day')->format("d");

        if($week > $this->getWeeks()){
            $year = $this->nextMonth()->year;
            $month = $this->nextMonth()->month;
            $week = $this->nextMonth()->week;
            $day = $this->nextMonth()->day;
        }

        return new Month($month , $year , $week , $day);
    }

    /**
     * return week before current week
     * 
     * @return Month
     */
    public function previousWeek(){
        $year = $this->year;
        $month = $this->month;
        $week = $this->week - 1;
        $day = $this->date->format("d");

        if($week === 0){
            $year = $this->previousMonth()->year;
            $month = $this->previousMonth()->month;
            $week = $this->previousMonth()->week;
            $day = $this->previousMonth()->day;
        }

        return new Month($month , $year , $week , $day);
    }

    /**
     * return the day at the format day dayNumber month
     * 
     * @return string 
     */
    public function toStringDay(){
        if($this->day < 10){
            return "0".$this->day. " " . $this->months[$this->month - 1] . " " . $this->year;
        }
        return $this->day. " " . $this->months[$this->month - 1] . " " . $this->year;
    }

    /**
     * return day before current day
     * 
     * @return month
     */
    public function previousDay(){
        $year = $this->year;
        $month = $this->month;
        $week = $this->week;
        $day = $this->day - 1;

        if($day === 0){
            $year = $this->previousMonth()->year;
            $month = $this->previousMonth()->month;
            $week = $this->previousMonth()->week;
            $day = $this->previousMonth()->day;
        }

        return new Month($month , $year , $week , $day);
    }

    /**
     * return day after the current day
     * 
     * @return month
     */
    public function nextDay(){
        $year = $this->year;
        $month = $this->month;
        $week = $this->week;
        $day = $this->day + 1;

        if($day > date('t')){
           $year = $this->nextMonth()->year;
           $month = $this->nextMonth()->month;
           $week = $this->nextMonth()->week;
           $day = $this->nextMonth()->day;
        }

        return new Month($month , $year , $week , $day);
    }
}
?>