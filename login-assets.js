// Basic React initialization script
console.log("React initialized from static JS");

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
  const container = document.getElementById('login-container');
  if (container) {
    console.log("Login container found, initializing React");
    
    // Show a basic login form
    container.innerHTML = `
      <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background: linear-gradient(to right bottom, #f0f4f8, #d9e2ec);">
        <div style="width: 100%; max-width: 400px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
          <div style="padding: 2rem;">
            <h2 style="text-align: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Acceso al Sistema</h2>
            <form id="login-form">
              <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Usuario</label>
                <input type="text" id="username" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" placeholder="Nombre de usuario" required>
              </div>
              <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Contraseña</label>
                <input type="password" id="password" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" placeholder="••••••••" required>
              </div>
              <button type="submit" style="width: 100%; padding: 0.75rem; background: linear-gradient(to right, #3b82f6, #4f46e5); color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                Iniciar sesión
              </button>
            </form>
          </div>
          <div style="background-color: #f9fafb; padding: 1rem; text-align: center; font-size: 0.75rem; color: #6b7280;">
            Sistema de gestión empresarial © ${new Date().getFullYear()}
          </div>
        </div>
      </div>
    `;
    
    // Add form submission handler
    const form = document.getElementById('login-form');
    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Create form data
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        formData.append('_token', csrfToken);
        
        // Send POST request
        fetch('/api/login', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            username: username,
            password: password,
            _token: csrfToken
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.href = '/dashboard';
          } else {
            alert(data.message || 'Credenciales inválidas');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al iniciar sesión. Inténtalo de nuevo.');
        });
      });
    }
  } else {
    console.error("Login container not found");
  }
}); 