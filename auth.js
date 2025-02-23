// Save user ID to localStorage after login/signup
function saveUserSession(userID) {
    localStorage.setItem('userID', userID);
}

// Clear user session on logout
function logout() {
    localStorage.removeItem('userID');
    window.location.href = 'login.html';
}