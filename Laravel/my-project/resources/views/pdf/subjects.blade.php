<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Subjects</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .info-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .info-container p {
            margin: 5px 0;
            font-weight: bold;
        }
        /* Header Section */
.header-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 20px;
    background-color: #f3f4f6; /* Light Gray */
    border-bottom: 1px solid #d1d5db; /* Light Border */
    border-radius: 8px;
}

.header-section .logo-section {
    max-width: 150px; /* Set appropriate size for the logo */
    margin-bottom: 20px;
}

.student-info {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.student-info h2 {
    font-size: 24px;
    font-weight: 600;
    color: #1f2937; /* Dark Gray */
    margin-bottom: 8px;
}

.student-info p {
    font-size: 18px;
    color: #4b5563; /* Mid Gray */
    margin-bottom: 4px;
}

.student-image {
    width: 160px;
    height: 160px;
    overflow: hidden;
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.student-image-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Student Detailed Information Section */
.student-info-details {
    padding: 20px;
    border: 1px solid #d1d5db;
    background-color: #f3f4f6;
    border-radius: 8px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 12px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}

.info-item {
    display: flex;
    justify-content: space-between;
}

.label {
    font-weight: 600;
    color: #1f2937;
}

.value {
    font-weight: 400;
    color: #4b5563;
}

.full-width-info {
    grid-column: span 2;
}

.full-width-info .info-item {
    justify-content: flex-start;
    margin-bottom: 8px;
}

    </style>
</head>
<body>

        

            <!-- Student Information -->
            <!-- Student Information and Image -->
    <!-- Header Section (Logo + Student Info + Image) -->
<div class="header-section">
    <!-- Logo Section (left side) -->
   <!-- Display the logo if Base64 data is available -->
   @if ($logo)
        <img src="{{ $logo }}" alt="Logo" width="100">
    @else
        <p>Logo not found</p>
    @endif

    <!-- Student Information Section (middle part) -->
    <div class="student-info">
        <h2 class="college-name">Amando Cope College</h2>
        <p class="address">Baranghawon, Tabaco City</p>
        <p class="contact">(052) 487-4455</p>
    </div>

    <!-- Student Image Section (right side) -->
    <div class="student-image">
         <!-- Display Student Image -->
         <img src="{{ $studentImage }}" alt="Student Image">
    </div>
</div>

<!-- Student Detailed Information Section -->
<div class="student-info-details">
    <p class="section-title">Student Information</p>

    <div class="info-grid">
        <div class="info-item">
            <span class="label">Name:</span>
            <span class="value">{{ $studentInfo['name'] ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="label">Student #:</span>
            <span class="value">{{ $studentInfo['student_id'] ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <span class="label">Semester:</span>
            <span class="value">{{ $studentInfo['semester'] ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="label">Year Level:</span>
            <span class="value">{{ $studentInfo['year_level'] ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <span class="label">Category:</span>
            <span class="value">{{ $studentInfo['category'] ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="label">School Year:</span>
            <span class="value">{{ $studentInfo['academic_year'] ?? 'N/A' }}</span>
        </div>
    </div>

    <!-- Course & Major in one full-width column -->
    <div class="full-width-info">
        <div class="info-item">
            <span class="label">Course:</span>
            <span class="value">{{ $studentInfo['course'] ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="label">Major:</span>
            <span class="value">{{ $studentInfo['major'] ?? 'N/A' }}</span>
        </div>
    </div>
</div>


      


    <!-- Subjects Table -->
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Units</th>
                <th>Days</th>
                <th>Time</th>
                <th>Room</th>
                <th>Professor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->units }}</td>
                    <td>{{ $subject->formatted_days }}</td>
                    <td>{{ $subject->class_time }}</td>
                    <td>{{ $subject->room }}</td>
                    <td>{{ $subject->professor->fullname ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
