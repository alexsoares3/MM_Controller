<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/x-icon" href="/favicon.ico">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <title>MM Controller</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11 mx-auto mt-3 rounded">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" id="modal-902294"
                    href="#modal-container-902294" role="button"
                    style="margin-top: 20px; background-color: #76ABAE;">Add New Entry</button>
                <!--Modal for new entries-->
                <div class="modal fade" id="modal-container-902294" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="background-color:#31363F">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">
                                    Add a new entry
                                </h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form">
                                    <div class="modal-body">
                                        <form role="form">
                                            <div class="form-group">
                                                <label for="name">Entry name</label>
                                                <input type="text" class="form-control" id="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="state">Starting State</label>
                                                <input type="text" class="form-control" id="state">
                                            </div>
                                        </form>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" style="background-color: #76ABAE;"
                                    onclick="addEntry()">
                                    Save changes
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <table class="table table-striped table-hover" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>State</th>
                            <th>Last Modified</th>
                            <th>Toggle (0 to 1/1 to 0)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Database connection information
                        require 'api/db_credentials.php';

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Retrieve data from the database
                        $sql = "SELECT * FROM ARD";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $button_color = ($row['state'] == 0) ? 'btn-danger' : 'btn-success';
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['state']; ?></td>
                                    <td><?php echo $row['last_modified']; ?></td>
                                    <td>
                                        <button type="button" class="btn <?php echo $button_color; ?>"
                                            onclick="changeState(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', <?php echo $row['state']; ?>)"
                                            style="float: center;">
                                            <?php echo ($row['state'] == 0) ? 'Turn On' : 'Turn Off'; ?>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn <?php echo 'btn-success'; ?>"
                                            onclick="editEntry(<?php echo $row['id']; ?>,'<?php echo $row['name']; ?>',<?php echo $row['state']; ?>)"
                                            style="background-color:#76ABAE;">
                                            Edit
                                        </button>
                                        <!--Modal for editing entries-->
                                        <div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" style="background-color:#31363F">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">
                                                            Edit Entry
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editForm" role="form">
                                                            <div class="form-group">
                                                                <label for="editId">Entry ID</label>
                                                                <input type="text" class="form-control" id="editId" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editName">Entry name</label>
                                                                <input type="text" class="form-control" id="editName">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editState">State</label>
                                                                <input type="text" class="form-control" id="editState">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            style="background-color: #76ABAE;" onclick="saveChanges()">
                                                            Save Changes
                                                        </button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn <?php echo 'btn-danger'; ?>"
                                            onclick="delEntry(<?php echo $row['id']; ?>,'<?php echo $row['name']; ?>')">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                        // Close connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>

        function addEntry() {
            var name = $('#name').val();
            var startingState = $('#state').val();
            $.ajax({
                url: '/api/api.php',
                type: 'GET',
                data: { operation: 'create', name: name, state: startingState },

                success: function (response) {
                    // Refresh the page or update the UI as needed
                    console.log("AJAX success:", response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            console.log("Sending AJAX request with data:", { operation: 'create', name: name, state: startingState });
        }

        function delEntry(id, name) {
            var confirmed = window.confirm("Are you sure you want to delete entry #" + id + " (" + name + ")?");
            if (!confirmed) {
                return; // Do nothing if the user cancels
            }

            $.ajax({
                url: '/api/api.php',
                type: 'GET',
                data: { operation: 'delete', id: id },

                success: function (response) {
                    console.log("AJAX success:", response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            console.log("Sending AJAX request with data:", { operation: 'delete', id: id });
        }

        function changeState(id, name, currentState) {
            var newState = currentState === 0 ? 1 : 0; // Toggle state


            $.ajax({
                url: '/api/api.php',
                type: 'GET',
                data: { operation: 'update', id: id, name: name, state: newState },

                success: function (response) {
                    console.log("AJAX success:", response);
                    var button = $('#button_' + id);
                    button.removeClass('btn-danger btn-success');
                    button.addClass(newState === 0 ? 'btn-danger' : 'btn-success');
                    button.text(newState === 0 ? 'Activate' : 'Deactivate');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            console.log("Sending AJAX request with data:", { operation: 'update', id: id, name: name, state: newState });
        }

        function editEntry(id, name, state) {
            $('#editId').val(id);
            $('#editName').val(name);
            $('#editState').val(state);
            $('#editModal').modal('show');
        }

        function saveChanges() {
            var id = $('#editId').val();
            var name = $('#editName').val();
            var state = $('#editState').val();

            $.ajax({
                url: '/api/api.php',
                type: 'GET',
                data: { operation: 'update', id: id, name: name, state: state },

                success: function (response) {
                    console.log("AJAX success:", response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

    </script>
</body>