<?php

class MCFCalendar
{
   var $start_date;
   var $end_date;
   var $first_day;
   var $last_day;
   var $calendar_table = array();
   var $events = array();
   
   public function __construct($timestamp = null)
   {
     if(is_null($timestamp)) $timestamp = time();
      $this->start_date = self::getFirstDayTable($timestamp);
      $this->end_date = self::getLastDayTable($timestamp);   
      $this->first_day = mktime(0,0,0,date('n', $timestamp), 1, date('y', $timestamp));
      $this->last_day = mktime(0,0,0,date('n', $timestamp), date('t', $timestamp), date('y', $timestamp));
   }
   
   public function processEvents($events = array())
   {
      foreach ($events as $event)
      {
         $start = strtotime($event->getstartdate());
         $end = strtotime($event->getenddate());
         
         if ($start <= $end)
         {
          while($start <= $end)
          {
             $this->events[$start][] = $event;
             $start = strtotime(' + 1 DAY', $start); // 3600*24;
          }  
         }         
      }
   }
   
   public function processCalendar()
   {
      $date = $this->start_date;
      $week_nbr = 0;
      $today = getdate();
      $this->calendar_table = array(); // Reset the table
      
      while ($date <= $this->end_date)
      {   
         $this->calendar_table[$week_nbr][] = array(
                                                'date' => $date, 
                                                'mysql_date' => date('Y/m/d', $date), 
                                                'text' => date('l d/M/Y',$date),
                                                'events' => (isset($this->events[$date]))?$this->events[$date]:array(),
                                                'current' => (($date >= $this->first_day) && ($date <= $this->last_day)),
																								'today' => ($date == mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']))
                                                );
         
         if (date('N', $date) == 7)
         {
            $week_nbr++;
         }
         
         $date = strtotime(' + 1 DAY', $date); // 3600*24;
      }
   }
   
   public static function getTimestampFromMonthYear($month, $year)
   {
      return mktime(0,0,0,$month, 1, $year);
   }
   
   public static function getNextMonthTimestamp($timestamp)
   {      
         return strtotime('+ 1 MONTH', $timestamp);
   }
   
   public static function getPreviousMonthTimestamp($timestamp)
   {  
         return strtotime('- 1 MONTH', $timestamp);
   }
   
   /**
   *  Build a month table for the current date month
   */
   
   public static function getFirstDayTable($timestamp)
   {
         $first_day = mktime(0,0,0,date('n', $timestamp), 1, date('y', $timestamp));
      
      if (date('N', $first_day) > 1)
      {
         return $first_day - (3600*24*(date('N',$first_day)-1));
      }
      else
      {
         return $first_day;
      }
   }
   
   public static function getLastDayTable($timestamp)
   {
      $last_day = mktime(0,0,0,date('n', $timestamp), date('t', $timestamp), date('y', $timestamp));
      
      if (date('N', $last_day) < 7)
      {
         return $last_day + (3600*24*(7-date('N',$last_day)));
      }
      else
      {
         return $last_day;
      }
   }
   
  public static function checkCompatibility($class)
  {
	$object = new $class;
	if (method_exists($object, 'getStartDate') && method_exists($object, 'getEndDate'))
	{
		return true;
	}
	return false;
  }  

  /*public static function checkiCalCompatibility($class)
  {
	$object = new $class;
	if (method_exists($object, 'getSummary') && method_exists($object, 'getDescription'))
	{
		return true;
	}
	return false;
  }*/

  public static function loadiCalLibraries()
  {

    $config = cms_utils::get_config();
    $class = $config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'MCFactory'  . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'bennu'  . DIRECTORY_SEPARATOR . 'lib'  . DIRECTORY_SEPARATOR . 'bennu.inc.php';
    // require_once dirname(__FILE__) . '/../bennu/lib/bennu.inc.php';
    require_once($class);
  }

}
