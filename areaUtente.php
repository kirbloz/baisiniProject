    <?php
        require_once('php/header.php');
        echo 1;
        require_once('php/session.inc.php');  
        echo 2;   
        checkActive(true); //session
        echo 3;
    ?>	

    <div class="wrapper">
        <br>
        <div style='color:red;' class='centered'>WORK IN PROGRESS</div>
        <br>

        <div class="user-data wrapper centered color-lightb">
            <?php
                var_dump($_SESSION);
            ?>
        </div>
        
    </div>
    
</body>
</html>