document.addEventListener('DOMContentLoaded', function() {
    // Barcode scanner functionality
    const barcodeInput = document.getElementById('barcode-input');
    
    if (barcodeInput) {
        barcodeInput.focus();
        
        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const barcode = this.value.trim();
                if (barcode.length > 0) {
                    markAttendance(barcode);
                    this.value = '';
                }
            }
        });
    }
    
    function markAttendance(barcode) {
        fetch('/api/attendance/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ barcode: barcode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const attendanceTable = document.getElementById('attendance-table');
                if (attendanceTable) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${data.student.dni}</td>
                        <td>${data.student.first_name} ${data.student.last_name}</td>
                        <td>${data.attendance.status}</td>
                        <td>${data.attendance.time}</td>
                    `;
                    attendanceTable.querySelector('tbody').prepend(newRow);
                }
                
                // Show success message
                alert(`Asistencia registrada: ${data.student.first_name} ${data.student.last_name}`);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al registrar la asistencia');
        });
    }
});