<?php
// include database connection file
include_once ("config.php");

// Check if form is submitted for event update, then redirect to homepage after update
if (isset($_POST['update'])) {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_description = $_POST['event_description'];
    $organizer_id = $_POST['organizer_id'];

    // update event data
    $result = mysqli_query($mysqli, "UPDATE acara SET event_name='$event_name', event_date='$event_date', event_time='$event_time', event_description='$event_description', organizer_id='$organizer_id' WHERE event_id=$event_id");

    // Redirect to homepage to display updated event in list
    header("Location: index.php");
}
?>

<?php
// Display selected event data based on id
// Getting id from url
$event_id = $_GET['event_id'];

// Fetch event data based on id
$result = mysqli_query($mysqli, "SELECT * FROM acara WHERE event_id=$event_id");

while ($event_data = mysqli_fetch_array($result)) {
    $event_name = $event_data['event_name'];
    $event_date = $event_data['event_date'];
    $event_time = $event_data['event_time'];
    $event_description = $event_data['event_description'];
    $organizer_id = $event_data['organizer_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <a href="index.php">Home</a>
    <br /><br />

    <form name="update_event" method="post" action="edit_event.php">
        <table class="table">
            <tr>
                <td>Nama Acara</td>
                <td><input type="text" class="form-control" name="event_name" value="<?php echo $event_name; ?>"
                        required></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td><input type="date" class="form-control" name="event_date" value="<?php echo $event_date; ?>"
                        required></td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td><input type="time" class="form-control" name="event_time" value="<?php echo $event_time; ?>"
                        required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><textarea class="form-control" name="event_description"
                        required><?php echo $event_description; ?></textarea></td>
            </tr>
            <tr>
                <td>Organizer ID</td>
                <td><input type="text" class="form-control" name="organizer_id" value="<?php echo $organizer_id; ?>"
                        required></td>
            </tr>
            <tr>
                <td><input type="hidden" name="event_id" value="<?php echo $event_id; ?>"></td>
                <td><input type="submit" name="update" class="btn btn-primary" value="Update"></td>
            </tr>
        </table>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>