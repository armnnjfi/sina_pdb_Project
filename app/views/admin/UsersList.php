<h3> Dear <?php echo $_SESSION['Name'];?> </h3>
<h3>users list : </h3>
<br>


<table cellpadding="10">
    <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Role</th>
            <th>email</th>
            <th>Promote to Admin</th>
            <th>Admin to User</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data['user'] as $user) { ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><a href="http://localhost/sina%20project/mvc/project/admin/userPromote?userId=<?php echo $user['id'] ?>"><button>promote to admin</button></a></td>
            <?php if ($user['id'] != '5') { ?> 
            <td><a href="http://localhost/sina%20project/mvc/project/admin/adminToUser?userId=<?php echo $user['id'] ?>"><button>to user</button></a></td>
            <?php } ?>
            
        </tr>
        <?php } ?>
    </tbody>
</table>