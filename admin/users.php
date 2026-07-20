<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/User.php";

$database = new Database();
$conn = $database->connect();

$user = new User($conn);

// Change Role
if (isset($_POST['change_role'])) {

    $user->updateRole($_POST['id'], $_POST['role']);

    header("Location: users.php");
    exit();
}

// Delete User
if (isset($_GET['delete'])) {

    if ($_GET['delete'] != $_SESSION['user_id']) {

        $user->deleteUser($_GET['delete']);
    }

    header("Location: users.php");
    exit();
}

$users = $user->getUsers();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>users Details | Lunora</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="recent-orderss">

<table>

<thead>

<tr>

<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Phone</th>
<th>Role</th>
<th>Joined</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = $users->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['fullname']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['phone']); ?></td>

<td>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<select name="role">

<option value="user"
<?php if($row['role']=="user") echo "selected"; ?>>

User

</option>

<option value="admin"
<?php if($row['role']=="admin") echo "selected"; ?>>

Admin

</option>

</select>

<button name="change_role">

Update

</button>

</form>

</td>

<td><?php echo $row['created_at']; ?></td>

<td>

<?php if($row['id'] != $_SESSION['user_id']){ ?>

<a href="?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this user?')">

<i class="fa-solid fa-trash"></i>

</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>
</html>