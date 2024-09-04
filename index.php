<html>
    <head>
    </head>
    <body>
    <?php
        $xml=simplexml_load_file("dt/_stops.xml")->dataObjects->SiteFrame->stopPlaces or die("Error: Cannot create object");
        
        foreach ($xml->StopPlace as $code) {
            if (stripos($code->Name, 'Borlänge Centrum') !== false) {
                echo $code->Name . "<br>";
                echo $code->PrivateCode . "<br>";
            }
            elseif (stripos($code->Name, 'Borlänge Resecentrum') !== false) {
                echo $code->Name . "<br>";
                echo $code->PrivateCode . "<br>";
                break;
            }
        }
    ?> 

    </body>
    </html>