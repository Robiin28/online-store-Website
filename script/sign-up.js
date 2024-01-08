const form = document.getElementById("form");
    const password = document.getElementById("password");
    const password2 = document.getElementById("password2");
    const errorMessage = document.querySelector("small");

    form.addEventListener("submit", function(e) {
        
        if (password.value.length < 6 || password2.value.length < 6) {
            errorMessage.textContent = "Passwords must be at least 6 characters long";
            errorMessage.style.visibility = "visible";
        } else if (password.value !== password2.value) {
            errorMessage.textContent = "Passwords do not match";
            errorMessage.style.visibility = "visible";
        } else {
            // form can be submitted here
            form.submit();
        }
        e.preventDefault();
    });



    //for password visibility
    var passwordToggle = document.querySelector(".password-toggle");
    var passwordTogglel = document.querySelector(".password-toggle2");
     var passwordInput = document.getElementById("password");
       var passwordInputl = document.getElementById("password2");
   
       function togglePasswordVisibility() {
     if (passwordInput.type === "password") {
       passwordInput.type = "text";
       passwordToggle.classList.remove("fa-eye");
       passwordToggle.classList.add("fa-eye-slash");
     } else {
       passwordInput.type = "password";
       passwordToggle.classList.remove("fa-eye-slash");
       passwordToggle.classList.add("fa-eye");
     }
   }
   
   //for password confirm
       function togglePasswordVisibility2() {
     if (passwordInputl.type === "password") {
       passwordInputl.type = "text";
       passwordTogglel.classList.remove("fa-eye");
       passwordTogglel.classList.add("fa-eye-slash");
     } else {
       passwordInputl.type = "password";
       passwordTogglel.classList.remove("fa-eye-slash");
       passwordTogglel.classList.add("fa-eye");
     }
   }
   