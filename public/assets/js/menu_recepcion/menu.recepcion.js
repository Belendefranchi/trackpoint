window.addEventListener('DOMContentLoaded', function () {
	const hoy = new Date().toISOString().split('T')[0];
	document.getElementById('fecha_recepcion').value = hoy;
});

function getFloat(id) {
	return parseFloat(document.getElementById(id).value) || 0;
}