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
    var spacer = document.getElementById("parameterSpace");
    var errorMessage = document.getElementById("error-message");
    var table = document.getElementById("result-div");

    spacer.style.display = "none";
    inputField.style.display = "none";
    inputField.value = "";
    secondDropdown.style.display = "none";
    errorMessage.style.display = "none";
    table.innerHTML = "";

    let queryType = getQueryType(dropdown.selectedIndex)
    switch (queryType) {
        case QueryType.INPUT:
            spacer.style.display = "block";
            inputField.style.display = "block";
            break;
        case QueryType.DROPDOWN:
            spacer.style.display = "block";
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
    $('.sort-btn').html('▲');
    const $button = $(`.sort-btn[id="${column}"]`);
    $button.html(order === 'asc' ? '▲' : '▼');
}
