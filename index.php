<html>

<head>
</head>

<body>
    <?php
    date_default_timezone_set("Europe/Stockholm");
    $xml = simplexml_load_file("dt/_stops.xml")->dataObjects->SiteFrame->stopPlaces or die("Error: Cannot create object");
    
    foreach ($xml->StopPlace as $code) {
        if (stripos($code->Name, 'Borlänge Centrum') !== false) {
            $privcode1 = $code->PrivateCode;
        } elseif (stripos($code->Name, 'Borlänge Resecentrum') !== false) {
            $privcode2 = $code->PrivateCode;
        }
    }

    $Linje1 = simplexml_load_file("dt/line_20_1_9011020000100000.xml") or die("Error: Cannot create object");
    $Namespace = 'http://www.netex.org.uk/netex';
    $Linje1->registerXPathNamespace('netex', $Namespace);
    $RouteName1 = $Linje1->xpath('//netex:Name');
    $routePointRefs1 = $Linje1->xpath('//netex:RoutePointRef');
    $StopPoints1 = $Linje1->xpath('//netex:StopPointInJourneyPatternRef');
    $RouteNameArray = [];
    $ParentID1 = [];
    $Parent1ID1 = [];
    $DalaAirport1TidArray = [];
    $Bullermyren1TidArray = [];
    $UnixTimeArrayDalaAirport = [];
    $UnixTimeArrayBullermyren = [];
    $UpcomingTimesDalaAirport = [];
    $UpcomingTimesBullermyren = [];
    $Linje1Vardag = "gjj48i5tn94ltd92p95tvc2se2inbb0u";
    foreach ($routePointRefs1 as $routePointRef) {
        $refValue = (string) $routePointRef['ref'];
        $RPFparentElement1 = $routePointRef->xpath("parent::*")[0];
        $RPFparentparent1 = $RPFparentElement1->xpath("parent::*")[0];
        $RPFparentparentparent1 = $RPFparentparent1->xpath("parent::*")[0];
        if ($RPFparentparentparent1->Name == "Dala Airport") {
            if (str_contains($refValue, $privcode1)){
                $RPFparentId1 = (string) $RPFparentElement1['id'];
                $RPFparentExplode1 = (explode(":", $RPFparentId1));
                $ParentID1[] = $RPFparentExplode1[3];
            }
        }
    }
      
    foreach ($routePointRefs1 as $routePointRef) {
        $refValue = (string) $routePointRef['ref'];
        $RPFparentElement1 = $routePointRef->xpath("parent::*")[0];
        $RPFparentparent1 = $RPFparentElement1->xpath("parent::*")[0];
        $RPFparentparentparent1 = $RPFparentparent1->xpath("parent::*")[0];
        if ($RPFparentparentparent1->Name == "Bullermyren/Övre Tjärna") {
            if (str_contains($refValue, $privcode1)){
                $RPFparent1Id1 = (string) $RPFparentElement1['id'];
                $RPFparent1Explode1 = (explode(":", $RPFparent1Id1));
                $Parent1ID1[] = $RPFparent1Explode1[3]; 
            }
        }
    }
    foreach ($StopPoints1 as $StopPoint1) {
        $StopRef = (string) $StopPoint1['ref'];
        $StopPExplode1 = (explode("_",  $StopRef));
        if (in_array($StopPExplode1[1], $ParentID1)) {
            $StopParent1 = $StopPoint1->xpath("parent::*")[0];
            $StopParentParent1 = $StopParent1->xpath("parent::*")[0];
            $StopParentParentParent1 = $StopParentParent1->xpath("parent::*")[0];
            $DayType = $StopParentParentParent1->dayTypes->DayTypeRef;            
            $DayTypeRef = (string) $DayType['ref'];
            if (str_contains($DayTypeRef, $Linje1Vardag)){
                $SPparentElement1 = $StopPoint1->xpath("parent::*")[0];
                $DalaAirport1TidArray[] = $SPparentElement1->DepartureTime; 
            }
                
        }
    } 
   
    foreach ($StopPoints1 as $StopPoint1) {
        $StopRef = (string) $StopPoint1['ref'];
        $StopP1Explode1 = (explode("_",  $StopRef));
        if (in_array($StopP1Explode1[1], $Parent1ID1)) {
            $Stop1Parent1 = $StopPoint1->xpath("parent::*")[0];
            $Stop1ParentParent1 = $Stop1Parent1->xpath("parent::*")[0];
            $Stop1ParentParentParent1 = $Stop1ParentParent1->xpath("parent::*")[0];
            $DayType1 = $Stop1ParentParentParent1->dayTypes->DayTypeRef;            
            $DayTypeRef = (string) $DayType1['ref'];
            if (str_contains($DayTypeRef, $Linje1Vardag)){
                $SP1parentElement1 = $StopPoint1->xpath("parent::*")[0];
                $Bullermyren1TidArray[] = $SP1parentElement1->DepartureTime;
            }
                
        }
    }   
    
    foreach ($DalaAirport1TidArray as $TidArray){
        $TidString = (string) $TidArray;
        $UnixTimeArrayDalaAirport[] = strtotime($TidString);
    }
    
    foreach ($Bullermyren1TidArray as $TidArray2){
        $TidString2 = (string) $TidArray2;
        $UnixTimeArrayBullermyren[] = strtotime($TidString2);
    }
    foreach ($UnixTimeArrayDalaAirport as $TimeArray){
        if (date("U") <= $TimeArray)
            $UpcomingTimesDalaAirport[] = $TimeArray;
    }
    foreach ($UnixTimeArrayBullermyren as $TimeArray){
        if (date("U") <= $TimeArray)
        $UpcomingTimesBullermyren[] = $TimeArray;
    }

    sort($UpcomingTimesDalaAirport);
    sort($UpcomingTimesBullermyren);
    echo "linje 1 mot dala airport:" . "<br>";
    echo date("H:i", $UpcomingTimesDalaAirport[0]) . "<br>";
    echo "Linje 1 mot Bullermyren/övre tjärna" . "<br>";
    echo date("H:i", $UpcomingTimesBullermyren[0]) . "<br>";
?>

</body>

</html>
