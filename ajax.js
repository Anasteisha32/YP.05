function Ajax(url, data, success) {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Успешный ответ:', response); // Вывод ответа сервера в консоль
            success(response);
        },
        error: function(xhr, status, error) {
            console.log('Системная ошибка!');
            console.error('Ошибка AJAX:', status, error); // Вывод ошибки в консоль
        }
    });
}