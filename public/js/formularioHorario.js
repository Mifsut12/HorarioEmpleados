const registros = Array.from(document.querySelectorAll("select.Empleado1"))

registros.forEach((registro, index) => {
    registro.addEventListener("change", () =>{
        for(let i = index; i < registros.length; i++){
            registros[i].value = registro.value;
        }
    });
})