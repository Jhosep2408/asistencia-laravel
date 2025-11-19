document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    document.getElementById('sidebarCollapse').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });

    // Activar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


// Actualizar secciones al cambiar el grado
document.getElementById('grade_id').addEventListener('change', function() {
    const gradeId = this.value;
    const classroomSelect = document.getElementById('classroom_id');
    
    // Limpiar opciones actuales
    classroomSelect.innerHTML = '<option value="">Seleccione una sección</option>';
    
    if (gradeId) {
        // Obtener secciones del grado seleccionado (usando datos precargados)
        const grade = JSON.parse(this.options[this.selectedIndex].dataset.grade);
        
        if (grade && grade.classrooms) {
            grade.classrooms.forEach(classroom => {
                const option = document.createElement('option');
                option.value = classroom.id;
                option.textContent = `Sección ${classroom.name}`;
                classroomSelect.appendChild(option);
            });
        }
    }
});