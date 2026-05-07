<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mes rendez-vous</title>
    <style>
        @page {
            margin: 50px 40px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.5;
        }

        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #2563eb;
            font-size: 24px;
            margin: 0;
        }

        .header p {
            color: #666;
            font-size: 11px;
            margin: 5px 0 0 0;
        }

        .info-box {
            background: #f3f4f6;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .info-box strong {
            color: #2563eb;
        }

        h2 {
            color: #2563eb;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        thead th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }

        tbody td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-accepted { background: #dbeafe; color: #1e40af; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-refused { background: #fee2e2; color: #991b1b; }
        .badge-cancelled { background: #e5e7eb; color: #374151; }

        .notes {
            background: #f0fdf4;
            border-left: 3px solid #10b981;
            padding: 6px 10px;
            margin-top: 4px;
            font-style: italic;
            font-size: 10px;
            color: #065f46;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .empty {
            text-align: center;
            color: #999;
            padding: 40px;
            font-style: italic;
        }

        .summary {
            background: #eff6ff;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .summary-row {
            display: inline-block;
            margin-right: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Medical Appointments — My Appointments</h1>
    <p>Patient report | Generated on {{ $generatedAt->format('d/m/Y H:i') }}</p>
</div>

<div class="info-box">
    <strong>Patient:</strong> {{ $user->full_name }}<br>
    <strong>Email:</strong> {{ $user->email }}
    @if($user->phone)
        <br><strong>Phone:</strong> {{ $user->phone }}
    @endif
</div>

@php
    $stats = [
        'total' => $appointments->count(),
        'pending' => $appointments->where('status', 'pending')->count(),
        'accepted' => $appointments->where('status', 'accepted')->count(),
        'completed' => $appointments->where('status', 'completed')->count(),
        'cancelled' => $appointments->where('status', 'cancelled')->count(),
    ];
@endphp

<div class="summary">
    <div class="summary-row"><strong>Total:</strong> {{ $stats['total'] }}</div>
    <div class="summary-row"><strong>Pending:</strong> {{ $stats['pending'] }}</div>
    <div class="summary-row"><strong>Accepted:</strong> {{ $stats['accepted'] }}</div>
    <div class="summary-row"><strong>Completed:</strong> {{ $stats['completed'] }}</div>
    <div class="summary-row"><strong>Cancelled:</strong> {{ $stats['cancelled'] }}</div>
</div>

<h2>Appointments History</h2>

@if($appointments->isEmpty())
    <div class="empty">No appointments found.</div>
@else
    <table>
        <thead>
            <tr>
                <th style="width: 90px;">Date & Time</th>
                <th style="width: 130px;">Doctor</th>
                <th style="width: 90px;">Specialization</th>
                <th style="width: 70px;">Status</th>
                <th>Reason / Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>
                        {{ $appointment->appointment_date->format('d/m/Y') }}<br>
                        <span style="color: #666;">{{ $appointment->appointment_date->format('H:i') }}</span>
                    </td>
                    <td>
                        <strong>Dr. {{ $appointment->doctor->full_name }}</strong>
                    </td>
                    <td>
                        {{ $appointment->doctor->doctorProfile->specialization ?? '-' }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                    </td>
                    <td>
                        @if($appointment->reason)
                            <strong>Reason:</strong> {{ $appointment->reason }}<br>
                        @endif
                        @if($appointment->status === 'completed' && $appointment->consultation_notes)
                            <div class="notes">
                                <strong>Doctor's notes:</strong> {{ $appointment->consultation_notes }}
                            </div>
                        @endif
                        @if(!$appointment->reason && !$appointment->consultation_notes)
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<div class="footer">
    Medical Appointments System | © {{ date('Y') }} | Page {PAGE_NUM} of {PAGE_COUNT}
</div>

</body>
</html>