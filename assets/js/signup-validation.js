const form = document.getElementById('form');
const firstname = document.getElementById('first_name');
const lastname = document.getElementById('last_name');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const usertype = document.getElementById('user_type');
// const password2 = document.getElementById('password2');

form.addEventListener('submit', e => {
    e.preventDefault();

    if (validateInputs()) {
        form.submit(); // Submit the form if validation passes
    }
});

const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success')
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};




const isValidEmail = email => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

const validateInputs = () => {
    const firstnameValue = firstname.value.trim();
    const lastnameValue = lastname.value.trim();
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const usertypeValue = usertype.value;
    // const password2Value = password2.value.trim();

    let firstnameValid = false;
    let lastnameValid = false;
    let userValid = false;
    let emailValid = false;
    let passValid = false;
    let usertypeValid = false;

    if (firstnameValue === '') {
        setError(firstname, 'First name is required');
    } else {
        setSuccess(firstname);
        firstnameValid = true;
    }
    if (lastnameValue === '') {
        setError(lastname, 'Last name is required');
    } else {
        setSuccess(lastname);
        lastnameValid = true;
    }

    if (usernameValue === '') {
        setError(username, 'Username is required');

    } else if (usernameValue.length < 3) {
        setError(username, 'Username must be at least 3 character.');
    } else {
        setSuccess(username);
        userValid = true;
    }

    if (emailValue === '') {
        setError(email, 'Email is required');
    } else if (!isValidEmail(emailValue)) {
        setError(email, 'Provide a valid email address');
    } else {
        setSuccess(email);
        emailValid = true;
    }

    if (passwordValue === '') {
        setError(password, 'Password is required');
    } else if (passwordValue.length < 8) {
        setError(password, 'Password must be at least 8 character.');
    } else {
        setSuccess(password);
        passValid = true;
    }


    // if (password2Value === '') {
    //     setError(password2, 'Please confirm your password');
    // } else if (password2Value !== passwordValue) {
    //     setError(password2, "Passwords doesn't match");
    // } else {
    //     setSuccess(password2);
    // }
    return firstnameValid && lastnameValid && userValid && emailValid && passValid;

};
