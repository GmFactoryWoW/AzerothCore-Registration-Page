// Requirements
let validEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Email regex
const PASSWORD_VALID_CHARS = /[a-zA-Z0-9!#$%&'()*+,\-./:;<=>?@[\]^_`{{}}~]/;
const PASSWORD_VALID_REGEX = new RegExp(`^[a-zA-Z0-9!#$%&'()*+,\-./:;<=>?@[\\]^_\`{{}}~]{${PASSWORD_MIN_LENGTH},${PASSWORD_MAX_LENGTH}}$`);
let validPassword = PASSWORD_VALID_REGEX; // Password regex
let validUsername = new RegExp(`^[a-zA-Z0-9]{${USERNAME_MIN_LENGTH},${USERNAME_MAX_LENGTH}}$`); // Username regex
// Uppercase letter requirement removed

// Get the helper elements
let usernameHelper = document.getElementById("usernameHelper"); // Username helper
let emailHelper = document.getElementById("emailHelper"); // Email helper
let passwordCharsHelper = document.getElementById("passwordCharsHelper"); // Password length helper
let mustContainHelper = document.getElementById("mustContainHelper"); // Must contain uppercase letter helper
let passwordMatchHelper = document.getElementById("passwordMatchHelper"); // Confirm password match helper

// Get the input elements
let inputUsername = document.getElementById('username');
let inputEmail = EMAIL_ENABLED ? document.getElementById('email') : null;
let inputPassword = document.getElementById('password');
let inputConfirmPassword = document.getElementById('passwordRepeat');
let submitButton = document.getElementById('submit'); // Submit button

// Flags to check if the fields have been touched
let usernameTouched = false;
let emailTouched = false;
let passwordTouched = false;
let confirmPasswordTouched = false;

// Function to validate the form
function validateForm() {
  let username = inputUsername.value;
  let email = inputEmail ? inputEmail.value : "";
  let password = inputPassword.value;
  let confirmPassword = inputConfirmPassword.value;

  let isUsernameValid = validUsername.test(username);
  let isEmailValid = EMAIL_ENABLED ? validEmail.test(email) : true;
  let isPasswordLengthValid = validPassword.test(password);
  let isPasswordMatchValid = password === confirmPassword;

  // Validate username
  if (usernameTouched) {
    if (!isUsernameValid) {
      usernameHelper.classList.add("text-danger");
      usernameHelper.innerHTML = `Le nom d’utilisateur doit contenir entre ${USERNAME_MIN_LENGTH} et ${USERNAME_MAX_LENGTH} caractères. Seuls les lettres et les chiffres sont autorisés !`;
    } else {
      usernameHelper.classList.remove("text-danger");
      usernameHelper.innerHTML = "";
    }
  }

  // Validate email
  if (EMAIL_ENABLED && emailTouched) {
    if (!isEmailValid) {
      emailHelper.classList.add("text-danger");
      emailHelper.innerHTML = "Veuillez saisir une adresse e-mail valide !";
    } else if (inputEmail.value.length > 255) {
      emailHelper.classList.add("text-danger");
      emailHelper.innerHTML = "L’adresse e-mail doit contenir au maximum 255 caractères.";
    } else {
      emailHelper.classList.remove("text-danger");
      emailHelper.innerHTML = "";
    }
  }

  // Validate password length
  if (passwordTouched) {
    if (!isPasswordLengthValid) {
      passwordCharsHelper.classList.add("text-danger");
      passwordCharsHelper.classList.remove("text-success");
      passwordCharsHelper.innerHTML = `Le mot de passe doit contenir entre ${PASSWORD_MIN_LENGTH} et ${PASSWORD_MAX_LENGTH} caractères. Caractères autorisés : a-z, A-Z, 0-9 et ! # $ % & ' ( ) * + , - . / : ; < = > ? @ [ ] ^ _ \` {{ }} ~`;
    } else {
      passwordCharsHelper.classList.remove("text-danger");
      passwordCharsHelper.classList.add("text-success");
      passwordCharsHelper.innerHTML = `Mot de passe : ${PASSWORD_MIN_LENGTH} caractère(s) minimum, ${PASSWORD_MAX_LENGTH} caractères maximum. Caractères autorisés : a-z, A-Z, 0-9 et ! # $ % & ' ( ) * + , - . / : ; < = > ? @ [ ] ^ _ \` {{ }} ~`;
    }

  }

  // Confirm password match validation
  if (passwordTouched && confirmPasswordTouched) {
    if (isPasswordMatchValid) {
      passwordMatchHelper.classList.remove("text-danger");
      passwordMatchHelper.classList.add("text-success");
    } else {
      passwordMatchHelper.classList.add("text-danger");
      passwordMatchHelper.classList.remove("text-success");
    }
  }

  // Enable or disable the submit button
  submitButton.disabled = !(isUsernameValid && isEmailValid && isPasswordLengthValid && isPasswordMatchValid);
}

// Validate username
if (inputUsername) {
  inputUsername.addEventListener('input', function () {
    usernameTouched = true;
    validateForm();
  });
}

// Validate email
if (inputEmail) {
  inputEmail.addEventListener('input', function () {
    emailTouched = true;
    validateForm();
  });
}

// Validate password and confirm password
if (inputPassword) {
  inputPassword.addEventListener('input', function () {
    passwordTouched = true;
    validateForm();
  });
}

if (inputConfirmPassword) {
  inputConfirmPassword.addEventListener('input', function () {
    confirmPasswordTouched = true;
    validateForm();
  });
}

// Initial validation call to set the button state correctly on page load
validateForm();