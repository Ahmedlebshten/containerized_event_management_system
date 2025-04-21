<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Type Selection</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the form */
        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        /* Headings */
        h2 {
            text-align: center;
            color: #333;
        }

        /* Labels */
        label {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        /* Dropdown Style */
        select, input {
            width: 94%;
            padding: 10px;
            font-size: 1rem;
            margin: 10px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        /* Button Style */
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        /* Mobile Responsiveness */
        @media (max-width: 480px) {
            form {
                padding: 15px;
            }

            h2 {
                font-size: 1.5rem;
            }

            button {
                padding: 8px 10px;
            }
        }
    </style>

    <script>
        function handleUserTypeChange() {
            var userType = document.getElementById("user_type").value;
            var emailField = document.getElementById("admin_email");

            // Show the email field only if admin is selected
            if (userType === "admin") {
                emailField.style.display = "block";  
            } else {
                emailField.style.display = "none";
            }
        }
        
        // handles the form submission when the user submits the form.
        function handleSubmit(event) {
            event.preventDefault();
            var userType = document.getElementById("user_type").value;
            var email = document.getElementById("email").value;

            if (userType === "user") {
                window.location.href = "home.html";    // go to this page
            } else if (userType === "admin") {
                // Check if email field is filled and validate email on the server
                if (email) {
                    document.getElementById("user_form").submit(); // Submit the form if email is true
                } else {
                    alert("Please enter your email.");
                }
            } else {
                alert("Please select a user type.");
            }
        }
    </script>

</head>
<body>
    <form id="user_form" method="POST" action="process-user-type.php" onsubmit="handleSubmit(event)">
        <label for="user_type">Choose User Type:</label>
        <select id="user_type" name="user_type" onchange="handleUserTypeChange()" required>
            <option value="" disabled selected>Select an option</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        
        <!-- this field is shown only if user selected admin -->
        <div id="admin_email" style="display: none;">
            <label for="email">Enter Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email">
        </div>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
