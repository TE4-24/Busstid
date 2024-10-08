<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BussTabel</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
  <script src="https://kit.fontawesome.com/9002bb148d.js" crossorigin="anonymous"></script>

</head>
<body>
  
  <div class="view">

    <img class="banner" src="Bilder/Asset 1Iris_symbol.svg">
    
    <div class="flex-container">
  
      <div class="column-container">
  
        <div class="column">
        <?php
            for ($i = 1; $i <= 7; $i++) {
              ?>
            <div class="tabelRow">
              <div class="transport">
               <p class="number"> Buss </p> 
               <img src="gifs/bus.gif" width="50px" class="gifar">
              </div>
              <div class="time">
                <div> <div>XX:XX</div> </div>
                <div> <div>15 Min</div> </div>
              </div>
            </div>
            <?php
            }
        ?>
        
        </div>
  
        <div class="column">
        <?php
            for ($i = 1; $i <= 7; $i++) {
              ?>
            <div class="tabelRow">
              <div class="transport">
               <p class="number"> Train </p> 
               <img src="gifs/train.gif" width="50px" class="gifar">
              </div>
              <div class="time">
                <div><div>XX:XX</div></div>
                <div><div>15 Min</div></div>
              </div>
            </div>
            <?php
            }
        ?>
        
        </div>
  
      </div>
      
    </div>
  </div>

</body>
</html>