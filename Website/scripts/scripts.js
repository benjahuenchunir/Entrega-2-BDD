let sortOrder = 'asc';

const QueryType = {
    INPUT: "input",
    DROPDOWN: "dropdown",
    NONE: "none"
}

function getQueryType(index) {
    if ([0, 6].includes(index)) {
        return QueryType.NONE;
    } else if ([3].includes(index)) {
        return QueryType.DROPDOWN;
    } else {
        return QueryType.INPUT;
    }
}

function toggleInputOrDropdown() {
    var dropdown = document.getElementById("queryDropdown");
    var inputField = document.getElementById("inputField");
    var secondDropdown = document.getElementById("secondDropdown");
    var errorMessage = document.getElementById("error-message");
    var table = document.getElementById("result-div");

    inputField.style.display = "none";
    inputField.value = "";
    secondDropdown.style.display = "none";
    errorMessage.style.display = "none";
    table.innerHTML = "";

    let queryType = getQueryType(dropdown.selectedIndex)
    switch (queryType) {
        case QueryType.INPUT:
            inputField.style.display = "block";
            break;
        case QueryType.DROPDOWN:
            secondDropdown.style.display = "block";
            break;
    }
}

function onSortButtonClicked(clicked_id) {
    sortOrder = toggleSortOrder(sortOrder);
    sortTable(clicked_id, sortOrder);
    updateSortButtons(clicked_id, sortOrder);
};

function toggleSortOrder(currentOrder) {
    return currentOrder === 'asc' ? 'desc' : 'asc';
}

function sortTable(column, order) {
    const $table = $('#result-table');
    const $tbody = $table.find('tbody');
    const $rows = $tbody.find('tr').toArray();

    $rows.sort(function (a, b) {
        var aValue = $(a).find('td.' + column).text();
        var bValue = $(b).find('td.' + column).text();

        if (order === 'asc') {
            return aValue.localeCompare(bValue, undefined, { numeric: true });
        } else {
            return bValue.localeCompare(aValue, undefined, { numeric: true });
        }
    });

    $tbody.empty();
    $rows.forEach(function (row) {
        $tbody.append(row);
    });
}

function updateSortButtons(column, order) {
    $('.btn-secondary').html('▲');
    const $button = $(`.btn-secondary[id="${column}"]`);
    $button.html(order === 'asc' ? '▲' : '▼');
}

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
                $('#result-div').removeClass('d-none');
                $('#result-div').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error running query:', error);
            },
        });
    });
    $('#queryDropdown').change(function() {
        $('#result-div').addClass('d-none');
        toggleInputOrDropdown();
    });
});