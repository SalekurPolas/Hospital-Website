function ChangeDateFormat(x, y) {
    var date = new Date(x.value);
   	var month = date.getMonth();
    var day = date.getDate();
    var year = date.getFullYear();
    document.getElementById(y).value = year + "-" + month + "-" + day;
}

function ShowEditDoctorInfo() {
	document.getElementById("id_edit_doctor_info").style.display = "block";
}

function ShowAppointmentDetails(appointment_id, patient_name, appointment_fee, appointment_adate, appointment_disease) {
	document.getElementById('appointment_id').innerHTML = 'Appointment ID : ' + appointment_id;
	document.getElementById('patient_name').innerHTML = 'Patient Name : ' + patient_name;
	document.getElementById('appointment_fee').innerHTML = 'Appointment Fee : ' + appointment_fee;
	document.getElementById('appointment_adate').innerHTML = 'Appointment Date : ' + appointment_adate;
	document.getElementById('appointment_disease').innerHTML = 'Patient Disease : ' + appointment_disease;
	document.getElementById("id_view_appointment").style.display = "block";
}

function ShowCreateAppointment(doctor_id, doctor_name, hospital, specialist, fee) {
	document.getElementById('doctor_info').innerHTML = 'Doctor ID: ' + doctor_id + ' Doctor Name: ' + doctor_name + ' Hospital: ' + hospital + ' Specialist: ' + specialist + ' Fee: ' + fee;
	document.getElementById("id_create_appointment").style.display = "block";
}