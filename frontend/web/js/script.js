let countOfFields = 1; // Текущее число полей
let curFieldNameIdFio = 1; // Уникальное значение для атрибута name
let curFieldNameIdEmail = 1; // Уникальное значение для атрибута name
let maxFieldLimit = 5; // Максимальное число возможных полей
function deleteField(a) {
    let contDiv = a.parentNode;
    contDiv.parentNode.removeChild(contDiv);
    countOfFields--;
    return false;
}
function addField() {
    // Проверяем, не достигло ли число полей максимума
    if (countOfFields >= maxFieldLimit) {
        alert("Число полей достигло своего максимума = " + maxFieldLimit);
        return false;
    }

    countOfFields++;
    curFieldNameIdFio++;
    curFieldNameIdEmail++;
    let div = document.createElement("div");
    div.innerHTML = "<br><br> <input name='name_'" + curFieldNameIdFio +  "type='text' placeholder='fio'/> " +
        "<a onclick='return deleteField(this)' href='#'>[X]</a> " +
        "<br><br>" +
        "<input name='name_'" + curFieldNameIdFio +  "type='text' placeholder='email'/>" +
        "<a onclick='return deleteField(this)' href='#'>[X]</a> ";
    document.getElementById("parentId").appendChild(div);
    return false;
}

document.getElementById('send').addEventListener('click', function(event) {
    event.preventDefault();
    let form = document.getElementById('contact-form');
    let fio = form.querySelector('[name="name_1"]').value;
    let email = form.querySelector('[name="name_2"]').value;
    let data = {'fio':fio, 'email':email};
    $.ajax({
        url: form.action,
        type: 'post',
        data: data,
        success: function(data) {
            let response = document.getElementById('response');
            response.innerHTML = data;
        }
    });

});
