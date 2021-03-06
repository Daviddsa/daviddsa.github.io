function generaObjetos() {
    document.getElementById("objetos").innerHTML =
    "<br>" + new Date().toLocaleTimeString("es-ES", { hour: "numeric", minute: "numeric", second: "numeric"});

    if (document.getElementById("obj_menor").value > 0) {
        document.getElementById("objetos").innerHTML =  document.getElementById("objetos").innerHTML + " <br>Menores: ";

        randomMagicItem(1, document.getElementById("obj_menor").value);
    }

    if (document.getElementById("obj_medio").value > 0) {
        document.getElementById("objetos").innerHTML =  document.getElementById("objetos").innerHTML + " <br>Intermedios: ";

        randomMagicItem(2, document.getElementById("obj_medio").value);
    }

    if (document.getElementById("obj_mayor").value > 0) {
        document.getElementById("objetos").innerHTML =  document.getElementById("objetos").innerHTML + " <br>Mayores: ";

        randomMagicItem(3, document.getElementById("obj_mayor").value);
    }
}

// Obtiene material del objeto
function getMaterial(tipo) {
    var material = "";

    if (tiraDados(1,100) >= 96) {
        switch (tipo) {
            case 1:
            // Solo madera

            break;
            case 2:
            // Solo metal

            break;
            default:
            switch (tiraDados(1,10)) {
                case 1:

                break;
                default:
                return material;
            }
        }
    } else {
        return material;
    }
}

// Obtiene el objeto en sí, con sus carácteristicas
function randomMagicItem(rareza, repeticiones) {
    for (var i = 0; i < repeticiones; i++) {
        var tirada = tiraDados(1,100);

        switch (rareza) {
            case 1:
            if (tirada <= 4) {
                console.log("Armaduras y escudos");
                randomArmaduraEscudo(0, rareza);
            } else if (tirada <= 9) {
                console.log("Armas");
                randomArma();
            } else if (tirada <= 44) {
                console.log("Pociones");
                randomPocion();
            } else if (tirada <= 46) {
                console.log("Anillos");
                randomAnillo();
            } else if (tirada <= 81) {
                console.log("Pergaminos");
                randomPergamino();
            } else if (tirada <= 91) {
                console.log("Varitas");
                randomVarita();
            } else {
                console.log("Objetos maravillosos");
                randomObjetoMaravilloso();
            }
            break;
            case 2:
            if (tirada <= 10) {
                console.log("Armaduras y escudos");
                randomArmaduraEscudo(0, rareza);
            } else if (tirada <= 20) {
                console.log("Armas");
                randomArma();
            } else if (tirada <= 30) {
                console.log("Pociones");
                randomPocion();
            } else if (tirada <= 40) {
                console.log("Anillos");
                randomAnillo();
            } else if (tirada <= 50) {
                console.log("Cetros");
                randomCetro();
            } else if (tirada <= 65) {
                console.log("Pergaminos");
                randomPergamino();
            } else if (tirada <= 68) {
                console.log("Bastones");
                randomBaston();
            } else if (tirada <= 83) {
                console.log("Varitas");
                randomVarita();
            } else {
                console.log("Objetos maravillosos");
                randomObjetoMaravilloso();
            }
            break;
            case 3:
            if (tirada <= 10) {
                console.log("Armaduras y escudos");
                randomArmaduraEscudo(0, rareza);
            } else if (tirada <= 20) {
                console.log("Armas");
                randomArma();
            } else if (tirada <= 25) {
                console.log("Pociones");
                randomPocion();
            } else if (tirada <= 35) {
                console.log("Anillos");
                randomAnillo();
            } else if (tirada <= 45) {
                console.log("Cetros");
                randomCetro();
            } else if (tirada <= 55) {
                console.log("Pergaminos");
                randomPergamino();
            } else if (tirada <= 75) {
                console.log("Bastones");
                randomBaston();
            } else if (tirada <= 80) {
                console.log("Varitas");
                randomVarita();
            } else {
                console.log("Objetos maravillosos");
                randomObjetoMaravilloso();
            }
            break;
            default:
            alert("Rareza errónea.");
        }
    }
}

// Obtiene Armaduras y Escudos
function randomArmaduraEscudo(itera_bucle, rareza) {
    var item = "";
    var material = "";
    var mejora = 0;
    var cont_aptitudes = 0;

    var tirada = tiraDados(1,100);

    switch (rareza) {
        case 1:
        if (tirada <= 60) {
            itera_bucle = 0;

            item = "Escudo";
            mejora = 1;
            material = getMaterial(0);

            console.log("- Escudo +1");
        } else if (tirada <= 80) {
            itera_bucle = 0;

            item = "Armadura";
            mejora = 1;

            console.log("- Armadura +1");
        } else if (tirada <= 85) {
            itera_bucle = 0;

            item = "Escudo";
            mejora = 2;

            console.log("- Escudo +2");
        } else if (tirada <= 87) {
            itera_bucle = 0;

            item = "Armadura";
            mejora = 2;

            console.log("- Armadura +2");
        } else if (tirada <= 89) {
            itera_bucle = 1;

            // TODO: Armadura específica
            console.log("- Armadura esp.");
        } else if (tirada <= 91) {
            itera_bucle = 1;

            // TODO: Escudo específico
            console.log("- Escudo esp.");
        } else {
            cont_aptitudes++;

            randomArmaduraEscudo(1, rareza);
        }

        break;
        case 2:
        break;
        case 3:
        break;
        default:

    }

    // TODO: Materiales especiales

    if (itera_bucle == 0) {
        if (mejora > 0) {
            document.getElementById("objetos").innerHTML = document.getElementById("objetos").innerHTML + " <br> " + item + material + " +" + mejora + " ";
        }
    }

    if (item == "Armadura") {
        for (var i = 0; i < cont_aptitudes; i++) {
            document.getElementById("objetos").innerHTML = document.getElementById("objetos").innerHTML + aptitudArmadura(rareza);
        }
    } else if (item == "Escudo") {
        for (var i = 0; i < cont_aptitudes; i++) {
            document.getElementById("objetos").innerHTML = document.getElementById("objetos").innerHTML + aptitudEscudo(rareza);
        }
    }

    document.getElementById("objetos").innerHTML = document.getElementById("objetos").innerHTML + ", ";
}

function aptitudArmadura(rareza) {
    var resultado = "";
    var tirada = tiraDados(1,100);

    console.log("aptitud++");

    switch (rareza) {
        case 1:
        if (tirada <= 25) {
            resultado = "Ilusoria ";
        } else if (tirada <= 32) {
            resultado = "Fortificante leve ";
        } else if (tirada <= 52) {
            resultado = "Resbaladiza ";
        } else if (tirada <= 92) {
            resultado = "De las sombras ";
        } else if (tirada <= 96) {
            resultado = "Resistente a conjuros (13) ";
        } else if (tirada <= 97) {
            resultado = "Resbaladiza mejorada ";
        } else if (tirada <= 99) {
            resultado = "De las sombras mejorada ";
        } else {
            resultado = aptitudArmadura(rareza) + aptitudArmadura(rareza);
        }
        break;
        default:

    }

    return resultado;
}

function aptitudEscudo(rareza) {
    var resultado = "";
    var tirada = tiraDados(1,100);

    console.log("aptitud++");

    switch (rareza) {
        case 1:
        if (tirada <= 20) {
            resultado = "Atrapador de flechas ";
        } else if (tirada <= 40) {
            resultado = "Golpeador ";
        } else if (tirada <= 50) {
            resultado = "Cegador ";
        } else if (tirada <= 75) {
            resultado = "Fortificante leve ";
        } else if (tirada <= 92) {
            resultado = "Desviador de flechas ";
        } else if (tirada <= 97) {
            resultado = "Animado ";
        } else if (tirada <= 99) {
            resultado = "Resistente a conjuros (13) ";
        } else {
            resultado = aptitudEscudo(rareza) + aptitudEscudo(rareza);
        }
        break;
        default:

    }

    return resultado;
}

function randomArma() {

}

function randomPocion() {

}

function randomAnillo() {

}

function RandomCetro() {

}

function randomPergamino() {

}

function randomBaston() {

}

function randomVarita() {

}

function randomObjetoMaravilloso(rareza) {
    var tirada = tiraDados(1,100);

    switch (rareza) {
        case 1:
        switch (tirada) {
            case 1:
            document.getElementById("objetos").innerHTML = document.getElementById("objetos").innerHTML + "Disolvente universal (50 po), ";
            break;
            case 2:
            document.getElementById("objetos").innerHTML = document.getElementById("objetos").innerHTML + "Fetiche de plumas (ancla) (50 po), ";
            break;
            default:

        }
        break;
        default:

    }
}
