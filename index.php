<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ParkyPark</title>
    </head>
    <body>
        <h1>Parking tariff counter</h1>
            <p>Taxan på parkeringsplatsen är:
            ```Alla dagar 09:00 - 18:00: 5 kr / tim
            <br>
            Övrig tid: 0 kr / tim
            <br>
            Max pris per dygn: 25 kr
            <br>
            Första timmen (första timmen som inte är 0 kr / tim): 10 kr / tim (därefter 5 kr / tim
            enligt ovan)
            <br>
            ```
            <br>
            Tidpunkter skall kunna anges med flera dygns skillnad, t.ex. från igår 10:00 ->
            imorgon 22:00.
            <br>
            Exempel: Idag 10:00 -> Idag 12:00 skall bli en total kostnad på 15 kr. (Första timmen
            10 kr / tim + därefter 5 kr / tim).</p>
            <p>---------------------------------------------------------------------------------------</p>
                   
        <?php   
   
        date_default_timezone_set('Europe/Stockholm');
        //Här ställer du in vilken start- & sluttid du vill ha
        $starttid = 1565373600;
        $sluttid = 1565427600;
                   

        echo "</br>Starttid: " .date("Y-m-d H:i:s", $starttid); 
        echo "</br>Sluttid: " . date("Y-m-d H:i:s", $sluttid) . "</br>";
        echo ("</br>Antal timmar: " . ($sluttid - $starttid)/3600) . "</br>";  

        //Variabler
        $i = $starttid;
        $x = 0;
        $Fem = 0;
        $Tio = 0;
        $y = 0;
              
        //Array som håller parkeringsavgifterna per dag
        $datum = array();
        $datumIndex = 0;
 
        
        // Loopas igenom så länge $i är mindre än sluttid och fördelar ut perioden i de på de olika tidpunkterna.
        while ( $i < $sluttid ) {
            
            if(date('H:i', $i) >= '09:00' && date('H:i', $i) < '18:00' && $x < 3600 ) {                
                $x++; 
                $Tio++;
            }
            elseif(date('H:i', $i) >= '09:00' && date('H:i', $i) < '18:00' && ($x >= 3600 || $datumIndex > 0)) {                
                $x++;
                $Fem++;
            }
            elseif(date('H:i', $i) < '09:00' || date('H:i', $i) > '18:00') {                  
                
                // När klockan slår '00:00:00' kommer det senaste dygnets parkeringsavgift sättas i nuvarande index i arryen. 
                // Datumindexet ökar så att nästa plats i arrayen ska fyllas.
                // Efter att värdet är satt så nollställs räknarna och börjar räkna om på nästa dygn.
                if(date('H:i:s', $i) == '00:00:00'){ 
                    
                $Avgift = ((($Tio/3600)*10)+(($Fem/3600)*5));
                
                    if($Avgift > 25){
                        $Avgift = 25;
                    }

                $datum[$datumIndex] = $Avgift;
                $datumIndex++;
                $Tio = 0;
                $Fem = 0;                
                }               
                $y++;                
            }   
            $i++;          
        }
        //Sista dagen(alternativt första dagen) får värdet av vad räknarna står på när loopen har körts klart.
        $Avgift = ((($Tio/3600)*10)+(($Fem/3600)*5));
        
       if($Avgift > 25){
           $Avgift = 25;
       }
        $datum[$datumIndex] = $Avgift;
        //Dag variabel
        $d = 1;
        
        foreach($datum as $dag){
            echo "</br>Dag " .$d . " :  " . $dag . " kr";
            $d++;
        }
        echo '</br>';
        
        $Parkeringsavgift = (array_sum($datum));
        
        echo '</br>Den totala parkeringsavgiften är: ' . round($Parkeringsavgift, 2) . ' kr';
        
        ?>
               
    </body>
</html>
 