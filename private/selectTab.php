<?php
if($_SERVER['SCRIPT_NAME'] === '/public/profil.php'):
?>
<nav class="navTab">
    <ul>
        <li class="buttonTabs <?= URLManagement::activeTab(PARAM_PERSONAL_ONGLET) ?>">
            <a href=" <?= URLManagement::addUrlParam(array('onglet' => PARAM_PERSONAL_ONGLET)) ?>">
                <i class="icon-user"></i> Personnel
            </a>
        </li>

        <li class="buttonTabs <?= URLManagement::activeTab(PARAM_EMPLOYEE_ONGLET) ?>">
            <a href=" <?= URLManagement::addUrlParam(array('onglet' => PARAM_EMPLOYEE_ONGLET))?>">
               <i class="icon-users-group"></i> Employés
            </a>
        </li>
    </ul>
</nav>

<?php 
    endif;

    if($_SERVER['SCRIPT_NAME'] === '/public/planning.php'):
?>

<nav class="navTab">
    <ul>
        <li class="buttonTabs <?= URLManagement::activeTab(PARAM_MISSION_ONGLET) ?>"> 
            <a href=" <?= URLManagement::addUrlParam(array('onglet'=> PARAM_MISSION_ONGLET)) ?>">
                <i class="icon-clipboard-list"></i> Missions 
            </a>
        </li>
        
        <li class="buttonTabs <?= URLManagement::activeTab(PARAM_EMPLOYEE_ONGLET) ?>"> 
            <a href=" <?= URLManagement::addUrlParam(array('onglet'=> PARAM_EMPLOYEE_ONGLET)) ?>">
                <i class="icon-users-group"></i> Employés 
            </a>
        </li>

        <li class="buttonTabs <?= URLManagement::activeTab(PARAM_VEHICLES_ONGLET) ?>"> 
            <a href=" <?= URLManagement::addUrlParam(array('onglet'=> PARAM_VEHICLES_ONGLET)) ?>">
                <i class="icon-warehouse"></i> Véhicules 
            </a>
        </li>
        
        <li class="buttonTabs <?= URLManagement::activeTab(PARAM_MATERIAL_ONGLET) ?>"> 
            <a href=" <?= URLManagement::addUrlParam(array('onglet'=> PARAM_MATERIAL_ONGLET)) ?>">
                <i class="icon-tool"></i> Matériel 
            </a>
        </li>
    </ul>
</nav>

<?php endif; ?>