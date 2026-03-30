function agregarfila() {
    const cuerpo = document.getElementById("cuerpo");
    const primeraFila = cuerpo.querySelector("tr");
    

    const nuevaFila = primeraFila.cloneNode(true);
    nuevaFila.querySelectorAll("input").forEach(input => input.value = "");
    nuevaFila.querySelector("select").selectedIndex = 0;
    cuerpo.appendChild(nuevaFila);
}
