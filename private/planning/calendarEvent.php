<div class="calendarEvent">
    <a href="<?= URLManagement::addUrlParam(array('event'=>$event['eventId']))?>" class="buttonEvent"> détails </a>
    <p class="descriptionEvent"> <span class="eventLabel"> </span> <span class="eventInfo"> <?= $event['eventDescription'] ?> </span> </p>
    <p class="worksiteNameEvent"> <span class="eventLabel"> </span> <span class="eventInfo"> <?= $event['worksiteName'] ?> </span> </p>
    <p class="worksiteEvent"> <span class="eventLabel"> </span> <span class="eventInfo"> <?= $event['worksiteAddress'] ?> </span> </p>
    <p class="eventTime"> 
        <span class="eventLabel"> </span> 
        <span class="eventInfo">
            <?= (new DateTime($event['eventStartTime']))->format('H:m') ?> 
            - <?= (new DateTime($event['eventEndTime']))->format('H:m') ?>
        </span>
    </p>
</div>