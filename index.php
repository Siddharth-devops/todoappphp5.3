<?php
    $server_address = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'todo_db';

    $connection = mysql_connect($server_address, $username, $password);

    if(!$connection) {
        die("Error Occured" . mysql_error());
    }

    mysql_select_db($db_name, $connection);

    if (isset($_POST['add'])) {
        $title = mysql_real_escape_string($_POST['title']);
        $description = mysql_real_escape_string($_POST['description']);
      
        $sql = "INSERT INTO todo_items (title, description) VALUES ('$title', '$description')";
        if (!mysql_query($sql, $connection)) {
          die('Error adding todo item: ' . mysql_error());
        }
    }

    if (isset($_POST['update'])) {
        $id = mysql_real_escape_string($_POST['id']);
        $title = mysql_real_escape_string($_POST['title']);
        $description = mysql_real_escape_string($_POST['description']);
      
        $sql = "UPDATE todo_items SET title='$title', description='$description', updated_at=NOW() WHERE id=$id";
        if (!mysql_query($sql, $connection)) {
          die('Error updating todo item: ' . mysql_error());
        }
    }

    if (isset($_GET['delete'])) {
        $id = mysql_real_escape_string($_GET['delete']);
      
        $sql = "DELETE FROM todo_items WHERE id=$id";
        if (!mysql_query($sql, $connection)) {
          die('Error deleting todo item: ' . mysql_error());
        }
    }

    $sql = "SELECT * FROM todo_items";
    $result = mysql_query($sql, $connection);
    if (!$result) {
        die('Error retrieving todo items: ' . mysql_error());
    }

    echo '<table>';
    while ($row = mysql_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['description'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '<td>' . $row['updated_at'] . '</td>';
        echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
        echo '<td><a href="index.php?delete=' . $row['id'] . '">Delete</a></td>';
        echo '</tr>';
    }
    echo '</table>';

    mysql_close($connection);

?>