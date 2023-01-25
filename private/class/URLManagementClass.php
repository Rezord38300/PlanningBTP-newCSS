<?php
/**
 * Allow to manage the url of the web site 
 * @author Nikola Chevalliot
 */
class URLManagement{

    /**
     * Get the URL and add some parameter
     * @param $params it's an array ( name of variable => value)
     * 
     * @return string
     */
    public static function addUrlParam($params=array()): string{
        $p = array_merge($_GET, $params);
        $qs = http_build_query($p);
        return basename($_SERVER['PHP_SELF']).'?'.$qs;
    }

    /** 
     * function that add the active class to the buttons
     * @author Nikola Chevalliot
     * @param $tab the url param
     *
     * @return string
     */
    public static function activeTab($tab){
        if($_GET['onglet'] == $tab){
            return "activeTab";
        }
    }

    // /** 
    //  * Function to switch between day week month view on the calendar 
    //  * @author Nikola Chevalliot
    //  * 
    //  * @return string
    // */
    // public static function displayType(){
    //     switch($_GET['display']){
    //         case "day":
    //                 return URLManagement::addUrlParam(array('display'=>'week' , 'week'=>'2'));
    //             break;
    //         case "week":
    //                 return URLManagement::addUrlParam(array('display'=>'month'));
    //             break;
    //         case "month":
    //                 return URLManagement::addUrlParam(array('display'=>'day' , 'day'=>date('d')));
    //             break;
    //     }
    // }
}

?>