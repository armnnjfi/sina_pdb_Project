<nav  style="background-color:rgba(217, 217, 217, 0.9); color: white; height: 70px;"  >
    <ul style="height:100%; display: flex; align-items: center; gap: 30px;">
        <li style="color: #000"><a style="text-decoration: none; color: #000 " href="http://localhost/sina%20project/mvc/project/home">home</a></li>
        <?php if (!$this->check_auth()) { ?>
        <li style="color: #000"><a style="text-decoration: none; color: #000 " href="http://localhost/sina%20project/mvc/project/register">register</a></li>
        <?php } ?>
        
        <?php if ($this->check_auth()) { ?>
        <form style="margin-bottom:0px;" action="http://localhost/sina%20project/mvc/project/logout" method="post">
            <button type="submit">Logout</button>
        </form>
        <?php } else { ?>
        <form style="margin-bottom:0px;" action="http://localhost/sina%20project/mvc/project/login" method="post">
            <button type="submit">Login</button>
        </form>
        <?php } ?>
    </ul>
</nav>