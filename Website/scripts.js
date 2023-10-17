const QueryType = {
    INPUT: "input",
    DROPDOWN: "dropdown",
    NONE: "none"
}
// TODO quizas mejor guardar los dropdowns como globales

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

    // Hide all fields by default
    spacer.style.display = "none";
    inputField.style.display = "none";
    inputField.value = "";
    secondDropdown.style.display = "none";

    // Show the appropriate field based on the selected option
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

function runQuery() {
    event.preventDefault();
    let dropdown = document.getElementById("queryDropdown");
    let queryType = getQueryType(dropdown.selectedIndex);
    switch (queryType) {
        case QueryType.INPUT:
            let inputField = document.getElementById("inputField");
            if (inputField.value == "") {
                alert("El campo no puede estar vacio");
                return;
            }
            break;
        case QueryType.DROPDOWN:
            let secondDropdown = document.getElementById("secondDropdown");
            if (secondDropdown.selectedIndex == 0) {
                alert("Debe seleccionar una opcion");
                return;
            }
            break;
            // TODO quizas esto no es necesario
    }
    console.log("Running query: " + dropdown.selectedIndex);
    
    fetch('/includes/formhandler.inc.php', {
            method: 'POST',
            body: JSON.stringify({
                queryIndex: dropdown.selectedIndex,
                userInput: inputField.value,
                userSelection: secondDropdown[secondDropdown.selectedIndex].value
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}