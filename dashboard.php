<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your Digital Time Capsule Pro Dashboard - Manage your time capsules in style.">
    <title>Dashboard - Digital Time Capsule Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #0f0f1a 100%);
            font-family: 'Inter', sans-serif;
            color: #e6e6e6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Simplified Particle Background */
        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            will-change: transform;
        }
        .particle {
            position: absolute;
            background: rgba(74, 144, 226, 0.5);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }
        @keyframes float {
            0% { transform: translateY(100vh); opacity: 0.4; }
            100% { transform: translateY(-10vh); opacity: 0.8; }
        }

        /* Optimized Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 8px rgba(74, 144, 226, 0.4); }
            50% { box-shadow: 0 0 15px rgba(74, 144, 226, 0.7); }
        }

        /* Header */
        .header {
            background: rgba(20, 20, 35, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 10;
            position: sticky;
            top: 0;
        }
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        .logo:hover {
            color: #6ab0ff;
        }
        .logo img {
            width: 40px;
            margin-right: 12px;
            filter: drop-shadow(0 0 5px rgba(74, 144, 226, 0.6));
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-link {
            color: #e6e6e6;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .nav-link:hover {
            background-color: rgba(74, 144, 226, 0.2);
            color: #ffffff;
        }

        /* Dashboard Container */
        .dashboard-container {
            background: rgba(30, 30, 45, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            max-width: 1000px;
            margin: 60px auto;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 10;
            animation: fadeInUp 0.8s ease-out;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .dashboard-title {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 1.5px;
            background: linear-gradient(45deg, #4a90e2, #9bd3ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .button-group {
            display: flex;
            gap: 15px;
        }
        .logout-btn, .new-capsule-btn {
            padding: 10px 20px;
            background: linear-gradient(45deg, #4a90e2, #7bc3ff);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 3px 10px rgba(74, 144, 226, 0.4);
        }
        .logout-btn:hover, .new-capsule-btn:hover {
            background: linear-gradient(45deg, #3a7bd5, #5aaaff);
            transform: translateY(-2px);
        }
        .logout-btn {
            background: linear-gradient(45deg, #ff4a4a, #ff8787);
        }
        .logout-btn:hover {
            background: linear-gradient(45deg, #e63939, #ff6666);
        }

        /* Welcome Message */
        .welcome-message {
            font-size: 18px;
            color: #d0d0d0;
            text-align: center;
            margin: 20px 0;
            animation: fadeInUp 1s ease-out;
        }

        /* Capsules Section */
        .capsules-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .capsule-card {
            background: rgba(40, 40, 55, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            will-change: transform;
        }
        .capsule-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
        }
        .capsule-title {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 15px;
        }
        .capsule-meta p {
            font-size: 14px;
            color: #d0d0d0;
            margin: 8px 0;
        }
        .countdown {
            font-size: 14px;
            color: #7bc3ff;
            margin: 8px 0;
            font-weight: 500;
        }
        .capsule-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .action-btn {
            padding: 8px 18px;
            background: linear-gradient(45deg, #4a90e2, #7bc3ff);
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 8px rgba(74, 144, 226, 0.3);
        }
        .action-btn:hover {
            background: linear-gradient(45deg, #3a7bd5, #5aaaff);
            transform: translateY(-2px);
        }
        .download-btn[disabled] {
            background: rgba(80, 80, 80, 0.8);
            cursor: not-allowed;
            box-shadow: none;
        }
        .download-btn[disabled]:hover {
            background: rgba(80, 80, 80, 0.8);
            transform: none;
        }
        .delete-btn {
            background: linear-gradient(45deg, #ff4a4a, #ff8787);
        }
        .delete-btn:hover {
            background: linear-gradient(45deg, #e63939, #ff6666);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 18, 0.85);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }
        .modal.show {
            display: flex;
            animation: fadeInUp 0.5s ease-out;
        }
        .modal-content {
            background: rgba(35, 35, 50, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            max-height: 80vh;
            overflow-y: auto;
            animation: fadeInUp 0.6s ease-out;
        }
        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            color: #d0d0d0;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .modal-close:hover {
            color: #ff6666;
        }
        .modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 30px;
            text-align: center;
            letter-spacing: 1px;
            background: linear-gradient(45deg, #4a90e2, #9bd3ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .modal-field {
            margin-bottom: 25px;
            position: relative;
        }
        .modal-field label {
            font-size: 14px;
            font-weight: 500;
            color: #d0d0d0;
            margin-bottom: 10px;
            display: block;
            position: absolute;
            top: -25px;
            left: 5px;
        }
        .modal-field input,
        .modal-field textarea {
            width: 100%;
            padding: 12px 15px;
            background: rgba(50, 50, 65, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-size: 15px;
            color: #e6e6e6;
            transition: border-color 0.3s ease, transform 0.2s ease;
        }
        .modal-field input:focus,
        .modal-field textarea:focus {
            outline: none;
            border-color: #7bc3ff;
            transform: scale(1.02);
        }
        .modal-field textarea {
            resize: vertical;
            height: 80px;
        }
        .modal-field input[type="file"] {
            padding: 10px 0;
            border: none;
            background: none;
        }
        .time-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .time-wrapper input[type="date"],
        .time-wrapper input[type="time"] {
            flex: 1;
        }
        .time-wrapper select {
            padding: 12px;
            background: rgba(50, 50, 65, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-size: 15px;
            color: #e6e6e6;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }
        .time-wrapper select:focus {
            outline: none;
            border-color: #7bc3ff;
        }
        .current-file, .days-left {
            font-size: 12px;
            color: #a0a0a0;
            margin-top: 5px;
        }
        .modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        .save-btn, .cancel-btn {
            flex: 1;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 3px 10px rgba(74, 144, 226, 0.4);
        }
        .save-btn {
            background: linear-gradient(45deg, #4a90e2, #7bc3ff);
        }
        .cancel-btn {
            background: linear-gradient(45deg, #ff4a4a, #ff8787);
        }
        .save-btn:hover {
            background: linear-gradient(45deg, #3a7bd5, #5aaaff);
            transform: translateY(-2px);
        }
        .cancel-btn:hover {
            background: linear-gradient(45deg, #e63939, #ff6666);
            transform: translateY(-2px);
        }

        /* Modal Readonly Fields */
        .modal-readonly-field {
            margin-bottom: 25px;
        }
        .modal-readonly-field label {
            font-size: 14px;
            font-weight: 500;
            color: #d0d0d0;
            margin-bottom: 10px;
            display: block;
        }
        .modal-readonly-field p {
            font-size: 15px;
            color: #e6e6e6;
            padding: 12px 15px;
            background: rgba(50, 50, 65, 0.9);
            border-radius: 8px;
            margin: 0;
            word-wrap: break-word;
        }
        .modal-readonly-field a {
            color: #9bd3ff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .modal-readonly-field a:hover {
            color: #5aaaff;
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background: rgba(20, 20, 35, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px;
            text-align: center;
            font-size: 14px;
            color: #a0a0a0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 10;
            animation: fadeInUp 1s ease-out;
        }
        .footer a {
            color: #9bd3ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #5aaaff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="particles"></div>

    <header class="header">
        <a href="index.html" class="logo">
            <img src="images/logo3.jpg" alt="Digital Time Capsule Logo" loading="lazy">
            Digital Time Capsule Pro
        </a>
        <nav class="nav-links">
            <a href="index.html" class="nav-link">Home</a>
            <a href="pricing.html" class="nav-link">Pricing</a>
            <a href="about.html" class="nav-link">About</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Your Time Capsules</h1>
            <div class="button-group">
                <button class="new-capsule-btn" onclick="openModal()">New Capsule</button>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </div>
        <p class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <div class="capsules-section" id="capsulesSection">
            <p style="text-align: center; color: #c0c0c0;">Loading capsules...</p>
        </div>
    </div>

    <div id="capsuleModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">×</span>
            <h2 class="modal-title">New Capsule</h2>
            <form id="capsuleForm" enctype="multipart/form-data" style="display: none;">
                <div class="modal-field">
                    <label for="modalCapsuleTitle">Capsule Title</label>
                    <input type="text" id="modalCapsuleTitle" name="title" required placeholder="Enter capsule title">
                </div>
                <div class="modal-field">
                    <label for="modalUnlockDate">Unlock Date & Time</label>
                    <div class="time-wrapper">
                        <input type="date" id="modalUnlockDate" name="unlockDate" required>
                        <input type="time" id="modalUnlockTime" name="unlockTime" required step="300">
                        <select id="modalAmPm" name="amPm">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    <p class="days-left" id="daysLeft"></p>
                </div>
                <div class="modal-field">
                    <label for="modalDescription">Description</label>
                    <textarea id="modalDescription" name="description" placeholder="Capsule purpose"></textarea>
                </div>
                <div class="modal-field">
                    <label for="modalContents">Contents</label>
                    <textarea id="modalContents" name="contents" placeholder="What’s inside?"></textarea>
                </div>
                <div class="modal-field">
                    <label for="modalFile">File</label>
                    <input type="file" id="modalFile" name="file" accept=".pdf,.jpg,.png,.txt,.mp4">
                    <p class="current-file" id="currentFile">No file</p>
                </div>
                <div class="modal-field">
                    <label for="modalOwnerEmail">Owner Email</label>
                    <input type="email" id="modalOwnerEmail" name="ownerEmail" required placeholder="navadeep77@localhost">
                </div>
                <div class="modal-field">
                    <label for="modalNomineeEmail">Nominee Email</label>
                    <input type="email" id="modalNomineeEmail" name="nomineeEmail" placeholder="Optional">
                </div>
                <input type="hidden" id="modalCapsuleID" name="capsuleID">
                <div class="modal-actions">
                    <button type="submit" class="save-btn">Submit</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
            <div id="capsuleView" style="display: none;">
                <div class="modal-readonly-field">
                    <label>Unlock Date & Time</label>
                    <p id="viewUnlockDateTime"></p>
                </div>
                <div class="modal-readonly-field">
                    <label>Description</label>
                    <p id="viewDescription"></p>
                </div>
                <div class="modal-readonly-field">
                    <label>Contents</label>
                    <p id="viewContents"></p>
                </div>
                <div class="modal-readonly-field">
                    <label>File</label>
                    <p id="viewFile"></p>
                </div>
                <div class="modal-readonly-field">
                    <label>Owner Email</label>
                    <p id="viewOwnerEmail"></p>
                </div>
                <div class="modal-readonly-field">
                    <label>Nominee Email</label>
                    <p id="viewNomineeEmail"></p>
                </div>
                <div class="modal-actions">
                    <button type="button" class="cancel-btn" onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>© 2025 Digital Time Capsule Pro. <a href="privacy-policy.html">Privacy Policy</a></p>
    </footer>

    <script>
        // Optimized Particle Background
        function createParticles() {
            const particleContainer = document.getElementById('particles');
            const particleCount = 30;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 3 + 1;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${Math.random() * 100}vw`;
                particle.style.animationDuration = `${Math.random() * 10 + 15}s`;
                particleContainer.appendChild(particle);
            }
        }
        window.addEventListener('load', () => {
            if (window.innerWidth > 768) createParticles();
        });

        // Dashboard Logic
        let capsules = [];
        let isModalOpen = false;
        let lastFetchTime = 0;
        const FETCH_INTERVAL = 300000;
        const COUNTDOWN_INTERVAL = 10000;

        document.addEventListener('DOMContentLoaded', () => {
            fetchCapsules();
            setInterval(fetchCapsules, FETCH_INTERVAL);
            setInterval(updateCountdowns, COUNTDOWN_INTERVAL);
        });

        function setupMinDateTime() {
            const unlockDateInput = document.getElementById('modalUnlockDate');
            const unlockTimeInput = document.getElementById('modalUnlockTime');
            const now = new Date(Date.now() + 5 * 60 * 1000);
            const minDate = now.toISOString().split('T')[0];
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const minTime = `${hours % 12 || 12}:${minutes < 10 ? '0' + minutes : minutes}`;
            const amPm = hours >= 12 ? 'PM' : 'AM';

            unlockDateInput.min = minDate;
            unlockTimeInput.min = minTime;
            unlockDateInput.value = minDate;
            unlockTimeInput.value = minTime;
            document.getElementById('modalAmPm').value = amPm;

            unlockDateInput.addEventListener('change', () => {
                if (unlockDateInput.value === minDate) {
                    unlockTimeInput.min = minTime;
                } else {
                    unlockTimeInput.min = '00:00';
                }
            }, { once: true });
        }

        async function fetchCapsules() {
            try {
                const response = await fetch('/DigitalTimeCapsule/get_capsules.php', {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: { 'Cache-Control': 'no-cache' }
                });
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                const data = await response.json();
                if (data.success && data.capsules) {
                    updateCapsules(data.capsules);
                    lastFetchTime = Date.now();
                } else {
                    document.getElementById('capsulesSection').innerHTML = '<p style="text-align: center; color: #c0c0c0;">No capsules yet!</p>';
                }
            } catch (error) {
                console.error('Fetch Error:', error.message);
                document.getElementById('capsulesSection').innerHTML = '<p style="text-align: center; color: #ff4a4a;">Failed to load capsules.</p>';
            }
        }

        function updateCapsules(newCapsules) {
            const section = document.getElementById('capsulesSection');
            section.innerHTML = '';
            newCapsules.forEach(c => {
                const isUnlocked = c.Status === 'Unlocked' || (new Date(c.UnlockDateTime).getTime() <= Date.now());
                const card = document.createElement('div');
                card.className = 'capsule-card';
                card.dataset.id = c.CapsuleID;
                card.innerHTML = `
                    <h3 class="capsule-title">${c.Title}</h3>
                    <div class="capsule-meta">
                        <p><strong>Unlocks:</strong> ${new Date(c.UnlockDateTime).toLocaleString()}</p>
                        <p><strong>Status:</strong> ${isUnlocked ? 'Unlocked' : c.Status}</p>
                        <p class="countdown" data-unlock="${c.UnlockDateTime}"></p>
                    </div>
                    <div class="capsule-actions">
                        <button class="action-btn view-btn" onclick="openModal('${c.CapsuleID}', '${c.Title}', '${c.UnlockDateTime}', '${isUnlocked ? 'Unlocked' : c.Status}', '${c.Description || ''}', '${c.Contents || ''}', '${c.FilePath || ''}', '${c.OwnerEmail}', '${c.NomineeEmail || ''}')">Details</button>
                        <a href="/DigitalTimeCapsule/download_file.php?id=${c.CapsuleID}" class="action-btn download-btn" ${c.FilePath ? '' : 'disabled'}>Download</a>
                        <button class="action-btn delete-btn" onclick="alert('Delete TBD')">Delete</button>
                    </div>
                `;
                section.appendChild(card);
            });
            capsules = newCapsules;
        }

        function updateCountdowns() {
            if (isModalOpen) return;
            const now = Date.now();
            const countdownEls = document.querySelectorAll('.countdown');
            countdownEls.forEach(el => {
                const unlockTime = new Date(el.dataset.unlock).getTime();
                const distance = unlockTime - now;
                if (distance > 0) {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    el.textContent = `Unlocks in: ${days}d ${hours}h`;
                } else {
                    el.textContent = 'Unlocked!';
                }
            });
        }

        function openModal(id = '', title = '', unlockDateTime = '', status = 'Locked', description = '', contents = '', filePath = '', ownerEmail = '', nomineeEmail = '') {
            const modal = document.getElementById('capsuleModal');
            const form = document.getElementById('capsuleForm');
            const view = document.getElementById('capsuleView');
            modal.classList.add('show');
            modal.style.display = 'flex';
            isModalOpen = true;

            if (status === 'Unlocked' || (unlockDateTime && new Date(unlockDateTime).getTime() <= Date.now())) {
                form.style.display = 'none';
                view.style.display = 'block';
                document.getElementById('viewUnlockDateTime').textContent = new Date(unlockDateTime).toLocaleString();
                document.getElementById('viewDescription').textContent = description || 'No description provided';
                document.getElementById('viewContents').textContent = contents || 'No contents provided';
                document.getElementById('viewFile').innerHTML = filePath ? `<a href="/DigitalTimeCapsule/download_file.php?id=${id}" target="_blank">${filePath.split('/').pop()}</a>` : 'No file attached';
                document.getElementById('viewOwnerEmail').textContent = ownerEmail;
                document.getElementById('viewNomineeEmail').textContent = nomineeEmail || 'None';
            } else {
                form.style.display = 'block';
                view.style.display = 'none';
                document.getElementById('modalCapsuleTitle').value = title;
                if (unlockDateTime) {
                    const date = new Date(unlockDateTime);
                    document.getElementById('modalUnlockDate').value = date.toISOString().split('T')[0];
                    const hours = date.getHours();
                    const minutes = date.getMinutes();
                    document.getElementById('modalUnlockTime').value = `${hours % 12 || 12}:${minutes < 10 ? '0' + minutes : minutes}`;
                    document.getElementById('modalAmPm').value = hours >= 12 ? 'PM' : 'AM';
                    const distance = date.getTime() - Date.now();
                    if (distance > 0 && status === 'Locked') {
                        const daysLeft = Math.ceil(distance / (1000 * 60 * 60 * 24));
                        document.getElementById('daysLeft').textContent = `${daysLeft} day${daysLeft !== 1 ? 's' : ''} remaining`;
                    } else {
                        document.getElementById('daysLeft').textContent = 'Invalid date';
                    }
                } else {
                    setupMinDateTime();
                }
                document.getElementById('modalDescription').value = description;
                document.getElementById('modalContents').value = contents;
                document.getElementById('currentFile').textContent = filePath ? `Current: ${filePath.split('/').pop()}` : 'No file';
                document.getElementById('modalOwnerEmail').value = ownerEmail;
                document.getElementById('modalNomineeEmail').value = nomineeEmail;
                document.getElementById('modalCapsuleID').value = id;
            }
        }

        function closeModal() {
            const modal = document.getElementById('capsuleModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.getElementById('capsuleForm').reset();
                document.getElementById('modalCapsuleTitle').value = '';
                document.getElementById('currentFile').textContent = 'No file';
                document.getElementById('daysLeft').textContent = '';
                isModalOpen = false;
                setupMinDateTime();
            }, 200);
        }

        document.getElementById('capsuleForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const date = document.getElementById('modalUnlockDate').value;
            const time = document.getElementById('modalUnlockTime').value;
            const amPm = document.getElementById('modalAmPm').value;
            const [hours, minutes] = time.split(':');
            let formattedHours = parseInt(hours);
            if (amPm === 'PM' && formattedHours !== 12) formattedHours += 12;
            if (amPm === 'AM' && formattedHours === 12) formattedHours = 0;
            const unlockDateTime = `${date}T${formattedHours.toString().padStart(2, '0')}:${minutes}:00`;
            formData.append('unlockDateTime', unlockDateTime);

            try {
                const response = await fetch('/DigitalTimeCapsule/save_capsule.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });
                const data = await response.json();
                if (data.success) {
                    closeModal();
                    fetchCapsules();
                }
                alert(data.message);
            } catch (error) {
                alert('Save Error: ' + error.message);
            }
        });

        function logout() {
            fetch('/DigitalTimeCapsule/logout.php', { method: 'POST', credentials: 'same-origin' })
                .then(() => window.location.href = 'login.html')
                .catch(error => console.error('Logout Error:', error));
        }
    </script>
</body>
</html>