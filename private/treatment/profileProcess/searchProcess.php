<?php
/**
 * search word in all tables that we give in param
 * 
 * @RETURN string
 */
    function querySearch(array $tables , array $searchWord):string{
        $nbTable = 0;
        $query = $orderby = "";
        
        if(isset($searchWord)){
            foreach($tables as $table => $data){
                // add Union before each additional table to search
                if($nbTable != 0){
                    $query.= " UNION ";
                }
    
                // for each word , we search ...
                $nbWord = 0; // number of word that we do search
                $searchQuery = "(";
                    foreach($searchWord as $word){
                        $nbColumn = 0;
                            foreach($data["column"] as $column){
                                if($nbColumn != 0){
                                    $searchQuery.= " OR ";
                                }
                                $searchQuery.= $column." LIKE '%".$word."%'"; // search in each column
    
                                // order of results by table
                                if(!empty($data['orderby'])){
                                    $orderby = " ORDER BY ".$data['orderby']. " ".$data['order'];
                                }
                                $nbColumn++;
                            }
                        $nbWord++;
                        if(count($searchWord) != $nbWord){
                            $searchQuery.= " AND ";
                        }
                    }
                $searchQuery.= ")";
                $query.= "SELECT * FROM " . $table . " WHERE " . $searchQuery . $orderby; // search in each table
                $nbTable++;
            }
        }
        else{
            foreach($tables as $table => $data){
                // add Union before each additional table to search
                if($nbTable != 0){
                    $query.= " UNION ";
                }
                $query.= "SELECT * FROM " . $table; // search in each table
                $nbTable++;
            }
        }
        return $query;
    }

?>