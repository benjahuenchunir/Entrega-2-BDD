<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Metastreaming PostgreSQL Query Builder</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <img src="imgs/logo.png" width="300" height="300" class="mx-auto d-block">
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-14 col-lg-12">
                <form id="data-form">
                    <label for="queryDropdown">Seleccione una consulta:</label>
                    <select id="queryDropdown" name="queryIndex" class="form-control">
                        <option value="0">Muestre todas las películas junto con sus proveedores, siempre y cuando el proveedor las ofrezca de manera gratuita</option>
                        <option value="1">Dado un numero n ingresado por el usuario, muestre todas las series que tengan al menos n temporadas</option>
                        <option value="2">Dado un titulo ingresado por el usuario, muestre todas las películas/series con ese título y los proveedores que las ofrecen</option>
                        <option value="3">Dado un genero seleccionado por el usuario, muestre todas las películas que pertenezcan a ese género, o que pertenezcan a alguno de sus subgéneros inmediatos</option>
                        <option value="4">Dado un username ingresado por el usuario, muestre todas las películas a las que tiene acceso dicho usuario</option>
                        <option value="5">Dado un username ingresado por el usuario, muestre todas las series para las cuales el usuario ingresado ha visto mas de un capítulo en el último año</option>
                        <option value="6">Muestre la suma de dinero gastada por cada usuario en películas no incluidas en planes de suscripción</option>
                    </select>

                    <input type="text" id="inputField" name="userInput" style="display: none" placeholder="Ingrese un valor" class="form-control mt-3">
                    <span id="error-message" style="color: red; display: none;"></span>

                    <select id="secondDropdown" style="display: none" name="userSelection" class="form-control mt-3"></select>


                    <button type="submit" id="run-query-btn" class="btn btn-primary mt-3">Run query</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-14 col-lg-12">
                <div id="result-div" class='d-none'></div>
            </div>
        </div>
    </div>
    <script src="scripts/scripts.js"></script>
</body>

</html>