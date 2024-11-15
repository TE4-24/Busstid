
<?php 
    set_time_limit(0);
    $curl = curl_init();
    $file = fopen("dt\dt.zip", "w");
    curl_setopt($curl, CURLOPT_URL, "https://opendata.samtrafiken.se/netex/dt/dt.zip?key=d3bfb8efff904e97a2c71d7231363343");
    curl_setopt($curl, CURLOPT_ENCODING, "gzip");
    curl_setopt($curl, CURLOPT_FILE, $file);
    curl_exec($curl);
    curl_close($curl);
?>

<?php 
    
?>

<?php 
    $zip = new ZipArchive;
    if ($zip->open('dt\dt.zip') === TRUE) {
        $zip->extractTo('dt');
        $zip->close();
        echo 'Unzipped Process Successful!'; 
    } else { 
        echo 'Unzipped Process failed'; 
    }
?>

<?php 
    $leaveFiles = array(
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
        
        
        

    foreach ( glob("dt/*") as $file){
        if ( !in_array(basename($file), $leaveFiles)) {
            unlink($file);
        }
    }
?>

