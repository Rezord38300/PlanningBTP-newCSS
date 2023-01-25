<?php 
    require_once dirname(__FILE__,2). "/class/Events.php";
    $eventDetails = $event->getDetailSelectedEvent($_GET['event']);
    $selectedEvent = $event->getEvent($eventDetails[0]['eventId']);
?>


<div class="detailEvent">
        <span>
            <label for="eventDescription"> Description :</label>
            <input type="text" name="eventDescription" id="eventDescription" value="<?= $selectedEvent[0]['eventDescription'] ?>">
        </span>

        <span>
            <label for="eventStartDate"> Date de début :</label>
            <input type="date" name="eventStartDate" id="eventStartDate" value="<?= $selectedEvent[0]['eventStartDate'] ?>">
        </span>

        <span>
            <label for="eventEndDate"> Date de fin :</label>
            <input type="date" name="eventEndDate" id="eventEndDate" value="<?= $selectedEvent[0]['eventEndDate'] ?>">
        </span>

        <span>
            <label for="eventStartTime"> Heure de début :</label>
            <input type="time" name="eventStartTime" id="eventStartTime" value="<?= $selectedEvent[0]['eventStartTime'] ?>">
        </span>

        <span>
            <label for="eventEndTime"> Heure de fin :</label>
            <input type="time" name="eventEndTime" id="eventEndTime" value="<?= $selectedEvent[0]['eventEndTime'] ?>">
        </span>

        <ul>
            <li>
                <input type="checkbox" checked>
                <i></i>
                <h2>Lieux de la mission </h2>
                <span>
                    <!-- WORKSITES -->
                    <div class="scrollTableContainer">
                        <table class="listContant">
                            <thead>
                                <tr>
                                    <th scope="col"> Nom du lieux </th>
                                    <th scope="col"> Adresse </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $workSite = $event->getWorksite($eventDetails[0]['worksiteId']); ?>
                                <tr class="employeeObject">
                                    <td> <?= InputSecurity::displayWithFormat($workSite[0]['worksiteName'], "LastName") ?> </td>
                                    <td> <?= InputSecurity::displayWithFormat($workSite[0]['worksiteAddress']) ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </span>
            </li>
            <li>
                <input type="checkbox" checked>
                <i></i>
                <h2>Employés de la mission</h2>
                <span>
                    <!-- EMPLOYEES -->
                    <div class="scrollTableContainer">
                        <table class="listContant">
                            <thead>
                                <tr>
                                    <th scope="col"> Image</th>
                                    <th scope="col"> Nom </th>
                                    <th scope="col"> Prénom </th>
                                    <th scope="col"> Poste </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($eventDetails as $eventDetail): $employee = $event->getEmployee($eventDetail['userId']);?>
                                    <tr class="employeeObject">
                                        <td scope="row"> <img src="<?= $employee->userPicture ?>" alt="image de l'employé"> </td>
                                        <td> <?= InputSecurity::displayWithFormat($employee[0]['userLastName'] , "LastName") ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($employee[0]['userFirstName'] , "FirstName") ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($employee[0]['userPosition'] , "Position") ?> </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </span>
            </li>
            <li>
                <input type="checkbox" checked>
                <i></i>
                <h2>Véhicules de la mission</h2>
                <span>
                    <!-- VEHICLES -->
                    <div class="scrollTableContainer">
                        <table class="listContant">
                            <thead>
                                <tr>
                                    <th scope="col"> Plaque d’immatriculation </th>
                                    <th scope="col"> Model </th>
                                    <th scope="col"> Nombre de place </th>
                                    <th scope="col"> Permis nécessaire </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($eventDetails as $eventDetail): $vehicle = $event->getVehicles($eventDetail['vehicle']);?>
                                    <tr class="employeeObject">
                                        <td> <?= InputSecurity::displayWithFormat($vehicle[0]['vehicleLicensePlate'], "LastName") ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($vehicle[0]['vehicleModel']) ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($vehicle[0]['vehicleMaxPassenger']) ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($vehicle[0]['vehicleDriverLicense'], "LastName") ?> </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </span>
            </li>
            <li>
                <input type="checkbox" checked>
                <i></i>
                <h2>Matériel de la mission</h2>
                <span>
                    <!-- MATERIAL -->
                    <div class="scrollTableContainer">
                        <table class="listContant">
                            <thead>
                                <tr>
                                    <th scope="col"> Nom de l’équipement </th>
                                    <th scope="col"> Nombre total </th>
                                    <th scope="col"> Nombre disponible </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($eventDetails as $eventDetail): $material = $event->getMaterial($eventDetail['equipment'])?>
                                    <tr class="employeeObject">
                                        <td> <?= InputSecurity::displayWithFormat($material[0]['equipmentName'], "LastName") ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($material[0]['equipmentTotalQuantity']) ?> </td>
                                        <td> <?= InputSecurity::displayWithFormat($material[0]['equipmentAvailableQuantity']) ?> </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </span>
            </li>
        </ul>
</div>