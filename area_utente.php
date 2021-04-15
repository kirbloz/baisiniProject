    <?php
        include('php/header.php')
    ?>	

    <div class="container">

        <br>
        <?php
        if(!isset($_POST['username']) || !isset($_POST['pwd'])){
            die("Form non compilato");
            }
        echo "USERNAME: " . htmlentities($_POST['username'], ENT_HTML5, 'ISO-8859-1');
        ?>

        <br><br>
        
        
    </div>
    
</body>
</html>