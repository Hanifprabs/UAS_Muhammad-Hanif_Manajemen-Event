<?php
/**
 * using mysqli_connect for database connection
 */

$databaseHost = 'localhost';
$databaseName = 'manajemen_event';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
if (!$mysqli) {
    die("Tidak bisa terkoneksi ke database");
}

$event_name = "";
$event_date = "";
$event_time = "";
$event_description = "";
$organizer_id = "";
$sukses = "";
$error = "";

if (isset($_GET["op"])) {
    $op = $_GET["op"];
} else {
    $op = "";
}

if ($op == 'delete') {
    $event_id = $_GET['event_id'];
    $sql1 = "DELETE FROM acara WHERE event_id = '$event_id'";
    $q1 = mysqli_query($mysqli, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $event_id = $_GET['event_id'];
    $sql1 = "SELECT * FROM acara WHERE event_id = '$event_id'";
    $q1 = mysqli_query($mysqli, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $event_name = $r1['event_name'];
    $event_date = $r1['event_date'];
    $event_time = $r1['event_time'];
    $event_description = $r1['event_description'];
    $organizer_id = $r1['organizer_id'];

    if ($event_name == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST["simpan"])) {
    $event_name = $_POST["event_name"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $event_description = $_POST["event_description"];
    $organizer_id = $_POST["organizer_id"];

    if ($event_name && $event_date && $event_time && $event_description && $organizer_id) {
        if ($op == 'edit') {
            $sql1 = "UPDATE acara SET event_name = '$event_name', event_date = '$event_date', event_time = '$event_time', event_description = '$event_description', organizer_id = '$organizer_id' WHERE event_id = '$event_id'";
            $q1 = mysqli_query($mysqli, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1 = "INSERT INTO acara (event_name, event_date, event_time, event_description, organizer_id) VALUES ('$event_name', '$event_date', '$event_time', '$event_description', '$organizer_id')";
            $q1 = mysqli_query($mysqli, $sql1);
            if ($q1) {
                $sukses = "Berhasil Memasukkan Data Baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Acara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!--untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert" id="errorAlert">
                        <?php echo $error ?>
                    </div>
                <?php endif; ?>
                <?php if ($sukses): ?>
                    <div class="alert alert-success" role="alert" id="successAlert">
                        <?php echo $sukses ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="event_name" class="col-sm-2 col-form-label">Nama Acara</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="event_name" name="event_name"
                                value="<?php echo $event_name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="event_date" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="event_date" name="event_date"
                                value="<?php echo $event_date ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="event_time" class="col-sm-2 col-form-label">Waktu</label>
                        <div class="col-sm-10">
                            <input type="time" class="form-control" id="event_time" name="event_time"
                                value="<?php echo $event_time ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="event_description" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="event_description" name="event_description"><?php echo $event_description ?></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="organizer_id" class="col-sm-2 col-form-label">Organizer</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="organizer_id" name="organizer_id"
                                value="<?php echo $organizer_id ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!--untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Acara
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Acara</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Organizer</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM acara ORDER BY event_id DESC";
                        $q2 = mysqli_query($mysqli, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $event_id = $r2["event_id"];
                            $event_name = $r2["event_name"];
                            $event_date = $r2["event_date"];
                            $event_time = $r2["event_time"];
                            $event_description = $r2["event_description"];
                            $organizer_id = $r2["organizer_id"];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td><?php echo $event_name ?></td>
                                <td><?php echo $event_date ?></td>
                                <td><?php echo $event_time ?></td>
                                <td><?php echo $event_description ?></td>
                                <td><?php echo $organizer_id ?></td>
                                <td>
                                    <a href="index.php?op=edit&event_id=<?php echo $event_id ?>"><button type="button"  class="btn btn-warning">Edit</button></a>
                                    </td>
                                    <td>
                                    <a href="index.php?op=delete&event_id=<?php echo $event_id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Hide success and error messages after 5 seconds
        setTimeout(function () {
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
            var errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>
