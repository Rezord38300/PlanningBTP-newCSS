<?php
    require_once dirname(__FILE__,2). "/class/Month.php";
    require_once dirname(__FILE__,2). "/class/Events.php";

    $event = new Events($PDO);
    $month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null , $_GET['week'] ?? null , $_GET['day'] ?? null);
    $weeks = $month->getWeeks();
    $firstDay = $month->getFirstDay();
    $firstDay = $firstDay->format('N') === '1' ? $firstDay : $month->getFirstDay()->modify('last Monday');
    
    $lastDay = $firstDay->modify('+' . (6 + 7 * ($weeks - 1)) . 'days');
    $events = $event->getEventBetweenByDay($firstDay , $lastDay , $_GET['onglet']);

    /**
     * Allow to setup the date 
     */
    $date;
    foreach($month->days as $dayNumber => $day){
        $date = $firstDay->modify("+".($dayNumber + $month->setupWeek($month->week)). "day");
    }
    
    $formatDate = 'Y-m-'.$month->formatDayNumber($month->day);
?>

<div class="tab" >
    <div class="tabHeader">
        <div class="leftSide">
                <div class="zoneAddEvent">
                    <input type="checkbox" name="buttonAddEvent" id="buttonAddEvent" class="buttonAddEvent">
                    <label for="buttonAddEvent" class="buttonLabel" id="buttonLabel"> <i id="iButtonLabel" class="icon-calendar-plus-alt"></i></label>
                    <label for="buttonAddEvent" class="indicator"> Ajouter une mission</label>
                    <?php include_once dirname(__FILE__). "/addEventView.php"?>
                </div>
            
                <div class="zoneModifyEvent">
                    <?php if(isset($_GET['event'])){
                        include_once dirname(__FILE__). "/modifyEvent.php";
                    } ?>
                </div>
        </div>

        <div class="middle">
            <h2> <?= $month->toStringDay(); ?> </h2>
        </div>

        <div class="rightSide">
                <div class="navigationPreviousNext">
                    <a href="<?= URLManagement::addUrlParam(array('month'=>$month->previousDay()->month ,'year'=>$month->previousDay()->year , 'week'=>$month->previousDay()->week , 'day'=>$month->previousDay()->day))?> "> <i class="icon-angle-left"></i> </a>
                    <a href="<?= URLManagement::addUrlParam(array('month'=>$month->nextDay()->month ,'year'=>$month->nextDay()->year , 'week'=>$month->nextDay()->week , 'day'=>$month->nextDay()->day))?> "> <i class="icon-angle-right"></i> </a>
                </div>
                <div class="navigationView">
                    <a href="<?= URLManagement::addUrlParam(array('month'=>date('m') ,'year'=>date('Y'), 'day'=>date('d')))?>">Aujourd’hui</a>
                    <a href="<?= URLManagement::addUrlParam(array('display'=>'day' , 'day'=>date('d'))) ?>" class="changeView"> Jour </a>
                    <a href="<?= URLManagement::addUrlParam(array('display'=>'week' , 'week'=>$month->getCurrentWeek())) ?>" class="changeView"> Semaine </a>
                    <a href="<?= URLManagement::addUrlParam(array('display'=>'month')) ?>" class="changeView"> Mois </a>
                </div>
        </div>
    </div>

    <table class="calendarTable">
        <tbody class="calendarBodyDayView">
            <tr>
                <th class="rowName"> Matin </th>
                <?php
                    $eventsForDay = $events[$date->format($formatDate)] ?? [];
                    foreach($eventsForDay as $event): 
                    if($event['eventStartTime'] >= '00:00:00' && $event['eventStartTime'] <= '12:59:59'):
                ?>
                    <td class="eventMorning">
                        <?php include dirname(__FILE__)."/calendarEvent.php"; ?>
                    </td>
                <?php 
                    endif;
                    endforeach 
                ?>
            </tr>
            <tr>
                <th class="rowName"> Après-midi </th>
                <?php
                    $eventsForDay = $events[$date->format($formatDate)] ?? [];
                    foreach($eventsForDay as $event): 
                    if($event['eventStartTime'] >= '13:00:00' && $event['eventStartTime'] <= '23:59:59'):
                ?>
                    <td class="eventAfternoon">
                        <?php include dirname(__FILE__)."/calendarEvent.php"; ?>
                    </td>
                <?php 
                    endif;
                    endforeach 
                ?>
            </tr>
        </tbody>
    </table>
</div>