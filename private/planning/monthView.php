<?php
    require_once dirname(__FILE__,2). "/class/Month.php";
    require_once dirname(__FILE__,2). "/class/Events.php";

    $event = new Events($PDO);
    $month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null , $_GET['week'] ?? null , $_GET['day'] ?? null);
    $weeks = $month->getWeeks();
    $firstDay = $month->getFirstDay();
    $firstDay = $firstDay->format('N') === '1' ? $firstDay : $month->getFirstDay()->modify('last Monday');

    $lastDay = $firstDay->modify('+' . (6 + 7 * ($weeks - 1)) . 'days');
    if($_SESSION['userFonction']){

    }

    switch($_SESSION['userFonction']){
        case PARAM_SESSION_TYPE_ADMINISTRATOR:
                $events = $event->getEventBetweenByDay($firstDay , $lastDay , InputSecurity::validateWithoutNumber($_GET['onglet']));
            break;
        case PARAM_SESSION_TYPE_EMPLOYEE:
                $events = $event->getEventBetweenByDay($firstDay , $lastDay , null);
            break;
        case PARAM_SESSION_TYPE_TEAM_LEADER:
            break;
    }
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
            <h2> <?= $month->toStringMonth(); ?> </h2>
        </div>

        <div class="rightSide">
                <div class="navigationPreviousNext">
                    <a href="<?= URLManagement::addUrlParam(array('month'=>$month->previousMonth()->month ,'year'=>$month->previousMonth()->year)) ?> "> <i class="icon-angle-left"></i> </a>
                    <a href="<?= URLManagement::addUrlParam(array('month'=>$month->nextMonth()->month ,'year'=>$month->nextMonth()->year)) ?> "> <i class="icon-angle-right"></i> </a>
                </div>
                <div class="navigationView">
                    <a href="<?= URLManagement::addUrlParam(array('month'=>date('m') ,'year'=>date('Y'))) ?>">Aujourd’hui</a>
                    <a href="<?= URLManagement::addUrlParam(array('display'=>'day' , 'day'=>date('d'))) ?>" class="changeView"> Jour </a>
                    <a href="<?= URLManagement::addUrlParam(array('display'=>'week' , 'week'=>$month->getCurrentWeek())) ?>" class="changeView"> Semaine </a>
                    <a href="<?= URLManagement::addUrlParam(array('display'=>'month')) ?>" class="changeView"> Mois </a>
                </div>
        </div>
    </div>

    <table class="calendarTable calendarTable<?php echo $weeks?>weeks">
        <thead>
            <tr>
                <?php foreach($month->days as $dayNumber => $day):?>
                    <th> <?= $day ?> </th>
                <?php endforeach?>
            </tr>
        </thead>

        <tbody>
            <?php for($i = 0 ; $i < $weeks; $i++): ?>
                <tr>
                    <?php foreach($month->days as $dayNumber => $day): 
                            $date = $firstDay->modify("+".($dayNumber + $i*7). "days");
                            $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                    ?>
                        <td class="<?= $month->withinMonth($date) ?'' : 'calendarOtherMonth' ?>">
                            <?php if($date->format('Y-m-d') === date('Y-m-d')): ?>
                                <p class="calendarDayNumber colorCurrentDay"> <?= $date->format('d'); ?> </p>
                            <?php 
                                else : ?>
                                <p class="calendarDayNumber"> <?= $date->format('d'); ?> </p>
                            <?php 
                                endif 
                            ?>
                            <div class="eventContainer">
                                <?php 
                                    foreach($eventsForDay as $event){
                                        include dirname(__FILE__)."/calendarEvent.php";
                                    }
                                ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>