    <?php
        @include('php/header.php');
        if(!checkActive())
            header('location:login.php?error=nosession') //session
    ?>	

    <div class="wrapper">
        <br>
        <div style='color:red;' class='centered'>WORK IN PROGRESS</div>
        <br>

        <div class="user-data wrapper centered color-lightb">
        </div>
        
    </div>
    
</body>
</html>