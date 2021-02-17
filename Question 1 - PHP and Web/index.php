<!doctype html>
<?php

//DB connection
$db = mysqli_connect("localhost", "root", "", "linux_machines_db");

//If there is a Search Post the query is updated to the information filled on the search field
if (isset($_POST['search'])) {
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM machine WHERE CONCAT(machine_id, machine_ip, machine_name, machine_linux_version, machine_status, 
    machine_logged_user, machine_cpu_usage, machine_memory_usage, machine_running_proccess, machine_need_testing) LIKE '%" . $valueToSearch . "%'";
    $run = mysqli_query($db, $query);

    //If there isn't a Search Post the query select all machines
} else {
    $query = "SELECT * FROM machine";
    $run = mysqli_query($db, $query);
}

//If there is a Save Machine Post, the insert query is filled with the informations provided on the form fields and it is persisted to the DB
if (isset($_POST['save_machine'])) {
    $machine_name = $_POST['machinename'];
    $machine_id = $_POST['machineid'];
    $linux_version = $_POST['linuxversion'];
    $machine_status = $_POST['machinestatus'];
    $logged_user = $_POST['userlogged'];
    $cpu_usage = $_POST['cpuUsage'];
    $memory_usage = $_POST['memoryusage'];
    $running_proccess = $_POST['runningproccess'];
    $need_testing = $_POST['needtesting'];
    $query = "INSERT INTO machine(machine_name, machine_ip, machine_linux_version, machine_status, machine_logged_user, machine_cpu_usage, machine_memory_usage, machine_running_proccess, machine_need_testing)
        VALUES ('$machine_name', '$machine_id', '$linux_version', '$machine_status', '$logged_user', '$cpu_usage', '$memory_usage', '$running_proccess', '$need_testing')";
    $run = mysqli_query($db, $query);
    if (!$run) {
        die($query);
    }
    header('Location: index.php');
}
?>
<html>

<head>
    <meta charset="utf-8">
    <!-- Adding the CSS file -->
    <link rel="stylesheet" href="style.css">
    <title>Linux Machine Monitor</title>
</head>

<body>
    <h2>Linux Machine Monitor</h2>
    <div class="init_buttons">
        <button class="add_toggle_button" onclick="toggleForm()">Add new machine</button>
    </div><br>
    <div id="form_add_machine" class="form">
        <form action="index.php" method="post">
            <label for="machinename">Machine name</label>
            <input class="inputtext" type="text" id="mname" name="machinename" placeholder="Enter the machine name" required>

            <label for="machineid">Machine ip</label>
            <input class="inputtext" type="text" id="mip" name="machineid" placeholder="Enter the machine ip" required>

            <label for="linuxversion">Linux Version</label>
            <input class="inputtext" type="text" id="lversion" name="linuxversion" placeholder="Enter the Linux version" required>

            <label for="machinestatus">Machine status</label>
            <select class="inputtext" name="machinestatus" id="status" required>
                <option value="" disabled selected>Select a status</option>
                <option value="Online">Online</option>
                <option value="Offline">Offline</option>
                <option value="Unknown">Unknown</option>
            </select>

            <label for="userlogged">User logged</label>
            <input class="inputtext" type="text" id="ulogged" name="userlogged" placeholder="Enter the logged user" required>

            <label for="cpuUsage">CPU Usage</label>
            <input class="inputtext" type="number" min="1" max="100" step="0.01" id="cpusage" name="cpuUsage" placeholder="Enter the CPU usage" required>

            <label for="memoryusage">Memory usage</label>
            <input class="inputtext" type="number" id="meusage" name="memoryusage" placeholder="Enter the memory usage" required>

            <label for="runningproccess">Running proccess</label>
            <input class="inputtext" type="text" id="rproccess" name="runningproccess" placeholder="Enter the running proccess" required>

            <label for="needtesting">Need testing</label>
            <select class="inputtext" name="needtesting" id="ntesting" required>
                <option value="" disabled selected>Select a option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>

            <input class="submit_button" type="Submit" value="Save" name="save_machine" />
        </form>
    </div><br>
    <div>
        <form id="filter_form" action="index.php" method="post">
            <input class="search_input" type="text" id="search" name="valueToSearch" placeholder="Filter">
            <input class="search_button" type="Submit" value="Search" name="search" />
        </form>
    </div><br>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Machine name</th>
                            <th>Machine IP</th>
                            <th>Linux version</th>
                            <th>Machine status</th>
                            <th>User logged</th>
                            <th>CPU usage</th>
                            <th>Memory usage</th>
                            <th>Running proccess</th>
                            <th>Need testing</th>
                        </tr>
                    </thead>
                    <?php
                    //This while executes until there is no returns left, and fill the lines of the HTML table with the DB information
                    while ($rows = mysqli_fetch_array($run)) {
                        $machine_id = $rows['machine_id'];
                        $machine_name = $rows['machine_name'];
                        $machine_ip = $rows['machine_ip'];
                        $linux_version = $rows['machine_linux_version'];
                        $machine_status = $rows['machine_status'];
                        $machine_user = $rows['machine_logged_user'];
                        $cpu_usage = $rows['machine_cpu_usage'];
                        $memory_usage = $rows['machine_memory_usage'];
                        $running_proccess = $rows['machine_running_proccess'];
                        $need_testing = $rows['machine_need_testing'];
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $machine_id; ?></td>
                                <td><?php echo $machine_name; ?></td>
                                <td><?php echo $machine_ip; ?></td>
                                <td><?php echo $linux_version; ?></td>
                                <td><?php echo $machine_status ?></td>
                                <td><?php echo $machine_user; ?></td>
                                <td><?php echo $cpu_usage; ?></td>
                                <td><?php echo $memory_usage; ?></td>
                                <td><?php echo $running_proccess; ?></td>
                                <td><?php if ($need_testing == 0) echo "No";
                                    else echo "Yes" ?></td>
                            </tr>
                        </tbody>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
<!-- Adding the JS file -->
<script type="text/javascript" src="scripts.js"></script>

</html>
