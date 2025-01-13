<!-- form.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Permission</title>
    <!-- Include Bootstrap or any CSS framework if needed -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Add New Permission</h2>
    <form action="{{ route('department.store') }}" method="POST">
        @csrf

        <!-- Module Name -->
        <div class="form-group">
            <label for="name">Department Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Create Access -->
        {{-- <div class="form-group">
            <label for="create_access">Create Access:</label>
            <select class="form-control" id="create_access" name="create_access">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Read Access -->
        <div class="form-group">
            <label for="read_access">Read Access:</label>
            <select class="form-control" id="read_access" name="read_access">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Update Access -->
        <div class="form-group">
            <label for="update_access">Update Access:</label>
            <select class="form-control" id="update_access" name="update_access">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Delete Access -->
        <div class="form-group">
            <label for="delete_access">Delete Access:</label>
            <select class="form-control" id="delete_access" name="delete_access">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div> --}}

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
