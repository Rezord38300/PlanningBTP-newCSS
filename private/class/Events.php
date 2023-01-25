<?php 

include_once dirname(__FILE__,2). "/dataBase/dataBaseConnection.php";

class Events{
   
    public $PDO;
    function __construct($pdo)
    {
        $this->PDO = $pdo;
    }

    /**
     * allow to get an event with his ID
     * 
     * @return assoc_array from data base
     */
        public function getEvent($eventId = null){
            if($eventId != null){
                $select = "select distinct *";
                $from = " from Event";
                $where = " where eventId = " . $eventId;

                $query = $select . $from . $where;
                $statement = $this->PDO->query($query);
                $getEvent = $statement->fetchAll();
                return $getEvent;
            }
        }


    /**
     * allow to get all worksite from de data base
     * 
     * @return assoc_array from data base
     */
        public function getWorksite($worksiteId = null){
            $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);

            if($worksiteId != null){
                $select = "select distinct *";
                $from = " from Worksite";
                $where = " where worksiteId = ". $worksiteId; 
                $query = $select . $from . $where;
                $statement = $this->PDO->query($query);
                $getSite = $statement->fetchAll();
                return $getSite;
            }
            else{
                $select = "select distinct *";
                $from = " from Worksite";
                $query = $select . $from;
                $statement = $this->PDO->query($query);
                $getSite = $statement->fetchAll();
                return $getSite;
            }
        }

    /**
     * allow to get all employees from de data base
     * 
     * @return assoc_array from data base
     */
    public function getEmployee($employeeId = null){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);

        if($employeeId != null){
            $select = "select distinct *";
            $from = " from User";
            $where = " where userId=". $employeeId;
            $query = $select . $from . $where;
            $statement = $this->PDO->query($query);
            $getEmployee = $statement->fetchAll();
            return $getEmployee;
        }
        else{
            $select = "select distinct *";
            $from = " from User";
            $where = " where userId not in (select userId from Affected)";
            $query = $select . $from . $where;
            $statement = $this->PDO->query($query);
            $getEmployee = $statement->fetchAll();
            return $getEmployee;
        }
    }

    /**
     * allow to get all Material from de data base
     * 
     * @return assoc_array from data base
     */
    public function getMaterial(){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);

        $select = "select distinct *";
        $from = " from Equipment";
        $where = " where equipmentName not in (select equipmentName from UsedEquipment)";
        $query = $select . $from . $where;
        $statement = $this->PDO->query($query);
        $getMaterial = $statement->fetchAll();
        return $getMaterial;
    }

    /**
     * allow to get all Vehicles from de data base
     * 
     * @return assoc_array from data base
     */
    public function getVehicles(){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);

        $select = "select distinct *";
        $from = " from Vehicle";
        $where = " where vehicleLicensePlate not in (select vehicleLicensePlate from GoTo)";
        $query = $select . $from . $where;
        $statement = $this->PDO->query($query);
        $getSite = $statement->fetchAll();
        return $getSite;
    }

    /**
     * allow to get an event in the data base
     * 
     * @return assoc_array from data base
     */
    public function getEventBetween(\DateTimeImmutable $eventStart , \DateTimeImmutable $eventEnd){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        /* Get the event from dataBase */
        $select = "select distinct *";
        $from = " from Event e join Worksite w on w.worksiteId = e.worksiteId";
        $where = " where eventStartDate";
        $between = " between '{$eventStart->format('Y-m-d 00:00:00')}' and '{$eventEnd->format('Y-m-d 23:59:59')}'";
        $orderBy = " order by e.eventStartTime asc";
        
        $query = $select . $from . $where . $between . $orderBy;

        $statement = $this->PDO->query($query);
        $getEvent = $statement->fetchAll();

        return $getEvent;
    }

    /**
     * allow to group event by day
     * 
     * @return day
     */
    public function getEventBetweenByDay(\DateTimeImmutable $eventStart , \DateTimeImmutable $eventEnd , ?string $page = null){
        $events = "";

        if($page == null){
            $events = $this->getEventForGivenPerson($eventStart , $eventEnd);
        }

        switch($page){
            case "missions":
                    $events = $this->getEventBetween($eventStart , $eventEnd);
                break;
            case "employees":
                    $events = $this->getEventWithEmployees($eventStart , $eventEnd);
                break;
            case "vehicles":
                    $events = $this->getEventWithVehicles($eventStart , $eventEnd);
                break;
            case "material":
                    $events = $this->getEventWithMaterial($eventStart , $eventEnd);
                break;
        }

        $days = [];
        foreach($events as $event){
            $date = explode(' ' , $event['eventStartDate'])[0];
            if(!isset($days[$date])){
                $days[$date] = [$event];
            }
            else{
                $days[$date][] = $event;
            }
        }
        return $days;
    }

    /**
     * allow to get event where employees is it 
     * 
     * @return assoc_array from data base
     */
    public function getEventWithEmployees(\DateTimeImmutable $eventStart , \DateTimeImmutable $eventEnd){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        $select = "select distinct *";
        $from = " from Event e join Affected a on e.eventId = a.eventId join Worksite w on e.worksiteId = w.worksiteId";
        $where = " where eventStartDate";
        $between = " between '{$eventStart->format('Y-m-d 00:00:00')}' and '{$eventEnd->format('Y-m-d 23:59:59')}'";
        $orderBy = " order by e.eventStartTime asc";
        
        $query = $select . $from . $where . $between . $orderBy;

        $statement = $this->PDO->query($query);
        $getEvent = $statement->fetchAll();

        return $getEvent;
    }

    /**
     * allow to get event where vehicles is used
     * 
     * @return assoc_array from data base
     */
    public function getEventWithVehicles(\DateTimeImmutable $eventStart , \DateTimeImmutable $eventEnd){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        $select = "select distinct *";
        $from = " from Event e join GoTo g on e.eventId = g.eventId join Worksite w on e.worksiteId = w.worksiteId";
        $where = " where eventStartDate";
        $between = " between '{$eventStart->format('Y-m-d 00:00:00')}' and '{$eventEnd->format('Y-m-d 23:59:59')}'";
        $orderBy = " order by e.eventStartTime asc";
        
        $query = $select . $from . $where . $between . $orderBy;

        $statement = $this->PDO->query($query);
        $getEvent = $statement->fetchAll();

        return $getEvent;
    }

    /**
     * allow to get event where material is used
     * 
     * @return assoc_array from data base
     */
    public function getEventWithMaterial(\DateTimeImmutable $eventStart , \DateTimeImmutable $eventEnd){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        $select = "select distinct *";
        $from = " from Event e join UsedEquipment u on e.eventId = u.eventId join Worksite w on e.worksiteId = w.worksiteId";
        $where = " where eventStartDate";
        $between = " between '{$eventStart->format('Y-m-d 00:00:00')}' and '{$eventEnd->format('Y-m-d 23:59:59')}'";
        $orderBy = " order by e.eventStartTime asc";
        
        $query = $select . $from . $where . $between . $orderBy;

        $statement = $this->PDO->query($query);
        $getEvent = $statement->fetchAll();

        return $getEvent;
    }

    /**
     * allow to get event for person connected 
     * 
     * @return assoc_array from data base
     */
    public function getEventForGivenPerson(\DateTimeImmutable $eventStart , \DateTimeImmutable $eventEnd){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        $select = "select distinct *";
        $from = " from Affected a join Event e on a.eventId = e.eventId join Worksite w on e.worksiteId = w.worksiteId";
        $where = " where eventStartDate";
        $between = " between '{$eventStart->format('Y-m-d 00:00:00')}' and '{$eventEnd->format('Y-m-d 23:59:59')}' and a.userId =".$_SESSION['userId'];
        $orderBy = " order by e.eventStartTime asc";
        
        $query = $select . $from . $where . $between . $orderBy;

        $statement = $this->PDO->query($query);
        $getEvent = $statement->fetchAll();

        return $getEvent;
    }

    /**
     * allow to get the information about selected event
     * 
     * @return assoc_array from data base
     */
    public function getDetailSelectedEvent($eventId){
        $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
        $select = "select e.eventId, a.userId, e.worksiteId, GROUP_CONCAT(distinct(u.equipmentName)) equipment, GROUP_CONCAT(distinct(g.vehicleLicensePlate)) vehicle";
        $from = " from Event e join Affected a on e.eventId = a.eventId left outer join UsedEquipment u on e.eventId = u.eventId left outer join GoTo g on e.eventId = g.eventId";
        $where = " where e.eventId =". $eventId;
        $groupBy = " group by e.eventId, a.userId, e.worksiteId";

        $query = $select . $from . $where . $groupBy;

        $statement = $this->PDO->query($query);
        $getEvent = $statement->fetchAll();

        return $getEvent;
    }


    /**
     * create a new event
     * 
     */

     public function createEvent(Events $event){
        $query = "";
     }
}

?>