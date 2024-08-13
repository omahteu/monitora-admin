$(document).ready(function() {
    $.ajax({
        url: './php/read.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const dados = data['records']
            console.log(dados)
            var registros = $('#registros');
            registros.empty();

            $.each(dados, function(index, item) {
                var row = $('<tr>');

                row.append($('<td>').text(item.usuario));
                row.append($('<td>').text(item.os));
                row.append($('<td>').text(item.codigo));
                row.append(createImageCell(item.testada));
                row.append(createImageCell(item.hretirado));
                row.append(createImageCell(item.hnovo));
                row.append(createImageCell(item.cavalete));
                row.append(createImageCell(item.solservico));

                registros.append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Erro ao buscar dados: ' + error);
        }
    });
    

    function createImageCell(base64String) {
        var imageUrl = 'data:image/png;base64,' + base64String;
        var img = $('<img>').attr('src', imageUrl).css({ width: '100px', cursor: 'pointer' });
        var a = $('<a>').attr('href', imageUrl).attr('download', 'image.png').append(img);
        return $('<td>').append(a);
    }
});
