<?php

require_once('php/getmenu.php');

?>
<html>
<head></head>
<body>
    <div>
    <table>
        <?php
            $menuArray = getMenuArray(__DIR__ . '/menu.xls');
            //print_r($menuArray); 
            
            foreach($menuArray as  $rowArr)
            {
                echo ('<tr>');
                foreach($rowArr as $elem)
                {
                    echo('<td>'.$elem . '</td>');
                }
                echo ('</tr>');

            }
            ?>
    </table>
    </div>
</body>
</html>
