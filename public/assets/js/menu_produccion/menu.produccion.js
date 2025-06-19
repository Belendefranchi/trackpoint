window.addEventListener('DOMContentLoaded', function () {
	const hoy = new Date().toISOString().split('T')[0];
	document.getElementById('fecha_faena').value = hoy;
	document.getElementById('fecha_produccion').value = hoy;
});


document.getElementById('unidades').addEventListener('input', function () {
this.value = this.value.replace(/\D/g, ''); // Elimina cualquier cosa que no sea dígito
});

document.getElementById('cantidad').addEventListener('input', function () {
this.value = this.value.replace(/\D/g, ''); // Elimina cualquier cosa que no sea dígito
});

function getFloat(id) {
	return parseFloat(document.getElementById(id).value) || 0;
}

function actualizarCamposActivos() {
	const modo = document.querySelector('input[name="modo_peso"]:checked').value;
	const inputNeto = document.getElementById('peso_neto');
	const inputBruto = document.getElementById('peso_bruto');

	if (modo === 'neto') {
			inputNeto.removeAttribute('readonly');
			inputNeto.classList.remove('input-disabled-style');
			inputNeto.classList.remove('bg-light');
			inputNeto.classList.add('bg-primary-subtle');
			
			inputBruto.setAttribute('readonly', 'readonly');
			inputBruto.classList.remove('bg-primary-subtle');
			inputBruto.classList.add('input-disabled-style');
			inputBruto.classList.add('bg-light');

	} else {
			inputBruto.removeAttribute('readonly');
			inputBruto.classList.remove('input-disabled-style');
			inputBruto.classList.remove('bg-light');
			inputBruto.classList.add('bg-primary-subtle');
			
			inputNeto.setAttribute('readonly', 'readonly');
			inputNeto.classList.remove('bg-primary-subtle');
			inputNeto.classList.add('input-disabled-style');
			inputNeto.classList.add('bg-light');

	}
}

function calcularSegunModo() {
	const modo = document.querySelector('input[name="modo_peso"]:checked').value;
	const taraPri = getFloat('tara_pri');
	const taraSec = getFloat('tara_sec');

	if (modo === 'neto') {
			const neto = getFloat('peso_neto');
			const bruto = neto + taraPri + taraSec;
			document.getElementById('peso_bruto').value = bruto.toFixed(2);
	} else if (modo === 'bruto') {
			const bruto = getFloat('peso_bruto');
			const neto = bruto - taraPri - taraSec;
			document.getElementById('peso_neto').value = neto.toFixed(2);
	}
}

// Escuchar cambios
['peso_neto', 'peso_bruto', 'tara_pri', 'tara_sec'].forEach(id => {
	document.getElementById(id).addEventListener('input', calcularSegunModo);
});

document.querySelectorAll('input[name="modo_peso"]').forEach(radio => {
	radio.addEventListener('change', () => {
			actualizarCamposActivos();
			calcularSegunModo();
	});
});

// Inicializar al cargar
window.addEventListener('DOMContentLoaded', () => {
	actualizarCamposActivos();
	calcularSegunModo();
});