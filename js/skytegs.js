if (document.getElementById('wordList') !== null) {
// Сохраняем XMLHttpRequest и адрес JSON-файла в переменных
    var xhr = new XMLHttpRequest();
 // var url = "/words_data.json";
    var url = "/csv_reader.php";

// Вызываем при изменении атрибута readyState
    xhr.onreadystatechange = function () {
        // Проверяем, выполнен ли запрос на получение
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Разбираем строку JSON
            var jsonData = JSON.parse(xhr.responseText);
            // Вызываем displaySkyTegs() и передаём разобранный JSON
            displaySkyTegs(jsonData, 'day');
        }
    };

// Выполняем HTTP-вызов, используя переменную url
    xhr.open("GET", url, true);
    xhr.send();

// // Функция, которая форматирует строку с тегами HTML, а затем выводит результат для нужного периода: month, week или day
    function displaySkyTegs(data, period) {
        var numbers = [];
        for (let i in data.ratings) {
            numbers.push(data.ratings[i][period]);
        }
        var maxFont = Math.max(...numbers); //значение для вычисления максимального значения шрифта

        // Вставляем данные в переменную и форматируем их с помощью тегов HTML
        var output = ""; //Зарезервировано для заголовка виджета
        output += "<ul>";

        // В цикле проходим по всем словам
        for (let i in data.ratings) {
            output += "<li style=\"font-size: " + weightToFontSize(1, maxFont, +data.ratings[i][period]) + "px; opacity: calc(" + (0.5+(data.ratings[i][period]-1)/9) + ");\" title=\"" + data.ratings[i][period] + "\"><a href=" + encodeURIComponent(data.ratings[i].name) + ">" + data.ratings[i].name + "</a></li>";
        }

        output += "</ul>";
        // Выводим данные в элементе wordList
        document.getElementById("wordList").innerHTML=output;
    }


    function weightToFontSize(tmin, tmax, ti) { //Расчет веса слов
        //tmin,tmax - минимальный и максимальный вес слова
        //ti - вес тега
        //fmax - максимальный размер шрифта
        //si - размер щрифта
        var si = 1;
        var fmax = 48;
        if (ti > tmax) {ti = tmax;}
        if (ti > tmin) {
            si = fmax * (ti - tmin) / (tmax - tmin);
            si = Math.round(si);
        }
        return si + 7; //+7, чтобы минимальный размер шрифта был 8px, т.е. читаем
    }
}