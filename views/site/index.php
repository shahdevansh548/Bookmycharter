<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<!-- Google Font: Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f3f6fb;
    color: #333;
    margin: 0;
    padding: 0;
}

.site-index {
    padding: 40px 20px;
}

.jumbotron {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
    padding: 60px 30px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.jumbotron h1 {
    font-size: 2.5rem;
    font-weight: 600;
}

.body-content {
    display: grid;
    gap: 30px;
}

.card {
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.card h2 {
    font-size: 1.6rem;
    color: #007bff;
    border-left: 4px solid #007bff;
    padding-left: 12px;
    margin-bottom: 20px;
}

.card p {
    font-size: 1.1rem;
    line-height: 1.7;
}

.card ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.card ul li {
    font-size: 1.05rem;
    background-color: #f1f8ff;
    margin-bottom: 12px;
    padding: 15px 20px;
    border-left: 4px solid #4facfe;
    border-radius: 10px;
    transition: background-color 0.3s ease;
}

.card ul li:hover {
    background-color: #e0f4ff;
}

.card strong {
    color: #004085;
}
</style>

<div class="site-index">

    <div class="jumbotron text-center">
        <h1>Skip the waiting room—book your doctor’s appointment anytime, anywhere.</h1>
    </div>

    <div class="body-content">
        <div class="card">
            <h2>Welcome</h2>
            <p>Our user-friendly online booking system makes it easy to schedule, manage, and track appointments with just a few clicks. Whether you're booking a routine check-up or a specialist consultation, we're here to make healthcare more convenient for you.</p>
        </div>

        <div class="card">
            <h2>Key Features</h2>
            <ul>
                <li>📅 <strong>Easy Appointment Scheduling:</strong> Book appointments with your preferred doctor 24/7 from the comfort of your home.</li>
                <li>👨‍⚕️ <strong>Doctor Profiles:</strong> View detailed profiles, specialties, and available slots before booking.</li>
                <li>🔔 <strong>Appointment Reminders:</strong> Get SMS and email reminders to ensure you never miss an appointment.</li>
                <li>💻 <strong>Virtual Consultations:</strong> Choose in-person or secure video consultations, depending on your needs.</li>
                <li>🔄 <strong>Reschedule or Cancel:</strong> Easily modify your appointments without making a phone call.</li>
            </ul>
        </div>

        <div class="card">
            <h2>Why Use Our Appointment System?</h2>
            <ul>
                <li><strong>Saves Time:</strong> No more phone queues or long waiting times.</li>
                <li><strong>Improves Accuracy:</strong> Confirmed bookings with real-time availability.</li>
                <li><strong>24/7 Access:</strong> Book, change, or cancel appointments anytime.</li>
                <li><strong>Safe and Secure:</strong> All your data is encrypted and HIPAA-compliant.</li>
            </ul>
        </div>
    </div>
</div>

