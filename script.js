document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.querySelector('input[type="password"]');

    //Check if input exists to avoid errors on pages without passwords
    if (passwordInput) {
        const toggleBtn = document.createElement('button');
        toggleBtn.innerText = "Show Password";
        toggleBtn.type = "button"; //Important: don't let it submit the form
        toggleBtn.style.marginTop = "5px";
        toggleBtn.style.backgroundColor = "#ccc";

        toggleBtn.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleBtn.innerText = type === 'password'  ? 'Show password' : 'Hide Password';
        });

        passwordInput.parentNode.appendChild(toggleBtn);
    }
})