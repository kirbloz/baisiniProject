    <?php
        include('php/header.php')
    ?>	

    <div class="wrapper">

        <br>
        <?php
        // if(!isset($_POST['username']) || !isset($_POST['pwd'])){
        //     die("Form non compilato");
        //     }
        echo "USERNAME: " . htmlentities($_POST['username'], ENT_HTML5, 'ISO-8859-1');
        echo "<div style='color:red;' class='centered'>WORK IN PROGRESS</div>"
        ?>

        <br><br>
        
        
    </div>
    
</body>
</html>