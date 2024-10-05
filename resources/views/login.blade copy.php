<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Correct CDN for Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-700">Login</h2>
            <form id="loginForm">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-800">Email:</label>
                    <input type="email" id="email" name="email" required
                        class="mt-2 block w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-4 focus:ring-blue-400 focus:border-blue-500 transition duration-300"
                        placeholder="you@example.com">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-800">Password:</label>
                    <input type="password" id="password" name="password" required
                        class="mt-2 block w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-4 focus:ring-blue-400 focus:border-blue-500 transition duration-300"
                        placeholder="********">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold py-3 rounded-lg shadow-lg hover:from-blue-500 hover:to-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 transition duration-300">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="#" class="text-sm text-blue-700 hover:underline">Forgot your password?</a>
            </div>

            <div id="errors" class="mt-6 text-red-600 text-sm text-center"></div> <!-- Error messages will appear here -->
        </div>


    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the default form submit

            // Create a FormData object from the form
            const formData = new FormData(this);

            try {
                // Send a POST request to the server
                const response = await fetch("{{ url('api/login') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                // Parse the JSON response
                const result = await response.json();

                // Handle successful response
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        text: result.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Optionally, redirect the user after login success
                        window.location.href = "/dashboard"; // Redirect to the dashboard or another page
                    });
                } else {
                    // Handle validation errors
                    let errorMessages = '';
                    Object.keys(result.errors).forEach(function(key) {
                        errorMessages += `<p>${result.errors[key][0]}</p>`;
                    });
                    document.getElementById('errors').innerHTML = errorMessages;

                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed!',
                        text: result.message || 'Please check your credentials and try again.',
                        confirmButtonText: 'Try Again'
                    });
                }
            } catch (error) {
                // Handle network or unexpected errors
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
