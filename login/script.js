function login() {
    // Add your login logic here
    var studentID = document.getElementById('studentID').value;
    var password = document.getElementById('password').value;
  
    // Example: Check if fields are not empty
    if (studentID && password) {
      alert('Login successful!');
    } else {
      alert('Please enter Student ID and Password.');
    }
  }
  
  function loginWithGoogle() {
    // Add Google login API integration here
    alert('Fix');
  }
  