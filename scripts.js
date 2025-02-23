document.addEventListener('DOMContentLoaded', () => {
    // Initialize storage
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    const capsules = JSON.parse(localStorage.getItem('capsules') || '[]');
    const currentUser = JSON.parse(localStorage.getItem('currentUser'));
    
    // Auth management
    const updateAuthState = () => {
        document.querySelectorAll('.nav-links').forEach(nav => {
            nav.innerHTML = currentUser ? `
                <a href="dashboard.html" class="nav-link">Dashboard</a>
                <a href="new-capsule.html" class="nav-link">New Capsule</a>
                <a href="about.html" class="nav-link">About</a>
                <button class="nav-link" id="logoutBtn">Logout</button>
            ` : `
                <a href="index.html" class="nav-link">Home</a>
                <a href="login.html" class="nav-link">Login</a>
                <a href="signup.html" class="nav-link">Signup</a>
            `;
        });
    };

    // Form handlers
    const handleLogin = (e) => {
        e.preventDefault();
        const [identifier, password] = e.target.querySelectorAll('input');
        const user = users.find(u => 
            (u.email === identifier.value || u.username === identifier.value) && 
            u.password === password.value
        );
        if (user) {
            localStorage.setItem('currentUser', JSON.stringify(user));
            window.location.href = 'dashboard.html';
        } else {
            alert('Invalid credentials!');
        }
    };

    const handleSignup = (e) => {
        e.preventDefault();
        const [username, email, pass, confirmPass] = e.target.querySelectorAll('input');
        if (pass.value !== confirmPass.value) return alert('Passwords mismatch!');
        const newUser = {
            id: Date.now(),
            username: username.value,
            email: email.value,
            password: pass.value
        };
        localStorage.setItem('users', JSON.stringify([...users, newUser]));
        localStorage.setItem('currentUser', JSON.stringify(newUser));
        window.location.href = 'dashboard.html';
    };

    const handleCapsuleCreation = (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const newCapsule = {
            id: Date.now(),
            userId: currentUser.id,
            title: formData.get('title'),
            description: formData.get('description'),
            unlockDate: formData.get('unlockDate'),
            created: new Date().toISOString()
        };
        localStorage.setItem('capsules', JSON.stringify([...capsules, newCapsule]));
        window.location.href = 'dashboard.html';
    };

    // Event listeners
    document.addEventListener('submit', e => {
        if (e.target.matches('#loginForm')) handleLogin(e);
        if (e.target.matches('#signupForm')) handleSignup(e);
        if (e.target.matches('#capsuleForm')) handleCapsuleCreation(e);
    });

    document.addEventListener('click', e => {
        if (e.target.matches('#logoutBtn')) {
            localStorage.removeItem('currentUser');
            window.location.href = 'index.html';
        }
    });

    // Protected routes
    const protectedRoutes = ['dashboard.html', 'new-capsule.html'];
    if (protectedRoutes.some(route => location.pathname.endsWith(route)) && !currentUser) {
        window.location.href = 'login.html';
    }

    // Update UI
    updateAuthState();
    if (location.pathname.endsWith('dashboard.html')) {
        const userCapsules = capsules.filter(c => c.userId === currentUser?.id);
        const container = document.getElementById('capsulesContainer');
        if (container) {
            container.innerHTML = userCapsules.length ? userCapsules.map(capsule => `
                <div class="capsule-card">
                    <h3>${capsule.title}</h3>
                    <p>${capsule.description}</p>
                    <small>Unlocks: ${new Date(capsule.unlockDate).toLocaleDateString()}</small>
                </div>
            `).join('') : '<div class="empty-state">No capsules found</div>';
        }
    }
});