<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PHP/PostgreSQL Query Builder</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="scripts/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
                <img src="imgs/logo.png" width="300" height="300" class="mx-auto d-block">
    <div class="container mt-5">
    
    
            
        <form id="data-form">
            <label for="queryDropdown">Seleccione una consulta:</label>
            <select id="queryDropdown" onchange="toggleInputOrDropdown()" name="queryIndex" class="form-control">
                <option value="0">Muestre todas las películas junto con sus proovedores, siempre y cuando el proovedor las ofrezca de manera gratuita</option>
                <option value="1">Dado un numero n ingresado por el usuario, muestre todas las series que tengan al menos n temporadas</option>
                <option value="2">Dado un titulo ingresado por el usuario, muestre todas las películas/series con ese título y los proovedores que las ofrecen</option>
                <option value="3">Dado un genero seleccionado por el usuario, muestre todas las películas que pertenezcan a ese género, o que pertenezcan a alguno de sus subgéneros inmediatos</option>
                <option value="4">Dado un username ingresado por el usuario, muestre todas las películas a las que tiene acceso dicho usuario</option>
                <option value="5">Dado un username ingresado por el usuario, muestre todas las series para las cuales el usuario ingresado ha visto mas de un capítulo en el último año</option>
                <option value="6">Muestre la suma de dinero gastada por cada usuario en películas no incluidas en planes de suscripción</option>
            </select>

            <br id="parameterSpace" style="display: none">

            <input type="text" id="inputField" name="userInput" style="display: none" placeholder="Ingrese un valor" class="form-control">
            <span id="error-message" style="color: red; display: none;"></span>

            <select id="secondDropdown" style="display: none" name="userSelection" class="form-control"></select>

            <br>

            <button type="submit" class="btn btn-primary">Run query</button>
        </form>
    </div>

    

    <div id="result-div" class="container mt-5"></div>

    <script>
        $(document).ready(function() {
            // Populate Genders Dropdown
            $.ajax({
                url: 'utils/get_genders.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var dropdown = $('#secondDropdown');
                    $.each(response, function(key, entry) {
                        dropdown.append($('<option></option>').attr('value', entry.id).text(entry.nombre));
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching gender data:', error);
                },
            });
            // Run query on form submit
            $('#data-form').submit(function(e) {
                e.preventDefault();
                var queryIndex = $('#queryDropdown').val();
                var userInput = $('#inputField').val();
                var userSelection = $('#secondDropdown').val();
                const errorMessage = document.getElementById("error-message");
                errorMessage.style.display = "none";
                var url = '';
                switch (queryIndex) {
                    case '0':
                        url = 'queries/get_free_movies_and_providers.php';
                        break;
                    case '1':
                        if (userInput === '') {
                            errorMessage.style.display = "block";
                            errorMessage.innerHTML = "Por favor ingrese un valor";
                            return;
                        } else if (isNaN(userInput)) {
                            errorMessage.style.display = "block";
                            errorMessage.innerHTML = "Por favor ingrese un número";
                            return;
                        }
                        url = 'queries/get_series_with_at_least_x_seasons.php';
                        break;
                    case '2':
                        url = 'queries/get_movies_and_series_with_x_title.php';
                        break;
                    case '3':
                        url = 'queries/get_movies_that_belong_to_gender_or_subgender.php';
                        break;
                    case '4':
                        url = 'queries/get_all_movies_user_x_has_access_to.php';
                        break;
                    case '5':
                        url = 'queries/get_series_user_x_saw_more_than_one_chapter.php';
                        break;
                    case '6':
                        url = 'queries/get_users_and_money_spent_on_movies.php';
                        break;
                    default:
                        console.error('Invalid query index.');
                        break;
                }

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        userInput: userInput,
                        userSelection: userSelection
                    },
                    success: function(data) {
                        $('#result-div').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error running query:', error);
                    },
                });
            });
        });
    </script>

</body>

</html>