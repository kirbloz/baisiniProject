<?php
    @include('php/header.php');
    if(!checkActive())
        header('location:login.php?error=nosession') //session
?>	

    <div class="wrapper">
        <br>
        <div class='centered'>
            <a href="areaUtente.php?viewCustomer=true"></a>
        </div>
        <br>

        <div class="user-data wrapper centered color-lightb">
        </div>
        
    </div>
    
</body>
</html>