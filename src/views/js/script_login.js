document.addEventListener('DOMContentLoaded', function() {

    // --- Lógica para las Etiquetas Flotantes ---
    const inputs = document.querySelectorAll('.input-group input');

    inputs.forEach(input => {
        // Si el input ya tiene valor al cargar la página (p.ej. autocompletado),
        // mantenemos la etiqueta arriba.
        if (input.value.trim() !== '') {
            input.classList.add('has-content');
            input.nextElementSibling.style.top = '-15px';
            input.nextElementSibling.style.fontSize = '0.8rem';
            input.nextElementSibling.style.color = 'var(--primary-color)';
        }

        input.addEventListener('focus', function() {
            this.nextElementSibling.style.top = '-15px';
            this.nextElementSibling.style.fontSize = '0.8rem';
            this.nextElementSibling.style.color = 'var(--primary-color)';
        });

        input.addEventListener('blur', function() {
            // Solo devolvemos la etiqueta a su posición si el campo está vacío
            if (this.value.trim() === '') {
                this.nextElementSibling.style.top = '10px';
                this.nextElementSibling.style.fontSize = '1rem';
                this.nextElementSibling.style.color = '#999';
            }
        });
    });

    // --- Lógica para el botón de ver/ocultar contraseña ---
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        // Cambiar el tipo del input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Cambiar el icono del ojo
        this.classList.toggle('fa-eye-slash');
    });

});