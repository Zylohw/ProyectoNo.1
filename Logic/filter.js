function mostrarFiltro(){
    const filtro = document.getElementById("filtroSelect").value;
    const selectPartida = document.getElementById("selectPartida");
    const inputFecha    = document.getElementById("inputFecha");

    // Oculta ambos primero
    selectPartida.style.display = "none";
    inputFecha.style.display    = "none";

    if(filtro === "fecha"){
        inputFecha.style.display = "block";
    } else if(filtro === "numero"){
        selectPartida.style.display = "block";
    }
}

function aplicarFiltro(){
    const filtro  = document.getElementById("filtroSelect").value;
    const partida = document.getElementById("partida_filtro").value;
    const fecha   = document.getElementById("filtroFecha").value;

    if(filtro === "todas"){
        window.location.href = "listarpartidas.php";
    } else if(filtro === "fecha"){
        if(fecha === ""){
            alert("Por favor selecciona una fecha");
            return;
        }
        window.location.href = "listarpartidas.php?orden=fecha&fecha=" + fecha;
    } else if(filtro === "numero"){
        if(partida === ""){
            alert("Por favor selecciona una partida");
            return;
        }
        window.location.href = "listarpartidas.php?orden=numero&NumPartida=" + partida;
    }
}