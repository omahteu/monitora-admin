$(document).ready(function() {
    var currentPage = 1;
    var recordsPerPage = 5;

    function loadPage(page) {
        $.ajax({
            url: './php/read.php',
            method: 'GET',
            data: { page: page, limit: recordsPerPage },
            dataType: 'json',
            success: function(data) {
                const dados = data['records'];
                const totalPages = data['total_pages'];
                
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

                updatePagination(totalPages);
            },
            error: function(xhr, status, error) {
                console.log("Erro ao carregar os dados: ", xhr.responseText);
            }
        });
    }

    function updatePagination(totalPages) {
        var pagination = $('#pagination');
        pagination.empty();

        for (var i = 1; i <= totalPages; i++) {
            var li = $('<li>').addClass('page-item');
            var pageLink = $('<a>')
                .text(i)
                .attr('href', '#')
                .addClass('page-link')
                .data('page', i)
                .click(function(e) {
                    e.preventDefault();
                    var page = $(this).data('page');
                    currentPage = page;
                    loadPage(page);
                });

            if (i === currentPage) {
                li.addClass('active');
            }

            li.append(pageLink);
            pagination.append(li);
        }
    }

    function createImageCell(base64String) {
        if (base64String) {
            var imageUrl = 'data:image/png;base64,' + base64String;
            var img = $('<img>').attr('src', imageUrl).css({ width: '100px', cursor: 'pointer' });
            var a = $('<a>').attr('href', imageUrl).attr('download', 'image.png').append(img);
            return $('<td>').append(a);
        } else {
            return $('<td>').text('Sem imagem');
        }
    }

    loadPage(currentPage);
});
