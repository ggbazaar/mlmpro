<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Signup</h2>
        <form id="signupForm" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="name" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile:</label>
                <input type="text" id="mobile" name="mobile" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="parent_code" class="block text-sm font-medium text-gray-700">Parent Code:</label>
                <input type="text" id="parent_code" name="parent_code" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50">Signup</button>
        </form>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the default form submit

            // Get form data
            const formData = new FormData(this);

            try {
                // Send a POST request to the server
                const response = await fetch("{{ url('api/create-user') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                // Parse the JSON response
                const result = await response.json();

                // Show success or error message using SweetAlert
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Signup Successful!',
                        text: result.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Clear the form fields after the user clicks 'OK'
                        document.getElementById('signupForm').reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Signup Failed!',
                        text: result.message,
                        confirmButtonText: 'Try Again'
                    });
                }
            } catch (error) {
                // Handle any unexpected errors
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again later.',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
</body>
</html>
