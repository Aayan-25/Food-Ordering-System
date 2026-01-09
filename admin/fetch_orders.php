<?php
include("../connection/connect.php");
error_reporting(0);

$sql = "SELECT users.*, users_orders.* 
        FROM users 
        INNER JOIN users_orders ON users.u_id = users_orders.u_id";

$query = mysqli_query($db, $sql);

if (!mysqli_num_rows($query) > 0) {
    echo '<tr><td colspan="8" align="center">No Orders</td></tr>';
} else {
    while ($rows = mysqli_fetch_array($query)) {

        echo '<tr>
            <td>'.$rows['username'].'</td>
            <td>'.$rows['title'].'</td>
            <td>'.$rows['quantity'].'</td>
            <td>$'.$rows['price'].'</td>
            <td>'.$rows['address'].'</td>';

        $status = $rows['status'];

        if ($status == "" || $status == "NULL") {
            echo '<td><button class="btn btn-info">Dispatch</button></td>';
        } elseif ($status == "in process") {
            echo '<td><button class="btn btn-warning">On The Way!</button></td>';
        } elseif ($status == "closed") {
            echo '<td><button class="btn btn-primary">Delivered</button></td>';
        } elseif ($status == "rejected") {
            echo '<td><button class="btn btn-danger">Cancelled</button></td>';
        }

        echo '
            <td>'.$rows['date'].'</td>
            <td>
                <a href="delete_orders.php?order_del='.$rows['o_id'].'" 
                   onclick="return confirm(\'Are you sure?\');" 
                   class="btn btn-danger btn-xs">
                   <i class="fa fa-trash-o"></i>
                </a>

                <a href="view_order.php?user_upd='.$rows['o_id'].'" 
                   class="btn btn-info btn-sm m-l-5">
                   <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>';
    }
}
?>
