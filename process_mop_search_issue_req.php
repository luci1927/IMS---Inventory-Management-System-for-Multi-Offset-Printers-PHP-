<?php require "connection.php";

if (isset($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
    $endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

   // echo "<script>console.log('Yesterday: " . $startDate . "');</script>";
    //echo "<script>console.log('Today: " . $endDate . "');</script>";

    $query = "SELECT ref_no, `description` AS descr,time_requested,time_approved, 
    request_user.`name` AS user_name,request_status.`name` AS `status` 
    FROM request INNER JOIN request_status ON
    request.request_status_id = request_status.id INNER JOIN request_user ON 
    request.request_user_email = request_user.email 
    WHERE DATE(request.time_requested)  BETWEEN '$startDate' AND '$endDate' 
    ORDER BY time_requested DESC;";



    $item_table_rs = Database::search($query);
    $item_table_num = $item_table_rs->num_rows;

    if ($item_table_num > 0) {
        for ($x = 0; $x < $item_table_num; $x++) {
            $item_table_data = $item_table_rs->fetch_assoc();
            echo "<tr>
                    <td>" . ($x + 1) . "</td>
                    <td>{$item_table_data['ref_no']}</td>
                    <td>" . nl2br(htmlspecialchars($item_table_data['descr'])) . "</td>
                    <td>{$item_table_data['time_requested']}</td>
                    <td>{$item_table_data['time_approved']}</td>
                    <td>{$item_table_data['user_name']}</td>
                    <td>{$item_table_data['status']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data available for the selected date.</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>Please select a valid date.</td></tr>";
}
