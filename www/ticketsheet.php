<?php
    $snum = $_GET['snum'];
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-2.2.4.js"></script>

        <link rel="stylesheet" 
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
            crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" 
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
            integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" 
            crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" 
            crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.8.0/dist/JsBarcode.all.min.js"></script>
        <script src="gradinfo.json"></script>
        <script src="js/gradutil.js"></script>
        <!-- factor out this code -->
        <script>
            gradlist = new gradutils(gradInfo);
        
            function findStudent(sn) {
                for(var ssn in gradInfo) {
                    if (sn in gradInfo[ssn]) {
                        return gradInfo[ssn][sn];
                    }
                }
                return null ;
            }
            var sinfo = findStudent(<?php echo($snum)?>);
            
            $(document).ready(function() {
                console.log("ready...");
                $('span.snum').html(sinfo[0]); 
                $('span.name').html(sinfo[1]+", "+sinfo[2]);
                var ssn_dtime = gradlist.sessionDateAndTime(sinfo[5]);
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                var dateS = ssn_dtime.date.toLocaleDateString("en-UK",options);
                $('span.session').html(dateS+", "+ssn_dtime.time);
                $('span.qual').html(sinfo[3]+": "+sinfo[4]);
                $('span.seat').html(sinfo[6]+" / "+sinfo[7]);
            });
        </script>
        
        <style>
            .ticket { border : solid black 1px; padding: 30px; }
            .name { font-size: 20pt;}
            .barcode { height: 100px;}
            .seat { font-size: 18pt ; font-weight: bold;} 
            .grad { font-size: 18pt; font-weight: bold;}
            .guest { font-size: 18pt; font-weight: bold;}
        </style>

    </head>
    <body>
        <div class="container">
<?php 
    foreach (['','_01','_02','_03','_04'] as $guest) { 
?>
    <div class='row ticket'>
        <div id='dut-logo' class="col-sm-4">
            <img height="60" src="http://www.dut.ac.za/wp-content/themes/stylish-v1.2.4-child/dut-logo.jpg"/>
            <div class='grad'>Graduation 2018</div>
        </div>

        <div class="col-sm-4">
            <span class='name'></span>
            <br><b>Graduation Session:</b>&nbsp;<span class='session'></span>
            <?php if($guest != "") {
                print "<div class='guest'>Guest$guest</div>" ;
            } else {
                print "<br><b>Qualification:</b>&nbsp;<span class='qual'></span>";
                print "<br><b>Row/Seat:</b>&nbsp;<span class='seat'></span>";
            } ?>
        </div>
        <div class="col-sm-4">
            <svg class='barcode' id="barcode<?php echo($guest) ?>"></svg>
        </div>
        <script>
            JsBarcode("#barcode"+"<?php echo($guest) ?>",sinfo[0]+"<?php echo($guest) ?>");
        </script>
    </div>
<?php } ?>
        </div>
    </body>
</html>