$(document).ready(function() {
    let currentPage = 1;
    const recordsPerPage = 5;
    let selectedDate = '';

    function loadPage(page, dateFilter = '') {
        $.ajax({
            url: './php/read.php',
            method: 'GET',
            data: { 
                page: page, 
                limit: recordsPerPage, 
                date: dateFilter
            },
            dataType: 'json',
            success: function(data) {
                renderTable(data.records);
                updatePagination(data.total_pages);
            },
            error: function(xhr) {
                console.error("Erro ao carregar os dados: ", xhr.responseText);
            }
        });
    }

    function renderTable(records) {
        const registros = $('#registros');
        registros.empty();

        records.forEach(item => {
            const dataHoraBrasileira = moment(item.data).format('DD/MM/YYYY HH:mm:ss');
            const row = $('<tr>');
            
            row.append($('<td>').text(item.usuario));
            row.append($('<td>').text(item.os));
            row.append($('<td>').text(item.codigo));
            row.append($('<td>').text(dataHoraBrasileira));
            row.append(createImageCell(item.testada));
            row.append(createImageCell(item.hretirado));
            row.append(createImageCell(item.hnovo));
            row.append(createImageCell(item.cavalete));
            row.append(createImageCell(item.solservico));

            registros.append(row);
        });
    }

    function updatePagination(totalPages) {
        const pagination = $('#pagination');
        pagination.empty();

        for (let i = 1; i <= totalPages; i++) {
            const li = $('<li>').addClass('page-item');
            const pageLink = $('<a>')
                .text(i)
                .attr('href', '#')
                .addClass('page-link')
                .data('page', i)
                .click(function(e) {
                    e.preventDefault();
                    currentPage = $(this).data('page');
                    loadPage(currentPage, selectedDate);
                });

            if (i === currentPage) {
                li.addClass('active');
            }

            li.append(pageLink);
            pagination.append(li);
        }
    }

    function createImageCell(base64String) {
        const cell = $('<td>');

        if (base64String) {
            const imageUrl = `data:image/webp;base64,${base64String}`;
            const img = $('<img>').attr('src', imageUrl).css({ width: '100px', height: '100px', cursor: 'pointer' });
            const link = $('<a>').attr('href', imageUrl).attr('download', 'image.webp').append(img);
            cell.append(link);
        } else {
            cell.text('Sem imagem');
        }

        return cell;
    }

    $('#filtro-data').on("change", function() {
        selectedDate = $(this).val();
        loadPage(currentPage, selectedDate);
    });

    function promptForLogin() {
        const correctCode = "isci%231";
        let userInput = '';

        while (userInput !== correctCode) {
            userInput = prompt("Digite o código para visualizar as imagens:");
            if (userInput !== correctCode) {
                alert("Código incorreto! Tente novamente.");
            }
        }
    }

    promptForLogin();
});
