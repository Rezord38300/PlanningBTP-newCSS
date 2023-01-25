<?php
    // const display parameter:
    const PARAM_DAY_DISPLAY = 'day';
    const PARAM_WEEK_DISPLAY = 'week';
    const PARAM_MONTH_DISPLAY = 'month';

    const PARAM_VIEW_DISPLAY = 'view';
    const PARAM_MODIFY_DISPLAY = 'modify';

    // const onglet parameter:
    const PARAM_MISSION_ONGLET = 'missions';
    const PARAM_PERSONAL_ONGLET = 'personal';
    const PARAM_EMPLOYEE_ONGLET = 'employees';
    const PARAM_VEHICLES_ONGLET = 'vehicles';
    const PARAM_MATERIAL_ONGLET = 'material';
    
    const PARAM_SESSION_TYPE = [
        'administrateur' => 'administrator',
        'chef d\'équipe' => 'planningManager',
        'responsable véhicules' => 'vehicleManager',
        'responsable matériel' => 'materialManager',
        'resource humaine' => 'humanResources',
        'employé' => 'employee'
    ];

    const PARAM_SESSION_TYPE_ADMINISTRATOR = "administrator";
    const PARAM_SESSION_TYPE_TEAM_LEADER = "planningManager";
    const PARAM_SESSION_TYPE_VEHICLE_MANAGER = "vehicleManager";
    const PARAM_SESSION_TYPE_MATERIAL_MANAGER = "materialManager";
    const PARAM_SESSION_TYPE_HUMAN_MANAGER = "humanResources";
    const PARAM_SESSION_TYPE_EMPLOYEE = "employee";

    const TITLE_PAGE_INDEX = "Connexion";
    const TITLE_PAGE_HOME = "Accueil";
    const TITLE_PAGE_PROFIL = "Profil";
    const TITLE_PAGE_COST = "Frais";
    const TITLE_PAGE_PLANNING = "Planning";
    const TITLE_PAGE_SCHEDULE = "Horaires";
    const TITLE_PAGE_MATERIAL = "Matériel";
    const TITLE_PAGE_VEHICLE = "Véhicule";

    const LINK_LOGIN_PROCESS = "/private/treatment/indexProcess/logInProcess.php";
    const LINK_LOGOUT_PROCESS = "/private/treatment/indexProcess/logOutProcess.php";
    const LINK_TO_MODIFY_PROCESS = "/private/treatment/profileProcess/modifyProcess.php";

    const LINK_TO_HOME = "/public/home.php";
    const LINK_TO_PROFIL = "/public/profil.php?onglet=personal&display=view";
    const LINK_TO_PLANNING = "/public/planning.php?onglet=missions&display=week";
    const LINK_TO_SCHEDULES = "/public/schedule.php";
    const LINK_TO_EXPENDITURE = "/public/expenditure.php";
    const LINK_TO_TOOL_MANAGEMENT = "/public/toolManagement.php";
    const LINK_TO_VEHICLE_MANAGEMENT = "/public/vehicleManagement.php";
?>