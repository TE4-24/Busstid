<html>

<head>
</head>

<body>
    <?php
    date_default_timezone_set("Europe/Stockholm");
    $xml = simplexml_load_file("dt/_stops.xml")->dataObjects->SiteFrame->stopPlaces or die("Error: Cannot create object");
    $Sharedxml = simplexml_load_file("dt/_shared_data.xml") or die("Error: can't create object");
    $DayTypeXml = $Sharedxml->dataObjects->CompositeFrame->frames->ServiceCalendarFrame->dayTypes->DayType;
    $VardagArray = [];

    foreach ($DayTypeXml as $DayTypes) {
        $DaysOfWeek = $DayTypes->properties->PropertyOfDay->DaysOfWeek;
        $DayTypeId = (string) $DayTypes['id'];
        if ($DaysOfWeek == "Monday Tuesday Wednesday Thursday Friday") {
            $VardagArray[] = $DayTypeId;
        }
    }

    foreach ($xml->StopPlace as $code) {
        // echo $code->Name . "<br>";
        if ($code->Name == 'Borlänge centrum') {
            $privcode1 = $code->PrivateCode;
        }
        if ($code->Name == 'Borlänge resecentrum') {
            $privcode2 = $code->PrivateCode;
            break;
        }
    }
    
    $Namespace = 'http://www.netex.org.uk/netex';
    $xmlArray = array(
        '_stops.xml',
        '_shared_data.xml',
        'line_20_1_9011020000100000.xml',
        'line_20_2_9011020000200000.xml', 
        'line_20_3_9011020000300000.xml',
        'line_20_4_9011020000400000.xml', 
        'line_20_101_9011020010100000.xml',
        'line_20_102_9011020010200000.xml',
        'line_20_121_9011020012100000.xml',
        'line_20_151_9011020015100000.xml', 
        'line_20_152_9011020015200000.xml', 
        'line_20_153_9011020015300000.xml', 
        'line_20_154_9011020015400000.xml',
        'line_20_213_9011020021300000.xml', 
        'line_20_214_9011020021400000.xml', 
        'line_20_215_9011020021500000.xml', 
        'line_20_223_9011020022300000.xml', 
        'line_20_253_9011020025300000.xml',
        'line_20_296_9011020029600000.xml',
        'line_20_298_9011020029800000.xml',
        'line_20_370_9011020037000000.xml'
    );
    $Riktning1 = array(
        'Studieplan/Skräddarbacken',
        'Bullermyren/Övre Tjärna',
        'Skräddarbacken',
        'Färjegårdarna',
        'Grängesberg',
        'Kvarnsveden',
        'Rämshyttan', 
        'Studieplan',
        'Ludvika'
    );
    $Riktning2 = array();
    // $ParentIDRiktning1 = [];
    // $ParentIDRiktning2 = [];
    // $Riktning1TidArray = [];
    // $Riktning2TidArray = [];
    // $UnixTimeArrayRiktning1 = [];
    // $UnixTimeArratRiktning2 = [];
    // $UpcomingTimesRiktning1 = [];
    // $upcomingTimesRiktning2 = [];
    // foreach ($xmlArray as $xmlList){
    //     $Linje = simplexml_load_file($xmlList) or die("error");
    //     $Linje -> registerXPathNamespace('netex', $Namespace);
    //     $routePointRefs = $Linje->xpath('//netex:RoutePointRef');
    //     $stopPoints = $Linje->xpath('//netex:StopPointInJourneyPatternRef');

    //     foreach ( $routePointRefs as $routePointRef) {
    //         $refValue = (string) $routePointRef['ref'];
    //         $RPFparentElement = $routePointRef->xpath("parent::*")[0];
    //         $RPFparentparent = $RPFparentElement->xpath("parent::*")[0];
    //         $RPFparentparentparent = $RPFparentparent->xpath("parent::*")[0];
    //         if (in_array($RPFparentparentparent->Name,$Riktning1)) {
    //             if (str_contains($refValue, $privcode1)) {
    //                 $RPFparentID = (string) $RPFparentElement['id'];
    //                 $RPFparentExplode = (explode(":", $RPFparentID));
    //                 $ParentIDRiktning1[] = $RPFparentExplode[3];
    //             }
    //         }
    //     }
        // foreach ($stopPoints as $StopPoint) {
        //     $StopRef = (string) $StopPoint['ref'];
        //     $StopPExplode = (explode("_",  $StopRef));
        //     if (in_array($StopPExplode[1], $ParentIDRiktning1)) {
        //         $StopParent = $StopPoint->xpath("parent::*")[0];
        //         $StopParentParent = $StopParent->xpath("parent::*")[0];
        //         $StopParentParentParent = $StopParentParent->xpath("parent::*")[0];
        //         $DayType = $StopParentParentParent->dayTypes->DayTypeRef;
        //         $DayTypeRef = (string) $DayType['ref'];
        //         $SPparentElement = $StopPoint->xpath("parent::*")[0];
        //         if (in_array($DayTypeRef, $VardagArray)) {
        //             $Riktning1TidArray[] = $SPparentElement->DepartureTime; 
        //         }
        //     }
        // }
    //     foreach ($Riktning1TidArray as $TidArray) {
    //     $TidString = (string) $TidArray;
    //     $UnixTimeArrayRiktning1[] = strtotime($TidString);
    //     }
    

    //     foreach ($UnixTimeArrayRiktning1 as $TimeArray) {
    //         if (date("U") <= $TimeArray){
    //         $UpcomingTimesRiktning1[] = $TimeArray;
    //         }
    //     }
    
    //     sort($UpcomingTimesRiktning1);
    //     echo "Linje " . date("H:i", $UpcomingTimesRiktning1[0]) . "<br>";
    //     array_splice($UpcomingTimesRiktning1, 0);
    // }
    foreach ($xmlArray as $xmlList){
        $Linje = simplexml_load_file($xmlList) or die("Error could not create object");
        $Linje -> registerXPathNamespace('netex', $Namespace);
        $RoutePointRef = $Linje->xpath('//netex:RoutePointRef');
        $StopPoints = $Linje->xpath('//netex:StopPointInJourneyPatternRef');

        foreach ($RoutePointRef as $RouteRef){
            $refValue = (string) $RouteRef['ref'];
            $RPFparentElement = $RouteRef->xpath("parent::*")[0];
            $RPFparentparent = $RPFparentElement->xpath("parent::*")[0];
            $RPFparentparentparent = $RPFparentparent->xpath("parent::*")[0];
            if (in_array($RPFparentparentparent->Name,$Riktning1)) {
                if (str_contains($refValue, $privcode1)) {
                    $RPFparentID = (string) $RPFparentElement['id'];
                    $RPFparentExplode1 = (explode(":", $RPFparentID));
                    $ParentIDRiktning1C[] = $RPFparentExplode1[3];
                }
                elseif (str_contains($refValue, $privcode2)){
                    $RPFparentID = (string) $RPFparentElement['id'];
                    $RPFparentExplode2 = (explode(":", $RPFparentID));
                    $ParentIDRiktning1RC[] = $RPFparentparentparent->Name .",".  $RPFparentExplode2[3];
                }
            }
        }
    }
foreach ($ParentIDRiktning1RC as $bussIDRC) {
        $BussExplode = explode(",", $bussIDRC);
        echo $BussExplode[0] . "<br>";
    }
    foreach ($StopPoints as $StopPoint) {
        $StopRef = (string) $StopPoint['ref'];
        $StopPExplode = (explode("_",  $StopRef));
        if (in_array($StopPExplode[1], $BussExplode)) {
            $StopParent = $StopPoint->xpath("parent::*")[0];
            $StopParentParent = $StopParent->xpath("parent::*")[0];
            $StopParentParentParent = $StopParentParent->xpath("parent::*")[0];
            $DayType = $StopParentParentParent->dayTypes->DayTypeRef;
            $DayTypeRef = (string) $DayType['ref'];
            $SPparentElement = $StopPoint->xpath("parent::*")[0];
            if (in_array($DayTypeRef, $VardagArray)) {
                $Riktning1TidArrayRC[] = $BussExplode[0] . "," . $SPparentElement->DepartureTime; 
            }
        }
    }

    
print_r($Riktning1TidArrayRC)
    ?>
</body>

</html>