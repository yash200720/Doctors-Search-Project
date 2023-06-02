<?php
    if(isset($_POST["selectarea"]) && isset($_POST["findyourdoctor"]))
    {
        $con = mysqli_connect("localhost", "id20815505_newdoctordatabase", "Ya@_200702", "id20815505_doctorsdatabase");

        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $selectarea = $_POST['selectarea'] . '%';
        $findyourdoctor = $_POST['findyourdoctor'];

        $query = "SELECT * FROM `Doctors` WHERE `DoctorArea` LIKE ? AND `DoctorsCategory` LIKE ?";
        $stmt = mysqli_prepare($con, $query);

        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($stmt, "ss", $selectarea, $findyourdoctor);

        if (!mysqli_stmt_execute($stmt)) {
            die("Execution failed: " . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        $rowcount = mysqli_num_rows($result);

        $data = '<h1 class="title-GExcsT valign-text-middle" data-id="7:8">Doctors Found in Your Area</h1>';
        $doctor_data = "";

        if ($rowcount > 0) {
            $doctor_data = '<div class="container"><div class="finalClass">';
            while ($row = mysqli_fetch_assoc($result)) {
                $doctorid = $row["ID"];
                $doctorname = $row["DoctorName"];
                $doctorinformation = $row["DoctorInformation"];
                $doctorimage = $row["Doctor_image"];

                $doctor_data .= '<div class="col-xl-3 col-sm-6 mb-5 ">
                    <div class="newClass rounded shadow-sm py-5 px-4"><img src="'.$doctorimage.'" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">'.$doctorname.'</h5><span class="small text-uppercase text-muted">'.$findyourdoctor.'</span><p>'.$doctorinformation.'</p></div></div>';
            }
            $doctor_data .= '</div></div>';
            $data .= $doctor_data;
        } else {
            $data = '<h1 class="title-GExcsT valign-text-middle" data-id="7:8">No Doctor Found in Your Area</h1>';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
    else {
        $data=' <h1 class="title-GExcsT valign-text-middle" data-id="7:8">Bad Query</h1>';
    }

    echo $data;
?>
