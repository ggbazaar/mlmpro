<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->

<div class="bg-gradient-to-r from-red-400 to-red-700 p-10">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-2">
    <!-- Left Section -->
    <div>
      <h1 class="text-4xl font-bold mb-4">GGB</h1>
      <h2 class="text-2xl font-semibold mb-6"> Build Your Network Today!</h2>
      <p class="text-lg mb-6">
        Learn how the Freedom software can help take your direct selling business to the next level with a demo.
      </p>

      <!-- Review Card -->
      <!-- <div class="bg-white text-black p-6 rounded-lg shadow-lg mb-6  ">
        <div class="flex items-center mb-4">
          <img class="h-10" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Capterra_logo.svg/1200px-Capterra_logo.svg.png" alt="Capterra logo" />
          <div class="ml-4">
            <p class="text-lg font-bold">EXCELLENT rating</p>
            <p class="text-gray-600 text-sm">Based on 55 reviews</p>
          </div>
        </div>
        <div class="flex items-center mb-4">
          <span class="text-yellow-400 text-xl">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
        </div>
      </div> -->

      <!-- Login Form -->
      <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-2 rounded-lg shadow-lg w-full max-w-md">
          <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login to Your Account</h2>
          <form id="loginForm" class="space-y-6">
            <!-- Email Input -->
            <div>
              <label class="block text-gray-600 font-semibold mb-2">Mobile or Email Address</label>
              <input type="text" name="emailOrMobile"  id="emailOrMobile" placeholder="Enter your mobile or email" class="w-full p-4 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" />
            </div>

            <!-- Password Input -->
            <div>
              <label class="block text-gray-600 font-semibold mb-2">Password</label>
              <input type="password" name="password" id="password" placeholder="Enter your password" class="w-full p-4 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" />
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center">
              <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
              <label for="remember" class="ml-2 text-gray-600">Remember Me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
              Login
            </button>
          </form>

          <!-- Additional Links -->
          <div class="mt-6 text-center">
            <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Section -->
    <div class="bg-red-200 p-2 rounded-lg shadow-lg">
      <h2 class="text-2xl font-semibold text-black mb-6">Add Advisor*</h2>
      <form class="bg-white p-8 rounded-lg shadow-lg space-y-6" id="saveform" name="saveform">
        <div class="grid grid-cols-2 gap-2">
          <input type="text" name="name" placeholder="Name*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" />
          <input type="text" name="mobile" placeholder="Mobile*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" />
          <input type="email" name="email" placeholder="Email*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" />
          <input type="text" name="whatsapp" placeholder="WhatsApp*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" />
          <input type="text" name="pan" placeholder="PAN*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" />
          <input type="text" name="aadhar" placeholder="Aadhar*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>

        <!-- Relation -->
        <div>
          <label class="block text-black font-semibold mb-2">Relation:</label>
          <div class="flex space-x-4">
            <label class="inline-flex items-center">
              <input type="radio" name="relation" value="S/O" class="form-radio text-red-600">
              <span class="ml-2">S/O</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" name="relation" value="W/O" class="form-radio text-red-600">
              <span class="ml-2">W/O</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" name="relation" value="H/O" class="form-radio text-red-600">
              <span class="ml-2">H/O</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" name="relation" value="F/O" class="form-radio text-red-600">
              <span class="ml-2">F/O</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" name="relation" value="D/O" class="form-radio text-red-600">
              <span class="ml-2">D/O</span>
            </label>
          </div>
        </div>
        <!-- Relation Name Input -->
        <div>
          <!-- <label class="block text-black font-semibold mb-2">Relation Name:</label> -->
          <input type="text" name="rname" placeholder="Relation Name" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 w-full" />
        </div>

        <div class="grid grid-cols-2 gap-4">
  <!-- Gender -->
  <div>
    <label class="block text-black font-semibold mb-2">Gender:</label>
    <div class="flex space-x-8 mb-4">
      <label class="inline-flex items-center">
        <input type="radio" name="gender" value="Male" class="form-radio text-red-600">
        <span class="ml-2">Male</span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio" name="gender" value="Female" class="form-radio text-red-600">
        <span class="ml-2">Female</span>
      </label>
    </div>
    <input type="date" placeholder="Date of Birth (DOB)*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 w-full" />
  </div>

  <!-- Side -->
  <div>
    <label class="block text-black font-semibold mb-2">Side (Optional):</label>
    <div class="flex space-x-8 mb-4">
      <label class="inline-flex items-center">
        <input type="radio" name="side" value="1" class="form-radio text-red-600">
        <span class="ml-2">Left</span>
      </label>
      <label class="inline-flex items-center">
        <input type="radio" name="side" value="2" class="form-radio text-red-600">
        <span class="ml-2">Right</span>
      </label>
    </div>
    <input id="parent_code" name="parent_code" type="text" placeholder="Parent Code*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 w-full" />
  </div>

  <!-- Additional Inputs -->
  <div class="col-span-2">
    <input type="password" name="password" placeholder="Password*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 w-full mb-4" />
    <input type="text" name="level" placeholder="Level*" class="p-4 border border-green-900 bg-red-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 w-full" />
  </div>
</div>

   

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition duration-200">Submit</button>
      </form>
    </div>
  </div>
</div>
<script>
document.getElementById('saveform').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent default form submission
  const formData = new FormData(this); // Create a FormData object from the form

  console.log(formData,"adadfasdf");

  // Log form data for debugging
  for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
  }

  // Send the request using fetch
  fetch('http://127.0.0.1:8000/api/create-user/', {
    method: 'POST',
    body: formData, // Use FormData directly
    headers: {
      'Accept': 'application/json', // Accept JSON response
    },
  })
  .then(response => {
    if (!response.ok) {
      return response.json().then(err => {
        console.error('Error response:', err); // Log detailed error response
        throw new Error(err.message || 'Network response was not ok'); // Use specific error message
      });
    }
    return response.json(); // Parse JSON response
  })
  .then(data => {
    console.log('Success:', data);
    // Handle success (e.g., display a success message)
    Swal.fire({
      title: 'Success!',
      text: 'User created successfully!',
      icon: 'success',
      confirmButtonText: 'OK'
    });
  })
  .catch(error => {
    console.error('Error:', error);
    // Handle error (e.g., display an error message)
    Swal.fire({
      title: 'Error!',
      text: error.message || 'Something went wrong!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  });
});
</script>


<script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the form values
    const emailOrMobile = document.getElementById('emailOrMobile').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    // You can now handle the form submission with JavaScript, such as sending it to an API
    console.log('Email or Mobile:', emailOrMobile);
    console.log('Password:', password);
    console.log('Remember Me:', remember);

    // Example: You can send the data to a server using fetch
    fetch('/api/signin', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        email: emailOrMobile,
        password: password,
        remember: remember
      })
    })
    .then(response => response.json())
    .then(data => {
      // Handle response data
      console.log(data);
      return redirect()->route('route_name');
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
</script>


